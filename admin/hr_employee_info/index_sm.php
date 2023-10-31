<?php 
    $layout_title = "Welcome";
    $menu_active =33;
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2 style="font-family: 'Khmer OS Moul';"><i class="fa fa-fw fa-map-marker"></i> តារាងបុគ្គលិក បើកគូប៉ុងបាយ, អង្ករ, ធូបមុស</h2>
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
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation">
                <a href="index.php">បុគ្គលិកបានប្រចាំខែ</a>
            </li>
            <li role="presentation">
                <a href="index_sw.php">បុគ្គលិកដកចេញប្រចាំខែ</a>
            </li>
            <li role="presentation" class="active">
                <a href="index_sm.php">បុគ្គលិកដកនៅសល់ប្រចាំខែ</a>
            </li>
        </ul>

    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_2" role="grid" aria-describedby="sample_1_info">
                <thead>
                    <tr role="row" class="text-center">
                        <th>ល.រ</th>
                        <th>លេខបាំង</th>
                        <th>ឈ្នោះបុគ្គលិក</th>
                        <th>មុខងារ</th>
                        <th>ក្រុម</th>
                        <th>ប្រាក់ខែ</th>
                        <th>ចំនួនអង្ករ</th>
                        <th>ចំនួនគូប៉ុង</th>
                        <th>ចំនួនធូកមុស</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                               A.*,B.*,C.*
                            FROM tbl_hr_employee_note AS A 
                            LEFT JOIN tbl_hr_employee_list AS B ON A.emn_empl_id=B.empl_id
                            LEFT JOIN tbl_hr_position_list AS C ON B.empl_position=C.po_id
                            ORDER BY emn_date DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->empl_card_id.'</td>';
                                echo '<td>'.$row->empl_emloyee_kh.'</td>';
                                echo '<td>'.$row->po_name.'</td>';
                                echo '<td>'.$row->emn_date.' || '.$row->emn_description.'</td>';
                                echo '<td>'.$row->emn_note.'</td>';
                                echo '<td>'.$row->emn_note.'</td>';
                                echo '<td>'.$row->emn_note.'</td>';
                                echo '<td>'.$row->emn_note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->emn_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
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
