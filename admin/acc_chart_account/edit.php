<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        
        $v_id = @$_POST['txt_id'];
        $v_number = @$connect->real_escape_string($_POST['txt_number']);
        $v_name = @$connect->real_escape_string($_POST['txt_name']);
        $v_type = @$connect->real_escape_string($_POST['txt_type']);
        $v_main = @$connect->real_escape_string($_POST['txt_main']);
        $v_sub_main = @$connect->real_escape_string($_POST['txt_sub_main']);
        $v_sub_main = @$connect->real_escape_string($_POST['txt_sub_main']);
        $v_des = @$connect->real_escape_string($_POST['txt_des']);
        
       
        $query_update = "UPDATE `tbl_acc_chart_account` 
            SET 
                `accca_number`='$v_number',
                `sub_main_id`='$v_sub_main',
                `accca_account_name`='$v_name',
                `accca_account_type`='$v_type',
                `accca_des`='$v_des',
                `user_id`='$user_id'
            WHERE `accca_id`='$v_id'";
            
       
        if($connect->query($query_update)){
            $sql1=$connect->query("SELECT * FROM tbl_acc_open_bal");
            while ($row1=mysqli_fetch_object($sql1)) {
                $sql2=$connect->query("SELECT A.*,C.tr_id
                FROM tbl_acc_chart_account AS A 
                LEFT JOIN tbl_acc_type_account AS B ON A.accca_account_type=B.accta_id
                LEFT JOIN tbl_acc_account_type_report AS C ON B.type_report_id=C.tr_id");
                while ($row2=mysqli_fetch_object($sql2)) {
                    if($row2->tr_id=='1'||$row2->tr_id=='6'||$row2->tr_id=='4')
                        $bal=$row1->debit-$row1->credit;
                    else
                        $bal=-$row1->debit+$row1->credit;
                    $connect->query("UPDATE tbl_acc_open_bal SET bal='$bal' WHERE id='$row1->id' AND chart_acc_id='$row2->accca_id'");
                }
            }
            $sql1=$connect->query("SELECT * FROM tbl_acc_add_tran_amount_detail");
            while ($row1=mysqli_fetch_object($sql1)) {
                $sql2=$connect->query("SELECT A.*,C.tr_id
                FROM tbl_acc_chart_account AS A 
                LEFT JOIN tbl_acc_type_account AS B ON A.accca_account_type=B.accta_id
                LEFT JOIN tbl_acc_account_type_report AS C ON B.type_report_id=C.tr_id");
                while ($row2=mysqli_fetch_object($sql2)) {
                    if($row2->tr_id=='1'||$row2->tr_id=='6'||$row2->tr_id=='4')
                        $bal=$row1->debit-$row1->credit;
                    else
                        $bal=-$row1->debit+$row1->credit;
                    $connect->query("UPDATE tbl_acc_add_tran_amount_detail SET bal='$bal' WHERE id='$row1->id' AND acc_id='$row2->accca_id'");
                }
            }
            $sql1=$connect->query("SELECT * FROM tbl_acc_add_tran_dr_cr_detail");
            while ($row1=mysqli_fetch_object($sql1)) {
                $sql2=$connect->query("SELECT A.*,C.tr_id
                FROM tbl_acc_chart_account AS A 
                LEFT JOIN tbl_acc_type_account AS B ON A.accca_account_type=B.accta_id
                LEFT JOIN tbl_acc_account_type_report AS C ON B.type_report_id=C.tr_id");
                while ($row2=mysqli_fetch_object($sql2)) {
                    if($row2->tr_id=='1'||$row2->tr_id=='6'||$row2->tr_id=='4')
                        $bal=$row1->debit-$row1->credit;
                    else
                        $bal=-$row1->debit+$row1->credit;
                    $connect->query("UPDATE tbl_acc_add_tran_dr_cr_detail SET bal='$bal' WHERE id='$row1->id' AND acc_id='$row2->accca_id'");
                }
            }
            echo '<script>myAlertSuccess("Updated")</script>';
        }else{
            echo '<script>myAlertSuccess("Error")</script>';
        }
    }


// get old data 
    $edit_id = @$_GET['edit_id'];
    $old_data = $connect->query("SELECT * FROM tbl_acc_chart_account WHERE accca_id='$edit_id'");
    $row_old_data = mysqli_fetch_object($old_data);


 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12"> 
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
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->accca_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input value="<?= $row_old_data->accca_number ?>" type="number" class="form-control" name="txt_number"  autocomplete="off">
                                    <label>Number :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input value="<?= $row_old_data->accca_account_name ?>" type="text" class="form-control" name="txt_name"  autocomplete="off">
                                    <label>Account Name :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#acc_sub_main'><i class="fa fa-plus"></i></a>
                                    <div class="btn btn-xs btn-success" id="sub_main"><i class="fa fa-refresh"></i></div>
                                    <select class="form-control myselect2" name="txt_sub_main" required="required">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_acc_chart_sub ORDER BY name ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                $v_code=str_pad($row_data->code, 6,'*',STR_PAD_RIGHT);
                                                if($row_old_data->sub_main_id==$row_data->id)
                                                    echo '<option SELECTED value="'.$row_data->id.'">'.$v_code.' :: '.$row_data->name.'</option>';
                                                else
                                                    echo '<option value="'.$row_data->id.'">'.$v_code.' :: '.$row_data->name.'</option>';
                                            }
                                         ?>
                                    </select>
                                    <label>Sub Main Account :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#acc_type'><i class="fa fa-plus"></i></a>
                                    <div class="btn btn-xs btn-success" id="type_id"><i class="fa fa-refresh"></i></div>
                                    <select class="form-control myselect2" name="txt_type" required="required">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_acc_type_account ORDER BY accta_type_account ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                if($row_old_data->accca_account_type==$row_data->accta_id)
                                                    echo '<option SELECTED value="'.$row_data->accta_id.'">'.$row_data->accta_type_account.'</option>';
                                                else
                                                    echo '<option value="'.$row_data->accta_id.'">'.$row_data->accta_type_account.'</option>';
                                            }
                                         ?>
                                    </select>
                                    <label>Account Type :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group form-md-line-input">
                                    <textarea name="txt_des" id="input" class="form-control" rows="3" required="required"><?= $row_old_data->accca_des ?></textarea>
                                    <label>Chart Account Description :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_submit" class="btn green"><i class="fa fa-save fa-fw"></i>Save & Close</button>
                                <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript" src="../../assets/global/plugins/jquery.min.js"></script>
