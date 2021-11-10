<?php 
    include_once '../../config/database.php';
?>

<?php
if(isset($_POST['btn_submit_unit'])){
    $v_name = @$_POST['txt_name'];
    $v_note = @$_POST['txt_note'];
    $user_id=@$_SESSION['user']->user_id;

    $query_add = "INSERT INTO tbl_st_unit (
            stun_name,
            stun_note,
            user_id
            ) 
        VALUES(
            '$v_name',
            '$v_note',
            '$user_id'
            )";
    if($connect->query($query_add)){
        $sms = '<div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Successfull!</strong> Data inserted ...
        </div>'; 
    }else{
        $sms = '<div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Error!</strong> Query error ...
        </div>';   
    }
}
else if(isset($_POST['btn_submit_category'])){
    $v_name = @$_POST['txt_name'];
    $v_note = @$_POST['txt_note'];
    $user_id=@$_SESSION['user']->user_id;

    $query_add = "INSERT INTO tbl_inv_category (
            name,
            note,
            user_id
            ) 
        VALUES(
            '$v_name',
            '$v_note',
            '$user_id'
            )";
    if($connect->query($query_add)){
        $sms = '<div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Successfull!</strong> Data inserted ...
        </div>'; 
    }else{
        $sms = '<div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Error!</strong> Query error ...
        </div>';   
    }
}
else if(isset($_POST['btnSaveInvType'])){
    $v_name = @$_POST['txt_name'];
        $v_note = @$_POST['txt_note'];
        $v_user_id = @$_SESSION['user']->user_id;
        $query_add = "INSERT INTO  tbl_inv_pro_type (
                name,
                note,
                user_id                
                ) 
            VALUES(
                '$v_name',
                '$v_note',
                '$v_user_id'
                )";
    if($connect->query($query_add)){
        $sms = '<div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Successfull!</strong> Data inserted ...
        </div>'; 
    }else{
        $sms = '<div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Error!</strong> Query error ...
        </div>';   
    }
}
?>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
<!-- END GLOBAL MANDATORY STYLES -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="../../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN THEME GLOBAL STYLES -->
<link href="../../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="../../assets/global/css/components-rounded.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="../../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
<!-- END THEME GLOBAL STYLES -->

<!-- BEGIN THEME LAYOUT STYLES -->
<link href="../../assets/layouts/layout4/css/layout.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/layouts/layout4/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
<link href="../../assets/layouts/layout4/css/custom.min.css" rel="stylesheet" type="text/css" />
<!-- END THEME LAYOUT STYLES -->


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms; ?>
        </div>
    </div>
    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Input Information</h3>
            </div>
            <div class="panel-body">
                <?php if(@$_GET['status']=='pro_type'){ ?>
                    <form action="#" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group form-md-line-input">
                                        <input type="text" class="form-control" name="txt_name"  autocomplete="off">
                                        <label>Product Type Name :
                                            <span class="required" aria-required="true"></span>
                                        </label>
                                    </div>
                                    <div class="form-group form-md-line-input">
                                        <textarea name="txt_note" id="inputTxt_note" class="form-control" rows="5"></textarea>
                                        <label>Note :
                                            <span aria-required="true"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" name="btn_submit_pro_type" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
                                </div>
                            </div>
                        </div>
                    </form><br>
                <?php }else if(@$_GET['status']=='unit'){ ?>
                    <form action="#" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group form-md-line-input">
                                        <input type="text" class="form-control" name="txt_name"  autocomplete="off">
                                        <label>Product Unit Name :
                                            <span class="required" aria-required="true"></span>
                                        </label>
                                    </div>
                                    <div class="form-group form-md-line-input">
                                        <textarea name="txt_note" id="inputTxt_note" class="form-control" rows="5"></textarea>
                                        <label>Note :
                                            <span aria-required="true"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" name="btn_submit_unit" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
                                </div>
                            </div>
                        </div>
                    </form><br>
                <?php }else if(@$_GET['status']=='category'){ ?>
                    <form action="#" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group form-md-line-input">
                                        <input type="text" class="form-control" name="txt_name"  autocomplete="off">
                                        <label>Product Category Name :
                                            <span class="required" aria-required="true"></span>
                                        </label>
                                    </div>
                                    <div class="form-group form-md-line-input">
                                        <textarea name="txt_note" id="inputTxt_note" class="form-control" rows="5"></textarea>
                                        <label>Note :
                                            <span aria-required="true"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" name="btn_submit_category" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
                                </div>
                            </div>
                        </div>
                    </form><br>
                <?php } else if(@$_GET['status']=='inv_type'){ ?>
                    <form action="#" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Name: </label>
                                        <input type="text" class="form-control" name="txt_name" required=""  autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Note : </label>
                                        <textarea type="text" class="form-control" name="txt_note" style="height: 80px;" autocomplete="off"></textarea>
                                    </div>
                                </div>
                            </div>

                            
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-6 text-center">
                                    <button type="submit" name="btnSaveInvType" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
                                   <!--  <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a> -->
                                </div>
                            </div>
                        </div>
                    </form><br>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- BEGIN CORE PLUGINS -->
<script src="../../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="../../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="../../assets/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../assets/pages/scripts/table-datatables-buttons.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="../../assets/layouts/layout4/scripts/layout.min.js" type="text/javascript"></script>
<script src="../../assets/layouts/layout4/scripts/demo.min.js" type="text/javascript"></script>
<!-- <script src="../../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script> -->
<!-- <script src="../../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script> -->
<!-- END THEME LAYOUT SCRIPTS -->

