<?php include '../../config/database.php'; ?>
<?php 
	$d = @$_GET['d'];
	if($d == 'cbo_check'){
		echo '<option value="">=== Please Click and Choose ===</option>';
		$v_select = $connect->query("SELECT * FROM tbl_acc_check_name_list ORDER BY chn_name ASC");
        while ($row_data = mysqli_fetch_object($v_select)) {
            if($row_data->chn_id == @$row_old_data->st_check_by){
                echo '<option SELECTED value="'.$row_data->chn_id.'">'.$row_data->chn_name.'</option>';
            }else{
                echo '<option value="'.$row_data->chn_id.'">'.$row_data->chn_name.'</option>';

            }
        }
	}
?>



