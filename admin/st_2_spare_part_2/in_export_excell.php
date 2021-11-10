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
} else {
    $v_date_start = date('Y-m-01');
    $v_date_end = date('Y-m-t');
}
    $v_sql = "SELECT A.*,B.stca_name,B.stca_code,C.stun_name,B.stca_id,E.stsout_date_out,H.stsin_letter_no,
    H.stsin_req_no,D.locaton_id,F.name_vn as machine_name,D.out_qty,C.stun_name,H.stsin_id,H.stsin_date_in,
     D.std_id,E.stsout_date_out,G.in_qty,
     (G.in_qty*G.in_price_vn/H.stsin_exchange_rate)+(G.in_qty*G.in_price_dollar) AS price_qty,I.stsup_name,
                (
                    (
                        SELECT IFNULL(SUM(in_qty),0)
                        FROM tbl_st_stock_in AS AA 
                        LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                        WHERE AA.stsin_date_in>'{$v_date_start}'
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
                        WHERE AA.stsin_date_in>'{$v_date_start}'
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
                LEFT JOIN tbl_st_stock_out_detail AS D ON D.pro_id=A.stpron_id
                LEFT JOIN tbl_st_stock_out AS E ON E.stsout_id=D.stsout_id
                LEFT JOIN tbl_st_track_machine_list AS F ON F.id=D.track_mac_id
                LEFT JOIN tbl_st_stock_in_detail AS G ON G.pro_id=A.stpron_id
                LEFT JOIN tbl_st_stock_in AS H ON H.stsin_id=G.stsin_id
                INNER JOIN tbl_st_branch_list AS I ON I.stsup_id=D.locaton_id
               

                WHERE A.stpron_material_type='$_SESSION[status]' AND H.stsin_date_in BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                AND E.stsout_date_out BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                  GROUP BY G.std_id
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
                )<>0  ORDER BY B.stca_code ASC,A.stpron_code ASC
                ";
//echo $v_sql;
$get_data = $connect->query($v_sql);

// exit($v_sql);

$v_br='<br>';
$v_sp='&nbsp&nbsp;';
$i=0;
$idx=7;
// header text
$today=date("Y-m-d");
if($v_date_start==$today) {
    $v_date_start=date('Y-m-01');
}



$objPHPExcel->getActiveSheet()->setCellValue('E' . 1,'តារាងជួសជុលមិនអចិន្រ្ដៃយ៍'.' '.date('d/m/Y', strtotime($v_date_start)).'-'. date('d/m/Y', strtotime($v_date_end)));
$objPHPExcel->getActiveSheet()->setCellValue('E' . 2, 'Bảng Nhập Kho Vật tư Sửa Chữa Hàng Ngày');
// Header
$objPHPExcel->getActiveSheet()->setCellValue('A' . 4, 'N');
$objPHPExcel->getActiveSheet()->setCellValue('B' . 4, 'ថ្ងៃខែ');
$objPHPExcel->getActiveSheet()->setCellValue('C' . 4, 'លេខសំណើរ');
$objPHPExcel->getActiveSheet()->setCellValue('D' . 4, 'លេខប័ណ្ណ');
$objPHPExcel->getActiveSheet()->setCellValue('E' . 4, 'កូដ');
$objPHPExcel->getActiveSheet()->setCellValue('F' . 4, 'តំបន់');
$objPHPExcel->getActiveSheet()->setCellValue('G' . 4, 'គ្រឿងចក្រឬម៉ាស៊ីន');

$objPHPExcel->getActiveSheet()->setCellValue('H' . 4, 'ឈ្មោះ');
$objPHPExcel->getActiveSheet()->mergeCells('H4:I4');
$objPHPExcel->getActiveSheet()->getStyle('E4:G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

$objPHPExcel->getActiveSheet()->setCellValue('J' . 4, 'ចំនួន');
$objPHPExcel->getActiveSheet()->setCellValue('K' . 4, 'ឯកតា');
$objPHPExcel->getActiveSheet()->setCellValue('L' . 4, 'តម្លៃ');
$objPHPExcel->getActiveSheet()->mergeCells('L4:M4');
$objPHPExcel->getActiveSheet()->getStyle('E4:G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
$objPHPExcel->getActiveSheet()->setCellValue('N' . 4, 'សរុប');


// Header
$objPHPExcel->getActiveSheet()->setCellValue('A' . 5, '');
$objPHPExcel->getActiveSheet()->setCellValue('B' . 5, 'Ngày');
$objPHPExcel->getActiveSheet()->setCellValue('C' . 5, 'Số Đề Nghị');
$objPHPExcel->getActiveSheet()->setCellValue('D' . 5, 'số Phiếu');
$objPHPExcel->getActiveSheet()->setCellValue('E' . 5, 'Mã');
$objPHPExcel->getActiveSheet()->setCellValue('F' . 5, 'Khu vực');
$objPHPExcel->getActiveSheet()->setCellValue('G' . 5, 'cơ giới và máy');
$objPHPExcel->getActiveSheet()->setCellValue('H' . 5, 'VN');
$objPHPExcel->getActiveSheet()->setCellValue('I' . 5, 'KH');
$objPHPExcel->getActiveSheet()->setCellValue('J' . 5, 'số lượng');
$objPHPExcel->getActiveSheet()->setCellValue('K' . 5, 'Đơn vị');
$objPHPExcel->getActiveSheet()->setCellValue('L' . 5, 'NHẬP');
$objPHPExcel->getActiveSheet()->setCellValue('M' . 5, '$');
$objPHPExcel->getActiveSheet()->setCellValue('N' . 5, 'Tổng công');


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
                 $total_prce=0;

  while ($row = mysqli_fetch_object($get_data)) {

     if (!in_array($row->stca_name, $v_cat_name_tmp)) {
        array_push($v_cat_name_tmp, $row->stca_name);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$idx, $row->stca_code . ' - ' . $row->stca_name);
        $idx++;
    }
     $total_prce +=$row->price_qty;
    
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
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $idx, date('d/M/Y',strtotime($row->stsin_date_in)));
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $idx, $row->stsin_letter_no);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $idx, $row->stsin_req_no);
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $idx, $row->stpron_code);
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $idx, $row->stsup_name);
    $objPHPExcel->getActiveSheet()->setCellValue('G' . $idx, $row->machine_name);
    $objPHPExcel->getActiveSheet()->setCellValue('H' . $idx, $row->stpron_name_vn);
    $objPHPExcel->getActiveSheet()->setCellValue('I' . $idx, $row->stpron_name_kh);
    $objPHPExcel->getActiveSheet()->setCellValue('J' . $idx, $row->in_qty);
    $objPHPExcel->getActiveSheet()->setCellValue('K' . $idx, $row->stun_name);
    $objPHPExcel->getActiveSheet()->setCellValue('L' . $idx,($row->price_qty/$row->in_qty ?: 0));
    $objPHPExcel->getActiveSheet()->setCellValue('M' . $idx,$row->price_qty);

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

                    
    

    $idx++;

    $objPHPExcel->getActiveSheet()->setCellValue('A' . 6,"");
    $objPHPExcel->getActiveSheet()->setCellValue('B' . 6,"");
    $objPHPExcel->getActiveSheet()->setCellValue('C' . 6,"");
    $objPHPExcel->getActiveSheet()->setCellValue('D' . 6,"");
    $objPHPExcel->getActiveSheet()->setCellValue('E' . 6,"");
    $objPHPExcel->getActiveSheet()->setCellValue('F' . 6,"");
    $objPHPExcel->getActiveSheet()->setCellValue('F' . 6,"");
    $objPHPExcel->getActiveSheet()->setCellValue('G' . 6,"");
    $objPHPExcel->getActiveSheet()->setCellValue('H' . 6,"");
    $objPHPExcel->getActiveSheet()->setCellValue('I' . 6,"");
    $objPHPExcel->getActiveSheet()->setCellValue('J' . 6,"");
    $objPHPExcel->getActiveSheet()->setCellValue('K' . 6,"");
    $objPHPExcel->getActiveSheet()->setCellValue('L' . 6,"");
    $objPHPExcel->getActiveSheet()->setCellValue('M' . 6,"");
    $objPHPExcel->getActiveSheet()->setCellValue('N' . 6,$total_prce);
    
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