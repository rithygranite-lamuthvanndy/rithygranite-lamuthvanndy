<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
    include_once 'my_function.php';
    include '../acc_my_operation/my_operation.php';
?>
<?php 
    if(isset($_GET['status'])=='success')
        echo '<script>myAlertSuccess("Adding")</script>';
 ?>
<link href="../../assets/global/plugins/jstree/dist/themes/default/style.min.css" rel="stylesheet" type="text/css" />
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Chart Account</h2>
        </div>
    </div>
    <br>
    <div class="">
        <div class="caption font-dark">
            <a href="add.php" id="sample_editable_1_new" class="btn green"> Add New
                <i class="fa fa-plus"></i>
            </a>
            <!-- <a name="btn_delete" onclick="submitForm()" id="sample_editable_1_new" class="btn-md btn btn-primary"> Delete 
                <i class="fa fa-list"></i>
            </a> -->
        </div>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info">
                <thead>
                    <tr role="row" class="text-center">
                        <!--<th>N&deg;</th>-->
                        <th>Chart Account Code</th>
                        <th>Sub Main</th>
                        <th>Chart Account Name</th>
                        <th>Account Type</th>
                        <th>Descrption</th>
                        <th>Amount</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT A.*,accta_type_account,D.name AS sub_name
                        FROM tbl_acc_chart_account AS A 
                        LEFT JOIN tbl_acc_type_account AS C ON A.accca_account_type=C.accta_id
                        LEFT JOIN tbl_acc_chart_sub AS D ON A.sub_main_id=D.id
                        GROUP BY accca_id 
                        ORDER BY accca_number ASC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            $sql_bal=$connect->query(getDataCur(date('Y-m-d'),date('Y-m-d'),$row->accca_id));
                            // echo $sql_bal;
                            $row_bal=mysqli_fetch_object($sql_bal);
                            $res_debit=$row_bal->total_debit1+$row_bal->total_debit2;
                            $res_credit=$row_bal->total_credit1+$row_bal->total_credit2;
                            $v_bal=calBalance($row->accca_id,$res_debit,$res_credit);
                            echo '<tr>';
                                // echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->accca_number.'</td>';
                                echo '<td>'.$row->sub_name.'</td>';
                                echo '<td>'.$row->accca_account_name.'</td>';
                                echo '<td>'.$row->accta_type_account.'</td>';
                                echo '<td>'.$row->accca_des.'</td>';
                                echo '<td>'.number_format($v_bal,2).'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->accca_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   // echo '<a href="delete.php?del_id='.$row->accca_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).keyup(function(event) {
        if (event.shiftKey && event.which  == 78) {
            window.location.href = "add.php";
        }
    });
</script>
<?php include_once '../layout/footer.php' ?>