<?php 
    $menu_active =101;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_add'])){
        $v_meeting_no= @$_POST['cbo_meeting_no'];
        $v_joiner_no = @$_POST['cbo_joiner_no'];
        $v_topic = @$_POST['txt_topic'];
        $v_note = @$_POST['txt_note'];
        
        foreach ($v_joiner_no as $key =>$value) {
            if($value){
                $new_joiner=$v_joiner_no[$key];
                $query_add = "INSERT INTO tbl_meeting_add_joiner_name (ajn_meeting_no
                                                    ,ajn_name
                                                    ,ajn_note
                                                    ,ajn_join
                                                    ) 

                                            VALUES('$v_meeting_no'
                                                    ,'$v_topic'
                                                    ,'$v_note'
                                                    ,'$new_joiner'
                                                    )";
                $flag=$connect->query($query_add);
            }
            
        }
            
            if($flag){
                $sms = '<div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Successfull!</strong> Data inserted ...
                </div>';
                // header("Refresh:2; url=index.php");   
            }else{
                $sms = '<div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Error!</strong> Query error ...
                </div>';
                // header("Refresh:0; url=add.php");    
            }
        
    }

 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-user fa-fw"></i>Add New</h2>
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
                                <div class="form-group form-md-line-input">
                                   <select class="form-control" name="cbo_meeting_no">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_meeting_plan ORDER BY meetp_meting_no ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_data->meetp_id.'">'.$row_data->meetp_meting_no.'</option>';
                                            }
                                         ?>
                                    </select>
                                    <label>Meeting N&deg; :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" name="txt_topic" id="input" class="form-control" required="required">
                                    <label>Topic :</label>
                                </div>
                            </div>
                        </div>
                            <div class="row form_base">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group form-md-line-input">
                                       <select class="form-control" name="cbo_joiner_no[]">
                                            <option value="">=== Please Choose and Select ===</option>
                                            <?php 
                                                $v_select = $connect->query("SELECT * FROM tbl_meeting_name_list ORDER BY mnl_name ASC");
                                                while ($row_data = mysqli_fetch_object($v_select)) {
                                                    echo '<option value="'.$row_data->mnl_id.'">'.$row_data->mnl_name.'</option>';
                                                }
                                             ?>
                                        </select>
                                        <label>Joiner Name :
                                            <span class="required" aria-required="true"></span>
                                        </label>
                                    </div>
                                </div>
                            <div class="form_add_result"></div>
                            </div>
                            <div class="form-group text-center">
                                <button type="button" class="btn btn-info my_add"><i class="fa fa-plus"></i> Add More</button>
                            </div>
                        </div>
                        <div class="row">
                             <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group form-md-line-input">
                                    <textarea class="form-control" name="txt_note" autocomplete="off"></textarea>
                                    <label>Note :</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 col-sm-6 col-md-6 col-lg-6 text-center">
                                <button type="submit" name="btn_add" class="btn blue"><i class="fa fa-save fa-fw"></i> Save</button>
                                <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i> Cancel</a>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>

<script src="../../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $('.my_add').click(function(){
        $('.form_add_result').append($('.form_base').html());
        cal_amo();
    });
</script>



<?php include_once '../layout/footer.php' ?>
