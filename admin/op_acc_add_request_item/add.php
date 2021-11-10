<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        $v_status = @$_POST['txt_status'];
        $v_id = @$_POST['txt_id'];
        $v_unit = @$_POST['cbo_unit'];
        $v_item_name = @$_POST['txt_item_name'];
        $v_qty = @$_POST['txt_qty'];
        $v_price= @$_POST['txt_price'];
        
        foreach ($v_item_name as $key => $value) {
            if($value){
                $new_item=$v_item_name[$key];
                $new_unit=$v_unit[$key];
                $new_qty=$v_qty[$key];
                $new_price=$v_price[$key];
                $query_add = "INSERT INTO tbl_acc_request_item (
                        rei_number,
                        rei_item_name,
                        rei_qty,
                        rei_unit,
                        rei_price
                        ) 
                    VALUES
                        (
                        '$v_id',
                        '$new_item',
                        '$new_qty',
                        '$new_unit',
                        '$new_price'
                        )";

                $flag=$connect->query($query_add);
            }
        }        
        if($v_status=='back')
            header('Location: ../op_acc_add_request_form_invoice/edit.php?edit_id='.$v_id.'');

        if($flag){
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
    if(@$_GET['sent_id']){
        $id=@$_GET['sent_id'];
    }
 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Create Record</h2>
        </div>
    </div>
    
    <br>
    <br>

    <div class="portlet-title">
        <div class="caption font-dark">
            <a href="index.php?sent_id=<?= $id ?>" id="sample_editable_1_new" class="btn red"> 
                <i class="fa fa-arrow-left"></i>
                Back
            </a>
        </div>
    </div>
    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Input Information</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" value="<?= $id; ?>" name="txt_id">
                    <input type="hidden" value="<?= @$_GET['status']; ?>" name="txt_status">
                    <table id="myTable" class="table table-bordered">
                    <thead>
                       <tr>
                           <th>
                               <label>Item Name :
                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#item_name'><i class="fa fa-plus"></i></a>
                                    <span class="required" aria-required="true"></span>
                                </label>
                           </th>
                           <th>
                               <label>Unit :
                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#modal_unit_name'><i class="fa fa-plus"></i></a>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                           </th>
                           <th>
                               <label>Qty :
                                    <span class="required" aria-required="true"></span>
                                </label>
                           </th>
                           <th>
                               <label>Price :
                                    <span class="required" aria-required="true"></span>
                                </label>
                           </th>
                           <th>
                               <label>Amount :
                                    <span class="required" aria-required="true"></span>
                                </label>
                           </th>
                       </tr>
                    </thead>
                   <tbody>
                       <tr class="my_form_base" style="background: red; display: none;">
                           <td>
                                <input type="text" onkeyup="get_qty(this)" class="form-control" autocomplete="off" name="txt_item_name[]">
                               <!--  <select class="form-control" id="id_item_name" name="txt_item_name[]">
                                    <option value="">==Please Choose and Select==</option>
                                    <?php 
                                        $v_select = $connect->query("SELECT * FROM tbl_acc_item ORDER BY accit_id DESC");
                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                            echo '<option value="'.$row_data->accit_id.'">'.$row_data->accit_name.'</option>';
                                        }
                                     ?>
                                </select> -->
                           </td>
                           <td>
                                <select class="form-control" id="unit_name" name="cbo_unit[]">
                                    <option value="">==Please Choose and Select==</option>
                                    <?php 
                                        $v_select = $connect->query("SELECT * FROM tbl_acc_unit_list ORDER BY uni_id ASC");
                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                            echo '<option value="'.$row_data->uni_id.'">'.$row_data->uni_name.'</option>';
                                        }
                                     ?>
                                </select>
                           </td>
                           <td>
                                <input type="text" onkeyup="get_qty(this)" class="form-control" autocomplete="off" name="txt_qty[]" value="0">
                           </td>
                           <td>
                                <input type="text" onkeyup="get_price(this)" class="form-control" autocomplete="off" name="txt_price[]" value="0">
                           </td>
                           <td>
                                <input type="text" class="form-control" value="0" autocomplete="off" readonly="" name="txt_amount[]">
                           </td>
                       </tr>
                   </tbody>
               </table>
                <div class="form-group text-center">
                    <div id="add_more" class="btn btn-default yellow btn-md"><i class="fa fa-plus"></i>Add More</div>
                </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_submit" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
                                <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>


<script src="../../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    var index_row = 1;
    $('#add_more').click(function(){ 
        $('#myTable').append('<tr data-row-id="'+(++index_row)+'">'+$('.my_form_base').html()+'</tr>');
        $('tr[data-row-id='+index_row+']').find('select').select2();
    });

    setTimeout(function(){
        $('#add_more').click();      
    },2000);

    function get_price(obj){
        var price=$(obj).val();
        var qty=$(obj).parents('tr').find('td:nth-child(3) > input').val();
        var amo=price*qty;
        $(obj).parents('tr').find('td:nth-child(5) > input').val(amo.toFixed(2)); 
    }

    function get_qty(obj){
        var qty=$(obj).val();
        var price=$(obj).parents('tr').find('td:nth-child(4) > input').val();
        var amo=price*qty;
        $(obj).parents('tr').find('td:nth-child(5) > input').val(amo.toFixed(2)); 
    }
</script>
<script type="text/javascript">
    function my_array(p){
        var v_arr=[];
        for(i=0;i<p.length;i++){
            v_arr.push(p[i].innerHTML);
        }
    }

    $('select#id_item_name').mouseover(function(){
        $.ajax({url: "ajx_get_content_select.php?d=id_item_name", success: function(result){
            if($('select#id_item_name').html().trim() != result.trim()){
                $('select#id_item_name').html(result);
            }
        }});
    });

    $('select#id_unit_name').click(function(){
        $.ajax({url: "ajx_get_content_select.php?d=id_unit_name", success: function(result){
            if($('select#id_unit_name').html().trim() != result.trim()){
                $('select#id_unit_name').html(result);
            }
        }});
    });
</script>
<?php include_once '../layout/footer.php' ?>

<div class="modal fade" id="modal_item_name">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_item_name.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="modal_unit_name">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_unit.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>