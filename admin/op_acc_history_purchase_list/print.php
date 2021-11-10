<?php
    include_once '../../config/database.php';
    include_once '../st_operation/operation.php';
?>
<?php

if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
    $v_date_start = $_GET['p_date_start'];
    $v_date_end = $_GET['p_date_end'];
    $txt_category=@$_GET['cate_id'];
        if($txt_category !="") {
            $txt_category=" AND  cate_id ='$txt_category' ";
        }
        else {
            $txt_category='';
        }
}
else {
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
            border: 1px solid black !important;
            white-space: nowrap;
            padding: 5px 10px !important;
        }

        table>tbody tr th {
            font-family: 'Khmer Moul' !important;
            font-weight: bold !important;
        }

        table>tbody tr:first-child th {
            width: 2px;
        }

        table tbody tr td:nth-child(2),
        table tbody tr td:nth-child(3),
        table tbody tr td:nth-child(4),
        table tbody tr td:nth-child(5) {
            width: 100px !important;
        }

        table tbody tr:first-child td,
        table tbody tr td:nth-child(5),
        table tbody tr:nth-child(3) {
            /*background: #DDEBF7 !important;*/
        }

        table tbody tr td:nth-child(7) {
            /*background: #E7E6E6 !important;*/
        }

       
        .main_border h3,
        .main_border h4 {
            font-family: 'Khmer Moul' !important;
            text-decoration: underline;
            font-weight: bold;
            text-align: center;
        }

        .myqty {
            font-weight: bold;
        }

        tbody tr.bg-blue td {
            background: #5B9BD5 !important;
            text-align: left !important;
            color: white !important;
        }


       

        .myprice:before {
            content: '$ ';
            padding-right: 5px;
        }

        .myprice_vn:after {
            content: 'd';
            text-decoration: underline;
            padding-left: 5px;
        }
         table th {
            background: #DDEBF7 !important;
        }
    </style>
</head>
<link rel="stylesheet" href="../../print_offline/bootstrap.min.css">
<script src="../../print_offline/jquery.min.js"></script>

<body>
    <div class="main_border">
        <h3>Price History List of Purchase <?= date('d/m/Y', strtotime($v_date_start)) . ' - ' . date('d/m/Y', strtotime($v_date_end)) ?></h3>
        
        <br>
        <!-- Table Decription -->
        <table>
            <thead>
              <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Date Buy</th>
                        <th style="padding: 10px 50px;">Item Name</th>
                        <th>Qty</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Amount</th>
                        
                    </tr>
               
            </thead>
            <tbody>
               <?php
                       
                        $v_cat_name_tmp = [];
                        while ($row = mysqli_fetch_object($get_data)) {
                            if (!in_array($row->cate_id, $v_cat_name_tmp)) {
                                 $i = 0;
                                array_push($v_cat_name_tmp, $row->cate_id);
                                    if($row->cate_id=="1") {
                                        $cate_name="សំភារៈផលិត";
                                     }
                                     else if($row->cate_id=="2") {
                                        $cate_name="គ្រឿងបន្លាស់";
                                     }
                                      else if($row->cate_id=="3") {
                                        $cate_name="សំភារៈរោងជាង";
                                     }
                                      else if($row->cate_id=="4") {
                                        $cate_name="សំភារៈការិយាល័យ";
                                        
                                     }
                                     else {
                                        $cate_name="";
                                     }
                                echo '<tr class="bg-blue">';
                                echo '<td colspan="8">' . $cate_name . '</td>';
                                echo '</tr>';
                            }
                    ?>

                     <tr>
                        <td style="width: 5%;"><?php echo (++$i); ?></td>
                        <td style="width:8%;"><?php echo $row->buy_date; ?></td>
                        <td style="width: 60%;"><?php echo $row->pro_name_kh.' '.$row->pro_name_vn; ?></td>
                        <td style="width: 5%;"><?php echo $row->qty; ?></td>
                        <td style="width:8%;"><?php echo $row->uni_name; ?></td>
                        <td style="width:8%;"><?php echo $row->price; ?></td>
                        <td style="width:8%;"><?php echo $row->amount; ?></td>
                       
                    </tr>
                    <?php
                      }
                    ?>
            </tbody>
        </table>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            var t = $('#total');
            var t1 = $('#tt').val();
            t.text(t1);
            window.print();
        });
        setTimeout(function(){
          window.close();
        },1000);
    </script>



</body>

</html>