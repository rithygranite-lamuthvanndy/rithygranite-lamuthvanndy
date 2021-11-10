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
if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
    $date1=$_GET['p_date_start'];
    $date2=$_GET['p_date_end'];
    $v_date_start=$date1;
    $v_date_end=$date2;


}
else {
    $v_date_start = date('Y-m-01');
    $v_date_end = date('Y-m-t');
}

$monthArr = [];

// create new funtion for calulator price
 function calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,$type)
   {
    global $connect; 

   
                               
                       $v_sql1 = "SELECT A.*,B.stca_name,B.stca_code,C.stun_name,B.stca_id,
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
                WHERE A.stpron_material_type='1'
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
// echo $v_sql;
$get_data1 =$connect->query($v_sql1);

                $v_cat_name_tmp1 = [];

                $v_total_price_beg1 = 0;
                $v_total_price_in1 = 0;
                $v_total_qty_in1 = 0;
                $v_total_price_out1 = 0;
                $v_total_qty_out1 = 0;
                $v_total_price_adjust1 = 0;
                $v_total_qty_adjust1 = 0;
                $v_total_price_bal1 = 0;
                $v_total_qty_bal1 = 0;
                $v_arr_summary1 = [];
while ($row1 = mysqli_fetch_object($get_data1)) {
                    $v_begining_bal_qty1 = ($row1->begining_bal_qty ?: 0);
                    $v_begining_bal_price1 = round(($row1->begining_bal_price ?: 0), 2);

                    $v_arr_in1 = explode("=", $row1->current_in);
                    $v_current_in_qty1 = (@$v_arr_in1[0] ?: 0);
                    $v_current_in_price1 = round((@$v_arr_in1[1] ?: 0), 2);

                    $v_array1 = [
                        'begining_bal_price' => $v_begining_bal_price1,
                        'begining_bal_qty' => $v_begining_bal_qty1,
                        'current_in_price' => $v_current_in_price1,
                        'current_in_qty' => $v_current_in_qty1
                    ];
                    $result_cost1 = myCalCostAverage($v_array1);
                    $v_last_qty1 = ($v_begining_bal_qty1 + $v_current_in_qty1 - @$row1->current_out + @$row1->current_adjust);
                     $v_total_price_beg1 += $v_begining_bal_price1;
                    $v_total_qty_in1 += $v_current_in_qty1;
                    $v_total_price_in1 += $v_current_in_price1;
                    $v_total_price_out1 += $result_cost1 * $row1->current_out;
                    $v_total_qty_out1 += $row1->current_out;
                    $v_total_price_adjust1 += $result_cost1 * $row1->current_adjust;
                    $v_total_qty_adjust1 += $row1->current_adjust;
                    $v_total_price_bal1 += $v_last_qty1 * $result_cost1;
                    $v_total_qty_bal1 += $v_last_qty1;

                    $arr_child1 = [
                        $row1->stca_id => $row1->stca_id,
                        'price_beg' => $v_begining_bal_price1,
                        'price_in' => $v_current_in_price1,
                        'price_out' => $result_cost1 * $row1->current_out,
                        'price_adjust' => $result_cost1 * $row1->current_adjust,
                        'price_end' => $v_last_qty1 * $result_cost1
                    ];
                    array_push($v_arr_summary1, $arr_child1);

}

 $v_sql2 = "SELECT * FROM tbl_st_category_list WHERE material_type_id='1' AND stca_id='$cate_min_id' ";
                $v_result_summary1 = $connect->query($v_sql2);
                $total_begin=0;
                while ($row_summary1 = mysqli_fetch_object($v_result_summary1)) {
                  
                    $v_arr_result1 = summaryMaterial($row_summary1->stca_id, $v_arr_summary1);

                                if($type=="1") {
                                     return $v_arr_result1['t_price_beg']; 
                                }
                                else if($type=="2") {
                                    return $v_arr_result1['t_price_in']; 
                                }
                                else if($type=="3") {
                                    return $v_arr_result1['t_price_out']; 
                                }

                                 if($type=="4") {
                                    return  $v_arr_result1['t_price_beg']; 
                                     
                                }

                                 if($type=="5") {
                                    return  $v_arr_result1['t_price_in']; 
                                     
                                }
                                 if($type=="6") {
                                    return  $v_arr_result1['t_price_out']; 
                                     
                                }
                                
                            
                             

                         }

   
   }

// end calulator
// set number column
$objPHPExcel->getActiveSheet()->getStyle('C')
->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1); 
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
$objPHPExcel->getActiveSheet()->getStyle('K')
->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1); 
$objPHPExcel->getActiveSheet()->getStyle('L')
->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1); 
$objPHPExcel->getActiveSheet()->getStyle('M')
->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1); 
$objPHPExcel->getActiveSheet()->getStyle('N')
->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1); 

$objPHPExcel->getActiveSheet()
    ->getStyle('A5:P5')
    ->getNumberFormat()
    ->setFormatCode(
        PHPExcel_Style_NumberFormat::FORMAT_GENERAL
    );

   


$objPHPExcel->getActiveSheet()->getStyle('O')
->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1); 
$objPHPExcel->getActiveSheet()->getStyle('P')
->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1); 
   
     
      
// Set document properties
$objPHPExcel->getProperties()->setCreator("Silak")
                             ->setLastModifiedBy("Silak")
                             ->setTitle("Rithy granite company")
                             ->setSubject("Rithy granite company")
                             ->setDescription("Rithy granite company")
                             ->setKeywords("Rithy granite company")
                             ->setCategory("Test result file");
if (isset($_GET['p_date_start']) || isset($_GET['p_date_end'])) {
    $v_date_start = $_GET['p_date_start'];

    $v_date_end = $_GET['p_date_end'];
} else {
    $v_date_start = date('Y-m-01');
    $v_date_end = date('Y-m-t');
}
         $v_sql = "SELECT A.*,B.stca_name,B.stca_code,C.stun_name,B.stca_id,
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
                WHERE A.stpron_material_type='1'
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
// exit($v_sql);
$get_data = $connect->query($v_sql);
$v_br='<br>';
$v_sp='&nbsp&nbsp;';
$i=0;
 $i_in=$i+1;
$idx=6;
// header text
$today=date("Y-m-d");
if($v_date_start==$today) {
    $v_date_start=date('Y-m-01');
}
$objPHPExcel->getActiveSheet()->setCellValue('E' . 1, 'របាយការណ៍សម្ភារៈផលិតក្នុងរោងចក្រ'.' '.date('d/m/Y', strtotime($v_date_start)).'-'. date('d/m/Y', strtotime($v_date_end)));
$objPHPExcel->getActiveSheet()->setCellValue('G' . 2, 'BÁO CÁO VẬT TỪ SỬ DỤNG TRONG NHÀ MÁY');
// Header
$objPHPExcel->getActiveSheet()->setCellValue('A' . 4, 'ល.រ');
$objPHPExcel->getActiveSheet()->setCellValue('B' . 4, 'បរិយាយ');
$objPHPExcel->getActiveSheet()->setCellValue('C' . 4, 'ស្តុក');
$objPHPExcel->getActiveSheet()->setCellValue('D' . 4, 'សរុប');
// Header
$objPHPExcel->getActiveSheet()->setCellValue('A' . 5, 'STT');
$objPHPExcel->getActiveSheet()->setCellValue('B' . 5, 'Mô tả');
$objPHPExcel->getActiveSheet()->setCellValue('C' . 5, 'Nhập và xuất kho');
$objPHPExcel->getActiveSheet()->setCellValue('D' . 5, 'Tổng');



