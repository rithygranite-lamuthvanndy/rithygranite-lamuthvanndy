<?php 
    $menu_active =115;
    $left_active =0;
    $layout_title = "Welcome to Setting Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Cash Layout</h2>
        </div>
    </div>
    <br>
    <div class="row">
        <form action="" method="post">
            <div class="col-sm-3" style="padding-right: 0px;">
                <div class="input-group">
                    <select required="" class="form-control" name="txt_month_year">
                        <option value="">== please choose ==</option>
                        <?php 
                            $v_select = $connect->query("SELECT * FROM tbl_cf_monthyear_list ORDER BY cfmy_name ASC");
                            while ($row_data = mysqli_fetch_object($v_select)) {
                                if($row_data->cfmy_id == @$_POST['txt_month_year']){
                                    echo '<option SELECTED value="'.$row_data->cfmy_id.'">'.$row_data->cfmy_name.'</option>';
                                    
                                }else{
                                    echo '<option value="'.$row_data->cfmy_id.'">'.$row_data->cfmy_name.'</option>';

                                }
                            }
                        ?>
                    </select>
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="caption font-dark" style="display: inline-block;">
                    <button type="submit" name="btn_search" id="sample_editable_1_new" class="btn blue"> Search
                        <i class="fa fa-search"></i>
                    </button>
                </div>
                <div class="caption font-dark" style="display: inline-block;">
                    <a href="<?= $_SERVER['PHP_SELF'] ?>" id="sample_editable_1_new" class="btn red"> Clear
                        <i class="fa fa-refresh"></i>
                    </a>
                </div>

            </div>
        </form>
    </div>
    <div class="portlet-body">
        <div class="row">
            <div class="col-xs-6">
                <table class="table table-striped table-bordered table-hover collapsed" width="100%">
                    <h3>Income</h3>
                    <thead>
                        <tr>
                            <th>N&deg;</th>
                            <th>Category</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i = 0;
                            $v_total = 0;
                            if(isset($_POST['btn_search'])){
                                $v_month_year = @$_POST['txt_month_year'];
                                $get_data = $connect->query("SELECT *
                                    FROM   tbl_cf_cash_estimate AS A  
                                    LEFT JOIN tbl_cf_category_list AS C ON C.cfcl_id=A.cfce_category
                                    WHERE cfce_type = '1' AND cfce_month_year='$v_month_year'
                                    ORDER BY cfce_id DESC");
                            }else{
                                $get_data = $connect->query("SELECT *
                                    FROM   tbl_cf_cash_estimate AS A  
                                    LEFT JOIN tbl_cf_category_list AS C ON C.cfcl_id=A.cfce_category
                                    WHERE cfce_type = '1'
                                    ORDER BY cfce_id DESC");
                            }
                            while ($row = mysqli_fetch_object($get_data)) {
                                $v_total += $row->cfce_amount;
                                echo '<tr>';
                                    echo '<td>'.(++$i).'</td>';
                                    echo '<td>'.$row->cfcl_name.'</td>';
                                    echo '<td>'.number_format($row->cfce_amount,2).'</td>';
                                    echo '</td>';
                                echo '</tr>';
                            }
                            $sum_income = $v_total;
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th class="text-right">Total :</th>
                            <th><?= number_format($v_total,2) ?> $</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="col-xs-6">
                <table class="table table-striped table-bordered table-hover collapsed" width="100%">
                    <h3>Expense</h3>
                    <thead>
                        <tr>
                            <th>N&deg;</th>
                            <th>Category</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i = 0;
                            $v_total = 0;
                            if(isset($_POST['btn_search'])){
                                $v_month_year = @$_POST['txt_month_year'];
                                $get_data = $connect->query("SELECT *
                                    FROM   tbl_cf_cash_estimate AS A  
                                    LEFT JOIN tbl_cf_category_list AS C ON C.cfcl_id=A.cfce_category
                                    WHERE cfce_type = '2' AND cfce_month_year='$v_month_year'
                                    ORDER BY cfce_id DESC");
                            }else{
                                $get_data = $connect->query("SELECT *
                                    FROM   tbl_cf_cash_estimate AS A  
                                    LEFT JOIN tbl_cf_category_list AS C ON C.cfcl_id=A.cfce_category
                                    WHERE cfce_type = '2'
                                    ORDER BY cfce_id DESC");
                            }
                            while ($row = mysqli_fetch_object($get_data)) {
                                $v_total += $row->cfce_amount;
                                echo '<tr>';
                                    echo '<td>'.(++$i).'</td>';
                                    echo '<td>'.$row->cfcl_name.'</td>';
                                    echo '<td>'.number_format($row->cfce_amount,2).'</td>';
                                    echo '</td>';
                                echo '</tr>';
                            }
                            $sum_expense = $v_total;
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th class="text-right">Total :</th>
                            <th><?= number_format($v_total,2) ?> $</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <table class="table table-striped table-bordered table-hover collapsed" width="100%">
                    <h3>Asset</h3>
                    <thead>
                        <tr>
                            <th>N&deg;</th>
                            <th>Category</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i = 0;
                            $v_total = 0;
                            if(isset($_POST['btn_search'])){
                                $v_month_year = @$_POST['txt_month_year'];
                                $get_data = $connect->query("SELECT *
                                    FROM   tbl_cf_cash_estimate AS A  
                                    LEFT JOIN tbl_cf_category_list AS C ON C.cfcl_id=A.cfce_category
                                    WHERE cfce_type = '3' AND cfce_month_year='$v_month_year'
                                    ORDER BY cfce_id DESC");
                            }else{
                                $get_data = $connect->query("SELECT *
                                    FROM   tbl_cf_cash_estimate AS A  
                                    LEFT JOIN tbl_cf_category_list AS C ON C.cfcl_id=A.cfce_category
                                    WHERE cfce_type = '3'
                                    ORDER BY cfce_id DESC");
                            }
                            while ($row = mysqli_fetch_object($get_data)) {
                                $v_total += $row->cfce_amount;
                                echo '<tr>';
                                    echo '<td>'.(++$i).'</td>';
                                    echo '<td>'.$row->cfcl_name.'</td>';
                                    echo '<td>'.number_format($row->cfce_amount,2).'</td>';
                                    echo '</td>';
                                echo '</tr>';
                            }
                            $sum_asset = $v_total;
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th class="text-right">Total :</th>
                            <th><?= number_format($v_total,2) ?> $</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="col-xs-6">
                <table class="table table-striped table-bordered table-hover collapsed" width="100%">
                    <h3>Liability</h3>
                    <thead>
                        <tr>
                            <th>N&deg;</th>
                            <th>Category</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i = 0;
                            $v_total = 0;
                            if(isset($_POST['btn_search'])){
                                $v_month_year = @$_POST['txt_month_year'];
                                $get_data = $connect->query("SELECT *
                                    FROM   tbl_cf_cash_estimate AS A  
                                    LEFT JOIN tbl_cf_category_list AS C ON C.cfcl_id=A.cfce_category
                                    WHERE cfce_type = '4' AND cfce_month_year='$v_month_year'
                                    ORDER BY cfce_id DESC");
                            }else{
                                $get_data = $connect->query("SELECT *
                                    FROM   tbl_cf_cash_estimate AS A  
                                    LEFT JOIN tbl_cf_category_list AS C ON C.cfcl_id=A.cfce_category
                                    WHERE cfce_type = '4'
                                    ORDER BY cfce_id DESC");
                            }
                            while ($row = mysqli_fetch_object($get_data)) {
                                $v_total += $row->cfce_amount;
                                echo '<tr>';
                                    echo '<td>'.(++$i).'</td>';
                                    echo '<td>'.$row->cfcl_name.'</td>';
                                    echo '<td>'.number_format($row->cfce_amount,2).'</td>';
                                    echo '</td>';
                                echo '</tr>';
                            }
                            $sum_liability = $v_total;
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th class="text-right">Total :</th>
                            <th><?= number_format($v_total,2) ?> $</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
            <h4 style="padding:12px" class="text-right bg-primary">Income - Expesne : <strong><?= number_format($sum_income-$sum_expense,2) ?></strong> $</h4>
            <h4 style="padding:12px" class="text-right bg-danger">Assset - Liability : <strong><?= number_format($sum_asset-$sum_liability,2) ?></strong> $</h4>
    </div>
</div>






<?php include_once '../layout/footer.php' ?>
