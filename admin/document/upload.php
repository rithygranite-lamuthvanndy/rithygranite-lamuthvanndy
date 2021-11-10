<?php
include_once '../../config/database.php';
include_once '../layout/header_frame.php';
?>
<style type="text/css">
    .dz-message {
        text-align: center;
        font-size: 28px;
    }

    .dz-remove {
        background-color: red;
        padding: 2px;
        color: white;
    }
</style>
<div class="portlet light bordered">
    <div class="portlet-body">
        <div class="panel panel-primary" style="height: 70%;">
            <div class="panel-heading">
                <h3 class="panel-title">Input Information</h3>
            </div>
            <div class="panel-body">
                <form action="ajx_operation.php" class="dropzone">
                    <input type="hidden" name="txt_id" value="<?= $_GET['child_id'] ?>">
                    <input type="hidden" name="txt_department" value="<?= $_GET['dep'] ?>">
                </form>
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
        //    acceptedFiles: "*.*",
        maxFilesize: 2,
        maxFiles: 10,
        acceptedFiles: "image/*,application/pdf"
        addRemoveLinks: false
        //    parallelUploads: 1 // Number of files process at a time (default 2)

    });

    $('#uploadfiles').click(function() {
        myDropzone.processQueue();
    });
</script>