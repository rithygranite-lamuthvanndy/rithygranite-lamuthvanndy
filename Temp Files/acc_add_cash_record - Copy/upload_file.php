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
        $v_doc_id = @$_GET['doc_id'];
        if($v_image["name"] != ""){
            $new_name = date("Ymd")."_".rand(1111,9999).$v_image["name"];
            move_uploaded_file($v_image["tmp_name"], "../../img/img_company_list/".$new_name);


            // delete 
            $old_img = @$_GET['old_img'];
            if($old_img != ""){
                if(file_exists("../../img/img_company_list/".$old_img)){
                    unlink("../../img/img_company_list/".$old_img);
                }
            }


            $connect->query("UPDATE tbl_ct_company SET ctcom_logo='$new_name' WHERE ctcom_id='$v_doc_id'");
            header("location: list_attach.php.php");
        }else{
            $sms = '<div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> Please Choose Image ...
                </div>';
        }
    }

// get old data 
    $edit_id = @$_GET['edit_id'];
    $old_data = $connect->query("SELECT * FROM tbl_doc_document WHERE docdoc_id='$edit_id'");
    $row_old_data = mysqli_fetch_object($old_data);

    
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
                 <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-body">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_title"  autocomplete="off">
                                    <label>Title :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <input required="" type="file" class="form-control" name="txt_file" placeholder="date record..."  autocomplete="off">
                                    <label>Upload File :
                                        <span class="required" aria-required="true"></span>
                                    </label>

                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" name="btn_submit" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
                                    <a href="list_attach.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
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
