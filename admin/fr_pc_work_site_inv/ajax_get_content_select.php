<?php include_once('../../config/database.php') ?>
<?php 

 if(isset($_GET['p_inv_code'])){
		$v_inv_id=@$_GET['p_inv_code'];
		$v_select = $connect->query("SELECT * FROM tbl_acc_reqw_item_ 
			WHERE reiw_numberw='$v_inv_id'
			ORDER BY reiw_description DESC");
		while ($row_data = mysqli_fetch_object($v_select)) {
			if($v_inv_id==$row_data->inv_pron_id)
	            echo '<option selected value="'.$row_data->reiw_id.'">'.$row_data->reiw_description.'</option>';
	        else
	            echo '<option value="'.$row_data->reiw_id.'">'.$row_data->reiw_description.'</option>';
        }
	}
 ?>