<?php include '../../config/database.php'; ?>
<?php 
	$d = @$_GET['d'];
	if($d == 'id_item_name'){
		echo '<option value="">=== Please Click and Choose ===</option>';
		$v_select = $connect->query("SELECT * FROM tbl_acc_item ORDER BY accit_id DESC");
        while ($row_data = mysqli_fetch_object($v_select)) {
            echo '<option value="'.$row_data->accit_id.'">'.$row_data->accit_name.'</option>';
        }
	}else if($d == 'id_unit_name'){
		echo '<option value="">=== Please Click and Choose ===</option>';
		$v_select = $connect->query("SELECT * FROM tbl_acc_unit_list ORDER BY uni_id ASC");
        while ($row_data = mysqli_fetch_object($v_select)) {
            echo '<option value="'.$row_data->uni_id.'">'.$row_data->uni_name.'</option>';
        }
	}
?>



