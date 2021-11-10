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
$objPHPExcel->getActiveSheet()->getStyle('C')
->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1); 
$objPHPExcel->getActiveSheet()->getStyle('D')
->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1); 
$objPHPExcel->getActiveSheet()->getStyle('E')
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
$objPHPExcel->getActiveSheet()->getStyle('O')
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
                WHERE A.stpron_material_type='$_SESSION[status]'
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
$idx=6;
// header text
$today=date("Y-m-d");
if($v_date_start==$today) {
    $v_date_start=date('Y-m-01');
}
$objPHPExcel->getActiveSheet()->setCellValue('E' . 1, 'សម្ភារប្រើប្រាស់នៅក្នុងរណ្ដៅរ៉ែ'.' '.date('d/m/Y', strtotime($v_date_start)).'-'. date('d/m/Y', strtotime($v_date_end)));
$objPHPExcel->getActiveSheet()->setCellValue('E' . 2, 'VẬT TƯ SỬ DỤNG TRONG Mỏ - THÁNG'.' '.date('d/m/Y', strtotime($v_date_start)).'-'. date('d/m/Y', strtotime($v_date_end)));
// Header
$objPHPExcel->getActiveSheet()->setCellValue('A' . 4, 'កូដ');
$objPHPExcel->getActiveSheet()->setCellValue('B' . 4, 'ឈ្មោះសំភារៈ');
$objPHPExcel->getActiveSheet()->setCellValue('C' . 4, 'ឈ្មោះសំភារៈ');
$objPHPExcel->getActiveSheet()->setCellValue('D' . 4, 'តម្លៃ/មធម្យភាគ');
$objPHPExcel->getActiveSheet()->setCellValue('E' . 4, 'ស្ដុកដើមគ្រា');
$objPHPExcel->getActiveSheet()->setCellValue('F' . 4, 'ស្ដុកដើមគ្រា');
$objPHPExcel->getActiveSheet()->setCellValue('G' . 4, 'ស្ដុកដើមគ្រា');
$objPHPExcel->getActiveSheet()->setCellValue('H' . 4, 'ស្ដុកចូល');
$objPHPExcel->getActiveSheet()->setCellValue('I' . 4, 'ស្ដុកចូល');
$objPHPExcel->getActiveSheet()->setCellValue('J' . 4, 'ស្ដុកចេញ');
$objPHPExcel->getActiveSheet()->setCellValue('K' . 4, 'ស្ដុកចេញ');
$objPHPExcel->getActiveSheet()->setCellValue('L' . 4, 'ស្ដុកកែតម្រូវ');
$objPHPExcel->getActiveSheet()->setCellValue('M' . 4, 'ស្ដុកកែតម្រូវ');
$objPHPExcel->getActiveSheet()->setCellValue('N' . 4, 'ស្ដុកចុងគ្រា');
$objPHPExcel->getActiveSheet()->setCellValue('O' . 4, 'ស្ដុកចុងគ្រា');
// Header
$objPHPExcel->getActiveSheet()->setCellValue('A' . 5, 'Mã');
$objPHPExcel->getActiveSheet()->setCellValue('B' . 5, 'Tền Vật Tư');
$objPHPExcel->getActiveSheet()->setCellValue('C' . 5, 'KH');
$objPHPExcel->getActiveSheet()->setCellValue('D' . 5, 'GÍA USD/Trung bình');
$objPHPExcel->getActiveSheet()->setCellValue('E' . 5, 'TỒN ĐẦU');
$objPHPExcel->getActiveSheet()->setCellValue('F' . 5, 'TỒN ĐẦU');
$objPHPExcel->getActiveSheet()->setCellValue('G' . 5, '	$');
$objPHPExcel->getActiveSheet()->setCellValue('H' . 5, 'XUẤT');
$objPHPExcel->getActiveSheet()->setCellValue('I' . 5, '$');
$objPHPExcel->getActiveSheet()->setCellValue('J' . 5, 'NHẬP');
$objPHPExcel->getActiveSheet()->setCellValue('K' . 5, '$');
$objPHPExcel->getActiveSheet()->setCellValue('L' . 5, 'Đã sửa');
$objPHPExcel->getActiveSheet()->setCellValue('M' . 5, '$');
$objPHPExcel->getActiveSheet()->setCellValue('N' . 5, 'TỒN');
$objPHPExcel->getActiveSheet()->setCellValue('O' . 5, '$');

