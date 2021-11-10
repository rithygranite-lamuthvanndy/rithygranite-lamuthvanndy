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
        $v_date_record = @$connect->real_escape_string($_POST['txt_date_record']);
        $v_topic_plan = @$connect->real_escape_string($_POST['txt_topic_plan']);
        $v_category = @$connect->real_escape_string($_POST['txt_category']);
        $v_company = @$connect->real_escape_string($_POST['txt_company']);
        $v_employee = @$connect->real_escape_string($_POST['txt_employee']);
        $v_approved = @$connect->real_escape_string($_POST['txt_approved']);
        $v_note = @$connect->real_escape_string($_POST['txt_note']);
        $v_user_id = @$_SESSION['user']->user_id;
        
       
        $query_update = "UPDATE `tbl_working_planning` 
            SET 
                `wfpl_date_record`='$v_date_record',
                `wfpl_topic_plan`='$v_topic_plan',
                `wfpl_category`='$v_category',
                `wfpl_company`='$v_company',
                `wfpl_employee`='$v_employee',
                `wfpl_approved`='$v_approved',
                `wfpl_note`='$v_note',
                `user_id`='$v_user_id'
            WHERE `wfpl_id`='$v_id'";
            
       
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
    $old_data = $connect->query("SELECT * FROM tbl_working_planning WHERE wfpl_id='$edit_id'");
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
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->wfpl_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Date Record :
                                    <span class="required text-danger" aria-required="true">*</span>
                                </label>
                                <input type="date" value="<?= $row_old_data->wfpl_date_record ?>" name="txt_date_record" class="form-control" required="">
                                <br>

                                <label>Topic Plan :
                                    <span class="required text-danger" aria-required="true">*</span>
                                </label>
                                <input type="text" value="<?= $row_old_data->wfpl_topic_plan ?>" name="txt_topic_plan" class="form-control" required="">
                                <br>

                                <label>Category :
                                    <span class="required text-danger" aria-required="true">*</span>
                                </label>
                                    <select class="form-control" name="txt_category" required="required">
                                        <option value="">=== Please Choose ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_working_category ORDER BY cate_id ASC");
                                            while ($row_select = mysqli_fetch_object($v_select)) {
                                                if($row_select->cate_id==$row_old_data->wfpl_category){
                                                    echo '<option SELECTED="SELECTED" value="'.$row_select->cate_id.'">'.$row_select->cate_name.'</option>'; 
                                                }else{
                                                    echo '<option value="'.$row_select->cate_id.'">'.$row_select->cate_name.'</option>';
                                                }
                                            }
                                         ?>
                                    </select>
                                <br>

                                <label>Company :
                                    <span class="required text-danger" aria-required="true">*</span>
                                </label>
                                    <select class="form-control" name="txt_company" required="required">
                                        <option value="">=== Please Choose ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_company ORDER BY com_id ASC");
                                            while ($row_select = mysqli_fetch_object($v_select)) {
                                                if($row_select->com_id==$row_old_data->wfpl_company){
                                                    echo '<option SELECTED="SELECTED" value="'.$row_select->com_id.'">'.$row_select->com_name.'</option>'; 
                                                }else{
                                                    echo '<option value="'.$row_select->com_id.'">'.$row_select->com_name.'</option>';
                                                }
                                            }
                                         ?>
                                    </select>
                                <br>

                                <label>Employee :
                                    <span class="required text-danger" aria-required="true">*</span>
                                </label>
                                    <select class="form-control" name="txt_employee" required="required">
                                        <option value="">=== Please Choose ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_employee ORDER BY emp_id ASC");
                                            while ($row_select = mysqli_fetch_object($v_select)) {
                                                if($row_select->emp_id==$row_old_data->wfpl_employee){
                                                    echo '<option SELECTED="SELECTED" value="'.$row_select->emp_id.'">'.$row_select->emp_name.'</option>'; 
                                                }else{
                                                    echo '<option value="'.$row_select->emp_id.'">'.$row_select->emp_name.'</option>';
                                                }
                                            }
                                         ?>
                                    </select>
                                <br>

                                <label>Approved by :
                                    <span class="required text-danger" aria-required="true">*</span>
                                </label>
                                    <select class="form-control" name="txt_approved" required="required">
                                        <option value="">=== Please Choose ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_employee ORDER BY emp_id ASC");
                                            while ($row_select = mysqli_fetch_object($v_select)) {
                                                if($row_select->emp_id==$row_old_data->wfpl_approved){
                                                    echo '<option SELECTED="SELECTED" value="'.$row_select->emp_id.'">'.$row_select->emp_name.'</option>'; 
                                                }else{
                                                    echo '<option value="'.$row_select->emp_id.'">'.$row_select->emp_name.'</option>';
                                                }
                                            }
                                         ?>
                                    </select>
                                <br>

                                <label>Note :
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <textarea name="txt_note" rows="4" class="form-control"><?= $row_old_data->wfpl_note ?></textarea>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_submit" class="btn green"><i class="fa fa-save fa-fw"></i>Update</button>
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
