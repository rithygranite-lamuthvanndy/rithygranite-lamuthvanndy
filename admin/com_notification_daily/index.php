<?php 
    $menu_active =10;
    $left_menu =4;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once 'permission.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Notification Daily</h2>
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
                        <th>Date Record</th>
                        <th>Notification</th>
                        <th>Department</th>
                        <th>Employee</th>
                        <th class="text-danger">Manager Check</th>
                        <th>Date Audit</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $v_current_year_month = date('Y-m');
                        $get_data = $connect->query("SELECT 
                               *
                            FROM   tbl_com_notification_daily AS A
                            LEFT JOIN tbl_com_depatment AS DEP ON A.comnd_department=DEP.comdep_id
                            LEFT JOIN tbl_com_employee AS EMP ON A.comnd_employee=EMP.comemp_id
                            LEFT JOIN tbl_com_manager_check AS MC ON A.comnd_manager_check=MC.commc_id
                            LEFT JOIN tbl_user AS U ON A.user_id=U.user_id
                            WHERE DATE_FORMAT(comnd_date_record,'%Y-%m')='$v_current_year_month'
                            ORDER BY comnd_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->comnd_date_record.'</td>';
                                echo '<td>'.$row->comnd_notification.'</td>';
                                echo '<td>'.$row->comdep_name.'</td>';
                                echo '<td>'.$row->comemp_name.'</td>';
                                echo '<td class="text-danger">'.$row->commc_name.'</td>';
                                echo '<td>'.$row->date_audit.'</td>';
                                echo '<td class="text-center">';
                                    echo button_edit($row->comnd_id);
                                    echo button_delete($row->comnd_id);
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
