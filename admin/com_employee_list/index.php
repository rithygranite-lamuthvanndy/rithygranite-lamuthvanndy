<?php 
    $menu_active =10;
    $left_menu =4;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
    include_once 'permission.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Employee List</h2>
        </div>
    </div>
    <br>
    <div class="">
        <div class="caption font-dark">
            <?= button_add(); ?>
        </div>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Employee</th>
                        <th>Note</th>
                        <th>User</th>
                        <th>Date Audit</th>
                        <th></th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                               *
                            FROM   tbl_com_employee AS A
                            LEFT JOIN tbl_user AS U ON A.user_id=U.user_id
                            ORDER BY comemp_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->comemp_name.'</td>';
                                echo '<td>'.$row->comemp_note.'</td>';
                                echo '<td>'.$row->user_name.'</td>';
                                echo '<td>'.$row->date_audit.'</td>';
                                echo '<td>'.'</td>';
                                echo '<td class="text-center">';
                                echo button_edit($row->comemp_id);
                                echo button_delete($row->comemp_id);
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
