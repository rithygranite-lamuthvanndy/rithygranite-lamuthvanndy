<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
    if(isset($_POST['btn_submit'])){
        $v_id= @$_POST['txt_id'];
        $v_date_record= @$_POST['txt_date_record'];
        $v_chart_acc = @$_POST['cbo_chart_acc'];
        $v_des = @$_POST['txt_des'];
        $v_debit = @$_POST['txt_debit'];
        $v_credit = @$_POST['txt_credit'];  

        $stm="UPDATE tbl_acc_add_tran_amount SET 
        date_record='$v_date_record'
        WHERE id=(SELECT main_id FROM  tbl_acc_add_tran_amount_detail WHERE id=$v_id)
        ";
        $connect->query($stm);
        // exit();
        $query_add = "UPDATE tbl_acc_add_tran_amount_detail SET
                description='$v_des',
                acc_id='$v_chart_acc',
                debit='$v_debit',
                credit='$v_credit'
                WHERE id='$v_id'";
            $connect->query($query_add);
        // ================
        $query_add = "UPDATE tbl_acc_add_tran_amount_detail SET
                acc_id='413',
                debit='".(($v_credit)?($v_credit):(0))."',
                credit='".(($v_debit)?($v_debit):(0))."'
                WHERE parent_id='$v_id'";
        if($connect->query($query_add)){
           echo '<script>myAlertSuccess("Edit")</script>';
        }else{
           echo '<script>myAlertError("Syntax Error.....")</script>';
        }
    }
    $v_id=@$_GET['edit_id'];
    $sql_old=$connect->query("SELECT A.*,B.date_record AS open_date FROM tbl_acc_add_tran_amount_detail AS A 
    LEFT JOIN tbl_acc_add_tran_amount AS B ON A.main_id=B.id 
    WHERE A.id='$v_id'");
    $row_old=mysqli_fetch_object($sql_old);
 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2>
                <i class="fa fa-plus-circle fa-fw"></i>Edit Record 
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
                                <input type="hidden" name="txt_id" value="<?= @$v_id; ?>">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Date : </label>
                                    <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control date" required name="txt_date_record" value="<?= $row_old->open_date ?>">
                                </div>
                                <div class="form-group">
                                    <label>Chart Of Account Name : </label>
                                    <select name="cbo_chart_acc" id="input" class="form-control myselect2" required="required">
                                        <option>=== Select and Choose here ===</option>
                                        <?php 
                                            $sql=$connect->query("SELECT * FROM  tbl_acc_chart_account ORDER BY accca_number ASC");
                                            while ($row=mysqli_fetch_object($sql)) {
                                                if($row_old->acc_id==$row->accca_id)
                                                    echo '<option SELECTED value="'.$row->accca_id.'">'.$row->accca_number.' :: '.$row->accca_account_name.'</option>';
                                                else
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
                                        <textarea id="input" name="txt_des" class="form-control" rows="5" required="required"><?= $row_old->description ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Debit : </label>
                                    <input type="number" step="0.01" class="form-control" value="<?= $row_old->debit ?>" required name="txt_debit">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Credit : </label>
                                    <input type="number" step="0.01" class="form-control" value="<?= $row_old->credit ?>" required name="txt_credit"">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Balance : </label>
                                    <input type="text" class="form-control" value="<?= ($row_old->debit-$row_old->credit) ?>" name="txt_bal" readonly="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_submit" class="btn green"><i class="fa fa-save fa-fw"></i>Save Change</button>
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