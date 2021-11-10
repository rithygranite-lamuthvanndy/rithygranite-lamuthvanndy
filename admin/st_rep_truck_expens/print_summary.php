<?php
include_once '../../config/database.php';
include_once '../st_operation/operation.php'
?>
<link rel="stylesheet" href="../../print_offline/bootstrap.min.css">
<script src="../../print_offline/jquery.min.js"></script>
<?php
    
function myCalCostAverage_Report($arg_arr,$tr_id,$cu_out,$month)
    {


       

        $result = 0;
        $result = ($arg_arr['begining_bal_price'] + $arg_arr['current_in_price']) /
        MAX(($arg_arr['begining_bal_qty'] + $arg_arr['current_in_qty']), 1);
         $result=$result * $cu_out;
         echo '<input type="hidden" class="section_data'.$tr_id.''.$month.' section_data'.$tr_id.' 
         section_data_m'.$month.' total_ex
         " 
         value="'.round($result, 2).'"> ';
   
        return round($result, 2);
    }


  function group_by_month_report($v_date_start,$v_date_end,$motn_order) {
    global $connect;
    $date_query_function='AND E.stsout_date_out BETWEEN "'.$v_date_start.'" AND  "'.$v_date_end.'" ';
        $v_sql_report = "SELECT A.*,B.stca_name,B.stca_code,C.stun_name,B.stca_id,F.name_kh,F.name_vn,F.date_buy,F.track_price,F.note,F.id,E.stsout_date_out,F.id as tr_id,
    YEAR(E.stsout_date_out) AS sy, MONTH(E.stsout_date_out) AS sm,
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
                    LEFT JOIN tbl_st_track_machine_list AS CC ON CC.id=BB.track_mac_id
                    WHERE  AA.stsout_date_out BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id AND F.id=BB.track_mac_id
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
                 WHERE A.stpron_material_type='3' OR A.stpron_material_type='5' AND E.stock_status='3' OR 
                E.stock_status='5' 
                $date_query_function 
                
                HAVING 

                (
                    (
                        SELECT IFNULL(SUM(in_qty),0)
                        FROM tbl_st_stock_in AS AA 
                        LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                        WHERE AA.stsin_date_in<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id ORDER BY F.id
                    )-
                    (
                        SELECT IFNULL(SUM(out_qty),0)
                        FROM tbl_st_stock_out AS AA 
                        LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
                        WHERE AA.stsout_date_out<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id ORDER BY F.id
                    )+
                    (
                        SELECT IFNULL(SUM(qty_adjust),0)
                        FROM tbl_st_stock_adjustment AS AA 
                        LEFT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
                        WHERE  AA.stsadj_date_record BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                        AND BB.pro_id=A.stpron_id ORDER BY F.id
                    )
                )>0 OR 
                (
                    SELECT SUM(in_qty) 
                    FROM tbl_st_stock_in AS AA 
                    LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                    WHERE  AA.stsin_date_in BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id ORDER BY F.id
                )>0 OR
                (
                    SELECT SUM(out_qty) 
                    FROM tbl_st_stock_out AS AA 
                    LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
                    WHERE  AA.stsout_date_out BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id ORDER BY F.id
                )>0 
                OR 
                (
                    SELECT SUM(qty_adjust)
                    FROM tbl_st_stock_adjustment AS AA 
                    LEFT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
                    WHERE  AA.stsadj_date_record BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id ORDER BY F.id
                )<>0 
                     ";  

           // echo $v_sql_report;  
           // exit();   
    $get_data =$connect->query($v_sql_report);
   
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
                $total_cost=0;
               
        
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

                    $result_cost = myCalCostAverage_Report($v_array,$row->tr_id,$row->current_out,$motn_order);

                    $v_last_qty = ($v_begining_bal_qty + $v_current_in_qty - @$row->current_out + @$row->current_adjust);
                    // =========================== End Calculation ====================


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
            background-color: #DDEBF7 !important;

        }
        .table_print>thead>tr>th {
    vertical-align: bottom;
    border-bottom:1px solid black !important;
}
        
    </style>
</head>


