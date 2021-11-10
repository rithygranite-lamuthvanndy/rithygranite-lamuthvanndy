<?php 
    $menu_active =2;
    $layout_title = "Edit Slider Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>

 
<?php 
    if(isset($_POST['btn_add'])){
        $v_image = @$_FILES['txt_image'];
        $v_id = @$_POST['txt_id']; 

        $v_egc_type = @$connect->real_escape_string($_POST['txt_egc_type']);
        $v_category = @$connect->real_escape_string($_POST['txt_category']);
        $v_title = @$connect->real_escape_string($_POST['txt_title']);
        $v_price = @$connect->real_escape_string($_POST['txt_price']);
        $v_user_id = @$_SESSION['user']->user_id;

        if($v_image["name"] != ""){
            $old_image = @$_POST['txt_old_img'];
            if(file_exists("../../img/img_web_view/".$old_image)){
                unlink("../../img/img_web_view/".$old_image);
            }

            $new_name = date("Ymd")."_".rand(1111,9999)."_".$v_image["name"];
            move_uploaded_file($v_image["tmp_name"], "../../img/img_web_view/".$new_name);

            $query_update = "UPDATE tbl_view_info SET
                    vinfo_contact_no='$v_egc_type',
                    vinfo_type_id='$v_category',
                    vinfo_title='$v_title',
                    vinfo_image='$new_name',
                    vinfo_price_show='$v_price',
                    vinfo_user_id='$v_user_id' WHERE vinfo_id='$v_id'";
            
        }else{
            $query_update = "UPDATE tbl_view_info SET
                    vinfo_contact_no='$v_egc_type',
                    vinfo_type_id='$v_category',
                    vinfo_title='$v_title',
                    vinfo_price_show='$v_price',
                    vinfo_user_id='$v_user_id'  WHERE vinfo_id='$v_id'";
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
    $old_slider = $connect->query("SELECT * FROM tbl_view_info WHERE vinfo_id='$edit_id'");
    $row_old = mysqli_fetch_object($old_slider);


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
                    <input type="hidden" name="txt_id" value="<?= @$row_old->vinfo_id ?>">
                    <input type="hidden" name="txt_old_img" value="<?= @$row_old->vinfo_image ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Contact No /លេខកិច្ចសន្យា
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <select class="form-control" name="txt_egc_type" required="required">
                                    <option value="">=== Please choose EGC Type ===</option>
                                    <?php 
                                        $acc_type = $connect->query("SELECT * FROM tbl_egc001_type ORDER BY et_name ASC");
                                        while ($row_acc_type = mysqli_fetch_object($acc_type)) {
                                            if($row_acc_type->et_id == @$row_old->vinfo_contact_no){
                                                echo '<option SELECTED value="'.$row_acc_type->et_id.'">'.$row_acc_type->et_name.'</option>';
                                                
                                            }else{
                                                echo '<option value="'.$row_acc_type->et_id.'">'.$row_acc_type->et_name.'</option>';

                                            }
                                        }
                                     ?>
                                </select>
                                <br>

                                <label>Urgent Status
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <select class="form-control" name="txt_category" required="required">
                                    <?php 
                                        $view_type = $connect->query("SELECT * FROM tbl_view_info_type ORDER BY vit_name ASC");
                                        while ($row_view_type = mysqli_fetch_object($view_type)) {
                                            if($row_view_type->vit_id == @$row_old->vinfo_type_id){
                                            echo '<option SELECTED value="'.$row_view_type->vit_id.'">'.$row_view_type->vit_name.'</option>';
                                                
                                            }else{
                                            echo '<option value="'.$row_view_type->vit_id.'">'.$row_view_type->vit_name.'</option>';

                                            }
                                        }
                                     ?>
                                </select>
                                <br>


                                <label>Title
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <input type="text" value="<?= @$row_old->vinfo_title ?>" class="form-control" name="txt_title" required="required" autocomplete="off">
                                <br>

                                <label>Image
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <input type="file" class="form-control" name="txt_image" autocomplete="off">
                                <br>


                                <label>Price
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <input type="text" value="<?= @$row_old->vinfo_price_show ?>" class="form-control" name="txt_price" required="required" autocomplete="off">
                                <br>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <img width="100%" src="../../img/img_web_view/<?= @$row_old->vinfo_image ?>" class="img-responsive img-responsive img-thumbnail" alt="Image"><br><br><br>
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
