<?php include_once '../../config/database.php';?>
<?php 

if(@$_GET['print_id']){
    $id = @$_GET['print_id'];
    $sql = $connect->query("SELECT * FROM tbl_prod_add_quote as A
            LEFT JOIN tbl_cus_customer_info AS C ON C.cussi_id=A.qt_customer
            LEFT JOIN tbl_cus_type AS B ON B.cusct_id=C.cussi_type 
            WHERE qt_id=$id
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
                        <br>
                        <img class="img-reponsive" src="../../img/img_logo/logo.png">
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="row text-center">
                    <h4 style="font-family: 'Khmer OS Muol Light';font-weight: bold!important; color: black;!important;">តារាងតម្លៃផលិតផល</h4>
                    <h4 style="font-family: 'Khmer OS Muol Light';font-weight: bold!important; color: black;!important;">QUOTATION</h4>
                </div>
            </div>
            <!-- <div class="clearfix"></div> -->
            <div class="col-xs-12 pull-right">
              
                <table style="width: 100%;">
                    <thead>
                        <tr>
                            <th>TO:</th>
                            <th><?= $row_old->cussi_name ?></th>
                            <th class="text-right">NO:</th>
                            <th class="text-center"><?= $row_old->qt_no ?></th>
                        </tr>
                        <tr>
                            <th>Name :</th>
                            <th><?= $row_old->cusct_name ?></th>
                            <th class="text-right">Date:</th>
                            <th class="text-center"><?= $row_old->qt_date ?></th>
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
                            <th class="text-right"></th>
                            <th class="text-center"></th>
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
                <thead style="background-color: #CCFFFF;">
                    <tr role="row" class="text-center">
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">N&deg;</th>
                        <th colspan="2" style="vertical-align: middle; text-align: center;">Description of Goods<br> 
                            (Sự miêu tả)</th>
                        <th colspan="3" style="vertical-align: middle; text-align: center;">Dimension/Quy Cách (CM)</th>
                        <th colspan="2" style="vertical-align: middle; text-align: center;">Quantity (Số lượng)</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">Noted (Lưu ý)</th>
                    </tr>
                    <tr role="row" class="text-center">
                        <th style="vertical-align: middle; text-align: center;">Name (Tên)</th>
                        <th style="vertical-align: middle; text-align: center;">Feature (Đặc tính)</th>
                        <th style="vertical-align: middle; text-align: center;">Length<br>(Chiều dài)</th>
                        <th style="vertical-align: middle; text-align: center;">Width<br>(Chiều rộng)</th>
                        <th style="vertical-align: middle; text-align: center;">Thickness<br>(Chiều cao)<br>(+-0.2)</th>
                        <th style="vertical-align: middle; text-align: center;">Pc M2</th>
                        <th style="vertical-align: middle; text-align: center;">Price</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $i=1;
                    $total_amo=0;
                    $id1 = @$_GET['print_id'];
                    $get_data=$connect->query("SELECT * FROM tbl_prod_add_quote_list as A
                            LEFT JOIN tbl_inv_type_make AS D ON D.tm_id = A.qtl_feature
                            WHERE qtl_qt_id = $id1");
                    while($row_body=mysqli_fetch_object($get_data)) 
                    {   
  
                        $v_name = $row_body->qtl_name;
                        $v_code = $row_body->tm_code;
                        $v_length = $row_body->qtl_length;
                        $v_width = $row_body->qtl_width;
                        $v_thickness= $row_body->qtl_thickness;
                        $v_pcs_m2 = $row_body->qtl_pcs_m2;
                        $v_price = $row_body->qtl_price;
                        $v_note1 = $row_body->qtl_note;
                    ?>
                    <tr>
                      <td style="height: 35px; vertical-align: middle; text-align: center;"><?= sprintf("%02d",$i); ?></td>
                      <td style="vertical-align: middle; text-align: left;"><?= $v_name; ?></td>
                      <td style="vertical-align: middle; text-align: center;"><?= $v_code; ?></td>
                      <td style="vertical-align: middle; text-align: left;"><?= $v_length; ?></td>
                      <td style="vertical-align: middle; text-align: left;"><?= $v_width; ?></td>
                      <td style="vertical-align: middle; text-align: center;"><?= number_format($v_thickness,2); ?></td>
                        <td style="vertical-align: middle; text-align: center;"><?= $v_pcs_m2; ?></td>
                      <td style="vertical-align: middle; text-align: center;"><?= number_format($v_price,2); ?> $</td>
                      <td style="vertical-align: middle; text-align: left;"><?= $v_note1; ?></td>
                    </tr>
                <?php
                    $i++;
                }
                if($i<8){
                    for ($idx = 1; $idx <=(6-$i) ; $idx++) {
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
        </table>
        <div class="col-xs-12">
            <div class="form-group">
                <label>Note : </label>
                <textarea type="text" class="form-control" name="txt_note" style="height: 163px;" autocomplete="off"><?= $row_old->qt_note ?></textarea>          
            </div>
        </div>
        <div class="row" style="padding: 0 15px;">
                <div class="col-xs-3 border text-center">
                    <h5>Người Lập:  </h5>
                    <br>
                    <br>
                    <br>
                    <hr class="my_box_border">
                    <div class="text-left">
                        <h5>Name : <strong> </strong></h5>
                        <h5>Date : <strong>.......................................</strong></h5>
                    </div>
                </div>
                <div class="col-xs-3 border text-center ">

                </div>
                 <div class="col-xs-3 border text-center ">

                </div>
                 <div class="col-xs-3 border text-center ">
                    <h5>Người Kiểm tra:</h5>
                    <br>
                    <br>
                    <br>
                    <hr class="my_box_border">
                    <div class="text-left">
                        <h5>Name : <strong> </strong></h5>
                        <h5>Date : <strong>.......................................</strong></h5>
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


