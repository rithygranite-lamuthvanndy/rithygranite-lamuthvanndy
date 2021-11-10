<?php 
    $menu_active =130;
    $left_active =0;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        $v_date = @$_POST['txt_date'];
        $v_name = @$_POST['txt_name'];
        $v_type = @$_POST['txt_type'];
        $v_phone_number = @$_POST['txt_number'];
        $v_emial = @$_POST['txt_email'];
        $v_address = @$_POST['txt_address'];
        $v_note = @$_POST['txt_note'];
        $v_user_id = @$_SESSION['user']->user_id;
        

        $query_add = "INSERT INTO tbl_sup_supplier_info (
                supsi_name,
                supsi_type,
                supsi_phone,
                supsi_email,
                supsi_address,
                supsi_note                
                ) 
            VALUES(
                '$v_name',
                '$v_type',
                '$v_phone_number',
                '$v_emial',
                '$v_address',
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
                <strong>Error!</strong>'.mysqli_error($connect).'
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
                                <div class="form-group">
                                    <label>Name : </label>
                                    <input type="text" class="form-control" name="txt_name" required=""  autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Type : </label>
                                    <select type="text" class="form-control myselect2" name="txt_type" required="" autocomplete="off">
                                        <option value="">==choose type==</option>
                                        <?php 
                                            $get_cus_type=$connect->query("SELECT * FROM tbl_sup_type ORDER BY supct_name ASC");
                                            while($row_cus_type = mysqli_fetch_object($get_cus_type)){
                                                echo '<option value="'.$row_cus_type->supct_id.'">'.$row_cus_type->supct_name.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Phone Number : </label>
                                    <input type="text" class="form-control" name="txt_number" required="" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Email : </label>
                                    <input type="text" class="form-control" name="txt_email" required="" autocomplete="off">
                                </div>

                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Address : </label>
                                    <textarea type="text" class="form-control" name="txt_address" style="height: 125px;" autocomplete="off"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Note : </label>
                                    <textarea type="text" class="form-control" name="txt_note" rows="4" autocomplete="off"></textarea>
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
