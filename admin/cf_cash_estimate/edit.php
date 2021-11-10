<?php 
    $menu_active =5;
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
        $v_amount = @$_POST['txt_amount'];
        $v_description = @$_POST['txt_description'];
        $v_month_year = @$_POST['txt_month_year'];
        $v_category = @$_POST['txt_category'];
        $v_type = @$_POST['txt_type'];
        $v_user_id = @$_SESSION['user']->user_id;
        
       
        $query_update = "UPDATE `tbl_cf_cash_estimate` 
            SET 
                `cfce_date_record`='$v_date',
                `cfce_month_year`='$v_month_year',
                `cfce_description`='$v_description',
                `cfce_category`='$v_category',
                `cfce_type`='$v_type',
                `cfce_amount`='$v_amount',
                `user_id`='$v_user_id'
            WHERE `cfce_id`='$v_id'";
            
       
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
    $old_data = $connect->query("SELECT * FROM tbl_cf_cash_estimate WHERE cfce_id='$edit_id'");
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
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->cfce_id ?>">
                                        <div class="form-body">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="">
                                    <label>Date :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                        <input type="text" class="form-control" value="<?= $row_old_data->cfce_date_record ?>" required="" name="txt_date">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div><br>
                                <div class="">
                                    <label>Amount :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                    <input type="text" value="<?= $row_old_data->cfce_amount ?>" class="form-control" name="txt_amount"  required="" autocomplete="off">
                                </div><br>
                                <div class="">
                                    <label>Description :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                    <textarea class="form-control" rows="3" name="txt_description"  required="" autocomplete="off"><?= $row_old_data->cfce_description ?></textarea>
                                </div><br>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="">
                                    <label>Month Year :<span class="required" aria-required="true">*</span></label>
                                    <select class="form-control" name="txt_month_year" required="">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_cf_monthyear_list ORDER BY cfmy_name ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                if($row_data->cfmy_id == @$row_old_data->cfce_month_year){
                                                    echo '<option SELECTED value="'.$row_data->cfmy_id.'">'.$row_data->cfmy_name.'</option>';
                                                    
                                                }else{
                                                    echo '<option value="'.$row_data->cfmy_id.'">'.$row_data->cfmy_name.'</option>';

                                                }
                                            }
                                         ?>
                                    </select>
                                </div><br>
                                <div class="">
                                    <label>Category :<span class="required" aria-required="true">*</span></label>
                                    <select class="form-control" name="txt_category" required="">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_cf_category_list ORDER BY cfcl_name ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                if($row_data->cfcl_id == @$row_old_data->cfce_category){
                                                    echo '<option SELECTED value="'.$row_data->cfcl_id.'">'.$row_data->cfcl_name.'</option>';
                                                }else{
                                                    echo '<option value="'.$row_data->cfcl_id.'">'.$row_data->cfcl_name.'</option>';

                                                }
                                            }
                                         ?>
                                    </select>
                                </div><br>
                                <div class="">
                                    <label>Type :<span class="required" aria-required="true">*</span></label>
                                    <select class="form-control" name="txt_type" required="">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_cf_type_list ORDER BY cftl_name ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                if($row_data->cftl_id == @$row_old_data->cfce_type){
                                                    echo '<option SELECTED value="'.$row_data->cftl_id.'">'.$row_data->cftl_name.'</option>';
                                                }else{
                                                    echo '<option value="'.$row_data->cftl_id.'">'.$row_data->cftl_name.'</option>';

                                                }
                                            }
                                         ?>
                                    </select>
                                </div><br>
                            </div>
                        </div>
                        <br>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" name="btn_submit" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
                                    <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>



<?php include_once '../layout/footer.php' ?>
