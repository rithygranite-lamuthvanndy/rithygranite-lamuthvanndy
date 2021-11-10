<?php 
    $menu_active =13;
    $left_active =66;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once 'permission.php';
    include_once '../layout/header.php';
?>



<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Supplier List</h2>
        </div>
    </div>
    <?= button_add() ?>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Supply Name</th>
                        <th>Type</th>
                        <th>Supply Number</th>
                        <th>Location</th>
                        <th>Address</th>
                        <th>Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT * FROM   tbl_op_sup_list ORDER BY osl_id ASC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->osl_name.'</td>';
                                echo '<td>'.$row->osl_type.'</td>';
                                echo '<td>'.$row->osl_ph_number.'</td>';
                                echo '<td>'.$row->osl_location.'</td>';
                                echo '<td>'.$row->osl_address.'</td>';
                                echo '<td>'.$row->osl_note.'</td>';
                                echo '<td class="text-center">';
                                echo button_edit($row->osl_id);
                                echo button_delete($row->osl_id);
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
