<?php 
    $menu_active =3;
    $layout_title = "upload";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>

<?php 
    if(isset($_POST['btn_add'])){
        $v_image = @$_FILES['txt_image'];
        $v_id = @$_POST['txt_id'];
        if($v_image["name"] != ""){
            $old_image = @$_POST['txt_old_img'];
            if(file_exists("../../img/img_user/".$old_image) AND $old_image != 'blank.png'){
                unlink("../../img/img_user/".$old_image);
            }

            $new_name = date("Ymd")."_".rand(1111,9999).".png";
            copy("tmp_".@$_SESSION['user']->user_id.'.png',"../../img/img_user/".$new_name);

            $query_update = "UPDATE tbl_user SET
                    user_photo='$new_name' WHERE user_id='$v_id'";
            
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
        }else{
            exit();
        }
    }


// get old data 
    $edit_id = @$_GET['edit_id'];
    $edit_img = @$_GET['edit_img'];
    $old_data = $connect->query("SELECT * FROM tbl_user WHERE user_id='$edit_id'");
    $row_old_data = mysqli_fetch_object($old_data);


 ?>


<div class="portlet light bordered">
    <div class="portlet-body">
        <?= @$sms ?>
        <div class="portlet light bordered" id="form_wizard_1">
            <div class="portlet-body form">
                <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->user_id ?>">
                    <input type="hidden" name="txt_old_img" value="<?= $row_old_data->user_photo ?>">
                    <div class="form-body">
                        
                        <div class="row">
                            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                                <div class="form-group">
                                    <label>Preview Image <span class="required" aria-required="true">*</span> </label>
                                    <div id="uploaded_image">
                                        <img width="100%" src="../../img/img_user/<?= $row_old_data->user_photo ?>" class="img-responsive img-responsive img-thumbnail" alt="Image">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>New Image <span class="required" aria-required="true">*</span> </label>
                                    <input type="file" class="form-control" name="txt_image" placeholder="Enter your email" autocomplete="off" required="" id="upload_image">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-5 text-center">
                                <button type="submit" name="btn_add" class="btn green"><i class="fa fa-save fa-fw"></i>Save Change</button>
                                <a href="<?= $_SERVER['PHP_SELF'] ?>?edit_id=<?= @$_GET['edit_id'] ?>" class="btn yellow"><i class="fa fa-eraser fa-fw"></i>Reset</a>
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
