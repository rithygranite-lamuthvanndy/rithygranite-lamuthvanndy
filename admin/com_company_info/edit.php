<?php 
    $menu_active =10;
    $left_menu =4;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        
        $v_id = @$_POST['txt_id'];
        $v_name_kh = @$_POST['txt_name_kh'];
        $v_name_en = @$_POST['txt_name_en'];
        $v_name_ch = @$_POST['txt_name_ch'];
        $v_addr = @$_POST['txt_addr'];
        $v_phone = @$_POST['txt_phone'];
        $v_email = @$_POST['txt_email'];
        $v_website = @$_POST['txt_website'];
        $v_facebook = @$_POST['txt_facebook'];
        $v_note = @$_POST['txt_note'];
        $v_user_id = @$_SESSION['user']->user_id;
       
        $query_update = "UPDATE `tbl_com_company_info` 
            SET 
                `comci_name_kh`='$v_name_kh',
                `comci_name_en`='$v_name_en',
                `comci_name_ch`='$v_name_ch',
                `comci_addr`='$v_addr',
                `comci_phone`='$v_phone',
                `comci_email`='$v_email',
                `comci_website`='$v_website',
                `comci_facebook`='$v_facebook',
                `comci_note`='$v_note',
                `user_id`='$v_user_id'
            WHERE `comci_id`='$v_id'
                    ";
            
       
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
    $old_data = $connect->query("SELECT * FROM tbl_com_company_info WHERE comci_id='$edit_id'");
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
            <h3 class="panel-title">Input Information</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->comci_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Company Name KH :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <input type="text" value="<?= $row_old_data->comci_name_kh ?>" name="txt_name_kh" class="form-control">
                                <br>

                                <label>Company Name EN :
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <input type="text" value="<?= $row_old_data->comci_name_en ?>" name="txt_name_en" class="form-control" required="">
                                <br>

                                <label>Company Name CH :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <input type="text" value="<?= $row_old_data->comci_name_ch ?>" name="txt_name_ch" class="form-control">
                                <br>

                                <label>Address :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <input type="text" value="<?= $row_old_data->comci_addr ?>" name="txt_addr" class="form-control">
                                <br>

                                <label>Phone :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <input type="text" value="<?= $row_old_data->comci_phone ?>" name="txt_phone" class="form-control">
                                <br>
                                
                                <label>Email :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <input type="text" value="<?= $row_old_data->comci_email ?>" name="txt_email" class="form-control">
                                <br>

                                <label>Website :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <input type="text" value="<?= $row_old_data->comci_website ?>" name="txt_website" class="form-control">
                                <br>

                                <label>Facebook :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <input type="text" value="<?= $row_old_data->comci_facebook ?>" name="txt_facebook" class="form-control">
                                <br>

                                <label>Note :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <textarea name="txt_note" rows="4" class="form-control"><?= $row_old_data->comci_note ?></textarea>
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
