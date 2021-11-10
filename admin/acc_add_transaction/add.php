<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
    if(isset($_POST['btn_save_new'])){
        $v_date = @$_POST['txt_date'];
        $v_month_year = @$_POST['cbo_month_year'];
        $v_invoice_no = @$_POST['txt_inv_no'];
        $v_user_id = @$_SESSION['user']->user_id;
        $query_add_1 = "INSERT INTO tbl_acc_add_transaction (
                accad_date_record,
                accad_month_year,
                accad_cash_rec_id,
                user_id
                ) 
            VALUES
                (
                '$v_date',
                '$v_month_year',
                '$v_invoice_no',
                '$v_user_id'
                )";
        if($connect->query($query_add_1)){
            $flag_1=1;
            $v_id=$connect->insert_id;
        }
        else {
            echo 'Error';
            die();
        }

        $v_id=$connect->insert_id;
        $v_acc_no= @$_POST['txt_acc_name'];
        $v_pro_id = @$_POST['cbo_pro_id'];
        $v_active = @$_POST['txt_act_code'];
        $v_debit = @$_POST['txt_debit'];
        $v_credit= @$_POST['txt_crebit'];

        foreach ($v_acc_no as $key => $value) {
            if($value){
                $new_acc_id=$v_acc_no[$key];
                $new_pro_id=$v_pro_id[$key];
                $new_active=$v_active[$key];
                $new_debit=$v_debit[$key];
                $new_credit=$v_credit[$key];
                $query_add_2="INSERT INTO tbl_acc_add_transaction_detail
                    (
                        transation_id,
                        chart_acc_id,
                        project_id,
                        activity_code,
                        debit,
                        credit,
                        user_id
                    )
                    VALUES
                    (
                    '$v_id',
                    '$new_acc_id',
                    '$new_pro_id',
                    '$new_active',
                    '$new_debit',
                    '$new_credit',
                    '$user_id'
                    )";
                // echo $query_add_2.'<br>';
                $flag=$connect->query($query_add_2);
            }
        }
        if($flag_1==1&&$flag){
            echo '<script>myAlertSuccess("Add")</script>';
            exit(0);
        }else{  
            echo '<script>myAlertError("Error")</script>';
        }
    }
    if(isset($_POST['btn_save_close'])){
        $v_date = @$_POST['txt_date'];
        $v_month_year = @$_POST['cbo_month_year'];
        $v_invoice_no = @$_POST['txt_inv_no'];
        $v_user_id = @$_SESSION['user']->user_id;

        $query_add_1 = "INSERT INTO tbl_acc_add_transaction (
                accad_date_record,
                accad_month_year,
                accad_cash_rec_id,
                user_id
                ) 
            VALUES
                (
                '$v_date',
                '$v_month_year',
                '$v_invoice_no',
                '$v_user_id'
                )";
        if($connect->query($query_add_1)){
            $flag_1=1;
            $v_id=$connect->insert_id;
        }
        else {
            echo 'Error';
            die();
        }

        $v_id=$connect->insert_id;
        $v_acc_no= @$_POST['txt_acc_name'];
        $v_pro_id = @$_POST['cbo_pro_id'];
        $v_debit = @$_POST['txt_debit'];
        $v_credit= @$_POST['txt_crebit'];
        $v_active = @$_POST['txt_act_code'];

        foreach ($v_acc_no as $key => $value) {
            if($value){
                $new_acc_id=$v_acc_no[$key];
                $new_pro_id=$v_pro_id[$key];
                $new_debit=$v_debit[$key];
                $new_active=$v_active[$key];
                $new_credit=$v_credit[$key];
                $query_add_2="INSERT INTO tbl_acc_add_transaction_detail
                    (
                        transation_id,
                        chart_acc_id,
                        project_id,
                        activity_code,
                        debit,
                        credit,
                        user_id
                    )
                    VALUES
                    (
                    '$v_id',
                    '$new_acc_id',
                    '$new_pro_id',
                    '$new_active',
                    '$new_debit',
                    '$new_credit',
                    '$user_id'
                    )";
                // echo $query_add_2.'<br>';
                $flag=$connect->query($query_add_2);
            }
        }
        if($flag_1==1&&$flag){
            header('location: index.php');
        }else{
            $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> Query error ...
            </div>';   
        }
    }

 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Create Record</h2>
        </div>
    </div>
    
    <br>
    <br>

    <div class="portlet-title">
        <div class="caption font-dark">
            <a href="index.php" id="sample_editable_1_new" class="btn red"> 
                <i class="fa fa-arrow-left"></i>
                Back
            </a>
        </div>
    </div>
    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Input Information</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <div class="form-body">
                       <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Date :
                                    </label>
                                    <input type="text" value="<?= date('Y-m-d') ?>" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" autocomplete="off" required name="txt_date">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Month Year :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#month_year'><i class="fa fa-plus"></i></a> 
                                    <div class="btn btn-xs btn-success" id="re_month_year"><i class="fa fa-refresh"></i></div>
                                    <select class="form-control myselect2" required="" name="cbo_month_year">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_acc_month_year ORDER BY accmy_name ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_data->accmy_id.'">'.$row_data->accmy_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div id="flag_invocie" class="form-group">
                                    <label>Voucher N&deg; :
                                    </label>
                                    <!-- <a class="btn btn-primary btn-xs" data-toggle="modal" href='#invoice'><i class="fa fa-plus"></i></a>
                                    <div class="btn btn-xs btn-success" id="inv_refresh"><i class="fa fa-refresh"></i></div> -->
                                    <select onchange="change_inv()" required="" class="form-control myselect2" name="txt_inv_no">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $now_month=date("Y-m",strtotime($now));
                                            $v_select = $connect->query("SELECT accdr_id,accdr_voucher_no FROM tbl_acc_cash_record 
                                                WHERE accdr_id NOT IN (SELECT accad_cash_rec_id FROM tbl_acc_add_transaction)
                                                AND DATE_FORMAT(accdr_date,'%Y-%m')='$now_month' ORDER BY accdr_voucher_no DESC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_data->accdr_id.'">'.$row_data->accdr_voucher_no.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Voucher Type :
                                    </label>
                                    <input type="text" name="txt_vou_type" readonly="" id="inputTxt_vou_type" class="form-control" required="required" pattern="" title="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Phone :
                                    </label>
                                    <input type="text" readonly="" class="form-control" autocomplete="off" name="txt_phone">
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>To :
                                    </label>
                                    <input type="text" readonly="" class="form-control" autocomplete="off" name="txt_name">
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Address :
                                    </label>
                                    <input type="text" readonly="" class="form-control" autocomplete="off" name="txt_address">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Note :
                                    </label>
                                   <textarea name="txt_note" readonly="" id="inputTxt_note" class="form-control" rows="2" required="required"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group form-md-line-input">
                                    <input readonly="" type="text" class="form-control" autocomplete="off" name="txt_tra_type">
                                    <label>Transation Type :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group form-md-line-input">
                                    <input readonly="" type="text" class="form-control" autocomplete="off" name="txt_cash_in">
                                    <label>Cash In :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group form-md-line-input">
                                    <input readonly="" type="text" class="form-control" autocomplete="off" name="txt_cash_out">
                                    <label>Cash Out :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                       
                        <table id="myTable" class="table table-bordered">
                            <tr>
                                <th>Acccount Name</th>
                                <th>Acccount No</th>
                                <th>Project Code</th>
                                <th>Activity Code</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Action</th>
                            </tr>
                            <tbody>
                                <tr class="my_form_base" style="background: red; display: none;">
                                    <td>
                                        <select class="form-control" onchange="change_acc_name(this)" name="txt_acc_name[]">
                                            <option value="">=== Please Choose and Select ===</option>
                                            <?php 
                                                $v_select = $connect->query("SELECT * FROM tbl_acc_chart_account ORDER BY accca_account_name DESC");
                                                while ($row_data = mysqli_fetch_object($v_select)) {
                                                    echo '<option value="'.$row_data->accca_id.'">'.$row_data->accca_account_name.'</option>';
                                                }
                                             ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="txt_acco_no[]" readonly="" id="inputTxt_acc_no" class="form-control" required="required">
                                    </td>
                                    <td>
                                        <select class="form-control" data-live-search="true" name="cbo_pro_id[]">
                                            <option value="">=== Please Choose and Select ===</option>
                                            <?php 
                                                $v_select = $connect->query("SELECT * FROM  tbl_acc_project ORDER BY accpro_name DESC");
                                                while ($row_data = mysqli_fetch_object($v_select)) {
                                                    echo '<option value="'.$row_data->accpro_id.'">'.$row_data->accpro_name.'</option>';
                                                }
                                             ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="txt_act_code[]" id="inputTxt_acc_no" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" onkeyup="getDebit()" value="0.00" name="txt_debit[]" id="inputTxt_acc_no" class="form-control"">
                                    </td>
                                    <td>
                                        <input type="text" onkeyup="getCredit()" name="txt_crebit[]" id="inputTxt_acc_no" value="0.00" class="form-control">
                                    </td>
                                    <td class="text-center">
                                        <button class="btnDelete">Delete</button>
                                    </td>
                                </tr>
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th style="visibility: hidden;"></th>
                                    <th style="visibility: hidden;"></th>
                                    <th style="visibility: hidden;"></th>
                                    <th style="visibility: hidden;"></th>
                                    <th class="debit">0.00 $</th>
                                    <th class="credit">0.00 $</th>
                                    <th class="outbal">0.00$</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="row">
                        <div class="text-center">
                            <div class="form_add_result"></div>
                            <div id="add_more" class="btn btn-default yellow btn-md"><i class="fa fa-plus"></i>Add More</div>
                        </div>
                    </div>
                    <br>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button name="btn_print" class="btn green"><i class="fa fa-print"></i> Print</button>
                                <button type="submit" name="btn_save_new" class="btn purple"><i class="fa fa-save fa-fw"></i>Save & New</button>
                                <button type="submit" name="btn_save_close" class="btn blue"><i class="fa fa-save fa-fw"></i>Save & Close</button>
                                <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript" src="../../assets/global/plugins/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('input[name=txt_date]').datepicker().on('changeDate', function (ev) {
            $(this).change();
            var v_date=new Date($(this).val());
            v_p=toDate(v_date);
            $.ajax({ url: "ajax_get_vouch_no.php?v_date="+v_p,success:function(result){
                $('select[name=txt_inv_no]').html(result);
            }});
        });
    });


    function getDebit(){
        v_debit=0;
        $('input[name^="txt_debit"]').each(function(){
            v_debit+=parseFloat($(this).val());
        });

        v_credit=0;
        $('input[name^="txt_crebit"]').each(function(){
            v_credit+=parseFloat($(this).val());
        });

        $('.debit').html(v_debit.toFixed(2).toString()+" $");
        $('.outbal').html((v_debit-v_credit).toFixed(2)+"$");
    }

    function getCredit(){
        v_credit=0;
        $('input[name^="txt_crebit"]').each(function(){
            v_credit+=parseFloat($(this).val());
        });

        v_debit=0;
        $('input[name^="txt_debit"]').each(function(){
            v_debit+=parseFloat($(this).val());
        });
        $('.credit').html(v_credit.toFixed(2).toString()+" $");
        $('.outbal').html((v_debit-v_credit).toFixed(2)+"$");
    }

    function toDate(obj){
        var year=obj.getFullYear();
        var month=obj.getMonth()+1;
        if(month<10)
            month="0"+month;
        return (year+"-"+month);
    }
    var index_row = 1;
    $('#add_more').click(function(){ 
        $('#myTable').append('<tr data-row-id="'+(++index_row)+'">'+$('.my_form_base').html()+'</tr>');
        $('tr[data-row-id='+index_row+']').find('select').select2();
    });
    setTimeout(function(){
        $('#add_more').click();      
    },2000);

    function change_acc_name(select){
        $.ajax({url: "ajx_load_acc_no.php?acc_id="+$(select).val(),success:function(result){
            var myObj=JSON.parse(result);
            $(select).parents('tr').find('td:nth-child(2) > input').val(myObj['acc_no']);
        }});
    }
    $(document).ready(function(){
        $("tbody").on('click', '.btnDelete', function () {
            var rowCount = $('tbody>tr').length;
            if(rowCount<=3){
                alert("You can not delete this record.");
                return;
            }
            $(this).parents('tr').remove();
            getDebit();
            getCredit();
        });
    });

    function change_inv(){
        $inv_id=$('select[name=txt_inv_no]').val();
        $.ajax({url: "ajx_load_invoice_data.php?inv_no="+$inv_id,async: false, success: function(result){
            var myObj = JSON.parse(result);
            $('input[name="txt_vou_type"]').val(myObj['vouch']);
            $('input[name="txt_tra_type"]').val(myObj['tran']);
            $('input[name="txt_phone"]').val(myObj['phone']);
            $('input[name="txt_name"]').val(myObj['name']);
            $('input[name="txt_address"]').val(myObj['address']);
            $('textarea[name="txt_note"]').val(myObj['note']);
            $('input[name="txt_cash_in"]').val(myObj['cash_in']);
            $('input[name="txt_cash_out"]').val(myObj['cash_out']);
        }});
    }

    $('div#re_month_year').click(function(){
        $.ajax({url: "ajx_get_content_select.php?d=txt_month_year", success: function(result){
            if($('select[name=txt_month_year]').html().trim() != result.trim()){
                $('select[name=txt_month_year]').html(result);
            }
        }});
    });
    $('div#inv_refresh').click(function(){
        $.ajax({url: "ajx_get_content_select.php?d=txt_inv_no", success: function(result){
            if($('select[name=txt_inv_no]').html().trim() != result.trim()){
                $('select[name=txt_inv_no]').html(result);
            }
        }});
    });
</script>


<?php include_once '../layout/footer.php' ?>
<div class="modal fade" id="month_year">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_month_year.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="invoice">
    <div class="modal-dialog modal-lg" style="border: 1px solid darkred;">
        <iframe src="iframe_add_invoice_no.php" frameborder="0" style="height: 600px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
