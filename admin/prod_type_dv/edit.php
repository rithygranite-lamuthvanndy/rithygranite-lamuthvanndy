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
        $v_name_kh = @$_POST['txt_name_kh'];
        $v_name_en = @$_POST['txt_name_en'];
        $v_name_vn = @$_POST['txt_name_vn'];
        $v_note = @$_POST['txt_note'];
        $v_user_id = @$_SESSION['user']->user_id;
       
        $query_update = "UPDATE `tbl_prod_type_dv` 
            SET 
                `tdv_code`='$v_code',
                `tdv_name_kh`='$v_name_kh',
                `tdv_name_en`='$v_name_en',
                `tdv_name_vn`='$v_name_vn',
                `tdv_note`='$v_note',
                `tdv_user_id`='$v_user_id'
            WHERE `tdv_id`='$v_id'";
            
       
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
    $old_data = $connect->query("SELECT * FROM tbl_prod_type_dv WHERE tdv_id='$edit_id'");
    $row_old_data = mysqli_fetch_object($old_data);


 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Edit Record Type DV</h2>
        </div>
    </div>
    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
            <h3 class="panel-title">Edit Information</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->tdv_id ?>">
                    <div class="form-body">

                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Code Type : </label>
                                    <input type="text" class="form-control" name="txt_code" required="" value="<?= $row_old_data->tdv_code ?>"  autocomplete="off">
                                </div>
                                <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                    <label>Name Khmer: </label>
                                    <input type="text" class="form-control" name="txt_name_kh" required="" value="<?= $row_old_data->tdv_name_kh ?>"  autocomplete="off">
                                </div>
                                <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                    <label>Name English: </label>
                                    <input type="text" class="form-control" name="txt_name_en" required="" value="<?= $row_old_data->tdv_name_en ?>"  autocomplete="off">
                                </div>
                                <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                    <label>Name Vietnam: </label>
                                    <input type="text" class="form-control" name="txt_name_vn" required="" value="<?= $row_old_data->tdv_name_vn ?>"  autocomplete="off">
                                </div>
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label>Note : </label>
                                    <textarea type="text" class="form-control" name="txt_note" style="height: 80px;" autocomplete="off"><?= $row_old_data->tdv_note ?></textarea>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

                            </div>
                        </div>

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
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
