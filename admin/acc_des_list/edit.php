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
        $v_code = @$connect->real_escape_string($_POST['txt_code']);
        $v_name = @$connect->real_escape_string($_POST['txt_name']);
        $v_chart_acc_id = @$connect->real_escape_string($_POST['cbo_chart_acc']);
        $v_note = @$connect->real_escape_string($_POST['txt_note']);
        
       
        $query_update = "UPDATE `tbl_acc_decription` SET 
        `chart_of_acc_id`='$v_chart_acc_id',
        `des_code`='$v_code',
        `des_name`='$v_name',
        `des_note`='$v_note',
        `user_id`='$user_id'
         WHERE des_id='$v_id'";
            
       
        if($connect->query($query_update)){
            echo '<script>myAlertSuccess("Updateing")</script>';
        }else{
            echo '<script>myAlertSuccess("Error")</script>';  
        }
    }


// get old data 
    $edit_id = @$_GET['edit_id'];
    $old_data = $connect->query("SELECT * FROM tbl_acc_decription WHERE des_id='$edit_id'");
    $row_old_data = mysqli_fetch_object($old_data);


 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-plus-circle fa-fw"></i>Edit Record</h2>
        </div>
    </div>
    <br>
    <br>

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
            <h3 class="panel-title">Input Information</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt_id" value="<?= $edit_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Description Code :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <div class="form-group">
                                    <input value="<?= $row_old_data->des_code ?>" type="text" class="form-control" name="txt_code"  autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Description Name :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <div class="form-group">
                                    <input value="<?= $row_old_data->des_name ?>" required="required" type="text" class="form-control" name="txt_name"  autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Description Name :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <select name="cbo_chart_acc" id="inputTxt_chart_acc" class="form-control myselect2">
                                    <option value="">=== Select and Choose ===</option>
                                    <?php 
                                        $v_select=$connect->query("SELECT * FROM tbl_acc_chart_account ORDER BY accca_number ASC");
                                        while ($row_select=mysqli_fetch_object($v_select)) {
                                            if($row_old_data->chart_of_acc_id==$row_select->accca_id)
                                                echo '<option SELECTED value="'.$row_select->accca_id.'">'.$row_select->accca_number.' == '.$row_select->accca_account_name.'</option>';
                                            else
                                                echo '<option value="'.$row_select->accca_id.'">'.$row_select->accca_number.' == '.$row_select->accca_account_name.'</option>';
                                        }
                                     ?>
                                </select>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Note :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <div class="form-group">
                                    <input value="<?= $row_old_data->des_note ?>" type="text" class="form-control" name="txt_note"  autocomplete="off">
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
