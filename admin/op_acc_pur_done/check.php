<?php 
    $menu_active =13;
    $left_active =0;
    $layout_title = "Check Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        
        $v_id = @$_POST['txt_id'];
        $v_check = @$_POST['cbo_check'];
        $v_date = @$_POST['txt_date'];
        $v_note = @$_POST['txt_note'];
        
       
        $query_update = "UPDATE `tbl_acc_request_form` 
            SET 
                man_app_by='$v_check',
                man_app_date='$v_date',
                man_app_comment='$v_note'
            WHERE `req_id`='$v_id'";
                            
       
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
    $sent_id = @$_GET['sent_id'];
    $old_data = $connect->query("SELECT * FROM tbl_acc_request_form WHERE req_id='$sent_id'");
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
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->req_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Date Record :
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <?php 
                                    if($row_old_data->man_app_date!='0000-00-00')
                                        $date=$row_old_data->man_app_date;
                                    else
                                        $date=date('Y-m-d');
                                 ?>
                                <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" value="<?= $date ?>" name="txt_date" class="form-control" required="">
                                <br>
                                <br>
                                <label>Approved By :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <select class="form-control" name="cbo_check">
                                    <option value="">=== Please choose and select ===</option>
                                    <?php 
                                        $v_select = $connect->query("SELECT * FROM tbl_acc_approved_name_list ORDER BY apn_name ASC");
                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                            if($row_data->apn_id == @$row_old_data->man_app_by){
                                                echo '<option SELECTED value="'.$row_data->apn_id.'">'.$row_data->apn_name.'</option>';
                                                
                                            }else{
                                                echo '<option value="'.$row_data->apn_id.'">'.$row_data->apn_name.'</option>';

                                            }
                                        }
                                     ?>
                                </select>
                                <br>
                                 <label>Note :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <?php 
                                    if($row_old_data->man_app_comment)$note=$row_old_data->man_app_comment;
                                    else $note="";
                                 ?>
                                <textarea name="txt_note" id="inputTxt_note" class="form-control" rows="3"><?= $note ?></textarea>
                                <br>
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
