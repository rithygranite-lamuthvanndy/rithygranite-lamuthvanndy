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
    if(isset($_POST['btn_submit'])){
        $v_date_record = @$_POST['txt_date_record'];
        $v_title = @$_POST['txt_title'];
        $v_sub = @$_POST['txt_sub'];
        $v_desctiption = @$_POST['txt_description'];
        $v_leader = @$_POST['txt_leader'];
        $v_gorup = @$_POST['txt_group'];
        $v_date_start = @$_POST['txt_date_start'];
        $v_date_end = @$_POST['txt_date_end'];
        $v_amount = @$_POST['txt_amount'];
        $v_note = @$_POST['txt_note'];
        $v_user_id = @$_SESSION['user']->user_id;
        

        $query_add = "INSERT INTO tbl_pj_project_initiation (
                pini_date_record,
                pini_project_title,
                pini_project_sub,
                pini_description,
                pini_leader,
                pini_group,
                pini_date_start,
                pini_date_finish,
                pini_amount,
                pini_note,
                user_id                
                ) 
            VALUES(
                '$v_date_record',
                '$v_title',
                '$v_sub',
                '$v_desctiption',
                '$v_leader',
                '$v_gorup',
                '$v_date_start',
                '$v_date_end',
                '$v_amount',
                '$v_note',
                '$v_user_id'
                )";
        if($connect->query($query_add)){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data inserted ...
            </div>'; 
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
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <?= @$sms; ?>
            <h2>
                <i class="fa fa-plus-circle fa-fw"></i>Create  Record
            </h2>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">            
            <h2 class="text-right form-group">
                #<p style="font-family: 'Times New Roman'; font-size: 16px;" id="pono_code"></p></p>PURCHASE ORDER 
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
                    <?php if(!@$_GET['status']=='add_more'){ ?>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group ">
                                    <label>Customer Name : </label>
                                    <select name="txt_cus_name" id="input" class="form-control" required="">
                                        <option value="">=== Select Project Title ===</option>
                                        <?php 
                                            $sql=$connect->query("SELECT * FROM tbl_cus_customer_info AS A 
                                                    LEFT JOIN tbl_cus_type AS B ON B.cusct_id=A.cussi_type ORDER BY cussi_id");
                                            while ($row=mysqli_fetch_object($sql)) {
                                                echo '<option value="'.$row->cussi_id.'">'.$row->cus_code.' || '.$row->cussi_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label>Address : </label>
                                    <input type="text" class="form-control" name="txt_address"  autocomplete="off" readonly="" id="txt_addr">
                                </div>
                                <div class="form-group ">
                                    <label>Phone : </label>
                                    <input type="text" class="form-control" name="txt_phone"  autocomplete="off" readonly="" id="txt_phone">
                                </div>
                                <div class="form-group ">
                                    <label>Email : </label>
                                    <input type="text" class="form-control" name="txt_email"  autocomplete="off" readonly="" id="txt_email">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group " placeholder="date end">
                                    <label>PO No :  </label>
                                    <input type="text" onkeyup="changepono()" class="form-control" name="txt_amount"  id="txt_fr_amount" value="calculating">

                                </div>
                                <div class="form-group ">
                                    <label>Date Record : </label>
                                    <input type="text" class="form-control" name="txt_date_record" data-provide="datepicker" data-date-format="yyyy-mm-dd"  autocomplete="off" value="<?= date('Y-m-d') ?>" required="required">
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
                                <th class="text-center" style="width: 10%;">Feature<br>(Đặc tính)</th>
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
                                    <select class="form-control" name="cbo_color[]">
                                        <option value="">ANGKOR BLACK</option>
                                        <?php 
                                            $v_select_sql="SELECT * FROM tbl_inv_color_list ORDER BY name";
                                            $v_select = $connect->query($v_select_sql);
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_data->id.'">'.$row_data->name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" name="cbo_grade_type[]">
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
                                    <input type="number" onchange="changeLenght(this)" onkeyup="changeLenght(this)" name="txt_lenght[]" class="form-control"value="" autocomplete="off" >
                                </td>
                                <td>
                                    <input type="number" onchange="changeWidth(this)" onkeyup="changeWidth(this)" name="txt_width[]" class="form-control"value="60">
                                </td>
                                <td>
                                    <input type="number" name="txt_height[]" class="form-control"value="1.80">
                                </td>
                                <td>
                                    <input type="number" name="txt_sheet[]" onchange="changeHeight(this)" onkeyup="changeHeight(this)" class="form-control">
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
                                <th class="text-right">សរុប <br>​ TOTAL M <sup>2</sup></th>
                                <th ><input type="text" name="txt_total_slep" readonly="" id="inputTxt_total_amo1" class="form-control" value="0" required="required" pattern="" title=""></th>
                                <th ><input type="text" name="txt_total_amo" readonly="" id="inputTxt_total_amo" class="form-control" value="0" required="required" pattern="" title=""></th>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                            </tr>
                        </tfoot>
                    </table>
                    <br>
                    <?php if(!@$_GET['status']=='add_more'){ ?>
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
        document.getElementById("pono_code").innerHTML = myObj['t_amo'];
    }
    function totalslep () {
        var t_amo1=0;
        $('input[name^="txt_sheet"]').each(function () {
            t_amo1+= parseFloat($(this).val());
        });
        $('tfoot >tr:first-child').find('th:nth-last-child(4) >input[name=txt_total_slep]').val(t_amo1.toFixed(3));
    }
    function changepono () {
        var t_amo1=0;
        $('input[name^="txt_mater_kare"]').each(function () {
            t_amo1+= parseFloat($(this).val());
        });
        $('tfoot >tr:first-child').find('th:nth-last-child(4) >input[name=txt_total_slep]').val(t_amo1.toFixed(3));
        document.getElementById("pono_code").innerHTML = myObj['t_amo1'];
    }
    function set_iframe_counter(){
        document.getElementById('result_modal').src = '../inv_counter_list/index.php?view=iframe';
    }
    $zerol=0;
    document.getElementById("pono_code").innerHTML = formatter.format($zerol);
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