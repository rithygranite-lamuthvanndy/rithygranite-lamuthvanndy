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
            <h2><i class="fa fa-fw fa-map-marker"></i> Estimate: Search by month year</h2>
        </div>
    </div>
    <br>
    <div class="row">
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            
            <div class="col-sm-3">
                <div class="" >

                    <select name="txt_month_year" class="form-control">
                        <option value="">Choose: Month Year</option>
                        <?php 
                            $category = $connect->query("SELECT * FROM tbl_cf_monthyear_list ORDER BY cfmy_name ASC");
                            while($row_cate = mysqli_fetch_object($category)){
                                if($row_cate->cfmy_id == @$_POST['txt_month_year']){
                                    echo '<option SELECTED value="'.$row_cate->cfmy_id.'">'.$row_cate->cfmy_name.'</option>';

                                }else{
                                    echo '<option value="'.$row_cate->cfmy_id.'">'.$row_cate->cfmy_name.'</option>';
                                    
                                }
                            }
                        ?>
                    </select>

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
                        <th>Month Year</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>User Audit</th>
                        <th>Date Audit</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $total_amount=0;

                        if(isset($_POST['btn_search'])){
                            $v_date_s = @$_POST['txt_date_start'];
                            $v_date_e = @$_POST['txt_date_end'];

                            if(@$_POST['txt_month_year']>0){
                                $v_category = @$_POST['txt_month_year'];
                                $get_data = $connect->query("SELECT 
                                   A.*,U.user_name,MY.cfmy_name,C.cfcl_name,T.cftl_name
                                FROM  tbl_cf_cash_estimate AS A  
                                LEFT JOIN tbl_user AS U ON U.user_id=A.user_id
                                LEFT JOIN tbl_cf_monthyear_list AS MY ON MY.cfmy_id=A.cfce_month_year
                                LEFT JOIN tbl_cf_category_list AS C ON C.cfcl_id=A.cfce_category
                                LEFT JOIN tbl_cf_type_list AS T ON T.cftl_id=A.cfce_type
                                WHERE A.cfce_month_year='$v_category'
                                ORDER BY cfce_date_record DESC");

                            }else{
                                

                                                            }
                        }else{
                            
                            $v_current_year_month = date('Y-m');
                            $get_data = $connect->query("SELECT 
                               A.*,U.user_name,MY.cfmy_name,C.cfcl_name,T.cftl_name
                            FROM  tbl_cf_cash_estimate AS A  
                            LEFT JOIN tbl_user AS U ON U.user_id=A.user_id
                            LEFT JOIN tbl_cf_monthyear_list AS MY ON MY.cfmy_id=A.cfce_month_year
                            LEFT JOIN tbl_cf_category_list AS C ON C.cfcl_id=A.cfce_category
                            LEFT JOIN tbl_cf_type_list AS T ON T.cftl_id=A.cfce_type
                            WHERE DATE_FORMAT(cfce_date_record,'%Y-%m')='$v_current_year_month'
                            ORDER BY cfce_date_record DESC");

                        }

                        
                        while ($row = mysqli_fetch_object($get_data)) {
                            $total_amount+= $row->cfce_amount; 

                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->cfce_date_record.'</td>';
                                echo '<td>'.$row->cfmy_name.'</td>';
                                echo '<td>'.$row->cfcl_name.'</td>';
                                echo '<td>'.$row->cftl_name.'</td>';
                                echo '<td>'.$row->cfce_description.'</td>';
                                echo '<td>'.$row->cfce_amount.'</td>';
                                echo '<td>'.$row->user_name.'</td>';
                                echo '<td>'.$row->date_audit.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->cfce_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   //echo '<a href="delete.php?del_id='.$row->cfce_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

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
                        <th></th>
                        <th>Total:
                            <?php
                                echo "$total_amount";
                            ?>
                        </th>
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
