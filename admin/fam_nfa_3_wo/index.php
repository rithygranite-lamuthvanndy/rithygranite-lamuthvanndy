<?php 
    $menu_active =141;
    $left_active =0;
    $layout_title = "Non Fix Assets";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
    if(isset($_GET['status'])){
        $v_status=$_GET['status'];
        $_SESSION['status']=$v_status;
        if($v_status==1||$_SESSION['status']==1){
            $_SESSION['title']="Written_Off";
        }
        else if($v_status==2||$_SESSION['status']==2){
            $_SESSION['title']="View";
        }
        else if($v_status==3||$_SESSION['status']==3){
            $_SESSION['title']="Disposal";
        }
        $_SESSION['action']=1;
    }
    if(isset($_GET['action'])){
        $_SESSION['action']=@$_GET['action'];
    }
 ?>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2>Disposal / Write Off Asset</h2>
        </div>     
    </div>
    <div class="portlet-title">
        <div class="caption font-dark">
            <a href="../fix_asset_management/index.php" id="sample_editable_1_new" class="btn bg-maroon btn-flat"> 
                <i class="fa fa-arrow-left"></i>
                Back
            </a>
        </div>
    </div>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="<?= (($_SESSION['action']==1)?'active':'') ?>">
            <a href='index.php?action=1'><i class="fa fa-bar-chart"></i> Written Off</a>
        </li>
        <li role="presentation" class="<?= (($_SESSION['action']==2)?'active':'') ?>">
            <a href="index.php?action=2"><i class="fa fa-sign-in"></i> View</a>
        </li>
        <li role="presentation" class="<?= (($_SESSION['action']==3)?'active':'') ?>">
            <a href="index.php?action=3"><i class="fa fa-sign-in"></i> Disposal</a>
        </li>
    </ul>   
    <?php 
        if($_SESSION['action']==1){
            include_once 'tab_written_off.php';
        }
        else if($_SESSION['action']==2){
            include_once 'tab_view.php';
        }
        else if(@$_SESSION['action']==3){
            include_once 'tab_disposal.php';
        }
     ?>
</div>

<?php include_once '../layout/footer.php' ?>