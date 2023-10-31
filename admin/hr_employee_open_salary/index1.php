<?php 
    $menu_active =33;
    $left_active =0;
    $layout_title = "តារាងបៀវត្សរ៍ប្រចាំខែ";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-6">
            <h2><i class="fa fa-fw fa-map-marker"></i>Open Salary Employee <?= date('M-Y') ?></h2>
        </div>
        <div class="col-xs-6 text-right">
		    <h2>Total Salary: <?= number_format($sumsalary,2) ?></h2>
        </div>
    </div><br>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="../hr_employee_open_salary/">តារាងបៀវត្សរ៍ប្រចាំខែ</a>
        </li>
        <li role="presentation">
            <a href="../dashboard-bo/">បៀវត្សរ៍បុគ្គលិក</a>
        </li>
        <li role="presentation">
            <a href="../dashboard-bo/">បៀវត្សរ៍កម្មករ</a>
        </li>
        <li role="presentation">
            <a href="../dashboard-bo/">ប្រាក់ខែ ក្រុមម៉ៅការស៊ីម៉ោង</a>
        </li>
        <li role="presentation">
            <a href="../dashboard-bo/">ប្រាក់ខែ ក្រុមម៉ៅការស៊ីការ៉េ</a>
        </li>
    </ul> 
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
                        <th class="text-center">Salary on Month</th>
                        <th class="text-center">Salary Approul</th>
                        <th class="text-center">Open Salary</th>
                        <th>Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $sumsalary=0;
                        $get_data = $connect->query("SELECT 
                               A.*, B.*, MA.*
                            FROM   tbl_hr_salary_open_detail AS A  
                            LEFT JOIN tbl_hr_employee_list AS MA ON A.emopd_emp_id=MA.empl_id
                            LEFT JOIN tbl_hr_position_list AS B ON MA.empl_position=B.po_id
                            LEFT JOIN tbl_hr_salary_open AS D ON A.emop_id=D.emopd_emop_id
                            ORDER BY emopd_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td class="text-center">'.(++$i).'</td>';
                                echo '<td>'.$row->emup_date.'</td>';
                                echo '<td>'.$row->empl_emloyee_kh.'<br>'.$row->empl_emloyee_en.'</td>';
                                echo '<td class="text-center">'.$row->po_name.'</td>';
                                echo '<td>'.number_format($row->emup_salary_up,2).'<br><a href="#more_info" class="btn btn-info btn-xs" onclick="load_iframe(this)" data_id="'.$row->empl_id.'" data_status="'.$row->empl_id.'" role="button" data-toggle="modal">Info..</a> </td>';
                                echo '<td class="text-center"><input type="checkbox" name="myCheckboxes[]" id="myCheckboxes"  value="' . $row->emup_id . '"></td>';
                                echo '<td class="text-center"><input type="checkbox" name="myCheckboxes[]" id="myCheckboxes"  value="' . $row->emup_id . '"></td>';
                                echo '<td>'.$row->emup_note.'</td>';
                                echo '<td class="text-center">';
                                   echo '<a href="edit.php?edit_id='.$row->emup_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   echo '<a href="delete.php?del_id='.$row->emup_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

                                echo '</td>';
                            echo '</tr>';
                            $sumsalary+=$row->emup_salary_up;
                        }
                    ?>
                </tbody>
            </table>
            
        </div>
    </div>
</div>






<?php include_once '../layout/footer.php' ?>
<script type="text/javascript">
    function load_iframe(obj){
       let v_id=$(obj).attr('data_id');
       // let v_status=$(obj).attr('data_status');
        $('#my_frame').attr("src","iframe_more_info.php?v_id="+v_id);
    }
</script>
<div class="modal fade" id="more_info">
    <div class="modal-dialog modal-lg" style="width: 80%; border: 1px solid darkred;">
        <iframe id="my_frame" frameborder="0" style="height: 800px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
