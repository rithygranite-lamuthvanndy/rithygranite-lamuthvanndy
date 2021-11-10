<?php 
    $menu_active =150;
    $left_active =0;
    $layout_title = "Welcome to Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Project Title</h2>
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
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Date</th>
                        <th>Project Title</th>
                        <th>Description</th>
                        <th>Leader</th>
                        <th>Provider</th>
                        <th>Start Date</th>
                        <th>Finish Date</th>
                        <th>Amount</th>
                        <th>Expense</th>
                        <th>Note</th>                       
                        <th class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                               *
                            FROM   tbl_pj_project_title AS A  
                            LEFT JOIN tbl_pj_leader AS B ON B.dlead_id=A.pti_leader
                            LEFT JOIN tbl_pj_provider AS C ON C.dpro_id=A.pti_provider
                            ORDER BY pti_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->pti_date_record.'</td>';
                                echo '<td>'.$row->pti_project_title.'</td>';
                                echo '<td>'.$row->pti_description.'</td>';
                                echo '<td>'.$row->dlead_name.'</td>';
                                echo '<td>'.$row->dpro_name.'</td>';
                                echo '<td>'.$row->pti_date_start.'</td>';
                                echo '<td>'.$row->pti_date_finish.'</td>';
                                echo '<th class="text-center">'.number_format($row->pti_amount,2).'</th>';
                                echo '<th class="text-center">'.number_format($row->pti_expense,2).'</th>';
                                echo '<td>'.$row->pti_note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->pti_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
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