// start query1
 $total_span1 = 0;
 $month1 = 0;
 $month2=0;
 $month3=0;
if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
        $v_date_start=$date1;
        $v_date_end=$date2;
        $start = $month =strtotime("$v_date_start");
        $end = strtotime("$v_date_end");
        $col_span=0;
        $total_span=0;
        while($month <= $end)
                    {
                         $date_result=date('Y-m',$month);
                         $month = strtotime("+1 month", $month);

                         if($date_result==date('Y-01')) {
                            $col_span=1;
                            $month1=1;
                            array_push($monthArr, 1);
                         }
                         else if($date_result==date('Y-02')) {
                            $col_span =1;
                            $month2=2;
                            array_push($monthArr, 2);
                         }
                         else if($date_result==date('Y-03')) {
                            $col_span =1;
                            $month3=3;
                            array_push($monthArr, 3);
                         }
                         else {
                            $col_span=0;
                         }

                         $total_span +=$col_span;
                         $total_span1=$total_span;
                    }
               if($total_span==1) {
                        if($month1==1) {
                            $objPHPExcel->getActiveSheet()->setCellValue('E' . 4, 'ត្រីមាសទី 1'.PHP_EOL.'Quý 1');
                            $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setWrapText(true);
                            $objPHPExcel->getActiveSheet()->mergeCells('E4:E4');
            $objPHPExcel->getActiveSheet()->getStyle('E4:E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

                        }
                        else if($month2==2) {
                            $objPHPExcel->getActiveSheet()->setCellValue('F' . 4, 'ត្រីមាសទី 1'.PHP_EOL.'Quý 1');
                            $objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->setWrapText(true);
                            $objPHPExcel->getActiveSheet()->mergeCells('F4:F4');
            $objPHPExcel->getActiveSheet()->getStyle('F4:F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                        }
                        else {
                            $objPHPExcel->getActiveSheet()->setCellValue('G' . 4, 'ត្រីមាសទី 1'.PHP_EOL.'Quý 1');
                            $objPHPExcel->getActiveSheet()->getStyle('G4')->getAlignment()->setWrapText(true);
                            $objPHPExcel->getActiveSheet()->mergeCells('G4:G4');
            $objPHPExcel->getActiveSheet()->getStyle('G4:G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                        }
                     }
                     else if($total_span==2) {

                        if($month1==1 && $month2==2) {
                            $objPHPExcel->getActiveSheet()->setCellValue('E' . 4, 'ត្រីមាសទី 1'.PHP_EOL.'Quý 1');
                            $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setWrapText(true);

                            $objPHPExcel->getActiveSheet()->mergeCells('E4:F4');
             $objPHPExcel->getActiveSheet()->getStyle('E4:F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                        }
                        else if($month2==2 && $month3==3) {
                            $objPHPExcel->getActiveSheet()->setCellValue('F' . 4, 'ត្រីមាសទី 1'.PHP_EOL.'Quý 1');
                            $objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->setWrapText(true);
                            $objPHPExcel->getActiveSheet()->mergeCells('F4:G4');
             $objPHPExcel->getActiveSheet()->getStyle('F4:G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                        }
             
                     }
                     else if($total_span==3) {
                        $objPHPExcel->getActiveSheet()->setCellValue('E' . 4, 'ត្រីមាសទី 1'.PHP_EOL.'Quý 1');
                        $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setWrapText(true);
                       $objPHPExcel->getActiveSheet()->mergeCells('E4:G4');
                       $objPHPExcel->getActiveSheet()->getStyle('E4:G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                     }
                     else {

                     }

                    


}
else {
  $objPHPExcel->getActiveSheet()->setCellValue('E' . 4, 'ត្រីមាសទី 1'.PHP_EOL.'Quý 1');
  $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setWrapText(true);
   $objPHPExcel->getActiveSheet()->mergeCells('E4:G4');
   $objPHPExcel->getActiveSheet()->getStyle('E4:G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
   $objPHPExcel->getActiveSheet()->mergeCells('E5:G5');
   $objPHPExcel->getActiveSheet()->getStyle('E5:G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
}

if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
        if($month1==1){
          $objPHPExcel->getActiveSheet()->setCellValue('E' . 5, '1');
        }
        if($month2==2){
          $objPHPExcel->getActiveSheet()->setCellValue('F' . 5, '2');
        }
        if($month3==3){
          $objPHPExcel->getActiveSheet()->setCellValue('G' . 5, '3');
        }
 }
 else {
    $objPHPExcel->getActiveSheet()->setCellValue('E' . 5, '1');
    $objPHPExcel->getActiveSheet()->setCellValue('F' . 5, '2');
    $objPHPExcel->getActiveSheet()->setCellValue('G' . 5, '3');

 }
 // end query 1
// start query2
 $total_span2 = 0;
 $month4 = 0;
 $month5=0;
 $month6=0;
if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
        $v_date_start=$date1;
        $v_date_end=$date2;
        $start = $month =strtotime("$v_date_start");
        $end = strtotime("$v_date_end");
        $col_span=0;
        $total_span=0;
        while($month <= $end)
                    {
                         $date_result=date('Y-m',$month);
                         $month = strtotime("+1 month", $month);

                         if($date_result==date('Y-04')) {
                            $col_span=1;
                            $month4=4;
                            array_push($monthArr, 4);
                         }
                         else if($date_result==date('Y-05')) {
                            $col_span =1;
                            $month5=5;
                            array_push($monthArr, 5);
                         }
                         else if($date_result==date('Y-06')) {
                            $col_span =1;
                            $month6=6;
                            array_push($monthArr, 6);
                         }
                         else {
                            $col_span=0;
                         }

                         $total_span +=$col_span;
                         $total_span2=$total_span;
                    }
               if($total_span==1) {
                        if($month4==4) {

$objPHPExcel->getActiveSheet()->setCellValue('H' . 4, 'ត្រីមាសទី 2'.PHP_EOL.'Quý 2');
$objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->setWrapText(true);
                            $objPHPExcel->getActiveSheet()->mergeCells('H4:H4');
            $objPHPExcel->getActiveSheet()->getStyle('H4:H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                        }
                        else if($month8==5) {
                            $objPHPExcel->getActiveSheet()->setCellValue('I' . 4, 'ត្រីមាសទី 2'.PHP_EOL.'Quý 2');
$objPHPExcel->getActiveSheet()->getStyle('I4')->getAlignment()->setWrapText(true);
                            $objPHPExcel->getActiveSheet()->mergeCells('I4:I4');
            $objPHPExcel->getActiveSheet()->getStyle('I4:I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                        }
                        else {
                            $objPHPExcel->getActiveSheet()->setCellValue('J' . 4, 'ត្រីមាសទី 2'.PHP_EOL.'Quý 2');
$objPHPExcel->getActiveSheet()->getStyle('J4')->getAlignment()->setWrapText(true);
                            $objPHPExcel->getActiveSheet()->mergeCells('J4:J4');
            $objPHPExcel->getActiveSheet()->getStyle('J4:J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                        }
                     }
                     else if($total_span==2) {

                        if($month4==4 && $month5==5) {
                            $objPHPExcel->getActiveSheet()->setCellValue('H' . 4, 'ត្រីមាសទី 2'.PHP_EOL.'Quý 2');
$objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->setWrapText(true);

                            $objPHPExcel->getActiveSheet()->mergeCells('H4:I4');
             $objPHPExcel->getActiveSheet()->getStyle('H4:I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                        }
                        else if($month5==5 && $month6==6) {
                            $objPHPExcel->getActiveSheet()->setCellValue('I' . 4, 'ត្រីមាសទី 2'.PHP_EOL.'Quý 2');
$objPHPExcel->getActiveSheet()->getStyle('I4')->getAlignment()->setWrapText(true);
                            $objPHPExcel->getActiveSheet()->mergeCells('I4:J4');
             $objPHPExcel->getActiveSheet()->getStyle('I4:J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                        }
             
                     }
                     else if($total_span==3) {
                        $objPHPExcel->getActiveSheet()->setCellValue('H' . 4, 'ត្រីមាសទី 2'.PHP_EOL.'Quý 2');
$objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->setWrapText(true);
                       $objPHPExcel->getActiveSheet()->mergeCells('H4:J4');
                       $objPHPExcel->getActiveSheet()->getStyle('H4:J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                     }
                     else {

                     }

                    


}
else {
    $objPHPExcel->getActiveSheet()->setCellValue('H' . 4, 'ត្រីមាសទី 2'.PHP_EOL.'Quý 2');
$objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->setWrapText(true);
   $objPHPExcel->getActiveSheet()->mergeCells('H4:J4');
   $objPHPExcel->getActiveSheet()->getStyle('H4:J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
   $objPHPExcel->getActiveSheet()->mergeCells('H5:J5');
   $objPHPExcel->getActiveSheet()->getStyle('H5:J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
}

if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
        if($month4==4){
          $objPHPExcel->getActiveSheet()->setCellValue('H' . 5, '4');
        }
        if($month5==5){
          $objPHPExcel->getActiveSheet()->setCellValue('I' . 5, '5');
        }
        if($month6==6){
          $objPHPExcel->getActiveSheet()->setCellValue('J' . 5, '6');
        }
 }
 else {
    $objPHPExcel->getActiveSheet()->setCellValue('H' . 5, '4');
    $objPHPExcel->getActiveSheet()->setCellValue('I' . 5, '5');
    $objPHPExcel->getActiveSheet()->setCellValue('J' . 5, '6');

 }
 // end query 2

 
 // start query3
 $total_span3 = 0;
 $month7 = 0;
 $month8=0;
 $month9=0;
if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
        $v_date_start=$date1;
        $v_date_end=$date2;
        $start = $month =strtotime("$v_date_start");
        $end = strtotime("$v_date_end");
        $col_span=0;
        $total_span=0;
        while($month <= $end)
                    {
                         $date_result=date('Y-m',$month);
                         $month = strtotime("+1 month", $month);

                         if($date_result==date('Y-07')) {
                            $col_span=1;
                            $month7=7;
                            array_push($monthArr, 7);
                         }
                         else if($date_result==date('Y-08')) {
                            $col_span =1;
                            $month8=8;
                            array_push($monthArr, 8);
                         }
                         else if($date_result==date('Y-09')) {
                            $col_span =1;
                            $month9=9;
                            array_push($monthArr, 9);
                         }
                         else {
                            $col_span=0;
                         }

                         $total_span +=$col_span;
                         $total_span3=$total_span;
                    }
               if($total_span==1) {
                        if($month7==7) {
$objPHPExcel->getActiveSheet()->setCellValue('K' . 4, 'ត្រីមាសទី 3'.PHP_EOL.'Quý 3');
$objPHPExcel->getActiveSheet()->getStyle('K4')->getAlignment()->setWrapText(true);
                            $objPHPExcel->getActiveSheet()->mergeCells('K4:K4');
            $objPHPExcel->getActiveSheet()->getStyle('K4:K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                        }
                        else if($month8==8) {
                            $objPHPExcel->getActiveSheet()->setCellValue('L' . 4, 'ត្រីមាសទី 3'.PHP_EOL.'Quý 3');
$objPHPExcel->getActiveSheet()->getStyle('L4')->getAlignment()->setWrapText(true);
                            $objPHPExcel->getActiveSheet()->mergeCells('L4:L4');
            $objPHPExcel->getActiveSheet()->getStyle('L4:L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                        }
                        else {
                            $objPHPExcel->getActiveSheet()->setCellValue('M' . 4, 'ត្រីមាសទី 3'.PHP_EOL.'Quý 3');
$objPHPExcel->getActiveSheet()->getStyle('M4')->getAlignment()->setWrapText(true);
                            $objPHPExcel->getActiveSheet()->mergeCells('M4:M4');
            $objPHPExcel->getActiveSheet()->getStyle('M4:M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                        }
                     }
                     else if($total_span==2) {

                        if($month7==7 && $month8==8) {
                            $objPHPExcel->getActiveSheet()->setCellValue('K' . 4, 'ត្រីមាសទី 3'.PHP_EOL.'Quý 3');
$objPHPExcel->getActiveSheet()->getStyle('K4')->getAlignment()->setWrapText(true);
                            $objPHPExcel->getActiveSheet()->mergeCells('K4:L4');
             $objPHPExcel->getActiveSheet()->getStyle('K4:L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                        }
                        else if($month8==8 && $month9==9) {
                            $objPHPExcel->getActiveSheet()->setCellValue('L' . 4, 'ត្រីមាសទី 3'.PHP_EOL.'Quý 3');
$objPHPExcel->getActiveSheet()->getStyle('L4')->getAlignment()->setWrapText(true);
                            $objPHPExcel->getActiveSheet()->mergeCells('L4:M4');
             $objPHPExcel->getActiveSheet()->getStyle('L4:M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                        }
             
                     }
                     else if($total_span==3) {
                        $objPHPExcel->getActiveSheet()->setCellValue('K' . 4, 'ត្រីមាសទី 3'.PHP_EOL.'Quý 3');
$objPHPExcel->getActiveSheet()->getStyle('K4')->getAlignment()->setWrapText(true);
                       $objPHPExcel->getActiveSheet()->mergeCells('K4:M4');
                       $objPHPExcel->getActiveSheet()->getStyle('K4:M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                     }
                     else {

                     }

                    


}
else {
    $objPHPExcel->getActiveSheet()->setCellValue('K' . 4, 'ត្រីមាសទី 3'.PHP_EOL.'Quý 3');
$objPHPExcel->getActiveSheet()->getStyle('K4')->getAlignment()->setWrapText(true);

   $objPHPExcel->getActiveSheet()->mergeCells('K4:M4');
   $objPHPExcel->getActiveSheet()->getStyle('K4:M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
   $objPHPExcel->getActiveSheet()->mergeCells('K5:M5');
   $objPHPExcel->getActiveSheet()->getStyle('K5:M5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
}

if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
        if($month7==7){
          $objPHPExcel->getActiveSheet()->setCellValue('K' . 5, '7');
        }
        if($month8==8){
          $objPHPExcel->getActiveSheet()->setCellValue('L' . 5, '8');
        }
        if($month9==9){
          $objPHPExcel->getActiveSheet()->setCellValue('M' . 5, '9');
        }
 }
 else {
    $objPHPExcel->getActiveSheet()->setCellValue('K' . 5, '7');
    $objPHPExcel->getActiveSheet()->setCellValue('L' . 5, '8');
    $objPHPExcel->getActiveSheet()->setCellValue('M' . 5, '9');

 }
 // end query 3

 // start query4
 $total_span4 = 0;
 $month10 = 0;
 $month11=0;
 $month12=0;
if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
        $v_date_start=$date1;
        $v_date_end=$date2;
        $start = $month =strtotime("$v_date_start");
        $end = strtotime("$v_date_end");
        $col_span=0;
        $total_span=0;
        while($month <= $end)
                    {
                         $date_result=date('Y-m',$month);
                         $month = strtotime("+1 month", $month);

                         if($date_result==date('Y-10')) {
                            $col_span=1;
                            $month10=10;
                            array_push($monthArr, 10);
                         }
                         else if($date_result==date('Y-11')) {
                            $col_span =1;
                            $month11=11;
                            array_push($monthArr, 11);
                         }
                         else if($date_result==date('Y-12')) {
                            $col_span =1;
                            $month12=12;
                            array_push($monthArr, 12);
                         }
                         else {
                            $col_span=0;
                         }

                         $total_span +=$col_span;
                         $total_span4=$total_span;
                    }
               if($total_span==1) {
                        if($month10==10) {
$objPHPExcel->getActiveSheet()->setCellValue('N' . 4, 'ត្រីមាសទី 4'.PHP_EOL.'Quý 4');
$objPHPExcel->getActiveSheet()->getStyle('N4')->getAlignment()->setWrapText(true);
                            $objPHPExcel->getActiveSheet()->mergeCells('N4:N4');
            $objPHPExcel->getActiveSheet()->getStyle('N4:N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                        }
                        else if($month11==11) {
                            $objPHPExcel->getActiveSheet()->setCellValue('O' . 4, 'ត្រីមាសទី 4'.PHP_EOL.'Quý 4');
$objPHPExcel->getActiveSheet()->getStyle('O4')->getAlignment()->setWrapText(true);
                            $objPHPExcel->getActiveSheet()->mergeCells('O4:O4');
            $objPHPExcel->getActiveSheet()->getStyle('O4:O4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                        }
                        else {
                            $objPHPExcel->getActiveSheet()->setCellValue('P' . 4, 'ត្រីមាសទី 4'.PHP_EOL.'Quý 4');
$objPHPExcel->getActiveSheet()->getStyle('P4')->getAlignment()->setWrapText(true);
                            $objPHPExcel->getActiveSheet()->mergeCells('P4:P4');
            $objPHPExcel->getActiveSheet()->getStyle('P4:P4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                        }
                     }
                     else if($total_span==2) {

                        if($month10==10 && $month11==11) {
                            $objPHPExcel->getActiveSheet()->setCellValue('N' . 4, 'ត្រីមាសទី 4'.PHP_EOL.'Quý 4');
$objPHPExcel->getActiveSheet()->getStyle('N4')->getAlignment()->setWrapText(true);
                            $objPHPExcel->getActiveSheet()->mergeCells('N4:O4');
             $objPHPExcel->getActiveSheet()->getStyle('N4:O4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                        }
                        else if($month11==11 && $month12==12) {
                            $objPHPExcel->getActiveSheet()->setCellValue('O' . 4, 'ត្រីមាសទី 4'.PHP_EOL.'Quý 4');
$objPHPExcel->getActiveSheet()->getStyle('O4')->getAlignment()->setWrapText(true);
                            $objPHPExcel->getActiveSheet()->mergeCells('O4:P4');
             $objPHPExcel->getActiveSheet()->getStyle('O4:P4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                        }
             
                     }
                     else if($total_span==3) {
                        $objPHPExcel->getActiveSheet()->setCellValue('N' . 4, 'ត្រីមាសទី 4'.PHP_EOL.'Quý 4');
$objPHPExcel->getActiveSheet()->getStyle('N4')->getAlignment()->setWrapText(true);
                       $objPHPExcel->getActiveSheet()->mergeCells('N4:P4');
                       $objPHPExcel->getActiveSheet()->getStyle('N4:P4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                     }
                     else {

                     }

                    


}
else {
    $objPHPExcel->getActiveSheet()->setCellValue('N' . 4, 'ត្រីមាសទី 4'.PHP_EOL.'Quý 4');
$objPHPExcel->getActiveSheet()->getStyle('N4')->getAlignment()->setWrapText(true);

   $objPHPExcel->getActiveSheet()->mergeCells('N4:P4');
   $objPHPExcel->getActiveSheet()->getStyle('N4:P4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
   $objPHPExcel->getActiveSheet()->mergeCells('N5:P5');
   $objPHPExcel->getActiveSheet()->getStyle('N5:P5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
}

if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
        if($month10==10){
          $objPHPExcel->getActiveSheet()->setCellValue('N' . 5, '10');
        }
        if($month11==11){
          $objPHPExcel->getActiveSheet()->setCellValue('O' . 5, '11');
        }
        if($month12==12){
          $objPHPExcel->getActiveSheet()->setCellValue('P' . 5, '12');
        }
 }
 else {
    $objPHPExcel->getActiveSheet()->setCellValue('N' . 5, '10');
    $objPHPExcel->getActiveSheet()->setCellValue('O' . 5, '11');
    $objPHPExcel->getActiveSheet()->setCellValue('P' . 5, '12');

 }
 // end query 4



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

while ($row = mysqli_fetch_object($get_data)) {
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

                    $result_cost = myCalCostAverage($v_array);

                    $v_last_qty = ($v_begining_bal_qty + $v_current_in_qty - @$row->current_out + @$row->current_adjust);



                     $v_total_price_beg += $v_begining_bal_price;
                    $v_total_qty_in += $v_current_in_qty;
                    $v_total_price_in += $v_current_in_price;
                    $v_total_price_out += $result_cost * $row->current_out;
                    $v_total_qty_out += $row->current_out;
                    $v_total_price_adjust += $result_cost * $row->current_adjust;
                    $v_total_qty_adjust += $row->current_adjust;
                    $v_total_price_bal += $v_last_qty * $result_cost;
                    $v_total_qty_bal += $v_last_qty;

                    $arr_child = [
                        $row->stca_id => $row->stca_id,
                        'price_beg' => $v_begining_bal_price,
                        'price_in' => $v_current_in_price,
                        'price_out' => $result_cost * $row->current_out,
                        'price_adjust' => $result_cost * $row->current_adjust,
                        'price_end' => $v_last_qty * $result_cost
                    ];
                    array_push($v_arr_summary, $arr_child);
}



 $i = 0;
 $check_loop=1;
  $v_sql = "SELECT * FROM tbl_st_category_list WHERE material_type_id='1'";
                $v_result_summary = $connect->query($v_sql);


     while ($row_summary = mysqli_fetch_object($v_result_summary)) {

        if($check_loop==1) {
            $idx=6;
        }
        else {
            $idx = $idx+4;
        }
        ++$check_loop;

       
        

         $v_arr_result = summaryMaterial($row_summary->stca_id, $v_arr_summary);
         $cate_min_id=$row_summary->stca_id;

        $objPHPExcel->getActiveSheet()->setCellValue('A' . $idx,"");
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $idx,"");
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $idx, "ដើមគ្រា Đầu kỳ");
         if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-01-01') && $v_date_end>date('Y-01-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-01-01') && 
                                            $v_date_end >date('Y-01-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-01-01');
                                                 $v_date_end = date('Y-01-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-01-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-01-01');
                                    $v_date_end = date('Y-01-31');
                                }
                                  $d1= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,4);


                               if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-02-01') && $v_date_end>date('Y-02-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-02-01') && 
                                            $v_date_end >date('Y-02-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-02-01');
                                                 $v_date_end = date('Y-02-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-02-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-02-01');
                                    $v_date_end = date('Y-02-31');
                                }
                                  $d2= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,4);
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-03-01') && $v_date_end>date('Y-03-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-03-01') && 
                                            $v_date_end >date('Y-03-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-03-01');
                                                 $v_date_end = date('Y-03-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-03-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-03-01');
                                    $v_date_end = date('Y-03-31');
                                }
                                  $d3= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,4);
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-04-01') && $v_date_end>date('Y-04-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-04-01') && 
                                            $v_date_end >date('Y-04-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-04-01');
                                                 $v_date_end = date('Y-04-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-04-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-04-01');
                                    $v_date_end = date('Y-04-31');
                                }
                                  $d4= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,4);
                                 if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-05-01') && $v_date_end>date('Y-05-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-05-01') && 
                                            $v_date_end >date('Y-05-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-05-01');
                                                 $v_date_end = date('Y-05-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-05-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-05-01');
                                    $v_date_end = date('Y-05-31');
                                }
                                  $d5= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,4);
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-06-01') && $v_date_end>date('Y-06-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-06-01') && 
                                            $v_date_end >date('Y-06-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-06-01');
                                                 $v_date_end = date('Y-06-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-06-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-06-01');
                                    $v_date_end = date('Y-06-31');
                                }
                                  $d6= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,4);
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-07-01') && $v_date_end>date('Y-07-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-07-01') && 
                                            $v_date_end >date('Y-07-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-07-01');
                                                 $v_date_end = date('Y-07-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-07-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-07-01');
                                    $v_date_end = date('Y-07-31');
                                }
                                  $d7= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,4);
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-08-01') && $v_date_end>date('Y-08-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-08-01') && 
                                            $v_date_end >date('Y-08-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-08-01');
                                                 $v_date_end = date('Y-08-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-08-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-08-01');
                                    $v_date_end = date('Y-08-31');
                                }
                                  $d8= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,4);
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-09-01') && $v_date_end>date('Y-09-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-09-01') && 
                                            $v_date_end >date('Y-09-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-09-01');
                                                 $v_date_end = date('Y-09-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-09-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-09-01');
                                    $v_date_end = date('Y-09-31');
                                }
                                  $d9= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,4);
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-10-01') && $v_date_end>date('Y-10-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-10-01') && 
                                            $v_date_end >date('Y-10-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-10-01');
                                                 $v_date_end = date('Y-10-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-10-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-10-01');
                                    $v_date_end = date('Y-10-31');
                                }
                                  $d10= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,4);
                                 if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-11-01') && $v_date_end>date('Y-11-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-11-01') && 
                                            $v_date_end >date('Y-11-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-11-01');
                                                 $v_date_end = date('Y-11-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-11-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-11-01');
                                    $v_date_end = date('Y-11-31');
                                }
                                  $d11= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,4);
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-12-01') && $v_date_end>date('Y-12-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-12-01') && 
                                            $v_date_end >date('Y-12-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-12-01');
                                                 $v_date_end = date('Y-12-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-12-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-12-01');
                                    $v_date_end = date('Y-12-31');
                                }
                                  $d12= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,4);
                                  $d_all=array($d1,$d2,$d3,$d4,$d5,$d6,$d7,$d8,$d9,$d10,$d11,$d12);
                                 number_format(array_sum($d_all),2);
                                  $d_all_total=array_sum($d_all);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $idx, $d_all_total);

                    if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-01-01') && $v_date_end>date('Y-01-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-01-01') && 
                                            $v_date_end >date('Y-01-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-01-01');
                                                 $v_date_end = date('Y-01-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-01-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-01-01');
                                    $v_date_end = date('Y-01-31');
                                }
                                  
                                 $cc=calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);

                         $objPHPExcel->getActiveSheet()->setCellValue('E' .$idx,$cc);
                    

                        

                            if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-02-01') && $v_date_end>date('Y-02-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-02-01') && 
                                            $v_date_end >date('Y-02-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-02-01');
                                                 $v_date_end = date('Y-02-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-02-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-02-01');
                                    $v_date_end = date('Y-02-31');
                                }
                                // echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $idx,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1));
                      if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-03-01') && $v_date_end>date('Y-03-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-03-01') && 
                                            $v_date_end >date('Y-03-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-03-01');
                                                 $v_date_end = date('Y-03-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-03-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-03-01');
                                    $v_date_end = date('Y-03-31');
                                }
                                 

                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $idx,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1));

                     if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-04-01') && $v_date_end>date('Y-04-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-04-01') && 
                                            $v_date_end >date('Y-04-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-04-01');
                                                 $v_date_end = date('Y-04-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-04-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-04-01');
                                    $v_date_end = date('Y-04-31');
                                }
                                 

                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $idx, calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1));

                    if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-05-01') && $v_date_end>date('Y-05-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-05-01') && 
                                            $v_date_end >date('Y-05-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-05-01');
                                                 $v_date_end = date('Y-05-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-05-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-05-01');
                                    $v_date_end = date('Y-05-31');
                                }
                                 

                     $objPHPExcel->getActiveSheet()->setCellValue('I' . $idx,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1));

                      if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-06-01') && $v_date_end>date('Y-06-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-06-01') && 
                                            $v_date_end >date('Y-06-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-06-01');
                                                 $v_date_end = date('Y-06-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-06-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-06-01');
                                    $v_date_end = date('Y-06-31');
                                }
                                  

                     $objPHPExcel->getActiveSheet()->setCellValue('J' . $idx,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1));

                    if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-07-01') && $v_date_end>date('Y-07-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-07-01') && 
                                            $v_date_end >date('Y-07-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-07-01');
                                                 $v_date_end = date('Y-07-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-07-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-07-01');
                                    $v_date_end = date('Y-07-31');
                                }
                                  
                      $objPHPExcel->getActiveSheet()->setCellValue('K' . $idx,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1));
                        if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-08-01') && $v_date_end>date('Y-08-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-08-01') && 
                                            $v_date_end >date('Y-08-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-08-01');
                                                 $v_date_end = date('Y-08-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-08-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-08-01');
                                    $v_date_end = date('Y-08-31');
                                }

                       $objPHPExcel->getActiveSheet()->setCellValue('L' . $idx,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1));
                  

                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-09-01') && $v_date_end>date('Y-09-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-09-01') && 
                                            $v_date_end >date('Y-09-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-09-01');
                                                 $v_date_end = date('Y-09-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-09-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-09-01');
                                    $v_date_end = date('Y-09-31');
                                }
                                


                       $objPHPExcel->getActiveSheet()->setCellValue('M' . $idx,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1));
                        if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-10-01') && $v_date_end>date('Y-10-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-10-01') && 
                                            $v_date_end >date('Y-10-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-10-01');
                                                 $v_date_end = date('Y-10-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-10-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-10-01');
                                    $v_date_end = date('Y-10-31');
                                }

                        $objPHPExcel->getActiveSheet()->setCellValue('N' . $idx,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1));

                        if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-11-01') && $v_date_end>date('Y-11-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-11-01') && 
                                            $v_date_end >date('Y-11-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-11-01');
                                                 $v_date_end = date('Y-11-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-11-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-11-01');
                                    $v_date_end = date('Y-11-31');
                                }

                                $objPHPExcel->getActiveSheet()->setCellValue('O' . $idx,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1));

                                    if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-12-01') && $v_date_end>date('Y-12-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-12-01') && 
                                            $v_date_end >date('Y-12-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-12-01');
                                                 $v_date_end = date('Y-12-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-12-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }
                                }
                                else {
                                    $v_date_start = date('Y-12-01');
                                    $v_date_end = date('Y-12-31');
                                }
                                  $objPHPExcel->getActiveSheet()->setCellValue('P' . $idx,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1));
