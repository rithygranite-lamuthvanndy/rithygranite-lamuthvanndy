<?php
include '../../config/database.php';
include_once 'operation.php';
include_once 'function.php';

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../../plugin/Classes/PHPExcel.php';
require_once '../../plugin/Classes/PHPExcel/IOFactory.php';
// require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
if (isset($_GET['p_date_start']) && isset($_GET['p_date_end']) && isset($_GET['id']) ) {
    
    $id=$_GET['id'];
    $date1 = $_GET['p_date_start'];
    $date2 = $_GET['p_date_end'];
    $txt_truck_name_id=$id;
            if($txt_truck_name_id !="") {
                $truck_id_search=$txt_truck_name_id;
                $query_truck='WHERE A.id='.$truck_id_search.' ';
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

$objPHPExcel->getActiveSheet()->setCellValue('E' . 1, 'តារាងតាមដានការជួសជុលគ្រឿងចក្រ'.' '.date('d/m/Y', strtotime($date1)).'-'. date('d/m/Y', strtotime($date2)));
$objPHPExcel->getActiveSheet()->setCellValue('F' . 2, 'Bảng theo gíoi sửa chưã cơ giới');
$idx=10;
$v_sql_report = "SELECT A.* 
                FROM tbl_st_track_machine_list AS A 
                $query_truck
                ";
               
    $get_data =$connect->query($v_sql_report);

    while ($rows = mysqli_fetch_object($get_data)) {
   
      $truck_id=$rows->id;
// top table

$objPHPExcel->getActiveSheet()->setCellValue('A' . 4,"ឈ្មោះគ្រឿងចក្រ :".$rows->name_vn);
$objPHPExcel->getActiveSheet()->mergeCells("A4:J4");
$objPHPExcel->getActiveSheet()->setCellValue('A' . 5,"ឈ្មោះគ្រឿងចក្រ :".$rows->date_buy);
$objPHPExcel->getActiveSheet()->mergeCells("A5:J5");
$objPHPExcel->getActiveSheet()->setCellValue('A' . 6,"ឈ្មោះគ្រឿងចក្រ :".$rows->track_price);
$objPHPExcel->getActiveSheet()->mergeCells("A6:J6");
// Header
$objPHPExcel->getActiveSheet()->setCellValue('A' . 8, 'N°');
$objPHPExcel->getActiveSheet()->setCellValue('B' . 8, 'ថ្ងៃខែឆ្នាំ');
$objPHPExcel->getActiveSheet()->setCellValue('C' . 8, 'លេខសំណើរ');
$objPHPExcel->getActiveSheet()->setCellValue('D' . 8, 'ឈ្មោះសំភារះ');
$objPHPExcel->getActiveSheet()->setCellValue('E' . 8, 'ទំហំ');
$objPHPExcel->getActiveSheet()->setCellValue('F' . 8, 'ចំនួន');
$objPHPExcel->getActiveSheet()->setCellValue('G' . 8, 'ឯកតា');
$objPHPExcel->getActiveSheet()->setCellValue('H' . 8, 'តម្លៃរាយ');
$objPHPExcel->getActiveSheet()->setCellValue('I' . 8, 'សរុប');
$objPHPExcel->getActiveSheet()->setCellValue('J' . 8, 'សរុបក្នុងខែ');
// Header
$objPHPExcel->getActiveSheet()->setCellValue('A' . 9, 'N°');
$objPHPExcel->getActiveSheet()->setCellValue('B' . 9, 'Ngày/Tháng/Năm');
$objPHPExcel->getActiveSheet()->setCellValue('C' . 9, 'Số Đề Nghị');
$objPHPExcel->getActiveSheet()->setCellValue('D' . 9, 'Tên hàng');
$objPHPExcel->getActiveSheet()->setCellValue('E' . 9, 'Kích thước');
$objPHPExcel->getActiveSheet()->setCellValue('F' . 9, 'số lưởng');
$objPHPExcel->getActiveSheet()->setCellValue('G' . 9, 'đơn vi');
$objPHPExcel->getActiveSheet()->setCellValue('H' . 9, 'giá');
$objPHPExcel->getActiveSheet()->setCellValue('I' . 9, 'Giá tông');
$objPHPExcel->getActiveSheet()->setCellValue('J' . 9, 'tông công');

// merge column
$objPHPExcel->getActiveSheet()->mergeCells('A8:A9');
$objPHPExcel->getActiveSheet()->getStyle('A8:A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



 $i = 0;
                    $v_gounp_month_year =null;
                    $v_gounp_letter_no =null;
                    
                    $v_sql_detail = "SELECT 
                                    A.stsout_date_out,A.stsout_letter_no,B.out_qty,B.pro_id,C.stpron_name_vn,
                                    DATE_FORMAT(A.stsout_date_out,'%m/%Y') AS group_month,
                                    B.out_qty,
                                    D.stun_name,B.stsout_id,A.stock_status,
                                    (
                                        SELECT 
                                        COUNT(*)
                                        FROM tbl_st_stock_out_detail AS AA 
                                        WHERE AA.track_mac_id=B.track_mac_id
                                        AND AA.stsout_id=A.stsout_id
                                    ) AS group_letter_no,
                                    (
                                        SELECT 
                                            COUNT(*)
                                        FROM tbl_st_stock_out_detail AS AA 
                                        LEFT JOIN tbl_st_stock_out AS BB ON AA.stsout_id=BB.stsout_id
                                        WHERE AA.track_mac_id=B.track_mac_id
                                        AND BB.stock_status=A.stock_status
                                        AND DATE_FORMAT(BB.stsout_date_out,'%Y-%m')=DATE_FORMAT(A.stsout_date_out,'%Y-%m')
                                    ) AS group_row_monthly
                                    FROM tbl_st_stock_out AS A 
                                    LEFT JOIN tbl_st_stock_out_detail AS B ON A.stsout_id=B.stsout_id
                                    LEFT JOIN tbl_st_product_name AS C ON B.pro_id=C.stpron_id
                                    LEFT JOIN tbl_st_unit_list AS D ON B.unit_id=D.stun_id
                                   
                                    WHERE A.stock_status='3' OR A.stock_status='5'
                                    AND B.track_mac_id='$truck_id'
                                    $date_query
                                   
                                    GROUP BY  B.std_id,MONTH(A.stsout_date_out),YEAR(A.stsout_date_out)
                                    ORDER BY A.stsout_date_out";


                    $v_result = $connect->query($v_sql_detail);
                    $status_month = 0;
                    $idx_loop=$idx+1;

                   

                    

                    
                    // getTotalMonthly($p_result);
                    
                    
                         $v_total_monthly = 0;
                         $loop_indx=1;
                         $span_x=0;
                     
                    
                    while ($row = mysqli_fetch_object($v_result)) {

                         if($row->pro_id !="") {

                         if ($v_gounp_month_year != $row->group_month) 
                         {
                            
                        ++$status_month;
                            if($i==0) {
                                $objPHPExcel->getActiveSheet()->setCellValue('A' . 10,'ខែ '.$row->group_month);
                               $idx_loop=10;
                                $objPHPExcel->getActiveSheet()->mergeCells('A10:J10');
                            }
                            else {
                                $objPHPExcel->getActiveSheet()->setCellValue('A' .$idx_loop,'ខែ '.$row->group_month);
                                 $objPHPExcel->getActiveSheet()->mergeCells('A'.$idx_loop.':J'.$idx_loop.'');


                            }
                            
                           
                             $v_gounp_month_year = $row->group_month;
                              $is_new_month = true;
                              $idx_loop +=1;
                         } 
                            else {

                                $is_new_month = false;
                                $idx_loop +=0;
                            }

                        
 $v_unit_price = getCostPerProductName($row->stsout_date_out, $row->pro_id,$row->stock_status);
                        
                         
                         $objPHPExcel->getActiveSheet()->setCellValue('A' .$idx_loop,++$i);
                         $objPHPExcel->getActiveSheet()->setCellValue('B' .$idx_loop,$row->stsout_date_out);
                          if ($v_gounp_letter_no != $row->stsout_id) {
                              $objPHPExcel->getActiveSheet()->setCellValue('C' .$idx_loop,$row->stsout_letter_no);
                             $cell_from=$row->group_letter_no;
                             $cell_to=$cell_from+$idx_loop-1;
                             if($cell_from>=2) {
                                 $objPHPExcel->getActiveSheet()->mergeCells('C'.$idx_loop.':C'.$cell_to.'');

                             }
                            
                              $v_gounp_letter_no = $row->stsout_id;
                          }

                             $objPHPExcel->getActiveSheet()->setCellValue('D' .$idx_loop,$row->stpron_name_vn);
                             $objPHPExcel->getActiveSheet()->setCellValue('E' .$idx_loop,"-");
                             $objPHPExcel->getActiveSheet()->setCellValue('F' .$idx_loop,$row->out_qty);
                             $objPHPExcel->getActiveSheet()->setCellValue('G' .$idx_loop,$row->stun_name);
                             $objPHPExcel->getActiveSheet()->setCellValue('H' .$idx_loop,$v_unit_price);
                             $objPHPExcel->getActiveSheet()->setCellValue('I' .$idx_loop,$v_unit_price * $row->out_qty);
                             $v_total_monthly += ($v_unit_price * $row->out_qty);
                             $span_x=$row->group_row_monthly;
                               $span_to=$span_x+$idx_loop-1;
                             if($span_x>=2) {
                                 $objPHPExcel->getActiveSheet()->mergeCells('J'.$idx_loop.':J'.$span_to.'');

                             }
                             if ($is_new_month)
                               

                             // $objPHPExcel->getActiveSheet()->setCellValue('J' .$idx_loop,$v_total_monthly);
     $objPHPExcel->getActiveSheet()->setCellValue("J".$idx_loop,"=SUM(I$idx_loop:I$span_to)");
                               

                        
                         ++$idx_loop;
                            }

                         }
                    $objPHPExcel->getActiveSheet()->setCellValue('I' .$idx_loop,"TOTAL:");
                    $objPHPExcel->getActiveSheet()->setCellValue('J' .$idx_loop,$v_total_monthly);

                  

 




 
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