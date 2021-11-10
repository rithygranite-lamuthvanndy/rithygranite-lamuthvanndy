<?php 
    $menu_active =13;
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
        $v_in_no = @$_POST['txt_invoice_no'];
        $v_res_name = @$_POST['cbo_res_name'];
        $v_pos = @$_POST['cbo_pos'];
        $v_pre = @$_POST['txt_pre'];
        $v_check = @$_POST['cbo_check'];
        $v_appr = @$_POST['txt_appr'];
        
       
        $query_update = "UPDATE `tbl_acc_request_form` 
            SET 
                req_date='$v_date',
                req_number='$v_in_no',
                req_request_name='$v_res_name',
                req_position='$v_pos',
                req_prepare_by='$v_pre',
                req_check_by='$v_check',
                req_approved_by='$v_appr'
            WHERE `req_id`='$v_id'";
                            
       
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
    $old_data = $connect->query("SELECT * FROM tbl_acc_request_form WHERE req_id='$edit_id'");
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
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->req_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Date Record :
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" value="<?= $row_old_data->req_date ?>" name="txt_date" class="form-control" required="">
                                <br>
                                <br>

                                <label>Number :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <input type="text" value="<?= $row_old_data->req_number ?>" name="txt_invoice_no" class="form-control">
                                <br>

                                <label>Request Name :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <select class="form-control" name="cbo_res_name">
                                    <option value="">=== Please choose and select ===</option>
                                    <?php 
                                        $v_select = $connect->query("SELECT * FROM tbl_acc_request_name_list ORDER BY res_name ASC");
                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                            if($row_data->res_id == @$row_old_data->req_request_name){
                                                echo '<option SELECTED value="'.$row_data->res_id.'">'.$row_data->res_name.'</option>';
                                                
                                            }else{
                                                echo '<option value="'.$row_data->res_id.'">'.$row_data->res_name.'</option>';

                                            }
                                        }
                                     ?>
                                </select>
                                <br>

                                <label>Position :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <select class="form-control" name="cbo_pos">
                                    <option value="">=== Please choose and select ===</option>
                                    <?php 
                                        $v_select = $connect->query("SELECT * FROM tbl_acc_position ORDER BY po_name ASC");
                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                            if($row_data->po_id == @$row_old_data->req_position){
                                                echo '<option SELECTED value="'.$row_data->po_id.'">'.$row_data->po_name.'</option>';
                                                
                                            }else{
                                                echo '<option value="'.$row_data->po_id.'">'.$row_data->po_name.'</option>';

                                            }
                                        }
                                     ?>
                                </select>
                                <br>

                                <label>Check By :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <select class="form-control" name="cbo_check">
                                    <option value="">=== Please choose and select ===</option>
                                    <?php 
                                        $v_select = $connect->query("SELECT * FROM tbl_acc_check_name_list ORDER BY chn_name ASC");
                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                            if($row_data->chn_id == @$row_old_data->req_check_by){
                                                echo '<option SELECTED value="'.$row_data->chn_id.'">'.$row_data->chn_name.'</option>';
                                                
                                            }else{
                                                echo '<option value="'.$row_data->chn_id.'">'.$row_data->chn_name.'</option>';

                                            }
                                        }
                                     ?>
                                </select>
                                <br>

                                <label>Prepare By :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <select class="form-control" name="txt_pre">
                                    <option value="">=== Please choose and select ===</option>
                                    <?php 
                                        $v_select = $connect->query("SELECT * FROM tbl_acc_prepare_name_list ORDER BY pren_name ASC");
                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                            if($row_data->pren_id == @$row_old_data->req_prepare_by){
                                                echo '<option SELECTED value="'.$row_data->pren_id.'">'.$row_data->pren_name.'</option>';
                                                
                                            }else{
                                                echo '<option value="'.$row_data->pren_id.'">'.$row_data->pren_name.'</option>';

                                            }
                                        }
                                     ?>
                                </select>
                                <br>
                                 <label>Approved By :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <select class="form-control" name="txt_appr">
                                    <option value="">=== Please choose and select ===</option>
                                    <?php 
                                        $v_select = $connect->query("SELECT * FROM tbl_acc_approved_name_list ORDER BY apn_name ASC");
                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                            if($row_data->apn_id == @$row_old_data->req_approved_by){
                                                echo '<option SELECTED value="'.$row_data->apn_id.'">'.$row_data->apn_name.'</option>';
                                                
                                            }else{
                                                echo '<option value="'.$row_data->apn_id.'">'.$row_data->apn_name.'</option>';

                                            }
                                        }
                                     ?>
                                </select>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-6 text-center">
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



<script type="text/javascript" src="../../plugin/ckeditor_4.7.0_full/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace( 'detail', {
        language: 'en',
      height: '700'
        // uiColor: '#9AB8F3'
    });
</script>


<?php include_once '../layout/footer.php' ?>
