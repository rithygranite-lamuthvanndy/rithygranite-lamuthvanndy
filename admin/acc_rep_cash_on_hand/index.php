<?php
$menu_active = 20;
$left_active = 0;
$layout_title = "View Page";
include_once '../../config/database.php';
include_once '../../config/athonication.php';
include_once '../layout/header.php';
?>
<?php
if (isset($_POST['btn_search'])) {
    $v_date_s = @$_POST['txt_date_start'];
    $v_date_e = @$_POST['txt_date_end'];
    // echo $v_date_s.'fff'.$v_date_e;
    $get_data = $connect->query("SELECT 
           A.*,E.*,des_name,
           SUM(accdr_cash_in) AS bal_in,
           SUM(accdr_cash_out) AS bal_out
        FROM  tbl_acc_cash_record AS A 
        LEFT JOIN tbl_acc_transaction_type_list AS C ON A.tran_type_id=C.trat_id
        LEFT JOIN tbl_acc_voucher_type_list AS D ON A.vou_type_id =D.vot_id
        LEFT JOIN tbl_acc_cash_record_detail AS E ON A.accdr_id=E.cash_rec_id
        LEFT JOIN tbl_acc_decription AS F ON E.des_id=F.des_id
        WHERE DATE_FORMAT(accdr_date,'%Y-%m-%d') BETWEEN '$v_date_s' AND '$v_date_e'
        AND A.type_bank_id=8
        GROUP BY A.accdr_id
        ORDER BY accdr_date,accdr_id ASC");


    $month_old = date('Y-m', strtotime($v_date_s));
    $sql = $connect->query("SELECT 
                        (
                            SELECT SUM(A1.debit-A1.credit)
                            FROM tbl_acc_open_bal AS A1 
                            WHERE A1.chart_acc_id=A.accca_id
                            AND DATE_FORMAT(A1.open_date,'%Y-%m')<='$month_old'
                        )AS open_cash_on_hand,
                        (
                            SELECT
                                SUM(A2.accdr_cash_in-A2.accdr_cash_out)
                            FROM tbl_acc_cash_record A2 
                            WHERE A2.type_bank_id=8
                            AND DATE_FORMAT(A2.accdr_date,'%Y-%m')<'$month_old'
                        ) AS cash_record_cash_on_hand
                    FROM tbl_acc_chart_account AS A 
                    WHERE A.accca_id=1
                    ");
    // A . accca_id = 1  For Cash On Hand
    // A2.type_bank_id=8  For Cash On Hand
    $row_old_bal = mysqli_fetch_object($sql);
    $v_old_amo = $row_old_bal->open_cash_on_hand + $row_old_bal->cash_record_cash_on_hand;
} else if (isset($_POST['btn_print'])) {
    $v_date_start = @$_POST['txt_date_start'];
    $v_date_end = @$_POST['txt_date_end'];
    $v_begin_bal = @$_POST['txt_bigning_bal'];
    $v_cash_in = @$_POST['txt_cash_in'];
    $v_cash_out = @$_POST['txt_cash_out'];
    if (($v_date_start && $v_date_end) == "") {
        header('location: index.php');
        die();
    } else {
        header('location: print.php?date_start=' . $v_date_start . '&date_end=' . $v_date_end);
    }
    // $v_name = @$_POST['txt_name'];
} else {
    $v_current_month = date('Y-m');
    $get_data = $connect->query("SELECT 
           A.*,E.*,des_name,
           SUM(accdr_cash_in) AS bal_in,
           SUM(accdr_cash_out) AS bal_out
        FROM  tbl_acc_cash_record AS A 
        LEFT JOIN tbl_acc_transaction_type_list AS C ON A.tran_type_id=C.trat_id
        LEFT JOIN tbl_acc_voucher_type_list AS D ON A.vou_type_id =D.vot_id
        LEFT JOIN tbl_acc_cash_record_detail AS E ON A.accdr_id=E.cash_rec_id
        LEFT JOIN tbl_acc_decription AS F ON E.des_id=F.des_id
        WHERE DATE_FORMAT(accdr_date,'%Y-%m')='$v_current_month'
        GROUP BY E.detail_id
        ORDER BY accdr_date,accdr_id ASC");
    $v_old_amo = 0;
}

?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-file-o"></i> Report Cash Daily</h2>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
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
                    <button type="submit" name="btn_print" formtarget="new" id="sample_editable_1_new" class="btn btn-warning btn-sm"> Print
                        <i class="fa fa-print"></i>
                    </button>
                </div>
            </div>
            <br>
            <br>
            <br>
            <div class="clearfix"></div>
            <div class="col-xs-2">
                <label for="input">Beginning Balance :</label>
                <input type="text" name="txt_bigning_bal" readonly="" id="input" class="form-control" value="<?= number_format($v_old_amo, 2) ?> $" required="required">
            </div>
            <div class="col-xs-2">
                <label for="input">Total Received (USD) :</label>
                <input type="text" name="txt_cash_in" readonly="" id="input" class="form-control" value="0.00 $" required="required">
            </div>
            <div class="col-xs-2">
                <label for="input">Total Payment (USD) :</label>
                <input type="text" name="txt_cash_out" readonly="" id="input" class="form-control" value="0.00 $" required="required">
            </div>
            <div class="col-xs-2">
                <label for="input">Total Amount (USD) :</label>
                <input type="text" name="txt_cash_bal" readonly="" id="input" class="form-control" value="0.00 $" required="required">
            </div>
            <br>
        </form>
    </div>
    <br>
    <style type="text/css">
        table {
            font-family: 'Khmer OS';
            -webkit- font-family: 'Khmer OS';
        }
    </style>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_2" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Date</th>
                        <th>Section</th>
                        <th>Project</th>
                        <th>Reference</th>
                        <th>FR/ER</th>
                        <th>Description</th>
                        <th>Transaction note </th>
                        <th class="text-center">Received (USD)</th>
                        <th class="text-center">Payment (USD)</th>
                        <th class="text-center">Amount (USD)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    $bal = round($v_old_amo, 2);
                    // // $flag_in=0;
                    $flag_in = 0;
                    $flag_out = 0;
                    $total_received = 0;
                    $total_payment = 0;
                    $total_amo = 0;
                    while ($row = mysqli_fetch_object($get_data)) {
                        echo '<tr>';
                        echo '<td>' . (++$i) . '</td>';
                        echo '<td>' . date('d-M-Y', strtotime($row->accdr_date)) . '</td>';
                        echo '<td>Mine</td>';
                        echo '<td></td>';
                        echo '<td>' . $row->accdr_voucher_no . '</td>';
                        echo '<td>' . $row->doc_ref . '</td>';
                        echo '<td>' . $row->des_name . '</td>';
                        echo '<td>' . $row->tran_note . '</td>';
                        echo '<th class="text-center">' . round($row->accdr_cash_in, 2) . ' <i class="fa fa-dollar"></i></th>';
                        echo '<th class="text-center">' . round($row->accdr_cash_out, 2) . ' <i class="fa fa-dollar"></i></th>';
                        $flag_in += $row->accdr_cash_in;
                        $flag_out += $row->accdr_cash_out;
                        $bal = round($bal + $row->accdr_cash_in - $row->accdr_cash_out, 2);

                        echo '<th class="text-center">' . round($bal, 2) . ' <i class="fa fa-dollar"></i></th>';
                        echo '</tr>';


                        $total_received += $row->accdr_cash_in;
                        $total_payment += $row->accdr_cash_out;
                        $total_amo = $v_old_amo + $total_received - $total_payment;
                    }
                    ?>
                </tbody>
            </table>
            <input type="hidden" name="txt_t_cash_in_tmp" value="<?= $total_received ?>">
            <input type="hidden" name="txt_t_cash_out_tmp" value="<?= $total_payment ?>">
            <input type="hidden" name="txt_t_cash_bal_tmp" value="<?= $total_amo ?>">
        </div>
    </div>
</div>



<script src="../../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<!-- <script type="text/javascript" src="my_custom_print.js"></script> -->
<script type="text/javascript">
    var total_in = $('input[name=txt_t_cash_in_tmp]').val();
    total_in = Number(parseFloat(total_in).toFixed(2)).toLocaleString('en', {
        minimumFractionDigits: 2
    });
    $('input[name=txt_cash_in]').val(total_in + " $");

    var total_out = $('input[name=txt_t_cash_out_tmp]').val();
    total_out = Number(parseFloat(total_out).toFixed(2)).toLocaleString('en', {
        minimumFractionDigits: 2
    });
    $('input[name=txt_cash_out]').val(total_out + " $");

    var total_bal = $('input[name=txt_t_cash_bal_tmp]').val();
    total_bal = Number(parseFloat(total_bal).toFixed(2)).toLocaleString('en', {
        minimumFractionDigits: 2
    });
    $('input[name=txt_cash_bal]').val(total_bal + " $");
</script>
<!-- <script type="text/javascript">
    var $custm_print = function(){
        $('[name=btn_print]').click();
    }
</script> -->
<?php include_once '../layout/footer.php' ?>