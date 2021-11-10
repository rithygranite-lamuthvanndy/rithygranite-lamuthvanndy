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
        $v_date = @$_POST['txt_date'];
        $v_ris_tit = @$_POST['txt_ris_tit'];
        $v_ris_upd = @$_POST['txt_ris_upd'];
        $v_note = @$_POST['txt_note'];
        $v_user_id = @$_SESSION['user']->user_id;
        

        $query_add = "INSERT INTO tbl_pj_control_risk (
                cris_date_record,
                cris_risk_title,
                cris_risk_update,
                cris_note,
                user_id
                
                ) 
            VALUES(
                '$v_date',
                '$v_ris_tit',
                '$v_ris_upd',
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
                                    <label>Risk Title : </label>
                                    <select name="txt_ris_tit" id="input" class="form-control" required="">
                                        <option value="">=== Select Risk Title ===</option>
                                        <?php 
                                            $sql=$connect->query("SELECT * FROM tbl_pj_risk_management AS PRM
                                                LEFT JOIN tbl_pj_project_title AS PPT ON PRM.pris_project_title=PPT.pti_id
                                                LEFT JOIN tbl_pj_project_initiation AS PPI ON PRM.pris_project_sub=PPI.pini_id");
                                            while ($row=mysqli_fetch_object($sql)) {
                                                echo '<option value="'.$row->pti_id.'">'.$row->pti_project_title.'::'.$row->pini_project_sub.'::'.$row->pris_risk_title.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>    
                                <div class="form-group">
                                    <label>Risk Update : </label>
                                    <select name="txt_ris_upd" id="input" class="form-control" required="">
                                        <option value="">=== Select Risk Update ===</option>
                                        <?php 
                                            $sql=$connect->query("SELECT * FROM tbl_pj_risk_update ORDER BY drup_name");
                                            while ($row=mysqli_fetch_object($sql)) {
                                                echo '<option value="'.$row->drup_id.'">'.$row->drup_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Note : </label>
                                    <textarea name="txt_note" id="input" class="form-control" rows="5"></textarea>
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
