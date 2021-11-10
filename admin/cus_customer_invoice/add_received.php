<?php 
    $menu_active =120;
    $left_active =0;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        $v_date_record = @$_POST['txt_date_record'];
        $v_inv_numver = @$_POST['txt_invoice_number'];
        $v_project = @$_POST['txt_project'];
        $v_site = @$_POST['txt_site'];
        $v_location = @$_POST['txt_location'];
        $v_amount = @$_POST['txt_amount'];
        $v_step_payment = @$_POST['txt_step_payment'];
        $v_percentage = @$_POST['txt_percentage'];
        $v_note = @$_POST['txt_note'];
        $v_user_id = @$_SESSION['user']->user_id;
        

        $query_add = "INSERT INTO tbl_cus_invoice (
                cusin_date_record,
                cusin_invoice_no,
                cusin_project,
                cusin_site,
                cusin_location,
                cusin_amount,
                cusin_step_payment,
                cusin_percent,
                cusin_note,
                user_id
                
                ) 
            VALUES(
                '$v_date_record',
                '$v_inv_numver',
                '$v_project',
                '$v_site',
                '$v_location',
                '$v_amount',
                '$v_step_payment',
                '$v_percentage',
                '$v_note',
                '$v_user_id'
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
                 <form action="#" method="post" enctype="multipart/form-data">
                    <div class="form-body">


                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Date Record : </label>
                                    <input type="text" class="form-control datepicker" data-date-format="yyyy-mm-dd" data-provide="datepicker" name="txt_date_record"  autocomplete="off" placeholder="choose date" required="">
                                </div>
                                <div class="form-group">
                                    <label>Invoice Number : </label>
                                    <input type="text" class="form-control datepicker" name="txt_invoice_number"  autocomplete="off" required="">
                                </div>
                                <div class="form-group">
                                    <label>Project : </label>
                                    <select class="form-control datepicker" name="txt_project"  autocomplete="off" required="">
                                        <option value="">==choose project==</option>
                                        <?php
                                            $get_project=$connect->query("SELECT * FROM tbl_cus_project ORDER BY cuspro_name ASC");
                                            while ($row_project=mysqli_fetch_object($get_project)) {
                                                echo '<option value="'.$row_project->cuspro_id.'">'.$row_project->cuspro_name.' :: '.$row_project->cuspro_code.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Site : </label>
                                    <input type="text" class="form-control datepicker" name="txt_site"  autocomplete="off" required="">
                                </div>
                                <div class="form-group">
                                    <label>Location : </label>
                                    <input type="text" class="form-control datepicker" name="txt_location"  autocomplete="off" required="">
                                </div>
                                
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Amount : </label>
                                    <input type="text" class="form-control datepicker" name="txt_amount"  autocomplete="off" required="">
                                </div>
                                <div class="form-group">
                                    <label>Step Payment : </label>
                                    <select class="form-control" name="txt_step_payment"  autocomplete="off" required="">
                                        <option value="">==choose payment step==</option>
                                        <?php
                                            $get_sp=$connect->query("SELECT * FROM tbl_cus_step_payment ORDER BY cuspro_name ASC");
                                            while ($row_sp=mysqli_fetch_object($get_sp)) {
                                                echo '<option value="'.$row_sp->cuspro_id.'">'.$row_sp->cuspro_name.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Percent : </label>
                                    <input type="text" class="form-control" name="txt_percentage"  autocomplete="off" required="">
                                </div>
                                <div class="form-group">
                                    <label>Note : </label>
                                    <input type="text" style="height: 105px;" class="form-control" name="txt_note"  autocomplete="off" >
                                </div>
                            </div>
                        </div>

                        
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-6 text-center">
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


<?php include_once '../layout/footer.php' ?>
