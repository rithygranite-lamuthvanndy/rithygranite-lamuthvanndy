<?php 
    $menu_active =11;
    $left_menu=6;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once 'permission.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Search: Notification</h2>
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
                <select name="txt_search_name" class="form-control">
                    <option value="">==all department==</option>
                    <?php 
                        $get_search_data = $connect->query("SELECT * FROM tbl_com_depatment ORDER BY comdep_name ASC");
                        while($row_select = mysqli_fetch_object($get_search_data)){
                            if($row_select->comdep_id == @$_POST['txt_search_name']){
                                echo '<option SELECTED value="'.$row_select->comdep_id.'">'.$row_select->comdep_name.'</option>';
                                
                            }else{

                                echo '<option value="'.$row_select->comdep_id.'">'.$row_select->comdep_name.'</option>';
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="col-xs-2">
                <select name="txt_employee" class="form-control">
                    <option value="">==all employee==</option>
                    <?php 
                        $get_employee = $connect->query("SELECT * FROM tbl_com_employee ORDER BY comemp_name ASC");
                        while($row_employee = mysqli_fetch_object($get_employee)){
                            if($row_employee->comemp_id == @$_POST['txt_employee']){
                                echo '<option SELECTED value="'.$row_employee->comemp_id.'">'.$row_employee->comemp_name.'</option>';

                            }else{
                                echo '<option value="'.$row_employee->comemp_id.'">'.$row_employee->comemp_name.'</option>';
                                
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
                        <th>Notification</th>
                        <th>Department</th>
                        <th>Employee</th>
                        <th class="text-danger">Manager Check</th>
                        <th class="text-danger">Manager Name</th>
                        <th class="text-danger">Manager Reply</th>
                        <th>Date Audit</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                        if(isset($_POST['btn_search'])){
                            $v_from = @$_POST['txt_from'];
                            $v_to = @$_POST['txt_to'];
                            $v_topic = @$_POST['txt_search_name'];
                            $v_employee = @$_POST['txt_employee'];
                            if($v_topic != "" AND $v_employee == ""){
                                //echo "5"; topic
                                $get_data = $connect->query("SELECT 
                                   *
                                FROM   tbl_com_notification_daily AS A
                                LEFT JOIN tbl_com_depatment AS DEP ON A.comnd_department=DEP.comdep_id
                                LEFT JOIN tbl_com_employee AS EMP ON A.comnd_employee=EMP.comemp_id
                                LEFT JOIN tbl_com_manager_check AS MC ON A.comnd_manager_check=MC.commc_id
                                LEFT JOIN tbl_com_manager_name AS MN ON A.comnd_manager_name=MN.commn_id
                                LEFT JOIN tbl_user AS U ON A.user_id=U.user_id
                                WHERE comnd_date_record BETWEEN '$v_from' AND '$v_to' AND A.comnd_department='$v_topic'
                                ORDER BY comnd_id DESC");

                            }else if($v_topic == "" AND $v_employee != ""){
                                //echo "4"; employee 
                                $get_data = $connect->query("SELECT 
                                   *
                                FROM   tbl_com_notification_daily AS A
                                LEFT JOIN tbl_com_depatment AS DEP ON A.comnd_department=DEP.comdep_id
                                LEFT JOIN tbl_com_employee AS EMP ON A.comnd_employee=EMP.comemp_id
                                LEFT JOIN tbl_com_manager_check AS MC ON A.comnd_manager_check=MC.commc_id
                                LEFT JOIN tbl_com_manager_name AS MN ON A.comnd_manager_name=MN.commn_id
                                LEFT JOIN tbl_user AS U ON A.user_id=U.user_id
                                WHERE comnd_date_record BETWEEN '$v_from' AND '$v_to' AND A.comnd_employee='$v_employee'
                                ORDER BY comnd_id DESC");

                            }else if($v_topic != "" AND $v_employee != ""){
                                //echo "3"; topic + employee
                                $get_data = $connect->query("SELECT 
                                   *
                                FROM   tbl_com_notification_daily AS A
                                LEFT JOIN tbl_com_depatment AS DEP ON A.comnd_department=DEP.comdep_id
                                LEFT JOIN tbl_com_employee AS EMP ON A.comnd_employee=EMP.comemp_id
                                LEFT JOIN tbl_com_manager_check AS MC ON A.comnd_manager_check=MC.commc_id
                                LEFT JOIN tbl_com_manager_name AS MN ON A.comnd_manager_name=MN.commn_id
                                LEFT JOIN tbl_user AS U ON A.user_id=U.user_id
                                WHERE comnd_date_record BETWEEN '$v_from' AND '$v_to' AND A.comnd_employee='$v_employee' AND A.comnd_department='$v_topic'
                                ORDER BY comnd_id DESC");


                            }else if($v_topic == "" AND $v_employee == ""){
                                //echo "2";
                                $get_data = $connect->query("SELECT 
                                   *
                                FROM   tbl_com_notification_daily AS A
                                LEFT JOIN tbl_com_depatment AS DEP ON A.comnd_department=DEP.comdep_id
                                LEFT JOIN tbl_com_employee AS EMP ON A.comnd_employee=EMP.comemp_id
                                LEFT JOIN tbl_com_manager_check AS MC ON A.comnd_manager_check=MC.commc_id
                                LEFT JOIN tbl_com_manager_name AS MN ON A.comnd_manager_name=MN.commn_id
                                LEFT JOIN tbl_user AS U ON A.user_id=U.user_id
                                WHERE comnd_date_record BETWEEN '$v_from' AND '$v_to'
                                ORDER BY comnd_id DESC");

                                
                            }
                        }else{
                            //echo "1";
                            $v_current_year_month = date('Y-m');
                            $get_data = $connect->query("SELECT 
                               *
                            FROM   tbl_com_notification_daily AS A
                            LEFT JOIN tbl_com_depatment AS DEP ON A.comnd_department=DEP.comdep_id
                            LEFT JOIN tbl_com_employee AS EMP ON A.comnd_employee=EMP.comemp_id
                            LEFT JOIN tbl_com_manager_check AS MC ON A.comnd_manager_check=MC.commc_id
                            LEFT JOIN tbl_com_manager_name AS MN ON A.comnd_manager_name=MN.commn_id
                            LEFT JOIN tbl_user AS U ON A.user_id=U.user_id
                            WHERE DATE_FORMAT(comnd_date_record,'%Y-%m')='$v_current_year_month'
                            ORDER BY comnd_id DESC");
                        }

                        

                        $i = 0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->comnd_date_record.'</td>';
                                echo '<td>'.$row->comnd_notification.'</td>';
                                echo '<td>'.$row->comdep_name.'</td>';
                                echo '<td>'.$row->comemp_name.'</td>';
                                echo '<td class="text-center text-danger">
                                    '.$row->commc_name.'
                                    <a href="edit_manager.php?sent_id='.$row->comnd_id.'">
                                    <i class="fa fa-pencil"></i>
                                    </a>
                                    </td>';
                                echo '<td class="text-danger">'.$row->commn_name.'</td>';
                                echo '<td class="text-danger">'.$row->comnd_manager_reply.'</td>';
                                echo '<td>'.$row->date_audit.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->comnd_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   //echo '<a href="delete.php?del_id='.$row->comnd_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

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
