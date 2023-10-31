<?php 
    $menu_active =11;
    $left_menu =4;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
    include_once 'operation.php';
?>

<?php
if (isset($_POST['btn_submit'])) {
    $v_po_date = @$_POST['txt_date'];
    $v_po_no = @$_POST['txt_number'];
    $v_po_customer = @$_POST['cbo_customer'];
    $v_po_note = @$_POST['txt_note'];
    $v_po_date_li = @$_POST['txt_date_line'];
    $v_po_delivery = @$_POST['txt_deli'];
    $v_po_others = @$_POST['txt_others'];
    $v_po_quota_code = @$_POST['cbo_quote_code'];

    $query_add_1 = "INSERT INTO tbl_prod_add_po (
                po_no,
                po_date,
                po_customer,
                po_note,
                po_date_li,
                po_delivery,
                po_others,
                po_quota_code
                ) 
            VALUES
                (
                '$v_po_no',
                '$v_po_date',
                '$v_po_customer',
                '$v_po_note',
                '$v_po_date_li',
                '$v_po_delivery',
                '$v_po_others',
                '$v_po_quota_code'
                )";
    if ($connect->query($query_add_1)) {
        $flag_1 = 1;
        $v_id = $connect->insert_id;
    } else {
        echo 'Error';
        die();
    }

    $v_pol_name =       @$_POST['txt_name'];
    $v_pol_feature =    @$_POST['txt_feature'];
    $v_pol_length =     @$_POST['txt_length'];
    $v_pol_width =      @$_POST['txt_width'];
    $v_pol_thickness =  @$_POST['txt_thickness'];
    $v_pol_pcs_slab =   @$_POST['txt_pcs_slab'];
    $v_pol_m2=          @$_POST['txt_mater_kare'];
    $v_pol_note=        @$_POST['txt_note1'];

    foreach ($v_pol_name as $key => $value) {
        if ($value) {
            $new_pol_name =     $v_pol_name[$key];
            $new_pol_feature =  $v_pol_feature[$key];
            $new_pol_length =   $v_pol_length[$key];
            $new_pol_width =    $v_pol_width[$key];
            $new_pol_thickness =$v_pol_thickness[$key];
            $new_pol_pcs_slab = $v_pol_pcs_slab[$key];
            $new_pol_m2=        $v_pol_m2[$key];
            $new_pol_note=      $v_pol_note[$key];
            
            $query_add = "INSERT INTO tbl_prod_add_po_list (
                        pol_po_id,
                        pol_name,
                        pol_feature,
                        pol_length,
                        pol_width,
                        pol_thickness,
                        pol_pcs_slab,
                        pol_m2,
                        pol_note
                        ) 
                    VALUES
                        (
                        '$v_id',
                        '$new_pol_name',
                        '$new_pol_feature',
                        '$new_pol_length',
                        '$new_pol_width',
                        '$new_pol_thickness',
                        '$new_pol_pcs_slab',
                        '$new_pol_m2',
                        '$new_pol_note'
                        )";

            $flag = $connect->query($query_add);
        }
    }

    if ($flag_1 == 1 && $flag) {
        $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data inserted ...
            </div>';
    } else {
        $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> Query error ...
            </div>';
    }
}

