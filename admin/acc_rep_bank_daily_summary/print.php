<?php 
    include_once '../../config/database.php';
    include_once 'my_function.php';
?>
<?php 
if(@$_GET['date_start']){
    $v_date_start=$_GET['date_start'];
    $v_date_end=$_GET['date_end'];
}
$sql=$connect->query("SELECT comci_name_kh,comci_name_en,comci_name_ch,comci_logo,comci_addr FROM tbl_com_company_info");
    $row_header=mysqli_fetch_object($sql);

 ?>
<!DOCTYPE html>
<html>
<head>  
    <meta charset="utf-8">
</head>
<!-- <body id="content" style="width: 70%; margin: auto;"> -->
<body id="content">
    <link rel="stylesheet" href="../../print_offline/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Khmer&family=Time New Roman" rel="stylesheet">
    <style>
        * {
            font-family: 'Khmer', 'Time New Roman';
             -webkit-print-color-adjust: exact;
        }
    </style>
    <style type="text/css">
        #my_first_table tr>th,
        #my_fourth_table tr:nth-child(1) >th{
            -webkit-print-color-adjust: exact;
            background-color: #2F75B5!important;
            -webkit-background-color: #2F75B5!important;
            color: #fff!important;
            -webkit-color: #fff!important;
        }
        #my_first_table tr:last-child >td{
            -webkit-print-color-adjust: exact;
            background-color: #DDEBF7!important;
            -webkit-background-color: #DDEBF7!important;
        }

        #my_second_table tr>th,#my_third_table tr:nth-child(1) >th{
            background-color: #FFE699!important;
            -webkit-print-color-adjust: exact;
            -webkit-background-color: #FFE699!important;
        }

        #my_second_table tr:nth-child(1) >th:nth-child(1),
        #my_second_table tr:nth-child(1) >th:nth-child(2),
        #my_second_table tr:nth-child(1) >th:nth-child(4)
        {
            padding: 45px 0px!important;
        } 
        #my_second_table tr:nth-child(4)>td,
        #my_second_table tr:nth-last-child(2) >td,
        #my_third_table tr:last-child >th
        {
            -webkit-print-color-adjust: exact;
            background-color: #FFF2CC!important;
            -webkit-background-color: #FFF2CC!important;
        } 

        #my_third_table tr:nth-child(1) >th:first-child,
        #my_third_table tr:nth-child(1) >th:nth-last-child(2)
        {
            padding: 20px 0px!important;
        }
        #my_third_table tr:nth-child(1) >th:last-child{
            padding: 40px 0px!important;
        }

        #my_fourth_table .my_sub_th{
            -webkit-print-color-adjust: exact;
            background: #DDEBF7!important;
            -webkit-background: #DDEBF7!important;
        }

        .tablefive thead >tr,
        .tablefive tfoot >tr
        {
            background: #D9E1F2!important;
        }
        table.tablefive tbody tr td{
            vertical-align: middle;
        }
    </style>
    <div class="container">
        <br>
        <br>
        <div class="row text-center my_title">
            <div style="position: absolute; top: 10px;left: 10px;">
                <img width="80px" class="img-reponsive" src="../../img/img_logo/<?= $row_header->comci_logo ?>">
            </div>
            <div style="position: absolute; width: 100%; left: 0px; top: 0px; text-align: center;">
                <h1 class="text-primary" style="color: #6467EF!important; font-weight: bold!important; font-size: 30px!important; font-family: 'Time New Roman'!important;"><?= $row_header->comci_name_en ?></h1>
                <p style="font-size: 25px!important; text-decoration: underline; font-family: 'Khmer OS Muol Light','Khmer OS';">របាយការណ៍សាច់ប្រាក់ប្រចាំថ្ងៃ</p>
            </div>
        </div>
    </div><br>
    <br>
    <ul>
            <li>ឈ្មោះក្រុមហ៊ុន  : ឬទ្ធីក្រានីត(សកម្មភាពថ្មក្រានីត)</li>
            <li>កាលបរិច្ឆេទ     : <?php echo date('d-M-Y') ?></li>
        </ul>    
    <div class="portlet-body">
        <div class="container-fliud">
        <!-- First Table -->
        <table class="table table-bordered" id="my_first_table">
            <tbody>
                <tr>
                    <th class="text-center">I- ទិន្នន័យសាច់ប្រាក់ជាក់ស្តែងប្រចាំថ្ងៃ</th>
                    <th class="text-center">សមតុល្យដើមគ្រា</th>
                    <th class="text-center">ទឹកប្រាក់ចូល</th>
                    <th class="text-center">ទឹកប្រាក់ចេញ</th>
                    <th class="text-center">សមតុល្យចុងគ្រា</th>
                </tr>
                <tr>
                  <td class="text-left">1- សាច់ប្រាក់ក្នុងដៃ</td>
                  <td class="text-center">$ <?= number_format(i_cash_on_hand_old_total($v_date_start),2) ?></td>
                  <td class="text-center">$ <?= number_format(i_cash_on_hand_cash_in_total($v_date_start,$v_date_end),2) ?></td>
                  <td class="text-center">$ <?= number_format(i_cash_on_hand_cash_out_total($v_date_start,$v_date_end),2) ?></td>
                    <?php 
                        $v_old_cash_on_hand=i_cash_on_hand_old_total($v_date_start)
                        +i_cash_on_hand_cash_in_total($v_date_start,$v_date_end)
                        -i_cash_on_hand_cash_out_total($v_date_start,$v_date_end);
                     ?>
                  <td class="text-center">$ <?= number_format(
                    $v_old_cash_on_hand,2) ?></td>
                </tr>
                <tr>
                  <td class="text-left text-danger">*** ប្រតិបត្តិការណ៍ចុះបញ្ជី</td>
                  <td class="text-center">$ <?= number_format(i_re_cash_old_total($v_date_start),2) ?></td>
                  <td class="text-center">$ <?= number_format(i_re_cash_cash_in_total($v_date_start,$v_date_end),2) ?></td>
                  <td class="text-center">$ <?= number_format(i_re_cash_cash_out_total($v_date_start,$v_date_end),2) ?></td>
                  <td class="text-center">$ <?= number_format(
                    i_re_cash_old_total($v_date_start)
                  +i_re_cash_cash_in_total($v_date_start,$v_date_end)
                  -i_re_cash_cash_out_total($v_date_start,$v_date_end),2) ?></td>
                </tr>
                <tr>
                  <td class="text-left">2- សាច់ប្រាក់ក្នុងធនាគារ</td>
                  <td class="text-center">$ <?= number_format(i_cash_in_bank_old_total($v_date_start),2) ?></td>
                  <td class="text-center">$ <?= number_format(i_cash_in_bank_cash_in_total($v_date_start,$v_date_end),2) ?></td>
                  <td class="text-center">$ <?= number_format(i_cash_in_bank_cash_out_total($v_date_start,$v_date_end),2) ?></td>
                  <td class="text-center">$ <?= number_format(
                    i_cash_in_bank_old_total($v_date_start)
                    +i_cash_in_bank_cash_in_total($v_date_start,$v_date_end)
                    -i_cash_in_bank_cash_out_total($v_date_start,$v_date_end),2) ?></td>
                </tr>
                <tr>
                  <td class="text-left">2.1-ធនាគារវឌ្ឍនះ-គណនី RITHY GRANITE</td>
                  <td class="text-center">$ <?= number_format(i_i_bank_old_total($v_date_start),2) ?></td>
                  <td class="text-center">$ <?= number_format(i_i_bank_cash_in_total($v_date_start,$v_date_end),2) ?></td>
                  <td class="text-center">$ <?= number_format(i_i_bank_cash_out_total($v_date_start,$v_date_end),2) ?></td>
                  <td class="text-center">$ <?= number_format(
                    i_i_bank_old_total($v_date_start)
                    +i_i_bank_cash_in_total($v_date_start,$v_date_end)
                    -i_i_bank_cash_out_total($v_date_start,$v_date_end),2) ?></td>
                </tr>
                <tr>
                  <td class="text-left">2.2-ធនាគារAgribank-គណនី Mr.Leng Rithy</td>
                  <td class="text-center">$ <?= number_format(i_ii_bank_old_total($v_date_start),2) ?></td>
                  <td class="text-center">$ <?= number_format(i_ii_bank_cash_in_total($v_date_start,$v_date_end),2) ?></td>
                  <td class="text-center">$ <?= number_format(i_ii_bank_cash_out_total($v_date_start,$v_date_end),2) ?></td>
                  <td class="text-center">$ <?= number_format(
                    i_ii_bank_old_total($v_date_start)
                    +i_ii_bank_cash_in_total($v_date_start,$v_date_end)
                    -i_ii_bank_cash_out_total($v_date_start,$v_date_end),2) ?></td>
                </tr>
                <tr>
                  <td class="text-left">សរុបសាច់ប្រាក់ក្រុមហ៊ុនឬទ្ធីក្រានីត</td>
                  <td class="text-center">$ <?= number_format(
                    i_cash_on_hand_old_total($v_date_start)+i_cash_in_bank_old_total($v_date_start),2) ?></td>
                  <td class="text-center">$ <?= number_format(i_cash_on_hand_cash_in_total($v_date_start,$v_date_end)+i_cash_in_bank_cash_in_total($v_date_start,$v_date_end),2) ?></td>
                  <td class="text-center">$ <?= number_format(i_cash_on_hand_cash_out_total($v_date_start,$v_date_end)+i_cash_in_bank_cash_out_total($v_date_start,$v_date_end),2) ?></td>
                  <td class="text-center">$ <?= number_format(
                    (i_cash_on_hand_old_total($v_date_start)+i_cash_in_bank_old_total($v_date_start))
                    +(i_cash_on_hand_cash_in_total($v_date_start,$v_date_end)+i_cash_in_bank_cash_in_total($v_date_start,$v_date_end)
                    -(i_cash_on_hand_cash_out_total($v_date_start,$v_date_end)+i_cash_in_bank_cash_out_total($v_date_start,$v_date_end))),2) ?></td>
                </tr>
            </tbody>
        </table>
        
        <br>
        <br>
        <!-- Fourth Table -->
        <table class="table table-bordered" id="my_fourth_table">
            <tbody>
                <tr>
                    <th class="text-center" style="width: 20px;">ល.រ</th>
                    <th colspan="2" class="text-center" style="width: 200px!important;">យោង</th>
                    <th class="text-center" style="width: 350px;">បរិយាយ</th>
                    <th class="text-center" style="width: 150px;">ទឹកប្រាក់ចូល</th>
                    <th class="text-center" style="width: 150px;">ទឹកប្រាក់ចេញ</th>
                    <th class="text-center" style="width: 150px;">សមតុល្យ</th>
                </tr>
                <tr>
                    <th colspan="7" class="text-left my_sub_th">I-ប្រតិបត្តិការណ៍សាច់ប្រាក់ក្នុងដៃ</th>
                </tr>
                <tr>
                    <th colspan="6" class="text-right">សមតុល្យដើមគ្រា៖ </th>
                    <?php 
                        $old_cash=i_cash_on_hand_old_total($v_date_start);
                     ?>
                    <th class="text-center"><?= number_format($old_cash,2) ?> $</th>
                </tr>
                <?php 
                    iii_2_1_detail($v_date_start,$v_date_end,$old_cash,1,8);
                 ?>
                <tr>
                    <th colspan="7" class="text-left">*** ប្រតិបត្តិការណ៍ចុះបញ្ជី </th>
                </tr>
                <?php 
                    iii_2_1_detail($v_date_start,$v_date_end,$old_cash,1,6);
                 ?>
                <tr>
                    <th colspan="7" class="text-left my_sub_th">II-ប្រតិបត្តិការណ៍សាច់ប្រាក់ក្នុងធនាគារ</th>
                </tr>
                <tr>
                    <th colspan="6" class="text-right">សមតុល្យសរុប៖  </th>
                    <th class="text-center"><?= number_format(i_cash_in_bank_old_total($v_date_start),2) ?> $</th>
                </tr>
                <tr>
                    <th colspan="5" class="text-left my_sub_th">2.1-ធនាគារវឌ្ឍនះ-គណនី RITHY GRANITE</th>
                    <th class="text-center">សមតុល្យដើមគ្រា៖ </th>
                    <th class="text-center"><?= number_format(i_i_bank_old_total($v_date_start),2) ?> $</th>
                </tr>
                <?php 
                    $v_bal=i_i_bank_old_total($v_date_start);


                    iii_2_1_detail($v_date_start,$v_date_end,$v_bal,6,1);//6 for chart account// 1= $type_cash_bank
                 ?>

                <tr>
                    <th colspan="5" class="text-left my_sub_th">2.2-ធនាគារAgribank-គណនី Mr.Leng Rithy</th>
                    <th class="text-center">សមតុល្យដើមគ្រា៖ </th>
                    <th class="text-center"><?= number_format(i_ii_bank_old_total($v_date_start),2) ?> $</th>
                </tr>
                <?php 
                    $v_bal=i_ii_bank_old_total($v_date_start);
                    iii_2_1_detail($v_date_start,$v_date_end,$v_bal,7,2);
                 ?>

                <tr>
                    <th colspan="5" class="text-left my_sub_th">2.3-ធនាគារNCB-គណនី Boss VN</th>
                    <th class="text-center">សមតុល្យដើមគ្រា៖ </th>
                    <th class="text-center"><?= number_format(i_ii_bank_old_total($v_date_start),2) ?> $</th>
                </tr>
                <?php 
                    $v_bal=i_ii_bank_old_total($v_date_start);
                    
                    iii_2_1_detail($v_date_start,$v_date_end,$v_bal,307,6);
                 ?>
            </tbody>
        </table>
        
        <!-- Five Table -->
        <form action="controller.php" method="POST" role="form" id="form_padding">
        <input type="hidden" name="txt_main_date" value="<?= $v_date_start ?>">
        <div class="row">
            <div class="col-xs-5">
                <table class="table table-bordered tablefive" id="form_padding_cash">
                    <thead>
                        <tr>
                            <th class="text-center" colspan="3">Padding Cash</th>
                        </tr>
                        <tr>
                            <td class="text-center" style="width: 30%;">Date</td>
                            <td class="text-center" style="width: 50%;">Descrption</td>
                            <td class="text-center" width="100">Amount</td>
                        </tr>
                    </thead>
                    <tbody>
                            <?php 
                                $v_total=0;
                                $v_sql1="SELECT * FROM  tbl_acc_rep_cash_rec_daily_padding WHERE cash_rec_daily_date='$v_date_start'";
                                $result=$connect->query($v_sql1);
                                while ($row_old_one=mysqli_fetch_object($result)) {
                                    $v_total+=$row_old_one->amo;
                            ?>
                            <tr>
                                <td class="text-center">
                                    <?= $row_old_one->date_record ?>
                                </td>
                                <td class="text-center">
                                    <?= $row_old_one->description ?>
                                </td>
                                <td class="text-center">
                                    <?= $row_old_one->amo ?>
                                </td>
                            </tr>
                            <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-center" colspan="2">Total Cash available :</td>
                            <td class="text-center">$ <?= number_format($v_total,2) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="col-xs-7 col-lg-7">
                <table class="table table-bordered tablefive tableCashCount">
                    <thead>
                        <tr>
                            <th class="text-center" colspan="6">Cash Count Sheet (Cash with Cashier)</th>
                        </tr>
                        <tr>
                            <td class="text-center">Type of Currency</td>
                            <td class="text-center">Unit</td>
                            <td class="text-center">Amount</td>
                            <td class="text-center">Type of Currency</td>
                            <td class="text-center">Unit</td>
                            <td class="text-center">Amount</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $v_sql1="SELECT * FROM  tbl_acc_rep_cash_rec_daily_cash_count WHERE cash_rec_daily_date='$v_date_start'";
                            $result=$connect->query($v_sql1);
                            $row_old_two=mysqli_fetch_object($result);
                        ?>
                        <tr>
                            <td class="text-center">
                                <span class="pull-left">$</span>
                                <span class="pull-right"><?= number_format(100,2) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <?= @$row_old_two->dollar_100 ?>
                            </td>
                            <td class="text-center">
                                $ <?= number_format(@$row_old_two->dollar_100*100,2) ?>
                            </td>
                            <td class="text-center">
                                <span class="pull-left">R</span>
                                <span class="pull-right"><?= number_format(1000*100,0) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <?= @$row_old_two->reils_1000 ?>
                            </td>
                            <td class="text-center">
                                R <?= number_format(@$row_old_two->reils_1000*100000,0) ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <span class="pull-left">$</span>
                                <span class="pull-right"><?= number_format(50,2) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <?= @$row_old_two->dollar_50 ?>
                            </td>
                            <td class="text-center">
                                $ <?= number_format(@$row_old_two->dollar_50*50,2) ?>
                            </td>
                            <td class="text-center">
                                <span class="pull-left">R</span>
                                <span class="pull-right"><?= number_format(500*100,0) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <?= @$row_old_two->reils_500 ?>
                            </td>
                            <td class="text-center">
                                R <?= number_format(@$row_old_two->reils_500*50000,0) ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <span class="pull-left">$</span>
                                <span class="pull-right"><?= number_format(20,2) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <?= @$row_old_two->dollar_20 ?>
                            </td>
                            <td class="text-center">
                                $ <?= number_format(@$row_old_two->dollar_20*20,2) ?>
                            </td>
                            <td class="text-center">
                                <span class="pull-left">R</span>
                                <span class="pull-right"><?= number_format(200*100,0) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <?= @$row_old_two->reils_200 ?>
                            </td>
                            <td class="text-center">
                                R <?= number_format(@$row_old_two->reils_200*20000,0) ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <span class="pull-left">$</span>
                                <span class="pull-right"><?= number_format(10,2) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <?= @$row_old_two->dollar_10 ?>
                            </td>
                            <td class="text-center">
                                $ <?= number_format(@$row_old_two->dollar_10*10,2) ?>
                            </td>
                            <td class="text-center">
                                <span class="pull-left">R</span>
                                <span class="pull-right"><?= number_format(100*100,0) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <?= @$row_old_two->reils_100 ?>
                            </td>
                            <td class="text-center">
                                R <?= number_format(@$row_old_two->reils_100*10000,0) ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <span class="pull-left">$</span>
                                <span class="pull-right"><?= number_format(5,2) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <?= @$row_old_two->dollar_5 ?>
                            </td>
                            <td class="text-center">
                                $ <?= number_format(@$row_old_two->dollar_5*5,2) ?>
                            </td>
                            <td class="text-center">
                                <span class="pull-left">R</span>
                                <span class="pull-right"><?= number_format(50*100,0) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <?= @$row_old_two->reils_50 ?>
                            </td>
                            <td class="text-center">
                                R <?= number_format(@$row_old_two->reils_50*5000,0) ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <span class="pull-left">$</span>
                                <span class="pull-right"><?= number_format(2,2) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <?= @$row_old_two->dollar_1 ?>
                            </td>
                            <td class="text-center">
                                $ <?= number_format(@$row_old_two->dollar_1*2,0) ?>
                            </td>
                            <td class="text-center">
                                <span class="pull-left">R</span>
                                <span class="pull-right"><?= number_format(20*100,0) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <?= @$row_old_two->reils_20 ?>
                            </td>
                            <td class="text-center">
                                R <?= number_format(@$row_old_two->reils_20*2000,0) ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <span class="pull-left">$</span>
                                <span class="pull-right"><?= number_format(1,2) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <?= @$row_old_two->dollar_1 ?>
                            </td>
                            <td class="text-center">
                                $ <?= number_format(@$row_old_two->dollar_1,2) ?>
                            </td>
                            <td class="text-center">
                                <span class="pull-left">R</span>
                                <span class="pull-right"><?= number_format(10*100,0) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <?= @$row_old_two->reils_10 ?>
                            </td>
                            <td class="text-center">
                                R <?= number_format(@$row_old_two->reils_10*1000,0) ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td class="text-center">
                                <span class="pull-left">R</span>
                                <span class="pull-right"><?= number_format(5*100,0) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <?= @$row_old_two->reils_5 ?>
                            </td>
                            <td class="text-center">
                                R <?= number_format(@$row_old_two->reils_5*500,0) ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td class="text-center">
                                <span class="pull-left">R</span>
                                <span class="pull-right"><?= number_format(1*100,0) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <?= @$row_old_two->reils_1 ?>
                            </td>
                            <td class="text-center">
                                R <?= number_format(@$row_old_two->reils_1*100,0) ?>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-right" colspan="2">Total Cash available :</td>
                            <td class="text-center"><?= @$row_old_two->total_dollar ?></td>
                            <td class="text-right" colspan="2">Total (Riel)</td>
                            <td class="text-center"><?= number_format(@$row_old_two->total_reils*100,0) ?></td>
                        </tr>
                        <tr>
                            <td class="text-right" colspan="2">Grand Total ( USD) :</td>
                            <td class="text-center"><?= number_format(@$row_old_two->total_dollar+@$row_old_two->total_reils/4000,2) ?></td>
                            <?php 
                                if(@$row_old_two->final_grand_total!=null){
                                    $result_final_grand_total=@$row_old_two->final_grand_total;
                                }
                                else{
                                    $result_final_grand_total=$v_old_cash_on_hand+
                                                            @$row_old_two->total_dollar+@$row_old_two->total_reils/4000-
                                                            $v_total;
                                }
                             ?>
                            <td class="bg-warning"><?= number_format($result_final_grand_total,2) ?></td>
                        </tr>
                    </tfoot>
                        <input type="hidden" name="txt_total_dollar" value="<?= @$row_old_two->total_dollar ?>">
                        <input type="hidden" name="txt_total_reils" value="<?= @$row_old_two->total_reils ?>">
                        <input type="hidden" name="txt_final_grand_total" value="<?= @$row_old_two->final_grand_total ?>">
                </form>
                </table>
            </div>
        </div>
        <br>
        <br>
        <!-- Sign  -->
        <div class="row sign">
            <div class="col-xs-4 text-center">
                <p  style="font-family: 'Khmer OS Muol Light';">រៀបចំដោយ</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black;">
                <p style="font-family: 'Khmer OS Muol Light';">បេឡាករ</p>
            </div>

            <div class="col-xs-4 text-center">
                <p  style="font-family: 'Khmer OS Muol Light';">ត្រួតពិនិត្យដោយ</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black;">
                <p  style="font-family: 'Khmer OS Muol Light';">ប្រធានគណនេយ្យ</p>
            </div>

            <div class="col-xs-4 text-center">
                <p  style="font-family: 'Khmer OS Muol Light';">ត្រួតពិនិត្យនិងឯកភាពដោយ</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black;">
                <p  style="font-family: 'Khmer OS Muol Light';">នាយិកាប្រតិបត្តិ</p>
            </div>
        </div>
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


