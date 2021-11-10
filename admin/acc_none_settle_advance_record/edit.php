<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
    if(isset($_GET['edit_id'])){
        $v_id=$_GET['edit_id'];
        $sql=$connect->query("SELECT A.*
            FROM tbl_acc_none_settle_advance AS A
            WHERE A.id='$v_id'");
        $row_main=mysqli_fetch_object($sql);
    }
 ?>

<?php 
    if(@$_GET['status']=='true'){
        echo '<script>myAlertSuccess("Plese wait continue to update in add transaction in next 5 seconds")</script>';
        $sql=$connect->query("SELECT id FROM tbl_acc_add_tran_amount WHERE ref_id='$v_id' AND status_type='4'");
        $row=mysqli_fetch_object($sql);
        $continue_update_id=@$row->id;
        // echo $continue_update_id;
        if($continue_update_id)
            header( "refresh:5; url=../acc_add_tra_amount/edit.php?edit_id=".$continue_update_id.'&status=con_update_settle_advance'); 
    }
    if(isset($_POST['btn_save'])){
        //Add Main Item
        $v_main_id = @$connect->real_escape_string($_POST['txt_main_id']);
        $v_rec_from_id = @$connect->real_escape_string($_POST['cbo_rec_from']);
        $v_pos_id = @$connect->real_escape_string($_POST['cbo_pos']);
        $v_date_record = @$connect->real_escape_string($_POST['txt_date_record']);
        $v_entry_no = @$connect->real_escape_string($_POST['txt_entry_no']);

        $query_update = "UPDATE tbl_acc_none_settle_advance SET 
        rec_from_id='$v_rec_from_id',
        pos_id='$v_pos_id',
        date_record='$v_date_record',
        entry_no='$v_entry_no', 
        user_id='$user_id'
        WHERE id='$v_main_id'";
        if($connect->query($query_update))
            $flag_add_1=1;

        $v_status= @$_POST['txt_status'];
        $v_code= @$_POST['txt_code'];
        $v_description= @$_POST['cbo_description'];
        $v_tran_note= @$_POST['txt_tran_note'];
        $v_doc_ref= @$_POST['txt_doc_ref'];
        $v_qty= @$_POST['txt_qty'];
        $v_unit= @$_POST['txt_unit'];
        $v_price= @$_POST['txt_price'];
        $v_out= @$_POST['txt_settle_out'];
        $v_in= @$_POST['txt_settle_in'];

        foreach ($v_description as $key => $value) {
            if($value!=0&&$v_status[$key]==0){
                $new_code=$v_code[$key];
                $new_description=$v_description[$key];
                $new_tran_note=$v_tran_note[$key];
                $new_doc_ref=$v_doc_ref[$key];
                $new_qty=$v_qty[$key];
                $new_unit=$v_unit[$key];
                $new_price=$v_price[$key];
                $new_out=$v_out[$key];
                $new_in=$v_in[$key];
                 //Add Sub Item
                $query_add_2="INSERT INTO tbl_acc_none_settle_advance_detail(
                    main_id, 
                    code_no, 
                    description_id, 
                    tran_note, 
                    doc_ref, 
                    quantity, 
                    unit, 
                    price,  
                    settle_in, 
                    settle_out
                    )
                    VALUES
                    (
                    '$v_main_id',
                    '$new_code',
                    '$new_description',
                    '$new_tran_note',
                    '$new_doc_ref',
                    '$new_qty',
                    '$new_unit',
                    '$new_price',
                    '$new_in',
                    '$new_out'
                    )";
                $flag_add_2=$connect->query($query_add_2);
            }
            else if($value!=0&&$v_status[$key]!=0){
                $new_code=$v_code[$key];
                $new_description=$v_description[$key];
                $new_tran_note=$v_tran_note[$key];
                $new_doc_ref=$v_doc_ref[$key];
                $new_qty=$v_qty[$key];
                $new_unit=$v_unit[$key];
                $new_price=$v_price[$key];
                $new_out=$v_out[$key];
                $new_in=$v_in[$key];
                $query_update="UPDATE tbl_acc_none_settle_advance_detail SET 
                    code_no='$new_code', 
                    description_id='$new_description', 
                    tran_note='$new_tran_note', 
                    doc_ref='$new_doc_ref', 
                    quantity='$new_qty', 
                    unit='$new_unit', 
                    price='$new_price', 
                    settle_in='$new_in', 
                    settle_out='$new_out'
                    WHERE id='$v_status[$key]'";
                $flag_add_2=$connect->query($query_update);
            }
        }
        if($flag_add_1==1&&$flag_add_2){
            header('location: edit.php?status=true&edit_id='.$v_main_id);
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
                    <input type="hidden" name="txt_main_id" value="<?= $row_main->id ?>">
                    <div class="form-body">
                       <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="float: left;">
                                <div class="form-group">
                                    <label>Name *: </label>
                                    <select name="cbo_rec_from" id="inputCbo_rec_from" class="form-control myselect2" required="required">
                                        <option value="">=== Select and Choose ===</option>
                                        <?php 
                                            $v_select=$connect->query("SELECT name,id FROM tbl_acc_other_rec_from_list ORDER BY name");
                                            while ($row_select=mysqli_fetch_object($v_select)) {
                                                if($row_main->rec_from_id==$row_select->id)
                                                    echo '<option selected value="'.$row_select->id.'">'.$row_select->name.'</option>';
                                                else
                                                    echo '<option value="'.$row_select->id.'">'.$row_select->name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Position *: </label>
                                    <select name="cbo_pos" id="inputCbo_rec_from" class="form-control myselect2" required="required">
                                        <option value="">=== Select and Choose ===</option>
                                        <?php 
                                            $v_select=$connect->query("SELECT po_id,po_name FROM tbl_acc_position ORDER BY po_name");
                                            while ($row_select=mysqli_fetch_object($v_select)) {
                                                if($row_main->pos_id==$row_select->po_id)
                                                    echo '<option selected value="'.$row_select->po_id.'">'.$row_select->po_name.'</option>';
                                                else
                                                    echo '<option value="'.$row_select->po_id.'">'.$row_select->po_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Address : </label>
                                    <input type="text" name="txt_rec_address" id="inputTxt_address" class="form-control" placeholder="Auto fill ....." readonly>
                                </div>
                                <div class="form-group">
                                    <label>Phone No : </label>
                                    <input type="text" name="txt_rec_phone" id="inputTxt_address" class="form-control" placeholder="Auto fill ....." readonly>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="float: right;">
                                <div class="form-group">
                                    <label>Date : </label>
                                    <input type="text" name="txt_date_record" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control date" required value="<?= $row_main->date_record ?>">
                                </div>
                                <div class="form-group">
                                    <label for="input" class="control-label">Entry No*:</label>
                                    <input type="text" value="<?= $row_main->entry_no ?>" name="txt_entry_no" class="form-control" required="" placeholder="Entry No .....">
                                </div>
                            </div>
                            <!-- Detail -->
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <br>    
                                <table id="myTable" class="table table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Code</th>
                                            <th class="text-center" style="width: 20%;">Description
                                                <button type="button" class="btn btn-primary btn-xs" id="add_des_name"><i class="fa fa-plus"></i></button>
                                                <button type="button" class="btn btn-info btn-xs" id="re_des_name"><i class="fa fa-refresh"></i></button>
                                            </th>
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
                                        <?php 
                                            $sql=$connect->query("SELECT * FROM tbl_acc_none_settle_advance_detail WHERE main_id='$row_main->id'");
                                            while ($row_detail=mysqli_fetch_object($sql)) {?>
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="txt_status[]" value="<?= $row_detail->id ?>">
                                                        <input type="text" name="txt_code[]" class="form-control" value="<?= $row_detail->code_no ?>">
                                                    </td>
                                                    <td>
                                                        <select class="form-control myselect2" name="cbo_description[]">
                                                            <option value="">=== Please Choose and Select ===</option>
                                                            <?php 
                                                                $v_select = $connect->query("SELECT des_id,des_name FROM tbl_acc_decription ORDER BY des_name DESC");
                                                                while ($row_data = mysqli_fetch_object($v_select)) {
                                                                    if($row_detail->description_id==$row_data->des_id)
                                                                        echo '<option selected value="'.$row_data->des_id.'">'.$row_data->des_name.'</option>';
                                                                    else
                                                                        echo '<option value="'.$row_data->des_id.'">'.$row_data->des_name.'</option>';
                                                                }
                                                             ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <textarea name="txt_tran_note[]" id="inputTxt_tran_note" class="form-control" rows="1"><?= $row_detail->tran_note ?></textarea>
                                                    </td>
                                                    <td>
                                                        <textarea name="txt_doc_ref[]" id="inputTxt_tran_note" class="form-control" rows="1"><?= $row_detail->doc_ref ?></textarea>
                                                    </td>
                                                    <td>
                                                        <input onkeyup="cal_Out(this)" type="number" min="0" step="1" name="txt_qty[]" class="form-control" value="<?= $row_detail->quantity ?>">
                                                    </td>  
                                                    <td>
                                                        <input type="text"  name="txt_unit[]" class="form-control" value="<?= $row_detail->unit ?>">
                                                    </td>  
                                                    <td>
                                                        <input onkeyup="cal_Out(this)" type="number" min="0" step="0.01"  name="txt_price[]" class="form-control" value="<?= $row_detail->price ?>">
                                                    </td>    
                                                    <td>
                                                        <input type="number" step="0.01" min="0" name="txt_settle_in[]" onkeyup="totalIn()" onchange="totalIn()" class="form-control" value="<?= $row_detail->settle_in ?>">
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.01" min="0" name="txt_settle_out[]" onkeyup="totalOut()" onchange="totalOut()" class="form-control" value="<?= $row_detail->settle_out ?>">
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btnDelete btn btn-info"><i class="fa fa-trash"></i></div>
                                                    </td>
                                                </tr>
                                        <?php } ?>    

                                        <tr class="my_form_base" style="background: red; display: none;">
                                            <td>
                                                <input type="hidden" name="txt_status[]" value="0">
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
                                                <input onkeyup="cal_Out(this)" type="number" min="0" step="1" name="txt_qty[]" class="form-control" value="0">
                                            </td>  
                                            <td>
                                                <input type="text"  name="txt_unit[]" class="form-control">
                                            </td>  
                                            <td>
                                                <input onkeyup="cal_Out(this)" type="number" min="0" step="0.01"  name="txt_price[]" class="form-control" value="0.00">
                                            </td>    
                                            <td>
                                                <input type="number" step="0.01" min="0" name="txt_settle_in[]" onkeyup="totalIn()" onchange="totalIn()" class="form-control" value="0.00">
                                            </td>
                                            <td>
                                                <input type="number" step="0.01" min="0" name="txt_settle_out[]" onkeyup="totalOut()" onchange="totalOut()" class="form-control" value="0.00">
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
    $(document).ready(function () {
        $('select[name=cbo_rec_from]').change(function () {
            let v_rec_id=$(this).val();
            $.ajax({url: 'ajx_get_title_info.php?p_rec_id='+v_rec_id,success:function (result) {
                var myObj=JSON.parse(result);
                $('input[name=txt_rec_phone]').val(myObj['rec_phone']);
                $('input[name=txt_rec_address]').val(myObj['rec_address']);
            }});
        });
    });
    setTimeout(function(){
        $('select[name=cbo_rec_from]').change();     
    },1000);
    // Load Item

    totalIn();
    totalOut();
    //End Load Item

    var index_row = 1;
    $('#add_more').click(function(){ 
        $('#myTable').append('<tr data-row-id="'+(++index_row)+'">'+$('.my_form_base').html()+'</tr>');
        $('tr[data-row-id='+index_row+']').find('select').select2();
    });
    //Delete Row By Row
    $("tbody").on('click', '.btnDelete', function () {
        var rowCount = $('tbody>tr').length;
        if(rowCount<=2){
            alert("You can not delete this record.");
            return;
        }
        var v_id=$(this).parents('tbody >tr').find('td:first-child >input').val();
        $.ajax({url: 'ajax_delete.php?del_id='+v_id,success:function (result) {
        }});
        $(this).parents('tr').remove();
        totalIn();
        totalOut();
    });
    function cal_Out (args) {
        var v_qty=$(args).parents('tbody >tr').find('td:nth-last-child(6) >input').val();
        var v_price=$(args).parents('tbody >tr').find('td:nth-last-child(4) >input').val();
        var v_credit=v_qty*v_price;
        var v_price=$(args).parents('tbody >tr').find('td:nth-last-child(2) >input').val(v_credit.toFixed(2));
        totalOut();
    }
    function totalIn () {
        let v_total_amo=0;
        $('td:nth-last-child(3) >input').each(function () {
            v_total_amo+=parseFloat($(this).val());
        });
        $('tfoot tr:first-child th:nth-last-child(3) >input').val(v_total_amo.toFixed(2));
        var total_debit=v_total_amo;
        var total_credit=$('tfoot tr:first-child th:nth-last-child(2) >input').val();
        $('tfoot tr:last-child th:nth-last-child(2) >input').val((total_debit-total_credit).toFixed(2));
    }
    function totalOut () {
        let v_total_amo=0;
        $('td:nth-last-child(2) >input').each(function () {
            v_total_amo+=parseFloat($(this).val());
        });
        $('tfoot tr:first-child th:nth-last-child(2) >input').val(v_total_amo.toFixed(2));
        var total_credit=v_total_amo;
        var total_debit=$('tfoot tr:first-child th:nth-last-child(3) >input').val();
        $('tfoot tr:last-child th:nth-last-child(2) >input').val((total_debit-total_credit).toFixed(2));
    }
    $('#add_des_name').click(function () {
        $('#add_item').modal('show');
        $('iframe').attr('src','iframe_add_item.php?p_status=des_name');
    });
    $('#re_des_name').click(function () {
        $.ajax({url: 'ajx_get_content_select.php?status=des_name',success:function (result) {
            if($('select[name^="cbo_description"]').html().trim()!=result.trim())
                $('select[name^="cbo_description"]').html(result);
        }});
    });
</script>
<?php include_once '../layout/footer.php' ?>
<div class="modal fade" id="add_item">
    <div class="modal-dialog" style="border: 1px solid darkred; width: 70%;">
        <iframe frameborder="0" style="height: 450px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>