<?php 
    $menu_active =55;
    $left_active =0;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){

        $v_id = @$_POST['txt_id'];
        $v_date = @$_POST['txt_date'];
        $v_title = @$_POST['txt_title'];
        $v_description = @$_POST['txt_description'];
        $v_category = @$_POST['txt_category'];
        $v_creator = @$_POST['txt_creator'];
        $v_department = @$_POST['txt_department'];
        $v_note = @$_POST['txt_note'];
        $v_user_id = @$_SESSION['user']->user_id;
        
        
       
        $query_update = "UPDATE `tbl_doc_document` 
            SET 
                `docdoc_date`='$v_date',
                `docdoc_title`='$v_title',
                `docdoc_desciption`='$v_description',
                `docdoc_category`='$v_category',
                `docdoc_creator`='$v_creator',
                `docdoc_department`='$v_department',
                `docdoc_note`='$v_note',
                `user_id`='$v_user_id'
            WHERE `docdoc_id`='$v_id'";
            
       
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
    $old_data = $connect->query("SELECT * FROM tbl_doc_document WHERE docdoc_id='$edit_id'");
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
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->docdoc_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Date :
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <input type="date" value="<?= $row_old_data->docdoc_date ?>" name="txt_date" class="form-control" required="">
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Title :
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <input type="text" value="<?= $row_old_data->docdoc_title ?>" name="txt_title" class="form-control" required="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Description :
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <input type="text" value="<?= $row_old_data->docdoc_desciption ?>" name="txt_description" class="form-control" required="">
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Category :
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <select class="form-control myselect2" name="txt_category" required="required">
                                    <option value="">=== Please choose and select ===</option>
                                    <?php 
                                        $acc_type = $connect->query("SELECT * FROM tbl_doc_category ORDER BY doccat_name ASC");
                                        while ($row_acc_type = mysqli_fetch_object($acc_type)) {
                                            if($row_acc_type->doccat_id == @$row_old_data->docdoc_category){
                                                echo '<option SELECTED value="'.$row_acc_type->doccat_id.'">'.$row_acc_type->doccat_name.'</option>';
                                                
                                            }else{
                                                echo '<option value="'.$row_acc_type->doccat_id.'">'.$row_acc_type->doccat_name.'</option>';

                                            }
                                        }
                                     ?>
                                </select> 
                                
                            </div>   
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Creator :
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <select class="form-control myselect2" name="txt_creator" required="required">
                                    <option value="">=== Please choose and select ===</option>
                                    <?php 
                                        $acc_type = $connect->query("SELECT * FROM tbl_doc_creator ORDER BY doccre_name ASC");
                                        while ($row_acc_type = mysqli_fetch_object($acc_type)) {
                                            if($row_acc_type->doccre_id == @$row_old_data->docdoc_creator){
                                                echo '<option SELECTED value="'.$row_acc_type->doccre_id.'">'.$row_acc_type->doccre_name.'</option>';
                                                
                                            }else{
                                                echo '<option value="'.$row_acc_type->doccre_id.'">'.$row_acc_type->doccre_name.'</option>';

                                            }
                                        }
                                     ?>
                                </select> 
                                
                            </div>   
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Department :
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <select class="form-control myselect2" name="txt_department" required="required">
                                    <option value="">=== Please choose and select ===</option>
                                    <?php 
                                        $acc_type = $connect->query("SELECT * FROM tbl_doc_department ORDER BY docdep_name ASC");
                                        while ($row_acc_type = mysqli_fetch_object($acc_type)) {
                                            if($row_acc_type->docdep_id == @$row_old_data->docdoc_department){
                                                echo '<option SELECTED value="'.$row_acc_type->docdep_id.'">'.$row_acc_type->docdep_name.'</option>';
                                                
                                            }else{
                                                echo '<option value="'.$row_acc_type->docdep_id.'">'.$row_acc_type->docdep_name.'</option>';

                                            }
                                        }
                                     ?>
                                </select> 
                            </div>   
                         </div>
                         <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Note :
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <input type="text" value="<?= $row_old_data->docdoc_note ?>" name="txt_note" class="form-control" required="">
                            </div>
                            
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
