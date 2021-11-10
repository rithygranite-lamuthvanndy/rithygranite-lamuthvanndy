<?php include '../../config/database.php'; ?>
<?php 
	if(@$_GET['v_acc_id']&&@$_GET['status']=='id'){
		$v_acc_id=$_GET['v_acc_id'];
		$v_select = $connect->query("SELECT empl_id,empl_salary FROM tbl_hr_employee_list ORDER BY empl_emloyee_kh DESC");
	    while ($row_data = mysqli_fetch_object($v_select)) {
	    	if($v_acc_id==$row_data->empl_id)
	        	echo '<option selected value="'.$row_data->empl_id.'">'.$row_data->empl_empl_salary.'</option>';
	        else
	        	echo '<option value="'.$row_data->empl_id.'">'.$row_data->empl_empl_salary.'</option>';
	    }
	}
	else if(@$_GET['v_acc_id']&&@$_GET['status']=='name'){
		$v_acc_id=$_GET['v_acc_id'];
		$v_select = $connect->query("SELECT empl_id,empl_emloyee_en,empl_empl_salary FROM tbl_hr_employee_list ORDER BY empl_emloyee_en DESC");
	    while ($row_data = mysqli_fetch_object($v_select)) {
	    	if($v_acc_id==$row_data->empl_id)
	        	echo '<option selected value="'.$row_data->empl_id.'">'.$row_data->empl_empl_salary.'</option>';
	        else
	        	echo '<option value="'.$row_data->empl_id.'">'.$row_data->empl_empl_salary.'</option>';
	    }
	}
	
?>



