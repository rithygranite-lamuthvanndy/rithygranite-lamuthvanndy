<?php include '../../config/database.php'; ?>
<?php 
	$id = @$_POST['pro_id'];
	
	$query = "SELECT * FROM tbl_st_product_name 
					 INNER JOIN tbl_st_unit_list 
					 ON tbl_st_unit_list.stun_id=tbl_st_product_name.stpron_unit

	WHERE stpron_id = ".$id." "; 
	
    $result = $connect->query($query); 
     
    // Generate HTML of city options list 
    if($result->num_rows > 0){ 
        // echo '<option value="">Select ឈ្មោះ/Tền first</option>'; 
        while($row = $result->fetch_assoc()){  
            echo '<option value="'.$row['stun_id'].'">'.$row['stun_name'].'</option>'; 
        } 
    }else{ 
        echo '<option value="">Select ឈ្មោះ/Tền  not available</option>'; 
    } 


?>



