<?php 
    $menu_active =150;
    $left_active =0;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>



<?php 
    if(isset($_POST['btn_submit'])){
        $v_date_record = @$_POST['txt_date_record'];
        $v_title = @$_POST['txt_title'];
        $v_description = @$_POST['txt_description'];
        $v_leader = @$_POST['txt_leader'];
        $v_date_start = @$_POST['txt_date_start'];
        $v_date_end = @$_POST['txt_date_end'];
        $v_provider = @$_POST['txt_provider'];
        $v_amount = @$_POST['txt_amount'];
        $v_expense = @$_POST['txt_expense'];
        $v_note = @$_POST['txt_note'];
        $v_user_id = @$_SESSION['user']->user_id;
        $query_add = "INSERT INTO tbl_pj_project_title (
                pti_date_record,
                pti_project_title,
                pti_description,
                pti_leader,
                pti_date_start,
                pti_date_finish,
                pti_provider,
                pti_amount,
                pti_expense,
                pti_note,
                user_id
                
                ) 
            VALUES(
                '$v_date_record',
                '$v_title',
                '$v_description',
                '$v_leader',
                '$v_date_start',
                '$v_date_end',
                '$v_provider',
                '$v_amount',
                '$v_expense',
                '$v_note',
                '$v_user_id'
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
                                    <label>Date Record : </label>
                                    <input type="text" class="form-control" name="txt_date_record" data-provide="datepicker" data-date-format="yyyy-mm-dd"  autocomplete="off" required="" value="<?= date('Y-m-d') ?>">
                                </div>
                                <div class="form-group">
                                    <label>Project Title : </label>
                                    <input type="text" class="form-control" name="txt_title"  autocomplete="off" required="">
                                </div>
                                <div class="form-group">
                                    <label>Description : </label>
                                    <input type="text" class="form-control" name="txt_description"  autocomplete="off" required="">
                                </div>
                                <div class="form-group">
                                    <label>Start Date : </label>
                                    <input type="text" class="form-control" name="txt_date_start" data-provide="datepicker" data-date-format="yyyy-mm-dd"  autocomplete="off" required="" placeholder="start date">
                                </div>
                                <div class="form-group">
                                    <label>Finish Date : </label>
                                    <input type="text" class="form-control" name="txt_date_end" data-provide="datepicker" data-date-format="yyyy-mm-dd"  autocomplete="off" required="" placeholder="end date">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Leader : </label>
                                    <select name="txt_leader" class="form-control">
                                        <option value="">--leader--</option>
                                        <?php 
                                            $get_leader = $connect->query("SELECT * FROM tbl_pj_leader ORDEr BY dlead_name ASC");
                                            while ($row_leader = mysqli_fetch_object($get_leader)) {
                                                echo '<option value="'.$row_leader->dlead_id.'">'.$row_leader->dlead_name.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Provider : </label>
                                    <select name="txt_provider" class="form-control">
                                        <option value="">--provider--</option>
                                        <?php 
                                            $get_provider = $connect->query("SELECT * FROM tbl_pj_provider ORDEr BY dpro_name ASC");
                                            while ($row_provider = mysqli_fetch_object($get_provider)) {
                                                echo '<option value="'.$row_provider->dpro_id.'">'.$row_provider->dpro_name.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Amount : </label>
                                    <input type="text" class="form-control" name="txt_amount"  autocomplete="off" required="">
                                </div>
                                <div class="form-group">
                                    <label>Expense : </label>
                                    <input type="text" class="form-control" name="txt_expense" autocomplete="off" required="">
                                </div>
                                <div class="form-group">
                                    <label>Note : </label>
                                    <input type="text" class="form-control" name="txt_note" autocomplete="off" required="">
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



<?php include_once '../layout/footer.php' ?>
