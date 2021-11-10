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
        $v_update = @$_POST['txt_update'];
        $v_conclusion = @$_POST['txt_conclusion'];
        $v_suggest_next = @$_POST['txt_suggest_next'];
        $v_user_id = @$_SESSION['user']->user_id;
        

        $query_add = "INSERT INTO tbl_pj_project_close (
                pclo_date_record,
                pclo_project_title,
                pclo_project_update,
                pclo_conclusion,
                pclo_suggest_next,
                user_id
                
                ) 
            VALUES(
                '$v_date_record',
                '$v_title',
                '$v_update',
                '$v_conclusion',
                '$v_suggest_next',
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
                                    <input type="text" class="form-control" name="txt_date_record" data-provide="datepicker" data-date-format="yyyy-mm-dd" placeholder="date record" autocomplete="off" required="" value="<?= date('Y-m-d') ?>">
                                </div>
                                <div class="form-group">
                                    <label>Project Title : </label>
                                    <select name="txt_title" class="form-control">
                                        <option value="">--project title--</option>
                                        <?php 
                                            $get_p_title = $connect->query("SELECT * FROM tbl_pj_project_title ORDEr BY     pti_project_title ASC");
                                            while ($row_title = mysqli_fetch_object($get_p_title)) {
                                                echo '<option value="'.$row_title->pti_id.'">'.$row_title->pti_project_title.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Project Update : </label>
                                    <input type="text" class="form-control" name="txt_update"  autocomplete="off" required="">
                                </div>
                                <div class="form-group">
                                    <label>Project Conclusion : </label>
                                    <input type="text" class="form-control" name="txt_conclusion"  autocomplete="off" required="">
                                </div>
                                <div class="form-group">
                                    <label>Suggest Next : </label>
                                    <input type="text" class="form-control" name="txt_suggest_next"  autocomplete="off" required="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            </div>
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
                </form><br>
            </div>
        </div>
    </div>
</div>



<?php include_once '../layout/footer.php' ?>
