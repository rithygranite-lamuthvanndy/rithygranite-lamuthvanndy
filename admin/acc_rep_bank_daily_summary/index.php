<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "Report Cash Bank Summary";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
    include_once 'my_function.php';
?>
<?php 

if(@$_GET['status']==true){
   echo '<script>myAlertSuccess("Save Completed")</script>';
}
if(isset($_POST['btn_search'])||isset($_POST['txt_date_start'])||isset($_POST['txt_date_end'])){
    $v_date_start=$_POST['txt_date_start'];
    $v_date_end=$_POST['txt_date_end'];

    $sql_old=$connect->query("SELECT (SUM(accdr_cash_in)-SUM(accdr_cash_out)) AS old_cash
        FROM tbl_acc_cash_record WHERE DATE_FORMAT(accdr_date,'%Y-%m-%d')<'$v_date_start'");
    $row_old=mysqli_fetch_object($sql_old);
}   
// else if(isset($_POST['btn_print'])){
//     $v_date_startd=$_POST['txt_date_start'];
//     header('location: print.php?date_start='.$v_date_start);
// }
else{
    $v_date_start=date('Y-m-d');
    $v_date_end=date('Y-m-d');
}
 ?>
<style type="text/css">
    .myTableDetail tr >th,
    .myTableDetail tr:nth-child(1) >th{
        background-color: #EEECE1!important;;
        color: blue!important;
        
    }
    .myTableDetail tbody tr th,
    .myTableDetail tbody tr td{
        border: 1px solid black;
    }
    .myTableDetail tbody >tr:nth-child(3){
        background-color: #FFFF00;
    }
    .myTableDetail tr:last-child >td{
        background-color: #C5D9F1!important;
        -webkit-background-color: #DDEBF7!important;
    }
</style>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-5">
            <h4 class="text-uppercase" style="font-size: 24px; text-decoration: underline;font-weight: bold;"><i class="fa fa-book"></i> Report Bank Record Summary</h4>
        </div>
        <div class="col-xs-7">
            <form action="#" method="post">
                    <div class="col-sm-4">
                        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                            <input onchange="this.form.submit()" autocomplete="off" name="txt_date_start" value="<?= ($v_date_start)?($v_date_start):(@$_POST['txt_date_start']) ?>" type="text" class="form-control" placeholder="Date From ....">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                            <input onchange="this.form.submit()" autocomplete="off" name="txt_date_end" value="<?= ($v_date_end)?($v_date_end):(@$_POST['txt_date_end']) ?>" type="text" class="form-control" placeholder="Date From ....">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="caption font-dark" style="display: inline-block;">
                            <button type="submit" name="btn_search" id="sample_editable_1_new" class="btn blue btn-sm"> Search
                                <i class="fa fa-search"></i>
                            </button>
                            <a target="_blank" href="print.php?date_start=<?= $v_date_start ?>&date_end=<?= $v_date_end ?>" class="btn btn-warning btn-sm">
                                Print
                                <i class="fa fa-print"></i>
                            </a>
                        </div>
                    </div>
                    <br>
                    <br>
            </form>
        </div>
    </div>
    <hr>
    <table class="table table-bordered table-responsive pull-right" style="width: 250px;">
        <thead>
            <tr>
                <th>Month :</th>
                <th class="text-primary"><?= date('Y-m-d') ?></th>
            </tr>
            <tr>
                <th>Year :</th>
                <th class="text-primary"><?= date('Y') ?></th>
            </tr>
        </thead>
    </table>
    <div class="portlet-body">
        <div class="container-fliud">
        <!-- First Table -->
            <table class="table table-bordered myTableDetail table-responsive">
                <tbody>
                    <tr>
                        <th class="text-center">N&deg;</th>
                        <th class="text-center">Bank Account</th>
                        <th class="text-center">Account Name</th>
                        <th class="text-center">Bank Name</th>
                        <th class="text-center">Types Of Bank Acc</th>
                        <th class="text-center">Campany Name</th>
                        <th class="text-center">Beginning Balance</th>
                        <th class="text-center">Received</th>
                        <th class="text-center">Deposit Cash/Check</th>
                        <th class="text-center">Payment Per Bank</th>
                        <th class="text-center">Endding Bank Balance</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td colspan="6">
                            <div class="text-center">
                                Total Bank Account (Dollar)
                            </div>
                        </td>
                        <td>
                            $
                        </td>
                        <td>
                            $
                        </td>
                        <td>
                            $
                        </td>
                        <td>
                            $
                        </td>
                        <td>
                            $
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <!-- Sign  -->
        <div class="row sign">
            <div class="col-xs-4 text-center">
                <p  style="font-family: 'Time New Roman'; font-weight: bold;">Prepare By</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black;">
                <p style="font-family: 'Time New Roman'; font-weight: bold;">General Cashier</p>
            </div>

            <div class="col-xs-4 text-center">
                <p  style="font-family: 'Time New Roman'; font-weight: bold;">Check By</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black;">
                <p  style="font-family: 'Time New Roman'; font-weight: bold;">Chief Accountant</p>
            </div>

            <div class="col-xs-4 text-center">
                <p  style="font-family: 'Time New Roman'; font-weight: bold;">Approved By</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black;">
                <p  style="font-family: 'Time New Roman'; font-weight: bold;">Chief Executive Officer (CFO)</p>
            </div>
        </div>
    </div>
</div>
<?php include_once '../layout/footer.php' ?>
<script type="text/javascript">
    $('div[name=btn_add]').click(function(event) {
        var objRow=$('table[id=form_padding_cash]').find('tbody >tr').html();
        $('table[id=form_padding_cash]').find('tbody').append(`<tr>${ objRow }</tr>`);
    });
    $('table[id=form_padding_cash]').on('click', 'div[name=btn_padding_delete_row]', function(event) {
        var row_count=$(this).parents('table[id=form_padding_cash] ').find('tbody >tr').length;
        if(row_count!=1){
            $(this).parents('tbody >tr').remove();
            calTotalAmountPaddingCash();
        }
    });
    $('table[id=form_padding_cash]').on('keyup', 'input[name^=txt_amo]', function(event) {
        calTotalAmountPaddingCash();
    });
    $('input[name^=txt_unit_reils]').keyup(function(event) {
        var v_type=$(this).attr('id');
        var v_unit=$(this).val();
        var result=numeral(v_type*v_unit*100).format('0,0');
        $(this).parents('tr').find('td:last-child >input').val('R '+result);
        calTotalCashAvalibleReil();
        calGendTotal();
    });
    $('input[name^=txt_unit_dollar]').keyup(function(event) {
        var v_type=$(this).attr('id');
        var v_unit=$(this).val();
        var result=numeral(v_type*v_unit).format('$ 0,0.00');
        $(this).parents('tr').find('td:nth-child(3) >input').val(result);
        calTotalCashAvalibleDollar();
        calGendTotal();
    });
    function calTotalCashAvalibleDollar(){
        v_total_amo=0;
        $('table.tableCashCount').find('tbody >tr').each(function(index, el) {
            var v_type=$(this).find('td:nth-child(2) >input').attr('id');//.attr('id');
            var v_unit=$(this).find('td:nth-child(2) input').val();
            var result=v_type*v_unit;
            if(result){
                v_total_amo+=result;
            }
        });
        console.log($('table.tableCashCount').find('tfoot tr:first-child >td:nth-child(2)').html(numeral(v_total_amo).format('0,00.00 $')));
        $('input[name=txt_total_dollar]').val(v_total_amo);
        return v_total_amo;
    }
    function calTotalCashAvalibleReil(){
        v_total_amo=0;
        $('table.tableCashCount').find('tbody >tr').each(function(index, el) {
            var v_type=$(this).find('td:nth-last-child(2) >input').attr('id');//.attr('id');
            var v_unit=$(this).find('td:nth-last-child(2) input').val();
            var result=v_type*v_unit;
            if(result){
                v_total_amo+=result;
            }
        });
        $('table.tableCashCount').find('tfoot tr:first-child >td:last-child').html('R '+numeral(v_total_amo*100).format('0,00'));
        $('input[name=txt_total_reils]').val(v_total_amo);
        return v_total_amo;
    }
    g_calTotalAmountPaddingCash=0;
    function calTotalAmountPaddingCash(){
        v_total_amo=0;
        $('table[id=form_padding_cash]').find('tbody>tr').each(function(index, el) {
            v_total_amo+=parseFloat($(this).find('td:nth-child(3) input').val());
        });
        $('table[id=form_padding_cash]').find('tfoot tr >td:last-child').html(numeral(v_total_amo).format('0,0.00 $'));
        g_calTotalAmountPaddingCash=v_total_amo;
        calGrandTotalAll()
        return v_total_amo;
    }
    v_result_calGendTotal=0;
    function calGendTotal(){
        v_total_amo_dollar=calTotalCashAvalibleDollar();
        v_total_amo_reils=calTotalCashAvalibleReil();
        v_result=v_total_amo_dollar+(v_total_amo_reils*100/4000);
        v_result_calGendTotal=v_result;
        $('table.tableCashCount').find('tfoot >tr:last-child >td:nth-child(2)').html(numeral(v_result).format('0,0.00 $'));
        calGrandTotalAll();
    }
    function calGrandTotalAll(){
        v_total_register=<?= $v_old_cash_on_hand ?>;
        v_total_register=(v_total_register)?(v_total_register):0;
        v_TotalAmountPaddingCash=g_calTotalAmountPaddingCash;
        v_result=v_total_register+v_result_calGendTotal-v_TotalAmountPaddingCash;
        $('table.tableCashCount').find('tfoot >tr:last-child >td:nth-child(3)').html(numeral(v_result).format('0,0.00 $'));
        $('input[name=txt_final_grand_total]').val(v_result);
    }
</script>
