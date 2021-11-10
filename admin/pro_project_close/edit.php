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
        $v_date_record = @$_POST['txt_date_record'];
        $v_title = @$_POST['txt_title'];
        $v_update = @$_POST['txt_update'];
        $v_conclusion = @$_POST['txt_conclusion'];
        $v_suggest_next = @$_POST['txt_suggest_next'];
        
       
        $query_update = "UPDATE `tbl_pj_project_close` 
            SET 
                pclo_date_record='$v_date_record',
                pclo_project_title='$v_title',
                pclo_project_update='$v_update',
                pclo_conclusion='$v_conclusion',
                pclo_suggest_next='$v_suggest_next'
            WHERE `pclo_id`='$v_id'";
            
       
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
    $old_data = $connect->query("SELECT * FROM tbl_pj_project_close WHERE pclo_id='$edit_id'");
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
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->pclo_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Date Record : </label>
                                    <input type="text" class="form-control" name="txt_date_record" data-provide="datepicker" data-date-format="yyyy-mm-dd" placeholder="date record" autocomplete="off" required="" value="<?= $row_old_data->pclo_date_record ?>">
                                </div>
                                <div class="form-group">
                                    <label>Project Title : </label>
                                    <select name="txt_title" class="form-control">
                                        <option value="">--project title--</option>
                                        <?php 
                                            $get_p_title = $connect->query("SELECT * FROM tbl_pj_project_title ORDEr BY     pti_project_title ASC");
                                            while ($row_title = mysqli_fetch_object($get_p_title)) {
                                                if($row_title->pti_id == $row_old_data->pclo_project_title)
                                                    echo '<option SELECTED value="'.$row_title->pti_id.'">'.$row_title->pti_project_title.'</option>';
                                                else
                                                    echo '<option value="'.$row_title->pti_id.'">'.$row_title->pti_project_title.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Project Update : </label>
                                    <input type="text" class="form-control" name="txt_update"  autocomplete="off" required="" value="<?= $row_old_data->pclo_project_update ?>">
                                </div>
                                <div class="form-group">
                                    <label>Project Conclusion : </label>
                                    <input type="text" class="form-control" name="txt_conclusion"  autocomplete="off" required="" value="<?= $row_old_data->pclo_conclusion ?>">
                                </div>
                                <div class="form-group">
                                    <label>Suggest Next : </label>
                                    <input type="text" class="form-control" name="txt_suggest_next"  autocomplete="off" required="" value="<?= $row_old_data->pclo_suggest_next ?>">
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
