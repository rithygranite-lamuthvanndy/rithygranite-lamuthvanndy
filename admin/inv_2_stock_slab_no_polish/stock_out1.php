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
            D.user_name
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
            SUM(sheet) AS total_sheet,
            C.name AS counter_name
            FROM tbl_inv_2_stock_slap_no_polish AS A 
            LEFT JOIN tbl_inv_2_stock_slap_no_polish_detail AS B ON A.id=B.parent_id
            LEFT JOIN tbl_inv_counter_list AS C ON A.counter_id=C.id
            WHERE DATE_FORMAT(date_record,'%Y-%m')='$v_current_month' 
            GROUP BY B.parent_id";
    $get_data = $connect->query($v_sql);
    $v_old_amo = 0;
}
?>
<div class="">
    <div class="caption font-dark">
        <?php
        $sql = $connect->query("SELECT * FROM tbl_inv_1_stock_block_stone WHERE date_record='$now'");
        // if(!mysqli_num_rows($sql)){
        echo '<a href="add.php" id="sample_editable_1_new" class="btn green"> Add New
                    <i class="fa fa-plus"></i>
                </a>';
        // }
        ?>
    </div>
</div>
<br>
<div class="row">
    <form action="index.php?action=2" method="post">
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
<div class="portlet-body">
    <div id="sample_1_wrapper" class="dataTables_wrapper">
        <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_1" role="grid" aria-describedby="sample_1_info">
            <thead>
                <tr role="row" class="text-center">
                    <th class="text-center">N&deg;</th>
                    <th class="text-center">Date Record</th>
                    <th class="text-center">Counter</th>
                    <th class="text-center">Total Length</th>
                    <th class="text-center">Total Width</th>
                    <th class="text-center">Total Height</th>
                    <th class="text-center">Total Sheet</th>
                    <th class="text-center">Stock Out Type</th>
                    <th class="text-center">Note</th>
                    <th style="min-width: 150px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                while ($row = mysqli_fetch_object($get_data)) {
                    $v_sql_count = "SELECT COUNT(*) AS out_count 
                            FROM tbl_inv_2_stock_slap_no_polish_detail 
                            WHERE stock_out_status<>0
                            AND parent_id='$row->id'
                            GROUP BY parent_id";
                    $v_count_out = $connect->query($v_sql_count);
                    $row_count_out = mysqli_fetch_object($v_count_out);
                    echo '<tr>';
                    echo '<td class="text-center">' . (++$i) . '</td>';
                    echo '<td class="text-center">' . $row->date_record . '</td>';
                    echo '<td class="text-center">' . $row->counter_name . '</td>';
                    echo '<td class="text-center">' . number_format($row->total_length, 2) . '</td>';
                    echo '<td class="text-center">' . number_format($row->total_width, 2) . '</td>';
                    echo '<td class="text-center">' . number_format($row->total_height, 2) . '</td>';
                    echo '<td class="text-center">' . number_format($row->total_sheet, 0) . '</td>';
                    echo '<td class="text-center">';
                    echo '<a href="#modal" onclick="set_iframe_out_type(' . $row->id . ')"  data-toggle="modal" class="btn btn-xs btn-primary" title="Stock Out Type">Update Stock Out ( ' . ((@$row_count_out->out_count) ? (@$row_count_out->out_count) : '0') . ' )</a> ';
                    echo '</td>';
                    echo '<td class="text-center">' . $row->note . '</td>';
                    echo '<td class="text-center">';
                    echo '<a href="add.php?status=add_more&parent_id=' . $row->id . '" class="btn btn-xs btn-primary" title="Add More"><i class="fa fa-plus"></i></a> ';
                    echo '<a href="#modal" onclick="set_iframe_more_info(' . $row->id . ')" data-toggle="modal" class="btn btn-xs btn-info" title="More Info"><i class="fa fa-info-circle"></i></a> ';
                    echo '<a href="edit.php?edit_id=' . $row->id . '" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                    echo '<a onclick="deleteRecord(' . $row->id . ')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>