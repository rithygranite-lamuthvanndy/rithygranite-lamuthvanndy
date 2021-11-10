<?php include_once '../../config/database.php'; ?>
<?php 
	if(isset($_GET['des_code'])){//Key up of Descripiton Code
		$v_des_code=$_GET['des_code'];
		$sql_select=$connect->query("SELECT * FROM tbl_acc_decription WHERE des_code LIKE '$v_des_code'");
		if(mysqli_num_rows($sql_select)==1){
			$row_select=mysqli_fetch_object($sql_select);
			echo '<option SELECTED value="'.$row_select->des_id.'">'.$row_select->des_name.'</option>';
		}
		else if(mysqli_num_rows($sql_select)==null){
			$sql=$connect->query("SELECT * FROM tbl_acc_decription ORDER BY des_code ASC");
			echo '<option value="">=== Please Click and Choose ===</option>';
			while ($row_select_2=mysqli_fetch_object($sql)) {
			    echo '<option value="'.$row_select_2->des_id.'">'.$row_select_2->des_name.'</option>';
			}
		}
	}
	else if(isset($_GET['des_id'])){//Change Descrption Name
		$v_des_id=$_GET['des_id'];
		$sql=$connect->query("SELECT * FROM tbl_acc_decription WHERE des_id='$v_des_id'");
		$row_select=mysqli_fetch_object($sql);
		echo $row_select->des_code;
	}
 ?>