<?php
include_once '../../config/database.php';
include_once '../st_operation/operation.php'
?>
<?php
    
if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
    $date1=$_GET['p_date_start'];
    $date2=$_GET['p_date_end'];
    $v_date_start=$date1;
    $v_date_end=$date2;
    $condition = "E.stsout_date_out BETWEEN '$v_date_start' 
                    AND '$v_date_end' 
                    AND stock_status='6' ";


}
else {
    $v_date_start = date('Y-m-01');
    $v_date_end = date('Y-m-t');
     $condition = "DATE_FORMAT(E.stsout_date_out,'%Y-%m')='" . date('Y-m') . "'
            AND E.stock_status='6' ";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta charset="utf-8">
    <link href='https://fonts.googleapis.com/css?family=Khmer|DM+Serif+Display&display=swap' rel='stylesheet' type='text/css'>
    <style type="text/css">
        * {
            font-size: 13px;
            font-family: 'khmer', 'Time New Reman';
            -webkit-print-color-adjust: exact;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table>tbody,
        th,
        td {
            text-align: center !important;
            border: 1px solid black;
            white-space: nowrap;
            padding: 5px 10px !important;
        }

        .myTable2 thead tr th,
        .myTable2 tbody tr th,
        table tbody tr:first-child th,
        table tbody tr:last-child th,
        table tbody tr:nth-child(2) th {
            font-family: 'Khmer Moul' !important;
            background: #DDEBF7 !important;
            font-weight: bold !important;
        }

        .main_border h3,
        .main_border h4 {
            font-family: 'Khmer Moul' !important;
            text-decoration: underline;
            font-weight: bold;
            text-align: center;
        }

        tbody tr.bg-blue td {
            background: #5B9BD5 !important;
            text-align: left !important;
        }

        .mycustomtable tbody,
        .mycustomtable thead,
        .mycustomtable tfoot {
            white-space: nowrap;
        }

        .myqty {
            font-weight: bold;
        }

        .myprice {
            font-weight: bold;
            color: #FF0000 !important;
            background-color: #F2F2F2 !important;
        }

        .myavg {
            color: #39EB7C !important;
        }

        .myavg:before,
        .myprice:before {
            content: '$ ';
            padding-right: 5px;
        }

        .myborder {
            border: 2px solid black !important;
        }

        .myTable2 {
            border: 2px solid black;
            width: 70%;
        }
          .tr_report  {
            background: #F2F2DB !important;
        }
        th {
            text-align: center;
        }
    </style>
</head>
<link rel="stylesheet" href="../../print_offline/bootstrap.min.css">
<script src="../../print_offline/jquery.min.js"></script>

<body>
    <div class="main_border">
        <?php
     
      
            echo '<h3>របាយការណ៍តាមដានឧបករណ៍ជាង នឹង ម៉ាស៊ីនខា្នតតូច' . date('d/m/Y', strtotime($v_date_start)) . ' - ' . date('d/m/Y', strtotime($v_date_end)) . '</h3>';
      
        ?>
        <h4>Báo Cáo Theo Dõi Thiết Bị Và Máy Kích Thước Nhỏ</h4>
        <br>
        <!-- Table Decription -->
        <table>
            <thead>
                
                <tr style="background-color: #35baf6;">
                        <th rowspan="2">N°</th>
                        <th>ថ្ងៃដក</th>
                        <th colspan="2">ឈ្មោះសំភារៈ<br>Tên Vật Tư</th>
                        <th>កូដសំភារៈ</th>
                        <th>តម្លៃឯកតា</th>
                        <th>ឈ្មោះអ្នកដក</th>
                        <th>តំបន់ ប្រើប្រាស់</th>
                        <th>ចេញ/Out</th>
                        <th>លេខសំគាល់ ម៉ាស៊ីនឫ ឧបករណ៍ជាង</th>
                        <th colspan="2">ស្ដុកដើមគ្រា</th>
                        <th>តាមដាន</th>
                        <th>ថ្ងៃប្រគល់​ សង</th>
                        <th>ចូល/IN(Adjustment)</th>
                        <th>លេខសំគាល់ ម៉ាស៊ីនឫ ឧបករណ៍ជាង</th>
                        <th>សំគាល់បញ្ហា</th>
                        <th>ចំនួន ស្ដុកសល់ ចុងក្រោយ</th>
                       
                    </tr>
                    <tr style="background-color: #35baf6;">
                        <th>Ngày Lấy</th>
                        <th>KH</th>
                        <th>VN</th>
                        <th>Mã vật Tư</th>
                        <th>Giá</th>
                        <th>Tên Người lấy</th>
                        <th>Khu Vực</th>
                        <th>Xuất</th>
                        <th>Số Mã Máy hoặc Thiết Bị</th>
                        <th>TỒN ĐẦU</th>
                        <th>$</th>
                        <th>Ghi Chú</th>
                        <th>Ngày Trả</th>
                        <th></th>
                        <th>Số Mã Máy hoặc Thiết Bị</th>
                        <th>Ghi chú Lý do</th>
                        <th>số Lượng còn lại</th>
                    </tr>
                
            </thead>
            <tbody>
                  <?php
                    $v_sql = "SELECT A.*,B.stca_name,B.stca_code,C.stun_name,B.stca_id,
                    E.stsout_date_out,C.stun_name,F.stman_name,D.locaton_id,I.stsadj_note,
                    I.stsadj_date_record,E.st_out_check,I.ajust_check,E.stsout_id,E.stsout_note,
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
                        SELECT SUM(in_price_dollar*IFNULL(in_qty,0))
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
                                SUM(in_price_dollar)*IFNULL(SUM(in_qty),0)
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
                  SELECT 
                        COUNT(*)
                        FROM tbl_st_product_name AS AA 
                        LEFT JOIN tbl_st_stock_out_detail AS BB ON BB.pro_id=AA.stpron_id
                        LEFT JOIN tbl_st_stock_out AS CC ON CC.stsout_id=BB.stsout_id
                            WHERE CC.stsout_date_out BETWEEN '{$v_date_start}' AND '{$v_date_end}' AND AA.stpron_id=A.stpron_id
                            
                ) AS row_span,

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
                INNER JOIN tbl_st_manager_list AS F ON F.stman_id=E.stsout_man_id
                
                LEFT JOIN tbl_st_stock_adjustment_detail AS G 
                ON G.pro_id=A.stpron_id
                LEFT JOIN tbl_st_stock_adjustment AS I
                ON I.stsadj_code=E.stsout_letter_no
                WHERE {$condition} GROUP BY D.std_id
                
               
            
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
//echo $v_sql;
$get_data = $connect->query($v_sql);
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

                
               $check_pro_id="";
                while ($row = mysqli_fetch_object($get_data)) {
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

                    

                        ?>
                <?php

                ?>
                 <tr>
                        <td><?php echo ++$i; ?></td>
                        <td><?php echo $row->stsout_date_out; ?></td>
                    <?php
                      if($check_pro_id !=$row->stpron_id) {
                    ?>
                      <td rowspan="<?php echo $row->row_span ?>">
                        <?php echo $row->stpron_name_kh; ?>
                          
                      </td>
                    <?php } ?>

                     <?php
                      if($check_pro_id !=$row->stpron_id) {
                    ?>
                      <td rowspan="<?php echo $row->row_span ?>">
                        <?php echo $row->stpron_name_vn; ?>
                          
                      </td>
                    <?php } ?>

                     <?php
                      if($check_pro_id !=$row->stpron_id) {
                    ?>
                      <td rowspan="<?php echo $row->row_span ?>">
                       <?php echo $row->stpron_code; ?>
                          
                      </td>
                    <?php } ?>

                     <?php
                      if($check_pro_id !=$row->stpron_id) {
                    ?>
                      <td rowspan="<?php echo $row->row_span ?>">
                       $ <?php echo number_format($result_cost, 2); ?>
                          
                      </td>
                    <?php } ?>

                    
                        
                        <td><?php echo $row->stman_name; ?></td>
                        <td>
                            <?php
                        if($row->locaton_id=="0")  {
                            echo "រោងចក្រ";
                            
                          }
                        else if($row->locaton_id=="1") {
                            echo "រណ្ដៅ";
                        }
                        else if($row->locaton_id=="2") {
                            echo "រោងជាង";
                        }
                        else {
                            echo "";
                        }

                         ?>
                        </td>
                    <?php
                      if($check_pro_id !=$row->stpron_id) {
                    ?>
                      <td rowspan="<?php echo $row->row_span ?>">
                        <?php echo $row->current_out; ?>
                          
                      </td>
                    <?php } ?>
                      <td><?php echo $row->st_out_check; ?></td>
                       <?php
                      if($check_pro_id !=$row->stpron_id) {
                    ?>
                      <td rowspan="<?php echo $row->row_span ?>">
                      <?php echo $v_begining_bal_qty; ?>
                          
                      </td>
                    <?php } ?>

                       <?php
                      if($check_pro_id !=$row->stpron_id) {
                    ?>
                      <td rowspan="<?php echo $row->row_span ?>">
                      $ <?php echo number_format($v_begining_bal_price, 2); ?>
                          
                      </td>
                    <?php } ?>


                      
                      <td><?php echo $row->stsout_note; ?></td>
                      <td><?php echo $row->stsadj_date_record; ?></td>

                        <?php
                      if($check_pro_id !=$row->stpron_id) {
                    ?>
                      <td rowspan="<?php echo $row->row_span ?>">
                     <?php echo $row->current_adjust; ?>
                          
                      </td>
                    <?php } ?>

                   
                      <td><?php echo $row->stsadj_note; ?></td>
                      <td><?php echo $row->ajust_check; ?></td>
                       <?php
                      if($check_pro_id !=$row->stpron_id) {
                    ?>
                      <td rowspan="<?php echo $row->row_span ?>">
                    <?php echo $v_last_qty; ?>
                          
                      </td>
                    <?php } ?>

                     
                       

                        
                    </tr>
                    <?php
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

                        $check_pro_id=$row->stpron_id;

                        }
                    ?>
              
               

                        
                       
                       
            </tbody>
        </table>

        <br>

       
       
    </div>
  
    <script type="text/javascript">
        $(document).ready(function () {
            window.print();
        });
        setTimeout(function(){
           window.close();
        },1000);
    </script>
</body>

</html>