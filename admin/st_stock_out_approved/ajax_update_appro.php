<?php include '../../config/database.php'; ?>
<?php 
if(isset($_POST['myData'])){
	$json=json_decode($_POST['myData']);
	$v_user_id=$_SESSION['user']->user_id;
	foreach($json as $obj) {
		$status=($obj->v_view)?'1':'0';
		$v_main_id=$obj->v_man_id;
		$sql="UPDATE tbl_st_stock_out_detail SET 
			out_approved='$status',
			user_approved='$v_user_id'
			WHERE std_id='$v_main_id'";
		if(!$connect->query($sql)){
			continue;
		}
	}
}
 ?>
