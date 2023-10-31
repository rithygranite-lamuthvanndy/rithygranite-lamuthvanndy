<?php 
    $layout_title = "Welcome";
    $left_menu_active =5;
    $menu_active =11;
    $left_menu =1;
    $layout_title = "Welcome to Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2 style="font-family: 'Khmer OS';"><i class="fa fa-fw fa-map-marker"></i> តារាងតម្លៃផលិតផល</h2>
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
                        <th rowspan="2" class="text-center">N&deg;</th>
                        <th rowspan="2" class="text-center">Code</th>
                        <th colspan="2" class="text-center">Description of Goods</th>
                        <th colspan="3" class="text-center">Dimension/(CM)</th>
                        <th colspan="3" class="text-center">Unit Prince/M2/M3</th>
                        <th rowspan="2" style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                    <tr role="row" class="text-center">
                        <th class="text-center">Name</th>
                        <th class="text-center">Feature</th>
                        <th class="text-center">Length</th>
                        <th class="text-center">Thickness (+-2)</th>
                        <th class="text-center">PC/Slap</th>
                        <th class="text-center">M2/M3</th>
                        <th class="text-center">Unit Price</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                               *
                            FROM tbl_pro_price AS A 
                            ORDER BY pp_id ASC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->pp_name_id.'</td>';
                                echo '<td>'.$row->pp_name_id.'</td>';
                                echo '<td>'.$row->pp_name_id.'</td>';
                                echo '<td>'.$row->pp_length.'</td>';
                                echo '<td>'.$row->pp_width.'</td>';
                                echo '<td>'.$row->pp_thickness.'</td>';
                                echo '<td>'.$row->pp_pcs_slab.'</td>';
                                echo '<td>'.$row->pp_m2_m3.'</td>';
                                echo '<td>'.$row->pp_price.'</td>';
                                echo '<td class="text-center">';
                                    //echo '<a href="edit.php?edit_id='.$row->pp_id.'&view='.@$_GET['view'].'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   echo '<a onclick="deleteRecord('.$row->pp_id.')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

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
