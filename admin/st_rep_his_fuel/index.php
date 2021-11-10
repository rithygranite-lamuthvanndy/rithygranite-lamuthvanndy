<?php
$menu_active = 140;
$left_active = 0;
$layout_title = "Report Truck";
include_once '../../config/database.php';
include_once '../../config/athonication.php';
include_once '../layout/header.php';
include_once '../st_operation/operation.php';
include_once '../st_rep_his_truck/function.php';
?>
<?php
if (isset($_POST['btn_search'])) {
    $date_start = @$_POST['txt_date_start'];
    $date_end = @$_POST['txt_date_end'];
    // echo $n;
    $condition = "AND B.stsout_date_out BETWEEN '$date_start' AND '$date_end' ";
} else {
    $v_current_date = date('Y-m-d');
    // $condition = "AND B.stsout_date_out='$v_current_date'";
    $condition = "AND 1=1";
}
?>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2 style="font-family: 'khmer'; float: left;"><i class="fa fa-file"></i> របាយការណ៍ប្រើប្រាស់ប្រេងតាមគ្រឿងចក្រ </h2>
        </div>
        <div class="col-xs-7">
            <form action="#" method="post">
                <div class="col-sm-4">
                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                        <input type="text" class="form-control" value="<?= @$_POST['txt_date_start'] ?>" name="txt_date_start" placeholder="Choose Date Start ..." required="" aufocomplete="off">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                        <input type="text" class="form-control" value="<?= @$_POST['txt_date_end'] ?>" name="txt_date_end" placeholder="Choose Date End ..." required="" aufocomplete="off">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="caption font-dark" style="display: inline-block;">
                        <button type="submit" name="btn_search" id="sample_editable_1_new" class="btn blue btn-md"> Search
                            <i class="fa fa-search"></i>
                        </button>

                        <a class="btn btn-md btn-danger" href="index.php" role="button"><i class="fa fa-undo"></i> Clear</a>

                    </div>
                </div>
                <br>
                <br>
            </form>
        </div>
        <br>
        <?php
        $v_sql = "SELECT * FROM tbl_st_product_name WHERE stpron_material_type='4' ORDER BY stpron_id";
        $result_pro = $connect->query($v_sql);
        $arr_pro_name = [];
        while ($row_pro = mysqli_fetch_object($result_pro)) {
            $obj_tmp = null;
            @$obj_tmp->pro_id = $row_pro->stpron_id;
            @$obj_tmp->pro_name_vn = $row_pro->stpron_name_vn;
            @$obj_tmp->pro_name_kh = $row_pro->stpron_name_kh;
            array_push($arr_pro_name, $obj_tmp);
        }
        // echo json_encode($arr_pro_name);
        ?>
        <div class="portlet-body">
            <div id="sample_1_wrapper" class="dataTables_wrapper" style="overflow-x: scroll;">
                <table class="table table-striped table-bordered table-hover dataTable dtr-inline myTableNowrap" role="grid" aria-describedby="sample_1_info">
                    <thead>
                        <tr>
                            <th>កូដ</th>
                            <th colspan="2" class="text-center">ឈ្មោះ</th>
                            <?php
                            foreach ($arr_pro_name as $key => $value)
                                echo '<th  class="text-center" colspan="2">' . $value->pro_name_kh . '</th>';
                            ?>
                        </tr>
                        <tr>
                            <th>-</th>
                            <th>VN</th>
                            <th>KH</th>
                            <?php
                            foreach ($arr_pro_name as $key => $value)
                                echo '<th  class="text-center" colspan="2">' . $value->pro_name_vn . '</th>';
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $idx = 0;
                        $v_sql = "SELECT 
                                    A.*,D.pti_project_title,C.name_vn,C.name_kh,B.stsout_date_out
                                    FROM tbl_st_stock_out_detail AS A 
                                    LEFT JOIN tbl_st_stock_out AS B ON A.stsout_id=B.stsout_id
                                    LEFT JOIN tbl_st_track_machine_list AS C ON A.track_mac_id=C.id
                                    LEFT JOIN tbl_pj_project_title AS D ON A.project_id=D.pti_id
                                    WHERE B.stock_status=4 {$condition}
                                    GROUP BY A.pro_id
                                    ";
                        // echo $v_sql;
                        $v_result = $connect->query($v_sql);
                        $arr_total_summary_monthly = [];
                        $v_cat_name_tmp = [];
                        $arr_total_amo = [];
                        $arr_total_amo_type = [];
                        $v_pro_ject_id=0;
                        while ($row = mysqli_fetch_object($v_result)) {
                            if (!in_array($row->project_id, $v_cat_name_tmp)) {
                                array_push($v_cat_name_tmp, $row->project_id);
                                echo '<tr class="bg-blue">';
                                echo '<td colspan="15">' . $row->pti_project_title . '</td>';
                                echo '</tr>';
                                $v_pro_ject_id= $row->project_id;
                            }
                            echo '<tr>';
                            echo '<td></td>';
                            echo '<td>' . $row->name_vn . '</td>';
                            echo '<td>' . $row->name_kh . '</td>';
                            foreach ($arr_pro_name as $key => $value) {
                                $arr_tmp = getEachQty_Price($v_pro_ject_id,$row->track_mac_id, $row->stsout_date_out, $value->pro_id);
                                $arr_tmp = json_decode($arr_tmp);
                                // echo $arr_tmp;
                                echo '<td class="text-right">' . ($arr_tmp->qty ? $arr_tmp->qty : '0') . '</td>';
                                echo '<td>';
                                echo '<span class="pull-left">$</span>';
                                echo '<span class="pull-right">';
                                echo ($arr_tmp->qty ? number_format($arr_tmp->price, 2) : '-');
                                // echo number_format($arr_tmp->price, 2);
                                echo '</span>';
                                echo '</td>';
                                $arr_total_amo[$value->pro_id]['qty'] = @$arr_total_amo[$value->pro_id]['qty'] += $arr_tmp->qty;
                                $arr_total_amo[$value->pro_id]['price'] = @$arr_total_amo[$value->pro_id]['price'] += ($arr_tmp->qty ? $arr_tmp->price : 0);

                                @$arr_total_amo_type[$v_pro_ject_id][$value->pro_id]['qty'] += $arr_tmp->qty;
                                @$arr_total_amo_type[$v_pro_ject_id][$value->pro_id]['price'] += $arr_tmp->price;
                            }
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-right">
                                សរុប:
                            </th>
                            <?php
                            foreach ($arr_pro_name as $key => $value) {
                                echo '<th class="text-right">' . @$arr_total_amo[$value->pro_id]['qty'] . '</th>';
                                echo '<th>';
                                echo '<span class="pull-left">$</span>';
                                echo '<span class="pull-right">';
                                echo  number_format(@$arr_total_amo[$value->pro_id]['price'], 2);
                                echo '</span>';
                                echo '</th>';
                            }
                            ?>
                        </tr>
                    </tfoot>
                </table>
                <br><br>
                <!-- Table 2 -->
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th colspan="2">DESCRIPTION</th>
                            <?php
                            foreach ($arr_pro_name as $key => $value)
                                echo '<th  class="text-center" colspan="2">' . $value->pro_name_vn . '</th>';
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // echo json_encode($arr_total_amo_type);
                        $i = 0;
                        $v_sql = "SELECT * FROM tbl_pj_project_title ORDER BY pti_id";
                        $v_result_summary = $connect->query($v_sql);
                        while ($row_summary = mysqli_fetch_object($v_result_summary)) {
                            // $v_arr_result = summaryMaterial($row_summary->stca_id, $v_arr_summary);
                            echo '<tr>';
                            echo '<td>' . (++$i) . '</td>';
                            echo '<td>' . $row_summary->pti_project_title_vn . '</td>';
                            echo '<td>' . $row_summary->pti_project_title . '</td>';
                            foreach ($arr_pro_name as $key => $value) {
                                echo '<th  class="text-center">' . @$arr_total_amo_type[$row_summary->pti_id][$value->pro_id]['qty'] . '</th>';
                                echo '<th  class="text-center">';
                                echo '<span class="pull-left">$</span>';
                                echo '<span class="pull-right">';
                                echo (@$arr_total_amo_type[$row_summary->pti_id][$value->pro_id]['qty'] ?
                                    number_format($arr_total_amo_type[$row_summary->pti_id][$value->pro_id]['price'], 2) : '-');
                                echo '</span>';
                                echo '</th>';
                            }
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php include_once '../layout/footer.php' ?>

    <?php
    function getEachQty_Price($p_project_id,$p_track, $v_date, $p_pro_id)
    {
        global $connect;
        $v_sql = "SELECT 
                SUM(B.out_qty) AS sum_qty 
                FROM tbl_st_stock_out AS A 
                LEFT JOIN tbl_st_stock_out_detail AS B ON A.stsout_id=B.stsout_id
                WHERE stsout_date_out='$v_date'
                AND track_mac_id='$p_track'
                AND stock_status='4'
                AND B.project_id='$p_project_id'
                AND B.pro_id='$p_pro_id'
                ";
        // echo $v_sql.'<br><br>';
        $result = $connect->query($v_sql);
        $v_result = ['qty' => 0, 'price' => 0];
        while ($row = mysqli_fetch_object($result)) {
            $amo = getCostPerProductName($v_date, $p_pro_id, 4);
            $v_result = [
                'qty' => $v_result['qty'] += @$row->sum_qty,
                'price' => $v_result['price'] += $amo
            ];
        }
        return json_encode($v_result);
    }
    ?>