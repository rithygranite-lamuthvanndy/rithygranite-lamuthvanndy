<?php 
    $menu_active =120;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
    $v_cus_inv_id = @$_GET['sent_id'];

    if(isset($_POST['btn_submit'])){
        $v_date_record = @$_POST['txt_date_record'];
        $v_amount = @$_POST['txt_amount'];
        $v_step_payment = @$_POST['txt_step_payment'];
        $v_note = @$_POST['txt_note'];
        

        $query_add = "INSERT INTO tbl_cus_receipt (
                cusre_date_record,
                cusre_invoice_no,
                cusre_received_amount,
                cusre_step_payment,
                cusre_note
                
                ) 
            VALUES(
                '$v_date_record',
                '$v_cus_inv_id',
                '$v_amount',
                '$v_step_payment',
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
    if(isset($_POST['btn_update'])){
        $v_id = @$_POST['txt_id'];
        $v_date_record = @$_POST['txt_date_record'];
        $v_amount = @$_POST['txt_amount'];
        $v_step_payment = @$_POST['txt_step_payment'];
        $v_note = @$_POST['txt_note'];
        

        $query_update = "UPDATE tbl_cus_receipt SET 
                cusre_date_record='$v_date_record',
                cusre_received_amount='$v_amount',
                cusre_step_payment='$v_step_payment',
                cusre_note='$v_note' 
                WHERE cusre_id='$v_id'";

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




    if(@$_GET['del_id'] != ""){
        $del_id = @$_GET['del_id'];
        $connect->query("DELETE FROM tbl_cus_receipt WHERE cusre_id='$del_id'");
    }
 ?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Received Payment</h2>
        </div>
    </div>
    <br>
    <div class="">
        <div class="caption font-dark">
            <a  data-toggle="modal" href='#modal-id' id="sample_editable_1_new" class="btn green">
                <i class="fa fa-plus"></i>
            </a>
            <a href="index.php" id="sample_editable_1_new" class="btn red">
                <i class="fa fa-undo"></i>
            </a>
        </div>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Date Record</th>
                        <th>Invoice Number</th>
                        <th>Received Amount</th>
                        <th>Step Payment</th>
                        <th>Attatch File</th>
                        <th>Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $get_data = $connect->query("SELECT * FROM tbl_cus_receipt AS A
                            LEFT JOIN tbl_cus_invoice AS CI ON A.cusre_invoice_no=CI.cusin_id
                            LEFT JOIN tbl_cus_step_payment AS C ON C.cuspro_id=A.cusre_step_payment
                            WHERE A.cusre_invoice_no='$v_cus_inv_id'
                            ORDER BY cusre_id DESC");
                        $i = 0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->cusre_date_record.'</td>';
                                echo '<td>'.$row->cusre_invoice_no.'</td>';
                                echo '<td class="text-center">$ '.number_format($row->cusre_received_amount,2).'</td>';
                                echo '<td>'.$row->cuspro_name.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="upload_received.php?up_id='.$row->cusre_id.'&old_file='.$row->cusre_attach_file.'&sent_id='.$v_cus_inv_id.'" class="text-danger" title="upload"><i class="fa fa-upload fa-fw"></i></a>';
                                    if($row->cusre_attach_file != ""){
                                        echo ' | <a href="../../file/file_customer_invoice/'.$row->cusre_attach_file.'" target="_blank" title="download"><i class="fa fa-download fa-fw"></i></a>';
                                        
                                    }else{
                                        echo ' | <a class="text-default"><i class="fa fa-download fa-fw"></i></a>';
                                    }
                                echo '</td>';
                                echo '<td>'.$row->cusre_note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a data-toggle="modal" href="#modal_edit'.$i.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                    // echo '<a href="index_received.php?del_id='.$row->cusre_id.'&del_img='.$row->cusre_attach_file.'&sent_id='.$v_cus_inv_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>






<?php include_once '../layout/footer.php' ?>

<!-- add form -->
<div class="modal fade" id="modal-id">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add Receipt</h4>
            </div>
            <div class="modal-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Date Record : </label>
                                    <input type="text" class="form-control datepicker" data-date-format="yyyy-mm-dd" data-provide="datepicker" name="txt_date_record"  autocomplete="off" placeholder="choose date" required="" value="<?= date('Y-m-d') ?>">
                                </div>
                                <div class="form-group sr-only">
                                    <label>Invoice Number : </label>
                                    <input type="text" class="form-control datepicker" readonly value="<?= $v_cus_inv_id ?>" name="txt_invoice_number"  autocomplete="off" required="">
                                </div>
                                <div class="form-group">
                                    <label>Received Amount : </label>
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
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Note : </label>
                                    <input type="text" style="height: 105px;" class="form-control" name="txt_note"  autocomplete="off" >
                                </div>
                            </div>
                        </div>

                        
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-6 text-left">
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

<!-- edit  form-->
<?php 
    $i = 0;
    $get_data = $connect->query("SELECT * FROM tbl_cus_receipt AS A
        LEFT JOIN tbl_cus_invoice AS CI ON A.cusre_invoice_no=CI.cusin_id
        LEFT JOIN tbl_cus_step_payment AS C ON C.cuspro_id=A.cusre_step_payment
        WHERE A.cusre_invoice_no='$v_cus_inv_id'
        ORDER BY cusre_id DESC");
    while ($row = mysqli_fetch_object($get_data)) {
        $i++;
        ?>
        <div class="modal fade" id="modal_edit<?= $i ?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Edit Receipt</h4>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post" enctype="multipart/form-data">
                            <input type="hidden" value="<?= $row->cusre_id ?>" name="txt_id"/>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Date Record : </label>
                                            <input type="text" class="form-control datepicker" data-date-format="yyyy-mm-dd" data-provide="datepicker" name="txt_date_record"  autocomplete="off" placeholder="choose date" required="" value="<?= $row->cusre_date_record ?>">
                                        </div>
                                        <div class="form-group sr-only">
                                            <label>Invoice Number : </label>
                                            <input type="text" class="form-control datepicker" readonly value="<?= $v_cus_inv_id ?>" name="txt_invoice_number"  autocomplete="off" required="" value="<?= $v_cus_inv_id ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Received Amount : </label>
                                            <input type="text" class="form-control datepicker" name="txt_amount" value="<?= $row->cusre_received_amount ?>" autocomplete="off" required="">
                                        </div>
                                        <div class="form-group">
                                            <label>Step Payment : </label>
                                            <select class="form-control" name="txt_step_payment"  autocomplete="off" required="">
                                                <option value="">==choose payment step==</option>
                                                <?php
                                                    $get_sp=$connect->query("SELECT * FROM tbl_cus_step_payment ORDER BY cuspro_name ASC");
                                                    while ($row_sp=mysqli_fetch_object($get_sp)) {
                                                        if($row_sp->cuspro_id == $row->cusre_step_payment)
                                                            echo '<option SELECTED value="'.$row_sp->cuspro_id.'">'.$row_sp->cuspro_name.'</option>';
                                                        else
                                                            echo '<option value="'.$row_sp->cuspro_id.'">'.$row_sp->cuspro_name.'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Note : </label>
                                            <input type="text" style="height: 105px;" class="form-control" name="txt_note"  autocomplete="off" value="<?= $row->cusre_note ?>">
                                        </div>
                                    </div>
                                </div>

                                
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-6 text-left">
                                        <button type="submit" name="btn_update" class="btn blue"><i class="fa fa-save fa-fw"></i>Save Change</button>
                                        <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form><br>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
?>