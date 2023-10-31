<?php include_once '../../config/database.php';?>
<?php

if(@$_GET['date_start']&&@$_GET['date_end']!=""){
    $v_bin_bal=@$_GET['bin_bal'];
    // Getting Company Header
    $v_date_start=$_GET['date_start'];
    $v_date_end=$_GET['date_end'];
    $sql=$connect->query("SELECT comci_name_kh,comci_name_en,comci_name_ch,comci_logo FROM tbl_com_company_info");
    $row_header=mysqli_fetch_object($sql);

    // Body Invoice
    $sql_get_data = $connect->query("SELECT
                                   *,C.name AS ex_name
        FROM   tbl_acc_cash_record AS A
        LEFT JOIN tbl_acc_decription AS B ON A.accdr_description=B.des_id
        LEFT JOIN tbl_acc_expense_type_list AS C ON A.expense_type_id=C.id
        WHERE DATE_FORMAT(accdr_date,'%Y-%m-%d') BETWEEN '$v_date_start' AND '$v_date_end' AND status=1
        ORDER BY accdr_date ASC");


    $sql=$connect->query("SELECT SUM(accdr_cash_in) AS bal_in,
         SUM(accdr_cash_out) AS bal_out
        FROM  tbl_acc_cash_record
        WHERE DATE_FORMAT(accdr_date,'%Y-%m-%d') < '$v_date_start' AND status=1");
    $row_old_bal=mysqli_fetch_object($sql);
    if(mysqli_num_rows($sql)>0)
        $v_old_amo=$row_old_bal->bal_in-$row_old_bal->bal_out;
    else
        $v_old_amo=0;
}
 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<div id ="content" class="container">
    <link rel="stylesheet" href="../../print_offline/bootstrap.min.css">    
    <style media="print">  
        *{ font-family: 'khmer os content'; font-size: 9px; }
        @media print {
            .table tfoot tr td.bg{      
                -webkit-print-color-adjust: exact;
                background: #444 !important;
                color: #fff !important;
            }
            .table *{ padding-bottom: 2px!important; padding-top: 2px!important; }
            .my_title>p{
                font-weight: bold!important;
            }
            .table-bordered tr>th,.table-bordered tr>td,.my_border_dark{
                border: 0.5px solid #000!important;
            }
            tbody tr:nth-child(1) >th {
                -webkit-print-color-adjust: exact;
                background: #A7B0B6 !important;
                color: #fff!important;
                padding: 5px!important;
                border:1px solid #fff!important;
            }
            #center >div p{
                font-weight: bold;
            }
        }
    </style>
    <center id="center">
        <div class="row">
            <p class="text-primary" style="color: #6467EF!important; font-size: 18px!important; font-family: 'khmer OS Muol Light'!important;"><?= $row_header->comci_name_kh ?></p>
            <p style="font-size: 20px!important; font-family: 'Time New Roman'!important;"><?= $row_header->comci_name_en ?></p>
            <p style="font-size: 20px!important; font-weight: bold; text-decoration: underline; font-family: 'Time New Roman'">Cash Record Report</p>
            <p style="font-size: 16px!important; font-weight: bold; font-family: 'Time New Roman'">From <?= date('D d-M-Y',strtotime($v_date_start)) ?> To <?= date('D d-M-Y',strtotime($v_date_end)) ?></p>
        </div>
    </center>
    <br>
    <div class="container-fliud">
        <table class="table table-bordered" style="padding-bottom: 2px!important; padding-top: 2px!important;">
            <tbody>
                <tr>
                    <th class="text-center" style="width: 20px!important;">N&deg;</th>
                    <th class="text-center" style="width: 90px!important;">Date</th>
                    <th class="text-center"style="width:50px!important;">Voucher N&deg;</th>
                    <th class="text-center"style="width:50px!important;">References</th>
                    <th class="text-center" style="width: 50px!important;">Name</th>
                    <th class="text-center" style="width:150px!important;">Description</th>
                    <th class="text-center" style="width: 70px!important;"> Cash In</th>
                    <th class="text-center" style="width: 70px!important;"> Cash Out</th>
                    <th class="text-center" style="width: 70px!important;"> Balance</th>
                    <th class="text-center" style="width: 400px!important;"> Note</th>
                </tr>
                <tr>
                    <th colspan="8" style="padding-left: 470px!important;">Beginning Balance : </th>
                    <th class="text-center"><?= number_format($v_old_amo,2) ?> $</th>
                    <th></th>
                </tr>
                <?php
                    $i=1;
                    $flag_in=$v_old_amo;
                    $flag_out=0;
                    $bal=round($v_old_amo,2);
                    $total_cash_in=0;
                    $total_cash_out=0;
                    $total_bal=0;
                    while($row_body=mysqli_fetch_object($sql_get_data))
                    {
                        $v_date=$row_body->accdr_date;
                        $v_inv_no=$row_body->accdr_invoice_no;
                        $v_voc_no=$row_body->accdr_voucher_no;
                        $v_name=$row_body->accdr_name;
                        $v_des=$row_body->des_name;
                        $v_note=$row_body->accdr_note;
                        $v_cash_in=$row_body->accdr_cash_in;
                        $v_cash_out=$row_body->accdr_cash_out;

                        $flag_in+=$row_body->accdr_cash_in;
                        $flag_out+=$row_body->accdr_cash_out;
                        $bal= round($bal+$row_body->accdr_cash_in-$row_body->accdr_cash_out,2);;
                    ?>
                    <tr>
                      <td class="text-left"><?= sprintf('%02d',$i); ?></td>
                      <td class="text-left"><?= date('d-M-Y',strtotime($v_date)); ?></td>
                      <td class="text-left"><?= $v_voc_no; ?></td>
                      <td class="text-left"><?= $v_inv_no; ?></td>
                      <td class="text-left"><?= $v_name; ?></td>
                      <td class="text-left"><?= $v_des; ?></td>
                      <td class="text-center"><?= number_format($v_cash_in,2); ?> $</td>
                      <td class="text-center"><?= number_format($v_cash_out,2); ?>$</td>
                      <td class="text-center"><?= number_format($bal,2); ?>$</td>
                      <td class="text-left"><?= $v_note; ?></td>
                    </tr>
                <?php
                    $i++;
                    $total_cash_in+=$v_cash_in;
                    $total_cash_out+=$v_cash_out;
                    $total_bal=$v_old_amo+$total_cash_in-$total_cash_out;

                }
                ?>
                <tr>
                    <th colspan="6" style="padding-left: 400px!important;">Balance : </th>
                    <th class="text-center"><?= number_format($total_cash_in,2) ?> $</th>
                    <th class="text-center"><?= number_format($total_cash_out,2) ?> $</th>
                    <th class="text-center"><?= number_format($total_bal,2) ?>$</th>
                    <th></th>
                </tr>
            </tbody>
        </table>
    </div>
  <div id="pageFooter"></div>
  </div>
</body>
</html>
<script src="../../print_offline/jquery.min.js"></script>
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