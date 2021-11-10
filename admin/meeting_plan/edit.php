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
        $v_date_meeting = @$_POST['txt_date_meeting'];
        $v_category = @$_POST['cbo_category'];
        $v_location = @$_POST['txt_location'];
        $v_time= @$_POST['txt_time'];
        $v_topic = @$_POST['txt_topic'];
        $v_reason = @$_POST['txt_reason'];
        $v_description = @$_POST['txt_description'];
        $v_note = @$_POST['txt_note'];
        $v_meeting_no= @$_POST['txt_meeting_no'];
        $v_user_id = @$_SESSION['user']->user_id;
        $date_audit = date("Y-m-d H:i:s");
   

        $query_update = "UPDATE tbl_meeting_plan SET    meetp_date_meeting='$v_date_meeting',
                                                            meetp_location='$v_location',
                                                            meetp_time='$v_time',
                                                            meetp_topic='$v_topic',
                                                            meetp_reason='$v_reason',
                                                            meetp_description='$v_description',
                                                            meetp_note='$v_note',
                                                            date_audit='$date_audit',
                                                            meetp_meting_no='$v_meeting_no',
                                                            user_id='$v_user_id',
                                                            cat_id='$v_category'
                                        WHERE meetp_id='$v_id'";

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
        $old_data = $connect->query("SELECT * FROM tbl_meeting_plan WHERE meetp_id='$edit_id'");
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
                    <input type="hidden" name="txt_id" value="<?= $row_user->meetp_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="date" value="<?= $row_user->meetp_date_meeting ?>" class="form-control" name="txt_date_meeting" required="required" autocomplete="off">
                                    <label>Date Meeting :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <select name="cbo_category" id="input" class="form-control" required="required">
                                        <option value="">=== Choose and Select ===</option>
                                        <?php 
                                            $sql=$connect->query("SELECT * FROM tbl_meeting_category ORDER BY cat_name ASC");
                                            while ($row=mysqli_fetch_object($sql)) {
                                                if($row_user->cat_id==$row->cat_id)
                                                    echo '<option SELECTED value="'.$row->cat_id.'">'.$row->cat_name.'</option>';
                                                else
                                                    echo '<option value="'.$row->cat_id.'">'.$row->cat_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                    <label>Catetegory Planing :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" value="<?= $row_user->meetp_meting_no?>" name="txt_meeting_no" required="required" autocomplete="off">
                                    <label>Meeting No :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" value="<?= $row_user->meetp_location ?>" class="form-control" name="txt_location" required="required" autocomplete="off">
                                    <label>Location (Where) :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                        
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" value="<?= $row_user->meetp_time ?>" class="form-control" name="txt_time" required="required" autocomplete="off">
                                    <label>Time (When) :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" value="<?= $row_user->meetp_topic ?>" class="form-control" name="txt_topic" required="required" autocomplete="off">
                                    <label>Topic (What) :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                        
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" value="<?= $row_user->meetp_reason ?>" class="form-control" name="txt_reason" required="required" autocomplete="off">
                                    <label>Reason (Why) :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" value="<?= $row_user->meetp_description ?>" class="form-control" name="txt_description" required="required" autocomplete="off">
                                    <label>Description (How) :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                               <div class="form-group form-md-line-input">
                                    <textarea class="form-control" name="txt_note" ><?= $row_user->meetp_note ?></textarea>
                                    <label>Note :</label>
                                </div>
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
