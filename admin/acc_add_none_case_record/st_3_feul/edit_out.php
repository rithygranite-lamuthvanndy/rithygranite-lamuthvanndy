<?php
$menu_active = 140;
$left_active = 0;
$layout_title = "Edit Stock Out";
include_once '../../config/database.php';
include_once '../../config/athonication.php';
include_once '../layout/header.php';
?>
<?php
if (@$_SESSION['save_call_back']) {
    $sms = '<div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Success !</strong> Updating record
            </div>';
    $_SESSION['save_call_back'] = null;
}

// get old data 
$edit_id = @$_GET['edit_id'];
$old_data = $connect->query("SELECT * FROM tbl_st_stock_out WHERE stsout_id='$edit_id'");
$row_old_data = mysqli_fetch_object($old_data);
// var_dump($row_old_data);
?>
<style type="text/css">
    #myTable>thead tr th {
        white-space: nowrap;
    }

    .myTableScroll {
        width: 100%;
        overflow-x: scroll;
    }
</style>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
        </div>
    </div>
    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-truck fa-flip-horizontal"></i>
                    Edit Stock <?= (($_SESSION['action'] == 2) ? 'In' : 'Out') ?> <?= $_SESSION['title'] ?>
                </h3>
            </div>
            <div class="panel-body">
                <form action="controller_update.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt_parent_id" value="<?= $row_old_data->stsout_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                <div class="form-group">
                                    <label>Date Stock Out *:
                                    </label>
                                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                        <input value="<?= $row_old_data->stsout_date_out ?>" type="text" class="form-control" value="<?= date('Y-m-d') ?>" name="txt_date_record" placeholder="Choose Date" required="" aufocomplete="off">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                <div class="form-group">
                                    <label>Letter Number *: </label>
                                    <input value="<?= $row_old_data->stsout_letter_no ?>" type="text" class="form-control" name="txt_letter_no" required="" autocomplete="off">
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
                                            echo '<option ' . ($row_old_data->stsout_man_id == $row_data->stman_id ? 'selected' : '') . ' value="' . $row_data->stman_id . '">' . $row_data->stman_name . '</option>';
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
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 myTableScroll">
                                <table id="myTable" class="table table-bordered myFormDetail_ns" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 20%; word-wrap: nowrap;">Project</th>
                                            <th class="text-center" style="width: 25%; word-wrap: nowrap;">Product Code</th>
                                            <th class="text-center" style="width: 30%;">Product Name
                                                <a class="btn btn-primary btn-xs" data-toggle="modal" href='#modal' onclick="view_iframe_product_name();"><i class="fa fa-plus"></i></a>
                                                <div class="btn btn-success btn-xs" id="re_pro_name"><i class="fa fa-refresh"></i></div>
                                            </th>
                                            <th class="text-center" style="width: 7%;">QUANTITY</th>
                                            <th class="text-center" style="width: 15%;">Product Type</th>
                                            <th class="text-center" style="width: 15%;">តំបន់</th>
                                            <th class="text-center" style="width: 15%;">UNIT</th>
                                            <th class="text-center" style="width: 15%;">ម៉ាស៊ីន/គ្រឿងចក្រ</th>
                                            <th class="text-center" style="width: 3%;"> <i class="fa fa-cog fa-spin"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $v_sql_child = "SELECT A.*,C.stpron_code
                                                        FROM tbl_st_stock_out_detail AS A 
                                                        LEFT JOIN tbl_st_stock_out  AS B ON A.stsout_id=B.stsout_id
                                                        LEFT JOIN tbl_st_product_name AS C ON A.pro_id=C.stpron_id
                                                        WHERE A.stsout_id='$edit_id'
                                                        ";
                                        $v_result_child = $connect->query($v_sql_child);
                                        $v_total_amo = 0;
                                        while ($row_child = mysqli_fetch_object($v_result_child)) {
                                            echo '<input type="hidden" value="' . $row_child->std_id . '" name="txt_status[]" id="inputTxt_acc_no" class="form-control">';
                                            echo '<tr>';
                                            echo '<td>
                                                        <select class="form-contro myselect2" name="cbo_project[]">
                                                            <option value="">** Select **</option>';
                                                            $v_select = $connect->query("SELECT * FROM tbl_pj_project_title ORDER BY pti_project_title DESC");
                                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                                echo '<option '.($row_child->project_id== $row_data->pti_id?'selected':'').' value="'.$row_data->pti_id.'">'.$row_data->pti_project_title.'</option>';
                                                            }
                                                        echo '</select>
                                                    </td>';
                                            echo  '<td>
                                                    <input type="text" value="' . $row_child->stpron_code . '" name="txt_pro_code[]" id="inputTxt_acc_no" class="form-control" readonly="">
                                                </td>
                                                <td>
                                                    <select class="form-control myselect2" name="cbo_pro_code[]">
                                                        <option value="">=== Please Choose and Select ===</option>';
                                                            $v_select = $connect->query("SELECT stpron_id,stpron_code,stpron_name_vn,stpron_name_kh 
                                                                                                                        FROM tbl_st_product_name 
                                                                                                                        WHERE stpron_material_type='$_SESSION[status]'
                                                                                                                        ORDER BY stpron_code DESC");
                                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                                echo '<option ' . ($row_child->pro_id == $row_data->stpron_id ? 'selected' : '') . ' value="' . $row_data->stpron_id . '" data_pro_code=' . $row_data->stpron_code . '>[' . $row_data->stpron_code . '] ' . $row_data->stpron_name_vn . ' == ' . $row_data->stpron_name_kh . '</option>';
                                                            }
                                            echo '</select>
                                                </td>
                                                <td>
                                                    <input type="number" step="1" name="txt_qty[]" class="form-control" value="' . $row_child->out_qty . '">
                                                </td>
                                                <td>
                                                    <select class="form-control myselect2" name="cbo_pro_type_id[]">
                                                        <option value="">=== Select ===</option>';
                                                            $v_select = $connect->query("SELECT * FROM tbl_st_product_type_list ORDER BY name DESC");
                                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                                echo '<option ' . ($row_child->pro_type_id == $row_data->id ? 'selected' : '') . ' value="' . $row_data->id . '">' . $row_data->name . '</option>';
                                                            }
                                                            echo '</select>
                                                </td>';
                                            echo '<td>
                                                        <select name="cbo_location[]" id="input" class="form-control">
                                                            <option value="">-- Select One --</option>
                                                            <option ' . ($row_child->locaton_id == 0 ? '' : 'selected') . ' value="0">រោងចក្រ/option>
                                                            <option ' . ($row_child->locaton_id == 1 ? '' : 'selected') . ' value="1">រណ្ដៅ</option>
                                                            <option ' . ($row_child->locaton_id == 2 ? '' : 'selected') . ' value="2">រោងជាង</option>
                                                        </select>
                                                    </td>
                                                <td>
                                                    <select class="form-control" name="cbo_unit[]">
                                                        <option value="">= Select =</option>';
                                            $v_select = $connect->query("SELECT * FROM tbl_st_unit_list ORDER BY stun_name DESC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option ' . ($row_child->unit_id == $row_data->stun_id ? 'selected' : '') . ' value="' . $row_data->stun_id . '" >' . $row_data->stun_name . '</option>';
                                            }
                                            echo '</select>
                                                </td>
                                                <td>
                                                    <select class="form-control myselect2" name="cbo_track_machine[]">
                                                        <option value="">= Select =</option>';
                                            $v_select = $connect->query("SELECT * FROM tbl_st_track_machine_list ORDER BY name_vn DESC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option ' . ($row_child->track_mac_id == $row_data->id ? 'selected' : '') . ' value="' . $row_data->id . '" >' . $row_data->name_vn . '</option>';
                                            }
                                            echo '</select>
                                                </td>
                                                <td class="text-center">
                                                    <div  data_id="' . $row_child->std_id . '"  class="btnDelete btn btn-danger btn-xs"><i class="fa fa-trash"></i></div>
                                                </td>';
                                            echo '</tr>';
                                        }
                                        ?>
                                        <input type="hidden" value="0" name="txt_status[]" id="inputTxt_acc_no" class="form-control">
                                        <tr class="my_form_base" style="background: red; display: none;">
                                            <td>
                                                <select class="form-control" name="cbo_project[]">
                                                    <option value="">** Select **</option>
                                                    <?php
                                                        $v_select = $connect->query("SELECT * FROM tbl_pj_project_title ORDER BY pti_project_title DESC");
                                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                                            echo '<option value="' . $row_data->pti_id . '">' . $row_data->pti_project_title . '</option>';
                                                        }
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
                                                <input type="number" step="1" name="txt_qty[]" class="form-control" value="0">
                                            </td>
                                            <td>
                                                <select class="form-control" name="cbo_pro_type_id[]">
                                                    <option value="">=== Select ===</option>
                                                    <?php
                                                    $v_select = $connect->query("SELECT * FROM tbl_st_product_type_list ORDER BY name DESC");
                                                    while ($row_data = mysqli_fetch_object($v_select)) {
                                                        echo '<option value="' . $row_data->id . '">' . $row_data->name . '</option>';
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
                                                <div data_id="0" class="btnDelete btn btn-danger btn-xs"><i class="fa fa-trash"></i></div>
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
        $('tr[data-row-id=' + index_row + ']').find('select').select2({
            width: 'auto'
        });
    });
    // setTimeout(function(){
    //     $('#add_more').click();      
    // },1000);
    //Delete Row By Row
    $("tbody").on('click', 'div.btnDelete', function() {
        var rowCount = $('tbody >tr').length;
        if (rowCount <= 2) {
            alert("You can not delete this record.");
            return;
        }
        v_row_detail_id = $(this).attr('data_id');
        obj_delete = $(this);
        if (v_row_detail_id) {
            $.get('delete_in.php?del_detail_id=' + v_row_detail_id, function(data) {
                obj_delete.parents('tr').remove();
                myAlertSuccess('Delete');
            });
        }
    });
    $('tbody').on('keyup', 'tr td:nth-child(3) >input,tr td:nth-child(5) >input,tr td:nth-child(6) >input', function(event) {
        let v_qty = $(this).parents('tr').find('td:nth-child(3) input').val();
        let v_exchange_rate = $('input[name=txt_exchange_rate]').val();
        let v_price_vn = $(this).parents('tr').find('td:nth-child(5) input').val();
        let v_price_dollar = $(this).parents('tr').find('td:nth-child(6) input').val();
        let v_amo = (v_qty * v_price_vn / v_exchange_rate) + (v_price_dollar * v_qty);
        $(this).parents('tr').find('td:nth-child(7) input').val(v_amo.toFixed(2));
        totalAmount();
    });

    function totalAmount() {
        let v_total_amo = 0;
        $('tbody >tr').each(function(index, el) {
            v_amo = parseFloat($(this).find('td:nth-last-child(2) >input').val());
            v_total_amo += v_amo;
        });
        $('tfoot tr th:last-child').html(v_total_amo.toFixed(2));
    }

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
    $("tbody").on('change', 'tr td:nth-child(3) select[name^=cbo_pro_code]', function() {
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