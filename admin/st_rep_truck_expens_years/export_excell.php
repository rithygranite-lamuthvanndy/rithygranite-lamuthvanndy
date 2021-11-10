<?php
include '../../config/database.php';
include_once '../st_operation/operation.php';

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../../plugin/Classes/PHPExcel.php';
require_once '../../plugin/Classes/PHPExcel/IOFactory.php';
// require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
function myCalCostAverage_Report($arg_arr,$tr_id,$cu_out,$year)
    {
        $result = 0;
        $result = ($arg_arr['begining_bal_price'] + $arg_arr['current_in_price']) /
        MAX(($arg_arr['begining_bal_qty'] + $arg_arr['current_in_qty']), 1);
         $result=$result * $cu_out;
    echo '<input type="hidden"  class="section_data'.$tr_id.''.$year.'  section_data_y'.$year.'  
          
         " 
         value="'.round($result, 2).'"> ';
   
        return round($result, 2);
    }


  function group_by_month_report($v_date_start,$v_date_end,$year_order) {   
    global $connect;
    $date_query_function='AND E.stsout_date_out BETWEEN "'.$v_date_start.'" AND  "'.$v_date_end.'" ';
        $v_sql_report = "SELECT A.*,B.stca_name,B.stca_code,C.stun_name,B.stca_id,F.name_kh,F.name_vn,F.date_buy,F.track_price,F.note,F.id,E.stsout_date_out,F.id as tr_id,
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
                    LEFT JOIN tbl_st_track_machine_list AS CC ON CC.id=BB.track_mac_id
                    WHERE  AA.stsout_date_out BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id AND F.id=BB.track_mac_id
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
                LEFT JOIN tbl_st_stock_out_detail AS D ON D.pro_id=A.stpron_id
                LEFT JOIN tbl_st_stock_out AS E ON E.stsout_id=D.stsout_id
                LEFT JOIN tbl_st_track_machine_list AS F ON F.id=D.track_mac_id
                WHERE A.stpron_material_type='3' AND E.stock_status='3' 
                $date_query_function 
                
                HAVING 

                (
                    (
                        SELECT IFNULL(SUM(in_qty),0)
                        FROM tbl_st_stock_in AS AA 
                        LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                        WHERE AA.stsin_date_in<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id ORDER BY F.id
                    )-
                    (
                        SELECT IFNULL(SUM(out_qty),0)
                        FROM tbl_st_stock_out AS AA 
                        LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
                        WHERE AA.stsout_date_out<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id ORDER BY F.id
                    )+
                    (
                        SELECT IFNULL(SUM(qty_adjust),0)
                        FROM tbl_st_stock_adjustment AS AA 
                        LEFT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
                        WHERE  AA.stsadj_date_record BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                        AND BB.pro_id=A.stpron_id ORDER BY F.id
                    )
                )>0 OR 
                (
                    SELECT SUM(in_qty) 
                    FROM tbl_st_stock_in AS AA 
                    LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                    WHERE  AA.stsin_date_in BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id ORDER BY F.id
                )>0 OR
                (
                    SELECT SUM(out_qty) 
                    FROM tbl_st_stock_out AS AA 
                    LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
                    WHERE  AA.stsout_date_out BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id ORDER BY F.id
                )>0 
                OR 
                (
                    SELECT SUM(qty_adjust)
                    FROM tbl_st_stock_adjustment AS AA 
                    LEFT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
                    WHERE  AA.stsadj_date_record BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id ORDER BY F.id
                )<>0 
                     ";  

          // echo $v_sql_report;     
    $get_data =$connect->query($v_sql_report);
   
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
                $total_cost=0;
               
        
    while ($row = mysqli_fetch_object($get_data)) {

         // =========================== Start Calculation ====================
                    $v_begining_bal_qty = ($row->begining_bal_qty ?: 0);
                    $v_begining_bal_price = round(($row->begining_bal_price ?: 0), 2);

                    $v_arr_in = explode("=", $row->current_in);
                    $v_current_in_qty = (@$v_arr_in[0] ?: 0);
                    $v_current_in_price = round((@$v_arr_in[1] ?: 0), 2);
                   

                    $v_array = [
                        'begining_bal_price' => $v_begining_bal_price,
                        'begining_bal_qty' => $v_begining_bal_qty,
                        'current_in_price' => $v_current_in_price,
                        'current_in_qty' => $v_current_in_qty
                    ];

                    $result_cost = myCalCostAverage_Report($v_array,$row->tr_id,$row->current_out,$year_order);

                    $v_last_qty = ($v_begining_bal_qty + $v_current_in_qty - @$row->current_out + @$row->current_adjust);
                    // =========================== End Calculation ====================


      }
  }



// Set document properties
$objPHPExcel->getProperties()->setCreator("Silak")
                             ->setLastModifiedBy("Silak")
                             ->setTitle("Rithy granite company")
                             ->setSubject("Rithy granite company")
                             ->setDescription("Rithy granite company")
                             ->setKeywords("Rithy granite company")
                             ->setCategory("Test result file");

