<?php 
    include_once '../../config/database.php';
?>

<?php 
	$str=$_POST['myCheckboxes'];

	$arr=explode(",",$str);
	foreach ($arr as $key => $value) {
		if($value){
			$connect->query("DELETE FROM tbl_acc_add_tran_amount_detail WHERE main_id='$arr[$key]'");
			$connect->query("DELETE FROM tbl_acc_add_tran_amount WHERE id='$arr[$key]'");
		}
	}
?>