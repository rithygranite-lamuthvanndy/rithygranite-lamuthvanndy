<?php include_once '../../config/database.php';?>
<?php 

if(@$_GET['print_id']){
    $id = @$_GET['print_id'];
    $sql = $connect->query("SELECT * FROM tbl_prod_add_po as A
            LEFT JOIN tbl_cus_customer_info AS C ON C.cussi_id=A.po_customer
            LEFT JOIN tbl_prod_add_quote AS D ON D.qt_id=A.po_quota_code
            LEFT JOIN tbl_cus_type AS B ON B.cusct_id=C.cussi_type 
            WHERE po_id=$id
            ");
    $row_old = mysqli_fetch_object($sql);
}   
 ?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    </style>
</head>
<body  id="content">
    <link rel="stylesheet" href="../../print_offline/bootstrap.min.css">
    <style type="text/css">
        *{ font-family: 'khmer os'; font-size: 11px!important; }
        @media print {
            .table thead tr th{
                -webkit-print-color-adjust: exact;
                background: blue; !important;
                color: black !important;
            }
            .table tfoot tr td.bg{
                -webkit-print-color-adjust: exact;
                background: #444 !important;
                color: black; !important;
            }
            .table *{ padding-bottom: 2px!important; padding-top: 2px!important; }
            .my_title>p{
                font-weight: bold!important;
            }
            .my_box_border{
                border: 1px solid black;
            }
            .table-bordered>thead>tr>th,.table-bordered>tbody>tr>td,.table-bordered>tfoot>tr>th{
                border: 0.5px solid black!important;
            }
        }
    </style>
    <div class="container border my_box_border">
        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-3">
                        <img class="img-reponsive" src="../../img/img_logo/logo.png">
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="row text-center">
                    <h1 style="font-family: 'Khmer OS Muol Light';">ប័ណបញ្ជាទិញ</h1>
                    <h1 style="font-family: 'Khmer OS Muol Light';">PURCHASE ORDER</h1>
                </div>
            </div>
            <!-- <div class="clearfix"></div> -->
            <div class="col-xs-12 pull-right">
              
                <table style="width: 100%;">
                    <thead>
                        <tr>
                            <th>TO:</th>
                            <th><?= $row_old->cussi_name ?></th>
                            <th class="text-right">PO NO:</th>
                            <th class="text-center"><?= $row_old->po_no ?></th>
                        </tr>
                        <tr>
                            <th>Name :</th>
                            <th><?= $row_old->cusct_name ?></th>
                            <th class="text-right">Date:</th>
                            <th class="text-center"><?= $row_old->po_date ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Address:</td>
                            <td><?= $row_old->cussi_address ?></td>
                            <th class="text-right">Customer ID:</th>
                            <th class="text-center"><?= $row_old->cus_code ?></th>
                        </tr>
                        <tr>
                            <td>Phone :</td>
                            <td><?= $row_old->cussi_phone ?></td>
                            <th class="text-right">Quote Code:</th>
                            <th class="text-center"><?= $row_old->qt_no ?></th>
                        </tr>
                        <tr>
                            <td>Email :</td>
                            <td><?= $row_old->cussi_email ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
   <br><br>
    <div class="container-fliud">
        <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th class="text-center">NO<br>(STT)</th>
                                <th class="text-center" style="width: 20%;">Name<br>(Tên)</th>
                                <th class="text-center" style="width: 10%;">Feature<br>(Đặc tính)</th>
                                <th class="text-center">បណ្ដោយ <br> Dài</th>
                                <th class="text-center">ទទឹង <br> Rộng</th>
                                <th class="text-center">កម្រាស់ <br> PRICE</th>
                                <th class="text-center">សន្លឹក - M2 <br> Số Tấm</th>
                                <th class="text-center">តម្លៃ  <br> PCS - M2</th>
                                <th class="text-center">សំគ្គាល់  <br> Others</th>
                            </tr>
                        </thead>
                <tbody>
                <?php
                    $i=1;
                    $total_amo=0;
                    $total_slab=0;
                    $total_m2=0;
                    $id1 = @$_GET['print_id'];
                    $get_data=$connect->query("SELECT * FROM tbl_prod_add_po_list as A
                            LEFT JOIN tbl_inv_type_make AS D ON D.tm_id = A.pol_feature
                            WHERE pol_po_id = $id1");
                    while($row_body=mysqli_fetch_object($get_data)) 
                    {   
  
                        $v_name = $row_body->pol_name;
                        $v_code = $row_body->tm_code;
                        $v_length = $row_body->pol_length;
                        $v_width = $row_body->pol_width;
                        $v_thickness= $row_body->pol_thickness;
                        $v_pcs_slab = $row_body->pol_pcs_slab;
                        $v_m2 = $row_body->pol_m2;
                        $v_note1 = $row_body->pol_note;
                        $total_slab+=$v_pcs_slab;
                        $total_m2+=$v_m2;
                    ?>
                    <tr>
                      <td style="height: 35px; vertical-align: middle; text-align: center;"><?= sprintf("%02d",$i); ?></td>
                      <td style="vertical-align: middle; text-align: left;"><?= $v_name; ?></td>
                      <td style="vertical-align: middle; text-align: center;"><?= $v_code; ?></td>
                      <td style="vertical-align: middle; text-align: left;"><?= $v_length; ?></td>
                      <td style="vertical-align: middle; text-align: left;"><?= $v_width; ?></td>
                      <td style="vertical-align: middle; text-align: center;"><?= number_format($v_thickness,2); ?></td>
                        <td style="vertical-align: middle; text-align: center;"><?= $v_pcs_slab; ?></td>
                      <td style="vertical-align: middle; text-align: center;"><?= number_format($v_m2,2); ?> </td>
                      <td style="vertical-align: middle; text-align: left;"><?= $v_note1; ?></td>
                    </tr>
                <?php
                    $i++;
                }
                if($i<16){
                    for ($idx = 1; $idx <=(12-$i) ; $idx++) {
                        echo '<tr>';
                            echo '<td style="height: 35px; vertical-align: middle; text-align: center;">'.sprintf("%02d",($i+$idx)).'</td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';

                        echo '</tr>';
                    }
                }

                ?>
            </tbody>
                        <tfoot>
                            <tr>
                               
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th colspan="2" class="text-right">សរុប <br>TOTAL M <sup>2</sup></th>
                                <th style="vertical-align: middle; text-align: center; font-size: 14px;"><?= $total_slab ?></th>
                                <th style="vertical-align: middle; text-align: center; font-size: 14px;"><?= number_format($total_m2,2) ?></th>
                                <th style="visibility: hidden;"></th>
                                
                            </tr>
                        </tfoot>
        </table>

        <div class="row" style="padding: 0 15px;">
                <div class="col-xs-4 border text-center">
                    <h5>ផ្នែកស្តុកបញ្ចេញថ្មពីឃ្លាំង</h5>
                    <h5>Stock Controller by:</h5>
                    <br>
                    <br>
                    <br>
                    <br>
                    <hr class="my_box_border">
                    <div class="text-left">
                        <h5>Name : <strong> </strong></h5>
                    </div>
                </div>
                <div class="col-xs-4 border text-center ">
                    <h5>ផ្នែករដ្ឋបាល</h5>
                    <h5>Adiministration:</h5>
                    <br>
                    <br>
                    <br>
                    <br>
                    <hr class="my_box_border">
                    <div class="text-left">
                        <h5>Name : <strong> </strong></h5>
                    </div>
                </div>
                 <div class="col-xs-4 border text-center ">
                    <h5>ឯកភាពដោយ</h5>
                    <h5>Approved by:</h5>
                    <br>
                    <br>
                    <br>
                    <br>
                    <hr class="my_box_border">
                    <div class="text-left">
                        <h5>Name : <strong> </strong></h5>
                    </div>
                </div>
        </div>
        <div class="row" style="padding: 0 15px;">
                <div class="col-xs-4 border text-center">
                    <h5>អ្នកទទួលដឹកជញ្ជូន</h5>
                    <h5>Delivery by:</h5>
                    <br>
                    <br>
                    <br>
                    <br>
                    <hr class="my_box_border">
                    <div class="text-left">
                        <h5>Name : <strong> </strong></h5>
                    </div>
                </div>
                <div class="col-xs-4 border text-center ">
                    <h5>ផ្នែកសន្តិសុខ</h5>
                    <h5>Security by:</h5>
                    <br>
                    <br>
                    <br>
                    <br>
                    <hr class="my_box_border">
                    <div class="text-left">
                        <h5>Name : <strong> </strong></h5>
                    </div>
                </div>
                 <div class="col-xs-4 border text-center ">
                    <h5>អ្នកទទួលទំនិញ</h5>
                    <h5>Received by:</h5>
                    <br>
                    <br>
                    <br>
                    <br>
                    <hr class="my_box_border">
                    <div class="text-left">
                        <h5>Name : <strong> </strong></h5>
                    </div>
                </div>
        </div>
    </div>   <br>
 </div>
</body>
</html>
<script src="../../print_offline/jquery.min.js"></script>
<script type="text/javascript">
    window.onload=function(){
      var printme=document.getElementById('content');
      var wme=window.open("","","width=1100,height=1100");
      wme.document.write(printme.outerHTML);
      wme.document.close();
      wme.focus();
      wme.print();
      wme.close();
    }
    setTimeout(function(){
        window.close();
    },1000);
</script>


