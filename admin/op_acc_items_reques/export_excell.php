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
     $txt_items=$_GET['txt_items'];
        if($txt_items !="")   {
              $txt_items=" AND  A.rei_item_name ='$txt_items' ";
        } 
        else {
             $txt_items='';
        }
        
} else {
    $v_date_start = date('Y-m-01');
    $v_date_end = date('Y-m-t');

    $txt_items='';
}
  $v_sql = "SELECT * FROM tbl_acc_request_item  AS A
                        LEFT JOIN tbl_acc_request_form AS        B ON A.rei_number=B.req_id
                     LEFT JOIN tbl_acc_department_list AS        C ON B.dep_id=C.dep_id
                   LEFT JOIN tbl_acc_request_name_list AS        D ON B.req_request_name=D.res_id
                  LEFT JOIN tbl_acc_approved_name_list AS        E ON B.req_approved_by=E.apn_id
                  LEFT JOIN tbl_acc_pur_confirm        AS        F ON F.req_no=B.req_id
                  LEFT JOIN tbl_hr_employee_list       AS        G ON G.empl_id=F.buyer_id
                  LEFT JOIN tbl_acc_unit_list          AS        H ON H.uni_id=A.rei_unit
                  LEFT JOIN tbl_acc_type_request_list  AS        I ON I.typr_id=B.type_req_id
                            WHERE DATE_FORMAT(B.req_date,'%Y-%m-%d') BETWEEN '$v_date_start' AND '$v_date_end' $txt_items
                         ORDER BY I.typr_name ASC
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



$objPHPExcel->getActiveSheet()->setCellValue('E' . 1,'សរុបសំណើរ&សរុបចំណាយ '.' '.date('d/m/Y', strtotime($v_date_start)).'-'. date('d/m/Y', strtotime($v_date_end)));
// Header
$objPHPExcel->getActiveSheet()->setCellValue('A' . 4, 'N');
$objPHPExcel->getActiveSheet()->setCellValue('B' . 4, 'កាលបរិច្ឆេទស្នើរសុំ');
$objPHPExcel->getActiveSheet()->setCellValue('C' . 4, 'លេខសំណើរ');
$objPHPExcel->getActiveSheet()->setCellValue('D' . 4, 'ឈ្មោះនាយកដ្ឋាន');
$objPHPExcel->getActiveSheet()->setCellValue('E' . 4, 'អ្នកស្នើរសុំ');
$objPHPExcel->getActiveSheet()->setCellValue('F' . 4, 'ឯកភាពដោយ');
$objPHPExcel->getActiveSheet()->setCellValue('G' . 4, 'ទឹកប្រាក់ស្នើរសុំ');
$objPHPExcel->getActiveSheet()->setCellValue('H' . 4, 'ឈ្មោះអ្នកទិញ&អ្នកទទួល');
$objPHPExcel->getActiveSheet()->setCellValue('I' . 4, 'ប្រភេទឡាន&ម៉ាស៊ីន&ឈ្នួល');
$objPHPExcel->getActiveSheet()->setCellValue('J' . 4, 'ឈ្មោះសម្ភារៈ');
$objPHPExcel->getActiveSheet()->setCellValue('K' . 4, 'ទំហំ/លេខ');
$objPHPExcel->getActiveSheet()->setCellValue('L' . 4, 'ចំនួន');
$objPHPExcel->getActiveSheet()->setCellValue('M' . 4, 'ឯកតា');
$objPHPExcel->getActiveSheet()->setCellValue('N' . 4, 'តម្លៃរាយ');
$objPHPExcel->getActiveSheet()->setCellValue('O' . 4, 'តម្លៃសរុប');
$objPHPExcel->getActiveSheet()->setCellValue('P' . 4, 'ចំណាំសំរាប់ផ្នែកទិញ');




// Header

