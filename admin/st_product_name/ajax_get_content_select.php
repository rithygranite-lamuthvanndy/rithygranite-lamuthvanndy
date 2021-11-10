<?php include_once('../../config/database.php') ?>
<?php 
if(isset($_GET['status'])){
	$d = @$_GET['status'];
	echo $d;
	if($d=='st_unit_list'){
		echo '<option value="">=== Select and choose===</option>';
		$get_select=$connect->query("SELECT * FROM tbl_st_unit_list ORDER BY stun_name ASC");
        while($row_data = mysqli_fetch_object($get_select)){
            echo '<option value="'.$row_data->stun_id.'">'.$row_data->stun_name.'</option>';
        }
	}
}
else if(@$_GET['cbo_category']AND@$_GET['p_materail_type_id']){
	$v_material_type_id=@$_GET['p_materail_type_id'];
	echo '<option value="">=== Select and choose===</option>';
	$get_select=$connect->query("SELECT * 
								FROM tbl_st_category_list 
								WHERE material_type_id='$v_material_type_id'
								ORDER BY stca_name ASC");
    while($row_data = mysqli_fetch_object($get_select)){
        echo '<option value="'.$row_data->stca_id.'">'.$row_data->stca_name.'</option>';
    }
}
else if(@$_GET['cbo_pro_type']AND@$_GET['p_materail_type_id']){
	$v_material_type_id=@$_GET['p_materail_type_id'];
	echo '<option value="">=== Select and choose===</option>';
	$get_select=$connect->query("SELECT * 	
								FROM tbl_st_product_type_list 
								WHERE material_type_id='$v_material_type_id'
								ORDER BY name ASC");
	while($row_data = mysqli_fetch_object($get_select)){
	    echo '<option value="'.$row_data->id.'">'.$row_data->name.'</option>';
	}
}

 ?>