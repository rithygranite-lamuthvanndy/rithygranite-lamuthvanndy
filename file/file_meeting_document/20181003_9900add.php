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
        $v_date_record = @$_POST['txt_date_record'];
        $v_time = @$_POST['txt_time'];
        $v_invoice_no = @$_POST['txt_invoice_no'];
        $v_name = @$_POST['txt_name'];
        $v_description = @$_POST['txt_description'];
        $v_cash_in = @$_POST['txt_cash_in'];
        $v_cash_out = @$_POST['txt_cash_out'];
        $v_balance = @$_POST['txt_balance'];
        $v_note = @$_POST['txt_note'];

        $query_add = "INSERT INTO tbl_acc_cash_record (
                accdr_date,
                accdr_time,
                accdr_invoice_no,
                accdr_name,
                accdr_description,
                accdr_cash_in,
                accdr_cash_out,
                accdr_balance,
                accdr_note
                ) 
            VALUES
                (
                '$v_date_record',
                '$v_time',
                '$v_invoice_no',
                '$v_name',
                '$v_description',
                '$v_cash_in',
                '$v_cash_out',
                '$v_balance',
                '$v_note'
                )";

        if($connect->query($query_add)){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data inserted ...
            </div>'; 
        }else{
            $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> Query error ...
            </div>';   
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
                                    <label>Time : </label>
                                    <input type="text" class="form-control" required name="txt_time">
                                </div>
                                <div class="form-group">
                                    <label>Invoice No : </label>
                                    <input type="text" class="form-control" required name="txt_invoice_no">
                                </div>
                                <div class="form-group">
                                    <label>Name : </label>
                                    <input type="text" class="form-control" required name="txt_name">
                                </div>
                                <div class="form-group">
                                    <label>Description : </label>
                                    <input type="text" class="form-control" required name="txt_description">
                                </div>

                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Cash In : </label>
                                    <input type="text" class="form-control" required name="txt_cash_in" value="0">
                                </div>
                                <div class="form-group">
                                    <label>Cash Out : </label>
                                    <input type="text" class="form-control" required name="txt_cash_out" value="0">
                                </div>
                                <div class="form-group">
                                    <label>Balance : </label>
                                    <input type="text" class="form-control" required name="txt_balance" value="0">
                                </div>
                                <div class="form-group">
                                    <label>Note : </label>
                                    <textarea class="form-control" style="height: 108px" autocomplete="off" name="txt_note"></textarea>
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
</script>
<?php include_once '../layout/footer.php' ?>
