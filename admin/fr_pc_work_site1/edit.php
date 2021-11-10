<?php 
    $menu_active =13;
    $left_active =52;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>



<?php 
    if(isset($_POST['btn_submit'])){

        $v_id = @$_POST['txt_id'];
        $v_frpc_no = @$_POST['txt_frpc_no'];
        $v_date = @$_POST['txt_date'];
        $v_disc = @$_POST['txt_disc'];
        $v_qty = @$_POST['txt_qty'];
        $v_un_pr = @$_POST['txt_un_pc'];
        $v_amount = @$_POST['txt_amount'];
        $v_note = @$_POST['txt_note'];
        $query_update = "UPDATE `tbl_fr_pc_expense` 
            SET 
                `frpc_no`='$v_frpc_no',
                `frpc_date`='$v_date',
                `frpc_description`='$v_disc',
                `frpc_qty`='$v_qty',
                `frpc_unit_price`='$v_un_pr',
                `frpc_amount`='$v_amount',
                `frpc_note`='$v_note'
            WHERE `frpc_id`='$v_id'";
            
        if($connect->query($query_update)){
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
    // get old data 
    $edit_id = @$_GET['edit_id'];
    $old_data = $connect->query("SELECT * FROM tbl_fr_pc_expense WHERE frpc_id='$edit_id'");
    $row_old_data = mysqli_fetch_object($old_data);

 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Edit Record (FR/PC)</h2>
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
                 <form action="#" method="post" enctype="multipart/form-data">
                     <input type="hidden" name="txt_id" value="<?= $row_old_data->frpc_id ?>">
                    <div class="form-body">

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>FR/PC No : </label>
                                    <input type="text" class="form-control" name="txt_frpc_no" value="<?= $row_old_data->frpc_no ?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <label>Date : </label>
                                <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" required name="txt_date" value="<?= $row_old_data->frpc_date ?>">
                                        
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Description : </label>
                                    <input type="text" class="form-control" name="txt_disc" value="<?= $row_old_data->frpc_description ?>" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <label>QTY : </label> 
                                <input type="text" class="form-control" name="txt_qty" value="<?= $row_old_data->frpc_qty ?>" autocomplete="off">        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <label>Unit Price : </label> 
                                <input type="text" class="form-control" name="txt_un_pc" value="<?= $row_old_data->frpc_unit_price ?>" autocomplete="off">        
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Amount (USD) : </label>
                                    <input type="text" step="0.00" class="form-control" name="txt_amount" value="<?= $row_old_data->frpc_amount ?>" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Note : </label>
                                    <textarea type="text" class="form-control" name="txt_note" rows="5"  autocomplete="off"><?= $row_old_data->frpc_note ?></textarea>
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



<script type="text/javascript" src="../../plugin/ckeditor_4.7.0_full/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace( 'detail', {
        language: 'en',
      height: '700'
        // uiColor: '#9AB8F3'
    });
</script>


<?php include_once '../layout/footer.php' ?>
