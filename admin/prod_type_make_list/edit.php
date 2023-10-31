<?php 
    $menu_active =11;
    $left_menu =4;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    if(@($_GET['view']=='iframe')){
        include_once '../layout/header_frame.php';
    }
    else{
        include_once '../layout/header.php';
    }
?>


<?php 
    if(isset($_POST['btn_submit'])){
        $v_id = @$_POST['txt_id'];
        $v_code = @$_POST['txt_code'];
        $v_name = @$_POST['txt_name'];
        $v_name_en = @$_POST['txt_name_en'];
        $v_name_kh = @$_POST['txt_name_kh'];
        $v_description = @$_POST['txt_description'];
        $v_account = @$_POST['txt_account'];
        $v_unit_price = @$_POST['txt_unit_price'];
        $v_note = @$_POST['txt_note'];
        $v_user_id = @$_SESSION['user']->user_id;
      
       
        $query_update = "UPDATE `tbl_inv_type_make` 
            SET 
                `tm_code`='$v_code',
                `tm_name`='$v_name',
                `tm_name_en`='$v_name_en',
                `tm_name_kh`='$v_name_kh',
                `tm_description`='$v_description',
                `tm_account`='$v_account',
                `tm_unit_price`='$v_unit_price',
                `tm_note`='$v_note',
                `tm_user_id`='$v_user_id'
            WHERE `tm_id`='$v_id'";
            
       
        if($connect->query($query_update)){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data update ...
            </div>'; 
        }else{
            $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> '.mysqli_error($connect).'
            </div>';   
        }
    }


// get old data 
    $edit_id = @$_GET['edit_id'];
    $old_data = $connect->query("SELECT * FROM tbl_inv_type_make WHERE tm_id='$edit_id'");
    $row_old_data = mysqli_fetch_object($old_data);


 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Edit Record</h2>
        </div>
    </div>
    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
            <h3 class="panel-title">Edit Information</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->tm_id ?>">
                    <div class="form-body">

                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Code Type : </label>
                                    <input type="text" class="form-control" value="<?= $row_old_data->tm_code ?>" name="txt_code" required=""  autocomplete="off">
                                </div>
                                <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                    <label>Name Khmer : </label>
                                    <input type="text" class="form-control" value="<?= $row_old_data->tm_name_kh ?>" name="txt_name_kh" required=""  autocomplete="off">
                                </div>
                                <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                    <label>Name English : </label>
                                    <input type="text" class="form-control" value="<?= $row_old_data->tm_name_en ?>" name="txt_name_en" required=""  autocomplete="off">
                                </div>
                                <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                    <label>Name Vietnam : </label>
                                    <input type="text" class="form-control" value="<?= $row_old_data->tm_name ?>" name="txt_name" required=""  autocomplete="off">
                                </div>
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label>Add Account Items: </label>
                                    <select name="txt_account" id="input" class="form-control" required="">
                                        <option value="">=== Select and choose ===</option>
                                        <?php 
                                            $v_select=$connect->query("SELECT accca_id,accca_number,accca_account_name FROM tbl_acc_chart_account ORDER BY accca_number");
                                            while ($row_select=mysqli_fetch_object($v_select)) {
                                                if($row_select->accca_id == $row_old_data->tm_account)
                                                    echo '<option SELECTED value="'.$row->accca_id.'">'.$row_select->accca_number.' = '.$row_select->accca_account_name.'</option>';
                                                else
                                                    echo '<option value="'.$row_select->accca_id.'">'.$row_select->accca_number.' = '.$row_select->accca_account_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label>Unit Price/M2 or M3 : </label>
                                    <input type="number" class="form-control" value="<?= $row_old_data->tm_unit_price ?>" name="txt_unit_price" required=""  autocomplete="off">
                                </div>
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label>Description : </label>
                                    <textarea type="text" class="form-control" name="txt_description" style="height: 80px;" autocomplete="off"><?= $row_old_data->tm_description ?></textarea>
                                </div>
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label>Note : </label>
                                    <textarea type="text" class="form-control" name="txt_note" style="height: 80px;" autocomplete="off"><?= $row_old_data->tm_note ?></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <button type="submit" name="btn_submit" class="btn green"><i class="fa fa-save fa-fw"></i>Save</button>
                                <a href="index.php?view=<?= @$_GET['view'] ?>" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>



<?php 
    if(@$_GET['view']=='iframe')
        include_once '../layout/footer_frame.php';
    else
        include_once '../layout/footer.php';
 ?>
