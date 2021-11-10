<?php 
    $menu_active =122;
    $left_active =0;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        $v_date_record = @$connect->real_escape_string($_POST['txt_date_record']);
        $v_topic_plan = @$connect->real_escape_string($_POST['txt_topic_plan']);
        $v_category = @$connect->real_escape_string($_POST['txt_category']);
        $v_company = @$connect->real_escape_string($_POST['txt_company']);
        $v_employee = @$connect->real_escape_string($_POST['txt_employee']);
        $v_approved = @$connect->real_escape_string($_POST['txt_approved']);
        $v_note = @$connect->real_escape_string($_POST['txt_note']);
        $v_user_id = @$_SESSION['user']->user_id;

        $query_add = "INSERT INTO tbl_working_planning (
                wfpl_date_record,
                wfpl_topic_plan,
                wfpl_category,
                wfpl_company,
                wfpl_employee,
                wfpl_approved,
                wfpl_note,
                user_id
                ) 
            VALUES(
                '$v_date_record',
                '$v_topic_plan',
                '$v_category',
                '$v_company',
                '$v_employee',
                '$v_approved',
                '$v_note',
                '$v_user_id')";
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


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Create Record</h2>
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
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Date Record :
                                    <span class="required text-danger" aria-required="true">*</span>
                                </label>
                                <input type="date" name="txt_date_record" class="form-control" required="">
                                <br>

                                <label>Topic Plan :
                                    <span class="required text-danger" aria-required="true">*</span>
                                </label>
                                <input type="text" name="txt_topic_plan" class="form-control" required="">
                                <br>

                                <div class="">
                                    <label>Category :<span class="required text-danger" aria-required="true">*</span></label>
                                    <select class="form-control" name="txt_category" required="">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_working_category ORDER BY cate_name ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_data->cate_id.'">'.$row_data->cate_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div><br>

                                <div class="">
                                    <label>Company :<span class="required text-danger" aria-required="true">*</span></label>
                                    <select class="form-control" name="txt_company" required="">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_company ORDER BY com_name ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_data->com_id.'">'.$row_data->com_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div><br>

                                <div class="">
                                    <label>Employee :<span class="required text-danger" aria-required="true">*</span></label>
                                    <select class="form-control" name="txt_employee" required="">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_employee ORDER BY emp_name ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_data->emp_id.'">'.$row_data->emp_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div><br>
                                
                                <div class="">
                                    <label>Approved By :<span class="required text-danger" aria-required="true">*</span></label>
                                    <select class="form-control" name="txt_approved" required="">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_employee ORDER BY emp_name ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_data->emp_id.'">'.$row_data->emp_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div><br>

                                <label>Note :
                                </label>
                                <textarea name="txt_note" rows="4" class="form-control"></textarea>
                                <br>
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
