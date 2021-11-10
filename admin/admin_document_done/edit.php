<?php 
    $menu_active =44;
    $left_active =0;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        
        $v_id= @$_POST['txt_id'];
        $v_don_date= @$_POST['txt_don_date'];
        $v_done= @$_POST['cbo_done'];
        $v_sign_by= @$_POST['cbo_sign_by'];
        $v_app_by= @$_POST['cbo_app_by'];
       
        $query_update = "UPDATE tbl_admin_document_request 
            SET 
            docr_done='$v_done',
            docr_done_date='$v_don_date',
            docr_sign_by='$v_sign_by',
            docr_approved_by='$v_app_by'
            WHERE docr_id='$v_id'";
            
       
        if($connect->query($query_update)){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data Update ...
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
    $old_data = $connect->query("SELECT * FROM  tbl_admin_document_request WHERE docr_id='$edit_id'");
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
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->docr_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for ="">Done Date:</label>   
                                    <?php 
                                        $v_done_date=($row_old_data->docr_done_date!='0000-00-00')?($row_old_data->docr_done_date):date('Y-m-d');
                                     ?> 
                                    <input class="form-control" required name="txt_don_date" type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" placeholder="date..." autocomplete="off" value="<?= $v_done_date ?>">  
                                </div>
                                <div class="form-group">
                                    <label>Done: </label>   
                                    <select name="cbo_done" class="form-control" required="required">
                                        <option value="">=== Select Done here ===</option>
                                        <?php 
                                            $sql=$connect->query("SELECT * FROM tbl_admin_done_list ORDER BY do_id DESC");
                                            while ($row=mysqli_fetch_object($sql)) {
                                                if($row_old_data->docr_done==$row->do_id)
                                                    echo '<option SELECTED value="'.$row->do_id.'">'.$row->do_name.'</option>';
                                                else
                                                    echo '<option value="'.$row->do_id.'">'.$row->do_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Sign By: </label>   
                                    <select name="cbo_sign_by" class="form-control" required="required">
                                        <option value="">=== Select Sign By here ===</option>
                                        <?php 
                                            $sql=$connect->query("SELECT * FROM tbl_admin_sign_name_list ORDER BY snl_id DESC");
                                            while ($row=mysqli_fetch_object($sql)) {
                                                if($row_old_data->docr_sign_by==$row->snl_id)
                                                    echo '<option SELECTED value="'.$row->snl_id.'">'.$row->snl_name.'</option>';
                                                else
                                                    echo '<option value="'.$row->snl_id.'">'.$row->snl_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Approved By: </label>   
                                    <select name="cbo_app_by" class="form-control" required="required">
                                        <option value="">=== Select Approved By here ===</option>
                                        <?php 
                                            $sql=$connect->query("SELECT * FROM tbl_admin_approved_name_list ORDER BY anl_id DESC");
                                            while ($row=mysqli_fetch_object($sql)) {
                                                if($row_old_data->docr_approved_by==$row->anl_id)
                                                    echo '<option SELECTED value="'.$row->anl_id.'">'.$row->anl_name.'</option>';
                                                else
                                                    echo '<option value="'.$row->anl_id.'">'.$row->anl_name.'</option>';
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
