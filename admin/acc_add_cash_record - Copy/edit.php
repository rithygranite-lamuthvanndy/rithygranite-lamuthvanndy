<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
    if(isset($_POST['btn_submit_close'])){
        
        $v_id = @$_POST['txt_id'];
        $v_vouc_type_id = @$_POST['cbo_vou_id'];
        $v_vouc_no = @$_POST['txt_voucher_no'];
        $v_tran_type_id = @$_POST['cbo_tran_type'];
        $v_cash_type_id = @$_POST['cbo_cash_type'];
        $v_date_record = @$_POST['txt_date_record'];
        $v_address = @$_POST['txt_address'];
        $v_invoice_no = @$_POST['txt_invoice_no'];
        $v_name = @$_POST['txt_name'];
        $v_description = @$_POST['txt_description'];
        $v_cash_in = @$_POST['txt_cash_in'];
        $v_cash_out = @$_POST['txt_cash_out'];
        $v_balance = @$_POST['txt_balance'];
        $v_note = @$_POST['txt_note'];
        $v_text_cash = @$_POST['txt_text_cash'];
       
        $query_update = "UPDATE `tbl_acc_cash_record` 
            SET 
                accdr_date='$v_date_record',
                status=1,
                voucher_type_id='$v_vouc_type_id',
                transa_type_id='$v_tran_type_id',
                cash_type_bank_id='$v_cash_type_id',
                accdr_address='$v_address',
                accdr_voucher_no='$v_vouc_no',
                accdr_invoice_no='$v_invoice_no',
                accdr_name='$v_name',
                accdr_description='$v_description',
                accdr_cash_in='$v_cash_in',
                accdr_cash_out='$v_cash_out',
                accdr_balance='$v_balance',
                text_cash='$v_text_cash',
                accdr_note='$v_note'
            WHERE `accdr_id`='$v_id'";
                            
       
        if($connect->query($query_update)){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data update ...
            </div>'; 
            header('location: index.php');
        }else{
            $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> Query error ...
            </div>';   
        }
    }


