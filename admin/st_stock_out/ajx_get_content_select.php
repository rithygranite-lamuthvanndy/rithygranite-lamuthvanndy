<?php include '../../config/database.php'; ?>
<?php 
	$d = @$_GET['status'];
	if($d == 're_pro_name'){
		echo '<option value="">=== Please Choose and Select ===</option>';
		$v_select = $connect->query("SELECT stpron_id,stpron_code,stpron_name_vn,stpron_name_kh FROM tbl_st_product_name ORDER BY stpron_code DESC");
        while ($row_data = mysqli_fetch_object($v_select)) {
            echo '<option value="'.$row_data->stpron_id.'" data_pro_code='.$row_data->stpron_code.'>['.$row_data->stpron_name_vn.'] '.$row_data->stpron_name_vn.' == '.$row_data->stpron_name_kh.'</option>';
        }
	}

	if(@$_GET['status']=='st_employee_list'){
		echo '<option value="">=== Select and choose===</option>';
	    $get_select=$connect->query("SELECT * FROM tbl_hr_employee_list ORDER BY empl_emloyee_en ASC");
        while($row_data = mysqli_fetch_object($get_select)){
            echo '<option value="'.$row_data->empl_id.'"> [ '.$row_data->empl_card_id.' ] '.$row_data->empl_emloyee_en.'</option>';
        }
	}
?>



