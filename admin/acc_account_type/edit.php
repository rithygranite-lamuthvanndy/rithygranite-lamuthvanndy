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
        $v_main = @$_POST['txt_main'];
        $v_report_type = @$_POST['cbo_report_type'];
        
       
        $query_update = "UPDATE `tbl_acc_type_account` 
            SET 
                `accta_type_account`='$v_name',
                `accta_main_account`='$v_main',
                `type_report_id`='$v_report_type'
            WHERE `accta_id`='$v_id'";
            
       
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
    $old_data = $connect->query("SELECT * FROM tbl_acc_type_account WHERE accta_id='$edit_id'");
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
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->accta_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Account Name :
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <input type="text" value="<?= $row_old_data->accta_type_account ?>" name="txt_name" class="form-control" required="">
                                <br>

                               <!--  <label>Account Type :
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <select class="form-control myselect2" name="txt_main" required="required">
                                    <option value="">=== Please choose and select ===</option>
                                    <?php 
                                        $acc_type = $connect->query("SELECT * FROM tbl_acc_main_account ORDER BY accma_main_account ASC");
                                        while ($row_acc_type = mysqli_fetch_object($acc_type)) {
                                            if($row_acc_type->accma_id == @$row_old_data->accta_main_account){
                                                echo '<option SELECTED value="'.$row_acc_type->accma_id.'">'.$row_acc_type->accma_main_account.'</option>';
                                                
                                            }else{
                                                echo '<option value="'.$row_acc_type->accma_id.'">'.$row_acc_type->accma_main_account.'</option>';

                                            }
                                        }
                                     ?>
                                </select>
                                <br> -->
                                

                                <label>Account Type Report *: 
                                </label>
                                <select class="form-control" name="cbo_report_type" required="required">
                                    <option value="">=== Please choose and select ===</option>
                                    <?php 
                                        $v_select = $connect->query("SELECT * FROM tbl_acc_account_type_report ORDER BY tr_name ASC");
                                        while ($row_select = mysqli_fetch_object($v_select)) {
                                            if($row_select->tr_id == @$row_old_data->type_report_id){
                                                echo '<option SELECTED value="'.$row_select->tr_id.'">'.$row_select->tr_name.'</option>';
                                                
                                            }else{
                                                echo '<option value="'.$row_select->tr_id.'">'.$row_select->tr_name.'</option>';

                                            }
                                        }
                                     ?>
                                </select>
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
