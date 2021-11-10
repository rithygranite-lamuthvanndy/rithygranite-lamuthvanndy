<?php 
    include_once '../../config/database.php';
?>

<?php 
	$str=$_POST['myCheckboxes'];
	$clup_name_id=$_POST['clup_name_id'];
	$arr=explode(",",$str);
	foreach ($arr as $key => $value) {
		if($value){

			 $query_add = "INSERT INTO  tbl_group_truck_items(
                group_id,
                truck_machin_id               
                ) 
            VALUES(
                '$clup_name_id',
                '$value'
                )";
    if ($connect->query($query_add)) {

        
    } else {
    	echo "Error Update";
    	exit();
        
    }
			//$connect->query("DELETE FROM tbl_acc_open_bal WHERE id='$arr[$key]'");
		}
	}
?>