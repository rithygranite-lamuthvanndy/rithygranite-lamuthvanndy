<?php 
    $menu_active =150;
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
        $v_pro_tit = @$_POST['txt_pro_tit'];
        $v_pro_sub = @$_POST['txt_pro_sub'];
        $v_ris_til = @$_POST['txt_ris_til'];
        $v_des = @$_POST['txt_des'];
        
       
        $query_update = "UPDATE tbl_pj_risk_management 
            SET 
                pris_date_record='$v_date',
                pris_project_title='$v_pro_tit',
                pris_project_sub='$v_pro_sub',
                pris_risk_title='$v_ris_til',
                pris_description='$v_des'
            WHERE pris_id='$v_id'";
            
       
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
    $old_data = $connect->query("SELECT *,CB.user_id AS id,CB.date_audit AS audit FROM tbl_pj_risk_management AS CB
                            LEFT JOIN tbl_pj_project_title AS PT ON CB.pris_project_title=PT.pti_id 
                            LEFT JOIN tbl_pj_project_initiation AS PI ON CB.pris_project_sub=PI.pini_id 
                            WHERE pris_id='$edit_id'");
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
            <h3 class="panel-title">Edit Information</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->pris_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Date Record : </label>    
                                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                        <input value="<?= $row_old_data->pris_date_record ?>" type="text" class="form-control" placeholder="YYYY-MM-DD" name="txt_date" required="required"  autocomplete="off">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Project Title : </label>
                                    <select name="txt_pro_tit" id="input" class="form-control" required="">
                                        <!-- <option value="">=== Select Project Title ===</option> -->
                                        <?php 
                                            $sql=$connect->query("SELECT * FROM tbl_pj_project_title ORDER BY pti_project_title");
                                            while ($row=mysqli_fetch_object($sql)) {
                                                if($row_old_data->pris_project_title==$row->pti_id)
                                                    echo '<option SELECTED value="'.$row->pti_id.'">'.$row->pti_project_title.'</option>';
                                                else
                                                    echo '<option value="'.$row->pti_id.'">'.$row->pti_project_title.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Project Sub : </label>
                                    <select name="txt_pro_sub" id="input" class="form-control" required="">
                                        <!-- <option value="">=== Select Project Sub ===</option> -->
                                        <?php 
                                            $sql=$connect->query("SELECT * FROM tbl_pj_project_initiation ORDER BY pini_project_sub");
                                            while ($row=mysqli_fetch_object($sql)) {
                                                if($row_old_data->pris_project_sub==$row->pini_id)
                                                    echo '<option SELECTED value="'.$row->pini_id.'">'.$row->pini_project_sub  .'</option>';
                                                else
                                                    echo '<option value="'.$row->pini_id.'">'.$row->pini_project_sub  .'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>  
                                <div class="form-group">
                                    <label>Risk Title : </label>
                                    <input value="<?= $row_old_data->pris_risk_title ?>" type="text" class="form-control" name="txt_ris_til"  autocomplete="off" required="">
                                </div>
                                <div class="form-group">
                                    <label>Description : </label>
                                    <textarea name="txt_des" id="input" class="form-control" rows="3"><?= $row_old_data->pris_description ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-6 text-center">
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


<?php include_once '../layout/footer.php' ?>
