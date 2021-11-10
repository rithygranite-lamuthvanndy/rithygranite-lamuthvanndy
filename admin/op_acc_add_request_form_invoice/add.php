<?php
$menu_active = 13;
$left_active = 33;
$layout_title = "Add Page";
include_once '../../config/database.php';
include_once '../../config/athonication.php';
include_once '../layout/header.php';
?>


<?php
if (isset($_POST['btn_submit'])) {
    $v_date = @$_POST['txt_date'];
    $v_number = @$_POST['txt_number'];
    $v_re_name = @$_POST['cbo_re_name'];
    $v_pos = @$_POST['cbo_pos'];
    $v_pre_by = @$_POST['cbo_pre_by'];
    $v_check_by = @$_POST['cbo_check_by'];
    $v_appro_by = @$_POST['cbo_appro_by'];
    $v_dep = @$_POST['cbo_dep'];
    $v_type_of_req = @$_POST['cbo_type_of_req'];

    $query_add_1 = "INSERT INTO tbl_acc_request_form (
                req_date,
                req_number,
                dep_id,
                type_req_id,
                req_request_name,
                req_position,
                req_prepare_by,
                req_check_by,
                req_approved_by
                ) 
            VALUES
                (
                '$v_date',
                '$v_number',
                '$v_dep',
                '$v_type_of_req',
                '$v_re_name',
                '$v_pos',
                '$v_pre_by',
                '$v_check_by',
                '$v_appro_by'
                )";
    if ($connect->query($query_add_1)) {
        $flag_1 = 1;
        $v_id = $connect->insert_id;
    } else {
        echo 'Error';
        die();
    }

    $v_unit = @$_POST['cbo_unit'];
    $v_item_name = @$_POST['txt_item_name'];
    $v_qty = @$_POST['txt_qty'];
    $v_price = @$_POST['txt_price'];
    $v_item_type = @$_POST['txt_item_type'];
    $v_size = @$_POST['txt_size'];
    $v_track=@$_POST['cbo_track'];

    foreach ($v_item_name as $key => $value) {
        if ($value) {
            $new_item = $v_item_name[$key];
            $new_unit = $v_unit[$key];
            $new_qty = $v_qty[$key];
            $new_price = $v_price[$key];
            $new_item_type = $v_item_type[$key];
            $new_size = $v_size[$key];
            $new_track=$v_track[$key];
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
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="border: 1px #C5BCBC solid;">
                <br>
                <div class="form-group">
                    <label>
                        Request Name :
                        <span class="required" aria-required="true"></span>
                    </label>
                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#request_name'><i class="fa fa-plus"></i></a>
                    <div class="btn btn-success btn-xs re_fresh_name"><i class="fa fa-refresh"></i></div>
                    <select class="form-control myselect2" name="cbo_re_name" required="">
                        <option value="">=== Please Choose and Select ===</option>
                        <?php
                        $v_select = $connect->query("SELECT * FROM tbl_acc_request_name_list ORDER BY res_id ASC");
                        while ($row_data = mysqli_fetch_object($v_select)) {
                            echo '<option value="' . $row_data->res_id . '">' . $row_data->res_name . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group form-md-line-input">
                    <input type="text" name="txt_number" id="input" class="form-control" required="required">
                    <label>Request Number :
                        <span class="required" aria-required="true"></span>
                    </label>
                </div>
                <div class="form-group">
                    <label>Position :
                        <span class="required" aria-required="true"></span>
                    </label>
                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#pos_name'><i class="fa fa-plus"></i></a>
                    <div class="btn btn-success btn-xs re_fresh_name">
                    <i class="fa fa-refresh"></i>
                    </div>

                    <select class="form-control myselect2" name="cbo_pos" required="">
                        <option value="">=== Please Choose and Select ===</option>
                        <?php
                        $v_select = $connect->query("SELECT * FROM tbl_acc_position ORDER BY po_id ASC");
                        while ($row_data = mysqli_fetch_object($v_select)) {
                            echo '<option value="' . $row_data->po_id . '">' . $row_data->po_name . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 pull-right">
                <div class="form-group">
                    <label>Date Record :</label>
                    <input type="text" data-provide="datepicker" value="<?= date("Y-m-d") ?>" data-date-format="yyyy-mm-dd" name="txt_date" class="form-control" required="">

                </div>
                <div class="form-group">
                    <label>Department :</label>
                    <button type="button" name="add_dep" class="btn btn-info btn-xs"><i class="fa fa-plus"></i></button>
                    <div class="btn btn-success btn-xs re_fresh_name">
<i class="fa fa-refresh"></i>
</div>

                    <select name="cbo_dep" id="inputCbo_dep" class="form-control myselect2" required="required">
                        <option value="">=== Select and choose ===</option>
                        <?php
                        $v_select = $connect->query("SELECT * FROM tbl_acc_department_list ORDER BY dep_name ASC");
                        while ($row_select = mysqli_fetch_object($v_select)) {
                            echo '<option value="' . $row_select->dep_id . '">' . $row_select->dep_name . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Type of Request :</label>
                    <button type="button" name="add_type" class="btn btn-info btn-xs"><i class="fa fa-plus"></i></button>
                    <div class="btn btn-success btn-xs re_fresh_name">
                    <i class="fa fa-refresh"></i>
                    </div>

                    <select name="cbo_type_of_req" id="inputCbo_dep" class="form-control myselect2" required="required">
                        <option value="">=== Select and choose ===</option>
                        <?php
                        $v_select = $connect->query("SELECT * FROM tbl_acc_type_request_list ORDER BY typr_name ASC");
                        while ($row_select = mysqli_fetch_object($v_select)) {
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
                <table id="myTable" class="table table-bordered myFormDetail_ns">
                    <thead>
                        <tr>
                            <th>
                                <label>Item Name KH
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th>
                                <label>Item Name VN
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th>
                                <label>សំរាប់-Dành cho
                                   <!--  <a class="btn btn-primary btn-xs" data-toggle="modal" href='#modal' onclick="view_iframe_track_name();"><i class="fa fa-plus"></i></a>

                                    <div class="btn btn-success btn-xs" id="re_track_name"><i class="fa fa-refresh"></i></div> -->
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
                                <label>Unit
                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#modal_unit_name'>
                                        <i class="fa fa-plus"></i>
                                    </a>
                                    <div class="btn btn-success btn-xs" id="re_pro_name"><i class="fa fa-refresh"></i></div>

                                    <span class="required" aria-required="true">*</span>
                                </label>
                            </th>
                            <th>
                                <label>Price
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th style="width: 200px;">
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
                                <input type="text" class=" form-control" name="txt_item_name[]">
                            </td>
                            <td>
                                <input type="text" class=" form-control" name="txt_item_type[]">
                            </td>

                            <td>

                                <!-- <select class="form-control"  name="cbo_track[]">
                                    <option value="">==Please Select==</option> -->
                                   <!--  <?php
                                    //$v_select_track = $connect->query("SELECT * FROM tbl_st_track_machine_list ORDER BY id ASC");
                                    //while ($row_track = mysqli_fetch_object($v_select_track)) {
                                        // echo '<option value="' . $row_track->id . '">
                                        // '.$row_track->name_vn.'
                                        // </option>';
                                  //  }
                                    ?> -->
                                <!-- </select> -->
                                <textarea  name="cbo_track[]" class="form-control" rows="1">
                                    
                                </textarea>
                            </td>
                            
                            
                            <td>
                                <input type="text"" class=" form-control" name="txt_size[]">
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

                <div class="row" style="padding: 0 15px;">
                    <div class="col-xs-4 border text-center" style=" border: 1px #C5BCBC solid;">
                        <h5>
                            Approved By
                            <a class="btn btn-primary btn-xs" data-toggle="modal" href='#app_by'><i class="fa fa-plus"></i></a>
                            <div class="btn btn-success btn-xs re_fresh_name">
<i class="fa fa-refresh"></i>
</div>

                        </h5>
                        <br>
                        <br>
                        <br>
                        <h5><strong>
                                <div class="form-group form-md-line-input">
                                    <select class="form-control myselect2" name="cbo_appro_by" autocomplete="off" required="">
                                        <option value="">=== Please Cilck and Choose ===</option>
                                        <?php
                                        $v_select = $connect->query("SELECT * FROM tbl_acc_approved_name_list ORDER BY apn_name ASC");
                                        while ($row_data = mysqli_fetch_object($v_select)) {
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
                            <div class="btn btn-success btn-xs re_fresh_name">
                            <i class="fa fa-refresh"></i>
                            </div>

                        </h5>
                        <br>
                        <br>
                        <br>
                        <h5><strong>
                                <div class="form-group form-md-line-input">
                                    <select class="form-control myselect2" name="cbo_check_by" autocomplete="off" required="">
                                        <option value="">=== Please Cilck and Choose ===</option>
                                        <?php
                                        $v_select = $connect->query("SELECT * FROM tbl_acc_check_name_list ORDER BY chn_name ASC");
                                        while ($row_data = mysqli_fetch_object($v_select)) {
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
                            <div class="btn btn-success btn-xs re_fresh_name">
                            <i class="fa fa-refresh"></i>
                            </div>

                        </h5>
                        <br>
                        <br>
                        <br>
                        <h5><strong>
                                <div class="form-group form-md-line-input">
                                    <select class="form-control myselect2" name="cbo_pre_by" autocomplete="off" required="">
                                        <option value="">=== Please Cilck and Choose ===</option>
                                        <?php
                                        $v_select = $connect->query("SELECT * FROM tbl_acc_prepare_name_list ORDER BY pren_id ASC");
                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                            echo '<option value="' . $row_data->pren_id . '">' . $row_data->pren_name . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </strong></h5>
                    </div>
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
        var qty = $(obj).parents('tr').find('td:nth-last-child(5) > input').val();
        var amo = price * qty;
        $(obj).parents('tr').find('td:nth-last-child(2) > input').val(amo.toFixed(2));
        cal_total_amount();
    }
    cal_total_amount();

    function cal_total_amount() {
        var v_total_amount =0;
        $('tbody >tr').find('td:nth-last-child(2)').each(function() {
            v_total_amount += parseFloat($(this).find('input').val());
        });
        $('tfoot >tr').find('th:last-child').html(v_total_amount.toFixed(2));
    }

    function get_qty(obj) {
        var qty = $(obj).val();
        var price = $(obj).parents('tr').find('td:nth-last-child(3) > input').val();
        var amo = price * qty;
        $(obj).parents('tr').find('td:nth-last-child(2) > input').val(amo.toFixed(2));
        cal_total_amount();
    }
</script>
<script type="text/javascript">
    $('select[name=cbo_re_name]').parents('div.form-group').hover(function() {
        $.ajax({
            url: "ajx_get_content_select.php?d=cbo_re_name",
            success: function(result) {
                if ($('select[name=cbo_re_name]').html().trim() != result.trim()) {
                    $('select[name=cbo_re_name]').html(result);
                }
            }
        });
    });
    $('select[name=cbo_pos]').parents('div.form-group').hover(function() {
        $.ajax({
            url: "ajx_get_content_select.php?d=cbo_pos",
            success: function(result) {
                if ($('select[name=cbo_pos]').html().trim() != result.trim()) {
                    $('select[name=cbo_pos]').html(result);
                }
            }
        });
    });
    $('select#id_item_name').parents('div.form-group').change(function() {
        $.ajax({
            url: "ajx_get_content_select.php?d=p_item_name",
            success: function(result) {
                if ($('select#id_item_name').html().trim() != result.trim()) {
                    $('select#id_item_name').html(result);
                }
            }
        });
    });
    $('select#unit_name').parents('div.form-group').mouseover(function() {
        $.ajax({
            url: "ajx_get_content_select.php?d=unit_name",
            success: function(result) {
                if ($('select#unit_name').html().trim() != result.trim()) {
                    $('select#unit_name').html(result);
                }
            }
        });
    });
    $('select[name=cbo_check_by]').parents('div.form-group').hover(function() {
        $.ajax({
            url: "ajx_get_content_select.php?d=cbo_check_by",
            success: function(result) {
                if ($('select[name=cbo_check_by]').html().trim() != result.trim()) {
                    $('select[name=cbo_check_by]').html(result);
                }
            }
        });
    });
    $('select[name=cbo_appro_by]').parents('div.form-group').hover(function() {
        $.ajax({
            url: "ajx_get_content_select.php?d=cbo_appro_by",
            success: function(result) {
                if ($('select[name=cbo_appro_by]').html().trim() != result.trim()) {
                    $('select[name=cbo_appro_by]').html(result);
                }
            }
        });
    });
    $('select[name=cbo_pre_by]').parents('div.form-group').hover(function() {
        $.ajax({
            url: "ajx_get_content_select.php?d=cbo_pre_by",
            success: function(result) {
                if ($('select[name=cbo_pre_by]').html().trim() != result.trim()) {
                    $('select[name=cbo_pre_by]').html(result);
                }
            }
        });
    });
    $('select[name=cbo_dep]').parents('div.form-group').hover(function() {
        $.ajax({
            url: "ajx_get_content_select.php?d=cbo_dep",
            success: function(result) {
                if ($('select[name=cbo_dep]').html().trim() != result.trim()) {
                    $('select[name=cbo_dep]').html(result);
                }
            }
        });
    });
    $('select[name=cbo_type_of_req]').parents('div.form-group').hover(function() {
        $.ajax({
            url: "ajx_get_content_select.php?d=cbo_type_of_req",
            success: function(result) {
                if ($('select[name=cbo_type_of_req]').html().trim() != result.trim()) {
                    $('select[name=cbo_type_of_req]').html(result);
                }
            }
        });
    });

   
    $('#re_pro_name').click(function () {
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



    $('button[name=add_dep]').click(function() {
        $('div#add_dep').modal('show');
    });
    $('button[name=add_type]').click(function() {
        $('div#add_type_of_req').modal('show');
    });

    $('.re_fresh_name').click(function () {
       
        myAlertInfo("Refreshed");
    });

    
 function view_iframe_track_name(){
        document.getElementById('result_modal').src = '../st_track_machince_list/add.php?view=iframe';
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