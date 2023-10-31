<?php include '../../config/database.php'; ?>
<?php 
	$d = @$_GET['d'];
	
	if($d == 'txt_month_year'){
		echo '<option value="">=== Please Click and Choose ===</option>';
		$v_select = $connect->query("SELECT * FROM tbl_acc_month_year ORDER BY accmy_name ASC");
        while ($row_data = mysqli_fetch_object($v_select)) {
            echo '<option value="'.$row_data->accmy_id.'">'.$row_data->accmy_name.'</option>';
        }
	}
	else if($d == 'txt_inv_no'){
		echo '<option value="">=== Please Click and Choose ===</option>';
		$v_select = $connect->query("SELECT accdr_id,accdr_voucher_no,accdr_name FROM tbl_acc_cash_record 
	        WHERE accdr_id NOT IN (SELECT accad_cash_rec_id FROM tbl_acc_add_transaction)
	     	ORDER BY accdr_voucher_no DESC");
	    while ($row_data = mysqli_fetch_object($v_select)) {
	        echo '<option value="'.$row_data->accdr_id.'">'.$row_data->accdr_voucher_no.' :: '.$row_data->accdr_name.'</option>';
	    }
	}
?>



