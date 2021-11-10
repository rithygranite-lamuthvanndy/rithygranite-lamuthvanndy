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
            <h2><i class="fa fa-fw fa-map-marker"></i> Job Description</h2>
        </div>
    </div>
    <br>
    <div class="row">
        <!-- start search form -->
        <form action="" method="post">
            <div class="col-xs-2">
                <select name="txt_employee" class="form-control" required="">
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
                        <th class="text-center">Time</th>
                        <th class="text-center">Hour</th>
                        <th>Description</th>
                        <th>Employee</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                        if(isset($_POST['btn_search'])){
                            $v_employee = @$_POST['txt_employee'];
                            $get_data = $connect->query("SELECT * FROM tbl_working_job_description AS A LEFT JOIN tbl_employee AS B ON B.emp_id=A.jd_employee WHERE A.jd_employee='$v_employee'");
                        }else{
                            $get_data = $connect->query("SELECT * FROM tbl_working_job_description AS A LEFT JOIN tbl_employee AS B ON B.emp_id=A.jd_employee");
                        }

                        $i = 0;
                        while ($row = mysqli_fetch_object($get_data)) {
                              
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->jd_time.'</td>';
                                echo '<th class="text-center">'.$row->jd_hour.'</th>';
                                echo '<td>'.$row->jd_description.'</td>';
                                echo '<td>'.$row->emp_name.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->jd_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                 //  echo '<a href="delete.php?del_id='.$row->docdoc_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

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
