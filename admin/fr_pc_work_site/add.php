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
                $v_number = @$_POST['txt_number'];
                $v_ft_name = @$_POST['txt_ft_name'];
                $v_mo_name = @$_POST['txt_mo_name'];
                $v_fix_name = @$_POST['txt_fix_name'];
                $v_of_name = @$_POST['txt_of_name'];
                $v_other = @$_POST['txt_other'];
                $v_fr_order = @$_POST['txt_fr_order'];
                $v_fr_other = @$_POST['txt_fr_other'];
                $v_fixbuy_not = @$_POST['txt_fixbuy_not'];
                $v_fixbuy_ready = @$_POST['txt_fixbuy_ready'];
                $v_fixbuy_borrow = @$_POST['txt_fixbuy_borrow'];
                $v_pay_not = @$_POST['txt_pay_not'];
                $v_pay_ready = @$_POST['txt_pay_ready'];
                $v_note = @$_POST['txt_note'];

    $query_add_1 = "INSERT INTO tbl_acc_request_wordsite (
                reqw_date,
                reqw_number,
                reqw_ft_name,
                reqw_mo_name,
                reqw_fix_name,
                reqw_of_name,
                reqw_other,
                reqw_fr_order,
                reqw_fr_other,
                reqw_fixbuy_not,
                reqw_fixbuy_ready,
                reqw_fixbuy_borrow,
                reqw_pay_not,
                reqw_pay_ready,
                reqw_note
                ) 
            VALUES
                (
                '$v_date',
                '$v_number',
                '$v_ft_name',
                '$v_mo_name',
                '$v_fix_name',
                '$v_of_name',
                '$v_other',
                '$v_fr_order',
                '$v_fr_other',
                '$v_fixbuy_not',
                '$v_fixbuy_ready',
                '$v_fixbuy_borrow',
                '$v_pay_not',
                '$v_pay_ready',
                '$v_note'
                )";
    if ($connect->query($query_add_1)) {
        $flag_1 = 1;
        $v_id = $connect->insert_id;
    } else {
        echo 'Error';
        die();
    }

                        $v_description = @$_POST['txt_item_name'];
                        $v_qty = @$_POST['txt_qty'];
                        $v_unit = @$_POST['cbo_unit'];
                        $v_price = @$_POST['txt_price'];
                        $v_limit = @$_POST['txt_limit'];
                        $v_date_li = @$_POST['txt_date_li'];
                        $v_note1 = @$_POST['txt_note1'];

    foreach ($v_description as $key => $value) {
        if ($value) {
                        $new_description=$v_description[$key];
                        $new_qty=$v_qty[$key];
                        $new_unit=$v_unit[$key];
                        $new_price=$v_price[$key];
                        $new_limit=$v_limit[$key];
                        $new_date_li=$v_date_li[$key];
                        $new_note=$v_note1[$key];
            $query_add = "INSERT INTO tbl_acc_reqw_item_ (
                        reiw_numberw,
                        reiw_description,
                        reiw_qty,
                        reiw_unit,
                        reiw_price,
                        reiw_limit,
                        reiw_date_li,
                        reiw_note
                        ) 
                    VALUES
                        (
                        '$v_id',
                        '$new_description',
                        '$new_qty',
                        '$new_unit',
                        '$new_price',
                        '$new_limit',
                        '$new_date_li',
                        '$new_note'
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
                <div class="form-group">
                    <label>Date Record :</label>
                    <input type="text" data-provide="datepicker" value="<?= date("Y-m-d") ?>" data-date-format="yyyy-mm-dd" name="txt_date" class="form-control" required="">

                </div>
                <div class="form-group">
                    <label>លេខសណើរ :</label>
                    <input type="text" name="txt_number" id="input" class="form-control" required="required">
                </div>
            </div>

            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <br>
                <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_ft_name">
                            <label for="customCheckbox1" class="custom-control-label">រោងចក្រ</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_mo_name">
                            <label for="customCheckbox1" class="custom-control-label">រណ្តៅរ៉ែ</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_fix_name">
                            <label for="customCheckbox1" class="custom-control-label">ជួសជុល</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_of_name">
                            <label for="customCheckbox1" class="custom-control-label">ការិយាល័យ</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_other">
                            <label for="customCheckbox1" class="custom-control-label">ផ្សេងៗ</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_fr_order">
                            <label for="customCheckbox1" class="custom-control-label">ប្រភេទសំណើរទិញកម្មង់</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_fr_other">
                            <label for="customCheckbox1" class="custom-control-label">ស្នើប្រាក់ទូទាត់ ឬផ្សេងៗ</label>
                        </div>
                </div>
                <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <label>-បានជួសជុល ឬទិញរួច៖</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_fixbuy_not">
                            <label for="customCheckbox1" class="custom-control-label">មិនទាន់</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_fixbuy_ready">
                            <label for="customCheckbox1" class="custom-control-label">រួចរាល់</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_fixbuy_borrow">
                            <label for="customCheckbox1" class="custom-control-label">ទិញជំពាក់</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <label>-បានទូទាត់រួច៖</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_pay_not">
                            <label for="customCheckbox1" class="custom-control-label">មិនទាន់</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_pay_ready">
                            <label for="customCheckbox1" class="custom-control-label">រួចរាល់</label>
                        </div>
                </div>
            </div>

            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 pull-right">
                <div class="form-group">
                    <label>-ផ្សេងៗ៖
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
                <table id="myTable" class="table table-bordered myFormDetail_ns">
                    <thead>
                        <tr>
                            <th>
                                <label>បរិយាយ / ប្រភេទ / ទំហំ
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th style="width: 100px;">
                                <label>Qty (ចំនួន)
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th>
                                <label>Unit (គិតជា)
                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#modal_unit_name'>
                                        <i class="fa fa-plus"></i>
                                    </a>
                                    <div class="btn btn-success btn-xs" id="re_pro_name"><i class="fa fa-refresh"></i></div>

                                    <span class="required" aria-required="true">*</span>
                                </label>
                            </th>
                            <th>
                                <label>Price (តម្លៃរាយ)
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th style="width: 200px;">
                                <label>Amount (សរុប)
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th>
                                <label>កម្រិត
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th>
                                <label>ថ្ងៃកំណត់
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th>
                                <label>មូលហេតុ/សម្គាល់
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th>
                                <label>Action
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="my_form_base" style="background: red; display: none;">
                            <td>
                                <input type="text" class=" form-control" name="txt_item_name[]">
                            </td>
                            <td>
                                <input type="number" onkeyup="get_qty(this)" onchange="get_qty(this)" step="1" class="form-control" autocomplete="off" name="txt_qty[]" value="">
                            </td>
                            <td>
                                <select class="form-control" id="unit_name" name="cbo_unit[]">
                                    <option value="">==Please Choose and Select==</option>
                                    <?php
                                    $v_select = $connect->query("SELECT * FROM tbl_acc_unit_list ORDER BY uni_id ASC");
                                    while ($row_data = mysqli_fetch_object($v_select)) {
                                        echo '<option value="' . $row_data->uni_id . '">' . $row_data->uni_name . '</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" onkeyup="get_price(this)" step="0.01" class="form-control" autocomplete="off" name="txt_price[]" value="">
                            </td>
                            <td>
                                <input type="text" class="form-control" value="0" autocomplete="off" readonly="" name="txt_amount[]">
                            </td>
                            <td>
                                <input type="text" class=" form-control" name="txt_limit[]">
                            </td>
                            <td>
                                <input type="text" class=" form-control" name="txt_date_li[]">
                            </td>
                            <td>
                                <input type="text" class=" form-control" name="txt_note1[]">
                            </td>
                            <td class="text-center">
                                <button class="btnDelete">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <th class="text-right" colspan="4">Total Amount :</th>
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
        var price = $(obj).val();
        var qty = $(obj).parents('tr').find('td:nth-last-child(8) > input').val();
        var amo = price * qty;
        $(obj).parents('tr').find('td:nth-last-child(5) > input').val(amo.toFixed(2));
        cal_total_amount();
    }
    cal_total_amount();

    function cal_total_amount() {
        var v_total_amount =0;
        $('tbody >tr').find('td:nth-last-child(5)').each(function() {
            v_total_amount += parseFloat($(this).find('input').val());
        });
        $('tfoot >tr').find('th:last-child').html(v_total_amount.toFixed(2));
    }

    function get_qty(obj) {
        var qty = $(obj).val();
        var price = $(obj).parents('tr').find('td:nth-last-child(6) > input').val();
        var amo = price * qty;
        $(obj).parents('tr').find('td:nth-last-child(5) > input').val(amo.toFixed(2));
        cal_total_amount();
    }
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