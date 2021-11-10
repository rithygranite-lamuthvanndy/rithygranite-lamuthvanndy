<?php include '../../config/database.php'; ?>
<?php 
	$d = @$_GET['status'];
	if($d == 'des_name'){
		echo '<option value="">=== Please Choose and Select ===</option>';
		$v_select = $connect->query("SELECT des_id,des_name FROM tbl_acc_decription ORDER BY des_name DESC");
        while ($row_data = mysqli_fetch_object($v_select)) {
            echo '<option value="'.$row_data->des_id.'">'.$row_data->des_name.'</option>';
        }
	}

?>



