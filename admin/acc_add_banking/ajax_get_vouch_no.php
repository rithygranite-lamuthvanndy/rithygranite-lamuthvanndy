<?php include '../../config/database.php'; ?>
<?php 
	if(@$_GET['v_date']){
	    $v_date=@$_GET['v_date'];
	    $v_select = $connect->query("SELECT accdr_id,accdr_voucher_no FROM tbl_acc_cash_record 
	          WHERE DATE_FORMAT(accdr_date,'%Y-%m')='$v_date' AND accdr_id NOT IN (SELECT accad_cash_rec_id FROM tbl_acc_add_transaction)
	        ORDER BY accdr_voucher_no DESC");
	      while ($row_data = mysqli_fetch_object($v_select)) {
	          echo '<option value="'.$row_data->accdr_id.'">'.$row_data->accdr_voucher_no.'</option>';
	      }
  	}
?>
