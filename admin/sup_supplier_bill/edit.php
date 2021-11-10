<?php 
    $menu_active =130;
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
        $v_inv_numver = @$_POST['txt_invoice_number'];
        $v_supplier = @$_POST['txt_supplier'];
        $v_project = @$_POST['txt_project'];
        $v_site = @$_POST['txt_site'];
        $v_location = @$_POST['txt_location'];
        $v_amount = @$_POST['txt_amount'];
        $v_pay_amount = @$_POST['txt_pay_amount'];
        $v_balance_amount = @$_POST['txt_balance_amount'];
        $v_step_payment = @$_POST['txt_step_payment'];
        $v_percentage = @$_POST['txt_percentage'];
        $v_note = @$_POST['txt_note'];
        $v_user_id = @$_SESSION['user']->user_id;
        
       
        $query_update = "UPDATE `tbl_sup_bill` 
            SET 
                `supb_date_record`='$v_date_record',
                `supb_invoice_no`='$v_inv_numver',
                `supb_supplier_id`='$v_supplier',
                `supb_project`='$v_project',
                `supb_site`='$v_site',
                `supb_location`='$v_location',
                `supb_amount`='$v_amount',
                `supb_pay_amount`='$v_pay_amount',
                `supb_balance_amount`='$v_balance_amount',
                `supb_step_payment`='$v_step_payment',
                `supb_percent`='$v_percentage',
                `supb_note`='$v_note',
                `user_id`='$v_user_id'
            WHERE `supb_id`='$v_id'";
            
       
        if($connect->query($query_update)){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data update ...
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
    $old_data = $connect->query("SELECT * FROM tbl_sup_bill WHERE supb_id='$edit_id'");
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
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->supb_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Date Record : </label>
                                    <input type="text" class="form-control datepicker" data-date-format="yyyy-mm-dd" data-provide="datepicker" name="txt_date_record"  autocomplete="off" placeholder="choose date" required="" value="<?= $row_old_data->supb_date_record ?>">
                                </div>
                                <div class="form-group">
                                    <label>Bill Number : </label>
                                    <input type="text" class="form-control datepicker" name="txt_invoice_number"  autocomplete="off" required="" value="<?= $row_old_data->supb_invoice_no ?>">
                                </div>
                                <div class="form-group">
                                    <label>Supplier Name : </label>
                                    <select class="form-control datepicker" name="txt_supplier"  autocomplete="off" required="">
                                        <option value="">==choose supplier==</option>
                                        <?php
                                            $get_supplier=$connect->query("SELECT * FROM tbl_sup_supplier_info ORDER BY supsi_name ASC");
                                            while ($row_supplier=mysqli_fetch_object($get_supplier)) {
                                                if($row_supplier->supsi_id == $row_old_data->supb_supplier_id){
                                                    echo '<option SELECTED value="'.$row_supplier->supsi_id.'">'.$row_supplier->supsi_name.'</option>';
                                                    
                                                }else{
                                                    echo '<option value="'.$row_supplier->supsi_id.'">'.$row_supplier->supsi_name.'</option>';

                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Project : </label>
                                    <select class="form-control datepicker" name="txt_project"  autocomplete="off" required="">
                                        <option value="">==choose project==</option>
                                        <?php
                                            $get_project=$connect->query("SELECT * FROM tbl_sup_project ORDER BY suppro_name ASC");
                                            while ($row_project=mysqli_fetch_object($get_project)) {
                                                if($row_project->suppro_id == $row_old_data->supb_project){
                                                    echo '<option SELECTED value="'.$row_project->suppro_id.'">'.$row_project->suppro_name.' :: '.$row_project->suppro_code.'</option>';
                                                    
                                                }else{
                                                    echo '<option value="'.$row_project->suppro_id.'">'.$row_project->suppro_name.' :: '.$row_project->suppro_code.'</option>';

                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Site : </label>
                                    <input type="text" class="form-control datepicker" name="txt_site"  autocomplete="off" required="" value="<?= $row_old_data->supb_site ?>">
                                </div>
                                <div class="form-group">
                                    <label>Location : </label>
                                    <input type="text" class="form-control datepicker" name="txt_location"  autocomplete="off" required="" value="<?= $row_old_data->supb_location ?>">
                                </div>
                               
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Amount : </label>
                                    <input type="text" class="form-control datepicker" name="txt_amount"  autocomplete="off" required="" value="<?= $row_old_data->supb_amount ?>">
                                </div>
                                <div class="form-group">
                                    <label>Pay Amount : </label>
                                    <input type="text" class="form-control datepicker" name="txt_pay_amount"  autocomplete="off" required="" value="<?= $row_old_data->supb_pay_amount ?>">
                                </div>
                                <div class="form-group">
                                    <label>Balance Amount : </label>
                                    <input type="text" class="form-control datepicker" name="txt_balance_amount"  autocomplete="off" required="" value="<?= $row_old_data->supb_balance_amount ?>">
                                </div>
                                <div class="form-group">
                                    <label>Step Payment : </label>
                                    <select class="form-control" name="txt_step_payment"  autocomplete="off" required="">
                                        <option value="">==choose payment step==</option>
                                        <?php
                                            $get_sp=$connect->query("SELECT * FROM tbl_sup_step_payment ORDER BY supp_name ASC");
                                            while ($row_sp=mysqli_fetch_object($get_sp)) {
                                                if($row_sp->supp_id == $row_old_data->supb_step_payment){
                                                    echo '<option SELECTED value="'.$row_sp->supp_id.'">'.$row_sp->supp_name.'</option>';
                                                    
                                                }else{
                                                    echo '<option value="'.$row_sp->supp_id.'">'.$row_sp->supp_name.'</option>';

                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Percent : </label>
                                    <input type="text" class="form-control" name="txt_percentage"  autocomplete="off" required="" value="<?= $row_old_data->supb_percent ?>">
                                </div>
                                <div class="form-group">
                                    <label>Note : </label>
                                    <input type="text" style="height: 105px;" class="form-control" name="txt_note"  autocomplete="off" value="<?= $row_old_data->supb_note ?>">
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



<?php include_once '../layout/footer.php' ?>
