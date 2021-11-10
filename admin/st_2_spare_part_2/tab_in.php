<?php
if (isset($_POST['txt_date_start']) && isset($_POST['txt_date_end'])) {
    $v_date_start = $_POST['txt_date_start'];
    $v_date_end = $_POST['txt_date_end'];
    $condition = "stsin_date_in BETWEEN '$v_date_start' 
                    AND '$v_date_end' 
                    AND stock_status={$_SESSION['action']}";
} else {
    $condition = "DATE_FORMAT(stsin_date_in,'%Y-%m')='" . date('Y-m') . "'
            AND stock_status={$_SESSION['status']}";
}
$sql = "SELECT
        A.*,C.*,B.supsi_name,stun_name,stpron_code,stpron_name_vn,stpron_name_kh,
        (C.in_qty*C.in_price_vn/A.stsin_exchange_rate)+(C.in_qty*C.in_price_dollar) AS total_amo
        FROM tbl_st_stock_in AS A 
        LEFT JOIN tbl_sup_supplier_info AS B ON A.stsin_supp_id=B.supsi_id
        LEFT JOIN tbl_st_stock_in_detail AS C ON A.stsin_id=C.stsin_id
        LEFT JOIN tbl_st_unit_list AS D On C.in_qty=D.stun_id
        LEFT JOIN tbl_st_product_name AS E On C.pro_id=E.stpron_id
        WHERE {$condition} GROUP BY C.std_id,C.stsin_id";
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
                <a target="_blank" href="print_in.php?p_date_start=<?= (@$_POST['txt_date_start'] ? $_POST['txt_date_start'] : date('Y-m-d')) ?>&p_date_end=<?= (@$_POST['txt_date_end'] ? $_POST['txt_date_end'] : date('Y-m-d')) ?>" id="sample_editable_1_new" class="btn yellow">
                    <i class="fa fa-print"></i> Print</a>
                     <a target="_blank" href="in_export_excell.php?p_date_start=<?= (@$_POST['txt_date_start'] ? $_POST['txt_date_start'] : date('Y-m-d')) ?>&p_date_end=<?= (@$_POST['txt_date_end'] ? $_POST['txt_date_end'] : date('Y-m-d')) ?>" id="sample_editable_1_new" class="btn blue">
                <i class="fa fa-share"></i> Export</a>
                <a href="add_in.php" id="sample_editable_1_new" class="btn green"><i class="fa fa-plus-circle"></i> Add Stock In (<?= $_SESSION['title'];?>)</a>
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
                    <th class="all" rowspan="2" style="vertical-align: middle;">N&deg;</th>
                    <th class="all">ថ្ងៃខែ</th>
                    <th class="all">លេខសំណើរ</th>
                    <th class="all">លេខប័ណ្ណ</th>
                    <th class="all">កូដ</th>
                    <th class="all" colspan="2">ឈ្មោះ/Tền</th>
                    <th class="all">ចំនួន</th>
                    <th class="all">ឯកតា</th>
                    <th class="all" colspan="2">តម្លៃ/Giá</th>
                    <th class="all">សរុប</th>
                    <th class="all" rowspan="2" style="min-width: 100px; vertical-align: middle;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                </tr>
                <tr>
                    <th class="all">Ngày</th>
                    <th class="all">Số Đề Nghị</th>
                    <th class="all">số Phiếu</th>
                    <th class="all">Mã</th>
                    <th class="all">VN</th>
                    <th class="all">KH</th>
                    <th class="all">số lượng</th>
                    <th class="all">Đơn vị</th>
                    <th class="all">VN</th>
                    <th class="all">$</th>
                    <th class="all">Tổng công</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                while ($row = mysqli_fetch_object($get_data)) {
                    echo '<tr>';
                    echo '<td>' . (++$i) . '</td>';
                    echo '<td>' . $row->stsin_date_in . '</td>';
                    echo '<td>' . $row->stsin_letter_no . '</td>';
                    echo '<td>' . $row->stsin_req_no . '</td>';
                    echo '<td>' . $row->stpron_code . '</td>';
                    echo '<td>' . $row->stpron_name_vn . '</td>';
                    echo '<td>' . $row->stpron_name_kh . '</td>';
                    echo '<td>' . $row->in_qty . '</td>';
                    echo '<td>' . $row->stun_name . '</td>';
                    echo '<td>' . $row->in_price_vn . '</td>';
                    echo '<td>' . $row->in_price_dollar . '</td>';
                    echo '<td>' . number_format($row->total_amo, 2) . '</td>';
                    echo '<td class="text-center">';
                    echo '<a href="edit_in.php?edit_id=' . $row->stsin_id . '" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-edit"></i></a> ';
                    echo '<a href="delete_in.php?del_detail_id=' . $row->std_id . '&parent_id=' . $row->stsin_id . '" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>