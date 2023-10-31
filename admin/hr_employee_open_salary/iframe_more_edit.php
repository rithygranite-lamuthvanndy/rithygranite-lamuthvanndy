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

        $v_id = @$_POST['txt_id'];
        $v_date = @$_POST['txt_date'];
        $v_salary_up = @$_POST['txt_salary_up'];
        $v_note = @$_POST['txt_note'];
        $query_update = "UPDATE `tbl_hr_employee_salary_up` 
            SET 
                
                `emup_date`='$v_date',
                `emup_salary_up`='$v_salary_up',
                `emup_note`='$v_note'
            WHERE `emup_id`='$v_id'";
            
        if($connect->query($query_update)){
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
    if(@$_GET['v_id']){
        $v_id=@$_GET['v_id'];
        $get_data=$connect->query("SELECT A.*,B.*,C.*,E.*,F.*,
            (select sum(emup_salary_up) from tbl_hr_employee_salary_up where emup_emp_id=A.empl_id) as tt_salary_up
            FROM tbl_hr_employee_list AS A 
            LEFT JOIN tbl_hr_position_list AS B ON A.empl_position=B.po_id
            LEFT JOIN tbl_hr_department_sub AS C ON A.empl_department=C.dep_id
            left join tbl_hr_sex_list as D on A.empl_sex=D.sex_id
            left join tbl_hr_employee_salary_up as F on A.empl_id=F.emup_emp_id
            left join tbl_hr_national_list as E on A.empl_national=E.national_id
            WHERE A.empl_id='$v_id'");
        $row = mysqli_fetch_object($get_data);
    }
?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-6">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Edit Record</h2>
        </div>
        <div class="col-xs-6 text-right">
          <h2><p style="font-family: 'Khmer OS Moul';"><?= $row->empl_emloyee_kh ?></p></h2>
                                <h3><p style="font-family: 'Times New Roman';"><?= $row->empl_emloyee_en ?></p></h3>
                                <h4><p style="font-family: 'Khmer OS';"><?= $row->po_name ?></p></h4>
        </div>
    </div>

    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Input Information</h3>
            </div>
            <div class="panel-body">
                 <form action="#" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="txt_id" value="<?= $row->emup_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label for="inputCbo_position">Salary Date: </label>
                                    <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" required name="txt_date" value="<?= $row->emup_date ?>">
                               <label>Note /ចំណាំ
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                  <textarea type="text" class="form-control" name="txt_note" rows="4"  autocomplete="off"><?= $row->emup_note ?></textarea>
                                <br>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Salary Default: </label>
                                    <input name="txt_salary_df" value="<?= $row->empl_salary ?>"  type="text" class="form-control"  required="" readonly="">
                                <label>Salary Up: </label>
                                    <input name="txt_salary_up" onkeyup="calculate_money()"  type="text" class="form-control" value="<?= $row->tt_salary_up ?>" >
                                <label>Total Salary: </label>
                                    <input name="txt_total" type="text" class="form-control" id="salary_tt" value="<?= $row->tt_salary_up+$row->empl_salary ?>"   required="" readonly="">
                                
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_submit" class="btn btn-lg btn-warning"><i class="fa fa-edit"></i> ធ្វើបច្ចុប្បន្នភាព</button>
                                
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
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
      height: '700'
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

