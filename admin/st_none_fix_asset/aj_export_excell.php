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
$objPHPExcel->getActiveSheet()->getStyle('G')
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
 if(isset($_GET['p_date_start'])&&isset($_GET['p_date_end'])){
    $v_date_start=$_GET['p_date_start'];
    $v_date_end=$_GET['p_date_end'];
    $condition="stsadj_date_record BETWEEN '$v_date_start' 
                AND '$v_date_end' 
                AND stsadj_status={$_SESSION['status']}";
    $sql="SELECT
        A.*,C.*,B.*
        FROM tbl_st_stock_adjustment AS A 
        LEFT JOIN tbl_st_stock_adjustment_detail AS B ON A.stsadj_id=B.stsadj_id
        LEFT JOIN tbl_st_product_name AS C On B.pro_id=C.stpron_id
        WHERE {$condition} GROUP BY B.id";
        $get_data=$connect->query($sql);


    $v_sql_beg="
            SELECT IFNULL(SUM(qty_adjust),0) AS old_qty
            FROM tbl_st_stock_adjustment AS AA 
            LEFT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
            WHERE AA.stsadj_date_record<'{$v_date_start}'";
    $get_data_beg=$connect->query($v_sql_beg);
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


          
        
$objPHPExcel->getActiveSheet()->setCellValue('E' . 1, 'តារាងកែប្រែស្ដុកសំភារៈផ្កត់ផ្គង់ក្នុងរណ្ដៅប្រចាំថ្ងៃ'.' '.date('d/m/Y', strtotime($v_date_start)).'-'. date('d/m/Y', strtotime($v_date_end)));
$objPHPExcel->getActiveSheet()->setCellValue('E' . 2, 'Bảng Nhập Kho Vật tư Nhà Máy Hàng Ngày');
// Header
$objPHPExcel->getActiveSheet()->setCellValue('A' . 4, 'N');
$objPHPExcel->getActiveSheet()->setCellValue('B' . 4, 'ថ្ងៃខែ');
$objPHPExcel->getActiveSheet()->setCellValue('C' . 4, 'លេខប័ណ្');
$objPHPExcel->getActiveSheet()->setCellValue('D' . 4, 'កូដ');
$objPHPExcel->getActiveSheet()->setCellValue('E' . 4, 'Tền');
$objPHPExcel->getActiveSheet()->setCellValue('F' . 4, 'ឈ្មោះ');
$objPHPExcel->getActiveSheet()->setCellValue('G' . 4, 'ចំនួន');
$objPHPExcel->getActiveSheet()->setCellValue('H' . 4, 'សំគាល់');



// Header
$objPHPExcel->getActiveSheet()->setCellValue('A' . 5, '');
$objPHPExcel->getActiveSheet()->setCellValue('B' . 5, 'Ngày');
$objPHPExcel->getActiveSheet()->setCellValue('C' . 5, 'Số Đề Nghị');
$objPHPExcel->getActiveSheet()->setCellValue('D' . 5, 'Mã');
$objPHPExcel->getActiveSheet()->setCellValue('E' . 5, 'VN');
$objPHPExcel->getActiveSheet()->setCellValue('F' . 5, 'KH');
$objPHPExcel->getActiveSheet()->setCellValue('G' . 5, 'Đơn vị');
$objPHPExcel->getActiveSheet()->setCellValue('H' . 5, 'Ghi chú');
  $i=1;

    while ($row = mysqli_fetch_object($get_data)) {
   
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $idx,$i++);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $idx, date('d/M/Y',strtotime($row->stsadj_date_record)));
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $idx, $row->stsadj_code);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $idx, $row->stpron_code);
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $idx, $row->stpron_name_vn);
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $idx, $row->stpron_name_kh);
    $objPHPExcel->getActiveSheet()->setCellValue('G' . $idx, $row->qty_adjust);
    $objPHPExcel->getActiveSheet()->setCellValue('H' . $idx, $row->stsadj_note);
   
    

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