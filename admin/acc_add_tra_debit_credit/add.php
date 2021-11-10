<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "Add Transation Debit Credit";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>

<?php 
    if(@$_GET['status']=='true')
        echo '<script>myAlertSuccess("Add")</script>';
    if(isset($_POST['btn_save_new'])){
        //Add Main Item
        $v_type_id = @$connect->real_escape_string($_POST['cboType']);
        $v_entry_no = @$connect->real_escape_string($_POST['cbo_entry_no']);
        $v_date_record = @$connect->real_escape_string($_POST['txt_date_record']);

        $query_add = "INSERT INTO `tbl_acc_add_tran_dr_cr`(
        `date_record`, 
        `ref_id`, 
        `status_type`, 
        `user_id`)
        VALUES (
        '$v_date_record',
        '$v_entry_no',
        '$v_type_id',
        '$user_id'
        )";
        if($connect->query($query_add))
            $flag_add_1=1;
        $v_last_id=$connect->insert_id;

        $v_status= @$_POST['txt_status'];
        $v_ref_detail_id=@$_POST['txt_ref_detail_id'];
        $v_detail_code=@$_POST['txt_detail_code'];
        $v_description=@$_POST['txt_description'];
        $v_tran_note=@$_POST['txt_tran_note'];
        $v_doc_ref=@$_POST['txt_doc_ref'];
        $v_qty=@$_POST['txt_qty'];
        $v_unit_price=@$_POST['txt_unit_price'];
        $v_acc_debit_old= @$_POST['txt_debit_old'];
        $v_acc_credit_old= @$_POST['txt_credit_old'];
        $v_acc_id= $_POST['cbo_acc_id'];
        $v_acc_debit= @$_POST['txt_debit'];
        $v_acc_credit= @$_POST['txt_credit'];
        foreach ($v_acc_id as $key => $value) {
            if($value){
                $new_status=$v_status[$key];
                $new_ref_detail_id=$v_ref_detail_id[$key];
                $new_detail_code=$v_detail_code[$key];
                $new_des=$v_description[$key];
                $new_tran_note=$v_tran_note[$key];
                $new_doc_ref=$v_doc_ref[$key];
                $new_qty=$v_qty[$key];
                $new_unit_price=$v_unit_price[$key];
                $new_acc_debit_old=$v_acc_debit_old[$key];
                $new_acc_credit_old=$v_acc_credit_old[$key];
                $new_acc_id=$v_acc_id[$key];
                $new_acc_debit=$v_acc_debit[$key];
                $new_acc_credit=$v_acc_credit[$key];
                 //Add Sub Item
                $query_add_2="INSERT INTO tbl_acc_add_tran_dr_cr_detail(
                    `main_id`, 
                    `ref_detail_id`, 
                    `status`, 
                    `detail_code`, 
                    `description`, 
                    `tran_note`, 
                    `doc_ref`, 
                    `qty`, 
                    `unit_price`, 
                    `debit_old`, 
                    `credit_old`, 
                    `acc_id`, 
                    `debit`, 
                    `credit`
                    )
                    VALUES
                    (
                    '$v_last_id',
                    '$new_ref_detail_id',
                    '$new_status',
                    '$new_detail_code',
                    '$new_des',
                    '$new_tran_note',
                    '$new_doc_ref',
                    '$new_qty',
                    '$new_unit_price',
                    '$new_acc_debit_old',
                    '$new_acc_credit_old',
                    '$new_acc_id',
                    '$new_acc_debit',
                    '$new_acc_credit'
                    )";
                if(!$connect->query($query_add_2)){
                    die($connect->error);
                }
            }
        }
        if($flag_add_1==1){
            header('location: add.php?status=true');
        }else{  
            echo '<script>myAlertError("Error")</script>';
        }
    }
     if(isset($_POST['btn_save_close'])){
        //Add Main Item
        $v_type_id = @$connect->real_escape_string($_POST['cboType']);
        $v_entry_no = @$connect->real_escape_string($_POST['cbo_entry_no']);
        $v_date_record = @$connect->real_escape_string($_POST['txt_date_record']);

        $query_add = "INSERT INTO `tbl_acc_add_tran_dr_cr`(
        `date_record`, 
        `ref_id`, 
        `status_type`, 
        `user_id`)
        VALUES (
        '$v_date_record',
        '$v_entry_no',
        '$v_type_id',
        '$user_id'
        )";
        if($connect->query($query_add))
            $flag_add_1=1;
        $v_last_id=$connect->insert_id;

        $v_status= @$_POST['txt_status'];
        $v_ref_detail_id=@$_POST['txt_ref_detail_id'];
        $v_detail_code=@$_POST['txt_detail_code'];
        $v_description=@$_POST['txt_description'];
        $v_tran_note=@$_POST['txt_tran_note'];
        $v_doc_ref=@$_POST['txt_doc_ref'];
        $v_qty=@$_POST['txt_qty'];
        $v_unit_price=@$_POST['txt_unit_price'];
        $v_acc_debit_old= @$_POST['txt_debit_old'];
        $v_acc_credit_old= @$_POST['txt_credit_old'];
        $v_acc_id= @$_POST['cbo_acc_id'];
        $v_acc_debit= @$_POST['txt_debit'];
        $v_acc_credit= @$_POST['txt_credit'];
        foreach ($v_acc_id as $key => $value) {
            die($value);
            if($value){
                $new_status=$v_status[$key];
                $new_ref_detail_id=$v_ref_detail_id[$key];
                $new_detail_code=$v_detail_code[$key];
                $new_des=$v_description[$key];
                $new_tran_note=$v_tran_note[$key];
                $new_doc_ref=$v_doc_ref[$key];
                $new_qty=$v_qty[$key];
                $new_unit_price=$v_unit_price[$key];
                $new_acc_debit_old=$v_acc_debit_old[$key];
                $new_acc_credit_old=$v_acc_credit_old[$key];
                $new_acc_id=$v_acc_id[$key];
                $new_acc_debit=$v_acc_debit[$key];
                $new_acc_credit=$v_acc_credit[$key];
                 //Add Sub Item
                $query_add_2="INSERT INTO tbl_acc_add_tran_dr_cr_detail(
                    `main_id`, 
                    `ref_detail_id`, 
                    `status`, 
                    `detail_code`, 
                    `description`, 
                    `tran_note`, 
                    `doc_ref`, 
                    `qty`, 
                    `unit_price`, 
                    `debit_old`, 
                    `credit_old`,  
                    `acc_id`, 
                    `debit`, 
                    `credit`
                    )
                    VALUES
                    (
                    '$v_last_id',
                    '$new_ref_detail_id',
                    '$new_status',
                    '$new_detail_code',
                    '$new_des',
                    '$new_tran_note',
                    '$new_doc_ref',
                    '$new_qty',
                    '$new_unit_price',
                    '$new_acc_debit_old',
                    '$new_acc_credit_old',
                    '$new_acc_id',
                    '$new_acc_debit',
                    '$new_acc_credit'
                    )";
                if(!$connect->query($query_add_2)){
                    die($connect->error);
                }
            }
        }
        if($flag_add_1==1){
            //Update balance add transaction
            // $sql1=$connect->query("SELECT * FROM tbl_acc_add_tran_dr_cr_detail");
            // while ($row1=mysqli_fetch_object($sql1)) {
            //     $sql2=$connect->query("SELECT A.*,C.tr_id
            //     FROM tbl_acc_chart_account AS A 
            //     LEFT JOIN tbl_acc_type_account AS B ON A.accca_account_type=B.accta_id
            //     LEFT JOIN tbl_acc_account_type_report AS C ON B.type_report_id=C.tr_id");
            //     while ($row2=mysqli_fetch_object($sql2)) {
            //         if($row2->tr_id=='1'||$row2->tr_id=='6'||$row2->tr_id=='4')
            //             $bal=$row1->debit-$row1->credit;
            //         else
            //             $bal=-$row1->debit+$row1->credit;
            //         $connect->query("UPDATE tbl_acc_add_tran_dr_cr_detail SET bal='$bal' WHERE id='$row1->id' AND acc_id='$row2->accca_id'");
            //     }
            // }
            header('location: index.php?v_status=true');
        }else{  
            header('location: index.php?v_status=fail');
        }
    }
 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Create Transaction Debit/Credit</h2>
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
                       <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <label class="control-label">Type :</label>
                                        <select name="cboType" onchange="changeType(this)" id="inputCboType" class="form-control myselect2" required="required">
                                            <option value="1">Adjustment Record</option>
                                            <option value="2">Stock / Inventory Record</option>
                                            <option value="3">Transfer Funds</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label for="input" class="control-label">Ref No *:</label>
                                        <select name="cbo_entry_no" id="input" onchange="changeItem();" class="form-control myselect2" required="required">
                                            <option value="">== Select and Choose ==</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="form-group">
                                        <label>Date : </label>
                                        <input type="text" name="txt_date_record" id="datepicker" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control date" required value="<?= date('Y-m-d') ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- Detail -->
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <table class="table-bordered" id="myTable">
                                    <style type="text/css">
                                        table >thead >tr th,table >tfoot >tr th{
                                            padding: 10px;
                                        }
                                    </style>
                                    <thead>
                                        <tr>
                                            <!-- <th class="text-center" style="width: 2%;">No</th> -->
                                            <th class="text-center" style="width: 4%;">Code</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Transation Note</th>
                                            <th class="text-center">Document Ref</th>
                                            <th class="text-center" style="width: 6px;">Quantity</th>
                                            <th class="text-center">Unit</th>
                                            <th class="text-center" style="width: 7%;">Debit</th>
                                            <th class="text-center" style="width: 7%;">Credit</th>
                                            <th class="text-center" style="width: 10%;">Account No</th>
                                            <th class="text-center" style="width: 20%;">Account Name</th>
                                            <th class="text-center" style="width: 7%;">Debit</th>
                                            <th class="text-center" style="width: 7%;">Credit</th>
                                            <th class="text-center" style="width: 3%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th class="text-right" colspan="2">Total Amount:</th>
                                            <th class="text-center">0.00</th>
                                            <th class="text-center">0.00</th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th class="text-right" colspan="2">Out of Balance:</th>
                                            <th class="text-center" colspan="2">0.00</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <br>
                                <div class="row">
                                    <div class="text-center">
                                        <div class="form_add_result"></div>
                                        <div id="add_more" class="btn btn-info btn-md"><i class="fa fa-plus"></i> Add More</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_save_new" class="btn blue"><i class="fa fa-save fa-fw"></i>Save & New</button>
                                <button type="submit" name="btn_save_close" class="btn yellow"><i class="fa fa-save fa-fw"></i>Save & Close</button>
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
<script type="text/javascript">
    $('#add_more').click(function(){ 
        var index_row = $('#myTable tr').length;
        $('#myTable').append('<tr data-row-id="'+(index_row)+'">'+$('.my_form_base').html()+'</tr>');
        // $('#myTable').append('<tr>'+$('.my_form_base').html()+'</tr>');
        $('tr[data-row-id='+index_row+']').find('select').select2();
    });
    //Load Item
    $(document).ready(function () { 
        changeType($('select[name=cboType]').html());
        $('button[name=btn_save_close]').attr("disabled", "disabled");
        $('button[name=btn_save_new]').attr("disabled", "disabled");
    });

    function changeType (args) {
        let v_type_id=parseInt($(args).val());
        $.ajax({url: 'ajx_get_content_select.php?p_type_id='+v_type_id,success:function (result) {
            $('select[name=cbo_entry_no]').html(result.trim());
        }});
    }
    

    $("tbody").on('click', 'button[name=btnUp],button[name=btnDown]', function () {
         var row = $(this).parents('tr:first');
        if ($(this).is('button[name=btnUp]')) 
            row.insertBefore(row.prev());
        else 
            row.insertAfter(row.next());
    });

    var index_row=0;
    function changeItem () {
        var v_type=$('select[name=cboType] >option:selected').val();
        var v_id=$('select[name=cbo_entry_no]').val();
        $.ajax({url: 'ajax_get_item.php?p_type='+v_type+"&p_id="+v_id,async:false,success:function (result) {
            $('tbody').html(result);
        }});

        $('tbody >tr').each(function () {
            $('tbody >tr[data-row-id='+(index_row++)+']').find('select').select2();
        });
        // =====
        $.ajax({url: 'ajx_get_ref_name.php?p_type='+v_type+"&p_id="+v_id,async:false,success:function (data,status) {
            $('input[name=txt_name]').val(data);
        }});

        //===========
        $('tbody >tr').each(function() {
            var v_debit=$(this).find('td:nth-last-child(3)');
            getDebit(v_debit);
            var v_credit=$(this).find('td:nth-last-child(2)');
            getCredit(v_credit);
        });
    }
    function changeAccName (args) {
        let v_acc_id=$(args).val();
         $.ajax({url: 'ajx_get_content_select.php?v_acc_id_name='+v_acc_id,success:function (result) {
            // alert(result);
            $(args).parents('tbody >tr').find('td:nth-last-child(5) >select').html(result);
        }});
    }
    function changeAccNo (args) {
        let v_acc_id=$(args).val();
         $.ajax({url: 'ajx_get_content_select.php?v_acc_id='+v_acc_id,success:function (result) {
            $(args).parents('tbody >tr').find('td:nth-last-child(4) >select').html(result);
        }});
    }

    function getDebit (args) {
        var v_total_debit=0;
        $('tbody >tr').find('td:nth-last-child(3)').each(function () {
            v_total_debit+=parseFloat($(this).find('input').val());
        });
        $('tfoot tr:first-child').find('th:nth-last-child(3)').html(v_total_debit.toFixed(2));
        totalAmount();
    }
    function getCredit (args) {
        var v_total_credit=0;
        $('tbody >tr').find('td:nth-last-child(2)').each(function () {
            v_total_credit+=parseFloat($(this).find('input').val());
        });
        $('tfoot tr:first-child').find('th:nth-last-child(2)').html(v_total_credit.toFixed(2));
        totalAmount();
    }
    function totalAmount () {
        let v_total_amo=0;
        let v_total_debit=$('tfoot tr:first-child').find('th:nth-last-child(3)').html();
        let v_total_credit=$('tfoot tr:first-child').find('th:nth-last-child(2)').html();
        v_total_amo=parseFloat(v_total_debit)-parseFloat(v_total_credit);      
        if(v_total_amo!=0){
            $('button[name=btn_save_close]').attr("disabled", "disabled");
            $('button[name=btn_save_new]').attr("disabled", "disabled");
        }
        else{
            $('button[name=btn_save_close]').removeAttr("disabled");
            $('button[name=btn_save_new]').removeAttr("disabled");
        }
        $('tfoot tr:last-child').find('th:nth-last-child(2)').html(v_total_amo.toFixed(2));
    }
    function getQty(args) {
        let v_qty=$(args).val();
        let v_unit_price=$(args).parents('tbody >tr').find('td:nth-last-child(7) >input').val();
        $(args).parents('tbody >tr').find('td:nth-last-child(6) >input').val(v_qty*parseFloat(v_unit_price));
    }
    function getUnitPrice (args) {
        let v_unit_price=$(args).val();
        let v_qty=$(args).parents('tbody >tr').find('td:nth-last-child(8) >input').val();
        $(args).parents('tbody >tr').find('td:nth-last-child(6) >input').val(parseFloat(v_unit_price)*parseFloat(v_qty));
    }
</script>
<?php include_once '../layout/footer.php' ?>