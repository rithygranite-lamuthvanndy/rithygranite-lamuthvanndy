<?php 
	include_once '../../config/database.php'
?>
 <?php 
 	if(isset($_POST['data'])){
 		$v_arr=explode(',', $_POST['data']);

 		$v_sql_update="UPDATE tbl_acc_request_form
 		SET req_opdl_id='$v_arr[1]' 
 		WHERE req_id='$v_arr[0]'";
 		if($connect->query($v_sql_update)){
 			echo $v_sql_update;
 		}
 	}

  ?>