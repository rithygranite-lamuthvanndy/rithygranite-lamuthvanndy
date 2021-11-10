<?php 
    include_once '../../config/database.php';
?>

<?php 
	if(@$_GET['del_id'] != ""){
		$del_id = @$_GET['del_id'];
		$connect->query("DELETE FROM tbl_inv_block_to_cursed_detail WHERE parent_id='$del_id'");
		$connect->query("DELETE FROM tbl_inv_block_to_cursed WHERE id='$del_id'");
	}
?>