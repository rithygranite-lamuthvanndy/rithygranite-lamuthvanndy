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
$objPHPExcel->getActiveSheet()->setCellValue('G' . 4, 'លេខ PO');
$objPHPExcel->getActiveSheet()->setCellValue('H' . 4, 'ទីតាំងទិញ');

// Header
$objPHPExcel->getActiveSheet()->setCellValue('A' . 5, 'N°');
$objPHPExcel->getActiveSheet()->setCellValue('B' . 5, 'Description');
$objPHPExcel->getActiveSheet()->setCellValue('C' . 5, 'ID');
$objPHPExcel->getActiveSheet()->setCellValue('D' . 5, 'Price');
$objPHPExcel->getActiveSheet()->setCellValue('E' . 5, 'Section');
$objPHPExcel->getActiveSheet()->setCellValue('F' . 5, 'QTY');
$objPHPExcel->getActiveSheet()->setCellValue('G' . 5, 'PO');
$objPHPExcel->getActiveSheet()->setCellValue('H' . 5, 'MUA');


// merge column
// $objPHPExcel->getActiveSheet()->mergeCells('A8:A9');
// $objPHPExcel->getActiveSheet()->getStyle('A8:A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

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

     while ($rows = mysqli_fetch_object($get_data)) {
      $truck_id=$rows->id;
      $machin_id=$rows->truck_machin_id;
     if($track_name !=$rows->name) {
        ++$status_track;
        $track_name=$rows->name;
        $is_truck=true;

         }
    else {
        $is_truck =false;
    }



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