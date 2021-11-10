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
        $v_date_meeting= @$_POST['txt_date_meeting'];
        $v_time= @$_POST['txt_time'];
        $v_step= @$_POST['txt_step'];
        $v_topic_agen= @$_POST['txt_topic_agen'];
        $v_des= @$_POST['txt_des'];
        $v_leader_name= @$_POST['cbo_leader_name'];
        $v_qty= @$_POST['txt_qty'];
        $v_note= @$_POST['txt_note'];

        $v_user_id = @$_SESSION['user']->user_id;
        $date_audit = date("Y-m-d H:i:s");
   

        $query_update = "UPDATE tbl_meeting_record SET mr_date_record='$v_date_meeting'
                                                ,mr_time='$v_time'   
                                                ,mr_plan_referent='$v_meeting_no'
                                                ,mr_step='$v_step'
                                                ,mr_topic_agenda='$v_topic_agen'    
                                                ,mr_description='$v_des'
                                                ,mr_leader_name='$v_leader_name'
                                                ,mr_qty_joiner='$v_qty'
                                                ,mr_note='$v_note'
                                                ,user_id='$v_user_id'
                                                ,date_audit='$date_audit'
                                        WHERE mr_id='$v_id'";

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
        $old_data = $connect->query("SELECT * FROM tbl_meeting_record WHERE mr_id='$edit_id'");
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
                                                if($row_data->meetp_id==$row_user->mr_plan_referent)
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
                                    <input type="date" class="form-control" value="<?= $row_user->mr_date_record ?>" name="txt_date_meeting" required="required" autocomplete="off">
                                    <label>Date Meeting :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" value="<?= $row_user->mr_time ?>" name="txt_time" required="required" autocomplete="off">
                                    <label>Meeting Time :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" value="<?= $row_user->mr_step ?>" name="txt_step" required="required" autocomplete="off">
                                    <label>Meeting Step :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" value="<?= $row_user->mr_topic_agenda ?>" name="txt_topic_agen" required="required" autocomplete="off">
                                    <label>Meeting Topic Agenda :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" value="<?= $row_user->mr_description ?>" name="txt_des" required="required" autocomplete="off">
                                    <label>Meeting Decription :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                   <select class="form-control" name="cbo_leader_name">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_meeting_name_list ORDER BY mnl_name ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                if($row_data->mnl_id==$row_user->mr_leader_name)
                                                    echo '<option SELECTED value="'.$row_data->mnl_id.'">'.$row_data->mnl_name.'</option>';
                                                else
                                                    echo '<option value="'.$row_data->mnl_id.'">'.$row_data->mnl_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                    <label>Leader Name :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" value="<?= $row_user->mr_qty_joiner ?>" name="txt_qty" required="required" autocomplete="off">
                                    <label>Qty Joiner :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group form-md-line-input">
                                    <textarea name="txt_note" id="input" class="form-control" rows="3"><?= $row_user->mr_note ?></textarea>
                                    <label>Meeting Note :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-md-12 col-lg-12 text-center">
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
