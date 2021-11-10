<?php include_once '../../config/database.php';?>
<?php 

if(@$_GET['date_start']&&@$_GET['date_end']!=""){
    // Getting Company Header
    $v_date_start=@$_GET['date_start'];
    $v_date_end=@$_GET['date_end'];
    $sql=$connect->query("SELECT comci_name_kh,comci_name_en,comci_name_ch,comci_logo FROM tbl_com_company_info");
    $row_header=mysqli_fetch_object($sql);
    
    // Body Invoice
    $sql_get_data = $connect->query("SELECT 
                                   *
        FROM   tbl_acc_cash_record AS A
        LEFT JOIN tbl_acc_decription AS B ON A.accdr_description=B.des_id
        WHERE DATE_FORMAT(accdr_date,'%Y-%m-%d') BETWEEN '$v_date_start' AND '$v_date_end' AND status=2
        ORDER BY accdr_date ASC");
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
        *{ font-size: 9px!important; }
        table{
            font-family: 'khmer os';
        }
        @media print {
            .table thead tr th{
                -webkit-print-color-adjust: exact;
                /*background: #222 !important;*/
                color: #000 !important;
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
            .table-bordered tr>th,.table-bordered tr>td{
                border: 0.5px solid #000!important;
            }
            .table td:nth-child(5){
                font-family: 'Khmer OS Muol Light';
            }
        }

    </style>
</head>
<body onload="window.print();">
    <div class="container">
        <div class="row">
        </div>
        <div class="row text-center my_title">
            <p style="font-size: 18px!important;"><?= $row_header->comci_name_kh ?></p>
            <p style="font-size: 15px!important; font-family: 'khmer os muol light'!important;"><?= $row_header->comci_name_en ?></p>
            <p style="font-size: 15px!important;text-decoration: underline;">None Cash Record Report</p>
            <p style="font-size: 13px!important;">From <?= date('D d-M-Y',strtotime($v_date_start)) ?> To <?= date('D d-M-Y',strtotime($v_date_end)) ?></p>
        </div>
    </div><br>
    <br>    
    <div class="container-fliud">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <!-- <th class="text-center">ថ្ងៃខែឆ្នាំ <br> Description</th> -->
                    <th class="text-center" style="width: 20px!important;">N&deg;</th>
                    <th class="text-center" style="width: 90px!important;">Date Record</th>
                    <th class="text-center" style="width: 30px!important;">Time</th>
                    <th class="text-center"style="width:50px!important;">Invoice N&deg;</th>
                    <th class="text-center"style="width:50px!important;">Voucher N&deg;</th>
                    <th class="text-center" style="width: 50px!important;">Name</th>
                    <th class="text-center" style="width:150px!important;">Description</th>
                    <th class="text-center" style="width: 100px!important;"> Accrul </th>
                    <th class="text-center" style="width: 400px!important;"> Note </th>
                </tr>
                <?php
                    $i=1;
                    $total_acc=0;
                    while($row_body=mysqli_fetch_object($sql_get_data)) 
                    {   
                        $v_date=$row_body->accdr_date;
                        $v_time=$row_body->accdr_time;
                        $v_inv_no=$row_body->accdr_invoice_no;
                        $v_vou_no=$row_body->accdr_voucher_no;
                        $v_name=$row_body->accdr_name;
                        $v_des=$row_body->des_name;
                        $v_accrul=$row_body->accdr_accrual;
                        $v_note=$row_body->accdr_note;
                    ?>
                    <tr>
                      <td class="text-left"><?= sprintf('%02d',$i); ?></td>
                      <td class="text-left"><?= date('D d-M-Y',strtotime($v_date)); ?></td>
                      <td class="text-left"><?= $v_time; ?></td>
                      <td class="text-left"><?= $v_inv_no; ?></td>
                      <td class="text-left"><?= $v_vou_no; ?></td>
                      <td class="text-left" style="font-family: 'khmer os'!important;"><?= $v_name; ?></td>
                      <td class="text-left"><?= $v_des; ?></td>
                      <td class="text-center"><?= number_format($v_accrul,2); ?> $</td>
                      <td class="text-center"><?= $v_note; ?> </td>
                    </tr>
                <?php
                    $i++;
                    $total_acc+=$v_accrul;
                }
                ?>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th class="text-center">Balance Accrual : </th>
                    <th class="text-center"><?= number_format($total_acc,2) ?>$</th>
                    <th></th>
                </tr>
            </tbody>
        </table>
    </div> 
</body>
</html>
<script type="text/javascript">
	setTimeout(function(){
		window.close();
	},1000);
</script>


