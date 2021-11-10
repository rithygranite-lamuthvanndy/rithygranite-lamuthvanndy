<?php 
    $menu_active =13;
    $left_active =45;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
    $date=date('Y-m-d');
    if(isset($_POST['btn_prin'])){
        header('location: print.php');
    }
    if(isset($_GET['status'])){
        if($_GET['status']=='Success')
            if($_GET['action']=='add')
                echo '<script>myAlertSuccess("Adding");</script>';
            else if($_GET['action']=='edit')
                echo '<script>myAlertSuccess("Updating");</script>';
        else
            echo '<script>myAlertError("Error");</script>';
    }
 ?>
<style type="text/css">
    td {
      border-collapse: collapse;
      border: 1px black solid;
    }
    tr:nth-of-type(5) td:nth-of-type(1) {
      visibility: hidden;
    }
    .rotate {
      /* FF3.5+ */
      -moz-transform: rotate(-90.0deg);
      /* Opera 10.5 */
      -o-transform: rotate(-90.0deg);
      /* Saf3.1+, Chrome */
      -webkit-transform: rotate(-90.0deg);
      /* IE6,IE7 */
      filter: progid: DXImageTransform.Microsoft.BasicImage(rotation=0.083);
      /* IE8 */
      -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)";
      /* Standard */
      transform: rotate(-90.0deg);
    }
    #table_2 >thead{
        background: #D9E1F2;
    }
     #table_2 >thead >tr:nth-child(3){
        background: #fff;
    }
</style>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Purchase Confirmation Form</h2>
        </div>
    </div>
    <div class="caption font-dark">
        <a href="add.php" id="sample_editable_1_new" class="btn green"> Add New
            <i class="fa fa-plus"></i>
        </a>
        <a href="print_blank_page.php" target="_blank" id="sample_editable_1_new" class="btn red"> Print Blank Form
            <i class="fa fa-plus"></i>
        </a>
    </div>
    <br>
    <div id="sample_1_wrapper" class="dataTables_wrapper">
        <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
            <thead>
                <tr role="row" class="text-center">
                    <th>N&deg;</th>
                    <th>Confirmed Date</th>
                    <th>Request No</th>
                    <th>Department of RGC</th>
                    <th>Type of Request No: (***)</th>
                    <th>Request by</th>
                    <th>Approve by</th>
                    <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i = 0;
                    $get_data = $connect->query("SELECT A.*,B.req_number,C.dep_name,D.typr_name,E.res_name,
                        F.apn_name
                        FROM tbl_acc_pur_confirm AS A 
                        INNER JOIN tbl_acc_request_form AS B ON B.req_id =A.req_no
                        INNER JOIN tbl_acc_department_list AS C ON C.dep_id=B.dep_id
                        INNER JOIN tbl_acc_type_request_list AS D ON D.typr_id=B.type_req_id
                        INNER JOIN tbl_acc_request_name_list AS E ON E.res_id=B.req_request_name
                        INNER JOIN tbl_acc_approved_name_list AS F ON F.apn_id=B.req_approved_by

                    
                    ORDER BY A.pur_id ASC");
                    while ($row = mysqli_fetch_object($get_data)) {
                        echo '<tr>';
                            echo '<td>'.(++$i).'</td>';
                            echo '<td>'.$row->confirm_date.'</td>';
                            echo '<td>'.$row->req_number.'</td>';
                            echo '<td>'.$row->dep_name.'</td>';
                            echo '<td>'.$row->typr_name.'</td>';
                            echo '<td>'.$row->res_name.'</td>';
                            echo '<td>'.$row->apn_name.'</td>';
                             echo '<td class="text-center">';
                                    echo '<a target="_blank" href="print.php?print_id='.$row->pur_id.'" class="btn btn-xs btn-info" title="Print"><i class="fa fa-print"></i></a> ';
                                    echo '<a href="edit.php?edit_id='.$row->pur_id.'" target="_blank" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   echo '<a href="delete.php?del_id='.$row->pur_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

                                echo '</td>';
                        echo '</tr>';
                    }

                ?> 
            </tbody>
        </table>
    </div>
</div> 
<?php include_once '../layout/footer.php' ?>