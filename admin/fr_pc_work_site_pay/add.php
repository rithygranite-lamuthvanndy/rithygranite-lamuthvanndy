<?php
$menu_active = 13;
$left_active = 103;
$layout_title = "Add Page";
include_once '../../config/database.php';
include_once '../../config/athonication.php';
include_once '../layout/header.php';
?>


<?php
if (isset($_POST['btn_submit'])) {
                $v_date = @$_POST['txt_date'];
                $v_no = @$_POST['txt_number'];
                $v_description = @$_POST['txt_desc'];
                $v_trans_type = @$_POST['cbo_tran_from'];
                $v_bank_name = @$_POST['txt_bank_name'];
                $v_acc_name = @$_POST['txt_acc_name'];
                $v_acc_num = @$_POST['txt_acc_num'];
                $v_pay = @$_POST['txt_pay'];
                $v_receive = @$_POST['txt_receive'];
                $v_note = @$_POST['txt_note'];

    $query_add_1 = "INSERT INTO tbl_frpc_add_pay (
                ap_no,
                ap_date,
                ap_description,
                ap_trans_type,
                ap_bank_name,
                ap_acc_name,
                ap_acc_num,
                ap_pay,
                ap_receive,
                ap_note
                ) 
            VALUES
                (
                '$v_no',
                '$v_date',
                '$v_description',
                '$v_trans_type',
                '$v_bank_name',
                '$v_acc_name',
                '$v_acc_num',
                '$v_pay',
                '$v_receive',
                '$v_note'
                )";

    if ($connect->query($query_add_1)) {
        $flag_1 = 1;
        $v_id = $connect->insert_id;
    } else {
        echo 'Error';
        die();
    }
                        $v_new_description = @$_POST['txt_new_description'];
                        $v_new_type = @$_POST['cbo_tran_from2'];
                        $v_new_bank_name = @$_POST['txt_bank_name2'];
                        $v_new_acc_name = @$_POST['txt_new_acc_name'];
                        $v_new_acc_no = @$_POST['txt_new_acc_no'];
                        $v_new_frpc_id = @$_POST['txt_new_frpc_id'];
                        $v_new_inv_no = @$_POST['txt_new_inv_no'];
                        $v_new_amount = @$_POST['txt_amount'];

    foreach ($v_new_description as $key => $value) {
        if ($value) {
                        $new_description=$v_new_description[$key];
                        $new_type=$v_new_type[$key];
                        $new_bank_name=$v_new_bank_name[$key];
                        $new_acc_name=$v_new_acc_name[$key];
                        $new_acc_no=$v_new_acc_no[$key];
                        $new_frpc_id=$v_new_frpc_id[$key];
                        $new_inv_no=$v_new_inv_no[$key];
                        $new_amount=$v_new_amount[$key];
            $query_add = "INSERT INTO tbl_frpc_add_pay_list (
                        apl_ap_id,
                        apl_description,
                        apl_type,
                        apl_bank_name,
                        apl_acc_name,
                        apl_acc_no,
                        apl_frpc_id,
                        apl_inv_no,
                        apl_amount
                        ) 
                    VALUES
                        (
                        '$v_id',
                        '$new_description',
                        '$new_type',
                        '$new_bank_name',
                        '$new_acc_name',
                        '$new_acc_no',
                        '$new_frpc_id',
                        '$new_inv_no',
                        '$new_amount'
                        )";
            $flag = $connect->query($query_add);
        }
    }

    if ($flag_1 == 1 && $flag) {
        $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data inserted ...
            </div>';
    } else {
        $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> Query error ...
            </div>';
    }
}

?>


