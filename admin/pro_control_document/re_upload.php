<?php 
    $menu_active =150;
    $left_active =0;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>



<?php 
    if(isset($_POST['btn_submit'])){
        
        $v_id = @$_POST['txt_id'];

        $v_image = @$_FILES['txt_file'];
        $new_name = date("Ymd")."_".rand(1111,9999)."_".$v_image["name"];
        if(!move_uploaded_file($v_image["tmp_name"], "../../file/file_control_document/".$new_name)){
            $new_name = "";
        }else{
            $v_old_file = @$_POST['txt_old'];
            if($v_old_file){
                if(file_exists("../../file/file_control_document/".$v_old_file)){
                    unlink("../../file/file_control_document/".$v_old_file);
                }
            }
        }

       
        $query_update = "UPDATE tbl_pj_control_document SET 
                cdoc_attach='$new_name'
            WHERE cdoc_id='$v_id'";
        $connect->query($query_update);
        echo '<script> window.location.replace("index.php"); </script>';
    }


// get old data 
    $edit_id = @$_GET['edit_id'];
    $old_data = $connect->query("SELECT *,PCD.user_id AS id,PCD.date_audit AS audit FROM tbl_pj_control_document AS PCD
                        LEFT JOIN tbl_pj_project_title AS PPT ON PCD.cdoc_project_title=PPT.pti_id WHERE cdoc_id='$edit_id'");
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
            <h3 class="panel-title">Edit Information</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->cdoc_id ?>">
                    <input type="hidden" name="txt_old" value="<?= @$_GET['old'] ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Attach : </label>
                                    <input type="file" class="form-control" name="txt_file"  autocomplete="off" required="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <button type="submit" name="btn_submit" class="btn green"><i class="fa fa-save fa-fw"></i>Update</button>
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
