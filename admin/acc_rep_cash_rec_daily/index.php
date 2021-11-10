<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
    include_once 'my_function.php';
?>
<?php 

if(@$_GET['status']==true){
   echo '<script>myAlertSuccess("Save Completed")</script>';
}
if(isset($_POST['btn_search'])||isset($_POST['txt_date_start'])||isset($_POST['txt_date_end'])){
    $v_date_start=$_POST['txt_date_start'];
    $v_date_end=$_POST['txt_date_end'];

    $sql_old=$connect->query("SELECT (SUM(accdr_cash_in)-SUM(accdr_cash_out)) AS old_cash
        FROM tbl_acc_cash_record WHERE DATE_FORMAT(accdr_date,'%Y-%m-%d')<'$v_date_start'");
    $row_old=mysqli_fetch_object($sql_old);
}   
// else if(isset($_POST['btn_print'])){
//     $v_date_startd=$_POST['txt_date_start'];
//     header('location: print.php?date_start='.$v_date_start);
// }
else{
    $v_date_start=date('Y-m-d');
    $v_date_end=date('Y-m-d');
}
 ?>
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
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-file-o"></i> Report Cash Daily Summary</h2>
        </div>
    </div>
    <br>
    <br>
    <form action="#" method="post">
            <div class="col-sm-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input onchange="this.form.submit()" autocomplete="off" name="txt_date_start" value="<?= ($v_date_start)?($v_date_start):(@$_POST['txt_date_start']) ?>" type="text" class="form-control" placeholder="Date From ....">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input onchange="this.form.submit()" autocomplete="off" name="txt_date_end" value="<?= ($v_date_end)?($v_date_end):(@$_POST['txt_date_end']) ?>" type="text" class="form-control" placeholder="Date From ....">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="caption font-dark" style="display: inline-block;">
                    <button type="submit" name="btn_search" id="sample_editable_1_new" class="btn blue btn-sm"> Search
                        <i class="fa fa-search"></i>
                    </button>
                    <a target="_blank" href="print.php?date_start=<?= $v_date_start ?>&date_end=<?= $v_date_end ?>" class="btn btn-warning btn-sm">
                        Print
                        <i class="fa fa-print"></i>
                    </a>
                </div>
            </div>
            <br>
            <br>
        </form>
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
                    <th class="text-center" style="width: 250px;">បរិយាយ</th>
                    <th class="text-center" style="width: 250px;">សំគាលប្រតិបត្តការណ៍</th>
                    <th class="text-center" style="width: 150px;">ទឹកប្រាក់ចូល</th>
                    <th class="text-center" style="width: 150px;">ទឹកប្រាក់ចេញ</th>
                    <th class="text-center" style="width: 150px;">សមតុល្យ</th>
                </tr>
                <tr>
                    <th colspan="8" class="text-left my_sub_th">I-ប្រតិបត្តិការណ៍សាច់ប្រាក់ក្នុងដៃ</th>
                </tr>
                <tr>
                    <th colspan="7" class="text-right">សមតុល្យដើមគ្រា៖ </th>
                    <?php 
                        $old_cash=i_cash_on_hand_old_total($v_date_start);
                     ?>
                    <th class="text-center"><?= number_format($old_cash,2) ?> $</th>
                </tr>
                <?php 
                    iii_2_1_detail($v_date_start,$v_date_end,$old_cash,1,8);
                 ?>
                <tr>
                    <th colspan="8" class="text-left">*** ប្រតិបត្តិការណ៍ចុះបញ្ជី </th>
                </tr>
                <?php 
                    iii_2_1_detail($v_date_start,$v_date_end,$old_cash,1,6);
                 ?>
                <tr>
                    <th colspan="8" class="text-left my_sub_th">II-ប្រតិបត្តិការណ៍សាច់ប្រាក់ក្នុងធនាគារ</th>
                </tr>
                <tr>
                    <th colspan="7" class="text-right">សមតុល្យសរុប៖  </th>
                    <th class="text-center"><?= number_format(i_cash_in_bank_old_total($v_date_start),2) ?> $</th>
                </tr>
                <tr>
                    <th colspan="6" class="text-left my_sub_th">2.1-ធនាគារវឌ្ឍនះ-គណនី RITHY GRANITE</th>
                    <th class="text-center">សមតុល្យដើមគ្រា៖ </th>
                    <th class="text-center"><?= number_format(i_i_bank_old_total($v_date_start),2) ?> $</th>
                </tr>
                <?php 
                    $v_bal=i_i_bank_old_total($v_date_start);


                    iii_2_1_detail($v_date_start,$v_date_end,$v_bal,6,1);//6 for chart account// 1= $type_cash_bank
                 ?>

                <tr>
                    <th colspan="6" class="text-left my_sub_th">2.2-ធនាគារAgribank-គណនី Mr.Leng Rithy</th>
                    <th class="text-center">សមតុល្យដើមគ្រា៖ </th>
                    <th class="text-center"><?= number_format(i_ii_bank_old_total($v_date_start),2) ?> $</th>
                </tr>
                <?php 
                    $v_bal=i_ii_bank_old_total($v_date_start);
                    iii_2_1_detail($v_date_start,$v_date_end,$v_bal,7,2);
                 ?>

                <tr>
                    <th colspan="6" class="text-left my_sub_th">2.3-ធនាគារNCB-គណនី Boss VN</th>
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
                                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                        <input autocomplete="off" name="txt_date[]" value="<?= $row_old_one->date_record ?>" type="text" class="form-control" placeholder="Date From ....">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <textarea name="txt_description[]" id="input" class="form-control" rows="3"><?= $row_old_one->description ?></textarea>
                                </td>
                                <td class="text-center">
                                    <div class="input-group">
                                        <input type="text"  value="<?= $row_old_one->amo ?>" name="txt_amo[]" onkeypress="return isNumber(event)" id="input" class="form-control">
                                        <div class="input-group-addon" name="btn_padding_delete_row">
                                            <span class="fa fa-trash fa-2x text-danger"></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td class="text-center">
                                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                        <input autocomplete="off" name="txt_date[]" value="<?= date('Y-m-d') ?>" type="text" class="form-control" placeholder="Date From ....">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <textarea name="txt_description[]" id="input" class="form-control" rows="3"></textarea>
                                </td>
                                <td class="text-center" style="width: 30%;">
                                    <div class="input-group">
                                        <input type="text" value="0" name="txt_amo[]" onkeypress="return isNumber(event)" id="input" class="form-control">
                                        <div class="input-group-addon" name="btn_padding_delete_row">
                                            <span class="fa fa-trash fa-2x text-danger"></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-center" colspan="2">Total Cash available :</td>
                            <td class="text-center">$ <?= number_format($v_total,2) ?></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="text-center">
                    <!-- <button form="form_padding" type="submit" name="btn_Save" class="btn btn-info">Save</button> -->
                    <button form="form_padding" onclick="this.form.submit()" type="submit" name="btn_Save" class="btn btn-info">Save</button>
                    <div name="btn_add" class="btn btn-success">Add</div>
                </div>
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
                                <input id="100" value="<?= @$row_old_two->dollar_100 ?>" type="text" name="txt_unit_dollar_100" id="input" class="form-control" onkeypress="return isNumber(event)">
                            </td>
                            <td class="text-center">
                                <input type="text" value="<?= @$row_old_two->dollar_100*100 ?>" name="txt_amo_dollar" id="input" class="form-control" readonly="">
                            </td>
                            <td class="text-center">
                                <span class="pull-left">R</span>
                                <span class="pull-right"><?= number_format(1000*100,0) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <input id="1000" value="<?= @$row_old_two->reils_1000 ?>" type="text" name="txt_unit_reils_1000" id="input" class="form-control" onkeypress="return isNumber(event)">
                            </td>
                            <td class="text-center">
                                <input type="text" value="<?= @$row_old_two->reils_1000*100000 ?>" name="txt_amo_reils" id="input" class="form-control" readonly="">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <span class="pull-left">$</span>
                                <span class="pull-right"><?= number_format(50,2) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <input  id="50" value="<?= @$row_old_two->dollar_50 ?>" type="text" name="txt_unit_dollar_50" id="input" class="form-control" onkeypress="return isNumber(event)">
                            </td>
                            <td class="text-center">
                                <input type="text" value="<?= @$row_old_two->dollar_50*50 ?>" name="txt_amo_dollar" id="input" class="form-control" readonly="">
                            </td>
                            <td class="text-center">
                                <span class="pull-left">R</span>
                                <span class="pull-right"><?= number_format(500*100,0) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <input id="500" value="<?= @$row_old_two->reils_500 ?>" type="text" name="txt_unit_reils_500" id="input" class="form-control" onkeypress="return isNumber(event)">
                            </td>
                            <td class="text-center">
                                <input type="text" value="<?= @$row_old_two->reils_500*50000 ?>" name="txt_amo_reils" id="input" class="form-control" readonly="">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <span class="pull-left">$</span>
                                <span class="pull-right"><?= number_format(20,2) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <input id="20" value="<?= @$row_old_two->dollar_20 ?>" type="text" name="txt_unit_dollar_20" id="input" class="form-control" onkeypress="return isNumber(event)">
                            </td>
                            <td class="text-center">
                                <input type="text" value="<?= @$row_old_two->dollar_20*20 ?>" name="txt_amo_dollar" id="input" class="form-control" readonly="">
                            </td>
                            <td class="text-center">
                                <span class="pull-left">R</span>
                                <span class="pull-right"><?= number_format(200*100,0) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <input id="200" value="<?= @$row_old_two->reils_200 ?>" type="text" name="txt_unit_reils_200" id="input" class="form-control" onkeypress="return isNumber(event)">
                            </td>
                            <td class="text-center">
                                <input type="text" value="<?= @$row_old_two->reils_200*20000 ?>" name="txt_amo_reils" id="input" class="form-control" readonly="">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <span class="pull-left">$</span>
                                <span class="pull-right"><?= number_format(10,2) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <input id="10" value="<?= @$row_old_two->dollar_10 ?>" type="text" name="txt_unit_dollar_10" id="input" class="form-control" onkeypress="return isNumber(event)">
                            </td>
                            <td class="text-center">
                                <input type="text" value="<?= @$row_old_two->dollar_10*10 ?>" name="txt_amo_dollar" id="input" class="form-control" readonly="">
                            </td>
                            <td class="text-center">
                                <span class="pull-left">R</span>
                                <span class="pull-right"><?= number_format(100*100,0) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <input id="100" value="<?= @$row_old_two->reils_100 ?>" type="text" name="txt_unit_reils_100" id="input" class="form-control" onkeypress="return isNumber(event)">
                            </td>
                            <td class="text-center">
                                <input type="text" value="<?= @$row_old_two->reils_100*10000 ?>" name="txt_amo_reils" id="input" class="form-control" readonly="">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <span class="pull-left">$</span>
                                <span class="pull-right"><?= number_format(5,2) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <input id="5" value="<?= @$row_old_two->dollar_5 ?>" type="text" name="txt_unit_dollar_5" id="input" class="form-control" onkeypress="return isNumber(event)">
                            </td>
                            <td class="text-center">
                                <input type="text" value="<?= @$row_old_two->dollar_5*5 ?>" name="txt_amo_dollar" id="input" class="form-control" readonly="">
                            </td>
                            <td class="text-center">
                                <span class="pull-left">R</span>
                                <span class="pull-right"><?= number_format(50*100,0) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <input id="50" value="<?= @$row_old_two->reils_50 ?>" type="text" name="txt_unit_reils_50" id="input" class="form-control" onkeypress="return isNumber(event)">
                            </td>
                            <td class="text-center">
                                <input type="text" value="<?= @$row_old_two->reils_50*5000 ?>" name="txt_amo_reils" id="input" class="form-control" readonly="">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <span class="pull-left">$</span>
                                <span class="pull-right"><?= number_format(2,2) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <input id="2" type="text" value="<?= @$row_old_two->dollar_1 ?>" name="txt_unit_dollar_2" id="input" class="form-control" onkeypress="return isNumber(event)">
                            </td>
                            <td class="text-center">
                                <input type="text" value="<?= @$row_old_two->dollar_1*2 ?>" name="txt_amo_dollar" id="input" class="form-control" readonly="">
                            </td>
                            <td class="text-center">
                                <span class="pull-left">R</span>
                                <span class="pull-right"><?= number_format(20*100,0) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <input id="20" value="<?= @$row_old_two->reils_20 ?>" type="text" name="txt_unit_reils_20" id="input" class="form-control" onkeypress="return isNumber(event)">
                            </td>
                            <td class="text-center">
                                <input type="text" value="<?= @$row_old_two->reils_20*2000 ?>" name="txt_amo_reils" id="input" class="form-control" readonly="">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <span class="pull-left">$</span>
                                <span class="pull-right"><?= number_format(1,2) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <input id="1" value="<?= @$row_old_two->dollar_1 ?>" type="text" name="txt_unit_dollar_1" id="input" class="form-control" onkeypress="return isNumber(event)">
                            </td>
                            <td class="text-center">
                                <input type="text" value="<?= @$row_old_two->dollar_1 ?>" name="txt_amo_dollar" id="input" class="form-control" readonly="">
                            </td>
                            <td class="text-center">
                                <span class="pull-left">R</span>
                                <span class="pull-right"><?= number_format(10*100,0) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <input id="10" value="<?= @$row_old_two->reils_10 ?>" type="text" name="txt_unit_reils_10" id="input" class="form-control" onkeypress="return isNumber(event)">
                            </td>
                            <td class="text-center">
                                <input type="text" value="<?= @$row_old_two->reils_10*1000 ?>" name="txt_amo_reils" id="input" class="form-control" readonly="">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td class="text-center">
                                <span class="pull-left">R</span>
                                <span class="pull-right"><?= number_format(5*100,0) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <input id="5" value="<?= @$row_old_two->reils_5 ?>" type="text" name="txt_unit_reils_5" id="input" class="form-control" onkeypress="return isNumber(event)">
                            </td>
                            <td class="text-center">
                                <input type="text" value="<?= @$row_old_two->reils_5*500 ?>" name="txt_amo_reils" id="input" class="form-control" readonly="">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td class="text-center">
                                <span class="pull-left">R</span>
                                <span class="pull-right"><?= number_format(1*100,0) ?></span>
                            </td>
                            <td class="text-center" style="width: 80px;">
                                <input id="1" value="<?= @$row_old_two->reils_1 ?>" type="text" name="txt_unit_reils_1" id="input" class="form-control" onkeypress="return isNumber(event)">
                            </td>
                            <td class="text-center">
                                <input type="text" value="<?= @$row_old_two->reils_1*100 ?>" name="txt_amo_reils" id="input" class="form-control" readonly="">
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
</div>
<?php include_once '../layout/footer.php' ?>
<script type="text/javascript">
    $('div[name=btn_add]').click(function(event) {
        var objRow=$('table[id=form_padding_cash]').find('tbody >tr').html();
        $('table[id=form_padding_cash]').find('tbody').append(`<tr>${ objRow }</tr>`);
    });
    $('table[id=form_padding_cash]').on('click', 'div[name=btn_padding_delete_row]', function(event) {
        var row_count=$(this).parents('table[id=form_padding_cash] ').find('tbody >tr').length;
        if(row_count!=1){
            $(this).parents('tbody >tr').remove();
            calTotalAmountPaddingCash();
        }
    });
    $('table[id=form_padding_cash]').on('keyup', 'input[name^=txt_amo]', function(event) {
        calTotalAmountPaddingCash();
    });
    $('input[name^=txt_unit_reils]').keyup(function(event) {
        var v_type=$(this).attr('id');
        var v_unit=$(this).val();
        var result=numeral(v_type*v_unit*100).format('0,0');
        $(this).parents('tr').find('td:last-child >input').val('R '+result);
        calTotalCashAvalibleReil();
        calGendTotal();
    });
    $('input[name^=txt_unit_dollar]').keyup(function(event) {
        var v_type=$(this).attr('id');
        var v_unit=$(this).val();
        var result=numeral(v_type*v_unit).format('$ 0,0.00');
        $(this).parents('tr').find('td:nth-child(3) >input').val(result);
        calTotalCashAvalibleDollar();
        calGendTotal();
    });
    function calTotalCashAvalibleDollar(){
        v_total_amo=0;
        $('table.tableCashCount').find('tbody >tr').each(function(index, el) {
            var v_type=$(this).find('td:nth-child(2) >input').attr('id');//.attr('id');
            var v_unit=$(this).find('td:nth-child(2) input').val();
            var result=v_type*v_unit;
            if(result){
                v_total_amo+=result;
            }
        });
        console.log($('table.tableCashCount').find('tfoot tr:first-child >td:nth-child(2)').html(numeral(v_total_amo).format('0,00.00 $')));
        $('input[name=txt_total_dollar]').val(v_total_amo);
        return v_total_amo;
    }
    function calTotalCashAvalibleReil(){
        v_total_amo=0;
        $('table.tableCashCount').find('tbody >tr').each(function(index, el) {
            var v_type=$(this).find('td:nth-last-child(2) >input').attr('id');//.attr('id');
            var v_unit=$(this).find('td:nth-last-child(2) input').val();
            var result=v_type*v_unit;
            if(result){
                v_total_amo+=result;
            }
        });
        $('table.tableCashCount').find('tfoot tr:first-child >td:last-child').html('R '+numeral(v_total_amo*100).format('0,00'));
        $('input[name=txt_total_reils]').val(v_total_amo);
        return v_total_amo;
    }
    g_calTotalAmountPaddingCash=0;
    function calTotalAmountPaddingCash(){
        v_total_amo=0;
        $('table[id=form_padding_cash]').find('tbody>tr').each(function(index, el) {
            v_total_amo+=parseFloat($(this).find('td:nth-child(3) input').val());
        });
        $('table[id=form_padding_cash]').find('tfoot tr >td:last-child').html(numeral(v_total_amo).format('0,0.00 $'));
        g_calTotalAmountPaddingCash=v_total_amo;
        calGrandTotalAll()
        return v_total_amo;
    }
    v_result_calGendTotal=0;
    function calGendTotal(){
        v_total_amo_dollar=calTotalCashAvalibleDollar();
        v_total_amo_reils=calTotalCashAvalibleReil();
        v_result=v_total_amo_dollar+(v_total_amo_reils*100/4000);
        v_result_calGendTotal=v_result;
        $('table.tableCashCount').find('tfoot >tr:last-child >td:nth-child(2)').html(numeral(v_result).format('0,0.00 $'));
        calGrandTotalAll();
    }
    function calGrandTotalAll(){
        v_total_register=<?= $v_old_cash_on_hand ?>;
        v_total_register=(v_total_register)?(v_total_register):0;
        v_TotalAmountPaddingCash=g_calTotalAmountPaddingCash;
        v_result=v_total_register+v_result_calGendTotal-v_TotalAmountPaddingCash;
        $('table.tableCashCount').find('tfoot >tr:last-child >td:nth-child(3)').html(numeral(v_result).format('0,0.00 $'));
        $('input[name=txt_final_grand_total]').val(v_result);
    }
</script>
