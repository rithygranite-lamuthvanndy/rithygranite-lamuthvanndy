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
        $v_name = @$_POST['txt_name'];
        $v_note = @$_POST['txt_note'];
        $v_phone = @$_POST['txt_phone'];
        $v_address = @$_POST['txt_address'];
        $v_email = @$_POST['txt_email'];
        

        $query_add = "INSERT INTO tbl_acc_other_rec_from_list (
                name,
                phone_number,
                address,
                note,
                email,
                user_id
                ) 
            VALUES(
                '$v_name',
                '$v_phone',
                '$v_address',
                '$v_note',
                '$v_email',
                '$user_id'
                )";
        if($connect->query($query_add)){
            echo '<script>myAlertSuccess("Add")</script>';
        }else{
            echo '<script>myAlertError("Error")</script>';
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
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_name" required=""  autocomplete="off">
                                    <label>Other Received From Name :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" id="mask_phone" name="txt_phone"  autocomplete="off">
                                    <label>Phone Number :
                                        <span aria-required="true"></span>
                                    </label>
                                </div>
                            </div>  
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="email" class="form-control" name="txt_email"> 
                                    <label>Email :
                                        <span aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_address"  autocomplete="off">
                                    <label>Address :
                                        <span aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group form-md-line-input">
                                <input type="text" class="form-control" name="txt_note"  autocomplete="off">
                                <label>Note :
                                    <span class="required" aria-required="true"></span>
                                </label>
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


<?php include_once '../layout/footer.php' ?>
