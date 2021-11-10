<?php include_once '../../config/database.php'; ?>
<?php 
	if(isset($_GET['v_item_id'])){
		$v_item_id=$_GET['v_item_id'];
		$sql=$connect->query("SELECT stpron_name_en FROM tbl_st_product_name WHERE stpron_id='$v_item_id'");
		$row_item=mysqli_fetch_object($sql);
		echo $row_item->stpron_name_en;
	}
 ?>