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
        $v_ris_tit = @$_POST['txt_ris_tit'];
        $v_ris_upd = @$_POST['txt_ris_upd'];
        $v_note = @$_POST['txt_note'];
        
       
        $query_update = "UPDATE tbl_pj_control_risk SET 
                cris_date_record='$v_date',
                cris_risk_title='$v_ris_tit',
                cris_risk_update='$v_ris_upd',
                cris_note='$v_note'
            WHERE cris_id='$v_id'";
            
       
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
    $old_data = $connect->query("SELECT *,PCR.user_id AS id,PCR.date_audit AS audit FROM tbl_pj_control_risk AS PCR
                        LEFT JOIN tbl_pj_risk_update AS PRU ON PCR.cris_risk_update=PRU.drup_id
                        LEFT JOIN tbl_pj_risk_management AS PRM ON PCR.cris_risk_title=PRM.pris_id
                        LEFT JOIN tbl_pj_project_title AS PPT ON PRM.pris_project_title=PPT.pti_id
                        LEFT JOIN tbl_pj_project_initiation AS PPI ON PRM.pris_project_sub=PPI.pini_id
                         WHERE cris_id='$edit_id'");
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
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->cris_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Date Record : </label>
                                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                        <input value="<?= $row_old_data->cris_date_record ?>" type="text" class="form-control" placeholder="YYYY-MM-DD" name="txt_date" required="required"  autocomplete="off">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Risk Title : </label>
                                    <select value="<?= $row_old_data->cris_id ?>" name="txt_ris_tit" id="input" class="form-control" required="">
                                        <option value="">=== Select Risk Title ===</option>
                                        <?php 
                                            $sql=$connect->query("SELECT * FROM tbl_pj_risk_management AS PRM
                                                LEFT JOIN tbl_pj_project_title AS PPT ON PRM.pris_project_title=PPT.pti_id
                                                LEFT JOIN tbl_pj_project_initiation AS PPI ON PRM.pris_project_sub=PPI.pini_id");
                                            while ($row=mysqli_fetch_object($sql)) {
                                                if($row_old_data->cris_risk_title==$row->pti_id)
                                                    echo '<option SELECTED value="'.$row->pti_id.'">'.$row->pti_project_title.'::'.$row->pini_project_sub.'::'.$row->pris_risk_title.'</option>';
                                                else
                                                    echo '<option value="'.$row->pti_id.'">'.$row->pti_project_title.'::'.$row->pini_project_sub.'::'.$row->pris_risk_title.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>    
                                <div class="form-group">
                                    <label>Risk Update : </label>
                                    <select value="<?= $row_old_data->cris_id ?>" name="txt_ris_upd" id="input" class="form-control" required="">
                                        <option value="">=== Select Risk Update ===</option>
                                        <?php 
                                            $sql=$connect->query("SELECT * FROM tbl_pj_risk_update ORDER BY drup_name");
                                            while ($row=mysqli_fetch_object($sql)) {
                                                if($row_old_data->cris_risk_update==$row->drup_id)
                                                    echo '<option SELECTED value="'.$row->drup_id.'">'.$row->drup_name.'</option>';
                                                else
                                                    echo '<option value="'.$row->drup_id.'">'.$row->drup_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Note : </label>
                                    <textarea name="txt_note" id="input" class="form-control" rows="5"><?= $row_old_data->cris_note ?></textarea>
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



<script type="text/javascript" src="../../plugin/ckeditor_4.7.0_full/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace( 'detail', {
        language: 'en',
      height: '700'
        // uiColor: '#9AB8F3'
    });
</script>


<?php include_once '../layout/footer.php' ?>
