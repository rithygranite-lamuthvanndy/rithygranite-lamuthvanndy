<?php 
    $menu_active =120;
    $left_active =0;
    $layout_title = "Welcome to Setting Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
    $cus_inv_id = @$_GET['alert_id'];


    // add 
        if(isset($_POST['btn_submit'])){
        $v_date_record = @$_POST['txt_date'];
        $v_note = @$_POST['txt_note'];
        

        $query_add = "INSERT INTO tbl_cus_invoice_alert (
                cusia_date_alert,
                cusia_invoice_no,
                cusia_note
                
                ) 
            VALUES(
                '$v_date_record',
                '$cus_inv_id',
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
        header('location: alert.php?alert_id='.$cus_inv_id);
    }


    // delete
    if(@$_GET['del_id'] != ""){
        $del_id = @$_GET['del_id'];
        $connect->query("DELETE FROM tbl_cus_invoice_alert WHERE cusia_id='$del_id'");
        header('location: alert.php?alert_id='.$cus_inv_id);
    }

?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Customer Invoice Alert</h2>
        </div>
    </div>
    <br>
    <div class="">
        <div class="caption font-dark">
            <a  data-toggle="modal" href='#modal_add_alert' class="btn green"> Add New
                <i class="fa fa-plus"></i>
            </a>
            <a href='index.php' class="btn red"> 
                <i class="fa fa-arrow-left"></i>
                Back
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
                        <th>Description</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT  * FROM tbl_cus_invoice_alert AS A 
                            LEFT JOIN tbl_cus_invoice AS B ON B.cusin_id=A.cusia_invoice_no WHERE cusia_invoice_no='$cus_inv_id' ORDER BY cusia_date_alert DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->cusia_date_alert.'</td>';
                                echo '<td>'.$row->cusin_invoice_no.'</td>';
                                echo '<td>'.$row->cusia_note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="alert.php?del_id='.$row->cusia_id.'&alert_id='.$cus_inv_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

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
<div class="modal fade" id="modal_add_alert">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add Alert</h4>
            </div>
            <div class="modal-body">
                <form action="" method="POST" role="form" id="form_add_alert">
                    <div class="form-group">
                        <label for="">Date Alert</label>
                        <input type="text" name="txt_date" class="form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" id="" placeholder="choose date" autocomplete="off">
                    </div>
                
                    <div class="form-group">
                        <label for="">Alert Note</label>
                        <textarea name="txt_note" class="form-control" rows="5" autocomplete="off"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="sunmit" class="btn btn-primary" form="form_add_alert" name="btn_submit">Save changes</button>
            </div>
        </div>
    </div>
</div>