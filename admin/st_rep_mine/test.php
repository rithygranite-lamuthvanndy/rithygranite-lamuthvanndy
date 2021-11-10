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

if (isset($_GET['p_date_start']) && isset($_GET['p_date_end']) && isset($_GET['id']) ) {
    
    $id=$_GET['id'];
    $date1 = $_GET['p_date_start'];
    $date2 = $_GET['p_date_end'];
    $txt_truck_name_id=$id;
            if($txt_truck_name_id !="") {
                $truck_id_search=$id;
                echo $truck_id_search;
                $query_truck='WHERE tbl_group_truck.id='.$truck_id_search.' ';
                $date_query='AND A.stsout_date_out BETWEEN "'.$date1.'" AND  "'.$date2.'" ';
            }
            else {
                $query_truck='';
                $date_query='AND A.stsout_date_out BETWEEN "'.$date1.'" AND  "'.$date2.'" ';
            }


            if($date1==$date2) {
                $date_query='';
            }
    




}
else {
     $query_truck='';
     $date_query='';
     $date1=$date2=$txt_truck_name_id="";
}


// set number column
$objPHPExcel->getActiveSheet()        // Format as date and time
    ->getStyle('B')
    ->getNumberFormat()
    ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
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
                 $total_price_loop=0;

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
                        F.supsi_name,C.stpron_name_kh,
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
                                   
                                    WHERE A.stock_status=3
                                    AND B.track_mac_id='$machin_id'

                                    $date_query
                                   
                                    GROUP BY  B.std_id,MONTH(A.stsout_date_out),YEAR(A.stsout_date_out)
                                    ORDER BY A.stsout_date_out";
                                   
                    $v_result = $connect->query($v_sql_detail);
                    $i = 0;
                    $v_total=0;
                    $total_by_cate=0;
                    while ($row = mysqli_fetch_object($v_result)) {
                        $v_unit_price = getCostPerProductName($row->stsout_date_out, $row->pro_id, 3);
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

        // if($track_name !=$rows->name) {
        //   ++$total_price_loop;
        //   $idx_last=$idx+1;
        // $objPHPExcel->getActiveSheet()->setCellValue('C' .$idx_last,"TOTAL".$rows->name);
        // $objPHPExcel->getActiveSheet()->setCellValue('G' .$idx_last,$total_by_cate);
        // $is_total_price=true;

        // }
        // else {
        //    $is_total_price=false;
        //    $idx_last=$idx;
        // }

        

        ++$idx;
       

      }

        $objPHPExcel->getActiveSheet()->setCellValue('C' .$idx,"TOTAL".$rows->name);
        $objPHPExcel->getActiveSheet()->setCellValue('G' .$idx,$total_by_cate);



  


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