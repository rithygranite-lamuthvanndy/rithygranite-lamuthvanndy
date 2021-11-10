<?php 
    $menu_active =5;
    $left_active =0;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        
        $v_id = @$_POST['txt_id'];
        $v_date_record = @$_POST['txt_date_record'];
        $v_master_user = @$_POST['txt_master_user'];
        $v_company = @$_POST['txt_company'];
        $v_full_name = @$_POST['txt_full_name'];
        $v_sex = @$_POST['txt_sex'];
        $v_position = @$_POST['txt_position'];
        $v_tel1 = @$_POST['txt_tel1'];
        $v_tel2 = @$_POST['txt_tel2'];
        $v_email1 = @$_POST['txt_email1'];
        $v_email2 = @$_POST['txt_email2'];
        $v_address = @$_POST['txt_address'];
        $v_note = @$_POST['txt_note'];

       
        $query_update = "UPDATE `tbl_ct_contact_list` 
            SET 
                `ctco_date_record`='$v_date_record',
                `ctco_master_user`='$v_master_user',
                `ctco_company`='$v_company',
                `ctco_full_name`='$v_full_name',
                `ctco_sex`='$v_sex',
                `ctco_position`='$v_position',
                `ctco_tel1`='$v_tel1',
                `ctco_tel2`='$v_tel2',
                `ctco_email1`='$v_email1',
                `ctco_email2`='$v_email2',
                `ctco_address`='$v_address',
                `ctco_note`='$v_note'
            
            WHERE `ctco_id`='$v_id'";
            
       
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
    $old_data = $connect->query("SELECT * FROM tbl_ct_contact_list WHERE ctco_id='$edit_id'");
    $row_old_data = mysqli_fetch_object($old_data);


 ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
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
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->ctco_id ?>">
                    <div class="form-body">

                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Date Record
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <input type="date" value="<?= $row_old_data->ctco_date_record ?>" name="txt_date_record" class="form-control" required="">
                        </div>    
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Upline Name :
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <select class="form-control" name="txt_master_user" required="required">
                                    <option value="">=== Please choose and select ===</option>
                                    <?php 
                                        $acc_type = $connect->query("SELECT * FROM tbl_ct_contact_list ORDER BY ctco_full_name ASC");
                                        while ($row_acc_type = mysqli_fetch_object($acc_type)) {
                                            if($row_acc_type->ctco_id == @$row_old_data->ctco_master_user){
                                                echo '<option SELECTED value="'.$row_acc_type->ctco_id.'">'.$row_acc_type->ctco_full_name.'</option>';
                                                
                                            }else{
                                                echo '<option value="'.$row_acc_type->ctco_id.'">'.$row_acc_type->ctco_full_name.'</option>';

                                            }
                                        }
                                     ?>
                                </select>    
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Company :
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <select class="form-control" name="txt_company" required="required">
                                    <option value="">=== Please choose and select ===</option>
                                    <?php 
                                        $acc_type = $connect->query("SELECT * FROM tbl_ct_company ORDER BY ctcom_company_name ASC");
                                        while ($row_acc_type = mysqli_fetch_object($acc_type)) {
                                            if($row_acc_type->ctcom_id == @$row_old_data->ctco_company){
                                                echo '<option SELECTED value="'.$row_acc_type->ctcom_id.'">'.$row_acc_type->ctcom_company_name.'</option>';
                                                
                                            }else{
                                                echo '<option value="'.$row_acc_type->ctcom_id.'">'.$row_acc_type->ctcom_company_name.'</option>';

                                            }
                                        }
                                     ?>
                                </select>  
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Full Name :
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <input type="text" value="<?= $row_old_data->ctco_full_name ?>" name="txt_full_name" class="form-control" required="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Sex :
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <select class="form-control" name="txt_sex" required="required">
                                    <option value="">=== Please choose and select ===</option>
                                    <?php 
                                        $acc_type = $connect->query("SELECT * FROM tbl_ct_sex ORDER BY ctsex_name ASC");
                                        while ($row_acc_type = mysqli_fetch_object($acc_type)) {
                                            if($row_acc_type->ctsex_id == @$row_old_data->ctco_sex){
                                                echo '<option SELECTED value="'.$row_acc_type->ctsex_id.'">'.$row_acc_type->ctsex_name.'</option>';
                                                
                                            }else{
                                                echo '<option value="'.$row_acc_type->ctsex_id.'">'.$row_acc_type->ctsex_name.'</option>';

                                            }
                                        }
                                     ?>
                                </select>  
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Position :
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <select class="form-control" name="txt_position" required="required">
                                    <option value="">=== Please choose and select ===</option>
                                    <?php 
                                        $acc_type = $connect->query("SELECT * FROM tbl_ct_position ORDER BY ctpo_name ASC");
                                        while ($row_acc_type = mysqli_fetch_object($acc_type)) {
                                            if($row_acc_type->ctpo_id == @$row_old_data->ctco_position){
                                                echo '<option SELECTED value="'.$row_acc_type->ctpo_id.'">'.$row_acc_type->ctpo_name.'</option>';
                                                
                                            }else{
                                                echo '<option value="'.$row_acc_type->ctpo_id.'">'.$row_acc_type->ctpo_name.'</option>';

                                            }
                                        }
                                     ?>
                                </select>  
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Tel1 :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <input type="text" value="<?= $row_old_data->ctco_tel1 ?>" name="txt_tel1" class="form-control">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Tel2 :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <input type="text" value="<?= $row_old_data->ctco_tel2 ?>" name="txt_tel2" class="form-control">
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Email1 :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <input type="text" value="<?= $row_old_data->ctco_email1 ?>" name="txt_email1" class="form-control">
                                
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Email2 :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <input type="text" value="<?= $row_old_data->ctco_email2 ?>" name="txt_email2" class="form-control">
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Address :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <input type="text" value="<?= $row_old_data->ctco_address ?>" name="txt_address" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Note :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <input type="text" value="<?= $row_old_data->ctco_note ?>" name="txt_note" class="form-control">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
