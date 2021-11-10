<?php include_once '../../config/database.php';?>
<?php include_once 'myfunction.php';?>
<?php include_once '../../plugin/My_Operation/my_operation.php';?>
<?php
$sql=$connect->query("SELECT comci_name_kh,comci_name_en,comci_name_ch,comci_logo FROM tbl_com_company_info");
$row_header=mysqli_fetch_object($sql);

if(@$_GET['date_start']&&@$_GET['date_end']!=""){
    $v_date_s = @$_GET['date_start'];
    $v_date_e = @$_GET['date_end'];
     $str="SELECT * FROM (
                SELECT '1' AS statustable,A.status_type,A.date_record,A.ref_id
                FROM tbl_acc_add_tran_amount AS A 
                WHERE DATE_FORMAT(A.date_record,'%Y-%m-%d') BETWEEN '$v_date_s' AND '$v_date_e' AND p_appr='1'
                UNION
                SELECT '2' AS statustable,AA.status_type,AA.date_record,AA.ref_id
                FROM tbl_acc_add_tran_dr_cr AS AA 
                WHERE DATE_FORMAT(AA.date_record,'%Y-%m-%d') BETWEEN '$v_date_s' AND '$v_date_e'  AND p_appr='1' 
            ) AS A 
            ORDER BY A.date_record ASC
            ";
}
else{
    $v_current_year_month = date('Y-m');
    $str="SELECT '1' AS statustable,A.status_type,A.date_record,A.ref_id
            FROM tbl_acc_add_tran_amount AS A 
            WHERE DATE_FORMAT(A.date_record,'%Y-%m')='$v_current_year_month' AND p_appr='1'
            UNION
            SELECT '2' AS statustable,AA.status_type,AA.date_record,AA.ref_id
            FROM tbl_acc_add_tran_dr_cr AS AA 
            WHERE DATE_FORMAT(AA.date_record,'%Y-%m')='$v_current_year_month' AND p_appr='1'
            ORDER BY date_record ASC
            ";
}
$get_data_main = $connect->query($str);
 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../print_offline/bootstrap.min.css">    
