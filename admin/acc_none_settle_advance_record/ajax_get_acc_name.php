<?php include_once '../../config/database.php'; ?>
<?php 
	if(isset($_GET['v_acc_id'])){
		$v_acc_id=$_GET['v_acc_id'];
		$sql=$connect->query("SELECT accca_account_name FROM tbl_acc_chart_account WHERE accca_id='$v_acc_id'");
		$row_result=mysqli_fetch_object($sql);
		echo $row_result->accca_account_name;
	}
 ?>