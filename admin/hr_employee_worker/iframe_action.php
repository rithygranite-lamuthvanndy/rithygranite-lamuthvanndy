<?php 
    $menu_active =1;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
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

<link rel="stylesheet" type="text/css" href="../../assets/global/plugins/select2/css/select2.min.css">
<link href="../../assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
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

<?php 
    if(isset($_POST['btn_submit'])){
        
        $v1_id = @$_POST['txt_id'];
        $v_note = @$connect->real_escape_string($_POST['txt_note']);
        $v_act = @$connect->real_escape_string($_POST['cbo_act']);
        
       
        $query_update = "UPDATE `tbl_hr_employee_list` 
            SET 
                `empl_note`='$v_note',
                `empl_act`='$v_act'
            WHERE `empl_id`='$v1_id'";
            
       
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
    $v2_id = @$_GET['v2_id'];
    $old_data = $connect->query("SELECT * FROM tbl_hr_employee_list WHERE empl_id='$v2_id'");
    $row_old_data = mysqli_fetch_object($old_data);


 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2 style="font-family:'Khmer OS';"><i class="fa fa-plus-circle fa-fw"></i>ធ្វើបច្ចុប្បន្នភាព បុគ្គលិក</h2>
        </div>
    </div>
    <br>
    <br>
    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
            <h3 class="panel-title" style="font-family:'Khmer OS Siemreap';">ព័ត៌មានបុគ្គលិក</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->empl_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-4">
                                            <?php
                                            if($row_old_data->empl_pic == null){
                                                echo '<img width="100%" src="../../img/img_empl/blank.jpg">';
                                            }else{
                                                echo '<img width="100%" src="../../img/img_empl/'.$row_old_data->empl_pic.'" alt="Blank">';
                                                
                                            }
                                            ?>
                            </div>
                            <div class="col-xs-8">
                                <div class="form-group form-md-line-input">

                                    <label>ឈ្មោះ
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <h2 style="font-family:'Khmer OS';"><?= $row_old_data->empl_emloyee_kh ?></h2>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label>សកម្មភាពធ្វើការ * : </label>
                                        <select name="cbo_act" id="inputCbo_position" class="form-control myselect" required="required">
                                            <option value="">*** Select and choose ***</option>
                                            <?php 
                                                $v_result=$connect->query("SELECT * FROM tbl_hr_approved_name_list ORDER BY anl_name");
                                                
                                                while ($row_select=mysqli_fetch_object($v_result)) {
                                                if($row_old_data->empl_act==$row_select->anl_id)
                                                    echo '<option selected value="'.$row_select->anl_id.'">'.$row_select->anl_name.'</option>';
                                                else
                                                    echo '<option value="'.$row_select->anl_id.'">'.$row_select->anl_name.'</option>';
                                                }
                                             ?>
                                        </select>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label>កំណត់ចំណាំ
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <textarea name="txt_note" rows="3" class="form-control" style="font-family:'Khmer OS Siemreap';"><?= $row_old_data->empl_note ?></textarea>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_submit" class="btn green"><i class="fa fa-save fa-fw"></i>Save</button>
                            </div>
                        </div>
                    </div>
                </form>
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
<script src="../../assets/global/plugins/select2/js/select2.full.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.myselect2').select2();
    });
</script>

<!-- <script src="../../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script> -->
<!-- <script src="../../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script> -->
<!-- END THEME LAYOUT SCRIPTS -->


