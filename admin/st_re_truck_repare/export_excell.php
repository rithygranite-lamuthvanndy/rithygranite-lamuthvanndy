<?php
include '../../config/database.php';
include_once '../st_operation/operation.php';
include_once 'function.php';

if (PHP_SAPI == 'cli')
  die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../../plugin/Classes/PHPExcel.php';
require_once '../../plugin/Classes/PHPExcel/IOFactory.php';
// require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
function belen_price($v_date_start,$v_date_end,$pro_name_id) {


    global $connect;
    // start stock_early
       $v_sql_eanly = "SELECT A.*,B.stca_name,B.stca_code,C.stun_name,B.stca_id,
                (
                    (
                        SELECT IFNULL(SUM(in_qty),0)
                        FROM tbl_st_stock_in AS AA 
                        LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                        WHERE AA.stsin_date_in<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )-
                    (
                        SELECT IFNULL(SUM(out_qty),0)
                        FROM tbl_st_stock_out AS AA 
                        LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
                        WHERE AA.stsout_date_out<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )+
                    (
                        SELECT IFNULL(SUM(qty_adjust),0)
                        FROM tbl_st_stock_adjustment AS AA 
                        LEFT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
                        WHERE  AA.stsadj_date_record <'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )
                ) AS begining_bal_qty,
                (
                    (
                        SELECT SUM(
                                    (IFNULL(in_qty,0)*in_price_vn/stsin_exchange_rate)
                                        +(in_price_dollar*IFNULL(in_qty,0))
                                    )
                        FROM tbl_st_stock_in AS AA 
                        LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                        WHERE AA.stsin_date_in<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )
                ) AS begining_bal_price,
                (
                    SELECT CONCAT(
                                SUM(in_qty),
                                '=',
                                SUM((in_price_vn/stsin_exchange_rate)+in_price_dollar)*IFNULL(SUM(in_qty),0)
                            )
                    FROM tbl_st_stock_in AS AA 
                    LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                    WHERE  AA.stsin_date_in BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                ) current_in,
                (
                    SELECT SUM(out_qty) 
                    FROM tbl_st_stock_out AS AA 
                    LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
                    WHERE  AA.stsout_date_out BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                ) current_out,
                (
                    SELECT SUM(BB.qty_adjust) 
                    FROM tbl_st_stock_adjustment AS AA 
                    RIGHT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
                    WHERE  AA.stsadj_date_record BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                )current_adjust
                FROM tbl_st_product_name AS A 
                LEFT JOIN tbl_st_category_list AS B ON A.stpron_category=B.stca_id
                LEFT JOIN tbl_st_unit_list AS C ON A.stpron_unit=C.stun_id
                WHERE A.stpron_material_type='3' OR A.stpron_material_type='5' AND A.stpron_id='$pro_name_id' 
                HAVING 

                (
                    (
                        SELECT IFNULL(SUM(in_qty),0)
                        FROM tbl_st_stock_in AS AA 
                        LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                        WHERE AA.stsin_date_in<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )-
                    (
                        SELECT IFNULL(SUM(out_qty),0)
                        FROM tbl_st_stock_out AS AA 
                        LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
                        WHERE AA.stsout_date_out<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )+
                    (
                        SELECT IFNULL(SUM(qty_adjust),0)
                        FROM tbl_st_stock_adjustment AS AA 
                        LEFT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
                        WHERE  AA.stsadj_date_record BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                        AND BB.pro_id=A.stpron_id
                    )
                )>0 OR 
                (
                    SELECT SUM(in_qty) 
                    FROM tbl_st_stock_in AS AA 
                    LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                    WHERE  AA.stsin_date_in BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                )>0 OR
                (
                    SELECT SUM(out_qty) 
                    FROM tbl_st_stock_out AS AA 
                    LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
                    WHERE  AA.stsout_date_out BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                )>0 
                OR 
                (
                    SELECT SUM(qty_adjust)
                    FROM tbl_st_stock_adjustment AS AA 
                    LEFT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
                    WHERE  AA.stsadj_date_record BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                )<>0

                ";
              //  echo $v_sql_eanly."<br>";
// echo $v_sql;
$get_data_early = $connect->query($v_sql_eanly);
      
       $v_cat_name_tmp = [];

                $v_total_price_beg = 0;
                $v_total_price_in = 0;
                $v_total_qty_in = 0;
                $v_total_price_out = 0;
                $v_total_qty_out = 0;
                $v_total_price_adjust = 0;
                $v_total_qty_adjust = 0;
                $v_total_price_bal = 0;
                $v_total_qty_bal = 0;
                $v_arr_summary = [];
            
     
     
  while ($row_a = mysqli_fetch_object($get_data_early)) {

// if (!in_array($row_a->stca_name, $v_cat_name_tmp)) {
//                         array_push($v_cat_name_tmp, $row_a->stca_name);
                        
//                     }
   
     // =========================== Start Calculation ====================
                    $v_begining_bal_qty = ($row_a->begining_bal_qty ?: 0);
                    $v_begining_bal_price =round(($row_a->begining_bal_price ?: 0), 2);

                     


                    
                    
         // echo $a_id."<br>";

                    $v_arr_in = explode("=", $row_a->current_in);
                    $v_current_in_qty = (@$v_arr_in[0] ?: 0);
                    $v_current_in_price = round((@$v_arr_in[1] ?: 0), 2);

                    $v_array = [
                        'begining_bal_price' => $v_begining_bal_price,
                        'begining_bal_qty' => $v_begining_bal_qty,
                        'current_in_price' => $v_current_in_price,
                        'current_in_qty' => $v_current_in_qty
                    ];

                    $result_cost = myCalCostAverage($v_array);

                    $v_last_qty = ($v_begining_bal_qty + $v_current_in_qty - @$row_a->current_out + @$row_a->current_adjust);
                    // =========================== End Calculation ====================
                     $v_total_price_beg += $v_begining_bal_price;
                    $v_total_qty_in += $v_current_in_qty;
                    $v_total_price_in += $v_current_in_price;
                    $v_total_price_out += $result_cost * $row_a->current_out;
                    $v_total_qty_out += $row_a->current_out;
                    $v_total_price_adjust += $result_cost * $row_a->current_adjust;
                    $v_total_qty_adjust += $row_a->current_adjust;
                    $v_total_price_bal += $v_last_qty * $result_cost;
                    $v_total_qty_bal += $v_last_qty;

                    $arr_child = [
                        $row_a->stca_id => $row_a->stca_id,
                        'price_beg' => $v_begining_bal_price,
                        'price_in' => $v_current_in_price,
                        'price_out' => $result_cost * $row_a->current_out,
                        'price_adjust' => $result_cost * $row_a->current_adjust,
                        'price_end' => $v_last_qty * $result_cost
                    ];
                    array_push($v_arr_summary, $arr_child);
                   
                }
 

               


     

       // end stock ealy
}

function numberToRomanRepresentation($number) {
    $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
    $returnValue = '';
    while ($number > 0) {
        foreach ($map as $roman => $int) {
            if($number >= $int) {
                $number -= $int;
                $returnValue .= $roman;
                break;
            }
        }
    }
    return $returnValue;
}

if (isset($_GET['txt_month_start']) && isset($_GET['txt_month_end']) && isset($_GET['txt_truck_name']) ) {
     $date1 = @$_GET['txt_month_start'];
    $date2 = @$_GET['txt_month_end'];
    $txt_truck_name_id=@$_GET['txt_truck_name'];
    $txt_location=@$_GET['txt_location'];
            if($txt_truck_name_id !="") {
                $truck_id_search=$txt_truck_name_id;
               
                $query_truck='WHERE tbl_group_truck.id='.$truck_id_search.' ';
                $date_query='AND A.stsout_date_out BETWEEN "'.$date1.'" AND  "'.$date2.'" ';
            }
            else {
                $query_truck='';
                $date_query='AND A.stsout_date_out BETWEEN "'.$date1.'" AND  "'.$date2.'" ';
            }

            if($txt_location !="") {
                $location_id_search=$txt_location;
                $query_location='AND B.locaton_id="'.$location_id_search.'" ';
            }
            else {
                $query_location="";
            }




}
else {
      $query_truck='';
     $date_query='';
     $date1=$date2=$txt_truck_name_id=$query_location="";
}


// set number column

// $objPHPExcel->getActiveSheet()->getStyle('C')
// ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1); 
$objPHPExcel->getActiveSheet()->getStyle('D')
->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1); 
$objPHPExcel->getActiveSheet()->getStyle('E')
->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1); 
$objPHPExcel->getActiveSheet()->getStyle('F')
->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1); 
$objPHPExcel->getActiveSheet()->getStyle('G')
->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1); 
$objPHPExcel->getActiveSheet()->getStyle('H')
->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1); 
$objPHPExcel->getActiveSheet()->getStyle('I')
->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1); 
$objPHPExcel->getActiveSheet()->getStyle('J')
->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1); 

