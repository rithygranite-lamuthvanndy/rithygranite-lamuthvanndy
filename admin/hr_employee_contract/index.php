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
            <h2 style="font-family:'Khmer OS Muol';"><i class="fa fa-fw fa-map-marker"></i> តារាងសារជ័រប្រចាំខែ </h2>
        </div>
    </div>
    <br>
    <div class="">
        <div class="caption font-dark">
            <a href="add.php" id="sample_editable_1_new" class="btn green"> បញ្ចូលទិន្នន័យ
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
                        <th>លេខបាំង</th>
                        <th>ឈ្មោះកម្មករ</th>
                        <th>ភេទ</th>
                        <th>ក្រុម</th>
                        <th>សរុបជ័រមុខ<br>01 ដល់ 10</th>
                        <th>សរុបជ័រមុខ<br>11 ដល់ 20</th>
                        <th>សរុបជ័រមុខ<br>21 ដល់ 31</th>
                        <th>សរុប<br>ជ័រមុខរួម</th>
                        <th>សរុបជ័រចាន<br>01 ដល់ 10</th>
                        <th>សរុបជ័រចាន<br>11 ដល់ 20</th>
                        <th>សរុបជ័រចាន<br>21 ដល់ 31</th>
                        <th>សរុប<br>ជ័រចានរួម</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                               *
                            FROM   tbl_hr_total_rubber AS A  
                            LEFT JOIN tbl_hr_employee_list AS MA ON A.tr_emp=MA.empl_id
                            left join tbl_hr_sex_list as D on MA.empl_sex=D.sex_id
                            LEFT JOIN tbl_hr_department_sub AS C ON MA.empl_department=C.dep_id
                            LEFT JOIN tbl_hr_item_rubber AS MB ON A.tr_t_rubber=MB.ir_id
                            ORDER BY tr_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->empl_card_id.'</td>';
                                echo '<td>'.$row->empl_emloyee_kh.'</td>';
                                echo '<td>'.$row->sex_name.'</td>';
                                echo '<td>'.$row->dep_name.'</td>';
                                echo '<td>'.'</td>';
                                echo '<td>'.'</td>';
                                echo '<td>'.'</td>';
                                echo '<td>'.'</td>';
                                echo '<td>'.'</td>';
                                echo '<td>'.'</td>';
                                echo '<td>'.'</td>';
                                echo '<td>'.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->emp_id.'" class="btn btn-xs btn-warning" title="edit">ព័ត៌មាន</a> ';
                                    echo '<a href="edit.php?edit_id='.$row->emp_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   //echo '<a href="delete.php?del_id='.$row->accta_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

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
