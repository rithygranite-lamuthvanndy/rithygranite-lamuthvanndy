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


}
else {
    $v_date_start = date('Y-m-01');
    $v_date_end = date('Y-m-t');
}
?>

<?php

  
    function calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,$type)
   {
   global $connect; 
                               
                       $v_sql1 = "SELECT A.*,B.stca_name,B.stca_code,C.stun_name,B.stca_id,
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
                        SELECT SUM(
                                    (IFNULL(in_qty,0)*in_price_vn/stsin_exchange_rate)
                                        +(in_price_dollar*IFNULL(in_qty,0))
                                    )
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
                WHERE A.stpron_material_type='1'
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
// echo $v_sql;
$get_data1 =$connect->query($v_sql1);
 $i = 0;
                $v_cat_name_tmp1 = [];

                $v_total_price_beg1 = 0;
                $v_total_price_in1 = 0;
                $v_total_qty_in1 = 0;
                $v_total_price_out1 = 0;
                $v_total_qty_out1 = 0;
                $v_total_price_adjust1 = 0;
                $v_total_qty_adjust1 = 0;
                $v_total_price_bal1 = 0;
                $v_total_qty_bal1 = 0;
                $v_arr_summary1 = [];
while ($row1 = mysqli_fetch_object($get_data1)) {
                    $v_begining_bal_qty1 = ($row1->begining_bal_qty ?: 0);
                    $v_begining_bal_price1 = round(($row1->begining_bal_price ?: 0), 2);

                    $v_arr_in1 = explode("=", $row1->current_in);
                    $v_current_in_qty1 = (@$v_arr_in1[0] ?: 0);
                    $v_current_in_price1 = round((@$v_arr_in1[1] ?: 0), 2);

                    $v_array1 = [
                        'begining_bal_price' => $v_begining_bal_price1,
                        'begining_bal_qty' => $v_begining_bal_qty1,
                        'current_in_price' => $v_current_in_price1,
                        'current_in_qty' => $v_current_in_qty1
                    ];
                    $result_cost1 = myCalCostAverage($v_array1);
                    $v_last_qty1 = ($v_begining_bal_qty1 + $v_current_in_qty1 - @$row1->current_out + @$row1->current_adjust);
                     $v_total_price_beg1 += $v_begining_bal_price1;
                    $v_total_qty_in1 += $v_current_in_qty1;
                    $v_total_price_in1 += $v_current_in_price1;
                    $v_total_price_out1 += $result_cost1 * $row1->current_out;
                    $v_total_qty_out1 += $row1->current_out;
                    $v_total_price_adjust1 += $result_cost1 * $row1->current_adjust;
                    $v_total_qty_adjust1 += $row1->current_adjust;
                    $v_total_price_bal1 += $v_last_qty1 * $result_cost1;
                    $v_total_qty_bal1 += $v_last_qty1;

                    $arr_child1 = [
                        $row1->stca_id => $row1->stca_id,
                        'price_beg' => $v_begining_bal_price1,
                        'price_in' => $v_current_in_price1,
                        'price_out' => $result_cost1 * $row1->current_out,
                        'price_adjust' => $result_cost1 * $row1->current_adjust,
                        'price_end' => $v_last_qty1 * $result_cost1
                    ];
                    array_push($v_arr_summary1, $arr_child1);

}

 $v_sql2 = "SELECT * FROM tbl_st_category_list WHERE material_type_id='1' AND stca_id='$cate_min_id' ";
                $v_result_summary1 = $connect->query($v_sql2);
                $total_begin=0;
                while ($row_summary1 = mysqli_fetch_object($v_result_summary1)) {
                  
                    $v_arr_result1 = summaryMaterial($row_summary1->stca_id, $v_arr_summary1);

                                if($type=="1") {
                                     echo number_format($v_arr_result1['t_price_beg'], 2); 
                                }
                                else if($type=="2") {
                                    echo number_format($v_arr_result1['t_price_in'], 2); 
                                }
                                else if($type=="3") {
                                    echo number_format($v_arr_result1['t_price_out'], 2); 
                                }

                                 if($type=="4") {
                                    return  $v_arr_result1['t_price_beg']; 
                                     
                                }

                                 if($type=="5") {
                                    return  $v_arr_result1['t_price_in']; 
                                     
                                }
                                 if($type=="6") {
                                    return  $v_arr_result1['t_price_out']; 
                                     
                                }
                                
                            
                             

                         }

                
             

   
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
     
      
            echo '<h3>របាយការណ៍ប្រើប្រាស់សម្ភារៈផលិតក្នុងអណ្តូងរ៉ែ ' . date('d/m/Y', strtotime($v_date_start)) . ' - ' . date('d/m/Y', strtotime($v_date_end)) . '</h3>';
      
        ?>
        <h4>BÁO CÁO VẬT TƯ CƯA TẠI MỎ ĐÁ</h4>
        <br>
        <!-- Table Decription -->
        <table>
            <thead>
                <tr>
                            <th rowspan="2">ល.រ<br>STT</th>
                            <th rowspan="2">បរិយាយ<br>Mô tả</th>
                            <th rowspan="2">ស្តុក<br>Nhập và xuất kho</th>
                            <th rowspan="2">សរុប<br>Tổng</th>
                            
             <?php
             $total_span1=0;
             $month1=0;
             $month2=0;
             $month3=0;
             if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                  $start = $month =strtotime("$date1");
                    $end = strtotime("$date2");
                    $col_span=0;
                    $total_span=0;
                    while($month <= $end)
                    {
                         $date_result=date('Y-m',$month);
                         $month = strtotime("+1 month", $month);

                         if($date_result==date('Y-01')) {
                            $col_span=1;
                            $month1=1;

                         }
                         else if($date_result==date('Y-02')) {
                            $col_span =1;
                            $month2=2;

                         }
                         else if($date_result==date('Y-03')) {
                            $col_span =1;
                            $month3=3;
                         }
                         else {
                            $col_span=0;
                         }

                         $total_span +=$col_span;
                         $total_span1=$total_span;
                    }
                     if($total_span==1) {
                        //echo '<th colspan="1">ត្រីមាសទី 1 <br>Quý 1</th>';
                        ?>
                            <th colspan="1">
                                ត្រីមាសទី 1 <br>Quý 1
                            </th>
                        <?php
                     }
                     else if($total_span==2) {
                        echo '<th colspan="2">ត្រីមាសទី 1 <br>Quý 1</th>';
                     }
                     else if($total_span==3) {
                        echo '<th colspan="3">ត្រីមាសទី 1 <br>Quý 1</th>';
                     }
                     else {

                     }

              }
              else {
                echo '<th colspan="3">ត្រីមាសទី 1 <br>Quý 1
                </th>';

              }
            ?>
                
                <!-- qery 2             -->
                            
             <?php
             $total_span2=0;
             $month4=0;
             $month5=0;
             $month6=0;
              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {

                 $start = $month =strtotime("$date1");
                    $end = strtotime("$date2");
                    $col_span=0;
                    $total_span=0;
                    while($month <= $end)
                    {
                        $date_result=date('Y-m',$month);
                         $month = strtotime("+1 month", $month);

                         if($date_result==date('Y-04')) {
                            $col_span=1;
                            $month4=4;

                         }
                         else if($date_result==date('Y-05')) {
                            $col_span =1;
                            $month5=5;
                         }
                         else if($date_result==date('Y-06')) {
                            $col_span =1;
                            $month6=6;
                         }
                         else {
                            $col_span=0;
                         }

                         $total_span +=$col_span;
                         $total_span2=$total_span;
                    }
                     if($total_span==1) {
                        echo '<th colspan="1">ត្រីមាសទី 2<br>Quý 2</th>';
                     }
                     else if($total_span==2) {
                        echo '<th colspan="2">ត្រីមាសទី 2<br>Quý 2</th>';
                     }
                     else if($total_span==3) {
                        echo '<th colspan="3">ត្រីមាសទី 2<br>Quý 2</th>';
                     }
                     else {

                     }

              }
              else {
                echo '<th colspan="3">ត្រីមាសទី 2<br>Quý 2</th>';
              }
            ?>

                            

                <!-- qery 3             -->
                            
             <?php
             $total_span3=0;
             $month7=0;
             $month8=0;
             $month9=0;
            if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {

                 $start = $month =strtotime("$date1");
                    $end = strtotime("$date2");
                    $col_span=0;
                    $total_span=0;
                    while($month <= $end)
                    {
                         $date_result=date('Y-m',$month);
                         $month = strtotime("+1 month", $month);

                         if($date_result==date('Y-07')) {
                            $col_span=1;
                            $month7=7;
                         }
                         else if($date_result==date('Y-08')) {
                            $col_span =1;
                            $month8=8;
                         }
                         else if($date_result==date('Y-09')) {
                            $col_span =1;
                            $month9=9;
                         }
                         else {
                            $col_span=0;
                         }

                         $total_span +=$col_span;
                         $total_span3 = $total_span;
                    }
                     if($total_span==1) {
                        echo '<th colspan="1">ត្រីមាសទី 3<br>Quý 3</th>';
                     }
                     else if($total_span==2) {
                        echo '<th colspan="2">ត្រីមាសទី 3<br>Quý 3</th>';
                     }
                     else if($total_span==3) {
                        echo '<th colspan="3">ត្រីមាសទី 3<br>Quý 3</th>';
                     }
                     else {

                     }

                
                }
                else {
                    echo '<th colspan="3">ត្រីមាសទី 3<br>Quý 3</th>'; 
                }
            ?>
               
                           
                  <!-- qery 4            -->
                            
            <?php
                $total_span4 = 0;
                $month10 = 0;
                $month11=0;
                $month12=0;
                if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {


                    $start = $month =strtotime("$date1");
                    $end = strtotime("$date2");
                    $col_span=0;
                    $total_span=0;
                    while($month <= $end)
                    {
                         $date_result=date('Y-m',$month);
                         $month = strtotime("+1 month", $month);

                         if($date_result==date('Y-10')) {
                            $col_span=1;
                            $month10=10;
                         }
                         else if($date_result==date('Y-11')) {
                            $col_span =1;
                            $month11=11;
                         }
                         else if($date_result==date('Y-12')) {
                            $col_span =1;
                            $month12=12;
                         }
                         else {
                            $col_span=0;
                         }

                         $total_span +=$col_span;
                         $total_span4=$total_span;
                    }
                     if($total_span==1) {
                        echo '<th colspan="1">ត្រីមាសទី 4<br>Quý 4</th>';
                     }
                     else if($total_span==2) {
                        echo '<th colspan="2">ត្រីមាសទី 4<br>Quý 4</th>';
                     }
                     else if($total_span==3) {
                        echo '<th colspan="3">ត្រីមាសទី 4<br>Quý 4</th>';
                     }
                     else {

                     }


                                     
                }
                else {
                    echo '<th colspan="3">ត្រីមាសទី 4<br>Quý 4</th>';
                }
            ?>
                       
                        </tr>

                        <tr>
                                <!-- ត្រីមាសទី 2 -->
                                <?php
                                    if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                        if($month1==1){
                                            ?>
                                                <th>1</th>
                                            <?php
                                            }
                                            if($month2==2){
                                                ?>
                                                    <th>2</th>
                                                <?php
                                            }
                                            if($month3==3){
                                                ?>
                                                    <th>3</th>
                                                <?php
                                            }
                                    }else{
                                        ?>
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                        <?php   
                                    }

                                ?>
                                <!-- ចុងត្រីមាសទី 2 -->

                                <!-- ត្រីមាសទី 2 -->
                                <?php
                                    if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                        if($month4==4){
                                            ?>
                                                <th>4</th>
                                            <?php
                                            }
                                            if($month5==5){
                                                ?>
                                                    <th>5</th>
                                                <?php
                                            }
                                            if($month6==6){
                                                ?>
                                                    <th>6</th>
                                                <?php
                                            }
                                    }else{
                                        ?>
                                            <th>4</th>
                                            <th>5</th>
                                            <th>6</th>
                                        <?php   
                                    }

                                ?>
                                <!-- ចុងត្រីមាសទី 2 -->

                                <!-- ត្រីមាសទី 3 -->
                                <?php
                                    if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                        if($month7==7){
                                            ?>
                                                <th>7</th>
                                            <?php
                                            }
                                            if($month8==8){
                                                ?>
                                                    <th>8</th>
                                                <?php
                                            }
                                            if($month9==9){
                                                ?>
                                                    <th>9</th>
                                                <?php
                                            }
                                    }else{
                                        ?>
                                            <th>7</th>
                                            <th>8</th>
                                            <th>9</th>
                                        <?php   
                                    }

                                ?>
                                <!-- ចុងត្រីមាសទី 3 -->


                                <!-- ត្រីមាសទី 4 -->
                                <?php
                                    if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                        if($month10==10){
                                            ?>
                                                <th>10</th>
                                            <?php
                                        }
                                        if($month11==11){
                                            ?>
                                                <th>11</th>
                                            <?php
                                        }
                                        if($month12==12){
                                            ?>
                                                <th>12</th>
                                            <?php
                                        }

                                        // ++++++++++++
                                    
                                    // +++++++++++++
                                    }else{
                                        ?>
                                            <th>10</th>
                                            <th>11</th>
                                            <th>12</th>
                                        <?php   
                                    }
                                ?>
                                <!-- ចុងត្រីមាសទី ៤ -->
                        </tr>
             </thead>
                    <tbody>
                  <?php
                        $idx = 1;
                       $v_sql = "SELECT A.*,B.stca_name,B.stca_code,C.stun_name,B.stca_id,
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
                        SELECT SUM(
                                    (IFNULL(in_qty,0)*in_price_vn/stsin_exchange_rate)
                                        +(in_price_dollar*IFNULL(in_qty,0))
                                    )
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
                WHERE A.stpron_material_type='1'
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
// echo $v_sql;
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
while ($row = mysqli_fetch_object($get_data)) {
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




}

                $i = 0;
                $v_sql = "SELECT * FROM tbl_st_category_list WHERE material_type_id='1'";
                $v_result_summary = $connect->query($v_sql);
                while ($row_summary = mysqli_fetch_object($v_result_summary)) {
                    $v_arr_result = summaryMaterial($row_summary->stca_id, $v_arr_summary);
                    $cate_min_id=$row_summary->stca_id;


                        ?>
              
               

                        
                       
                        <tr>
                            <td></td>
                            <td>
                            
                            </td>
                            <td>ដើមគ្រា Đầu kỳ</td>
                            <td >
                               <?php

                                 if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-01-01') && $v_date_end>date('Y-01-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-01-01') && 
                                            $v_date_end >date('Y-01-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-01-01');
                                                 $v_date_end = date('Y-01-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-01-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-01-01');
                                    $v_date_end = date('Y-01-31');
                                }
                                  $d1= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,4);


                               if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-02-01') && $v_date_end>date('Y-02-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-02-01') && 
                                            $v_date_end >date('Y-02-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-02-01');
                                                 $v_date_end = date('Y-02-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-02-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-02-01');
                                    $v_date_end = date('Y-02-31');
                                }
                                $d2= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,4);
                                if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-03-01') && $v_date_end>date('Y-03-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-03-01') && 
                                            $v_date_end >date('Y-03-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-03-01');
                                                 $v_date_end = date('Y-03-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-03-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-03-01');
                                    $v_date_end = date('Y-03-31');
                                }
                                  $d3= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,4);
                                if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-04-01') && $v_date_end>date('Y-04-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-04-01') && 
                                            $v_date_end >date('Y-04-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-04-01');
                                                 $v_date_end = date('Y-04-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-04-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-04-01');
                                    $v_date_end = date('Y-04-31');
                                }
                                  $d4= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,4);
                                if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-05-01') && $v_date_end>date('Y-05-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-05-01') && 
                                            $v_date_end >date('Y-05-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-05-01');
                                                 $v_date_end = date('Y-05-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-05-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-05-01');
                                    $v_date_end = date('Y-05-31');
                                }
                                  $d5= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,4);
                                if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-06-01') && $v_date_end>date('Y-06-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-06-01') && 
                                            $v_date_end >date('Y-06-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-06-01');
                                                 $v_date_end = date('Y-06-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-06-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-06-01');
                                    $v_date_end = date('Y-06-31');
                                }
                                  $d6= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,4);
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-07-01') && $v_date_end>date('Y-07-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-07-01') && 
                                            $v_date_end >date('Y-07-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-07-01');
                                                 $v_date_end = date('Y-07-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-07-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-07-01');
                                    $v_date_end = date('Y-07-31');
                                }
                                  $d7= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,4);
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-08-01') && $v_date_end>date('Y-08-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-08-01') && 
                                            $v_date_end >date('Y-08-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-08-01');
                                                 $v_date_end = date('Y-08-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-08-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-08-01');
                                    $v_date_end = date('Y-08-31');
                                }
                                  $d8= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,4);
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-09-01') && $v_date_end>date('Y-09-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-09-01') && 
                                            $v_date_end >date('Y-09-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-09-01');
                                                 $v_date_end = date('Y-09-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-09-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-09-01');
                                    $v_date_end = date('Y-09-31');
                                }
                                  $d9= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,4);
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-10-01') && $v_date_end>date('Y-10-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-10-01') && 
                                            $v_date_end >date('Y-10-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-10-01');
                                                 $v_date_end = date('Y-10-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-10-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-10-01');
                                    $v_date_end = date('Y-10-31');
                                }
                                  $d10= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,4);
                                 if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-11-01') && $v_date_end>date('Y-11-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-11-01') && 
                                            $v_date_end >date('Y-11-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-11-01');
                                                 $v_date_end = date('Y-11-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-11-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-11-01');
                                    $v_date_end = date('Y-11-31');
                                }
                                  $d11= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,4);
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-12-01') && $v_date_end>date('Y-12-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-12-01') && 
                                            $v_date_end >date('Y-12-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-12-01');
                                                 $v_date_end = date('Y-12-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-12-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-12-01');
                                    $v_date_end = date('Y-12-31');
                                }
                                  $d12= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,4);
                                  $d_all=array($d1,$d2,$d3,$d4,$d5,$d6,$d7,$d8,$d9,$d10,$d11,$d12);
                                  echo number_format(array_sum($d_all),2);
                                  $d_all_total=array_sum($d_all);
                                 

                                ?>
                            </td>

                            <!-- month 1 -->
                            <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-01-31') && 
                                    $date2 >=date('Y-01-01')
                                  )
                                    {

                            ?>
                             <td>
                                <?php
                                 if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-01-01') && $v_date_end>date('Y-01-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-01-01') && 
                                            $v_date_end >date('Y-01-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-01-01');
                                                 $v_date_end = date('Y-01-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-01-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-01-01');
                                    $v_date_end = date('Y-01-31');
                                }
                                  
                                  echo $cc=calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);

                                ?>
                             </td>
                             <?php
                                }
                              }
                              else {
                             ?>
                             <td>
                                <?php
                                 if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-01-01') && $v_date_end>date('Y-01-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-01-01') && 
                                            $v_date_end >date('Y-01-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-01-01');
                                                 $v_date_end = date('Y-01-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-01-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-01-01');
                                    $v_date_end = date('Y-01-31');
                                }
                                  
                                  echo $cc=calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);

                                ?>
                             </td>

                             <?php
                               }
                             ?>
                            <!-- month 2 -->
                             <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-02-31') && 
                                    $date2 >=date('Y-02-01')
                                  )
                                    {

                            ?>

                             <td>
                              <?php
                                    if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-02-01') && $v_date_end>date('Y-02-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-02-01') && 
                                            $v_date_end >date('Y-02-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-02-01');
                                                 $v_date_end = date('Y-02-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-02-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-02-01');
                                    $v_date_end = date('Y-02-31');
                                }
                                  echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);

                                ?>
                             </td>
                             <?php
                               }
                              }
                              else {
                             ?>

                              <td>
                              <?php
                                    if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-02-01') && $v_date_end>date('Y-02-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-02-01') && 
                                            $v_date_end >date('Y-02-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-02-01');
                                                 $v_date_end = date('Y-02-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-02-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-02-01');
                                    $v_date_end = date('Y-02-31');
                                }
                                  echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);

                                ?>
                             </td>

                             <?php
                               }
                             ?>

                             <!-- month 3 -->
                             <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-03-31') && 
                                    $date2 >=date('Y-03-01')
                                  )
                                    {

                            ?>

                             <td> 
                               <?php
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-03-01') && $v_date_end>date('Y-03-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-03-01') && 
                                            $v_date_end >date('Y-03-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-03-01');
                                                 $v_date_end = date('Y-03-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-03-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-03-01');
                                    $v_date_end = date('Y-03-31');
                                }
                                  echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);

                                ?>
                             </td>
                            <?php
                               }
                            }
                            else {
                            ?>
                             <td> 
                               <?php
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-03-01') && $v_date_end>date('Y-03-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-03-01') && 
                                            $v_date_end >date('Y-03-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-03-01');
                                                 $v_date_end = date('Y-03-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-03-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-03-01');
                                    $v_date_end = date('Y-03-31');
                                }
                                  echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);

                                ?>
                             </td>
                            <?php
                              }
                            ?>

                             <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-04-31') && 
                                    $date2 >=date('Y-04-01')
                                  )
                                    {

                            ?>

                             <td>
                                <?php
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-04-01') && $v_date_end>date('Y-04-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-04-01') && 
                                            $v_date_end >date('Y-04-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-04-01');
                                                 $v_date_end = date('Y-04-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-04-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-04-01');
                                    $v_date_end = date('Y-04-31');
                                }
                                  echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);

                                ?>

                             </td>
                             <?php
                                }
                              }
                              else {
                             ?>
                              <td>
                                <?php
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-04-01') && $v_date_end>date('Y-04-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-04-01') && 
                                            $v_date_end >date('Y-04-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-04-01');
                                                 $v_date_end = date('Y-04-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-04-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-04-01');
                                    $v_date_end = date('Y-04-31');
                                }
                                  echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);

                                ?>

                             </td>
                             <?php
                               }
                             ?>

                              <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-05-31') && 
                                    $date2 >=date('Y-05-01')
                                  )
                                    {

                            ?>

                             <td>
                                 <?php
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-05-01') && $v_date_end>date('Y-05-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-05-01') && 
                                            $v_date_end >date('Y-05-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-05-01');
                                                 $v_date_end = date('Y-05-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-05-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-05-01');
                                    $v_date_end = date('Y-05-31');
                                }
                                  echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);

                                ?>

                             </td>
                             <?php
                                }
                              }
                              else {
                             ?>
                             <td>
                                 <?php
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-05-01') && $v_date_end>date('Y-05-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-05-01') && 
                                            $v_date_end >date('Y-05-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-05-01');
                                                 $v_date_end = date('Y-05-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-05-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-05-01');
                                    $v_date_end = date('Y-05-31');
                                }
                                  echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);

                                ?>

                             </td>

                             <?php
                               }
                             ?>

                              <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-06-31') && 
                                    $date2 >=date('Y-06-01')
                                  )
                                    {

                            ?>

                             <td>
                                <?php
                                    if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-06-01') && $v_date_end>date('Y-06-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-06-01') && 
                                            $v_date_end >date('Y-06-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-06-01');
                                                 $v_date_end = date('Y-06-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-06-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-06-01');
                                    $v_date_end = date('Y-06-31');
                                }
                                  echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);

                                ?>
                            </td>
                            <?php
                              }
                             }
                             else {
                            ?>
                             <td>
                                <?php
                                    if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-06-01') && $v_date_end>date('Y-06-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-06-01') && 
                                            $v_date_end >date('Y-06-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-06-01');
                                                 $v_date_end = date('Y-06-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-06-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-06-01');
                                    $v_date_end = date('Y-06-31');
                                }
                                  echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);

                                ?>
                            </td>

                        <?php } ?>

                         <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-07-31') && 
                                    $date2 >=date('Y-07-01')
                                  )
                                    {

                            ?>

                             <td>

                                <?php
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-07-01') && $v_date_end>date('Y-07-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-07-01') && 
                                            $v_date_end >date('Y-07-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-07-01');
                                                 $v_date_end = date('Y-07-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-07-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-07-01');
                                    $v_date_end = date('Y-07-31');
                                }
                                  echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);

                                ?>

                            </td>
                        <?php
                           }
                         }
                         else {
                        ?>
                         <td>

                                <?php
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-07-01') && $v_date_end>date('Y-07-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-07-01') && 
                                            $v_date_end >date('Y-07-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-07-01');
                                                 $v_date_end = date('Y-07-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-07-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-07-01');
                                    $v_date_end = date('Y-07-31');
                                }
                                  echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);

                                ?>

                            </td>

                        <?php
                          }
                        ?>
                         <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-08-31') && 
                                    $date2 >=date('Y-08-01')
                                  )
                                    {

                            ?>

                             <td>
                                 <?php
                                 if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-08-01') && $v_date_end>date('Y-08-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-08-01') && 
                                            $v_date_end >date('Y-08-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-08-01');
                                                 $v_date_end = date('Y-08-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-08-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-08-01');
                                    $v_date_end = date('Y-08-31');
                                }
                                  
                                  echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);

                                ?>
                            </td>
                            <?php
                               }
                              }
                              else {
                            ?>
                            <td>
                                 <?php
                                 if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-08-01') && $v_date_end>date('Y-08-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-08-01') && 
                                            $v_date_end >date('Y-08-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-08-01');
                                                 $v_date_end = date('Y-08-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-08-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-08-01');
                                    $v_date_end = date('Y-08-31');
                                }
                                  
                                  echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);

                                ?>
                            </td>

                            <?php
                              }
                            ?>

                             <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-09-31') && 
                                    $date2 >=date('Y-09-01')
                                  )
                                    {

                            ?>

                             <td>

                                 <?php
                                 if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-09-01') && $v_date_end>date('Y-09-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-09-01') && 
                                            $v_date_end >date('Y-09-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-09-01');
                                                 $v_date_end = date('Y-09-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-09-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-09-01');
                                    $v_date_end = date('Y-09-31');
                                }
                                  echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);

                                ?>

                            </td>
                            <?php
                              }
                             }
                             else {
                            ?>
                             <td>

                                 <?php
                                 if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-09-01') && $v_date_end>date('Y-09-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-09-01') && 
                                            $v_date_end >date('Y-09-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-09-01');
                                                 $v_date_end = date('Y-09-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-09-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-09-01');
                                    $v_date_end = date('Y-09-31');
                                }
                                  echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);

                                ?>

                            </td>
                            <?php
                              }
                            ?>
                             <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-10-31') && 
                                    $date2 >=date('Y-10-01')
                                  )
                                    {

                            ?>

                             <td>
                                 <?php
                                 if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-10-01') && $v_date_end>date('Y-10-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-10-01') && 
                                            $v_date_end >date('Y-10-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-10-01');
                                                 $v_date_end = date('Y-10-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-10-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-10-01');
                                    $v_date_end = date('Y-10-31');
                                }
                                  echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);

                                ?>

                            </td>
                            <?php
                              }
                             }
                             else {
                            ?>
                             <td>
                                 <?php
                                 if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-10-01') && $v_date_end>date('Y-10-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-10-01') && 
                                            $v_date_end >date('Y-10-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-10-01');
                                                 $v_date_end = date('Y-10-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-10-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-10-01');
                                    $v_date_end = date('Y-10-31');
                                }
                                  echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);

                                ?>

                            </td>
                            <?php
                              }
                            ?>

                             <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-11-31') && 
                                    $date2 >=date('Y-11-01')
                                  )
                                    {

                            ?>

                             <td>
                               
                                 <?php
                                 if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-11-01') && $v_date_end>date('Y-11-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-11-01') && 
                                            $v_date_end >date('Y-11-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-11-01');
                                                 $v_date_end = date('Y-11-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-11-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-11-01');
                                    $v_date_end = date('Y-11-31');
                                }
                                  echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);

                                ?>
                            </td>
                        <?php
                          }
                          }
                          else {
                        ?>
                         <td>
                               
                                 <?php
                                 if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-11-01') && $v_date_end>date('Y-11-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-11-01') && 
                                            $v_date_end >date('Y-11-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-11-01');
                                                 $v_date_end = date('Y-11-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-11-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-11-01');
                                    $v_date_end = date('Y-11-31');
                                }
                                  echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);

                                ?>
                            </td>

                        <?php
                           }
                        ?>

                         <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-12-31') && 
                                    $date2 >=date('Y-12-01')
                                  )
                                    {

                            ?>

                             <td>
                                     <?php
                                 if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-12-01') && $v_date_end>date('Y-12-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-12-01') && 
                                            $v_date_end >date('Y-12-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-12-01');
                                                 $v_date_end = date('Y-12-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-12-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-12-01');
                                    $v_date_end = date('Y-12-31');
                                }
                                  echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);

                                ?>
                            </td>

                            <?php
                               }
                            }
                            else {
                            ?>
 <td>
                                     <?php
                                 if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-12-01') && $v_date_end>date('Y-12-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-12-01') && 
                                            $v_date_end >date('Y-12-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-12-01');
                                                 $v_date_end = date('Y-12-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-12-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-12-01');
                                    $v_date_end = date('Y-12-31');
                                }
                                  echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,1);

                                ?>
                            </td>
                            <?php
                              }
                            ?>
                        </tr>
                  

                         <tr >
                            <td style="border-top: none;"><?php echo ++$i; ?></td>
                            <td style="border-top: none;">
                               <?php echo  $row_summary->stca_name; ?>
                            </td>
                            <td>ស្តុកចូល Nhập kho</td>
                            <td>
                                <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-01-01') && $v_date_end>date('Y-01-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-01-01') && 
                                            $v_date_end >date('Y-01-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-01-01');
                                                 $v_date_end = date('Y-01-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-01-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-01-01');
                                    $v_date_end = date('Y-01-31');
                                }
                                 $in_1= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,5);
                                 if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-02-01') && $v_date_end>date('Y-02-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-02-01') && 
                                            $v_date_end >date('Y-02-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-02-01');
                                                 $v_date_end = date('Y-02-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-02-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-02-01');
                                    $v_date_end = date('Y-02-31');
                                }
                                 $in_2= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,5);
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-03-01') && $v_date_end>date('Y-03-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-03-01') && 
                                            $v_date_end >date('Y-03-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-03-01');
                                                 $v_date_end = date('Y-03-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-03-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-03-01');
                                    $v_date_end = date('Y-03-31');
                                }
                                 $in_3= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,5);
                                 if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-04-01') && $v_date_end>date('Y-04-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-04-01') && 
                                            $v_date_end >date('Y-04-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-04-01');
                                                 $v_date_end = date('Y-04-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-04-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-04-01');
                                    $v_date_end = date('Y-04-31');
                                }
                                 $in_4= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,5);
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-05-01') && $v_date_end>date('Y-05-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-05-01') && 
                                            $v_date_end >date('Y-05-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-05-01');
                                                 $v_date_end = date('Y-05-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-05-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-05-01');
                                    $v_date_end = date('Y-05-31');
                                }
                                 $in_5= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,5);
                                 if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-06-01') && $v_date_end>date('Y-06-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-06-01') && 
                                            $v_date_end >date('Y-06-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-06-01');
                                                 $v_date_end = date('Y-06-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-06-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-06-01');
                                    $v_date_end = date('Y-06-31');
                                }
                                 $in_6= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,5);
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-07-01') && $v_date_end>date('Y-07-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-07-01') && 
                                            $v_date_end >date('Y-07-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-07-01');
                                                 $v_date_end = date('Y-07-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-07-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-07-01');
                                    $v_date_end = date('Y-07-31');
                                }
                                 $in_7= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,5);
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-08-01') && $v_date_end>date('Y-08-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-08-01') && 
                                            $v_date_end >date('Y-08-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-08-01');
                                                 $v_date_end = date('Y-08-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-08-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-08-01');
                                    $v_date_end = date('Y-08-31');
                                }
                                 $in_8= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,5);
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-09-01') && $v_date_end>date('Y-09-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-09-01') && 
                                            $v_date_end >date('Y-09-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-09-01');
                                                 $v_date_end = date('Y-09-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-09-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-09-01');
                                    $v_date_end = date('Y-09-31');
                                }
                                 $in_9= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,5);
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-10-01') && $v_date_end>date('Y-10-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-10-01') && 
                                            $v_date_end >date('Y-10-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-10-01');
                                                 $v_date_end = date('Y-10-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-10-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-10-01');
                                    $v_date_end = date('Y-10-31');
                                }
                                 $in_10= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,5);
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-11-01') && $v_date_end>date('Y-11-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-11-01') && 
                                            $v_date_end >date('Y-11-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-11-01');
                                                 $v_date_end = date('Y-11-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-11-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-11-01');
                                    $v_date_end = date('Y-11-31');
                                }
                                 $in_11= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,5);
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-12-01') && $v_date_end>date('Y-12-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-12-01') && 
                                            $v_date_end >date('Y-12-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-12-01');
                                                 $v_date_end = date('Y-12-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-12-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-12-01');
                                    $v_date_end = date('Y-12-31');
                                }
                                 $in_12= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,5);
                                 $in_all=array($in_1,$in_2,$in_3,$in_4,$in_5,$in_6,$in_7,$in_8,$in_9,$in_10,$in_11,$in_12);
                                  echo  number_format(array_sum($in_all),2);
                                  $in_all_total=array_sum($in_all);
                                 

                                ?>
                            </td>
                             <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-01-31') && 
                                    $date2 >=date('Y-01-01')
                                  )
                                    {

                            ?>
                             <td>

                                <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-01-01') && $v_date_end>date('Y-01-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-01-01') && 
                                            $v_date_end >date('Y-01-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-01-01');
                                                 $v_date_end = date('Y-01-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-01-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-01-01');
                                    $v_date_end = date('Y-01-31');
                                }
                                   echo $be1= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2);
                                ?>
                             </td>
                        <?php
                           }
                          }
                          else {
                        ?>
                        <td>

                                <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-01-01') && $v_date_end>date('Y-01-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-01-01') && 
                                            $v_date_end >date('Y-01-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-01-01');
                                                 $v_date_end = date('Y-01-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-01-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-01-01');
                                    $v_date_end = date('Y-01-31');
                                }
                                   echo $be1= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2);
                                ?>
                             </td>

                        <?php
                          }
                        ?>

                        <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-02-31') && 
                                    $date2 >=date('Y-02-01')
                                  )
                                    {

                            ?>

                             <td>
                                <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-02-01') && $v_date_end>date('Y-02-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-02-01') && 
                                            $v_date_end >date('Y-02-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-02-01');
                                                 $v_date_end = date('Y-02-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-02-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-02-01');
                                    $v_date_end = date('Y-02-31');
                                }
                                   echo $be2=calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2);
                                ?>
                             </td>
                             <?php
                               }
                             }
                             else {
                             ?>
                              <td>
                                <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-02-01') && $v_date_end>date('Y-02-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-02-01') && 
                                            $v_date_end >date('Y-02-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-02-01');
                                                 $v_date_end = date('Y-02-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-02-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-02-01');
                                    $v_date_end = date('Y-02-31');
                                }
                                   echo $be2=calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2);
                                ?>
                             </td>

                             <?php
                               }
                             ?>

                             <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-03-31') && 
                                    $date2 >=date('Y-03-01')
                                  )
                                    {

                            ?>

                             <td>
                                 <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-03-01') && $v_date_end>date('Y-03-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-03-01') && 
                                            $v_date_end >date('Y-03-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-03-01');
                                                 $v_date_end = date('Y-03-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-03-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-03-01');
                                    $v_date_end = date('Y-03-31');
                                }
                                   echo $be3=calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2);
                                ?>
                            </td>
                            <?php
                               }
                             }
                             else {
                            ?>
                             <td>
                                 <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-03-01') && $v_date_end>date('Y-03-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-03-01') && 
                                            $v_date_end >date('Y-03-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-03-01');
                                                 $v_date_end = date('Y-03-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-03-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-03-01');
                                    $v_date_end = date('Y-03-31');
                                }
                                   echo $be3=calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2);
                                ?>
                            </td>
                            <?php
                              }
                            ?>

                            <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-04-31') && 
                                    $date2 >=date('Y-04-01')
                                  )
                                    {

                            ?>

                             <td>
                                 <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-04-01') && $v_date_end>date('Y-04-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-04-01') && 
                                            $v_date_end >date('Y-04-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-04-01');
                                                 $v_date_end = date('Y-04-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-04-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-04-01');
                                    $v_date_end = date('Y-04-31');
                                }
                                   echo $be4= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2);
                                ?>
                            </td>
                            <?php
                               }
                             }
                             else {
                            ?>
                            <td>
                                 <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-04-01') && $v_date_end>date('Y-04-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-04-01') && 
                                            $v_date_end >date('Y-04-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-04-01');
                                                 $v_date_end = date('Y-04-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-04-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-04-01');
                                    $v_date_end = date('Y-04-31');
                                }
                                   echo $be4= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2);
                                ?>
                            </td>
                            <?php
                              }
                            ?>

                            <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-05-31') && 
                                    $date2 >=date('Y-05-01')
                                  )
                                    {

                            ?>

                             <td>
                                 <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-05-01') && $v_date_end>date('Y-05-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-05-01') && 
                                            $v_date_end >date('Y-05-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-05-01');
                                                 $v_date_end = date('Y-05-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-05-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-05-01');
                                    $v_date_end = date('Y-05-31');
                                }
                                   echo $be5= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2);
                                ?>
                             </td>

                             <?php
                               }
                              }
                              else {
                             ?>
                             <td>
                                 <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-05-01') && $v_date_end>date('Y-05-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-05-01') && 
                                            $v_date_end >date('Y-05-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-05-01');
                                                 $v_date_end = date('Y-05-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-05-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-05-01');
                                    $v_date_end = date('Y-05-31');
                                }
                                   echo $be5= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2);
                                ?>
                             </td>
                             <?php
                               }
                             ?>
                             <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-06-31') && 
                                    $date2 >=date('Y-06-01')
                                  )
                                    {

                            ?>

                             <td>
                                 <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-06-01') && $v_date_end>date('Y-06-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-06-01') && 
                                            $v_date_end >date('Y-06-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-06-01');
                                                 $v_date_end = date('Y-06-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-06-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-06-01');
                                    $v_date_end = date('Y-06-31');
                                }
                                   echo $be6= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2);
                                ?>
                            </td>
                            <?php
                              }
                             }
                             else {
                            ?>
                            <td>
                                 <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-06-01') && $v_date_end>date('Y-06-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-06-01') && 
                                            $v_date_end >date('Y-06-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-06-01');
                                                 $v_date_end = date('Y-06-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-06-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-06-01');
                                    $v_date_end = date('Y-06-31');
                                }
                                   echo $be6= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2);
                                ?>
                            </td>
                            <?php
                             }
                            ?>

                            <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-07-31') && 
                                    $date2 >=date('Y-07-01')
                                  )
                                    {

                            ?>

                             <td>
                                 <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-07-01') && $v_date_end>date('Y-07-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-07-01') && 
                                            $v_date_end >date('Y-07-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-07-01');
                                                 $v_date_end = date('Y-07-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-07-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-07-01');
                                    $v_date_end = date('Y-07-31');
                                }
                                   echo $be7= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2);
                                ?>
                            </td>
                            <?php
                              }
                             }
                             else {
                            ?>
                            <td>
                                 <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-07-01') && $v_date_end>date('Y-07-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-07-01') && 
                                            $v_date_end >date('Y-07-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-07-01');
                                                 $v_date_end = date('Y-07-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-07-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-07-01');
                                    $v_date_end = date('Y-07-31');
                                }
                                   echo $be7= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2);
                                ?>
                            </td>

                            <?php
                              }
                            ?>

                            <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-08-31') && 
                                    $date2 >=date('Y-08-01')
                                  )
                                    {

                            ?>

                             <td>
                                 <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-08-01') && $v_date_end>date('Y-08-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-08-01') && 
                                            $v_date_end >date('Y-08-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-08-01');
                                                 $v_date_end = date('Y-08-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-08-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-08-01');
                                    $v_date_end = date('Y-08-31');
                                }
                                   echo $be8= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2);
                                ?>
                            </td>
                            <?php
                              }
                             }
                             else {
                            ?>
                            <td>
                                 <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-08-01') && $v_date_end>date('Y-08-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-08-01') && 
                                            $v_date_end >date('Y-08-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-08-01');
                                                 $v_date_end = date('Y-08-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-08-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-08-01');
                                    $v_date_end = date('Y-08-31');
                                }
                                   echo $be8= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2);
                                ?>
                            </td>
                            <?php
                              }
                            ?>


                            <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-09-31') && 
                                    $date2 >=date('Y-09-01')
                                  )
                                    {

                            ?>


                             <td>
                                 <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-09-01') && $v_date_end>date('Y-09-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-09-01') && 
                                            $v_date_end >date('Y-09-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-09-01');
                                                 $v_date_end = date('Y-09-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-09-01')) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-09-01');
                                    $v_date_end = date('Y-09-31');
                                }
                                   echo $be9= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2);
                                ?>
                             </td>
                             <?php
                                }
                              }
                              else {
                             ?>
                              <td>
                                 <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-09-01') && $v_date_end>date('Y-09-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-09-01') && 
                                            $v_date_end >date('Y-09-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-09-01');
                                                 $v_date_end = date('Y-09-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-09-01')) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-09-01');
                                    $v_date_end = date('Y-09-31');
                                }
                                   echo $be9= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2);
                                ?>
                             </td>
                             <?php
                               }
                             ?>

                             <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-10-31') && 
                                    $date2 >=date('Y-10-01')
                                  )
                                    {

                            ?>

                             <td>
                                 <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-10-01') && $v_date_end>date('Y-10-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-10-01') && 
                                            $v_date_end >date('Y-10-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-10-01');
                                                 $v_date_end = date('Y-10-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-10-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-10-01');
                                    $v_date_end = date('Y-10-31');
                                }
                                   echo $be10=calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2);
                                ?>
                            </td>
                            <?php
                              }
                            }
                            else {
                            ?>
                             <td>
                                 <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-10-01') && $v_date_end>date('Y-10-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-10-01') && 
                                            $v_date_end >date('Y-10-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-10-01');
                                                 $v_date_end = date('Y-10-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-10-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-10-01');
                                    $v_date_end = date('Y-10-31');
                                }
                                   echo $be10=calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2);
                                ?>
                            </td>
                            <?php
                                 }   
                            ?>

                            <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-11-31') && 
                                    $date2 >=date('Y-11-01')
                                  )
                                    {

                            ?>

                             <td>
                                 <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-11-01') && $v_date_end>date('Y-11-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-11-01') && 
                                            $v_date_end >date('Y-11-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-11-01');
                                                 $v_date_end = date('Y-11-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-11-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-11-01');
                                    $v_date_end = date('Y-11-31');
                                }
                                   echo $be11=calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2);
                                ?>
                            </td>
                        <?php
                           }
                         }
                         else {
                        ?>
                        <td>
                                 <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-11-01') && $v_date_end>date('Y-11-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-11-01') && 
                                            $v_date_end >date('Y-11-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-11-01');
                                                 $v_date_end = date('Y-11-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-11-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-11-01');
                                    $v_date_end = date('Y-11-31');
                                }
                                   echo $be11=calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2);
                                ?>
                            </td>
                        <?php
                          }
                        ?>

                        <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-12-31') && 
                                    $date2 >=date('Y-12-01')
                                  )
                                    {

                            ?>

                             <td>
                                 <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-12-01') && $v_date_end>date('Y-12-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-12-01') && 
                                            $v_date_end >date('Y-12-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-12-01');
                                                 $v_date_end = date('Y-12-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-12-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-12-01');
                                    $v_date_end = date('Y-12-31');
                                }
                                   echo $be12=calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2);
                                ?>
                            </td>
                            <?php
                              }
                             }
                             else {
                            ?>
                             <td>
                                 <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-12-01') && $v_date_end>date('Y-12-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-12-01') && 
                                            $v_date_end >date('Y-12-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-12-01');
                                                 $v_date_end = date('Y-12-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-12-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-12-01');
                                    $v_date_end = date('Y-12-31');
                                }
                                   echo $be12=calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,2);
                                ?>
                            </td>
                            <?php
                              }
                            ?>
                        </tr>

                       

                        <tr>
                            <td style="border-top: none;"></td>
                            <td style="border-top: none;">
                              
                            </td>
                            <td>ស្តុកចេញ Xuất kho</td>
                            <td>
                              <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-01-01') && $v_date_end>date('Y-01-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-01-01') && 
                                            $v_date_end >date('Y-01-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-01-01');
                                                 $v_date_end = date('Y-01-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-01-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-01-01');
                                    $v_date_end = date('Y-01-31');
                                }
                                 $out_1= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,6);
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-02-01') && $v_date_end>date('Y-02-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-02-01') && 
                                            $v_date_end >date('Y-02-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-02-01');
                                                 $v_date_end = date('Y-02-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-02-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-02-01');
                                    $v_date_end = date('Y-02-31');
                                }
                                 $out_2= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,6);
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-03-01') && $v_date_end>date('Y-03-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-03-01') && 
                                            $v_date_end >date('Y-03-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-03-01');
                                                 $v_date_end = date('Y-03-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-03-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-03-01');
                                    $v_date_end = date('Y-03-31');
                                }
                                 $out_3= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,6);
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-04-01') && $v_date_end>date('Y-04-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-04-01') && 
                                            $v_date_end >date('Y-04-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-04-01');
                                                 $v_date_end = date('Y-04-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-04-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-04-01');
                                    $v_date_end = date('Y-04-31');
                                }
                                 $out_4= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,6);
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-05-01') && $v_date_end>date('Y-05-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-05-01') && 
                                            $v_date_end >date('Y-05-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-05-01');
                                                 $v_date_end = date('Y-05-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-05-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-05-01');
                                    $v_date_end = date('Y-05-31');
                                }
                                 $out_5= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,6);
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-06-01') && $v_date_end>date('Y-06-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-06-01') && 
                                            $v_date_end >date('Y-06-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-06-01');
                                                 $v_date_end = date('Y-06-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-06-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-06-01');
                                    $v_date_end = date('Y-06-31');
                                }
                                 $out_6= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,6);
                                 if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-07-01') && $v_date_end>date('Y-07-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-07-01') && 
                                            $v_date_end >date('Y-07-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-07-01');
                                                 $v_date_end = date('Y-07-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-07-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-07-01');
                                    $v_date_end = date('Y-07-31');
                                }
                                 $out_7= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,6);
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-08-01') && $v_date_end>date('Y-08-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-08-01') && 
                                            $v_date_end >date('Y-08-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-08-01');
                                                 $v_date_end = date('Y-08-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-08-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-08-01');
                                    $v_date_end = date('Y-08-31');
                                }
                                 $out_8= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,6);
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-09-01') && $v_date_end>date('Y-09-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-09-01') && 
                                            $v_date_end >date('Y-09-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-09-01');
                                                 $v_date_end = date('Y-09-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-09-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-09-01');
                                    $v_date_end = date('Y-09-31');
                                }
                                 $out_9= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,6);
                                   if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-10-01') && $v_date_end>date('Y-10-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-10-01') && 
                                            $v_date_end >date('Y-10-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-10-01');
                                                 $v_date_end = date('Y-10-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-10-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-10-01');
                                    $v_date_end = date('Y-10-31');
                                }
                                 $out_10= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,6);
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-11-01') && $v_date_end>date('Y-11-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-11-01') && 
                                            $v_date_end >date('Y-11-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-11-01');
                                                 $v_date_end = date('Y-11-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-11-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-11-01');
                                    $v_date_end = date('Y-11-31');
                                }
                                 $out_11= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,6);
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-12-01') && $v_date_end>date('Y-12-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-12-01') && 
                                            $v_date_end >date('Y-12-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-12-01');
                                                 $v_date_end = date('Y-12-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-12-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-12-01');
                                    $v_date_end = date('Y-12-31');
                                }
                                 $out_12= calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,6);
                                 $out_all=array($out_1,$out_2,$out_3,$out_4,$out_5,$out_6,$out_7,$out_8,$out_9,$out_10,$out_11,$out_12);
                                  echo  number_format(array_sum($out_all),2);
                                    $out_all_total=array_sum($out_all);

                                ?>
                            </td>

                            <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-01-31') && 
                                    $date2 >=date('Y-01-01')
                                  )
                                    {

                            ?>

                             <td> 

                                <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-01-01') && $v_date_end>date('Y-01-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-01-01') && 
                                            $v_date_end >date('Y-01-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-01-01');
                                                 $v_date_end = date('Y-01-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-01-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-01-01');
                                    $v_date_end = date('Y-01-31');
                                }
                                   echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3);
                                ?>
                             </td>
                             <?php
                               }
                              }
                              else {
                             ?>

                              <td> 

                                <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-01-01') && $v_date_end>date('Y-01-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-01-01') && 
                                            $v_date_end >date('Y-01-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-01-01');
                                                 $v_date_end = date('Y-01-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-01-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-01-01');
                                    $v_date_end = date('Y-01-31');
                                }
                                   echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3);
                                ?>
                             </td>

                             <?php
                               }
                             ?>


                             <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-02-31') && 
                                    $date2 >=date('Y-02-01')
                                  )
                                    {

                            ?>

                             <td>
                                 <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-02-01') && $v_date_end>date('Y-02-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-02-01') && 
                                            $v_date_end >date('Y-02-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-02-01');
                                                 $v_date_end = date('Y-02-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-02-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-02-01');
                                    $v_date_end = date('Y-02-31');
                                }
                                   echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3);
                                ?>
                             </td>
                            <?php
                               }
                              }
                              else {
                            ?>
                            <td>
                                 <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-02-01') && $v_date_end>date('Y-02-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-02-01') && 
                                            $v_date_end >date('Y-02-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-02-01');
                                                 $v_date_end = date('Y-02-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-02-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-02-01');
                                    $v_date_end = date('Y-02-31');
                                }
                                   echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3);
                                ?>
                             </td>
                            <?php
                              }
                            ?>

                            <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-03-31') && 
                                    $date2 >=date('Y-03-01')
                                  )
                                    {

                            ?>


                             <td>
                                <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-03-01') && $v_date_end>date('Y-03-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-03-01') && 
                                            $v_date_end >date('Y-03-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-03-01');
                                                 $v_date_end = date('Y-03-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-03-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-03-01');
                                    $v_date_end = date('Y-03-31');
                                }
                                   echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3);
                                ?>
                             </td>
                        <?php
                           }
                          }
                          else {
                        ?>
                         <td>
                                <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-03-01') && $v_date_end>date('Y-03-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-03-01') && 
                                            $v_date_end >date('Y-03-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-03-01');
                                                 $v_date_end = date('Y-03-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-03-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-03-01');
                                    $v_date_end = date('Y-03-31');
                                }
                                   echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3);
                                ?>
                             </td>
                        <?php
                          }
                        ?>

                        <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-04-31') && 
                                    $date2 >=date('Y-04-01')
                                  )
                                    {

                            ?>

                             <td> 
                                <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-04-01') && $v_date_end>date('Y-04-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-04-01') && 
                                            $v_date_end >date('Y-04-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-04-01');
                                                 $v_date_end = date('Y-04-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-04-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-04-01');
                                    $v_date_end = date('Y-04-31');
                                }
                                   echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3);
                                ?>
                             </td>
                             <?php
                                 }
                                }
                                else {
                             ?>
                              <td> 
                                <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-04-01') && $v_date_end>date('Y-04-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-04-01') && 
                                            $v_date_end >date('Y-04-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-04-01');
                                                 $v_date_end = date('Y-04-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-04-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-04-01');
                                    $v_date_end = date('Y-04-31');
                                }
                                   echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3);
                                ?>
                             </td>
                             <?php
                               }
                             ?>

                             <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-05-31') && 
                                    $date2 >=date('Y-05-01')
                                  )
                                    {

                            ?>

                             <td>
                                <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-05-01') && $v_date_end>date('Y-05-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-05-01') && 
                                            $v_date_end >date('Y-05-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-05-01');
                                                 $v_date_end = date('Y-05-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-05-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-05-01');
                                    $v_date_end = date('Y-05-31');
                                }
                                   echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3);
                                ?>
                            </td>
                            <?php
                              }
                             }
                             else {
                            ?>
                             <td>
                                <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-05-01') && $v_date_end>date('Y-05-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-05-01') && 
                                            $v_date_end >date('Y-05-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-05-01');
                                                 $v_date_end = date('Y-05-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-05-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-05-01');
                                    $v_date_end = date('Y-05-31');
                                }
                                   echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3);
                                ?>
                            </td>
                            <?php
                              }
                            ?>

                            <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-06-31') && 
                                    $date2 >=date('Y-06-01')
                                  )
                                    {

                            ?>

                             <td>
                                <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-06-01') && $v_date_end>date('Y-06-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-06-01') && 
                                            $v_date_end >date('Y-06-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-06-01');
                                                 $v_date_end = date('Y-06-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-06-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-06-01');
                                    $v_date_end = date('Y-06-31');
                                }
                                   echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3);
                                ?>
                             </td>
                             <?php
                               }
                             }
                             else {
                             ?>
                              <td>
                                <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-06-01') && $v_date_end>date('Y-06-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-06-01') && 
                                            $v_date_end >date('Y-06-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-06-01');
                                                 $v_date_end = date('Y-06-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-06-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-06-01');
                                    $v_date_end = date('Y-06-31');
                                }
                                   echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3);
                                ?>
                             </td>
                             <?php
                               }
                             ?>

                             <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-07-31') && 
                                    $date2 >=date('Y-07-01')
                                  )
                                    {

                            ?>

                             <td>
                                <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-07-01') && $v_date_end>date('Y-07-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-07-01') && 
                                            $v_date_end >date('Y-07-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-07-01');
                                                 $v_date_end = date('Y-07-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-07-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-07-01');
                                    $v_date_end = date('Y-07-31');
                                }
                                   echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3);
                                ?>
                             </td>
                             <?php
                               }
                             }
                             else {
                             ?>
                             <td>
                                <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-07-01') && $v_date_end>date('Y-07-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-07-01') && 
                                            $v_date_end >date('Y-07-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-07-01');
                                                 $v_date_end = date('Y-07-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-07-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-07-01');
                                    $v_date_end = date('Y-07-31');
                                }
                                   echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3);
                                ?>
                             </td>
                             <?php
                                }
                             ?>

                             <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-08-31') && 
                                    $date2 >=date('Y-08-01')
                                  )
                                    {

                            ?>

                             <td>
                                <?php
                                 if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-08-01') && $v_date_end>date('Y-08-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-08-01') && 
                                            $v_date_end >date('Y-08-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-08-01');
                                                 $v_date_end = date('Y-08-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-08-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-08-01');
                                    $v_date_end = date('Y-08-31');
                                }
                                   echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3);
                                ?>
                            </td>
                        <?php
                           }
                        }
                        else {
                        ?>

                         <td>
                                <?php
                                 if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-08-01') && $v_date_end>date('Y-08-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-08-01') && 
                                            $v_date_end >date('Y-08-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-08-01');
                                                 $v_date_end = date('Y-08-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-08-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-08-01');
                                    $v_date_end = date('Y-08-31');
                                }
                                   echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3);
                                ?>
                            </td>
                        <?php
                          }
                        ?>

                        <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-09-31') && 
                                    $date2 >=date('Y-09-01')
                                  )
                                    {

                            ?>

                             <td>
                                <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-09-01') && $v_date_end>date('Y-09-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-09-01') && 
                                            $v_date_end >date('Y-09-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-09-01');
                                                 $v_date_end = date('Y-09-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-09-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-09-01');
                                    $v_date_end = date('Y-09-31');
                                }
                                   echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3);
                                ?>
                            </td>
                        <?php
                           }
                         }
                         else {
                        ?>
                        <td>
                                <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-09-01') && $v_date_end>date('Y-09-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-09-01') && 
                                            $v_date_end >date('Y-09-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-09-01');
                                                 $v_date_end = date('Y-09-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-09-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-09-01');
                                    $v_date_end = date('Y-09-31');
                                }
                                   echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3);
                                ?>
                            </td>
                        <?php
                         }
                        ?>

                        <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-10-31') && 
                                    $date2 >=date('Y-10-01')
                                  )
                                    {

                            ?>

                             <td>
                                <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-10-01') && $v_date_end>date('Y-10-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-10-01') && 
                                            $v_date_end >date('Y-10-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-10-01');
                                                 $v_date_end = date('Y-10-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-10-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-10-01');
                                    $v_date_end = date('Y-10-31');
                                }
                                   echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3);
                                ?>
                            </td>

                        <?php
                           }
                         }
                         else {
                        ?>
                        <td>
                                <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-10-01') && $v_date_end>date('Y-10-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-10-01') && 
                                            $v_date_end >date('Y-10-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-10-01');
                                                 $v_date_end = date('Y-10-31');
                                             }
                                        else {
                                          if($v_date_end<date('Y-10-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-10-01');
                                    $v_date_end = date('Y-10-31');
                                }
                                   echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3);
                                ?>
                            </td>
                        <?php
                          }
                        ?>

                        <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-11-31') && 
                                    $date2 >=date('Y-11-01')
                                  )
                                    {

                            ?>

                             <td>
                                 <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-11-01') && $v_date_end>date('Y-11-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-11-01') && 
                                            $v_date_end >date('Y-11-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-11-01');
                                                 $v_date_end = date('Y-11-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-11-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-11-01');
                                    $v_date_end = date('Y-11-31');
                                }
                                   echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3);
                                ?>
                             </td>
                            <?php
                              }
                             }
                             else {
                            ?>
                            <td>
                                 <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-11-01') && $v_date_end>date('Y-11-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-11-01') && 
                                            $v_date_end >date('Y-11-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-11-01');
                                                 $v_date_end = date('Y-11-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-11-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-11-01');
                                    $v_date_end = date('Y-11-31');
                                }
                                   echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3);
                                ?>
                             </td>
                            <?php
                              }
                            ?>

                            <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-12-31') && 
                                    $date2 >=date('Y-12-01')
                                  )
                                    {

                            ?>

                             <td>
                                 <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-12-01') && $v_date_end>date('Y-12-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-12-01') && 
                                            $v_date_end >date('Y-12-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-12-01');
                                                 $v_date_end = date('Y-12-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-12-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-12-01');
                                    $v_date_end = date('Y-12-31');
                                }
                                   echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3);
                                ?>
                             </td>
                            <?php
                              }
                             }
                             else {
                            ?>
                            <td>
                                 <?php
                                  if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                    $v_date_start=$date1;
                                    $v_date_end=$date2;
                                        if($v_date_start>date('Y-12-01') && $v_date_end>date('Y-12-31')) {
                                            $v_date_start =0;
                                            $v_date_end =0;
                                        }
                                        else if(
                                            $v_date_start <date('Y-12-01') && 
                                            $v_date_end >date('Y-12-31')
                                             )
                                             {
                                                 $v_date_start = date('Y-12-01');
                                                 $v_date_end = date('Y-12-31');
                                             }
                                        else {
                                           if($v_date_end<date('Y-12-01') ) {
                                                 $v_date_start =0;
                                                 $v_date_end =0;
                                            }
                                            else {
                                                $v_date_start=$date1;
                                                $v_date_end=$date2;
                                            }
                                        }


                                }
                                else {
                                    $v_date_start = date('Y-12-01');
                                    $v_date_end = date('Y-12-31');
                                }
                                   echo calulate_t_price_beg($v_date_start,$v_date_end,$cate_min_id,3);
                                ?>
                             </td>
                            <?php } ?>
                        </tr>

                        <tr class="tr_report">
                            <td></td>
                            <td>
                              
                            </td>
                            <td>សមតុល្យ Cuối kỳ</td>
                            <td>
                                <?php
                                  $total_by_cate=($d_all_total+$in_all_total)-($out_all_total);
                                  echo number_format($total_by_cate,2);
                                ?>
                            </td>

                            <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-01-31') && 
                                    $date2 >=date('Y-01-01')
                                  )
                                    {

                            ?>

                             <td>

                                <?php
                                  echo number_format(($in_1+$d1)-($out_1),2);
                                ?>
                             </td>
                             <?php
                               }
                             }
                             else {
                             ?>
                              <td>

                                <?php
                                  echo number_format(($in_1+$d1)-($out_1),2);
                                ?>
                             </td>
                             <?php
                               }
                             ?>

                             <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-02-31') && 
                                    $date2 >=date('Y-02-01')
                                  )
                                    {

                            ?>

                             <td>
                                 <?php
                                  echo number_format(($in_2+$d2)-($out_2),2);
                                ?>
                             </td>
                             <?php
                               }
                              }
                              else {
                             ?>
                              <td>
                                 <?php
                                  echo number_format(($in_2+$d2)-($out_2),2);
                                ?>
                             </td>
                             <?php
                               }
                             ?>

                             <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-03-31') && 
                                    $date2 >=date('Y-03-01')
                                  )
                                    {

                            ?>

                             <td>
                                  <?php
                                  echo number_format(($in_3+$d3)-($out_3),2);
                                ?>
                             </td>
                             <?php
                               }
                             }
                            else {
                             ?>
                              <td>
                                  <?php
                                  echo number_format(($in_3+$d3)-($out_3),2);
                                ?>
                             </td>
                             <?php
                               }
                             ?>

                             <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-04-31') && 
                                    $date2 >=date('Y-04-01')
                                  )
                                    {

                            ?>

                             <td>
                                 <?php
                                  echo number_format(($in_4+$d4)-($out_4),2);
                                ?>
                             </td>
                        <?php
                           }
                         }
                         else {
                        ?>
                         <td>
                                 <?php
                                  echo number_format(($in_4+$d4)-($out_4),2);
                                ?>
                             </td>
                        <?php
                          }
                        ?>

                        <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-05-31') && 
                                    $date2 >=date('Y-05-01')
                                  )
                                    {

                            ?>

                             <td>
                                 <?php
                                  echo number_format(($in_5+$d5)-($out_5),2);
                                ?>
                             </td>
                            <?php
                               }
                             }
                             else {
                            ?>
                            <td>
                                 <?php
                                  echo number_format(($in_5+$d5)-($out_5),2);
                                ?>
                             </td>
                          <?php } ?>

                          <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-06-31') && 
                                    $date2 >=date('Y-06-01')
                                  )
                                    {

                            ?>

                             <td>
                                <?php
                                  echo number_format(($in_6+$d6)-($out_6),2);
                                ?>
                             </td>
                    <?php  
                       }
                     }
                     else {
                    ?>
                     <td>
                                <?php
                                  echo number_format(($in_6+$d6)-($out_6),2);
                                ?>
                             </td>
                    <?php
                      }
                    ?>

                    <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-07-31') && 
                                    $date2 >=date('Y-07-01')
                                  )
                                    {

                            ?>

                             <td>
                               <?php
                                  echo number_format(($in_7+$d7)-($out_7),2);
                                ?>
                             </td>
                    <?php
                      }
                     }
                     else {
                    ?>
                     <td>
                               <?php
                                  echo number_format(($in_7+$d7)-($out_7),2);
                                ?>
                             </td>
                    <?php
                      }
                    ?>

                    <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-08-31') && 
                                    $date2 >=date('Y-08-01')
                                  )
                                    {

                            ?>

                             <td>
                                <?php
                                  echo number_format(($in_8+$d8)-($out_8),2);
                                ?>
                             </td>
                        <?php
                          }
                         }
                         else {
                        ?>

                        <td>
                                <?php
                                  echo number_format(($in_8+$d8)-($out_8),2);
                                ?>
                             </td>

                        <?php
                          }
                        ?>

                        <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-09-31') && 
                                    $date2 >=date('Y-09-01')
                                  )
                                    {

                            ?>


                             <td>
                                 <?php
                                  echo number_format(($in_9+$d9)-($out_9),2);
                                ?>
                             </td>
                    <?php
                      }
                     }
                     else {
                    ?>
                             <td>
                                 <?php
                                  echo number_format(($in_9+$d9)-($out_9),2);
                                ?>
                             </td>
                    <?php
                      }
                    ?>

                    <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-10-31') && 
                                    $date2 >=date('Y-10-01')
                                  )
                                    {

                            ?>



                             <td>
                                 <?php
                                  echo number_format(($in_10+$d10)-($out_10),2);
                                ?>
                             </td>
                    <?php
                       }
                      }
                      else {
                    ?>
                     <td>
                                 <?php
                                  echo number_format(($in_10+$d10)-($out_10),2);
                                ?>
                             </td>
                    <?php
                      }
                    ?>

                    <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-11-31') && 
                                    $date2 >=date('Y-11-01')
                                  )
                                    {

                            ?>

                             <td>
                                 <?php
                                  echo number_format(($in_11+$d11)-($out_11),2);
                                ?>
                             </td>
                    <?php
                       }}
                       else {
                    ?>
                     <td>
                                 <?php
                                  echo number_format(($in_11+$d11)-($out_11),2);
                                ?>
                             </td>

                <?php } ?>

                <?php
                              if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
                                if(
                                    $date1<=date('Y-12-31') && 
                                    $date2 >=date('Y-12-01')
                                  )
                                    {

                            ?>

                             <td>
                                 <?php
                                  echo number_format(($in_12+$d12)-($out_12),2);
                                ?>
                             </td>
                    <?php
                      }
                  }
                  else {
                    ?>
                    <td>
                                 <?php
                                  echo number_format(($in_12+$d12)-($out_12),2);
                                ?>
                             </td>
                    <?php
                      }
                    ?>
                        </tr>
                       

                      <?php

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