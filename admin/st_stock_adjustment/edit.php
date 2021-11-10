<?php 
    $menu_active =140;
    $left_active =0;
    $layout_title = "Update Stock Adjustment";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        
        $v_id = @$_POST['txt_id'];
        $v_date_record = @$_POST['txt_date_record'];
        $v_employee = @$_POST['cbo_employee'];
        $v_product = @$_POST['cbo_product_name'];
        $v_qty_adj = @$_POST['txt_qty_adj'];
        $v_note = @$_POST['txt_note'];
        $v_user_id = @$_SESSION['user']->user_id;
       
        $query_update = "UPDATE `tbl_st_stock_adjustment` 
            SET 
                `stsadj_date_record`='$v_date_record',
                `stsadj_product_code`='$v_product',
                `stsadj_qty_adj`='$v_qty_adj',
                `stsadj_employee`='$v_employee',
                `stsadj_note`='$v_note',
                `user_id`='$v_user_id'
            WHERE `stsadj_id`='$v_id'";
            
       
        if($connect->query($query_update)){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data update ...
            </div>'; 
        }else{
            $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> '.$connect->error.'
            </div>';   
        }
    }


// get old data 
    $edit_id = @$_GET['edit_id'];
    $old_data = $connect->query("SELECT * FROM tbl_st_stock_adjustment WHERE stsadj_id='$edit_id'");
    $row_old_data = mysqli_fetch_object($old_data);
 ?>
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
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->stsadj_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Date Record *:</label>
                                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                        <input type="text" class="form-control" autocomplete="off" value="<?= $row_old_data->stsadj_date_record ?>" placeholder="Choose Date" required="" aufocomplete="off" name="txt_date_record">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Product Name *: </label>
                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#modal' onclick="view_iframe_product_name();"><i class="fa fa-plus"></i></a>
                                    <select type="text" class="form-control myselect2" name="cbo_product_name" required="" autocomplete="off">
                                        <option value="">=== Select and choose===</option>
                                        <?php 
                                            $get_select=$connect->query("SELECT * FROM tbl_st_product_name ORDER BY stpron_name_vn ASC");
                                            while($row_data = mysqli_fetch_object($get_select)){
                                                if($row_old_data->stsadj_product_code==$row_data->stpron_id)
                                                    echo '<option selected value="'.$row_data->stpron_id.'">['.$row_data->stpron_code.' ] '.$row_data->stpron_name_kh.' :: '.$row_data->stpron_name_vn.'</option>';
                                                else
                                                    echo '<option value="'.$row_data->stpron_id.'">['.$row_data->stpron_code.' ] '.$row_data->stpron_name_kh.' :: '.$row_data->stpron_name_vn.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>                              
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>References N&deg; *: </label>
                                    <input type="text" name="txt_ref_no" value="<?= $row_old_data->stsadj_ref_no ?>" class="form-control" autocomplete="off" required="" aufocomplete="off" placeholder="References N&deg;......">
                                </div>
                                <div class="form-group">
                                    <label>Note : </label>
                                    <textarea type="text" class="form-control" name="txt_note" style="height: 80px;" autocomplete="off"><?= $row_old_data->stsadj_note ?></textarea>
                                </div>
                            </div>   
                            <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                                <div class="row">
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>QTY Balanace : </label>
                                            <input type="text" name="txt_qty_bal" class="form-control" autocomplete="off" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>New Qty After Adjust: </label>
                                            <input type="text" name="txt_new_qty_after_adjust" class="form-control" value="0" autocomplete="off" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>QTY Difference *: </label>
                                            <input type="text"  value="<?= $row_old_data->stsadj_qty_adj ?>" name="txt_qty_difference" class="form-control" autocomplete="off" value="0" placeholder="Qty Adjustment" required="" aufocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_submit" class="btn blue"><i class="fa fa-save fa-fw"></i>Update</button>
                                <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        // ===============Refrsh Modal ========================
        $('#modal').on('hidden.bs.modal', function () {
            var iframe_statue=$(this).find('iframe').attr('src');
            if(iframe_statue=='../st_product_name/index.php?view=iframe'){
                $.get('ajx_get_content_select.php?status=st_product_name', function(data) {
                    if($('select[name=cbo_product_name]').html().trim()!=data.trim()){
                        $('select[name=cbo_product_name]').html(data);
                    }
                });
            }
        });
        $('select[name=cbo_product_name]').change(function(event) {
            $.get('ajx_get_content_select.php?p_pro_id='+$(this).val(), function(data) {
                $('input[name=txt_qty_bal]').val(data);
                $('input[name=txt_new_qty_after_adjust]').val(data);
            });
        });

        $('input[name=txt_qty_difference]').keyup(function(event) {
            v_new_qty=parseInt($(this).val());
            v_old=parseInt($('input[name=txt_qty_bal]').val());
            $('input[name=txt_new_qty_after_adjust]').val(v_new_qty+v_old);
        });

        setTimeout(function(){
            $('select[name=cbo_product_name]').change();
            $('input[name=txt_qty_difference]').keyup();
        },100);
    });
</script>
<?php include_once '../layout/footer.php' ?>
<script type="text/javascript">
    function view_iframe_product_name(){
        document.getElementById('result_modal').src = '../st_product_name/index.php?view=iframe';
    }
    function view_iframe_employee(){
        document.getElementById('result_modal').src = '../st_employee_list/index.php?view=iframe';
    }
</script>
<div class="modal fade" id="modal">
    <div class="modal-dialog" style="border: 1px solid darkred; width: 70%;">
        <iframe id="result_modal" frameborder="0" style="height: 600px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>