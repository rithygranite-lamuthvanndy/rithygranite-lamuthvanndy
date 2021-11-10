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
$objPHPExcel->getActiveSheet()->getStyle('I')
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
    $condition = "stsout_date_out BETWEEN '$v_date_start' 
                AND '$v_date_end' 
                AND stock_status={$_SESSION['status']}";
    $sql = "SELECT
        A.*,C.*,B.stman_name,stun_name,stpron_code,stpron_name_vn,stpron_name_kh,
        F.name_vn AS track_machine,
        (
            CASE C.locaton_id
                WHEN 0 THEN 'រោងចក្រ'
                WHEN 1 THEN 'រណ្ដៅ'
                WHEN 2 THEN 'រោងជាង'
            END 
        ) AS location_name
        FROM tbl_st_stock_out AS A 
        LEFT JOIN tbl_st_manager_list AS B ON A.stsout_man_id=B.stman_id
        LEFT JOIN tbl_st_stock_out_detail AS C ON A.stsout_id=C.stsout_id
        LEFT JOIN tbl_st_unit_list AS D On C.unit_id=D.stun_id
        LEFT JOIN tbl_st_product_name AS E On C.pro_id=E.stpron_id
        LEFT JOIN tbl_st_track_machine_list AS F ON C.track_mac_id=F.id
        WHERE {$condition} GROUP BY C.std_id,C.stsout_id";
    $get_data = $connect->query($sql);


    $v_sql_beg = "
            SELECT IFNULL(SUM(out_qty),0) AS old_qty
            FROM tbl_st_stock_out AS AA 
            LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
            WHERE AA.stsout_date_out<'{$v_date_start}'
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

 


$objPHPExcel->getActiveSheet()->setCellValue('E' . 1, 'តារាងបញ្ចេញស្ដុកប្រេងប្រចាំថ្ងៃ'.' '.date('d/m/Y', strtotime($v_date_start)).'-'. date('d/m/Y', strtotime($v_date_end)));
$objPHPExcel->getActiveSheet()->setCellValue('E' . 2, 'Bảng Xuất Kho dầu Hàng Ngày');
// Header
$objPHPExcel->getActiveSheet()->setCellValue('A' . 4, 'N°');
$objPHPExcel->getActiveSheet()->setCellValue('B' . 4, 'ថ្ងៃខែ');
$objPHPExcel->getActiveSheet()->setCellValue('C' . 4, 'លេខប័ណ្ណ');
$objPHPExcel->getActiveSheet()->setCellValue('D' . 4, 'អ្នកទទួល');
$objPHPExcel->getActiveSheet()->setCellValue('E' . 4, 'កូដ');
$objPHPExcel->getActiveSheet()->setCellValue('F' . 4, 'Tền');
$objPHPExcel->getActiveSheet()->setCellValue('G' . 4, 'ឈ្មោះ');

$objPHPExcel->getActiveSheet()->setCellValue('H' . 4, 'តំបន់');
$objPHPExcel->getActiveSheet()->setCellValue('I' . 4, 'ចំនួន');
$objPHPExcel->getActiveSheet()->setCellValue('J' . 4, 'ឯកតា');
$objPHPExcel->getActiveSheet()->setCellValue('K' . 4, 'ម៉ាស៊ីន/គ្រឿងចក្រ');
$objPHPExcel->getActiveSheet()->setCellValue('L' . 4, 'សំគាល់');


// Header
$objPHPExcel->getActiveSheet()->setCellValue('A' . 5, '');
$objPHPExcel->getActiveSheet()->setCellValue('B' . 5, 'Ngày');
$objPHPExcel->getActiveSheet()->setCellValue('C' . 5, 'Số Đề Nghị');
$objPHPExcel->getActiveSheet()->setCellValue('D' . 5, 'Người Nhận');
$objPHPExcel->getActiveSheet()->setCellValue('E' . 5, 'Mã');
$objPHPExcel->getActiveSheet()->setCellValue('F' . 5, 'VN');
$objPHPExcel->getActiveSheet()->setCellValue('G' . 5, 'KH');
$objPHPExcel->getActiveSheet()->setCellValue('H' . 5, 'Khu vực');
$objPHPExcel->getActiveSheet()->setCellValue('I' . 5, 'số lượng');
$objPHPExcel->getActiveSheet()->setCellValue('J' . 5, 'Đơn vị');
$objPHPExcel->getActiveSheet()->setCellValue('K' . 5, 'Máy móc / máy móc');
$objPHPExcel->getActiveSheet()->setCellValue('L' . 5, 'Máy móc / máy móc');


  $i=1;

   while ($row = mysqli_fetch_object($get_data)) {
    if($row->std_id>0) {
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $idx,$i++);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $idx,$row->stsout_date_out);
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $idx,$row->stsout_letter_no);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $idx,$row->stman_name);
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $idx, $row->stpron_code);
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $idx, $row->stpron_name_vn);
    $objPHPExcel->getActiveSheet()->setCellValue('G' . $idx, $row->stpron_name_kh);
    $objPHPExcel->getActiveSheet()->setCellValue('H' . $idx, $row->location_name);
    $objPHPExcel->getActiveSheet()->setCellValue('I' . $idx, $row->out_qty);
    $objPHPExcel->getActiveSheet()->setCellValue('J' . $idx, $row->stun_name);
    $objPHPExcel->getActiveSheet()->setCellValue('K' . $idx, $row->track_machine);
    $objPHPExcel->getActiveSheet()->setCellValue('L' . $idx, $row->stsout_note);
    

    $idx++;
    }
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