<?php
$menu_active = 140;
$left_active = 0;
$layout_title = "Report Truck";
include_once '../../config/database.php';
include_once '../../config/athonication.php';
include_once '../layout/header.php';
include_once '../st_operation/operation.php';
include_once 'function.php';
?>
<?php
if (isset($_POST['btn_search'])) {
    $date1 = date($_POST['txt_month_start'] . '-01');
    $date2 = date($_POST['txt_month_end'] . '-31');
    $date_diff = strtotime($date2) - strtotime($date1);
    $n = floor(($date_diff) / 2628000);
    // echo $n;
}
$n=(@$n? @$n:0);
?>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2 style="font-family: 'khmer'; float: left;"><i class="fa fa-file"></i> របាយការណ៍ជួសជុលគ្រឿងចក្រ</h2>
        </div>
        <div class="col-xs-7">
            <form action="#" method="post">
                <div class="col-sm-4">
                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                        <input type="text" class="form-control monthpicker" value="<?= @$_POST['txt_month_start'] ?>" name="txt_month_start" placeholder="Choose Month ..." required="" aufocomplete="off">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control monthpicker" value="<?= @$_POST['txt_month_end'] ?>" name="txt_month_end" placeholder="Choose Month ..." required="" aufocomplete="off">
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
        <div class="portlet-body">
            <div id="sample_1_wrapper" class="dataTables_wrapper" style="overflow-x: scroll;">
                <table class="table table-striped table-bordered table-hover dataTable dtr-inline myTableNowrap" role="grid" aria-describedby="sample_1_info">
                    <thead>
                        <tr>
                            <th>N&deg;</th>
                            <th>-</th>
                            <th colspan="2">-</th>
                            <th>-</th>
                            <th>-</th>
                            <th>-</th>
                            <th>-</th>
                            <th>-</th>
                            <th>-</th>
                        </tr>
                        <tr>
                            <th rowspan="2">ល.រ</th>
                            <th rowspan="2">កាលបរិច្ឆេទទិញ</th>
                            <th colspan="2">ឈ្មោះគ្រឿងចក្រ</th>
                            <th rowspan="2">តម្លៃគ្រឿងចក្រ</th>
                            <th rowspan="2">%</th>
                            <th rowspan="2">មុខងារ&ប្រចាំការ</th>
                            <th rowspan="2">សរុបការជួសជុលទាំងអស់</th>
                            <th rowspan="2">សរុបការជួសជុល2018</th>
                            <th rowspan="2">សរុបការជួសជុល2019</th>
                            <?php
                            if ($n!=0) {
                                echo  '<th colspan="' . $n . '" style="text-align: center;">ទឹកប្រាក់ជួសជុលតាមខែ</th>';
                            }
                            ?>
                        </tr>
                        <tr>
                            <th>ខ្មែរ</th>
                            <th>វៀតណាម</th>
                            <?php
                                for ($i = 1; $i <= $n; $i++) {
                                    $month_name_year = date('F', mktime(0, 0, 0, $i, 1, date('Y'))) . '-' . date('y');
                                    echo '<th>' . $month_name_year . '</th>';
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $idx = 0;
                        $v_sql = "SELECT A.* 
                            FROM tbl_st_track_machine_list AS A 
                            ORDER BY name_vn";
                        $v_result = $connect->query($v_sql);
                        $arr_total_summary_monthly = [];
                        while ($row = mysqli_fetch_object($v_result)) {
                            $obj_result = json_decode(getSummaryHistoyofTrack($row->id));
                            echo '<tr>';
                            echo '<td>' . (++$idx) . '</td>';
                            // echo '<td>' . $obj_result . '</td>';
                            echo '<td>' . $row->date_buy . '</td>';
                            echo '<td>' . $row->name_kh . '</td>';
                            echo '<td>';
                            echo '<a target="_blank" href="more_info.php?track_id=' . $row->id . '">' . $row->name_vn . ' </a>';
                            echo '</td>';
                            echo '<td>' . $row->track_price . '</td>';
                            echo '<td>-</td>';
                            echo '<td>' . $row->track_position . '</td>';
                            echo '<td>';
                            echo '<span class="pull-left">$</span>';
                            echo '<span class="pull-right">' . ($obj_result->sumary ? number_format($obj_result->sumary, 2) : '-') . '</span>';
                            echo '</td>';
                            echo '<td>';
                            echo '<span class="pull-left">$</span>';
                            echo '<span class="pull-right">' . (@get_object_vars($obj_result->year)['2018'] ? number_format(@get_object_vars($obj_result->year)['2018'], 2) : '-') . '</span>';
                            echo '</td>';
                            echo '</td>';
                            echo '<td>';
                            echo '<span class="pull-left">$</span>';
                            echo '<span class="pull-right">' . (@get_object_vars($obj_result->year)['2019'] ? number_format(@get_object_vars($obj_result->year)['2019'], 2) : '-') . '</span>';
                            echo '</td>';
                                for ($i = 1; $i <= $n; $i++) {
                                    echo '<td style="white-space: nowrap!important; background: #489EFD;">';
                                    echo '<span class="pull-left">$</span>';
                                    echo '<span class="pull-right">';
                                    $month_name_year = date('Y') . '-' . date('m', mktime(0, 0, 0, $i, 1, date('Y')));
                                    $obj_summry_monthly = json_decode(getSummaryHistoyofTrackMonthly($row->id, $month_name_year));
                                    echo ($obj_summry_monthly->sumary ? number_format($obj_summry_monthly->sumary, 2) : '-');
                                    echo '</span>';
                                    echo '</td>';
                                    @$obj_js_month->$i += $obj_summry_monthly->sumary;
                                    // $arr_total_summary_monthly[$i-1]['monthly']+= $obj_summry_monthly->sumary;

                                    // $arr_total_summary_monthly=[
                                    //     $i=> $arr_total_summary_monthly[$i]+= $obj_summry_monthly->sumary
                                    // ];
                                }
                            echo '</tr>';
                            $arr_total_summary = [
                                'summary' => @$arr_total_summary['summary'] += $obj_result->sumary,
                                '2018' => @$arr_total_summary['2018'] += @get_object_vars($obj_result->year)['2018'],
                                '2019' => @$arr_total_summary['2019'] += @get_object_vars($obj_result->year)['2019']
                            ];
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr class="bg-blue-madison">
                            <th colspan="7" class="text-right">សរុបការជួសជុល</th>
                            <th class="text-right">
                                <span class="pull-left">$</span>
                                <span class="pull-right"><?= ($arr_total_summary['summary'] ? number_format($arr_total_summary['summary'], 2) : '-') ?></span>
                            </th>
                            <th class="text-right">
                                <span class="pull-left">$</span>
                                <span class="pull-right"><?= ($arr_total_summary['2018'] ? number_format($arr_total_summary['2018'], 2) : '-') ?></span>
                            </th>
                            <th class="text-right">
                                <span class="pull-left">$</span>
                                <span class="pull-right"><?= ($arr_total_summary['2019'] ? number_format($arr_total_summary['2019'], 2) : '-') ?></span>
                            </th>
                            <?php
                                for ($i = 1; $i <= $n; $i++) {
                                    echo '<th>';
                                    echo '<span class="pull-left">$</span>';
                                    echo '<span class="pull-right">' . (@$obj_js_month->$i ? number_format(@$obj_js_month->$i, 2) : '-') . '</span>';
                                    echo '</th>';
                                }
                            ?>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <?php include_once '../layout/footer.php' ?>
    <script type="text/javascript">
        function updateShowHideDetail() {
            v_status = $('input[name=is_show_hide]').val();
            $.get("ajx_update_detail_inter.php", {
                    p_status: v_status
                },
                function(data, textStatus, jqXHR) {
                    location.reload();
                }
            );
        }

        function showInfo(e) {
            document.getElementById('result_modal').src = 'more_info.php?parent=' + e;
        }
    </script>
    <div class="modal fade" id="modal">
        <div class="modal-dialog" style="border: 1px solid darkred; width: 70%;">
            <iframe id="result_modal" frameborder="0" style="height: 600px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
        </div>
    </div>

    