<?php 
    $menu_active =101;
    $left_active =0;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){

        $v_id = @$_POST['txt_id'];
        $v_old_file = @$_POST['txt_old_file'];
        $v_date= @$_POST['txt_date'];
        $v_title = @$_POST['txt_title'];
        $v_plan = @$_POST['cbo_plan'];
        $v_note = @$_POST['txt_note'];
        $v_image = @$_FILES['txt_file'];
        $date_audit = date("Y-m-d H:i:s");
        
        
       
        if($v_image["name"] != ""){


            // if(file_exists('../../file/file_meeting_document/'.$old_file)){
            // }

            $new_name = date("Ymd")."_".rand(1111,9999).$v_image["name"];
            move_uploaded_file($v_image["tmp_name"], "../../file/file_meeting_document/".$new_name);


            $connect->query("UPDATE tbl_meeting_document SET
                doc_date_record='$v_date',
                plan_id='$v_plan',
                title='$v_title',
                file_title='$new_name',
                note='$v_note',
                date_audit='$date_audit'
                WHERE doc_id='$v_id'
                ");
            if(file_exists('../../file/file_meeting_document/'.$v_old_file)){
                unlink('../../file/file_meeting_document/'.$v_old_file);
            }
            $sms = '<div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong></strong> Sucessful.....
                </div>';
        }else{
            $sms = '<div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> Please Choose File ...
                </div>';
        }
    }


// get old data 
    $edit_id = @$_GET['sent_id'];
    $old_file = @$_GET['old_file'];
    $old_data = $connect->query("SELECT * FROM tbl_meeting_document WHERE doc_id='$edit_id'");
    $row_old_data = mysqli_fetch_object($old_data);


 ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
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
               
            <h3 class="panel-title">Input Information</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt_id" value="<?= $edit_id ?>">
                    <input type="hidden" name="txt_old_file" value="<?= $old_file ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                                <div class="form-group form-md-line-input">
                                    <input type="date" value="<?= $row_old_data->doc_date_record ?>" class="form-control" name="txt_date" placeholder="date record..."  autocomplete="off">
                                    <label>Date :
                                        <span class="required" aria-required="true"></span>
                                    </label>

                                </div>
                            </div>
                    
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" value="<?= $row_old_data->title ?>" class="form-control" name="txt_title"  autocomplete="off">
                                    <label>Title :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                        </div>
                    </div>

                    <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <select class="form-control" name="cbo_plan">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_meeting_plan ORDER BY meetp_meting_no ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                if($row_old_data->plan_id==$row_data->meetp_id)
                                                    echo '<option SELECTED value="'.$row_data->meetp_id.'">'.$row_data->meetp_meting_no.'</option>';
                                                else
                                                    echo '<option value="'.$row_data->meetp_id.'">'.$row_data->meetp_meting_no.'</option>';
                                            }
                                         ?>
                                    </select>
                                    <label>Plan N&deg; :<span class="required" aria-required="true">*</span></label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="file" class="form-control" name="txt_file" value="<?= $row_old_data->file_title ?>"  autocomplete="off">
                                    <label>File :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                        </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group form-md-line-input">
                                    <textarea name="txt_note" id="inputTxt_note" class="form-control" rows="3" required="required"><?= $row_old_data->note ?></textarea>
                                    <label>Note :
                                        <span class="required" aria-required="true"></span>
                                    </label>
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



<script type="text/javascript" src="../../plugin/ckeditor_4.7.0_full/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace( 'detail', {
        language: 'en',
      height: '700'
        // uiColor: '#9AB8F3'
    });
</script>


<?php include_once '../layout/footer.php' ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
