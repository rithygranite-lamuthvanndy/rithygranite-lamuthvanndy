<?php include '../../config/database.php'; ?>
<?php 
if(isset($_POST['myData'])){
	$str=$_POST['myData'];
	$arr=explode(",",$str);
	$v_app=($arr[0]=='true')?'1':'0';
	$v_main_id=$arr[1];
	$sql="UPDATE tbl_acc_add_tran_dr_cr SET p_appr='$v_app' WHERE id='$v_main_id'";
	$connect->query($sql);
	// echo $v_app;
}
 ?>
