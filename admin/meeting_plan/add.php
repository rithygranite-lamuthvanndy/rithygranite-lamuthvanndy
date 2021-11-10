<?php 
    $menu_active =101;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>

<?php 
    if(isset($_POST['btn_add'])){
        $v_date_meeting = @$_POST['txt_date_meeting'];
        $v_category = @$_POST['cbo_category'];
        $v_location = @$_POST['txt_location'];
        $v_time= @$_POST['txt_time'];
        $v_topic = @$_POST['txt_topic'];
        $v_reason = @$_POST['txt_reason'];
        $v_description = @$_POST['txt_description'];
        $v_note = @$_POST['txt_note'];
        $v_meeting_no= @$_POST['txt_meeting_no'];
        $date_audit = date("Y-m-d H:i:s");
        $v_user_id = @$_SESSION['user']->user_id;
        
            $query_add = "INSERT INTO tbl_meeting_plan (meetp_date_meeting
                                                ,meetp_location
                                                ,meetp_meting_no
                                                ,meetp_time
                                                ,meetp_topic
                                                ,meetp_reason
                                                ,meetp_description
                                                ,meetp_note
                                                ,user_id
                                                ,date_audit
                                                ,cat_id
                                                ) 

                                        VALUES('$v_date_meeting'
                                                ,'$v_location'
                                                ,'$v_meeting_no'
                                                ,'$v_time'
                                                ,'$v_topic'
                                                ,'$v_reason'
                                                ,'$v_description'
                                                ,'$v_note'
                                                ,'$v_user_id'
                                                ,'$date_audit'
                                                ,'$v_category'
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
                                    <input type="date" class="form-control" name="txt_date_meeting" required="required" autocomplete="off">
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
                                    <input type="text" class="form-control" name="txt_meeting_no" required="required" autocomplete="off">
                                    <label>Meeting No :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_location" required="required" autocomplete="off">
                                    <label>Location (Where) :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                        
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_time" required="required" autocomplete="off">
                                    <label>Time (When) :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_topic" required="required" autocomplete="off">
                                    <label>Topic (What) :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                        
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_reason" required="required" autocomplete="off">
                                    <label>Reason (Why) :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_description" required="required" autocomplete="off">
                                    <label>Description (How) :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group form-md-line-input">
                                    <textarea class="form-control" name="txt_note" autocomplete="off"></textarea>
                                    <label>Note :</label>
                                </div>
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
