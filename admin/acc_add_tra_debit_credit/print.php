<?php 
    include_once '../../config/database.php';
?>
<?php 

$sql=$connect->query("SELECT comci_name_kh,comci_name_en,comci_name_ch,comci_logo FROM tbl_com_company_info");
$row_header=mysqli_fetch_object($sql);

if(isset($_GET['print_id'])){
    $v_print_id=$_GET['print_id'];

    // Body Invoice
    $sql_master=$connect->query("SELECT A.*
        FROM tbl_acc_add_tran_dr_cr AS A 
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
           <p style="font-size: 22px!important; font-family: 'Time New Romen'!important; font-weight: bold; text-decoration: underline;">ADD TRANSACTION DR/CR</p>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-4">
                <div class="row">
                    <div class="col-xs-5">Date :</div>
                    <div class="col-xs-7"><?= date("d-M-Y",strtotime($row_master->date_record)) ?></div>
                </div>
               <!--  <div class="row">
                    <div class="col-xs-5">Entry No :</div>
                    <div class="col-xs-7" style="word-break: break-all;"><?= @$row_master->name ?></div>
                    <br>
                </div> -->
               
            </div>
        </div>
    </div>
    <br>
    <div class="container-fluid" style="padding: 0px!important;">
        <table>
            <thead>
                <tr>
                    <th class="text-center text-uppercase" style="width: 2%;">N&deg;</th>
                    <th class="text-center text-uppercase" style="width: 8%;">Code</th>
                    <th class="text-center text-uppercase" style="width: 15%;">DESCRIPTION</th>
                    <th class="text-center text-uppercase"style="width: 7%;">Transation Note</th>
                    <th class="text-center text-uppercase"style="width: 7%;">Document Ref</th>
                    <th class="text-center text-uppercase"style="width: 3%;">QTY</th>
                    <th class="text-center text-uppercase"style="width: 5%;">UNIT PRICE</th>
                    <th class="text-center text-uppercase"style="width: 7%;">AMOUNT</th>
                    <th class="text-center text-uppercase" style="width: 7%;">Debit</th>
                    <th class="text-center text-uppercase" style="width: 7%;">Credit</th>
                    <th class="text-center text-uppercase"style="width: 5%;">Account No</th>
                    <th class="text-center text-uppercase"style="width: 15%;">Account Name</th>
                    <th class="text-center text-uppercase" style="width: 7%;">Debit</th>
                    <th class="text-center text-uppercase" style="width: 20%;">Credit</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $i=0;
                    $v_total_amo_debit=0;
                    $v_total_amo_credit=0;
                    $v_sql=$connect->query("SELECT A.*,acc_id,SUM(debit) AS total_debit,SUM(credit) AS total_credit,accca_number,accca_account_name 
                        FROM tbl_acc_add_tran_dr_cr_detail AS A 
                        LEFT JOIN tbl_acc_chart_account AS B ON A.acc_id=B.accca_id
                        WHERE A.main_id='$v_print_id' 
                        GROUP BY B.accca_id");

                    while ($row=mysqli_fetch_object($v_sql)) {
                        echo '<tr>';
                            echo '<td class="text-center">'.sprintf('%02d',++$i).'</td>';
                            echo '<td class="text-left">'.$row->detail_code.'</td>';
                            echo '<td class="text-left">'.$row->description.'</td>';
                            echo '<td class="text-left">'.$row->tran_note.'</td>';
                            echo '<td class="text-left">'.$row->doc_ref.'</td>';
                            echo '<td class="text-left">'.$row->qty.'</td>';
                            echo '<td class="text-center">$ '.number_format($row->unit_price,2).'</td>';
                            echo '<td class="text-center">$ '.number_format($row->qty*$row->unit_price,2).'</td>';
                            echo '<td class="text-center">$ '.number_format($row->debit_old,2).'</td>';
                            echo '<td class="text-left">$ '.number_format($row->credit_old,2).'</td>';
                            echo '<td class="text-left">'.$row->accca_number.'</td>';
                            echo '<td class="text-left">'.$row->accca_account_name.'</td>';
                            echo '<td class="text-center">$ '.number_format($row->total_debit,2).'</td>';
                            echo '<td class="text-center">$ '.number_format($row->total_credit,2).'</td>';
                        echo '</tr>';
                        $v_total_amo_debit+=$row->debit;
                        $v_total_amo_credit+=$row->credit;
                    }
                    for($idx=$i;$idx<@$_SESSION['new_row_acc_add_tra_debit_credit'];$idx++){
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
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th class="text-right">Total : </th>
                    <th class="text-center">$ <?= number_format($v_total_amo_debit,2) ?></th>
                    <th class="text-center">$ <?= number_format($v_total_amo_credit,2) ?></th>
                </tr>
                <tr>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th style="border: none;"></th>
                    <th class="text-right">Out of Balance:  </th>
                    <th class="text-center" colspan="2">$ <?= number_format($v_total_amo_debit-$v_total_amo_credit,2) ?></th>
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


