<?php 
    $menu_active =10;
    $left_active =0;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        $v_name = $connect->real_escape_string(@$_POST['txt_name']);
        $v_status = @$_POST['txt_status'];
        $v_see_group_data = (@$_POST['txt_see_group_data'])?(1):(0);
        $v_note = $connect->real_escape_string(@$_POST['txt_note']);
        $v_user_id = @$_SESSION['user']->user_id;
        
        $query_add = "INSERT INTO  tbl_user_position (
                up_name,
                up_status,
                up_group_data,
                up_note              
                ) 
            VALUES(
                '$v_name',
                '$v_status',
                '$v_see_group_data',
                '$v_note'
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
                 <form action="#" method="post" enctype="multipart/form-data">
                    <div class="form-body">


                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Name : </label>
                                    <input type="text" class="form-control" name="txt_name" required=""  autocomplete="off">
                                </div>                                
                                <div class="form-group">
                                    <label>Note : </label>
                                    <textarea type="text" class="form-control" name="txt_note" style="height: 80px;" autocomplete="off"></textarea>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="txt_status" required="required">
                                        <option value="">=== Please Choose Status ===</option>
                                        <?php 
                                            $status = $connect->query("SELECT * FROM tbl_user_status ORDER BY us_id ASC");
                                            while ($row_status = mysqli_fetch_object($status)) {
                                                echo '<option value="'.$row_status->us_id.'">'.$row_status->us_name.'</option>';
                                            }
                                         ?>
                                    </select><span class="help-block help-block-error"></span>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="txt_see_group_data" id="group_data" checked="">
                                    <label for="group_data">See Only Group Data</label>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-6 text-center">
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
