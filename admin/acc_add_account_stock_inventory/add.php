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
        $query_add = "INSERT INTO tbl_acc_rec_stock_inventory(
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

        $v_code= @$_POST['txt_code'];
        $v_description= @$_POST['cbo_description'];
        $v_tran_note= @$_POST['txt_tran_note'];
        $v_doc_ref= @$_POST['txt_doc_ref'];
        $v_qty= @$_POST['txt_qty'];
        $v_unit= @$_POST['txt_unit'];
        $v_price= @$_POST['txt_price'];
        $v_credit= @$_POST['txt_credit'];
        $v_debit= @$_POST['txt_debit'];
        foreach ($v_description as $key => $value) {
            if($value){
                $new_code=$v_code[$key];
                $new_description=$v_description[$key];
                $new_tran_note=$v_tran_note[$key];
                $new_doc_ref=$v_doc_ref[$key];
                $new_qty=$v_qty[$key];
                $new_unit=$v_unit[$key];
                $new_price=$v_price[$key];
                $new_credit=$v_credit[$key];
                $new_debit=$v_debit[$key];
                 //Add Sub Item
                $query_add_2="INSERT INTO tbl_acc_rec_stock_inventory_detail(
                    detail_id, 
                    code_no, 
                    description_id, 
                    tran_note, 
                    doc_ref, 
                    quantity, 
                    unit, 
                    price,  
                    debit, 
                    credit
                    )
                    VALUES
                    (
                    '$v_last_id',
                    '$new_code',
                    '$new_description',
                    '$new_tran_note',
                    '$new_doc_ref',
                    '$new_qty',
                    '$new_unit',
                    '$new_price',
                    '$new_debit',
                    '$new_credit'
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
        $query_add = "INSERT INTO tbl_acc_rec_stock_inventory(
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

        $v_code= @$_POST['txt_code'];
        $v_description= @$_POST['cbo_description'];
        $v_tran_note= @$_POST['txt_tran_note'];
        $v_doc_ref= @$_POST['txt_doc_ref'];
        $v_qty= @$_POST['txt_qty'];
        $v_unit= @$_POST['txt_unit'];
        $v_price= @$_POST['txt_price'];
        $v_credit= @$_POST['txt_credit'];
        $v_debit= @$_POST['txt_debit'];
        foreach ($v_description as $key => $value) {
            if($value){
                $new_code=$v_code[$key];
                $new_description=$v_description[$key];
                $new_tran_note=$v_tran_note[$key];
                $new_doc_ref=$v_doc_ref[$key];
                $new_qty=$v_qty[$key];
                $new_unit=$v_unit[$key];
                $new_price=$v_price[$key];
                $new_credit=$v_credit[$key];
                $new_debit=$v_debit[$key];
                 //Add Sub Item
                $query_add_2="INSERT INTO tbl_acc_rec_stock_inventory_detail(
                    detail_id, 
                    code_no, 
                    description_id, 
                    tran_note, 
                    doc_ref, 
                    quantity, 
                    unit, 
                    price,  
                    debit, 
                    credit
                    )
                    VALUES
                    (
                    '$v_last_id',
                    '$new_code',
                    '$new_description',
                    '$new_tran_note',
                    '$new_doc_ref',
                    '$new_qty',
                    '$new_unit',
                    '$new_price',
                    '$new_debit',
                    '$new_credit'
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
                                            <th class="text-center">Code</th>
                                            <th class="text-center" style="width: 20%;">Description</th>
                                            <th class="text-center" style="width: 20%;">Transation Note</th>
                                            <th class="text-center" style="width: 15%;">Document Ref</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center" style="width: 5%;">Unit</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Debit</th>
                                            <th class="text-center">Credit</th>
                                            <th class="text-center" style="width: 5%;"> <i class="fa fa-cog fa-spin"></i> Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="my_form_base" style="background: red; display: none;">
                                            <td>
                                                <input type="text" name="txt_code[]" class="form-control">
                                            </td>
                                            <td>
                                                <select class="form-control" name="cbo_description[]">
                                                    <option value="">=== Please Choose and Select ===</option>
                                                    <?php 
                                                        $v_select = $connect->query("SELECT des_id,des_name FROM tbl_acc_decription ORDER BY des_name DESC");
                                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                                            echo '<option value="'.$row_data->des_id.'">'.$row_data->des_name.'</option>';
                                                        }
                                                     ?>
                                                </select>
                                            </td>
                                            <td>
                                                <textarea name="txt_tran_note[]" id="inputTxt_tran_note" class="form-control" rows="1"></textarea>
                                            </td>
                                            <td>
                                                <textarea name="txt_doc_ref[]" id="inputTxt_tran_note" class="form-control" rows="1"></textarea>
                                            </td>
                                            <td>
                                                <input onkeyup="cal_credit(this)" type="number" min="0" step="1" name="txt_qty[]" class="form-control" value="0">
                                            </td>  
                                            <td>
                                                <input type="text"  name="txt_unit[]" class="form-control">
                                            </td>  
                                            <td>
                                                <input onkeyup="cal_credit(this)" type="number" min="0" step="0.01"  name="txt_price[]" class="form-control" value="0.00">
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
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th class="text-right" colspan="2">Total :</th>
                                            <th class="text-center"><input type="text" name="txt_total_debit" readonly="" class="form-control" value="0.00"></th>
                                            <th class="text-center"><input type="text" name="txt_total_credit" readonly="" class="form-control" value="0.00"></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th class="text-right" colspan="2">Out of Balance :</th>
                                            <th class="text-center" colspan="2"><input type="text" name="txt_out_of_bal" readonly="" class="form-control" value="0.00"></th>
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
    function cal_credit (args) {
        var v_qty=$(args).parents('tbody >tr').find('td:nth-last-child(6) >input').val();
        var v_price=$(args).parents('tbody >tr').find('td:nth-last-child(4) >input').val();
        var v_credit=v_qty*v_price;
        var v_price=$(args).parents('tbody >tr').find('td:nth-last-child(2) >input').val(v_credit.toFixed(2));
        totalCredit();
    }
    function totalDebit () {
        let v_total_amo=0;
        $('td:nth-last-child(3) >input').each(function () {
            v_total_amo+=parseFloat($(this).val());
        });
        $('tfoot tr:first-child th:nth-last-child(3) >input').val(v_total_amo.toFixed(2));
        var total_debit=v_total_amo;
        var total_credit=$('tfoot tr:first-child th:nth-last-child(2) >input').val();
        $('tfoot tr:last-child th:nth-last-child(2) >input').val((total_debit-total_credit).toFixed(2));
    }
    function totalCredit () {
        let v_total_amo=0;
        $('td:nth-last-child(2) >input').each(function () {
            v_total_amo+=parseFloat($(this).val());
        });
        $('tfoot tr:first-child th:nth-last-child(2) >input').val(v_total_amo.toFixed(2));
        var total_credit=v_total_amo;
        var total_debit=$('tfoot tr:first-child th:nth-last-child(3) >input').val();
        $('tfoot tr:last-child th:nth-last-child(2) >input').val((total_debit-total_credit).toFixed(2));
    }
</script>
<?php include_once '../layout/footer.php' ?>