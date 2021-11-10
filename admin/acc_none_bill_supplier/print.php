<?php 
    include_once '../../config/database.php';
?>
<?php 

$sql=$connect->query("SELECT comci_name_kh,comci_name_en,comci_name_ch,comci_logo FROM tbl_com_company_info");
$row_header=mysqli_fetch_object($sql);

if(isset($_GET['print_id'])){
    $v_print_id=$_GET['print_id'];

    $sql=$connect->query("SELECT A.*,supsi_name,B.* 
        FROM tbl_acc_none_bill_supp AS A 
        LEFT JOIN tbl_sup_supplier_info AS B ON A.supp_id=B.supsi_id
        LEFT JOIN tbl_acc_none_bill_supp_detail AS C ON A.id=C.none_bill_supp_id
        WHERE A.id='$v_print_id'");
    $row_main=mysqli_fetch_object($sql);
}   
 ?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    <link href='https://fonts.googleapis.com/css?family=Khmer' rel='stylesheet' type='text/css'>
    <style type="text/css">
        *{ 
            font-size: 14px!important; 
            font-family: 'khmer','Time New Reman'!important;
            -webkit-print-color-adjust: exact;
        }
        table {
          border-collapse: collapse;
        }

        table >tbody, th, td {
          border: 1px solid black;
          padding: 3px!important;
        }
        table >tbody >tr >td {
          border: 1px solid black;
          padding: 3px 0px!important;
        }
        table >thead >tr >th{
          background-color: #B4C6E7!important;
        }
        table >tbody >tr:nth-child(even) {background-color: #D9E1F2!important;}
    </style>
</head>
<body>
    <link rel="stylesheet" href="../../print_offline/bootstrap.min.css">
    <script src="../../print_offline/jquery.min.js"></script>
    <div class="container-fluid">
        <br>
        <div class="row my_title pull-left">
            <p style="font-size: 20px!important; font-family: 'Khmer OS Muol'!important; font-weight: bold;"><?= $row_header->comci_name_kh ?></p>
            <p style="font-size: 17px!important; font-family: 'Time New Romen'!important; font-weight: bold;"><?= $row_header->comci_name_en ?></p>
        </div>
        <div class="clearfix"></div>
        <div class="row text-center">
           <p style="font-size: 19px!important; font-family: 'Time New Romen'!important; font-weight: bold; text-decoration: underline;">BILL SUPPLY</p>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-4">
                <div class="row">
                    <div class="col-xs-5">Supplier Name :</div>
                    <div class="col-xs-7"><?= $row_main->supsi_name ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-5">Address:</div>
                    <div class="col-xs-7" style="word-break: break-all;"><?= $row_main->supsi_address ?></div>
                    <br>
                </div>
                <div class="row">
                    <div class="col-xs-5">Phone Number:</div>
                    <div class="col-xs-7"><?= $row_main->supsi_phone ?></div>
                </div>
            </div>

            <div class="col-xs-3 pull-right">
                <div class="row">
                    <div class="col-xs-5">Date:</div>
                    <div class="col-xs-7"><?= date('d-M-Y',strtotime($row_main->date_record)) ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-5">Invoice No:</div>
                    <div class="col-xs-7"><?= $row_main->inv_no ?></div>
                    <br>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="container-fluid">
        <table>
            <thead>
                <tr>
                    <th class="text-center" style="width: 30px;">No</th>
                    <th class="text-center" style="width: 250px;">Description</th>
                    <th class="text-center" style="width: 200px;">Transaction Note</th>
                    <th class="text-center" style="width: 80px;">PO No</th>
                    <th class="text-center" style="width: 150px;">Purchase Confirmation No</th>
                    <th class="text-center" style="width: 80px;">Item Code</th>
                    <th class="text-center" style="width: 200px;">Item Name</th>
                    <th class="text-center" style="width: 100px;">Quantity</th>
                    <th class="text-center" style="width: 100px;">Price</th>
                    <th class="text-center" style="width: 100px;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $i=0;
                    $v_total_amo=0;
                    $v_sql=$connect->query("SELECT A.*,B.*,
                        stpron_code,stpron_name_vn,stpron_name_kh
                        FROM tbl_acc_none_bill_supp AS A 
                        LEFT JOIN tbl_acc_none_bill_supp_detail AS B ON B.none_bill_supp_id=A.id
                        LEFT JOIN tbl_st_product_name AS C ON B.item_id=C.stpron_id
                        WHERE A.id='$v_print_id'");
                    while ($row_select=mysqli_fetch_object($v_sql)) {
                        echo '<tr>';
                            echo '<td class="text-center">'.sprintf('%02d',++$i).'</td>';
                            echo '<td class="text-center">'.$row_select->decription.'</td>';
                            echo '<td class="text-center">-</td>';
                            echo '<td class="text-center">'.$row_select->po_no.'</td>';
                            echo '<td class="text-center">'.$row_select->pur_confirm_no.'</td>';
                            echo '<td class="text-center">'.$row_select->stpron_code.'</td>';
                            echo '<td class="text-center">'.$row_select->stpron_name_kh.'</td>';
                            echo '<td class="text-center">'.$row_select->qty.'</td>';
                            echo '<td class="text-center">$ '.number_format($row_select->unit_price,2).'</td>';
                            echo '<td class="text-center">$ '.number_format($row_select->unit_price*$row_select->qty,2).'</td>';
                        echo '</tr>';
                        $v_total_amo+=$row_select->unit_price*$row_select->qty;
                    }
                    for($idx=$i;$idx<@$_SESSION['new_row_acc_none_bill_supplier'];$idx++){
                        echo '<tr>';
                            echo '<td class="text-center">'.sprintf('%02d',++$i).'</td>';
                            echo '<td class="text-center"></td>';
                            echo '<td class="text-center"></td>';
                            echo '<td class="text-center"></td>';
                            echo '<td class="text-center"></td>';
                            echo '<td class="text-center"></td>';
                            echo '<td class="text-center"></td>';
                            echo '<td class="text-center"></td>';
                            echo '<td class="text-center"></td>';
                            echo '<td class="text-center"></td>';
                        echo '</tr>';
                    }
                 ?>
            </tbody>
            <tfoot>
                <tr>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th colspan="2" class="text-right">Total Amount : </th>
                    <th colspan="2" class="text-right">$ <?= number_format($v_total_amo,2) ?></th>
                </tr>
                <tr>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th colspan="2" class="text-right">Discount :</th>
                    <th colspan="2" class="text-right">$ <?= number_format($row_main->total_discount,2) ?></th>
                </tr>
                <tr>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th colspan="2" class="text-right">Grand Total :</th>
                    <th colspan="2" class="text-right">$ <?= number_format($v_total_amo-$row_main->total_discount,2) ?></th>
                </tr>
            </tfoot>
        </table>

        <br>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-3">
                    <div class="text-center">
                        <p  style="font-family: 'Khmer OS Muol Light'; font-weight: bold;">រៀបចំដោយ<br>Prepared by</p>
                        <br>
                        <br>
                        <hr style="border: 0.5px solid black; width: 70%;">
                        <p style="font-family: 'Khmer OS Muol Light';">Date:.............................</p>
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="text-center">
                        <p  style="font-family: 'Khmer OS Muol Light';font-weight: bold;">ពិនិត្យលើកទី ១ ដោយ<br>First Check by</p>
                        <br>
                        <br>
                        <hr style="border: 0.5px solid black; width: 70%;">
                        <p style="font-family: 'Khmer OS Muol Light';">Date:.............................</p>
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="text-center">
                        <p  style="font-family: 'Khmer OS Muol Light'; font-weight: bold;">ពិនិត្យលើកទី ២ ដោយ<br>Second Check by</p>
                        <br>
                        <br>
                        <hr style="border: 0.5px solid black; width: 70%;">
                        <p style="font-family: 'Khmer OS Muol Light';">Date:.............................</p>
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="text-center">
                        <p  style="font-family: 'Khmer OS Muol Light'; font-weight: bold;">អនុម័តដោយ<br>Approved by</p>
                        <br>
                        <br>
                        <hr style="border: 0.5px solid black; width: 70%;">
                        <p style="font-family: 'Khmer OS Muol Light';">Date:.............................</p>
                    </div>
                </div>
            </div>
        </div>
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


