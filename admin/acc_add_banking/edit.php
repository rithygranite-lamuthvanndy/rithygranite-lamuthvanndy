<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
    if(isset($_POST['btn_save_close'])){
        
        $v_id = @$_POST['txt_id'];
        $v_date = @$_POST['txt_date'];
        $v_month_year = @$_POST['cbo_month_year'];
        $v_invoice_no = @$_POST['txt_inv_no'];
        $v_user_id = @$_SESSION['user']->user_id;
        
       
        $query_update1 = "UPDATE `tbl_acc_add_transaction` SET 
                accad_date_record='$v_date',
                accad_month_year='$v_month_year',
                accad_cash_rec_id='$v_invoice_no',
                user_id='$v_user_id'
            WHERE `accad_id`='$v_id'";
                            
       
        if($connect->query($query_update1)){
            $v_sub_id= @$_POST['txt_sub_id'];
            $v_acc_no= @$_POST['txt_acc_name'];
            $v_pro_id = @$_POST['cbo_pro_id'];
            $v_debit = @$_POST['txt_debit'];
            $v_credit= @$_POST['txt_crebit'];

            foreach ($v_acc_no as $key => $value) {
                if($value){
                    $new_sub_id= $v_sub_id[$key];
                    $new_acc_id=$v_acc_no[$key];
                    $new_pro_id=$v_pro_id[$key];
                    $new_debit=$v_debit[$key];
                    $new_credit=$v_credit[$key];
                    // $sql=$connect->query("SELECT id FROM tbl_acc_add_transaction_detail WHERE id='$new_sub_id'");
                    if($new_sub_id!=0){
                        $query_update2="UPDATE tbl_acc_add_transaction_detail SET
                            transation_id='$v_id',
                            chart_acc_id='$new_acc_id',
                            project_id='$new_pro_id',
                            debit='$new_debit',
                            credit='$new_credit',
                            user_id='$user_id' 
                            WHERE id='$new_sub_id'
                            ";
                        $flag=$connect->query($query_update2);
                    }
                    else{
                        $query_add_2="INSERT INTO tbl_acc_add_transaction_detail
                            (
                                transation_id,
                                chart_acc_id,
                                project_id,
                                debit,
                                credit,
                                user_id
                            )
                            VALUES
                            (
                            '$v_id',
                            '$new_acc_id',
                            '$new_pro_id',
                            '$new_debit',
                            '$new_credit',
                            '$user_id'
                            )";
                        $flag=$connect->query($query_add_2);
                    }
                }
            }
            if($flag){
                $sms = '<div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Successfull!</strong> Data update ...
                </div>'; 
                header('location: index.php');
            }

        }else{
            $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> Query error ...'.mysqli_error($connect).'
            </div>';   
        }
    }


