<?php 
    $menu_active =20;
    $left_active =76;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
    include_once '../../plugin/My_Operation/my_operation.php';
?>
<script type="text/javascript">
    function ask_replace(){
        var v_result=confirm('This Voucher No already exist, Do you want to replace?');
        if(v_result==true){
            $.get('ajax_delete.php?p_status=replace', function(data) {
            });
        }
    }
</script>
<?php 

    if(isset($_POST['btn_submit_new'])){
        //Add Main Item
        $v_rec_status = @$connect->real_escape_string($_POST['cbo_status_type']);
        $v_rec_from = @$connect->real_escape_string($_POST['cbo_rec_from']);
        $v_pos = @$connect->real_escape_string($_POST['cbo_pos']);
        $v_vou_type = @$connect->real_escape_string($_POST['cbo_vou_type']);
        $v_date_record = @$connect->real_escape_string($_POST['txt_date_record']);
        $v_address = @$connect->real_escape_string($_POST['txt_address']);
        $v_tran_type = @$connect->real_escape_string($_POST['cbo_tran_type']);
        $v_vou_no = @$connect->real_escape_string($_POST['txt_vou_no']);
        $v_pho_num = @$connect->real_escape_string($_POST['txt_pho_num']);
        $v_email = @$connect->real_escape_string($_POST['txt_email']);
        $v_cash_bank = @$connect->real_escape_string($_POST['cbo_cash_bank']);
        $v_note = @$connect->real_escape_string($_POST['txt_note']);
        $v_total_amo = @$connect->real_escape_string($_POST['txt_total_amo']);
        $v_text_cash = @$connect->real_escape_string($_POST['txt_text_cash']);

        //Check Data Already Exist
        $v_sql="SELECT accdr_id,accdr_voucher_no FROM tbl_acc_cash_record";
        $v_result=$connect->query($v_sql);
        $arr_result=isAlreadyExist($v_result,$v_vou_no);
        if($arr_result['status']){
            $v_parent_id=$arr_result['id'];
            $_SESSION['parent_id']=$v_parent_id;
            echo '<script type="text/javascript">ask_replace()</script>';
        }


        if($v_vou_type==6){
            $cash_out=0;
            $cash_in=$v_total_amo;
        }
        else{
            $cash_out=$v_total_amo;
            $cash_in=0;
        }
        $query_add = "INSERT INTO `tbl_acc_cash_record`(
        `status`, 
        rec_status,
        `rec_from_id`, 
        `pos_id`, 
        `vou_type_id`, 
        `tran_type_id`, 
        `type_bank_id`, 
        `accdr_date`, 
        `accdr_address`, 
        `accdr_voucher_no`, 
        `accdr_phone`, 
        `accdr_email`, 
        `accdr_cash_in`, 
        `accdr_cash_out`, 
        `accdr_note`, 
        `text_cash`, 
        `user_id`) 
        VALUES (
        '1',
        '$v_rec_status',
        '$v_rec_from',
        '$v_pos',
        '$v_vou_type',
        '$v_tran_type',
        '$v_cash_bank',
        '$v_date_record',
        '$v_address',
        '$v_vou_no',
        '$v_pho_num',
        '$v_email',
        '$cash_in',
        '$cash_out',
        '$v_note',
        '$v_text_cash',
        '$user_id'
        )";

        if($connect->query($query_add))
            $flag_add_1=1;
        $v_last_id=$connect->insert_id;

        $v_code= @$_POST['txt_code'];
        $v_des= @$_POST['cbo_des'];
        $v_tran_note= @$_POST['txt_tran_note'];
        $v_doc_ref= @$_POST['txt_doc_ref'];
        $v_qty= @$_POST['txt_qty'];
        $v_price= @$_POST['txt_price'];
        // $v_discount= @$_POST['txt_discount'];
        foreach ($v_des as $key => $value) {
            if($value){
                $new_code=$v_code[$key];
                $new_des=$v_des[$key];
                $new_tran_note=$v_tran_note[$key];
                $new_doc_ref=$v_doc_ref[$key];
                $new_qty=$v_qty[$key];
                $new_price=$v_price[$key];
                // $new_discount=$v_discount[$key];
                 //Add Sub Item
                $query_add_2="INSERT INTO `tbl_acc_cash_record_detail`(
                    `cash_rec_id`, 
                    `code`, 
                    `des_id`, 
                    `tran_note`, 
                    `doc_ref`, 
                    `qty`, 
                    `price`,  
                    `user_id`)
                    VALUES
                    (
                    '$v_last_id',
                    '$new_code',
                    '$new_des',
                    '$new_tran_note',
                    '$new_doc_ref',
                    '$new_qty',
                    '$new_price',
                    '$user_id'
                    )";
                $connect->query($query_add_2);
            }
        }
        if($flag_add_1==1){
            echo '<script>myAlertSuccess("Add")</script>';
        }else{  
            echo '<script>myAlertError("Error")</script>';
        }
    }
 ?>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2>
                <i class="fa fa-plus-circle fa-fw"></i>Create  Voucher
            </h2>
        </div>
    </div>
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
                    <div class="row">
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label id="change_label_status"></label>
                                <select name="cbo_status_type" id="input" class="form-control myselect2" required="required">
                                    <option value="1"> ទទួលពី Received From </option>
                                    <option value="2"> Other Received From </option>
                                    <option value="3"> ទូទាត់ទៅ Pay To </option>
                                    <option value="4"> Other Pay To </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label id="change_label"></label>
                                <div style="position: absolute; top: 0px; right: 20px;">
                                    <a class="btn btn-primary btn-xs" href='#form_status'><i class="fa fa-plus"></i></a>
                                    <div class="btn btn-success btn-xs" id="btn_refresh_des"><i class="fa fa-refresh"></i></div>
                                </div>
                                <select name="cbo_rec_from" id="input" class="form-control myselect2" required="required">
                                    <!-- <option>=== Please Click and Choose ===</option> -->
                                    <?php 
                                        echo '<option value="">=== Please Click and Choose ===</option>';
                                        $sql=$connect->query("SELECT * FROM tbl_cus_customer_info ORDER BY cussi_name ASC");
                                        while ($row=mysqli_fetch_object($sql)) {
                                            echo '<option value="'.$row->cussi_id.'">'.$row->cussi_name.' </option>';
                                        }
                                     ?> 
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>ប្រភេទសក្ខីប័ត្រ  / Voucher Type:</label>
                                <select name="cbo_vou_type" id="input" class="form-control myselect2" required="required">
                                    <option>=== Select and Choose here ===</option>
                                    <?php 
                                        $sql=$connect->query("SELECT * FROM tbl_acc_voucher_type_list ORDER BY vot_code ASC");
                                        while ($row=mysqli_fetch_object($sql)) {
                                            echo '<option data_code="'.$row->vot_code.'" value="'.$row->vot_id.'">'.$row->vot_code.' :: '.$row->vot_name.'</option>';
                                        }
                                     ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>កាលបរិច្ឆេទប្រតិបត្តិការ / Transaction Date:</label>
                                <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" required name="txt_date_record" value="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>តួនាទី Postion:</label>
                                <select name="cbo_pos" id="input" class="form-control myselect2" required="required">
                                    <option>=== Select and Choose here ===</option>
                                    <?php 
                                        $sql=$connect->query("SELECT * FROM tbl_acc_position ORDER BY po_name ASC");
                                        while ($row=mysqli_fetch_object($sql)) {
                                            echo '<option value="'.$row->po_id.'">'.$row->po_name.' </option>';
                                        }
                                     ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>អាស័យដ្ឋាន / Address: </label>
                                <input type="text" class="form-control" readonly="" name="txt_address">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>ប្រភេទប្រតិបត្តិការ / Transaction Type:</label>
                                <select name="cbo_tran_type" id="input" class="form-control myselect2" required="required">
                                    <option value="">=== Click and choose ===</option>
                                    <?php 
                                    $sql=$connect->query("SELECT * FROM tbl_acc_transaction_type_list ORDER BY trat_name ASC");
                                    while ($row=mysqli_fetch_object($sql)) {
                                        echo '<option value="'.$row->trat_id.'">'.$row->trat_name.'</option>';
                                    }
                                     ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>លេខសក្ខីប័ត្រៈ / Voucher No:</label>
                                <input type="text" class="form-control" required name="txt_vou_no" readonly="">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>លេខទូរស័ព្ទ / Phone Number:</label>
                                <input type="text" id="mask_phone" class="form-control" readonly="" name="txt_pho_num">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>សារអេឡិចត្រូនិច / Email:</label>
                                <input type="email" class="form-control" name="txt_email" readonly="">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>ប្រភេទសាច់ប្រាក់/ធនាគារ:</label>
                                <select name="cbo_cash_bank" id="input" class="form-control myselect2" required="">
                                    <option>=== Select and Choose here ===</option>
                                    <?php 
                                        $sql=$connect->query("SELECT * FROM tbl_acc_type_cash_bank ORDER BY name ASC");
                                        while ($row=mysqli_fetch_object($sql)) {
                                            echo '<option value="'.$row->id.'">'.$row->name.'</option>';
                                        }
                                     ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Note : </label>
                                <textarea class="form-control" rows="1" autocomplete="off" name="txt_note"></textarea>
                            </div>
                         </div>
                    </div>
                    <hr>
                    <table id="myTable" class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 100px;">កូដ <br> Code</th>
                                <th class="text-center" style="width: 200px;">ការបរិយាយ <br> DESCRIPTION
                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#description'><i class="fa fa-plus"></i></a>
                                    <div class="btn btn-success btn-xs" id="re_des"><i class="fa fa-refresh"></i></div>
                                </th>
                                <th class="text-center" style="width:350px;">សំគាល់ប្រតិបត្តិការណ៍ <br> TRANSACTION NOTE</th>
                                <th class="text-center">ឯកសារយោង <br> DOCUMENT REF</th>
                                <th class="text-center">បរិមាណ <br> QUANTITY</th>
                                <th class="text-center">តម្លៃ <br> PRICE</th>
                                <!-- <th class="text-center">បញ្ចុះតម្លៃ <br> DISCOUNT</th> -->
                                <th class="text-center">ទឹកប្រាក់  <br> AMOUNT</th>
                                <th class="text-center"> <i class="fa fa-cog fa-spin"></i> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="my_form_base" style="background: red; display: none;">
                                <td>
                                    <input type="text" onkeyup="getDesCode(this);" name="txt_code[]" id="inputTxt_acc_no" class="form-control">
                                </td>
                                <td>
                                    <select class="form-control" onchange="getDes(this);" name="cbo_des[]">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_acc_decription ORDER BY des_name DESC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_data->des_id.'">'.$row_data->des_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </td>
                                <td>
                                    <textarea name="txt_tran_note[]" class="form-control" rows="1"></textarea>
                                </td>
                                <td>
                                    <input type="text" name="txt_doc_ref[]" class="form-control">
                                </td>
                                <td>
                                    <input type="number" step="0.001" onkeyup="getQty(this)" name="txt_qty[]" class="form-control" value="0">
                                </td>
                                <td>
                                    <input type="number" onkeyup="getPrice(this)" step="0.001" name="txt_price[]" class="form-control" value="0">
                                </td>
                                <td>
                                    <input type="text" name="txt_amo[]" value="0" readonly="" id="inputTxt_acc_no" class="form-control">
                                </td>
                                <td class="text-center">
                                    <button class="btnDelete btn btn-info"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th class="text-right">ទឹកប្រាក់សរុប <br>​ TOTAL AMOUNT</th>
                                <th colspan="2"><input type="text" name="txt_total_amo" readonly="" id="inputTxt_total_amo" class="form-control" value="0" required="required" pattern="" title=""></th>
                            </tr>
                            <tr>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th class="text-right">ទឹកប្រាក់ជាអក្សរ <br> AMOUNT IN WORDS</th>
                                <th colspan="2"><textarea name="txt_text_cash" readonly="" id="inputTxt_text_cash" class="form-control" rows="3" required="required"></textarea></th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="row">
                        <div class="text-center">
                            <div class="form_add_result"></div>
                            <div id="add_more" class="btn btn-default yellow btn-md"><i class="fa fa-plus"></i>Add More</div>
                        </div>
                    </div>
                    <br>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <!-- <a href="index.php" class="btn yellow"><i class="fa fa-print"></i>Print</a> -->
                                <button type="submit" name="btn_submit_new" class="btn green"><i class="fa fa-save fa-fw"></i>Save & New</button>
                                <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="number_to_word_kh.js"></script>
