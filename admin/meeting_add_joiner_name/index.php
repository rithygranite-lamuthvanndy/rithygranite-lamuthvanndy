<?php 
    $menu_active =101;
    $left_menu=16;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once 'permission.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <br>
    <br>

    <div class="portlet-title">
        <div class="caption font-dark">
           <?= button_add(); ?>
        </div>
        <div class="tools"> </div>
    </div>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row">
                        <th>N&deg; #</th>
                        <th>Topic</th>
                        <th>Topic</th>
                        <th>Name</th>
                        <th>Join?</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $user_query = $connect->query("SELECT * 
                            FROM tbl_meeting_add_joiner_name AS A 
                            LEFT JOIN tbl_meeting_plan AS B ON A.ajn_meeting_no=B.meetp_id
                            LEFT JOIN tbl_meeting_name_list AS C ON A.ajn_join=C.mnl_id
                                                            ");
                        $no = 0;
                        while ($row_user = mysqli_fetch_object($user_query)) {
                            echo '<tr>';
                                echo "<td>".(++$no)."</td>";
                                echo "<td>$row_user->ajn_name</td>";
                                echo "<td>$row_user->mnl_name</td>";
                                echo "<td>...</td>";
                                echo "<td>$row_user->ajn_note</td>";
                            echo '</tr>';
                        }
                    ?> 
                </tbody>
            </table>
        </div>
    </div>
</div>




<?php include_once '../layout/footer.php' ?>
