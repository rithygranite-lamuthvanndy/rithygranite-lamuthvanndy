<?php 
    include_once '../../config/database.php';
?>

<?php
if(isset($_POST['btn_save_des'])){
    $v_code = @$connect->real_escape_string($_POST['txt_code']);
    $v_name = @$connect->real_escape_string($_POST['txt_name']);
    $v_chart_acc_id = @$connect->real_escape_string($_POST['cbo_chart_acc']);
    $v_note = @$connect->real_escape_string($_POST['txt_note']);
    $user_id=$_SESSION['user_id'];
    $query_add = "INSERT INTO tbl_acc_decription (
            chart_of_acc_id,
            des_code,
            des_name,
            des_note,
            user_id
            ) 
        VALUES(
            '$v_chart_acc_id',
            '$v_code',
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
?>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/select2/css/select2.min.css" rel="stylesheet"/>
<link href="../../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
<!-- END GLOBAL MANDATORY STYLES -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="../../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="../../assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
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
                <?php if(@$_GET['p_status']=='des_name'){ ?>
                    <form action="#" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <label>Description Code :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="txt_code"  autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <label>Description Name :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="txt_name" required="required" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <label>Account Name :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                    <select name="cbo_chart_acc" id="inputTxt_chart_acc" class="form-control myselect2">
                                        <option value="">=== Select and Choose ===</option>
                                        <?php 
                                            $v_select=$connect->query("SELECT * FROM tbl_acc_chart_account ORDER BY accca_number ASC");
                                            while ($row_select=mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_select->accca_id.'">'.$row_select->accca_number.' == '.$row_select->accca_account_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <label>Note :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="txt_note"  autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" name="btn_save_des" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
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
<script src="../../assets/global/plugins/bootstrap-select-1.12.4/js/bootstrap-select.min.js" type="text/javascript"></script>
<!-- <script src="../../assets/pages/scripts/table-datatables-buttons.min.js" type="text/javascript"></script> -->
<script src="../../assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>

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

<script type="text/javascript">
    $(document).ready(function () {
        $('.myselect2').select2();
    });
</script>
