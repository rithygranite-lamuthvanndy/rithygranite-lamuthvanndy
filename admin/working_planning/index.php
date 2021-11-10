<?php 
    $menu_active =122;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Planning</h2>
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
                        <th>Category</th>
                        <th>Company</th>
                        <th>Employee</th>
                        <th class="text-danger">Approved by</th>
                        <th>Note</th>
                        <th>User</th>
                        <th>Date_Audit</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(isset($_POST['btn_search'])){
                            $v_from = @$_POST['txt_from'];
                            $v_to = @$_POST['txt_to'];
                            $v_topic = @$_POST['txt_topic'];
                            $v_employee = @$_POST['txt_employee'];
                            if($v_topic != "" AND $v_employee == ""){
                                //echo "5";
                            }else if($v_topic == "" AND $v_employee != ""){
                                //echo "4";
                            }else if($v_topic != "" AND $v_employee != ""){
                                //echo "3";
                            }else if($v_topic == "" AND $v_employee == ""){
                                $get_data = $connect->query("SELECT 
                                   *
                                FROM  tbl_working_planning AS A 
                                LEFT JOIN tbl_working_category AS WC ON A.wfpl_category=WC.cate_id
                                LEFT JOIN tbl_company AS COM ON A.wfpl_company=COM.com_id
                                LEFT JOIN tbl_employee AS EMP ON A.wfpl_employee=EMP.emp_id
                                LEFT JOIN tbl_user AS U ON A.user_id=U.user_id
                                WHERE wfpl_date_record BETWEEN '$v_from' AND '$v_to'
                                ORDER BY wfpl_id DESC");
                            }
                        }else{
                            $current_date = date('Y-m');
                            $get_data = $connect->query("SELECT 
                               *
                            FROM  tbl_working_planning AS A 
                            LEFT JOIN tbl_working_category AS WC ON A.wfpl_category=WC.cate_id
                            LEFT JOIN tbl_company AS COM ON A.wfpl_company=COM.com_id
                            LEFT JOIN tbl_employee AS EMP ON A.wfpl_employee=EMP.emp_id
                            LEFT JOIN tbl_user AS U ON A.user_id=U.user_id
                            WHERE DATE_FORMAT(wfpl_date_record,'%Y-%m')='$current_date'
                            ORDER BY wfpl_id DESC");
                            
                        }


                        $i = 0;
                        
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->wfpl_date_record.'</td>';
                                echo '<td>'.$row->wfpl_topic_plan.'</td>';
                                echo '<td>'.$row->cate_name.'</td>';
                                echo '<td>'.$row->com_name.'</td>';
                                echo '<td>'.$row->emp_name.'</td>';
                                    $get_apb_name = $connect->query("SELECT emp_name FROM tbl_employee WHERE emp_id='$row->wfpl_approved'");
                                    $row_apb_name = mysqli_fetch_object($get_apb_name);
                                echo '<td class="text-danger">'.$row_apb_name->emp_name.'</td>';
                                echo '<td>'.$row->wfpl_note.'</td>';
                                echo '<td>'.$row->user_name.'</td>';
                                echo '<td>'.$row->date_audit.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->wfpl_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                  // echo '<a href="delete.php?del_id='.$row->docwfpl_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

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
