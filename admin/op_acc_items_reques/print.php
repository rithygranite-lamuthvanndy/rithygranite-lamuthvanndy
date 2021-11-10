<?php
    include_once '../../config/database.php';
    include_once '../st_operation/operation.php';
?>
<?php

if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
     $txt_items=$_GET['txt_items'];
        if($txt_items !="")   {
              $txt_items=" AND  A.rei_item_name ='$txt_items' ";
        } 
        else {
             $txt_items='';
        }

    $v_date_start = $_GET['p_date_start'];
    $v_date_end = $_GET['p_date_end'];
}
else {
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
        <h3>សរុបសំណើរ&សរុបចំណាយ <?= date('d/m/Y', strtotime($v_date_start)) . ' - ' . date('d/m/Y', strtotime($v_date_end)) ?></h3>
        
        <br>
        <!-- Table Decription -->
        <table>
            <thead>
                 <tr role="row" class="text-center">
                        <th style="width: 4%;">N&deg;</th>
                        <th style="">កាលបរិច្ឆេទស្នើរសុំ</th>
                        <th style="">លេខសំណើរ</th>
                        <th style="">ឈ្មោះនាយកដ្ឋាន</th>
                        <th style="">អ្នកស្នើរសុំ</th>
                        <th style="">ឯកភាពដោយ</th>
                        <th style="">ទឹកប្រាក់ស្នើរសុំ</th>
                        <th style="">ឈ្មោះអ្នកទិញ&អ្នកទទួល</th>
                        <th style="">ប្រភេទឡាន&ម៉ាស៊ីន&ឈ្នួល</th>
                        <th style="">ឈ្មោះសម្ភារៈ</th>
                        <th style="">ទំហំ/លេខ</th>
                        <th style="">ចំនួន</th>
                        <th style="">ឯកតា</th>
                        <th style="">តម្លៃរាយ</th>
                        <th style="">តម្លៃសរុប</th>
                        <th style="">ចំណាំសំរាប់ផ្នែកទិញ</th>
                        
                    </tr>
               
            </thead>
            <tbody>
               <?php
                       
                        $v_cat_name_tmp = [];
                        while ($row = mysqli_fetch_object($get_data)) {

                     if (!in_array($row->typr_name, $v_cat_name_tmp)) {
                      $i = 0;
                        array_push($v_cat_name_tmp, $row->typr_name);
                        echo '<tr class="bg-blue">';
                        echo '<td colspan="16" style="color:white;">' . $row->typr_name . '</td>';
                        echo '</tr>';
                     }

                    ?>

                    <tr>
                        <td><?php echo (++$i); ?></td>
                        <td><?php echo $row->req_date; ?></td>
                        <td><?php echo $row->req_number; ?></td>
                        <td><?php echo $row->dep_name; ?></td>
                        <td><?php echo $row->res_name; ?></td>
                        <td><?php echo $row->apn_name; ?></td>
                        <td><?php echo number_format($row->rei_price,2); ?></td>
                        <td><?php echo $row->empl_emloyee_kh.' '.$row->empl_emloyee_en; ?></td>
                        <td><?php echo $row->for_area;  ?></td>
                        <td><?php echo $row->rei_item_name.' '.$row->rei_type; ?></td>
                        <td><?php echo $row->rei_size; ?></td>
                        <td><?php echo $row->rei_qty; ?></td>
                        <td><?php echo $row->uni_name; ?></td>
                        <td><?php echo number_format($row->rei_price,2); ?></td>
                        <td><?php echo number_format($row->rei_qty * $row->rei_price, 2) ?></td>
                        <td>
                            <?php
                             if($row->pur_id >0) {
                                echo "Done";
                             }
                             else {
                                echo "Pendding";
                             }
                            ?>
                        </td>
                        
                        
                    </tr>
                    <?php
                      }
                    ?>
            </tbody>
        </table>
<br>
<br>
         <?php
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

    

            ?>


<table  style="width: 50%;float: left;">
  <thead>
   
  </thead>
  <tbody>
    <?php
      $total_price_all=0;
       while ($rows = mysqli_fetch_object($get_datas)) {
        $total_price_all +=$rows->total_price;
    ?>
    <tr>
      <td><?php echo $rows->typr_name; ?></td>
      <td><label style="text-align: left;">$</label> <span style="float: right;">
          <?php echo number_format($rows->total_price,2); ?>
      </span></td>
    </tr>
    <?php } ?>
    
    <tr>
      
      <td style="font-weight: bold;">សរុប</td>
      <td><label style="text-align: left;font-weight: bold;">$</label> <span style="float: right;font-weight: bold;"><?php echo number_format($total_price_all,2); ?></span></td>
    </tr>
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