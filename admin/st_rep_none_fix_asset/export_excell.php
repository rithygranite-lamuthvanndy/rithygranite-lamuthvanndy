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
     $condition = "E.stsout_date_out BETWEEN '$v_date_start' 
                    AND '$v_date_end' 
                    AND stock_status='6' ";


}
else {
    $v_date_start = date('Y-m-01');
    $v_date_end = date('Y-m-t');
    $condition = "DATE_FORMAT(E.stsout_date_out,'%Y-%m')='" . date('Y-m') . "'
            AND E.stock_status='6' ";
}


// set number column

$objPHPExcel->getActiveSheet()->getStyle('F')
->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1); 
$objPHPExcel->getActiveSheet()->getStyle('G')
->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1); 
$objPHPExcel->getActiveSheet()->getStyle('H')
->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1); 

$objPHPExcel->getActiveSheet()->getStyle('J')
->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1); 

$objPHPExcel->getActiveSheet()->getStyle('L')
->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);  
$sheet = $objPHPExcel->getActiveSheet();  
$sheet->getStyle('M')->getAlignment()->applyFromArray(
    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);
$sheet = $objPHPExcel->getActiveSheet();   
$sheet->getStyle('J')->getAlignment()->applyFromArray(
    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
); 
$sheet = $objPHPExcel->getActiveSheet();  
$sheet->getStyle('O')->getAlignment()->applyFromArray(
    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);
$sheet = $objPHPExcel->getActiveSheet();  
$sheet->getStyle('P')->getAlignment()->applyFromArray(
    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
); 
$sheet = $objPHPExcel->getActiveSheet();   
$sheet->getStyle('Q')->getAlignment()->applyFromArray(
    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
); 
// Set document properties
$objPHPExcel->getProperties()->setCreator("Silak")
                             ->setLastModifiedBy("Silak")
                             ->setTitle("Rithy granite company")
                             ->setSubject("Rithy granite company")
                             ->setDescription("Rithy granite company")
                             ->setKeywords("Rithy granite company")
                             ->setCategory("Test result file");

       $v_sql = "SELECT A.*,B.stca_name,B.stca_code,C.stun_name,B.stca_id,
                    E.stsout_date_out,C.stun_name,F.stman_name,D.locaton_id,I.stsadj_note,
                    I.stsadj_date_record,E.st_out_check,I.ajust_check,E.stsout_id,E.stsout_note,
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
                        SELECT SUM(in_price_dollar*IFNULL(in_qty,0))
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
                                SUM(in_price_dollar)*IFNULL(SUM(in_qty),0)
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
                  SELECT 
                        COUNT(*)
                        FROM tbl_st_product_name AS AA 
                        LEFT JOIN tbl_st_stock_out_detail AS BB ON BB.pro_id=AA.stpron_id
                        LEFT JOIN tbl_st_stock_out AS CC ON CC.stsout_id=BB.stsout_id
                            WHERE CC.stsout_date_out BETWEEN '{$v_date_start}' AND '{$v_date_end}' AND AA.stpron_id=A.stpron_id
                            
                ) AS row_span,

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
                INNER JOIN tbl_st_manager_list AS F ON F.stman_id=E.stsout_man_id
                
                LEFT JOIN tbl_st_stock_adjustment_detail AS G 
                ON G.pro_id=A.stpron_id
                LEFT JOIN tbl_st_stock_adjustment AS I
                ON I.stsadj_code=E.stsout_letter_no
                WHERE {$condition} GROUP BY D.std_id
                
               
            
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

$i = 0;
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

                
               $check_pro_id="";
 $i_in=$i+1;
$idx=6;
// header text
$today=date("Y-m-d");
if($v_date_start==$today) {
    $v_date_start=date('Y-m-01');
}
$objPHPExcel->getActiveSheet()->setCellValue('E' . 1, 'របាយការណ៍តាមដានឧបករណ៍ជាង នឹង ម៉ាស៊ីនខា្នតតូច'.' '.date('d/m/Y', strtotime($v_date_start)).'-'. date('d/m/Y', strtotime($v_date_end)));
$objPHPExcel->getActiveSheet()->setCellValue('F' . 2, 'Báo Cáo Theo Dõi Thiết Bị Và Máy Kích Thước Nhỏ');
// Header
$objPHPExcel->getActiveSheet()->setCellValue('A' . 4, 'N°');

