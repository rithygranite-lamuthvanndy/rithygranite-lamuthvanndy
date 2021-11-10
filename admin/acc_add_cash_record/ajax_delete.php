<?php include_once '../../config/database.php'; ?>
<?php 
if (isset($_GET['del_id'])) {
	$v_id=$_GET['del_id'];
	$connect->query("DELETE FROM tbl_acc_cash_record_detail WHERE detail_id='$v_id'");
}
else if(@$_GET['p_status']=='replace'){
	$v_parent_id=$_SESSION['parent_id'];
	$connect->query("DELETE FROM tbl_acc_cash_record WHERE accdr_id='$v_parent_id'");
	$connect->query("DELETE FROM tbl_acc_cash_record_detail WHERE cash_rec_id='$v_parent_id'");
}

 ?>