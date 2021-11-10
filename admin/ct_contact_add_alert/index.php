<?php 
    $menu_active =111;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Add Contact Alert</h2>
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
                        <th>Contact Name</th>
                        <th>Date Alert</th>
                        <th>Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $count = 0;
                        $i = 0;
                        $v_current_year_month = date('Y-m');

                        $get_data = $connect->query("SELECT 
                               *
                            FROM  tbl_ct_contact_alert AS A
                            LEFT JOIN tbl_ct_contact_list AS CL ON A.ctca_contact=CL.ctco_id
                                WHERE DATE_FORMAT(ctca_date_alert,'%Y-%m')='$v_current_year_month'
                            ORDER BY ctca_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            $count+= 1; 
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->ctco_full_name.'</td>';
                                echo '<td>'.$row->ctca_date_alert.'</td>';
                                echo '<td>'.$row->ctca_note.'</td>';
                                echo '<td class="text-center">';
                                    //echo '<a href="edit.php?edit_id='.$row->ctca_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   // echo '<a href="index_alert.php?ct_id='.$row->ctca_id.'" class="btn btn-xs btn-info" title="alert"><i class="fa fa-bell"></i></a> ';
                                   echo '<a href="delete.php?del_id='.$row->ctca_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Count:
                            <?php
                                echo "$count";
                            ?>
                        </th>
                        <th></th>
                        <th></th>
                        <th></th>
                        
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>






<?php include_once '../layout/footer.php' ?>
