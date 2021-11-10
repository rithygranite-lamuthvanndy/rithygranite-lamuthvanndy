<?php 
    $menu_active =140;
    $left_active =0;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        
        $v_id = @$_POST['txt_id'];
        $v_name = $connect->real_escape_string(@$_POST['txt_name']);
        $v_main_menu = $connect->real_escape_string(@$_POST['txt_main_menu']);
        $v_status = $connect->real_escape_string($_POST['txt_status']);
       
        $query_update = "UPDATE `tbl_left_menu` 
            SET 
                `lm_name`='$v_name',
                `lm_main_menu`='$v_main_menu',
                `lm_status`='$v_status'
            WHERE `lm_id`='$v_id'";
            
       
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
    $old_data = $connect->query("SELECT * FROM tbl_left_menu WHERE lm_id='$edit_id'");
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
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->lm_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                
                                <div class="form-group">
                                    <label>Name : </label>
                                    <input type="text" class="form-control" name="txt_name" required="" value="<?= $row_old_data->lm_name ?>" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Main Menu : </label>
                                    <select name="txt_main_menu" class="form-control" required="">
                                      <option value="">==choose Main Menu==</option>
                                      <?php 
                                          $get_main_menu = $connect->query("SELECT * FROM tbl_main_menu ORDER BY mm_index_order ASC");
                                          while ($row_main_menu = mysqli_fetch_object($get_main_menu)) {
                                              if($row_main_menu->mm_id == $row_old_data->lm_main_menu){
                                                  echo '<option SELECTED value="'.$row_main_menu->mm_id.'">'.$row_main_menu->mm_name.'</option>';
                                                  
                                              }else{
                                                  echo '<option value="'.$row_main_menu->mm_id.'">'.$row_main_menu->mm_name.'</option>';
                                              }
                                          }
                                      ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Status <span style="color: red;">*</span></label>
                                    <select class="form-control" name="txt_status" required="required">
                                        <?php 
                                            $status = $connect->query("SELECT * FROM tbl_user_status ORDER BY us_id ASC");
                                            while ($row_status = mysqli_fetch_object($status)) {
                                                if($row_status->us_id == $row_old_data->lm_status)
                                                    echo '<option SELECTED value="'.$row_status->us_id.'">'.$row_status->us_name.'</option>';
                                                else
                                                    echo '<option value="'.$row_status->us_id.'">'.$row_status->us_name.'</option>';
                                            }
                                         ?>
                                    </select><span class="help-block help-block-error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-6 text-center">
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
<?php include_once '../layout/footer.php' ?>
