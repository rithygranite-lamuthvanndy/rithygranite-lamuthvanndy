<?php 
    include_once '../../config/database.php';
?>

<?php 
	$str=$_POST['myCheckboxes'];

	$arr=explode(",",$str);
	foreach ($arr as $key => $value) {
		if($value){
			$connect->query("DELETE FROM tbl_acc_inv_revenue_detial WHERE id='$arr[$key]'");
			$connect->query("DELETE FROM tbl_inv_sale_revenue WHERE id='$arr[$key]'");
		}
	}
?>