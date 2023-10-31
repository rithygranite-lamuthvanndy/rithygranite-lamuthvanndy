<?php 
    $menu_active =141;
    $left_active =0;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    if(@$_GET['view']=='iframe')
        include_once '../layout/header_frame.php';
    else
        include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        $v_dep_id = mysqli_escape_string($connect,@$_POST['txt_dep_id']);
        $v_fix_asset_name = mysqli_escape_string($connect,@$_POST['txt_fix_name']);
        $v_size_model = mysqli_escape_string($connect,@$_POST['txt_size_model']);
        $v_unit = mysqli_escape_string($connect,@$_POST['txt_unit']);
        $v_physical_fa_cost = mysqli_escape_string($connect,@$_POST['txt_cost']);
        $v_narrative_remarks = mysqli_escape_string($connect,@$_POST['txt_na_re']);
        $v_fixed_asset_no = mysqli_escape_string($connect,@$_POST['txt_fix_asset_no']);
        $v_purchased_date = mysqli_escape_string($connect,@$_POST['txt_pur_date']);
        $v_responsible_staff = mysqli_escape_string($connect,@$_POST['cho_staff']);
        $v_fix_asset_location = mysqli_escape_string($connect,@$_POST['txt_location']);
        //$v_photo_id = (!@$_SESSION['saved_image_name']=$new_name) ?: 'blank.png';
        $v_fl_note = mysqli_escape_string($connect,@$_POST['txt_flnote']);
        $v_user_id = @$_SESSION['user']->user_id;


        $image = "no_photo.png";
         if(!empty($_FILES['image']['size'])){
            $image = date("Ymd")."_".rand(1111,9999).$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'],"../../img/img_fix_asset/$image");

            $query_add = "INSERT INTO tbl_fix_asset_list (
                    dep_id,
                    fix_asset_name,
                    size_model,
                    unit,
                    physical_fa_cost,
                    narrative_remarks,
                    fixed_asset_no,
                    purchased_date,
                    responsible_staff,
                    fix_asset_location,
                    photo_id,
                    fl_note,
                    user_id             
                    ) 
                VALUES(
                    '$v_dep_id',
                    '$v_fix_asset_name',
                    '$v_size_model',
                    '$v_unit',
                    '$v_physical_fa_cost',
                    '$v_narrative_remarks',
                    '$v_fixed_asset_no',
                    '$v_purchased_date',
                    '$v_responsible_staff',
                    '$v_fix_asset_location',
                    '$image',
                    '$v_fl_note',
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
                    <strong>Error!</strong> '.$connect->error.'
                </div>';   
            }

        }else{
                    $query_add = "INSERT INTO tbl_fix_asset_list (
                    dep_id,
                    fix_asset_name,
                    size_model,
                    unit,
                    physical_fa_cost,
                    narrative_remarks,
                    fixed_asset_no,
                    purchased_date,
                    responsible_staff,
                    fix_asset_location,
                    photo_id,
                    fl_note,
                    user_id             
                    ) 
                VALUES(
                    '$v_dep_id',
                    '$v_fix_asset_name',
                    '$v_size_model',
                    '$v_unit',
                    '$v_physical_fa_cost',
                    '$v_narrative_remarks',
                    '$v_fixed_asset_no',
                    '$v_purchased_date',
                    '$v_responsible_staff',
                    '$v_fix_asset_location',
                    '$image',
                    '$v_fl_note',
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
                    <strong>Error!</strong> '.$connect->error.'
                </div>';   
            }
        }
    }
    
 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Create Record Fixed Asset</h2>
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
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label>Fixed Asset No: </label>
                                        <input name="txt_fix_asset_no" type="text" class="form-control" required=""  autocomplete="off" autofocus="">
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label>Department Fix Asset </label>
                                        <select type="text" class="form-control myselect2" name="txt_dep_id" required="" autocomplete="off">
                                            <option value="">=== Select and choose===</option>
                                            <?php
                                            $get_select = $connect->query("SELECT * FROM tbl_fix_depart ORDER BY dep_name ASC");
                                            while ($row_data = mysqli_fetch_object($get_select)) {
                                                echo '<option value="' . $row_data->dep_id . '">' . $row_data->dep_name . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Fixed Asset Name: </label>
                                        <input name="txt_fix_name" type="text" class="form-control" required=""  autocomplete="off" autofocus="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label>Size | Model : </label>
                                        <input name="txt_size_model" type="text" class="form-control" required=""  autocomplete="off">
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label>Unit* : </label>
                                        <input name="txt_unit" type="number" class="form-control" required=""  autocomplete="off" step="1" value="1">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label>Physical FA  Cost: </label>
                                        <input name="txt_cost" type="number" step="0.01" class="form-control" required=""  autocomplete="off">
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label>Narrative/ Remarks : </label>
                                         <input name="txt_na_re" type="number" step="0.01" class="form-control" required=""  autocomplete="off">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label for="inputCbo_position">Purchased Date: </label>
                                        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                            <input type="text" class="form-control" value="<?= date('Y') ?>" name="txt_pur_date" placeholder="Choose Date" required="" aufocomplete="off">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label>Responsible Staff: </label>
                                        <input name="cho_staff" type="text" class="form-control" required=""  autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Location: </label>
                                        <select type="text" class="form-control myselect2" name="txt_location" required="" autocomplete="off">
                                            <option value="">=== Select and choose===</option>
                                            <?php
                                            $get_select = $connect->query("SELECT * FROM tbl_fix_locat ORDER BY locat_id ASC");
                                            while ($row_data = mysqli_fetch_object($get_select)) {
                                                echo '<option value="' . $row_data->locat_id . '">' . $row_data->locat_name . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Note : </label>
                                        <textarea type="text" class="form-control" name="txt_flnote" style="height: 80px;" autocomplete="off"></textarea>
                                    </div>
                                </div>                                            
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                   
                                <div class="col-md-12" style="padding-left: 2px;">
                                        <div class="form-group col-xs-12">
                                                <label for = "">User Photo</label>
                                                <input type="file" id = "phot" name="image" onchange="loadFile(event)" />
                                        </div>
                                        <div class = "form-group col-xs-12">                                   
                                            <img src="" alt="" id="preview" class="img-responsive img-responsive img-thumbnail" >
                                        </div>
                                </div>
                            </div>
                        </div>


                    </div>
                        
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <br>
                                <button type="submit" name="btn_submit" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
                                <a href="index.php?view=<?= @$_GET['view'] ?>" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>
<?php 
    if(@$_GET['view']=='iframe')
        include_once '../layout/footer_frame.php';
    else
        include_once '../layout/footer.php';
 ?>
    <script>
        function loadFile(e){
        var output = document.getElementById('preview');
        output.width = 700;

        output.src = URL.createObjectURL(e.target.files[0]);
        }
    </script>
<script src="../../js/dropzone.js"></script>
<script src="../../js/croppie.js"></script>
<link rel="stylesheet" href="../../css/croppie.css" />

<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg" style="width: 70%;">
        <div class="modal-content">
            <div class="modal-body">
                <iframe id="result_modal" src="" width="100%" style="min-height: 600px; resize: vertical;" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>