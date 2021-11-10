<?php 
    $menu_active =150;
    $left_active =0;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>



<?php 
    if(isset($_POST['btn_submit'])){
        
        $v_id = @$_POST['txt_id'];
        $v_date_record = @$_POST['txt_date_record'];
        $v_title = @$_POST['txt_title'];
        $v_sub = @$_POST['txt_sub'];
        $v_desctiption = @$_POST['txt_description'];
        $v_leader = @$_POST['txt_leader'];
        $v_gorup = @$_POST['txt_group'];
        $v_date_start = @$_POST['txt_date_start'];
        $v_date_end = @$_POST['txt_date_end'];
        $v_amount = @$_POST['txt_amount'];
        $v_note = @$_POST['txt_note'];
        
       
        $query_update = "UPDATE `tbl_pj_project_initiation` 
            SET 
                pini_date_record='$v_date_record',
                pini_project_title='$v_title',
                pini_project_sub='$v_sub',
                pini_description='$v_desctiption',
                pini_leader='$v_leader',
                pini_group='$v_gorup',
                pini_date_start='$v_date_start',
                pini_date_finish='$v_date_end',
                pini_amount='$v_amount',
                pini_note='$v_note'
            WHERE `pini_id`='$v_id'";
            
       
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
    $old_data = $connect->query("SELECT * FROM tbl_pj_project_initiation WHERE pini_id='$edit_id'");
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
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->pini_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group ">
                                    <label>Date Record : </label>
                                    <input type="text" class="form-control" name="txt_date_record" data-provide="datepicker" data-date-format="yyyy-mm-dd"  autocomplete="off" value="<?= $row_old_data->pini_date_record ?>" required="required">
                                </div>
                                <div class="form-group ">
                                    <label>Project Title : </label>
                                    <select name="txt_title" id="input" class="form-control" required="">
                                        <option value="">=== Select Project Title ===</option>
                                        <?php 
                                            $sql=$connect->query("SELECT * FROM tbl_pj_project_title ORDER BY pti_project_title");
                                            while ($row=mysqli_fetch_object($sql)) {
                                                if($row->pti_id == $row_old_data->pini_project_title)
                                                    echo '<option SELECTED value="'.$row->pti_id.'">'.$row->pti_project_title.'</option>';
                                                else
                                                    echo '<option value="'.$row->pti_id.'">'.$row->pti_project_title.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label>Project Sub : </label>
                                    <input type="text" class="form-control" name="txt_sub" value="<?= $row_old_data->pini_project_sub ?>" autocomplete="off" required="required">
                                </div>
                                <div class="form-group ">
                                    <label>Description : </label>
                                    <input type="text" class="form-control" name="txt_description" value="<?= $row_old_data->pini_description ?>" autocomplete="off" required="required">
                                </div>
                                <div class="form-group">
                                    <label>Leader : </label>
                                    <select name="txt_leader" class="form-control" required="required">
                                        <option value="">--leader--</option>
                                        <?php 
                                            $get_leader = $connect->query("SELECT * FROM tbl_pj_leader ORDEr BY dlead_name ASC");
                                            while ($row_leader = mysqli_fetch_object($get_leader)) {
                                                if($row_leader->dlead_id == $row_old_data->pini_leader)
                                                    echo '<option SELECTED value="'.$row_leader->dlead_id.'">'.$row_leader->dlead_name.'</option>';
                                                else
                                                    echo '<option value="'.$row_leader->dlead_id.'">'.$row_leader->dlead_name.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label>Group : </label>
                                    <input type="text" class="form-control" name="txt_group" value="<?= $row_old_data->pini_group ?>" autocomplete="off" required="required">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group ">
                                    <label>Start Date :  </label>
                                    <input type="text" class="form-control" name="txt_date_start" value="<?= $row_old_data->pini_date_start ?>" data-provide="datepicker" data-date-format="yyyy-mm-dd"  autocomplete="off" placeholder="date start" required="required">
                                </div>
                                <div class="form-group ">
                                    <label>Finish Date :  </label>
                                    <input type="text" class="form-control" name="txt_date_end" value="<?= $row_old_data->pini_date_finish ?>" data-provide="datepicker" data-date-format="yyyy-mm-dd"  autocomplete="off" placeholder="date end" required="required">
                                </div>
                                <div class="form-group " placeholder="date end">
                                    <label>Amount :  </label>
                                    <input type="text" class="form-control" name="txt_amount" value="<?= $row_old_data->pini_amount ?>" autocomplete="off" required="required">
                                </div>
                                <div class="form-group ">
                                    <label>Note :  </label>
                                    <input type="text" class="form-control" name="txt_note" value="<?= $row_old_data->pini_note ?>" autocomplete="off" required="required">
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

<?php include_once '../layout/footer.php' ?>
