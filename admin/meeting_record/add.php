<?php 
    $menu_active =101;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>

<?php 
    if(isset($_POST['btn_add'])){
        $v_meeting_no = @$_POST['cbo_meeting_no'];
        $v_date_meeting= @$_POST['txt_date_meeting'];
        $v_time= @$_POST['txt_time'];
        $v_step= @$_POST['txt_step'];
        $v_topic_agen= @$_POST['txt_topic_agen'];
        $v_des= @$_POST['txt_des'];
        $v_leader_name= @$_POST['cbo_leader_name'];
        $v_qty= @$_POST['txt_qty'];
        $v_note= @$_POST['txt_note'];

        $date_audit = date("Y-m-d H:i:s");
        $v_user_id = @$_SESSION['user']->user_id;
        
            $query_add = "INSERT INTO tbl_meeting_record(
                                                mr_date_record
                                                ,mr_time   
                                                ,mr_plan_referent
                                                ,mr_step
                                                ,mr_topic_agenda    
                                                ,mr_description
                                                ,mr_leader_name
                                                ,mr_qty_joiner
                                                ,mr_note
                                                ,user_id
                                                ,date_audit
                                                ) 

                                        VALUES('$v_date_meeting'
                                                ,'$v_time'
                                                ,'$v_meeting_no'
                                                ,'$v_step'
                                                ,'$v_topic_agen'
                                                ,'$v_des'
                                                ,'$v_leader_name'
                                                ,'$v_qty'
                                                ,'$v_note'
                                                ,'$v_user_id'
                                                ,'$date_audit'
                                                )";
            
            if($connect->query($query_add)){
                $sms = '<div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Successfull!</strong> Data inserted ...
                </div>';
                // header("Refresh:2; url=index.php");   
            }else{
                $sms = '<div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Error!</strong> Query error ...
                </div>';
                // header("Refresh:0; url=add.php");    
            }
        
    }

 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-user fa-fw"></i>Add New</h2>
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
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                   <select class="form-control" name="cbo_meeting_no">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_meeting_plan ORDER BY meetp_meting_no ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
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
                                    <input type="date" class="form-control" name="txt_date_meeting" required="required" autocomplete="off">
                                    <label>Date Meeting :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_time" required="required" autocomplete="off">
                                    <label>Meeting Time :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_step" required="required" autocomplete="off">
                                    <label>Meeting Step :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_topic_agen" required="required" autocomplete="off">
                                    <label>Meeting Topic Agenda :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_des" required="required" autocomplete="off">
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
                                    <input type="text" class="form-control" name="txt_qty" required="required" autocomplete="off">
                                    <label>Qty Joiner :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group form-md-line-input">
                                    <textarea name="txt_note" id="input" class="form-control" rows="3"></textarea>
                                    <label>Meeting Note :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 col-sm-6 col-md-6 col-lg-6 text-center">
                                <button type="submit" name="btn_add" class="btn blue"><i class="fa fa-save fa-fw"></i> Save</button>
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