// Set document properties
$objPHPExcel->getProperties()->setCreator("Silak")
                             ->setLastModifiedBy("Silak")
                             ->setTitle("Rithy granite company")
                             ->setSubject("Rithy granite company")
                             ->setDescription("Rithy granite company")
                             ->setKeywords("Rithy granite company")
                             ->setCategory("Test result file");

$objPHPExcel->getActiveSheet()->setCellValue('E' . 1, 'របាយការណ៍សម្ភារៈប្រើប្រាស់ក្នុងការជួសជុល ប្រចាំខែ'.' '.date('d/m/Y', strtotime($date1)).'-'. date('d/m/Y', strtotime($date2)));
$objPHPExcel->getActiveSheet()->setCellValue('F' . 2, 'Báo Cáo vật tư sử dụng trong sửa chữa của tháng');
$idx=6;
// Header
$objPHPExcel->getActiveSheet()->setCellValue('A' . 4, 'ល.រ');
$objPHPExcel->getActiveSheet()->setCellValue('B' . 4, 'បរិយាយ');
$objPHPExcel->getActiveSheet()->setCellValue('C' . 4, 'លេខសម្គាល់');
$objPHPExcel->getActiveSheet()->setCellValue('D' . 4, 'តម្លៃជាមធ្យម');
$objPHPExcel->getActiveSheet()->setCellValue('E' . 4, 'ទីតាំង');
$objPHPExcel->getActiveSheet()->setCellValue('F' . 4, 'ចេញ / OUT');
$objPHPExcel->getActiveSheet()->setCellValue('H' . 4, 'លេខ PO');
$objPHPExcel->getActiveSheet()->setCellValue('I' . 4, 'ទីតាំងទិញ');

$objPHPExcel->getActiveSheet()->setCellValue('F' . 5, 'បរិមាណ');
$objPHPExcel->getActiveSheet()->setCellValue('G' . 5, 'ទឹកប្រាក់');

// Header
$objPHPExcel->getActiveSheet()->setCellValue('A' . 6, 'N°');
$objPHPExcel->getActiveSheet()->setCellValue('B' . 6, 'Description');
$objPHPExcel->getActiveSheet()->setCellValue('C' . 6, 'ID');
$objPHPExcel->getActiveSheet()->setCellValue('D' . 6, 'Price');
$objPHPExcel->getActiveSheet()->setCellValue('E' . 6, 'Section');
$objPHPExcel->getActiveSheet()->setCellValue('F' . 6, 'QTY');
$objPHPExcel->getActiveSheet()->setCellValue('G' . 6, '$');
$objPHPExcel->getActiveSheet()->setCellValue('H' . 6, 'PO');
$objPHPExcel->getActiveSheet()->setCellValue('I' . 6, 'MUA');


