<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>

<?php 
    if(isset($_POST['btn_save_new'])){
        $v_ref = @$connect->real_escape_string($_POST['txt_ref']);
        $v_date_record = @$connect->real_escape_string($_POST['txt_date_record']);
        $v_tran_from = @$connect->real_escape_string($_POST['cbo_tran_from']);
        $v_amo_debit = @$connect->real_escape_string($_POST['txt_amo_debit']);
        $v_tran_to = @$connect->real_escape_string($_POST['cbo_tran_to']);
        $v_amo_credit = @$connect->real_escape_string($_POST['txt_amo_credit']);
        $v_amo_tran = @$connect->real_escape_string($_POST['txt_tran_amo']);
        $v_des_id = @$connect->real_escape_string($_POST['cbo_description']);
        $v_note = @$connect->real_escape_string($_POST['txt_note']);

        $query_add = "INSERT INTO tbl_acc_add_transfer_fund(
        tran_ref_no,
        date_record,
        from_chart_acc, 
        debit, 
        to_chart_acc,
        credit,
        des_id,
        note,
        user_id
         )
        VALUES (
        '$v_ref',
        '$v_date_record',
        '$v_tran_from', 
        '0',
        '0',
        '$v_amo_tran',
        '$v_des_id',
        '$v_note',
        '$user_id'
        )";
        $connect->query($query_add);
        $last_parent_id = $connect->insert_id;
        $query_add = "INSERT INTO tbl_acc_add_transfer_fund(
        tran_ref_no,
        date_record,
        from_chart_acc, 
        debit, 
        to_chart_acc,
        credit,
        des_id,
        note,
        parent_id,
        user_id
         )
         VALUES(
        '$v_ref',
        '$v_date_record',
        '0', 
        '$v_amo_tran',
        '$v_tran_to',
        '0',
        '$v_des_id',
        '$v_note',
        '$last_parent_id',
        '$user_id'
        )";
        if($connect->query($query_add)){
            echo '<script>myAlertSuccess("Add")</script>';
        }else{  
            echo '<script>myAlertError("Error")</script>';
        }
    }
    else if(isset($_POST['btn_save_close'])){
        $v_ref = @$connect->real_escape_string($_POST['txt_ref']);
        $v_date_record = @$connect->real_escape_string($_POST['txt_date_record']);
        $v_tran_from = @$connect->real_escape_string($_POST['cbo_tran_from']);
        $v_amo_debit = @$connect->real_escape_string($_POST['txt_amo_debit']);
        $v_tran_to = @$connect->real_escape_string($_POST['cbo_tran_to']);
        $v_amo_credit = @$connect->real_escape_string($_POST['txt_amo_credit']);
        $v_amo_tran = @$connect->real_escape_string($_POST['txt_tran_amo']);
        $v_des_id = @$connect->real_escape_string($_POST['cbo_description']);
        $v_note = @$connect->real_escape_string($_POST['txt_note']);

        $query_add = "INSERT INTO tbl_acc_add_transfer_fund(
        tran_ref_no,
        date_record,
        from_chart_acc, 
        debit, 
        to_chart_acc,
        credit,
        des_id,
        note,
        user_id
         )
        VALUES (
        '$v_ref',
        '$v_date_record',
        '$v_tran_from', 
        '0',
        '0',
        '$v_amo_tran',
        '$v_des_id',
        '$v_note',
        '$user_id'
        )";
        $connect->query($query_add);
        $last_parent_id = $connect->insert_id;
        $query_add = "INSERT INTO tbl_acc_add_transfer_fund(
        tran_ref_no,
        date_record,
        from_chart_acc, 
        debit, 
        to_chart_acc,
        credit,
        des_id,
        note,
        parent_id,
        user_id
         )
         VALUES(
        '$v_ref',
        '$v_date_record',
        '0', 
        '$v_amo_tran',
        '$v_tran_to',
        '0',
        '$v_des_id',
        '$v_note',
        '$last_parent_id',
        '$user_id'
        )";
        if($connect->query($query_add)){
            header('location: index.php');
        }else{  
            echo '<script>myAlertError("Error")</script>';
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
                                    <label for="input" class="control-label">Transfer Funds Ref *:</label>
                                    <input type="text" name="txt_ref" class="form-control">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Date : </label>
                                    <input type="text" name="txt_date_record" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" required value="<?= date('Y-m-d') ?>">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Trsansfer Funds From *: </label>
                                    <select name="cbo_tran_from" id="input" class="form-control myselect2" required="required">
                                        <option value="">=== Select and choose ===</option>
                                        <?php 
                                            $v_select=$connect->query("SELECT accca_id,accca_number,accca_account_name FROM tbl_acc_chart_account ORDER BY accca_number");
                                            while ($row_select=mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_select->accca_id.'">'.$row_select->accca_number.' = '.$row_select->accca_account_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                                
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Amount Credit : </label>
                                    <input type="text" name="txt_amo_credit" id="inputCbo_amo_debit" class="form-control" readonly="">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Trsansfer Funds To *: </label>
                                    <select name="cbo_tran_to" id="input" class="form-control myselect2" required="required">
                                        <option value="">=== Select and choose ===</option>
                                        <?php 
                                            $v_select=$connect->query("SELECT accca_id,accca_number,accca_account_name FROM tbl_acc_chart_account ORDER BY accca_number");
                                            while ($row_select=mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_select->accca_id.'">'.$row_select->accca_number.' = '.$row_select->accca_account_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Amount Debit : </label>
                                    <input type="text" name="txt_amo_debit" id="inputCbo_amo_debit" class="form-control" readonly="">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-right">
                                <div class="form-group">
                                    <label>Trsansfer Amount *: </label>
                                    <input type="text" name="txt_tran_amo" id="input" class="form-control" required="required" placeholder="Please enter amount...">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Description: </label>
                                    <select name="cbo_description" id="input" class="form-control myselect2" required="required">
                                        <option value="">=== Select and choose ===</option>
                                        <?php 
                                            $v_select=$connect->query("SELECT * FROM tbl_acc_decription ORDER BY des_name");
                                            while ($row_select=mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_select->des_id.'">'.$row_select->des_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Transaction Note : </label>
                                    <div class="form-group">
                                        <textarea name="txt_note" id="textarea" class="form-control" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_save_close" class="btn yellow"><i class="fa fa-save fa-fw"></i>Save & Close</button>
                                <button type="submit" name="btn_save_new" class="btn blue"><i class="fa fa-save fa-fw"></i>Save & New</button>
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
$(document).ready(function () {
    $('input[name=txt_amo_debit]').parents('div[class="col-xs-12 col-sm-6 col-md-6 col-lg-6"]').hide();
    $('input[name=txt_amo_credit]').parents('div[class="col-xs-12 col-sm-6 col-md-6 col-lg-6"]').hide();

    $('select[name=cbo_tran_from]').change(function () {
        let v_chart_acc_id=$(this).val();
        let myArr=[1,v_chart_acc_id];
        $.ajax({url: 'ajax_get_amount.php',
            type: 'POST',
            async: false,
            data: 'data='+myArr,
            success: function (data,status) {
                // alert(data);
                $('input[name=txt_amo_credit]').parents('div[class="col-xs-12 col-sm-6 col-md-6 col-lg-6"]').show();
                $('input[name=txt_amo_credit]').val(parseFloat(data).toFixed(2));
            }});
    });

    $('select[name=cbo_tran_to]').change(function () {
        let v_chart_acc_id=$(this).val();
        let myArr=[2,v_chart_acc_id];
        $.ajax({url: 'ajax_get_amount.php',
            type: 'POST',
            async: false,
            data: 'data='+myArr,
            success: function (data,status) {
                // alert(data);
                $('input[name=txt_amo_debit]').parents('div[class="col-xs-12 col-sm-6 col-md-6 col-lg-6"]').show();
                $('input[name=txt_amo_debit]').val(parseFloat(data).toFixed(2));
            }});
    });


    // $('input[name=txt_tran_amo]').keyup(function () {
    //     let v_amo=parseFloat($(this).val());
    //     let v_tra_from=$('input[name=txt_amo_credit]').val();
    //     if(v_amo>v_tra_from){
    //         $('button[name=btn_save_new]').addClass("disabled");
    //         $('button[name=btn_save_close]').addClass("disabled");
    //     }
    //     else{
    //         $('button[name=btn_save_new]').removeClass("disabled");
    //         $('button[name=btn_save_close]').removeClass("disabled");
    //     }
    // });

    setTimeout(function () {
        $('input[name=txt_tran_amo]').keyup();
        $.ajax({url: 'ajax_get_last_tran_no.php',success:function (data,status) {
            $('input[name=txt_ref]').val(data);
        }});
    },100);
});
</script>
<?php include_once '../layout/footer.php' ?>