// get old data 
    $edit_id = @$_GET['edit_id'];
    $old_data = $connect->query("SELECT * FROM tbl_acc_cash_record WHERE accdr_id='$edit_id'");
    $row_old_data = mysqli_fetch_object($old_data);


 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2 class="voucher_code">
                <i class="fa fa-plus-circle fa-fw"></i>Edit Record
                <p></p>
            </h2>
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
                <form action="#" method="post" enctype="multipart/form-data" autocomplete="off">
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->accdr_id ?>">
                    <input type="hidden" name="txt_voucher_no" value="<?= $row_old_data->accdr_voucher_no ?>">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Date : </label>
                                    <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" required name="txt_date_record" value="<?= $row_old_data->accdr_date ?>">
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label>Voucher Type : </label>
                                            <!-- <a class="btn btn-primary btn-xs" data-toggle="modal" href='#voucher_type'><i class="fa fa-plus"></i></a>
                                            <div class="btn btn-success btn-xs" id="vou_type"><i class="fa fa-refresh"></i></div> -->
                                            <select name="cbo_vou_id" id="input" onchange="get_voucher_no(this)" class="form-control myselect2" required="required">
                                                <option value="">=== Select and Choose here ===</option>
                                                <?php 
                                                    $sql=$connect->query("SELECT * FROM tbl_acc_voucher_type_list ORDER BY vot_code ASC");
                                                    while ($row=mysqli_fetch_object($sql)) {
                                                        if($row_old_data->voucher_type_id==$row->vot_id)
                                                            echo '<option data_code="'.$row->vot_code.'" SELECTED value="'.$row->vot_id.'">'.$row->vot_code.' :: '.$row->vot_name.'</option>';
                                                        else
                                                            echo '<option data_code="'.$row->vot_code.'" value="'.$row->vot_id.'">'.$row->vot_code.' :: '.$row->vot_name.'</option>';
                                                    }
                                                 ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label>Type Cash/Bank : </label>
                                            <!-- <a class="btn btn-primary btn-xs" data-toggle="modal" href='#type_cash_bank'><i class="fa fa-plus"></i></a>
                                            <div class="btn btn-success btn-xs" id="cash_type"><i class="fa fa-refresh"></i></div> -->
                                            <select name="cbo_cash_type" id="input" onchange="get_voucher_no(this)" class="form-control myselect2" required="required">
                                                <option>=== Select and Choose here ===</option>
                                                <?php 
                                                    $sql=$connect->query("SELECT * FROM tbl_acc_type_cash_bank ORDER BY name ASC");
                                                    while ($row=mysqli_fetch_object($sql)) {
                                                        if($row_old_data->cash_type_bank_id==$row->id)
                                                            echo '<option SELECTED value="'.$row->id.'">'.$row->name.'</option>';
                                                        else
                                                            echo '<option value="'.$row->id.'">'.$row->name.'</option>';
                                                    }
                                                 ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Invoice No : </label>
                                    <input type="text" class="form-control" required name="txt_invoice_no" value="<?= $row_old_data->accdr_invoice_no ?>">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Description : </label>
                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#description'><i class="fa fa-plus"></i></a>
                                     <div class="btn btn-success btn-xs" id="re_des"><i class="fa fa-refresh"></i></div>
                                    <select name="txt_description" id="input" class="myselect2 form-control" required="required">
                                        <option value="">=== Select and Choose here ===</option>
                                        <?php 
                                            $sql=$connect->query("SELECT * FROM tbl_acc_decription ORDER BY des_name ASC");
                                            while ($row=mysqli_fetch_object($sql)) {
                                                if($row_old_data->accdr_description==$row->des_id)
                                                    echo '<option SELECTED value="'.$row->des_id.'">'.$row->des_name.'</option>';
                                                else
                                                    echo '<option value="'.$row->des_id.'">'.$row->des_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Name : </label>
                                    <input type="text" class="form-control" required name="txt_name" value="<?= $row_old_data->accdr_name ?>">
                                </div>
                                <div class="form-group">
                                    <label>Address : </label>
                                    <input type="text" class="form-control" required name="txt_address" value="<?= $row_old_data->accdr_address ?>">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Transation Type :</label>
                                    <!-- <a class="btn btn-primary btn-xs" data-toggle="modal" href='#transation_type'><i class="fa fa-plus"></i></a>
                                    <div class="btn btn-success btn-xs" id="re_tran"><i class="fa fa-refresh"></i></div> -->
                                    <select name="cbo_tran_type" id="input" class="form-control myselect2" required="required">
                                        <option value="">=== Click and choose ===</option>
                                        <?php 
                                        $sql=$connect->query("SELECT * FROM tbl_acc_transaction_type_list ORDER BY trat_name ASC");
                                        while ($row=mysqli_fetch_object($sql)) {
                                            if($row_old_data->transa_type_id==$row->trat_id)
                                                echo '<option SELECTED value="'.$row->trat_id.'">'.$row->trat_name.'</option>';
                                            else
                                                echo '<option value="'.$row->trat_id.'">'.$row->trat_name.'</option>';
                                        }
                                         ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Cash In : </label>
                                    <input type="number" step="0.01" class="form-control" required name="txt_cash_in" value="<?= $row_old_data->accdr_cash_in ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Cash Out : </label>
                                    <input type="number" step="0.01" class="form-control" required name="txt_cash_out" value="<?= $row_old_data->accdr_cash_out ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Balance : </label>
                                    <input type="text" readonly="" class="form-control" required name="txt_balance">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Text Cash : </label>
                                    <textarea name="txt_text_cash" readonly="" id="inputTxt_text_cash" class="form-control" rows="3" required="required"><?= $row_old_data->text_cash ?></textarea>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Note : </label>
                                    <textarea class="form-control" rows="3" autocomplete="off" name="txt_note"><?= $row_old_data->accdr_note ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                               <a href="index.php" class="btn yellow"><i class="fa fa-print"></i>Print</a>
                                <button type="submit" name="btn_submit_close" class="btn blue"><i class="fa fa-close"></i>Save & Close</button>
                                <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../../assets/global/plugins/jquery.min.js"></script>
<script type="text/javascript" src="number_to_word_kh.js"></script>
<script type="text/javascript">
    var d=new Date($('input[name=txt_date_record]').val());
    my_date=to_fixed_date(d);
    $(document).ready(function () {
        $('input[name=txt_date_record]').datepicker().on('changeDate', function (ev) {
            $(this).change();
            var cash_res_id=$('input[name=txt_id]').val();
            var v_date=my_getDate($(this).val());
            var vou_id=$('select[name=cbo_vou_id]').val();
            var code_vouch=$('select[name=cbo_vou_id]').find('option:selected').attr('data_code');
            var arr=new Array(cash_res_id,code_vouch,v_date,vou_id);
            $.ajax({url:"ajx_get_vou_no.php?",type:'POST',data:'data='+arr,success: function(result){
                var myObj=JSON.parse(result);
                $('input[name=txt_voucher_no]').val(myObj['vou_no']);
                $('h2.voucher_code').find('p').html(myObj['vou_no']);
            }});
        });
    });

    $('select[name=cbo_vou_id]').ready(function(){
        get_voucher_no(this);
    });

    function get_voucher_no(obj){
        var vou_id=$(obj).val();
        var v_date=my_getDate($('input[name=txt_date_record]').val());
        var cash_res_id=$('input[name=txt_id]').val();
        var code_vouch=$(obj).find('option:selected').attr('data_code');
        var arr=new Array(cash_res_id,code_vouch,v_date,vou_id);
        $.ajax({url:"ajx_get_vou_no.php",type:'POST',data:'data='+arr,success: function(result){
            // alert(result);
            // return false;
            var myObj=JSON.parse(result);
            $('input[name=txt_voucher_no]').val(myObj['vou_no']);
            $('h2.voucher_code').find('p').html(myObj['vou_no']);
        }});
    }
    

    $('input[name=txt_cash_out]').keyup(function(){
        $c_out =$(this).val();
        $c_in = $('input[name="txt_cash_in"]').val();
        var result= parseFloat($c_in) - parseFloat($c_out);
        $('input[name="txt_balance"]').val(result.toFixed(2));
        event.preventDefault();
            
        var get_num = $c_out;
        $float_num = get_num.toString().split(".")[1];

        var num_to_words = toWords(parseInt(get_num));
        $('textarea[name=txt_text_cash]').val(num_to_words +" ដុល្លារគត់");
        if(parseInt($float_num)!=0){
            my_float=parseFloat("0."+$float_num);
            if((my_float*100)<10)
                num_to_words += 'ដុល្លារ និង សូន្យ';
            else
                num_to_words += 'ដុល្លារ និង ';

            num_to_words += toWords($float_num)+" សេន";
            $('textarea[name=txt_text_cash]').val(num_to_words);
        }
    });
    $('input[name="txt_cash_in"]').keyup(function(){
        $c_in=$(this).val();
        $c_out = $('input[name="txt_cash_out"]').val();
        var result= parseFloat($c_in) - parseFloat($c_out);
        $('input[name="txt_balance"]').val(result.toFixed(2));
        event.preventDefault();

        var get_num = $c_in;
        $float_num = get_num.toString().split(".")[1];
        var num_to_words = toWords(parseInt(get_num));
        $('textarea[name=txt_text_cash]').val(num_to_words +" ដុល្លារគត់");
        if(parseInt($float_num)!=0){
            my_float=parseFloat("0."+$float_num);
            if((my_float*100)<10)
                num_to_words += 'ដុល្លារ និង សូន្យ';
            else
                num_to_words += 'ដុល្លារ និង ';
            num_to_words += toWords($float_num)+"​ សេន";
            $('textarea[name=txt_text_cash]').val(num_to_words);
        }
    });
    function to_fixed_date(obj){
            year=(obj.getFullYear()).toString();
            if(obj.getMonth()+1<10)
                month="0"+(obj.getMonth()+1);
            else
                month=(obj.getMonth()+1).toString();

            if(obj.getDate()<10)
                date="0"+obj.getDate();
            else
                date=obj.getDate().toString();
            return (year+"-"+month+"-"+date);
        }
    $('div#vou_type').click(function(){
        $.ajax({url: "ajx_get_content_select.php?d=cbo_vou_id", success: function(result){
            if($('select[name=cbo_vou_id]').html().trim() != result.trim()){
                $('select[name=cbo_vou_id]').html(result);
            }
        }});
    });

    $('div#re_des').click(function(){
        $.ajax({url: "ajx_get_content_select.php?d=txt_description", success: function(result){
            if($('select[name=txt_description]').html().trim() != result.trim()){
                $('select[name=txt_description]').html(result);
            }
        }});
    });
    $('div#re_tran').click(function(){
        $.ajax({url: "ajx_get_content_select.php?d=cbo_tran_type", success: function(result){
            if($('select[name=cbo_tran_type]').html().trim() != result.trim()){
                $('select[name=cbo_tran_type]').html(result);
            }
        }});
    });
    $('div#cash_type').click(function(){
        $.ajax({url: "ajx_get_content_select.php?d=cbo_cash_type", success: function(result){
            if($('select[name=cbo_cash_type]').html().trim() != result.trim()){
                $('select[name=cbo_cash_type]').html(result);
            }
        }});
    });
</script>
<?php include_once '../layout/footer.php' ?>
<div class="modal fade" id="description">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_description.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="voucher_type">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_voucher_type.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="transation_type">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_transa_type.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="type_cash_bank">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_type_bank.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>