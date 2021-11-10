<?php include '../../config/database.php'; ?>
<?php 
	$d = @$_GET['d'];
	if($d == 'cbo_re_name'){
		echo '<option value="">=== Please Click and Choose ===</option>';
		$v_select = $connect->query("SELECT * FROM tbl_acc_request_name_list ORDER BY res_id ASC");
        while ($row_data = mysqli_fetch_object($v_select)) {
            echo '<option value="'.$row_data->res_id.'">'.$row_data->res_name.'</option>';
        }
	}else if($d == 'cbo_pos'){
		echo '<option value="">=== Please Click and Choose ===</option>';
		$v_select = $connect->query("SELECT * FROM tbl_acc_position ORDER BY po_id ASC");
        while ($row_data = mysqli_fetch_object($v_select)) {
            echo '<option value="'.$row_data->po_id.'">'.$row_data->po_name.'</option>';
        }
	}
	else if($d == 'p_item_name'){
		echo '<option value="">=== Please Click and Choose ===</option>';
		$v_select = $connect->query("SELECT * FROM tbl_acc_item ORDER BY accit_id DESC");
        while ($row_data = mysqli_fetch_object($v_select)) {
            echo '<option value="'.$row_data->accit_id.'">'.$row_data->accit_name.'</option>';
        }
	}
	else if($d == 'unit_name'){
		echo '<option value="">=== Please Click and Choose ===</option>';
		$v_select = $connect->query("SELECT * FROM tbl_acc_unit_list ORDER BY uni_id ASC");
        while ($row_data = mysqli_fetch_object($v_select)) {
            echo '<option value="'.$row_data->uni_id.'">'.$row_data->uni_name.'</option>';
        }
	}
	else if($d == 'cbo_check_by'){
		echo '<option value="">=== Please Click and Choose ===</option>';
		$v_select = $connect->query("SELECT * FROM tbl_acc_check_name_list ORDER BY chn_name ASC");
        while ($row_data = mysqli_fetch_object($v_select)) {
            echo '<option value="'.$row_data->chn_id.'">'.$row_data->chn_name.'</option>';
        }
	}
	else if($d == 'cbo_appro_by'){
		echo '<option value="">=== Please Click and Choose ===</option>';
        $v_select = $connect->query("SELECT * FROM tbl_acc_approved_name_list ORDER BY apn_name ASC");
        while ($row_data = mysqli_fetch_object($v_select)) {
            echo '<option value="'.$row_data->apn_id.'">'.$row_data->apn_name.'</option>';
        }
	}
	else if($d == 'cbo_pre_by'){
		echo '<option value="">=== Please Click and Choose ===</option>';
		$v_select = $connect->query("SELECT * FROM tbl_acc_prepare_name_list ORDER BY pren_id ASC");
        while ($row_data = mysqli_fetch_object($v_select)) {
            echo '<option value="'.$row_data->pren_id.'">'.$row_data->pren_name.'</option>';
        }
	}
	else if($d == 'cbo_dep'){
		echo '<option value="">=== Please Click and Choose ===</option>';
		$v_select=$connect->query("SELECT * FROM tbl_acc_department_list ORDER BY dep_name ASC");
        while ($row_select=mysqli_fetch_object($v_select)) {
            echo '<option value="'.$row_select->dep_id.'">'.$row_select->dep_name.'</option>';
        }
	}
	else if($d == 'cbo_type_of_req'){
		echo '<option value="">=== Please Click and Choose ===</option>';
		$v_select=$connect->query("SELECT * FROM tbl_acc_type_request_list ORDER BY typr_name ASC");
        while ($row_select=mysqli_fetch_object($v_select)) {
            echo '<option value="'.$row_select->typr_id.'">'.$row_select->typr_name.'</option>';
        }
	}

	else if($d == 'cbo_unit'){
		echo '<option value="">=== Please Click and Choose ===</option>';
		$v_select=$connect->query("SELECT * FROM tbl_acc_unit_list ORDER BY uni_id ASC");
        while ($row_select=mysqli_fetch_object($v_select)) {
            echo '<option value="'.$row_select->uni_id.'">'.$row_select->uni_name.'</option>';
        }
	}

	else if($d == 'cbo_track'){
		echo '<option value="">=== Please Click and Choose ===</option>';
		$v_select=$connect->query("SELECT * FROM tbl_st_track_machine_list ORDER BY id ASC");
        while ($row_select=mysqli_fetch_object($v_select)) {
            echo '<option value="'.$row_select->id.'">'.$row_select->name_vn.'</option>';
        }
	}
	

?>



