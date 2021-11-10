<?php 
    $menu_active =120;
    $left_active =0;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        $v_id = @$_POST['txt_id'];
        $v_old_file = @$_POST['txt_old_file'];
        $v_file = @$_FILES['txt_file'];
        if($v_file["name"] != ""){
            $new_name = date("Ymd")."_".rand(1111,9999)."_".$v_file["name"];
            $new_name = preg_replace("/ /", "_", $new_name);
            if(move_uploaded_file($v_file["tmp_name"], "../../file/file_customer_invoice/".$new_name)){
                if(file_exists("../../file/file_customer_invoice/".$v_old_file)){
                    unlink("../../file/file_customer_invoice/".$v_old_file);
                }
            }else{
                $new_name = $v_old_file;
            }
        }else{
            $new_name = $v_old_file;
        }
        $query_update = "UPDATE `tbl_cus_invoice` 
            SET 
                `cusin_attach_file`='$new_name'
            WHERE `cusin_id`='$v_id'";
            
       
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
        header('location: index.php');
    }


// get old data 
    $old_id = @$_GET['up_id'];
    $old_file = @$_GET['old_file'];

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
            <h3 class="panel-title">Edit Information</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt_id" value="<?= $old_id ?>">
                    <input type="hidden" name="txt_old_file" value="<?= $old_file ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Upload File : </label>
                                    <input type="file" class="form-control datepicker" name="txt_file" placeholder="choose file" required="">
                                </div>
                                
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
<?php include_once '../layout/footer.php' ?>
