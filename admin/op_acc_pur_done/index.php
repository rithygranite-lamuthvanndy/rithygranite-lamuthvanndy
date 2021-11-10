<?php 
    $menu_active =13;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Purchase Done List</h2>
        </div>
    </div>
    <br>
    <!-- <div class="">
        <div class="caption font-dark">
            <a href="add.php" id="sample_editable_1_new" class="btn green"> Add New
                <i class="fa fa-plus"></i>
            </a>
        </div>
    </div> -->
    <br>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Date Record</th>
                        <th>Check Item</th>
                        <th>Number </th>
                        <th>Request Name</th>
                        <th>Position</th>
                        <th>Prepare By</th>
                        <th>Check By </th>
                        <th>Approved By </th>
                        <th>Manager Approved By</th>
                        <th>Manager Approved Date</th>
                        <th>Manager Approved Comment</th>
                        <!-- <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $get_data=$connect->query("SELECT * FROM tbl_acc_request_form AS A
                            LEFT JOIN tbl_acc_request_name_list AS B ON A.req_request_name=B.res_id 
                            LEFT JOIN tbl_acc_position AS C ON A.req_position=C.po_id
                            LEFT JOIN tbl_acc_prepare_name_list AS D ON A.req_prepare_by=D.pren_id
                            LEFT JOIN tbl_acc_check_name_list AS E ON A.req_check_by=E.chn_id
                            LEFT JOIN tbl_acc_approved_name_list AS F ON A.req_approved_by=F.apn_id
                         ORDER BY req_id DESC");
                        $i = 0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.date("D d-m-Y",strtotime($row->req_date)).'</td>';
                                echo '<td class="text-center">
                                    <a href="check.php?sent_id='.$row->req_id.'" title="Check">
                                        <i class="fa fa-check btn btn-xs btn-info"></i>
                                    </a>';
                                    if($row->man_app_by!=0){
                                    echo    '<a href="check.php?sent_id='.$row->req_id.'" title="Check">
                                        <i class="fa fa-check-circle btn-xs btn btn-success">Checked</i>
                                        </a>';
                                    }
                                echo '</td>';
                                echo '<td>'.$row->req_number.'</td>';
                                echo '<td>'.$row->res_name.'</td>';
                                echo '<td>'.$row->po_name.'</td>';
                                echo '<td>'.$row->pren_name.'</td>';
                                echo '<td>'.$row->chn_name.'</td>';
                                echo '<td>'.$row->apn_name.'</td>';
                                $sql=$connect->query("SELECT * 
                                    FROM tbl_acc_request_form AS A
                                    LEFT JOIN tbl_acc_approved_name_list AS B ON A.man_app_by=B.apn_id WHERE req_id='$row->req_id'");
                                $row_1=mysqli_fetch_object($sql);
                                echo '<td>'.$row_1->apn_name.'</td>';
                                echo '<td>'.$row->man_app_date.'</td>';
                                echo '<td>'.$row->man_app_comment.'</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>






<?php include_once '../layout/footer.php' ?>
