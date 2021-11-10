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
        $v_date= @$_POST['txt_date'];
        $v_pro_tit= @$_POST['txt_pro_tit'];
        $v_leader= @$_POST['txt_leader'];
        $v_com_pla= @$_POST['txt_com_pla'];
        $v_des= @$_POST['txt_des'];
        $v_name= @$_POST['txt_name'];
        $v_con_tel= @$_POST['txt_con_tel'];
        $v_note= @$_POST['txt_note'];
        $v_user_id = @$_SESSION['user']->user_id;
        

        $query_add = "INSERT INTO tbl_pj_communication_plan (
                pcom_date_record,
                pcom_project_title,
                pcom_leader,
                pcom_communication_plan,
                pcom_description,
                pcom_name,
                pcom_contact_tel,
                pcom_note,
                user_id
                ) 
            VALUES(
                '$v_date',
                '$v_pro_tit',
                '$v_leader',
                '$v_com_pla',
                '$v_des',
                '$v_name',
                '$v_con_tel',
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
                                <div class="form-group">
                                    <label>Date Record :
                                    </label>    
                                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                        <input type="text" class="form-control" placeholder="YYYY-MM-DD" name="txt_date" required="required"  autocomplete="off">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Project Title :
                                    </label>
                                    <select name="txt_pro_tit" id="input" class="form-control" required="">
                                        <option value="">=== Select Project Title ===</option>
                                        <?php 
                                            $sql=$connect->query("SELECT * FROM tbl_pj_project_title ORDER BY pti_project_title");
                                            while ($row=mysqli_fetch_object($sql)) {
                                                echo '<option value="'.$row->pti_id.'">'.$row->pti_project_title.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Leader :
                                    </label>
                                    <select name="txt_leader" id="input" class="form-control" required="">
                                        <option value="">=== Select Leader ===</option>
                                        <?php 
                                            $sql=$connect->query("SELECT * FROM tbl_pj_leader ORDER BY dlead_name");
                                            while ($row=mysqli_fetch_object($sql)) {
                                                echo '<option value="'.$row->dlead_id.'">'.$row->dlead_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Communication Plan :
                                    </label>
                                    <input type="text" class="form-control" name="txt_com_pla"  autocomplete="off" required="">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Description :
                                    </label>
                                    <input type="text" class="form-control" name="txt_des"  autocomplete="off" required="">
                                </div>
                                <div class="form-group">
                                    <label>Name :
                                    </label>
                                    <input type="text" class="form-control" name="txt_name"  autocomplete="off" required="">
                                </div>
                                <div class="form-group">
                                    <label>Contact Tel : </label>
                                    <input type="text" class="form-control" name="txt_con_tel"  autocomplete="off" required="">
                                </div>
                                <div class="form-group">
                                    <label>Note : </label>
                                    <textarea name="txt_note" id="input" class="form-control" rows="3"></textarea>
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



<?php include_once '../layout/footer.php' ?>
