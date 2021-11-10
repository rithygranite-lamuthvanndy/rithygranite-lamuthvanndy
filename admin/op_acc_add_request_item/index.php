<?php 
    $menu_active =13;
    $left_active =33;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once 'permission.php';
    include_once '../layout/header.php';
?>

<?php 
     $get_data=$connect->query("SELECT * 
                            FROM tbl_acc_request_item AS A 
                            LEFT JOIN tbl_acc_request_form AS B ON A.rei_number=B.req_id
                            LEFT JOIN  tbl_acc_unit_list AS C ON A.rei_unit=C.uni_id");

    if(@$_GET['sent_id']){
        $id=$_GET['sent_id'];
        $get_data=$connect->query("SELECT * 
                            FROM tbl_acc_request_item AS A 
                            LEFT JOIN tbl_acc_request_form AS B ON A.rei_number=B.req_id
                            LEFT JOIN  tbl_acc_unit_list AS C ON A.rei_unit=C.uni_id 
                            LEFT JOIN tbl_acc_item AS D ON A.rei_item_name=D.accit_id
                            WHERE A.rei_number='$id'
                            ");
    }

 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <input type="text" name="txt_id" value="<?= $id ?>">
            <h2><i class="fa fa-fw fa-map-marker"></i> Add Request Item</h2>
        </div>
    </div>
    <?= button_add(); ?>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Number</th>
                        <th>Item Name</th>
                        <th>Unit </th>
                        <th>Qty</th>
                        <th>Price </th>
                        <th>Amount </th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $total_qty=0;
                        $total_price=0;
                        $total_amo=0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->req_number.'</td>';
                                echo '<td>'.$row->accit_name.'</td>';
                                echo '<td>'.$row->uni_name.'</td>';
                                echo '<td>'.number_format($row->rei_qty,0.3).'</td>';
                                echo '<td>'.number_format($row->rei_price,2).'</td>';
                                echo '<td>'.number_format($row->rei_qty*$row->rei_price,2).'</td>';
                                echo '<td class="text-center">';
                                echo button_edit($row->rei_id,$row->rei_number);
                                echo button_delete($row->rei_id,$row->rei_number);

                                echo '</td>';
                            echo '</tr>';
                            $total_qty+=$row->rei_qty;
                            $total_price+=$row->rei_price;
                            $total_amo=$total_qty*$total_price;
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total :</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th><?= number_format($total_qty,0.3) ?></th>
                        <th><?= number_format($total_price,2) ?></th>
                        <th><?= number_format($total_amo,2) ?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript" src="../../assets/global/plugins/jquery.min.js"></script>
<script type="text/javascript">
    $('#addnew').click(function(){
        v_id=$('input[name=txt_id]').val();
        $('input[name=txt_m_id]').val(v_id);
    });

    var index_row = 1;  
    $('#add_more').click(function(){ 
        $('#myTable').append('<tr data-row-id="'+(++index_row)+'">'+$('.my_form_base').html()+'</tr>');
        $('tr[data-row-id='+index_row+']').find('select').select2();
    });

    setTimeout(function(){
        $('#add_more').click();      
    },2000);
</script>

<?php include_once '../layout/footer.php' ?>
<div class="modal fade" id="modal-id">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add Reuqest Item</h4>
            </div>
            <div class="modal-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <input type="text" name="txt_m_id">
                    <table id="myTable" class="table table-bordered">
                        <thead>
                           <tr>
                               <th>
                                   <label>Item Name :
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>