<?php include_once '../../config/database.php'; ?>
<?php 
	if(@$_GET['del_id'] != ""){
		$del_id = @$_GET['del_id'];
		$connect->query("DELETE FROM tbl_st_category_list WHERE stca_id='$del_id'");
	}
?>