// in stock
   $idx_in=$idx+1;
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $idx_in,++$i);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $idx_in,$row_summary->stca_name);

        $objPHPExcel->getActiveSheet()->setCellValue('C' . $idx_in, "ស្តុកចូល Nhập kho");
          if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-01-01') && $v_date_end>date('Y-01-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-01-01') && 
                                            $v_date_end >date('Y-01-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-01-01');
                                                 $v_date_end = date('Y-01-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-01-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-01-01');
                                    $v_date_end = date('Y-01-31');
                                }
                                 $in_1= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,5);
                                 if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-02-01') && $v_date_end>date('Y-02-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-02-01') && 
                                            $v_date_end >date('Y-02-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-02-01');
                                                 $v_date_end = date('Y-02-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-02-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-02-01');
                                    $v_date_end = date('Y-02-31');
                                }
                                 $in_2= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,5);
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-03-01') && $v_date_end>date('Y-03-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-03-01') && 
                                            $v_date_end >date('Y-03-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-03-01');
                                                 $v_date_end = date('Y-03-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-03-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-03-01');
                                    $v_date_end = date('Y-03-31');
                                }
                                 $in_3= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,5);
                                 if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-04-01') && $v_date_end>date('Y-04-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-04-01') && 
                                            $v_date_end >date('Y-04-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-04-01');
                                                 $v_date_end = date('Y-04-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-04-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-04-01');
                                    $v_date_end = date('Y-04-31');
                                }
                                 $in_4= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,5);
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-05-01') && $v_date_end>date('Y-05-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-05-01') && 
                                            $v_date_end >date('Y-05-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-05-01');
                                                 $v_date_end = date('Y-05-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-05-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-05-01');
                                    $v_date_end = date('Y-05-31');
                                }
                                 $in_5= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,5);
                                 if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-06-01') && $v_date_end>date('Y-06-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-06-01') && 
                                            $v_date_end >date('Y-06-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-06-01');
                                                 $v_date_end = date('Y-06-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-06-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-06-01');
                                    $v_date_end = date('Y-06-31');
                                }
                                 $in_6= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,5);
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-07-01') && $v_date_end>date('Y-07-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-07-01') && 
                                            $v_date_end >date('Y-07-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-07-01');
                                                 $v_date_end = date('Y-07-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-07-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-07-01');
                                    $v_date_end = date('Y-07-31');
                                }
                                 $in_7= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,5);
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-08-01') && $v_date_end>date('Y-08-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-08-01') && 
                                            $v_date_end >date('Y-08-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-08-01');
                                                 $v_date_end = date('Y-08-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-08-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-08-01');
                                    $v_date_end = date('Y-08-31');
                                }
                                 $in_8= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,5);
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-09-01') && $v_date_end>date('Y-09-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-09-01') && 
                                            $v_date_end >date('Y-09-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-09-01');
                                                 $v_date_end = date('Y-09-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-09-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-09-01');
                                    $v_date_end = date('Y-09-31');
                                }
                                 $in_9= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,5);
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-10-01') && $v_date_end>date('Y-10-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-10-01') && 
                                            $v_date_end >date('Y-10-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-10-01');
                                                 $v_date_end = date('Y-10-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-10-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-10-01');
                                    $v_date_end = date('Y-10-31');
                                }
                                 $in_10= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,5);
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-11-01') && $v_date_end>date('Y-11-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-11-01') && 
                                            $v_date_end >date('Y-11-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-11-01');
                                                 $v_date_end = date('Y-11-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-11-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-11-01');
                                    $v_date_end = date('Y-11-31');
                                }
                                 $in_11= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,5);
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-12-01') && $v_date_end>date('Y-12-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-12-01') && 
                                            $v_date_end >date('Y-12-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-12-01');
                                                 $v_date_end = date('Y-12-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-12-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-12-01');
                                    $v_date_end = date('Y-12-31');
                                }
                                 $in_12= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,5);
                                 $in_all=array($in_1,$in_2,$in_3,$in_4,$in_5,$in_6,$in_7,$in_8,$in_9,$in_10,$in_11,$in_12);
                                   number_format(array_sum($in_all),2);
                                  $in_all_total=array_sum($in_all);
                                 

                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $idx_in, $in_all_total);

                    if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-01-01') && $v_date_end>date('Y-01-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-01-01') && 
                                            $v_date_end >date('Y-01-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-01-01');
                                                 $v_date_end = date('Y-01-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-01-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-01-01');
                                    $v_date_end = date('Y-01-31');
                                }
                                  
                                 $cc=calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2);

                         $objPHPExcel->getActiveSheet()->setCellValue('E' .$idx_in,$cc);
                    

                        

                            if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-02-01') && $v_date_end>date('Y-02-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-02-01') && 
                                            $v_date_end >date('Y-02-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-02-01');
                                                 $v_date_end = date('Y-02-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-02-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-02-01');
                                    $v_date_end = date('Y-02-31');
                                }
                                // echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $idx_in,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2));
                      if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-03-01') && $v_date_end>date('Y-03-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-03-01') && 
                                            $v_date_end >date('Y-03-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-03-01');
                                                 $v_date_end = date('Y-03-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-03-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-03-01');
                                    $v_date_end = date('Y-03-31');
                                }
                                 

                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $idx_in,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2));

                     if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-04-01') && $v_date_end>date('Y-04-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-04-01') && 
                                            $v_date_end >date('Y-04-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-04-01');
                                                 $v_date_end = date('Y-04-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-04-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-04-01');
                                    $v_date_end = date('Y-04-31');
                                }
                                 

                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $idx_in, calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2));

                    if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-05-01') && $v_date_end>date('Y-05-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-05-01') && 
                                            $v_date_end >date('Y-05-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-05-01');
                                                 $v_date_end = date('Y-05-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-05-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-05-01');
                                    $v_date_end = date('Y-05-31');
                                }
                                 

                     $objPHPExcel->getActiveSheet()->setCellValue('I' . $idx_in,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2));

                      if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-06-01') && $v_date_end>date('Y-06-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-06-01') && 
                                            $v_date_end >date('Y-06-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-06-01');
                                                 $v_date_end = date('Y-06-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-06-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-06-01');
                                    $v_date_end = date('Y-06-31');
                                }
                                  

                     $objPHPExcel->getActiveSheet()->setCellValue('J' . $idx_in,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2));

                    if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-07-01') && $v_date_end>date('Y-07-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-07-01') && 
                                            $v_date_end >date('Y-07-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-07-01');
                                                 $v_date_end = date('Y-07-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-07-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-07-01');
                                    $v_date_end = date('Y-07-31');
                                }
                                  
                      $objPHPExcel->getActiveSheet()->setCellValue('K' . $idx_in,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2));
                        if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-08-01') && $v_date_end>date('Y-08-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-08-01') && 
                                            $v_date_end >date('Y-08-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-08-01');
                                                 $v_date_end = date('Y-08-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-08-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-08-01');
                                    $v_date_end = date('Y-08-31');
                                }

                       $objPHPExcel->getActiveSheet()->setCellValue('L' . $idx_in,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2));
                  

                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-09-01') && $v_date_end>date('Y-09-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-09-01') && 
                                            $v_date_end >date('Y-09-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-09-01');
                                                 $v_date_end = date('Y-09-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-09-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-09-01');
                                    $v_date_end = date('Y-09-31');
                                }
                                


                       $objPHPExcel->getActiveSheet()->setCellValue('M' . $idx_in,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2));
                        if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-10-01') && $v_date_end>date('Y-10-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-10-01') && 
                                            $v_date_end >date('Y-10-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-10-01');
                                                 $v_date_end = date('Y-10-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-10-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-10-01');
                                    $v_date_end = date('Y-10-31');
                                }

                        $objPHPExcel->getActiveSheet()->setCellValue('N' . $idx_in,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2));

                        if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-11-01') && $v_date_end>date('Y-11-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-11-01') && 
                                            $v_date_end >date('Y-11-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-11-01');
                                                 $v_date_end = date('Y-11-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-11-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-11-01');
                                    $v_date_end = date('Y-11-31');
                                }

                                $objPHPExcel->getActiveSheet()->setCellValue('O' . $idx_in,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2));

                                    if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-12-01') && $v_date_end>date('Y-12-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-12-01') && 
                                            $v_date_end >date('Y-12-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-12-01');
                                                 $v_date_end = date('Y-12-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-12-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }
                                }
                                else {
                                    $v_date_start = date('Y-12-01');
                                    $v_date_end = date('Y-12-31');
                                }
                                  $objPHPExcel->getActiveSheet()->setCellValue('P' . $idx_in,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2));



