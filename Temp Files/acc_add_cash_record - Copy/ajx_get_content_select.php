<?php include '../../config/database.php'; ?>
<?php 
	$d = @$_GET['d'];
	if($d == 'txt_description'){
		echo '<option value="">=== Please Click and Choose ===</option>';
		$sql=$connect->query("SELECT * FROM tbl_acc_decription ORDER BY des_name ASC");
        while ($row=mysqli_fetch_object($sql)) {
            echo '<option value="'.$row->des_id.'">'.$row->des_name.'</option>';
        }
	}
	else if($d == 'cbo_vou_id'){
		echo '<option value="">=== Please Click and Choose ===</option>';
		$sql=$connect->query("SELECT * FROM tbl_acc_voucher_type_list ORDER BY vot_code ASC");
        while ($row=mysqli_fetch_object($sql)) {
            echo '<option value="'.$row->vot_id.'">'.$row->vot_code.' :: '.$row->vot_name.'</option>';
       	}
	}
	else if($d == 'cbo_tran_type'){
		echo '<option value="">=== Please Click and Choose ===</option>';
		 $sql=$connect->query("SELECT * FROM tbl_acc_transaction_type_list ORDER BY trat_name ASC");
        while ($row=mysqli_fetch_object($sql)) {
            echo '<option value="'.$row->trat_id.'">'.$row->trat_name.'</option>';
        }
	}else if($d == 'cbo_cash_type'){
		echo '<option value="">=== Please Click and Choose ===</option>';
		$sql=$connect->query("SELECT * FROM tbl_acc_type_cash_bank ORDER BY name ASC");
	    while ($row=mysqli_fetch_object($sql)) {
	        echo '<option value="'.$row->id.'">'.$row->name.'</option>';
	    }
	}
?>



