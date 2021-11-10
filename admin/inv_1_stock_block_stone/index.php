<?php 
    $menu_active =145;
    $dropdown=false;
    $left_menu_active=1;
    $layout_title = "Welcome Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2 style="font-family: 'Khmer OS Muol Light';"><i class="fa fa-fw fa-map-marker"></i> របាយការណ៍ថ្មប្លុក ពីអណ្តូងរ៉ែ ចូលរោងចក្រ</h2>
        </div>
    </div>
    <br>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="<?= ((@$_GET['action']==1||@$_GET['action']=='')?'active':'') ?>">
            <a href='index.php?action=1'>ចូលរោងចក្រ</a>
        </li>
        <li role="presentation" class="<?= ((@$_GET['action']==2)?'active':'') ?>">
            <a href="index.php?action=2">ចេញយកទៅអារ</a>
        </li>
        <li role="presentation" class="<?= ((@$_GET['action']==3)?'active':'') ?>">
            <a href="index.php?action=3">របាយការណ៍ស្តុក</a>
        </li>
    </ul>   
    <br>

    <?php 
        if(@$_GET['action']==1||@$_GET['action']==''){
            include_once 'stock_in.php';
        }
        else if(@$_GET['action']==2){
            include_once 'stock_out.php';
        }
        else if(@$_GET['action']==3){
            include_once 'summary.php';
        }
     ?>
</div>
<?php include_once '../layout/footer.php' ?>
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-body">
                <iframe id="result_modal" src="" width="100%" style="min-height: 600px; resize: vertical;" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function set_iframe_more_info(e){
        document.getElementById('result_modal').src = 'more_info.php?parent_id='+e;
    }
    function set_iframe_out_type(e){
        document.getElementById('result_modal').src = 'more_info.php?parent_id='+e+'&type=out';
    }
    $('#modal').on('hidden.bs.modal', function () {
        location.reload();
    });
</script>
