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
        //Add Main Item
        $v_date_record = @$connect->real_escape_string($_POST['txt_date_record']);
        $v_entry_no = @$connect->real_escape_string($_POST['txt_entry_no']);
        $query_add = "INSERT INTO tbl_acc_rec_adjustment(
        date_record,
        entry_no, 
        user_id
         )
        VALUES (
        '$v_date_record',
        '$v_entry_no',
        '$user_id'
        )";
        if($connect->query($query_add))
            $flag_add_1=1;
        $v_last_id=$connect->insert_id;

        $v_acc_no= @$_POST['cbo_acc_no'];
        $v_tran_note= @$_POST['txt_tran_note'];
        $v_doc_ref= @$_POST['txt_doc_ref'];
        $v_credit= @$_POST['txt_credit'];
        $v_debit= @$_POST['txt_debit'];
        foreach ($v_acc_no as $key => $value) {
            if($value){
                $new_acc_no=$v_acc_no[$key];
                $new_tran_note=$v_tran_note[$key];
                $new_doc_ref=$v_doc_ref[$key];
                $new_credit=$v_credit[$key];
                $new_debit=$v_debit[$key];
                 //Add Sub Item
                $query_add_2="INSERT INTO tbl_acc_rec_adjustment_detail(
                    detail_id, 
                    account_id, 
                    tran_note, 
                    doc_ref, 
                    debit, 
                    credit
                    )
                    VALUES
                    (
                    '$v_last_id',
                    '$new_acc_no',
                    '$new_tran_note',
                    '$new_doc_ref',
                    '$new_credit',
                    '$new_debit'
                    )";
                $flag_add_2=$connect->query($query_add_2);
            }
        }
        if($flag_add_1==1&&$flag_add_2){
            echo '<script>myAlertSuccess("Add")</script>';
        }else{  
            echo '<script>myAlertError("Error")</script>';
        }
    }
    else if(isset($_POST['btn_save_close'])){
        //Add Main Item
        $v_date_record = @$connect->real_escape_string($_POST['txt_date_record']);
        $v_entry_no = @$connect->real_escape_string($_POST['txt_entry_no']);
        $query_add = "INSERT INTO tbl_acc_rec_adjustment(
        date_record,
        entry_no, 
        user_id
         )
        VALUES (
        '$v_date_record',
        '$v_entry_no',
        '$user_id'
        )";
        if($connect->query($query_add))
            $flag_add_1=1;
        $v_last_id=$connect->insert_id;

        $v_acc_no= @$_POST['cbo_acc_no'];
        $v_tran_note= @$_POST['txt_tran_note'];
        $v_doc_ref= @$_POST['txt_doc_ref'];
        $v_credit= @$_POST['txt_credit'];
        $v_debit= @$_POST['txt_debit'];
        foreach ($v_acc_no as $key => $value) {
            if($value){
                $new_acc_no=$v_acc_no[$key];
                $new_tran_note=$v_tran_note[$key];
                $new_doc_ref=$v_doc_ref[$key];
                $new_credit=$v_credit[$key];
                $new_debit=$v_debit[$key];
                 //Add Sub Item
                $query_add_2="INSERT INTO tbl_acc_rec_adjustment_detail(
                    detail_id, 
                    account_id, 
                    tran_note, 
                    doc_ref, 
                    debit, 
                    credit
                    )
                    VALUES
                    (
                    '$v_last_id',
                    '$new_acc_no',
                    '$new_tran_note',
                    '$new_doc_ref',
                    '$new_credit',
                    '$new_debit'
                    )";
                $flag_add_2=$connect->query($query_add_2);
            }
        }
        if($flag_add_1==1&&$flag_add_2){
            header('location: index.php?status=true');
        }else{  
            echo '<script>myAlertError("Error")</script>';
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

    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Input Information</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data" autocomplete="off">
                    <div class="form-body">
                       <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Date : </label>
                                    <input type="text" name="txt_date_record" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" required value="<?= date('Y-m-d') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="input" class="control-label">Entry No*:</label>
                                    <input type="text" name="txt_entry_no" class="form-control" required="" placeholder="Entry No .....">
                                </div>
                            </div>

                            <!-- Detail -->
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <br>    
                                <table id="myTable" class="table table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 10%;">Account N&deg;</th>
                                            <th class="text-center" style="width: 20%;">Account Name</th>
                                            <th class="text-center">Transation Note</th>
                                            <th class="text-center">Document Ref</th>
                                            <th class="text-center" style="width: 9%;">Debit</th>
                                            <th class="text-center" style="width: 9%;">Credit</th>
                                            <th class="text-center" style="width: 5%;"> <i class="fa fa-cog fa-spin"></i> Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="my_form_base" style="background: red; display: none;">
                                            <td>
                                                <select class="form-control" onchange="changeItemID(this);" name="cbo_acc_no[]">
                                                    <option value="">=== Please Choose and Select ===</option>
                                                    <?php 
                                                        $v_select = $connect->query("SELECT accca_number,accca_id FROM tbl_acc_chart_account ORDER BY accca_number DESC");
                                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                                            echo '<option value="'.$row_data->accca_id.'">'.$row_data->accca_number.'</option>';
                                                        }
                                                     ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" onchange="changeItemName(this);"">
                                                    <option value="">=== Please Choose and Select ===</option>
                                                    <?php 
                                                        $v_select = $connect->query("SELECT accca_id,accca_account_name FROM tbl_acc_chart_account ORDER BY accca_account_name DESC");
                                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                                            echo '<option value="'.$row_data->accca_id.'">'.$row_data->accca_account_name.'</option>';
                                                        }
                                                     ?>
                                                </select>
                                            </td>
                                            <td>
                                                <textarea name="txt_tran_note[]" id="inputTxt_tran_note" class="form-control" rows="1"></textarea>
                                            </td>
                                            <td>
                                                <input type="text"  name="txt_doc_ref[]" class="form-control" >
                                            </td>    
                                            <td>
                                                <input type="number" step="0.01" min="0" name="txt_debit[]" onkeyup="totalDebit()" onchange="totalDebit()" class="form-control" value="0.00">
                                            </td>
                                            <td>
                                                <input type="number" step="0.01" min="0" name="txt_credit[]" onkeyup="totalCredit()" onchange="totalCredit()" class="form-control" value="0.00">
                                            </td>
                                            <td class="text-center">
                                                <div class="btnDelete btn btn-info"><i class="fa fa-trash"></i></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th class="text-right">Total :</th>
                                            <th class="text-center"><input type="text" name="txt_total_debit" readonly="" class="form-control" value="0.00"></th>
                                            <th class="text-center"><input type="text" name="txt_total_credit" readonly="" class="form-control" value="0.00"></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="row">
                                <br>
                                    <div class="text-center">
                                        <div class="form_add_result"></div>
                                        <div id="add_more" class="btn btn-default yellow btn-sm"><i class="fa fa-plus"></i>Add More</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_save_new" class="btn blue"><i class="fa fa-save fa-fw"></i>Save & New</button>
                                <button type="submit" name="btn_save_close" class="btn green"><i class="fa fa-save fa-fw"></i>Save & Close</button>
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
    //Press Button Add More
    var index_row = 1;
    $('#add_more').click(function(){ 
        $('#myTable').append('<tr data-row-id="'+(++index_row)+'">'+$('.my_form_base').html()+'</tr>');
        $('tr[data-row-id='+index_row+']').find('select').select2();
    });
    setTimeout(function(){
        $('#add_more').click();      
    },1000);
    //Delete Row By Row
    $("tbody").on('click', '.btnDelete', function () {
        var rowCount = $('tbody>tr').length;
        if(rowCount<=2){
            alert("You can not delete this record.");
            return;
        }
        $(this).parents('tr').remove();
        totalDebit();
        totalCredit();
    });
    function totalDebit () {
        let v_total_amo=0;
        $('td:nth-last-child(3) >input').each(function () {
            v_total_amo+=parseFloat($(this).val());
        });
        $('tfoot tr th:nth-last-child(3) >input').val(v_total_amo.toFixed(2));
    }
    function totalCredit () {
        let v_total_amo=0;
        $('td:nth-last-child(2) >input').each(function () {
            v_total_amo+=parseFloat($(this).val());
        });
        $('tfoot tr th:nth-last-child(2) >input').val(v_total_amo.toFixed(2));
    }
    function changeItemID (args) {
        var v_acc_id=$(args).val();
        $.ajax({url: 'ajx_get_content_select.php?v_acc_id='+v_acc_id+"&status=id",success:function (result) {
            $(args).parents('tbody >tr').find('td:nth-child(2) >select').html(result);
        }});
    }
    function changeItemName (args) {
        var v_acc_id=$(args).val();
        $.ajax({url: 'ajx_get_content_select.php?v_acc_id='+v_acc_id+"&status=name",success:function (result) {
            $(args).parents('tbody >tr').find('td:nth-child(1) >select').html(result);
        }});
    }
</script>
<?php include_once '../layout/footer.php' ?>