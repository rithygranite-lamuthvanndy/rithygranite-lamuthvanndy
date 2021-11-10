<?php 
    $menu_active =145;
    $dropdown=true;
    $left_menu_active=100;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header_frame.php';
    include_once '../inv_operation/PHP/operation.php';
?>
<?php 
    $v_parent_id=@$_GET['parent_id'];

 ?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?php 
                $v_sql_select=$connect->query("SELECT date_record FROM  tbl_inv_block_to_cursed WHERE id='$v_parent_id'");
                $v_date=mysqli_fetch_object($v_sql_select)->date_record;
             ?>
            <h2 style="font-family: khmer;"><i class="fa fa-fw fa-map-marker"></i>តារាងរាប់ថ្មប្លុកចូលអារ <?= date('D d-M-Y',strtotime($v_date)) ?></h2>
        </div>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1000px;">
                <thead>
                    <tr role="row">
                        <th class="text-center">N &deg;<br></th>
                        <th class="text-center" style="width: 15%;">តំបន់ <br> Khu<br></th>
                        <th class="text-center" style="width: 15%;">ជាន់ <br> Tầng<br></th>
                        <th class="text-center" style="width: 10%;">កូដថ្មដុំ <br> Block Code</th>
                        <th class="text-center">បណ្ដោយ <br> Dài</th>
                        <th class="text-center">ទទឹង <br> Rộng</th>
                        <th class="text-center">កម្រាស់ <br> PRICE</th>
                        <th class="text-center">ម៉ែតគូបs  <br> M3</th>
                        <th class="text-center" style="width: 8%;">ប្រភេទថ្ម </th>
                        <th class="text-center" style="width: 8%;">ពណ៌ </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        
                        $v_sql_select="SELECT A.*,
                        C.name AS location_name,
                        D.name AS floor_name,
                        E.name AS grade_type_name,
                        F.name AS color_name,
                        B.block_code
                        FROM tbl_inv_block_to_cursed_detail AS A 
                        LEFT JOIN tbl_inv_block_from_mine_detail AS B ON A.bfm_detail_id=B.id
                        LEFT JOIN tbl_inv_location_list AS C ON B.location_id=C.id
                        LEFT JOIN tbl_inv_floor_list AS D ON B.floor_id=D.id
                        LEFT JOIN  tbl_inv_grade_type_list AS E ON B.grade_type_id=E.id 
                        LEFT JOIN tbl_inv_color_list AS F ON B.color_id=F.id
                        WHERE A.parent_id='$v_parent_id'";
                        $get_data = $connect->query($v_sql_select);
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td class="text-center">'.(++$i).'</td>';
                                echo '<td class="text-center">'.$row->location_name.'</td>';
                                echo '<td class="text-center">'.$row->floor_name.'</td>';
                                echo '<td class="text-center">'.$row->block_code.'</td>';
                                echo '<td class="text-right">'.number_format($row->length,2).'</td>';
                                echo '<td class="text-right">'.number_format($row->width,2).'</td>';
                                echo '<td class="text-right">'.number_format($row->height,2).'</td>';
                                echo '<td class="text-right">'.number_format(cal_mater_cub($row->length,$row->width,$row->height),2).'</td>';
                                echo '<td class="text-center">'.$row->grade_type_name.'</td>';
                                echo '<td class="text-center">'.$row->color_name.'</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php 
    include_once '../layout/footer_frame.php';
 ?>