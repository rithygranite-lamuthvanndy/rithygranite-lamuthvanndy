<?php 
    $menu_active =13;
    $left_active =52;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        $v_frpc_no = @$_POST['txt_frpc_no'];
        $v_date = @$_POST['txt_date'];
        $v_type = @$_POST['txt_type'];
        $v_disc = @$_POST['txt_disc'];
        $v_qty = @$_POST['txt_qty'];
        $v_un_pr = @$_POST['txt_un_pc'];
        $v_amount = @$_POST['txt_amount'];
        $v_note = @$_POST['txt_note'];
        $query_add = "INSERT INTO tbl_fr_pc_expense (
                frpc_no,
                frpc_date,
                frpc_type,
                frpc_description,
                frpc_qty,
                frpc_unit_price,
                frpc_amount,
                frpc_note
                ) 
            VALUES(
                '$v_frpc_no',
                '$v_date',
                '$v_type',
                '$v_disc',
                '$v_qty',
                '$v_un_pr',
                '$v_amount',
                '$v_note')";
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
        <div class="col-md-8">
            <?= @$sms ?><br>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Create Record (FR/PC)</h2>
            <br>
            <br>
            <br><br>
        </div>
        <div class="col-md-4">
            <h2>Amount:</h2> <p style="font-family: 'Times New Roman'; font-size: 45px;" id="total_amount"></p>
        </div>
        </div>
    </div>
    
    <br>
    <br>

    <div class="portlet-title">
        <div class="caption font-dark">
        </div>
    </div>
    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Input Information</h3>
            </div>
            <div class="panel-body">
                 <form action="#" method="post" enctype="multipart/form-data" autocomplete="off">
                    <div class="form-body">

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                        <label>FR-PC/ប្រភេទសំណើរ * : </label>
                                   
                                    <div class="btn btn-success btn-xs" id="refresh_cbo_counter"><i class="fa fa-refresh"></i></div>
                                        <select name="txt_type" id="input" class="form-control myselect2" required="required">
                                            <option value="">*** Select and choose ***</option>
                                            <?php 
                                                $v_result=$connect->query("SELECT * FROM tbl_fr_pc_type_list ORDER BY fpt_id");
                                                while ($row_select=mysqli_fetch_object($v_result)) {
                                                    echo '<option data_code="'.$row_select->fpt_code.'" value="'.$row_select->fpt_id.'">'.$row_select->fpt_code.' || '.$row_select->fpt_name.'</option>';
                                                }
                                             ?>
                                        </select>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>FR/PC No : </label>

                                    <input type="text" class="form-control" name="txt_frpc_no" readonly="">
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <label>Date : </label>
                                <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" required name="txt_date" value="<?= date('Y-m-d') ?>">   
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Description : </label>
                                    <input type="text" class="form-control" name="txt_disc"  autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <label>QTY : </label> 
                                <input type="text"  onkeyup="calculate_money()" class="form-control" name="txt_qty" >        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <label>Unit Price : </label> 
                                <input type="text"  onkeyup="calculate_money()" class="form-control" name="txt_un_pc"  value="0" >        
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Amount (USD) : </label>
                                    <input type="text" onkeyup="calculate_money_am()" class="form-control" name="txt_amount"  id="txt_fr_amount" value="calculating">
                                </div>
                            </div>
                        </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Note : </label>
                                    <textarea type="text" class="form-control" name="txt_note" rows="5"  autocomplete="off"></textarea>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_submit" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../../assets/global/plugins/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        $('select[name=txt_type]').change(function () {
            var code_vouch=$(this).find('option:selected').attr('data_code');
            var v_date=my_getDate($('input[name=txt_date]').val());
            var vou_id=$(this).val();
            var myObject={
                fpt_id:null,
                vou_code:code_vouch,
                v_date:v_date,
                vou_id:vou_id
            };
            
            var myString =JSON.stringify(myObject);
            $.ajax({type:'POST',url:"ajx_get_frpc_no.php",data:'data='+myString,success: function(result){
                var myObj=JSON.parse(result);
                // alert(result);
                $('input[name=txt_frpc_no]').val(myObj['vou_no']);
            }});
        });
        $('input[name=txt_date]').datepicker().on('changeDate', function (ev) {
            $(this).change();
            var v_date=my_getDate(new Date($(this).val()));
            var vou_id=$('select[name=txt_type]').val();
            var vou_id=$('select[name=txt_type]').val();
            code_vouch=$('select[name=txt_type]').find('option:selected').attr('data_code');
            var myObject={
                fpt_id:null,
                vou_code:code_vouch,
                v_date:v_date,
                vou_id:vou_id
            };
            var myString =JSON.stringify(myObject);
            $.ajax({url:"ajx_get_frpc_no.php",type:'POST',data:'data='+myString,success: function(result){
                var myObj=JSON.parse(result);
                $('input[name=txt_frpc_no]').val(myObj['vou_no']);
            }});
        });
    });
    function calculate_money(){
        $v_fr_qty=$('input[name=txt_qty]').val();
        $v_fr_price=$('input[name=txt_un_pc]').val();
        $v_amount=parseFloat($v_fr_qty)*parseFloat($v_fr_price);
        $('input#txt_fr_amount').val($v_amount.toFixed(2));
        $('label#total_amount').val($v_amount.toFixed(2));
        document.getElementById("total_amount").innerHTML = "$ "+$v_amount.toFixed(2);
        //$('input#txt_fr_amount').val(Math.floor($v_amount));
    }
    function calculate_money_am(){
        $v_amount1=$('input[name=txt_amount]').val();
        $('label#total_amount').val($v_amount1.toFixed(2));
        document.getElementById("total_amount").innerHTML = "$ "+$v_amount1.toFixed(2);
    }
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