if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
               $v_date_start = @$_GET['p_date_start'];
    $v_date_start="$v_date_start-01-01";
    $v_date_end = @$_GET['p_date_end'];
    $v_date_end="$v_date_end-12-31";
    $date_query=' C.stsout_date_out BETWEEN "'.$v_date_start.'" AND  "'.$v_date_end.'" ';
     $sum_loop_year=0;  
     $start_year=@$_GET['p_date_start'];
     $end_year=@$_GET['p_date_end'];
     $sum_loop_year =($end_year - $start_year)+1;


            }
            else {
                  $v_date_start = date('Y-01-01');
     $v_date_end = date('Y-12-31');
     $date_query=' C.stsout_date_out BETWEEN "'.$v_date_start.'" AND  "'.$v_date_end.'" ';
     $sum_loop_year=1;
     $start_year=date('Y');
     $start_year=date('Y');
            }


$objPHPExcel->getActiveSheet()->setCellValue('E' . 1, 'របាយការណ៍សម្ភារៈផលិតក្នុងរោងចក្រ'.' '.@$_GET['p_date_start'].'-'.@$_GET['p_date_end']);
$objPHPExcel->getActiveSheet()->setCellValue('F' . 2, 'Báo Cáo Sửa Chữa Cơ Giới');

// Header
$objPHPExcel->getActiveSheet()->setCellValue('A' . 4, 'N°');
$objPHPExcel->getActiveSheet()->setCellValue('B' . 4, 'Ngày Mua');
$objPHPExcel->getActiveSheet()->setCellValue('C' . 4, 'Tên');
$objPHPExcel->getActiveSheet()->mergeCells("C4:D4");
$objPHPExcel->getActiveSheet()->setCellValue('A' . 5, 'ល.រ');
$objPHPExcel->getActiveSheet()->mergeCells("A5:A6");
$objPHPExcel->getActiveSheet()->setCellValue('B' . 5, 'កាលបរិច្ឆេទទិញ');
$objPHPExcel->getActiveSheet()->mergeCells("B5:B6");
$objPHPExcel->getActiveSheet()->setCellValue('C' . 5, 'ឈ្មោះគ្រឿងចក្រ');
$objPHPExcel->getActiveSheet()->mergeCells("C5:D5");
$objPHPExcel->getActiveSheet()->setCellValue('C' . 6, 'ខ្មែរ');
$objPHPExcel->getActiveSheet()->setCellValue('D' . 6, 'វៀតណាម');

$id_five=5;
$id_six=6;
for ($th=1; $th <=$sum_loop_year ; $th++) {    
    $letters = range('E','Z');
    $num =$th;
    $letter_c=$letters[$num-1];
    $year_order=$start_year+$th-1;
    $objPHPExcel->getActiveSheet()->setCellValue("$letter_c" . 4,"ជុសជួលប្រចាំឆ្នាំ $year_order"); 
    

    $objPHPExcel->getActiveSheet()->setCellValue("$letter_c" . 5,"Tổng cộng 
sửa chữa $year_order"); 
    $objPHPExcel->getActiveSheet()->mergeCells("$letter_c$id_five:$letter_c$id_six");

    }

                     
$v_br='<br>';
$v_sp='&nbsp&nbsp;';
$idx=7;


 $v_sql_track= "SELECT *  FROM tbl_st_track_machine_list  AS A
                LEFT JOIN tbl_st_stock_out_detail AS B ON A.id =B.track_mac_id
                LEFT JOIN tbl_st_stock_out AS C ON C.stsout_id=B.stsout_id
                WHERE $date_query  AND C.stock_status='3'   ";  
           // echo $v_sql_report;     
    $get_data_track =$connect->query($v_sql_track);
    $j=0;

   
             $v_track_tmp = [];   
        
    while ($rows = mysqli_fetch_object($get_data_track)) {

          if (!in_array($rows->id, $v_track_tmp)) {
              array_push($v_track_tmp, $rows->id);

            for ($th=1; $th <=$sum_loop_year ; $th++) { 
                $year=$start_year+$th-1;
                  echo group_by_month_report($year.'-01-01',$year.'-01-31',$year); 
                  echo group_by_month_report($year.'-02-01',$year.'-02-31',$year); 
                  echo group_by_month_report($year.'-03-01',$year.'-03-31',$year); 
                  echo group_by_month_report($year.'-04-01',$year.'-04-31',$year); 
                  echo group_by_month_report($year.'-04-01',$year.'-05-31',$year); 
                  echo group_by_month_report($year.'-06-01',$year.'-06-31',$year); 
                  echo group_by_month_report($year.'-07-01',$year.'-07-31',$year); 
                  echo group_by_month_report($year.'-08-01',$year.'-08-31',$year); 
                  echo group_by_month_report($year.'-09-01',$year.'-09-31',$year); 
                  echo group_by_month_report($year.'-10-01',$year.'-10-31',$year); 
                  echo group_by_month_report($year.'-11-01',$year.'-11-31',$year); 
                  echo group_by_month_report($year.'-12-01',$year.'-12-31',$year); 


                       
            }

              $objPHPExcel->getActiveSheet()->setCellValue('A' . $idx,(++$j));
              




  }
  ++$idx;
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