<body>
    <div class="main_border">
        <?php
     
      
            echo '<h3>របាយការណ៍ជួសជុលគ្រឿងចក្រ ' . @$_GET['p_date_start'] . ' - ' . @$_GET['p_date_end'] . '</h3>';
      
        ?>
        <h4>Báo Cáo Sửa Chữa Cơ Giới</h4>
        <br>
        <!-- Table Decription -->
        <?php
          if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
               $v_date_start = @$_GET['p_date_start'];
    $v_date_end = @$_GET['p_date_end'];
    $date_query=' C.stsout_date_out BETWEEN "'.$v_date_start.'" AND  "'.$v_date_end.'" ';

    $year = date("Y", strtotime($v_date_start));


            }
            else {
                     $v_date_start = date('Y-01-01');
     $v_date_end = date('Y-12-31');
     $date_query=' C.stsout_date_out BETWEEN "'.$v_date_start.'" AND  "'.$v_date_end.'" ';
     $year=date('Y');
            }
        ?>

        

        <table class="table_print">
             <thead>
            <tr style="background-color: #e7ecf1;">
                        <th>No</th>
                        <th>Ngày Mua</th>
                        <th colspan="2">Tên</th>
                        <th>Giá</th>
                        <th>%</th>
                       <!--  <th>Chức năng</th>
                        <th>Tổng cộng sửa chữa</th> -->
                        <th>Tổng cộng sửa chữa</th>
                        <th>Tổng cộng sửa chữa</th>
                        <?php
                        $row_s1=0;
                        $row_s2=0;
                        $row_s3=0;
                        $row_s4=0;
                        $row_s5=0;
                        $row_s6=0;
                        $row_s7=0;
                        $row_s8=0;
                        $row_s9=0;
                        $row_s10=0;
                        $row_s11=0;
                        $row_s12=0;
                        $total_row_s=0;
                          if($v_date_end >=date("$year-01-01") 

                             && $v_date_start <=date("$year-01-31") 
                              )  {
                            $row_s1=1;

                        ?>
                        <th>tháng 1</th>
                    <?php } else {$row_s1=0;} ?>
                    <?php
                          if($v_date_end >=date("$year-02-01") 

                             && $v_date_start <=date("$year-02-31") 
                              )  {
                            $row_s2=1;
                        ?>
                        <th>tháng 2</th>
                    <?php } else {$row_s2=0;} ?>

                    <?php
                          if($v_date_end >=date("$year-03-01") 

                             && $v_date_start <=date("$year-03-31") 
                              )  {
                            $row_s3=1;
                        ?>
                        <th>tháng 3</th>
                    <?php } else {$row_s3=0;} ?>
                    <?php
                          if($v_date_end >=date("$year-04-01") 

                             && $v_date_start <=date("$year-04-31") 
                              )  {
                            $row_s4=1;
                        ?>
                        <th>tháng 4</th>
                    <?php } else {$row_s4=0;} ?>
                    <?php
                          if($v_date_end >=date("$year-05-01") 

                             && $v_date_start <=date("$year-05-31") 
                              )  {
                            $row_s5=1;
                        ?>
                        <th>tháng 5</th>
                    <?php } else {$row_s5=0;} ?>
                    <?php
                          if($v_date_end >=date("$year-06-01") 

                             && $v_date_start <=date("$year-06-31") 
                              )  {
                            $row_s6=1;
                        ?>
                        <th>tháng 6</th>
                    <?php } else {$row_s6=0;} ?>
                    <?php
                          if($v_date_end >=date("$year-07-01") 

                             && $v_date_start <=date("$year-07-31") 
                              )  {
                            $row_s7=1;
                        ?>
                        <th>tháng 7</th>
                    <?php } else {$row_s7=0;} ?>
                    <?php
                          if($v_date_end >=date("$year-08-01") 

                             && $v_date_start <=date("$year-08-31") 
                              )  {
                            $row_s8=1;
                        ?>
                        <th>tháng 8</th>
                    <?php } else {$row_s8=0;} ?>
                    <?php
                          if($v_date_end >=date("$year-09-01") 

                             && $v_date_start <=date("$year-09-31") 
                              )  {
                            $row_s9=1;
                        ?>
                        <th>tháng 9</th>
                    <?php } else {$row_s9=0;} ?>
                    <?php
                          if($v_date_end >=date("$year-10-01") 

                             && $v_date_start <=date("$year-10-31") 
                              )  {
                            $row_s10=1;
                        ?>
                        <th>tháng 10</th>
                    <?php } else {$row_s10=0;} ?>
                <?php
                          if($v_date_end >=date("$year-11-01") 

                             && $v_date_start <=date("$year-11-31") 
                              )  {
                            $row_s11=1;
                        ?>
                        <th>tháng 11</th>
                    <?php } else {$row_s11=0;} ?>
                    <?php
                          if($v_date_end >=date("$year-12-01") 

                             && $v_date_start <=date("$year-12-31") 
                              )  {
                            $row_s12=1;
                        ?>
                        <th>tháng 12</th>
                    <?php } else {$row_s12=0;} ?>
                    </tr>
                    <tr style="background-color: #e7ecf1;">
                        <th rowspan="2">ល.រ</th>
                        <th rowspan="2">កាលបរិច្ឆេទទិញ</th>
                        <th colspan="2">ឈ្មោះគ្រឿងចក្រ</th>
                        <!-- <th></th> -->
                        <th rowspan="2">តម្លៃគ្រឿងចក្រ</th>
                        <th rowspan="2">%</th>
                        <th rowspan="2">មុខងារនិងប្រចាំការ</th>
                       <!--  <th rowspan="2">សរុបការជុសជួលទាំងអស់</th>
                        <th rowspan="2">សរុបការជុសជួលទាំងអស់ ២០១៨</th> -->
                        <th rowspan="2">សរុបការជុសជួលទាំងអស់</th>
                        <?php
                        $total_row_s=$row_s1+$row_s2+$row_s3+$row_s4+$row_s5+$row_s6+$row_s7+$row_s8+$row_s9+$row_s10+$row_s11+$row_s12;
                        ?>

                        <th colspan="<?php echo $total_row_s; ?>">ទឹកប្រាក់ជួសជុលតាមខែ</th>
                      
                    </tr>
                    <tr style="background-color: #e7ecf1;">
                       
                        <th>ខ្មែរ</th>
                        <th>វៀតណាម</th>
                        <?php
                          if($v_date_end >=date("$year-01-01") 

                             && $v_date_start <=date("$year-01-31") 
                              )  {
                        ?>
                        
                        <th>Jan 1</th>
                    <?php } ?>
                <?php
                          if($v_date_end >=date("$year-02-01") 

                             && $v_date_start <=date("$year-02-31") 
                              )  {
                        ?>
                        <th>Feb 2</th>
                    <?php } ?>
                <?php
                          if($v_date_end >=date("$year-03-01") 

                             && $v_date_start <=date("$year-03-31") 
                              )  {
                        ?>
                        <th>Mar 3</th>
                    <?php } ?>
                    <?php
                          if($v_date_end >=date("$year-04-01") 

                             && $v_date_start <=date("$year-04-31") 
                              )  {
                        ?>
                        <th>Apr 4</th>
                    <?php } ?>
                    <?php
                          if($v_date_end >=date("$year-05-01") 

                             && $v_date_start <=date("$year-05-31") 
                              )  {
                        ?>
                        <th>May 5</th>
                    <?php  } ?>
                <?php
                          if($v_date_end >=date("$year-06-01") 

                             && $v_date_start <=date("$year-06-31") 
                              )  {
                        ?>
                        <th>Jun 6</th>
                <?php } ?>
                <?php
                          if($v_date_end >=date("$year-07-01") 

                             && $v_date_start <=date("$year-07-31") 
                              )  {
                        ?>
                        <th>Jul 7</th>
                    <?php } ?>
                <?php
                          if($v_date_end >=date("$year-08-01") 

                             && $v_date_start <=date("$year-08-31") 
                              )  {
                        ?>
                        <th>Aug 8</th>
                    <?php } ?>
                <?php
                          if($v_date_end >=date("$year-09-01") 

                             && $v_date_start <=date("$year-09-31") 
                              )  {
                        ?>
                        <th>Sep 9</th>
                    <?php  } ?>
                <?php
                          if($v_date_end >=date("$year-10-01") 

                             && $v_date_start <=date("$year-10-31") 
                              )  {
                        ?>
                        <th>Oct 10</th>
                    <?php } ?>
                    <?php
                          if($v_date_end >=date("$year-11-01") 

                             && $v_date_start <=date("$year-11-31") 
                              )  {
                        ?>

                        <th>Nov 11</th>
                    <?php } ?>
                <?php
                          if($v_date_end >=date("$year-12-01") 

                             && $v_date_start <=date("$year-12-31") 
                              )  {
                        ?>
                        <th>Dec 12</th>
                    <?php } ?>
                    </tr>
                </thead>
                <tbody>
               <?php
    $v_sql_track= "SELECT *  FROM tbl_st_track_machine_list  AS A
                LEFT JOIN tbl_st_stock_out_detail AS B ON A.id =B.track_mac_id
                LEFT JOIN tbl_st_stock_out AS C ON C.stsout_id=B.stsout_id
                WHERE $date_query  AND C.stock_status='3' OR C.stock_status='5'   ";  
            //echo $v_sql_track;     
    $get_data_track =$connect->query($v_sql_track);
    $i=0;

   
             $v_track_tmp = [];   
        
    while ($rows = mysqli_fetch_object($get_data_track)) {

       if (!in_array($rows->id, $v_track_tmp)) {
                      array_push($v_track_tmp, $rows->id);

                    ?>

                   <?php

                            if($v_date_end >=date("$year-01-01") 

                             && $v_date_start <=date("$year-01-31") 
                              ) 
                            {

                                echo group_by_month_report(
                                    date("$year-01-01"),
                                    date("$year-01-31"),'01');    
                            }

                            if($v_date_end >=date("$year-02-01") 

                             && $v_date_start <=date("$year-02-31") 
                              ) 
                            {

                                echo group_by_month_report(
                                    date("$year-02-01"),
                                    date("$year-02-31"),'02');    
                            }
                            if($v_date_end >=date("$year-03-01") 

                             && $v_date_start <=date("$year-03-31") 
                              ) 
                            {

                                echo group_by_month_report(
                                    date("$year-03-01"),
                                    date("$year-03-31"),'03');    
                            }

                            if($v_date_end >=date("$year-04-01") 

                             && $v_date_start <=date("$year-04-31") 
                              ) 
                            {

                                echo group_by_month_report(
                                    date("$year-04-01"),
                                    date("$year-04-31"),'04');    
                            }

                            if($v_date_end >=date("$year-05-01") 

                             && $v_date_start <=date("$year-05-31") 
                              ) 
                            {

                                echo group_by_month_report(
                                    date("$year-05-01"),
                                    date("$year-05-31"),'05');    
                            }

                            if($v_date_end >=date("$year-06-01") 

                             && $v_date_start <=date("$year-06-31") 
                              ) 
                            {

                                echo group_by_month_report(
                                    date("$year-06-01"),
                                    date("$year-06-31"),'06');    
                            }

                            if($v_date_end >=date("$year-07-01") 

                             && $v_date_start <=date("$year-07-31") 
                              ) 
                            {

                                echo group_by_month_report(
                                    date("$year-07-01"),
                                    date("$year-07-31"),'07');    
                            }
                            if($v_date_end >=date("$year-08-01") 

                             && $v_date_start <=date("$year-08-31") 
                              ) 
                            {

                                echo group_by_month_report(
                                    date("$year-08-01"),
                                    date("$year-08-31"),'08');    
                            }

                            if($v_date_end >=date("$year-09-01") 

                             && $v_date_start <=date("$year-09-31") 
                              ) 
                            {

                                echo group_by_month_report(
                                    date("$year-09-01"),
                                    date("$year-09-31"),'09');    
                            }
                            if($v_date_end >=date("$year-10-01") 

                             && $v_date_start <=date("$year-10-31") 
                              ) 
                            {

                                echo group_by_month_report(
                                    date("$year-10-01"),
                                    date("$year-10-31"),'10');    
                            }
                            if($v_date_end >=date("$year-11-01") 

                             && $v_date_start <=date("$year-11-31") 
                              ) 
                            {

                                echo group_by_month_report(
                                    date("$year-11-01"),
                                    date("$year-11-31"),'11');    
                            }

                            if($v_date_end >=date("$year-12-01") 

                             && $v_date_start <=date("$year-12-31")
                              ) 
                            {



                                echo group_by_month_report(
                                    date("$year-12-01"),
                                    date("$year-12-31"),'12');  
                                  
                            }

                           


                            
                            
                             
                              
                            
                              
                            
                              
                             
                             
                              
                              
                             
                             
                         
                   ?>
                <div class="table_tr">
                    <tr>
                        <td><?php echo (++$i); ?></td>
                        <td><?php echo $rows->date_buy; ?></td>
                        <td><?php echo $rows->name_kh; ?></td>
                        <td><?php echo $rows->name_vn; ?></td>
                        <td><?php echo $rows->track_price; ?></td>
                        <td></td>
                        <td><?php echo $rows->note; ?></td>
                        <td id="total_this_year<?php echo $rows->id; ?>"></td>
                        <?php
                          if($v_date_end >=date("$year-01-01") 

                             && $v_date_start <=date("$year-01-31") 
                              )  {
                        ?>
                        <td id="out_td<?php echo $rows->id; ?>01" class="t_y<?php echo $rows->id; ?>"></td>
                        <?php } ?>
                        <?php
                          if($v_date_end >=date("$year-02-01") 

                             && $v_date_start <=date("$year-02-31") 
                              )  {
                        ?>
                        <td id="out_td<?php echo $rows->id; ?>02" class="t_y<?php echo $rows->id; ?>"></td>
                        <?php } ?>
                        <?php
                          if($v_date_end >=date("$year-03-01") 

                             && $v_date_start <=date("$year-03-31") 
                              )  {
                        ?>
                        <td id="out_td<?php echo $rows->id; ?>03" class="t_y<?php echo $rows->id; ?>"></td>
                        <?php } ?>
                    <?php
                          if($v_date_end >=date("$year-04-01") 

                             && $v_date_start <=date("$year-04-31") 
                              )  {
                        ?>
                        <td id="out_td<?php echo $rows->id; ?>04" class="t_y<?php echo $rows->id; ?>"></td>
                        <?php } ?>
                        <?php
                          if($v_date_end >=date("$year-05-01") 

                             && $v_date_start <=date("$year-05-31") 
                              )  {
                        ?>
                        <td id="out_td<?php echo $rows->id; ?>05" class="t_y<?php echo $rows->id; ?>"></td>
                       <?php } ?>
                       <?php
                          if($v_date_end >=date("$year-06-01") 

                             && $v_date_start <=date("$year-06-31") 
                              )  {
                        ?> 
                        <td id="out_td<?php echo $rows->id; ?>06" class="t_y<?php echo $rows->id; ?>"></td>
                        <?php } ?>
                    <?php
                          if($v_date_end >=date("$year-07-01") 

                             && $v_date_start <=date("$year-07-31") 
                              )  {
                        ?>
                        <td id="out_td<?php echo $rows->id; ?>07" class="t_y<?php echo $rows->id; ?>"></td>
                       <?php } ?>
                    <?php
                          if($v_date_end >=date("$year-08-01") 

                             && $v_date_start <=date("$year-08-31") 
                              )  {
                        ?> 
                        <td id="out_td<?php echo $rows->id; ?>08" class="t_y<?php echo $rows->id; ?>"></td>
                     <?php } ?>
                     <?php
                          if($v_date_end >=date("$year-09-01") 

                             && $v_date_start <=date("$year-09-31") 
                              )  {
                        ?>  
                        <td id="out_td<?php echo $rows->id; ?>09" class="t_y<?php echo $rows->id; ?>"></td>
                       <?php } ?>
                       <?php
                          if($v_date_end >=date("$year-10-01") 

                             && $v_date_start <=date("$year-10-31") 
                              )  {
                        ?>
                        <td id="out_td<?php echo $rows->id; ?>10" class="t_y<?php echo $rows->id; ?>"></td>
                        <?php } ?>
                    <?php
                          if($v_date_end >=date("$year-11-01") 

                             && $v_date_start <=date("$year-11-31") 
                              )  {
                        ?>
                        <td id="out_td<?php echo $rows->id; ?>11" class="t_y<?php echo $rows->id; ?>"></td>
                        <?php } ?>
                        <?php
                          if($v_date_end >=date("$year-12-01") 

                             && $v_date_start <=date("$year-12-31") 
                              )  {
                        ?>
                        <td id="out_td<?php echo $rows->id; ?>12" class="t_y<?php echo $rows->id; ?>"></td>
                    <?php } ?>
                    </tr>
                </div>
                   
                     <div style="display:hidden;">
                    <script type="text/javascript">
                        $(document).ready(function() {


                        var sum_out01 = 0;
                        var div_tr01 = $('.table_print').children('tbody').children('tr').length-2;

                        $(".section_data<?php echo $rows->id; ?>01").each(function(){
                            sum_out01 += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var divid_sum01=sum_out01/div_tr01;
                        var total_cost_out01=divid_sum01.toFixed(2);
                        $('#out_td<?php echo $rows->id; ?>01').html(total_cost_out01);



                        var sum_out02 = 0;
                        var div_tr02 = $('.table_print').children('tbody').children('tr').length-2;

                        $(".section_data<?php echo $rows->id; ?>02").each(function(){
                            sum_out02 += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var divid_sum02=sum_out02/div_tr02;
                        var total_cost_out02=divid_sum02.toFixed(2);
                        $('#out_td<?php echo $rows->id; ?>02').html(total_cost_out02);


                        var sum_out03 = 0;
                        var div_tr03 = $('.table_print').children('tbody').children('tr').length-2;

                        $(".section_data<?php echo $rows->id; ?>03").each(function(){
                            sum_out03 += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var divid_sum03=sum_out03/div_tr03;
                        var total_cost_out03=divid_sum03.toFixed(2);
                        $('#out_td<?php echo $rows->id; ?>03').html(total_cost_out03);


                        var sum_out04 = 0;
                        var div_tr04 = $('.table_print').children('tbody').children('tr').length-2;

                        $(".section_data<?php echo $rows->id; ?>04").each(function(){
                            sum_out04 += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var divid_sum04=sum_out04/div_tr04;
                        var total_cost_out04=divid_sum04.toFixed(2);
                        $('#out_td<?php echo $rows->id; ?>04').html(total_cost_out04);



                        var sum_out05 = 0;
                        var div_tr05 = $('.table_print').children('tbody').children('tr').length-2;

                        $(".section_data<?php echo $rows->id; ?>05").each(function(){
                            sum_out05 += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var divid_sum05=sum_out05/div_tr05;
                        var total_cost_out05=divid_sum05.toFixed(2);
                        $('#out_td<?php echo $rows->id; ?>05').html(total_cost_out05);

                        var sum_out06 = 0;
                        var div_tr06 = $('.table_print').children('tbody').children('tr').length-2;

                        $(".section_data<?php echo $rows->id; ?>06").each(function(){
                            sum_out06 += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var divid_sum06=sum_out06/div_tr06;
                        var total_cost_out06=divid_sum06.toFixed(2);
                        $('#out_td<?php echo $rows->id; ?>06').html(total_cost_out06);


                        var sum_out07 = 0;
                        var div_tr07 = $('.table_print').children('tbody').children('tr').length-2;

                        $(".section_data<?php echo $rows->id; ?>07").each(function(){
                            sum_out07 += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var divid_sum07=sum_out07/div_tr07;
                        var total_cost_out07=divid_sum07.toFixed(2);
                        $('#out_td<?php echo $rows->id; ?>07').html(total_cost_out07);


                        var sum_out08 = 0;
                        var div_tr08 = $('.table_print').children('tbody').children('tr').length-2;

                        $(".section_data<?php echo $rows->id; ?>08").each(function(){
                            sum_out08 += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var divid_sum08=sum_out08/div_tr08;
                        var total_cost_out08=divid_sum08.toFixed(2);
                        $('#out_td<?php echo $rows->id; ?>08').html(total_cost_out08);


                        var sum_out09 = 0;
                        var div_tr09 = $('.table_print').children('tbody').children('tr').length-2;

                        $(".section_data<?php echo $rows->id; ?>09").each(function(){
                            sum_out09 += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var divid_sum09=sum_out09/div_tr09;
                        var total_cost_out09=divid_sum09.toFixed(2);
                        $('#out_td<?php echo $rows->id; ?>09').html(total_cost_out09);


                        var sum_out10 = 0;
                        var div_tr10 = $('.table_print').children('tbody').children('tr').length-2;

                        $(".section_data<?php echo $rows->id; ?>10").each(function(){
                            sum_out10 += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var divid_sum10=sum_out10/div_tr10;
                        var total_cost_out10=divid_sum10.toFixed(2);
                        $('#out_td<?php echo $rows->id; ?>10').html(total_cost_out10);

                        

                        var sum_out11 = 0;
                        var div_tr11 = $('.table_print').children('tbody').children('tr').length-2;

                        $(".section_data<?php echo $rows->id; ?>11").each(function(){
                            sum_out11 += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var divid_sum11=sum_out11/div_tr11;
                        var total_cost_out11=divid_sum11.toFixed(2);
                        $('#out_td<?php echo $rows->id; ?>11').html(total_cost_out11);



                        var sum_out12 = 0;
                        var div_tr12 = $('.table_print').children('tbody').children('tr').length-2;

                        $(".section_data<?php echo $rows->id; ?>12").each(function(){
                            sum_out12 += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var divid_sum12=sum_out12/div_tr12;
                        var total_cost_out12=divid_sum12.toFixed(2);
                        $('#out_td<?php echo $rows->id; ?>12').html(total_cost_out12);



                        // total year
                        var sum_this_year = 0;
                        var div_tr_this_year = $('.table_print').children('tbody').children('tr').length-2;



                        $(".section_data<?php echo $rows->id; ?>").each(function(){

                            sum_this_year += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var div_t_y=sum_this_year/div_tr_this_year;
                        
                        var total_cost_this_year=div_t_y.toFixed(2);
                        $('#total_this_year<?php echo $rows->id; ?>').html(total_cost_this_year);



                        // End total year

                        

                         })
                   </script>
               </div>


              
                    
               <?php 

           } 

               ?>

                <?php  }

                 ?>
   

                    <tr class="tr_report" style="font-weight: bold;background: #F2F2DB !important;"> 
                        <td colspan="7">Tổng cộng sửa chữa / សរុបការជួសជុល:</td>
                        <td id="total_top_m"></td>
                        <?php
                          if($v_date_end >=date("$year-01-01") 

                             && $v_date_start <=date("$year-01-31") 
                              )  {
                        ?>
                        <td id="total_top_m1"></td>
                    <?php } ?>
                    <?php
                          if($v_date_end >=date("$year-02-01") 

                             && $v_date_start <=date("$year-02-31") 
                              )  {
                        ?>
                        <td id="total_top_m2"></td>
                    <?php } ?>
                  <?php
                          if($v_date_end >=date("$year-03-01") 

                             && $v_date_start <=date("$year-03-31") 
                              )  {
                        ?>
                        <td id="total_top_m3"></td>
                <?php } ?>
                <?php
                          if($v_date_end >=date("$year-04-01") 

                             && $v_date_start <=date("$year-04-31") 
                              )  {
                        ?>
                        <td id="total_top_m4"></td>
                <?php } ?>
                <?php
                          if($v_date_end >=date("$year-05-01") 

                             && $v_date_start <=date("$year-05-31") 
                              )  {
                        ?>
                        <td id="total_top_m5"></td>
                    <?php } ?>
                <?php
                          if($v_date_end >=date("$year-06-01") 

                             && $v_date_start <=date("$year-06-31") 
                              )  {
                        ?>
                        <td id="total_top_m6"></td>
                    <?php } ?>
                <?php
                          if($v_date_end >=date("$year-07-01") 

                             && $v_date_start <=date("$year-07-31") 
                              )  {
                        ?>
                        <td id="total_top_m7"></td>
                    <?php } ?>
                    <?php
                          if($v_date_end >=date("$year-08-01") 

                             && $v_date_start <=date("$year-08-31") 
                              )  {
                        ?>
                        <td id="total_top_m8"></td>
                    <?php } ?>
                <?php
                          if($v_date_end >=date("$year-09-01") 

                             && $v_date_start <=date("$year-09-31") 
                              )  {
                        ?>
                        <td id="total_top_m9"></td>
                    <?php } ?>
                <?php
                          if($v_date_end >=date("$year-10-01") 

                             && $v_date_start <=date("$year-10-31") 
                              )  {
                        ?>
                        <td id="total_top_m10"></td>
                    <?php } ?>
                <?php
                          if($v_date_end >=date("$year-11-01") 

                             && $v_date_start <=date("$year-11-31") 
                              )  {
                        ?>
                        <td id="total_top_m11"></td>
                    <?php } ?>
                <?php
                          if($v_date_end >=date("$year-12-01") 

                             && $v_date_start <=date("$year-12-31") 
                              )  {
                        ?>
                        <td id="total_top_m12"></td>
                    <?php } ?>
                        
                    </tr>
                    <tr class="tr_report" style="font-weight: bold;">
                       <!--  <td colspan="7">Tổng cộng Mở mặt mỏ đá Suy nghĩ m2 / សរុបលទ្ធផលបើមុខនៅរណ្ដៅគិតជា m2:</td>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                        <td>5</td>
                        <td>6</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td> -->
                        
                    </tr>
                </table>
                
        


    </div>
    <style type="text/css">
        
        .tr_report  {
            background: #F2F2DB !important;
            border:1px solid  black !important;

        }
        th {
            text-align: center;
        }
        .myselect2 {
            width: 100% !important;
        }
    </style>

    <script type="text/javascript">
        $(document).ready(function(){

            // Total month by month
                        var sum_this_month1 = 0;
                        var div_tr_this_month1 = $('.table_print').children('tbody').children('tr').length-2;
                        $(".section_data_m01").each(function(){
                            sum_this_month1 += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var div_t_m1=sum_this_month1/div_tr_this_month1;
                        var total_cost_this_m1=div_t_m1.toFixed(2);
                        $('#total_top_m1').html(total_cost_this_m1);


                        var sum_this_month2 = 0;
                        var div_tr_this_month2 = $('.table_print').children('tbody').children('tr').length-2;
                        $(".section_data_m02").each(function(){
                            sum_this_month2 += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var div_t_m2=sum_this_month2/div_tr_this_month2;
                        var total_cost_this_m2=div_t_m2.toFixed(2);
                        $('#total_top_m2').html(total_cost_this_m2);

                        var sum_this_month3 = 0;
                        var div_tr_this_month3 = $('.table_print').children('tbody').children('tr').length-2;
                        $(".section_data_m03").each(function(){
                            sum_this_month3 += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var div_t_m3=sum_this_month3/div_tr_this_month3;
                        var total_cost_this_m3=div_t_m3.toFixed(2);
                        $('#total_top_m3').html(total_cost_this_m3);

                        var sum_this_month4 = 0;
                        var div_tr_this_month4 = $('.table_print').children('tbody').children('tr').length-2;
                        $(".section_data_m04").each(function(){
                            sum_this_month4 += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var div_t_m4=sum_this_month4/div_tr_this_month4;
                        var total_cost_this_m4=div_t_m4.toFixed(2);
                        $('#total_top_m4').html(total_cost_this_m4);

                        var sum_this_month5 = 0;
                        var div_tr_this_month5 = $('.table_print').children('tbody').children('tr').length-2;
                        $(".section_data_m05").each(function(){
                            sum_this_month5 += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var div_t_m5=sum_this_month5/div_tr_this_month5;
                        var total_cost_this_m5=div_t_m5.toFixed(2);
                        $('#total_top_m5').html(total_cost_this_m5);


                        var sum_this_month6 = 0;
                        var div_tr_this_month6 = $('.table_print').children('tbody').children('tr').length-2;
                        $(".section_data_m06").each(function(){
                            sum_this_month6 += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var div_t_m6=sum_this_month6/div_tr_this_month6;
                        var total_cost_this_m6=div_t_m6.toFixed(2);
                        $('#total_top_m6').html(total_cost_this_m6);


                        var sum_this_month7 = 0;
                        var div_tr_this_month7 = $('.table_print').children('tbody').children('tr').length-2;
                        $(".section_data_m07").each(function(){
                            sum_this_month7 += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var div_t_m7=sum_this_month7/div_tr_this_month7;
                        var total_cost_this_m7=div_t_m7.toFixed(2);
                        $('#total_top_m7').html(total_cost_this_m7);


                        var sum_this_month8 = 0;
                        var div_tr_this_month8 = $('.table_print').children('tbody').children('tr').length-2;
                        $(".section_data_m08").each(function(){
                            sum_this_month8 += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var div_t_m8=sum_this_month8/div_tr_this_month8;
                        var total_cost_this_m8=div_t_m8.toFixed(2);
                        $('#total_top_m8').html(total_cost_this_m8);


                        var sum_this_month9 = 0;
                        var div_tr_this_month9 = $('.table_print').children('tbody').children('tr').length-2;
                        $(".section_data_m09").each(function(){
                            sum_this_month9 += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var div_t_m9=sum_this_month9/div_tr_this_month9;
                        var total_cost_this_m9=div_t_m9.toFixed(2);
                        $('#total_top_m9').html(total_cost_this_m9);


                        var sum_this_month10 = 0;
                        var div_tr_this_month10 = $('.table_print').children('tbody').children('tr').length-2;
                        $(".section_data_m10").each(function(){
                            sum_this_month10 += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var div_t_m10=sum_this_month10/div_tr_this_month10;
                        var total_cost_this_m10=div_t_m10.toFixed(2);
                        $('#total_top_m10').html(total_cost_this_m10);


                        var sum_this_month11 = 0;
                        var div_tr_this_month11 = $('.table_print').children('tbody').children('tr').length-2;
                        $(".section_data_m11").each(function(){
                            sum_this_month11 += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var div_t_m11=sum_this_month11/div_tr_this_month11;
                        var total_cost_this_m11=div_t_m11.toFixed(2);
                        $('#total_top_m11').html(total_cost_this_m11);


                        var sum_this_month12 = 0;
                        var div_tr_this_month12 = $('.table_print').children('tbody').children('tr').length-2;
                        $(".section_data_m12").each(function(){
                            sum_this_month12 += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var div_t_m12=sum_this_month12/div_tr_this_month12;
                        var total_cost_this_m12=div_t_m12.toFixed(2);
                        $('#total_top_m12').html(total_cost_this_m12);


                        var sum_total_ex = 0;
                        var div_tr_total_ex = $('.table_print').children('tbody').children('tr').length-2;
                        $(".total_ex").each(function(){
                            sum_total_ex += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var div_t_total=sum_total_ex/div_tr_total_ex;
                        var total_cost_t_total=div_t_total.toFixed(2);
                        $('#total_top_m').html(total_cost_t_total);



                        





                        // end total month by monh

        });
    </script>
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