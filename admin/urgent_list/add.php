<?php 
    $menu_active =2;
    $layout_title = "Add Slider Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_add'])){
        
        
            
            $v_title = @$connect->real_escape_string($_POST['txt_title']);
            $v_description = @$connect->real_escape_string($_POST['txt_description']);
            $v_user_id = @$_SESSION['user']->user_id;

            $query_add = "INSERT INTO tbl_view_info_type (
                    vit_name,
                    vit_note,
                    vit_user_id) 
                VALUES(
                    '$v_title',
                    '$v_description',
                    '$v_user_id')";
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
                                    <input type="text" class="form-control" name="txt_title" required="required" autocomplete="off">
                                    <label>Title
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <textarea style="height: 123px;" class="form-control" name="txt_description" required="required" autocomplete="off"></textarea>
                                    <label>Description
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                            <hr><hr>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_add" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
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
