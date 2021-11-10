<?php
if (isset($_POST['btn_search'])) {
    $v_date_s = @$_POST['txt_date_start'];
    $v_date_e = @$_POST['txt_date_end'];
    // echo $v_date_s.'fff'.$v_date_e;
    $v_sql = "SELECT A.*,
            SUM(length) AS total_length,
            SUM(width) AS total_width,
            SUM(height) AS total_height,
            C.name AS counter_name,
            D.user_name,
            (SELECT COUNT(*) AS out_count 
                FROM  tbl_inv_1_stock_block_stone_detail 
                WHERE stock_out_status<>0 AND parent_id=A.id) AS out_count,
            (SELECT COUNT(*) AS in_count 
                FROM tbl_inv_1_stock_block_stone_detail 
                WHERE parent_id=A.id) AS in_count
            FROM tbl_inv_1_stock_block_stone AS A 
            LEFT JOIN tbl_inv_1_stock_block_stone_detail AS B ON A.id=B.parent_id
            LEFT JOIN tbl_inv_counter_list AS C ON A.counter_id=C.id
            LEFT JOIN tbl_user AS D ON A.user_id=D.user_id
            WHERE date_record BETWEEN'$v_date_s' AND '$v_date_e'
            GROUP BY B.parent_id";
    $get_data = $connect->query($v_sql);
} else {
    $v_current_month = date('Y-m');
    $v_sql = "SELECT A.*,
            SUM(length) AS total_length,
            SUM(width) AS total_width,
            SUM(height) AS total_height,
            C.name AS counter_name,
            D.user_name,
            (SELECT COUNT(*) AS out_count 
                FROM  tbl_inv_1_stock_block_stone_detail 
                WHERE stock_out_status<>0 AND parent_id=A.id) AS out_count,
            (SELECT COUNT(*) AS in_count 
                FROM  tbl_inv_1_stock_block_stone_detail 
                WHERE parent_id=A.id) AS in_count
            FROM tbl_inv_1_stock_block_stone AS A 
            LEFT JOIN tbl_inv_1_stock_block_stone_detail AS B ON A.id=B.parent_id
            LEFT JOIN tbl_inv_counter_list AS C ON A.counter_id=C.id
            LEFT JOIN tbl_user AS D ON A.user_id=D.user_id
            WHERE DATE_FORMAT(date_record,'%Y-%m')='$v_current_month' 
            GROUP BY B.parent_id";
    $get_data = $connect->query($v_sql);
    $v_old_amo = 0;
}
?>
<div class="row">
    <form action="index.php?action=2" method="POST">
        <div class="col-sm-2">
            <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                <input autocomplete="off" name="txt_date_start" value="<?= @$_POST['txt_date_start'] ?>" type="text" class="form-control" placeholder="Date From ....">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                <input autocomplete="off" name="txt_date_end" value="<?= @$_POST['txt_date_end'] ?>" type="text" class="form-control" placeholder="Date To">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="caption font-dark" style="display: inline-block;">
                <button type="submit" name="btn_search" id="sample_editable_1_new" class="btn blue btn-sm"> Search
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </form>
</div>
<br>
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
                                echo '<td class="text-center">'.$row->floor_name.'</td>';
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