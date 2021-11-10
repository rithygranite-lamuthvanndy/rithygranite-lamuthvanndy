<?php 
    $menu_active =44;
    $left_active =0;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        $v_dat_record = @$_POST['txt_dat_record'];
        $v_tit_name = @$_POST['txt_tit_name'];
        $v_des = @$_POST['txt_des'];
        $v_dep = @$_POST['cbo_dep'];
        $v_emp_chk = @$_POST['cbo_emp_chk'];

        $query_add = "INSERT INTO tbl_admin_document_sample (
                docs_date_record,
                docs_title_name,
                docs_description,
                docs_department,
                docs_employee_check
                ) 
            VALUES(
                '$v_dat_record',
                '$v_tit_name',
                '$v_des',
                '$v_dep',
                '$v_emp_chk')";
        if($connect->query($query_add)){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data Inserted ...
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
                                <div class="form-group">
                                    <label for ="">Date Record:</label>    
                                    <input class="form-control" required name="txt_dat_record" type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" placeholder="date..." autocomplete="off" value="<?= date('Y-m-d') ?>">          
                                </div>
                                <div class="form-group">
                                    <label>Title Name: </label>
                                    <input type="text" class="form-control" name="txt_tit_name" placeholder=" " required="required" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Description: </label>
                                    <input type="text" class="form-control" name="txt_des" placeholder=" " required="required" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Department: </label>   
                                    <select name="cbo_dep" class="form-control" required="required">
                                        <option value="">=== Select Department here ===</option>
                                        <?php 
                                            $sql=$connect->query("SELECT * FROM  tbl_admin_department_list ORDER BY dep_id DESC");
                                            while ($row=mysqli_fetch_object($sql)) {
                                                echo '<option value="'.$row->dep_id.'">'.$row->dep_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                                 <div class="form-group">
                                    <label>Employee Check: </label>   
                                    <select name="cbo_emp_chk" class="form-control" required="required">
                                        <option value="">=== Select Empoyee Check here ===</option>
                                        <?php 
                                            $sql=$connect->query("SELECT * FROM  tbl_admin_check_name_list ORDER BY cnl_id DESC");
                                            while ($row=mysqli_fetch_object($sql)) {
                                                echo '<option value="'.$row->cnl_id.'">'.$row->cnl_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
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
