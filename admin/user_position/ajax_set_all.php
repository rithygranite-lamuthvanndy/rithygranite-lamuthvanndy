<?php include_once '../../config/database.php'; ?>
<?php 
if(isset($_POST['view'])){
	$arr=explode(',', $_POST['view']);
	$status=$_POST['status'];
	// $connect->query("DELETE FROM tbl_permission WHERE p_position='$v_position' AND p_module='$v_module'");
	foreach ($arr as $value) {
		// $connect->query("INSERT INTO tbl_permission(p_position,p_module,p_view,p_add,p_edit,p_delete) VALUES('$v_position','$value','1','0','0','0')");
		$connect->query("UPDATE tbl_permission SET p_view='$status' WHERE p_module='$value'");
	}
}
else if($_POST['add']){
	$arr=explode(',', $_POST['add']);
	$status=$_POST['status'];
	foreach ($arr as $value) {
		$connect->query("UPDATE tbl_permission SET p_add='$status' WHERE p_module='$value'");
	}
}
else if($_POST['edit']){
	$arr=explode(',', $_POST['edit']);
	$status=$_POST['status'];
	foreach ($arr as $value) {
		$connect->query("UPDATE tbl_permission SET p_edit='$status' WHERE p_module='$value'");
	}
}
else if($_POST['delete']){
	$arr=explode(',', $_POST['delete']);
	$status=$_POST['status'];
	foreach ($arr as $value) {
		$connect->query("UPDATE tbl_permission SET p_delete='$status' WHERE p_module='$value'");
	}
}

 ?>
