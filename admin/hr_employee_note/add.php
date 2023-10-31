<?php 
    $menu_active =33;
    $left_active =0;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        $v_empl_id = @$_POST['txt_empl_id'];
        $v_date = @$_POST['txt_date'];
        $v_desc = @$_POST['txt_desc'];
        $v_note = @$_POST['txt_note'];

        $query_add = "INSERT INTO tbl_hr_employee_note(
                emn_empl_id,
                emn_date,
                emn_description,
                emn_note
                ) 
            VALUES(
                '$v_empl_id',
                '$v_date',
                '$v_desc',
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
                                <label>Gender * : </label>
                                        <select name="txt_empl_id" id="inputCbo_position" class="form-control myselect2" required="required">
                                            <option value="">*** Select and choose ***</option>
                                            <?php 
                                                $v_result=$connect->query("SELECT * FROM tbl_hr_employee_list ORDER BY empl_emloyee_kh");
                                                while ($row_select=mysqli_fetch_object($v_result)) {
                                                    echo '<option value="'.$row_select->empl_id.'">'.$row_select->empl_card_id.' || '.$row_select->empl_emloyee_kh.'</option>';
                                                }
                                             ?>
                                        </select>
                                <label for="inputCbo_position">Salary Date: </label>
                                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                        <input type="text" class="form-control" value="<?= date('Y-m-d') ?>" name="txt_date" placeholder="Choose Date" required="" aufocomplete="off">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                    </div>
                                <br>
                                <label>បរិយា
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <input type="text" name="txt_desc" class="form-control" required="">
                                <br>
                                <label>Note /ចំណាំ
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <textarea name="txt_note" rows="10" class="form-control"></textarea>
                                <br>
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
