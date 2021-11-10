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
        $v_assgin = @$_POST['txt_assign'];
        $v_note = @$_POST['txt_note'];
   

        $query_update = "UPDATE tbl_user_position SET    up_name='$v_name',
                                                up_assign='$v_assgin',
                                                up_note='$v_note'
                                                WHERE up_id='$v_id'";
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
        $old_data = $connect->query("SELECT * FROM tbl_user_position WHERE up_id='$edit_id'");
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
                    <input type="hidden" name="txt_id" value="<?= $row_user->up_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_name"  required="required" value="<?= $row_user->up_name ?>">
                                    <label>Position Name 
                                        <span class="required" aria-required="true">*</span>    
                                    </label>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_assign"  required="required" value="<?= $row_user->up_assign ?>">
                                    <label>Assign :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                                 <div class="form-group form-md-line-input">
                                    <textarea name="txt_note" id="input" class="form-control" rows="3"><?= $row_user->up_note ?></textarea>
                                    <label>Note :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_update_user" class="btn blue"><i class="fa fa-check fa-fw"></i>Update</button>
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
