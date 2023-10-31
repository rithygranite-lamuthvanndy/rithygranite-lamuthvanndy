<?php 
    $menu_active =145;
    $dropdown=false;
    $left_menu_active=4;
    $layout_title = "Welcome Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';

    $stock_out_status=8;
?>
<?php 
if(isset($_POST['btn_search'])){
    $v_date_s = @$_POST['txt_date_start'];
    $v_date_e = @$_POST['txt_date_end'];
    // echo $v_date_s.'fff'.$v_date_e;
     $v_sql="SELECT A.*,
            SUM(length) AS total_length,
            SUM(width) AS total_width,
            SUM(height) AS total_height,
            C.name AS counter_name,
            D.user_name
            FROM tbl_inv_block_to_cursed AS A 
            LEFT JOIN tbl_inv_block_to_cursed_detail AS B ON A.id=B.parent_id
            LEFT JOIN tbl_inv_counter_list AS C ON A.counter_id=C.id
            LEFT JOIN tbl_user AS D ON A.user_id=D.user_id
            WHERE date_record BETWEEN'$v_date_s' AND '$v_date_e'
            GROUP BY B.parent_id";
    $get_data = $connect->query($v_sql);

}
else{
    $v_current = date('Y-m-d');
    $v_sql="SELECT A.*,
            SUM(length) AS total_length,
            SUM(width) AS total_width,
            SUM(height) AS total_height,
            C.name AS counter_name,
            D.user_name
            FROM tbl_inv_block_to_cursed AS A 
            LEFT JOIN tbl_inv_block_to_cursed_detail AS B ON A.id=B.parent_id
            LEFT JOIN tbl_inv_counter_list AS C ON A.counter_id=C.id
            LEFT JOIN tbl_user AS D ON A.user_id=D.user_id
            WHERE date_record='$v_current' 
            GROUP BY B.parent_id";
    $get_data = $connect->query($v_sql); 
    $v_old_amo=0;
}

 ?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2 style="font-family: 'Khmer OS Muol Light';"><i class="fa fa-fw fa-map-marker"></i> របាយការណ៍ថ្មស្លាបប៉ូលារួច ប្រចាំថ្ងៃក្នុងរោងចក្រ​ </h2>
        </div>
    </div>
    <br>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="<?= ((@$_GET['action']==1||@$_GET['action']=='')?'active':'') ?>">
            <a href='index.php?action=1'>Stock In</a>
        </li>
        <li role="presentation" class="<?= ((@$_GET['action']==2)?'active':'') ?>">
            <a href="index.php?action=2">Stock Out</a>
        </li>
    </ul>  
    <?php 
        if(@$_GET['action']==1||@$_GET['action']==''){
            include_once 'stock_in.php';
        }
        else if(@$_GET['action']==2){
            include_once 'stock_out.php';
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
    function set_iframe_out_type(e){
        document.getElementById('result_modal').src = 'more_info.php?parent_id='+e+'&type=out';
    }
     function set_iframe_more_info_in(e){
        document.getElementById('result_modal').src = '../inv_1_stock_block_stone/more_info.php?parent_id='+e+'&out_type='+<?= $stock_out_status ?>;
    }
    function set_iframe_more_info(e){
        document.getElementById('result_modal').src = 'more_info.php?parent_id='+e;
    }
    $('#modal').on('hidden.bs.modal', function () {
        location.reload();
    });
</script>