<script type="text/javascript" src="../../assets/global/plugins/jquery.min.js"></script>
<script>
    function getDes (args) {
        var v_id=$(args).val();
        $.ajax({url: 'ajax_get_des.php?des_id='+v_id,success:function (result) {
            $(args).parents('tbody >tr').find('td:nth-child(1) >input').val(result.trim());
        }});
    }
    function getDesCode (args) {
        var v_code=$(args).val();
        $.ajax({url: 'ajax_get_des.php?des_code='+v_code,success:function (result) {
            $(args).parents('tbody >tr').find('td:nth-child(2) >select').html(result.trim());
        }});
    }
    $('div#btn_refresh_des').click(function () {
        var v_id=$("select[name=cbo_status_type] >option:selected").val();
        $.ajax({url: 'ajx_get_content_select.php?status='+v_id,success: function (result) {
            $('select[name="cbo_rec_from"]').html(result);
        }});
    });
    $('a[href="#form_status"]').click(function () {
        var status_id=parseInt($("select[name=cbo_status_type] >option:selected").val());
        switch(status_id) {
            case 1:
                $('div[id=rec_from]').modal();
                break;
            case 2:
                $('div[id=other_rec_from]').modal();
                break;
            case 3:
                $('div[id=rec_pay_to]').modal();
                break;
            case 4:
                $('div[id=other_pay_to]').modal();
                break;
        }
    });

    var v_id=$("select[name=cbo_status_type] >option:selected").val();
    change_label(v_id);

    function change_label (args) {
        var v_id=parseInt(args);
        var v_label=" ";
        switch(v_id) {
            case 1:
                v_label="Received From (Customer):";
                break;
            case 2:
                v_label="Received From (Other):";
                break;
            case 3:
                v_label="Pay To (Vendor):";
                break;
            case 4:
                v_label="Pay To (Other):";
                break;
        }
        var v_text=$("select[name=cbo_status_type] >option:selected").text();
        $('label[id=change_label]').html(v_label);
        $('label[id=change_label_status]').html(v_text);
    }

    

    $(document).ready(function(){
        $('select[name="cbo_status_type"]').change(function () {
            var last_result='';
            var v_id=$(this).val();
            var v_id_status=$("select[name=cbo_status_type] >option:selected").val();
            change_label(v_id_status);
            $.ajax({url: 'ajx_get_content_select.php?status='+v_id,success: function (result) {
                $('select[name="cbo_rec_from"]').html(result);
            }});
        });

        $('select[name="cbo_rec_from"]').change(function () {
            var last_result=" ";
            var v_id=$(this).val();
            var v_status=$("select[name=cbo_status_type] >option:selected").val();
            var myArr=new Array(v_status,v_id);
            $.ajax({url: 'ajax_get_rec_info.php',data:'data='+myArr,type:'POST',async:false,success:function (result) {
                last_result=result;
            }});
            var myObj=JSON.parse(last_result);
            $('input[name="txt_email"]').val(myObj['email']);
            $('input[name="txt_address"]').val(myObj['address']);
            $('input[name="txt_pho_num"]').val(myObj['phone']);
        });
        
        //Press Button Add More
        var index_row = 1;
        $('#add_more').click(function(){ 
            $('#myTable').append('<tr data-row-id="'+(++index_row)+'">'+$('.my_form_base').html()+'</tr>');
            $('tr[data-row-id='+index_row+']').find('select').select2();
        });
        setTimeout(function(){
            $('#add_more').click();      
        },1000);
        //Delete Row By Row
        $("tbody").on('click', '.btnDelete', function () {
            var rowCount = $('tbody>tr').length;
            if(rowCount<=2){
                alert("You can not delete this record.");
                return;
            }
            totalAmount();
            $(this).parents('tr').remove();
        });
        //Refresh Cmbobox
        $('div#re_des').click(function(){
            $.ajax({url: "ajx_get_content_select.php?d=txt_description", success: function(result){
                if($('select[name="cbo_des[]"]').html().trim() != result.trim()){
                    $('select[name="cbo_des[]"]').html(result);
                }
            }});
        });
        $('div[id=rec_from_cus]').click(function(){
            $.ajax({url: "ajx_get_content_select.php?d=txt_rec_from", success: function(result){
                if($('select[name="cbo_rec_from"]').html().trim() != result.trim()){
                    $('select[name="cbo_rec_from"]').html(result);
                }
            }});
        });
        $('select[name=cbo_vou_type]').change(function () {
            var code_vouch=$(this).find('option:selected').attr('data_code');
            var v_date=my_getDate($('input[name=txt_date_record]').val());
            var vou_id=$(this).val();
            var myObject={
                cash_res_id:null,
                vou_code:code_vouch,
                v_date:v_date,
                vou_id:vou_id
            };
            var myString =JSON.stringify(myObject);
            $.ajax({type:'POST',url:"ajx_get_vou_no.php",data:'data='+myString,success: function(result){
                var myObj=JSON.parse(result);
                // alert(result);
                $('input[name=txt_vou_no]').val(myObj['vou_no']);
            }});
        });
        
        $('input[name=txt_date_record]').datepicker().on('changeDate', function (ev) {
            $(this).change();
            var v_date=my_getDate(new Date($(this).val()));
            var vou_id=$('select[name=cbo_vou_type]').val();
            var vou_id=$('select[name=cbo_vou_type]').val();
            code_vouch=$('select[name=cbo_vou_type]').find('option:selected').attr('data_code');
            var myObject={
                cash_res_id:null,
                vou_code:code_vouch,
                v_date:v_date,
                vou_id:vou_id
            };
            var myString =JSON.stringify(myObject);
            $.ajax({url:"ajx_get_vou_no.php",type:'POST',data:'data='+myString,success: function(result){
                var myObj=JSON.parse(result);
                $('input[name=txt_vou_no]').val(myObj['vou_no']);
            }});
        });
    });
    function getQty (args) {
        let v_price=$(args).parents('tbody >tr').find('td:nth-child(6) >input').val();
        let amo=v_price*$(args).val();
        $(args).parents('tbody >tr').find('td:nth-child(7) >input').val(amo.toFixed(2)+" $");
        totalAmount();
    }
    function getPrice (args) {
        let qty=$(args).parents('tbody >tr').find('td:nth-child(5) >input').val();
        let amo=qty*$(args).val();
        $(args).parents('tbody >tr').find('td:nth-child(7) >input').val(amo.toFixed(2)+" $");
        totalAmount();
    }
    function totalAmount () {
        var t_amo=0;
        $('input[name^="txt_amo"]').each(function () {
            t_amo+= parseFloat($(this).val());
        });
        // $('tfoot >tr:nth-last-child(2)').find('th:nth-last-child(1) >input[name=txt_total_amo]').val(roundUp(t_amo,3));
        $('tfoot >tr:nth-last-child(2)').find('th:nth-last-child(1) >input[name=txt_total_amo]').val(t_amo.toFixed(2));
        var get_num = t_amo.toFixed(2);
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
    }
</script>

<?php include_once '../layout/footer.php' ?>
<div class="modal fade" id="description">
    <div class="modal-dialog" style="width: 80%;">
        <iframe src="iframe_description.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="rec_from">
    <div class="modal-dialog" style="width: 70%;">
        <iframe src="iframe_add_rec_from.php" frameborder="0" style="height: 650px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="rec_pay_to">
    <div class="modal-dialog" style="width: 70%;">
        <iframe src="iframe_add_pay_to.php" frameborder="0" style="height: 590px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="other_rec_from">
    <div class="modal-dialog" style="width: 70%;">
        <iframe src="iframe_add_other_rec_from.php" frameborder="0" style="height: 500px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="other_pay_to">
    <div class="modal-dialog" style="width: 70%;">
        <iframe src="iframe_add_other_pay_to.php" frameborder="0" style="height: 500px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>