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
 if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
    $v_date_start = $_GET['p_date_start'];
    $v_date_end = $_GET['p_date_end'];
    $condition = "stsin_date_in BETWEEN '$v_date_start' 
                AND '$v_date_end' 
                AND stock_status={$_SESSION['status']}";
    $sql = "SELECT
        A.*,C.*,B.supsi_name,stun_name,stpron_code,stpron_name_vn,stpron_name_kh,
        (C.in_qty*C.in_price_dollar) AS total_amo
        FROM tbl_st_stock_in AS A 
        LEFT JOIN tbl_sup_supplier_info AS B ON A.stsin_supp_id=B.supsi_id
        LEFT JOIN tbl_st_stock_in_detail AS C ON A.stsin_id=C.stsin_id
        LEFT JOIN tbl_st_unit_list AS D On C.in_qty=D.stun_id
        LEFT JOIN tbl_st_product_name AS E On C.pro_id=E.stpron_id
        WHERE {$condition} GROUP BY C.std_id,C.stsin_id";
    $get_data = $connect->query($sql);


    $v_sql_beg = "
            SELECT IFNULL(SUM(in_qty),0) AS old_qty
            FROM tbl_st_stock_in AS AA 
            LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
            WHERE AA.stsin_date_in<'{$v_date_start}'
            AND stock_status={$_SESSION['status']}";
    $get_data_beg = $connect->query($v_sql_beg);
}

// exit($v_sql);

$v_br='<br>';
$v_sp='&nbsp&nbsp;';
$i=0;
$idx=6;
// header text
$today=date("Y-m-d");
if($v_date_start==$today) {
    $v_date_start=date('Y-m-01');
}



$objPHPExcel->getActiveSheet()->setCellValue('E' . 1,'តារាងបញ្ចូលស្ដុកប្រេងប្រចាំថ្ងៃ'.' '.date('d/m/Y', strtotime($v_date_start)).'-'. date('d/m/Y', strtotime($v_date_end)));
$objPHPExcel->getActiveSheet()->setCellValue('E' . 2, 'Bảng Nhập Kho dầu nhớt Hàng Ngày');
// Header
$objPHPExcel->getActiveSheet()->setCellValue('A' . 4, 'N');
$objPHPExcel->getActiveSheet()->setCellValue('B' . 4, 'ថ្ងៃខែ');
$objPHPExcel->getActiveSheet()->setCellValue('C' . 4, 'លេខសំណើរ');
$objPHPExcel->getActiveSheet()->setCellValue('D' . 4, 'អ្នកផ្គត់ផ្គង់');
$objPHPExcel->getActiveSheet()->setCellValue('E' . 4, 'កូដ');
$objPHPExcel->getActiveSheet()->setCellValue('F' . 4, 'Tền');
$objPHPExcel->getActiveSheet()->setCellValue('G' . 4, 'ឈ្មោះ');

$objPHPExcel->getActiveSheet()->setCellValue('H' . 4, 'សំគាល់/ឯកតា');
$objPHPExcel->getActiveSheet()->setCellValue('I' . 4, 'ចំនួន/លីត្រ');
$objPHPExcel->getActiveSheet()->setCellValue('J' . 4, 'តម្លៃ/L');
$objPHPExcel->getActiveSheet()->setCellValue('K' . 4, 'សរុប');


// Header
$objPHPExcel->getActiveSheet()->setCellValue('A' . 5, '');
$objPHPExcel->getActiveSheet()->setCellValue('B' . 5, 'Ngày');
$objPHPExcel->getActiveSheet()->setCellValue('C' . 5, 'Số Đề Nghị');
$objPHPExcel->getActiveSheet()->setCellValue('D' . 5, 'nhà cung cấp');
$objPHPExcel->getActiveSheet()->setCellValue('E' . 5, 'Mã');
$objPHPExcel->getActiveSheet()->setCellValue('F' . 5, 'VN');
$objPHPExcel->getActiveSheet()->setCellValue('G' . 5, 'KH');
$objPHPExcel->getActiveSheet()->setCellValue('H' . 5, 'Ghi Chú/Đơn vị');
$objPHPExcel->getActiveSheet()->setCellValue('I' . 5, 'số lưởng/L');
$objPHPExcel->getActiveSheet()->setCellValue('J' . 5, 'Giá USD/L');
$objPHPExcel->getActiveSheet()->setCellValue('K' . 5, 'Tổng công');



  $i=1;

  while ($row = mysqli_fetch_object($get_data)) {
   
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $idx,$i++);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $idx, date('d/M/Y',strtotime($row->stsin_date_in)));
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $idx, $row->stsin_letter_no);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $idx, $row->stsin_req_no);
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $idx, $row->stpron_code);
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $idx, $row->stpron_name_vn);
    $objPHPExcel->getActiveSheet()->setCellValue('G' . $idx, $row->stpron_name_kh);
    $objPHPExcel->getActiveSheet()->setCellValue('H' . $idx, $row->in_qty);
    $objPHPExcel->getActiveSheet()->setCellValue('I' . $idx, $row->stun_name);
    $objPHPExcel->getActiveSheet()->setCellValue('J' . $idx, $row->in_price_dollar);
    $objPHPExcel->getActiveSheet()->setCellValue('K' . $idx,($row->total_amo));
   
    

    $idx++;
    
}

// end bootom
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