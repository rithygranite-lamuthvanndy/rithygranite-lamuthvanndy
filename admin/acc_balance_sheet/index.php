<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "View Report Balance Sheet";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
    include_once 'my_function.php';
    include_once '../acc_income_statment/my_function.php';
?>
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
                <h3 style="font-weight: bold;"><strong>Balance Sheet</strong></h3>
                <b><h4 style="font-family: 'Khmer OS Moul';">FROM <?= @$_POST['txt_date_start'] ?> TO <?= @$_POST['txt_date_end'] ?></h4></b>
                <p style="font-size: 15px!important;" class="text-uppercase">Currency : USD</p>
            </div>
        </div>
    </div>
    <br>
    <div class="container" style="padding: 0 10px;">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 pull-right text-center" style="width: 135px; border-bottom: 1px solid black; margin: 0 10px;">
            <h5>Previous<br>Year</h5>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 pull-right text-center" style="width: 135px; border-bottom: 1px solid black; margin: 0 10px;">
            <h5>Previous<br>Month</h5>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 pull-right text-center" style="width: 135px; border-bottom: 1px solid black; margin: 0 10px;">
            <h5>Current<br>Month</h5>
        </div>  
    </div>
    <div class="portlet-body text-center">
        <div class="list-todo-item dark container">
            <?php 
                $i=0;
                $v_main_id=1;
                $v_main_name='Asset';
                $idx=0;
                echo '<a class="list-toggle-container" data-toggle="collapse" data-parent="#accordion1" onclick=" " href="#task-0" aria-expanded="false">
                        <div class="list-toggle done uppercase bg-primary" style="background-color: #C6E0B4; padding: 10px; color: black;">
                            <div class="list-toggle-title bold text-left">
                            '.$v_main_name.'
                            </div>
                        </div>
                    </a>';

                echo '<ul>
                        <li class="task-list-item" style="list-style: none;">
                            <a class="list-toggle-container" data-toggle="collapse" data-parent="#accordion1" onclick=" " href="#task-main_1" aria-expanded="false">
                                <div class="list-toggle done uppercase bg-primary" style="background-color: #FCE4D6; padding: 10px; color: black;">
                                    <div class="list-toggle-title bold text-left">Currenst Assets</div>
                                </div>
                            </a>';

                            $v_sub_main_id=[4,5];
                            $v_sun_main_name="Checking / Savings";
                            echo '<ul>
                                    <li class="task-list-item" style="list-style: none;">
                                        <a class="list-toggle-container" data-toggle="collapse" data-parent="#accordion1" onclick=" " href="#task-a0" aria-expanded="false">
                                            <div class="list-toggle done uppercase bg-primary" style="background-color: #DDEBF7; padding: 10px; color: black;">
                                                <div class="list-toggle-title bold text-left">'.$v_sun_main_name.'</div>
                                            </div>
                                        </a>
                                    </li>
                                    <div class="task-list panel-collapse collapse in" id="task-a0">
                                        <ul>
                                            <li class="task-list-item" style="list-style: none;">
                                                <table class="table table-hover table-striped table-bordered myTable">
                                                    <tbody>';
                                                $v_bal_checking_current_month1=0;
                                                $v_bal_checking_old_month1=0;
                                                $v_bal_checking_current_year1=0;
                                                if(isset($_POST['btn_search'])){
                                                    $v_date_start=@$_POST['txt_date_start'];
                                                    $v_date_end=@$_POST['txt_date_end'];
                                                    if($v_date_start>$v_date_end){
                                                        echo '<script>myAlertInfo("Please Choose Date From Before Date End")</script>';
                                                        header( "refresh:3;url=index.php" );
                                                    }
                                                }
                                                else{
                                                    $v_date_start=@date('Y-m-d');
                                                    $v_date_end=@date('Y-m-d');
                                                }
                                                $sql2=$connect->query(GetAccountName_BS($v_sub_main_id));
                                                while ($row2=mysqli_fetch_object($sql2)) {
                                                    echo '<tr>';       
                                                        echo '<td class="text-left">'.$row2->accca_number.'-'.$row2->accca_account_name.'</td>';  
                                                            $current_month_bal=bal_current_month_BS($v_date_start,$v_date_end,$row2->accca_id);//+bal_pre_month_BS($v_date_start,$v_date_end,$row2->accca_id);
                                                        echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($current_month_bal).'</span></td>';   
                                                            $old_month_bal=bal_pre_month_BS($v_date_start,$v_date_end,$row2->accca_id);
                                                        echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($old_month_bal).'</span></td>';  
                                                            $current_year_bal=bal_cur_year_BS($v_date_start,$v_date_end,$row2->accca_id);
                                                        echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($current_year_bal).'</span></td>';  
                                                    echo '</tr>';
                                                    $v_bal_checking_current_month1+=$current_month_bal;
                                                    $v_bal_checking_old_month1+=$old_month_bal;
                                                    $v_bal_checking_current_year1+=$current_year_bal;
                                                }
                                                echo '</tbody>
                                        <tfoot>
                                            <tr style="background-color: #FFF2CC;">
                                               <td colspan="" class="text-left">Total Checking / Savings:</td>
                                               <td class="text-center" style="width: 150px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS(($v_bal_checking_current_month1)).'</span></td>
                                               <td class="text-center" style="width: 150px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($v_bal_checking_old_month1).'</span></td>
                                               <td class="text-center" style="width: 150px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($v_bal_checking_current_year1).'</span></td>
                                            </tr>
                                        </tfoot>
                                                </table>
                                            </li>
                                        <ul>
                                    </div>
                                </ul>';


                            $v_sub_main_id=[3];
                            $v_sun_main_name="Account Receivable";
                            echo '<ul>
                                    <li class="task-list-item" style="list-style: none;">
                                        <a class="list-toggle-container" data-toggle="collapse" data-parent="#accordion1" onclick=" " href="#task-a1" aria-expanded="false">
                                            <div class="list-toggle done uppercase bg-primary" style="background-color: #DDEBF7; padding: 10px; color: black;">
                                                <div class="list-toggle-title bold text-left">'.$v_sun_main_name.'</div>
                                            </div>
                                        </a>
                                    </li>
                                    <div class="task-list panel-collapse collapse in" id="task-a1">
                                        <ul>
                                            <li class="task-list-item" style="list-style: none;">
                                                <table class="table table-hover table-striped table-bordered myTable">
                                                    <tbody>';
                                                        $v_bal_ar_current_month2=0;
                                                        $v_bal_ar_old_month2=0;
                                                        $v_bal_ar_current_year2=0;
                                                        if(isset($_POST['btn_search'])){
                                                            $v_date_start=@$_POST['txt_date_start'];
                                                            $v_date_end=@$_POST['txt_date_end'];
                                                            if($v_date_start>$v_date_end){
                                                                echo '<script>myAlertInfo("Please Choose Date From Before Date End")</script>';
                                                                header( "refresh:3;url=index.php" );
                                                            }
                                                        }
                                                        else{
                                                            $v_date_start=@date('Y-m-d');
                                                            $v_date_end=@date('Y-m-d');
                                                        }
                                                        $sql2=$connect->query(GetAccountName_BS($v_sub_main_id));
                                                        while ($row2=mysqli_fetch_object($sql2)) {
                                                            echo '<tr>';       
                                                                echo '<td class="text-left">'.$row2->accca_number.'-'.$row2->accca_account_name.'</td>';  
                                                                    $current_month_bal=bal_current_month_BS($v_date_start,$v_date_end,$row2->accca_id);//+bal_pre_month_BS($v_date_start,$v_date_end,$row2->accca_id);
                                                                echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($current_month_bal).'</span></td>';   
                                                                    $old_month_bal=bal_pre_month_BS($v_date_start,$v_date_end,$row2->accca_id);
                                                                echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($old_month_bal).'</span></td>';  
                                                                    $current_year_bal=bal_cur_year_BS($v_date_start,$v_date_end,$row2->accca_id);
                                                                echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($current_year_bal).'</span></td>';  
                                                            echo '</tr>';
                                                            $v_bal_ar_current_month2+=$current_month_bal;
                                                            $v_bal_ar_old_month2+=$old_month_bal;
                                                            $v_bal_ar_current_year2+=$current_year_bal;
                                                        }
                                            echo '</tbody>
                                                <tfoot>
                                                    <tr style="background-color: #FFF2CC;">
                                                       <td colspan="" class="text-left">Total Account Receivable:</td>
                                                       <td class="text-center" style="width: 150px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($v_bal_ar_current_month2).'</span></td>
                                                       <td class="text-center" style="width: 150px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($v_bal_ar_old_month2).'</span></td>
                                                       <td class="text-center" style="width: 150px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($v_bal_ar_current_year2).'</span></td>
                                                    </tr>
                                                </tfoot>
                                           </table>
                                            </li>
                                        </ul>
                            </div>
                            </ul>';


                            $v_sub_main_id=[14];
                            $v_sun_main_name="Inventory";
                            echo '<ul>
                                    <li class="task-list-item" style="list-style: none;">
                                        <a class="list-toggle-container" data-toggle="collapse" data-parent="#accordion1" onclick=" " href="#task-a3" aria-expanded="false">
                                            <div class="list-toggle done uppercase bg-primary" style="background-color: #DDEBF7; padding: 10px; color: black;">
                                                <div class="list-toggle-title bold text-left">'.$v_sun_main_name.'</div>
                                            </div>
                                        </a>
                                    </li>
                                    <div class="task-list panel-collapse collapse in" id="task-a3">
                                        <ul>
                                            <li class="task-list-item" style="list-style: none;">
                                                <table class="table table-hover table-striped table-bordered myTable">
                                                    <tbody>';
                                                        $v_bal_inv_current_month3=0;
                                                        $v_bal_inv_old_month3=0;
                                                        $v_bal_inv_current_year3=0;
                                                        if(isset($_POST['btn_search'])){
                                                            $v_date_start=@$_POST['txt_date_start'];
                                                            $v_date_end=@$_POST['txt_date_end'];
                                                            if($v_date_start>$v_date_end){
                                                                echo '<script>myAlertInfo("Please Choose Date From Before Date End")</script>';
                                                                header( "refresh:3;url=index.php" );
                                                            }
                                                            // $sql2=$connect->query(my_detail_date_($v_date_start,$v_date_end,$v_sub_main_id));
                                                        }
                                                        else{
                                                            $v_date_start=@date('Y-m-d');
                                                            $v_date_end=@date('Y-m-d');
                                                        }
                                                        $sql2=$connect->query(GetAccountName_BS($v_sub_main_id));
                                                        while ($row2=mysqli_fetch_object($sql2)) {
                                                            echo '<tr>';       
                                                                echo '<td class="text-left">'.$row2->accca_number.'-'.$row2->accca_account_name.'</td>';  
                                                                    $current_month_bal=bal_current_month_BS($v_date_start,$v_date_end,$row2->accca_id);//+bal_pre_month_BS($v_date_start,$v_date_end,$row2->accca_id);
                                                                echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($current_month_bal).'</span></td>';   
                                                                    $old_month_bal=bal_pre_month_BS($v_date_start,$v_date_end,$row2->accca_id);
                                                                echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($old_month_bal).'</span></td>';  
                                                                    $current_year_bal=bal_cur_year_BS($v_date_start,$v_date_end,$row2->accca_id);
                                                                echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($current_year_bal).'</span></td>';  
                                                            echo '</tr>';
                                                            $v_bal_inv_current_month3+=$current_month_bal;
                                                            $v_bal_inv_old_month3+=$old_month_bal;
                                                            $v_bal_inv_current_year3+=$current_year_bal;
                                                        }
                                            echo '</tbody>
                                                <tfoot>
                                                    <tr style="background-color: #FFF2CC;">
                                                       <td colspan="" class="text-left">Total Inventory:</td>
                                                       <td class="text-center" style="width: 150px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($v_bal_inv_current_month3).'</span></td>
                                                       <td class="text-center" style="width: 150px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($v_bal_inv_old_month3).'</span></td>
                                                       <td class="text-center" style="width: 150px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($v_bal_inv_current_year3).'</span></td>
                                                    </tr>
                                                </tfoot>
                                           </table>
                                        </li>
                                    </ul>
                            </div>
                            </ul>';

                            $v_sub_main_id=[2];
                            $v_sun_main_name="Other Current Assets";
                            echo '<ul>
                                    <li class="task-list-item" style="list-style: none;">
                                        <a class="list-toggle-container" data-toggle="collapse" data-parent="#accordion1" onclick=" " href="#task-a4" aria-expanded="false">
                                            <div class="list-toggle done uppercase bg-primary" style="background-color: #DDEBF7; padding: 10px; color: black;">
                                                <div class="list-toggle-title bold text-left">'.$v_sun_main_name.'</div>
                                            </div>
                                        </a>
                                    </li>
                                    <div class="task-list panel-collapse collapse in" id="task-a4">
                                        <ul>
                                            <li class="task-list-item" style="list-style: none;">
                                                <table class="table table-hover table-striped table-bordered myTable">
                                                    <tbody>';
                                                        $v_bal_oca_current_month4=0;
                                                        $v_bal_oca_month4=0;
                                                        $v_bal_oca_current_year4=0;
                                                        if(isset($_POST['btn_search'])){
                                                            $v_date_start=@$_POST['txt_date_start'];
                                                            $v_date_end=@$_POST['txt_date_end'];
                                                            if($v_date_start>$v_date_end){
                                                                echo '<script>myAlertInfo("Please Choose Date From Before Date End")</script>';
                                                                header( "refresh:3;url=index.php" );
                                                            }
                                                            // $sql2=$connect->query(my_detail_date_($v_date_start,$v_date_end,$v_sub_main_id));
                                                        }
                                                        else{
                                                            $v_date_start=@date('Y-m-d');
                                                            $v_date_end=@date('Y-m-d');
                                                        }
                                                        $sql2=$connect->query(GetAccountName_BS($v_sub_main_id));
                                                        while ($row2=mysqli_fetch_object($sql2)) {
                                                            echo '<tr>';       
                                                                echo '<td class="text-left">'.$row2->accca_number.'-'.$row2->accca_account_name.'</td>';  
                                                                    $current_month_bal=bal_current_month_BS($v_date_start,$v_date_end,$row2->accca_id);//+bal_pre_month_BS($v_date_start,$v_date_end,$row2->accca_id);
                                                                echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($current_month_bal).'</span></td>';   
                                                                    $old_month_bal=bal_pre_month_BS($v_date_start,$v_date_end,$row2->accca_id);
                                                                echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($old_month_bal).'</span></td>';  
                                                                    $current_year_bal=bal_cur_year_BS($v_date_start,$v_date_end,$row2->accca_id);
                                                                echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($current_year_bal).'</span></td>';  
                                                            echo '</tr>';
                                                            $v_bal_oca_current_month4+=$current_month_bal;
                                                            $v_bal_oca_month4+=$old_month_bal;
                                                            $v_bal_oca_current_year4+=$current_year_bal;
                                                        }
                                            echo '</tbody>
                                                <tfoot>
                                                    <tr style="background-color: #FFF2CC;">
                                                       <td colspan="" class="text-left">Total Other Current Asset:</td>
                                                       <td class="text-center" style="width: 150px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($v_bal_oca_current_month4).'</span></td>
                                                       <td class="text-center" style="width: 150px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($v_bal_oca_month4).'</span></td>
                                                       <td class="text-center" style="width: 150px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($v_bal_oca_current_year4).'</span></td>
                                                    </tr>
                                                </tfoot>
                                           </table>
                                        </li>
                                    </ul>
                            </div>
                            </ul>';

                            $v_sub_main_id=[6];
                            $v_sun_main_name="Fix Assets";
                            echo '<ul>
                                    <li class="task-list-item" style="list-style: none;">
                                        <a class="list-toggle-container" data-toggle="collapse" data-parent="#accordion1" onclick=" " href="#task-a5" aria-expanded="false">
                                            <div class="list-toggle done uppercase bg-primary" style="background-color: #DDEBF7; padding: 10px; color: black;">
                                                <div class="list-toggle-title bold text-left">'.$v_sun_main_name.'</div>
                                            </div>
                                        </a>
                                    </li>
                                    <div class="task-list panel-collapse collapse in" id="task-a5">
                                        <ul>
                                            <li class="task-list-item" style="list-style: none;">
                                                <table class="table table-hover table-striped table-bordered myTable">
                                                    <tbody>';
                                                        $v_bal_fa_current_month5=0;
                                                        $v_bal_fa_old_month5=0;
                                                        $v_bal_fa_current_year5=0;
                                                        if(isset($_POST['btn_search'])){
                                                            $v_date_start=@$_POST['txt_date_start'];
                                                            $v_date_end=@$_POST['txt_date_end'];
                                                            if($v_date_start>$v_date_end){
                                                                echo '<script>myAlertInfo("Please Choose Date From Before Date End")</script>';
                                                                header( "refresh:3;url=index.php" );
                                                            }
                                                            // $sql2=$connect->query(my_detail_date_($v_date_start,$v_date_end,$v_sub_main_id));
                                                        }
                                                        else{
                                                            $v_date_start=@date('Y-m-d');
                                                            $v_date_end=@date('Y-m-d');
                                                        }
                                                        $sql2=$connect->query(GetAccountName_BS($v_sub_main_id));
                                                        while ($row2=mysqli_fetch_object($sql2)) {
                                                            echo '<tr>';       
                                                                echo '<td class="text-left">'.$row2->accca_number.'-'.$row2->accca_account_name.'</td>';  
                                                                    $current_month_bal=bal_current_month_BS($v_date_start,$v_date_end,$row2->accca_id);//+bal_pre_month_BS($v_date_start,$v_date_end,$row2->accca_id);
                                                                echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($current_month_bal).'</span></td>';   
                                                                    $old_month_bal=bal_pre_month_BS($v_date_start,$v_date_end,$row2->accca_id);
                                                                echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($old_month_bal).'</span></td>';  
                                                                    $current_year_bal=bal_cur_year_BS($v_date_start,$v_date_end,$row2->accca_id);
                                                                echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($current_year_bal).'</span></td>';  
                                                            echo '</tr>';
                                                            $v_bal_fa_current_month5+=$current_month_bal;
                                                            $v_bal_fa_old_month5+=$old_month_bal;
                                                            $v_bal_fa_current_year5+=$current_year_bal;
                                                        }
                                                $v_total_cur_month_1=$v_bal_checking_current_month1+$v_bal_ar_current_month2+$v_bal_inv_current_month3+$v_bal_oca_current_month4+$v_bal_fa_current_month5;
                                                $v_total_old_month_1=$v_bal_checking_old_month1+$v_bal_ar_old_month2+$v_bal_inv_old_month3+$v_bal_oca_month4+$v_bal_fa_old_month5;
                                                $v_total_cur_year_1=$v_bal_checking_current_year1+$v_bal_ar_current_year2+$v_bal_inv_current_year3+$v_bal_oca_current_year4+$v_bal_fa_old_month5;
                                            echo '</tbody>
                                                <tfoot>
                                                    <tr style="background-color: #FFF2CC;">
                                                       <td colspan="" class="text-left">Total Fix Asset:</td>
                                                       <td class="text-center" style="width: 150px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($v_bal_fa_current_month5).'</span></td>
                                                       <td class="text-center" style="width: 150px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($v_bal_fa_old_month5).'</span></td>
                                                       <td class="text-center" style="width: 150px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($v_bal_fa_current_year5).'</span></td>
                                                    </tr>
                                                    <tr style="background-color: #FCE4D6;">
                                                       <td colspan="" class="text-left">Total Asset :</td>
                                                       <td class="text-center" style="width: 150px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($v_total_cur_month_1).'</span></td>
                                                       <td class="text-center" style="width: 150px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($v_total_old_month_1).'</span></td>
                                                       <td class="text-center" style="width: 150px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($v_total_cur_year_1).'</span></td>
                                                    </tr>
                                                </tfoot>
                                           </table>
                                        </li>
                                    </ul>
                            </div>
                            </ul>
                        </li> 
                    </ul>';
                $v_main_id=2;
                $v_main_name='Liabilities & Equity';
                $idx=0;
                echo '<a class="list-toggle-container" data-toggle="collapse" data-parent="#accordion1" onclick=" " href="#task-main_b" aria-expanded="false">
                        <div class="list-toggle done uppercase bg-primary" style="background-color: #C6E0B4; padding: 10px; color: black;">
                            <div class="list-toggle-title bold text-left">
                            '.$v_main_name.'
                            </div>
                        </div>
                    </a>';

                echo '<ul id="task-main_b">';
                    $v_sub_main_id=[8,7,15];
                    $v_sun_main_name="Current Liabilities";
                    echo '<li class="task-list-item" style="list-style: none;">
                                <a class="list-toggle-container" data-toggle="collapse" data-parent="#accordion1" onclick=" " href="#task-b1" aria-expanded="false">
                                    <div class="list-toggle done uppercase bg-primary" style="background-color: #DDEBF7; padding: 10px; color: black;">
                                        <div class="list-toggle-title bold text-left">'.$v_sun_main_name.'</div>
                                    </div>
                                </a>
                            </li>
                            <div class="task-list panel-collapse collapse in" id="task-b1">
                                <ul>
                                    <li class="task-list-item" style="list-style: none;">
                                        <table class="table table-hover table-striped table-bordered myTable">
                                            <tbody>';
                                                $v_bal_cl_current_month6=0;
                                                $v_bal_cl_old_month6=0;
                                                $v_bal_cl_current_year6=0;
                                                if(isset($_POST['btn_search'])){
                                                    $v_date_start=@$_POST['txt_date_start'];
                                                    $v_date_end=@$_POST['txt_date_end'];
                                                    if($v_date_start>$v_date_end){
                                                        echo '<script>myAlertInfo("Please Choose Date From Before Date End")</script>';
                                                        header( "refresh:3;url=index.php" );
                                                    }
                                                    // $sql2=$connect->query(my_detail_date_($v_date_start,$v_date_end,$v_sub_main_id));
                                                }
                                                else{
                                                    $v_date_start=@date('Y-m-d');
                                                    $v_date_end=@date('Y-m-d');
                                                }
                                                $sql2=$connect->query(GetAccountName_BS($v_sub_main_id));
                                                while ($row2=mysqli_fetch_object($sql2)) {
                                                    echo '<tr>';       
                                                        echo '<td class="text-left">'.$row2->accca_number.'-'.$row2->accca_account_name.'</td>';  
                                                            $current_month_bal=bal_current_month_BS($v_date_start,$v_date_end,$row2->accca_id)+bal_pre_month_BS($v_date_start,$v_date_end,$row2->accca_id);
                                                        echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($current_month_bal).'</span></td>';   
                                                            $old_month_bal=bal_pre_month_BS($v_date_start,$v_date_end,$row2->accca_id);
                                                        echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($old_month_bal).'</span></td>';  
                                                            $current_year_bal=bal_cur_year_BS($v_date_start,$v_date_end,$row2->accca_id);
                                                        echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($current_year_bal).'</span></td>';  
                                                    echo '</tr>';
                                                    $v_bal_cl_current_month6+=$current_month_bal;
                                                    $v_bal_cl_old_month6+=$old_month_bal;
                                                    $v_bal_cl_current_year6+=$current_year_bal;
                                                }
                                    echo '</tbody>
                                        <tfoot>
                                            <tr style="background-color: #FFF2CC;">
                                               <td colspan="" class="text-left">Total Current Liabilities:</td>
                                               <td class="text-center" style="width: 150px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($v_bal_cl_current_month6).'</span></td>
                                               <td class="text-center" style="width: 150px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($v_bal_cl_old_month6).'</span></td>
                                               <td class="text-center" style="width: 150px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($v_bal_cl_current_year6).'</span></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </li>
                            </ul>
                        </div>';

                    $v_sub_main_id=[9];
                    $v_sun_main_name="Equity";
                    echo '<li class="task-list-item" style="list-style: none;">
                                <a class="list-toggle-container" data-toggle="collapse" data-parent="#accordion1" onclick=" " href="#task-b2" aria-expanded="false">
                                    <div class="list-toggle done uppercase bg-primary" style="background-color: #DDEBF7; padding: 10px; color: black;">
                                        <div class="list-toggle-title bold text-left">'.$v_sun_main_name.'</div>
                                    </div>
                                </a>
                            </li>
                            <div class="task-list panel-collapse collapse in" id="task-b2">
                                <ul>
                                    <li class="task-list-item" style="list-style: none;">
                                        <table class="table table-hover table-striped table-bordered myTable">
                                            <tbody>';
                                                $v_bal_e_current_month7=0;
                                                $v_bal_e_old_month7=0;
                                                $v_bal_e_current_year7=0;
                                                if(isset($_POST['btn_search'])){
                                                    $v_date_start=@$_POST['txt_date_start'];
                                                    $v_date_end=@$_POST['txt_date_end'];
                                                    if($v_date_start>$v_date_end){
                                                        echo '<script>myAlertInfo("Please Choose Date From Before Date End")</script>';
                                                        header( "refresh:3;url=index.php" );
                                                    }
                                                    // $sql2=$connect->query(my_detail_date_($v_date_start,$v_date_end,$v_sub_main_id));
                                                }
                                                else{
                                                    $v_date_start=@date('Y-m-d');
                                                    $v_date_end=@date('Y-m-d');
                                                }
                                                $sql2=$connect->query(GetAccountName_BS($v_sub_main_id));
                                                while ($row2=mysqli_fetch_object($sql2)) {
                                                    echo '<tr>';       
                                                        echo '<td class="text-left">'.$row2->accca_number.'-'.$row2->accca_account_name.'</td>';  
                                                            $current_month_bal=bal_current_month_BS($v_date_start,$v_date_end,$row2->accca_id)+bal_pre_month_BS($v_date_start,$v_date_end,$row2->accca_id);
                                                        echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($current_month_bal).'</span></td>';   
                                                            $old_month_bal=bal_pre_month_BS($v_date_start,$v_date_end,$row2->accca_id);
                                                        echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($old_month_bal).'</span></td>';  
                                                            $current_year_bal=bal_cur_year_BS($v_date_start,$v_date_end,$row2->accca_id);
                                                        echo '<td class="text-center" style="width: 115px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($current_year_bal).'</span></td>';  
                                                    echo '</tr>';
                                                    $v_bal_e_current_month7+=$current_month_bal;
                                                    $v_bal_e_old_month7+=$old_month_bal;
                                                    $v_bal_e_current_year7+=$current_year_bal;
                                                }

                                                ///Get Net Income
                                                if(isset($_POST['btn_search'])){
                                                    $v_date_start=@($_POST['txt_date_start'])?($_POST['txt_date_start']):date('Y-m-d');
                                                    $v_date_end=@($_POST['txt_date_end'])?($_POST['txt_date_end']):date('Y-m-d');
                                                    if($v_date_start>$v_date_end){
                                                        echo '<script>myAlertInfo("Please Choose Date From Before Date End")</script>';
                                                        header( "refresh:3;url=index.php" );
                                                    }
                                                    $v_main_id=5;
                                                    $v_net_cur_month_tmp1=0;
                                                    $v_net_old_month_tmp1=0;
                                                    $v_net_cur_year_tmp1=0;
                                                    $sql2=$connect->query(GetAccountName($v_main_id));
                                                    while ($row_tmp1=mysqli_fetch_object($sql2)) {
                                                        $v_net_cur_month_tmp1+=bal_current_month($v_date_start,$v_date_end,$row_tmp1->accca_id)+bal_pre_month($v_date_start,$v_date_end,$row_tmp1->accca_id);
                                                        $v_net_old_month_tmp1+=bal_pre_month($v_date_start,$v_date_end,$row_tmp1->accca_id);
                                                        $v_net_cur_year_tmp1+=bal_cur_year($v_date_start,$v_date_end,$row_tmp1->accca_id);
                                                    }

                                                    $v_main_id=4;
                                                    $v_net_cur_month_tmp2=0;
                                                    $v_net_old_month_tmp2=0;
                                                    $v_net_cur_year_tmp2=0;
                                                    $sql2=$connect->query(GetAccountName($v_main_id));
                                                    while ($row_tmp1=mysqli_fetch_object($sql2)) {
                                                        $v_net_cur_month_tmp2+=bal_current_month($v_date_start,$v_date_end,$row_tmp1->accca_id)+bal_pre_month($v_date_start,$v_date_end,$row_tmp1->accca_id);
                                                        $v_net_old_month_tmp2+=bal_pre_month($v_date_start,$v_date_end,$row_tmp1->accca_id);
                                                        $v_net_cur_year_tmp2+=bal_cur_year($v_date_start,$v_date_end,$row_tmp1->accca_id);
                                                    }

                                                    $v_main_id=6;
                                                    $v_net_cur_month_tmp3=0;
                                                    $v_net_old_month_tmp3=0;
                                                    $v_net_cur_year_tmp3=0;
                                                    $sql2=$connect->query(GetAccountName($v_main_id));
                                                    while ($row_tmp1=mysqli_fetch_object($sql2)) {
                                                        $v_net_cur_month_tmp3+=bal_current_month($v_date_start,$v_date_end,$row_tmp1->accca_id)+bal_pre_month($v_date_start,$v_date_end,$row_tmp1->accca_id);
                                                        $v_net_old_month_tmp3+=bal_pre_month($v_date_start,$v_date_end,$row_tmp1->accca_id);
                                                        $v_net_cur_year_tmp3+=bal_cur_year($v_date_start,$v_date_end,$row_tmp1->accca_id);
                                                    }
                                                }
                                                $v_net_current_bal=@$v_net_cur_month_tmp1+@$v_net_cur_month_tmp2-@$v_net_cur_month_tmp3;
                                                $v_net_old_year_bal=@$v_net_old_month_tmp1+@$v_net_cur_year_tmp2-@$v_net_old_month_tmp3;
                                                $v_net_year_bal=@$v_net_cur_year_tmp1+@$v_net_cur_year_tmp2-@$v_net_cur_year_tmp3;
                                                // End Net Income
                                                echo '<tr>';       
                                                    echo '<td class="text-left">403101 - Net Income</td>';    
                                                    echo '<td class="text-center" style="width: 150px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($v_net_current_bal).'</span></td>';  
                                                    echo '<td class="text-center" style="width: 150px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($v_net_old_year_bal).'</span></td>';  
                                                    echo '<td class="text-center" style="width: 150px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($v_net_year_bal).'</span></td>';  
                                                echo '</tr>';
                                                $v_bal_e_current_month7=$v_bal_e_current_month7+$v_net_current_bal;

                                                $v_bal_e_old_month7=$v_bal_e_old_month7+$v_net_old_year_bal;

                                                $v_bal_e_current_year7=$v_bal_e_current_year7+$v_net_year_bal;


                                                // Total Equity and Liability
                                                $v_bal_cur_month=$v_bal_e_current_month7+$v_bal_cl_current_month6;
                                                $v_bal_old_month=$v_bal_e_old_month7+$v_bal_cl_old_month6;
                                                $v_bal_cur_year=$v_bal_e_current_year7+$v_bal_cl_current_year6;
                                    echo '</tbody>
                                        <tfoot>
                                            <tr style="background-color: #FFF2CC;">
                                               <td colspan="" class="text-left">Total Currenst Equity:</td>
                                               <td class="text-center" style="width: 150px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($v_bal_e_current_month7).'</span></td>
                                               <td class="text-center" style="width: 150px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($v_bal_e_old_month7).'</span></td>
                                               <td class="text-center" style="width: 150px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum_BS($v_bal_e_current_year7).'</span></td>
                                            </tr>
                                            <tr style="background-color: #DDEBF7;">
                                               <td colspan="" class="text-left">Total Liabilities & Equity:</td>
                                                <td class="text-center" style="width: 150px!important;">
                                                    <span class="pull-left">$</span>
                                                    <span class="pull-right">'.AccountFormatNum_BS($v_bal_cur_month).'</span>
                                                </td>
                                                <td class="text-center" style="width: 150px!important;">
                                                    <span class="pull-left">$</span>
                                                    <span class="pull-right">'.AccountFormatNum_BS($v_bal_old_month).'</span>
                                                </td>
                                                <td class="text-center" style="width: 150px!important;">
                                                    <span class="pull-left">$</span>
                                                    <span class="pull-right">'.AccountFormatNum_BS($v_bal_cur_year).'</span>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </li>
                            </ul>
                        </div>
                    </ul>';   
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
