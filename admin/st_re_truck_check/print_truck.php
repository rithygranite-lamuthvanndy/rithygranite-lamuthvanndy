<?php
include_once '../../config/database.php';
include_once 'operation.php';
include_once 'function.php';
?>


<?php
    
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
        .bg-blue {
    background: #3598dc!important;
        }
        .pull-right_color ,.pull-left_color{
            color: red !important;
        }
        .pull-left_color {
            float: left;
        }
        .pull-right_color {
            float: right;
        }
        .text-right {
            text-align: right !important;
            color: black;
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
         .bg_color {
      background: #b0d8f1!important;
    }
    .bg_col_span {
     background: #e0e7ea!important;
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
<script type="text/javascript" src="../../plugin/numeral/numeral.min.js"></script>


<body>
    <div class="main_border">
    <center>
        <?php
     
      
            echo '<h3>តារាងតាមដានការជួសជុលគ្រឿងចក្រ ' . date('d/m/Y', strtotime($date1)) . ' - ' . date('d/m/Y', strtotime($date2)) . '</h3>';
      
        ?>
        <h4>Bảng theo gíoi sửa chưã cơ giới</h4>
        <br>
    </center>
  </div>
     <?php
      
    
    $v_sql_report = "SELECT A.* 
                FROM tbl_st_track_machine_list AS A 
                $query_truck
                ";
               
    $get_data =$connect->query($v_sql_report);

    while ($rows = mysqli_fetch_object($get_data)) {
   
      $truck_id=$rows->id;


     
      
      
?>
    <div class="main_border">
        
        <div class="row">
        <div class="col-xs-12">
            
            <label>ឈ្មោះគ្រឿងចក្រ: <span class="text-primary"><?= $rows->name_vn ?></span></label><br>
            <label>កាលបរិច្ឆេទទិញ: <span class="text-primary"><?= $rows->date_buy ?></span></label><br>
            <label>តម្លៃគ្រឿងចក្រ: <span class="text-primary"><?= $rows->track_price ?></span></label><br>
        </div>
    </div>
        <!-- Table Decription -->
        <table>
            <thead>
               
               
                 <tr class="bg_color">
                        <th rowspan="2">N°</th>
                        <th>ថ្ងៃខែឆ្នាំ</th>
                        <th>លេខសំណើរ</th>
                        <th>ឈ្មោះសំភារះ</th>
                        <th>ទំហំ</th>
                        <th>ចំនួន</th>
                        <th>ឯកតា</th>
                        <th>តម្លៃរាយ</th>
                        <th>សរុប</th>
                        <th>សរុបក្នុងខែ</th>
                    </tr>
                    <tr class="bg_color">
                       
                        <th>Ngày/Tháng/Năm</th>
                        <th>Số Đề Nghị</th>
                        <th>Tên hàng</th>
                        <th>Kích thước</th>
                        <th>số lưởng</th>
                        <th>đơn vi</th>
                        <th>giá</th>
                        <th>Giá tông</th>
                        <th>tông công</th>
                    </tr>
            </thead>

            <tbody>
                 <?php
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

                   

                    

                    
                    // getTotalMonthly($p_result);
                    
                    
                         $v_total_monthly = 0;
                     
                    
                    while ($row = mysqli_fetch_object($v_result)) {
                         if($row->pro_id !="") {


                        if ($v_gounp_month_year != $row->group_month) {

                            ++$status_month;
                            
                            // $v_total_monthly = 0;
                            echo '<tr class="bg_col_span" data_month="dd' . $status_month . '">';
                            echo '<td style="text-align:left !important;"  colspan="10">ខែ ' . $row->group_month . '</td>';
                            echo '</tr>';
                            $v_gounp_month_year = $row->group_month;
                            $is_new_month = true;
                        } else {
                            $is_new_month = false;
                        }
                        
 $v_unit_price = getCostPerProductName($row->stsout_date_out, $row->pro_id,$row->stock_status);
                        

                       
                        echo '<tr data_price_each="' . $status_month . '" row_group="' . $row->group_row_monthly . '">';
                        echo '<td>' . (++$i) . '</td>';
                        echo '<td>' . $row->stsout_date_out . '</td>';
                        if ($v_gounp_letter_no != $row->stsout_id) {
                            echo '<td rowspan="' . $row->group_letter_no . '">' . $row->stsout_letter_no . '</td>';
                            $v_gounp_letter_no = $row->stsout_id;
                        }
                        echo '<td>' . $row->stpron_name_vn . '</td>';
                        echo '<td>-</td>';
                        echo '<td>' . $row->out_qty . '</td>';
                        echo '<td>' . $row->stun_name . '</td>';
                        echo '<td>';
                        echo '<span class="pull-left">$</span>';
                        echo '<span class="pull-right">' . number_format($v_unit_price, 2) . '</span>';
                        echo '</td>';
                        echo '<td data_price="' . $v_unit_price * $row->out_qty . '">';
                        echo  '<span class="pull-left">$</span>';
                        echo '<span class="pull-right">' . number_format($v_unit_price * $row->out_qty, 2) . '</span>';
                        echo '</td>';

                        $v_total_monthly += ($v_unit_price * $row->out_qty);


                        if ($is_new_month)



                            
                            echo '<td class="monthly_price" rowspan="' . $row->group_row_monthly . '">' . number_format($v_total_monthly,2) . '</td>';
                        echo '</tr>';
                      }
                    }
                    ?>
            </tbody>
             <tfoot>
                    <tr class="bg_color">
                        <th colspan="9" class="text-right">TOTAL:</th>
                        <th>
                            <span class="pull-left_color" >$</span> 
                            <span class="pull-right_color" ><?= number_format($v_total_monthly, 2) ?></span>
                        </th>
                    </tr>
                </tfoot>
            
            
        </table>

        <br>

       
       
    </div>
    <?php
      }
    ?>
  
    
    
</body>
</html>
<script>
    $(document).ready(function() {
        
        var v_status_parent = 0;
        var v_status = 0;
        var v_price_total = 0;
        var v_flag = 0;
        $('table tbody tr').each(function() {
            v_status_parent = $(this).attr('data_price_each');

            v_group_row = $(this).attr('row_group');
            v_price = parseFloat($(this).find('td[data_price]').attr('data_price'));
           
            if (v_status != v_status_parent) {
                obj_first = $(this);
                v_status = v_status_parent;
                v_obj = $(this).parent('tr').html();
                v_price_total = v_price;
                v_flag = 0;
            } else {
                v_price_total += v_price;
            }
            ++v_flag;
            if (v_flag == v_group_row) {
                v_span_left = `<span class="pull-left">$</span>`;
                v_span_left = `${v_span_left}<span class="pull-right">${numeral(v_price_total).format('0,0.00')}</span>`;
                obj_first.find('td:last-child').html(v_span_left);
            }
        });
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