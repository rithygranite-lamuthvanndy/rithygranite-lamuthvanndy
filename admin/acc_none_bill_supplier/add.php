<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>

<?php 
    if(isset($_POST['btn_save'])){
        //Add Main Item
        $v_supp_name = @$connect->real_escape_string($_POST['cbo_supp_name']);
        $v_inv_no = @$connect->real_escape_string($_POST['txt_inv_no']);
        $v_date_record = @$connect->real_escape_string($_POST['txt_date_record']);
        $v_total_dis_amount = @$connect->real_escape_string($_POST['txt_total_dis_amount']);
        $v_note = @$connect->real_escape_string($_POST['txt_note']);

        $query_add = "INSERT INTO tbl_acc_none_bill_supp(
        supp_id,
        inv_no, 
        date_record, 
        total_discount,
        note,
        user_id
         )
        VALUES (
        '$v_supp_name',
        '$v_inv_no',
        '$v_date_record',
        '$v_total_dis_amount',
        '$v_note',
        '$user_id'
        )";
        if($connect->query($query_add))
            $flag_add_1=1;
        $v_last_id=$connect->insert_id;

        $v_des_name= @$_POST['txt_des_name'];
        $v_po_no= @$_POST['txt_po_no'];
        $v_pur_con_no= @$_POST['txt_pur_con_no'];
        $v_item_no= @$_POST['cbo_item_no'];
        $v_qty= @$_POST['txt_qty'];
        $v_unit_price= @$_POST['txt_unit_price'];
        $v_amo= @$_POST['txt_amo'];
        foreach ($v_item_no as $key => $value) {
            if($value){
                $new_des_name=$v_des_name[$key];
                $new_po_no=$v_po_no[$key];
                $new_pur_con_no=$v_pur_con_no[$key];
                $new_item_no=$v_item_no[$key];
                $new_qty=$v_qty[$key];
                $new_unit_price=$v_unit_price[$key];
                $new_amo=$v_amo[$key];
                 //Add Sub Item
                $query_add_2="INSERT INTO tbl_acc_none_bill_supp_detail(
                    none_bill_supp_id, 
                    decription, 
                    po_no, 
                    pur_confirm_no, 
                    item_id, 
                    qty,  
                    unit_price, 
                    amount
                    )
                    VALUES
                    (
                    '$v_last_id',
                    '$new_des_name',
                    '$new_po_no',
                    '$new_pur_con_no',
                    '$new_item_no',
                    '$new_qty',
                    '$new_unit_price',
                    '$new_amo'
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
                                    <label for="input" class="control-label">Supplier Name*:</label>
                                    <button type="button" class="btn btn-primary btn-xs" id="add_supp_name"><i class="fa fa-plus"></i></button>
                                    <button type="button" class="btn btn-info btn-xs" id="re_supp_name"><i class="fa fa-refresh"></i></button>
                                    <select name="cbo_supp_name" id="input" class="form-control myselect2" required="required">
                                        <option value="">== Select and Choose ==</option>
                                        <?php 
                                            $sql=$connect->query("SELECT supsi_id,supsi_name FROM tbl_sup_supplier_info ORDER BY supsi_name");
                                            while ($row_select=mysqli_fetch_object($sql)) {
                                                echo '<option value="'.$row_select->supsi_id.'">'.$row_select->supsi_name.'</option>';   
                                            }
                                         ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="input" class="control-label">Address*:</label>
                                    <textarea name="txt_sup_add" id="inputTxt_sup_add" readonly="" class="form-control" rows="2" placeholder="Auto Fill"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="input" class="control-label">Phone*:</label>
                                    <input type="text" name="txt_sup_phone" class="form-control" readonly="" placeholder="Auto Fill ...">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Date : </label>
                                    <input type="text" name="txt_date_record" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control date" required value="<?= date('Y-m-d') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="input" class="control-label">Invoice No*:</label>
                                    <input type="text" name="txt_inv_no" class="form-control" required="" placeholder="Invoice No .....">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Note : </label>
                                    <div class="form-group">
                                        <textarea name="txt_note" id="textarea" class="form-control" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Detail -->
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <br>    
                                <table id="myTable" class="table table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 15%;">Descriptions</th>
                                            <th class="text-center" style="width: 5%;">PO No</th>
                                            <th class="text-center">Purchase Comfirmation N&deg;</th>
                                            <th class="text-center">Item Code<br>
                                                <a class="btn btn-primary btn-xs" data-toggle="modal" href='#add_item' onclick="view_iframe_product_name()"><i class="fa fa-plus"></i></a>
                                                <button type="button" class="btn btn-info btn-xs" id="re_item"><i class="fa fa-refresh"></i></button>
                                            </th>
                                            <th class="text-center" style="width: 20%;">Item Name</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center"> <i class="fa fa-cog fa-spin"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="my_form_base" style="background: red; display: none;">
                                            <td>
                                                <input type="text" name="txt_des_name[]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="txt_po_no[]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="txt_pur_con_no[]" class="form-control">
                                            </td>
                                            <td>
                                                <select class="form-control" onchange="changeItemCode(this);" name="cbo_item_no[]">
                                                    <option value="">=== Please Choose and Select ===</option>
                                                    <?php 
                                                        $v_select = $connect->query("SELECT stpron_id,stpron_code,stpron_name_vn FROM tbl_st_product_name ORDER BY stpron_code DESC");
                                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                                            echo '<option value="'.$row_data->stpron_id.'">'.$row_data->stpron_code.'</option>';
                                                        }
                                                     ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" onchange="changeItemName(this);"  name="cbo_item_name[]">
                                                    <option value="">=== Please Choose and Select ===</option>
                                                    <?php 
                                                        $v_select = $connect->query("SELECT stpron_id,stpron_code,stpron_name_vn,stpron_name_kh FROM tbl_st_product_name ORDER BY stpron_code DESC");
                                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                                            echo '<option value="'.$row_data->stpron_id.'">'.$row_data->stpron_name_kh.'</option>';
                                                        }
                                                     ?>
                                                </select>
                                            </td>    
                                            <td>
                                                <input type="text" onkeyup="getQty(this)" onchange="getQty(this)" name="txt_qty[]" class="form-control" value="1">
                                            </td>
                                            <td>
                                                <input type="text" onkeyup="getUnitPrce(this);" name="txt_unit_price[]" onchange="getUnitPrce(this);" class="form-control" value="0.001">
                                            </td>
                                            <td>
                                                <input type="text" name="txt_amo[]" value="0.001" readonly="" id="inputTxt_acc_no" class="form-control">
                                            </td>
                                            <td class="text-center">
                                                <div class="btnDelete btn btn-info btn-xs"><i class="fa fa-trash"></i></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th class="text-right" colspan="2">Total Amount:</th>
                                            <th class="text-center" colspan="2"><input type="text" name="txt_total_amount" readonly="" class="form-control" value="0.01"></th>
                                            <th style="visibility: hidden;"></th>
                                        </tr>
                                        <tr>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th class="text-right" colspan="2">Discount:</th>
                                            <th class="text-center" colspan="2"><input type="text" name="txt_total_dis_amount" class="form-control" value="0"></th>
                                            <th style="visibility: hidden;"></th>
                                        </tr>
                                        <tr>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th class="text-right" colspan="2">Grand Total:</th>
                                            <th class="text-center" colspan="2"><input type="text" name="txt_grand_total" readonly="" class="form-control" value="0.01"></th>
                                            <th style="visibility: hidden;"></th>
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
                                <button type="submit" name="btn_save" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
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
        totalAmount();
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
        totalAmount();
    });
    function getQty (args) {
        var v_qty=parseInt($(args).val());
        var v_unit_price=parseFloat($(args).parents('tbody >tr').find('td:nth-last-child(3) >input').val());
        $(args).parents('tbody >tr').find('td:nth-last-child(2) >input').val((v_qty*v_unit_price).toFixed(3));
        totalAmount();
    }
    function getUnitPrce (args) {
        var v_unit_price=parseFloat($(args).val());
        var v_qty=parseInt($(args).parents('tbody >tr').find('td:nth-last-child(4) >input').val());
        $(args).parents('tbody >tr').find('td:nth-last-child(2) >input').val((v_qty*v_unit_price).toFixed(3));
        totalAmount();
    }
    function totalAmount () {
        let v_total_amo=-0.001;
        $('td:nth-last-child(2) >input').each(function () {
            v_total_amo+=parseFloat($(this).val());
        });
        $('tfoot >tr >th').find('input[name=txt_total_amount]').val(v_total_amo.toFixed(3));
        $('tfoot >tr:last-child >th >input').val(v_total_amo.toFixed(3));
        return v_total_amo;
    }
    function changeItemCode (args) {
        var v_item_id=$(args).val();
        $.ajax({url: 'ajax_get_item_name.php?v_item_id='+v_item_id+"&status=code",async: false,success:function (result) {
            $(args).parents('tbody >tr').find('td:nth-child(5) >select').html(result);
        }});
    }
    function changeItemName (args) {
        var v_item_id=$(args).val();
        $.ajax({url: 'ajax_get_item_name.php?v_item_id='+v_item_id+"&status=name",async: false,success:function (result) {
            $(args).parents('tbody >tr').find('td:nth-child(4) >select').html(result);
        }});
    }
    $('tfoot >tr:nth-last-child(2) >th >input').keyup(function () {
        let v_dis=parseFloat($(this).val());
        let v_total_amo=totalAmount();
        $('tfoot >tr:last-child >th >input').val((v_total_amo-v_dis).toFixed(2));
    });
    
    $(document).ready(function () {
        $('select[name=cbo_supp_name]').change(function () {
            let v_sup_id=$(this).val();
            $.ajax({url: 'ajx_get_supp_info.php?v_sup_id='+v_sup_id,success:function (result) {
                // alert(result);
                var myObj=JSON.parse(result);
                $('textarea[name=txt_sup_add]').val(myObj['sup_address']);
                $('input[name=txt_sup_phone]').val(myObj['sup_phone']);
            }});
        });
        $('#add_supp_name').click(function () {
            $('#add_item').modal('show');
            $('iframe').attr('src','iframe_add_item.php?p_status=supp_name');
        });
        $('#re_supp_name').click(function () {
            $.ajax({url: 'ajx_get_content_select.php?status=cbo_supp_name',success:function (result) {
                if($('select[name="cbo_supp_name"]').html().trim()!=result.trim())
                    $('select[name="cbo_supp_name"]').html(result);
            }});
        });
        $('#re_item').click(function () {
             $.ajax({url: 'ajx_get_content_select.php?status=cbo_item_no',success:function (result) {
                if($('select[name="cbo_item_no[]"]').html().trim()!=result.trim())
                    $('select[name="cbo_item_no[]"]').html(result);
            }});

            $.ajax({url: 'ajx_get_content_select.php?status=cbo_item_name',success:function (result) {
                if($('select[name="cbo_item_name[]"]').html().trim()!=result.trim()){
                    $('select[name="cbo_item_name[]"]').html(result);
                }
            }});
        });
    });
    function view_iframe_product_name(){
        document.getElementById('result_modal').src = '../st_product_name/index.php?view=iframe';
    }
</script>
<?php include_once '../layout/footer.php' ?>
<div class="modal fade" id="add_item">
    <div class="modal-dialog" style="border: 1px solid darkred; width: 70%;">
        <iframe id="result_modal" frameborder="0" style="height: 600px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>