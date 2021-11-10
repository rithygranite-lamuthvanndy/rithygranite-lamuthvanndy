<?php 
    include_once '../../config/database.php';
?>
<?php 

$sql=$connect->query("SELECT comci_name_kh,comci_name_en,comci_name_ch,comci_logo FROM tbl_com_company_info");
$row_header=mysqli_fetch_object($sql);

if(isset($_GET['print_id'])){
    $v_print_id=$_GET['print_id'];

    $sql=$connect->query("SELECT A.*,B.name AS other_name,B.*,C.po_name AS pos_name
            FROM tbl_acc_none_settle_advance AS A
            LEFT JOIN tbl_acc_other_rec_from_list AS B ON A.rec_from_id=B.id
            LEFT JOIN tbl_acc_position AS C ON A.pos_id=C.po_id
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
           <p style="font-size: 19px!important; font-family: 'Time New Romen'!important; font-weight: bold; text-decoration: underline;">ADD NONE SETTLE ADVANCE RECORD</p>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-4">
                <div class="row">
                    <div class="col-xs-5">Name :</div>
                    <div class="col-xs-7"><?= $row_main->other_name ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-5">Position *:</div>
                    <div class="col-xs-7"><?= $row_main->pos_name ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-5">Address:</div>
                    <div class="col-xs-7" style="word-break: break-all;"><?= $row_main->address ?></div>
                    <br>
                </div>
                <div class="row">
                    <div class="col-xs-5">Phone No *:</div>
                    <div class="col-xs-7"><?= $row_main->phone_number ?></div>
                </div>
            </div>

            <div class="col-xs-3 pull-right">
                <div class="row">
                    <div class="col-xs-5">Date:</div>
                    <div class="col-xs-7"><?= date('d-M-Y',strtotime($row_main->date_record)) ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-5">Entry No:</div>
                    <div class="col-xs-7"><?= $row_main->entry_no ?></div>
                    <br>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="container-fluid">
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th class="text-center">N&deg;</th>
                    <th class="text-center" style="width: 10%;">Code</th>
                    <th class="text-center" style="width: 30%;">Description</th>
                    <th class="text-left">Transation Note</th>
                    <th class="text-left">Document Ref</th>
                    <th class="text-left">Quantity</th>
                    <th class="text-left">Unit</th>
                    <th class="text-left">Price</th>
                    <th class="text-center">Debit</th>
                    <th class="text-center">Credit</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $i=0;
                    $tot_in=0;
                    $tot_out=0;
                    $v_sql=$connect->query("SELECT A.*,des_name
                        FROM tbl_acc_none_settle_advance_detail AS A 
                        LEFT JOIN tbl_acc_decription AS B ON A.description_id=B.des_id
                        WHERE A.main_id='$v_print_id'");
                    while ($row=mysqli_fetch_object($v_sql)) {
                        echo '<tr>';
                            echo '<td class="text-center">'.sprintf('%02d',++$i).'</td>';
                            echo '<td class="text-center">'.$row->code_no.'</td>';
                            echo '<td class="text-left">'.$row->des_name.'</td>';
                            echo '<td class="text-left">'.$row->tran_note.'</td>';
                            echo '<td class="text-left">'.$row->doc_ref.'</td>';
                            echo '<td class="text-center">'.$row->quantity.'</td>';
                            echo '<td class="text-center">'.$row->unit.'</td>';
                            echo '<td class="text-center">$ '.number_format($row->price,2).'</td>';
                            echo '<td class="text-center">$ '.number_format($row->settle_in,2).'</td>';
                            echo '<td class="text-center">$ '.number_format($row->settle_out,2).'</td>';
                        echo '</tr>';
                        $tot_in+=$row->settle_in;
                        $tot_out+=$row->settle_out;
                    }
                    for($idx=$i;$idx<@$_SESSION['new_row_acc_none_settle_advance_record'];$idx++){
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
                    <th style="border: none;"></th>
                    <th>Total:</th>
                    <th class="text-center">$ <?= number_format($tot_in,2) ?></th>
                    <th class="text-center">$ <?= number_format($tot_out,2) ?></th>
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


