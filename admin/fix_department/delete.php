<?php include_once '../../config/database.php'; ?>
<?php 
	if(@$_GET['del_id'] != ""){
		$del_id = @$_GET['del_id'];
		$connect->query("DELETE FROM tbl_fix_depart WHERE dep_id='$del_id'");
	}
?>
<?php 
	header('location: index.php'); 
?>