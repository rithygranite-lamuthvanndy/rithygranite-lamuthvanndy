<?php include_once '../../config/database.php'; ?>
<?php 
	if($_GET['status']=="code"){
		$v_item_id=$_GET['v_item_id'];
		$sql=$connect->query("SELECT stpron_id,stpron_name_kh FROM tbl_st_product_name");
		echo '<option value="">=== Please Choose and Select ===a</option>';
		while ($row_item=mysqli_fetch_object($sql)) {
		    if($row_item->stpron_id==$v_item_id)
		    	echo '<option selected value="'.$row_item->stpron_id.'">'.$row_item->stpron_name_kh.'</option>';
		    else
		    	echo '<option value="'.$row_item->stpron_id.'">'.$row_item->stpron_name_kh.'</option>';
		}
	}
	else if($_GET['status']=="name"){
		$v_item_id=$_GET['v_item_id'];
		$sql=$connect->query("SELECT stpron_id,stpron_code FROM tbl_st_product_name");
		echo '<option value="">=== Please Choose and Select===b</option>';
		while ($row_item=mysqli_fetch_object($sql)) {
		    if($row_item->stpron_id==$v_item_id)
		    	echo '<option selected value="'.$row_item->stpron_id.'">'.$row_item->stpron_code.'</option>';
		    else
		    	echo '<option value="'.$row_item->stpron_id.'">'.$row_item->stpron_code.'</option>';
		}
	}
 ?>