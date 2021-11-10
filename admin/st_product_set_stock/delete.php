<?php 
    $menu_active =2;
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
?>
<?php 
	if(@$_GET['del_id'] != ""){
		$del_id = @$_GET['del_id'];
		$connect->query("DELETE FROM tbl_st_product_set WHERE stpset_id='$del_id'");
		$connect->query("DELETE FROM tbl_st_product_set_detail WHERE stpset_detail_id='$del_id'");
	}
	if(@$_GET['del_detail_id']){
		$del_detail_id = @$_GET['del_detail_id'];
		$connect->query("DELETE FROM tbl_st_product_set_detail WHERE id='$del_detail_id'");
	}
?>