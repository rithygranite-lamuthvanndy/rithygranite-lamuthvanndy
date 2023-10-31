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
else if($_POST['data']){
    $v_data=@$_POST['data'];
    $v_arr=explode(',', $v_data);
    $v_sql1="SELECT * FROM 
        tbl_inv_block_from_mine_detail 
        WHERE id NOT IN (SELECT bfm_detail_id FROM tbl_inv_block_to_cursed_detail) ";
    $v_sql3=" ORDER BY block_code";
    $sql2="";
    foreach ($v_arr as $value) {
        if($value){
            $sql2.="AND id <> '$value' ";
        }
    }
    $sql_result=$v_sql1.$sql2.$v_sql3;
    // echo $sql_result;
    $v_select = $connect->query($sql_result);
    echo '<option value="">=== select ===</option>';
    while ($row_data = mysqli_fetch_object($v_select)) {
        echo '<option value="'.$row_data->id.'">'.$row_data->block_code.'</option>';
    }
}

 ?>