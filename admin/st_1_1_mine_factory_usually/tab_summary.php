<?php
include_once '../st_operation/operation.php';
?>
<?php
if (isset($_POST['txt_date_start']) || isset($_POST['txt_date_end'])) {
    $v_date_start = $_POST['txt_date_start'];
    $v_date_end = $_POST['txt_date_end'];
} else {
    $v_date_start = date('Y-m-01');
    $v_date_end = date('Y-m-t');
}
$v_sql = "SELECT A.*,B.*,B.stca_name,B.stca_code,C.stun_name,B.stca_id,

                (
                    (
                        SELECT IFNULL(SUM(in_qty),0)
                        FROM tbl_st_stock_in AS AA 
                        LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                        WHERE AA.stsin_date_in<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )-
                    (
                        SELECT IFNULL(SUM(out_qty),0)
                        FROM tbl_st_stock_out AS AA 
                        LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
                        WHERE AA.stsout_date_out<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )+
                    (
                        SELECT IFNULL(SUM(qty_adjust),0)
                        FROM tbl_st_stock_adjustment AS AA 
                        LEFT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
                        WHERE  AA.stsadj_date_record <'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )
                ) AS begining_bal_qty,
                (
                    (
                        SELECT SUM(
                                    (IFNULL(in_qty,0)*in_price_vn/stsin_exchange_rate)
                                        +(in_price_dollar*IFNULL(in_qty,0))
                                    )
                        FROM tbl_st_stock_in AS AA 
                        LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                        WHERE AA.stsin_date_in<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )
                ) AS begining_bal_price,
                (
                    SELECT CONCAT(
                                SUM(in_qty),
                                '=',
                                SUM((in_price_vn/stsin_exchange_rate)+in_price_dollar)*IFNULL(SUM(in_qty),0)
                            )
                    FROM tbl_st_stock_in AS AA 
                    LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                    WHERE  AA.stsin_date_in BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                ) current_in,
                (
                    SELECT SUM(out_qty) 
                    FROM tbl_st_stock_out AS AA 
                    LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
                    WHERE  AA.stsout_date_out BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                ) current_out,
                (
                    SELECT SUM(BB.qty_adjust) 
                    FROM tbl_st_stock_adjustment AS AA 
                    RIGHT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
                    WHERE  AA.stsadj_date_record BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                )current_adjust
                FROM tbl_st_product_name AS A 
                LEFT JOIN tbl_st_category_list AS B ON A.stpron_category=B.stca_id
                LEFT JOIN tbl_st_unit_list AS C ON A.stpron_unit=C.stun_id
                WHERE A.stpron_material_type='$_SESSION[status]'
                HAVING 

                (
                    (
                        SELECT IFNULL(SUM(in_qty),0)
                        FROM tbl_st_stock_in AS AA 
                        LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                        WHERE AA.stsin_date_in<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )-
                    (
                        SELECT IFNULL(SUM(out_qty),0)
                        FROM tbl_st_stock_out AS AA 
                        LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
                        WHERE AA.stsout_date_out<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )+
                    (
                        SELECT IFNULL(SUM(qty_adjust),0)
                        FROM tbl_st_stock_adjustment AS AA 
                        LEFT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
                        WHERE  AA.stsadj_date_record BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                        AND BB.pro_id=A.stpron_id
                    )
                )>0 OR 
                (
                    SELECT SUM(in_qty) 
                    FROM tbl_st_stock_in AS AA 
                    LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                    WHERE  AA.stsin_date_in BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                )>0 OR
                (
                    SELECT SUM(out_qty) 
                    FROM tbl_st_stock_out AS AA 
                    LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
                    WHERE  AA.stsout_date_out BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                )>0 
                OR 
                (
                    SELECT SUM(qty_adjust)
                    FROM tbl_st_stock_adjustment AS AA 
                    LEFT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
                    WHERE  AA.stsadj_date_record BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                )<>0 ORDER BY B.stca_code ASC,A.stpron_code ASC
                ";
//echo $v_sql;
$get_data = $connect->query($v_sql);
?>
<style type="text/css">
    .mycustomtable tbody,
    .mycustomtable thead,
    .mycustomtable tfoot {
        white-space: nowrap;
    }

    .myqty {
        font-weight: bold;
    }

    .myprice {
        font-weight: bold;
        color: #FF0000;
        background-color: #F2F2F2;
    }

    .myavg {
        color: #39EB7C;
    }

    .myavg:before,
    .myprice:before {
        content: '$ ';
        padding-right: 5px;
    }
    .table th {
        
            background: #DDEBF7 !important;
            font-weight: bold !important;
            border: 1px solid white !important;
    }
</style>
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
            </div>
            <a target="_blank" href="print_summary.php?p_date_start=<?= (@$_POST['txt_date_start'] ? $_POST['txt_date_start'] : date('Y-m-d')) ?>&p_date_end=<?= (@$_POST['txt_date_end'] ? $_POST['txt_date_end'] : date('Y-m-d')) ?>" id="sample_editable_1_new" class="btn yellow">
                <i class="fa fa-print"></i> Print</a>
            <a target="_blank" href="export_excell.php?p_date_start=<?= (@$_POST['txt_date_start'] ? $_POST['txt_date_start'] : date('Y-m-d')) ?>&p_date_end=<?= (@$_POST['txt_date_end'] ? $_POST['txt_date_end'] : date('Y-m-d')) ?>" id="sample_editable_1_new" class="btn blue">
                <i class="fa fa-share"></i> Export</a>
        </div>
    </form>
</div>
<br>
<div class="portlet-body">
    <div style="overflow-x:auto;">
        <table class="table table-striped table-bordered table-hover dataTable dtr-inline mycustomtable">
            <thead>
                <tr role="row" class="text-center">
                    <th>កូដ</th>
                    <th colspan="2" class="text-center">ឈ្មោះសំភារៈ</th>
                    <th class="text-center">តម្លៃ/មធម្យភាគ</th>
                    <th colspan="3" class="text-center">ស្ដុកដើមគ្រា</th>
                    <th colspan="2" class="text-center">ស្ដុកចូល</th>
                    <th colspan="2" class="text-center">ស្ដុកចេញ</th>
                    <th colspan="2" class="text-center">ស្ដុកកែតម្រូវ</th>
                    <th colspan="2" class="text-center">ស្ដុកចុងគ្រា</th>
                </tr>
                <tr>
                    <th>Mã</th>
                    <th>Tền Vật Tư</th>
                    <th>Tền Vật Tư</th>
                    <th>GÍA USD/Trung bình</th>
                    <th colspan="2">TỒN ĐẦU</th>
                    <th>$</th>
                    <th>XUẤT</th>
                    <th>$</th>
                    <th>NHẬP</th>
                    <th>$</th>
                    <th>Đã sửa</th>
                    <th>$</th>
                    <th>TỒN</th>
                    <th>$</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $v_cat_name_tmp = [];

                $v_total_price_beg = 0;
                $v_total_price_in = 0;
                $v_total_qty_in = 0;
                $v_total_price_out = 0;
                $v_total_qty_out = 0;
                $v_total_price_adjust = 0;
                $v_total_qty_adjust = 0;
                $v_total_price_bal = 0;
                $v_total_qty_bal = 0;
                $v_arr_summary = [];
                while ($row = mysqli_fetch_object($get_data)) {
                    if (!in_array($row->stca_name, $v_cat_name_tmp)) {
                        array_push($v_cat_name_tmp, $row->stca_name);
                        echo '<tr class="bg-blue">';
                        echo '<td colspan="15">' . $row->stca_code . ' - ' . $row->stca_name . '</td>';
                        echo '</tr>';
                    }
                    // =========================== Start Calculation ====================
                    $v_begining_bal_qty = ($row->begining_bal_qty ?: 0);
                    $v_begining_bal_price = round(($row->begining_bal_price ?: 0), 2);

                    $v_arr_in = explode("=", $row->current_in);
                    $v_current_in_qty = (@$v_arr_in[0] ?: 0);
                    $v_current_in_price = round((@$v_arr_in[1] ?: 0), 2);

                    $v_array = [
                        'begining_bal_price' => $v_begining_bal_price,
                        'begining_bal_qty' => $v_begining_bal_qty,
                        'current_in_price' => $v_current_in_price,
                        'current_in_qty' => $v_current_in_qty
                    ];

                    $result_cost = myCalCostAverage($v_array);

                    $v_last_qty = ($v_begining_bal_qty + $v_current_in_qty - @$row->current_out + @$row->current_adjust);
                    // =========================== End Calculation ====================


                    echo '<tr>';
                    echo '<td>' . $row->stpron_code . '</td>';
                    echo '<td>' . $row->stpron_name_vn . '</td>';
                    echo '<td>' . $row->stpron_name_kh . '</td>';
                    echo '<td class="myavg">' . number_format($result_cost, 2) . '</td>';
                    echo '<td class="myqty">' . $v_begining_bal_qty . '</td>';
                    echo '<td>' . $row->stun_name . '</td>';
                    echo '<td class="myprice">' . number_format($v_begining_bal_price, 2) . '</td>';
                    echo '<td class="myqty">' . $v_current_in_qty . '</td>';
                    echo '<td class="myprice">' . number_format($v_current_in_price, 2) . '</td>';
                    echo '<td class="myqty">' . ($row->current_out ?: 0) . '</td>';
                    echo '<td class="myprice">' . number_format($result_cost * $row->current_out, 2) . '</td>';
                    echo '<td class="myqty">' . ($row->current_adjust ?: 0) . '</td>';
                    echo '<td class="myprice">' . number_format($result_cost * $row->current_adjust, 2) . '</td>';
                    echo '<td class="myqty">' . $v_last_qty . '</td>';
                    echo '<td class="myprice">' . number_format($v_last_qty * $result_cost, 2) . '</td>';
                    echo '</tr>';

                    $v_total_price_beg += $v_begining_bal_price;
                    $v_total_qty_in += $v_current_in_qty;
                    $v_total_price_in += $v_current_in_price;
                    $v_total_price_out += $result_cost * $row->current_out;
                    $v_total_qty_out += $row->current_out;
                    $v_total_price_adjust += $result_cost * $row->current_adjust;
                    $v_total_qty_adjust += $row->current_adjust;
                    $v_total_price_bal += $v_last_qty * $result_cost;
                    $v_total_qty_bal += $v_last_qty;

                    $arr_child = [
                        $row->stca_id => $row->stca_id,
                        'price_beg' => $v_begining_bal_price,
                        'price_in' => $v_current_in_price,
                        'price_out' => $result_cost * $row->current_out,
                        'price_adjust' => $result_cost * $row->current_adjust,
                        'price_end' => $v_last_qty * $result_cost
                    ];
                    array_push($v_arr_summary, $arr_child);
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="6" class="text-center">CỘNG/សរុប</th>
                    <th class="myprice"><?= number_format($v_total_price_beg, 2) ?></th>
                    <th class="myqty"><?= $v_total_qty_in ?></th>
                    <th class="myprice"><?= number_format($v_total_price_in, 2) ?></th>
                    <th class="myqty"><?= $v_total_qty_out ?></th>
                    <th class="myprice"><?= number_format($v_total_price_out, 2) ?></th>
                    <th class="myqty"><?= $v_total_qty_adjust ?></th>
                    <th class="myprice"><?= number_format($v_total_price_adjust, 2) ?></th>
                    <th class="myqty"><?= $v_total_qty_bal ?></th>
                    <th class="myprice"><?= number_format($v_total_price_bal, 2) ?></th>
                </tr>
            </tfoot>
        </table>
        <br>

        <!-- Table 2 -->
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>DESCRIPTION</th>
                    <th>BEGINNING</th>
                    <th>IN (NHẬP)</th>
                    <th>OUT (XUẤT)</th>
                    <th>ADJUST (XUẤT)</th>
                    <th>END (TỒN)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                ?>
                <?php
                $i = 0;
                $v_sql = "SELECT * FROM tbl_st_category_list WHERE material_type_id='$_SESSION[status]' ORDER BY stca_code ";
                $v_result_summary = $connect->query($v_sql);
                while ($row_summary = mysqli_fetch_object($v_result_summary)) {
                    $v_arr_result = summaryMaterial($row_summary->stca_id, $v_arr_summary);
                    echo '<tr>';
                    echo '<td>' . (++$i) . '</td>';
                    echo '<td>' . $row_summary->stca_name . '</td>';
                    echo '<td class="myprice">' . number_format($v_arr_result['t_price_beg'], 2) . '</td>';
                    echo '<td class="myprice">' . number_format($v_arr_result['t_price_in'], 2) . '</td>';
                    echo '<td class="myprice">' . number_format($v_arr_result['t_price_out'], 2) . '</td>';
                    echo '<td class="myprice">' . number_format($v_arr_result['t_price_adjust'], 2) . '</td>';
                    echo '<td class="myprice">' . number_format($v_arr_result['t_price_end'], 2) . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>