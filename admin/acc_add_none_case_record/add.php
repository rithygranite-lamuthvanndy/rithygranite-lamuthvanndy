<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>

<?php 
    if(isset($_POST['btn_submit'])){
        $v_date_record = @$connect->real_escape_string($_POST['txt_date_record']);
        $v_deli_no = @$connect->real_escape_string($_POST['txt_deli_no']);
        $v_invoice_no = @$connect->real_escape_string($_POST['txt_invoice_no']);
        $v_po_no = @$connect->real_escape_string($_POST['txt_po_no']);
        $v_name = @$connect->real_escape_string($_POST['txt_name']);
        $v_note = @$connect->real_escape_string($_POST['txt_note']);
        $v_accr = @$connect->real_escape_string($_POST['txt_accrual']);

        $query_add = "INSERT INTO `tbl_acc_none_cash_record`( `date_record`, 
        `deli_no`, `inv_no`, `po_no`, `name`, `Accrual`,note,user_id)
            VALUES
                (
                '$v_date_record',
                '$v_deli_no',
                '$v_invoice_no',
                '$v_po_no',
                '$v_name',
                '$v_accr',
                '$v_note',
                '$user_id'
                )";

        if($connect->query($query_add)){
            echo '<script>myAlertSuccess("Adding");</script>';
        }else{
            echo '<script>myAlertError("Error");</script>';
        }
    }

 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Create Record</h2>
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
                <h3 class="panel-title">Input Information</h3>
            </div>
            <div class="panel-body">
                 <form action="#" method="post" enctype="multipart/form-data" autocomplete="off">
                    <div class="form-body">
                       <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Date : </label>
                                    <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" required name="txt_date_record" value="<?= date('Y-m-d') ?>">
                                </div>
                                <div class="form-group">
                                    <label>Delivery No : </label>
                                    <input type="text" class="form-control" required name="txt_deli_no" ">
                                </div>
                                <div class="form-group">
                                    <label>Invoice No : </label>
                                    <input type="text" class="form-control" required name="txt_invoice_no">
                                </div>
                                <div class="form-group">
                                    <label>PO No : </label>
                                    <input type="text" class="form-control" required name="txt_po_no">
                                </div>

                                <div class="form-group">
                                    <label>Name : </label>
                                    <input type="text" class="form-control" required name="txt_name">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <!-- <div class="form-group">
                                    <label>Description : </label>
                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#description'><i class="fa fa-plus"></i></a>
                                    <select name="txt_description" id="input" class="form-control" required="required">
                                        <option value="">=== Select and Choose here ===</option>
                                        <?php 
                                            $sql=$connect->query("SELECT * FROM tbl_acc_decription ORDER BY des_name ASC");
                                            while ($row=mysqli_fetch_object($sql)) {
                                                echo '<option value="'.$row->des_id.'">'.$row->des_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div> -->
                                <div class="form-group">
                                    <label>Accrual : </label>
                                    <input type="number" class="form-control" required min="0.01" step="0.01" name="txt_accrual" value="0">
                                </div>
                                <div class="form-group">
                                    <label>Note : </label>
                                    <textarea class="form-control" rows="12" autocomplete="off" name="txt_note"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_submit" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
                                <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../../assets/global/plugins/jquery.min.js"></script>
<script type="text/javascript">
    $('input[name="txt_cash_in"],input[name="txt_cash_out"]').keyup(function(){
        $c_in = $('input[name="txt_cash_in"]').val();
        $c_out =$('input[name="txt_cash_out"]').val();
        $('input[name="txt_balance"]').val($c_in-$c_out);
    });
    $('select[name=txt_description]').mouseover(function(){
        $.ajax({url: "ajx_get_content_select.php?d=txt_description", success: function(result){
            if($('select[name=txt_description]').html().trim() != result.trim()){
                $('select[name=txt_description]').html(result);
            }
        }});
    });
</script>
<?php include_once '../layout/footer.php' ?>
<div class="modal fade" id="description">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_description.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>