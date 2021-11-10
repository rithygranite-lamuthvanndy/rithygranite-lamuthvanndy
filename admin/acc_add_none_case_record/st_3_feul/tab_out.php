<?php
if(isset($_POST['txt_date_start'])&&isset($_POST['txt_date_end'])){
    $v_date_start = $_POST['txt_date_start'];
    $v_date_end = $_POST['txt_date_end'];
    $condition = "stsout_date_out BETWEEN '$v_date_start' 
                    AND '$v_date_end' 
                    AND stock_status={$_SESSION['status']}";
} else {
    $condition = "DATE_FORMAT(A.stsout_date_out,'%Y-%m')='" . date('Y-m') . "'
            AND A.stock_status={$_SESSION['status']}";
}
$sql = "SELECT
            A.*,B.*,C.stman_name,E.stpron_code,E.stpron_name_vn,E.stpron_name_kh,D.stun_name,
			F.name_vn as machine_name,
			G.name AS pro_type_name
            FROM tbl_st_stock_out AS A 
            LEFT JOIN tbl_st_stock_out_detail AS B ON A.stsout_id=B.stsout_id
            LEFT JOIN tbl_st_manager_list AS C ON A.stsout_man_id=C.stman_id
            LEFT JOIN tbl_st_unit_list AS D ON B.unit_id=D.stun_id
            LEFT JOIN tbl_st_product_name AS E ON B.pro_id=E.stpron_id
            LEFT JOIN tbl_st_track_machine_list AS F ON B.track_mac_id=F.id
            LEFT JOIN tbl_st_product_type_list AS G ON B.pro_type_id=G.id
        WHERE {$condition} GROUP BY B.std_id";
// echo $sql;
$get_data = $connect->query($sql);
?>
<div class="row">
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" id="form">
        <div class="col-sm-2">
            <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                <input autocomplete="off" onchange="this.form.submit()" name="txt_date_start" value="<?= @$_POST['txt_date_start'] ?>" type="text" class="form-control" placeholder="Date From ....">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                <input autocomplete="off" onchange="this.form.submit()" name="txt_date_end" value="<?= @$_POST['txt_date_end'] ?>" type="text" class="form-control" placeholder="Date To">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="caption font-dark" style="display: inline-block;">
                <a href="index.php" id="sample_editable_1_new" class="btn btn-danger"><i class="fa fa-undo"></i> Clear</a>
                <a target="_blank" href="print_out.php?p_date_start=<?= (@$_POST['txt_date_start'] ? $_POST['txt_date_start'] : date('Y-m-d')) ?>&p_date_end=<?= (@$_POST['txt_date_end'] ? $_POST['txt_date_end'] : date('Y-m-d')) ?>" id="sample_editable_1_new" class="btn yellow">
                    <i class="fa fa-print"></i> Print</a>
                <a href="add_out.php" id="sample_editable_1_new" class="btn green"><i class="fa fa-plus-circle"></i> Add Stock Out (<?= $_SESSION['title'] ?>)</a>
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
                    <th rowspan="2" style="vertical-align: middle;">N&deg;</th>
                    <th>ថ្ងៃខែ</th>
                    <th>លេខសំណើរ</th>
                    <th>អ្នកទទួល</th>
                    <th>កូដ</th>
                    <th colspan="2" class="text-center">ឈ្មោះប្រភេទប្រើប្រាស់</th>
                    <th>តំបន់</th>
                    <th>ចំនួន/លីត្រ</th>
                    <th>ឯកតា</th>
                    <th rowspan="2">ម៉ាស៊ីន/គ្រឿងចក្រ</th>
                    <th rowspan="2" style="min-width: 100px; vertical-align: middle;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                </tr>
                <tr>
                    <th>Ngày</th>
                    <th>Người Nhận</th>
                    <th>số Phiếu</th>
                    <th>Mã</th>
                    <th>VN</th>
                    <th>KH</th>
                    <th>Khu vực</th>
                    <th>Số Lơửng/L</th>
                    <th>Đơn vị</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                while ($row = mysqli_fetch_object($get_data)) {
                    echo '<tr>';
                    echo '<td>' . (++$i) . '</td>';
                    echo '<td>' . $row->stsout_date_out . '</td>';
                    echo '<td>' . $row->stsout_letter_no . '</td>';
                    echo '<td>' . $row->stman_name . '</td>';
                    echo '<td>' . $row->stpron_code . '</td>';
                    echo '<td>' . $row->stpron_name_vn . '</td>';
                    echo '<td>' . $row->stpron_name_kh . '</td>';
                    echo '<td>' . $row->pro_type_name . '</td>';
                    echo '<td>' . $row->out_qty . '</td>';
                    echo '<td>' . $row->stun_name . '</td>';
                    echo '<td>' . $row->machine_name . '</td>';
                    echo '<td class="text-center">';
                    echo '<a href="edit_out.php?edit_id=' . $row->stsout_id . '" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-edit"></i></a> ';
                    echo '<a href="delete_out.php?del_detail_id=' . $row->std_id . '&parent_id=' . $row->std_id . '" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>