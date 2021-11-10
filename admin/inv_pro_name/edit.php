<?php 
    $menu_active =145;
    $left_active =0;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        
        $v_id = @$_POST['txt_id'];
        $v_date_record = @$_POST['txt_date_record'];
        $v_code = @$_POST['txt_code'];
        $v_item_en = @$_POST['txt_name_en'];
        $v_item_kh = @$_POST['txt_name_kh'];
        $v_unit = @$_POST['txt_unit'];
        $v_pro_type = @$_POST['cbo_pro_type'];
        $v_category = @$_POST['txt_category'];
        $v_employee = @$_POST['txt_employee'];
        $v_note = @$_POST['txt_note'];
        $v_pro_type = @$_POST['cbo_inv_type'];
        
       
        $query_update = "UPDATE `tbl_inv_product_name` 
            SET 
                `inv_pron_date_record`='$v_date_record',
                `inv_pron_code`='$v_code',
                `inv_pron_name_en`='$v_item_en',
                `inv_pron_name_kh`='$v_item_kh',
                `inv_pron_unit`='$v_unit',
                `inv_pron_pro_type`='$v_pro_type',
                `inv_pron_category`='$v_category',
                `inv_pron_note`='$v_note',
                `user_id`='$user_id'
            WHERE `inv_pron_id`='$v_id'";
            
       
        if($connect->query($query_update)){
            header('location: index.php?status=update');
        }else{
            echo '<script>myAlertError("Erorr ");</script>'; 
        }
    }


