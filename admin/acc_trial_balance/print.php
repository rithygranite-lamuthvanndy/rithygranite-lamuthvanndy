<?php include_once '../../config/database.php';?>
<?php include_once 'my_function.php';?>
<?php include_once '../acc_ledger/myfunction.php'; ?>
<?php   include '../acc_my_operation/my_operation.php'; ?>
<?php 

$sql=$connect->query("SELECT comci_name_kh,comci_name_en,comci_name_ch,comci_logo FROM tbl_com_company_info");
$row_header=mysqli_fetch_object($sql);

if(@$_GET['date_start']==''&&@$_GET['date_end']==''){
    $sql_master_detail=my_detail_normal();
}   
else{
    $v_date_start=@$_GET['date_start'];
    $v_date_end=@$_GET['date_end'];
    $sql_master_detail=my_detail_date($v_date_start,$v_date_end);
}
 ?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../print_offline/bootstrap.min.css">
    <script src="../../print_offline/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Khmer&family=Time New Roman" rel="stylesheet"> 
    <style type="text/css">
        *{ 
            font-size: 15px!important; 
            font-family: 'Khmer', 'Time New Roman';
            -webkit-print-color-adjust: exact;
        }
        @media print {
            table tr:nth-child(even) td{ 
                background: #F2F2F2!important;
            }
            tr:first-child th{ 
                background-color: #FCE4D6!important;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row text-center my_title">
            <p style="font-size: 27px!important; font-family: 'Time New Romen'!important; font-weight: bold ;color: #B795C8!important;"><?= $row_header->comci_name_en ?></p>
            <p style="font-size: 20px!important; font-weight: bold;" class="text-uppercase">Trial Balance</p>
            <p style="font-size: 20px!important;" class="text-uppercase">From <?= (@$v_date_start)?(@$v_date_start):date('Y-m-d') ?> To <?= (@$v_date_end)?(@$v_date_end):date('Y-m-d'); ?></p>
        </div>
    </div><br>
    <div class="container-fliud">
        <table class="table">
            <tbody>
                <tr>
                    <th class="text-right text-uppercase" colspan="2" style="text-decoration: underline; padding-right: 30px;">Debit</th>
                    <th class="text-center text-uppercase" style="text-decoration: underline;">Credit</th>
                </tr>
                <?php
                        $i = 0;
                        if(($_GET['date_start']&&$_GET['date_end'])!=''){
                            $v_start=@$_GET['date_start'];
                            $v_end=@$_GET['date_end'];
                            if($v_start>$v_end){
                                echo '<script>myAlertInfo("Please Choose Date From Before Date End")</script>';
                                header( "refresh:3;url=index.php" );
                            }
                            $sql = my_detail_date($v_start,$v_end);
                        }
                        else{
                            $sql=my_detail_date(date('Y-m-d'),date('Y-m-d'));
                        }
                        // echo $sql;
                        $get_cur=$connect->query($sql);
                        // $get_data_cur=$connect->query($sql[1]);
                        $grand_total_debit=0;
                        $grand_total_credit=0;
                        while ($row = mysqli_fetch_object($get_cur)) {
                            if(($_GET['date_start']&&$_GET['date_end'])!=''){
                                $sql_old=my_detail_date($v_start,$v_end,$row->accca_id);
                            }
                            else{
                                $sql_old=my_detail_date(date('Y-m-d'),date('Y-m-d'),$row->accca_id);
                            }
                            // echo '<br><br>'.$sql_old;
                            $get_old_data=$connect->query($sql_old);
                            $row_old=mysqli_fetch_object($get_old_data);

                            $res_debit=$row_old->total_debit1+$row_old->total_debit2+$row->total_debit1+$row->total_debit2;
                            $res_credit=$row_old->total_credit1+$row_old->total_credit2+$row->total_credit1+$row->total_credit2;


                            $v_bal=calBalance($row->accca_id,$res_debit,$res_credit);
                            // echo $v_bal;
                            if ((@$_GET['type'])=='option2') {
                                if($v_bal==0)continue;  
                            }


                            $show_bal=Show_Trial_bal($row->accca_id,$v_bal);
                            echo '<tr style="width: 100px!important;">';
                                echo '<td>'.$row->accca_number.'-'.$row->accca_account_name.'</td>';
                                echo '<td style="width: 120px;"><span class="pull-left">$</span><span class="pull-right">'.myFormat(abs($show_bal[0])).'</span></td>';
                                echo '<td style="width: 120px;"><span class="pull-left">$</span><span class="pull-right">'.myFormat(abs($show_bal[1])).'</span></td>';
                            echo '</tr>';
                            $grand_total_debit+=abs($show_bal[0]);
                            $grand_total_credit+=abs($show_bal[1]);
                        }
                    ?>
            </tbody>
            <footer>
                <tr>
                    <th class="text-right" style="font-weight: bold;">Total :</th>
                    <th class="text-right" style="font-weight: bold; padding: 0px;">
                        <div style="width: 90%; border-top: 2px solid black; padding: 8px; margin: auto;">
                            <span class="pull-left">$ </span></span>
                            <span class="pull-right" style="padding-right: 10px;"><?= number_format($grand_total_debit,2) ?></span>
                        </div>
                    </th>
                    <th class="text-right" style="font-weight: bold; padding: 0px;">
                        <div style="width: 90%; border-top: 2px solid black; padding: 8px; margin: auto;">
                            <span class="pull-left">$ </span></span>
                            <span class="pull-right" style="padding-right: 10px;"><?= number_format($grand_total_credit,2) ?></span>
                        </div>
                    </th>
                </tr>
            </footer>
        </table>
    </div> 
    <script type="text/javascript">
        $(document).ready(function () {
            window.print();
        });
        setTimeout(function(){
           window.close();
        },100);
    </script>
</body>
</html>


