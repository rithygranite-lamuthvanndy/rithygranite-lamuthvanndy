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
                $v_sql_select=$connect->query("SELECT date_record FROM tbl_inv_1_stock_block_stone WHERE id='$v_parent_id'");
                $v_date=mysqli_fetch_object($v_sql_select)->date_record;
             ?>
            <h2 style="font-family: khmer;"><i class="fa fa-fw fa-map-marker"></i> តារាងរាប់ថ្មប្លុកពីអណ្ដូងរ៉ែនៅថ្ងៃទី <?= date('D d-M-Y',strtotime($v_date))  ?></h2>
        </div>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
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
                        <th class="text-center" style="width: 10%;">Out Type </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        if(isset($_GET['out_type'])){
                            $v_out_type=$_GET['out_type'];
                            $v_sql_select="SELECT A.*,
                            B.name AS location_name,
                            C.name AS floor_name,
                            D.name AS grade_type_name,
                            E.name AS color_name,
                            A.id AS detail_id,
                            F.step AS out_type 
                            FROM tbl_inv_1_stock_block_stone_detail AS A 
                            LEFT JOIN tbl_inv_location_list AS B ON A.location_id=B.id
                            LEFT JOIN tbl_inv_floor_list AS C ON A.floor_id=C.id
                            LEFT JOIN  tbl_inv_grade_type_list AS D ON A.grade_type_id=D.id 
                            LEFT JOIN tbl_inv_color_list AS E ON A.color_id=E.id
                            LEFT JOIN tbl_inv_product_step_list AS F ON A.stock_out_status=F.id
                            WHERE parent_id='$v_parent_id' 
                            AND A.stock_out_status='$v_out_type'
                            ";
                        }
                        else{
                            $v_sql_select="SELECT A.*,
                            B.name AS location_name,
                            C.name AS floor_name,
                            D.name AS grade_type_name,
                            E.name AS color_name,
                            A.id AS detail_id,
                            F.step AS out_type 
                            FROM tbl_inv_1_stock_block_stone_detail AS A 
                            LEFT JOIN tbl_inv_location_list AS B ON A.location_id=B.id
                            LEFT JOIN tbl_inv_floor_list AS C ON A.floor_id=C.id
                            LEFT JOIN  tbl_inv_grade_type_list AS D ON A.grade_type_id=D.id 
                            LEFT JOIN tbl_inv_color_list AS E ON A.color_id=E.id
                            LEFT JOIN tbl_inv_product_step_list AS F ON A.stock_out_status=F.id
                            WHERE parent_id='$v_parent_id'";
                        }
                        $get_data = $connect->query($v_sql_select);
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td class="text-center">'.(++$i).'</td>';
                                echo '<td class="text-center">'.$row->location_name.'</td>';
                                echo '<td class="text-center">'.$row->floor_id.'</td>';
                                echo '<td class="text-center">'.$row->block_code.'</td>';
                                echo '<td class="text-right">'.number_format($row->length,2).'</td>';
                                echo '<td class="text-right">'.number_format($row->width,2).'</td>';
                                echo '<td class="text-right">'.number_format($row->height,2).'</td>';
                                echo '<td class="text-right">'.number_format(cal_mater_cub($row->length,$row->width,$row->height),2).'</td>';
                                echo '<td class="text-center">'.$row->grade_type_name.'</td>';
                                echo '<td class="text-center">'.$row->color_name.'</td>';
                                if(@$_GET['type']=='out'){
                                    echo '<td class="text-center">
                                                <p>'.$row->out_type.'
                                                    <a data_id='.$row->detail_id.' class="btn btn-xs green" title="Stock Out Type"><i class="fa fa-pencil"></i></a>
                                                </p>
                                                <div style="display: flex;">
                                                    <select style="display: none;" name="" id="input" class="form-control">
                                                        <option value="0">=== Select and Choose</option>';
                                                        $v_select=$connect->query("SELECT * FROM tbl_inv_product_step_list ORDER BY id");
                                                        while ($row_select=mysqli_fetch_object($v_select)) {
                                                            if($row->stock_out_status==$row_select->id)
                                                                echo '<option selected value="'.$row_select->id.'">'.$row_select->step.'</option>';
                                                            else
                                                                echo '<option value="'.$row_select->id.'">'.$row_select->step.'</option>';
                                                        }
                                                    echo '</select>
                                                    <button style="visibility: hidden;" type="button" class="btn btn-primary btn-xs"><i class="fa fa-save"></i></button>
                                                <div>
                                        </td>';
                                }
                                else{
                                    echo '<td class="text-center">'.$row->out_type.'</td>';
                                }
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
 <script type="text/javascript">
     $('td:last-child').find('button').click(function () {
        var v_id=$(this).parents('td').find('a').attr('data_id');
        var v_value=$(this).parents('td').find('select').val();
        if(!v_value){
            alert("Please, select out type !");
            return false;
        }
        var arr=new Array(v_id,v_value);
        $.ajax({url:'ajax_update_stock_out.php',type:'POST',data:'data='+arr,success:function (result) {
            if(!(result).trim()){
                alert("Error");
                return false;
            }
        }});
        // $(this).parents('td').find('p').html(v_code);
        // $(this).prev().hide();
        // $(this).hide();
        // $(this).parents('td').find('p >a').css('display','block');
        alert("Update Compelted");
    });
    $('td:last-child a').click(function () {
        var a=$(this).parents('td').find('select').css('display','block');
        $(this).parents('td').find('select').css('margin','0px 25px');
        $(this).parents('td').find('button').css('visibility','visible');
        $(this).css('display','none');
    });
 </script>