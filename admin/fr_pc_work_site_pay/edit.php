<?php
$menu_active = 13;
$left_active = 33;
$layout_title = "Edit Page";
include_once '../../config/database.php';
include_once '../../config/athonication.php';
include_once '../layout/header.php';
?>


<?php
if (@$_GET['edit_id']) {
    $id = @$_GET['edit_id'];
    $sql = $connect->query("SELECT * FROM tbl_acc_request_wordsite 
            WHERE reqw_id=$id
            ");
    $row_old = mysqli_fetch_object($sql);
}


if (isset($_POST['btn_submit'])) {

    $v_id = @$_POST['txt_id'];
    $v_date = @$_POST['txt_date'];
    $v_number = @$_POST['txt_number'];
    $v_re_name = @$_POST['cbo_re_name'];
    $v_pos = @$_POST['cbo_pos'];
    $v_pre_by = @$_POST['cbo_pre_by'];
    $v_check_by = @$_POST['cbo_check_by'];
    $v_appro_by = @$_POST['cbo_appro_by'];
    $v_dep = @$_POST['cbo_dep'];
    $v_type_of_req = @$_POST['cbo_type_of_req'];


    $query_update = "UPDATE `tbl_acc_request_form` 
            SET 
                req_date='$v_date',
                req_number='$v_number',
                dep_id='$v_dep',
                type_req_id='$v_type_of_req',
                req_request_name='$v_re_name',
                req_position='$v_pos',
                req_prepare_by='$v_pre_by',
                req_check_by='$v_check_by',
                req_approved_by='$v_appro_by'
            WHERE `req_id`='$v_id'";
    if ($connect->query($query_update))
        $flag = 1;
    else {
        echo 'Error';
        die();
    }

    $v_sub_id = @$_POST['txt_sub_id'];
    $v_unit = @$_POST['cbo_unit'];
    $v_item_name = @$_POST['txt_item_name'];
    $v_qty = @$_POST['txt_qty'];
    $v_price = @$_POST['txt_price'];
    $v_item_type = @$_POST['txt_item_type'];
    $v_size = @$_POST['txt_size'];
    $v_track=@$_POST['cbo_track'];
    foreach ($v_item_name as $key => $value) {
        if ($value) {
            $new_id = $v_sub_id[$key];
            $new_item = $v_item_name[$key];
            $new_unit = $v_unit[$key];
            $new_qty = $v_qty[$key];
            $new_price = $v_price[$key];
            $new_item_type = $v_item_type[$key];
            $new_size = $v_size[$key];
            $new_track=$v_track[$key];
            if ($new_id == 0 && $v_item_name) {
                $query_add = "INSERT INTO tbl_acc_request_item (
                        rei_number,
                        rei_item_name,
                        rei_type,
                        rei_size,
                        rei_qty,
                        rei_unit,
                        rei_price,
                        for_area
                        ) 
                    VALUES
                        (
                        '$v_id',
                        '$new_item',
                        '$new_item_type',
                        '$new_size',
                        '$new_qty',
                        '$new_unit',
                        '$new_price',
                        '$new_track'
                        )";
                $flag_1 = $connect->query($query_add);
            } else {
                $sql_update = "UPDATE tbl_acc_request_item SET 
                            rei_number='$v_id',
                            rei_item_name='$new_item',
                            rei_type='$new_item_type',
                            rei_size='$new_size',
                            rei_qty='$new_qty',
                            rei_unit='$new_unit',
                            rei_price='$new_price',
                            for_area='$new_track'
                    WHERE rei_id='$new_id'
                            ";

                $flag_1 = $connect->query($sql_update);
            }
        }
    }


    if ($flag = 1 && $flag_1) {
        $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data update ...
            </div>';
    } else {
        $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> Query error ...
            </div>';
    }
}


// // get old data 
//     $edit_id = @$_GET['edit_id'];
//     $old_data = $connect->query("SELECT * FROM tbl_acc_request_form WHERE req_id='$edit_id'");
//     $row_old_data = mysqli_fetch_object($old_data);


