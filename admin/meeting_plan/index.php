<?php 
    $menu_active =101;
    $left_menu=11;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once 'permission.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-user fa-fw"></i>Meeting Plan</h2>
        </div>
    </div>
    
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
                        <th>Date Meeting </th>
                        <th>Category Name</th>
                        <th>Meeting No</th>
                        <th>Participation (Who Join)</th>
                        <th>Location (Where)</th>
                        <th>Time (When)</th>
                        <th>Topic (What)</th>
                        <th>Reason (Why)</th>
                        <th>Description (How)</th>
                        <th>Note</th>
                        <th>User</th>
                        <th>Date Update</th>
                        <th class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $user_query = $connect->query("SELECT * FROM tbl_meeting_plan AS A 
                                LEFT JOIN tbl_meeting_category AS B ON A.cat_id=B.cat_id
                                                            ");
                        $no = 0;
                        while ($row_user = mysqli_fetch_object($user_query)) {
                            echo '<tr>';
                                echo "<td>".(++$no)."</td>";
                                echo "<td>$row_user->meetp_date_meeting</td>";
                                echo "<td>$row_user->cat_name</td>";
                                echo "<td>$row_user->meetp_meting_no</td>";
                                echo '<td class="text-center">';
                                    echo '<a href="add_joiner.php?sent_id='.$row_user->meetp_id.'" class="btn btn-xs btn-info" title="list"><i class="fa fa-user"></i></a> '; 
                                echo '</td>';
                                echo "<td>$row_user->meetp_location</td>";
                                echo "<td>$row_user->meetp_time</td>";
                                echo "<td>$row_user->meetp_topic</td>";
                                echo "<td>$row_user->meetp_reason</td>";
                                echo "<td>$row_user->meetp_description</td>";
                                echo "<td>$row_user->meetp_note</td>";
                                echo "<td>$row_user->user_id</td>";
                                echo "<td>$row_user->date_audit</td>";
                                echo '<td class="text-center">';
                                echo button_edit($row_user->meetp_id);
                                echo button_delete($row_user->meetp_id);
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
