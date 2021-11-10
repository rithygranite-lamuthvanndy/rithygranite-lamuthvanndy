<?php
$menu_active = 140;
$left_active = 0;
$layout_title = "Edit Page";
include_once '../../config/database.php';
include_once '../../config/athonication.php';
if (@$_GET['view'] == 'iframe')
    include_once '../layout/header_frame.php';
else
    include_once '../layout/header.php';
?>


<?php
if (isset($_POST['btn_submit'])) {
    $v_id = @$_POST['txt_id'];
    $v_code = mysqli_escape_string($connect, @$_POST['txt_code']);
    $v_bar_code = mysqli_escape_string($connect, @$_POST['txt_bar_code']);
    $v_item_vn = mysqli_escape_string($connect, @$_POST['txt_name_vn']);
    $v_item_kh = mysqli_escape_string($connect, @$_POST['txt_name_kh']);
    $v_unit = mysqli_escape_string($connect, @$_POST['cbo_unit']);
    $v_pro_type = mysqli_escape_string($connect, @$_POST['cbo_pro_type']);
    $v_mater_type = mysqli_escape_string($connect, @$_POST['cbo_mater_type']);
    $v_category = mysqli_escape_string($connect, @$_POST['cbo_category']);
    $v_note = mysqli_escape_string($connect, @$_POST['txt_note']);
    $v_user_id = @$_SESSION['user']->user_id;
    $v_photo = (!@$_SESSION['saved_image_name']) ?: 'blank.png';
    $v_pro_alert = mysqli_escape_string($connect, @$_POST['txt_pro_alert']);

    $query_update = "UPDATE `tbl_st_product_name` 
            SET 
                `stpron_barcode`='$v_bar_code',
                `stpron_code`='$v_code',
                `stpron_code`='$v_code',
                `stpron_photo`='$v_photo',
                `stpron_name_kh`='$v_item_kh',
                `stpron_name_vn`='$v_item_vn',
                `stpron_unit`='$v_unit',
                `stpron_pro_type`='$v_pro_type',
                `stpron_category`='$v_category',
                `stpron_material_type`='$v_mater_type',
                `stpron_note`='$v_note',
                `user_id`='$v_user_id',
                `pro_alert`='$v_pro_alert'
            WHERE `stpron_id`='$v_id'";
    // echo $query_update;

    if ($connect->query($query_update)) {
        $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data updated ...
            </div>';
    } else {
        $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> ' . $connect->error . '
            </div>';
    }
}


// get old data 
$edit_id = @$_GET['edit_id'];
$old_data = $connect->query("SELECT * FROM tbl_st_product_name WHERE stpron_id='$edit_id'");
$row_old_data = mysqli_fetch_object($old_data);
?>
<style type="text/css">
    .dz-message {
        text-align: center;
        font-size: 28px;
    }

    .dz-remove {
        background-color: red;
        padding: 2px;
        color: white;
    }

    .dz-clickable {
        border: 2px dashed blue;
    }
