<?php 
    $menu_active =11;
    $left_menu =4;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    if(@($_GET['view']=='iframe')){
        include_once '../layout/header_frame.php';
    }
    else{
        include_once '../layout/header.php';
    }
?> 
<?php 
    if(isset($_POST['btn_submit'])){
        $v_code = @$_POST['txt_code'];
        $v_name_kh = @$_POST['txt_name_kh'];
        $v_name_en = @$_POST['txt_name_en'];
        $v_name_vn = @$_POST['txt_name_vn'];
        $v_description = @$_POST['txt_description'];
        $v_unit_price = @$_POST['txt_unit_price'];
        $v_note = @$_POST['txt_note'];
        $v_user_id = @$_SESSION['user']->user_id;

       $image = "no_photo.png";
         if(!empty($_FILES['image']['size'])){
            $image = date("Ymd")."_".rand(1111,9999).$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'],"../../img/img_it/$image");

        $query_add = "INSERT INTO  tbl_items_type_list (
                tit_code,
                tit_name_kh,
                tit_name_en,
                tit_name_vn,
                tit_description,
                tit_unit_price,
                tit_note,
                tit_pictures,
                tit_user_id             
                ) 
            VALUES(
                '$v_code',
                '$v_name_kh',
                '$v_name_en',
                '$v_name_vn',
                '$v_description',
                '$v_unit_price',
                '$v_note',
                '$image',
                '$v_user_id'
                )";
        if($connect->query($query_add)){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong>  Adding Record ...
            </div>'; 
        }else{
            $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong>   '.mysqli_error($connect).'
            </div>'; 
        }
    }

 ?>


<div class="portlet light bordered">
    <div class="row">
        <?= @$sms ?>
        <div class="col-xs-12">
            <h2><i class="fa fa-plus-circle fa-fw"></i>Create Record</h2>
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
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Code Type : </label>
                                    <input type="text" class="form-control" name="txt_code" required=""  autocomplete="off">
                                </div>
                                <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                    <label>Name Khmer: </label>
                                    <input type="text" class="form-control" name="txt_name_kh" required=""  autocomplete="off">
                                </div>
                                <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                    <label>Name English: </label>
                                    <input type="text" class="form-control" name="txt_name_en" required=""  autocomplete="off">
                                </div>
                                <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                    <label>Name Vietnam: </label>
                                    <input type="text" class="form-control" name="txt_name_vn" required=""  autocomplete="off">
                                </div>
                                                            
                                <div class="form-group">
                                    <label>Unit Price/M2 or M3 : </label>
                                    <input type="text" class="form-control" name="txt_unit_price" required=""  autocomplete="off">
                                </div>
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label>Description : </label>
                                    <textarea type="text" class="form-control" name="txt_description" style="height: 80px;" autocomplete="off"></textarea>
                                </div>
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label>Note : </label>
                                    <textarea type="text" class="form-control" name="txt_note" style="height: 80px;" autocomplete="off"></textarea>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group col-xs-12">
                                            <label for = "">User Photo</label>
                                            <input type="file" id = "phot" name="image" onchange="loadFile(event)" />
                                        </div>
                                        <div class="form-group col-xs-12">                                   
                                            <img src="" alt="" id="preview">
                                        </div>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
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
        output.width = 400;
        output.height = 300;
        output.src = URL.createObjectURL(e.target.files[0]);
        }
    </script>