<script type="text/javascript">
$('div#type_id').mouseover(function(){
        $.ajax({url: "ajx_get_content_select.php?d=txt_type", success: function(result){
            if($('select[name=txt_type]').html().trim() != result.trim()){
                $('select[name=txt_type]').html(result);
                 $('select[name=txt_type]').attr("class","selectpicker form-control");
                $('select[name=txt_type]').attr("data-live-search","true");
                $('select[name=txt_type]').selectpicker('refresh');
            }
        }});
    });
    $('div#sub_main').click(function(){
        $.ajax({url: "ajx_get_content_select.php?d=txt_sub_main", success: function(result){
            if($('select[name=txt_sub_main]').html().trim() != result.trim()){
                $('select[name=txt_sub_main]').html(result);
                $('select[name=txt_sub_main]').attr("class","selectpicker form-control");
                $('select[name=txt_sub_main]').attr("data-live-search","true");
                $('select[name=txt_sub_main]').selectpicker('refresh');
                // alert(result);
            }
        }});
    });
    document.onkeyup = function(e) {
        if (e.altKey && e.which  === 18) {
            $('button[name=btn_submit]').click();
        }
    };    
</script>


<?php include_once '../layout/footer.php' ?>
<div class="modal fade" id="acc_type">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_acc_type.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="acc_sub_main">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_sub_main.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>