// get old data 
    $edit_id = @$_GET['edit_id'];
    $old_data = $connect->query("SELECT * FROM tbl_acc_add_transaction WHERE accad_id='$edit_id'");
    $row_old_data_main = mysqli_fetch_object($old_data);


 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Edit Record</h2>
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
                    <input type="hidden" name="txt_id" value="<?= $row_old_data_main->accad_id ?>">
                    <div class="form-body">
                       <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Date :
                                    </label>
                                    <input type="text" value="<?= $row_old_data_main->accad_date_record ?>" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" autocomplete="off" required name="txt_date">
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
                                                if($row_data->accmy_id==$row_old_data_main->accad_month_year)
                                                    echo '<option SELECTED value="'.$row_data->accmy_id.'">'.$row_data->accmy_name.'</option>';
                                                else
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
                                            $v_select = $connect->query("SELECT accdr_id,accdr_voucher_no FROM tbl_acc_cash_record 
                                             ORDER BY accdr_voucher_no DESC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                if($row_data->accdr_id==$row_old_data_main->accad_cash_rec_id)
                                                    echo '<option SELECTED value="'.$row_data->accdr_id.'">'.$row_data->accdr_voucher_no.'</option>';
                                                else
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
                                <tr class="my_form_base_2" style="background: red; display: none;">
                                    <td>
                                        <input type="hidden" name="txt_sub_id[]" value="0">
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
                                        <input type="text" onkeyup="getCredit()" value="0.00" name="txt_crebit[]" id="inputTxt_acc_no" class="form-control">
                                    </td>
                                     <td class="text-center">
                                        <button class="btnDelete">Delete</button>
                                    </td>
                                </tr>
                                <?php 
                                    $sql_sub=$connect->query("SELECT * 
                                        FROM tbl_acc_add_transaction_detail
                                        WHERE transation_id='$row_old_data_main->accad_id'");
                                    while ($row_old_data_sub=mysqli_fetch_object($sql_sub)) {
                                ?>
                                        <tr class="my_form_base">
                                            <td>
                                                <input type="hidden" name="txt_sub_id[]" value="<?= $row_old_data_sub->id ?>">
                                                <select class="form-control myselect2" onchange="change_acc_name(this)" name="txt_acc_name[]">
                                                    <option value="">=== Please Choose and Select ===</option>
                                                    <?php 
                                                        $v_select = $connect->query("SELECT * FROM tbl_acc_chart_account ORDER BY accca_account_name DESC");
                                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                                            if($row_old_data_sub->chart_acc_id==$row_data->accca_id)
                                                                echo '<option SELECTED value="'.$row_data->accca_id.'">'.$row_data->accca_account_name.'</option>';
                                                            else
                                                                echo '<option value="'.$row_data->accca_id.'">'.$row_data->accca_account_name.'</option>';
                                                        }
                                                     ?>
                                                </select>
                                            </td>
                                            <td>
                                                <?php 
                                                    $v_select=$connect->query("SELECT * FROM tbl_acc_chart_account WHERE accca_id='$row_old_data_sub->chart_acc_id'");
                                                    $row_select=mysqli_fetch_object($v_select);
                                                 ?>
                                                <input type="text" value="<?= $row_select->accca_number ?>" name="txt_acco_no[]" readonly="" id="inputTxt_acc_no" class="form-control" required="required">
                                            </td>
                                            <td>
                                                <select class="form-control myselect2" data-live-search="true" name="cbo_pro_id[]">
                                                    <option value="">=== Please Choose and Select ===</option>
                                                    <?php 
                                                        $v_select = $connect->query("SELECT * FROM  tbl_acc_project ORDER BY accpro_name DESC");
                                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                                            if($row_old_data_sub->project_id==$row_data->accpro_id)
                                                                echo '<option SELECTED value="'.$row_data->accpro_id.'">'.$row_data->accpro_name.'</option>';
                                                            else
                                                                echo '<option value="'.$row_data->accpro_id.'">'.$row_data->accpro_name.'</option>';
                                                        }
                                                     ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="txt_act_code[]" id="inputTxt_acc_no" class="form-control" value="<?= $row_old_data_sub->activity_code ?>">
                                            </td>
                                            <td>
                                                <input type="text" name="txt_debit[]" id="inputTxt_acc_no" class="form-control" value="<?= $row_old_data_sub->debit ?>">
                                            </td>
                                            <td>
                                                <input type="text" name="txt_crebit[]" id="inputTxt_acc_no" class="form-control" value="<?= $row_old_data_sub->credit ?>">
                                            </td>
                                             <td class="text-center">
                                                <button class="btnDelete">Delete</button>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                 ?>
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th style="visibility: hidden;"></th>
                                    <th style="visibility: hidden;"></th>
                                    <th style="visibility: hidden;"></th>
                                    <th style="visibility: hidden;"></th>
                                    <th class="credit"></th>
                                    <th class="debit"></th>
                                    <th class="outbal"></th>
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
                                <!-- <button name="btn_print" class="btn green"><i class="fa fa-print"></i> Print</button> -->
                                <!-- <button type="submit" name="btn_save_new" class="btn purple"><i class="fa fa-save fa-fw"></i>Save & New</button> -->
                                <button type="submit" name="btn_save_close" class="btn blue"><i class="fa fa-save fa-fw"></i>Update & Close</button>
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
            //alert(v_p);
            //v_p=(v_date.getFullYear()).toString()+"-"+(v_date.getMonth()+1).toString();
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
    $('input[name^=txt_debit]').keyup(function(){
        getDebit();
    });

    $('input[name^=txt_crebit]').keyup(function(){
        getCredit();
    });

    function toDate(obj){
        var year=obj.getFullYear();
        var month=obj.getMonth()+1;
        if(month<10)
            month="0"+month;
        return (year+"-"+month);
    }
    var index_row = 1;
    $('#add_more').click(function(){ 
        $('#myTable').append('<tr data-row-id="'+(++index_row)+'">'+$('.my_form_base_2').html()+'</tr>');
        $('tr[data-row-id='+index_row+']').find('select').select2();
    });

    getCredit();
    getDebit();

    function change_acc_name(select){
        $.ajax({url: "ajx_load_acc_no.php?acc_id="+$(select).val(),success:function(result){
            var myObj=JSON.parse(result);
            $(select).parents('tr').find('td:nth-child(2) > input').val(myObj['acc_no']);
        }});
    }
    $(document).ready(function(){
        $(".btnDelete").click(function () {
            var rowCount = $('tbody>tr').length;
            if(rowCount<=2){
                alert("You can not delete this record.");
                return;
            }
            var ans=confirm("Are you sure to delete this record ?");
            if(ans){
                var var_id=$(this).parents('tbody >tr').find('td:nth-child(1) >input').val();
                $.ajax({url: "delete.php?del_id="+var_id, success: function(result){
                    // alert(result);
                }});
                $(this).parents('tbody >tr').remove(); 
                getCredit();
                getDebit();
            }
        });
    });

    change_inv();

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
