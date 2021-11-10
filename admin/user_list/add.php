<?php  
    $menu_active =10;
    $left_menu =4;
    $layout_title = "Add User Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_add'])){

        $v_id_number    = $connect->real_escape_string(@$_POST['txt_id_number']);
        $v_user_name   = $connect->real_escape_string(@$_POST['txt_user_name']);
        $v_first_name   = $connect->real_escape_string(@$_POST['txt_first_name']);
        $v_last_name    = $connect->real_escape_string(@$_POST['txt_last_name']);
        $v_gender       = $connect->real_escape_string(@$_POST['txt_gender']);
        $v_phone        = $connect->real_escape_string(@$_POST['txt_phone']);
        $v_email        = $connect->real_escape_string(@$_POST['txt_email']);
        $v_address      = $connect->real_escape_string(@$_POST['txt_address']);
        $v_position     = $connect->real_escape_string(@$_POST['txt_position']);
        $v_password     = $connect->real_escape_string(@$_POST['txt_password']);
        $v_status       = $connect->real_escape_string(@$_POST['txt_status']);
        $v_note         = $connect->real_escape_string(@$_POST['txt_note']);
        $v_register_by  = $_SESSION['user']->user_id;
        $v_current_date_time = date('Y-m-d H:i:s');

        $v_image = @$_FILES['txt_photo'];
        // var_dump($v_image);
        if($v_image["name"] != ""){
            $v_photo_name = date("Ymd")."_".rand(1111,9999).".png";
            copy("tmp_".@$_SESSION['user']->user_id.'.png',"../../img/img_user/".$v_photo_name);
        }else{
            $v_photo_name = "blank.png";
        }

        $query_add = "INSERT INTO tbl_user (
            user_code,
            user_name,
            user_first_name,
            user_last_name,
            user_gender,
            user_phone_number,
            user_email,
            user_position,
            user_password,
            user_address,
            user_status,
            user_photo,
            user_note,
            user_res_by,
            user_created_at
        )VALUES(
            '$v_id_number',
            '$v_user_name',
            '$v_first_name',
            '$v_last_name',
            '$v_gender',
            '$v_phone',
            '$v_email',
            '$v_position',
            '$v_password',
            '$$v_address',
            '$v_status',
            '$v_photo_name',    
            '$v_note',
            '$v_register_by',
            '$v_current_date_time'
        )";
        if($connect->query($query_add)){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data inserted ...
            </div>';
            // header("Refresh:2; url=index.php");   
        }else{
            if($v_photo_name != "blank.png"){
                if(file_exists("../../img/img_user/".$v_photo_name)){
                    unlink("../../img/img_user/".$v_photo_name);
                }
            }
            $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> '.mysqli_error($connect).'
            </div>';
            // header("Refresh:0; url=add.php");    
        }
    }

 ?>
