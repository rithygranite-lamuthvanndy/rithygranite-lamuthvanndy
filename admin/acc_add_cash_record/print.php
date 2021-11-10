<?php include_once '../../config/database.php';?>
<?php 
    $sql=$connect->query("SELECT comci_name_kh,comci_name_en,comci_name_ch,comci_logo,comci_addr FROM tbl_com_company_info");
    $row_header=mysqli_fetch_object($sql);
 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body id="content">
    <link href="https://fonts.googleapis.com/css?family=Khmer" rel="stylesheet">
    <style>
        *{
            font-family: 'Khmer', 'khmer'!important;
        }
    </style>
    <link rel="stylesheet" href="../../print_offline/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="print_style.css">
    
    <div class="container-fluid" style="margin: 0px 20px 30px 20px;">
        <div class="row">
            <div class="pull-left">
                <h1 class="text-primary" style="color: #6467EF!important; font-weight: bold!important; font-size: 30px!important; font-family: 'Time New Roman'!important; "><?= $row_header->comci_name_en ?></h1>
            </div><br><br>
            <div class="pull-right">
                <p style="font-size: 25px!important; text-decoration: underline; font-family: 'Khmer OS Muol Light','Khmer OS';">សក្ខីប័ត្រ Voucher</p>
            </div>
        </div>
        
        <!-- <div class="clearfix"></div> -->
    </div>
    <!-- Master    -->
    <?php 
        if (isset($_GET['print_id'])) {
            $v_main_id=@$_GET['print_id'];
            $sql_main=$connect->query("SELECT A.*,po_name,vot_name,D.trat_name,E.name AS bank_name  
                FROM tbl_acc_cash_record AS A 
                LEFT JOIN tbl_acc_position AS B ON A.pos_id=B.po_id
                LEFT JOIN tbl_acc_voucher_type_list AS C ON A.vou_type_id=C.vot_id
                LEFT JOIN tbl_acc_transaction_type_list AS D ON A.tran_type_id=D.trat_id
                LEFT JOIN tbl_acc_type_cash_bank AS E ON A.type_bank_id=E.id
                WHERE accdr_id='$v_main_id'
                ");
            $row_main=mysqli_fetch_object($sql_main);
        }
     ?>
    <?php 
        $v_status=(int)$row_main->rec_status;
        switch ($v_status) {
            case 1:
                    $v_status_name='ទទួលពី Received From:';
                    $sql_select_rec=$connect->query("SELECT cussi_id,cussi_name 
                        FROM tbl_cus_customer_info WHERE cussi_id='$row_main->rec_from_id'");
                    $row_select_rec=mysqli_fetch_array($sql_select_rec);
                    $rec_name=$row_select_rec["cussi_name"];
                break;
            case 2:
                // echo '<p>ផ្សេង <br> Other (Customer):';
                $v_status_name='ទទួលពី Received From (Other):';
                    $sql_select_rec=$connect->query("SELECT id,name 
                    FROM tbl_acc_other_rec_from_list
                    WHERE id='$row_main->rec_from_id'");
                    $row_select_rec=mysqli_fetch_array($sql_select_rec);
                    $rec_name=$row_select_rec["name"];
                break;
            case 3:
                $v_status_name='ទូទាត់ទៅ Pay To (Vendor):';
                    $sql_select_rec=$connect->query("SELECT supsi_id,supsi_name 
                        FROM tbl_sup_supplier_info WHERE supsi_id='$row_main->rec_from_id'");
                    $row_select_rec=mysqli_fetch_array($sql_select_rec);
                    $rec_name=$row_select_rec["supsi_name"];
                break;
            case 4:
                $v_status_name='ទូទាត់ទៅ Pay To (Other):';
                    $sql_select_rec=$connect->query("SELECT id,name 
                    FROM tbl_acc_other_pay_to_list
                    WHERE id='$row_main->rec_from_id'");
                    $row_select_rec=mysqli_fetch_array($sql_select_rec);
                    $rec_name=$row_select_rec["name"];
                break;
        }
    ?>
    <div class="container-fliud">
        <table class="table" id="myTable2">
            <tbody>
                <tr>
                    <td>
                        <div class="row" style="padding-right: 10px;">
                            <div class="col-xs-3">
                                <p><?= $v_status_name ?></p>
                            </div> 
                            <div class="col-xs-3" style="border-bottom: 1px solid black;">
                                <p><?= $rec_name ?></p>
                            </div>
                            <div class="col-xs-3">
                                <p>តួនាទី Postion:</p>
                            </div>
                            <div class="col-xs-3" style="border-bottom: 1px solid black;">
                                <p><?= ($row_main->po_name)?($row_main->po_name):"-" ?></p>
                            </div>
                        </div>
                        <br>
                        <div class="row" style="padding-right: 10px;">
                            <div class="col-md-2 col-xs-2 col-lg-2 col-sm-2">
                                <p>ទំនាក់ទំនង Contact :</p>
                            </div>
                            <div class="col-md-10 col-xs-10 col-lg-10 col-sm-10">
                                <div class="row">
                                    <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3">
                                        <p>-​ អាស័យដ្ឋាន<br> Address :</p>
                                    </div>
                                    <div class="col-md-9 col-xs-9 col-lg-9 col-sm-9" style="border-bottom: 1px solid black;">
                                        <p><?= ($row_main->accdr_address)?($row_main->accdr_address):"_" ?></p>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-md-6 col-xs-6 col-lg-6 col-sm-6" style="width: 45%!important;">
                                        <div class="row">
                                            <div class="col-md-6 col-xs-6 col-lg-6 col-sm-">
                                                <p>-លេខទូរស័ព្ទ: <br> Phone Number:</p>
                                            </div>
                                            <div class="col-md-6 col-xs-6 col-lg-6 col-sm-6" style="border-bottom: 1px solid black;">
                                                <p><?= ($row_main->accdr_phone)?($row_main->accdr_phone):"_" ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-6 col-lg-6 col-sm-6">
                                        <div class="row">
                                            <div class="col-md-6 col-xs-6 col-lg-6 col-sm-6">
                                                <p>-សារអេឡិចត្រូនិច: <br> Email:</p></p>
                                            </div>
                                            <div class="col-md-6 col-xs-6 col-lg-6 col-sm-6" style="border-bottom: 1px solid black;">
                                                <p><?= ($row_main->accdr_email)?($row_main->accdr_email):"_"?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6">
                                <p>ប្រភេទសក្ខីប័ត្រ`<br> Voucher Type:</p>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6">
                                <p><?= $row_main->vot_name ?></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6">
                                <p>ប្រភេទប្រតិបត្តិការ: <br> Transaction Type:</p>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6">
                                <p><?= $row_main->trat_name ?></p>
                            </div>
                        </div>
                        
                        
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6">
                                <p>ប្រភេទសាច់ប្រាក់/ធនាគារ: <br> Type Cash/Bank:</p>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6">
                                <p><?= $row_main->bank_name ?></p>
                            </div>
                        </div>
                    </td>
                    <td style="width: 23%;">
                        <div class="row" style="padding-right: 10px;">
                            <div class="col-md-7 col-sm-7 col-lg-7 col-xs-7">
                                <p>កាលបរិច្ឆេទប្រតិបត្តិការ: <br>Transaction Date:</p>
                            </div>
                            <div class="col-md-5 col-sm-5 col-lg-5 col-xs-5" style="border-bottom: 1px solid black;">
                                <p><?= date("Y-m-d", strtotime($row_main->accdr_date)) ?></p>
                            </div>
                        </div>

                        <div class="row" style="padding-right: 10px;">
                            <div class="col-md-7 col-sm-7 col-lg-7 col-xs-7">
                                <p><p>លេខសក្ខីប័ត្រៈ <br> Voucher No:</p></p>
                            </div>
                            <div class="col-md-5 col-sm-5 col-lg-5 col-xs-5" style="border-bottom: 1px solid black;">
                                <p><?= $row_main->accdr_voucher_no ?></p>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- Detail -->
    <div class="container-fliud">
        <!-- <table class="table table-bordered" id="my_first_table"> -->
        <table class="table" id="my_first_table">
            <tbody>
                <tr>
                    <th class="text-center" style="width: 50px;">ល.រ<br>N&deg;</th>
                    <th class="text-center" style="width: 100px;">កូដ<br>Code</th>
                    <th class="text-center">ការបរិយាយ<br>Description</th>
                    <th class="text-center">សំគាល់ប្រតិបត្តិការណ៍<br>TRANSACTION NOTE</th>
                    <th class="text-center" style="width: 100px;">ឯកសារយោង<br>DOCUMENT REF</th>
                    <th class="text-center" style="width: 110px;">បរិមាណ<br>QUANTITY</th>
                    <th class="text-center" style="width: 110px;">តម្លៃ<br>PRICE</th>
                    <th class="text-center" style="width: 140px;">ទឹកប្រាក់<br>AMOUNT</th>
                </tr>
                <?php 
                    $i=0;
                    $sql_detail=$connect->query("SELECT A.*,des_name
                        FROM tbl_acc_cash_record_detail AS A 
                        LEFT JOIN tbl_acc_decription AS B ON A.des_id=B.des_id
                        WHERE cash_rec_id='$v_main_id'
                        ");
                    $row_num=mysqli_num_rows($sql_detail);
                    while ($row_detail=mysqli_fetch_object($sql_detail)) {
                        echo '<tr>';
                            echo '<td class="text-center">'.sprintf("%'.02d",++$i).'</td>';
                            echo '<td class="text-center">'.$row_detail->code.'</td>';
                            echo '<td class="text-center">'.$row_detail->des_name.'</td>';
                            echo '<td class="text-center">'.$row_detail->tran_note.'</td>';
                            echo '<td class="text-center">'.$row_detail->doc_ref.'</td>';
                            echo '<td class="text-center">'.$row_detail->qty.'</td>';
                            echo '<td class="text-center">$ '.number_format($row_detail->price,2).'</td>';
                            echo '<td class="text-center">$ '.number_format($row_detail->qty*$row_detail->price,2).'</td>';
                        echo '</tr>';
                    }
                    // Complete Row to get 12 rows 
                    for ($idx = $row_num+1; $idx <=@$_SESSION['new_row_add_cash_record'] ; $idx++) {
                        echo '<tr>';
                            echo '<td class="text-center">'.sprintf("%'.02d",$idx).'</td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                        echo '</tr>';
                    }
                 ?>
                <tr>
                    <th class="text-right" colspan="6">ទឹកប្រាក់សរុប /​ TOTAL AMOUNT</th>
                    <th class="text-center" colspan="2">$ <?= ($row_main->accdr_cash_in)?(number_format($row_main->accdr_cash_in,2)):(number_format($row_main->accdr_cash_out,2)) ?></th>
                </tr>
                <tr>
                    <th class="text-right" colspan="6">ទឹកប្រាក់ជាអក្សរ / AMOUNT IN WORDS</th>
                    <th class="text-center" colspan="2"><?= $row_main->text_cash ?></th>
                </tr>
            </tbody>
        </table>
        <br>
        <br>
        
    </div> 
    <!-- Sign -->
    <div class="container-fluid">
        <div class="sign">
            <div class="text-center" style="margin: 2.5px; width: 19%;">
                <p  style="font-family: 'Khmer OS Muol Light';">រៀបចំដោយ​<br>Prepared by</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black; width: 70%;">
                <p style="font-family: 'Khmer OS Muol Light';">Date:.............................</p>
            </div>

            <div class="text-center" style="margin: 2.5px; width: 19%;">
                <p  style="font-family: 'Khmer OS Muol Light';">ពិនិត្យដោយ<br>Reviewed by</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black; width: 70%;">
                <p  style="font-family: 'Khmer OS Muol Light';">Date:.............................</p>
            </div>

            <div class="text-center" style="margin: 2.5px; width: 19%;">
                <p  style="font-family: 'Khmer OS Muol Light';">អនុម័តលើកទី 1 ដោយ<br>First Approved by</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black; width: 70%;">
                <p  style="font-family: 'Khmer OS Muol Light';">Date:.............................</p>
            </div>
            <div class="text-center" style="margin: 2.5px; width: 19%;">
                <p  style="font-family: 'Khmer OS Muol Light';">អនុម័តលើកទី 2 ដោយ<br>Second Approved by</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black; width: 70%;">
                <p  style="font-family: 'Khmer OS Muol Light';">Date:.............................</p>
            </div>
            <div class="text-center" style="margin: 2.5px; width: 19%;">
                <p  style="font-family: 'Khmer OS Muol Light';">ទទួលដោយ<br>Received by</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black; width: 70%;">
                <p  style="font-family: 'Khmer OS Muol Light';">Date:.............................</p>
            </div>
        </div>
    </div>
    <script src="../../print_offline/bootstrap.min.js"></script>
    <script src="../../print_offline/jquery.min.js"></script>
</body>
</html>
<script type="text/javascript">
    window.onload=function(){
      var printme=document.getElementById('content');
      var wme=window.open("","","width=1200px");
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



