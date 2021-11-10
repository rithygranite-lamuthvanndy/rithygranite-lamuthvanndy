<?php  
    $menu_active =10;
    $left_menu =4;
    $layout_title = "Welcome to User Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once 'permission.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-user fa-fw"></i>User Position</h2>
        </div>
    </div>
    <?= button_add(); ?>
    <div class="portlet-body">
        <div id="sample_2_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline " id="sample_2" role="grid" aria-describedby="sample_2_info" style="width: 1180px;">
                <thead>
                    <tr role="row">
                        <th>N&deg; #</th>
                        <th>Position Name</th>
                        <th class="text-center">Assign Permission</th>
                        <!-- <th>Status</th> -->
                        <th class="text-center">See Only Group Data</th>
                        <th>Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $user_query = $connect->query("SELECT * FROM tbl_user_position AS A 
                        LEFT JOIN tbl_user_status AS B ON B.us_id=A.up_status ORDER BY up_id ASC");
                        $no = 0;
                        while ($row = mysqli_fetch_object($user_query)) {
                            echo '<tr>';
                                echo "<td>".(++$no)."</td>";
                                echo "<td>$row->up_name</td>";
                                echo '<td class="text-center">'.button_edit_permission($row->up_id).'</td>';
                                // echo '<td>'.$row->us_name.'</td>';
                                echo '<th class="text-center">'.(($row->up_group_data)?('<i class="fa fa-check text-success"></i>'):('<i class="fa fa-times text-danger"></i>')).'</th>';
                                echo '<td>'.$row->up_note.'</td>';
                                echo '<td class="text-center">';
                                    echo button_edit($row->up_id);
                                    if($row->up_id!=15)
                                        echo button_delete($row->up_id);
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
