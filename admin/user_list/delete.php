<?php 
	include '../../config/database.php';
	include_once '../../config/athonication.php';

	if(@$_GET['del_id']!=""){
		$del_id = @$_GET['del_id'];
		$del_img = @$_GET['del_img'];

		$connect->query("DELETE FROM tbl_user WHERE user_id='$del_id'");
		if($del_img != "blank.png"){
			if(file_exists("../../img/img_user/".$del_img)){
				unlink("../../img/img_user/".$del_img);
			}
		}
	}
 ?>

 <script type="text/javascript">
 	window.location.assign("index.php")
 </script>