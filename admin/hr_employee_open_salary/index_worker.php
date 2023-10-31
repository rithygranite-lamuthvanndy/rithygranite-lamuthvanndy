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
            <h2 style="font-family: 'Khmer OS Muol';"><i class="fa fa-fw fa-map-marker"></i>តារាងបៀវត្សរ៍ប្រចាំខែ <?= date('M-Y') ?></h2>
        </div>
        <div class="col-xs-6 text-right frameborder">
		    <h2><b>Total Salary: <p style="font-family: 'Times New Roman';" id="frpc_code"></p></b></h2>
            <!-- <input type="text" name="txt_cash_in" readonly="" id="input" class="form-control" value="0.00 $" required="required"> -->
        </div>
    </div><br>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation">
            <a href="../hr_employee_open_salary/">តារាងបៀវត្សរ៍ប្រចាំខែបុគ្គលិក</a>
        </li>
        <li role="presentation" class="active">
            <a href="index_worker.php">តារាងបៀវត្សរ៍ប្រចាំខែកម្មករ</a>
        </li>
        <li role="presentation">
            <a href="../hr_employee_open_salary/">បៀវត្សរ៍កម្មករ</a>
        </li>
        <li role="presentation">
            <a href="../hr_employee_open_salary/">ប្រាក់ខែ ក្រុមម៉ៅការស៊ីម៉ោង</a>
        </li>
        <li role="presentation">
            <a href="../hr_employee_open_salary/">ប្រាក់ខែ ក្រុមម៉ៅការស៊ីការ៉េ</a>
        </li>
    </ul> 
    <br>
    <div class="">
        <div class="caption font-dark">
            <a href="addw.php" id="sample_editable_1_new" class="btn green"> Add New
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
                        <th class="text-center">Emp ID</th>
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
                        $total_salary=0;
                        $get_data = $connect->query("SELECT 
                               A.*, B.*, MA.*
                            FROM   tbl_hr_employee_salary_up AS A  
                            LEFT JOIN tbl_hr_employee_list AS MA ON A.emup_emp_id=MA.empl_id
                            LEFT JOIN tbl_hr_position_list AS B ON MA.empl_position=B.po_id
                            WHERE empl_position = '142'
                            ORDER BY emup_date DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td class="text-center">'.(++$i).'</td>';
                                echo '<td>'.$row->emup_date.'</td>';
                                echo '<td>'.$row->empl_card_id.'</td>';
                                echo '<td>'.$row->empl_emloyee_kh.'<br>'.$row->empl_emloyee_en.'</td>';
                                echo '<td class="text-center">'.$row->po_name.'</td>';
                                echo '<td class="text-right">'.number_format($row->emup_salary_up,2).' ៛</td>';
                                echo '<td class="text-center"><input type="checkbox" name="myCheckboxes[]" id="myCheckboxes"  value="' . $row->emup_id . '"></td>';
                                echo '<td class="text-center"><input type="checkbox" name="myCheckboxes[]" id="myCheckboxes"  value="' . $row->emup_id . '"></td>';
                                echo '<td>'.$row->emup_note.'</td>';
                                echo '<td class="text-center">';
                                echo '<a href="#more_info" class="btn btn-info btn-xs" onclick="load_iframe(this)" data_id="'.$row->empl_id.'" data_status="'.$row->empl_id.'" role="button" data-toggle="modal">Info..</a> ';
                                echo '<a href="#more_info_edit" class="btn btn-xs btn-warning" onclick="load_iframe_edit(this)" data_id="'.$row->empl_id.'" data_status="'.$row->empl_id.'" role="button" data-toggle="modal"><i class="fa fa-edit"></i></a> ';

                                   echo '<a href="delete.php?del_id='.$row->emup_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

                                echo '</td>';
                            echo '</tr>';
                            $total_salary+=$row->emup_salary_up;
                            
                        }
                    ?>
                </tbody>
            </table>
            <input type="hidden" name="txt_t_salary" value="<?= $total_salary ?>">
        </div>
    </div>
</div>






<?php include_once '../layout/footer.php' ?>
<script type="text/javascript">
    var total_in = $('input[name=txt_t_salary]').val();
    total_in = Number(parseFloat(total_in).toFixed(2)).toLocaleString('en', {
        minimumFractionDigits: 2
    });
    $('input[name=txt_cash_in]').val(total_in + " $");
    document.getElementById("frpc_code").innerHTML = total_in+" ៛" ;

    function load_iframe(obj){
       let v_id=$(obj).attr('data_id');
       // let v_status=$(obj).attr('data_status');
        $('#my_frame').attr("src","iframe_more_info.php?v_id="+v_id);
    }
    function load_iframe_edit(obj){
       let v_id1=$(obj).attr('data_id');
       // let v_status=$(obj).attr('data_status');
        $('#my_frame_edit').attr("src","iframe_more_edit.php?v_id="+v_id1);
    }
</script>
<div class="modal fade" id="more_info">
    <div class="modal-dialog modal-lg" style="width: 80%;">
        <iframe id="my_frame" frameborder="0" style="height: 800px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="more_info_edit">
    <div class="modal-dialog modal-lg" style="width: 80%;">
        <iframe id="my_frame_edit" frameborder="0" style="height: 800px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
