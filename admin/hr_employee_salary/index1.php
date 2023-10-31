<?php 
    $menu_active =33;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Employee Salary Up</h2>
        </div>
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
                    <tr role="row">
                        <th class="text-center">N&deg;</th>
                        <th class="text-center">Month Up</th>
                        <th class="text-center">Employee Name</th>
                        <th class="text-center">Position</th>
                        <th class="text-center">Salary Default</th>
                        <th class="text-center">Salary Up</th>
                        <th class="text-center">Total</th>
                        <th>Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                               *
                            FROM   tbl_hr_employee_salary_up AS A  
                            LEFT JOIN tbl_hr_employee_list AS MA ON A.emup_emp_id=MA.empl_id
                            LEFT JOIN tbl_hr_position_list AS B ON MA.empl_position=B.po_id
                            ORDER BY emup_date DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->emup_date.'</td>';
                                echo '<td>'.$row->empl_emloyee_kh.'<br>'.$row->empl_emloyee_en.'</td>';
                                echo '<td class="text-center">'.$row->po_name.'</td>';
                                echo '<td>'.number_format($row->empl_salary,2).'</td>';
                                echo '<td>'.number_format($row->emup_salary_up,2).'</td>';
                                echo '<td>'.number_format($row->empl_salary+$row->emup_salary_up,2).'</td>';

                                echo '<td>'.$row->emup_note.'</td>';
                                echo '<td class="text-center">';
                                   echo '<a href="edit.php?edit_id='.$row->emup_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   echo '<a href="delete.php?del_id='.$row->emup_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

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
