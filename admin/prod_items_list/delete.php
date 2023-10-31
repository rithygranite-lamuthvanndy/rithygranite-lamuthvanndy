<?php include_once '../../config/database.php'; ?>
<?php 
	if(@$_GET['del_id'] != ""){
		$del_id = @$_GET['del_id'];
		$connect->query("DELETE FROM  tbl_items_type_list WHERE tit_id='$del_id'");
	}
?>