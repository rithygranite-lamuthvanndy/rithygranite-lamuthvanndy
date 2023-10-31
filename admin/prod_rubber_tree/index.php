<?php 
    
    $left_menu_active = 2;
    $menu_active =11;
    $left_menu =2;
    $layout_title = "Welcome to Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-4">
            <h2 style="font-family:'Khmer OS';"><i class="fa fa-fw fa-map-marker"></i> តារាងចំនួនដើមកៅស៊ូ តាមបាំង</h2>
        </div>
        <div class="col-xs-8 text-right">
            <h2>Table of number of rubber trees</h2><p style="font-family:'Times New Roman';"></p>
        </div>
    </div>
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
                <thead style="background-color: #CCFFFF;">
                    <tr role="row" class="text-center">
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">លេខរៀង</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">លេខបាំង</th>
                        <th colspan="3" style="vertical-align: middle; text-align: center;">ចំនួនដើមកៅស៊ូ </th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">សរុបរួម</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">សម្គាល់</th>
                        <th style="vertical-align: middle; text-align: center;" rowspan="2" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                    <tr role="row" class="text-center">
                        <th style="vertical-align: middle; text-align: center;">វេនទី ១</th>
                        <th style="vertical-align: middle; text-align: center;">វេនទី ២</th>
                        <th style="vertical-align: middle; text-align: center;">វេនទី ៣</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                               *, (art_depat_3+art_depat_2+art_depat_3) as totalart
                            FROM   tbl_access_rubber_tree AS A  

                            ORDER BY art_id ASC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->art_depat_id.'</td>';
                                echo '<td>'.$row->art_depat_1.' ដើម</td>';
                                echo '<td>'.$row->art_depat_2.' ដើម</td>';
                                echo '<td>'.$row->art_depat_3.' ដើម</td>';
                                echo '<td class="text-center">'.number_format($row->totalart,).' ដើម</td>';
                                echo '<td>'.$row->art_note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->art_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                    echo '<a href="delete.php?del_id='.$row->art_id.'" class="btn btn-xs btn-warning" title="delete"><i class="fa fa-trash"></i></a> ';
                                    echo '<a target="_blank" href="print.php?print_id=' . $row->art_id . '" class="btn btn-xs btn-info" title="edit"><i class="fa fa-print"></i></a> ';
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

