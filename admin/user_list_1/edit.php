<?php 
    $menu_active =5;
    $layout_title = "Add User Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php

    // btn update 
    if(isset($_POST['btn_update_user'])){
        $v_id = @$_POST['txt_id'];
        $v_name = @$_POST['txt_name'];
        $v_email = @$_POST['txt_email'];
        $v_gender = @$_POST['txt_gender'];
        $v_position = @$_POST['txt_position'];
        $v_status = @$_POST['txt_status'];
        $v_note = @$_POST['txt_note'];
   

        $query_update = "UPDATE tbl_user SET    user_name='$v_name',
                                                user_email='$v_email',
                                                user_gender='$v_gender',
                                                user_status='$v_status',
                                                user_position='$v_position',
                                                user_note='$v_note' WHERE user_id='$v_id'";
        if($connect->query($query_update)){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data was updated ...
            </div>'; 
        }else{
            $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> Query error ...
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
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-user fa-fw"></i>Edit User Information</h2>
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
                <h3 class="panel-title">Input User Information</h3>
            </div>
            <div class="panel-body">
                 <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt_id" value="<?= $row_user->user_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_name" placeholder="Enter your name" required="required" value="<?= $row_user->user_name ?>">
                                    <label>Username
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <span class="help-block">Enter your name...</span>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_email" placeholder="Enter your email" required="required" value="<?= $row_user->user_email ?>">
                                    <label>Email
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <span class="help-block">Enter your email...</span>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <select class="form-control" name="txt_gender" required="required">
                                        <option value="">=== Please Choose Gender ===</option>
                                        <?php 
                                            $gender = $connect->query("SELECT * FROM tbl_user_gender ORDER BY ug_id ASC");
                                            while ($row_gender = mysqli_fetch_object($gender)) {
                                                if($row_gender->ug_id==$row_user->user_gender){
                                                    echo '<option SELECTED="SELECTED" value="'.$row_gender->ug_id.'">'.$row_gender->ug_name.'</option>'; 
                                                }else{
                                                    echo '<option value="'.$row_gender->ug_id.'">'.$row_gender->ug_name.'</option>';
                                                }
                                            }
                                         ?>
                                    </select><span class="help-block help-block-error"></span>
                                    <label>Gender<span class="required" aria-required="true">*</span></label>
                                    <span class="help-block">Choose your gender here...</span>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <select class="form-control" name="txt_position" required="required">
                                        <?php 
                                            $positon = $connect->query("SELECT * FROM tbl_user_position");
                                            while ($row_position = mysqli_fetch_object($positon)) {
                                                if($row_position->up_id==$row_user->user_position){
                                                    echo '<option SELECTED="SELECTED" value="'.$row_position->up_id.'">'.$row_position->up_name.'</option>';
                                                }else{
                                                    echo '<option value="'.$row_position->up_id.'">'.$row_position->up_name.'</option>';
                                                }
                                            }
                                         ?>
                                    </select><span class="help-block help-block-error"></span>
                                    <label>Position<span class="required" aria-required="true">*</span></label>
                                    <span class="help-block">Choose your position here...</span>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <select class="form-control" name="txt_status" required="required">
                                        <option value="">=== Please Choose Status ===</option>
                                        <?php 
                                            $status = $connect->query("SELECT * FROM tbl_user_status ORDER BY us_id ASC");
                                            while ($row_status = mysqli_fetch_object($status)) {
                                                if($row_status->us_id==$row_user->user_status){
                                                    echo '<option SELECTED="SELECTED" value="'.$row_status->us_id.'">'.$row_status->us_name.'</option>';
                                                }else{
                                                    echo '<option value="'.$row_status->us_id.'">'.$row_status->us_name.'</option>';
                                                }
                                            }
                                         ?>
                                    </select><span class="help-block help-block-error"></span>
                                    <label>Status <span class="required" aria-required="true">*</span></label>
                                    <span class="help-block">Choose your Status here...</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                
                                
                                
                                <div class="form-group form-md-line-input">
                                    <textarea class="form-control" name="txt_note" style="height: 390px;" placeholder="Enter user note"><?= $row_user->user_note ?></textarea>
                                    <label>Note </label>
                                    <span class="help-block">Enter something about user...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_update_user" class="btn blue"><i class="fa fa-check fa-fw"></i>Save</button>
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
