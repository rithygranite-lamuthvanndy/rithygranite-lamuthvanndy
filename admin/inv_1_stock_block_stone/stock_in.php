<?php
if (isset($_POST['btn_search'])) {
    $v_date_s = @$_POST['txt_date_start'];
    $v_date_e = @$_POST['txt_date_end'];
    // echo $v_date_s.'fff'.$v_date_e;
    $v_sql = "SELECT A.*,
            length,
            width,
            height,
            date_format(date_record,'%d-%m-%Y') as date_ff,
            (length*width*height) as total_block,
            C.name AS counter_name,
            D.user_name, B.block_code, B.floor_id,
            (select name from tbl_inv_location_list where id=B.location_id) as location_bb,  
            (select name from tbl_inv_grade_type_list where id=B.grade_type_id) as grade_type_dd,
            (select name from tbl_inv_color_list where id=B.color_id) as color_ee
            FROM tbl_inv_1_stock_block_stone AS A 
            LEFT JOIN tbl_inv_1_stock_block_stone_detail AS B ON A.id=B.parent_id
            LEFT JOIN tbl_inv_counter_list AS C ON A.counter_id=C.id
            LEFT JOIN tbl_user AS D ON A.user_id=D.user_id
            LEFT JOIN tbl_inv_product_step_list AS F ON B.stock_out_status=F.id
            WHERE date_record BETWEEN'$v_date_s' AND '$v_date_e'
            ";
    $get_data = $connect->query($v_sql);
} else {
    $v_current_month = date('Y-m');
    $v_sql = "SELECT A.*,
            length,
            width,
            height,
            date_format(date_record,'%d-%m-%Y') as date_ff,
            (length*width*height) as total_block,
            C.name AS counter_name,
            D.user_name, B.block_code, B.floor_id,
            (select name from tbl_inv_location_list where id=B.location_id) as location_bb,  
            (select name from tbl_inv_grade_type_list where id=B.grade_type_id) as grade_type_dd,
            (select name from tbl_inv_color_list where id=B.color_id) as color_ee
            FROM tbl_inv_1_stock_block_stone AS A 
            LEFT JOIN tbl_inv_1_stock_block_stone_detail AS B ON A.id=B.parent_id
            LEFT JOIN tbl_inv_counter_list AS C ON A.counter_id=C.id
            LEFT JOIN tbl_user AS D ON A.user_id=D.user_id
            LEFT JOIN tbl_inv_product_step_list AS F ON B.stock_out_status=F.id
            WHERE DATE_FORMAT(date_record,'%Y-%m')='$v_current_month' 
            ";
    $get_data = $connect->query($v_sql);
    $v_old_amo = 0;
}
?>
<?php
$bi_stone_block=0;
if (isset($_POST['btn_search'])) {
    $v_date_s1 = @$_POST['txt_date_start'];
    $v_date_e1 = @$_POST['txt_date_end'];
    // echo $v_date_s.'fff'.$v_date_e;
    $v_sql1 = "SELECT A.*,
            length,
            width,
            height,
            date_format(date_record,'%d-%m-%Y') as date_ff,
            (length*width*height) as total_block,
            C.name AS counter_name,
            D.user_name, B.block_code, B.floor_id,
            (select name from tbl_inv_location_list where id=B.location_id) as location_bb,  
            (select name from tbl_inv_grade_type_list where id=B.grade_type_id) as grade_type_dd,
            (select name from tbl_inv_color_list where id=B.color_id) as color_ee
            FROM tbl_inv_1_stock_block_stone AS A 
            LEFT JOIN tbl_inv_1_stock_block_stone_detail AS B ON A.id=B.parent_id
            LEFT JOIN tbl_inv_counter_list AS C ON A.counter_id=C.id
            LEFT JOIN tbl_user AS D ON A.user_id=D.user_id
            LEFT JOIN tbl_inv_product_step_list AS F ON B.stock_out_status=F.id
            WHERE date_record <'$v_date_s'
            ";
    $get_data1 = $connect->query($v_sql1);
    while ($row1 = mysqli_fetch_object($get_data1)) {
        $bi_stone_block += $row1->total_block;
    }
} else {
    $v_current_month = date('Y-m');
    $v_sql1 = "SELECT A.*,
            length,
            width,
            height,
            date_format(date_record,'%d-%m-%Y') as date_ff,
            (length*width*height) as total_block,
            C.name AS counter_name,
            D.user_name, B.block_code, B.floor_id,
            (select name from tbl_inv_location_list where id=B.location_id) as location_bb,  
            (select name from tbl_inv_grade_type_list where id=B.grade_type_id) as grade_type_dd,
            (select name from tbl_inv_color_list where id=B.color_id) as color_ee
            FROM tbl_inv_1_stock_block_stone AS A 
            LEFT JOIN tbl_inv_1_stock_block_stone_detail AS B ON A.id=B.parent_id
            LEFT JOIN tbl_inv_counter_list AS C ON A.counter_id=C.id
            LEFT JOIN tbl_user AS D ON A.user_id=D.user_id
            LEFT JOIN tbl_inv_product_step_list AS F ON B.stock_out_status=F.id
            WHERE DATE_FORMAT(date_record,'%Y-%m')<'$v_current_month' 
            ";
    $get_data1 = $connect->query($v_sql1);
    while ($row1 = mysqli_fetch_object($get_data1)) {
        $bi_stone_block += $row1->total_block;
    }
    $v_old_amo = 0;
}
?>

