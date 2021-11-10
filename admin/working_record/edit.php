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
        $v_date = @$_POST['txt_date'];
        $v_title = @$_POST['txt_title'];
        $v_description = @$_POST['txt_description'];
        $v_hour = @$_POST['txt_hour'];
        $v_category = @$_POST['txt_category'];
        $v_creator = @$_POST['txt_creator'];
        $v_company = @$_POST['txt_company'];
        $v_department = @$_POST['txt_department'];
        $v_note = @$_POST['txt_note'];
        $v_user_id = @$_SESSION['user']->user_id;
        
        
       
        $query_update = "UPDATE `tbl_working_record` 
            SET 
                `wr_date`='$v_date',
                `wr_title`='$v_title',
                `wr_desciption`='$v_description',
                `wr_hour`='$v_hour',
                `wr_category`='$v_category',
                `wr_employee`='$v_creator',
                `wr_company`='$v_company',
                `wr_department`='$v_department',
                `wr_note`='$v_note',
                `wr_user_id`='$v_user_id'
            WHERE `wr_id`='$v_id'";
            
       
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
    $old_data = $connect->query("SELECT * FROM tbl_working_record WHERE wr_id='$edit_id'");
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
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->wr_id ?>">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="">
                                <label>Date :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                    <input type="text" class="form-control" required="" value="<?= $row_old_data->wr_date ?>"  name="txt_date">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div><br>
                            <div class="">
                                <label>Title :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <input type="text" class="form-control" name="txt_title"  value="<?= $row_old_data->wr_title ?>" required="" autocomplete="off">
                            </div><br>
                            <div class="">
                                <label>Title :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <input type="text" class="form-control" name="txt_hour"  value="<?= $row_old_data->wr_hour ?>" required="" autocomplete="off">
                            </div><br>
                            <div class="">
                                <label>Description :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <textarea class="form-control" rows="4" name="txt_description" required="" autocomplete="off"><?= $row_old_data->wr_desciption ?></textarea>
                            </div><br>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="">
                                <label>Category :<span class="required" aria-required="true">*</span></label>
                                <select class="form-control" name="txt_category" required="">
                                    <option value="">=== Please Choose and Select ===</option>
                                    <?php 
                                        $v_select = $connect->query("SELECT * FROM tbl_working_category ORDER BY cate_name ASC");
                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                            if($row_data->cate_id == $row_old_data->wr_category){
                                                echo '<option SELECTED value="'.$row_data->cate_id.'">'.$row_data->cate_name.'</option>';

                                            }else{
                                                echo '<option value="'.$row_data->cate_id.'">'.$row_data->cate_name.'</option>';

                                            }
                                        }
                                     ?>
                                </select>
                            </div><br>
                            <div class="">
                                <label>Employee :<span class="required" aria-required="true">*</span></label>
                                <select class="form-control" name="txt_creator" required="">
                                    <option value="">=== Please Choose and Select ===</option>
                                    <?php 
                                        $v_select = $connect->query("SELECT * FROM tbl_employee ORDER BY emp_name ASC");
                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                            if($row_data->emp_id == $row_old_data->wr_employee){
                                                echo '<option SELECTED value="'.$row_data->emp_id.'">'.$row_data->emp_name.'</option>';

                                            }else{
                                                echo '<option value="'.$row_data->emp_id.'">'.$row_data->emp_name.'</option>';

                                            }
                                        }
                                     ?>
                                </select>
                            </div><br>
                            <div class="">
                                <label>Department :<span class="required" aria-required="true">*</span></label>
                                <select class="form-control" name="txt_department" required="">
                                    <option value="">=== Please Choose and Select ===</option>
                                    <?php 
                                        $v_select = $connect->query("SELECT * FROM tbl_working_department ORDER BY dep_name ASC");
                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                            if($row_data->dep_id == $row_old_data->wr_department){
                                                echo '<option SELECTED value="'.$row_data->dep_id.'">'.$row_data->dep_name.'</option>';

                                            }else{
                                                echo '<option value="'.$row_data->dep_id.'">'.$row_data->dep_name.'</option>';

                                            }
                                        }
                                     ?>
                                </select>
                            </div><br>
                            <div class="">
                                <label>Company :<span class="required" aria-required="true">*</span></label>
                                <select class="form-control" name="txt_company" required="">
                                    <option value="">=== Please Choose and Select ===</option>
                                    <?php 
                                        $v_select = $connect->query("SELECT * FROM tbl_company ORDER BY com_name ASC");
                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                            if($row_data->com_id == $row_old_data->wr_company){
                                                echo '<option SELECTED value="'.$row_data->com_id.'">'.$row_data->com_name.'</option>';
                                                
                                            }else{
                                                echo '<option value="'.$row_data->com_id.'">'.$row_data->com_name.'</option>';

                                            }
                                        }
                                     ?>
                                </select>
                            </div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="">
                                <label>Note <span class="required" aria-required="true"></span>
                                </label>
                                <textarea rows="10" class="form-control" class="detail" id="detail" name="txt_note" autocomplete="off"><?= $row_old_data->wr_note ?></textarea>
                            </div><br>
                        </div>
                    </div>
                    <br>
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