<link rel="stylesheet" href="../../css/dropzone.css">
<div class="portlet light bordered">
    <div class="portlet-body">
        <?= @$sms ?>
        <div class="portlet light bordered" id="form_wizard_1" style="position: relative;">
            
            <div class="portlet-body form">
                <form class="form-horizontal" action="#" id="submit_form" method="POST" autocomplete="off" enctype="multipart/form-data">
                    <div class="form-wizard">
                        <div class="form-body">
                            <ul class="nav nav-pills nav-justified steps">
                                <li>
                                    <a href="#tab1" data-toggle="tab" class="step">
                                        <span class="number"> 1 </span>
                                        <span class="desc">
                                            <i class="fa fa-check"></i> Basic </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#tab2" data-toggle="tab" class="step">
                                        <span class="number"> 2 </span>
                                        <span class="desc">
                                            <i class="fa fa-check"></i> Position </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#tab3" data-toggle="tab" class="step active">
                                        <span class="number"> 3 </span>
                                        <span class="desc">
                                            <i class="fa fa-check"></i> Attatchment </span>
                                    </a>
                                </li>
                            </ul>
                            <div id="bar" class="progress progress-striped" role="progressbar">
                                <div class="progress-bar progress-bar-success"> </div>
                            </div>
                            <div class="tab-content">
                                <div class="alert alert-danger display-none">
                                    <button class="close" data-dismiss="alert"></button> You have some form errors. Please check below. </div>
                                <div class="alert alert-success display-none">
                                    <button class="close" data-dismiss="alert"></button> Your form validation is successful! </div>
                                <div class="tab-pane active" id="tab1">
                                    <div class="col-xs-2"></div>
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label>ID Number <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" name="txt_id_number" required="required">
                                            </div>
                                            <div class="form-group">
                                                <label>First Name <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" name="txt_first_name" required="required">
                                            </div>
                                            <div class="form-group">
                                                <label>Last Name <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" name="txt_last_name" required="required">
                                            </div>
                                            <div class="form-group">
                                                <label>User Name :<span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" name="txt_user_name" required="required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label>Gender <span style="color: red;">*</span></label>
                                                <select class="form-control" name="txt_gender" required="required">
                                                    <option value="">=== Please Choose Gender ===</option>
                                                    <?php 
                                                        $gender = $connect->query("SELECT * FROM tbl_user_gender ORDER BY ug_id ASC");
                                                        while ($row_gender = mysqli_fetch_object($gender)) {
                                                            echo '<option value="'.$row_gender->ug_id.'">'.$row_gender->ug_name.'</option>';
                                                        }
                                                     ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Phone <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" name="txt_phone" required="required">
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" name="txt_email" required="required">
                                            </div>
                                            <div class="form-group">
                                                <label>Address </label>
                                                <textarea style="height: 35px;" class="form-control" name="txt_address"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="tab-pane" id="tab2">
                                    <div class="col-xs-2"></div>
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label>Position <span style="color: red;">*</span></label>
                                                <select class="form-control selectpicker" name="txt_position" required="required" data-live-search="true">
                                                    <option value="">=== Please Choose Position ===</option>
                                                    <?php 
                                                        $positon = $connect->query("SELECT * FROM tbl_user_position ORDER BY up_id ASC");
                                                        while ($row_position = mysqli_fetch_object($positon)) {
                                                            echo '<option value="'.$row_position->up_id.'">'.$row_position->up_name.'</option>';
                                                        }
                                                     ?>
                                                </select><span class="help-block help-block-error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Password <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" name="txt_password" required="required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label>Status <span style="color: red;">*</span></label>
                                                <select class="form-control" name="txt_status" required="required">
                                                    <option value="">=== Please Choose Status ===</option>
                                                    <?php 
                                                        $status = $connect->query("SELECT * FROM tbl_user_status_add ORDER BY us_id ASC");
                                                        while ($row_status = mysqli_fetch_object($status)) {
                                                            echo '<option value="'.$row_status->us_id.'">'.$row_status->us_name.'</option>';
                                                        }
                                                     ?>
                                                </select><span class="help-block help-block-error"></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Note </label>
                                                <textarea style="height: 113px;" type="text" class="form-control" name="txt_note"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="tab-pane" id="tab3">
                                    <div class="col-xs-4"></div>
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label>User Photo</label>
                                                <div id="uploaded_image">
                                                    <img width="100%" id="user_photo_preview" class="img img-thumbnail img-responsive" src="../../img/img_user/blank.png" alt="">
                                                </div>
                                                <input type="file" id="upload_image" name="txt_photo" class="form-control">
                                                <br>
                                                <div class="row">
                                                    <div class="col-xs-6" style="padding-right: 0px;">
                                                        <label for="upload_image" type="button" class="btn btn-primary btn-block"><i class="fa fa-upload fa-fw"></i> Browse</label>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <button onclick="document.getElementById('upload_image').value=''; document.getElementById('user_photo_preview').src='../../img/img_user/blank.png'" type="button" class="btn btn-danger btn-block"><i class="fa fa-times fa-fw"></i> Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-2"></div>
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4" style="display: none;">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label>User Document</label>
                                                <img width="100%" class="img img-thumbnail img-responsive" src="../../file/file_user/plant_file.png" alt="">
                                                <input type="file" multiple="" id="upload_document" name="txt_document" class="form-control"><br>
                                                <div class="row">
                                                    <div class="col-xs-6" style="padding-right: 0px;">
                                                        <label for="upload_document" type="button" class="btn btn-primary btn-block"><i class="fa fa-upload fa-fw"></i> Browse</label>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <button onclick="document.getElementById('upload_document').value='';" type="button" class="btn btn-danger btn-block"><i class="fa fa-times fa-fw"></i> Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="text-center">
                                    <a href="index.php" class="btn red"><i class="fa fa-arrow-left"></i> Back</a>
                                    <a href="javascript:;" class="btn default button-previous">
                                        <i class="fa fa-angle-left"></i> Previous </a>
                                    <a href="javascript:;" class="btn btn-outline green button-next"> Continue
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                    <button type="submit" name="btn_add" class="btn green button-submit"> Save
                                        <i class="fa fa-check"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="../../js/dropzone.js"></script>
<?php include_once '../layout/footer.php' ?>

<script src="../../js/croppie.js"></script>
<link rel="stylesheet" href="../../css/croppie.css" />

<div id="uploadimageModal" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Upload & Crop Image</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8 text-center">
                          <div id="image_demo" style="width:350px; margin-top:30px"></div>
                    </div>
                    <div class="col-md-4" style="padding-top:30px;">
                        <br />
                        <br />
                        <br/>
                          <button class="btn btn-success crop_image">Crop & Upload Image</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>  
$(document).ready(function(){

    $image_crop = $('#image_demo').croppie({
    enableExif: true,
    viewport: {
      width:250,
      height:300,
      type:'square' //circle
    },
    boundary:{
      width:350,
      height:400
    }
  });

  $('#upload_image').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      $image_crop.croppie('bind', {
        url: event.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
    $('#uploadimageModal').modal('show');
  });

  $('.crop_image').click(function(event){
    $image_crop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function(response){
      $.ajax({
        url:"upload.php",
        type: "POST",
        async:false,
        data:{"image": response},
        success:function(data)
        {   
          $('#uploadimageModal').modal('hide');
          $('#uploaded_image').html(data);
        }
      });
    })
  });

});  
</script>

