<?php include_once('../../config/database.php') ?>
<?php 
if(isset($_GET['status'])){
	$d = @$_GET['status'];
	if($d=='cbo_unit'){
		echo '<option value="">=== Select and choose===</option>';
		$get_select=$connect->query("SELECT * FROM tbl_st_unit ORDER BY stun_name ASC");
        while($row_data = mysqli_fetch_object($get_select)){
            echo '<option value="'.$row_data->stun_id.'">'.$row_data->stun_name.'</option>';
        }
	}
	else if($d=='txt_category'){
		echo '<option value="">=== Select and choose===</option>';
		$get_select=$connect->query("SELECT * FROM tbl_inv_category ORDER BY name ASC");
        while($row_data = mysqli_fetch_object($get_select)){
            echo '<option value="'.$row_data->id.'">'.$row_data->name.'</option>';
        }
	}
	else if($d=='cbo_inv_type'){
		echo '<option value="">=== Select and choose===</option>';
		$get_select=$connect->query("SELECT * FROM tbl_inv_pro_type ORDER BY name ASC");
        while($row_data = mysqli_fetch_object($get_select)){
            echo '<option value="'.$row_data->id.'">'.$row_data->name.'</option>';
        }
	}
}
 ?>