<?php 
    $menu_active =140;
    $left_active =0;
    $layout_title = "View Stock In";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
    if(isset($_GET['status'])){
        $v_status=$_GET['status'];
        $_SESSION['status']=$v_status;
    }
    if(@$_GET['action'])
    $_SESSION['action']=(@$_GET['action'])?:1;
 ?>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2> Stock Spare Part</h2>
        </div>
    </div>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="<?= (($_SESSION['action']==1)?'active':'') ?>">
            <a href='index.php?action=1'><i class="fa fa-bar-chart"></i> Summary</a>
        </li>
        <li role="presentation" class="<?= (($_SESSION['action']==2)?'active':'') ?>">
            
            <a href="index.php?action=2"><i class="fa fa-sign-in"></i> In</a>
        </li>
        <li role="presentation" class="<?= (($_SESSION['action']==3)?'active':'') ?>">
            <a href="index.php?action=3"><i class="fa fa-sign-in"></i> Out</a>
        </li>
        <li role="presentation" class="<?= (($_SESSION['action']==4)?'active':'') ?>">
            <a href="index.php?action=4"><i class="fa fa-pencil"></i> Adjustment</a>
        </li>
    </ul>   
    <?php 
        if(@$_SESSION['action']==1){
            include_once 'tab_summary.php';
        }
        else if(@$_SESSION['action']==2){
            include_once 'tab_in.php';
        }
        else if(@$_SESSION['action']==3){
            include_once 'tab_out.php';
        }
        else if(@$_SESSION['action']==4){
            include_once 'tab_adjustment.php';
        }
        $_SESSION['title']='Spare Part';
     ?>
</div>
<?php include_once '../layout/footer.php' ?>
<script type="text/javascript">
    function showInfo(e){
        document.getElementById('result_modal').src = 'more_info.php?parent='+e;
    }
</script>
<div class="modal fade" id="modal">
    <div class="modal-dialog" style="border: 1px solid darkred; width: 70%;">
        <iframe id="result_modal" frameborder="0" style="height: 600px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>

<style type="text/css">
    .dt-buttons {
        display: none;
    }
</style>