<?php 
    $menu_active =13;
    $left_active =103;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        $v_frpc_no = @$_POST['txt_frpc_no'];
        $v_date = @$_POST['txt_date'];
        $v_type = @$_POST['txt_type'];
        $v_disc = @$_POST['txt_disc'];
        $v_qty = @$_POST['txt_qty'];
        $v_unit = @$_POST['txt_unit'];
        $v_un_pr = @$_POST['txt_un_pc'];
        $v_amount = @$_POST['txt_amount'];
        $v_note = @$_POST['txt_note'];
        $query_add = "INSERT INTO tbl_fr_pc_expense (
                frpc_no,
                frpc_date,
                frpc_type,
                frpc_description,
                frpc_qty,
                frpc_unit,
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
                '$v_unit',
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


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
        <div class="col-md-8">
            <?= @$sms ?><br>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Create Record (FR/PC)</h2>

            <div class="portlet-title">
                <div class="caption font-dark">
                    <a href="index.php" id="sample_editable_1_new" class="btn red"> 
                        <i class="fa fa-arrow-left"></i>
                        Back
                    </a>
                </div>
            </div>
        </div>
        <div class="btn-group pull-right">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>Create Record (FR/PC) <p style="font-family: 'Times New Roman'; font-size: 45px;" id="total_amount"></p></h3>
                    <h4><p style="font-family: 'Times New Roman'; font-size: 16px;" id="frpc_code"></p></h4>
                </div>
                <div class="icon">
                    <i class="fa fa-area-chart"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
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
                                    <input type="text" class="form-control" name="txt_disc"  autocomplete="off" id="txt_combodisc">
                                        <select autocomplete="off"  name="txt_type1" id="input" class="form-control myselect2" required="required">
                                            <option autocomplete="off"  value="">*** Select Descrition***</option>
                                            <?php 
                                                $v_result=$connect->query("SELECT * FROM tbl_fr_pc_expense ORDER BY frpc_id");
                                                while ($row_select=mysqli_fetch_object($v_result)) {
                                                  
                                                    echo '<option autocomplete="off" data_code="'.$row_select->frpc.'" value="'.$row_select->frpc_description.'">'.$row_select->frpc_description.'</option>';   
                                                }
                                             ?>
                                        </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <label>QTY : </label> 
                                <input type="text"  onkeyup="calculate_money()" class="form-control" name="txt_qty" >        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <label>Unit : </label> 
                                <select class="form-control" id="unit_name" name="txt_unit">
                                    <option value="">==Please Choose and Select==</option>
                                    <?php
                                    $v_select = $connect->query("SELECT * FROM tbl_acc_unit_list ORDER BY uni_id ASC");
                                    while ($row_data = mysqli_fetch_object($v_select)) {
                                        echo '<option value="' . $row_data->uni_id . '">' . $row_data->uni_name . '</option>';
                                    }
                                    ?>
                                </select>   
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <label>Unit Price : </label> 
                                <input type="text"  onkeyup="calculate_money()" class="form-control" name="txt_un_pc"  value="0" >        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
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
                                <a href="index.php" class="btn red" ><i class="fa fa-undo fa-fw"></i>Cancel</a>
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
                document.getElementById("frpc_code").innerHTML = myObj['vou_no'];
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
                document.getElementById("frpc_code").innerHTML = myObj['vou_no'];
            }});
        });
    });
            var formatter = new Intl.NumberFormat('en-US', {
              style: 'currency',
              currency: 'USD',
        });
    function calculate_money(){
        $v_fr_qty=$('input[name=txt_qty]').val();
        $v_fr_price=$('input[name=txt_un_pc]').val();
        $v_amount=parseFloat($v_fr_qty)*parseFloat($v_fr_price);
        $('input#txt_fr_amount').val(formatter.format($v_amount));
        document.getElementById("total_amount").innerHTML = formatter.format($v_amount);
        //$('input#txt_fr_amount').val(Math.floor($v_amount));
    }
    function calculate_money_am(){
        $v_amount1=$('input[name=txt_amount]').val();

        document.getElementById("total_amount").innerHTML = formatter.format($v_amount1);
    }

    $(document).ready(function(){
        $('select[name="txt_type1"]').change(function () {
            $comdesc=$("select[name=txt_type1] >option:selected").val();
            $('input#txt_combodisc').val($comdesc);
        });
    });
    $zerol=0;
    document.getElementById("total_amount").innerHTML = formatter.format($zerol);
</script>

<script type="text/javascript" src="../../plugin/ckeditor_4.7.0_full/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace( 'detail', {
        language: 'en',
      height: '700'
        // uiColor: '#9AB8F3'
    });
</script>


<?php include_once '../layout/footer.php' ?>
