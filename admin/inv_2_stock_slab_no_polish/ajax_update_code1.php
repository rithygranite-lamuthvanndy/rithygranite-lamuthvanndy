<?php 
	include_once '../../config/database.php';
 ?>
 <?php 
 	if(isset($_POST['data1'])){
 		$arr=explode(',', $_POST['data1']);

 		$v_update="UPDATE tbl_inv_2_stock_slap_no_polish_detail 
 		SET ns_make_to='$arr[1]' 
 		WHERE id='$arr[0]'";
 		if($connect->query($v_update))
 			echo 'Success';
 	}

  ?>