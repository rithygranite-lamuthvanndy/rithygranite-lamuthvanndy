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
    $sql = $connect->query("SELECT * FROM tbl_acc_request_form 
            WHERE req_id=$id
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
                        <label>Request Name :
                            <span class="required" aria-required="true"></span>
                        </label>
                        <input type="hidden" name="txt_id" id="inputTxt_id" class="form-control" value="<?= $id ?>" required="required" pattern="" title="">
                        <a class="btn btn-primary btn-xs" data-toggle="modal" href='#request_name'><i class="fa fa-plus"></i></a>
                        <div class="btn btn-success btn-xs" id="re_fresh_name">
                        <i class="fa fa-refresh"></i>
                        </div>

                        <select class="form-control myselect2" name="cbo_re_name" required="">
                            <option value="">=== Please Choose and Select ===</option>
                            <?php
                            $v_select = $connect->query("SELECT * FROM tbl_acc_request_name_list ORDER BY res_id ASC");
                            while ($row_data = mysqli_fetch_object($v_select)) {
                                if ($row_old->req_request_name == $row_data->res_id)
                                    echo '<option SELECTED value="' . $row_data->res_id . '">' . $row_data->res_name . '</option>';
                                else
                                    echo '<option value="' . $row_data->res_id . '">' . $row_data->res_name . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group form-md-line-input">
                        <input type="text" name="txt_number" value="<?= $row_old->req_number ?>" id="input" class="form-control" required="required">
                        <label>Request Number :
                            <span class="required" aria-required="true"></span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Position :
                            <span class="required" aria-required="true"></span>
                        </label>
                        <a class="btn btn-primary btn-xs" data-toggle="modal" href='#pos_name'><i class="fa fa-plus"></i></a>
                        <div class="btn btn-success btn-xs" id="re_fresh_position">
                        <i class="fa fa-refresh"></i>
                        </div>
                        <select class="form-control myselect2" name="cbo_pos" required="">
                            <option value="">=== Please Choose and Select ===</option>
                            <?php
                            $v_select = $connect->query("SELECT * FROM tbl_acc_position ORDER BY po_id ASC");
                            while ($row_data = mysqli_fetch_object($v_select)) {
                                if ($row_old->req_position == $row_data->po_id)
                                    echo '<option SELECTED value="' . $row_data->po_id . '">' . $row_data->po_name . '</option>';
                                else
                                    echo '<option value="' . $row_data->po_id . '">' . $row_data->po_name . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 pull-right">
                    <div class="form-group">
                        <label>Date Record :
                            <span class="required" aria-required="true">*</span>
                        </label>
                        <input type="text" data-provide="datepicker" value="<?= $row_old->req_date ?>" data-date-format="yyyy-mm-dd" name="txt_date" class="form-control" required="">
                        <br>
                        <div class="form-group">
                            <label>Department :</label>
                            <button type="button" name="add_dep" class="btn btn-info btn-xs"><i class="fa fa-plus"></i></button>
                            <div class="btn btn-success btn-xs" id="re_fresh_dep">
                        <i class="fa fa-refresh"></i>
                        </div>
                            <select name="cbo_dep" id="inputCbo_dep" class="form-control myselect2" required="required">
                                <option value="">=== Select and choose ===</option>
                                <?php
                                $v_select = $connect->query("SELECT * FROM tbl_acc_department_list ORDER BY dep_name ASC");
                                while ($row_select = mysqli_fetch_object($v_select)) {
                                    if ($row_old->dep_id == $row_select->dep_id)
                                        echo '<option selected value="' . $row_select->dep_id . '">' . $row_select->dep_name . '</option>';
                                    else
                                        echo '<option value="' . $row_select->dep_id . '">' . $row_select->dep_name . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Type of Request :</label>
                        <button type="button" name="add_type" class="btn btn-info btn-xs"><i class="fa fa-plus"></i></button>
                         <div class="btn btn-success btn-xs" id="re_fresh_type">
                        <i class="fa fa-refresh"></i></div>
                        <select name="cbo_type_of_req" id="inputCbo_dep" class="form-control myselect2" required="required">
                            <option value="">=== Select and choose ===</option>
                            <?php
                            $v_select = $connect->query("SELECT * FROM tbl_acc_type_request_list ORDER BY typr_name ASC");
                            while ($row_select = mysqli_fetch_object($v_select)) {
                                if ($row_old->type_req_id == $row_select->typr_id)
                                    echo '<option selected value="' . $row_select->typr_id . '">' . $row_select->typr_name . '</option>';
                                else
                                    echo '<option value="' . $row_select->typr_id . '">' . $row_select->typr_name . '</option>';
                            }
                            ?>
                        </select>
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
                                    <th>
                                        <label>Item Name KH :
                                            <span class="required" aria-required="true"></span>
                                        </label>
                                    </th>
                                    <th>
                                        <label>Item Name VN :
                                            <span class="required" aria-required="true"></span>
                                        </label>
                                    </th>
                                    <th>
                                <label>សំរាប់-Dành cho
                                   
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                                    
                                    <th>
                                        <label>Size 
                                            <span class="required" aria-required="true"></span>
                                        </label>
                                    </th>
                                    <th style="width: 100px;">
                                        <label>Qty 
                                            <span class="required" aria-required="true"></span>
                                        </label>
                                    </th>
                                    <th>
                                        <label>Unit :
                                            <a class="btn btn-primary btn-xs" data-toggle="modal" href='#modal_unit_name'><i class="fa fa-plus"></i></a>
                                             <div class="btn btn-success btn-xs" id="re_unit_name"><i class="fa fa-refresh"></i></div>
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                    </th>
                                    <th>
                                        <label>Price 
                                            <span class="required" aria-required="true"></span>
                                        </label>
                                    </th>
                                    <th>
                                        <label>Amount 
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
                                        <input type="text" class="form-control" name="txt_item_name[]">
                                    </td>
                                    <td>
                                        <input type="text"" class=" form-control" name="txt_item_type[]">
                                    </td>
                                     <td>
                                
                                <textarea name="cbo_track[]" class="form-control" rows="1"> 

                                </textarea>
                            </td>
                            
                                   
                                    <td>
                                        <input type="text"" class=" form-control" name="txt_size[]">
                                    </td>
                                    <td>
                                        <input type="number" step="1" onkeyup="get_qty(this)" class="form-control" autocomplete="off" name="txt_qty[]" value="0">
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
                                        <input type="number" step="0.01" onkeyup="get_price(this)" class="form-control" autocomplete="off" name="txt_price[]" value="0">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="0" autocomplete="off" readonly="" name="txt_amount[]">
                                    </td>
                                    <td class="text-center">
                                        <button class="btnDelete" my_id="1">Delete</button>
                                    </td>
                                </tr>
                                <?php
                                $sql_sub = $connect->query("SELECT * FROM tbl_acc_request_item WHERE rei_number='$id'");

                                while ($row_sub = mysqli_fetch_object($sql_sub)) {
                                    ?>
                                    <tr>
                                        <td>
                                            <input type="hidden" name="txt_sub_id[]" value="<?= $row_sub->rei_id ?>">
                                            <input type="text" class="form-control" name="txt_item_name[]" value="<?= $row_sub->rei_item_name ?>">
                                        </td>
                                        <td>
                                            <input type="text" class=" form-control" name="txt_item_type[]" value="<?= $row_sub->rei_type ?>">
                                        </td>
                                        <td>
                                            <textarea  name="cbo_track[]" class="form-control" rows="1"><?php echo $row_sub->for_area;  ?></textarea>
                                        </td>
                            
                                       
                                        <td>
                                            <input type="text" class=" form-control" name="txt_size[]" value="<?= $row_sub->rei_size ?>">
                                        </td>
                                        <td>
                                            <input type="number" step="1" onkeyup="get_qty(this)" onchange="get_qty(this)" class="form-control" autocomplete="off" name="txt_qty[]" value="<?= $row_sub->rei_qty ?>">
                                        </td>
                                         <td>
                                            <select class="form-control myselect2" id="unit_name" name="cbo_unit[]">
                                                <option value="">==Please Choose and Select==</option>
                                                <?php
                                                    $v_select = $connect->query("SELECT * FROM tbl_acc_unit_list ORDER BY uni_id ASC");
                                                    while ($row_data = mysqli_fetch_object($v_select)) {
                                                        if ($row_sub->rei_unit == $row_data->uni_id)
                                                            echo '<option SELECTED value="' . $row_data->uni_id . '">' . $row_data->uni_name . '</option>';
                                                        else
                                                            echo '<option value="' . $row_data->uni_id . '">' . $row_data->uni_name . '</option>';
                                                    }
                                                    ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" step="0.01" onkeyup="get_price(this)" onchange="get_price(this)" class="form-control" autocomplete="off" name="txt_price[]" value="<?= $row_sub->rei_price ?>">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" autocomplete="off" readonly="" name="txt_amount[]" value="<?= number_format($row_sub->rei_qty * $row_sub->rei_price, 2) ?>">
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
                                <th class="text-right" colspan="7">Total Amount :</th>
                                <th>1.00</th>
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
        v = $('.my_form_base').find('td>input').val();
    });

    $("tbody").on('click', '.btnDelete', function() {
        var rowCount = $('tbody>tr').length;
        if (rowCount < 3) {
            alert("You can not delete this record.");
            return;
        }
        var var_id = $(this).parents('tbody >tr').find('td:nth-child(1) >input').val();
        if (var_id != 1) {
            $.ajax({
                url: "delete_sub_item.php?del_id=" + var_id,
                success: function(result) {
                    // alert(result);
                }
            });
        }
        $(this).parents('tr').remove();
    });

    function get_price(obj) {
        var price = $(obj).val();
        var qty = $(obj).parents('tr').find('td:nth-last-child(5) > input').val();
        var amo = price * qty;
        $(obj).parents('tr').find('td:nth-last-child(2) > input').val(amo.toFixed(2));
        cal_total_amount();
    }

    function get_qty(obj) {
        var qty = $(obj).val();
        var price = $(obj).parents('tr').find('td:nth-last-child(3) > input').val();
        var amo = price * qty;
        $(obj).parents('tr').find('td:nth-last-child(2) > input').val(amo.toFixed(2));
        cal_total_amount();
    }
    cal_total_amount();

    function cal_total_amount() {
        var v_total_amount = -1;
        $('tbody >tr').find('td:nth-last-child(2)').each(function() {
            v_total_amount += parseFloat($(this).find('input').val());
        });
       var v_total_amount_s=v_total_amount+1
        $('tfoot >tr').find('th:last-child').html(v_total_amount_s.toFixed(2));
    }


    $('select[name=cbo_re_name]').parents('div.form-group').click(function() {
       // alert();
        $.ajax({
            url: "ajx_get_content_select.php?d=cbo_re_name",
            success: function(result) {
                if ($('select[name=cbo_re_name]').html().trim() != result.trim()) {
                    $('select[name=cbo_re_name]').html(result);
                    $('.selectpicker').selectpicker('refresh');
                }
            }
        });
    });

    $('#re_fresh_name').click(function () {
        $.ajax({url: 'ajx_get_content_select.php?d=cbo_re_name',success:function (result) {
            if($('select[name="cbo_re_name[]"]').html().trim()!=result.trim())
                $('select[name="cbo_re_name[]"]').html(result);
        }});
        myAlertInfo("Refresh Request Name");
    });


    $('select[name=cbo_pos]').parents('div.form-group').click(function() {
        $.ajax({
            url: "ajx_get_content_select.php?d=cbo_pos",
            success: function(result) {
                if ($('select[name=cbo_pos]').html().trim() != result.trim()) {
                    $('select[name=cbo_pos]').html(result);
                    $('.selectpicker').selectpicker('refresh');
                }
            }
        });
    });

    $('#re_fresh_position').click(function () {
        $.ajax({url: 'ajx_get_content_select.php?d=cbo_pos',success:function (result) {
            if($('select[name="cbo_pos[]"]').html().trim()!=result.trim())
                $('select[name="cbo_pos[]"]').html(result);
        }});
        myAlertInfo("Refresh Position Name");
    });

      $('select[name=cbo_dep]').parents('div.form-group').click(function() {
        $.ajax({
            url: "ajx_get_content_select.php?d=cbo_dep",
            success: function(result) {
                if ($('select[name=cbo_dep]').html().trim() != result.trim()) {
                    $('select[name=cbo_dep]').html(result);
                    $('.selectpicker').selectpicker('refresh');
                }
            }
        });
    });

    $('#re_fresh_dep').click(function () {
        $.ajax({url: 'ajx_get_content_select.php?d=cbo_dep',success:function (result) {
            if($('select[name="cbo_dep[]"]').html().trim()!=result.trim())
                $('select[name="cbo_dep[]"]').html(result);
        }});
        myAlertInfo("Refresh Department Name");
    });


     $('select[name=cbo_type_of_req]').parents('div.form-group').click(function() {
        $.ajax({
            url: "ajx_get_content_select.php?d=cbo_type_of_req",
            success: function(result) {
                if ($('select[name=cbo_type_of_req]').html().trim() != result.trim()) {
                    $('select[name=cbo_type_of_req]').html(result);
                    $('.selectpicker').selectpicker('refresh');
                }
            }
        });
    });

      $('#re_fresh_type').click(function () {
        $.ajax({url: 'ajx_get_content_select.php?d=cbo_type_of_req',success:function (result) {
            if($('select[name="cbo_type_of_req[]"]').html().trim()!=result.trim())
                $('select[name="cbo_type_of_req[]"]').html(result);
        }});
        myAlertInfo("Refresh Type of Request");
    });


    $('select[name=cbo_check_by]').parents('div.form-group').click(function() {
        $.ajax({
            url: "ajx_get_content_select.php?d=cbo_check_by",
            success: function(result) {
                if ($('select[name=cbo_check_by]').html().trim() != result.trim()) {
                    $('select[name=cbo_check_by]').html(result);
                    $('.selectpicker').selectpicker('refresh');
                }
            }
        });
    });

      $('#re_fresh_check_by').click(function () {
        $.ajax({url: 'ajx_get_content_select.php?d=cbo_check_by',success:function (result) {
            if($('select[name="cbo_check_by[]"]').html().trim()!=result.trim())
                $('select[name="cbo_check_by[]"]').html(result);
        }});
        myAlertInfo("Refresh Check By Name");
    });

    $('select[name=cbo_appro_by]').parents('div.form-group').click(function() {
        $.ajax({
            url: "ajx_get_content_select.php?d=cbo_appro_by",
            success: function(result) {
                if ($('select[name=cbo_appro_by]').html().trim() != result.trim()) {
                    $('select[name=cbo_appro_by]').html(result);
                    $('.selectpicker').selectpicker('refresh');
                }
            }
        });
    });

     $('#re_fresh_app_by').click(function () {
        $.ajax({url: 'ajx_get_content_select.php?d=cbo_appro_by',success:function (result) {
            if($('select[name="cbo_appro_by[]"]').html().trim()!=result.trim())
                $('select[name="cbo_appro_by[]"]').html(result);
        }});
        myAlertInfo("Refresh Approved By Name");
    });

    $('select[name=cbo_pre_by]').parents('div.form-group').click(function() {
        $.ajax({
            url: "ajx_get_content_select.php?d=cbo_pre_by",
            success: function(result) {
                if ($('select[name=cbo_pre_by]').html().trim() != result.trim()) {
                    $('select[name=cbo_pre_by]').html(result);
                    $('.selectpicker').selectpicker('refresh');
                }
            }
        });
    });

      $('#re_fresh_pre_by').click(function () {
        $.ajax({url: 'ajx_get_content_select.php?d=cbo_pre_by',success:function (result) {
            if($('select[name="cbo_pre_by[]"]').html().trim()!=result.trim())
                $('select[name="cbo_pre_by[]"]').html(result);
        }});
        myAlertInfo("Refresh Prepare By Name");
    });

       $('#re_unit_name').click(function () {
        $.ajax({url: 'ajx_get_content_select.php?d=cbo_unit',success:function (result) {
            if($('select[name="cbo_unit[]"]').html().trim()!=result.trim())
                $('select[name="cbo_unit[]"]').html(result);
        }});
        myAlertInfo("Refresh Unit Name");
    });


     $('#re_track_name').click(function () {
        $.ajax({url: 'ajx_get_content_select.php?d=cbo_track',success:function (result) {
            if($('select[name="cbo_track[]"]').html().trim()!=result.trim())
                $('select[name="cbo_track[]"]').html(result);
        }});
        myAlertInfo("Refresh Truck Name");
    });

     function view_iframe_track_name(){
        document.getElementById('result_modal').src = '../st_track_machince_list/add.php?view=iframe';
    }


    $('button[name=add_dep]').click(function() {
        $('div#add_dep').modal('show');
    });
    $('button[name=add_type]').click(function() {
        $('div#add_type_of_req').modal('show');
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