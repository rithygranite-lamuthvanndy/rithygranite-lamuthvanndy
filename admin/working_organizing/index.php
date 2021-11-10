<?php 
    $menu_active =122;
    $left_active =0;
    $layout_title = "Welcome...";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Organizing</h2>
        </div>
    </div>
    <br>
    <div class="row">
        <!-- start search form -->
        <form action="" method="post">
            <div class="col-xs-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input type="text" name="txt_from" required  value="<?= @$_POST['txt_from'] ?>" autocomplete="off" class="form-control">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-xs-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input type="text" name="txt_to"  required value="<?= @$_POST['txt_to'] ?>" autocomplete="off" class="form-control">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-xs-2">
                <select name="txt_topic" class="form-control">
                    <option value="">==all topic==</option>
                    <?php 
                        $get_topic = $connect->query("SELECT * FROM tbl_working_planning ORDER BY wfpl_topic_plan ASC");
                        while($row_topic = mysqli_fetch_object($get_topic)){
                            if($row_topic->wfpl_id == @$_POST['txt_topic']){
                                echo '<option SELECTED value="'.$row_topic->wfpl_id.'">'.$row_topic->wfpl_topic_plan.'</option>';
                                
                            }else{

                                echo '<option value="'.$row_topic->wfpl_id.'">'.$row_topic->wfpl_topic_plan.'</option>';
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="col-xs-2">
                <select name="txt_employee" class="form-control">
                    <option value="">==all employee==</option>
                    <?php 
                        $get_employee = $connect->query("SELECT * FROM tbl_employee ORDER BY emp_name ASC");
                        while($row_employee = mysqli_fetch_object($get_employee)){
                            if($row_employee->emp_id == @$_POST['txt_employee']){
                                echo '<option SELECTED value="'.$row_employee->emp_id.'">'.$row_employee->emp_name.'</option>';

                            }else{
                                echo '<option value="'.$row_employee->emp_id.'">'.$row_employee->emp_name.'</option>';
                                
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="col-xs-2">
                <button type="submit" name="btn_search" class="btn blue"><i class="fa fa-search"></i> Search</button>
                <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn red"><i class="fa fa-undo"></i> Clear</a>
            </div>
        </form>
        <!-- end search form -->
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
                        <th>Date Record</th>
                        <th>Topic Plan</th>
                        <th>Description</th>
                        <th>Employee</th>
                        <th>Note</th>
                        <th>Approved by</th>
                        <th class="text-danger">Check Organizing</th>
                        <th>User</th>
                        <th>Date_Audit</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>

                    <!-- start search code -->
                    <?php
                        if(isset($_POST['btn_search'])){
                            $v_from = @$_POST['txt_from'];
                            $v_to = @$_POST['txt_to'];
                            $v_topic = @$_POST['txt_topic'];
                            $v_employee = @$_POST['txt_employee'];
                            if($v_topic != "" AND $v_employee == ""){
                                //echo "5";
                                $get_data = $connect->query("SELECT 
                                   *
                                FROM  tbl_working_organizing AS A 
                                LEFT JOIN tbl_user AS U ON U.user_id=A.user_id
                                LEFT JOIN tbl_working_planning AS WP ON A.wfor_topic_plan=WP.wfpl_id
                                LEFT JOIN tbl_employee AS EMP ON A.wfor_employee=EMP.emp_id 
                                LEFT JOIN tbl_working_check_data AS WCD ON A.wfor_check_organizing=WCD.wfcd_id
                                WHERE wfor_date_record BETWEEN '$v_from' AND '$v_to' AND A.wfor_topic_plan='$v_topic'
                                ORDER BY wfor_id DESC");
                            }else if($v_topic == "" AND $v_employee != ""){
                                //echo "4";
                                $get_data = $connect->query("SELECT 
                                   *
                                FROM  tbl_working_organizing AS A 
                                LEFT JOIN tbl_user AS U ON U.user_id=A.user_id
                                LEFT JOIN tbl_working_planning AS WP ON A.wfor_topic_plan=WP.wfpl_id
                                LEFT JOIN tbl_employee AS EMP ON A.wfor_employee=EMP.emp_id 
                                LEFT JOIN tbl_working_check_data AS WCD ON A.wfor_check_organizing=WCD.wfcd_id
                                WHERE wfor_date_record BETWEEN '$v_from' AND '$v_to' AND A.wfor_employee='$v_employee'
                                ORDER BY wfor_id DESC");
                            }else if($v_topic != "" AND $v_employee != ""){
                                //echo "3";
                                $get_data = $connect->query("SELECT 
                                   *
                                FROM  tbl_working_organizing AS A 
                                LEFT JOIN tbl_user AS U ON U.user_id=A.user_id
                                LEFT JOIN tbl_working_planning AS WP ON A.wfor_topic_plan=WP.wfpl_id
                                LEFT JOIN tbl_employee AS EMP ON A.wfor_employee=EMP.emp_id 
                                LEFT JOIN tbl_working_check_data AS WCD ON A.wfor_check_organizing=WCD.wfcd_id
                                WHERE wfor_date_record BETWEEN '$v_from' AND '$v_to' AND A.wfor_employee='$v_employee' AND A.wfor_topic_plan='$v_topic' 
                                ORDER BY wfor_id DESC");
                            }else if($v_topic == "" AND $v_employee == ""){
                                //echo "2";
                                $get_data = $connect->query("SELECT 
                                   *
                                FROM  tbl_working_organizing AS A 
                                LEFT JOIN tbl_user AS U ON U.user_id=A.user_id
                                LEFT JOIN tbl_working_planning AS WP ON A.wfor_topic_plan=WP.wfpl_id
                                LEFT JOIN tbl_employee AS EMP ON A.wfor_employee=EMP.emp_id 
                                LEFT JOIN tbl_working_check_data AS WCD ON A.wfor_check_organizing=WCD.wfcd_id
                                WHERE wfor_date_record BETWEEN '$v_from' AND '$v_to'
                                ORDER BY wfor_id DESC");
                            }
                        }else{
                            //echo "1";
                            $current_date = date('Y-m');
                            $get_data = $connect->query("SELECT 
                                   *
                                FROM  tbl_working_organizing AS A 
                                LEFT JOIN tbl_user AS U ON U.user_id=A.user_id
                                LEFT JOIN tbl_working_planning AS WP ON A.wfor_topic_plan=WP.wfpl_id
                                LEFT JOIN tbl_employee AS EMP ON A.wfor_employee=EMP.emp_id 
                                LEFT JOIN tbl_working_check_data AS WCD ON A.wfor_check_organizing=WCD.wfcd_id
                                WHERE DATE_FORMAT(wfor_date_record,'%Y-%m')='$current_date'
                                ORDER BY wfor_id DESC");
                        }

                        $i = 0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->wfor_date_record.'</td>';
                                echo '<td>'.$row->wfpl_topic_plan.'</td>';
                                echo '<td>'.$row->wfor_description.'</td>';
                                echo '<td>'.$row->emp_name.'</td>';
                                echo '<td>'.$row->wfor_note.'</td>';
                                    // select employee name on approved
                                    $get_apb_name = $connect->query("SELECT emp_name FROM tbl_employee WHERE emp_id='$row->wfor_approved'");
                                    $row_apb_name = mysqli_fetch_object($get_apb_name);
                                echo '<td class="text-center">
                                        <a href="check_approved.php?sent_id='.$row->wfor_id.'">
                                        <i class="fa fa-pencil"></i>
                                        </a>
                                        '.@$row_apb_name->emp_name.'
                                    </td>';
                                echo '<td class="text-center text-danger">
                                        <a href="check_organizing.php?sent_id='.$row->wfor_id.'">
                                        <i class="fa fa-pencil"></i>
                                        </a>
                                        '.@$row->wfcd_name.'
                                    </td>';
                                echo '<td>'.$row->user_name.'</td>';
                                echo '<td>'.$row->date_audit.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->wfor_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                  // echo '<a href="delete.php?del_id='.$row->docwfor_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

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