$v_cat_name_tmp = [];
$v_arr_summary = [];
while ($row = mysqli_fetch_object($get_data)) {
    if (!in_array($row->stca_name, $v_cat_name_tmp)) {
        array_push($v_cat_name_tmp, $row->stca_name);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$idx, $row->stca_code . ' - ' . $row->stca_name);
        $idx++;
    }
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

    $objPHPExcel->getActiveSheet()->setCellValue('A' . $idx, $row->stpron_code);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $idx, $row->stpron_name_vn);
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $idx, $row->stpron_name_kh);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $idx, ($result_cost));
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $idx, $v_begining_bal_qty);
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $idx, $row->stun_name);
    $objPHPExcel->getActiveSheet()->setCellValue('G' . $idx, ($v_begining_bal_price));
    $objPHPExcel->getActiveSheet()->setCellValue('H' . $idx, $v_current_in_qty);
    $objPHPExcel->getActiveSheet()->setCellValue('I' . $idx, ($v_current_in_price));
    $objPHPExcel->getActiveSheet()->setCellValue('J' . $idx, ($row->current_out ?: 0));
    $objPHPExcel->getActiveSheet()->setCellValue('K' . $idx, ($result_cost * $row->current_out));
    $objPHPExcel->getActiveSheet()->setCellValue('L' . $idx, ($row->current_adjust ?: 0));
    $objPHPExcel->getActiveSheet()->setCellValue('M' . $idx, ($result_cost * $row->current_adjust));
    $objPHPExcel->getActiveSheet()->setCellValue('N' . $idx, $v_last_qty);
    $objPHPExcel->getActiveSheet()->setCellValue('O' . $idx, ($v_last_qty * $result_cost));

    $idx++;
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

 $v_total_beg = 0;
                $v_total_in = 0;
                $v_total_out = 0;
                $v_total_adjust = 0;
                $v_total_end = 0;

                $j = 1;

$header_bootom=$idx+3;
$objPHPExcel->getActiveSheet()->setCellValue('A' . $header_bootom, 'N°');
$objPHPExcel->getActiveSheet()->setCellValue('B' . $header_bootom, 'DESCRIPTION');
$objPHPExcel->getActiveSheet()->setCellValue('C' . $header_bootom, 'BEGINNING');
$objPHPExcel->getActiveSheet()->setCellValue('D' . $header_bootom, 'IN (NHẬP)');
$objPHPExcel->getActiveSheet()->setCellValue('E' . $header_bootom, 'OUT (XUẤT)');
$objPHPExcel->getActiveSheet()->setCellValue('F' . $header_bootom, 'ADJUST (XUẤT)');
$objPHPExcel->getActiveSheet()->setCellValue('G' . $header_bootom, 'END (TỒN)');
$in_plus=$header_bootom+1;
 $v_sql = "SELECT * FROM tbl_st_category_list WHERE material_type_id='$_SESSION[status]'";
                $v_result_summary = $connect->query($v_sql);
                while ($row_summary = mysqli_fetch_object($v_result_summary)) {
                    $v_arr_result = summaryMaterial($row_summary->stca_id, $v_arr_summary);
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $in_plus, $j++);
$objPHPExcel->getActiveSheet()->setCellValue('B' . $in_plus, $row_summary->stca_name);
$objPHPExcel->getActiveSheet()->setCellValue('C' . $in_plus, ($v_arr_result['t_price_beg']));
$objPHPExcel->getActiveSheet()->setCellValue('D' . $in_plus, ($v_arr_result['t_price_in']));
$objPHPExcel->getActiveSheet()->setCellValue('E' . $in_plus, ($v_arr_result['t_price_out']));
$objPHPExcel->getActiveSheet()->setCellValue('F' . $in_plus, ($v_arr_result['t_price_adjust']));
$objPHPExcel->getActiveSheet()->setCellValue('G' . $in_plus, ($v_arr_result['t_price_end']));
                    $v_total_beg += $v_arr_result['t_price_beg'];
                    $v_total_in += $v_arr_result['t_price_in'];
                    $v_total_out += $v_arr_result['t_price_out'];
                    $v_total_adjust += $v_arr_result['t_price_adjust'];
                    $v_total_end += $v_arr_result['t_price_end'];


$in_plus++;
                  
}
$in_plus_total=$in_plus+0;

$ind_footer_1=$in_plus_total+2;
$ind_footer_2=$in_plus_total+5;
$objPHPExcel->getActiveSheet()->setCellValue('B' . $in_plus_total,'CỘNG/សរុប');
$objPHPExcel->getActiveSheet()->setCellValue('C' . $in_plus_total, ($v_total_beg));
$objPHPExcel->getActiveSheet()->setCellValue('D' . $in_plus_total, ($v_total_in));
$objPHPExcel->getActiveSheet()->setCellValue('E' . $in_plus_total,($v_total_out));
$objPHPExcel->getActiveSheet()->setCellValue('F' . $in_plus_total,($v_total_adjust));
$objPHPExcel->getActiveSheet()->setCellValue('G' . $in_plus_total, ($v_total_end));


$objPHPExcel->getActiveSheet()->setCellValue('A' . $ind_footer_1,'GIÁM ĐỐC MỎ');
$objPHPExcel->getActiveSheet()->setCellValue('D' . $ind_footer_1,'LẬP BẢNG');
$objPHPExcel->getActiveSheet()->setCellValue('G' . $ind_footer_1,'THỦ KHO');

$objPHPExcel->getActiveSheet()->setCellValue('A' . $ind_footer_2,'VÕ VĂN LỰC');
$objPHPExcel->getActiveSheet()->setCellValue('D' . $ind_footer_2,'LẬP BẢNG');
$objPHPExcel->getActiveSheet()->setCellValue('G' . $ind_footer_2,'NUYÊN THANH BÌNH');
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