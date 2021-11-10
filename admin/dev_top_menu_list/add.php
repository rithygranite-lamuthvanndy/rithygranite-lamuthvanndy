<?php 
    $menu_active =12;
    $left_menu_active=1;
    $layout_title = "Add Top Menu";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    if(@($_GET['view']=='iframe')){
        include_once '../layout/header_frame.php';
    }
    else{
        include_once '../layout/header.php';
    }
?> 
<?php 
    if(isset($_POST['btn_submit'])){
        $v_name = @$_POST['txt_name'];
        $v_directory = @$_POST['txt_directory'];
        $v_order = @$_POST['txt_order'];
        

        $query_add = "INSERT INTO tbl_main_menu (
                mm_name,
                mm_directory,
                mm_index_order                
                ) 
            VALUES(
                '$v_name',
                '$v_directory',
                '$v_order'
                )";
        if($connect->query($query_add)){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong>  Adding Record ...
            </div>'; 
        }else{
            $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong>   '.mysqli_error($connect).'
            </div>'; 
        }
    }

 ?>


<div class="portlet light bordered">
    <div class="row">
        <?= @$sms ?>
        <div class="col-xs-12">
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
                                    <label>Top Menu Name : </label>
                                    <input type="text" class="form-control" name="txt_name" required=""  autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Top Menu Directory : </label>
                                    <input type="text" class="form-control" name="txt_directory" required=""  autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Top Menu Order : </label>
                                    <input type="number" step="1" min="1" class="form-control" name="txt_order"  autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <button type="submit" name="btn_submit" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
                                <a href="index.php?view=<?= @$_GET['view'] ?>" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>
<?php 
    if(@$_GET['view']=='iframe')
        include_once '../layout/footer_frame.php';
    else
        include_once '../layout/footer.php';
 ?>