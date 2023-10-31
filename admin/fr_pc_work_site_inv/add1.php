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
                $v_supply = @$_POST['txt_supply'];
                $v_note = @$_POST['txt_note'];

    $query_add_1 = "INSERT INTO tbl_frpc_add_inv (
                ai_no,
                ai_date,
                ai_supply,
                ai_note
                ) 
            VALUES
                (
                '$v_no',
                '$v_date',
                '$v_supply',
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
                        $v_frpc_id = @$_POST['txt_frpc_id'];
                        $v_frpc_no = @$_POST['txt_frpc_no'];
                        $v_date_pay = @$_POST['txt_date_pay'];

    foreach ($v_description as $key => $value) {
        if ($value) {
                        $new_description=$v_description[$key];
                        $new_qty=$v_qty[$key];
                        $new_unit=$v_unit[$key];
                        $new_price=$v_price[$key];
                        $new_frpc_id=$v_frpc_id[$key];
                        $new_frpc_no=$v_frpc_no[$key];
                        $new_date_pay=$v_date_pay[$key];
            $query_add = "INSERT INTO tbl_frpc_add_inv_list (
                        ail_ai_id,
                        ail_description,
                        ail_qty,
                        ail_unit,
                        ail_unit_price,
                        ail_frpc_id,
                        ail_frpc_no,
                        ail_date_pay
                        ) 
                    VALUES
                        (
                        '$v_id',
                        '$new_description',
                        '$new_qty',
                        '$new_unit',
                        '$new_price',
                        '$new_frpc_id',
                        '$new_frpc_no',
                        '$new_date_pay'
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
                    <label>Number Invoice :</label>
                    <input type="text" name="txt_number" id="input" class="form-control" required="required">
                </div>
            </div>

            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <br>
                <div class="form-group">
                    <label>Supplier Name : </label>
                        <a class="btn btn-primary btn-xs" data-toggle="modal" href='#add_modal' onclick="set_iframe_counter()"><i class="fa fa-plus"></i></a>
                        <div class="btn btn-success btn-xs" id="refresh_cbo_counter"><i class="fa fa-refresh"></i></div>
                        <select name="txt_supply" id="input" class="form-control myselect2" required="required">
                        <option value="">*** Select and choose ***</option>
                                            <?php 
                                                $v_result=$connect->query("SELECT * FROM tbl_op_sup_list ORDER BY osl_id");
                                                while ($row_select=mysqli_fetch_object($v_result)) {
                                                echo '<option value="'.$row_select->osl_id.'">'.$row_select->osl_name.'</option>';

                                                }
                                             ?>
                        </select>
                </div>
                <div class="form-group">
                    <label>Type :</label>
                    <input type="text" name="txt_number1" class="form-control" >
                </div>
                <div class="form-group">
                    <label>Number Phone :</label>
                    <input type="text" name="txt_number2" class="form-control">
                </div>
            </div>

            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 pull-right">
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
                <table id="myTable" class="table table-bordered myFormDetail_ns">
                    <thead>
                        <tr>
                            <th>
                                <label>បរិយាយ / ប្រភេទ / ទំហំ
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th>
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
                            <th>
                                <label>Amount (សរុប)
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th>
                                <label>Requesct No
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th>
                                <label>Product Name
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th>
                                <label>Date Pay
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
                                <select class="form-control" id="unit_name" name="txt_frpc_id[]" onchange="cbofrpcid(this);"required="" autocomplete="off">
                                    <option value="">==Please Choose and Select==</option>
                                    <?php
                                    $v_select = $connect->query("SELECT * FROM tbl_acc_request_wordsite ORDER BY reqw_id ASC");
                                    while ($row_data = mysqli_fetch_object($v_select)) {
                                        echo '<option data_id="'.$row_data->reqw_id.'"value="' . $row_data->reqw_id . '">' . $row_data->reqw_number . '</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <select type="text" class="form-control" name="txt_frpc_no[]" required="" autocomplete="off">
                                    <option value="">=== Select and choose===</option>
                                        <?php
                                        // $get_select=$connect->query("SELECT * FROM tbl_st_category_list ORDER BY stca_name ASC");
                                        // while($row_data = mysqli_fetch_object($get_select)){
                                        //     echo '<option value="'.$row_data->stca_id.'">'.$row_data->stca_name.'</option>';
                                        // }
                                        ?>
                                </select>
                            </td>
                            <td>
                                <input type="text" data-provide="datepicker" value="<?= date("Y-m-d") ?>" data-date-format="yyyy-mm-dd" name="txt_date_pay[]" class="form-control" required="">
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
<script type="text/javascript">
    function cbofrpcid (args) {
        let v_inv_id=$(args).find('option:selected').attr('data_id');
        $.ajax({url: 'ajax_get_content_select.php?p_inv_code='+v_inv_id,success:function (result) {
            $(args).parents('tr').find('td:nth-child(7) >select').html(result); 
        }});
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