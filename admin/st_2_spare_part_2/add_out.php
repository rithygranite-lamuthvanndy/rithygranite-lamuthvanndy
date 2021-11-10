<?php
$menu_active = 140;
$left_active = 0;
$layout_title = "Create Stock Out";
include_once '../../config/database.php';
include_once '../../config/athonication.php';
include_once '../layout/header.php';
?>
<?php
if (@$_SESSION['save_call_back']) {
    $sms = '<div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Success !</strong> Creating record
            </div>';
    $_SESSION['save_call_back'] = null;
}
?>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
        </div>
    </div>
    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-truck fa-flip-horizontal"></i> Create Stock Out (Spare Part)</h3>
            </div>
            <div class="panel-body">
                <form action="controller_save.php" method="post" enctype="multipart/form-data">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                <div class="form-group">
                                    <label>Date Stock Out *:
                                    </label>
                                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                        <input type="text" class="form-control" value="<?= date('Y-m-d') ?>" name="txt_date_record" placeholder="Choose Date" required="" aufocomplete="off">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                <div class="form-group">
                                    <label>Letter Number *: </label>
                                    <input type="text" class="form-control" name="txt_letter_no" required="" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                <div class="form-group">
                                    <label>Manager *: </label>
                                    <select type="text" class="form-control myselect2" name="cbo_manager" required="" autocomplete="off">
                                        <option value="">=== Select and choose===</option>
                                        <?php
                                        $get_select = $connect->query("SELECT * FROM tbl_st_manager_list ORDER BY stman_name ASC");
                                        while ($row_data = mysqli_fetch_object($get_select)) {
                                            echo '<option value="' . $row_data->stman_id . '">' . $row_data->stman_name . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Note : </label>
                                    <textarea type="text" class="form-control" name="txt_note" rows="1" autocomplete="off"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Detail -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <table id="myTable" class="table table-bordered myFormDetail_ns" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 20%; white-space: nowrap;">Project</th>
                                            <th class="text-center" style="width: 25%; white-space: nowrap;">Product Code</th>
                                            <th class="text-center" style="width: 30%;">Product Name
                                                <a class="btn btn-primary btn-xs" data-toggle="modal" href='#modal' onclick="view_iframe_product_name();"><i class="fa fa-plus"></i></a>
                                                <div class="btn btn-success btn-xs" id="re_pro_name"><i class="fa fa-refresh"></i></div>
                                            </th>
                                            <th class="text-center" style="width: 7%; white-space: nowrap;">Location</th>
                                            <th class="text-center" style="width: 7%; white-space: nowrap;">QUANTITY</th>
                                            <th class="text-center" style="width: 15%; white-space: nowrap;">UNIT</th>
                                            <th class="text-center" style="width: 15%;white-space: nowrap;">ម៉ាស៊ីន/គ្រឿងចក្រ</th>
                                            <th class="text-center" style="width: 3%;white-space: nowrap;"> <i class="fa fa-cog fa-spin"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="my_form_base" style="background: red; display: none;">
                                            <td>
                                                <select class="form-control" name="cbo_project[]">
                                                    <option value="">** Select **</option>
                                                    <?php
                                                    // $v_select = $connect->query("SELECT stpron_id,stpron_code,stpron_name_vn,stpron_name_kh FROM tbl_st_product_name ORDER BY stpron_code DESC");
                                                    // while ($row_data = mysqli_fetch_object($v_select)) {
                                                    //     echo '<option value="'.$row_data->stpron_id.'" data_pro_code='.$row_data->stpron_code.'>['.$row_data->stpron_code.'] '.$row_data->stpron_name_vn.' == '.$row_data->stpron_name_kh.'</option>';
                                                    // }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="txt_pro_code[]" id="inputTxt_acc_no" class="form-control" readonly="">
                                            </td>
                                            <td>
                                                <select class="form-control" name="cbo_pro_code[]">
                                                    <option value="">=== Please Choose and Select ===</option>
                                                    <?php
                                                    $v_select = $connect->query("SELECT stpron_id,stpron_code,stpron_name_vn,stpron_name_kh 
                                                            FROM tbl_st_product_name 
                                                            WHERE stpron_material_type='$_SESSION[status]'
                                                            ORDER BY stpron_code DESC");
                                                    while ($row_data = mysqli_fetch_object($v_select)) {
                                                        echo '<option value="' . $row_data->stpron_id . '" data_pro_code=' . $row_data->stpron_code . '>[' . $row_data->stpron_code . '] ' . $row_data->stpron_name_vn . ' == ' . $row_data->stpron_name_kh . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="cbo_location[]" id="input" class="form-control">
                                                    <option value="">-- Select One --</option>
                                                    <option value="0">រោងចក្រ</option>
                                                    <option value="1">រណ្ដៅ</option>
                                                    <option value="2">រោងជាង</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" step="1" name="txt_qty[]" class="form-control" value="0">
                                            </td>
                                            <td>
                                                <select class="form-control" name="cbo_unit[]">
                                                    <option value="">= Select =</option>
                                                    <?php
                                                    $v_select = $connect->query("SELECT * FROM tbl_st_unit_list ORDER BY stun_name DESC");
                                                    while ($row_data = mysqli_fetch_object($v_select)) {
                                                        echo '<option value="' . $row_data->stun_id . '" >' . $row_data->stun_name . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" name="cbo_track_machine[]">
                                                    <option value="">= Select =</option>
                                                    <?php
                                                    $v_select = $connect->query("SELECT * FROM tbl_st_track_machine_list ORDER BY name_vn DESC");
                                                    while ($row_data = mysqli_fetch_object($v_select)) {
                                                        echo '<option value="' . $row_data->id . '" >' . $row_data->name_vn . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <div class="btnDelete btn btn-danger btn-xs"><i class="fa fa-trash"></i></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 text-center">
                                    <label>&nbsp;</label>
                                    <br>
                                    <div id="add_more" class="btn btn-default yellow btn-md"><i class="fa fa-plus-circle"></i> Add More</div>
                                    <button type="submit" name="btn_save_out" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
                                    <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>
<?php include_once '../layout/footer.php' ?>
<script type="text/javascript">
    //Press Button Add More
    var index_row = 1;
    $('#add_more').click(function() {
        $('#myTable').append('<tr data-row-id="' + (++index_row) + '">' + $('.my_form_base').html() + '</tr>');
        $('tr[data-row-id=' + index_row + ']').find('select').select2();
    });
    setTimeout(function() {
        $('#add_more').click();
    }, 1000);
    //Delete Row By Row
    $("tbody").on('click', 'div.btnDelete', function() {
        var rowCount = $('tbody >tr').length;
        if (rowCount <= 2) {
            alert("You can not delete this record.");
            return;
        }
        $(this).parents('tr').remove();
    });

    $('#re_pro_name').click(function() {
        $.ajax({
            url: 'ajx_get_content_select.php?status=re_pro_name',
            success: function(result) {
                if ($('select[name="cbo_pro_code[]"]').html().trim() != result.trim())
                    $('select[name="cbo_pro_code[]"]').html(result);
            }
        });
        myAlertInfo("Refresh Product Name");
    });
    $("tbody").on('change', 'tr td:nth-child(3) select', function() {
        v_pro_code = $(this).find('option:selected').attr('data_pro_code');
        $(this).parents('tr').find('td:nth-child(2) input').val(v_pro_code);
    });

    function view_iframe_product_name() {
        document.getElementById('result_modal').src = '../st_product_name/index.php?view=iframe';
    }
</script>
<div class="modal fade" id="modal">
    <div class="modal-dialog" style="border: 1px solid darkred; width: 70%;">
        <iframe id="result_modal" frameborder="0" style="height: 600px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>