<div class="portlet light bordered">
    <br>
    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-1">
                <div class="caption font-dark">
                    <a href="index.php" id="sample_editable_1_new" class="btn red">
                        <i class="fa fa-arrow-left"></i>
                        Back
                    </a>
                    <p id="total_amount"></p>
                </div>
            </div>
            <div class="col-xs-1">
                <div class="caption font-dark">

                </div>
            </div>
        </div>
    </div>
    <form action="#" method="post" accept-charset="utf-8">
        <div class="row" style="padding: 0 15px;">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <br>
                <div class="form-group">
                    <label>Date Record :</label>
                    <input type="text" data-provide="datepicker" value="<?= date("Y-m-d") ?>" data-date-format="yyyy-mm-dd" name="txt_date" class="form-control" required="">

                </div>
                <div class="form-group">
                    <label>Number Pay :</label>
                    <input type="text" name="txt_number" id="input" class="form-control" required="required">
                </div>
                <div class="form-group">
                    <label>Descriptopm :</label>
                    <input type="text" name="txt_desc" id="input" class="form-control" required="required">
                </div>
            </div>

            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <br>
                <div class="form-group">
                    <label>Payer By :</label>
                    <input type="text" name="txt_pay" id="input" class="form-control" required="required">
                </div>
                <div class="col-sm-12">
                    <div class="form-group col-sm-6">
                        <label>Transaction Type :</label>
                                <select name="cbo_tran_from" class="form-control myselect2" required="" autocomplete="off">
                                    <option value="1"> ទូទាត់ជាសាច់ប្រាក់ </option>
                                    <option value="2"> ទូទាត់ជា Cheque </option>
                                    <option value="3"> ទូទាត់តាម ការបាញ់ App </option>
                                    <option value="4"> ទូទាត់តាមរយៈផ្សេងៗ </option>
                                </select>                       
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Bank Name:</label>
                        <input type="text" name="txt_bank_name" id="inputCbo_amo_debit" class="form-control" autocomplete="off" >                        
                    </div>                                       
                    
                </div>
                <div class="col-sm-12">
                    <div class="form-group col-sm-6">
                        <label>Account Name:</label>
                        <input type="text" name="txt_acc_name" id="inputCbo_amo_debit" class="form-control" autocomplete="off">                        
                    </div>    
                    <div class="form-group col-sm-6">
                        <label>Account Number:</label>
                        <input type="text" name="txt_acc_num" id="inputCbo_amo_debit" class="form-control" autocomplete="off">                        
                    </div> 
                </div>
            </div>

            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 pull-right">
                <br>
                <div class="form-group">
                    <label>Receive By :</label>
                    <input type="text" name="txt_receive" class="form-control" autocomplete="off">
                </div>
                <div class="form-group">
                    <label>Note :
                        <span class="required" aria-required="true">*</span>
                    </label>
                    <textarea name="txt_note" rows="5" class="form-control"></textarea>
                    <br>
                </div>

            </div>
        </div>
        <br>
        <div class="portlet-body">
            <div class="bs-example" data-example-id="bordered-table">
                <table id="myTable" class="table table-bordered table-hover myFormDetail_ns">
                    <thead>
                        <tr>
                            <th style="vertical-align: middle; text-align: center;">
                                <label>បរិយាយទូទាត់
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th style="vertical-align: middle; text-align: center;">
                                <label>ប្រភេទទូទាត់
                                </label>
                            </th>
                            <th style="vertical-align: middle; text-align: center;">
                                <label>ឈ្មោះធនាគារ
                                </label>
                            </th>
                            <th style="vertical-align: middle; text-align: center;">
                                <label>ឈ្មោះគណនេយ្យ
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th style="vertical-align: middle; text-align: center;">
                                <label>លេខគណនេយ្យ
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th style="vertical-align: middle; text-align: center; width: 200px;">
                                <label>Requesct No
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th style="vertical-align: middle; text-align: center; width: 200px;">
                                <label>Invoice No
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th style="vertical-align: middle; text-align: center;">
                                <label>Amount
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th style="vertical-align: middle; text-align: center;">
                                <label>Action
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="my_form_base" style="background: red; display: none;">
                            <td>
                                <input type="text" class=" form-control" name="txt_new_description[]">
                            </td>
                            <td>
                                <select name="cbo_tran_from2[]" class="form-control" required="" autocomplete="off">
                                    <option value="1"> ទូទាត់ជាសាច់ប្រាក់ </option>
                                    <option value="2"> ទូទាត់ជា Cheque </option>
                                    <option value="3"> ទូទាត់តាម ការបាញ់ App </option>
                                    <option value="4"> ទូទាត់តាមរយៈផ្សេងៗ </option>
                                </select>   
                            </td>
                            <td>
                                <input type="text" class=" form-control" name="txt_bank_name2[]">
                            </td>
                            <td>
                                <input type="text" class=" form-control" name="txt_new_acc_name[]">
                            </td>
                            <td>
                                <input type="text" class=" form-control" name="txt_new_acc_no[]">
                            </td>
                            <td>
                                <select type="text" class="form-control" name="txt_new_frpc_id[]" required="" autocomplete="off">
                                    <option value="">=== Select and choose===</option>
                                        <?php
                                            $v_select = $connect->query("SELECT * FROM tbl_acc_reqw_item_ 

                                                ORDER BY reiw_description DESC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                               
                                                    echo '<option selected value="'.$row_data->reiw_id.'">'.$row_data->reiw_description.'</option>';

                                            }

                                        ?>
                                </select>
                            </td>
                            <td>
                                <select type="text" class="form-control" name="txt_new_inv_no[]" required="" autocomplete="off">
                                    <option value="">=== Select and choose===</option>
                                        <?php
                                            $v_select = $connect->query("SELECT * FROM tbl_frpc_add_inv 

                                                ORDER BY ai_id DESC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                               
                                                    echo '<option selected value="'.$row_data->ai_id.'">'.$row_data->ai_no.' || '.$row_data->ai_supply.'</option>';

                                            }

                                        ?>
                                </select>
                            </td>
                            <td>
                                <input type="text" onkeyup="cal_total_amount()" class="form-control" name="txt_amount[]">
                            </td>
                            <td class="text-center">
                                <button class="btnDelete">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <th class="text-right" colspan="7">Total Amount :</th>
                        <th>1.00</th>
                        
                    </tfoot>
                </table>
                <div class="form-group text-center">
                    <div id="add_more" class="btn btn-default yellow btn-md"><i class="fa fa-plus"></i>Add More</div>
                </div>


            </div>
            <br>
            <div class="clearfix"></div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button type="submit" name="btn_submit" class="btn green"><i class="fa fa-save fa-fw"></i>Save</button>
                        <a onclick="return confirm('Are you sure to Cancel this?')" href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="../../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    var index_row = 1;
    $('#add_more').click(function() {
        $('#myTable').append('<tr data-row-id="' + (++index_row) + '">' + $('.my_form_base').html() + '</tr>');
        $('tr[data-row-id=' + index_row + ']').find('select').select2({
            width: 'auto'
        });
    });

    setTimeout(function() {
        $('#add_more').click();
    }, 2000);

    $("tbody").on('click', '.btnDelete', function() {
        var rowCount = $('tbody>tr').length;
        if (rowCount < 3) {
            alert("You can not delete this record.");
            return;
        }
        $(this).parents('tr').remove();
    });

    function get_price(obj) {
        let amo=$(args).parents('tbody >tr').find('td:nth-child(2) >input').val();
        $(args).parents('tbody >tr').find('td:nth-child(2) >input').val(amo.toFixed(2)+" $");
    }

    function cal_total_amount() {
        var v_total_amount =0;
        $('tbody >tr').find('td:nth-last-child(8) >input').each(function() {
            v_total_amount += parseFloat($(this).find('input').val());
        });
        $('tfoot >tr').find('th:last-child').html(v_total_amount.toFixed(2));
        
    }
