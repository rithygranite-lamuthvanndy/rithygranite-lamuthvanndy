<?php 
    include_once '../../config/database.php';
?>

<?php 
	$str=$_POST['myCheckboxes'];

	$arr=explode(",",$str);
	foreach ($arr as $key => $value) {
		if($value){
			$connect->query("DELETE FROM tbl_acc_none_settle_advance_detail WHERE main_id='$arr[$key]'");
			$connect->query("DELETE FROM tbl_acc_none_settle_advance WHERE id='$arr[$key]'");
		}
	}
?>