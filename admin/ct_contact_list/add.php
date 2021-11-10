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
        $v_date_record = @$_POST['txt_date_record'];
        $v_master_user = @$_POST['txt_master_user'];
        $v_company = @$_POST['txt_company'];
        $v_full_name = @$_POST['txt_full_name'];
        $v_sex = @$_POST['txt_sex'];
        $v_position = @$_POST['txt_position'];
        $v_photo = @$_POST['txt_photo'];
        $v_tel1 = @$_POST['txt_tel1'];
        $v_tel2 = @$_POST['txt_tel2'];
        $v_email1 = @$_POST['txt_email1'];
        $v_email2 = @$_POST['txt_email2'];
        $v_address = @$_POST['txt_address'];
        $v_note = @$_POST['txt_note'];

        $query_add = "INSERT INTO tbl_ct_contact_list (
                ctco_date_record,
                ctco_master_user,
                ctco_company,
                ctco_full_name,
                ctco_sex,
                ctco_position,
                ctco_photo,
                ctco_tel1,
                ctco_tel2,
                ctco_email1,
                ctco_email2,
                ctco_address,
                ctco_note

                
                )  
            VALUES(
                '$v_date_record',
                '$v_master_user',
                '$v_company',
                '$v_full_name',
                '$v_sex',
                '$v_position',
                '$v_photo',
                '$v_tel1',
                '$v_tel2',
                '$v_email1',
                '$v_email2',
                '$v_address',
                '$v_note'
                )";
        if($connect->query($query_add)){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data inserted ...
            </div>'; 
        }else{
            $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> Query error ...
            </div>';   
        }
    }

 ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Create Record</h2>
        </div>
    </div>

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
                    <div class="form-body">

                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="date" class="form-control" name="txt_date_record" placeholder="date record..."  autocomplete="off">
                                    <label>Date Record :
                                        <span class="required" aria-required="true"></span>
                                    </label>

                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <select class="form-control" name="txt_master_user" required="required">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_ct_contact_list ORDER BY ctco_full_name ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_data->ctco_id.'">'.$row_data->ctco_full_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                    <label>Upline Name
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                   
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <select class="form-control" name="txt_company" required="required">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_ct_company ORDER BY ctcom_company_name ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_data->ctcom_id.'">'.$row_data->ctcom_company_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                    <label>Company :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                   
                                </div>
                            </div>
                        
                            
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_full_name"  autocomplete="off">
                                    <label>Full Name :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <select class="form-control" name="txt_sex" required="required">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_ct_sex ORDER BY ctsex_name ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_data->ctsex_id.'">'.$row_data->ctsex_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                    <label>Sex :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                   
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <select class="form-control" name="txt_position" required="required">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_ct_position ORDER BY ctpo_name ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_data->ctpo_id.'">'.$row_data->ctpo_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                    <label>Position :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                   
                                </div>
                            </div>
                            
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_tel1"  autocomplete="off">
                                    <label>Tel1 
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_tel2"  autocomplete="off">
                                    <label>Tel2 
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                        
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_email1"  autocomplete="off">
                                    <label>Email1 
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_email2"  autocomplete="off">
                                    <label>Email2 
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                        
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_address"  autocomplete="off">
                                    <label>Address
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_note"  autocomplete="off">
                                    <label>Note
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