// out stock

$idx_out=$idx_in+1;

        $objPHPExcel->getActiveSheet()->setCellValue('A' . $idx_out,"");
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $idx_out,"");
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $idx_out, "ស្តុកចេញ Xuất kho");
           if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-01-01') && $v_date_end>date('Y-01-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-01-01') && 
                                            $v_date_end >date('Y-01-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-01-01');
                                                 $v_date_end = date('Y-01-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-01-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-01-01');
                                    $v_date_end = date('Y-01-31');
                                }
                                 $out_1= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,6);
                                    if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-02-01') && $v_date_end>date('Y-02-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-02-01') && 
                                            $v_date_end >date('Y-02-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-02-01');
                                                 $v_date_end = date('Y-02-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-02-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-02-01');
                                    $v_date_end = date('Y-02-31');
                                }
                                 $out_2= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,6);
                                     if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-03-01') && $v_date_end>date('Y-03-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-03-01') && 
                                            $v_date_end >date('Y-03-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-03-01');
                                                 $v_date_end = date('Y-03-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-03-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-03-01');
                                    $v_date_end = date('Y-03-31');
                                }
                                 $out_3= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,6);
                                    if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-04-01') && $v_date_end>date('Y-04-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-04-01') && 
                                            $v_date_end >date('Y-04-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-04-01');
                                                 $v_date_end = date('Y-04-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-04-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-04-01');
                                    $v_date_end = date('Y-04-31');
                                }
                                 $out_4= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,6);
                                     if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-05-01') && $v_date_end>date('Y-05-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-05-01') && 
                                            $v_date_end >date('Y-05-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-05-01');
                                                 $v_date_end = date('Y-05-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-05-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-05-01');
                                    $v_date_end = date('Y-05-31');
                                }
                                 $out_5= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,6);
                                     if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-06-01') && $v_date_end>date('Y-06-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-06-01') && 
                                            $v_date_end >date('Y-06-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-06-01');
                                                 $v_date_end = date('Y-06-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-06-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-06-01');
                                    $v_date_end = date('Y-06-31');
                                }
                                 $out_6= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,6);
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-07-01') && $v_date_end>date('Y-07-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-07-01') && 
                                            $v_date_end >date('Y-07-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-07-01');
                                                 $v_date_end = date('Y-07-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-07-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-07-01');
                                    $v_date_end = date('Y-07-31');
                                }
                                 $out_7= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,6);
                                     if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-08-01') && $v_date_end>date('Y-08-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-08-01') && 
                                            $v_date_end >date('Y-08-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-08-01');
                                                 $v_date_end = date('Y-08-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-08-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-08-01');
                                    $v_date_end = date('Y-08-31');
                                }
                                 $out_8= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,6);
                                    if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-09-01') && $v_date_end>date('Y-09-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-09-01') && 
                                            $v_date_end >date('Y-09-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-09-01');
                                                 $v_date_end = date('Y-09-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-09-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-09-01');
                                    $v_date_end = date('Y-09-31');
                                }
                                 $out_9= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,6);
                                     if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-10-01') && $v_date_end>date('Y-10-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-10-01') && 
                                            $v_date_end >date('Y-10-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-10-01');
                                                 $v_date_end = date('Y-10-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-10-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-10-01');
                                    $v_date_end = date('Y-10-31');
                                }
                                 $out_10= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,6);
                                    if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-11-01') && $v_date_end>date('Y-11-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-11-01') && 
                                            $v_date_end >date('Y-11-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-11-01');
                                                 $v_date_end = date('Y-11-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-11-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-11-01');
                                    $v_date_end = date('Y-11-31');
                                }
                                 $out_11= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,6);
                                    if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-12-01') && $v_date_end>date('Y-12-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-12-01') && 
                                            $v_date_end >date('Y-12-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-12-01');
                                                 $v_date_end = date('Y-12-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-12-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-12-01');
                                    $v_date_end = date('Y-12-31');
                                }
                                 $out_12= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,6);
                                 $out_all=array($out_1,$out_2,$out_3,$out_4,$out_5,$out_6,$out_7,$out_8,$out_9,$out_10,$out_11,$out_12);
                                    number_format(array_sum($out_all),2);
                                    $out_all_total=array_sum($out_all);
                                 

                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $idx_out, $out_all_total);

                    if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-01-01') && $v_date_end>date('Y-01-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-01-01') && 
                                            $v_date_end >date('Y-01-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-01-01');
                                                 $v_date_end = date('Y-01-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-01-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-01-01');
                                    $v_date_end = date('Y-01-31');
                                }
                                  
                                 $cc=calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3);

                         $objPHPExcel->getActiveSheet()->setCellValue('E' .$idx_out,$cc);
                    

                        

                            if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-02-01') && $v_date_end>date('Y-02-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-02-01') && 
                                            $v_date_end >date('Y-02-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-02-01');
                                                 $v_date_end = date('Y-02-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-02-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-02-01');
                                    $v_date_end = date('Y-02-31');
                                }
                                // echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $idx_out,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3));
                      if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-03-01') && $v_date_end>date('Y-03-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-03-01') && 
                                            $v_date_end >date('Y-03-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-03-01');
                                                 $v_date_end = date('Y-03-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-03-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-03-01');
                                    $v_date_end = date('Y-03-31');
                                }
                                 

                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $idx_out,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3));

                     if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-04-01') && $v_date_end>date('Y-04-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-04-01') && 
                                            $v_date_end >date('Y-04-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-04-01');
                                                 $v_date_end = date('Y-04-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-04-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-04-01');
                                    $v_date_end = date('Y-04-31');
                                }
                                 

                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $idx_out, calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3));

                    if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-05-01') && $v_date_end>date('Y-05-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-05-01') && 
                                            $v_date_end >date('Y-05-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-05-01');
                                                 $v_date_end = date('Y-05-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-05-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-05-01');
                                    $v_date_end = date('Y-05-31');
                                }
                                 

                     $objPHPExcel->getActiveSheet()->setCellValue('I' . $idx_out,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3));

                      if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-06-01') && $v_date_end>date('Y-06-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-06-01') && 
                                            $v_date_end >date('Y-06-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-06-01');
                                                 $v_date_end = date('Y-06-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-06-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-06-01');
                                    $v_date_end = date('Y-06-31');
                                }
                                  

                     $objPHPExcel->getActiveSheet()->setCellValue('J' . $idx_out,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3));

                    if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-07-01') && $v_date_end>date('Y-07-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-07-01') && 
                                            $v_date_end >date('Y-07-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-07-01');
                                                 $v_date_end = date('Y-07-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-07-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-07-01');
                                    $v_date_end = date('Y-07-31');
                                }
                                  
                      $objPHPExcel->getActiveSheet()->setCellValue('K' . $idx_out,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3));
                        if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-08-01') && $v_date_end>date('Y-08-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-08-01') && 
                                            $v_date_end >date('Y-08-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-08-01');
                                                 $v_date_end = date('Y-08-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-08-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-08-01');
                                    $v_date_end = date('Y-08-31');
                                }

                       $objPHPExcel->getActiveSheet()->setCellValue('L' . $idx_out,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3));
                  

                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-09-01') && $v_date_end>date('Y-09-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-09-01') && 
                                            $v_date_end >date('Y-09-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-09-01');
                                                 $v_date_end = date('Y-09-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-09-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-09-01');
                                    $v_date_end = date('Y-09-31');
                                }
                                


                       $objPHPExcel->getActiveSheet()->setCellValue('M' . $idx_out,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3));
                        if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-10-01') && $v_date_end>date('Y-10-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-10-01') && 
                                            $v_date_end >date('Y-10-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-10-01');
                                                 $v_date_end = date('Y-10-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-10-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-10-01');
                                    $v_date_end = date('Y-10-31');
                                }

                        $objPHPExcel->getActiveSheet()->setCellValue('N' . $idx_out,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3));

                        if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-11-01') && $v_date_end>date('Y-11-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-11-01') && 
                                            $v_date_end >date('Y-11-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-11-01');
                                                 $v_date_end = date('Y-11-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-11-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-11-01');
                                    $v_date_end = date('Y-11-31');
                                }

                                $objPHPExcel->getActiveSheet()->setCellValue('O' . $idx_out,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3));

                                    if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-12-01') && $v_date_end>date('Y-12-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-12-01') && 
                                            $v_date_end >date('Y-12-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-12-01');
                                                 $v_date_end = date('Y-12-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-12-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }
                                }
                                else {
                                    $v_date_start = date('Y-12-01');
                                    $v_date_end = date('Y-12-31');
                                }
                                  $objPHPExcel->getActiveSheet()->setCellValue('P' . $idx_out,calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3));




 // stock total

