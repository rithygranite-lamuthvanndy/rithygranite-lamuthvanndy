<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        
        $v_id = @$_POST['txt_id'];
        $v_name = @$_POST['txt_name'];
        $v_note = @$_POST['txt_note'];
        $v_phone = @$_POST['txt_phone'];
        $v_address = @$_POST['txt_address'];
        $v_email = @$_POST['txt_email'];
        
       
        $query_update = "UPDATE `tbl_acc_other_rec_from_list` 
            SET 
                `name`='$v_name',
                `phone_number`='$v_phone',
                `address`='$v_address',
                `note`='$v_note',
                `email`='$v_email',
                `user_id`='$user_id'
            WHERE `id`='$v_id'";
            
       
        if($connect->query($query_update)){
             echo '<script>myAlertSuccess("Update")</script>';
        }else{
            echo '<script>myAlertError("Error")</script>'; 
        }
    }


// get old data 
    $edit_id = @$_GET['edit_id'];
    $old_data = $connect->query("SELECT * FROM tbl_acc_other_rec_from_list WHERE id='$edit_id'");
    $row_old_data = mysqli_fetch_object($old_data);


 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
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
            <h3 class="panel-title">Input Information</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Other Received From Name :
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <input type="text" value="<?= $row_old_data->name ?>" name="txt_name" class="form-control" required="">
                                <br>
                                <label>Email:
                                    <span aria-required="true">*</span>
                                </label>
                                <input type="text" value="<?= $row_old_data->email ?>" name="txt_email" class="form-control">
                                <br>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Phone Number :
                                    <span aria-required="true">*</span>
                                </label>
                                <input type="text" id="mask_phone" value="<?= $row_old_data->phone_number ?>" name="txt_phone" class="form-control">
                                <br>

                                <label>Address: 
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <textarea name="txt_address" rows="2" class="form-control"><?= $row_old_data->address ?></textarea>
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                 <label>Note
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <textarea name="txt_note" rows="4" class="form-control"><?= $row_old_data->note ?></textarea>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
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



<script type="text/javascript" src="../../plugin/ckeditor_4.7.0_full/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace( 'detail', {
        language: 'en',
      height: '700'
        // uiColor: '#9AB8F3'
    });
</script>


<?php include_once '../layout/footer.php' ?>
