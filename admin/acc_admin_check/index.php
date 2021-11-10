<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Admin Check</h2>
        </div>
    </div>
    <br>
    <div class="">
        <div class="caption font-dark">
            <a href="add.php" id="sample_editable_1_new" class="btn green"> Add New
                <i class="fa fa-plus"></i>
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
                        <th>Date Request</th>
                        <th>Request No</th>
                        <th>Department RGC</th>
                        <th>Type of Request</th>
                        <th>Request By</th>
                        <th>Approved By</th>
                        <th>Amount Request</th>
                        <th>Location Buy</th>
                        <th>Responsible Purchase</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                               *
                            FROM   tbl_acc_admin_check_list AS A
                            LEFT JOIN tbl_acc_request_name_list AS B ON A.ch_request_by=B.res_id
                            LEFT JOIN tbl_acc_location_buy_list AS C ON A.ch_location_buy=C.locb_id
                            LEFT JOIN tbl_acc_response_purchase_list AS D ON A.ch_responsible_purchase=D.resp_id
                            LEFT JOIN tbl_acc_request_form AS E ON A.ch_request_no=E.req_id
                            LEFT JOIN tbl_acc_department_list AS F ON A.ch_department=F.dep_id
                            LEFT JOIN tbl_acc_type_request_list AS G ON A.ch_type_request=G.typr_id
                            LEFT JOIN tbl_acc_approved_name_list AS H ON A.ch_approved_by=H.apn_id
                            ORDER BY ch_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.date("D d-M-Y",strtotime($row->ch_date_request)).'</td>';
                                echo '<td>'.$row->req_number.'</td>';
                                echo '<td>'.$row->dep_name.'</td>';
                                echo '<td>'.$row->typr_name.'</td>';
                                echo '<td>'.$row->res_name.'</td>';
                                echo '<td>'.$row->apn_name.'</td>';
                                echo '<td>'.$row->ch_amount_request.'</td>';
                                echo '<td>'.$row->locb_name.'</td>';
                                echo '<td>'.$row->resp_name.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->ch_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   echo '<a href="delete.php?del_id='.$row->ch_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

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
