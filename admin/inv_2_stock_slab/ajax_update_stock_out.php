<?php 
	include_once '../../config/database.php'
 ?>
 <?php 
 	if(isset($_POST['data'])){
 		$v_arr=explode(',', $_POST['data']);

 		$v_sql_update="UPDATE tbl_inv_2_stock_slap_no_polish_detail
 		SET stock_out_status='$v_arr[1]' 
 		WHERE id='$v_arr[0]'";
 		if($connect->query($v_sql_update)){
 			echo $v_sql_update;
 		}
 	}

  ?>