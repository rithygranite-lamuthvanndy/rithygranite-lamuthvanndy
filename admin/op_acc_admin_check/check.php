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
                adm_check_by='$v_check',
                adm_check_date='$v_date',
                adm_check_comment='$v_note'
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
                                    if($row_old_data->adm_check_date!='0000-00-00')
                                        $date=$row_old_data->adm_check_date;
                                    else
                                        $date=date('Y-m-d');
                                 ?>
                                <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" value="<?= $date ?>" name="txt_date" class="form-control" required="">
                                <br>
                                <br>
                                <label>Check By :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <a class="btn btn-primary btn-xs" data-toggle="modal" href='#check'><i class="fa fa-plus"></i></a>
                                <select class="form-control myselect2" name="cbo_check">
                                    <option value="">=== Please choose and select ===</option>
                                    <?php 
                                        $v_select = $connect->query("SELECT * FROM tbl_acc_check_name_list ORDER BY chn_name ASC");
                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                            if($row_data->chn_id == @$row_old_data->adm_check_by){
                                                echo '<option SELECTED value="'.$row_data->chn_id.'">'.$row_data->chn_name.'</option>';
                                                
                                            }else{
                                                echo '<option value="'.$row_data->chn_id.'">'.$row_data->chn_name.'</option>';

                                            }
                                        }
                                     ?>
                                </select>
                                <br>
                                 <label>Note :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <?php 
                                    if($row_old_data->adm_check_comment)$note=$row_old_data->adm_check_comment;
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



<script type="text/javascript" src="../../assets/global/plugins/jquery.min.js"></script>
<script type="text/javascript">
    $('select[name=cbo_check]').mouseover(function(){
        $.ajax({url: "ajx_get_content_select.php?d=cbo_check", success: function(result){
            if($('select[name=cbo_check]').html().trim() != result.trim()){
                $('select[name=cbo_check]').html(result);
            }
        }});
    });
</script>


<?php include_once '../layout/footer.php' ?>
<div class="modal fade" id="check">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_check_by.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>