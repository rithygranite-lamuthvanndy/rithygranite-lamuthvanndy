<?php include '../../config/database.php'; ?>
<?php 
	$d = @$_GET['status'];
	if($d == 're_pro_name'){
		echo '<option value="">=== Please Choose and Select ===</option>';
		$v_select = $connect->query("SELECT stpron_id,stpron_code,stpron_name_vn,stpron_name_kh FROM tbl_st_product_name  WHERE stpron_material_type='$_SESSION[status]' ORDER BY stpron_code DESC");
        while ($row_data = mysqli_fetch_object($v_select)) {
            echo '<option value="'.$row_data->stpron_id.'" data_pro_code='.$row_data->stpron_code.'>['.$row_data->stpron_name_vn.'] '.$row_data->stpron_name_vn.' == '.$row_data->stpron_name_kh.'</option>';
        }
	}
?>



