<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        
        $v_id = @$_POST['txt_id'];
        $v_date = @$_POST['txt_date'];
        $v_res_number = @$_POST['cbo_res_number'];
        $v_dep = @$_POST['cbo_dep'];
        $v_type_res = @$_POST['cbo_typ_res'];
        $v_req_name = @$_POST['cbo_req_name'];
        $v_app_by = @$_POST['cbo_app_by'];
        $v_loc_by = @$_POST['cbo_loc_by'];
        $v_res_pur = @$_POST['cbo_res_pur'];
        $v_amo_req = @$_POST['txt_amo_req'];
        
       
        $query_update = "UPDATE `tbl_acc_admin_check_list` 
            SET 
                ch_date_request='$v_date',
                ch_request_no='$v_res_number',
                ch_department='$v_dep',
                ch_type_request='$v_type_res',
                ch_request_by='$v_req_name',
                ch_approved_by='$v_app_by',
                ch_amount_request='$v_amo_req',
                ch_location_buy='$v_loc_by',
                ch_responsible_purchase='$v_res_pur'
            WHERE `ch_id`='$v_id'";
            
       
        if($connect->query($query_update)){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data update ...
            </div>'; 
        }else{
            $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> Query error ...
            </div>';   
        }
    }


// get old data 
    $edit_id = @$_GET['edit_id'];
    $old_data = $connect->query("SELECT * FROM tbl_acc_admin_check_list WHERE ch_id='$edit_id'");
    $row_old_data = mysqli_fetch_object($old_data);


 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Edit Record</h2>
        </div>
    </div>
    <br>
    <br>

    <div class="portlet-title">
        <div class="caption font-dark">
            <a href="index.php" id="sample_editable_1_new" class="btn red"> 
                <i class="fa fa-arrow-left"></i>
                Back
            </a>
        </div>
    </div>
    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
            <h3 class="panel-title">Input Information</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->ch_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" autocomplete="off" required name="txt_date" value="<?= $row_old_data->ch_date_request ?>">
                                    <label>Date Record:
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                             <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                   <select class="form-control" name="cbo_res_number">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_acc_request_form ORDER BY req_number ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                if($row_data->req_id==$row_old_data->ch_request_no)
                                                    echo '<option SELECTED value="'.$row_data->req_id.'">'.$row_data->req_number.'</option>';
                                                else
                                                    echo '<option value="'.$row_data->req_id.'">'.$row_data->req_number.'</option>';
                                            }
                                         ?>
                                    </select>
                                    <label>Request N&deg; :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                   <select class="form-control" name="cbo_dep">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_acc_department_list ORDER BY dep_name ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                if($row_data->dep_id==$row_old_data->ch_department)
                                                    echo '<option SELECTED value="'.$row_data->dep_id.'">'.$row_data->dep_name.'</option>';
                                                else
                                                    echo '<option value="'.$row_data->dep_id.'">'.$row_data->dep_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                    <label>Department :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                   <select class="form-control" name="cbo_typ_res">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_acc_type_request_list ORDER BY typr_name ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                if($row_data->typr_id==$row_old_data->ch_type_request) 
                                                    echo '<option SELECTED value="'.$row_data->typr_id.'">'.$row_data->typr_name.'</option>';
                                                else
                                                    echo '<option value="'.$row_data->typr_id.'">'.$row_data->typr_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                    <label>Type of Request :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                   <select class="form-control" name="cbo_req_name" required="">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_acc_request_name_list ORDER BY res_name ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                if($row_data->res_id==$row_old_data->ch_request_by) 
                                                    echo '<option SELECTED value="'.$row_data->res_id.'">'.$row_data->res_name.'</option>';
                                                    echo '<option value="'.$row_data->res_id.'">'.$row_data->res_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                    <label>Request By :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <select class="form-control" name="cbo_app_by"  autocomplete="off" required="">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_acc_approved_name_list ORDER BY apn_name ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                if($row_data->apn_id==$row_old_data->ch_approved_by) 
                                                    echo '<option SELECTED value="'.$row_data->apn_id.'">'.$row_data->apn_name.'</option>';
                                                else
                                                    echo '<option value="'.$row_data->apn_id.'">'.$row_data->apn_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                    <label>Approved By :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <select class="form-control" name="cbo_loc_by" required="required">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_acc_location_buy_list ORDER BY locb_name ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                if($row_data->locb_id==$row_old_data->ch_location_buy) 
                                                    echo '<option SELECTED value="'.$row_data->locb_id.'">'.$row_data->locb_name.'</option>';
                                                    echo '<option value="'.$row_data->locb_id.'">'.$row_data->locb_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                    <label>Location Buy:
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <select class="form-control" name="cbo_res_pur" required="required">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_acc_response_purchase_list ORDER BY resp_name ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                if($row_data->resp_id==$row_old_data->ch_responsible_purchase) 
                                                    echo '<option SELECTED value="'.$row_data->resp_id.'">'.$row_data->resp_name.'</option>';
                                                    echo '<option value="'.$row_data->resp_id.'">'.$row_data->resp_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                    <label>Responsible Purchase :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" autocomplete="off" name="txt_amo_req" value="<?= $row_old_data->ch_amount_request ?>">
                                    <label>Amount Request :
                                        <span aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_submit" class="btn green"><i class="fa fa-save fa-fw"></i>Save</button>
                                <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>


<?php include_once '../layout/footer.php' ?>
