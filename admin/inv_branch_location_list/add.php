<?php 
    $menu_active =145;
    $left_active =0;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(@$_GET['status']=='true'){
         echo '<script>myAlertSuccess("Adding")</script>';
    }

    if(isset($_POST['btn_submit_new'])){
        $v_name = @$_POST['txt_name'];
        $v_note = @$_POST['txt_note'];
        $v_address = @$_POST['txt_address'];
        $v_user_id = @$_SESSION['user']->user_id;
        

        $query_add = "INSERT INTO tbl_inv_branch_location_list (
                name,
                address,
                note,
                user_id                
                ) 
            VALUES(
                '$v_name',
                '$v_address',
                '$v_note',
                '$v_user_id'
                )";
        if($connect->query($query_add)){
           $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data inserted ...
            </div>'; 
        }else{
           $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> '.mysqli_error($connect).'
            </div>';  
        }
    }
    if(isset($_POST['btn_submit_close'])){
        $v_name = @$_POST['txt_name'];
        $v_note = @$_POST['txt_note'];
        $v_address = @$_POST['txt_address'];
        $v_user_id = @$_SESSION['user']->user_id;
        

        $query_add = "INSERT INTO  tbl_inv_branch_location_list (
                name,
                address,
                note,
                user_id                
                ) 
            VALUES(
                '$v_name',
                '$v_address',
                '$v_note',
                '$v_user_id'
                )";
        // echo $query_add;
        if($connect->query($query_add)){
           $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data inserted ...
            </div>'; 
        }else{
           $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> '.mysqli_error($connect).'
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
                                <div class="form-group">
                                    <label>Name : </label>
                                    <input type="text" class="form-control" name="txt_name" required=""  autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Address : </label>
                                    <textarea type="text" class="form-control" name="txt_address" style="height: 80px;" autocomplete="off"></textarea>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Note : </label>
                                    <textarea type="text" class="form-control" name="txt_note" rows="7" autocomplete="off"></textarea>
                                </div>

                            </div>
                        </div>

                        
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_submit_new" class="btn blue"><i class="fa fa-save fa-fw"></i>Save & New</button>
                                <button type="submit" name="btn_submit_close" class="btn yellow"><i class="fa fa-save fa-fw"></i>Save & Close</button>
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
