<?php 
    include_once '../../config/database.php';
?>

<?php 
	$str=$_POST['myCheckboxes'];

	$arr=explode(",",$str);
	foreach ($arr as $key => $value) {
		if($value){
			$connect->query("DELETE FROM tbl_acc_add_tran_dr_cr_detail WHERE detail_id='$arr[$key]'");
			$connect->query("DELETE FROM tbl_acc_add_tran_dr_cr WHERE id='$arr[$key]'");
		}
	}
?>