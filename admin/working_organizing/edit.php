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
        $v_description = @$connect->real_escape_string($_POST['txt_description']);
        $v_employee = @$connect->real_escape_string($_POST['txt_employee']);
        $v_note = @$connect->real_escape_string($_POST['txt_note']);
        $v_user_id = @$_SESSION['user']->user_id;
        
       
        $query_update = "UPDATE `tbl_working_organizing` 
            SET 
                `wfor_date_record`='$v_date_record',
                `wfor_topic_plan`='$v_topic_plan',
                `wfor_description`='$v_description',
                `wfor_employee`='$v_employee',
                `wfor_note`='$v_note',
                `user_id`='$v_user_id'
            WHERE `wfor_id`='$v_id'";
            
       
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
    $old_data = $connect->query("SELECT * FROM tbl_working_organizing WHERE wfor_id='$edit_id'");
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
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->wfor_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Date Record :
                                    <span class="required text-danger" aria-required="true">*</span>
                                </label>
                                <input type="date" value="<?= $row_old_data->wfor_date_record ?>" name="txt_date_record" class="form-control" required="">
                                <br>

                                <label>Topic Plan :
                                    <span class="required text-danger" aria-required="true">*</span>
                                </label>
                                    <select class="form-control" name="txt_topic_plan" required="required">
                                        <option value="">=== Please Choose ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_working_planning ORDER BY wfpl_id ASC");
                                            while ($row_select = mysqli_fetch_object($v_select)) {
                                                if($row_select->wfpl_id==$row_old_data->wfor_topic_plan){
                                                    echo '<option SELECTED="SELECTED" value="'.$row_select->wfpl_id.'">'.$row_select->wfpl_topic_plan.'</option>'; 
                                                }else{
                                                    echo '<option value="'.$row_select->wfpl_id.'">'.$row_select->wfpl_topic_plan.'</option>';
                                                }
                                            }
                                         ?>
                                    </select>
                                <br>

                                <label>Description :
                                    <span class="required text-danger" aria-required="true">*</span>
                                </label>
                                <input type="text" value="<?= $row_old_data->wfor_description ?>" name="txt_description" class="form-control" required="">
                                <br>

                                <label>Employee :
                                    <span class="required text-danger" aria-required="true">*</span>
                                </label>
                                    <select class="form-control" name="txt_employee" required="required">
                                        <option value="">=== Please Choose ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_employee ORDER BY emp_id ASC");
                                            while ($row_select = mysqli_fetch_object($v_select)) {
                                                if($row_select->emp_id==$row_old_data->wfor_employee){
                                                    echo '<option SELECTED="SELECTED" value="'.$row_select->emp_id.'">'.$row_select->emp_name.'</option>'; 
                                                }else{
                                                    echo '<option value="'.$row_select->emp_id.'">'.$row_select->emp_name.'</option>';
                                                }
                                            }
                                         ?>
                                    </select>
                                <br>

                                <label>Note
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <textarea name="txt_note" rows="4" class="form-control"><?= $row_old_data->wfor_note ?></textarea>
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
