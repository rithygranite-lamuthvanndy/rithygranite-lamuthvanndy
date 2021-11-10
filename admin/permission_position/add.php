<?php 
    $menu_active =5;
    $layout_title = "Add User Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_add_user'])){
        $v_name = @$_POST['txt_name'];
        $v_password = @$_POST['txt_password'];
        $v_confirm_password = @$_POST['txt_confirm_password'];
        $v_email = @$_POST['txt_email'];
        $v_gender = @$_POST['txt_gender'];
        $v_position = @$_POST['txt_position'];
        $v_status = @$_POST['txt_status'];
        $v_note = @$_POST['txt_note'];
        if($v_password == $v_confirm_password){
            
            $v_photo = @$FILES['txt_photo'];
            // var_dump($v_photo);
            if($v_photo["name"] != ""){
                echo "Yes";
            }else{
                $v_photo_name = "blank.png";
            }

            $query_add = "INSERT INTO tbl_user (user_name,user_password,user_email,user_photo,user_gender,user_status,user_position,user_note) 
                VALUES('$v_name','$v_password','$v_email','$v_photo_name','$v_gender','$v_status','$v_position','$v_note')";
            if($connect->query($query_add)){
                $sms = '<div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Successfull!</strong> Data inserted ...
                </div>';
                // header("Refresh:2; url=index.php");   
            }else{
                $sms = '<div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Error!</strong> Query error ...
                </div>';
                // header("Refresh:0; url=add.php");    
            }
        }else{
            $sms = '<div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> Password and Confirm not match ...
            </div>';
        }



    }

 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-user fa-fw"></i>Create New User</h2>
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
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_name" placeholder="Enter your name" required="required" autocomplete="off">
                                    <label>Username
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <span class="help-block">Enter your name...</span>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_email" placeholder="Enter your email" required="required" autocomplete="off">
                                    <label>Email
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <span class="help-block">Enter your email...</span>
                                </div>
                                 <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_password" placeholder="Repeat your password" required="required" autocomplete="off">
                                    <label>Password
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <span class="help-block">Enter your password...</span>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <input type="password" class="form-control" name="txt_confirm_password" placeholder="Enter your password" required="required" autocomplete="off">
                                    <label>Confirm Password
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <span class="help-block">Enter your password again...</span>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <input type="file" class="form-control" name="txt_photo" placeholder="Enter your password">
                                    <label>Photo </label>
                                    <span class="help-block">Choose your photo...</span>
                                </div> 
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <select class="form-control" name="txt_gender" required="required">
                                        <option value="">=== Please Choose Gender ===</option>
                                        <?php 
                                            $gender = $connect->query("SELECT * FROM tbl_user_gender ORDER BY ug_id ASC");
                                            while ($row_gender = mysqli_fetch_object($gender)) {
                                                echo '<option value="'.$row_gender->ug_id.'">'.$row_gender->ug_name.'</option>';
                                            }
                                         ?>
                                    </select><span class="help-block help-block-error"></span>
                                    <label>Gender<span class="required" aria-required="true">*</span></label>
                                    <span class="help-block">Choose your gender here...</span>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <select class="form-control" name="txt_position" required="required">
                                        <option value="">=== Please Choose Position ===</option>
                                        <?php 
                                            $positon = $connect->query("SELECT * FROM tbl_user_position ORDER BY up_id ASC");
                                            while ($row_position = mysqli_fetch_object($positon)) {
                                                echo '<option value="'.$row_position->up_id.'">'.$row_position->up_name.'</option>';
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
                                                echo '<option value="'.$row_status->us_id.'">'.$row_status->us_name.'</option>';
                                            }
                                         ?>
                                    </select><span class="help-block help-block-error"></span>
                                    <label>Status <span class="required" aria-required="true">*</span></label>
                                    <span class="help-block">Choose your Status here...</span>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <textarea class="form-control" name="txt_note" style="height: 125px;" placeholder="Enter user note" autocomplete="off"></textarea>
                                    <label>Note </label>
                                    <span class="help-block">Enter something about user...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_add_user" class="btn blue"><i class="fa fa-plus fa-fw"></i>Add</button>
                                <button type="reset" class="btn yellow"><i class="fa fa-eraser fa-fw"></i>Reset</button>
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