// get old data 
    $edit_id = @$_GET['edit_id'];
    $old_data = $connect->query("SELECT * FROM tbl_inv_product_name WHERE inv_pron_id='$edit_id'");
    $row_old_data = mysqli_fetch_object($old_data);


 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Edit Record</h2>
        </div>
    </div>
    <br>
    <br>

    <div class="portlet-title">
        <div class="caption font-dark">
            <a href="index.php" id="sample_editable_1_new" class="btn red"> 
                <i class="fa fa-arrow-left"></i>
                Back
            </a>
        </div>
    </div>
    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
            <h3 class="panel-title">Edit Information</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->inv_pron_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Date Record :
                                    </label>
                                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                        <input type="text" class="form-control" placeholder="Choose Date" required="" aufocomplete="off" name="txt_date_record" value="<?= $row_old_data->inv_pron_date_record ?>">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Product Code : </label>
                                    <input type="text" class="form-control" name="txt_code" required="" value="<?= $row_old_data->inv_pron_code ?>" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Name EN : </label>
                                    <input type="text" class="form-control" name="txt_name_en" required="" value="<?= $row_old_data->inv_pron_name_en ?>" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Name KH : </label>
                                    <input type="text" class="form-control" name="txt_name_kh" required="" value="<?= $row_old_data->inv_pron_name_kh ?>" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Inventory Type : </label>
                                    <button type="button" class="btn btn-primary btn-xs" id="add_inv_type"><i class="fa fa-plus"></i></button>
                                    <button type="button" class="btn btn-info btn-xs" id="re_inv_type"><i class="fa fa-refresh"></i></button>
                                    <select type="text" class="form-control myselect2" name="cbo_inv_type" required="" autocomplete="off">
                                        <option value="">=== Select and choose===</option>
                                        <?php 
                                            $get_select=$connect->query("SELECT * FROM tbl_inv_pro_type ORDER BY name ASC");
                                            while($row_data = mysqli_fetch_object($get_select)){
                                                if($row_old_data->inv_pron_pro_type==$row_data->id)
                                                    echo '<option selected value="'.$row_data->id.'">'.$row_data->name.'</option>';
                                                else
                                                    echo '<option value="'.$row_data->id.'">'.$row_data->name.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Unit : </label>
                                    <button type="button" class="btn btn-primary btn-xs" id="add_unit"><i class="fa fa-plus"></i></button>
                                    <button type="button" class="btn btn-info btn-xs" id="re_unit"><i class="fa fa-refresh"></i></button>
                                    <select type="text" class="form-control" name="txt_unit" required="" autocomplete="off">
                                        <option value="">=== Select and choose ===</option>
                                        <?php 
                                            $get_select=$connect->query("SELECT * FROM tbl_st_unit ORDER BY stun_name ASC");
                                            while($row_data = mysqli_fetch_object($get_select)){
                                                if($row_data->stun_id==$row_old_data->inv_pron_unit){
                                                echo '<option SELECTED value="'.$row_data->stun_id.'">'.$row_data->stun_name.'</option>';
                                                    
                                                }else{
                                                echo '<option value="'.$row_data->stun_id.'">'.$row_data->stun_name.'</option>';

                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Category : </label>
                                    <button type="button" class="btn btn-primary btn-xs" id="add_category"><i class="fa fa-plus"></i></button>
                                    <button type="button" class="btn btn-info btn-xs" id="re_category"><i class="fa fa-refresh"></i></button>
                                    <select type="text" class="form-control myselect2" name="txt_category" required="" autocomplete="off">
                                        <option value="">=== Select and choose ===</option>
                                        <?php 
                                            $get_select=$connect->query("SELECT * FROM tbl_inv_category ORDER BY name ASC");
                                            while($row_data = mysqli_fetch_object($get_select)){
                                                if($row_data->id==$row_old_data->inv_pron_category){
                                                echo '<option SELECTED value="'.$row_data->id.'">'.$row_data->name.'</option>';
                                                    
                                                }else{
                                                echo '<option value="'.$row_data->id.'">'.$row_data->name.'</option>';

                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Note : </label>
                                    <textarea type="text" class="form-control" name="txt_note" rows="9" autocomplete="off"><?= $row_old_data->inv_pron_note ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_submit" class="btn green"><i class="fa fa-save fa-fw"></i>Save</button>
                                <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#add_pro_type').click(function () {
            $('#adding_item').modal('show');
            $('iframe').attr('src','iframe_add_item.php?status=pro_type');
        });
        $('#re_pro_type').click(function () {
            $.ajax({url: 'ajax_get_content_select.php?status=cbo_pro_type',success:function (result) {
                if($('select[name=cbo_pro_type]').html().trim()!=result.trim())
                    $('select[name=cbo_pro_type]').html(result);
            }});
        });

        $('#add_unit').click(function () {
            $('#adding_item').modal('show');
            $('iframe').attr('src','iframe_add_item.php?status=unit');
        });
        $('#re_unit').click(function () {
            $.ajax({url: 'ajax_get_content_select.php?status=cbo_unit',success:function (result) {
                if($('select[name=txt_unit]').html().trim()!=result.trim())
                    $('select[name=txt_unit]').html(result);
            }});
        });

        $('#add_inv_type').click(function () {
            $('#adding_item').modal('show');
            $('iframe').attr('src','iframe_add_item.php?status=inv_type');
        });
        $('#re_inv_type').click(function () {
            $.ajax({url: 'ajax_get_content_select.php?status=cbo_inv_type',success:function (result) {
                if($('select[name=cbo_inv_type]').html().trim()!=result.trim())
                    $('select[name=cbo_inv_type]').html(result);
            }});
        });
        
        $('#add_category').click(function () {
            $('#adding_item').modal('show');
            $('iframe').attr('src','iframe_add_item.php?status=category');
        });
        $('#re_category').click(function () {
            $.ajax({url: 'ajax_get_content_select.php?status=txt_category',success:function (result) {
                if($('select[name=txt_category]').html().trim()!=result.trim())
                    $('select[name=txt_category]').html(result);
            }});
        });
    });
</script>

<?php include_once '../layout/footer.php' ?>
<div class="modal fade" id="adding_item">
    <div class="modal-dialog" style="width: 50%;">
        <iframe frameborder="0" style="height: 500px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>