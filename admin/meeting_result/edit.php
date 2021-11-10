<?php 
    $menu_active =101;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php

    // btn update 
    if(isset($_POST['btn_update'])){
        $v_id = @$_POST['txt_id'];
        $v_meeting_no = @$_POST['cbo_meeting_no'];
        $v_mee_fee= @$_POST['txt_mee_fee'];
        $v_mee_con= @$_POST['txt_mee_con'];
        $v_mee_iss= @$_POST['txt_mee_iss'];
        $v_mee_imp= @$_POST['txt_mee_imp'];
        $v_next_mee= @$_POST['txt_next_mee'];

        $v_user_id = @$_SESSION['user']->user_id;
        $date_audit = date("Y-m-d H:i:s");
   

        $query_update = "UPDATE tbl_meeting_result SET   mre_meeting_topic='$v_meeting_no'
                                                ,mre_meeting_feedback='$v_mee_fee' 
                                                ,mre_conclusion='$v_mee_con'
                                                ,mre_issue='$v_mee_iss'
                                                ,mre_improvement='$v_mee_imp'
                                                ,mre_next_meeting='$v_next_mee'
                                                ,user_id='$v_user_id'
                                                ,date_audit='$date_audit'
                                        WHERE mre_id='$v_id'";

        if($connect->query($query_update)){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data was updated ...
            </div>'; 
        }else{
            $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> Query error ...
            </div>'; 
        }
    }

    // get old data  
    if(@$_GET['edit_id']!=""){
        $edit_id = @$_GET['edit_id'];
        $old_data = $connect->query("SELECT * FROM tbl_meeting_result WHERE mre_id='$edit_id'");
        $row_user = mysqli_fetch_object($old_data);
    }


 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-user fa-fw"></i>Edit Information</h2>
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
                    <input type="hidden" name="txt_id" value="<?= $edit_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                   <select class="form-control" name="cbo_meeting_no">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_meeting_plan ORDER BY meetp_meting_no ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                if($row_data->meetp_id==$row_user->mre_meeting_topic)
                                                    echo '<option SELECTED value="'.$row_data->meetp_id.'">'.$row_data->meetp_meting_no.'</option>';
                                                else
                                                    echo '<option value="'.$row_data->meetp_id.'">'.$row_data->meetp_meting_no.'</option>';
                                            }
                                         ?>
                                    </select>
                                    <label>Meeting N&deg; :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" value="<?= $row_user->mre_meeting_feedback ?>" name="txt_mee_fee" required="required" autocomplete="off">
                                    <label>Meeting FeedBack :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" value="<?= $row_user->mre_conclusion ?>" name="txt_mee_con" required="required" autocomplete="off">
                                    <label>Meeting Conclusion :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" value="<?= $row_user->mre_issue ?>" name="txt_mee_iss" required="required" autocomplete="off">
                                    <label>Meeting Issue :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                        
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" value="<?= $row_user->mre_improvement ?>" name="txt_mee_imp" required="required" autocomplete="off">
                                    <label>Meeting Improvement :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" value="<?= $row_user->mre_next_meeting ?>" name="txt_next_mee" required="required" autocomplete="off">
                                    <label>Next Meeting :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                        
                        </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 col-sm-6 col-md-6 col-lg-6 text-center">
                                <button type="submit" name="btn_update" class="btn blue"><i class="fa fa-save fa-fw"></i> Save</button>
                                <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i> Cancel</a>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>






<?php include_once '../layout/footer.php' ?>
