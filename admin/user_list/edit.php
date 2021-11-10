<?php 
    $menu_active =10;
    $left_menu =4;
    $layout_title = "Add User Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php

    // btn update 
    if(isset($_POST['btn_update'])){
        $v_id = @$_POST['txt_id'];
        $v_id_number    = $connect->real_escape_string(@$_POST['txt_id_number']);
        $v_first_name   = $connect->real_escape_string(@$_POST['txt_first_name']);
        $v_last_name    = $connect->real_escape_string(@$_POST['txt_last_name']);
        $v_user_name    = $connect->real_escape_string(@$_POST['txt_user_name']);
        $v_gender       = $connect->real_escape_string(@$_POST['txt_gender']);
        $v_phone        = $connect->real_escape_string(@$_POST['txt_phone']);
        $v_email        = $connect->real_escape_string(@$_POST['txt_email']);
        $v_address      = $connect->real_escape_string(@$_POST['txt_address']);
        $v_position     = $connect->real_escape_string(@$_POST['txt_position']);
        $v_agency       = $connect->real_escape_string(@$_POST['txt_agency']);
        $v_password     = $connect->real_escape_string(@$_POST['txt_password']);
        $v_status       = $connect->real_escape_string(@$_POST['txt_status']);
        $v_note         = $connect->real_escape_string(@$_POST['txt_note']);
   

        $query_update = "UPDATE tbl_user SET    
            user_code='$v_id_number',
            user_first_name='$v_first_name',
            user_last_name='$v_last_name',
            user_name='$v_user_name',
            user_gender='$v_gender',
            user_phone_number='$v_phone',
            user_email='$v_email',
            user_position='$v_position',
            user_password='$v_password',
            user_status='$v_status',
            user_note='$v_note' WHERE user_id='$v_id'";
        if($connect->query($query_update)){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data was updated ...
            </div>'; 
            echo '<script> window.location.replace("index.php");</script>';
        }else{
            $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error! </strong> '.mysqli_error($connect).'
            </div>'; 
        }
    }

    // get old data  
    if(@$_GET['edit_id']!=""){
        $edit_id = @$_GET['edit_id'];
        $old_data = $connect->query("SELECT * FROM tbl_user WHERE user_id='$edit_id'");
        $row_user = mysqli_fetch_object($old_data);
    }


 ?>


<div class="portlet light bordered">
    <div class="portlet-body">
        <?= @$sms ?>
        <div class="portlet light bordered" id="form_wizard_1" style="position: relative;">
           
            <div class="portlet-body form">
                <form class="form-horizontal" action="#" id="submit_form" method="POST" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" name="txt_id" value="<?= $row_user->user_id ?>">
                    <div class="form-wizard">
                        <div class="form-body">
                            <ul class="nav nav-pills nav-justified steps">
                                <li>
                                    <a href="#tab1" data-toggle="tab" class="step">
                                        <span class="number"> 1 </span>
                                        <span class="desc">
                                            <i class="fa fa-check"></i> Basic </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#tab2" data-toggle="tab" class="step">
                                        <span class="number"> 2 </span>
                                        <span class="desc">
                                            <i class="fa fa-check"></i> Position </span>
                                    </a>
                                </li>
                            </ul>
                            <div id="bar" class="progress progress-striped" role="progressbar">
                                <div class="progress-bar progress-bar-success"> </div>
                            </div>
                            <div class="tab-content">
                                <div class="alert alert-danger display-none">
                                    <button class="close" data-dismiss="alert"></button> You have some form errors. Please check below. </div>
                                <div class="alert alert-success display-none">
                                    <button class="close" data-dismiss="alert"></button> Your form validation is successful! </div>
                                <div class="tab-pane active" id="tab1">
                                    <div class="col-xs-2"></div>
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label>ID Number <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" name="txt_id_number" required="required" value="<?= $row_user->user_code ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>First Name <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" name="txt_first_name" required="required" value="<?= $row_user->user_first_name ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Last Name <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" name="txt_last_name" required="required" value="<?= $row_user->user_last_name ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>User Name <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" name="txt_user_name" required="required"  value="<?= $row_user->user_name ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label>Gender <span style="color: red;">*</span></label>
                                                <select class="form-control" name="txt_gender" required="required">
                                                    <option value="">=== Please Choose Gender ===</option>
                                                    <?php 
                                                        $gender = $connect->query("SELECT * FROM tbl_user_gender ORDER BY ug_id ASC");
                                                        while ($row_gender = mysqli_fetch_object($gender)) {
                                                            if($row_gender->ug_id == $row_user->user_gender)
                                                                echo '<option SELECTED value="'.$row_gender->ug_id.'">'.$row_gender->ug_name.'</option>';
                                                            else
                                                                echo '<option value="'.$row_gender->ug_id.'">'.$row_gender->ug_name.'</option>';
                                                        }
                                                     ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Phone <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" name="txt_phone" required="required" value="<?= $row_user->user_phone_number ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" name="txt_email" required="required" value="<?= $row_user->user_email ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Address </label>
                                                <textarea style="height: 35px;" class="form-control" name="txt_address"><?= $row_user->user_address ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="tab-pane" id="tab2">
                                    <div class="col-xs-2"></div>
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label>Position <span style="color: red;">*</span></label>
                                                <select class="form-control selectpicker" name="txt_position" required="required" data-live-search="true">
                                                    <option value="">=== Please Choose Position ===</option>
                                                    <?php 
                                                        $positon = $connect->query("SELECT * FROM tbl_user_position ORDER BY up_id ASC");
                                                        while ($row_position = mysqli_fetch_object($positon)) {
                                                            if($row_position->up_id == $row_user->user_position)
                                                                echo '<option SELECTED value="'.$row_position->up_id.'">'.$row_position->up_name.'</option>';
                                                            else
                                                                echo '<option value="'.$row_position->up_id.'">'.$row_position->up_name.'</option>';
                                                        }
                                                     ?>
                                                </select><span class="help-block help-block-error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Password <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" name="txt_password" required="required" value="<?= $row_user->user_password ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label>Status <span style="color: red;">*</span></label>
                                                <select class="form-control" name="txt_status" required="required">
                                                    <option value="">=== Please Choose Status ===</option>
                                                    <?php 
                                                        $status = $connect->query("SELECT * FROM tbl_user_status_add ORDER BY us_id ASC");
                                                        while ($row_status = mysqli_fetch_object($status)) {
                                                            if($row_status->us_id == $row_user->user_status)
                                                                echo '<option SELECTED value="'.$row_status->us_id.'">'.$row_status->us_name.'</option>';
                                                            else
                                                                echo '<option value="'.$row_status->us_id.'">'.$row_status->us_name.'</option>';
                                                        }
                                                     ?>
                                                </select><span class="help-block help-block-error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Note </label>
                                                <textarea style="height: 113px;" type="text" class="form-control" name="txt_note"><?= $row_user->user_note ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="text-center">
                                    <a href="index.php" class="btn red"><i class="fa fa-arrow-left"></i> Back</a>
                                    <a href="javascript:;" class="btn default button-previous">
                                        <i class="fa fa-angle-left"></i> Previous </a>
                                    <a href="javascript:;" class="btn btn-outline green button-next"> Continue
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                    <button type="submit" name="btn_update" class="btn green button-submit"> Save Change
                                        <i class="fa fa-check"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>






<?php include_once '../layout/footer.php' ?>
