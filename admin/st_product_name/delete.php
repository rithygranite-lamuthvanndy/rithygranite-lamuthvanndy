<?php 
    $menu_active =2;
    $layout_title = "Welcome Dashboard";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
	if(@$_GET['del_id'] != ""){
		$del_id = @$_GET['del_id'];
		$target_dir = "../../img/img_stock/product_name/";
		$v_sql="SELECT stpron_photo FROM tbl_st_product_name WHERE stpron_id='$del_id'";
		$row_old=mysqli_fetch_object($connect->query($v_sql));
		$v_old_image=$row_old->stpron_photo;
		if($v_old_image!='blank.png'){
		    if(file_exists($target_dir.$v_old_image)){
		        unlink($target_dir.$v_old_image);
		    }
		}
		$connect->query("DELETE FROM tbl_st_product_name WHERE stpron_id='$del_id'");

	}
?>