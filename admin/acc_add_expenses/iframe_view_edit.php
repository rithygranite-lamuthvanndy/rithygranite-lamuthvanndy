<?php 
    $menu_active =33;
    $layout_title = "Welcome";
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
        $v_date = @$_POST['txt_date'];
        $v_emp_id = @$_POST['txt_emp_id'];
        $v_salary_up = @$_POST['txt_salary_up'];
        $v_note = @$_POST['txt_note'];

        $query_add = "INSERT INTO tbl_hr_employee_salary_up(
                emup_date,
                emup_emp_id,
                emup_salary_up,
                emup_note
                ) 
            VALUES(
                '$v_date',
                '$v_emp_id',
                '$v_salary_up',
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

 ?>


<div class="portlet light bordered" style="width: 100%; height: 100%;">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Add Bill</h2>
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
    <div class="col-md-6">
        <label>Supplier៖
            <span class="required" aria-required="true">*</span>
        </label>
        <select name="txt_emp_id" id="input" class="form-control myselect2" required="required">
            <option value="">*** Select Descrition***</option>
            <?php 
                $v_result=$connect->query("SELECT * FROM tbl_hr_employee_list ORDER BY empl_id");
                while ($row_select=mysqli_fetch_object($v_result)) {
                                                  
                echo '<option value="'.$row_select->empl_id.'">'.$row_select->empl_emloyee_en.'</option>';   
                }
             ?>
        </select>
        <table width="100%">
            <tr>
                <th>Mailing address</th>
                <th>Terms</th>
                <th>Bill date</th>
                <th>Due date</th>
                <th>Bill no.</th>
            </tr>
            <tr>
                <td>
                    <textarea name="txt_note" rows="5" class="form-control"></textarea>
                </td>
                <td>
                    <select name="txt_emp_id" id="input" class="form-control myselect2" required="required">
                        <option value="">*** Select Descrition***</option>
                        <?php 
                            $v_result=$connect->query("SELECT * FROM tbl_hr_employee_list ORDER BY empl_id");
                            while ($row_select=mysqli_fetch_object($v_result)) {
                                                              
                            echo '<option value="'.$row_select->empl_id.'">'.$row_select->empl_emloyee_en.'</option>';   
                            }
                         ?>
                    </select>
                </td>
                <td></td>
                <td>
<div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                        <input type="text" class="form-control" value="<?= date('M-Y') ?>" name="txt_date" placeholder="Choose Date" required="" aufocomplete="off">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                    </div>
                </td>
                <td></td>
            </tr>
        </table>        
    </div>
    <div class="col-md-6">
        
    </div>
    <div class="col-xs-12"> 

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
                                <label for="inputCbo_position">Salary Date: </label>
                                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                        <input type="text" class="form-control" value="<?= date('M-Y') ?>" name="txt_date" placeholder="Choose Date" required="" aufocomplete="off">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                    </div>
                                <br>
                                <label>Employee Name / ឈ្មោះបុគ្គលិក៖
                                    <span class="required" aria-required="true">*</span>
                                </label>

                                        <select name="txt_emp_id" id="input" class="form-control myselect2" required="required">
                                            <option value="">*** Select Descrition***</option>
                                            <?php 
                                                $v_result=$connect->query("SELECT * FROM tbl_hr_employee_list ORDER BY empl_id");
                                                while ($row_select=mysqli_fetch_object($v_result)) {
                                                  
                                                    echo '<option value="'.$row_select->empl_id.'">'.$row_select->empl_emloyee_en.'</option>';   
                                                }
                                             ?>
                                        </select>


                                <br>
                                <label>Position: </label>
                                    <input name="txt_position" type="text" class="form-control"  required="" readonly="" placeholder="Auto Fill...">
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Salary Default: </label>
                                    <input name="txt_salary_df" onkeyup="calculate_money()" type="text" class="form-control"   required="" readonly="" placeholder="Auto Fill..." >
                                <label>Salary Up: </label>
                                    <input name="txt_salary_up" onkeyup="calculate_money()" type="text" class="form-control" value="0" >
                                <label>Total Salary: </label>
                                    <input name="txt_total" type="text" class="form-control" id="salary_tt" value="calculating"   required="" readonly="">
                                <label>Note /ចំណាំ
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <textarea name="txt_note" rows="10" class="form-control"></textarea>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_submit" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
                                <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <button type="submit" name="btn_submit" class="btn blue btn-circle"><i class="fa fa-save fa-fw"></i>Save</button>
                                <a href="index.php" class="btn red btn-circle">Save and Close <i class="fa fa-angle-down"></i></a>
    </div>
    <button type="submit" name="btn_submit" class="btn blue btn-circle">Cancel</button>
    
  </footer>
</div>

<script>
    function calculate_money(){
        $v_salary_df=$('input[name=txt_salary_df]').val();
        $v_salary_up1=$('input[name=txt_salary_up]').val();
        $v_amount=parseFloat($v_salary_df)+parseFloat($v_salary_up1);
        //$('input#salary_tt').val(formatter.format($v_amount));
        //document.getElementById("txt_total").innerHTML = formatter.format($v_amount);
        $('input#salary_tt').val(Math.floor($v_amount));
    }
    $(document).ready(function () {
        $('select[name=txt_emp_id]').change(function () {
            let v_emp_id=$(this).val();
            $.ajax({url: 'ajx_get_salary_info.php?v_emp_id='+v_emp_id,success:function (result) {
                var myObj=JSON.parse(result);
                $('input[name=txt_position]').val(myObj['empl_po']);
                $('input[name=txt_salary_df]').val(myObj['empl_salary1']);

            }});
        });
    });
</script>

<script type="text/javascript" src="../../plugin/ckeditor_4.7.0_full/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace( 'detail', {
        language: 'en',
      height: '100%'
        // uiColor: '#9AB8F3'
    });
</script>

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
