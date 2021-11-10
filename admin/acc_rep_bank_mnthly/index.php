<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
if(isset($_POST['btn_print'])){
    header('location: print.php?date_start=2018-10-10&date_end=2018-12-01');
}
?>
<style type="text/css">
    .my_left_table tr:last-child >th:last-child{
        background-color: #C0C0C0!important;
        -webkit-print-background-color: #C0C0C0!important;
    }
    .font_sign{
        font-family: 'Khmer OS Freehand'!important;
    }


    #my_content_table tr:first-child >th, 
    #my_content_table tr:last-child >th
    {
        -webkit-print-color-adjust: exact;
        background-color: #EEECE1!important;
       /* color: #fff!important;
        -webkit-color: #fff!important;*/
    }
    #my_content_table tr:nth-child(3) >th{
        -webkit-print-color-adjust: exact;
        background-color: #FFFF00!important;
    }
</style>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-file-o"></i> Report Bank Monthly</h2>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-xs-4">
            <table class="table table-bordered my_left_table">
                <tbody>
                    <tr>
                        <th class="text-left">Bank Name: <br>ឈ្មោះធនាគារ</th>
                        <th class="text-center"><input type="text" name="" id="input" class="form-control"></th>
                    </tr>
                    <tr>
                        <th class="text-left">Account Name: <br>ឈ្មោះគណនី</th>
                        <th class="text-center"><input type="text" name="" class="form-control"></th>
                    </tr>
                    <tr>
                        <th class="text-left">Balance Bank : <br>សមតុល្យធនាគារ</th>
                        <th class="text-center"><input type="text" name="" class="form-control"></th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-xs-4" style="float: right;">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th class="text-left">Date: <br>ថ្ងៃទី ខែ ឆ្នាំ :</th>
                        <th class="text-center"> 
                            <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                <input autocomplete="off" name="txt_date_start" value="<?= @$_POST['txt_date_start'] ?>" type="text" class="form-control">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th class="text-left">Year: <br>ឆ្នាំ :</th>
                        <th class="text-center"><input type="text" id="input"" class="form-control" required="required" pattern="" title=""></th>
                    </tr>
                    <tr>
                        <th class="text-left">Account # : <br>លេខគណនី</th>
                        <th class="text-center"><input type="text" id="input"" class="form-control" required="required" pattern="" title=""></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
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
        </form>
    </div>
    <br>
    <div class="container-fliud">
        <!-- my_content_table Table -->
        <table class="table table-bordered" id="my_content_table">
            <tbody>
                <tr>
                    <th class="text-center">Date : <br> ថ្ងៃ ខែ ឆ្នាំ</th>
                    <th class="text-center">Receipt NT : <br> លេខប័ណ្ណទទួលប្រាក់</th>
                    <th class="text-center">Voucher NT: <br> លេខសក្ខីប័ត្រ</th>
                    <th class="text-center">Payer/Payee : <br> ឈ្មោះអ្នកប្រគល់ប្រាក់ឬអ្នកទទួលប្រាក់</th>
                    <th class="text-center">Description & Explanation : <br> បរិយាយ និង ពន្យល់</th>
                    <th class="text-center">Deposit (Revenue) Cash/Cheque:  <br> Cសាច់ប្រាក់ និង Cheque ដែលយើងយកទៅដាក់នៅធនាគារ</th>
                    <th class="text-center">Deposit (Transfer) Cash/Cheque: <br> សាច់ប្រាក់ និង Cheque ដែលយើងយកទៅដាក់នៅធនាគារ</th>
                    <th class="text-center">Withdraw (Payment) </th>
                    <th class="text-center">Withdraw (Transfer)  </th>
                    <th class="text-center">Amount (USD) : <br> ចំនួនទឹកប្រាក់ (ដុល្លារអាមេរិក)</th>
                </tr>
                <tr>
                    <th colspan="9" class="text-right">Beginning balnace <br> សមតុល្យដើមគ្រា</th>
                    <th class="text-right"> $</th>
                </tr>
                <tr>
                    <th colspan="10" class="text-center">ខែ តុលា-2018</th>
                </tr>
                <tr>
                    <?php 
                        $v_date=date(Y-m);
                        $sql=$connect->query("SELECT * FROM tbl_acc_cash_record 
                            WHERE  DATE_FORMAT(accdr_date,'%Y-%m')='$v_date'");
                        while ($row_detial=mysql_fetch_object($sql)) {
                            $v_date_rec=$row_detial->accdr_date;
                            $v_rec_nt=$row_detial->accdr_date;
                            $v_vou_nt=$row_detial->accdr_date;
                            $v_payer=$row_detial->accdr_date;
                            $v_des=$row_detial->accdr_date;
                            $v_dep_rev=$row_detial->accdr_date;
                            $v_dep_tra=$row_detial->accdr_date;
                            $v_wid_pay=$row_detial->accdr_date;
                            $v_wid_tra=$row_detial->accdr_date;
                            $v_wid_amo=$row_detial->accdr_date;
                        }
                     ?>
                    <td class="text-center">A</td>
                    <td class="text-center">A</td>
                    <td class="text-center">A</td>
                    <td class="text-center">A</td>
                    <td class="text-center">A</td>
                    <td class="text-center">A</td>
                    <td class="text-center">A</td>
                    <td class="text-center">A</td>
                    <td class="text-center">A</td>
                    <td class="text-center">A</td>
                </tr>
                <tr>
                    <th colspan="5" class="text-right">សរុប (ដុល្លារអាមេរិក) ខែ តុលា-2018</th>
                    <th class="text-center">$</th>
                    <th class="text-center">$</th>
                    <th class="text-center">$</th>
                    <th class="text-center">$</th>
                    <th class="text-center">$</th>
                </tr>
            </tbody>
        </table>
        
        <br>
        <br>
        <!-- font_Sign  -->
        <div class="row">
            <div class="col-xs-3 text-center">
                <p class="font_sign">រៀបចំដោយ</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black;">
                <p class="font_sign">បេឡាករ</p>
            </div>

            <div class="col-xs-3 text-center">
                <p class="font_sign">ត្រួតពិនិត្យដោយ</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black;">
                <p class="font_sign">ប្រធានគណនេយ្យ</p>
            </div>

            <div class="col-xs-3 text-center">
                <p class="font_sign">ត្រួតពិនិត្យនិងឯកភាពដោយ</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black;">
                <p class="font_sign">ប្រធានហរិញ្ញវត្ថុ</p>
            </div>
             <div class="col-xs-3 text-center">
                <p class="font_sign">ឯកភាពដោយ</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black;">
                <p class="font_sign">នាយិកាប្រតិបត្តិ</p>
            </div>
        </div>
    </div> 
</div>
<?php include_once '../layout/footer.php' ?>