</head>
<body>
<div id ="content" class="container">
    <style>  
        *{ font-family: 'khmer', 'Time New Roman'; font-size: 9px; -webkit-print-color-adjust: exact;}
        @media print {
            table, th, td {
                -webkit-print-color-adjust: exact;
                /*border: 1px solid black;*/
                border-collapse: collapse;
            }
            th, td {
                padding: 5px;
                text-align: left;    
            }
            tr:first-child th{
                border-bottom:1px solid black!important;
            }
            h5{
                color: #9692C9!important;
            }
        }
    </style>
    <center id="center">
        <div class="row">
            <!-- <p class="text-primary" style="color: #6467EF!important; font-size: 18px!important; font-family: 'khmer OS Muol Light'!important;"><?= $row_header->comci_name_kh ?></p> -->
            <p style="font-size: 27px!important; font-weight: bold; font-family: 'Time New Roman'!important; color: #B795C8!important;"><?= $row_header->comci_name_en ?></p>
            <p style="font-size: 20px!important; font-weight: bold; text-decoration: underline; font-family: 'Time New Roman'">Journals</p>
            <b><h6 style="font-family: 'Khmer OS Moul';">FROM <?= @$_GET['date_start'] ?> TO <?= @$_GET['date_end'] ?></h6></b>
        </div>
    </center>
    <br>
    <br>
    <div class="portlet-body">
        <table class="myTable" role="grid" aria-describedby="sample_1_info">
            <tr role="row" class="text-center">
                <th class="text-center" style="min-width: 10px!important;">N&deg;</th>
                <th class="text-center" style="min-width: 60px!important;">Date Record</th>
                <th class="text-center" style="min-width: 100px!important;">Number</th>
                <th class="text-center">Name</th>
                <th class="text-center">Description</th>
                <th class="text-center">Transaction Note</th>
                <th class="text-center">Account</th>
                <th class="text-center">Debit</th>
                <th class="text-center">Credit</th>
            </tr>
            <tbody>
            <?php
                $grand_total_debit = 0;
                $grand_total_credit = 0;
                $i = 1;
                $tmp=0;
                while ($row_main = mysqli_fetch_object($get_data_main)) {
                    $main_date = $row_main->date_record;
                    
                    
                    $v_ref_id=$row_main->ref_id;
                    if(@$_GET['type']==''){
                        $str=myDetail1($v_ref_id,$row_main->statustable,$row_main->status_type);
                    }
                    else{
                        $str=myDetail2($v_ref_id,$row_main->statustable,$row_main->status_type,@$_GET['type']);
                    }
                    $sql1=$connect->query($str);
                    $v_num_row=@mysqli_num_rows($sql1);

                    if($v_num_row<=0)continue;                    
                            $total_debit=0;
                            $total_credit=0;    
                            $v_count_row = mysqli_num_rows($sql1);
                            $v_span_row = $v_count_row;
                            while ($row_detail=mysqli_fetch_object($sql1)) {

                                $v_ref_no=$row_detail->entry_no;
                                $v_name=$row_detail->name;

                                $total_debit+= $row_detail->debit;
                                $total_credit+= $row_detail->credit;

                                echo '<tr>';
                                    if($v_count_row == $v_span_row--){
                                        echo '<td style="vertical-align: top!important;" rowspan="'.$v_count_row.'">'.$i.'</td>';
                                        echo '<td style="vertical-align: top!important;" rowspan="'.$v_count_row.'">'.date('Y-m-d',strtotime($main_date)).'</td>';
                                        echo '<td style="vertical-align: top!important;width: 100px;" class="text-left" rowspan="'.$v_count_row.'">'.$row_detail->entry_no.'</td>';
                                        echo '<td style="vertical-align: top!important;" class="text-left" rowspan="'.$v_count_row.'">'.$row_detail->name.'</td>';
                                    }
                                    echo '<td class="text-left">'.$row_detail->description.'</td>';
                                    echo '<td class="text-left">'.$row_detail->tran_note.'</td>';
                                    echo '<td class="text-left" style="width: 250px;">'.$row_detail->accca_number.' - '.$row_detail->accca_account_name.'</td>';
                                    echo '<td class="text-right" style="width: 90px;">';
                                        if($row_detail->debit!=0)
                                            echo '<span class="pull-left">$</span>
                                            <span class="pull-right">'.number_format($row_detail->debit,2).'</span>
                                        </td>';
                                    echo '<td class="text-right" style="width: 90px;">';
                                        if($row_detail->credit!=0)
                                            echo '<span class="pull-left">$</span>
                                            <span class="pull-right">'.number_format($row_detail->credit,2).'</span>
                                        </td>';
                                echo '</tr>';
                                $tmp++;
                            }
                        echo '
                            <tr>
                                <th colspan="7" class="text-right" style="font-weight: bold;">Total: </th>
                                <th class="text-right bg-info norwap" style="font-weight: bold;">
                                    <span class="pull-left">$</span>
                                    <span class="pull-right" style="width: 80%; border-bottom: 3px double black;">'.number_format($total_debit,2).'</span>
                                </th>
                                <th class="text-right bg-info norwap" style="font-weight: bold;">
                                    <span class="pull-left">$</span>    
                                    <span class="pull-right" style="width: 80%; border-bottom: 3px double black;">'.number_format($total_credit,2).'</span>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="10" class="text-right"></th>
                            </tr>';
                    $grand_total_debit += $total_debit;
                    $grand_total_credit += $total_credit;
                    $tmp=$i;
                    $i++;
                }
            ?>
            </tbody>
        </table>
    </div>
    <br>
    <h5 class="text-right">Total Debit : $ <?= number_format($grand_total_debit,2) ?></h5>
    <h5 class="text-right">Total Credit : $ <?= number_format($grand_total_credit,2) ?></h5>
    <h5 class="text-right">Total Balance : $ <?= number_format(($grand_total_debit-$grand_total_credit),2) ?></h5>
  </div>
</body>
</html>
<script src="../../print_offline/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
        window.print();
    });
    setTimeout(function(){
      window.close();
    },1000);
</script>