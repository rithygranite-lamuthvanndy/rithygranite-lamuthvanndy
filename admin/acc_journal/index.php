<?php
$menu_active = 20;
$left_active = 0;
$layout_title = "View Jounal";
include_once '../../config/database.php';
include_once '../../config/athonication.php';
include_once '../layout/header.php';
include_once 'myfunction.php';
?>
<?php
if (@$_GET['status'] == 'Save_Suceess') { }
if (isset($_POST['btn_search'])) {
    $v_date_s = @$_POST['txt_date_start'];
    $v_date_e = @$_POST['txt_date_end'];
    if ($v_date_s > $v_date_e) {
        echo '<script>myAlertInfo("Please Choose Date From Before Date End")</script>';
        header("refresh:3;url=index.php");
    }
    $str = "SELECT * FROM (
                SELECT '1' AS statustable,A.status_type,A.date_record AS date_record,A.ref_id
                    FROM tbl_acc_add_tran_amount AS A 
                    WHERE DATE_FORMAT(A.date_record,'%Y-%m-%d') BETWEEN '$v_date_s' AND '$v_date_e' AND p_appr='1'
                    UNION
                SELECT '2' AS statustable,AA.status_type,AA.date_record AS date_record,AA.ref_id
                    FROM tbl_acc_add_tran_dr_cr AS AA 
                    WHERE DATE_FORMAT(AA.date_record,'%Y-%m-%d') BETWEEN '$v_date_s' AND '$v_date_e'  AND p_appr='1'
            ) AS A
            ORDER BY A.date_record ASC
            -- UNION 
            -- SELECT '3' AS statustable,'3' AS status_type ,AA.open_date,AA.id AS ref_id
            -- FROM tbl_acc_open_bal AS AA 
            -- WHERE DATE_FORMAT(AA.open_date,'%Y-%m-%d') BETWEEN '$v_date_s' AND '$v_date_e'
            ";
    // echo $str;
    $get_data_main = $connect->query($str);
} else if (isset($_POST['cbo_ref_no'])) {
    $v_date_s = @$_POST['txt_date_start'];
    $v_date_e = @$_POST['txt_date_end'];
    $str = @"SELECT '1' AS statustable,A.status_type,A.date_record,A.ref_id
            FROM tbl_acc_add_tran_amount AS A 
            WHERE DATE_FORMAT(A.date_record,'%Y-%m-%d') BETWEEN '$v_date_s' AND '$v_date_e' AND p_appr='1'
            UNION
            SELECT '2' AS statustable,AA.status_type,AA.date_record,AA.ref_id
            FROM tbl_acc_add_tran_dr_cr AS AA 
            WHERE DATE_FORMAT(AA.date_record,'%Y-%m-%d') BETWEEN '$v_date_s' AND '$v_date_e'  AND p_appr='1'
            ORDER BY date_record ASC
            -- UNION 
            -- SELECT '3' AS statustable,'3' AS status_type ,AA.open_date,AA.id AS ref_id
            -- FROM tbl_acc_open_bal AS AA 
            -- WHERE DATE_FORMAT(AA.open_date,'%Y-%m-%d') BETWEEN '$v_date_s' AND '$v_date_e' 
            ";
    $get_data_main = $connect->query($str);
} else {
    $v_current_year_month = date('Y-m');
    $str = "SELECT '1' AS statustable,A.status_type,A.date_record,A.ref_id
            FROM tbl_acc_add_tran_amount AS A 
            WHERE DATE_FORMAT(A.date_record,'%Y-%m')='$v_current_year_month' AND p_appr='1'
            UNION
            SELECT '2' AS statustable,AA.status_type,AA.date_record,AA.ref_id
            FROM tbl_acc_add_tran_dr_cr AS AA 
            WHERE DATE_FORMAT(AA.date_record,'%Y-%m')='$v_current_year_month' AND p_appr='1'
            ORDER BY date_record ASC
            -- UNION 
            -- SELECT '3' AS statustable,'3' AS status_type ,AA.open_date,AA.id AS ref_id
            -- FROM tbl_acc_open_bal AS AA 
            -- WHERE DATE_FORMAT(AA.open_date,'%Y-%m')='$v_current_year_month' 
            
            ";
    $get_data_main = $connect->query($str);
}
?>

