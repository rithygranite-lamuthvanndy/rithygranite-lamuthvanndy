<?php
include '../../config/database.php';
include 'myfunction.php';
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../../plugin/Classes/PHPExcel.php';
require_once '../../plugin/Classes/PHPExcel/IOFactory.php';
// require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Silak")
                             ->setLastModifiedBy("Silak")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");

if(@$_GET['date_start']!=''&&@$_GET['date_end']!=''){
	$v_date_s = @$_GET['date_start'];
    $v_date_e = @$_GET['date_end'];
	$str="    
        SELECT * FROM (
            SELECT '1' AS statustable,A.status_type,A.date_record,A.ref_id
            FROM tbl_acc_add_tran_amount AS A 
            WHERE DATE_FORMAT(A.date_record,'%Y-%m-%d') BETWEEN '$v_date_s' AND '$v_date_e' AND p_appr='1'
            UNION
            SELECT '2' AS statustable,AA.status_type,AA.date_record,AA.ref_id
            FROM tbl_acc_add_tran_dr_cr AS AA 
            WHERE DATE_FORMAT(AA.date_record,'%Y-%m-%d') BETWEEN '$v_date_s' AND '$v_date_e'  AND p_appr='1' 
        ) AS A 
        ORDER BY A.date_record
            ";
}
else{
	$v_current_year_month = date('Y-m');
    $str="SELECT * FROM (
            SELECT '1' AS statustable,A.status_type,A.date_record,A.ref_id
            FROM tbl_acc_add_tran_amount AS A 
            WHERE DATE_FORMAT(A.date_record,'%Y-%m')='$v_current_year_month' AND p_appr='1'
            UNION
            SELECT '2' AS statustable,AA.status_type,AA.date_record,AA.ref_id
            FROM tbl_acc_add_tran_dr_cr AS AA 
            WHERE DATE_FORMAT(AA.date_record,'%Y-%m')='$v_current_year_month' AND p_appr='1'
        ) AS A 
        ORDER BY A.date_record
            ";
}
$v_br='<br>';
$v_sp='&nbsp&nbsp;';
$i=0;
$idx=2;
$get_data_main = $connect->query($str);
while ($row_main = mysqli_fetch_object($get_data_main)) {
        $main_date = $row_main->date_record;
        
        $v_ref_id=$row_main->ref_id;
        if(@$_GET['type']=='')
            $str=myDetail1($v_ref_id,$row_main->statustable,$row_main->status_type);
        else
            $str=myDetail2($v_ref_id,$row_main->statustable,$row_main->status_type,@$_GET['type']);
        $sql1=$connect->query($str);
        $v_num_row=@mysqli_num_rows($sql1);

        if($v_num_row<=0)continue;                    
        $total_debit=0;
        $total_credit=0;

        // Header
        $objPHPExcel->getActiveSheet()->setCellValue('A' . 1, 'No');
        $objPHPExcel->getActiveSheet()->setCellValue('B' . 1, 'Date Record');
        $objPHPExcel->getActiveSheet()->setCellValue('C' . 1, 'Number');
        $objPHPExcel->getActiveSheet()->setCellValue('D' . 1, 'Name');
        $objPHPExcel->getActiveSheet()->setCellValue('E' . 1, 'Description');
        $objPHPExcel->getActiveSheet()->setCellValue('F' . 1, 'Transaction Note');
        $objPHPExcel->getActiveSheet()->setCellValue('G' . 1, 'Account Number');
        $objPHPExcel->getActiveSheet()->setCellValue('H' . 1, 'Account Name');
        $objPHPExcel->getActiveSheet()->setCellValue('I' . 1, 'Debit');
        $objPHPExcel->getActiveSheet()->setCellValue('J' . 1, 'Credit');

        while ($row_detail=mysqli_fetch_object($sql1)) {
            $v_ref_no=$row_detail->entry_no;
            $v_name=$row_detail->name;
			// Add some data
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$idx, ++$i);
            // $objPHPExcel->getActiveSheet()->setCellValue('B'.$idx, date('d/m/Y', strtotime($main_date)));
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$idx, PHPExcel_Shared_Date::PHPToExcel($main_date));
            $objPHPExcel->getActiveSheet()->getStyle('B'.$idx)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$idx, $row_detail->entry_no);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$idx, $row_detail->name);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$idx, $row_detail->description);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$idx, $row_detail->tran_note);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$idx, $row_detail->accca_number);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$idx, $row_detail->accca_account_name);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$idx, $row_detail->debit);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$idx, $row_detail->credit);
            $idx++;
            // echo $idx.$v_sp.$main_date.$v_sp.$row_detail->entry_no.$v_sp.$row_detail->accca_number.$v_sp.$row_detail->accca_account_name.$v_sp.number_format($row_detail->debit,2).$v_sp.number_format($row_detail->credit,2).$v_br;
		}
    }

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Jounal');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Save Excel 2007 file
$file_name='Export_Jounal_From_'.@$v_date_s.'_To_'.@$v_date_e.'.xlsx';
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save( $file_name);
header('location: '. $file_name);
// Redirect output to a client’s web browser (Excel2007)
// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// header('Content-Disposition: attachment;filename="'.str_replace('.php', '.xlsx', __FILE__).'"');
// header('Cache-Control: max-age=0');
// // If you're serving to IE 9, then the following may be needed
// header('Cache-Control: max-age=1');
// $objWriter->save('php://output');
// exit;

// // Redirect output to a client’s web browser (Excel2007)
// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// header('Content-Disposition: attachment;filename="export_excell.xlsx"');
// header('Cache-Control: max-age=0');
// // If you're serving to IE 9, then the following may be needed
// header('Cache-Control: max-age=1');

// // If you're serving to IE over SSL, then the following may be needed
// header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
// header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
// header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
// header ('Pragma: public'); // HTTP/1.0

// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
// $objWriter->save('php://output');
// exit;
