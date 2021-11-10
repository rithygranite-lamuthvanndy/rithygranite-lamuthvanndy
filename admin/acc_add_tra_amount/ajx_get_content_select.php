<?php include '../../config/database.php'; ?>
<?php 
	if(isset($_GET['p_type_id'])){
		$v_type_id=(int) $_GET['p_type_id'];
		switch ($v_type_id) {
			case '1'://Add Cash record voucher
				$sql=$connect->query("SELECT accdr_id AS id,accdr_voucher_no AS entry_no
					FROM tbl_acc_cash_record
					WHERE accdr_id NOT IN 
					(SELECT ref_id FROM tbl_acc_add_tran_amount WHERE status_type='$v_type_id')");
				break;
			case '2'://IV Sale Revenue
				$sql=$connect->query("SELECT id AS id,inv_no AS entry_no
					FROM tbl_acc_none_sale_revenue
					WHERE id NOT IN 
					(SELECT ref_id FROM tbl_acc_add_tran_amount WHERE status_type='$v_type_id')");
				break;
			case '3'://Bill Supplier
				$sql=$connect->query("SELECT id AS id,inv_no AS entry_no
					FROM tbl_acc_none_bill_supp
					WHERE id NOT IN 
					(SELECT ref_id FROM tbl_acc_add_tran_amount WHERE status_type='$v_type_id')");
				break;
			case '4'://Sale AV
				$sql=$connect->query("SELECT id AS id,entry_no AS entry_no
					FROM tbl_acc_none_settle_advance
					WHERE id NOT IN 
					(SELECT ref_id FROM tbl_acc_add_tran_amount WHERE status_type='$v_type_id')");
				break;
			case '5'://Transfer Funds
				$sql=$connect->query("SELECT id AS id,tran_ref_no AS entry_no
					FROM tbl_acc_add_transfer_fund
					WHERE (id OR parent_id) NOT IN 
					(SELECT ref_id FROM tbl_acc_add_tran_amount WHERE status_type='$v_type_id')
					GROUP BY tran_ref_no");
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



