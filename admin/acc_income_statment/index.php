<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "View Report Income Statement";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
    include_once 'my_function.php';
    include_once '../acc_my_operation/my_operation.php';
?>
<style type="text/css">
    /*.myTable ,td{
      border: 1px solid black;
    }*/
</style>
<div class="portlet light bordered">
    <div class="row">
        <!-- start search form -->
        <form action="" method="post">
            <div class="col-sm-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input autocomplete="off" name="txt_date_start" onchange="myChangDateStart(this)" value="<?= @$_POST['txt_date_start'] ?>" type="text" class="form-control" placeholder="Date From ....">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input autocomplete="off" name="txt_date_end" onchange="myChangDateEnd(this)" value="<?= @$_POST['txt_date_end'] ?>" type="text" class="form-control" placeholder="Date To">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-xs-5">
                <button type="submit" name="btn_search" class="btn blue"><i class="fa fa-search"></i> Search</button>
                <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn red"><i class="fa fa-undo"></i> Clear</a>
                <a href="print.php?date_start=<?= @$_POST['txt_date_start'] ?>&date_end=<?= @$_POST['txt_date_end'] ?>" target="_blank" class="btn btn-warning"><i class="fa fa-print"></i> Print</a>
            </div>
        </form>
        <!-- end search form -->
    </div>
    <div class="row">
        <div class="col-xs-12"> 
            <?php 
                $sql=$connect->query("SELECT * FROM tbl_com_company_info");
                $row_company=mysqli_fetch_array($sql);
             ?>
            <div class="text-center">
                <h1><b><?= $row_company['comci_name_en'] ?></b></h1>
                <h3><b>Income Statement</b></h3>
                <b><h4 style="font-family: 'Khmer OS Moul';">FROM <?= @$_POST['txt_date_start'] ?> TO <?= @$_POST['txt_date_end'] ?></h4></b>
                <p style="font-size: 20px!important;" class="text-uppercase">Currency : USD</p>
            </div>
        </div>
    </div>
    <br>
    <div class="container" style="padding: 0 10px;">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pull-right text-center" style="width: 170px; border-bottom: 1px solid black; margin: 0 10px;">
            <h5>YTD<br>Actual</h5>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 pull-right text-center" style="width: 170px; border-bottom: 1px solid black; margin: 0 10px;">
            <h5>YTD<br>Previous Month</h5>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 pull-right text-center" style="width: 170px; border-bottom: 1px solid black; margin: 0 10px;">
            <h5>Actual<br>Month</h5>
        </div>
       <!--  <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 pull-right text-center" style="width: 170px; border-bottom: 1px solid black; margin: 0 10px;">
            <h5>Actual<br>Month</h5>
        </div> -->  
    </div>
    <div class="portlet-body text-center">
        <div class="list-todo-item dark container">
            <?php 
                $i=0;
                // $sql=$connect->query("SELECT * FROM tbl_acc_account_type_report WHERE tr_id='5' OR tr_id='4' OR tr_id='6'");

                $v_main_id=5;
                $v_main_name='Income';
                echo '<a class="list-toggle-container" data-toggle="collapse" data-parent="#accordion1" onclick=" " href="#task-0" aria-expanded="false">
                        <div class="list-toggle done uppercase bg-primary" style="background-color: #FFF2CC; padding: 10px; color: black;">
                            <div class="list-toggle-title bold text-left">
                            '.$v_main_name.'
                            </div>
                        </div>
                    </a>';
                echo '
                <div class="task-list panel-collapse collapse in" id="task-0">
                    <ul>
                        <li class="task-list-item" style="list-style: none;">
                            <div class="task-content">
                                <table class="table table-hover table-striped table-bordered myTable">
                                    <tbody>';
                                            $v_bal_current_month_tmp1=0;
                                            $v_bal_old_month_tmp1=0;
                                            $v_bal_current_year_tmp1=0;
                                            if(isset($_POST['btn_search'])){
                                                $v_date_start=@$_POST['txt_date_start'];
                                                $v_date_end=@$_POST['txt_date_end'];
                                                if($v_date_start>$v_date_end){
                                                    echo '<script>myAlertInfo("Please Choose Date From Before Date End")</script>';
                                                    header( "refresh:3;url=index.php" );
                                                }
                                                // $sql2=my_detail_date($v_main_id,$v_date_start,$v_date_end);
                                            }
                                            else{
                                                $v_date_start=@date('Y-m-d');
                                                $v_date_end=@date('Y-m-d');
                                            }
                                            $sql2=$connect->query(GetAccountName($v_main_id));
                                            while ($row2=mysqli_fetch_object($sql2)) {
                                                echo '<tr>';       
                                                    echo '<td class="text-left">'.$row2->accca_number.'-'.$row2->accca_account_name.'</td>';  
                                                        $current_month_bal=bal_current_month($v_date_start,$v_date_end,$row2->accca_id)+bal_pre_month($v_date_start,$v_date_end,$row2->accca_id);
                                                    echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum($current_month_bal).'</span></td>';   
                                                        $old_month_bal=bal_pre_month($v_date_start,$v_date_end,$row2->accca_id);
                                                    echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum($old_month_bal).'</span></td>';  
                                                        $current_year_bal=bal_cur_year($v_date_start,$v_date_end,$row2->accca_id);
                                                    echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum($current_year_bal).'</span></td>';  
                                                echo '</tr>';
                                                $v_bal_current_month_tmp1+=$current_month_bal;
                                                $v_bal_old_month_tmp1+=$old_month_bal;
                                                $v_bal_current_year_tmp1+=$current_year_bal;
                                            }
                                            
                                echo '</tbody>
                                    <tfoot>
                                        <tr style="background-color: #DDEBF7;">
                                           <td colspan="" class="text-left">Total Income:</td>
                                           <td class="text-center" style="width: 150px!important;">'.AccountFormatNum($v_bal_current_month_tmp1).'</td>
                                           <td class="text-center" style="width: 150px!important;">'.AccountFormatNum($v_bal_old_month_tmp1).'</td>
                                           <td class="text-center" style="width: 150px!important;">'.AccountFormatNum($v_bal_current_year_tmp1).'</td>
                                        </tr>
                                    </tfoot>
                               </table>
                            </div>
                        </li>
                    </ul>
                </div>';


                $v_main_id=4;
                $v_main_name='Cost of Goods Sold';
                echo '<a class="list-toggle-container" data-toggle="collapse" data-parent="#accordion1" onclick=" " href="#task-1" aria-expanded="false">
                        <div class="list-toggle done uppercase bg-primary" style="background-color: #FFF2CC; padding: 10px; color: black;">
                            <div class="list-toggle-title bold text-left">
                            '.$v_main_name.'
                            </div>
                        </div>
                    </a>';
                echo '
                <div class="task-list panel-collapse collapse in" id="task-1">
                    <ul>
                        <li class="task-list-item" style="list-style: none;">
                            <div class="task-content">
                                <table class="table table-hover table-striped table-bordered myTable" >
                                    <tbody>';
                                            $v_bal_current_month_tmp2=0;
                                            $v_bal_old_month_tmp2=0;
                                            $v_bal_current_year_tmp2=0;
                                            if(isset($_POST['btn_search'])){
                                                $v_date_start=@$_POST['txt_date_start'];
                                                $v_date_end=@$_POST['txt_date_end'];
                                                if($v_date_start>$v_date_end){
                                                    echo '<script>myAlertInfo("Please Choose Date From Before Date End")</script>';
                                                    header( "refresh:3;url=index.php" );
                                                }
                                                // $sql2=my_detail_date($v_main_id,$v_date_start,$v_date_end);
                                            }
                                            else{
                                                $v_date_start=@date('Y-m-d');
                                                $v_date_end=@date('Y-m-d');
                                            }
                                            $sql2=$connect->query(GetAccountName($v_main_id));
                                            while ($row2=mysqli_fetch_object($sql2)) {
                                                echo '<tr>';       
                                                    echo '<td class="text-left">'.$row2->accca_number.'-'.$row2->accca_account_name.'</td>';  
                                                        $current_month_bal=bal_current_month($v_date_start,$v_date_end,$row2->accca_id)+bal_pre_month($v_date_start,$v_date_end,$row2->accca_id);
                                                    echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum($current_month_bal).'</span></td>';   
                                                        $old_month_bal=bal_pre_month($v_date_start,$v_date_end,$row2->accca_id);
                                                    echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum($old_month_bal).'</span></td>';  
                                                        $current_year_bal=bal_cur_year($v_date_start,$v_date_end,$row2->accca_id);
                                                    echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum($current_year_bal).'</span></td>';  
                                                echo '</tr>';
                                                $v_bal_current_month_tmp2+=$current_month_bal;
                                                $v_bal_old_month_tmp2+=$old_month_bal;
                                                $v_bal_current_year_tmp2+=$current_year_bal;
                                            }
                                           $v_to_income_cur_month=$v_bal_current_month_tmp1-$v_bal_current_month_tmp2;
                                           $v_to_income_old_month=$v_bal_old_month_tmp1-$v_bal_old_month_tmp2;
                                           $v_to_income_old_year=$v_bal_current_year_tmp1-$v_bal_current_year_tmp2;
                                echo '</tbody>
                                    <tfoot>
                                        <tr style="background-color: #DDEBF7;">
                                           <td colspan="" class="text-left">Total COGS:</td>
                                           <td class="text-center" style="width: 150px!important;">'.AccountFormatNum($v_bal_current_month_tmp2).'</td>
                                           <td class="text-center" style="width: 150px!important;">'.AccountFormatNum($v_bal_old_month_tmp2).'</td>
                                           <td class="text-center" style="width: 150px!important;">'.AccountFormatNum($v_bal_current_year_tmp2).'</td>
                                        </tr>
                                        <tr style="background-color: #FCE4D6;">
                                           <td colspan="" class="text-left">Gross Profit:</td>
                                           <td class="text-center" style="width: 150px!important;">'.AccountFormatNum($v_to_income_cur_month).'</td>
                                           <td class="text-center" style="width: 150px!important;">'.AccountFormatNum($v_to_income_old_month).'</td>
                                           <td class="text-center" style="width: 150px!important;">'.AccountFormatNum($v_to_income_old_year).'</td>
                                        </tr>
                                    </tfoot>
                               </table>
                            </div>
                        </li>
                    </ul>
                </div>';

                $v_main_id=6;
                $v_main_name='Expense';
                echo '<a class="list-toggle-container" data-toggle="collapse" data-parent="#accordion1" onclick=" " href="#task-2" aria-expanded="false">
                        <div class="list-toggle done uppercase bg-primary" style="background-color: #FFF2CC; padding: 10px; color: black;">
                            <div class="list-toggle-title bold text-left">
                            '.$v_main_name.'
                            </div>
                        </div>
                    </a>';
                echo '
                <div class="task-list panel-collapse collapse in" id="task-2">
                    <ul>
                        <li class="task-list-item" style="list-style: none;">
                            <div class="task-content">
                                <table class="table table-hover table-striped table-bordered myTable" >
                                    <tbody>';
                                            $v_bal_current_month_tmp3=0;
                                            $v_bal_old_month_tmp3=0;
                                            $v_bal_current_year_tmp3=0;
                                            if(isset($_POST['btn_search'])){
                                                $v_date_start=@$_POST['txt_date_start'];
                                                $v_date_end=@$_POST['txt_date_end'];
                                                if($v_date_start>$v_date_end){
                                                    echo '<script>myAlertInfo("Please Choose Date From Before Date End")</script>';
                                                    header( "refresh:3;url=index.php" );
                                                }
                                                // $sql2=my_detail_date($v_main_id,$v_date_start,$v_date_end);
                                            }
                                            else{
                                                $v_date_start=@date('Y-m-d');
                                                $v_date_end=@date('Y-m-d');
                                            }
                                            $sql2=$connect->query(GetAccountName($v_main_id));
                                            while ($row2=mysqli_fetch_object($sql2)) {
                                                echo '<tr>';       
                                                    echo '<td class="text-left">'.$row2->accca_number.'-'.$row2->accca_account_name.'</td>';  
                                                        $current_month_bal=bal_current_month($v_date_start,$v_date_end,$row2->accca_id)+bal_pre_month($v_date_start,$v_date_end,$row2->accca_id);
                                                    echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum($current_month_bal).'</span></td>';   
                                                        $old_month_bal=bal_pre_month($v_date_start,$v_date_end,$row2->accca_id);
                                                    echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum($old_month_bal).'</span></td>';  
                                                        $current_year_bal=bal_cur_year($v_date_start,$v_date_end,$row2->accca_id);
                                                    echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum($current_year_bal).'</span></td>';  
                                                echo '</tr>';
                                                $v_bal_current_month_tmp3+=$current_month_bal;
                                                $v_bal_old_month_tmp3+=$old_month_bal;
                                                $v_bal_current_year_tmp3+=$current_year_bal;
                                            }
                                echo '</tbody>
                                    <tfoot>
                                        <tr style="background-color: #DDEBF7;">
                                           <td colspan="" class="text-left">Total Expense:</td>
                                           <td class="text-center" style="width: 150px;">'.$v_bal_current_month_tmp3.'</td>
                                           <td class="text-center" style="width: 150px;">'.$v_bal_old_month_tmp3.'</td>
                                           <td class="text-center" style="width: 150px;">'.$v_bal_current_year_tmp3.'</td>
                                        </tr>
                                        <tr style="background-color: #FCE4D6;">
                                           <td colspan="" class="text-left">Net Income:</td>
                                           <td class="text-center" style="width: 150px!important;">'.number_format($v_to_income_cur_month-$v_bal_current_month_tmp3,2).'</td>
                                           <td class="text-center" style="width: 150px!important;">'.number_format($v_to_income_old_month-$v_bal_old_month_tmp3,2).'</td>
                                           <td class="text-center" style="width: 150px!important;">'.number_format($v_to_income_old_year-$v_bal_current_year_tmp3,2).'</td>
                                        </tr>
                                    </tfoot>
                               </table>
                            </div>
                        </li>
                    </ul>
                </div>';
            ?>
        </div>
    </div>
</div>
<!-- <script type="text/javascript" src="../../assets/global/plugins/jquery.min.js"></script> -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('tbody tr').each(function() {
            v_act_month=$(this).find('td:nth-child(2) >span:nth-child(2)').html();
            v_pre_month=$(this).find('td:nth-child(3) >span:nth-child(2)').html();
            v_act_year=$(this).find('td:nth-child(4) >span:nth-child(2)').html();
            if(v_act_month==''&&v_pre_month==''&&v_act_year==''){
                $(this).hide();
            }
        });


        $('tfoot >tr').each(function() {
            let v_total_debit=$(this).find('td:nth-child(2)').html();
            $(this).parents('.mt-list-item').find('#total_debit').html("$ "+v_total_debit);
            let v_total_credit=$(this).find('td:nth-child(3)').html();
            $(this).parents('.mt-list-item').find('#total_credit').html("$ "+v_total_credit);
        });


    }); 
    function myChangDateStart(args){
        $('h4').css('display','block');
        $('h4').html('FROM '+$(args).val());
    }
    function myChangDateEnd(args){
        $('h4').css('display','block');
        $('h4').append(' To '+$(args).val());
    }
</script>
<?php include_once '../layout/footer.php' ?>
