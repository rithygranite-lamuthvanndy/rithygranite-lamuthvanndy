<?php 
    $menu_active =101;
    $left_menu=15;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
    // include_once 'style.css';
?>
<?php 

 $sql_get_data = $connect->query("SELECT meetp_meting_no,mnl_name,ajn_name,ajn_meeting_no,ajn_join,ajn_id
    FROM tbl_meeting_add_joiner_name AS A 
    LEFT JOIN tbl_meeting_plan AS B ON A.ajn_meeting_no=B.meetp_id
    LEFT JOIN tbl_meeting_name_list AS C ON A.ajn_name=C.mnl_id
    ");
if(isset($_POST['btn_search'])){
    $id=$_POST['cbo_plan'];
    $sql_get_data = $connect->query("SELECT meetp_meting_no,mnl_name,ajn_name,ajn_meeting_no,ajn_join,ajn_id
    FROM tbl_meeting_add_joiner_name AS A 
    LEFT JOIN tbl_meeting_plan AS B ON A.ajn_meeting_no=B.meetp_id
    LEFT JOIN tbl_meeting_name_list AS C ON A.ajn_name=C.mnl_id
    WHERE ajn_meeting_no='$id'
    ");
    // echo 'fff';
}

 ?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-user fa-fw"></i> Check Attendance Joiner</h2>
        </div>
    </div>
    
    <br>
    <br>

    <div class="portlet-title">
        <div class="caption font-dark">
        </div>
        <div class="tools"> </div>
            <div class="row">
    			<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                    <div class="row">
                        <div class="col-xs-3">
                            <div class="form-group">
                                <select name="cbo_plan" id="input" class="form-control" required="required">
                                    <option value="">=== Select Plan N&deg; Here ===</option>
                                    <?php 
                                        $sql=$connect->query("SELECT meetp_meting_no,meetp_id FROM tbl_meeting_plan ORDER BY meetp_meting_no ASC");
                                        while ($row=mysqli_fetch_array($sql)) {
                                            echo '<option value="'.$row['meetp_id'].'">'.$row['meetp_meting_no'].'</option>';
                                        }
                                     ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="caption font-dark" style="display: inline-block;">
                                <button name="btn_search" type="submit" id="sample_editable_1_new" class="btn-md btn btn-primary"> Search Plan
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="caption font-dark" style="display: inline-block;">
                            <a href="<?= $_SERVER['PHP_SELF'] ?>" id="sample_editable_1_new" class="btn red"> Clear
                                <i class="fa fa-refresh"></i>
                            </a>
                        </div>
                    </div>
                </form>
                
            </div>
    </div>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info">
                <thead>
                    <tr role="row">
                        <th>N&deg; #</th>
                        <th>Plane No</th>
                        <th>Joiner Name</th>
                        <th class="text-center">Status</th>
                        <!-- <th>Date Update</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php 
                       
                        $no = 0;
                        while ($row_user = mysqli_fetch_object($sql_get_data)) {
                            echo '<tr>';
                                echo "<td>".(++$no)."</td>";

                                echo "<td>$row_user->meetp_meting_no</td>";
                                echo "<td>$row_user->mnl_name</td>";
                    ?>
                                <td class="text-center">
                                    <input type="hidden" name="meeting_id" value="<?= $row_user->ajn_id ?>">
                                    <!-- <input type="hidden" name="joiner_id" value="<?= $row_user->ajn_name ?>"> -->
                                    <label class="switch">
                                        <?php 
                                            if($row_user->ajn_join==0){
                                                echo '<input type="checkbox" id="my_switch">';    
                                            }
                                            else{
                                                echo '<input type="checkbox" checked id="my_switch">';
                                            }
                                         ?>
                                        
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                    <?php 
                                echo '</td>';
                            echo '</tr>';
                        }
                    ?> 
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript"  src="../../assets/global/plugins/jquery.min.js"></script>
<script type="text/javascript">
    $('input[id=my_switch]').change(function(e){
        $meeting_id=$(this).parents('td').find('input[name=meeting_id]').val();
        $flag=$(this).parents('td').find('#my_switch').is(':checked');
        // alert($flag);
        if($flag){
            $status=1; 
        }
        else
            $status=0;
        $.ajax({url: "check_attendent.php?meet_id="+$meeting_id+"&flag="+$status, success: function(result){
            // alert(result);
        }});
    });
</script>

<?php include_once '../layout/footer.php' ?>
