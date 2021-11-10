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
            <h2><i class="fa fa-fw fa-map-marker"></i> Control Risk</h2>
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
                        <th>Risk Title</th>
                        <th>Risk Update</th>
                        <th>Note</th>
                        <th class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT *,PCR.user_id AS id,PCR.date_audit AS audit FROM tbl_pj_control_risk AS PCR
                        LEFT JOIN tbl_pj_risk_update AS PRU ON PCR.cris_risk_update=PRU.drup_id
                        LEFT JOIN tbl_pj_risk_management AS PRM ON PCR.cris_risk_title=PRM.pris_id
                        LEFT JOIN tbl_pj_project_title AS PPT ON PRM.pris_project_title=PPT.pti_id
                        LEFT JOIN tbl_pj_project_initiation AS PPI ON PRM.pris_project_sub=PPI.pini_id");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->cris_date_record.'</td>';
                                echo '<td>'.$row->pti_project_title.'::'.$row->pini_project_sub.'::'.$row->pris_risk_title.'</td>';
                                echo '<td>'.$row->drup_name.'</td>';
                                echo '<td>'.$row->cris_note.'</td>'; 
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->cris_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                    // echo '<a href="delete.php?del_id='.$row->cris_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

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
