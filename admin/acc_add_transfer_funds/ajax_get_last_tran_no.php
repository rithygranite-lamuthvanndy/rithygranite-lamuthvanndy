<?php include_once '../../config/database.php'; ?>
<?php 
	$sql=$connect->query("SELECT COUNT(*) AS count FROM tbl_acc_add_transfer_fund");
	$row_result=mysqli_fetch_object($sql);
	$v_code='TF'.date('ymd').'-'.sprintf('%04d',$row_result->count+1);
	echo $v_code;
 ?>