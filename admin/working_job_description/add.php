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
        $v_time = @$_POST['txt_time'];
        $v_hour = @$_POST['txt_hour'];
        $v_description = @$_POST['txt_description'];
        $v_employee = @$_POST['txt_employee'];
        $v_user_id = @$_SESSION['user']->user_id;

        $query_add = "INSERT INTO tbl_working_job_description (
                jd_time,
                jd_hour,
                jd_description,
                jd_employee,
                jd_user
                ) 
            VALUES(
                '$v_time',
                '$v_hour',
                '$v_description',
                '$v_employee',
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
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="">
                                    <label>Time :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                    <input type="text" class="form-control" name="txt_time"  required="" autocomplete="off">
                                </div><br>
                                <div class="">
                                    <label>Hour :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                    <input type="text" class="form-control" name="txt_hour"  required="" autocomplete="off">
                                </div><br>
                                <div class="">
                                    <label>Description :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                    <textarea class="form-control" rows="3" name="txt_description"  required="" autocomplete="off"></textarea>
                                </div><br>
                                <div class="">
                                    <label>Employee :<span class="required" aria-required="true">*</span></label>
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
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-6 text-center">
                                    <button type="submit" name="btn_submit" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
                                    <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>

<?php include_once '../layout/footer.php' ?>
