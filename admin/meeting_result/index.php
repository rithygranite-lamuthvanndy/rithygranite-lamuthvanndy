<?php 
    $menu_active =101;
    $left_menu=14;
    $layout_title = "Welcome to User Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once 'permission.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-user fa-fw"></i>Meeting Result</h2>
        </div>
    </div>
    
    <br>
    <br>

    <div class="portlet-title">
        <div class="caption font-dark">
			
           <?= button_add() ?>
			
        </div>
        <div class="tools"> </div>
    </div>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row">
                        <th>N&deg; #</th>
                        <th>Meeting No</th>
                        <th>Meeting Feedback</th>
                        <th>Meeting Conclusion</th>
                        <th>Meeting Issue</th>
                        <th>Meeting Improvement</th>
                        <th>Meeting Next Meeting</th>
                        <th>User ID</th>
                        <th>Date Audit</th>
                        <th class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $user_query = $connect->query("SELECT A.*,meetp_meting_no,A.user_id AS use_id,A.date_audit AS audit FROM tbl_meeting_result AS A 
                            LEFT JOIN tbl_meeting_plan AS B ON A.mre_meeting_topic=B.meetp_id
                        ");
                        $no = 0;
                        while ($row_user = mysqli_fetch_object($user_query)) {
                            echo '<tr>';
                                echo "<td>".(++$no)."</td>";

                                echo "<td>$row_user->meetp_meting_no</td>";
                                echo "<td>$row_user->mre_meeting_feedback</td>";
                                echo "<td>$row_user->mre_conclusion</td>";
                                echo "<td>$row_user->mre_issue</td>";
                                echo "<td>$row_user->mre_improvement</td>";
                                echo "<td>$row_user->mre_next_meeting</td>";
                                echo "<td>$row_user->use_id</td>";
                                echo "<td>$row_user->audit</td>";
                                echo '<td class="text-center">';
                                echo button_edit($row_user->mre_id);
                                echo button_delete($row_user->mre_id);
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
