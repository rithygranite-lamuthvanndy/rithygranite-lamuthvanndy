<?php 
    $menu_active =140;
    $left_active =0;
    $layout_title = "Create Stock In";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
    if(@$_SESSION['save_call_back']){
        $sms='<div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Success !</strong> Creating record
            </div>';
        $_SESSION['save_call_back']=null;
    }
 ?>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
        </div>
    </div>
    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-truck fa-flip-horizontal"></i> 
                    Create Stock Spare Part
                </h3>
            </div>
            <div class="panel-body">
                <form action="controller_save.php" method="post" id="form" enctype="multipart/form-data">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                <div class="form-group">
                                    <label>Date Stock In *:
                                    </label>
                                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                        <input type="text" class="form-control" value="<?= date('Y-m-d') ?>" name="txt_date_record" placeholder="Choose Date" required="" aufocomplete="off">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                <div class="form-group">
                                    <label>Letter Number *: </label>
                                    <input type="text" class="form-control" name="txt_letter_no" required=""  autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                <div class="form-group">
                                    <label>Request N&deg; *: </label>
                                    <input type="text" class="form-control" name="txt_req_no" required=""  autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                <div class="form-group">
                                    <label>Supplier *: </label>
                                    <select type="text" class="form-control myselect2" name="cbo_supplier" required="" autocomplete="off">
                                        <option value="">=== Select and choose===</option>
                                        <?php 
                                            $get_select=$connect->query("SELECT * FROM tbl_sup_supplier_info ORDER BY supsi_name ASC");
                                            while($row_data = mysqli_fetch_object($get_select)){
                                                echo '<option value="'.$row_data->supsi_id.'">'.$row_data->supsi_name.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Note : </label>
                                    <textarea type="text" class="form-control" name="txt_note" rows="1" autocomplete="off"></textarea>
                                </div>
                            </div>
                        </div>
                        <style type="text/css">
                            th{
                                white-space: nowrap;
                            }
                        </style>
                        <!-- Detail -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <table id="myTable" class="table table-bordered myFormDetail_ns" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 15%;">កូដ</th>
                                            <th rowspan="2" class="text-center" style="width: 30%; vertical-align: middle;">ឈ្មោះ/Tền
                                                <a class="btn btn-primary btn-xs" data-toggle="modal" href='#modal' onclick="view_iframe_product_name();"><i class="fa fa-plus"></i></a>
                                                <div class="btn btn-success btn-xs" id="re_pro_name"><i class="fa fa-refresh"></i></div>
                                            </th>
                                            <th class="text-center" style="width: 10%;">ចំនួន</th>
                                            <th class="text-center" style="width: 14%;">ឯកតា</th>
                                            <th class="text-center" style="width: 10%; vertical-align: middle;" rowspan="2">តម្លៃ/Giá(VN)</th>
                                            <th class="text-center" style="width: 10%; vertical-align: middle;" rowspan="2">តម្លៃ/Giá($)</th>
                                            <th class="text-center" style="width: 15%;">សរុប</th>
                                            <th class="text-center" style="width: 3%;"> <i class="fa fa-cog fa-spin"></i></th>
                                        </tr>
                                        <tr>
                                            <th class="text-center" style="width: 25%;">Mã</th>
                                            <th class="text-center" style="width: 7%;">số lượng</th>
                                            <th class="text-center" style="width: 7%;">Đơn vị</th>
                                            <th class="text-center" style="width: 15%;">Tổng công</th>
                                            <th class="text-center" style="width: 3%;"> <i class="fa fa-cog fa-spin"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="my_form_base" style="background: red; display: none;">
                                            <td>
                                                <input type="text" name="txt_pro_code[]" id="inputTxt_acc_no" class="form-control" readonly="">
                                            </td>
                                            <td>
                                                <select class="form-control" name="cbo_pro_code[]" style="width: 100%;">
                                                    <option value="">== Please Choose and Select ==</option>
                                                    <?php 
                                                        $v_select = $connect->query("SELECT stpron_id,stpron_code,stpron_name_vn,stpron_name_kh,stpron_unit,stun_name
                                            FROM tbl_st_product_name 
                        INNER JOIN tbl_st_unit_list
                        ON tbl_st_unit_list.stun_id=tbl_st_product_name.stpron_unit
                                WHERE stpron_material_type='$_SESSION[status]'
                                                                                    ORDER BY stpron_code DESC");
                                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                                            echo '<option value="'.$row_data->stpron_id.'" data_pro_code='.$row_data->stpron_code.'
    data_unit_id='.$row_data->stpron_unit.'
    data_unit_name='.str_replace(' ','',$row_data->stun_name).'
    >
    ['.$row_data->stpron_code.'] '.$row_data->stpron_name_vn.' == '.$row_data->stpron_name_kh.'
                                                            
                                                            </option>';
                                                        }
                                                     ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" step="1" name="txt_qty[]" class="form-control" value="0">
                                            </td>
                                            <td>
                                        <input class="form-control" type="text" value="" readonly="">
                                        <!--  <select class="form-control" name="cbo_unit[]">
                                                    <option value="">= Select =</option>
                                                    <?php 
                                                        // $v_select = $connect->query("SELECT * FROM tbl_st_unit_list ORDER BY stun_name DESC");
                                                        // while ($row_data = mysqli_fetch_object($v_select)) {
                                                        //     echo '<option value="'.$row_data->stun_id.'" >'.$row_data->stun_name.'</option>';
                                                        // }
                                                     ?>
                                                </select> -->

                                            </td>
                                            <td>
                                                <input type="number" step="0.001" name="txt_price_vn[]" class="form-control" value="0">
                                            </td>
                                            <td>
                                                <input type="number" step="0.001" name="txt_price_dollar[]" class="form-control" value="0">
                                            </td>
                                            <td>
                                                <input type="text" name="txt_amo[]" value="0" readonly="" id="inputTxt_acc_no" class="form-control">
                                            </td>
                                            <td class="text-center">
                                                <div class="btnDelete btn btn-danger btn-xs"><i class="fa fa-trash"></i></div>
                                                <input type="hidden" name="cbo_unit[]" value="">
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
                                            <th class="text-right">ទឹកប្រាក់សរុប <br>​ TOTAL AMOUNT</th>
                                            <th colspan="2">0</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="col-xs-2">
                                    <label>Exchange Rate :</label>
                                    <?php 
                                        $v_sql="SELECT stsin_exchange_rate FROM tbl_st_stock_in ORDER BY stsin_id DESC";
                                        $v_last_exchane=@mysqli_fetch_object($connect->query($v_sql))->stsin_exchange_rate;
                                     ?>
                                    <input class="form-control" type="text" name="txt_exchange_rate" value="<?= ($v_last_exchane?:23250) ?>">
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 text-center">
                                    <label>&nbsp;</label>
                                    <br>
                                    <div id="add_more" class="btn btn-default yellow btn-md"><i class="fa fa-plus-circle"></i> Add More</div>
                                    <button type="submit" name="btn_save_in" id="btn_save" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
                                    <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>
<?php include_once '../layout/footer.php' ?>
<script type="text/javascript">

    var qty = 0;
    var pricevn = 0;
    var pricedollar = 0;
    var name = -1;
    // var unit = -1;

    //Press Button Add More
    var index_row = 1;
    $('#add_more').click(function(){ 
        $('#myTable').append('<tr data-row-id="'+(++index_row)+'">'+$('.my_form_base').html()+'</tr>');
        $('tr[data-row-id='+index_row+']').find('select').select2();

        qty = 0;
        pricevn = 0;
        pricedollar = 0;
        name = -1;
        // unit = -1;
    });
    setTimeout(function(){
        $('#add_more').click();      
    },1000);
    //Delete Row By Row
    $("tbody").on('click', 'div.btnDelete', function () {
        var rowCount = $('tbody >tr').length;
        if(rowCount<=2){
            alert("You can not delete this record.");
            return;
        }
        $(this).parents('tr').remove();
    });
    $('tbody').on('keyup', 'tr td:nth-child(3) >input,tr td:nth-child(5) >input,tr td:nth-child(6) >input', function(event) {
        let v_qty=$(this).parents('tr').find('td:nth-child(3) input').val();
        let v_exchange_rate=$('input[name=txt_exchange_rate]').val();
        let v_price_vn=$(this).parents('tr').find('td:nth-child(5) input').val();
        let v_price_dollar=$(this).parents('tr').find('td:nth-child(6) input').val();
        let v_amo=(v_qty*v_price_vn/v_exchange_rate)+(v_price_dollar*v_qty);
        $(this).parents('tr').find('td:nth-child(7) input').val(v_amo.toFixed(2));
        totalAmount();
        qty = v_qty;
        pricevn = v_price_vn;
        pricedollar = v_price_dollar;

    });
    function totalAmount(){
        let v_total_amo=0;
        $('tbody >tr').each(function(index, el) {
            v_amo=parseFloat($(this).find('td:nth-last-child(2) >input').val());
            v_total_amo+=v_amo;
        });
        $('tfoot tr th:last-child').html(v_total_amo.toFixed(2));
    }

    $('#re_pro_name').click(function () {
        $.ajax({url: 'ajx_get_content_select.php?status=re_pro_name',success:function (result) {
            if($('select[name="cbo_pro_code[]"]').html().trim()!=result.trim())
                $('select[name="cbo_pro_code[]"]').html(result);
        }});
        myAlertInfo("Refresh Product Name");
    });
    $("tbody").on('change', 'tr td:nth-child(2) select', function () {
        v_pro_code=$(this).find('option:selected').attr('data_pro_code');
        $(this).parents('tr').find('td:first-child input').val(v_pro_code);

         data_unit_name=$(this).find('option:selected').attr('data_unit_name'); 
            $(this).parents('tr').find('td:nth-child(4) input').val(data_unit_name);

            data_unit_id=$(this).find('option:selected').attr('data_unit_id'); 
            $(this).parents('tr').find('td:nth-child(8) input').val(data_unit_id);

        name = v_pro_code;
       // alert(data_unit_name);
    });

    $("tbody").on('change', 'tr td:nth-child(4) select', function () {
        unit = $(this).find('option:selected').val();
    });
    function view_iframe_product_name(){
        document.getElementById('result_modal').src = '../st_product_name/index.php?view=iframe';
    }

    // $('#btn_save').on('click', function(e)
    // {
    //     var tr_am = $('#myTable').find('tbody tr').length-1;
    //     var i=1;
    //     for(i=1;i<=tr_am;i++)
    //     {
    //         var name = $('#myTable').find('tbody tr:eq('+i+') td:eq(1) select').val();
    //         var qty = $('#myTable').find('tbody tr:eq('+i+') td:eq(2) input').val();
    //         var unit = $('#myTable').find('tbody tr:eq('+i+') td:eq(3) select').val();
    //         var pr_vn = $('#myTable').find('tbody tr:eq('+i+') td:eq(4) input').val();
    //         var pr_d = $('#myTable').find('tbody tr:eq('+i+') td:eq(5) input').val();
    //         if(name==0 || name=='')
    //         {
    //             alert('Please select NAME!');
    //             $('#myTable').find('tbody tr:eq('+i+') td:eq(1) select').focus();
    //             e.preventDefault();
    //             break;
    //         }
    //         else if(qty==0 || qty=='')
    //         {
    //             alert('Please input QTY!');
    //             $('#myTable').find('tbody tr:eq('+i+') td:eq(2) input').focus();
    //             e.preventDefault();
    //             break; 
    //         }
    //         else if(unit==0 || unit=='')
    //         {
    //             alert('Please select UNIT!');
    //             $('#myTable').find('tbody tr:eq('+i+') td:eq(3) select').focus();
    //             e.preventDefault();
    //             break; 
    //         }  
    //         else if((pr_vn==0 || pr_vn=='') && (pr_d==0 || pr_d==''))
    //         {
    //             alert('Please input PRICE!');
    //             // $('#myTable').find('tbody tr:eq('+i+') td:eq(4) input').focus();
    //             e.preventDefault();
    //             break; 
    //         }
    //         // else if(pr_d==0 || pr_d=='')
    //         // {
    //         //     alert('Please input price of DOLLAR!');
    //         //     $('#myTable').find('tbody tr:eq('+i+') td:eq(5) input').focus();
    //         //     e.preventDefault();
    //         //     break; 
    //         // }
    //     }
    // });

</script>
<div class="modal fade" id="modal">
    <div class="modal-dialog" style="border: 1px solid darkred; width: 70%;">
        <iframe id="result_modal" frameborder="0" style="height: 600px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>