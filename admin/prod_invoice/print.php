<?php 
    include_once '../../config/database.php';
?>
<?php 

$sql=$connect->query("SELECT comci_name_kh,comci_name_en,comci_name_ch,comci_logo FROM tbl_com_company_info");
$row_header=mysqli_fetch_object($sql);

if(isset($_GET['print_id'])){
    $v_print_id=$_GET['print_id'];

    // Body Invoice
    $sql_master=$connect->query("SELECT A.*,cussi_name,
        SUM(slab) AS total_slab,
        SUM(mater) AS total_mater,
        SUM(amount) AS total_amo,
        (SUM(amount)-total_discount) AS grand_toal,
        B.*
        FROM  tbl_inv_sale_revenue AS A 
        LEFT JOIN tbl_cus_customer_info AS B ON A.cus_id=B.cussi_id
        LEFT JOIN tbl_acc_inv_revenue_detial AS C ON A.id=C.none_sale_rev_id 
        WHERE A.id='$v_print_id'");
    $row_master=mysqli_fetch_object( $sql_master);
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
            font-size: 13px!important; 
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
           <p style="font-size: 22px!important; font-family: 'Time New Romen'!important; font-weight: bold; text-decoration: underline;">ADD NONE SALE REVENUE</p>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-4">
                <div class="row">
                    <div class="col-xs-5">Consignee Name* :</div>
                    <div class="col-xs-7"><?= $row_master->cussi_name ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-5">Customer ID :</div>
                    <div class="col-xs-7"><?= $row_master->cus_code ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-5">Address* :</div>
                    <div class="col-xs-7"><?= $row_master->cussi_address ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-5">Phone* :</div>
                    <div class="col-xs-7"><?= $row_master->cussi_phone ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-5">Email* :</div>
                    <div class="col-xs-7"><?= $row_master->cussi_email ?></div>
                </div>
            </div>
            <div class="col-xs-4 pull-right">
                <div class="row">
                    <div class="col-xs-5">Invoice No* :</div>
                    <div class="col-xs-7"><?= $row_master->inv_no ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-5">Date :</div>
                    <div class="col-xs-7"><?= $row_master->date_record ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-5">PO No :</div>
                    <div class="col-xs-7"><?= $row_master->po_no ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-5">Delivery No :</div>
                    <div class="col-xs-7"><?= $row_master->delivery_no ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-5">Delivery Date :</div>
                    <div class="col-xs-7"><?= $row_master->delivery_date ?></div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="container-fluid" style="padding: 0px!important;">
        <table style="width: 100%;">
            <thead>
                    <tr>
                        <th class="text-center" rowspan="2">N&deg;</th>
                        <th class="text-center" colspan="2">Description of Goods</th>
                        <th class="text-center" colspan="3">Dimension (CM)</th>
                        <th class="text-center" colspan="3">Quantity</th>
                        <th class="text-center" rowspan="2">Unit Price <br> (USD)</th>
                        <th class="text-center" rowspan="2">Amount <br> (USD) </th>
                    </tr>
                     <tr>
                        <th class="text-center">Inventory Name</th>
                        <th class="text-center">Feacture</th>
                        <th class="text-center">Length</th>
                        <th class="text-center">Width</th>
                        <th class="text-center">Thickness</th>
                        <th class="text-center">Slab</th>
                        <th class="text-center">M<sup>2</sup></th>
                        <th class="text-center">M<sup>3</sup></th>
                    </tr>
                </thead>
            <tbody>
                <?php 
                    $i = 0;
                    $tot_slap=0;
                    $tot_mater=0;
                    $tot_maters=0;
                    $tot_amount=0;
                    $v_sql=$connect->query("SELECT A.*,B.*,
                inv_pron_name_en,D.name AS fea_name
                FROM tbl_inv_sale_revenue AS A 
                LEFT JOIN tbl_acc_inv_revenue_detial AS B ON B.none_sale_rev_id=A.id
                LEFT JOIN tbl_inv_product_name AS C ON B.inv_pro_id=C.inv_pron_id
                LEFT JOIN tbl_inv_feature AS D ON B.fea_id=D.id
                WHERE A.id='$v_print_id'");

                    while ($row=mysqli_fetch_object($v_sql)) {
                        echo '<tr>';
                            echo '<td class="text-center">'.sprintf('%02d',++$i).'</td>';
                            echo '<td class="text-center">'.$row->inv_pron_name_en.'</td>';
                            echo '<td class="text-center">'.$row->fea_name.'</td>';
                            echo '<td class="text-center">'.$row->length.'</td>';
                            echo '<td class="text-center">'.number_format($row->width,2).'</td>';
                            echo '<td class="text-center">'.number_format($row->thickness,2).'</td>';
                            echo '<td class="text-center">'.number_format($row->slab,2).'</td>';
                            echo '<td class="text-center">'.number_format($row->mater,2).'</td>';
                            echo '<td class="text-center">'.number_format($row->mater_three,2).'</td>';
                            echo '<td class="text-center">$ '.number_format($row->unit_price,2).'</td>';
                            echo '<td class="text-center">$ '.number_format($row->amount,2).'</td>';
                        echo '</tr>';
                        $tot_slap+=$row->slab;
                        $tot_mater+=$row->mater;
                        $tot_maters+=$row->mater_three;
                        $tot_amount+=$row->amount;
                    }
                    for($idx=$i;$idx<$_SESSION['new_row_acc_none_sale_revenue'];$idx++){
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
                    <th class="text-right">Total : </th>
                    <th class="text-center"><?= number_format($tot_slap,2) ?></th>
                    <th class="text-center"><?= number_format($tot_mater,2) ?></th>
                    <th class="text-center"><?= number_format($tot_maters,2) ?></th>
                    <th style="border: none;"></th>
                    <th class="text-center">$ <?= number_format($tot_amount,2) ?></th>
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


