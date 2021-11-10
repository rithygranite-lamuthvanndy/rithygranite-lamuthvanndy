<?php 
    $menu_active =12;
    $left_menu_active =2;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header_frame.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        
        $v_id = @$_POST['txt_id'];
        $v_main_menu= @$_POST['cbo_main_menu'];
        $v_left_menu_name= @$_POST['txt_left_menu_name'];
        $v_left_menu_directory= @$_POST['txt_left_menu_directory'];
        $v_left_menu_index= @$_POST['txt_left_menu_index'];
        $v_left_menu_type= @$_POST['cbo_type'];
        
       
        $query_update = "UPDATE `tbl_left_menu` 
            SET 
                `lm_name`='$v_left_menu_name',
                `lm_directory`='$v_left_menu_directory',
                `lm_index_order`='$v_left_menu_index',
                `lm_main_menu`='$v_main_menu',
                `lm_status`='$v_left_menu_type'
            WHERE `lm_id`='$v_id'";
            
       
        if($connect->query($query_update)){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data update ....
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
    $old_data = $connect->query("SELECT * FROM tbl_left_menu WHERE lm_id='$edit_id'");
    $row_old_data = mysqli_fetch_object($old_data);


 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Edit Left Menu</h2>
        </div>
    </div>
    <br>
    <hr>
    <br>
    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
            <h3 class="panel-title">Edit Information</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt_id" value="<?= $edit_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Top Menu Name : </label>
                                    <select class="form-control myselect2" name="cbo_main_menu">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_main_menu ORDER BY mm_index_order");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                if($row_old_data->lm_main_menu==$row_data->mm_id)
                                                    echo '<option selected value="'.$row_data->mm_id.'">'.$row_data->mm_name.'</option>';
                                                else
                                                    echo '<option value="'.$row_data->mm_id.'">'.$row_data->mm_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Left Menu Name : </label>
                                    <input type="text" value="<?= $row_old_data->lm_name ?>" name="txt_left_menu_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Directory Name : </label>
                                    <input type="text" value="<?= $row_old_data->lm_directory ?>" name="txt_left_menu_directory" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label>Left Menu Index : </label>
                                    <input type="number" min="1" value="<?= $row_old_data->lm_index_order ?>" step="1" name="txt_left_menu_index" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Left Menu Type :</label>
                                    <select class="form-control myselect2" name="cbo_type">
                                        <?php 
                                            if($row_old_data->lm_status==1){
                                                echo '<option selected value="1">Link</option>';
                                                echo '<option  value="2">Tittle</option>';
                                                echo '<option value="3">DropDown</option>';
                                            }
                                            else if($row_old_data->lm_status==2){
                                                echo '<option value="1">Link</option>';
                                                echo '<option selected value="2">Tittle</option>';
                                                echo '<option value="3">DropDown</option>';
                                            }
                                            else if($row_old_data->lm_status==3){
                                                echo '<option value="1">Link</option>';
                                                echo '<option value="2">Tittle</option>';
                                                echo '<option selected value="3">DropDown</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <button type="submit" name="btn_submit" class="btn green"><i class="fa fa-save fa-fw"></i>Save</button>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>
<?php include_once '../layout/footer_frame.php' ?>
