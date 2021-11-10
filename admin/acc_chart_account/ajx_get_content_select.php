<?php include '../../config/database.php'; ?>
<?php 
	$d = @$_GET['d'];
	if($d == 'txt_type'){
		echo '<option value="">=== Please Click and Choose ===</option>';
		$v_select = $connect->query("SELECT * FROM tbl_acc_type_account ORDER BY accta_type_account ASC");
        while ($row_data = mysqli_fetch_object($v_select)) {
            echo '<option value="'.$row_data->accta_id.'">'.$row_data->accta_type_account.'</option>';
        }
	}
	else if($d == 'txt_sub_main'){
		echo '<option value="">=== Please Click and Choose ===</option>';
		$v_select = $connect->query("SELECT * FROM tbl_acc_chart_sub ORDER BY name ASC");
        while ($row_data = mysqli_fetch_object($v_select)) {
            $v_code=str_pad($row_data->code, 6,'*',STR_PAD_RIGHT);
            echo '<option value="'.$row_data->id.'">'.$v_code.' :: '.$row_data->name.'</option>';
        }
	}
?>