// merge column
$objPHPExcel->getActiveSheet()->mergeCells('A4:A5');
$objPHPExcel->getActiveSheet()->getStyle('A4:A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->mergeCells('B4:B5');
$objPHPExcel->getActiveSheet()->getStyle('B4:B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->mergeCells('C4:C5');
$objPHPExcel->getActiveSheet()->getStyle('C4:C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->mergeCells('D4:D5');
$objPHPExcel->getActiveSheet()->getStyle('D4:D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->mergeCells('E4:E5');
$objPHPExcel->getActiveSheet()->getStyle('E4:E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->mergeCells('F4:G4');
$objPHPExcel->getActiveSheet()->getStyle('F4:G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->mergeCells('H4:H5');
$objPHPExcel->getActiveSheet()->getStyle('H4:H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->mergeCells('I4:I5');
$objPHPExcel->getActiveSheet()->getStyle('I4:I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                   $loop_i=0;
                    $track_name="";
                    $truck_id=0;
                   
                    $v_sql_report = "SELECT * FROM tbl_group_truck
                    LEFT JOIN tbl_group_truck_items
                    ON tbl_group_truck_items.group_id=tbl_group_truck.id
                    INNER JOIN tbl_st_stock_out_detail
                    ON tbl_st_stock_out_detail.track_mac_id=tbl_group_truck_items.truck_machin_id

                    LEFT JOIN tbl_st_track_machine_list
                    ON tbl_group_truck_items.truck_machin_id=tbl_st_track_machine_list.id
                    $query_truck
                    GROUP BY tbl_group_truck.id ORDER BY order_number
                ";           
     $get_data =$connect->query($v_sql_report);
    $status_track=0;

    while ($rows = mysqli_fetch_object($get_data)) {
      $truck_id=$rows->id;
      $machin_id=$rows->truck_machin_id;

     if($track_name !=$rows->name) {
        ++$status_track;
        if($loop_i==0) {
           $objPHPExcel->getActiveSheet()->setCellValue('A' . 7,numberToRomanRepresentation(++$loop_i));
           $objPHPExcel->getActiveSheet()->setCellValue('B' . 7,$rows->name);
           $idx=7;

        }
        else {
          $idx +=1;
          $objPHPExcel->getActiveSheet()->setCellValue('A' .$idx,numberToRomanRepresentation(++$loop_i));
          $objPHPExcel->getActiveSheet()->setCellValue('B' .$idx,$rows->name);
        }
        $track_name=$rows->name;
        $is_truck=true;
        $idx +=1;


         }
        else {
            $is_truck =false;
            $idx +=0;
        }

         $v_sql_detail = "SELECT 
                                    A.stsout_date_out,A.stsout_letter_no,B.out_qty,B.pro_id,C.stpron_name_vn,
                                    DATE_FORMAT(A.stsout_date_out,'%m/%Y') AS group_month,
                                    B.out_qty,
                        D.stun_name,B.stsout_id,B.locaton_id,C.stpron_code,A.stsout_note,
                        F.supsi_name,C.stpron_name_kh,A.stock_status,
                                    (
                                        SELECT 
                                        COUNT(*)
                                        FROM tbl_st_stock_out_detail AS AA 
                                        WHERE AA.track_mac_id=B.track_mac_id
                                        AND AA.stsout_id=A.stsout_id
                                    ) AS group_letter_no,
                                    (
                                        SELECT 
                                            COUNT(*)
                                        FROM tbl_st_stock_out_detail AS AA 
                                        LEFT JOIN tbl_st_stock_out AS BB ON AA.stsout_id=BB.stsout_id
                                        WHERE AA.track_mac_id=B.track_mac_id
                                        AND BB.stock_status=A.stock_status
                                        AND DATE_FORMAT(BB.stsout_date_out,'%Y-%m')=DATE_FORMAT(A.stsout_date_out,'%Y-%m')
                                    ) AS group_row_monthly
                                    FROM tbl_st_stock_out AS A 
                                    LEFT JOIN tbl_st_stock_out_detail AS B ON A.stsout_id=B.stsout_id
                                   
                                    LEFT JOIN tbl_st_product_name AS C ON B.pro_id=C.stpron_id
                                    LEFT JOIN tbl_st_unit_list AS D ON B.unit_id=D.stun_id
                                    LEFT JOIN tbl_st_stock_in AS E ON E.stsin_letter_no=A.stsout_letter_no
                                     LEFT JOIN tbl_sup_supplier_info AS F ON F.supsi_id=E.stsin_supp_id
                                   
                                     WHERE A.stock_status='3' OR A.stock_status='5'
                                    AND B.track_mac_id='$machin_id'

                                    $date_query $query_location
                                   
                                    GROUP BY  B.std_id,MONTH(A.stsout_date_out),YEAR(A.stsout_date_out)
                                    ORDER BY A.stsout_date_out";
                                   
                    $v_result = $connect->query($v_sql_detail);
                    $i = 0;
                    $v_total=0;
                    $total_by_cate=0;
                    while ($row = mysqli_fetch_object($v_result)) {
                         if($row->pro_id !="") { 
                        $v_unit_price = getCostPerProductName($row->stsout_date_out, $row->pro_id,$row->stock_status);
                        $v_total = ($v_unit_price * $row->out_qty);
                        if($track_name ==$rows->name) {
                            $total_by_cate +=$v_total;
                        }




        $objPHPExcel->getActiveSheet()->setCellValue('A' .$idx,++$i);
        $objPHPExcel->getActiveSheet()->setCellValue('B' .$idx,$rows->name_vn.' | '.$row->stpron_name_vn);
        $objPHPExcel->getActiveSheet()->setCellValue('C' .$idx,$row->stpron_code);
        $objPHPExcel->getActiveSheet()->setCellValue('D' .$idx,$v_unit_price);
        if($row->locaton_id==0) {
                               
         $objPHPExcel->getActiveSheet()->setCellValue('E' .$idx,"រោងចក្រ");

                              }
                              else if($row->locaton_id==1) {
                               
         $objPHPExcel->getActiveSheet()->setCellValue('E' .$idx,"រណ្ដៅ");
                              }
                              else if($row->locaton_id==2) {
                                
        $objPHPExcel->getActiveSheet()->setCellValue('E' .$idx,"រោងជាង");
                              }
                              else {
        $objPHPExcel->getActiveSheet()->setCellValue('E' .$idx,"");
                              }
        $objPHPExcel->getActiveSheet()->setCellValue('F' .$idx,$row->out_qty);
        $objPHPExcel->getActiveSheet()->setCellValue('G' .$idx,$v_total);
        $objPHPExcel->getActiveSheet()->setCellValue('H' .$idx,$row->stsout_letter_no);
        $objPHPExcel->getActiveSheet()->setCellValue('I' .$idx,$row->supsi_name);
        ++$idx;

    }
       

      }

        $objPHPExcel->getActiveSheet()->setCellValue('A' .$idx,"TOTAL".$rows->name);
        $objPHPExcel->getActiveSheet()->setCellValue('G' .$idx,$total_by_cate);

        $objPHPExcel->getActiveSheet()->mergeCells("A$idx:B$idx");
$objPHPExcel->getActiveSheet()->getStyle("A$idx:B$idx")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



}

$idx_truck=$idx+3;
$txt_check_la_id=@$_GET['txt_location'];
 $txt_check_tr_id=@$_GET['txt_truck_name'];
   if( ($txt_check_tr_id !="" || $txt_check_tr_id =="") && ($txt_check_la_id=="")){
    $objPHPExcel->getActiveSheet()->setCellValue('B' .$idx_truck,"***** TRUCK");
    $idx_truck=$idx_truck+1;
    $objPHPExcel->getActiveSheet()->setCellValue('B' .$idx_truck,"Nº");
    $objPHPExcel->getActiveSheet()->setCellValue('C' .$idx_truck,"Description");
    $objPHPExcel->getActiveSheet()->setCellValue('D' .$idx_truck,"BEGINNING($)");
    $objPHPExcel->getActiveSheet()->setCellValue('E' .$idx_truck,"IN/NHAP($)");
    $objPHPExcel->getActiveSheet()->setCellValue('F' .$idx_truck,"OUT/XUAT($)");

    

    if (isset($_GET['txt_month_start'])) {
    $date1 = @$_GET['txt_month_start'];
    $date2 = @$_GET['txt_month_end'];
    $v_date_start =$date1;
    $v_date_end =$date2;
    $condition = "A.stsin_date_in BETWEEN '$v_date_start' 
                    AND '$v_date_end' 
                    AND A.stock_status='3' OR A.stock_status='5' ";
} else {
    $v_date_start = date('Y-m-01');
    $v_date_end = date('Y-m-t');
    $condition = "DATE_FORMAT(A.stsin_date_in,'%Y-%m')='" . date('Y-m') . "'
            AND A.stock_status='3' OR A.stock_status='5' ";
}

if($query_truck !="") {
    $date_query_turck='AND stsout_date_out BETWEEN "'.$date1.'" AND  "'.$date2.'" ';
}
else {
     $date_query_turck='WHERE stsout_date_out BETWEEN "'.$date1.'" AND  "'.$date2.'" ';
}
        $truck_id=0;
         $v_sql_truck = "SELECT *,tbl_group_truck.id as id_kemun FROM tbl_group_truck
                    LEFT JOIN tbl_group_truck_items
                    ON tbl_group_truck_items.group_id=tbl_group_truck.id
                    LEFT JOIN tbl_st_stock_out_detail
                    ON tbl_st_stock_out_detail.track_mac_id=tbl_group_truck_items.truck_machin_id
                    LEFT JOIN tbl_st_stock_out ON 
                    tbl_st_stock_out_detail.stsout_id=tbl_st_stock_out.stsout_id

                    LEFT JOIN tbl_st_track_machine_list
                    ON tbl_group_truck_items.truck_machin_id=tbl_st_track_machine_list.id
                    $query_truck $date_query_turck
  GROUP BY tbl_group_truck.id
                    ORDER BY order_number
                ";  
               // echo $v_sql_truck;
                       
    $get_data_truck =$connect->query($v_sql_truck);

   
    $i_truck=0;
    $track_name="";
    $amount_truck_be=0;
    $amount_truck_in=0;
    $amount_truck_out=0;
    $total_stock_in=0;
    $loop_belen=0;
    while ($rows = mysqli_fetch_object($get_data_truck)) {
      $truck_id=$rows->id;
      $machin_id=$rows->truck_machin_id;

      $v_sql_truck_cate= "SELECT 
                                    A.stsout_date_out,A.stsout_letter_no,B.out_qty,B.pro_id,C.stpron_name_vn,
                                    DATE_FORMAT(A.stsout_date_out,'%m/%Y') AS group_month,
                                    B.out_qty,
                        D.stun_name,B.stsout_id,B.locaton_id,C.stpron_code,A.stsout_note,
                        F.supsi_name,C.stpron_name_kh,C.stpron_id as pro_name_id,A.stock_status,
                        -- DISTINCT C.stpron_id),
                                    (
                                        SELECT 
                                        COUNT(*)
                                        FROM tbl_st_stock_out_detail AS AA 
                                        WHERE AA.track_mac_id=B.track_mac_id
                                        AND AA.stsout_id=A.stsout_id
                                    ) AS group_letter_no,
                                    (
                                        SELECT 
                                            COUNT(*)
                                        FROM tbl_st_stock_out_detail AS AA 
                                        LEFT JOIN tbl_st_stock_out AS BB ON AA.stsout_id=BB.stsout_id
                                        WHERE AA.track_mac_id=B.track_mac_id
                                        AND BB.stock_status=A.stock_status
                                        AND DATE_FORMAT(BB.stsout_date_out,'%Y-%m')=DATE_FORMAT(A.stsout_date_out,'%Y-%m')
                                    ) AS group_row_monthly
                                    FROM tbl_st_stock_out AS A 
                                    LEFT JOIN tbl_st_stock_out_detail AS B ON A.stsout_id=B.stsout_id
                                   
                                    LEFT JOIN tbl_st_product_name AS C ON B.pro_id=C.stpron_id
                                    LEFT JOIN tbl_st_unit_list AS D ON B.unit_id=D.stun_id
                                    LEFT JOIN tbl_st_stock_in AS E ON E.stsin_letter_no=A.stsout_letter_no
                                     LEFT JOIN tbl_sup_supplier_info AS F ON F.supsi_id=E.stsin_supp_id
                                   
                                   
                                    WHERE A.stock_status='3' OR A.stock_status='5'
                                    AND B.track_mac_id='$machin_id'

                                    $date_query 
                                   
                                    GROUP BY  B.std_id,MONTH(A.stsout_date_out),YEAR(A.stsout_date_out)
                                    ORDER BY A.stsout_date_out";

                                   
                    $v_result = $connect->query($v_sql_truck_cate);
                    $v_total=0;
                    $total_by_cate=0;
                    $pro_name_id=0;
                     $total_stock_in=0;
                    


                    while ($row = mysqli_fetch_object($v_result)) {
                        $pro_name_id=$row->pro_name_id;
                        if($row->pro_id !="") {
                        $v_unit_price = getCostPerProductName($row->stsout_date_out, $row->pro_id,$row->stock_status);
                        $v_total = ($v_unit_price * $row->out_qty);
                        $track_name=$rows->name;

                        if($track_name ==$rows->name) {
                            $total_by_cate +=$v_total;
                        }

                   // IN stock
                      
      $v_sql_stock_in = "SELECT A.*,B.*,C.*,
           (B.in_qty*B.in_price_vn/A.stsin_exchange_rate)+(B.in_qty*B.in_price_dollar) AS total_in

                         FROM tbl_st_stock_in AS A
                            LEFT JOIN tbl_st_stock_in_detail AS B
                            ON A.stsin_id=B.stsin_id  
                            LEFT JOIN tbl_st_product_name AS C On B.pro_id=C.stpron_id  
                         WHERE    C.stpron_id='$pro_name_id'  
                         AND A.stsin_date_in BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                          "; 
              //echo $v_sql_stock_in."<br>";          
      $get_data_in =$connect->query($v_sql_stock_in);
     
      $status_in=0;
      $in_id="";
     
       while ($row_in = mysqli_fetch_object($get_data_in)) {


        
          if($in_id !=$row_in->stpron_id) {

             ++$status_in;
             $in_id=$row_in->stpron_id;
             $total_stock_in +=$row_in->total_in;
             $is_in=true;
          }

          else {
             $is_in=false;
          }


       }
       // end in stock
   }

     }

         // start belen_price

                $v_sql_truck_belent = "SELECT *,tbl_group_truck.id as id_kemun FROM tbl_group_truck
                    LEFT JOIN tbl_group_truck_items
                    ON tbl_group_truck_items.group_id=tbl_group_truck.id
                    INNER JOIN tbl_st_stock_out_detail
                    ON tbl_st_stock_out_detail.track_mac_id=tbl_group_truck_items.truck_machin_id
                    LEFT JOIN tbl_st_track_machine_list
                    ON tbl_group_truck_items.truck_machin_id=tbl_st_track_machine_list.id
                    INNER JOIN tbl_st_product_name  
                    ON tbl_st_stock_out_detail.pro_id=tbl_st_product_name.stpron_id
                    $query_truck
                    -- GROUP BY truck_machin_id
                      ORDER BY order_number
                "; 
                //echo $v_sql_truck_belent; 
                       
    $get_truck_belen =$connect->query($v_sql_truck_belent);
    $pro_name_id=0;
    $a_pro_id_last="";
    $track_name_last="";
    $total_stock_early1=0;
    $total_stock_early2=0;
    $total_stock_early3=0;
    $total_stock_early4=0;
    $total_stock_early5=0;
    $i_kemn=0;
    $status_kemun=0;
    $status_kemun1=0;

     while ($row= mysqli_fetch_object($get_truck_belen)) {
        $p_name_id=$row->stpron_id;


        // start stock_early
       $v_sql_eanly = "SELECT A.*,B.stca_name,B.stca_code,C.stun_name,B.stca_id,
                (
                    (
                        SELECT IFNULL(SUM(in_qty),0)
                        FROM tbl_st_stock_in AS AA 
                        LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                        WHERE AA.stsin_date_in<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )-
                    (
                        SELECT IFNULL(SUM(out_qty),0)
                        FROM tbl_st_stock_out AS AA 
                        LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
                        WHERE AA.stsout_date_out<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )+
                    (
                        SELECT IFNULL(SUM(qty_adjust),0)
                        FROM tbl_st_stock_adjustment AS AA 
                        LEFT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
                        WHERE  AA.stsadj_date_record <'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )
                ) AS begining_bal_qty,
                (
                    (
                        SELECT SUM(
                                    (IFNULL(in_qty,0)*in_price_vn/stsin_exchange_rate)
                                        +(in_price_dollar*IFNULL(in_qty,0))
                                    )
                        FROM tbl_st_stock_in AS AA 
                        LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                        WHERE AA.stsin_date_in<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )
                ) AS begining_bal_price,
                (
                    SELECT CONCAT(
                                SUM(in_qty),
                                '=',
                                SUM((in_price_vn/stsin_exchange_rate)+in_price_dollar)*IFNULL(SUM(in_qty),0)
                            )
                    FROM tbl_st_stock_in AS AA 
                    LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                    WHERE  AA.stsin_date_in BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                ) current_in,
                (
                    SELECT SUM(out_qty) 
                    FROM tbl_st_stock_out AS AA 
                    LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
                    WHERE  AA.stsout_date_out BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                ) current_out,
                (
                    SELECT SUM(BB.qty_adjust) 
                    FROM tbl_st_stock_adjustment AS AA 
                    RIGHT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
                    WHERE  AA.stsadj_date_record BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                )current_adjust
                FROM tbl_st_product_name AS A 
                LEFT JOIN tbl_st_category_list AS B ON A.stpron_category=B.stca_id
                LEFT JOIN tbl_st_unit_list AS C ON A.stpron_unit=C.stun_id
                WHERE A.stpron_material_type='3' OR A.stpron_material_type='5' AND A.stpron_id='$p_name_id' 
                HAVING 

                (
                    (
                        SELECT IFNULL(SUM(in_qty),0)
                        FROM tbl_st_stock_in AS AA 
                        LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                        WHERE AA.stsin_date_in<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )-
                    (
                        SELECT IFNULL(SUM(out_qty),0)
                        FROM tbl_st_stock_out AS AA 
                        LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
                        WHERE AA.stsout_date_out<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )+
                    (
                        SELECT IFNULL(SUM(qty_adjust),0)
                        FROM tbl_st_stock_adjustment AS AA 
                        LEFT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
                        WHERE  AA.stsadj_date_record BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                        AND BB.pro_id=A.stpron_id
                    )
                )>0 OR 
                (
                    SELECT SUM(in_qty) 
                    FROM tbl_st_stock_in AS AA 
                    LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                    WHERE  AA.stsin_date_in BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                )>0 OR
                (
                    SELECT SUM(out_qty) 
                    FROM tbl_st_stock_out AS AA 
                    LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
                    WHERE  AA.stsout_date_out BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                )>0 
                OR 
                (
                    SELECT SUM(qty_adjust)
                    FROM tbl_st_stock_adjustment AS AA 
                    LEFT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
                    WHERE  AA.stsadj_date_record BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                )<>0

                ";
              // echo $v_sql_eanly."<br>";
// echo $v_sql;
$get_data_early = $connect->query($v_sql_eanly);
      
       $v_cat_name_tmp = [];

                $v_total_price_beg = 0;
                $v_total_price_in = 0;
                $v_total_qty_in = 0;
                $v_total_price_out = 0;
                $v_total_qty_out = 0;
                $v_total_price_adjust = 0;
                $v_total_qty_adjust = 0;
                $v_total_price_bal = 0;
                $v_total_qty_bal = 0;
                $v_arr_summary = [];
            
     
     
  while ($row_a = mysqli_fetch_object($get_data_early)) {

// if (!in_array($row_a->stca_name, $v_cat_name_tmp)) {
//                         array_push($v_cat_name_tmp, $row_a->stca_name);
                        
//                     }
   
     // =========================== Start Calculation ====================
                    $v_begining_bal_qty = ($row_a->begining_bal_qty ?: 0);
                    $v_begining_bal_price =round(($row_a->begining_bal_price ?: 0), 2);

                     


                    
                    
         // echo $a_id."<br>";

                    $v_arr_in = explode("=", $row_a->current_in);
                    $v_current_in_qty = (@$v_arr_in[0] ?: 0);
                    $v_current_in_price = round((@$v_arr_in[1] ?: 0), 2);

                    $v_array = [
                        'begining_bal_price' => $v_begining_bal_price,
                        'begining_bal_qty' => $v_begining_bal_qty,
                        'current_in_price' => $v_current_in_price,
                        'current_in_qty' => $v_current_in_qty
                    ];

                    $result_cost = myCalCostAverage($v_array);

                    $v_last_qty = ($v_begining_bal_qty + $v_current_in_qty - @$row_a->current_out + @$row_a->current_adjust);
                    // =========================== End Calculation ====================
                     $v_total_price_beg += $v_begining_bal_price;
                    $v_total_qty_in += $v_current_in_qty;
                    $v_total_price_in += $v_current_in_price;
                    $v_total_price_out += $result_cost * $row_a->current_out;
                    $v_total_qty_out += $row_a->current_out;
                    $v_total_price_adjust += $result_cost * $row_a->current_adjust;
                    $v_total_qty_adjust += $row_a->current_adjust;
                    $v_total_price_bal += $v_last_qty * $result_cost;
                    $v_total_qty_bal += $v_last_qty;

                    $arr_child = [
                        $row_a->stca_id => $row_a->stca_id,
                        'price_beg' => $v_begining_bal_price,
                        'price_in' => $v_current_in_price,
                        'price_out' => $result_cost * $row_a->current_out,
                        'price_adjust' => $result_cost * $row_a->current_adjust,
                        'price_end' => $v_last_qty * $result_cost
                    ];
                    array_push($v_arr_summary, $arr_child);
                   
                }
 

               


     

       // end stock ealy
               
                if($track_name_last=="XE SK / គ្រឿងចក្រអេស្កា") {
                   
                    
                    if($a_pro_id_last !=$row->stpron_id) {
                    
                        $total_stock_early1 +=$v_begining_bal_price;
                    }
                    else {
                        //$total_stock_early1 =$v_begining_bal_price;
                    }

                }

                else if($track_name_last=="XE BEN / គ្រឿងចក្រឡានបែន") {
                    if($a_pro_id_last !=$row->stpron_id) {


                        $total_stock_early2 +=$v_begining_bal_price;
                    }
                    else {
                        //$total_stock_early2 =$v_begining_bal_price;
                    }

                }

                 else if($track_name_last=="NHOM XE KHAC / ផ្សេងៗ") {
                    if($a_pro_id_last !=$row->stpron_id) {


                        $total_stock_early3 +=$v_begining_bal_price;
                    }
                    else {
                        //$total_stock_early3 =$v_begining_bal_price;
                    }

                }

                 else if($track_name_last=="XE SASER 15T / គ្រឿងចក្រសាសឺរ") {
                    if($a_pro_id_last !=$row->stpron_id) {

                        $total_stock_early4 +=$v_begining_bal_price;
                    }
                    else {
                        //$total_stock_early3 =$v_begining_bal_price;
                    }

                }

                 else if($track_name_last=="XUONG CO KHI / ​រោងជាង") {
                    if($a_pro_id_last !=$row->stpron_id) {

                        $total_stock_early5 +=$v_begining_bal_price;
                    }
                    else {
                        //$total_stock_early3 =$v_begining_bal_price;
                    }

                }

            
            
           $track_name_last=$row->name;
           $a_pro_id_last=$row->stpron_id;
            

           
     }
     $amount_truck_be =$v_begining_bal_price;

        // end start balen
$idx_truck +=1;

    $objPHPExcel->getActiveSheet()->setCellValue('B'.$idx_truck,(++$i_truck));
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$idx_truck,$rows->name);
    $name_check=$rows->name; 
                            if($name_check=="XE SK / គ្រឿងចក្រអេស្កា") {
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$idx_truck,$total_stock_early1);
                                  
                                }
                                else if($name_check=="XE BEN / គ្រឿងចក្រឡានបែន"){
   $objPHPExcel->getActiveSheet()->setCellValue('D'.$idx_truck,$total_stock_early2);
                                }
                                else if($name_check=="NHOM XE KHAC / ផ្សេងៗ"){
   $objPHPExcel->getActiveSheet()->setCellValue('D'.$idx_truck,$total_stock_early3);
                                }
                                else if($name_check=="XE SASER 15T / គ្រឿងចក្រសាសឺរ"){
   $objPHPExcel->getActiveSheet()->setCellValue('D'.$idx_truck,$total_stock_early4);
                                }
                                else if($name_check=="XUONG CO KHI / ​រោងជាង"){
   $objPHPExcel->getActiveSheet()->setCellValue('D'.$idx_truck,$total_stock_early5);
                                }
                                else {
   $objPHPExcel->getActiveSheet()->setCellValue('D'.$idx_truck,0);
                                }
   $objPHPExcel->getActiveSheet()->setCellValue('E'.$idx_truck,$total_stock_in);
   $objPHPExcel->getActiveSheet()->setCellValue('F'.$idx_truck,$total_by_cate);

    $amount_truck_be =$total_stock_early1
                     +$total_stock_early2
                     +$total_stock_early3
                     +$total_stock_early4
                     +$total_stock_early5;
                     $amount_truck_in +=$total_stock_in;
                     $amount_truck_out +=$total_by_cate;


 }
 ++$idx_truck;
 
 $objPHPExcel->getActiveSheet()->setCellValue('B'.$idx_truck,"TOTAL/CONG");
 $objPHPExcel->getActiveSheet()->mergeCells("B$idx_truck:C$idx_truck");
$objPHPExcel->getActiveSheet()->getStyle("B$idx_truck:C$idx_truck")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

 $objPHPExcel->getActiveSheet()->setCellValue('D'.$idx_truck,$amount_truck_be);
 $objPHPExcel->getActiveSheet()->setCellValue('E'.$idx_truck,$amount_truck_in);
 $objPHPExcel->getActiveSheet()->setCellValue('F'.$idx_truck,$amount_truck_out);
    

      }



 $txt_check_la_id=@$_GET['txt_location'];
 $txt_check_tr_id=@$_GET['txt_truck_name'];
   if( ($txt_check_la_id !="" || $txt_check_la_id =="") && ($txt_check_tr_id=="")) {
    $total_stock_in_section1=0;
    $total_stock_in_section2=0;
    $total_stock_in_section3=0;
    $idx_location=$idx_truck+3;
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$idx_location,'***** SECTION');
    $e_idx_location_start=$idx_location+1;
    $idx_location+=1;

    $objPHPExcel->getActiveSheet()->setCellValue('B'.$idx_location,'Nº');
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$idx_location,'Description');
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$idx_location,'BEGINNING($)');
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$idx_location,'IN/NHAP($)');
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$idx_location,'OUT/XUAT($)');

    if (isset($_GET['txt_month_start'])) {
    $date1 = @$_GET['txt_month_start'];
    $date2 = @$_GET['txt_month_end'];
    $v_date_start =$date1;
    $v_date_end =$date2;
    $condition = "A.stsin_date_in BETWEEN '$v_date_start' 
                    AND '$v_date_end' 
                    AND A.stock_status='3' OR A.stock_status='5' ";
    $txt_location_section=@$_GET['txt_location'];
     if($txt_location_section !="") {
                $location_section_search=$txt_location_section;
                $query_location_section='WHERE tbl_st_stock_out_detail.locaton_id="'.$location_section_search.'" ';
            }
            else {
                $query_location_section="";
            }



} else {
    $query_location_section="";
    $v_date_start = date('Y-m-01');
    $v_date_end = date('Y-m-t');
    $condition = "DATE_FORMAT(A.stsin_date_in,'%Y-%m')='" . date('Y-m') . "'
            AND A.stock_status='3' OR A.stock_status='5' ";
}
        $truck_id=0;
                    $v_sql_truck = "SELECT *,tbl_group_truck.id as id_kemun FROM tbl_group_truck
                    LEFT JOIN tbl_group_truck_items
                    ON tbl_group_truck_items.group_id=tbl_group_truck.id
                    INNER JOIN tbl_st_stock_out_detail
                    ON tbl_st_stock_out_detail.track_mac_id=tbl_group_truck_items.truck_machin_id
                    LEFT JOIN tbl_st_track_machine_list
                    ON tbl_group_truck_items.truck_machin_id=tbl_st_track_machine_list.id
                    $query_location_section
                    
                    GROUP BY tbl_st_stock_out_detail.locaton_id
                ";  

               // echo $v_sql_truck."<br>";
                       
    $get_data_truck =$connect->query($v_sql_truck);

   
    $i_truck=0;
    $track_name="";
    $amount_truck_be=0;
    
    $amount_truck_out=0;
    $total_stock_in=0;
    $loop_belen=0;
    while ($rows = mysqli_fetch_object($get_data_truck)) {
      $locaton_id_where=$rows->locaton_id;
      $machin_id=$rows->truck_machin_id;

      $v_sql_truck_cate= "SELECT 
                                    A.stsout_date_out,A.stsout_letter_no,B.out_qty,B.pro_id,C.stpron_name_vn,
                                    DATE_FORMAT(A.stsout_date_out,'%m/%Y') AS group_month,
                                    B.out_qty,
                        D.stun_name,B.stsout_id,B.locaton_id,C.stpron_code,A.stsout_note,
                        F.supsi_name,C.stpron_name_kh,C.stpron_id as pro_name_id,A.stock_status,
                        -- DISTINCT C.stpron_id),
                                    (
                                        SELECT 
                                        COUNT(*)
                                        FROM tbl_st_stock_out_detail AS AA 
                                        WHERE AA.track_mac_id=B.track_mac_id
                                        AND AA.stsout_id=A.stsout_id
                                    ) AS group_letter_no,
                                    (
                                        SELECT 
                                            COUNT(*)
                                        FROM tbl_st_stock_out_detail AS AA 
                                        LEFT JOIN tbl_st_stock_out AS BB ON AA.stsout_id=BB.stsout_id
                                        WHERE AA.track_mac_id=B.track_mac_id
                                        AND BB.stock_status=A.stock_status
                                        AND DATE_FORMAT(BB.stsout_date_out,'%Y-%m')=DATE_FORMAT(A.stsout_date_out,'%Y-%m')
                                    ) AS group_row_monthly
                                    FROM tbl_st_stock_out AS A 
                                    LEFT JOIN tbl_st_stock_out_detail AS B ON A.stsout_id=B.stsout_id
                                   
                                    LEFT JOIN tbl_st_product_name AS C ON B.pro_id=C.stpron_id
                                    LEFT JOIN tbl_st_unit_list AS D ON B.unit_id=D.stun_id
                                    LEFT JOIN tbl_st_stock_in AS E ON E.stsin_letter_no=A.stsout_letter_no
                                     LEFT JOIN tbl_sup_supplier_info AS F ON F.supsi_id=E.stsin_supp_id
                                   
                                   
                                    WHERE A.stock_status='3' OR A.stock_status='5'
                                    AND B.locaton_id='$locaton_id_where'

                                    $date_query 
                                   
                                    GROUP BY  B.std_id,MONTH(A.stsout_date_out),YEAR(A.stsout_date_out)
                                    ORDER BY A.stsout_date_out";

                                   
                    $v_result = $connect->query($v_sql_truck_cate);
                    $v_total_section=0;
                    $total_by_cate1=0;
                    $total_by_cate2=0;
                    $total_by_cate3=0;
                    $location_name_id=10;
                    $location_status=0;
                    $pro_name_id_section=0;
                    $total_by_cate_location=0;

                    
                    
                    


                    while ($row = mysqli_fetch_object($v_result)) {
       
                      //  echo $v_total_section.'kk'.$row->locaton_id."<br>";

                        if($row->pro_name_id !="") {
        $v_unit_price = getCostPerProductName($row->stsout_date_out, $row->pro_name_id,$row->stock_status);
                $v_total_section = ($v_unit_price * $row->out_qty);
            }
            else {
                $v_unit_price=0;
            }
                $v_total_section = ($v_unit_price * $row->out_qty);

               
              

                        if($row->locaton_id=="0") {
                
     // $v_unit_price = getCostPerProductName($row->stsout_date_out, $row->pro_name_id, 3);
     //            $v_total_section = ($v_unit_price * $row->out_qty);
                        
                                $total_by_cate1 +=$v_total_section;
                        } 
                         else if($row->locaton_id=="1") {
                             
    // $v_unit_price = getCostPerProductName($row->stsout_date_out, $row->pro_name_id, 3);
    //             $v_total_section = ($v_unit_price * $row->out_qty);
                                $total_by_cate2 +=$v_total_section;

                        }

                        else if($row->locaton_id=="2") {
                             if($pro_name_id_section !=$row->pro_name_id) {

    // $v_unit_price = getCostPerProductName($row->stsout_date_out, $row->pro_name_id, 3);
    //             $v_total_section = ($v_unit_price * $row->out_qty);
                                $total_by_cate3 +=$v_total_section;
                            }
                            else {
                                //$total_stock_early1 =$v_begining_bal_price;
                            }

                        }




    

                        $pro_name_id_section=$row->pro_name_id;
                          $total_by_cate_location +=$v_total_section;
                           

                       

                       

                    ?>

                      <?php
                      // AND B.stsin_id='$machin_id'

                      //echo $row->pro_id."<br>";


       
            // IN stock
                      
      $v_sql_stock_in = "SELECT A.*,B.*,C.*,D.*,
           SUM((B.in_qty*B.in_price_vn/A.stsin_exchange_rate)+(B.in_qty*B.in_price_dollar)) AS total_in_section

                         FROM tbl_st_stock_in AS A
                            LEFT JOIN tbl_st_stock_in_detail AS B
                            ON A.stsin_id=B.stsin_id  
                            LEFT JOIN tbl_st_product_name AS C On B.pro_id=C.stpron_id  
                            LEFT JOIN tbl_st_stock_out_detail AS D 
                            ON D.pro_id=C.stpron_id
                         WHERE {$condition}  AND   
                         D.locaton_id='$locaton_id_where'  
                 AND A.stsin_date_in BETWEEN '{$v_date_start}' AND '{$v_date_end}'

                         GROUP BY D.locaton_id "; 

                        // echo $v_sql_stock_in;

              //echo $v_sql_stock_in;          
      $get_data_in =$connect->query($v_sql_stock_in);
      
      $total_stock_in_section1=0;
      $total_stock_in_section2=0;
      $total_stock_in_section3=0;

      $total_in_query=0;
      $in_pro_id=0;
      
      //echo $i_truck;
     
        $amount_truck_in_section=0;

       while ($row_in = mysqli_fetch_object($get_data_in)) {
        

             if($row_in->locaton_id=="0") {
                if($in_pro_id !=$row_in->stpron_id) {
                    $total_stock_in_section1 +=$row_in->total_in_section;
                   
                }
                else {

                }
                
               
             }
             else if($row_in->locaton_id=="1") {
                 if($in_pro_id !=$row_in->stpron_id) {
                    $total_stock_in_section2 +=$row_in->total_in_section;
                }
                else {
                    
                }
                

             }
             else if($row_in->locaton_id=="2") {
                 if($in_pro_id !=$row_in->stpron_id) {
                    $total_stock_in_section3 +=$row_in->total_in_section;
                }
                else {
                    
                }
             }


         
             
             $in_pro_id=$row_in->stpron_id;

             
    

       }


       
       // end in stock
     }
      // start belen_price

                $v_sql_truck_belent = "SELECT *,tbl_st_stock_out_detail.locaton_id FROM tbl_group_truck
                    LEFT JOIN tbl_group_truck_items
                    ON tbl_group_truck_items.group_id=tbl_group_truck.id
                    INNER JOIN tbl_st_stock_out_detail
                    ON tbl_st_stock_out_detail.track_mac_id=tbl_group_truck_items.truck_machin_id
                    LEFT JOIN tbl_st_track_machine_list
                    ON tbl_group_truck_items.truck_machin_id=tbl_st_track_machine_list.id
                    INNER JOIN tbl_st_product_name  
                    ON tbl_st_stock_out_detail.pro_id=tbl_st_product_name.stpron_id
                    INNER JOIN tbl_st_stock_out 
                    ON tbl_st_stock_out_detail.stsout_id=tbl_st_stock_out_detail.stsout_id

                
                    $query_location_section
                     ORDER BY locaton_id
                "; 
                //echo $v_sql_truck_belent; 
                       
    $get_truck_belen =$connect->query($v_sql_truck_belent);
    $location_early_section=0;
    $location_early=0;
    $total_stock_early_section1=0;
    $total_stock_early_section2=0;
    $total_stock_early_section3=0;
    $total_stock_early_section4=0;
    $total_stock_early_section5=0;
    $i_kemn=0;
    $status_kemun=0;
    $status_kemun1=0;
    $a_pro_id_early_section="";


     while ($row= mysqli_fetch_object($get_truck_belen)) {
        $p_name_id_early_section=$row->stpron_id;

        


        // start stock_early
       $v_sql_eanly = "SELECT A.*,B.stca_name,B.stca_code,C.stun_name,B.stca_id,
                (
                    (
                        SELECT IFNULL(SUM(in_qty),0)
                        FROM tbl_st_stock_in AS AA 
                        LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                        WHERE AA.stsin_date_in<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )-
                    (
                        SELECT IFNULL(SUM(out_qty),0)
                        FROM tbl_st_stock_out AS AA 
                        LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
                        WHERE AA.stsout_date_out<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )+
                    (
                        SELECT IFNULL(SUM(qty_adjust),0)
                        FROM tbl_st_stock_adjustment AS AA 
                        LEFT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
                        WHERE  AA.stsadj_date_record <'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )
                ) AS begining_bal_qty,
                (
                    (
                        SELECT SUM(
                                    (IFNULL(in_qty,0)*in_price_vn/stsin_exchange_rate)
                                        +(in_price_dollar*IFNULL(in_qty,0))
                                    )
                        FROM tbl_st_stock_in AS AA 
                        LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                        WHERE AA.stsin_date_in<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )
                ) AS begining_bal_price,
                (
                    SELECT CONCAT(
                                SUM(in_qty),
                                '=',
                                SUM((in_price_vn/stsin_exchange_rate)+in_price_dollar)*IFNULL(SUM(in_qty),0)
                            )
                    FROM tbl_st_stock_in AS AA 
                    LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                    WHERE  AA.stsin_date_in BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                ) current_in,
                (
                    SELECT SUM(out_qty) 
                    FROM tbl_st_stock_out AS AA 
                    LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
                    WHERE  AA.stsout_date_out BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                ) current_out,
                (
                    SELECT SUM(BB.qty_adjust) 
                    FROM tbl_st_stock_adjustment AS AA 
                    RIGHT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
                    WHERE  AA.stsadj_date_record BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                )current_adjust
                FROM tbl_st_product_name AS A 
                LEFT JOIN tbl_st_category_list AS B ON A.stpron_category=B.stca_id
                LEFT JOIN tbl_st_unit_list AS C ON A.stpron_unit=C.stun_id
                WHERE A.stpron_material_type='3' OR A.stpron_material_type='5' AND A.stpron_id='$p_name_id_early_section' 
                HAVING 

                (
                    (
                        SELECT IFNULL(SUM(in_qty),0)
                        FROM tbl_st_stock_in AS AA 
                        LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                        WHERE AA.stsin_date_in<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )-
                    (
                        SELECT IFNULL(SUM(out_qty),0)
                        FROM tbl_st_stock_out AS AA 
                        LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
                        WHERE AA.stsout_date_out<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )+
                    (
                        SELECT IFNULL(SUM(qty_adjust),0)
                        FROM tbl_st_stock_adjustment AS AA 
                        LEFT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
                        WHERE  AA.stsadj_date_record BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                        AND BB.pro_id=A.stpron_id
                    )
                )>0 OR 
                (
                    SELECT SUM(in_qty) 
                    FROM tbl_st_stock_in AS AA 
                    LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                    WHERE  AA.stsin_date_in BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                )>0 OR
                (
                    SELECT SUM(out_qty) 
                    FROM tbl_st_stock_out AS AA 
                    LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
                    WHERE  AA.stsout_date_out BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                )>0 
                OR 
                (
                    SELECT SUM(qty_adjust)
                    FROM tbl_st_stock_adjustment AS AA 
                    LEFT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
                    WHERE  AA.stsadj_date_record BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                )<>0

                ";
              //  echo $v_sql_eanly."<br>";
// echo $v_sql;
$get_data_early = $connect->query($v_sql_eanly);
      
       $v_cat_name_tmp = [];

                $v_total_price_beg = 0;
                $v_total_price_in = 0;
                $v_total_qty_in = 0;
                $v_total_price_out = 0;
                $v_total_qty_out = 0;
                $v_total_price_adjust = 0;
                $v_total_qty_adjust = 0;
                $v_total_price_bal = 0;
                $v_total_qty_bal = 0;
                $v_arr_summary = [];
            
     
     
  while ($row_a_section = mysqli_fetch_object($get_data_early)) {

// if (!in_array($row_a_section->stca_name, $v_cat_name_tmp)) {
//                         array_push($v_cat_name_tmp, $row_a_section->stca_name);
                        
//                     }
   
     // =========================== Start Calculation ====================
                    $v_begining_bal_qty = ($row_a_section->begining_bal_qty ?: 0);
                    $v_begining_bal_price =round(($row_a_section->begining_bal_price ?: 0), 2);

                     


                    
                    
         // echo $a_id."<br>";

                    $v_arr_in = explode("=", $row_a_section->current_in);
                    $v_current_in_qty = (@$v_arr_in[0] ?: 0);
                    $v_current_in_price = round((@$v_arr_in[1] ?: 0), 2);

                    $v_array = [
                        'begining_bal_price' => $v_begining_bal_price,
                        'begining_bal_qty' => $v_begining_bal_qty,
                        'current_in_price' => $v_current_in_price,
                        'current_in_qty' => $v_current_in_qty
                    ];

                    $result_cost = myCalCostAverage($v_array);

                    $v_last_qty = ($v_begining_bal_qty + $v_current_in_qty - @$row_a_section->current_out + @$row_a_section->current_adjust);
                    // =========================== End Calculation ====================
                     $v_total_price_beg += $v_begining_bal_price;
                    $v_total_qty_in += $v_current_in_qty;
                    $v_total_price_in += $v_current_in_price;
                    $v_total_price_out += $result_cost * $row_a_section->current_out;
                    $v_total_qty_out += $row_a_section->current_out;
                    $v_total_price_adjust += $result_cost * $row_a_section->current_adjust;
                    $v_total_qty_adjust += $row_a_section->current_adjust;
                    $v_total_price_bal += $v_last_qty * $result_cost;
                    $v_total_qty_bal += $v_last_qty;

                    $arr_child = [
                        $row_a_section->stca_id => $row_a_section->stca_id,
                        'price_beg' => $v_begining_bal_price,
                        'price_in' => $v_current_in_price,
                        'price_out' => $result_cost * $row_a_section->current_out,
                        'price_adjust' => $result_cost * $row_a_section->current_adjust,
                        'price_end' => $v_last_qty * $result_cost
                    ];
                    array_push($v_arr_summary, $arr_child);
                   
                }
 

               


     

       // end stock ealy
           
           

                if($location_early=="0") {
                 
                   
                    if($a_pro_id_early_section !=$row->stpron_id) {

  
                        $total_stock_early_section1 +=$v_begining_bal_price;
                        //$is_be_section=true;

                    }
                    else {
                        //$is_be_section=false;
                        // $total_stock_early_section1 +=$v_begining_bal_price;
                    }

                }

                else if($location_early=="1") {
                    if($a_pro_id_early_section !=$row->stpron_id) {

                        $total_stock_early_section2 +=$v_begining_bal_price;
                    }
                    else {
                        //$total_stock_early2 =$v_begining_bal_price;
                    }

                }

                 else if($location_early=="2") {
                    if($a_pro_id_early_section !=$row->stpron_id) {

                        $total_stock_early_section3 +=$v_begining_bal_price;
                    }
                    else {
                        //$total_stock_early3 =$v_begining_bal_price;
                    }

                }

                 else if($location_early=="3") {
                    if($a_pro_id_early_section !=$row->stpron_id) {

                        $total_stock_early_section4 +=$v_begining_bal_price;
                    }
                    else {
                        //$total_stock_early3 =$v_begining_bal_price;
                    }

                }

                 else if($location_early=="4") {
                    if($a_pro_id_early_section !=$row->stpron_id) {

                        $total_stock_early_section5 +=$v_begining_bal_price;
                    }
                    else {
                        //$total_stock_early3 =$v_begining_bal_price;
                    }

                }

            $location_early=$row->locaton_id;
            $a_pro_id_early_section=$row->stpron_id;
          
           
     }
      // end start balen

    
     $objPHPExcel->getActiveSheet()->setCellValue('B'.$idx_location,(++$i_truck));
     if($rows->locaton_id=="0") {
                                
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$idx_location,"រោងចក្រ");
                            }
                            else if($rows->locaton_id=="1"){
                                
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$idx_location,"រណ្ដៅ");
                            }
                            else if($rows->locaton_id=="2"){
                                
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$idx_location,"រោងជាង");
                            }

        if($rows->locaton_id=="0") {
                              
$objPHPExcel->getActiveSheet()->setCellValue('D'.$idx_location,$total_stock_early_section1);
                               }
                                elseif($rows->locaton_id=="1") {
$objPHPExcel->getActiveSheet()->setCellValue('D'.$idx_location,$total_stock_early_section2);
                               }
                                elseif($rows->locaton_id=="2") {
$objPHPExcel->getActiveSheet()->setCellValue('D'.$idx_location,$total_stock_early_section3);
                               }
                                elseif($rows->locaton_id=="3") {
$objPHPExcel->getActiveSheet()->setCellValue('D'.$idx_location,$total_stock_early_section4);
                               }
                                elseif($rows->locaton_id=="4") {
$objPHPExcel->getActiveSheet()->setCellValue('D'.$idx_location,$total_stock_early_section5);
                               }
                                else {
$objPHPExcel->getActiveSheet()->setCellValue('D'.$idx_location,0);
                                }



