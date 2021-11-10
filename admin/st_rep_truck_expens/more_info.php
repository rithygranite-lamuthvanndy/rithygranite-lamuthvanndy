<?php
$menu_active = 140;
$left_active = 0;
$layout_title = "Report Truck Detail";
include_once '../../config/database.php';
include_once '../../config/athonication.php';
include_once '../layout/header.php';
include_once '../st_operation/operation.php';
?>
<?php
if (isset($_REQUEST['track_id'])) {
    $v_track_id = $_REQUEST['track_id'];
    $v_sql_report = "SELECT A.* 
                FROM tbl_st_track_machine_list AS A 
                WHERE A.id=' $v_track_id'";
    $row_get_data_master = mysqli_fetch_object($connect->query($v_sql_report));
}
?>
<style type="text/style">
    .group_month td{
        background-color: #8bc4d6;
    }
    table tfoot tr th{
        /* background-color: #bbb0b9!important; */
        /* background-color: red; */
    }
</style>
<div class="portlet light bordered">
    <a class="btn btn-md btn-danger" style="float: right;" href="index.php" onclick="window.close();"><i class="fa fa-close"></i> Close</a>
    <div class="row">
        <div class="col-xs-12">
            <h2 style="font-family: 'khmer';"><i class="fa fa-file"></i> តារាងតាមដានការជួសជុលគ្រឿងចក្រ </h2>
            <label>ឈ្មោះគ្រឿងចក្រ: <span class="text-primary"><?= $row_get_data_master->name_vn ?></span></label><br>
            <label>កាលបរិច្ឆេទទិញ: <span class="text-primary"><?= $row_get_data_master->date_buy ?></span></label><br>
            <label>តម្លៃគ្រឿងចក្រ: <span class="text-primary"><?= $row_get_data_master->track_price ?></span></label><br>
        </div>
    </div>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper" style="overflow-x: scroll;">
            <table class="table table-striped table-bordered table-hover myTableNowrap">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>ថ្ងៃខែឆ្នាំ</th>
                        <th>លេខសំណើរ</th>
                        <th>ឈ្មោះសំភារះ</th>
                        <th>ទំហំ</th>
                        <th>ចំនួន</th>
                        <th>ឯកតា</th>
                        <th>តម្លៃរាយ</th>
                        <th>សរុប</th>
                        <th>សរុបក្នុងខែ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    $v_gounp_month_year = null;
                    $v_gounp_letter_no = null;
                    $v_sql_detail = "SELECT 
                                    A.stsout_date_out,A.stsout_letter_no,B.out_qty,B.pro_id,C.stpron_name_vn,
                                    DATE_FORMAT(A.stsout_date_out,'%m/%Y') AS group_month,
                                    B.out_qty,
                                    D.stun_name,B.stsout_id,
                                    (
                                        SELECT 
                                        COUNT(*)
                                        FROM tbl_st_stock_out_detail AS AA 
                                        WHERE AA.track_mac_id=B.track_mac_id
                                        AND AA.stsout_id=A.stsout_id
                                    ) AS group_letter_no,
                                    (
                                        SELECT 
                                            COUNT(*)
                                        FROM tbl_st_stock_out_detail AS AA 
                                        LEFT JOIN tbl_st_stock_out AS BB ON AA.stsout_id=BB.stsout_id
                                        WHERE AA.track_mac_id=B.track_mac_id
                                        AND BB.stock_status=A.stock_status
                                        AND DATE_FORMAT(BB.stsout_date_out,'%Y-%m')=DATE_FORMAT(A.stsout_date_out,'%Y-%m')
                                    ) AS group_row_monthly
                                    FROM tbl_st_stock_out AS A 
                                    LEFT JOIN tbl_st_stock_out_detail AS B ON A.stsout_id=B.stsout_id
                                    LEFT JOIN tbl_st_product_name AS C ON B.pro_id=C.stpron_id
                                    LEFT JOIN tbl_st_unit_list AS D ON B.unit_id=D.stun_id
                                    WHERE A.stock_status=3
                                    AND B.track_mac_id='$v_track_id'
                                    GROUP BY B.std_id,MONTH(A.stsout_date_out),YEAR(A.stsout_date_out)
                                    ORDER BY A.stsout_date_out";
                    $v_result = $connect->query($v_sql_detail);
                    $status_month = 0;
                    $v_total_monthly = 0;
                    // getTotalMonthly($p_result);
                    while ($row = mysqli_fetch_object($v_result)) {
                        if ($v_gounp_month_year != $row->group_month) {
                            ++$status_month;
                            // $v_total_monthly = 0;
                            echo '<tr data_month="' . $status_month . '">';
                            echo '<td colspan="10">' . $row->group_month . '</td>';
                            echo '</tr>';
                            $v_gounp_month_year = $row->group_month;
                            $is_new_month = true;
                        } else {
                            $is_new_month = false;
                        }
                        $v_unit_price = getCostPerProductName($row->stsout_date_out, $row->pro_id, 3);
                        echo '<tr data_price_each="' . $status_month . '" row_group="' . $row->group_row_monthly . '">';
                        echo '<td>' . (++$i) . '</td>';
                        echo '<td>' . $row->stsout_date_out . '</td>';
                        if ($v_gounp_letter_no != $row->stsout_id) {
                            echo '<td rowspan="' . $row->group_letter_no . '">' . $row->stsout_letter_no . '</td>';
                            $v_gounp_letter_no = $row->stsout_id;
                        }
                        echo '<td>' . $row->stpron_name_vn . '</td>';
                        echo '<td>-</td>';
                        echo '<td>' . $row->out_qty . '</td>';
                        echo '<td>' . $row->stun_name . '</td>';
                        echo '<td>';
                        echo '<span class="pull-left">$</span>';
                        echo '<span class="pull-right">' . number_format($v_unit_price, 2) . '</span>';
                        echo '</td>';
                        echo '<td data_price="' . $v_unit_price * $row->out_qty . '">';
                        echo  '<span class="pull-left">$</span>';
                        echo '<span class="pull-right">' . number_format($v_unit_price * $row->out_qty, 2) . '</span>';
                        echo '</td>';
                        $v_total_monthly += $v_unit_price * $row->out_qty;
                        if ($is_new_month)
                            echo '<td class="monthly_price" rowspan="' . $row->group_row_monthly . '">' . number_format($v_total_monthly) . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr class="bg-blue">
                        <th colspan="9" class="text-right">TOTAL:</th>
                        <th>
                            <span class="pull-left">$</span> 
                            <span class="pull-right"><?= number_format($v_total_monthly, 2) ?></span>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?php include_once '../layout/footer.php' ?>
<script src="../../plugin/numeral/numeral.min.js"></script>
<script>
    $(document).ready(function() {
        var v_status_parent = 0;
        var v_status = 0;
        var v_price_total = 0;
        var v_flag = 0;
        $('table tbody tr').each(function() {
            v_status_parent = $(this).attr('data_price_each');
            v_group_row = $(this).attr('row_group');
            v_price = parseFloat($(this).find('td[data_price]').attr('data_price'));
            if (v_status != v_status_parent) {
                obj_first = $(this);
                v_status = v_status_parent;
                v_obj = $(this).parent('tr').html();
                v_price_total = v_price;
                v_flag = 0;
            } else {
                v_price_total += v_price;
            }
            ++v_flag;
            if (v_flag == v_group_row) {
                v_span_left = `<span class="pull-left">$</span>`;
                v_span_left = `${v_span_left}<span class="pull-right">${numeral(v_price_total).format('0,0.00')}</span>`;
                obj_first.find('td:last-child').html(v_span_left);
            }
        });
    });
</script>