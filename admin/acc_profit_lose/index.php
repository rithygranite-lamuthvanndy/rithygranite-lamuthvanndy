<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Report: Profit and Lose</h2>
        </div>
    </div>
    <br>
    <div class="row">
        <!-- start search form -->
        <form action="" method="post">
            <div class="col-xs-2">
                <select name="txt_month" class="form-control" required="">
                    <option value="">==all month year==</option>
                    <?php 
                        $get_employee = $connect->query("SELECT * FROM tbl_acc_month_year ORDER BY accmy_name ASC");
                        while($row_employee = mysqli_fetch_object($get_employee)){
                            if($row_employee->accmy_id == @$_POST['txt_month']){
                                echo '<option SELECTED value="'.$row_employee->accmy_id.'">'.$row_employee->accmy_name.'</option>';

                            }else{
                                echo '<option value="'.$row_employee->accmy_id.'">'.$row_employee->accmy_name.'</option>';
                                
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="col-xs-2">
                <button type="submit" name="btn_search" class="btn blue"><i class="fa fa-search"></i> Search</button>
                <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn red"><i class="fa fa-undo"></i> Clear</a>
            </div>
        </form>
        <!-- end search form -->
    </div>
    <br><br><br>
    <div class="row">

        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <h3>Income</h3>
            <table class="table table-striped table-bordered table-hover dataTable" width="100%" role="grid" aria-describedby="sample_1_info">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Account Number</th>
                        <th>Account Name</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        if(isset($_POST['btn_search'])){
                            $v_month = @$_POST['txt_month'];
                            $get_data = $connect->query("SELECT 
                                   B.accca_account_name,B.accca_number,SUM(accad_debit-accad_credit) AS sum_amount
                                FROM   tbl_acc_add_transaction AS A 
                                RIGHT JOIN tbl_acc_chart_account AS B ON B.accca_id=A.accad_account
                                LEFT JOIN tbl_acc_type_account AS C ON C.accta_id=B.accca_account_type
                                LEFT JOIN tbl_acc_main_account AS D ON D.accma_id=C.accta_main_account
                                WHERE D.accma_id='5' AND A.accad_month_year='$v_month'
                                GROUP BY accca_id
                                ORDER BY accca_number ASC");
                        }else{
                            $get_data = $connect->query("SELECT 
                                   B.accca_account_name,B.accca_number,SUM(accad_debit-accad_credit) AS sum_amount
                                FROM   tbl_acc_add_transaction AS A 
                                RIGHT JOIN tbl_acc_chart_account AS B ON B.accca_id=A.accad_account
                                LEFT JOIN tbl_acc_type_account AS C ON C.accta_id=B.accca_account_type
                                LEFT JOIN tbl_acc_main_account AS D ON D.accma_id=C.accta_main_account
                                WHERE D.accma_id='5' 
                                GROUP BY accca_id
                                ORDER BY accca_number ASC");
                        }
                        $v_total = 0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            $v_total += $row->sum_amount;
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->accca_number.'</td>';
                                echo '<td>'.$row->accca_account_name.'</td>';
                                echo '<td>'.number_format($row->sum_amount,2).'</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
                <tfoot class="bg-success">
                    <th class="text-right" colspan="3">Total Income:</th>
                    <th><?= number_format($v_total,2) ?></th>
                    <?php $total_incomequity_cost = 0; $total_income=$v_total; ?>
                </tfoot>
            </table>

            <br>

            <h3>Cost of Goods Sold</h3>
            <table class="table table-striped table-bordered table-hover dataTable" width="100%" role="grid" aria-describedby="sample_1_info">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Account Number</th>
                        <th>Account Name</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        if(isset($_POST['btn_search'])){
                            $v_month = @$_POST['txt_month'];
                            $get_data = $connect->query("SELECT 
                                   B.accca_account_name,B.accca_number,SUM(accad_debit-accad_credit) AS sum_amount
                                FROM   tbl_acc_add_transaction AS A 
                                RIGHT JOIN tbl_acc_chart_account AS B ON B.accca_id=A.accad_account
                                LEFT JOIN tbl_acc_type_account AS C ON C.accta_id=B.accca_account_type
                                LEFT JOIN tbl_acc_main_account AS D ON D.accma_id=C.accta_main_account
                                WHERE D.accma_id='4' AND A.accad_month_year='$v_month'
                                GROUP BY accca_id
                                ORDER BY accca_number ASC");
                        }else{
                            $get_data = $connect->query("SELECT 
                                   B.accca_account_name,B.accca_number,SUM(accad_debit-accad_credit) AS sum_amount
                                FROM   tbl_acc_add_transaction AS A 
                                RIGHT JOIN tbl_acc_chart_account AS B ON B.accca_id=A.accad_account
                                LEFT JOIN tbl_acc_type_account AS C ON C.accta_id=B.accca_account_type
                                LEFT JOIN tbl_acc_main_account AS D ON D.accma_id=C.accta_main_account
                                WHERE D.accma_id='4' 
                                GROUP BY accca_id
                                ORDER BY accca_number ASC");
                        }
                        $v_total = 0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            $v_total += $row->sum_amount;
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->accca_number.'</td>';
                                echo '<td>'.$row->accca_account_name.'</td>';
                                echo '<td>'.number_format($row->sum_amount,2).'</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
                <tfoot class="bg-success">
                    <th class="text-right" colspan="3">Total Cost of Goods Sold:</th>
                    <th><?= number_format($v_total,2) ?></th>
                    <?php $total_incomequity_cost-= $v_total; ?>
                </tfoot>
            </table>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <h3>Expense</h3>
            <table class="table table-striped table-bordered table-hover dataTable" width="100%" role="grid" aria-describedby="sample_1_info">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Account Number</th>
                        <th>Account Name</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        if(isset($_POST['btn_search'])){
                            $v_month = @$_POST['txt_month'];
                            $get_data = $connect->query("SELECT 
                                   B.accca_account_name,B.accca_number,SUM(accad_debit-accad_credit) AS sum_amount
                                FROM   tbl_acc_add_transaction AS A 
                                RIGHT JOIN tbl_acc_chart_account AS B ON B.accca_id=A.accad_account
                                LEFT JOIN tbl_acc_type_account AS C ON C.accta_id=B.accca_account_type
                                LEFT JOIN tbl_acc_main_account AS D ON D.accma_id=C.accta_main_account
                                WHERE D.accma_id='6' AND A.accad_month_year='$v_month'
                                GROUP BY accca_id
                                ORDER BY accca_number ASC");
                        }else{
                            $get_data = $connect->query("SELECT 
                                   B.accca_account_name,B.accca_number,SUM(accad_debit-accad_credit) AS sum_amount
                                FROM   tbl_acc_add_transaction AS A 
                                RIGHT JOIN tbl_acc_chart_account AS B ON B.accca_id=A.accad_account
                                LEFT JOIN tbl_acc_type_account AS C ON C.accta_id=B.accca_account_type
                                LEFT JOIN tbl_acc_main_account AS D ON D.accma_id=C.accta_main_account
                                WHERE D.accma_id='6' 
                                GROUP BY accca_id
                                ORDER BY accca_number ASC");
                        }
                        $total_expense = 0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            $v_total += $row->sum_amount;
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->accca_number.'</td>';
                                echo '<td>'.$row->accca_account_name.'</td>';
                                echo '<td>'.number_format($row->sum_amount,2).'</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
                <tfoot class="bg-success">
                    <th class="text-right" colspan="3">Total Expense:</th>
                    <th><?= number_format($v_total,2) ?></th>
                    <?php $total_expense=$v_total ?>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <h3 class="alert bg-primary text-right">Cross Profit : <?= number_format($total_incomequity_cost,2) ?></h3>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <h3 class="alert bg-primary text-right">Expense : <?= number_format($total_expense,2) ?></h3>
        </div>
    </div>
    <h3 class="alert bg-warning text-center">Profit : <?= number_format($total_incomequity_cost-$total_expense,2) ?></h3>
</div>






<?php include_once '../layout/footer.php' ?>