if($rows->locaton_id=="0") {
                                 
$objPHPExcel->getActiveSheet()->setCellValue('E'.$idx_location,$total_stock_in_section1);

                                 
                            }
                            else if($rows->locaton_id=="1"){
$objPHPExcel->getActiveSheet()->setCellValue('E'.$idx_location,$total_stock_in_section2);
                            }
                            else if($rows->locaton_id=="2"){
$objPHPExcel->getActiveSheet()->setCellValue('E'.$idx_location,$total_stock_in_section3);
                                 
                            }
  if($rows->locaton_id=="0") {
                                
  $objPHPExcel->getActiveSheet()->setCellValue('F'.$idx_location,$total_by_cate1);
                            }
                            else if($rows->locaton_id=="1"){
  $objPHPExcel->getActiveSheet()->setCellValue('F'.$idx_location,$total_by_cate2);
                            }
                            else if($rows->locaton_id=="2"){
  $objPHPExcel->getActiveSheet()->setCellValue('F'.$idx_location,$total_by_cate3);
                            }

    
 $location_early_section=
                     +$total_stock_early_section1
                     +$total_stock_early_section2
                     +$total_stock_early_section3
                     +$total_stock_early_section4;
               ++$idx_location;   
            }

$e_idx_location=$idx_location-1;
$objPHPExcel->getActiveSheet()->setCellValue('B'.$idx_location,"TOTAL/CONG");

$objPHPExcel->getActiveSheet()->mergeCells("B$idx_location:C$idx_location");
$objPHPExcel->getActiveSheet()->getStyle("B$idx_location:C$idx_location")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->setCellValue('D'.$idx_location,$location_early_section);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$idx_location,"=SUM(E$e_idx_location_start:E$e_idx_location)");
$objPHPExcel->getActiveSheet()->setCellValue('F'.$idx_location,"=SUM(F$e_idx_location_start:F$e_idx_location)");




   }
    
  

  




                  

 




 

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Jounal');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Save Excel 2007 file
$file_name='Export_Summary'. $_SESSION['title'].'_From_'.@$v_date_s.'_To_'.@$v_date_e.'.xlsx';
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save( $file_name);
header('location: '. $file_name);
?>