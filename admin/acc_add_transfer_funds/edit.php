<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
    include 'my_function.php';
?>

<?php 
    if(isset($_POST['btn_update_close'])){
        // die();
        $v_id = @$connect->real_escape_string($_POST['txt_id']);
        $v_ref = @$connect->real_escape_string($_POST['txt_ref']);
        $v_date_record = @$connect->real_escape_string($_POST['txt_date_record']);
        $v_tran_from = @$connect->real_escape_string($_POST['cbo_tran_from']);
        $v_amo_debit = @$connect->real_escape_string($_POST['txt_amo_debit']);
        $v_tran_to = @$connect->real_escape_string($_POST['cbo_tran_to']);
        $v_amo_credit = @$connect->real_escape_string($_POST['txt_amo_credit']);
        $v_des_id = @$connect->real_escape_string($_POST['cbo_description']);
        $v_note = @$connect->real_escape_string($_POST['txt_note']);
        $v_amo_tran = @$connect->real_escape_string($_POST['txt_tran_amo']);

        $query_update = "UPDATE tbl_acc_add_transfer_fund SET
        tran_ref_no='$v_ref',
        date_record='$v_date_record',
        from_chart_acc='$v_tran_from', 
        credit='$v_amo_tran',
        des_id='$v_des_id',
        note='$v_note',
        user_id='$user_id'
        WHERE id='$v_id'
        ";
        if(!$connect->query($query_update))
            exit();
        // echo 'success';
        $query_update = "UPDATE tbl_acc_add_transfer_fund SET
        tran_ref_no='$v_ref',
        date_record='$v_date_record',
        to_chart_acc='$v_tran_to', 
        debit='$v_amo_tran',
        des_id='$v_des_id',
        note='$v_note',
        user_id='$user_id'
        WHERE parent_id='$v_id'
        ";
        // die($query_update);
        if($connect->query($query_update)){
            header('location: index.php');
        }else{  
            echo '<script>myAlertError("Error")</script>';
        }
    }
    if(@($_GET['edit_id'])){
        $v_id=$_GET['edit_id'];
        $query="SELECT * FROM tbl_acc_add_transfer_fund WHERE id='$v_id' OR parent_id='$v_id' ORDER BY id";
        $sql=$connect->query($query);
        $row_old=mysqli_fetch_object($sql);
        // var_dump($row_old);
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
                    <input type="hidden" name="txt_id" value="<?= $row_old->id; ?>">
                    <div class="form-body">
                       <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="input" class="control-label">Transfer Funds Ref *:</label>
                                    <input type="text" name="txt_ref" readonly="" class="form-control" value="<?= $row_old->tran_ref_no; ?>">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Date : </label>
                                    <input type="text" name="txt_date_record" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" required value="<?= $row_old->date_record; ?>">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <?php 
                                $i=0;
                                $sql=$connect->query($query);
                                while ($row_sub_old=mysqli_fetch_object($sql)) {
                                    if($i==0){
                                    echo '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Trsansfer Funds From *: </label>
                                            <select name="cbo_tran_from" id="input" class="form-control myselect2" required="required">
                                                <option value=""><?= $i ?>=== Select and choose ===</option>';
                                                    $v_select=$connect->query("SELECT accca_id,accca_number,accca_account_name FROM tbl_acc_chart_account ORDER BY accca_number");
                                                    while ($row_select=mysqli_fetch_object($v_select)) {
                                                        if($row_sub_old->from_chart_acc==$row_select->accca_id)
                                                            echo '<option selected value="'.$row_select->accca_id.'">'.$row_select->accca_number.' = '.$row_select->accca_account_name.'</option>';
                                                        else
                                                            echo '<option value="'.$row_select->accca_id.'">'.$row_select->accca_number.' = '.$row_select->accca_account_name.'</option>';
                                                    }
                                                    $v_bal_credit=GetBalanceOfAccount(@$row_sub_old->from_chart_acc);
                                            echo '</select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Amount Credit : </label>
                                            <input type="text" name="txt_amo_credit" id="inputCbo_amo_debit" class="form-control" readonly="" value="'.$v_bal_credit.'">
                                        </div>
                                    </div>';
                                    }
                                    ?>
                                    <div class="clearfix"></div>
                                    <?php if($i==1){ 
                                        echo '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label>Trsansfer Funds To *: </label>
                                                <select name="cbo_tran_to" id="input" class="form-control myselect2" required="required">
                                                    <option value="">=== Select and choose ===</option>';
                                                        $v_select=$connect->query("SELECT accca_id,accca_number,accca_account_name FROM tbl_acc_chart_account ORDER BY accca_number");
                                                        while ($row_select=mysqli_fetch_object($v_select)) {
                                                            if($row_sub_old->to_chart_acc==$row_select->accca_id)
                                                                echo '<option selected value="'.$row_select->accca_id.'">'.$row_select->accca_number.' = '.$row_select->accca_account_name.'</option>';
                                                            else
                                                                echo '<option value="'.$row_select->accca_id.'">'.$row_select->accca_number.' = '.$row_select->accca_account_name.'</option>';
                                                        }
                                                        $v_bal_debit=GetBalanceOfAccount(@$row_sub_old->from_chart_acc);
                                                echo '</select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label>Amount Debit : </label>
                                                <input type="text" name="txt_amo_debit" id="inputCbo_amo_debit" class="form-control" readonly="" value="'.$v_bal_debit.'">
                                            </div>
                                        </div>';
                                     } ?>
                            <?php 
                                ++$i;
                                } 
                            ?>
                            <div class="clearfix"></div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-right">
                                <div class="form-group">
                                    <label>Trsansfer Amount *: </label>
                                    <input type="text" name="txt_tran_amo" id="input" class="form-control" value="<?= ($row_old->debit)?($row_old->debit):($row_old->credit) ?>" required="required" placeholder="Please enter amount...">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Description: </label>
                                    <select name="cbo_description" id="input" class="form-control myselect2" required="required">
                                        <option value="">=== Select and choose ===</option>
                                        <?php 
                                            $v_select=$connect->query("SELECT des_id,des_name FROM tbl_acc_decription ORDER BY des_name");
                                            while ($row_select=mysqli_fetch_object($v_select)) {
                                                if($row_old->des_id==$row_select->des_id)
                                                    echo '<option selected value="'.$row_select->des_id.'">'.$row_select->des_name.'</option>';
                                                else
                                                    echo '<option value="'.$row_select->des_id.'">'.$row_select->des_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Note : </label>
                                    <div class="form-group">
                                        <textarea name="txt_note" id="textarea" class="form-control" rows="4"><?= $row_old->note; ?></textarea>
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
                                <button type="submit" name="btn_update_close" class="btn yellow"><i class="fa fa-save fa-fw"></i>Update & Close</button>
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
    // $('input[name=txt_amo_debit]').parents('div[class="col-xs-12 col-sm-6 col-md-6 col-lg-6"]').hide();
    // $('input[name=txt_amo_credit]').parents('div[class="col-xs-12 col-sm-6 col-md-6 col-lg-6"]').hide();

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

    setTimeout(function () {
        $('input[name=txt_tran_amo]').keyup();
        $('select[name=cbo_tran_to]').change();
    },100);
});
</script>
<?php include_once '../layout/footer.php' ?>