<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    $sent_id = @$_GET['sent_id'];
    $old_data = $connect->query("SELECT * FROM tbl_acc_request_form AS A
                            LEFT JOIN tbl_acc_request_name_list AS B ON A.req_request_name=B.res_id 
                            LEFT JOIN tbl_acc_position AS C ON A.req_position=C.po_id
                            LEFT JOIN tbl_acc_prepare_name_list AS D ON A.req_prepare_by=D.pren_id
                            LEFT JOIN tbl_acc_check_name_list AS E ON A.req_check_by=E.chn_id
                            LEFT JOIN tbl_acc_approved_name_list AS F ON A.req_approved_by=F.apn_id
     WHERE A.req_id='$sent_id'");
    $row = mysqli_fetch_object($old_data);
 ?>


<div class="portlet light bordered">
    <br>
    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-1">
                <div class="caption font-dark">
                    <a href="index.php" id="sample_editable_1_new" class="btn red"> 
                        <i class="fa fa-arrow-left"></i>
                        Back
                    </a>
                </div>
            </div>
            <div class="col-xs-1">
                <div class="caption font-dark">
                    <a href="print.php?sent_id=<?= $sent_id; ?>" id="sample_editable_1_new" class="btn btn-info"> 
                        <i class="fa fa-print"></i>
                        Print
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="padding: 0 15px;">
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="border: 1px #C5BCBC solid;">
            <h5>Request Name: <?= $row->res_name ?></h5>
            <h5>Number: <?= $row->req_number ?></h5>
            <h5>Position: <?= $row->po_name ?></h5>
        </div>
         <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 pull-right">
            <h3>Date: <?= date("D d-M-Y",strtotime($row->req_date)) ?></h3>
        </div>
    </div>
    
    <br>

    <div class="portlet-body">
        <div class="bs-example" data-example-id="bordered-table">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                       <th class="text-center">N&deg;</th>
                       <th class="text-center">Item Name</th>
                       <th class="text-center">Unit</th>
                       <th class="text-center">Qty</th>
                       <th class="text-center">Price</th>
                       <th class="text-center">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $total_amo=0;
                        $get_data=$connect->query("SELECT * FROM tbl_acc_request_item AS A LEFT JOIN tbl_acc_request_form AS B ON A.rei_number=B.req_id
                            LEFT JOIN  tbl_acc_unit_list AS C ON A.rei_unit=C.uni_id
                            WHERE rei_number='$sent_id'");
                        $i = 0;
                        while ($row_select = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td class="text-center">'.(++$i).'</td>';
                                echo '<td class="text-center">'.$row_select->rei_item_name.'</td>';
                                echo '<td class="text-center">'.$row_select->uni_name.'</td>';
                                echo '<td class="text-center">'.number_format($row_select->rei_qty,0.3).'</td>';
                                echo '<td class="text-center">'.number_format($row_select->rei_price,2).' $</td>';
                                echo '<td class="text-center">'.number_format($row_select->rei_qty*$row_select->rei_price,2).' $</td>';
                            echo '</tr>';
                            $total_amo+=$row_select->rei_qty*$row_select->rei_price;
                        }
                    ?>
                </tbody>
                <tfoot>
                    <th style="visibility: hidden;"></th>
                    <th style="visibility: hidden;"></th>
                    <th style="visibility: hidden;"></th>
                    <th style="visibility: hidden;"></th>
                    <th class="text-center">Total Amount :</th>
                    <th class="text-center"><strong><?= number_format($total_amo,3) ?> $</strong></th>
                </tfoot>
            </table>

            <div class="row" style="padding: 0 15px;">
                <div class="col-xs-4 border text-center" style=" border: 1px #C5BCBC solid;">
                    <h5>Prepare By</h5>
                    <br>
                    <br>
                    <br>
                    <h5><strong><?= $row->pren_name ?></strong></h5>
                </div>
                 <div class="col-xs-4 border text-center" style=" border: 1px #C5BCBC solid;">
                    <h5>Check By</h5>
                    <br>
                    <br>
                    <br>
                    <h5><strong><?= $row->chn_name ?></strong></h5>
                </div>
                 <div class="col-xs-4 border text-center" style=" border: 1px #C5BCBC solid;">
                    <h5>Approved By</h5>
                    <br>
                    <br>
                    <br>
                    <h5><strong><?= $row->apn_name ?></strong></h5>
                </div>
            </div>
        </div>
    </div>
</div>





<?php include_once '../layout/footer.php' ?>
