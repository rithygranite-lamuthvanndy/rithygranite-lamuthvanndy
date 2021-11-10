<?php 
    $menu_active =150;
    $left_active =0;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>



<?php 
    if(isset($_POST['btn_submit'])){
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
        $v_user_id = @$_SESSION['user']->user_id;
        

        $query_add = "INSERT INTO tbl_pj_project_initiation (
                pini_date_record,
                pini_project_title,
                pini_project_sub,
                pini_description,
                pini_leader,
                pini_group,
                pini_date_start,
                pini_date_finish,
                pini_amount,
                pini_note,
                user_id                
                ) 
            VALUES(
                '$v_date_record',
                '$v_title',
                '$v_sub',
                '$v_desctiption',
                '$v_leader',
                '$v_gorup',
                '$v_date_start',
                '$v_date_end',
                '$v_amount',
                '$v_note',
                '$v_user_id'
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
                                <div class="form-group ">
                                    <label>Date Record : </label>
                                    <input type="text" class="form-control" name="txt_date_record" data-provide="datepicker" data-date-format="yyyy-mm-dd"  autocomplete="off" value="<?= date('Y-m-d') ?>" required="required">
                                </div>
                                <div class="form-group ">
                                    <label>Project Title : </label>
                                    <select name="txt_title" id="input" class="form-control" required="">
                                        <option value="">=== Select Project Title ===</option>
                                        <?php 
                                            $sql=$connect->query("SELECT * FROM tbl_pj_project_title ORDER BY pti_project_title");
                                            while ($row=mysqli_fetch_object($sql)) {
                                                echo '<option value="'.$row->pti_id.'">'.$row->pti_project_title.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label>Project Sub : </label>
                                    <input type="text" class="form-control" name="txt_sub"  autocomplete="off" required="required">
                                </div>
                                <div class="form-group ">
                                    <label>Description : </label>
                                    <input type="text" class="form-control" name="txt_description"  autocomplete="off" required="required">
                                </div>
                                <div class="form-group">
                                    <label>Leader : </label>
                                    <select name="txt_leader" class="form-control" required="required">
                                        <option value="">--leader--</option>
                                        <?php 
                                            $get_leader = $connect->query("SELECT * FROM tbl_pj_leader ORDEr BY dlead_name ASC");
                                            while ($row_leader = mysqli_fetch_object($get_leader)) {
                                                echo '<option value="'.$row_leader->dlead_id.'">'.$row_leader->dlead_name.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label>Group : </label>
                                    <input type="text" class="form-control" name="txt_group"  autocomplete="off" required="required">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group ">
                                    <label>Start Date :  </label>
                                    <input type="text" class="form-control" name="txt_date_start" data-provide="datepicker" data-date-format="yyyy-mm-dd"  autocomplete="off" placeholder="date start" required="required">
                                </div>
                                <div class="form-group ">
                                    <label>Finish Date :  </label>
                                    <input type="text" class="form-control" name="txt_date_end" data-provide="datepicker" data-date-format="yyyy-mm-dd"  autocomplete="off" placeholder="date end" required="required">
                                </div>
                                <div class="form-group " placeholder="date end">
                                    <label>Amount :  </label>
                                    <input type="text" class="form-control" name="txt_amount"  autocomplete="off" required="required">
                                </div>
                                <div class="form-group ">
                                    <label>Note :  </label>
                                    <input type="text" class="form-control" name="txt_note"  autocomplete="off" required="required">
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



<?php include_once '../layout/footer.php' ?>
