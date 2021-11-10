<?php include '../../config/database.php'; ?>
<?php 
if(isset($_POST['myData'])){
	$json=json_decode($_POST['myData']);
	foreach($json as $obj) {
		$status=($obj->v_view)?'1':'0';
		$v_main_id=$obj->v_man_id;
		$sql="UPDATE tbl_acc_add_tran_amount SET p_appr='$status' WHERE id='$v_main_id'";
		if(!$connect->query($sql)){
			continue;
		}
	}
}
 ?>
