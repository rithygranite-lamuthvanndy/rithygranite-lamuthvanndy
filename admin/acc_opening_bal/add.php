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
        $v_date_record= @$_POST['txt_date_record'];
        $v_chart_acc = @$_POST['cbo_chart_acc'];
        $v_des = @$_POST['txt_des'];
        $v_debit = @$_POST['txt_debit'];
        $v_credit = @$_POST['txt_credit'];
        $query_add = "INSERT INTO tbl_acc_add_tran_amount (
                p_appr,
                date_record,
                ref_id,
                status_type,
                name,
                user_id,
                date_audit
                ) 
            VALUES
                (
                '1',
                '$v_date_record',
                '',
                '5',
                '$user_id',
                '$v_credit',
                '$now'
                )
                ";

        if($connect->query($query_add)){
            $v_last_id=$connect->insert_id;
            $query_add = "INSERT INTO tbl_acc_add_tran_amount_detail (
                main_id,
                status,
                description,
                acc_id,
                debit,
                credit
                ) 
            VALUES
                (
                '$v_last_id',
                '1',
                '$v_des',
                '$v_chart_acc',
                '$v_debit',
                '$v_credit'
                )
                ";
            if($connect->query($query_add)){
                $query_add = "INSERT INTO tbl_acc_add_tran_amount_detail (
                    main_id,
                    status,
                    description,
                    acc_id,
                    debit,
                    credit,
                    parent_id
                    ) 
                VALUES
                    (
                    '$v_last_id',
                    '0',
                    '',
                    '413',
                    '".(($v_credit)?($v_credit):(0))."',
                    '".(($v_debit)?($v_debit):(0))."',
                    '".$connect->insert_id."'
                    )
                    ";
                $connect->query($query_add);
            }
           echo '<script>myAlertSuccess("Add")</script>';
        }else{
           echo '<script>myAlertError("Add")</script>';
        }
    }
    else if(isset($_POST['btn_submit_close'])){
        $v_date_record= @$_POST['txt_date_record'];
        $v_chart_acc = @$_POST['cbo_chart_acc'];
        $v_des = @$_POST['txt_des'];
        $v_debit = @$_POST['txt_debit'];
        $v_credit = @$_POST['txt_credit'];
        $query_add = "INSERT INTO tbl_acc_add_tran_amount (
                p_appr,
                date_record,
                ref_id,
                status_type,
                name,
                user_id,
                date_audit
                ) 
            VALUES
                (
                '1',
                '$v_date_record',
                '',
                '5',
                '$user_id',
                '$v_credit',
                '$now'
                )
                ";

        if($connect->query($query_add)){
            $v_last_id=$connect->insert_id;
            $query_add = "INSERT INTO tbl_acc_add_tran_amount_detail (
                main_id,
                status,
                description,
                acc_id,
                debit,
                credit
                ) 
            VALUES
                (
                '$v_last_id',
                '1',
                '$v_des',
                '$v_chart_acc',
                '$v_debit',
                '$v_credit'
                )
                ";
            if($connect->query($query_add)){
                $query_add = "INSERT INTO tbl_acc_add_tran_amount_detail (
                    main_id,
                    status,
                    description,
                    acc_id,
                    debit,
                    credit,
                    parent_id
                    ) 
                VALUES
                    (
                    '$v_last_id',
                    '0',
                    '',
                    '4',
                    '".(($v_credit)?($v_credit):(0))."',
                    '".(($v_debit)?($v_debit):(0))."',
                    '".$connect->insert_id."'
                    )
                    ";
                $connect->query($query_add);
            }
            header('location: index.php?status=close');
           // echo '<script>myAlertSuccess("Add")</script>';
        }else{
           echo '<script>myAlertError("Add")</script>';
        }
    }

 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2>
                <i class="fa fa-plus-circle fa-fw"></i>Create Add Record 
            </h2>
        </div>
    </div>
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
                                    <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control date" required name="txt_date_record" value="<?= date('Y-m-d') ?>">
                                </div>
                                <div class="form-group">
                                    <label>Chart Of Account Name : </label>
                                    <select name="cbo_chart_acc" id="input" class="form-control myselect2" required="required">
                                        <option>=== Select and Choose here ===</option>
                                        <?php 
                                            $sql=$connect->query("SELECT * FROM  tbl_acc_chart_account ORDER BY accca_number ASC");
                                            while ($row=mysqli_fetch_object($sql)) {
                                                echo '<option value="'.$row->accca_id.'">'.$row->accca_number.' :: '.$row->accca_account_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Description : </label>
                                        <textarea id="input" name="txt_des" class="form-control" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Debit : </label>
                                    <input type="number" step="0.01" class="form-control" value="0.00" required name="txt_debit">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Credit : </label>
                                    <input type="number" step="0.01" class="form-control" value="0.00" required name="txt_credit">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Balance : </label>
                                    <input type="text" class="form-control" value="0.00" name="txt_bal" readonly="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <a href="index.php" class="btn yellow"><i class="fa fa-print"></i>Print</a>
                                <button type="submit" name="btn_submit" class="btn green"><i class="fa fa-save fa-fw"></i>Save & New</button>
                                <button type="submit" name="btn_submit_close" class="btn blue"><i class="fa fa-close"></i>Save & Close</button>
                                <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>
    
<?php include_once '../layout/footer.php' ?>
<script>
    $('input[name=txt_credit],input[name=txt_debit]').keyup(function () {
        var debit=$('input[name=txt_debit]').val();
        var credit=$('input[name=txt_credit]').val();
        $('input[name=txt_bal]').val(debit-credit);
    });
</script>
