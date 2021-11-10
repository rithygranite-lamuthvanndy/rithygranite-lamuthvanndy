<?php 
	include_once '../../config/database.php';
 ?>
 <?php 
 	if(isset($_POST['data'])){
 		$arr=explode(',', $_POST['data']);

 		$v_update="UPDATE tbl_left_menu 
 		SET lm_index_order='$arr[1]' 
 		WHERE lm_id='$arr[0]'";
 		if($connect->query($v_update))
 			echo 'Success';
 	}

  ?>