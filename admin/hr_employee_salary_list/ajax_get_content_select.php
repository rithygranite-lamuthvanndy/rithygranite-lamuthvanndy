<?php include_once('../../config/database.php'); ?>

<?php 
$v_status=@$_GET['d'];
if($v_status=='cbo_counter'){
	echo '<option>=== Select and Choose here ===</option>';
    $sql=$connect->query("SELECT * FROM tbl_inv_counter_list ORDER BY name ASC");
    while ($row=mysqli_fetch_object($sql)) {
        echo '<option value="'.$row->id.'">'.$row->name.'</option>';
    }
}
else if($v_status=='cbo_location'){
	echo '<option>=== Select and Choose here ===</option>';
    $v_select = $connect->query("SELECT * FROM tbl_inv_location_list ORDER BY name");
    while ($row_data = mysqli_fetch_object($v_select)) {
        echo '<option value="'.$row_data->id.'">'.$row_data->name.'</option>';
    }
}else if($v_status=='cbo_floor'){
	echo '<option>=== Select and Choose here ===</option>';
    $v_select = $connect->query("SELECT * FROM tbl_inv_floor_list ORDER BY name");
    while ($row_data = mysqli_fetch_object($v_select)) {
        echo '<option value="'.$row_data->id.'">'.$row_data->name.'</option>';
    }
}

 ?>