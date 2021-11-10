
<?php include_once '../../config/database.php'; ?>
<?php 
$v_par=@$_GET['d'];
if($v_par=='cbo_main_menu'){
	echo '<option value="">=== Please Choose and Select ===</option>';
    $v_select = $connect->query("SELECT * FROM tbl_main_menu ORDER BY mm_index_order");
    while ($row_data = mysqli_fetch_object($v_select)) {
        echo '<option value="'.$row_data->mm_id.'">'.$row_data->mm_name.'</option>';
    }
}

 ?>