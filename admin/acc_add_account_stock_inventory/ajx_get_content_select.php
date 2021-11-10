<?php include '../../config/database.php'; ?>
<?php 
	$d = @$_GET['status'];
	if($d == 'cbo_supp_name'){
		echo '<option value="">=== Please Choose and Select ===</option>';
		$sql=$connect->query("SELECT supsi_id,supsi_name FROM tbl_sup_supplier_info ORDER BY supsi_name");
        while ($row_select=mysqli_fetch_object($sql)) {
            echo '<option value="'.$row_select->supsi_id.'">'.$row_select->supsi_name.'</option>';   
        }
	}
	else if($d == 'cbo_item_no'){
		echo '<option value="">=== Please Choose and Select ===</option>';
		$v_select = $connect->query("SELECT stite_id,stite_code,stite_item_en FROM tbl_st_item_name ORDER BY stite_code DESC");
        while ($row_data = mysqli_fetch_object($v_select)) {
            echo '<option value="'.$row_data->stite_id.'">'.$row_data->stite_code.'</option>';
        }
	}

?>



