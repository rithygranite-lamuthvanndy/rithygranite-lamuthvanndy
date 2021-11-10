<!-- Global Varaible -->
<?php 
    $arr_bank=[
            ['Ari Bank','ធនាគារ AGI'],
            ['Vatanac Bank','ធនាគារវឌ្ឍនៈ'], 
            ['NCB Bank','ធនាគារ NCB']
            ];
 ?>
<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "Report Cash Bank";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
    include_once 'my_function.php';
?>
<?php 
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
    .myTableRigthTitle >thead tr th:last-child{
        border-bottom: 1px solid #000;
    }
    .myTableRigthTitle >thead >tr th:first-child{
        border: none!important;
    }

    .myTableDetail tr >th,
    .myTableDetail tr:nth-child(1) >th{
        background-color: #EEECE1!important;;
        color: #000!important;
        
    }
    .myTableDetail tbody tr th,
    .myTableDetail tbody tr td{
        border: 1px solid black;
    }
    .myTableDetail tbody >tr:nth-child(3){
        background-color: #FFFF00;
    }
    .myTableDetail tr:last-child >td{
        -webkit-print-color-adjust: exact;
        background-color: #DDEBF7!important;
        -webkit-background-color: #DDEBF7!important;
    }
    .myTableDetail >tbody tr:last-child td:nth-child(2) div,
    .myTableDetail >tbody tr:last-child td:nth-child(3) div,
    .myTableDetail >tbody tr:last-child td:nth-child(4) div,
    .myTableDetail >tbody tr:last-child td:nth-child(5) div,
    .myTableDetail >tbody tr:last-child td:nth-child(6) div
    {
        border: 1px solid black; 
        top: 0px; 
        position: relative;
    }
</style>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-5 text-capital">
            <?php 
                if(isset($_GET['bank_satatus'])){
                    $v_type_bank=$_GET['bank_satatus'];
                    if($v_type_bank==2)
                        $arr_str_type_bank=$arr_bank[0];
                    else if($v_type_bank==1)
                        $arr_str_type_bank=$arr_bank[1];
                    else
                        $arr_str_type_bank=$arr_bank[2];
                }
             ?>
            <h4 style="font-weight: bold; text-decoration: underline;"><i class="fa fa-book"></i> Report Bank Record 
                <label style="color: red;text-decoration: underline;">("<?= $arr_str_type_bank[0] ?>")</label>
            </h4>
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
    <!-- Title Report Form -->
    <div class="row">
        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Bank Name<br>ឈ្មោះធនាគារ</th>
                        <th class="text-primary"><?= $arr_str_type_bank[0] ?><br><?= $arr_str_type_bank[1] ?></th>
                    </tr>
                    <tr>
                        <th>Account Name<br>ឈ្មោះគណណី</th>
                        <th class="text-primary">-<br>-</th>
                    </tr>
                    <tr>
                        <th>Balance Bank :<br>សមតុល្យធនាគារ :</th>
                        <th class="text-primary">-<br>-</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- <div class="col-xs-6 col-sm-4 col-md-6 col-lg-6"><div> -->
        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 pull-right">
            <table class="table-responsive myTableRigthTitle table">
                <thead>
                    <tr>
                        <th>Date :<br>ថ្ងៃខែឆ្នាំ:</th>
                        <th class="text-primary"><?= $arr_str_type_bank[0] ?><br><?= $arr_str_type_bank[0] ?></th>
                    </tr>
                    <tr>
                        <th>Year:<br>ឆ្នាំ:</th>
                        <th class="text-primary">-<br>-</th>
                    </tr>
                    <tr>
                        <th>Account #:<br>លេខគណនី :</th>
                        <th class="text-primary">-<br>-</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!--End Title Report Form -->
    <div class="portlet-body">
        <div class="container-fliud">

            <!-- First Table -->
            <table class="table table-bordered myTableDetail table-responsive">
                <tbody>
                    <tr>
                        <th class="text-center col"> Date <br>ថ្ងៃ ខែ ឆ្នាំ </th>
                        <th class="text-center">Receipt NT<br>លេខប័ណ្ណួទទួលប្រាក់ </th>
                        <th class="text-center">Voucher NT<br>លេខសក្ខីប័ត្រ </th>
                        <th class="text-center">Payer/Payee<br>ឈ្មោះអ្នកប្រគល់ប្រាក់ឫអ្នកទទួលប្រាក់</th>
                        <th class="text-center">Decription & Explanation <br>បរិយាយ និង ពន្យល់ </th>
                        <th class="text-center">Recieved (USD) <br> ទទួលប្រាក់</th>
                        <th class="text-center">OutStanding Cheque Deposit:<br> Cheque ដែលយើងទទួលហើយមិនទាន់យកទៅយកដាក់នៅធនាគារ</th>
                        <th class="text-center">Deposit Cash/Cheque:<br> សាច់ប្រាក់ និង Cheque ដែលយើងយកទៅដាក់នៅធនាគារ</th>
                        <th class="text-center">Payment per Bank:<br>ការទូទាត់តាមធនាគារ ឫ ដកប្រាក់ពីធនាគារំ </th>
                        <th class="text-center">Amount (USD) :<br> ចំនូនទឹកប្រាក់ (ដុល្លារអាមេរិក) </th>
                    </tr>
                    <tr>
                        <td colspan="9">
                            <div class="pull-right">
                                Biginning Balance :<br>
                                សមត្យដើមគ្រា :
                            </div>
                        </td>
                        <td style="vertical-align: middle;">
                            $
                        </td>
                    </tr>
                    <tr>
                        <td colspan="10" class="text-center">ខែ មករា-2019</td>
                    </tr>
                    <tr>
                        <td style="width:7%;flex:auto;"><?= date('Y-m-d') ?></td>
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
                        <td colspan="5">
                            <div class="pull-right">
                                សរុប (ដុល្លារអាឡមរិក) ខែ មករា-2019
                            </div>
                        </td>
                        <td>
                            $
                            <div></div>
                        </td>
                        <td>
                            $
                            <div></div>
                        </td>
                        <td>
                            $
                            <div></div>
                        </td>
                        <td>
                            $
                            <div></div>
                        </td>
                        <td>
                            $
                            <div></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <br>


        <!-- Sign  -->
        <div class="row sign">
            <div class="col-xs-4 text-center">
                <p  style="font-family: 'Khmer OS Muol Light';">រៀបចំដោយ</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black;">
                <p style="font-family: 'Khmer OS Muol Light';">បេឡាករ</p>
            </div>

            <div class="col-xs-4 text-center">
                <p  style="font-family: 'Khmer OS Muol Light';">ត្រួតពិនិត្យដោយ</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black;">
                <p  style="font-family: 'Khmer OS Muol Light';">ប្រធានគណនេយ្យ</p>
            </div>

            <div class="col-xs-4 text-center">
                <p  style="font-family: 'Khmer OS Muol Light';">ត្រួតពិនិត្យនិងឯកភាពដោយ</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black;">
                <p  style="font-family: 'Khmer OS Muol Light';">នាយិកាប្រតិបត្តិ</p>
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
