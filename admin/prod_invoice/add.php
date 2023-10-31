<?php 
    $left_menu_active = 4;
    $menu_active =11;
    $left_active =0;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>

<?php 
    if(isset($_POST['btn_save'])){
        //Add Main Item
        $v_cus_name = @$connect->real_escape_string($_POST['cbo_cus_name']);
        $v_inv_no = @$connect->real_escape_string($_POST['txt_inv_no']);
        $v_date_record = @$connect->real_escape_string($_POST['txt_date_record']);
        $v_po_no = @$connect->real_escape_string($_POST['txt_po_no']);
        $v_deli_no = @$connect->real_escape_string($_POST['txt_deli_no']);
        $v_del_date = @$connect->real_escape_string($_POST['txt_del_date']);
        $v_total_dis_amount = @$connect->real_escape_string($_POST['txt_total_dis_amount']);

        $query_add = "INSERT INTO tbl_inv_sale_revenue(
        cus_id,
        inv_no, 
        date_record, 
        po_no, 
        delivery_no, 
        delivery_date, 
        total_discount,
        user_id
        )
        VALUES (
        '$v_cus_name',
        '$v_inv_no',
        '$v_date_record',
        '$v_po_no',
        '$v_deli_no',
        '$v_del_date',
        '$v_total_dis_amount',
        '$user_id'
        )";
        if($connect->query($query_add))
            $flag_add_1=1;
        $v_last_id=$connect->insert_id;

        $v_code= @$_POST['cbo_code'];
        $v_pro_name= @$_POST['cbo_pro_name'];
        $v_fea= @$_POST['cbo_fea'];
        $v_length= @$_POST['txt_length'];
        $v_width= @$_POST['txt_width'];
        $v_thickness= @$_POST['txt_thickness'];
        $v_slab= @$_POST['txt_slab'];
        $v_mater= @$_POST['txt_mater'];
        $v_mater_three= @$_POST['txt_mater_three'];
        $v_unit_price= @$_POST['txt_unit_price'];
        $v_amo= @$_POST['txt_amo'];
        foreach ($v_pro_name as $key => $value) {
            if($value){
                $new_code=$v_code[$key];
                $new_pro_name=$v_pro_name[$key];
                $new_fea=$v_fea[$key];
                $new_length=$v_length[$key];
                $new_width=$v_width[$key];
                $new_thickness=$v_thickness[$key];
                $new_slab=$v_slab[$key];
                $new_mater=$v_mater[$key];
                $new_mater_three=$v_mater_three[$key];
                $new_unit_price=$v_unit_price[$key];
                $new_amo=$v_amo[$key];
                 //Add Sub Item
                $query_add_2="INSERT INTO tbl_acc_inv_revenue_detial(
                    none_sale_rev_id, 
                    code, 
                    inv_pro_id, 
                    fea_id, 
                    length, 
                    width, 
                    thickness, 
                    slab, 
                    mater, 
                    unit_price, 
                    amount,
                    mater_three
                    )
                    VALUES
                    (
                    '$v_last_id',
                    '$new_code',
                    '$new_pro_name',
                    '$new_fea',
                    '$new_length',
                    '$new_width',
                    '$new_thickness',
                    '$new_slab',
                    '$new_mater',
                    '$new_unit_price',
                    '$new_amo',
                    '$new_mater_three'
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
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label for="input" class="control-label">Consignee Name*:</label>
                                    <select name="cbo_cus_name" id="input" class="form-control myselect2" required="required">
                                        <option value="">== Select and Choose ==</option>
                                        <?php 
                                            $sql=$connect->query("SELECT cussi_id,cussi_name,cus_code FROM tbl_cus_customer_info ORDER BY cus_code");
                                            while ($row_select=mysqli_fetch_object($sql)) {
                                                echo '<option value="'.$row_select->cussi_id.'">'.$row_select->cussi_name.'</option>';   
                                            }
                                         ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label>Customer ID : </label>
                                    <input type="text" name="txt_cus_id" class="form-control" required="" readonly="" placeholder="Auto Fill...">
                                </div>
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label for="input" class="control-label">Address*:</label>
                                    <input type="text" name="txt_address" class="form-control" readonly="" placeholder="Auto Fill ...">
                                </div>
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label for="input" class="control-label">Phone*:</label>
                                    <input type="text" name="txt_phone" class="form-control" readonly="" placeholder="Auto Fill ...">
                                </div>
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label for="input" class="control-label">Email*:</label>
                                    <input type="text" name="txt_email" class="form-control" readonly="" placeholder="Auto Fill ...">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label for="input" class="control-label">Invoice No*:</label>
                                    <input type="text" name="txt_inv_no" class="form-control" required="" placeholder="Invoice No .....">
                                </div>
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label>Date : </label>
                                    <input type="text" name="txt_date_record" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control date" required value="<?= date('Y-m-d') ?>">
                                </div>
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label>PO No : </label>
                                    <input type="text" class="form-control" required name="txt_po_no">
                                </div>
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label>Delivery No : </label>
                                    <input type="text" class="form-control" required name="txt_deli_no" placeholder="Delivery No ....">
                                </div>
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label>Delivery Date : </label>
                                    <input type="text" name="txt_del_date" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" required value="<?= date('Y-m-d') ?>">
                                </div>
                            </div>

                            <!-- Detail -->
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <br>    
                                <table id="myTable" class="table table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                            <th class="text-center" rowspan="2">Code</th>
                                            <th class="text-center" colspan="2">Description of Goods</th>
                                            <th class="text-center" colspan="3">Dimension (CM)</th>
                                            <th class="text-center" colspan="3">Quantity</th>
                                            <th class="text-center" rowspan="2">Unit Price <br> (USD)</th>
                                            <th class="text-center" rowspan="2">Amount <br> (USD) </th>
                                            <th class="text-center" rowspan="2"> <i class="fa fa-cog fa-spin"></i> Action</th>
                                        </tr>
                                         <tr>
                                            <th class="text-center">Inventory Name
                                                <button type="button" class="btn btn-primary btn-xs" id="add_inv_name"><i class="fa fa-plus"></i></button>
                                                <button type="button" class="btn btn-info btn-xs" id="re_inv_name"><i class="fa fa-refresh"></i></button>
                                            </th>
                                            <th class="text-center">Feacture
                                                <button type="button" class="btn btn-primary btn-xs" id="add_fea_name"><i class="fa fa-plus"></i></button>
                                                <button type="button" class="btn btn-info btn-xs" id="re_fea_name"><i class="fa fa-refresh"></i></button>
                                            </th>
                                            <th class="text-center">Length</th>
                                            <th class="text-center">Width</th>
                                            <th class="text-center">Thickness</th>
                                            <th class="text-center">Slab</th>
                                            <th class="text-center">M<sup>2</sup></th>
                                            <th class="text-center">M<sup>3</sup></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="my_form_base" style="background: red; display: none;">
                                            <td> 
                                                <select class="form-control" onchange="changeInvCode(this);" name="cbo_code[]">
                                                    <option value="">=== Please Choose and Select ===</option>
                                                    <?php 
                                                        $v_select = $connect->query("SELECT inv_pron_id,inv_pron_name_en,inv_pron_code FROM tbl_inv_product_name ORDER BY inv_pron_name_en DESC");
                                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                                            echo '<option data_id="'.$row_data->inv_pron_id.'" value="'.$row_data->inv_pron_code.'">'.$row_data->inv_pron_code.'</option>';
                                                        }
                                                     ?>
                                                </select>
                                                <!-- <input type="text" name="cbo_code[]" class="form-control"> -->
                                            </td>
                                            <td>
                                                <select class="form-control" onchange="changeInvName(this);"  name="cbo_pro_name[]">
                                                    <option value="">=== Please Choose and Select ===</option>
                                                    <?php 
                                                        $v_select = $connect->query("SELECT inv_pron_id,inv_pron_name_en,inv_pron_code FROM tbl_inv_product_name ORDER BY inv_pron_name_en DESC");
                                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                                            echo '<option value="'.$row_data->inv_pron_id.'">'.$row_data->inv_pron_name_en.'</option>';
                                                        }
                                                     ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" name="cbo_fea[]">
                                                    <option value="">=== Please Choose and Select ===</option>
                                                    <?php 
                                                        $v_select = $connect->query("SELECT id,name FROM tbl_inv_feature ORDER BY name DESC");
                                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                                            echo '<option value="'.$row_data->id.'">'.$row_data->name.'</option>';
                                                        }
                                                     ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="txt_length[]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="txt_width[]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="txt_thickness[]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" onkeyup="getSlab(this)" onchange="getSlab(this)" name="txt_slab[]" class="form-control" value="0">
                                            </td>    
                                            <td>
                                                <input type="text"  onkeyup="getMater(this)" onchange="getMater(this)" name="txt_mater[]" class="form-control" value="0">
                                            </td>
                                             <td>
                                                <input type="text"  onkeyup="getMater_three(this)" onchange="getMater_three(this)" name="txt_mater_three[]" class="form-control" value="0">
                                            </td>
                                            <td>
                                                <input type="text" onkeyup="getAmount(this);" name="txt_unit_price[]" onchange="getAmount(this);" class="form-control" value="0">
                                            </td>
                                            <td>
                                                <input type="text" name="txt_amo[]" value="0" readonly="" id="inputTxt_acc_no" class="form-control">
                                            </td>
                                            <td class="text-center">
                                                <div class="btnDelete btn btn-info"><i class="fa fa-trash"></i></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="6" class="text-center text-uppercase">Total:</th>
                                            <th><input type="text" name="txt_total_slab" readonly="" id="inputTxt_total_amo" class="form-control" value="0" required="required"></th>
                                            <th><input type="text" name="txt_total_mater" readonly="" id="inputTxt_total_amo" class="form-control" value="0" required="required"></th>
                                             <th><input type="text" name="txt_total_mater_three" readonly="" id="inputTxt_total_amo_three" class="form-control" value="0" required="required"></th>
                                            <th></th>
                                            <th><input type="text" name="txt_total_amount" readonly="" id="inputTxt_total_amo" class="form-control" value="0" required="required"></th>
                                        </tr>
                                        <tr>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th class="text-right" colspan="2">Discount:</th>
                                            <th><input type="text" name="txt_total_dis_amount" class="form-control" value="0"></th>
                                        </tr>
                                        <tr>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th class="text-right" colspan="2">Grand Total:</th>
                                            <th><input type="text" name="txt_total_grand_total" class="form-control" value="$ 0" readonly=""></th>                                        </tr>
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
                                <a href="export.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Export</a>
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
        totalAmount();
    });
    function getSlab (args) {
        var v_val=$(args).val();
        var v_total=0;
        $('input[name^="txt_slab"]').each(function () {
            v_total+=parseInt($(this).val());
        });
        $('input[name=txt_total_slab]').val(v_total);
    }
    function getMater (args) {
        var v_val=$(args).val();
        var v_totals=0;
        var total_thrr=$("#inputTxt_total_amo_three").val();


        $('input[name^="txt_mater"]').each(function () {
            v_totals+=parseFloat($(this).val());
        });

        v_totals=v_totals-total_thrr;
        $('input[name=txt_total_mater]').val(v_totals); 

        var v_unit_price=$(args).parents('tbody >tr').find('td:nth-last-child(3) >input').val();
        var v_mater=$(args).val();
        if(v_mater==0)
            v_amo=v_unit_price;
        else 
            v_amo=v_mater*v_unit_price;
        $(args).parents('tbody >tr').find('td:nth-last-child(2) >input').val(parseFloat(v_amo).toFixed(4));
        totalAmount();
    }

     function getMater_three (args) {
        var v_val=$(args).val();
        var v_total=0;
        $('input[name^="txt_mater_three"]').each(function () {
            v_total+=parseFloat($(this).val());
        });
        $('input[name=txt_total_mater_three]').val(v_total); 

        var v_unit_price=$(args).parents('tbody >tr').find('td:nth-last-child(3) >input').val();
        var v_mater=$(args).val();
        if(v_mater==0)
            v_amo=v_unit_price;
        else 
            v_amo=v_mater*v_unit_price;
        $(args).parents('tbody >tr').find('td:nth-last-child(2) >input').val(parseFloat(v_amo).toFixed(4));
        totalAmount();
    }
    function getAmount (args) {
        var v_unit_price=$(args).val();
        var v_mater=$(args).parents('tbody >tr').find('td:nth-last-child(4) >input').val();
        var v_mater_first=$(args).parents('tbody >tr').find('td:nth-last-child(5) >input').val();
        if(v_mater==0)
            v_amo=v_unit_price;
        else 
            v_amo_first=v_mater_first * v_unit_price;
            v_amo=v_mater*v_unit_price;
            if(v_amo==0){
                   v_amo_first=v_mater_first * v_unit_price;
                     $(args).parents('tbody >tr').find('td:nth-last-child(2) >input').val(parseFloat(v_amo_first).toFixed(4));
                totalAmount();
            }
             
        else{
             $(args).parents('tbody >tr').find('td:nth-last-child(2) >input').val(parseFloat(v_amo).toFixed(4));
        totalAmount();
        }
       
    }
    function totalAmount () {
        let v_total_amo=0;
        $('td:nth-last-child(2) >input').each(function () {
            v_total_amo+=parseFloat($(this).val());
        });
        $('tfoot >tr >th').find('input[name=txt_total_amount]').val(v_total_amo);
        var v_dis=0;
        $('tfoot >tr:last-child >th >input').val((v_total_amo-v_dis));
        return v_total_amo;
    }
    $('tfoot >tr:nth-last-child(2) >th >input').keyup(function () {
        let v_dis=parseFloat($(this).val());
        let v_total_amo=totalAmount();
        $('tfoot >tr:last-child >th >input').val((v_total_amo-v_dis).toFixed(2));
    });
    function changeInvCode (args) {
        let v_inv_id=$(args).find('option:selected').attr('data_id');
        $.ajax({url: 'ajx_get_content_select.php?p_inv_code='+v_inv_id,success:function (result) {
            $(args).parents('tr').find('td:nth-child(2) >select').html(result); 
        }});
    }
    function changeInvName (args) {
        let v_inv_id=$(args).val();
        $.ajax({url: 'ajx_get_content_select.php?p_inv_name='+v_inv_id,success:function (result) {
            $(args).parents('tr').find('td:nth-child(1) >select').html(result); 
                // $('select[name="cbo_code[]"]').html(result);
        }});
    }
    $(document).ready(function () {
        $('select[name=cbo_cus_name]').change(function () {
            let v_cus_id=$(this).val();
            $.ajax({url: 'ajx_get_cus_info.php?v_cus_id='+v_cus_id,success:function (result) {
                var myObj=JSON.parse(result);
                $('input[name=txt_cus_id]').val(myObj['cus_code']);
                $('input[name=txt_address]').val(myObj['cus_address']);
                $('input[name=txt_phone]').val(myObj['cus_phone']);
                $('input[name=txt_email]').val(myObj['cus_email']);
            }});
        });

        $('#add_inv_name').click(function () {
            $('#add_item').modal('show');
            $('iframe').attr('src','iframe_add_item.php?p_status=inv_name');
        });
        $('#re_inv_name').click(function () {
            $.ajax({url: 'ajx_get_content_select.php?status=cbo_pro_name',success:function (result) {
                if($('select[name="cbo_pro_name[]"]').html().trim()!=result.trim())
                    $('select[name="cbo_pro_name[]"]').html(result);
            }});
            $.ajax({url: 'ajx_get_content_select.php?status=cbo_pro_code',success:function (result) {
                if($('select[name="cbo_code[]"]').html().trim()!=result.trim())
                    $('select[name="cbo_code[]"]').html(result);
            }});
        });
        $('#add_fea_name').click(function () {
            $('#add_item').modal('show');
            $('iframe').attr('src','iframe_add_item.php?p_status=fea_name');
        });
        $('#re_fea_name').click(function () {
             $.ajax({url: 'ajx_get_content_select.php?status=cbo_fea',success:function (result) {
                if($('select[name="cbo_fea[]"]').html().trim()!=result.trim())
                    $('select[name="cbo_fea[]"]').html(result);
            }});
        });
    });
</script>
<?php include_once '../layout/footer.php' ?>
<div class="modal fade" id="add_item">
    <div class="modal-dialog" style="border: 1px solid darkred; width: 70%;">
        <iframe frameborder="0" style="height: 500px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>