$objPHPExcel->getActiveSheet()->setCellValue('B' . 4, 'ថ្ងៃដក');
$objPHPExcel->getActiveSheet()->setCellValue('C' . 4, 'ឈ្មោះសំភារៈTên Vật Tư');
$objPHPExcel->getActiveSheet()->setCellValue('E' . 4, 'កូដសំភារៈ');
$objPHPExcel->getActiveSheet()->setCellValue('F' . 4, 'តម្លៃឯកតា');
$objPHPExcel->getActiveSheet()->setCellValue('G' . 4, 'ឈ្មោះអ្នកដក');
$objPHPExcel->getActiveSheet()->setCellValue('H' . 4, 'តំបន់ ប្រើប្រាស់');
$objPHPExcel->getActiveSheet()->setCellValue('I' . 4, 'ចេញ/Out');
$objPHPExcel->getActiveSheet()->setCellValue('J' . 4, 'លេខសំគាល់ ម៉ាស៊ីនឫ ឧបករណ៍ជាង');
$objPHPExcel->getActiveSheet()->setCellValue('K' . 4, 'ស្ដុកដើមគ្រា');
$objPHPExcel->getActiveSheet()->setCellValue('M' . 4, 'តាមដាន');
$objPHPExcel->getActiveSheet()->setCellValue('N' . 4, 'ថ្ងៃប្រគល់​ សង');
$objPHPExcel->getActiveSheet()->setCellValue('O' . 4, 'ចូល/IN(Adjustment)');
$objPHPExcel->getActiveSheet()->setCellValue('P' . 4, 'លេខសំគាល់ ម៉ាស៊ីនឫ ឧបករណ៍ជាង');
$objPHPExcel->getActiveSheet()->setCellValue('Q' . 4, 'សំគាល់បញ្ហា');
$objPHPExcel->getActiveSheet()->setCellValue('R' . 4, 'ចំនួន ស្ដុកសល់ ចុងក្រោយ');
// Header
$objPHPExcel->getActiveSheet()->setCellValue('A' . 5, '');
$objPHPExcel->getActiveSheet()->setCellValue('B' . 5, 'Ngày Lấy');
$objPHPExcel->getActiveSheet()->setCellValue('C' . 5, 'KH');
$objPHPExcel->getActiveSheet()->setCellValue('D' . 5, 'VN');
$objPHPExcel->getActiveSheet()->setCellValue('E' . 5, 'Mã vật Tư');
$objPHPExcel->getActiveSheet()->setCellValue('F' . 5, 'Giá');
$objPHPExcel->getActiveSheet()->setCellValue('G' . 5, 'Tên Người lấy');
$objPHPExcel->getActiveSheet()->setCellValue('H' . 5, 'Khu Vực');
$objPHPExcel->getActiveSheet()->setCellValue('I' . 5, 'Xuất');
$objPHPExcel->getActiveSheet()->setCellValue('J' . 5, 'Số Mã Máy hoặc Thiết Bị');
$objPHPExcel->getActiveSheet()->setCellValue('K' . 5, 'TỒN ĐẦU');
$objPHPExcel->getActiveSheet()->setCellValue('L' . 5, '$');
$objPHPExcel->getActiveSheet()->setCellValue('M' . 5, 'Ghi Chú');
$objPHPExcel->getActiveSheet()->setCellValue('N' . 5, 'Ngày Trả');
$objPHPExcel->getActiveSheet()->setCellValue('O' . 5, '');
$objPHPExcel->getActiveSheet()->setCellValue('P' . 5, 'Số Mã Máy hoặc Thiết Bị');


$objPHPExcel->getActiveSheet()->mergeCells("A4:A5");
$objPHPExcel->getActiveSheet()->mergeCells("C4:D4");
$objPHPExcel->getActiveSheet()->mergeCells("K4:L4");
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

                    $result_cost = myCalCostAverage($v_array);

                    $v_last_qty = ($v_begining_bal_qty + $v_current_in_qty - @$row->current_out + @$row->current_adjust);
                    // =========================== End Calculation ====================

