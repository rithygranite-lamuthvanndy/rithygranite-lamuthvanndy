<?php 
    $menu_active =101;
    $left_menu=24;
    $layout_title = "Welcome to User Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once 'permission.php';
    include_once '../layout/header.php';
?>
<?php 
if(isset($_POST['btn_search'])){
$v_date_s=@$_POST['txt_date_start'];
$v_date_e=@$_POST['txt_date_end'];
$user_query = $connect->query("SELECT * FROM tbl_meeting_plan AS A 
                                LEFT JOIN tbl_meeting_category AS B ON A.cat_id=B.cat_id
                                WHERE meetp_date_meeting BETWEEN '$v_date_s' AND '$v_date_e'
                                                            ");
}else{
$user_query = $connect->query("SELECT * FROM tbl_meeting_plan AS A 
                                LEFT JOIN tbl_meeting_category AS B ON A.cat_id=B.cat_id
                                                            ");
}
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
			
           <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="col-sm-6">
                <select name="cbo_id" id="inputCbo_id" class="form-control" required="required">
                    <option value="">=== Select and Choose here ===</option>
                    <?php 
                        $sql=$connect->query("SELECT meetp_meting_no,meetp_id 
                            FROM tbl_meeting_plan WHERE meetp_id IN(SELECT mre_meeting_topic FROM tbl_meeting_result)
                            ORDER BY meetp_meting_no");
                        while ($row_1=mysqli_fetch_object($sql)) {
                            echo '<option value="'.$row_1->meetp_id.'">'.$row_1->meetp_meting_no.'</option>';
                        }
                     ?>
                </select>   
            </div>
            <div class="col-sm-6">
                <div class="caption font-dark" style="display: inline-block;">
                    <button type="submit" name="btn_search" id="sample_editable_1_new" class="btn blue"> Search
                        <i class="fa fa-search"></i>
                    </button>

                </div>
                <div class="caption font-dark" style="display: inline-block;">
                    <a href="<?= $_SERVER['PHP_SELF'] ?>" id="sample_editable_1_new" class="btn red"> Clear
                        <i class="fa fa-refresh"></i>
                    </a>
                </div>

            </div>
        </form>
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
                        <!-- <th class="text-center">Action <i class="fa fa-cog fa-spin"></i></th> -->
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
                                // echo '<td class="text-center">';
                                //     echo '<a href="edit.php?edit_id='.$row_user->mre_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> '; 
                                // echo '</td>';
                            echo '</tr>';
                        }
                    ?> 
                </tbody>
            </table>
        </div>
    </div>
</div>




<?php include_once '../layout/footer.php' ?>
