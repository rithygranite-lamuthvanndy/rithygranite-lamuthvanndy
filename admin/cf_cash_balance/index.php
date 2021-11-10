<?php 
    $menu_active =0;
    $left_active =0;
    $layout_title = "Welcome...";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Cash Balance</h2>
        </div>
    </div>
    <br>
    <div class="row">
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="col-sm-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input name="txt_date_start" value="<?= @$_POST['txt_date_start'] ?>" REQUIRED type="text" class="form-control" placeholder="date from">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input name="txt_date_end" value="<?= @$_POST['txt_date_end'] ?>" REQUIRED type="text" class="form-control" placeholder="date to">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
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
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Date Record</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Month Year</th>
                        <th>Amount In</th>
						<th>Amount Out</th>
                        <th>Note</th>
                        <th>User_ID</th>
                        <th>Date_Audit</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $total_income = 0;
                        $total_expense = 0;
                        $total_balance = 0;

                        if(isset($_POST['btn_search'])){
                            $v_date_s = @$_POST['txt_date_start'];
                            $v_date_e = @$_POST['txt_date_end'];
                            
                            if(@$_POST['txt_category']!=""){
                                $v_category = @$_POST['txt_category'];
                                $get_data = $connect->query("SELECT 
                                   *
                                FROM tbl_cf_cash_record AS A
                                LEFT JOIN tbl_cf_category_list AS CL ON CL.cfcl_id=A.cfcr_category
                                LEFT JOIN tbl_cf_type_list AS T ON T.cftl_id=A.cfcr_type
                                LEFT JOIN tbl_cf_monthyear_list AS MY ON MY.cfmy_id=A.cfcr_month_year
                                LEFT JOIN tbl_user AS U ON U.user_id=A.user_id
                                WHERE cfcr_date_record BETWEEN '$v_date_s' AND '$v_date_e' AND A.wr_category='$v_category'
                                ORDER BY cfcr_id DESC");

                            }else{
                                $get_data = $connect->query("SELECT 
                                   *
                                FROM tbl_cf_cash_record AS A
                                LEFT JOIN tbl_cf_category_list AS CL ON CL.cfcl_id=A.cfcr_category
                                LEFT JOIN tbl_cf_type_list AS T ON T.cftl_id=A.cfcr_type
                                LEFT JOIN tbl_cf_monthyear_list AS MY ON MY.cfmy_id=A.cfcr_month_year
                                LEFT JOIN tbl_user AS U ON U.user_id=A.user_id
                                WHERE cfcr_date_record BETWEEN '$v_date_s' AND '$v_date_e'
                                ORDER BY cfcr_id DESC");

                            }
                        }else{
                            $v_current_year_month = date('Y-m');

                            $get_data = $connect->query("SELECT 
                               *
                            FROM tbl_cf_cash_record AS A
                            LEFT JOIN tbl_cf_category_list AS CL ON CL.cfcl_id=A.cfcr_category
                            LEFT JOIN tbl_cf_type_list AS T ON T.cftl_id=A.cfcr_type
                            LEFT JOIN tbl_cf_monthyear_list AS MY ON MY.cfmy_id=A.cfcr_month_year
                            LEFT JOIN tbl_user AS U ON U.user_id=A.user_id
                            WHERE DATE_FORMAT(cfcr_date_record,'%Y-%m')='$v_current_year_month'
                            ORDER BY cfcr_id DESC");

                        }

                        
                        while ($row = mysqli_fetch_object($get_data)) {
                            $total_income+= $row->cfcr_amount_in; 
                            $total_expense+= $row->cfcr_amount_out; 
                            $total_balance= $total_income-$total_expense; 

                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->cfcr_date_record.'</td>';
                                echo '<td>'.$row->cfcr_description.'</td>';
                                echo '<td>'.$row->cfcl_name.'</td>';
                                echo '<td>'.$row->cftl_name.'</td>';
                                echo '<td>'.$row->cfmy_name.'</td>';
                                echo '<td>'.$row->cfcr_amount_in.'</td>';
								echo '<td>'.$row->cfcr_amount_out.'</td>';
                                echo '<td>'.$row->cfcr_note.'</td>';
                                echo '<td>'.$row->user_name.'</td>';
                                echo '<td>'.$row->date_audit.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->cfcr_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                //   echo '<a href="delete.php?del_id='.$row->doccat_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Total:</th>
                        <th>
                            <?php
                                echo "$total_income";
                            ?>
                        </th>
                        <th>
                            <?php
                                echo "$total_expense";
                            ?>
                        </th>
                        <th>
                            <?php
                                echo "$total_balance";
                            ?>
                        </th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>






<?php include_once '../layout/footer.php' ?>
