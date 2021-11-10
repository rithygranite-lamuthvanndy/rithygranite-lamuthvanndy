<?php 
    $layout_title = "Welcome Fixed Asset Management";
    $menu_active =141;
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
    require_once "../../plugin/PHPExcel/Classes/PHPExcel.php";

$file = $_FILES['file']['name'];
$ekstensi = explode(".", $file);
$file_name ="file-".round(microtime(true)).".".end($ekstensi);
$sumber = $_FILES['file']['tmp_name'];
$target_dir ="../_file/";
$target_file = $target_dir.basename($_FILES["file"]["name"]);
move_uploaded_file($sumber, $target_file);
?>
<div class="portlet light bordered">
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_2" role="grid" aria-describedby="sample_1_info">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>DATE</th>
                        <th>COLOR</th>
                        <th>MAP</th>
                        <th>LAYER</th>
                        <th>GRADE</th>
                        <th>CODE</th>
                        <th>LENGTH</th>
                        <th>WIDTH</th>
                        <th>HEIHGT</th>
                        <th>QTY</th>
                        <th>M3</th>
                        <th>IN MONTH</th>
                        <th>Date Out</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $obj = PHPExcel_IOFactory::load($target_file);
                    $all_data = $obj->getActiveSheet()->toArray(null,true,true,true);
                    for($i=2; $i<= count($all_data); $i++){
                    echo '<tr>';
                    echo '<td>'.$all_data[$i]['A'].'</td>';
                    echo '<td>'.$all_data[$i]['B'].'</td>';
                    echo '<td>'.$all_data[$i]['C'].'</td>';
                    echo '<td>'.$all_data[$i]['E'].'</td>';
                    echo '<td>'.$all_data[$i]['F'].'</td>';
                    echo '<td>'.$all_data[$i]['G'].'</td>';
                    echo '<td>'.$all_data[$i]['H'].'</td>';
                    echo '<td>'.$all_data[$i]['I'].'</td>';
                    echo '<td>'.$all_data[$i]['J'].'</td>';
                    echo '<td>'.$all_data[$i]['K'].'</td>';
                    echo '<td>'.$all_data[$i]['L'].'</td>';
                    echo '<td>'.$all_data[$i]['M'].'</td>';
                    echo '<td>'.$all_data[$i]['N'].'</td>';
                    echo '<td>'.$all_data[$i]['O'].'</td>';
                    echo '</tr>';
                    }
                    ?>


                </tbody>
            </table>
        </div>
    </div>
</div>