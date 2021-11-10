<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
    // $ds = "/"; $uploadFolder = '/profiles';     
    if (!empty($_FILES)) {         
        $tempFileName = $_FILES['file']['tmp_name'];       
        $destPath = "";   
        $fname=str_replace(" ", "", $_FILES['file']['name']);
        $destFile =  $destPath.$fname;    
        move_uploaded_file($tempFileName,$destFile);      
    } 
?>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Expense Type List</h2>
        </div>
    </div>
    <br>
    <div class="">
        <div class="caption font-dark">
            <a href="add.php" id="sample_editable_1_new" class="btn green"> Add New
                <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>
    <br>
    <div class="portlet-body">
        <form action="#" class="dropzone dropzone-file-area" id="my-dropzone" enctype="multipart/form-data" style="width: 500px; margin-top: 50px;">
            <h3 class="sbold">Drop files here or click to upload</h3>
        </form>
    </div>
</div>
<?php include_once '../layout/footer.php' ?>
