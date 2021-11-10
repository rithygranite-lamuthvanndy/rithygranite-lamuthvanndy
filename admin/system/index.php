<?php 
    $menu_active =6;
    $layout_title = "System Information";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-info-circle fa-fw"></i>System <?= @$_SESSION['user']->user_name ?></h2>
        </div>
    </div>
    
    <br>

    <div class="portlet-body">
        <img src="../../img/img_system/about.jpg" class="img-responsive img-thumbnail" width="100%" alt="Image">
    </div>
</div>






<?php include_once '../layout/footer.php' ?>