$idx_bel=$idx_out+1;

        $objPHPExcel->getActiveSheet()->setCellValue('A' . $idx_bel,"");
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $idx_bel,"");
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $idx_bel, "សមតុល្យ Cuối kỳ");

        $total_by_cate=($d_all_total+$in_all_total)-($out_all_total);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $idx_bel,$total_by_cate);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $idx_bel,($in_1+$d1)-($out_1));
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $idx_bel,($in_2+$d2)-($out_2));
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $idx_bel,($in_3+$d3)-($out_3));
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $idx_bel,($in_4+$d4)-($out_4));
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $idx_bel,($in_5+$d5)-($out_5));
        $objPHPExcel->getActiveSheet()->setCellValue('J' . $idx_bel,($in_6+$d6)-($out_6));
        $objPHPExcel->getActiveSheet()->setCellValue('K' . $idx_bel,($in_7+$d7)-($out_7));
        $objPHPExcel->getActiveSheet()->setCellValue('L' . $idx_bel,($in_8+$d8)-($out_8));
        $objPHPExcel->getActiveSheet()->setCellValue('M' . $idx_bel,($in_9+$d9)-($out_9));
        $objPHPExcel->getActiveSheet()->setCellValue('N' . $idx_bel,($in_10+$d10)-($out_10));
        $objPHPExcel->getActiveSheet()->setCellValue('O' . $idx_bel,($in_11+$d11)-($out_11));
        $objPHPExcel->getActiveSheet()->setCellValue('P' . $idx_bel,($in_12+$d12)-($out_12));
          