?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Edit Record</h2>
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
        <form action="#" method="post" accept-charset="utf-8">
            <div class="row" style="padding: 0 15px;">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="border: 1px #C5BCBC solid;">
                        <div class="form-group">
                            <label>Date Record :</label>
                            <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" required name="txt_date" value="<?= $row_old->reqw_date ?>">
                            <input type="hidden" name="txt_id" id="inputTxt_id" class="form-control" value="<?= $id ?>" required="required" pattern="" title="">
                        </div>
                        <div class="form-group">
                            <label>លេខសណើរ :</label>
                            <input type="text" name="txt_number" id="input" class="form-control" value="<?= $row_old->reqw_number ?>" required="required" pattern="" title="">
                        </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 pull-right">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_ft_name" <?php if($row_old->reqw_ft_name>"0"){ echo 'checked';} ?> >
                            <label for="customCheckbox1" class="custom-control-label">រោងចក្រ</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_mo_name" <?php if($row_old->reqw_mo_name>"0"){ echo 'checked';} ?> >
                            <label for="customCheckbox1" class="custom-control-label">រណ្តៅរ៉ែ</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_fix_name" <?php if($row_old->reqw_fix_name>"0"){ echo 'checked';} ?> >
                            <label for="customCheckbox1" class="custom-control-label">ជួសជុល</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_of_name" <?php if($row_old->reqw_of_name>"0"){ echo 'checked';} ?> >
                            <label for="customCheckbox1" class="custom-control-label">ការិយាល័យ</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_other" <?php if($row_old->reqw_other>"0"){ echo 'checked';} ?> >
                            <label for="customCheckbox1" class="custom-control-label">ផ្សេងៗ</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_fr_order" <?php if($row_old->reqw_fr_order>"0"){ echo 'checked';} ?> >
                            <label for="customCheckbox1" class="custom-control-label">ប្រភេទសំណើរទិញកម្មង់</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_fr_other" <?php if($row_old->reqw_fr_other>"0"){ echo 'checked';} ?> >
                            <label for="customCheckbox1" class="custom-control-label">ស្នើប្រាក់ទូទាត់ ឬផ្សេងៗ</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <label>-បានជួសជុល ឬទិញរួច៖</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_fixbuy_not" <?php if($row_old->reqw_fixbuy_not>"0"){ echo 'checked';} ?> >
                            <label for="customCheckbox1" class="custom-control-label">មិនទាន់</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_fixbuy_ready" <?php if($row_old->reqw_fixbuy_ready>"0"){ echo 'checked';} ?> >
                            <label for="customCheckbox1" class="custom-control-label">រួចរាល់</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_fixbuy_borrow" <?php if($row_old->reqw_fixbuy_borrow>"0"){ echo 'checked';} ?> >
                            <label for="customCheckbox1" class="custom-control-label">ទិញជំពាក់</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <label>-បានទូទាត់រួច៖</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_pay_not" <?php if($row_old->reqw_pay_not>"0"){ echo 'checked';} ?> >
                            <label for="customCheckbox1" class="custom-control-label">មិនទាន់</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_pay_ready" <?php if($row_old->reqw_pay_ready>"0"){ echo 'checked';} ?> >
                            <label for="customCheckbox1" class="custom-control-label">រួចរាល់</label>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 pull-right">
                    <div class="form-group">
                        <label>-ផ្សេងៗ៖
                            <span class="required" aria-required="true">*</span>
                        </label>
                        <textarea name="txt_note" rows="5" class="form-control"><?= $row_old->reqw_note ?></textarea>
                        <br>
                    </div>
                </div>                
            </div>
            <br>
            <div class="portlet-body">
                <div class="bs-example" data-example-id="bordered-table">

                    <div class="panel-body">
                        <table id="myTable" class="table table-bordered myFormDetail_ns">
                            <thead>
                                <tr>
                                    <th style="width: 200px;">
                                        <label>បរិយាយ / ប្រភេទ / ទំហំ
                                            <span class="required" aria-required="true"></span>
                                        </label>
                                    </th>
                                    <th>
                                        <label>Qty (ចំនួន)
                                            <span class="required" aria-required="true"></span>
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
                                        <input type="hidden" name="txt_sub_id[]" value="0">
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
                                        <input type="text" class="form-control" name="txt_limit[]">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="txt_date_li[]">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="txt_note1[]">
                                    </td>
                                    <td class="text-center">
                                        <button class="btnDelete" my_id="1">Delete</button>
                                    </td>
                                </tr>




                                <?php
                                $id = @$_GET['edit_id'];                                
                                $sql_sub = $connect->query("SELECT * FROM `tbl_acc_reqw_item_` WHERE reiw_numberw='399'");
                                while ($row_sub = mysqli_fetch_object($sql_sub)) {
                                    ?>

                                <tr class="my_form_base" style="background: red; display: none;">
                                    <td>
                                        <input type="hidden" name="txt_sub_id[]" value="<?= $row_sub->reiw_id ?>">
                                        <input type="text" class="form-control" name="txt_item_name[]" value="<?= $row_sub->reiw_description ?>">
                                    </td>
                                    <td>
                                        <input type="number" onkeyup="get_qty(this)" onchange="get_qty(this)" step="1" class="form-control" autocomplete="off" name="txt_qty[]" value="<?= $row_sub->reiw_qty ?>">

                                    </td>
                                    <td>
                                        <select id="unit_name" name="cbo_unit[]" id="inputCbo_position" class="form-control myselect2" required="required">
                                            <option value="">==Please Choose and Select==</option>
                                            <?php
                                            $v_select = $connect->query("SELECT * FROM tbl_acc_unit_list ORDER BY uni_id ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                if ($row_sub->reiw_unit == $row_data->uni_id)
                                                    echo '<option SELECTED value="' . $row_data->uni_id . '">' . $row_data->uni_name . '</option>';
                                                else
                                                    echo '<option value="' . $row_data->uni_id . '">' . $row_data->uni_name . '</option>';
                                            }
                                            ?>
                                        </select>

                                    </td>
                                    <td>
                                        <input type="number" onkeyup="get_price(this)" step="0.01" class="form-control" autocomplete="off" name="txt_price[]" value="<?= $row_sub->reiw_price ?>">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="0" autocomplete="off" readonly="" name="txt_amount[]" value="<?= number_format($row_sub->reiw_qty * $row_sub->reiw_price, 2) ?>">
                                    </td>
                                    <td>
                                        <input type="text" class=" form-control" name="txt_limit[]" value="<?= $row_sub->reiw_limit ?>">
                                    </td>
                                    <td>
                                        <input type="text" class=" form-control" name="txt_date_li[]" value="<?= $row_sub->reiw_date_li ?>">
                                    </td>
                                    <td>
                                        <input type="text" class=" form-control" name="txt_note1[]" value="<?= $row_sub->reiw_note ?>">
                                    </td>
                                    <td class="text-center">
                                        <button class="btnDelete">Delete</button>
                                    </td>
                                </tr>                            

                                <?php
                                }
                                ?>
                            </tbody>


                            <tfoot>
                                <th class="text-right" colspan="4">Total Amount :</th>
                                <th>1.00</th>
                                <th class="text-right" colspan="4"></th>
                            </tfoot>

                        </table>
                        <div class="form-group text-center">
                            <div id="add_more" class="btn btn-default yellow btn-md"><i class="fa fa-plus"></i>Add More</div>
                        </div>
                        <div class="row" style="padding: 0 15px;">
                            <div class="col-xs-4 border text-center" style=" border: 1px #C5BCBC solid;">
                                <h5>
                                    Approved By
                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#app_by'><i class="fa fa-plus"></i></a>
                                    <div class="btn btn-success btn-xs" id="re_fresh_app_by">
                                    <i class="fa fa-refresh"></i>
                                    </div>

                                </h5>
                                <br>
                                <br>
                                <br>
                                <h5><strong>
                                        <div class="form-group form-md-line-input">
                                            <select class="form-control selectpicker" data-live-search="true" name="cbo_appro_by" autocomplete="off" required="">
                                                <option value="">=== Please Choose and Select ===</option>
                                                <?php
                                                $v_select = $connect->query("SELECT * FROM tbl_acc_approved_name_list ORDER BY apn_name ASC");
                                                while ($row_data = mysqli_fetch_object($v_select)) {
                                                    if ($row_old->req_approved_by == $row_data->apn_id)
                                                        echo '<option SELECTED value="' . $row_data->apn_id . '">' . $row_data->apn_name . '</option>';
                                                    else
                                                        echo '<option value="' . $row_data->apn_id . '">' . $row_data->apn_name . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </strong></h5>
                            </div>
                            <div class="col-xs-4 border text-center" style=" border: 1px #C5BCBC solid;">
                                <h5>
                                    Check By
                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#check_by'><i class="fa fa-plus"></i></a>
                                    <div class="btn btn-success btn-xs" id="re_fresh_check_by">
                                    <i class="fa fa-refresh"></i>
                                    </div>
                                </h5>
                                <br>
                                <br>
                                <br>
                                <h5><strong>
                                        <div class="form-group form-md-line-input">
                                            <select class="form-control selectpicker" data-live-search="true" name="cbo_check_by" autocomplete="off" required="">
                                                <option value="">=== Please Choose and Select ===</option>
                                                <?php
                                                $v_select = $connect->query("SELECT * FROM tbl_acc_check_name_list ORDER BY chn_name ASC");
                                                while ($row_data = mysqli_fetch_object($v_select)) {
                                                    if ($row_old->req_check_by == $row_data->chn_id)
                                                        echo '<option SELECTED value="' . $row_data->chn_id . '">' . $row_data->chn_name . '</option>';
                                                    else
                                                        echo '<option value="' . $row_data->chn_id . '">' . $row_data->chn_name . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </strong></h5>
                            </div>
                            <div class="col-xs-4 border text-center" style=" border: 1px #C5BCBC solid;">
                                <h5>
                                    Prepare By
                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#pre_by'><i class="fa fa-plus"></i></a>
                                    <div class="btn btn-success btn-xs" id="re_fresh_pre_by">
                                    <i class="fa fa-refresh"></i>
                                    </div>

                                </h5>
                                <br>
                                <br>
                                <br>
                                <h5><strong>
                                        <div class="form-group form-md-line-input">
                                            <select class="form-control selectpicker" data-live-search="true" name="cbo_pre_by" autocomplete="off" required="">
                                                <option value="">=== Please Choose and Select ===</option>
                                                <?php
                                                $v_select = $connect->query("SELECT * FROM tbl_acc_prepare_name_list ORDER BY pren_id ASC");
                                                while ($row_data = mysqli_fetch_object($v_select)) {
                                                    if ($row_old->req_prepare_by == $row_data->pren_id)
                                                        echo '<option SELECTED value="' . $row_data->pren_id . '">' . $row_data->pren_name . '</option>';
                                                    else
                                                        echo '<option value="' . $row_data->pren_id . '">' . $row_data->pren_name . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </strong></h5>
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
                    <!-- </form><br> -->
                </div>

            </div>
    </div>
    </form>
</div>
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
        <iframe src="iframe_add_unit.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
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