<div class="portlet light bordered">
    <div class="row">
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="col-sm-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input autocomplete="off" name="txt_date_start" value="<?= @$_POST['txt_date_start'] ?>" REQUIRED type="text" class="form-control" placeholder="Date from">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input autocomplete="off" name="txt_date_end" value="<?= @$_POST['txt_date_end'] ?>" REQUIRED type="text" class="form-control" placeholder="Date to">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <select name="cbo_ref_no" class="form-control myselect2" onchange="this.form.submit()">
                    <option value="">All Number</option>
                    <?php
                    $str = "SELECT '1' AS statustable,A.status_type,A.date_record,A.ref_id
                            FROM tbl_acc_add_tran_amount AS A 
                            WHERE p_appr='1'
                            UNION
                            SELECT '2' AS statustable,AA.status_type,AA.date_record,AA.ref_id
                            FROM tbl_acc_add_tran_dr_cr AS AA 
                            WHERE p_appr='1'";
                    $get_cbo = $connect->query($str);
                    while ($row_select = mysqli_fetch_object($get_cbo)) {
                        $sql = @$connect->query(myNumber($row_select->ref_id, $row_select->statustable, $row_select->status_type));
                        while ($row_select2 = @mysqli_fetch_object($sql)) {
                            if (@$_POST['cbo_ref_no'] == @$row_select2->entry_no)
                                echo '<option selected value="' . $row_select2->entry_no . '">' . $row_select2->entry_no . '</option>';
                            else
                                echo '<option value="' . $row_select2->entry_no . '">' . $row_select2->entry_no . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-5">
                <div class="caption font-dark" style="display: inline-block;">
                    <button type="submit" name="btn_search" id="sample_editable_1_new" class="btn blue"> Search
                        <i class="fa fa-search"></i>
                    </button>
                </div>
                <div class="caption font-dark" style="display: inline-block;">
                    <a href="<?= $_SERVER['PHP_SELF'] ?>" id="sample_editable_1_new" class="btn red"> Clear
                        <i class="fa fa-refresh"></i>
                    </a>
                </div>
                <div class="caption font-dark" style="display: inline-block;">
                    <a href="print.php?date_start=<?= @$_POST['txt_date_start'] ?>&date_end=<?= @$_POST['txt_date_end'] ?>&type=<?= @$_POST['cbo_ref_no'] ?>" target="_blank" class="btn btn-warning"><i class="fa fa-print"></i> Print</a>
                </div>
                <div class="caption font-dark" style="display: inline-block;">
                    <a href="export_excell.php?date_start=<?= @$_POST['txt_date_start'] ?>&date_end=<?= @$_POST['txt_date_end'] ?>&type=<?= @$_POST['cbo_ref_no'] ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Export</a>
                </div>
            </div>
        </form>
    </div>
    <br>
    <div class="row">
        <div class="col-xs-12">
            <?php
            $sql = $connect->query("SELECT * FROM tbl_com_company_info");
            $row_company = mysqli_fetch_array($sql);
            ?>
            <div class="text-center">
                <h1><b><?= $row_company['comci_name_en'] ?></b></h1>
                <h3><b>Report Journal</b></h3>
                <b>
                    <h4 style="font-family: 'Khmer OS Moul';">FROM <?= @$_POST['txt_date_start'] ?> TO <?= @$_POST['txt_date_end'] ?></h4>
                </b>
            </div>
        </div>
    </div>
    <br>
    <div class="portlet-body">
        <table class="dataTable dtr-inline myTable" role="grid" aria-describedby="sample_1_info">
            <thead>
                <tr role="row" class="text-center">
                    <th class="text-center">N&deg;</th>
                    <th class="text-center">Date Record</th>
                    <th class="text-center">Number</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Description</th>
                    <th class="text-center">Transaction Note</th>
                    <th class="text-center">Account</th>
                    <th class="text-center">Debit</th>
                    <th class="text-center">Credit</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $grand_total_debit = 0;
                $grand_total_credit = 0;
                $i = 1;
                $tmp = 0;
                while ($row_main = mysqli_fetch_object($get_data_main)) {
                    $main_date = $row_main->date_record;


                    $v_ref_id = $row_main->ref_id;
                    if (@$_POST['cbo_ref_no'] == '')
                        $str = myDetail1($v_ref_id, $row_main->statustable, $row_main->status_type);
                    else
                        $str = myDetail2($v_ref_id, $row_main->statustable, $row_main->status_type, @$_POST['cbo_ref_no']);
                    // echo $str.'< br><br>';
                    $sql1 = $connect->query($str);
                    $v_num_row = @mysqli_num_rows($sql1);

                    if ($v_num_row <= 0) continue;
                    // echo $str.'<br><br>';
                    $total_debit = 0;
                    $total_credit = 0;
                    $v_count_row = mysqli_num_rows($sql1);
                    $v_span_row = $v_count_row;
                    while ($row_detail = mysqli_fetch_object($sql1)) {

                        $v_ref_no = $row_detail->entry_no;
                        $v_name = $row_detail->name;

                        $total_debit += $row_detail->debit;
                        $total_credit += $row_detail->credit;

                        echo '<tr>';
                        if ($v_count_row == $v_span_row--) {
                            echo '<td style="vertical-align: top!important;" rowspan="' . $v_count_row . '">' . $i . '</td>';
                            echo '<td style="vertical-align: top!important;" style="margin: 0px!important; border=1;" class="text-center" rowspan="' . $v_count_row . '">' . date('Y-m-d', strtotime($main_date)) . '</td>';
                            echo '<td style="vertical-align: top!important;" class="text-center" rowspan="' . $v_count_row . '">' . $row_detail->entry_no . '</td>';
                            echo '<td style="vertical-align: top!important;" class="text-center" rowspan="' . $v_count_row . '">' . $row_detail->name . '</td>';
                        }
                        echo '<td class="text-left">' . $row_detail->description . '</td>';
                        echo '<td class="text-left">' . $row_detail->tran_note . '</td>';
                        echo '<td class="text-left">' . $row_detail->accca_number . ' - ' . $row_detail->accca_account_name . '</td>';
                        echo '<td class="text-right">';
                        if ($row_detail->debit != 0)
                            echo '<span class="pull-left">$</span>
                                    <span class="pull-right">' . number_format($row_detail->debit, 2) . '</span>
                                </td>';
                        echo '<td class="text-right">';
                        if ($row_detail->credit != 0)
                            echo '<span class="pull-left">$</span>
                                    <span class="pull-right">' . number_format($row_detail->credit, 2) . '</span>
                                </td>';
                        echo '</tr>';
                        $tmp++;
                    }
                    echo '
                    <tr>
                        <th colspan="7" class="text-right">Total: </th>
                        <th class="text-right bg-info norwap"><i class="fa fa-dollar"></i> ' . number_format($total_debit, 2) . ' </th>
                        <th class="text-right bg-info norwap"><i class="fa fa-dollar"></i> ' . number_format($total_credit, 2) . ' </th>
                    </tr>
                    <tr>
                        <th colspan="10" class="text-right"></th>
                    </tr>';

                    $grand_total_debit += $total_debit;
                    $grand_total_credit += $total_credit;
                    $tmp = $i;
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>
    <h4 class="text-right text-primary">Total Debit : $ <?= number_format($grand_total_debit, 2) ?></h4>
    <h4 class="text-right text-primary">Total Credit : $ <?= number_format($grand_total_credit, 2) ?></h4>
    <h4 class="text-right text-primary">Total Balance : $ <?= number_format(($grand_total_debit - $grand_total_credit), 2) ?></h4>
</div>

<style type="text/css" media="screen">
    table td {
        vertical-align: middle !important;
    }

    table .norwap {
        white-space: nowrap;
    }
</style>
<script type="text/javascript" src="../../assets/global/plugins/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.myTable').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'print',
                    className: 'btn info'
                },
                {
                    extend: 'copy',
                    className: 'btn info'
                },
                {
                    extend: 'excel',
                    className: 'btn info'
                },
                {
                    extend: 'colvis',
                    className: 'btn info',
                    text: 'Hide Columns'
                }
            ],
            paging: false,
            ordering: false,
            info: false,
            searching: false
        });
    });
</script>
<?php include_once '../layout/footer.php' ?>