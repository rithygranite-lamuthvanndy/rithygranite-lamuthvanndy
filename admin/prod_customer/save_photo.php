<?php 
	include_once '../../config/database.php';
 ?>
<?php
	$v_parent_id=$_POST['txt_id'];
	// Upload directory
	$target_dir = "../../img/img_empl/";
	$v_sql="SELECT cussi_photos FROM tbl_cus_customer_info WHERE cussi_id='$v_parent_id'";
	$row_old=mysqli_fetch_object($connect->query($v_sql));
	$v_old_image=$row_old->stpron_photo;
	if($v_old_image!='blank.png'){
	    if(file_exists($target_dir.$v_old_image)){
	        unlink($target_dir.$v_old_image);
	    }
	}
	// Upload file
	// $target_file = $target_dir . basename(@$_FILES["file"]["name"]);
	$v_image=@$_FILES["file"];
	$ext = pathinfo($v_image["name"], PATHINFO_EXTENSION);
	$new_name = date("Ymd")."_".rand(1111,9999).'.'.$ext;

	if(move_uploaded_file($v_image["tmp_name"], $target_dir.$new_name)) {
		if($v_parent_id)
	    	$v_sql_update=$connect->query("UPDATE tbl_cus_customer_info 
	                                    SET cussi_photos='$new_name'
	                                    WHERE cussi_id='$v_parent_id'
	                                    ");
	   	else{
	   		$_SESSION['saved_image_name']=$new_name;
	   	}
	}
?>