<?php include_once '../../config/database.php';?>
<?php 

if(@$_GET['sent_id']){
    $sent_id=@$_GET['sent_id'];
    $sql=$connect->query("SELECT *,rei_number FROM tbl_acc_request_form AS A
                            LEFT JOIN tbl_acc_request_name_list AS B ON A.req_request_name=B.res_id 
                            LEFT JOIN tbl_acc_position AS C ON A.req_position=C.po_id
                            LEFT JOIN tbl_acc_prepare_name_list AS D ON A.req_prepare_by=D.pren_id
                            LEFT JOIN tbl_acc_check_name_list AS E ON A.req_check_by=E.chn_id
                            LEFT JOIN tbl_acc_approved_name_list AS F ON A.req_approved_by=F.apn_id
                            LEFT JOIN tbl_acc_request_item AS G ON A.req_id=G.rei_number
                            WHERE rei_number='$sent_id'");
    $row=mysqli_fetch_object($sql);
    
    $sql=$connect->query("SELECT comci_name_kh,comci_name_en,comci_name_ch,comci_logo FROM tbl_com_company_info");
    $row_header=mysqli_fetch_object($sql);
}   
 ?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../print_offline/bootstrap.min.css">
    <script src="../../print_offline/jquery.min.js"></script>
    <style type="text/css">
        *{ font-family: 'khmer os content'; font-size: 14px!important; }
        @media print {
            .table thead tr th{
                -webkit-print-color-adjust: exact;
                background: #222 !important;
                color: #fff !important;
            }
            .table tfoot tr td.bg{
                -webkit-print-color-adjust: exact;
                background: #444 !important;
                color: #fff !important;
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
</head>
<body onload="window.print();">
    <div class="container">
        <div class="row">
            <div class="col-xs-5">
                <div class="row">
                    <div class="col-xs-2">
                        <img class="img-reponsive" src="../../img/img_logo/<?= $row_header->comci_logo ?>">
                    </div>
                    <div class="col-xs-10" style="border-bottom: 1px solid black;">
                       <h4 style="font-family: 'Khmer OS Muol Light';font-weight: bold!important; color: blue!important;"><?= $row_header->comci_name_kh ?></h4>
                       <h4 style="font-weight: bold!important;color: blue!important;"><?= $row_header->comci_name_en ?></h4>
                    </div>
                </div>
            </div>
            <!-- <div class="clearfix"></div> -->
            <div class="col-xs-4 pull-right">
                <h3 class="text-center text-primary" style="text-decoration: underline; font-weight: bold!important;font-family: 'Khmer OS Muol Light'!important;">Form Request</h3>
                <table class="table-bordered text-center" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">Date</th>
                            <th class="text-center">PC/FR N&deg;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= date("D d-M-Y",strtotime($row->req_date)) ?></td>
                            <td><?= $row->req_number ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-3 my_box_border">
                <h4 style="font-family: 'Khmer OS Muol Light';">អ្នកស្នើរ / Request</h4>
                <h5>ឈ្មោះ : <?= $row->res_name ?></h5>
                <h5>តួនាទី : <?= $row->po_name ?></h5>
            </div>
        </div>
    </div><br>
    <div class="container-fliud">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <!-- <th class="text-center">ថ្ងៃខែឆ្នាំ <br> Description</th> -->
                    <th class="text-center">ល.រ / N&deg;</th>
                    <th class="text-center">បរិយាយ / Item Name</th>
                    <th class="text-center">បរិមាណ / Quentity</th>
                    <th class="text-center">តម្លៃរាយ / Unit Price</th>
                    <th class="text-center">ទឹកប្រាក់សរុប / Amount</th>
              </tr>
            </thead>
            <tbody>
                <?php
                    $i=1;
                    $total_amo=0;
                    $get_data=$connect->query("SELECT * FROM tbl_acc_request_item AS A LEFT JOIN tbl_acc_request_form AS B ON A.rei_number=B.req_id
                            LEFT JOIN  tbl_acc_unit_list AS C ON A.rei_unit=C.uni_id
                            WHERE rei_number='$sent_id'");
                    while($row_body=mysqli_fetch_object($get_data)) 
                    {   
                        $v_name=$row_body->rei_item_name;
                        $v_unit=$row_body->uni_name;
                        $v_qty=$row_body->rei_qty;
                        $v_price=$row_body->rei_price;
                        $amo=$v_qty*$v_price;
                        $total_amo+=$amo;
                    ?>
                    <tr>
                      <td class="text-center"><?= $i; ?></td>
                      <td class="text-center"><?= $v_name; ?></td>
                      <td class="text-center"><?= number_format($v_qty,0.3); ?></td>
                      <td class="text-center"><?= number_format($v_price,2); ?> $</td>
                      <td class="text-center"><?= number_format($amo,2); ?> $</td>
                    </tr>
                <?php
                    $i++;
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th style="visibility: hidden;"></th>
                    <th style="visibility: hidden;"></th>
                    <th style="visibility: hidden;"></th>
                    <th class="text-center">Grand Total (USD) :</th>
                    <th class="text-center"><strong><?= number_format($total_amo,2) ?> $</strong></th>
                </tr>
            </tfoot>
        </table>
        <div class="row" style="padding: 0 15px;">
                <div class="col-xs-4 border text-center my_box_border">
                    <h5>ឯកភាពដោយ / Prepare By</h5>
                    <br>
                    <br>
                    <br>
                    <hr class="my_box_border">
                    <div class="text-left">
                        <h5>Name : <strong> <?= $row->pren_name ?></strong></h5>
                        <h5>Date : <strong>.......................................</strong></h5>
                    </div>
                </div>
                 <div class="col-xs-4 border text-center my_box_border">
                    <h5>ត្រួតពិនិត្យដោយ / Check By</h5>
                    <br>
                    <br>
                    <br>
                    <hr class="my_box_border">
                    <div class="text-left">
                        <h5>Name : <strong> <?= $row->chn_name ?></strong></h5>
                        <h5>Date : <strong>.......................................</strong></h5>
                    </div>
                </div>
                 <div class="col-xs-4 border text-center my_box_border">
                    <h5>រៀបចំដោយ / Approved By</h5>
                    <br>
                    <br>
                    <br>
                    <hr class="my_box_border">
                    <div class="text-left">
                        <h5>Name : <strong> <?= $row->apn_name ?></strong></h5>
                        <h5>Date : <strong>.......................................</strong></h5>
                    </div>
                </div>
            </div>
    </div>   
</body>
</html>


