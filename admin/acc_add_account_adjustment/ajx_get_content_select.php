<?php include '../../config/database.php'; ?>
<?php 
	if(@$_GET['v_acc_id']&&@$_GET['status']=='id'){
		$v_acc_id=$_GET['v_acc_id'];
		$v_select = $connect->query("SELECT accca_id,accca_account_name FROM tbl_acc_chart_account ORDER BY accca_account_name DESC");
	    while ($row_data = mysqli_fetch_object($v_select)) {
	    	if($v_acc_id==$row_data->accca_id)
	        	echo '<option selected value="'.$row_data->accca_id.'">'.$row_data->accca_account_name.'</option>';
	        else
	        	echo '<option value="'.$row_data->accca_id.'">'.$row_data->accca_account_name.'</option>';
	    }
	}
	else if(@$_GET['v_acc_id']&&@$_GET['status']=='name'){
		$v_acc_id=$_GET['v_acc_id'];
		$v_select = $connect->query("SELECT accca_id,accca_number FROM tbl_acc_chart_account ORDER BY accca_number DESC");
	    while ($row_data = mysqli_fetch_object($v_select)) {
	    	if($v_acc_id==$row_data->accca_id)
	        	echo '<option selected value="'.$row_data->accca_id.'">'.$row_data->accca_number.'</option>';
	        else
	        	echo '<option value="'.$row_data->accca_id.'">'.$row_data->accca_number.'</option>';
	    }
	}
	
?>



