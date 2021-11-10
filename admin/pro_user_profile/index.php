<?php 
    $menu_active =10;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> User Profiles Update</h2>
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
                        <th>education</th>
                        <th>location</th>
                        <th>skills1</th>
                        <th>skills2</th>
                        <th>skills3</th>
                        <th>skills4</th>
                        <th>skills5</th>
                        <th>note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT * FROM   tbl_user_profiles ORDER BY up_id ASC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->up_education.'</td>';
                                echo '<td>'.$row->up_location.'</td>';
                                echo '<td>'.$row->up_skills1.'</td>';
                                echo '<td>'.$row->up_skills2.'</td>';
                                echo '<td>'.$row->up_skills3.'</td>';
                                echo '<td>'.$row->up_skills4.'</td>';
                                echo '<td>'.$row->up_skills5.'</td>';
                                echo '<td>'.$row->up_notes.'</td>';
                                echo '<td class="text-center">';
                                echo '<a href="edit.php?edit_id='.$row->up_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                echo '<a onclick="deleteRecord('.$row->up_id.')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';
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
