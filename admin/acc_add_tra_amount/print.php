<?php 
    include_once '../../config/database.php';
?>
<?php 

$sql=$connect->query("SELECT comci_name_kh,comci_name_en,comci_name_ch,comci_logo FROM tbl_com_company_info");
$row_header=mysqli_fetch_object($sql);

if(isset($_GET['print_id'])){
    $v_print_id=$_GET['print_id'];

    if($_GET['status']=='tra_amount'){
        // Body Invoice
        $sql_master=$connect->query("SELECT A.*
                FROM tbl_acc_add_tran_amount AS A 
                WHERE A.id='$v_print_id'");
        $row_master=mysqli_fetch_object( $sql_master);
        if($row_master->status_type==1){
            // echo '<td>Cash Record Voucher</td>';
            $sql=$connect->query("SELECT accdr_voucher_no,accdr_address FROM  tbl_acc_cash_record WHERE accdr_id='$row_master->ref_id'");
            $row_tmp=mysqli_fetch_object($sql);
            $result_ref_no=@$row_tmp->accdr_voucher_no;
            $result_address=@$row_tmp->accdr_address;
        }
        else if($row_master->status_type==2){
            // echo '<td>IV Sale Revenue</td>';
            $sql=$connect->query("SELECT inv_no,cussi_address
                FROM tbl_acc_none_sale_revenue AS A 
                LEFT JOIN tbl_cus_customer_info AS B 
                ON A.cus_id=B.cussi_id
                WHERE id='$row_master->ref_id'");
            $row_tmp=mysqli_fetch_object($sql);
            $result_ref_no=$row_tmp->inv_no;
            $result_address=@$row_tmp->cussi_address;
        }
        else if($row_master->status_type==3){
            // echo '<td>Bill Supplier</td>';
            $sql=$connect->query("SELECT inv_no,supsi_address
                FROM tbl_acc_none_bill_supp AS A 
                LEFT JOIN tbl_sup_supplier_info AS B 
                ON A.supp_id=B.supsi_id 
                WHERE id='$row_master->ref_id'");
            $row_tmp=mysqli_fetch_object($sql);
            $result_ref_no=$row_tmp->inv_no;
            $result_address=@$row_tmp->supsi_address;
        }
        else if($row_master->status_type==4){
            // echo '<td>Settle Advance</td>';
            $sql=$connect->query("SELECT entry_no,address
                FROM tbl_acc_none_settle_advance AS A 
                LEFT JOIN tbl_acc_other_rec_from_list AS B 
                ON A.rec_from_id=B.id
                WHERE id='$row_master->ref_id'");
            $row_tmp=mysqli_fetch_object($sql);
            $result_ref_no=@$row_tmp->address;
        }

        // For Detail
        $v_sql_detail=$connect->query("SELECT A.*,acc_id,debit,credit,accca_number,accca_account_name 
        FROM tbl_acc_add_tran_amount_detail AS A 
        LEFT JOIN tbl_acc_chart_account AS B ON A.acc_id=B.accca_id
        WHERE A.main_id='$v_print_id'");
    }
    else if($_GET['status']=='tra_debit_credit'){
        $sql_master=$connect->query("SELECT A.*
        FROM tbl_acc_add_tran_dr_cr AS A 
        WHERE A.id='$v_print_id'");
        $row_master=mysqli_fetch_object($sql_master);

        if($row_master->status_type==1){
            // echo '<td>Adjustment Record</td>';
            $sql=$connect->query("SELECT entry_no FROM tbl_acc_rec_adjustment WHERE id='$row_master->ref_id'");
            $row_tmp=mysqli_fetch_object($sql);
            $result_ref_no=$row_tmp->entry_no;
            $result_address='-';
        }
        else if($row_master->status_type==2){
            // echo '<td>IV Sale Revenue</td>';
            $sql=$connect->query("SELECT entry_no FROM tbl_acc_rec_stock_inventory WHERE id='$row_master->ref_id'");
            $row_tmp=mysqli_fetch_object($sql);
            $result_ref_no=$row_tmp->entry_no;
            $result_address='-';
        }
        else if($row_master->status_type==3){
            // echo '<td>Transfer Funds</td>';
            $sql=$connect->query("SELECT tran_ref_no AS entry_no FROM tbl_acc_add_transfer_fund WHERE id='$row_master->ref_id'");
            $row_tmp=mysqli_fetch_object($sql);
            $result_ref_no=$row_tmp->entry_no;
            $result_address='-';
        }

        // For Detail
        $v_sql_detail=$connect->query("SELECT A.*,acc_id,SUM(debit) AS total_debit,SUM(credit) AS total_credit,accca_number,accca_account_name 
            FROM tbl_acc_add_tran_dr_cr_detail AS A 
            LEFT JOIN tbl_acc_chart_account AS B ON A.acc_id=B.accca_id
            WHERE A.main_id='$v_print_id' 
            GROUP BY B.accca_id");
    }
}   
 ?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    <link href='https://fonts.googleapis.com/css?family=Khmer|DM+Serif+Display&display=swap' rel='stylesheet' type='text/css'>
    <style type="text/css">
        .main_border{
            border: 1px solid black;
            padding: 10px;
        }
        *{ 
            font-size: 10px!important; 
            font-family: 'khmer','Time New Reman';
            -webkit-print-color-adjust: exact;
        }
        table {
          border-collapse: collapse;
        }

        table >tbody, th, td {
          border: 1px solid black;
          padding: 3px!important;
        }
        table >thead >tr >th,
        table >tfoot >tr >th[class^=text]{
          background-color: #C9C9C9!important;
        }
        table >tbody >tr >td{
            border-width: 1px 1px; 
            border-color: rgba(132,123,124,0.8) black;
        }
        table >tbody >tr:last-child >td
        {
            border-bottom-width: 1px; border-bottom-color: black;
        }
        /*table >tbody >tr >td:first-child{
            border-left-width: 1px;border-left-color: black;
        }
        table >tbody >tr >td:last-child{
            border-right-width: 1px;border-right-color: black;
        }*/
        table >tbody >tr td{
            height: 28px;
        }
        table >tbody >tr:nth-child(even) {background-color: #EAF3FA!important;}
    </style>
</head>
    <link rel="stylesheet" href="../../print_offline/bootstrap.min.css">
    <script src="../../print_offline/jquery.min.js"></script>
<body>
    <div class="main_border">
        <div class="container-fluid">
            <br>
            <div class="row my_title">
                <div class="col-md-3 pull-left">
                    <p style="font-size: 16px!important; font-family: 'Khmer OS Muol'!important; font-weight: bold;"><?= $row_header->comci_name_kh ?></p>
                </div>
                <div class="col-md-9">
                    <p class="pull-right" style="font-size: 20px!important; font-family: 'Time New Romen'!important; font-weight: bold;"><?= $row_header->comci_name_en ?></p>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="container-fluid" style="border: 1px solid black;">
            <div class="row text-center">
                <br>
               <p class="text-uppercase" style="font-size: 18px!important; font-family: 'Khmer OS Muol Light'!important; text-decoration: underline;">សក្ខីបត្រទិន្នានុប្បវត្ដិ</p>
               <p class="text-uppercase" style="font-size: 20px!important; font-family: 'Time New Romen'!important; font-weight: bold; text-decoration: underline;">Transaction voucher</p>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <div class="row">
                        <div class="col-sm-2 pull-left">ឈ្មោះ<br>Name :</div>
                        <br>
                        <div class="col-sm-6 text_name_responsive" style="border-bottom: 1px solid black;margin-right: 10px;">
                            <?= (@$row_master->name)?(@$row_master->name):'-' ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-7"> 
                    <div class="row">
                        <div class="col-sm-3 pull-right" style="border-bottom: 1px solid black;margin-right: 10px;">
                            <br>
                            <?= date("d-M-Y",strtotime($row_master->date_record)) ?>
                        </div>
                        <div class="col-sm-2 pull-right">កាលបរិច្ឆេទ:<br>Date :</div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-5">
                    <div class="row" style="padding-top: 10px;">
                        <div class="col-sm-2">អាសយដ្ឋាន:<br>Address:</div>
                        <div class="col-sm-6" style="border-bottom: 1px solid black;">
                            <br>
                            <?= ($result_address)?($result_address):'-' ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="row" style="padding-top: 10px;">
                        <div class="col-xs-3 pull-right" style="border-bottom: 1px solid black;margin-right: 10px;">
                            <br>
                            <?= ($result_ref_no)?($result_ref_no):'-' ?>
                        </div>
                        <div class="col-sm-2 pull-right" style="padding-right: 10px;">លេខយោង:<br>Reference N&deg;:</div>
                    </div>
                </div>
            </div>
            <br>
        </div>
        <br>
        <div class="container-fluid" style="padding: 0px!important;">
            <table style="width: 100%;">
                <thead>
                    <tr style="height: 40px;">
                        <th class="text-center text-uppercase" style="width: 2%;">ល.រ<br>N&deg;</th>
                        <th class="text-center text-uppercase" style="width: 5%;">កូដ<br>Code</th>
                        <th class="text-center text-uppercase" style="width: 16%;">បរិយាយ<br>DESCRIPTION</th>
                        <th class="text-center text-uppercase"style="width: 26%;">សម្គាល់ប្រតិបត្ដិការ<br>Transation Note</th>
                        <th class="text-center text-uppercase"style="width: 10%;">ឯកសារយោង<br>Document Ref</th>
                        <th class="text-center text-uppercase"style="width: 8%;">កូដសម្គាល់គម្រោង<br>Project Code</th>
                        <th class="text-center text-uppercase"style="width: 5%;">លេខគណនី<br>acct n&deg;</th>
                        <th class="text-center text-uppercase" style="width: 7%;">ឥណពន្ធ<br>Debit</th>
                        <th class="text-center text-uppercase" style="width: 7%;">ឥណទាន<br>Credit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $i=0;
                        $v_total_amo_debit=0;
                        $v_total_amo_credit=0;
                        while ($row=mysqli_fetch_object($v_sql_detail)) {
                             echo '<tr>';
                                    echo '<td class="text-center">'.sprintf('%02d',++$i).'</td>';
                                    echo '<td class="text-left">'.$row->detail_code.'</td>';
                                    echo '<td class="text-left">'.$row->description.'</td>';
                                    echo '<td class="text-left">'.$row->tran_note.'</td>';
                                    echo '<td class="text-center">'.$row->doc_ref.'</td>';
                                    echo '<td class="text-center"></td>';
                                    echo '<td class="text-center">'.$row->accca_number.'</td>';
                                    if($row->debit<=0){
                                        echo '<td></td>';
                                    }
                                    else{
                                        echo '<td class="text-center">$ '.number_format($row->debit,2).'</td>';
                                    }

                                    if($row->credit<=0)
                                         echo '<td></td>';
                                     else
                                        echo '<td class="text-center">$ '.number_format($row->credit,2).'</td>';
                            echo '</tr>';
                            $v_total_amo_debit+=$row->debit;
                            $v_total_amo_credit+=$row->credit;
                        }
                        for($idx=$i;$idx<@$_SESSION['new_row'];$idx++){
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
                            echo '</tr>';
                        }
                     ?>
                </tbody>
                <tfoot>
                    <tr style="height: 28px;">
                        <th style="border: none;"></th>
                        <th style="border: none;"></th>
                        <th style="border: none;"></th>
                        <th style="border: none;"></th>
                        <th style="border: none;"></th>
                        <th class="text-center" colspan="2">សរុប<br>Total : </th>
                        <th class="text-center">$ <?= number_format($v_total_amo_debit,2) ?></th>
                        <th class="text-center">$ <?= number_format($v_total_amo_credit,2) ?></th>
                    </tr>
                </tfoot>
            </table>
            <br>
            <br>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-3">
                        <div class="text-center">
                            <p  style="font-family: 'Khmer'; font-weight: bold;">រៀបចំដោយ<br>Prepared by</p>
                            <br>
                            <br>
                            <br>
                            <br>
                            <hr style="border: 0.5px solid black; width: 70%;">
                            <p style="font-family: 'Khmer';">Date:.............................</p>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="text-center">
                            <p  style="font-family: 'Khmer';font-weight: bold;">ពិនិត្យលើកទី ១ ដោយ<br>First Check by</p>
                            <br>
                            <br>
                            <br>
                            <br>
                            <hr style="border: 0.5px solid black; width: 70%;">
                            <p style="font-family: 'Khmer';">Date:.............................</p>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="text-center">
                            <p  style="font-family: 'Khmer'; font-weight: bold;">ពិនិត្យលើកទី ២ ដោយ<br>Second Check by</p>
                            <br>
                            <br>
                            <br>
                            <br>
                            <hr style="border: 0.5px solid black; width: 70%;">
                            <p style="font-family: 'Khmer';">Date:.............................</p>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="text-center">
                            <p  style="font-family: 'Khmer'; font-weight: bold;">អនុម័តដោយ<br>Approved by</p>
                            <br>
                            <br>
                            <br>
                            <br>
                            <hr style="border: 0.5px solid black; width: 70%;">
                            <p style="font-family: 'Khmer';">Date:.............................</p>
                        </div>
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


