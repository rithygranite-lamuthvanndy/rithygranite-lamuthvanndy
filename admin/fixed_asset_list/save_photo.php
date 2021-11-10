<?php 
	include_once '../../config/database.php';
 ?>
<?php
	$v_photo_id=$_POST['txt_id'];
	// Upload directory
	$target_dir = "../../img/img_fix_asset/";
	$v_sql="SELECT photo_id FROM tbl_fix_asset_list WHERE fl_id='$v_photo_id'";
	$row_old=mysqli_fetch_object($connect->query($v_sql));
	$v_old_image=$row_old->photo_id;
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
		if($v_photo_id)
	    	$v_sql_update=$connect->query("UPDATE tbl_fix_asset_list 
	                                    SET photo_id='$new_name'
	                                    WHERE fl_id='$v_photo_id'");
	   	else{
	   		$_SESSION['saved_image_name']=$new_name;
	   	}
	   	$add_ph = "INSERT INTO tbl_photos_list(
	   		photo_name
	   		) values (
	   		'$new_name')";
	    $connect->query("$add_ph");
	}

?>