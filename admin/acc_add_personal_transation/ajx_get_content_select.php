<?php include '../../config/database.php'; ?>
<?php 
	$d = @$_GET['d'];
	if($d == 'txt_dir_tran_type'){
		echo '<option value="">=== Select and Choose here ===</option>';
		$sql=$connect->query("SELECT id,name FROM tbl_acc_director_tran_type ORDER BY name ASC");
        while ($row=mysqli_fetch_object($sql)) {
            echo '<option value="'.$row->id.'">'.$row->name.'</option>';
        }
	}
?>