// $objPHPExcel->getActiveSheet()->setCellValue('A' . $idx,  $i_in++);
// $objPHPExcel->getActiveSheet()->setCellValue('B' . $idx, $row_summary->stca_name);
// $objPHPExcel->getActiveSheet()->setCellValue('C' . $idx, "ដើមគ្រា Đầu kỳ");
// $objPHPExcel->getActiveSheet()->setCellValue('D' . $idx, "");
// $objPHPExcel->getActiveSheet()->setCellValue('E' . $idx, "");
// $objPHPExcel->getActiveSheet()->setCellValue('F' . $idx, "");
// $objPHPExcel->getActiveSheet()->setCellValue('G' . $idx, "");
// $objPHPExcel->getActiveSheet()->setCellValue('H' . $idx, "");
                                 
}

// remove column
// $i=1;

// while ($i<=12):

//     # code...
//     if($i!=$month.$i)
//     {
//         $objPHPExcel->getActiveSheet()->removeColumn('E');    
//     }
//     $i++;
// endwhile;

$inMonth = count($monthArr);
$columnArr = array('E','F','G','H','I','J','K','L','M','N','O','P');
$ind = 0;
for ($i=1; $i <=12; $i++) {
    # code...
    if($i!=$monthArr[$ind])
    {
        $objPHPExcel->getActiveSheet()->removeColumn($columnArr[$ind]);
    }
    else
    {
        $ind=$ind+1;
        continue;
    }
}
// if($month1 !=1) {
//     $objPHPExcel->getActiveSheet()->removeColumn('E');
// }
// if($month2 !=2) {
//     $objPHPExcel->getActiveSheet()->removeColumn('F');
// }
// if($month3 !=3) {
//     $objPHPExcel->getActiveSheet()->removeColumn('G');
// }
// if($month4 !=4) {
//     $objPHPExcel->getActiveSheet()->removeColumn('H');
// }
// if($month5 !=5) {
//     $objPHPExcel->getActiveSheet()->removeColumn('I');
// }
// if($month6 !=6) {
//     $objPHPExcel->getActiveSheet()->removeColumn('J');
// }
// if($month7 !=7) {
//     $objPHPExcel->getActiveSheet()->removeColumn('K');
// }
// if($month8 !=8) {
//     $objPHPExcel->getActiveSheet()->removeColumn('L');
// }
// if($month9 !=9) {
//     $objPHPExcel->getActiveSheet()->removeColumn('M');
// }
// if($month10 !=10) {
//     $objPHPExcel->getActiveSheet()->removeColumn('N');
// }
// if($month11 !=11) {
//     $objPHPExcel->getActiveSheet()->removeColumn('O');
// }
// if($month12 !=12) {
//     $objPHPExcel->getActiveSheet()->removeColumn('P');
// }

// header
$objPHPExcel->getActiveSheet()->setCellValue('E' . 1, 'របាយការណ៍សម្ភារៈផលិតក្នុងរោងចក្រ'.' '.date('d/m/Y', strtotime($v_date_start)).'-'. date('d/m/Y', strtotime($v_date_end)));
$objPHPExcel->getActiveSheet()->setCellValue('F' . 2, 'BÁO CÁO VẬT TỪ SỬ DỤNG TRONG NHÀ MÁY');


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