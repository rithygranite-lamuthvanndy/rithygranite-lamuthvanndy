<?php 
    include_once '../../config/database.php';
    include_once '../layout/header_frame.php';
?>
<style type="text/css">
    .dz-message{
     text-align: center;
     font-size: 28px;
    }
    .dz-remove{
        background-color: red;
        padding: 2px;
        color: white;
    }
</style>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-plus-circle fa-fw"></i>Upload Fix Asset Image</h2>
        </div>
    </div>
    <div class="portlet-body">
        <div class="panel panel-primary" style="height: 70%;">
            <div class="panel-heading">
                <h3 class="panel-title">Input Information</h3>
            </div>
            <div class="panel-body">
             	<form action="save_photo.php" class="dropzone">
                    <input type="hidden" name="txt_id" value="<?= $_GET['fl_id'] ?>">
                </form>
                <center>
                    <button type="submit" id='uploadfiles' form="myDropzone" class="btn btn-primary">Upload</button>
                </center>
            </div>
        </div>
    </div>
</div>
<?php 
    include_once '../layout/footer_frame.php';
?>
<script type="text/javascript">
    Dropzone.autoDiscover = false;

    var myDropzone = new Dropzone(".dropzone", { 
       autoProcessQueue: false,
       acceptedFiles: "image/jpeg,image/png,image/gif",
       addRemoveLinks: true,
       parallelUploads: 1 // Number of files process at a time (default 2)

    });

    $('#uploadfiles').click(function(){
       myDropzone.processQueue();
    });
</script>