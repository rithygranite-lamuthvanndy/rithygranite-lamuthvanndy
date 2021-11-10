<?php
include_once '../../config/database.php';
include_once '../st_operation/operation.php'
?>
<link rel="stylesheet" href="../../print_offline/bootstrap.min.css">
<script src="../../print_offline/jquery.min.js"></script>
<?php
    
function myCalCostAverage_Report($arg_arr,$tr_id,$cu_out,$year)
    {
        $result = 0;
        $result = ($arg_arr['begining_bal_price'] + $arg_arr['current_in_price']) /
        MAX(($arg_arr['begining_bal_qty'] + $arg_arr['current_in_qty']), 1);
         $result=$result * $cu_out;
    echo '<input type="hidden"  class="section_data'.$tr_id.''.$year.'  section_data_y'.$year.'  
          
         " 
         value="'.round($result, 2).'"> ';
   
        return round($result, 2);
    }


  function group_by_month_report($v_date_start,$v_date_end,$year_order) {   
    global $connect;
    $date_query_function='AND E.stsout_date_out BETWEEN "'.$v_date_start.'" AND  "'.$v_date_end.'" ';
        $v_sql_report = "SELECT A.*,B.stca_name,B.stca_code,C.stun_name,B.stca_id,F.name_kh,F.name_vn,F.date_buy,F.track_price,F.note,F.id,E.stsout_date_out,F.id as tr_id,
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

                    $result_cost = myCalCostAverage_Report($v_array,$row->tr_id,$row->current_out,$year_order);

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
        
    </style>
</head>
<link rel="stylesheet" href="../../print_offline/bootstrap.min.css">
<script src="../../print_offline/jquery.min.js"></script>

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
    $v_date_start="$v_date_start-01-01";
    $v_date_end = @$_GET['p_date_end'];
    $v_date_end="$v_date_end-12-31";
    $date_query=' C.stsout_date_out BETWEEN "'.$v_date_start.'" AND  "'.$v_date_end.'" ';
     $sum_loop_year=0;  
     $start_year=@$_GET['p_date_start'];
     $end_year=@$_GET['p_date_end'];
     $sum_loop_year =($end_year - $start_year)+1;


            }
            else {
                  $v_date_start = date('Y-01-01');
     $v_date_end = date('Y-12-31');
     $date_query=' C.stsout_date_out BETWEEN "'.$v_date_start.'" AND  "'.$v_date_end.'" ';
     $sum_loop_year=1;
     $start_year=date('Y');
     $start_year=date('Y');
            }
        ?>
        <table class="table_print">
             <thead>
            <tr style="background-color: #DDEBF7;">
                        <th>No</th>
                        <th>Ngày Mua</th>
                        <th colspan="2">Tên</th>
                       <?php
                         for ($th=1; $th <=$sum_loop_year ; $th++) { 
                        
                        ?>
                        <th>ជុសជួលប្រចាំឆ្នាំ <?php echo $start_year+$th-1; ?></th>
                        <?php
                          }
                        ?>
                        
                        
                    </tr>
                    <tr style="background-color: #DDEBF7;">
                        <th rowspan="2">ល.រ</th>
                        <th rowspan="2">កាលបរិច្ឆេទទិញ</th>
                        <th colspan="2">ឈ្មោះគ្រឿងចក្រ</th>
                        <?php
                         for ($th=1; $th <=$sum_loop_year ; $th++) { 
                        
                        ?>
                        <th rowspan="2">Tổng cộng 
sửa chữa <?php echo $start_year+$th-1; ?></th>
                        <?php
                          }
                        ?>
                        
                       
                      
                    </tr>
                    <tr style="background-color: #DDEBF7;">
                       
                        <th>ខ្មែរ</th>
                        <th>វៀតណាម</th>
                    </tr>
             </thead>
              <tbody>
                    <?php



    $v_sql_track= "SELECT *  FROM tbl_st_track_machine_list  AS A
                LEFT JOIN tbl_st_stock_out_detail AS B ON A.id =B.track_mac_id
                LEFT JOIN tbl_st_stock_out AS C ON C.stsout_id=B.stsout_id
                WHERE $date_query  AND C.stock_status='3' OR C.stock_status='5'    ";  
           // echo $v_sql_report;     
    $get_data_track =$connect->query($v_sql_track);
    $j=0;

   
             $v_track_tmp = [];   
        
    while ($rows = mysqli_fetch_object($get_data_track)) {

          if (!in_array($rows->id, $v_track_tmp)) {
              array_push($v_track_tmp, $rows->id);

            for ($th=1; $th <=$sum_loop_year ; $th++) { 
                $year=$start_year+$th-1;
                  echo group_by_month_report($year.'-01-01',$year.'-01-31',$year); 
                  echo group_by_month_report($year.'-02-01',$year.'-02-31',$year); 
                  echo group_by_month_report($year.'-03-01',$year.'-03-31',$year); 
                  echo group_by_month_report($year.'-04-01',$year.'-04-31',$year); 
                  echo group_by_month_report($year.'-04-01',$year.'-05-31',$year); 
                  echo group_by_month_report($year.'-06-01',$year.'-06-31',$year); 
                  echo group_by_month_report($year.'-07-01',$year.'-07-31',$year); 
                  echo group_by_month_report($year.'-08-01',$year.'-08-31',$year); 
                  echo group_by_month_report($year.'-09-01',$year.'-09-31',$year); 
                  echo group_by_month_report($year.'-10-01',$year.'-10-31',$year); 
                  echo group_by_month_report($year.'-11-01',$year.'-11-31',$year); 
                  echo group_by_month_report($year.'-12-01',$year.'-12-31',$year); 


                       
            }

          
                        



                        
              

                    ?>
                     <tr>
                        <td><?php echo ++$j; ?></td>
                        <td><?php echo $rows->date_buy; ?></td>
                        <td><?php echo $rows->name_kh; ?></td>
                        <td><?php echo $rows->name_vn; ?></td>
                        <?php
                         for ($th=1; $th <=$sum_loop_year ; $th++) { 
                             $year=$start_year+$th-1;
                        
                        ?>
                        <td id="out_td<?php echo $rows->id.$year; ?>" class="t_y<?php echo $rows->id.$year; ?>"></td>
                        <?php
                          }
                        ?>
                    </tr>

                    <?php
                      for ($th=1; $th <=$sum_loop_year ; $th++) { 
                             $year=$start_year+$th-1;
                    ?>

                    <script type="text/javascript">
                      
                           var sum_out = 0;
                           
                           var div_tr = $('.table_print').children('tbody').children('tr').length;


                        $(".section_data<?php echo $rows->id.$year; ?>").each(function(){
                            sum_out += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var divid_sum=sum_out/div_tr;
                        var total_cost_out=divid_sum.toFixed(2);
                        $('#out_td<?php echo $rows->id.$year; ?>').html(total_cost_out);


                        


                      
                    </script>
                  <?php } ?>
                    
   <?php } } ?>

   <tr class="tr_report" style="font-weight: bold;"> 
                        <td colspan="4">Tổng cộng sửa chữa / សរុបការជួសជុល:</td>
                         <?php
                         for ($th=1; $th <=$sum_loop_year ; $th++) { 
                             $year=$start_year+$th-1;
                        
                        ?>

                        <td id="total_top_m<?php echo $year;?>"></td>
                       

                        <script type="text/javascript">
                            var sum_total_ex = 0;
                        var div_tr_total_ex = $('.table_print').children('tbody').children('tr').length-1;
                        $(".section_data_y<?php echo $year; ?>").each(function(){
                            sum_total_ex += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                       
                        
                        var div_t_total=sum_total_ex/div_tr_total_ex;
                        var total_cost_t_total=div_t_total.toFixed(2);
                        $("#total_top_m<?php echo $year; ?>").html(total_cost_t_total);
                        </script>
                        <?php
                          }
                        ?>
                        
                       
                        
                    </tr>
             </tbody>
                
        </table>


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