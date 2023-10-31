<?php 
    $menu_active =11;
    $left_menu =1;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
    include_once 'operation.php';
?>

<?php
if (isset($_POST['btn_submit'])) {
    $v_qt_date = @$_POST['txt_date'];
    $v_qt_no = @$_POST['txt_number'];
    $v_qt_customer = @$_POST['cbo_customer'];
    $v_qt_estimate = @$_POST['txt_estimate'];
    $v_qt_note = @$_POST['txt_note'];
    $v_qt_date_start = @$_POST['txt_date_s'];
    $v_qt_date_end = @$_POST['txt_date_e'];

    $query_add_1 = "INSERT INTO tbl_prod_add_quote (
                qt_no,
                qt_date,
                qt_customer,
                qt_estimate,
                qt_note,
                qt_date_start,
                qt_date_end
                ) 
            VALUES
                (
                '$v_qt_no',
                '$v_qt_date',
                '$v_qt_customer',
                '$v_qt_estimate',
                '$v_qt_note',
                '$v_qt_date_start',
                '$v_qt_date_end'
                )";
    if ($connect->query($query_add_1)) {
        $flag_1 = 1;
        $v_id = $connect->insert_id;
    } else {
        echo 'Error';
        die();
    }

    $v_qtl_name = @$_POST['txt_name'];
    $v_qtl_feature = @$_POST['txt_feature'];
    $v_qtl_length = @$_POST['txt_length'];
    $v_qtl_width = @$_POST['txt_width'];
    $v_qtl_thickness = @$_POST['txt_thickness'];
    $v_qtl_pcs_m2 = @$_POST['txt_pcs_m2'];
    $v_qtl_price=@$_POST['txt_price'];
    $v_qtl_note=@$_POST['txt_note1'];

    foreach ($v_qtl_name as $key => $value) {
        if ($value) {
            $new_qtl_name = $v_qtl_name[$key];
            $new_qtl_feature = $v_qtl_feature[$key];
            $new_qtl_length = $v_qtl_length[$key];
            $new_qtl_width = $v_qtl_width[$key];
            $new_qtl_thickness = $v_qtl_thickness[$key];
            $new_qtl_pcs_m2 = $v_qtl_pcs_m2[$key];
            $new_qtl_price=$v_qtl_price[$key];
            $new_qtl_note=$v_qtl_note[$key];
            $query_add = "INSERT INTO tbl_prod_add_quote_list (
                        qtl_qt_id,
                        qtl_name,
                        qtl_feature,
                        qtl_length,
                        qtl_width,
                        qtl_thickness,
                        qtl_pcs_m2,
                        qtl_price,
                        qtl_note
                        ) 
                    VALUES
                        (
                        '$v_id',
                        '$new_qtl_name',
                        '$new_qtl_feature',
                        '$new_qtl_length',
                        '$new_qtl_width',
                        '$new_qtl_thickness',
                        '$new_qtl_pcs_m2',
                        '$new_qtl_price',
                        '$new_qtl_note'
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
                <i class="fa fa-plus-circle fa-fw"></i>Create  Record
            </h2>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="col-xs-6">
                <p class="text-right" style="font-family: 'Times New Roman'; font-size: 60px;" id="frpc_code"></p>
            </div>
            <div class="col-xs-6">
                <p class="text-right" style="font-family: 'Times New Roman'; font-size: 60px;" id="qt_code">QUOTATION </p>
            </div>     
            
        </div>
    </div>
    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Input Information</h3>
            </div>
            <div class="panel-body">
                <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                    <form action="#" method="post" enctype="multipart/form-data" autocomplete="off">
                    <?php if(!@$_GET['status']=='add_more'){ ?>
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
                                    <label>Template : </label>
                                        <select name="txt_estimate" id="input" class="form-control myselect2" required="required">
                                            <option value="">*** Select and choose ***</option>
                                            <?php 
                                                $v_result=$connect->query("SELECT * FROM tbl_estimate ORDER BY te_id");
                                                while ($row_select=mysqli_fetch_object($v_result)) {
                                                echo '<option data_code="'.$row_select->te_code.'" value="'.$row_select->te_id.'">'.$row_select->te_code.' || '.$row_select->te_name_kh.'|| '.$row_select->te_name_en.'</option>';

                                                }
                                             ?>
                                        </select>
                                </div>
                                <div class="form-group " placeholder="date end">
                                    <label>QT No :  </label>
                                    <input type="text" class="form-control" name="txt_number" readonly="">
                                </div>
                                <div class="form-group ">
                                    <label>Date Record : </label>
                                    <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" required name="txt_date" value="<?= date('Y-m-d') ?>"> 
                                </div>
                                <div class="form-group ">
                                    <label>Customer ID.:  </label>
                                    <input type="text" class="form-control" name="txt_cus_id"  autocomplete="off" readonly="">
                                </div>

                            </div>
                        </div>

                    <?php } ?>
                    <hr>
                    <table id="myTable" class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10%;">Name<br>(Tên)</th>
                                <th class="text-center" style="width: 20%;">Feature<br>(Đặc tính)</th>
                                <th class="text-center">បណ្ដោយ <br> Dài</th>
                                <th class="text-center">ទទឹង <br> Rộng</th>
                                <th class="text-center">កម្រាស់ <br> PRICE</th>
                                <th class="text-center">សន្លឹក - M2 <br> Số Tấm</th>
                                <th class="text-center">តម្លៃ  <br> PCS - M2</th>
                                <th class="text-center">សំគ្គាល់  <br> Others</th>
                                <th class="text-center"> <i class="fa fa-cog fa-spin"></i> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="my_form_base" style="background: red; display: none;">
                                <td>
                                    <input type="text" name="txt_name[]" class="form-control">
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
                                    <input type="text"  step="1" name="txt_length[]" class="form-control" value="1" autocomplete="off" >
                                </td>
                                <td>
                                    <input type="number"  step="60" name="txt_width[]" class="form-control" value="60">
                                </td>
                                <td>
                                    <input type="number" step="1.8" name="txt_thickness[]" class="form-control"value="1.80">
                                </td>
                                <td>
                                    <input type="number" value="1" step="1" name="txt_pcs_m2[]" class="form-control">
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="0" name="txt_price[]">
                                </td>
                                <td>
                                    <input type="text" name="txt_note1[]" class="form-control" >
                                </td>
                                <td class="text-center">
                                    <button class="btnDelete btn btn-info"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <?php if(!@$_GET['status']=='add_more'){ ?>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group ">
                                    <label>Note : </label>
                                    <textarea type="text" class="form-control" name="txt_note" style="height: 100px;" autocomplete="off"></textarea>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group ">
                                    <label>Date Start : </label>
                                    <input type="text" class="form-control" name="txt_date_s" data-provide="datepicker" data-date-format="yyyy-mm-dd"  autocomplete="off" value="<?= date('Y-m-d') ?>" required="required">
                                </div>
                                <div class="form-group ">
                                    <label>Date End : </label>
                                    <input type="text" class="form-control" name="txt_date_e" data-provide="datepicker" data-date-format="yyyy-mm-dd"  autocomplete="off" value="<?= date('Y-m-d') ?>" required="required">
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <br>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_submit" class="btn yellow"><i class="fa fa-print fa-fw"></i> Save & Print</button>
                                <button type="submit" name="btn_submit" class="btn green"><i class="fa fa-save fa-fw"></i>Save & New</button>
                                <div id="add_more" class="btn btn-default yellow btn-md" title="Click on this button to add more record !">[<i class="fa fa-plus"></i>]</div>
                                <a href="index.php?action=2" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                            </div>
                        </div>
                    </div>
                    </form><br>    
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                    <div class="form-group">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#activity" data-toggle="tab">Name</a>
                            </li>
                            <li role="presentation">
                                <a href="#timeline" data-toggle="tab">Transactions</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">
                                SUMMARY
                                <hr><br><br><br><br>
                                RECENT TRANSACTIONS
                                <hr><br><br><br><br>
                                NOTES
                                <hr><br><br><br><br>
                            </div>
                            <div class="tab-pane" id="timeline">
                            </div>
                        </div>    
                    </div>                       
                </div>
                
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../../assets/global/plugins/jquery.min.js"></script>
<script>
    //Refresh Cmbobox
    $('div#refresh_cbo_counter').click(function(){
        $.ajax({url: "ajax_get_content_select.php?d=cbo_counter", success: function(result){
            if($('select[name="cbo_counter"]').html().trim() != result.trim()){
                $('select[name="cbo_counter"]').html(result);
                myAlertInfo("Your refresh item successfully !");
            }
        }});
    });

    $(document).ready(function(){

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
                return false;
            }
            $(this).parents('tr').remove();
            totalAmount();
            myAlertInfo("Your deleted record !");
        });
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

    function set_iframe_counter(){
        document.getElementById('result_modal').src = '../inv_counter_list/index.php?view=iframe';
    }
    $zerol=0;

    $(document).ready(function(){
        $('select[name=txt_estimate]').change(function () {
            var code_vouch=$(this).find('option:selected').attr('data_code');
            var v_date=my_getDate($('input[name=txt_date]').val());
            var vou_id=$(this).val();
            var myObject={
                te_id:null,
                vou_code:code_vouch,
                v_date:v_date,
                vou_id:vou_id
            };
            
            var myString =JSON.stringify(myObject);
            $.ajax({type:'POST',url:"ajx_get_qt.php",data:'data='+myString,success: function(result){
                var myObj=JSON.parse(result);
                // alert(result);
                $('input[name=txt_number]').val(myObj['vou_no']);
                document.getElementById("frpc_code").innerHTML = myObj['vou_no'];
            }});
        });
        $('input[name=txt_date]').datepicker().on('changeDate', function (ev) {
            $(this).change();
            var v_date=my_getDate(new Date($(this).val()));
            var vou_id=$('select[name=txt_estimate]').val();
            var vou_id=$('select[name=txt_estimate]').val();
            code_vouch=$('select[name=txt_estimate]').find('option:selected').attr('data_code');
            var myObject={
                te_id:null,
                vou_code:code_vouch,
                v_date:v_date,
                vou_id:vou_id
            };
            var myString =JSON.stringify(myObject);
            $.ajax({url:"ajx_get_qt.php",type:'POST',data:'data='+myString,success: function(result){
                var myObj=JSON.parse(result);
                $('input[name=txt_number]').val(myObj['vou_no']);
                document.getElementById("frpc_code").innerHTML = myObj['vou_no'];
            }});
        });
    });
  
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