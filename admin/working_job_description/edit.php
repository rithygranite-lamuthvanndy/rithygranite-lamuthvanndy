<?php 
    $menu_active =122;
    $left_active =0;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){

        $v_id = @$_POST['txt_id'];
        $v_time = @$_POST['txt_time'];
        $v_hour = @$_POST['txt_hour'];
        $v_description = @$_POST['txt_description'];
        $v_employee = @$_POST['txt_employee'];
        
        
       
        $query_update = "UPDATE `tbl_working_job_description` 
            SET 
                `jd_time`='$v_time',
                `jd_hour`='$v_hour',
                `jd_description`='$v_description',
                `jd_employee`='$v_employee'
            WHERE `jd_id`='$v_id'";
            
       
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
    $old_data = $connect->query("SELECT * FROM tbl_working_job_description WHERE jd_id='$edit_id'");
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
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->jd_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="">
                                    <label>Time :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                    <input type="text" class="form-control" name="txt_time"  required="" autocomplete="off" value="<?= $row_old_data->jd_time ?>">
                                </div><br>
                                <div class="">
                                    <label>Hour :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                    <input type="text" class="form-control" name="txt_hour"  required="" autocomplete="off" value="<?= $row_old_data->jd_hour ?>">
                                </div><br>
                                <div class="">
                                    <label>Description :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                    <textarea class="form-control" rows="3" name="txt_description"  required="" autocomplete="off"><?= $row_old_data->jd_description ?></textarea>
                                </div><br>
                                <div class="">
                                    <label>Employee :<span class="required" aria-required="true">*</span></label>
                                    <select class="form-control" name="txt_employee" required="">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_employee ORDER BY emp_name ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                if($row_data->emp_id == $row_old_data->jd_employee) 
                                                    echo '<option SELECTED value="'.$row_data->emp_id.'">'.$row_data->emp_name.'</option>';
                                                else
                                                    echo '<option value="'.$row_data->emp_id.'">'.$row_data->emp_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div><br>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-6 text-center">
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
