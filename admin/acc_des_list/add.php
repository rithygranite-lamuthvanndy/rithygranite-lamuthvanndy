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
        $v_code = @$connect->real_escape_string($_POST['txt_code']);
        $v_name = @$connect->real_escape_string($_POST['txt_name']);
        $v_chart_acc_id = @$connect->real_escape_string($_POST['cbo_chart_acc']);
        $v_note = @$connect->real_escape_string($_POST['txt_note']);
        $query_add = "INSERT INTO tbl_acc_decription (
                chart_of_acc_id,
                des_code,
                des_name,
                des_note,
                user_id
                ) 
            VALUES(
                '$v_chart_acc_id',
                '$v_code',
                '$v_name',
                '$v_note',
                '$user_id'
                )";
        if($connect->query($query_add)){
            echo '<script>myAlertSuccess("Adding")</script>';
        }else{
            echo 'myAlertError("Adding")';
        }
    }

 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-plus-circle fa-fw"></i>Create Record</h2>
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
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Description Code :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="txt_code"  autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Description Name :
                                    <span class="required" aria-required="true"></span>
                                </label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="txt_name" required="required" autocomplete="off">
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
                                    <input type="text" class="form-control" name="txt_note"  autocomplete="off">
                                </div>
                            </div>
                        </div>
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



<script type="text/javascript" src="../../plugin/ckeditor_4.7.0_full/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace( 'detail', {
        language: 'en',
      height: '700'
        // uiColor: '#9AB8F3'
    });
</script>


<?php include_once '../layout/footer.php' ?>
