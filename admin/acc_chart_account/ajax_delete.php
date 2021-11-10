<?php include_once '../../config/database.php'; ?>
<?php 
	if (isset($_POST['myAllId'])) {
		$arr=explode(",", $_POST['myAllId']);
		foreach ($arr as $value) {
			$tmp_str=substr($value, 0,3);
			$tmp_last_id=substr($value, 3,10);
			if($tmp_str=='ma_')
				$connect->query("DELETE FROM tbl_acc_main_account WHERE accma_id='$tmp_last_id'");
			else if($tmp_str=='su_'){
				$connect->query("DELETE FROM tbl_acc_chart_sub WHERE id='$tmp_last_id'");
			}
			else if($tmp_str=='de_')
				$connect->query("DELETE FROM tbl_acc_chart_account WHERE accca_id='$tmp_last_id'");
				echo 'detail';
		}
	}
 ?>