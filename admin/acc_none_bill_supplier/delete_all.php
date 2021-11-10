<?php 
    include_once '../../config/database.php';
?>

<?php 
	$str=$_POST['myCheckboxes'];

	$arr=explode(",",$str);
	foreach ($arr as $key => $value) {
		if($value){
			$connect->query("DELETE FROM tbl_acc_none_bill_supp_detail WHERE none_bill_supp_id='$arr[$key]'");
			$connect->query("DELETE FROM tbl_acc_none_bill_supp WHERE id='$arr[$key]'");
		}
	}
?>