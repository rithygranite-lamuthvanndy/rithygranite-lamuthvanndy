<?php 
    $menu_active =140;
    $left_active =0;
    $layout_title = "Edit Stock In";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
    if(@$_SESSION['save_call_back']){
        $sms='<div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Success !</strong> Updating record
            </div>';
        $_SESSION['save_call_back']=null;
    }

     // get old data 
    $edit_id = @$_GET['edit_id'];
    $old_data = $connect->query("SELECT * FROM tbl_st_stock_in WHERE stsin_id='$edit_id'");
    $row_old_data = mysqli_fetch_object($old_data);
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
                    Edit Stock <?= (($_SESSION['action']==2)?'In':'Out') ?> <?= $_SESSION['title'] ?>
                </h3>
            </div>
            <div class="panel-body">
                <form action="controller_update.php" method="post" id="form" enctype="multipart/form-data">
                    <input type="hidden" name="txt_parent_id" value="<?= $row_old_data->stsin_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                <div class="form-group">
                                    <label>Date Stock In *:
                                    </label>
                                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                        <input type="text" class="form-control" value="<?= $row_old_data->stsin_date_in ?>" name="txt_date_record" placeholder="Choose Date" required="" aufocomplete="off">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                <div class="form-group">
                                    <label>Letter Number *: </label>
                                    <input type="text" value="<?= $row_old_data->stsin_letter_no ?>" class="form-control" name="txt_letter_no" required=""  autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                <div class="form-group">
                                    <label>Request N&deg; *: </label>
                                    <input type="text" value="<?= $row_old_data->stsin_req_no ?>" class="form-control" name="txt_req_no" required=""  autocomplete="off">
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
                                                echo '<option '.($row_old_data->stsin_supp_id==$row_data->supsi_id?'selected':'').' value="'.$row_data->supsi_id.'">'.$row_data->supsi_name.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Note : </label>
                                    <textarea type="text" class="form-control" name="txt_note" rows="1" autocomplete="off"><?= $row_old_data->stsin_note ?></textarea>
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
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
                                <table id="myTable" class="table table-bordered" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width:15%;">កូដ</th>
                                            <th rowspan="2" class="text-center" style="width: 30%; vertical-align: middle;">ឈ្មោះ/Tền
                                                <a class="btn btn-primary btn-xs" data-toggle="modal" href='#modal' onclick="view_iframe_product_name();"><i class="fa fa-plus"></i></a>
                                                <div class="btn btn-success btn-xs" id="re_pro_name"><i class="fa fa-refresh"></i></div>
                                            </th>
                                            <th class="text-center" style="width: 10%;">ចំនួន</th>
                                            <th class="text-center" style="width: 14%;">ឯកតា</th>
                                            <th class="text-center" style="width: 10%; vertical-align: middle;">តម្លៃ/Giá(VN)</th>
                                            <th class="text-center" style="width: 10%; vertical-align: middle;">តម្លៃ/Giá($)</th>
                                            <th class="text-center" style="width: 15%;">សរុប</th>
                                            <th class="text-center" style="width: 3%;"> <i class="fa fa-cog fa-spin"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $v_sql_child="SELECT *,
                                                        (A.in_qty*A.in_price_vn/B.stsin_exchange_rate)+(A.in_qty*A.in_price_dollar) AS total_amo,C.stpron_code
                                                        FROM tbl_st_stock_in_detail AS A 
                                                        LEFT JOIN tbl_st_stock_in  AS B ON A.stsin_id=B.stsin_id
                                                        LEFT JOIN tbl_st_product_name AS C ON A.pro_id=C.stpron_id
                                                        WHERE A.stsin_id='$edit_id'
                                                        ";
                                            $v_result_child=$connect->query($v_sql_child);
                                            $v_total_amo=0;
                                            while ($row_child=mysqli_fetch_object($v_result_child)) {
                                                echo '<input type="hidden" value="'.$row_child->std_id.'" name="txt_status[]" id="inputTxt_acc_no" class="form-control">';
                                                echo '<tr>';
                                                    echo '<td>
                                                                <input type="text" value="'.$row_child->stpron_code.'" name="txt_pro_code[]" id="inputTxt_acc_no" class="form-control" readonly="">
                                                            </td>
                                                            <td>
                                                                <select class="form-control myselect2" name="cbo_pro_code[]">
                                                                    <option value="">== Please Choose and Select ==</option>';
                                                                        $v_select = $connect->query("SELECT stpron_id,stpron_code,stpron_name_vn,stpron_name_kh 
                                                                                                FROM tbl_st_product_name 
                                                                                                WHERE stpron_material_type='$_SESSION[status]'
                                                                                                ORDER BY stpron_code DESC");
    while ($row_data = mysqli_fetch_object($v_select)) {
    echo '<option '.($row_child->pro_id==$row_data->stpron_id?'selected':'').' value="'.$row_data->stpron_id.'" data_pro_code='.$row_data->stpron_code.'

    >
    ['.$row_data->stpron_code.'] '.$row_data->stpron_name_vn.' == '.$row_data->stpron_name_kh.'</option>';
                                                                        }
                                                                echo '</select>
                                                            </td>
                                                            <td>
                                                                <input type="number" step="1" name="txt_qty[]" class="form-control" value="'.$row_child->in_qty.'">
                                                            </td>
                                                            <td>
                                                                <select class="form-control myselect2" name="cbo_unit[]">
                                                                    <option value="">= Select =</option>';
                                                                        $v_select = $connect->query("SELECT * FROM tbl_st_unit_list ORDER BY stun_name DESC");
                                                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                                                            echo '<option '.($row_child->unit_id==$row_data->stun_id?'selected':'').' value="'.$row_data->stun_id.'" >'.$row_data->stun_name.'</option>';
                                                                        }
                                                                echo '</select>
                                                            </td>
                                                            <td>
                                                                <input type="number" step="0.001" name="txt_price_vn[]" class="form-control" value="'.$row_child->in_price_vn.'">
                                                            </td>
                                                            <td>
                                                                <input type="number" step="0.001" name="txt_price_dollar[]" class="form-control" value="'.$row_child->in_price_dollar.'">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="txt_amo[]" value="'.$row_child->total_amo.'" readonly="" id="inputTxt_acc_no" class="form-control">
                                                            </td>
                                                            <td class="text-center">
                                                                <div data_id="'.$row_child->std_id.'" class="btnDelete btn btn-danger btn-xs"><i class="fa fa-trash"></i></div>
                                                            </td>';
                                                echo '</tr>';
                                                $v_total_amo+=$row_child->total_amo;
                                            }
                                         ?>
                                        <input type="hidden" value="0" name="txt_status[]" id="inputTxt_acc_no" class="form-control">
                                        <tr class="my_form_base" style="background: red; display: none;">
                                            <td>
                                                <input type="text" name="txt_pro_code[]" id="inputTxt_acc_no" class="form-control" readonly="" style="width: 100%;">
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
             echo '<option value="'.$row_data->stpron_id.'" 
             data_pro_code='.$row_data->stpron_code.'
             data_unit_id='.$row_data->stpron_unit.'
            data_unit_name='.str_replace(' ','',$row_data->stun_name).'

             >['.$row_data->stpron_code.'] '.$row_data->stpron_name_vn.' == '.$row_data->stpron_name_kh.'</option>';
                                                        }
                                                     ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" step="1" name="txt_qty[]" class="form-control" value="0" style="width: 100%;">
                                            </td>
                                            <td>
                                                <select class="form-control" name="cbo_unit[]" style="width: 100%;">
                                                    <option value="">= Select =</option>
                                                    <?php 
                                                        $v_select = $connect->query("SELECT * FROM tbl_st_unit_list ORDER BY stun_name DESC");
                                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                                            echo '<option value="'.$row_data->stun_id.'" >'.$row_data->stun_name.'</option>';
                                                        }
                                                     ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" step="0.001" name="txt_price_vn[]" class="form-control" value="0" style="width: 100%;">
                                            </td>
                                            <td>
                                                <input type="number" step="0.001" name="txt_price_dollar[]" class="form-control" value="0" style="width: 100%;">
                                            </td>
                                            <td>
                                                <input type="text" name="txt_amo[]" value="0" readonly="" id="inputTxt_acc_no" class="form-control" style="width: 100%;">
                                            </td>
                                            <td class="text-center">
                                                <div data_id="0" class="btnDelete btn btn-danger btn-xs"><i class="fa fa-trash"></i></div>
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
                                            <th colspan="2"><?= number_format($v_total_amo,2) ?></th>
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
                                    <button type="submit" name="btn_save_in" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
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
    //Press Button Add More
    var index_row = 1;
    $('#add_more').click(function(){ 
        $('#myTable').append('<tr data-row-id="'+(++index_row)+'">'+$('.my_form_base').html()+'</tr>');
        $('tr[data-row-id='+index_row+']').find('select').select2();
    });
    // setTimeout(function(){
    //     $('#add_more').click();      
    // },1000);
    //Delete Row By Row
    $("tbody").on('click', 'div.btnDelete', function () {
        var rowCount = $('tbody >tr').length;
        if(rowCount<=2){
            alert("You can not delete this record.");
            return;
        }
        v_row_detail_id=$(this).attr('data_id');
        obj_delete=$(this);
        if(v_row_detail_id){
            $.get('delete_in.php?del_detail_id='+v_row_detail_id, function(data) {
                obj_delete.parents('tr').remove();
                myAlertSuccess('Delete');
            });
        }
    });
    $('tbody').on('keyup', 'tr td:nth-child(3) >input,tr td:nth-child(5) >input,tr td:nth-child(6) >input', function(event) {
        let v_qty=$(this).parents('tr').find('td:nth-child(3) input').val();
        let v_exchange_rate=$('input[name=txt_exchange_rate]').val();
        let v_price_vn=$(this).parents('tr').find('td:nth-child(5) input').val();
        let v_price_dollar=$(this).parents('tr').find('td:nth-child(6) input').val();
        let v_amo=(v_qty*v_price_vn/v_exchange_rate)+(v_price_dollar*v_qty);
        $(this).parents('tr').find('td:nth-child(7) input').val(v_amo.toFixed(2));
        totalAmount();
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
    });
    function view_iframe_product_name(){
        document.getElementById('result_modal').src = '../st_product_name/index.php?view=iframe';
    }
</script>
<div class="modal fade" id="modal">
    <div class="modal-dialog" style="border: 1px solid darkred; width: 70%;">
        <iframe id="result_modal" frameborder="0" style="height: 600px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>