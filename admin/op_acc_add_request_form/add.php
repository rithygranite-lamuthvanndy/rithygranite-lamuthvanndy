<?php 
    $menu_active =13;
    $left_active =0;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        $v_date = @$_POST['txt_date'];
        $v_number = @$_POST['txt_number'];
        $v_re_name = @$_POST['cbo_re_name'];
        $v_pos = @$_POST['cbo_pos'];
        $v_pre_by = @$_POST['cbo_pre_by'];
        $v_check_by = @$_POST['cbo_check_by'];
        $v_appro_by = @$_POST['cbo_appro_by'];

        $query_add = "INSERT INTO tbl_acc_request_form (
                req_date,
                req_number,
                req_request_name,
                req_position,
                req_prepare_by,
                req_check_by,
                req_approved_by
                ) 
            VALUES
                (
                '$v_date',
                '$v_number',
                '$v_re_name',
                '$v_pos',
                '$v_pre_by',
                '$v_check_by',
                '$v_appro_by'
                )";

        if($connect->query($query_add)){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data inserted ...
            </div>'; 
        }else{
            $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> Query error ...
            </div>';   
        }
    }

 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Create Record</h2>
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
                    <div class="form-body">


                       <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" autocomplete="off" required name="txt_date" value="<?= date("Y-m-d") ?>">
                                    <label>Date :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" autocomplete="off" name="txt_number required="">
                                    <label>Number :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                   <select class="form-control" name="cbo_re_name" required="">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_acc_request_name_list ORDER BY res_id ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_data->res_id.'">'.$row_data->res_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                    <label>Request Name :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                   <select class="form-control" name="cbo_pos" required="">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_acc_position ORDER BY po_id ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_data->po_id.'">'.$row_data->po_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                    <label>Position :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <select class="form-control" name="cbo_pre_by"  autocomplete="off" required="">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_acc_prepare_name_list ORDER BY pren_id ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_data->pren_id.'">'.$row_data->pren_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                    <label>Prepared By :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <select class="form-control" name="cbo_check_by"  autocomplete="off" required="">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_acc_check_name_list ORDER BY chn_name ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_data->chn_id.'">'.$row_data->chn_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                    <label>Check By :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <select class="form-control" name="cbo_appro_by"  autocomplete="off" required="">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_acc_approved_name_list ORDER BY apn_name ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
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
                        
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <button type="submit" name="btn_submit" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
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
