<?php include '../../config/database.php'; ?>
<?php 
if(isset($_POST['data'])){
	$arr=explode(',', $_POST['data']);
	$v_id=$arr[0];$v_code=$arr[1];
	$sql="UPDATE tbl_acc_cash_record SET
	accdr_voucher_no ='$v_code'
	WHERE accdr_id='$v_id'";
	if($connect->query($sql))
		echo '1';
}
 ?>