</style>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Edit Record</h2>
        </div>
    </div>
    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Information</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->stpron_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Product Bar Code : </label>
                                    <input type="text" class="form-control" name="txt_bar_code" required="" value="<?= $row_old_data->stpron_barcode ?>" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Product Code : </label>
                                    <input type="text" class="form-control" name="txt_code" required="" value="<?= $row_old_data->stpron_code ?>" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Name KH : </label>
                                    <input type="text" class="form-control" name="txt_name_kh" required="" value="<?= $row_old_data->stpron_name_kh ?>" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Name VN : </label>
                                    <input type="text" class="form-control" name="txt_name_vn" required="" value="<?= $row_old_data->stpron_name_vn ?>" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Unit : </label>
                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#modal' onclick="view_iframe_unit()"><i class="fa fa-plus"></i></a>
                                    <select type="text" class="form-control myselect2" name="cbo_unit" required="" autocomplete="off">
                                        <option value="">=== Select and choose ===</option>
                                        <?php
                                        $get_select = $connect->query("SELECT * FROM tbl_st_unit_list ORDER BY stun_name ASC");
                                        while ($row_data = mysqli_fetch_object($get_select)) {
                                            if ($row_data->stun_id == $row_old_data->stpron_unit) {
                                                echo '<option SELECTED value="' . $row_data->stun_id . '">' . $row_data->stun_name . '</option>';
                                            } else {
                                                echo '<option value="' . $row_data->stun_id . '">' . $row_data->stun_name . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Material Type : </label>
                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#modal' onclick="view_iframe_material()"><i class="fa fa-plus"></i></a>
                                    <select type="text" class="form-control myselect2" name="cbo_mater_type" required="" autocomplete="off">
                                        <option value="">=== Select and choose===</option>
                                        <?php
                                        $get_select = $connect->query("SELECT * FROM tbl_st_material_type_list ORDER BY sttyp_name ASC");
                                        while ($row_data = mysqli_fetch_object($get_select)) {
                                            if ($row_old_data->stpron_material_type == $row_data->sttyp_id)
                                                echo '<option selected value="' . $row_data->sttyp_id . '">' . $row_data->sttyp_name . '</option>';
                                            else
                                                echo '<option value="' . $row_data->sttyp_id . '">' . $row_data->sttyp_name . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Category : </label>
                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#modal' onclick="view_iframe_category()"><i class="fa fa-plus"></i></a>
                                    <select type="text" class="form-control myselect2" name="cbo_category" required="" autocomplete="off">
                                        <option value="">=== Select and choose ===</option>
                                        <?php
                                        $get_select = $connect->query("SELECT * 
                                                                        FROM tbl_st_category_list 
                                                                        WHERE material_type_id='$row_old_data->stpron_material_type'
                                                                        ORDER BY stca_name ASC");
                                        while ($row_data = mysqli_fetch_object($get_select)) {
                                            if ($row_data->stca_id == $row_old_data->stpron_category) {
                                                echo '<option SELECTED value="' . $row_data->stca_id . '">' . $row_data->stca_name . '</option>';
                                            } else {
                                                echo '<option value="' . $row_data->stca_id . '">' . $row_data->stca_name . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Production Type : </label>
                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#modal' onclick="view_iframe_product_type()"><i class="fa fa-plus"></i></a>
                                    <select type="text" class="form-control myselect2" name="cbo_pro_type" required="" autocomplete="off">
                                        <option value="">=== Select and choose===</option>
                                        <?php
                                        $get_select = $connect->query("SELECT * 
                                                                        FROM tbl_st_product_type_list 
                                                                        WHERE material_type_id='$row_old_data->stpron_material_type'
                                                                        ORDER BY name ASC");
                                        while ($row_data = mysqli_fetch_object($get_select)) {
                                            if ($row_old_data->stpron_pro_type == $row_data->id)
                                                echo '<option selected value="' . $row_data->id . '">' . $row_data->name . '</option>';
                                            else
                                                echo '<option value="' . $row_data->id . '">' . $row_data->name . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Note : </label>
                                    <textarea type="text" class="form-control" name="txt_note" rows="1" autocomplete="off"><?= $row_old_data->stpron_note ?></textarea>
                                </div>
                                 <div class="form-group">
                                    <label>Number Alert : </label>
                                    <input value="<?= $row_old_data->pro_alert ?>" type="text" name="txt_pro_alert" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-4">
                                <div action="save_photo.php" class="dropzone">
                                    <input type="hidden" name="txt_id" value="<?= $edit_id ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <img style="height: 190px; width: 100%;" src="../../img/img_stock/product_name/<?= $row_old_data->stpron_photo ?>" alt="Stock Rithy Granite, Product Name" class="img-responsive">
                            </div>
                            <div class="col-md-6 text-center">
                                <button type="submit" name="btn_submit" class="btn green"><i class="fa fa-save fa-fw"></i>Save</button>
                                <a href="index.php?view=<?= @$_GET['view'] ?>" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // ===============Refrsh Modal ========================
        $('#modal').on('hidden.bs.modal', function() {
            var iframe_statue = $(this).find('iframe').attr('src');
            if (iframe_statue == '../st_product_type_list/index.php?view=iframe') {
                $.get('ajax_get_content_select.php?status=st_product_type_list', function(data) {
                    if ($('select[name=cbo_pro_type]').html().trim() != data.trim()) {
                        $('select[name=cbo_pro_type]').html(data);
                    }
                });
            } else if (iframe_statue == '../st_unit_list/index.php?view=iframe') {
                $.get('ajax_get_content_select.php?status=st_unit_list', function(data) {
                    if ($('select[name=cbo_unit]').html().trim() != data.trim()) {
                        $('select[name=cbo_unit]').html(data);
                    }
                });
            } else if (iframe_statue == '../st_category_list/index.php?view=iframe') {
                $.get('ajax_get_content_select.php?status=st_category_list', function(data) {
                    if ($('select[name=cbo_category]').html().trim() != data.trim()) {
                        $('select[name=cbo_category]').html(data);
                    }
                });
            } else if (iframe_statue == '../st_material_type_list/index.php?view=iframe') {
                $.get('ajx_get_substance_detail.php?sub_id=' + v_main_sub, function(data) {
                    if (data != $('select[name=cbo_sub_detail]').html()) {
                        $('select[name=cbo_sub_detail]').html(data);
                    }
                });
            }
        });
    });

    function view_iframe_product_type() {
        document.getElementById('result_modal').src = '../st_product_type_list/index.php?view=iframe';
    }

    function view_iframe_unit() {
        document.getElementById('result_modal').src = '../st_unit_list/index.php?view=iframe';
    }

    function view_iframe_category() {
        document.getElementById('result_modal').src = '../st_category_list/index.php?view=iframe';
    }

    function view_iframe_material() {
        document.getElementById('result_modal').src = '../st_material_type_list/index.php?view=iframe';
    }
</script>
<?php
if (@$_GET['view'] == 'iframe')
    include_once '../layout/footer_frame.php';
else
    include_once '../layout/footer.php';
?>
<script type="text/javascript">
    Dropzone.autoDiscover = false;

    var myDropzone = new Dropzone(".dropzone", {
        autoProcessQueue: false,
        acceptedFiles: "image/jpeg,image/png,image/gif",
        addRemoveLinks: true,
        parallelUploads: 1 // Number of files process at a time (default 2)

    });

    $('button[name=btn_submit]').click(function() {
        myDropzone.processQueue();
    });

    $('select[name=cbo_mater_type]').change(function(event) {
        v_material_type = $(this).find('option:selected').val();
        $.get('ajax_get_content_select.php?cbo_category=cbo_category&p_materail_type_id=' + v_material_type, function(data) {
            $('select[name=cbo_category]').html(data);
        });

        $.get('ajax_get_content_select.php?cbo_pro_type=cbo_pro_type&p_materail_type_id=' + v_material_type, function(data) {
            $('select[name=cbo_pro_type]').html(data);
        });
    });
</script>
<!-- this script helps us to capture any div -->
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg" style="width: 70%;">
        <div class="modal-content">
            <div class="modal-body">
                <iframe id="result_modal" src="" width="100%" style="min-height: 600px; resize: vertical;" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>