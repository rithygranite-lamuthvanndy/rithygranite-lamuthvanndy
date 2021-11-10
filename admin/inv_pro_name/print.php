<?php include_once '../../config/database.php';?>
<?php 

if(@$_GET['date_start']&&@$_GET['date_end']!=""){
    $v_bin_bal=@$_GET['bin_bal'];
    // Getting Company Header
    $v_date_start=$_GET['date_start'];
    $v_date_end=$_GET['date_end'];
    $sql=$connect->query("SELECT comci_name_kh,comci_name_en,comci_name_ch,comci_logo,comci_addr FROM tbl_com_company_info");
    $row_header=mysqli_fetch_object($sql);
    
    // Body Invoice
    $sql_get_data = $connect->query("SELECT 
           A.*,E.*,des_name,
           SUM(accdr_cash_in) AS bal_in,
           SUM(accdr_cash_out) AS bal_out
        FROM  tbl_acc_cash_record AS A 
        LEFT JOIN tbl_acc_transaction_type_list AS C ON A.tran_type_id=C.trat_id
        LEFT JOIN tbl_acc_voucher_type_list AS D ON A.vou_type_id =D.vot_id
        LEFT JOIN tbl_acc_cash_record_detail AS E ON A.accdr_id=E.cash_rec_id
        LEFT JOIN tbl_acc_decription AS F ON E.des_id=F.des_id
        WHERE DATE_FORMAT(accdr_date,'%Y-%m-%d') BETWEEN '$v_date_start' AND '$v_date_end'
        GROUP BY E.detail_id
        ORDER BY accdr_date,accdr_id ASC");


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
<body id="content">
<!-- <body id="content" style="width: 80%; margin: auto;"> -->
    <link rel="stylesheet" href="../../print_offline/bootstrap.min.css">
    <style type="text/css">
        *{ font-family: 'khmer os content'; font-size: 17px!important; }
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
            tbody tr:nth-child(1) >th, tbody tr:last-child >th,tbody tr >td:nth-child(10){
                -webkit-print-color-adjust: exact;
                background: #EEECE1!important;
                /*font-size: 20px!important;*/
                padding: 5px!important;
            }

            .my_summary tr:nth-child(1) >th,.my_summary tr:last-child >td{
                background-color: #DDD9C4!important;
            }
            .my_summary{
                width: 700px!important;
            }
        }
    </style>
    <div class="container">
        <br>
        <br>
        <div class="row my_title">
            <div style="position: absolute; top: 10px; left: 10px;">
                <img style="margin-left: 0px!important;" width="80px" class="img-reponsive" src="../../img/img_logo/<?= $row_header->comci_logo ?>">
            </div>
                <div style="position: absolute; width: 100%; left: 0px; top: 0px; text-align: center;">
                    <h1 style="color: #6467EF!important; font-weight: bold!important; font-size: 30px!important; font-family: 'Time New Roman'!important;"><?= $row_header->comci_name_en ?></h1>
                    <p style="font-size: 20px!important; font-family: 'Time New Roman'!important;"><?= $row_header->comci_addr ?></p>
                    <p style="font-size: 25px!important;font-weight: bold; text-decoration: underline; font-family: 'Time New Roman'">Cash on Hand Report <?= date('F-Y', strtotime($v_date_start)) ?></p>
                </div>

                <!-- </div> -->
        </div>
    </div><br>
    <br>    
    <br>    
    <br>     
    <div class="container-fliud">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th class="text-center" style="width: 5px;">N&deg;</th>
                    <th class="text-center" style="width: 90px;">Date</th>
                    <th class="text-center" style="width: 15px;">Section</th>
                    <th class="text-center" style="width: 130px;">Reference</th>
                    <th class="text-center" style="width: 20px;">FR/ER</th>
                    <th class="text-center" style="width: 180px;">Description</th>
                    <th class="text-center" style="width: 180px;">Transaction note </th>
                    <th class="text-center" style="width: 130px;">Received (USD)</th>
                    <th class="text-center" style="width: 130px;">Payment (USD)</th>
                    <th class="text-center" style="width: 130px;">Amount (USD)</th>
                </tr>
                <tr>
                    <th colspan="9" class="text-right">Beginning Balance : </th>
                    <th class="text-center"><?= number_format($v_old_amo,2) ?> $</th>
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
                        $v_des=$row_body->accdr_note;
                        $v_tran_note=$row_body->tran_note;
                        $v_cash_in=$row_body->accdr_cash_in;
                        $v_cash_out=$row_body->accdr_cash_out;

                        $flag_in+=$row_body->accdr_cash_in;
                        $flag_out+=$row_body->accdr_cash_out;
                        $bal= round($bal+$row_body->accdr_cash_in-$row_body->accdr_cash_out,2);;
                    ?>
                    <tr>
                      <td class="text-left"><?= sprintf('%02d',$i); ?></td>
                      <td class="text-left" style="width: 120px!important;"><?= date('d-M-Y',strtotime($v_date)); ?></td>
                      <td class="text-left">Min3</td>
                      <td class="text-left" style="width: 150px!important;"><?= $v_voc_no; ?></td>
                      <td class="text-left"><?= $v_inv_no; ?></td>
                      <td class="text-left"><?= $v_des; ?></td>
                      <td class="text-left"><?= $v_tran_note; ?></td>
                      <td class="text-center"><?= number_format($v_cash_in,2); ?> $</td>
                      <td class="text-center"><?= number_format($v_cash_out,2); ?>$</td>
                      <td class="text-center"><?= number_format($bal,2); ?>$</td>
                    </tr>
                <?php
                    $i++;
                    $total_cash_in+=$v_cash_in;
                    $total_cash_out+=$v_cash_out;
                    $total_bal=$v_old_amo+$total_cash_in-$total_cash_out;

                }
                ?>
                <tr>
                    <th colspan="7" class="text-right">Balance : </th>
                    <th class="text-center"><?= number_format($total_cash_in,2) ?> $</th>
                    <th class="text-center"><?= number_format($total_cash_out,2) ?> $</th>
                    <th class="text-center"><?= number_format($total_bal,2) ?>$</th>
                </tr>
            </tbody>
        </table>
        

        <!-- Start Summary Cash In Flow -->
        <div class="text-uppercase">
            <p style="font-size: 20px!important; text-decoration: underline; color: #5458F2!important;-webkit-color: #5458F2!important;">Summary Cash In Flow</p>
        </div>
        <table class="my_summary table table-bordered">
            <thead>
                <tr>
                    <th>N&deg;</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Investment from CFO</td>
                    <td>0.00</td>
                    <td>ទទួលពីលោកអគ្គនាយកបណ្តាក់ទុនជាសាច់ប្រាក់  (សំរាប់ទូទាត់ចំណាយក្នុងសំណើរលេខ 18-0011 +ក្រៅសំណើរ + មិនមានក្នុងសំណើរ )</td>
                </tr>
                <tr>
                    <td colspan="2">Total :</td>
                    <td>123</td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <!-- Sign  -->
        <div class="row">
            <div class="col-xs-3 text-center">
                <p style="font-size: 22px!important; font-weight: bold;">Prepared by</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black;">
                <p style="font-size: 20!important;">General Cashier​</p>
            </div>

            <div class="col-xs-3 text-center">
                <p style="font-size: 22px!important; font-weight: bold;">Checked by</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black;">
                <p style="font-size: 20!important;">Chief Accountant</p>
            </div>

            <div class="col-xs-3 text-center">
                <p style="font-size: 22px!important; font-weight: bold;">Checked by</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black;">
                <p style="font-size: 20!important;">Chief Financial Officer (CFO)</p>
            </div>

            <div class="col-xs-3 text-center">
                <p style="font-size: 22px!important; font-weight: bold;">Approved by</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black;">
                <p style="font-size: 20!important;">Chief Executive Officer (CEO)</p>
            </div>
        </div>
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


