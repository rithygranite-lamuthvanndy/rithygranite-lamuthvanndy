<?php 
    $menu_active =2;
    $layout_title = "Edit News Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_add'])){
        $v_image = @$_FILES['txt_image'];
        $v_id = @$_POST['txt_id'];
        $v_title = @$connect->real_escape_string($_POST['txt_title']);
        $v_description = @$connect->real_escape_string($_POST['txt_description']);
        $v_detail = @$connect->real_escape_string($_POST['txt_detail']);
        if($v_image["name"] != ""){
            $old_image = @$_POST['txt_old_img'];
            if(file_exists("../../img/img_news/".$old_image)){
                unlink("../../img/img_news/".$old_image);
            }

            $new_name = date("Ymd")."_".rand(1111,9999)."_".$v_image["name"];
            move_uploaded_file($v_image["tmp_name"], "../../img/img_news/".$new_name);

            $query_update = "UPDATE tbl_news SET
                    news_title_en='$v_title',
                    news_image='$new_name',
                    news_description_en='$v_description',
                    news_detail_en='$v_detail' WHERE news_id='$v_id'";
            
        }else{
            $query_update = "UPDATE tbl_news SET
                    news_title_en='$v_title',
                    news_description_en='$v_description',
                    news_detail_en='$v_detail' WHERE news_id='$v_id'";
        }
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
    }


// get old data 
    $edit_id = @$_GET['edit_id'];
    $edit_img = @$_GET['edit_img'];
    $old_slider = $connect->query("SELECT * FROM tbl_news WHERE news_id='$edit_id'");
    $row_old_slider = mysqli_fetch_object($old_slider);


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
                <h3 class="panel-title">Input Information</h3>
            </div>
            <div class="panel-body">
                 <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt_id" value="<?= @$row_old_slider->news_id ?>">
                    <input type="hidden" name="txt_old_img" value="<?= @$row_old_slider->news_image ?>">
                    <div class="form-body">
                        <img width="100%" src="../../img/img_news/<?= @$row_old_slider->news_image ?>" class="img-responsive img-responsive img-thumbnail" alt="Image"><br><br><br>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_title" placeholder="Enter your name" required="required" autocomplete="off" value="<?= @$row_old_slider->news_title_en ?>">
                                    <label>Title
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <span class="help-block">Enter Slider Title...</span>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <input type="file" class="form-control" name="txt_image" placeholder="Enter your email" autocomplete="off">
                                    <label>Image
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <span class="help-block">Enter Slider Image...</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <textarea style="height: 123px;" class="form-control" name="txt_description" placeholder="Repeat your password" required="required" autocomplete="off"><?= @$row_old_slider->news_description_en ?></textarea>
                                    <label>Description
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <span class="help-block">Enter Slider Summary Description...</span>
                                </div>
                            </div>
                            <hr><hr><hr><br>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group form-md-line-input">
                                    <textarea style="height: 290px;" class="form-control detail" id="detail" name="txt_detail" placeholder="Repeat your password" required="required" autocomplete="off"><?= @$row_old_slider->news_detail_en ?></textarea>
                                    <label>Detail
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <span class="help-block">Enter Slider Detail...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_add" class="btn green"><i class="fa fa-check fa-fw"></i>Update</button>
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



<script type="text/javascript" src="../../plugin/ckeditor_4.7.0_full/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace( 'detail', {
        language: 'en',
      height: '700'
        // uiColor: '#9AB8F3'
    });
</script>


<?php include_once '../layout/footer.php' ?>
