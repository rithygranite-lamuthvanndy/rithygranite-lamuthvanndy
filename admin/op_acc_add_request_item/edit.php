<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        
        $v_id = @$_POST['txt_id'];
        $v_number = @$_POST['cbo_number'];
        $v_unit = @$_POST['cbo_unit'];
        $v_item_name = @$_POST['txt_item_name'];
        $v_qty = @$_POST['txt_qty'];
        $v_price= @$_POST['txt_price'];
        $v_amo = @$_POST['txt_amount'];
        
       
        $query_update = "UPDATE `tbl_acc_request_item` 
            SET 
                rei_number='$v_number',
                rei_item_name='$v_item_name',
                rei_qty='$v_qty',
                rei_unit='$v_unit',
                rei_price='$v_price',
                rei_amount='$v_amo'
            WHERE `rei_id`='$v_id'";
                            
       
        if($connect->query($query_update)){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data update ...
            </div>'; 
        }else{
            $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> Query error ...
            </div>';   
        }
    }


// get old data 
    $edit_id = @$_GET['edit_id'];
    $sent_id = @$_GET['sent_id'];
    $old_data = $connect->query("SELECT * FROM tbl_acc_request_item WHERE rei_id='$edit_id'");
    $row_old_data = mysqli_fetch_object($old_data);


 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Edit Record</h2>
        </div>
    </div>
    <br>
    <br>

    <div class="portlet-title">
        <div class="caption font-dark">
            <a href="index.php?sent_id=<?= $sent_id ?>" id="sample_editable_1_new" class="btn red"> 
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
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->rei_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                                <label>Number :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <select class="form-control myselect2" name="cbo_number">
                                    <option value="">=== Please choose and select ===</option>
                                    <?php 
                                        $v_select = $connect->query("SELECT * FROM tbl_acc_request_form ORDER BY req_number ASC");
                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                            if($row_data->req_id == @$row_old_data->rei_number){
                                                echo '<option SELECTED value="'.$row_data->req_id.'">'.$row_data->req_number.'</option>';
                                                
                                            }else{
                                                echo '<option value="'.$row_data->req_id.'">'.$row_data->req_number.'</option>';

                                            }
                                        }
                                     ?>
                                </select>
                                <br>
                                <br>

                                <label>Item Name :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <select class="form-control myselect2" name="txt_item_name">
                                    <option value="">=== Please choose and select ===</option>
                                    <?php 
                                        $v_select = $connect->query("SELECT * FROM tbl_acc_item ORDER BY accit_id DESC");
                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                            if($row_data->accit_id == @$row_old_data->rei_item_name){
                                                echo '<option SELECTED value="'.$row_data->accit_id.'">'.$row_data->accit_name.'</option>';
                                                
                                            }else{
                                                echo '<option value="'.$row_data->accit_id.'">'.$row_data->accit_name.'</option>';

                                            }
                                        }
                                     ?>
                                </select>
                                <br>
                                <br>
                                
                                <label>Unit :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <select class="form-control" name="cbo_unit">
                                    <option value="">=== Please choose and select ===</option>
                                    <?php 
                                        $v_select = $connect->query("SELECT * FROM tbl_acc_unit_list ORDER BY uni_id ASC");
                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                            if($row_data->uni_id == @$row_old_data->rei_unit){
                                                echo '<option SELECTED value="'.$row_data->uni_id.'">'.$row_data->uni_name.'</option>';
                                                
                                            }else{
                                                echo '<option value="'.$row_data->uni_id.'">'.$row_data->uni_name.'</option>';

                                            }
                                        }
                                     ?>
                                </select>
                                <br>

                                <label>Qty :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <input type="text" value="<?= $row_old_data->rei_qty ?>" name="txt_qty" class="form-control">
                                <br>

                                <label>Price :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <input type="text" value="<?= number_format($row_old_data->rei_price,2) ?>" name="txt_price" class="form-control">
                                <br>
                                <label>Amount :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <input type="text" readonly="" value="<?= number_format($row_old_data->rei_qty*$row_old_data->rei_price,2) ?>"  name="txt_amount" class="form-control">
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_submit" class="btn green"><i class="fa fa-save fa-fw"></i>Save</button>
                                <a href="index.php?sent_id=<?= $row_old_data->rei_number ?>" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
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
    $("input[name=txt_qty],input[name=txt_price]").keyup(function(){
        $qty=$("input[name=txt_qty]").val();
        $price=$("input[name=txt_price]").val();;
        $amo=($qty*$price);
        $("input[name=txt_amount]").val($amo.toFixed(2));
    });
</script>


<?php include_once '../layout/footer.php' ?>
