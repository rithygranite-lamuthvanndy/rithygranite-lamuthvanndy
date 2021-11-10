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
            <h2><i class="fa fa-fw fa-map-marker"></i> Project Close</h2>
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
                        <th>Date Record</th>
                        <th>Project Title</th>
                        <th>Project Update</th>
                        <th>Conclusion</th>
                        <th>Suggest Next</th>
                        <th class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                               *
                            FROM   tbl_pj_project_close AS A  
                            LEFT JOIN tbl_pj_project_title AS B ON B.pti_id=A.pclo_project_title
                            ORDER BY pclo_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->pclo_date_record.'</td>';
                                echo '<td>'.$row->pti_project_title.'</td>';
                                echo '<td>'.$row->pclo_project_update.'</td>';
                                echo '<td>'.$row->pclo_conclusion.'</td>';
                                echo '<td>'.$row->pclo_suggest_next.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->pclo_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';

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
