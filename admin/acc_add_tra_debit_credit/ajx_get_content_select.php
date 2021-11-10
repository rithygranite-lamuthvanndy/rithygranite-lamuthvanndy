<?php include '../../config/database.php'; ?>
<?php 
	if(isset($_GET['p_type_id'])){
		$v_type_id=(int) $_GET['p_type_id'];
		switch ($v_type_id) {
			case '1'://Ajustment Record
				$sql=$connect->query("SELECT id AS id,entry_no AS entry_no
					FROM tbl_acc_rec_adjustment
					WHERE id NOT IN 
					(SELECT id FROM tbl_acc_add_tran_dr_cr WHERE status_type='$v_type_id')");
				break;
			case '2'://Stock and Inventory
				$sql=$connect->query("SELECT id AS id,entry_no AS entry_no
					FROM tbl_acc_rec_stock_inventory
					WHERE id NOT IN 
					(SELECT id FROM tbl_acc_add_tran_dr_cr WHERE status_type='$v_type_id')");
				break;
			case '3'://Tranfer Funds
				$sql=$connect->query("SELECT id AS id,tran_ref_no AS entry_no
					FROM tbl_acc_add_transfer_fund A 
					WHERE id NOT IN 
					(SELECT id FROM tbl_acc_add_tran_dr_cr WHERE status_type='$v_type_id') 
					GROUP BY A.tran_ref_no");
				break;
		}
		echo '<option value="">=== Select and Choose ===</option>';
		while (@$row_select=mysqli_fetch_object(@$sql)) {
		    echo '<option value="'.$row_select->id.'">'.$row_select->entry_no.'</option>';   
		}
	}
	else if(isset($_GET['v_acc_id'])){
		$v_acc_id=$_GET['v_acc_id'];
		$v_select = $connect->query("SELECT accca_id,accca_account_name FROM tbl_acc_chart_account");
        while ($row_data = mysqli_fetch_object($v_select)) {
        	if($row_data->accca_id==$v_acc_id)
            	echo '<option selected value="'.$row_data->accca_id.'">'.$row_data->accca_account_name.'</option>';
            else
            	echo '<option value="'.$row_data->accca_id.'">'.$row_data->accca_account_name.'</option>';
        }
	}
	else if(isset($_GET['v_acc_id_name'])){
		$v_acc_id=$_GET['v_acc_id_name'];
		$v_select = $connect->query("SELECT accca_id,accca_account_name,accca_number FROM tbl_acc_chart_account");
        while ($row_data = mysqli_fetch_object($v_select)) {
        	if($row_data->accca_id==$v_acc_id)
            	echo '<option selected value="'.$row_data->accca_id.'">'.$row_data->accca_number.'</option>';
            else
            	echo '<option value="'.$row_data->accca_id.'">'.$row_data->accca_number.'</option>';
        }
	}

?>