?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <?= @$sms; ?>
                <h2>
                    <ol class="breadcrumb text-leght">       
                        <li class="breadcrumb-item"><h2><i class="fa fa-plus-circle fa-fw"></i></h2></li>
                        <li class="breadcrumb-item active">Create  Record</li>
                    </ol>
                </h2>            
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">            
                <h2>
                    <ol class="breadcrumb text-right">       
                        <li class="breadcrumb-item"><p id="pono_code"></p></li>
                        <li class="breadcrumb-item active">PURCHASE ORDER</li>
                    </ol>
                </h2>
        </div>
    </div>
    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Input Information</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" accept-charset="utf-8">
                    
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group ">
                                    <label>Customer Name : </label>
                                    <select name="cbo_customer" id="input" class="form-control myselect2" required="required">
                                        <option value="">=== Select Project Title ===</option>
                                        <?php 
                                            $sql=$connect->query("SELECT * FROM tbl_cus_customer_info ORDER BY cussi_id");
                                            while ($row=mysqli_fetch_object($sql)) {
                                                echo '<option value="'.$row->cussi_id.'">'.$row->cus_code.' || '.$row->cussi_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label>Address : </label>
                                    <input type="text" class="form-control" name="txt_address" autocomplete="off" readonly="" id="txt_address">
                                </div>
                                <div class="form-group ">
                                    <label>Phone : </label>
                                    <input type="text" class="form-control" name="txt_pho_num" autocomplete="off" readonly="" id="txt_pho_num">
                                </div>
                                <div class="form-group ">
                                    <label>Email : </label>
                                    <input type="text" class="form-control" name="txt_email" autocomplete="off" readonly="" id="txt_email">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group ">
                                    <label>PO No :  </label>
                                    <input type="text" onkeyup="changepono()" class="form-control" name="txt_number"  id="txt_number1" value="Thyping PO Code">

                                </div>
                                <div class="form-group ">
                                    <label>Date Record : </label>
                                    <input type="text" class="form-control" name="txt_date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  autocomplete="off" value="<?= date('Y-m-d') ?>" required="required">
                                </div>
                                <div class="form-group ">
                                    <label>Customer ID.:  </label>
                                    <input type="text" class="form-control" name="txt_cus_id"  autocomplete="off" readonly="">
                                </div>
                                <div class="form-group ">
                                    <label>Quote Code.:  </label>
                                    <select name="cbo_quote_code" id="input" class="form-control myselect2" required="required">
                                        <option value="">=== Select Project Title ===</option>
                                        <?php 
                                            $sql=$connect->query("SELECT * FROM tbl_prod_add_quote as A
                                                LEFT JOIN tbl_cus_customer_info AS C ON C.cussi_id=A.qt_customer
                                                ORDER BY qt_id");
                                            while ($row=mysqli_fetch_object($sql)) {
                                                echo '<option value="'.$row->qt_id.'">'.$row->qt_no.' || '.$row->cussi_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    
                    <hr>
                    <div class="portlet-body">
                        <div class="bs-example" data-example-id="bordered-table">
                    <table id="myTable" class="table table-bordered myFormDetail_ns">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10%;">Name<br>(Tên)</th>
                                <th class="text-center" style="width: 20%;">Feature<br>(Đặc tính)</th>
                                <th class="text-center">បណ្ដោយ <br> Dài</th>
                                <th class="text-center">ទទឹង <br> Rộng</th>
                                <th class="text-center">កម្រាស់ <br> PRICE</th>
                                <th class="text-center">សន្លឹក <br> Số Tấm</th>
                                <th class="text-center">ម៉ែតការ៉េ  <br> M2</th>
                                <th class="text-center">សំគ្គាល់  <br> Others</th>
                                <th class="text-center"> <i class="fa fa-cog fa-spin"></i> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="my_form_base" style="background: red; display: none;">
                                <td>
                                    <input type="text" name="txt_name[]" class="form-control" value="ANGKOR BLACK">
                                </td>
                                <td>
                                    <select class="form-control" name="txt_feature[]">
                                        <option value="">===  ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_inv_type_make ORDER BY tm_name");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_data->tm_id.'">'.$row_data->tm_code.' || '.$row_data->tm_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="number" onchange="changeLenght(this)" onkeyup="changeLenght(this)" step="1" name="txt_length[]" class="form-control"value="1" autocomplete="off" >
                                </td>
                                <td>
                                    <input type="number" onchange="changeWidth(this)" onkeyup="changeWidth(this)" step="60" name="txt_width[]" class="form-control" value="60">
                                </td>
                                <td>
                                    <input type="number" step="1.8" name="txt_thickness[]" class="form-control"value="1.80">
                                </td>
                                <td>
                                    <input type="number" name="txt_pcs_slab[]" onchange="changeHeight(this)" onkeyup="changeHeight(this)" class="form-control" value="0">
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="0" autocomplete="off" readonly="" name="txt_mater_kare[]">
                                </td>
                                <td>
                                    <input type="text" name="txt_note1[]" class="form-control" >
                                </td>
                                <td class="text-center">
                                    <button class="btnDelete btn btn-info"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                               
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th class="text-right">សរុប <br>TOTAL M <sup>2</sup></th>
                                <th ><input type="text" name="txt_total_slep" readonly="" id="totalslep" class="form-control" value="0" required="required" pattern="" title=""></th>
                                <th ><input type="text" name="txt_total_amo" readonly="" id="inputTxt_total_amo" class="form-control" value="0" required="required" pattern="" title=""></th>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                            </tr>
                        </tfoot>
                    </table>
                        </div>
                    </div>
                    <br>
                   
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group ">
                                    <label>Note : </label>
                                    <input type="text" class="form-control" name="txt_note"  autocomplete="off" required="required">
                                </div>
                                <div class="form-group ">
                                    <label>Date Line : </label>
                                    <input type="text" class="form-control" name="txt_date_line" data-provide="datepicker" data-date-format="yyyy-mm-dd"  autocomplete="off" value="<?= date('Y-m-d') ?>" required="required">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group ">
                                    <label>Delivery : </label>
                                    <input type="text" class="form-control" name="txt_deli"  autocomplete="off" required="required">
                                </div>
                                <div class="form-group ">
                                    <label>Others: </label>
                                    <input type="text" class="form-control" name="txt_others"  autocomplete="off" required="required">
                                </div>
                            </div>
                        </div>
                    <br>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_submit" class="btn green"><i class="fa fa-save fa-fw"></i>Save & New</button>
                                <div id="add_more" class="btn btn-default yellow btn-md" title="Click on this button to add more record !">[<i class="fa fa-plus"></i>]</div>
                                <a href="index.php?action=2" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
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
    //Refresh Cmbobox
    $('div#refresh_cbo_counter').click(function(){
        $.ajax({url: "ajax_get_content_select.php?d=cbo_counter", success: function(result){
            if($('select[name="cbo_counter"]').html().trim() != result.trim()){
                $('select[name="cbo_counter"]').html(result);
                myAlertInfo("Your refresh item successfully !");
            }
        }});
    });

    var index_row = 1;
    $('#add_more').click(function() {
        $('#myTable').append('<tr data-row-id="' + (++index_row) + '">' + $('.my_form_base').html() + '</tr>');
        $('tr[data-row-id=' + index_row + ']').find('select').select2({
            width: 'auto'
        });
    });

    setTimeout(function() {
        $('#add_more').click();
    }, 2000);

    $("tbody").on('click', '.btnDelete', function() {
        var rowCount = $('tbody>tr').length;
        if (rowCount < 3) {
            alert("You can not delete this record.");
            return;
        }
        $(this).parents('tr').remove();
    });

    $(document).ready(function(){
        $('select[name="cbo_customer"]').change(function () {
            let v_chart_acc_id=$(this).val();
            let myArr=[1,v_chart_acc_id];
            $.ajax({url: 'ajax_get_rec_info.php',
                    type: 'POST',
                    async: false,
                    data: 'data='+myArr,
                success:function (result) {
               last_result=result;
           }});
           var myObj=JSON.parse(last_result);
           $('input[name="txt_cus_id"]').val(myObj['code']);
           $('input[name="txt_email"]').val(myObj['email']);
           $('input[name="txt_address"]').val(myObj['address']);
           $('input[name="txt_pho_num"]').val(myObj['phone']);

       });
    });
    function changeLenght (obj) {
        var v_length=$(obj).val();
        var v_width=$(obj).parents('tr').find('td:nth-last-child(6) > input').val();
        var v_thickness=$(obj).parents('tr').find('td:nth-last-child(4) > input').val();
        var v_mater_cub= (v_length * v_width * v_thickness)/10000;
        $(obj).parents('tr').find('td:nth-last-child(3) > input').val(v_mater_cub.toFixed(2));
        totalAmount();
        
    }
    function changeWidth (obj) {
        var v_length=$(obj).parents('tr').find('td:nth-last-child(7) > input').val();
        var v_width=$(obj).val();
        var v_thickness=$(obj).parents('tr').find('td:nth-last-child(4) > input').val();
        var v_mater_cub= (v_length * v_width * v_thickness)/10000;
        $(obj).parents('tr').find('td:nth-last-child(3) > input').val(v_mater_cub.toFixed(2));
        totalAmount();
        
    }
    function changeHeight (obj) {
        var v_length=$(obj).parents('tr').find('td:nth-last-child(7) > input').val();
        var v_width=$(obj).parents('tr').find('td:nth-last-child(6) > input').val();
        var v_thickness=$(obj).val();
        var v_mater_cub= (v_length * v_width * v_thickness)/10000;
        $(obj).parents('tr').find('td:nth-last-child(3) > input').val(v_mater_cub.toFixed(2));
        totalAmount();
        totalslep();
    }
    function totalAmount () {
        var t_amo=0;
        $('input[name^="txt_mater_kare"]').each(function () {
            t_amo+= parseFloat($(this).val());
        });
        $('tfoot >tr:first-child').find('th:nth-last-child(3) >input[name=txt_total_amo]').val(t_amo.toFixed(3));
    }
    function totalslep () {
        var t_amo1=0;
        $('input[name^="txt_pcs_slab"]').each(function () {
            t_amo1+= parseFloat($(this).val());
        });
        $('tfoot >tr:first-child').find('th:nth-last-child(4) >input[name=txt_total_slep]').val(t_amo1);
    }
    function changepono () {
        $v_pono=$('input[name=txt_number]').val();

        document.getElementById("pono_code").innerHTML = '#'+$v_pono;

    }
    function set_iframe_counter(){
        document.getElementById('result_modal').src = '../inv_counter_list/index.php?view=iframe';
    }
    $zerol=0;
    document.getElementById("pono_code").innerHTML ='#'+$zerol;

  
</script>
<?php 
    include_once '../layout/footer.php';
 ?>
<div class="modal fade" id="add_modal">
    <div class="modal-dialog modal-lg" style="width: 50%;">
        <div class="modal-content">
            <div class="modal-body">
                <iframe id="result_modal" src="" width="100%" style="min-height: 600px; resize: vertical;" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>