$v_cat_name_tmp = [];
  while ($row = mysqli_fetch_object($get_data)) {   
    if (!in_array($row->typr_name, $v_cat_name_tmp)) {
        $i = 0;
        array_push($v_cat_name_tmp, $row->typr_name);
         $objPHPExcel->getActiveSheet()->setCellValue('A'.$idx,$row->typr_name);
        $idx++;

    }
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $idx,++$i);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $idx, date('d/M/Y',strtotime($row->req_date)));
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $idx, $row->req_number);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $idx, $row->dep_name);
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $idx, $row->res_name);
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $idx, $row->apn_name);
    $objPHPExcel->getActiveSheet()->setCellValue('G' . $idx, $row->rei_price);
    $objPHPExcel->getActiveSheet()->setCellValue('H' . $idx, $row->empl_emloyee_kh.' '.$row->empl_emloyee_en);
    $objPHPExcel->getActiveSheet()->setCellValue('I' . $idx, $row->for_area);
    $objPHPExcel->getActiveSheet()->setCellValue('J' . $idx, $row->rei_item_name);
    $objPHPExcel->getActiveSheet()->setCellValue('K' . $idx, $row->rei_size);
    $objPHPExcel->getActiveSheet()->setCellValue('L' . $idx, $row->rei_qty);
    $objPHPExcel->getActiveSheet()->setCellValue('M' . $idx, $row->uni_name);
    $objPHPExcel->getActiveSheet()->setCellValue('N' . $idx, $row->rei_price);
    $objPHPExcel->getActiveSheet()->setCellValue('O' . $idx, $row->rei_qty * $row->rei_price);
     if($row->pur_id >0) {
        $objPHPExcel->getActiveSheet()->setCellValue('P' . $idx, "Done");
                               
                         }
                    else {
             $objPHPExcel->getActiveSheet()->setCellValue('P' . $idx, "Pendding");
                               
                         }

    


    
                
    $idx++;
    
}


$idxs=$idx+1;


  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
        $v_date_start = $_GET['p_date_start'];
        $v_date_end = $_GET['p_date_end'];
          $txt_items=$_GET['txt_items'];
        if($txt_items !="")   {
             $txt_items=" AND  C.rei_item_name ='$txt_items' ";
        } 
        else {
             $txt_items='';
        }
         $get_datas=$connect->query("SELECT SUM(rei_qty*rei_price) as total_price,typr_name
                             FROM tbl_acc_type_request_list  AS A
                          LEFT JOIN tbl_acc_request_form AS        B ON A.typr_id=B.type_req_id
                          LEFT JOIN tbl_acc_request_item AS        C ON C.rei_number=B.req_id
                     
                            WHERE DATE_FORMAT(B.req_date,'%Y-%m-%d') BETWEEN '$v_date_start' AND '$v_date_end' $txt_items
                            GROUP BY A.typr_name
                         ORDER BY A.typr_name ASC");
    }
    else{

      $v_date_start = date('Y-m-01');
      $v_date_end = date('Y-m-t');
      $txt_items='';

       $get_datas=$connect->query("SELECT SUM(rei_qty*rei_price) as total_price,typr_name
                             FROM tbl_acc_type_request_list  AS A
                          LEFT JOIN tbl_acc_request_form AS        B ON A.typr_id=B.type_req_id
                          LEFT JOIN tbl_acc_request_item AS        C ON C.rei_number=B.req_id
                     
                            WHERE DATE_FORMAT(B.req_date,'%Y-%m-%d') BETWEEN '$v_date_start' AND '$v_date_end'
                            GROUP BY A.typr_name
                         ORDER BY A.typr_name ASC");
       
    }

     $total_price_all=0;
       while ($rows = mysqli_fetch_object($get_datas)) {
        $total_price_all +=$rows->total_price;

        $objPHPExcel->getActiveSheet()->setCellValue('A' .$idxs,$rows->typr_name);

        $objPHPExcel->getActiveSheet()->setCellValue('B' .$idxs,$rows->total_price);

        $idxs++;

    }
     $idx_last_total=$idxs;
     $objPHPExcel->getActiveSheet()->setCellValue('A' . $idx_last_total,"សរុប");
     $objPHPExcel->getActiveSheet()->setCellValue('B' . $idx_last_total,$total_price_all);

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