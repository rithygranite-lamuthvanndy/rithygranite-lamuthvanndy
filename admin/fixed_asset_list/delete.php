<?php include_once '../../config/database.php'; ?>
<?php 
	if(@$_GET['del_id'] != ""){
		$del_id = @$_GET['del_id'];
		$connect->query("DELETE FROM tbl_fix_asset_list WHERE fl_id='$del_id'");
	}
?>