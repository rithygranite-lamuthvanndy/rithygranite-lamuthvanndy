<?php 
    $menu_active =130;
    $left_active =0;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        
        $v_id = @$_POST['txt_id'];
        $v_date = @$_POST['txt_date'];
        $v_name = @$_POST['txt_name'];
        $v_type = @$_POST['txt_type'];
        $v_phone_number = @$_POST['txt_number'];
        $v_emial = @$_POST['txt_email'];
        $v_address = @$_POST['txt_address'];
        $v_note = @$_POST['txt_note'];
        $v_user_id = @$_SESSION['user']->user_id;
        
       
        $query_update = "UPDATE `tbl_sup_supplier_info` 
            SET 
                `supsi_date_record`='$v_date',
                `supsi_name`='$v_name',
                `supsi_type`='$v_type',
                `supsi_phone`='$v_phone_number',
                `supsi_email`='$v_emial',
                `supsi_address`='$v_address',
                `supsi_note`='$v_note'
            WHERE `supsi_id`='$v_id'";
            
       
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
    $old_data = $connect->query("SELECT * FROM tbl_sup_supplier_info WHERE supsi_id='$edit_id'");
    $row_old_data = mysqli_fetch_object($old_data);


 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Edit Record</h2>
        </div>
    </div>
    <div class="portlet-title">
        <div class="caption font-dark">
            <a href="index.php" id="sample_editable_1_new" class="btn red"> 
                <i class="fa fa-arrow-left"></i>
                Back
            </a>
        </div>
    </div>
    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
            <h3 class="panel-title">Edit Information</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->supsi_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Name : </label>
                                    <input type="text" class="form-control" name="txt_name" required="" value="<?= $row_old_data->supsi_name ?>" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Type : </label>
                                    <select type="text" class="form-control myselect2" name="txt_type" required="" autocomplete="off">
                                        <option value="">==choose type==</option>
                                        <?php 
                                            $get_cus_type=$connect->query("SELECT * FROM tbl_sup_type ORDER BY supct_name ASC");
                                            while($row_cus_type = mysqli_fetch_object($get_cus_type)){
                                                if($row_cus_type->supct_id==$row_old_data->supsi_type){
                                                echo '<option SELECTED value="'.$row_cus_type->supct_id.'">'.$row_cus_type->supct_name.'</option>';
                                                    
                                                }else{
                                                echo '<option value="'.$row_cus_type->supct_id.'">'.$row_cus_type->supct_name.'</option>';

                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Phone Number : </label>
                                    <input type="text" class="form-control" name="txt_number" value="<?= $row_old_data->supsi_phone ?>" required="" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Email : </label>
                                    <input type="text" class="form-control" name="txt_email" value="<?= $row_old_data->supsi_email ?>" required="" autocomplete="off">
                                </div>

                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Address : </label>
                                    <textarea type="text" class="form-control" name="txt_address" style="height: 125px;" autocomplete="off"><?= $row_old_data->supsi_address ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Note : </label>
                                    <textarea type="text" class="form-control" name="txt_note" rows="4" autocomplete="off"><?= $row_old_data->supsi_note ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_submit" class="btn green"><i class="fa fa-save fa-fw"></i>Save</button>
                                <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript" src="../../plugin/ckeditor_4.7.0_full/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace( 'detail', {
        language: 'en',
      height: '700'
        // uiColor: '#9AB8F3'
    });
</script>


<?php include_once '../layout/footer.php' ?>
