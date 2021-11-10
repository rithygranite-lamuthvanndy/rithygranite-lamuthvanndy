<?php 
    $menu_active =101;
    $left_menu=13;
    $layout_title = "Welcome to User Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once 'permission.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-user fa-fw"></i>Meeting Record</h2>
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
                        <th>Date Meeting</th>
                        <th>Time Meeting</th>
                        <th>Plan Code</th>
                        <th>Step</th>
                        <th>Topic Agenda</th>
                        <th>Description</th>
                        <th>Leader Name</th>
                        <th>Qty Joiner</th>
                        <th>Note</th>
                        <th>User ID</th>
                        <th>Date Audit</th>
                        <th class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $user_query = $connect->query("SELECT A.*,A.user_id AS use_id,meetp_meting_no,mnl_name,A.date_audit AS audit FROM tbl_meeting_record AS A 
                            LEFT JOIN tbl_meeting_plan AS B ON A.mr_plan_referent=B.meetp_id
                            LEFT JOIN tbl_meeting_name_list AS C ON A.mr_leader_name=C.mnl_id
                        ");
                        $no = 0;
                        while ($row_user = mysqli_fetch_object($user_query)) {
                            echo '<tr>';
                                echo "<td>".(++$no)."</td>";

                                echo "<td>$row_user->mr_date_record</td>";
                                echo "<td>$row_user->mr_time</td>";
                                echo "<td>$row_user->meetp_meting_no</td>";
                                echo "<td>$row_user->mr_step</td>";
                                echo "<td>$row_user->mr_topic_agenda</td>";
                                echo "<td>$row_user->mr_description</td>";
                                echo "<td>$row_user->mnl_name</td>";
                                echo "<td>$row_user->mr_qty_joiner</td>";
                                echo "<td>$row_user->mr_note</td>";
                                echo "<td>$row_user->use_id</td>";
                                echo "<td>$row_user->audit</td>";
                                echo '<td class="text-center">';
                                    echo button_edit($row_user->mr_id);
                                    echo button_delete($row_user->mr_id);
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
