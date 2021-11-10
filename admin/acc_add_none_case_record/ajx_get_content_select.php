<?php include '../../config/database.php'; ?>
<?php 
	$d = @$_GET['d'];
	if($d == 'txt_description'){
		echo '<option value="">=== Please Click and Choose ===</option>';
		$sql=$connect->query("SELECT * FROM tbl_acc_decription ORDER BY des_name ASC");
        while ($row=mysqli_fetch_object($sql)) {
            echo '<option value="'.$row->des_id.'">'.$row->des_name.'</option>';
        }
	}

?>



