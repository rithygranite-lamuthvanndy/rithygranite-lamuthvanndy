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
$objPHPExcel->getActiveSheet()->getStyle('M')
->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1); 
$objPHPExcel->getActiveSheet()->getStyle('N')
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
    $txt_category=@$_GET['cate_id'];
        if($txt_category !="") {
            $txt_category=" AND  cate_id ='$txt_category' ";
        }
        else {
            $txt_category='';
        }
} else {
    $v_date_start = date('Y-m-01');
    $v_date_end = date('Y-m-t');
    $txt_category='';
}
   $v_sql = "SELECT * FROM tbl_op_acc_history_purchase_list 
            INNER JOIN tbl_acc_unit_list ON 
            tbl_acc_unit_list.uni_id=tbl_op_acc_history_purchase_list.unit_id
                           
                            WHERE DATE_FORMAT(buy_date,'%Y-%m-%d') BETWEEN '$v_date_start' AND '$v_date_end' 
                            $txt_category
                         ORDER BY cate_id ASC,pro_name_kh ASC
                ";
//echo $v_sql;
$get_data = $connect->query($v_sql);

// exit($v_sql);

$v_br='<br>';
$v_sp='&nbsp&nbsp;';
$i=0;
$idx=5;
// header text
$today=date("Y-m-d");
if($v_date_start==$today) {
    $v_date_start=date('Y-m-01');
}



$objPHPExcel->getActiveSheet()->setCellValue('E' . 1,'Price History List of Purchase'.' '.date('d/m/Y', strtotime($v_date_start)).'-'. date('d/m/Y', strtotime($v_date_end)));
// Header
$objPHPExcel->getActiveSheet()->setCellValue('A' . 4, 'N');
$objPHPExcel->getActiveSheet()->setCellValue('B' . 4, 'Date Buy');
$objPHPExcel->getActiveSheet()->setCellValue('C' . 4, 'Item Name');
$objPHPExcel->getActiveSheet()->setCellValue('D' . 4, 'Qty');
$objPHPExcel->getActiveSheet()->setCellValue('E' . 4, 'Unit');
$objPHPExcel->getActiveSheet()->setCellValue('F' . 4, 'Price');
$objPHPExcel->getActiveSheet()->setCellValue('G' . 4, 'Amount');



// Header

 $v_cat_name_tmp = [];
  while ($row = mysqli_fetch_object($get_data)) {   

    if (!in_array($row->cate_id, $v_cat_name_tmp)) {
                                 $i = 0;
                                array_push($v_cat_name_tmp, $row->cate_id);
                                    if($row->cate_id=="1") {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $idx,"សំភារៈផលិត");
                                     }
                                     else if($row->cate_id=="2") {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $idx,"គ្រឿងបន្លាស់");
                                     }
                                      else if($row->cate_id=="3") {
                                       
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $idx,"សំភារៈរោងជាង");
                                     }
                                      else if($row->cate_id=="4") {
                                        
               $objPHPExcel->getActiveSheet()->setCellValue('A' . $idx,"សំភារៈការិយាល័យ");
                                        
                                     }
                                     else {
                                        
               $objPHPExcel->getActiveSheet()->setCellValue('A' . $idx,"");
                                     }
                                      $idx++;
                               
                            }
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $idx,++$i);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $idx, date('d/M/Y',strtotime($row->buy_date)));
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $idx, $row->pro_name_kh.' '.$row->pro_name_vn);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $idx, $row->qty);
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $idx, $row->uni_name);
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $idx, $row->price);
    $objPHPExcel->getActiveSheet()->setCellValue('G' . $idx, $row->amount);
    
                
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