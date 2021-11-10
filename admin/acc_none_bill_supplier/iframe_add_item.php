<?php 
    include_once '../../config/database.php';
?>

<?php
if(isset($_POST['btn_save_sup_name'])){
    $v_date = @$_POST['txt_date'];
    $v_name = @$_POST['txt_name'];
    $v_type = @$_POST['txt_type'];
    $v_phone_number = @$_POST['txt_number'];
    $v_emial = @$_POST['txt_email'];
    $v_address = @$_POST['txt_address'];
    $v_note = @$_POST['txt_note'];
    $v_user_id = @$_SESSION['user']->user_id;
    

    $query_add = "INSERT INTO tbl_sup_supplier_info (
            supsi_date_record,
            supsi_name,
            supsi_type,
            supsi_phone,
            supsi_email,
            supsi_address,
            supsi_note                
            ) 
        VALUES(
            '$v_date',
            '$v_name',
            '$v_type',
            '$v_phone_number',
            '$v_emial',
            '$v_address',
            '$v_note'
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
else if(isset($_POST['btn_save_item_name'])){
    $v_date_record = @$_POST['txt_date_record'];
    $v_code = @$_POST['txt_code'];
    $v_item_en = @$_POST['txt_name_en'];
    $v_item_kh = @$_POST['txt_name_kh'];
    $v_unit = @$_POST['txt_unit'];
    $v_pro_type = @$_POST['cbo_pro_type'];
    $v_category = @$_POST['txt_category'];
    $v_employee = @$_POST['txt_employee'];
    $v_note = @$_POST['txt_note'];
    $v_user_id = @$_SESSION['user']->user_id;
    

    $query_add = "INSERT INTO tbl_st_product_name (
                stpron_date_record,
                stpron_code,
                stpron_name_en,
                stpron_name_kh,
                stpron_unit,
                stpron_pro_type,
                stpron_category,
                stpron_employee,
                stpron_note,
                user_id                
                ) 
            VALUES(
                '$v_date_record',
                '$v_code',
                '$v_item_en',
                '$v_item_kh',
                '$v_unit',
                '$$v_pro_type',
                '$v_category',
                '$v_employee',
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
                <?php if(@$_GET['p_status']=='supp_name'){ ?>
                    <form action="#" method="post" enctype="multipart/form-data">
                        <div class="form-body">
	                        <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Date Record :
                                        </label>
                                        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                            <input type="text" class="form-control" placeholder="Choose Date" required="" aufocomplete="off" name="txt_date">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Name : </label>
                                        <input type="text" class="form-control" name="txt_name" required=""  autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Type : </label>
                                        <select type="text" class="form-control" name="txt_type" required="" autocomplete="off">
                                            <option value="">==choose type==</option>
                                            <?php 
                                                $get_cus_type=$connect->query("SELECT * FROM tbl_sup_type ORDER BY supct_name ASC");
                                                while($row_cus_type = mysqli_fetch_object($get_cus_type)){
                                                    echo '<option value="'.$row_cus_type->supct_id.'">'.$row_cus_type->supct_name.'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Phone Number : </label>
                                        <input type="text" class="form-control" name="txt_number" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Email : </label>
                                        <input type="text" class="form-control" name="txt_email" autocomplete="off">
                                    </div>

                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Address : </label>
                                        <textarea type="text" class="form-control" name="txt_address" style="height: 125px;" autocomplete="off"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Note : </label>
                                        <textarea type="text" class="form-control" name="txt_note" style="height: 163px;" autocomplete="off"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" name="btn_save_sup_name" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
                                </div>
                            </div>
                        </div>
                    </form><br>
                <?php }else if(@$_GET['p_status']=='item_name'){ ?>
                    <form action="#" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Date Record :
                                        </label>
                                        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                            <input type="text" class="form-control" placeholder="Choose Date" required="" aufocomplete="off" name="txt_date_record">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Product Code : </label>
                                        <input type="text" class="form-control" name="txt_code" required=""  autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Name EN : </label>
                                        <input type="text" class="form-control" name="txt_name_en" required=""  autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Name KH : </label>
                                        <input type="text" class="form-control" name="txt_name_kh" required=""  autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Production Type : </label>
                                        <select type="text" class="form-control myselect2" name="cbo_pro_type" required="" autocomplete="off">
                                            <option value="">=== Select and choose===</option>
                                            <?php 
                                                $get_select=$connect->query("SELECT * FROM tbl_st_product_type ORDER BY name ASC");
                                                while($row_data = mysqli_fetch_object($get_select)){
                                                    echo '<option value="'.$row_data->id.'">'.$row_data->name.'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Unit : </label>
                                        <select type="text" class="form-control myselect2" name="txt_unit" required="" autocomplete="off">
                                            <option value="">=== Select and choose===</option>
                                            <?php 
                                                $get_select=$connect->query("SELECT * FROM tbl_st_unit ORDER BY stun_name ASC");
                                                while($row_data = mysqli_fetch_object($get_select)){
                                                    echo '<option value="'.$row_data->stun_id.'">'.$row_data->stun_name.'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Category : </label>
                                        <select type="text" class="form-control myselect2" name="txt_category" required="" autocomplete="off">
                                            <option value="">=== Select and choose===</option>
                                            <?php 
                                                $get_select=$connect->query("SELECT * FROM tbl_st_category ORDER BY stca_name ASC");
                                                while($row_data = mysqli_fetch_object($get_select)){
                                                    echo '<option value="'.$row_data->stca_id.'">'.$row_data->stca_name.'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Employee : </label>
                                        <select type="text" class="form-control myselect2" name="txt_employee" autocomplete="off">
                                            <option value="">=== Select and choose===</option>
                                            <?php 
                                                $get_select=$connect->query("SELECT * FROM tbl_st_employee ORDER BY stemp_name ASC");
                                                while($row_data = mysqli_fetch_object($get_select)){
                                                    echo '<option value="'.$row_data->stemp_id.'">'.$row_data->stemp_name.'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Note : </label>
                                        <textarea type="text" class="form-control" name="txt_note" rows="5" autocomplete="off"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" name="btn_save_item_name" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
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
