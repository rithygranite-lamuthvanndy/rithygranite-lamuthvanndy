<?php include '../../config/database.php'; ?>
<?php 
	$d = @$_GET['status'];
	if($d == 'cbo_pro_name'){
		echo '<option value="">=== Please Choose and Select ===</option>';
		$v_select = $connect->query("SELECT inv_pron_id,inv_pron_name_en,inv_pron_code FROM tbl_inv_product_name ORDER BY inv_pron_name_en DESC");
	    while ($row_data = mysqli_fetch_object($v_select)) {
	        echo '<option value="'.$row_data->inv_pron_id.'">'.$row_data->inv_pron_code.'::'.$row_data->inv_pron_name_en.'</option>';
	    }
	}
	else if($d == 'cbo_pro_code'){
		echo '<option value="">=== Please Choose and Select ===</option>';
		$v_select = $connect->query("SELECT inv_pron_id,inv_pron_name_en,inv_pron_code FROM tbl_inv_product_name ORDER BY inv_pron_name_en DESC");
	    while ($row_data = mysqli_fetch_object($v_select)) {
            echo '<option data_id="'.$row_data->inv_pron_id.'" value="'.$row_data->inv_pron_code.'">'.$row_data->inv_pron_code.'</option>';
        }
	}
	else if($d == 'cbo_fea'){
		echo '<option value="">=== Please Choose and Select ===</option>';
		$v_select = $connect->query("SELECT id,name FROM tbl_inv_feature ORDER BY name DESC");
        while ($row_data = mysqli_fetch_object($v_select)) {
            echo '<option value="'.$row_data->id.'">'.$row_data->name.'</option>';
        }
	}
	else if(isset($_GET['p_inv_code'])){
		$v_inv_id=@$_GET['p_inv_code'];
		$v_select = $connect->query("SELECT inv_pron_id,inv_pron_name_en,inv_pron_code FROM tbl_inv_product_name ORDER BY inv_pron_name_en DESC");
		while ($row_data = mysqli_fetch_object($v_select)) {
			if($v_inv_id==$row_data->inv_pron_id)
	            echo '<option selected value="'.$row_data->inv_pron_id.'">'.$row_data->inv_pron_name_en.'</option>';
	        else
	            echo '<option value="'.$row_data->inv_pron_id.'">'.$row_data->inv_pron_name_en.'</option>';
        }
	}
	else if(isset($_GET['p_inv_name'])){
		$v_inv_id=@$_GET['p_inv_name'];
		$v_select = $connect->query("SELECT inv_pron_id,inv_pron_name_en,inv_pron_code FROM tbl_inv_product_name ORDER BY inv_pron_name_en DESC");
		while ($row_data = mysqli_fetch_object($v_select)) {
			if($v_inv_id==$row_data->inv_pron_id)
            	echo '<option selected data_id="'.$row_data->inv_pron_id.'" value="'.$row_data->inv_pron_code.'">'.$row_data->inv_pron_code.'</option>';
            else
            	echo '<option data_id="'.$row_data->inv_pron_id.'" value="'.$row_data->inv_pron_code.'">'.$row_data->inv_pron_code.'</option>';
        }
	}
?>