$objPHPExcel->getActiveSheet()->setCellValue('A' . $idx,++$i);
$objPHPExcel->getActiveSheet()->setCellValue('B' . $idx,$row->stsout_date_out);

     if($check_pro_id !=$row->stpron_id) {
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $idx,$row->stpron_name_kh);
    $merge_end=$idx+$row->row_span-1;
    $objPHPExcel->getActiveSheet()->mergeCells("C$idx:C$merge_end");
     }

    if($check_pro_id !=$row->stpron_id) {
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $idx,$row->stpron_name_vn);
    $merge_end=$idx+$row->row_span-1;
    $objPHPExcel->getActiveSheet()->mergeCells("D$idx:D$merge_end");
     }

     if($check_pro_id !=$row->stpron_id) {
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $idx,$row->stpron_code);
    $merge_end=$idx+$row->row_span-1;
    $objPHPExcel->getActiveSheet()->mergeCells("E$idx:E$merge_end");
     }

      if($check_pro_id !=$row->stpron_id) {
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $idx,$result_cost);
    $merge_end=$idx+$row->row_span-1;
    $objPHPExcel->getActiveSheet()->mergeCells("F$idx:F$merge_end");
     }
     $objPHPExcel->getActiveSheet()->setCellValue('G' . $idx,$row->stman_name);

     if($row->locaton_id=="0")  {
                        
    $objPHPExcel->getActiveSheet()->setCellValue('H' . $idx,"រោងចក្រ");
                            
                          }
                        else if($row->locaton_id=="1") {
                           
    $objPHPExcel->getActiveSheet()->setCellValue('H' . $idx,"រណ្ដៅ");
                        }
                        else if($row->locaton_id=="2") {
                            
    $objPHPExcel->getActiveSheet()->setCellValue('H' . $idx,"រោងជាង");
                        }
                        else {
   $objPHPExcel->getActiveSheet()->setCellValue('H' . $idx,"");
                        }


if($check_pro_id !=$row->stpron_id) {
    $objPHPExcel->getActiveSheet()->setCellValue('I' . $idx,$row->current_out);
    $merge_end=$idx+$row->row_span-1;
    $objPHPExcel->getActiveSheet()->mergeCells("I$idx:I$merge_end");
     }


$objPHPExcel->getActiveSheet()->setCellValue('J' . $idx,$row->st_out_check);

if($check_pro_id !=$row->stpron_id) {
    $objPHPExcel->getActiveSheet()->setCellValue('K' . $idx,$v_begining_bal_qty);
    $merge_end=$idx+$row->row_span-1;
    $objPHPExcel->getActiveSheet()->mergeCells("K$idx:K$merge_end");
     }

if($check_pro_id !=$row->stpron_id) {
    $objPHPExcel->getActiveSheet()->setCellValue('L' . $idx,$v_begining_bal_price);
    $merge_end=$idx+$row->row_span-1;
    $objPHPExcel->getActiveSheet()->mergeCells("L$idx:L$merge_end");
     }

 $objPHPExcel->getActiveSheet()->setCellValue('M' . $idx,$row->stsout_note);
 $objPHPExcel->getActiveSheet()->setCellValue('N' . $idx,$row->stsadj_date_record);
if($check_pro_id !=$row->stpron_id) {
    $objPHPExcel->getActiveSheet()->setCellValue('O' . $idx,$row->current_adjust);
    $merge_end=$idx+$row->row_span-1;
    $objPHPExcel->getActiveSheet()->mergeCells("O$idx:O$merge_end");
     }


    $objPHPExcel->getActiveSheet()->setCellValue('P' . $idx,$row->stsadj_note);
    $objPHPExcel->getActiveSheet()->setCellValue('Q' . $idx,$row->ajust_check);
   if($check_pro_id !=$row->stpron_id) {
    $objPHPExcel->getActiveSheet()->setCellValue('R' . $idx,$v_last_qty);
    $merge_end=$idx+$row->row_span-1;
    $objPHPExcel->getActiveSheet()->mergeCells("R$idx:R$merge_end");
     }
     








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

                        $check_pro_id=$row->stpron_id;












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