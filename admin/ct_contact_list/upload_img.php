<?php 
    $menu_active =5;
    $left_active =0;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        $v_image = @$_FILES['txt_file'];
        $v_cl_id = @$_GET['cl_id'];
        if($v_image["name"] != ""){
            $new_name = date("Ymd")."_".rand(1111,9999).".png";
            move_uploaded_file($v_image["tmp_name"], "../../img/img_contact_list/".$new_name);


            // delete 
            $old_img = @$_GET['old_img'];
            if($old_img != ""){
                if(file_exists("../../img/img_contact_list/".$old_img)){
                    unlink("../../img/img_contact_list/".$old_img);
                }
            }


            $connect->query("UPDATE tbl_ct_contact_list SET ctco_photo='$new_name' WHERE ctco_id='$v_cl_id'");
           header("location: index.php");
        }else{
            $sms = '<div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> Please Choose Image ...
                </div>';
        }
    }

 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Create Record </h2>
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
                 <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

                                <div class="form-group form-md-line-input">
                                    <input required="" type="file" class="form-control" name="txt_file" placeholder="date record..."  autocomplete="off">
                                    <label>Upload Image :
                                        <span class="required" aria-required="true"></span>
                                    </label>

                            </div>
                        </div>
                    </div>

                       

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_submit" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
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
