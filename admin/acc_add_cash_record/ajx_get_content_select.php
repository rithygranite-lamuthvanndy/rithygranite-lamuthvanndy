<?php include '../../config/database.php'; ?>
<?php 
	if(isset($_GET['d'])){
		$d = @$_GET['d'];
		if($d == 'txt_description'){
			echo '<option value="">=== Please Click and Choose ===</option>';
			$sql=$connect->query("SELECT des_id,des_name FROM tbl_acc_decription ORDER BY des_name ASC");
	        while ($row=mysqli_fetch_object($sql)) {
	            echo '<option value="'.$row->des_id.'">'.$row->des_name.'</option>';
	        }
		}
		else if($d == 'txt_rec_from'){
			echo '<option value="">=== Please Click and Choose ===</option>';
			$sql=$connect->query("SELECT id,name FROM tbl_acc_rec_from_list ORDER BY name ASC");
	       while ($row=mysqli_fetch_object($sql)) {
	            echo '<option value="'.$row->id.'">'.$row->name.' </option>';
	        }
		}
	}
	// ============================
	if(isset($_GET['status'])){
		$status_id=(int) @$_GET['status'];
		echo '<option value="">=== Please Click and Choose ===</option>';
		switch ($status_id) {
			case 1:
				$sql=$connect->query("SELECT cussi_id,cussi_name FROM tbl_cus_customer_info ORDER BY cussi_name ASC");
				while ($row=mysqli_fetch_object($sql)) 
	            	echo '<option value="'.$row->cussi_id.'">'.$row->cussi_name.' </option>';
				break;
			case 2:
				$sql=$connect->query("SELECT id,name FROM tbl_acc_other_rec_from_list ORDER BY name ASC");
		       	while ($row=mysqli_fetch_object($sql)) 
		            echo '<option value="'.$row->id.'">'.$row->name.' </option>';
				break;
			case 3:
				$sql=$connect->query("SELECT supsi_id,supsi_name FROM tbl_sup_supplier_info ORDER BY supsi_name ASC");
		       	while ($row=mysqli_fetch_object($sql)) 
		            echo '<option value="'.$row->supsi_id.'">'.$row->supsi_name.' </option>';
				break;
			case 4:
				$sql=$connect->query("SELECT id,name FROM tbl_acc_other_pay_to_list ORDER BY name ASC");
		       	while ($row=mysqli_fetch_object($sql)) 
		            echo '<option value="'.$row->id.'">'.$row->name.' </option>';
				break;
		}
	}
	// =====================================
	if(isset($_POST['data'])){
		$myArr=explode(',',$_POST['data']);
		$sql_old_data=$connect->query("SELECT rec_from_id FROM tbl_acc_cash_record WHERE accdr_id='$myArr[1]'");
		$row_old_data=mysqli_fetch_object($sql_old_data);
		if($myArr[0]==0){
			echo '<option value="">=== Please Click and Choose ===</option>';
			$sql=$connect->query("SELECT cussi_id,cussi_name FROM tbl_cus_customer_info ORDER BY cussi_name ASC");
	       	while ($row=mysqli_fetch_object($sql)) {
	       		if($row_old_data->rec_from_id==$row->cussi_id)
	            	echo '<option SELECTED value="'.$row->cussi_id.'">'.$row->cussi_name.' </option>';
	            else 
	            	echo '<option value="'.$row->cussi_id.'">'.$row->cussi_name.' </option>';
	        }
		}
		else if($myArr[0]==1){
			echo '<option value="">=== Please Click and Choose ===</option>';
			$sql=$connect->query("SELECT supsi_id,supsi_name FROM tbl_sup_supplier_info ORDER BY supsi_name ASC");
	       	while ($row=mysqli_fetch_object($sql)) {
	       		if($row_old_data->rec_from_id==$row->supsi_id)
	            	echo '<option SELECTED value="'.$row->supsi_id.'">'.$row->supsi_name.' </option>';
	            else 
	            	echo '<option value="'.$row->supsi_id.'">'.$row->supsi_name.' </option>';
	        }
		}
		else if($myArr[0]==2){
			echo '<option value="">=== Please Click and Choose ===</option>';
			$sql=$connect->query("SELECT id,name FROM tbl_acc_other ORDER BY name ASC");
	       	while ($row=mysqli_fetch_object($sql)) {
	       		if($row_old_data->rec_from_id==$row->id)
	            	echo '<option SELECTED value="'.$row->id.'">'.$row->name.' </option>';
	            else 
	            	echo '<option value="'.$row->id.'">'.$row->name.' </option>';
	        }
		}
	}
	//=====================
	if(isset($_POST['mainArr'])){
		$myArr=explode(",", $_POST['mainArr']);
		$status_id=$myArr[0];
		$v_old_id=$myArr[1];
		echo '<option value="">=== Please Click and Choose ===</option>';
		switch ($status_id) {
			case 1:
				$sql=$connect->query("SELECT cussi_id,cussi_name FROM tbl_cus_customer_info ORDER BY cussi_name ASC");
				while ($row=mysqli_fetch_object($sql)) 
					if($v_old_id==$row->cussi_id)
	            		echo '<option SELECTED value="'.$row->cussi_id.'">'.$row->cussi_name.' </option>';
	            	else
	            		echo '<option value="'.$row->cussi_id.'">'.$row->cussi_name.' </option>';
				break;
			case 2:
				$sql=$connect->query("SELECT id,name FROM tbl_acc_other_rec_from_list ORDER BY name ASC");
		       	while ($row=mysqli_fetch_object($sql)) 
		       		if($v_old_id==$row->id)
		            	echo '<option SELECTED value="'.$row->id.'">'.$row->name.' </option>';
		            else
		            	echo '<option value="'.$row->id.'">'.$row->name.' </option>';
				break;
			case 3:
				$sql=$connect->query("SELECT supsi_id,supsi_name FROM tbl_sup_supplier_info ORDER BY supsi_name ASC");
		       	while ($row=mysqli_fetch_object($sql)) 
		       		if($v_old_id==$row->supsi_id)
		            	echo '<option SELECTED value="'.$row->supsi_id.'">'.$row->supsi_name.' </option>';
		            else
		            	echo '<option value="'.$row->supsi_id.'">'.$row->supsi_name.' </option>';
				break;
			case 4:
				$sql=$connect->query("SELECT id,name FROM tbl_acc_other_pay_to_list ORDER BY name ASC");
		       	while ($row=mysqli_fetch_object($sql)) 
		       		if($v_old_id==$row->id)
		            	echo '<option SELECTED value="'.$row->id.'">'.$row->name.' </option>';
		            else
		            	echo '<option value="'.$row->id.'">'.$row->name.' </option>';
				break;
		}
	}
?>