<div class="">

</div>
<br>
<div class="row">
    <form action="index.php?action=1" method="POST">
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
            <div class="caption font-dark" style="display: inline-block;">
                <?php
                $v_current = date('Y-m-d');
                $sql = $connect->query("SELECT * FROM tbl_inv_1_stock_block_stone WHERE date_record='$v_current'");
                // if(!mysqli_num_rows($sql)){
                echo '<a href="add.php" id="sample_editable_1_new" class="btn green"> Add IN
                                <i class="fa fa-plus"></i>
                            </a>';
                // }
                ?>
          
            </div>
        </div>

            <br>

            
            <br>
            <br>
            <div class="clearfix"></div>
            <div class="col-xs-2">
                <label for="input">Beginning Stone Block :</label>
                <input type="text" name="txt_bigning_bal" readonly="" id="input" class="form-control" value="<?= number_format($bi_stone_block,3) ?> M3" required="required">
            </div>
            <div class="col-xs-2">
                <label for="input">Montly Total Stock In :</label>
                <input type="text" name="txt_tot_stock_in" readonly="" id="input" class="form-control" value="0.000 M3" required="required">
            </div>
            <div class="col-xs-2">
                <label for="input">Montly Total Stock Out :</label>
                <input type="text" name="txt_cash_out" readonly="" id="input" class="form-control" value="0.000 M3" required="required">
            </div>
            <div class="col-xs-2">
                <label for="input">Total Stock Balance :</label>
                <input type="text" name="txt_cash_bal" readonly="" id="input" class="form-control" value="0.000 M3" required="required">
            </div>
            <br>
    </form>
</div>
<br>
<div class="portlet-body">
    <div id="sample_1_wrapper" class="dataTables_wrapper">
        <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_1" role="grid" aria-describedby="sample_1_info">
            <thead>
                <tr role="row" class="text-center">
                    <th>N&deg;</th>
                    <th>Date Record</th>
                    <th>Counter</th>
                    <th>COLOR</th>
                    <th>MAP</th>
                    <th>LAYER</th>
                    <th>GRADE</th>
                    <th>Code Block</th>
                    <th>Length</th>
                    <th>Width</th>
                    <th>Height</th>
                    <th>M3</th>
                    <th style="min-width: 150px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $tot_stone_block=0;
                while ($row = mysqli_fetch_object($get_data)) {

                    echo '<tr>';
                    echo '<td class="text-center">' . (++$i) . '</td>';
                    echo '<td class="text-center">' . $row->date_ff . '</td>';
                    echo '<td class="text-center">' . $row->counter_name . '</td>';
                    echo '<td class="text-center">' . $row->color_ee . '</td>';
                    echo '<td class="text-center">' . $row->location_bb . '</td>';
                    echo '<td class="text-center">' . $row->floor_id . '</td>';
                    echo '<td class="text-center">' . $row->grade_type_dd . '</td>';
                    echo '<td class="text-center">' . $row->block_code . '</td>';
                    echo '<td class="text-center">' . number_format($row->length, 2) . ' m</td>';
                    echo '<td class="text-center">' . number_format($row->width, 2) . ' m</td>';
                    echo '<td class="text-center">' . number_format($row->height, 2) . ' m</td>';
                    echo '<td class="text-center">' . number_format($row->total_block, 3) . ' M3 </td>';
                    echo '<td class="text-center">';
                    echo '<a href="add.php?status=add_more&parent_id=' . $row->id . '" class="btn btn-xs btn-primary" title="Add More"><i class="fa fa-plus"></i></a> ';
                    echo '<a href="#modal" onclick="set_iframe_more_info(' . $row->id . ')" data-toggle="modal" class="btn btn-xs btn-info" title="More Info"><i class="fa fa-info-circle"></i></a> ';
                    echo '<a href="edit.php?edit_id=' . $row->id . '" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                    echo '<a onclick="deleteRecord(' . $row->id . ')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';
                    echo '</td>';
                    echo '</tr>';
                    $tot_stone_block +=$row->total_block;
                }
                ?>
            </tbody>
        </table>
        <input type="hidden" name="txt_t_stone_block" value="<?= $tot_stone_block ?>">
    </div>
</div>
<script type="text/javascript">

    var total_in = $('input[name=txt_t_stone_block]').val();
    total_in = Number(parseFloat(total_in).toFixed(3)).toLocaleString('en', {
        minimumFractionDigits: 3
    });
    $('input[name=txt_tot_stock_in]').val(total_in + " M3");
</script>