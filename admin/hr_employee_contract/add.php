<?php
$menu_active = 33;
$left_active =0;
$layout_title = "Add Page";
include_once '../../config/database.php';
include_once '../../config/athonication.php';
include_once '../layout/header.php';
?>


<?php
if (isset($_POST['btn_submit'])) {
                
                $v_empw_date = @$_POST['txt_date'];
                $v_empw_id_emp = @$_POST['txt_id_emp'];
                $v_empw_depat = @$_POST['txt_depat'];
                $v_empw_price = @$_POST['txt_price'];
                $v_empw_note = @$_POST['txt_note'];

    $query_add_1 = "INSERT INTO tbl_hr_emp_working (
                empw_date,
                empw_id_emp,
                empw_depat,
                empw_price,
                empw_note
                ) 
            VALUES
                (
                '$v_empw_date',
                '$v_empw_id_emp',
                '$v_empw_depat',
                '$v_empw_price',
                '$v_empw_note'
                )";
    if ($connect->query($query_add_1)) {
        $flag_1 = 1;
        $v_id = $connect->insert_id;
    } else {
        echo 'Error';
        die();
    }
                        $v_emwo_date = @$_POST['txt_date1'];
                        $v_emwo_hour = @$_POST['txt_hour'];

    foreach ($v_emwo_hour as $key => $value) {
        if ($value) {
                        $new_emwo_date=$v_emwo_date[$key];
                        $new_emwo_hour=$v_emwo_hour[$key];
            $query_add = "INSERT INTO tbl_hr_emp_working_ot (
                        emwo_empw_id,
                        emwo_date,
                        emwo_hour
                        ) 
                    VALUES
                        (
                        '$v_id',
                        '$new_emwo_date',
                        '$new_emwo_hour'
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
    <div class="portlet-title">
        <div class="col-xs-6">
            <h2 style="font-family:'Khmer OS Muol';"><i class="fa fa-fw fa-map-marker"></i> បញ្ចូលទិន្នន័យជ័រកៅស៊ូ </h2>
        </div>
        <div class="col-xs-6 text-right">
            <h2><b>Total Salary: <p style="font-family: 'Times New Roman';" id="frpc_code"></p></b></h2>
        </div>
        <br>
        <div class="">
            <div class="caption font-dark">
                <a href="index.php" id="sample_editable_1_new" class="btn red">
                        <i class="fa fa-arrow-left"></i>
                        Back
                    </a>
            </div>
        </div>
        <br>

    </div>
    <form action="#" method="post" accept-charset="utf-8">
        <div class="row" style="padding: 0 15px;">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <div class="form-group">
                    <label>Date Record :</label>
                    <input type="text" data-provide="datepicker" value="<?= date("Y-m-d") ?>" data-date-format="yyyy-mm-dd" name="txt_date" class="form-control" required="">

                </div>
                <div class="form-group">
                    <label>លេខប័ណបុគ្គលិក និងកម្មករ: </label>
                    <select name="txt_id_emp" id="input" class="form-control myselect2" required="required">
                            <option value="">*** Select and choose ***</option>
                            <?php 
                               $v_result=$connect->query("SELECT * FROM tbl_hr_employee_list WHERE empl_position = 142 ORDER BY empl_id");
                               while ($row_select=mysqli_fetch_object($v_result)) {
                                    echo '<option value="'.$row_select->empl_id.'">'.$row_select->empl_card_id.' || '.$row_select->empl_emloyee_kh.' || '.$row_select->empl_emloyee_en.'</option>';
                                }
                            ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>ឈ្មោះបុគ្គលិក EN: </label>
                    <input type="text" class="form-control" name="txt_frpc_no" readonly="">
                </div>
                <div class="form-group">
                    <label>ឈ្មោះបុគ្គលិក KH: </label>
                    <input type="text" class="form-control" name="txt_frpc_no" readonly="">
                </div>                                    

                                    
            </div>

            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

                <div class="form-group">
                    <label>ក្រុមទី </label>
                    <select name="txt_depat" id="input" class="form-control myselect2" required="required">
                            <option value="">*** Select and choose ***</option>
                            <?php 
                               $v_result=$connect->query("SELECT * FROM tbl_hr_department_sub  WHERE dep_id not IN (65, 66, 67, 68, 69, 70, 71) ORDER BY dep_id");
                               while ($row_select=mysqli_fetch_object($v_result)) {
                                    echo '<option value="'.$row_select->dep_id.'">'.$row_select->dep_id.' || '.$row_select->dep_name.'</option>';
                                }
                            ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>តម្លៃប្រាក់ម៉ោង: </label>
                    <input type="text" class="form-control" name="txt_price" >
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
                                <label>ថ្ងៃខែឆ្នាំ
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th>
                                <label>ប្រភេទជ័រ
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th>
                                <label>ចំនួនគីឡូ
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th>
                                <label>តម្លៃ
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th>
                                <label>សរុបទឹកប្រាក់
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
                                <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" required name="txt_date1[]" value="<?= date('Y-m-d') ?>">
                            </td>
                            <td>
                                <select name="txt_id_emp" id="input" class="form-control myselect2" required="required">
                                        <option value="">*** Select and choose ***</option>
                                        <?php 
                                           $v_result=$connect->query("SELECT * FROM tbl_hr_item_rubber ORDER BY ir_id");
                                           while ($row_select=mysqli_fetch_object($v_result)) {
                                                echo '<option value="'.$row_select->ir_id.'">'.$row_select->ir_name.' || '.$row_select->ir_type.'</option>';
                                            }
                                        ?>
                                </select>
                            </td>
                            <td>
                                <input type="text" class=" form-control" onchange="get_qty(this)" name="txt_hour[]" step="0.01" value="" autocomplete="off">
                            </td>
                            <td>
                                <input type="text" class=" form-control" onkeyup="get_price(this)" name="txt_date_li[]" step="0.01" value="" autocomplete="off">
                            </td>
                            <td>
                                <input type="text" class=" form-control" name="txt_note1[]" autocomplete="off" readonly="" value="0">
                            </td>
                            <td class="text-center">
                                <button class="btnDelete">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <th class="text-right" colspan="4">Total Amount :</th>
                        <th>$ 0.00</th>
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
        var qty = $(obj).parents('tr').find('td:nth-last-child(4) > input').val();
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
        v_total_amount = Number(parseFloat(v_total_amount).toFixed(2)).toLocaleString('en', {
        minimumFractionDigits: 2
        });
        document.getElementById("frpc_code").innerHTML = v_total_amount+" ៛" ;
    }

    function get_qty(obj) {
        var qty = $(obj).val();
        var price = $(obj).parents('tr').find('td:nth-last-child(3) > input').val();
        var amo = price * qty;
        $(obj).parents('tr').find('td:nth-last-child(2) > input').val(amo.toFixed(2));
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