</script>

<script type="text/javascript">
$(document).ready(function () {
    $('input[name=txt_bank_name]').parents('div[class="form-group col-sm-6"]').hide();
    $('input[name=txt_acc_name]').parents('div[class="col-sm-12"]').hide();
    $('input[name=txt_acc_num]').parents('div[class="col-sm-12"]').hide();

    $('select[name=cbo_tran_from]').change(function () {

        var status_id=parseInt($("select[name=cbo_tran_from] >option:selected").val());
        switch(status_id) {
            case 1:
        $('input[name=txt_bank_name]').parents('div[class="form-group col-sm-6"]').hide();
        $('input[name=txt_acc_name]').parents('div[class="col-sm-12"]').hide();
        $('input[name=txt_acc_num]').parents('div[class="col-sm-12"]').hide();           
                break;
            case 2:
        $('input[name=txt_bank_name]').parents('div[class="form-group col-sm-6"]').show();
        $('input[name=txt_acc_name]').parents('div[class="col-sm-12"]').show();
        $('input[name=txt_acc_num]').parents('div[class="col-sm-12"]').show();            
                break;
            case 3:
        $('input[name=txt_bank_name]').parents('div[class="form-group col-sm-6"]').show();
        $('input[name=txt_acc_name]').parents('div[class="col-sm-12"]').show();
        $('input[name=txt_acc_num]').parents('div[class="col-sm-12"]').show();            
                break;
            case 4:
        $('input[name=txt_bank_name]').parents('div[class="form-group col-sm-6"]').hide();
        $('input[name=txt_acc_name]').parents('div[class="col-sm-12"]').hide();
        $('input[name=txt_acc_num]').parents('div[class="col-sm-12"]').hide();
                  break;          
        }

    });
});
</script>


<?php include_once '../layout/footer.php' ?>

<div class="modal fade" id="request_name">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_request_name.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="pos_name">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_pos.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="item_name">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_item_name.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>


<div class="modal fade" id="modal_unit_name">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_unit.php" frameborder="0" style="height: 420px; max-width: 100%; width: 100%;" align="right" scrolling="0"></iframe>
    </div>
</div>


<div class="modal fade" id="pre_by">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_prepare_by.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="check_by">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_check_by.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="app_by">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_approved_by.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="add_dep">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_depment.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="add_type_of_req">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_type_of_req.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>

<div class="modal fade" id="modal">
    <div class="modal-dialog" style="border: 1px solid darkred; width: 70%;">
        <iframe id="result_modal" frameborder="0" style="height: 600px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>