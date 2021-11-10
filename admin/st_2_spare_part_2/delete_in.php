<?php 
    $menu_active =2;
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
?>
<?php 


	if(@$_GET['del_id'] != ""){
		$del_id = @$_GET['del_id'];
		$connect->query("DELETE FROM tbl_st_stock_in WHERE stsin_id='$del_id'");
		$connect->query("DELETE FROM tbl_st_stock_in_detail WHERE stsin_id='$del_id'");
		$connect->query("DELETE FROM tbl_st_stock_out_detail WHERE in_id='$del_id'");
		$connect->query("DELETE FROM tbl_st_stock_out WHERE in_id='$del_id'");

		echo '<script type="text/javascript">
				window.location.replace("index.php");
			</script>';
	}
	if(@$_GET['del_detail_id'])
	{
		// $del_detail_id = @$_GET['del_detail_id'];
		// $id_in = explode('-', $del_detail_id);
		// $for_out = $id_in[1];
		// $for_in = $id_in[0];
		// $v_parent_id = @$_GET['parent_id'];
		// $connect->query("DELETE FROM tbl_st_stock_out_detail WHERE std_id='$for_out'");
		// // $connect->query("DELETE FROM tbl_st_stock_in WHERE stsin_id='$v_parent_id'");
		// $connect->query("DELETE FROM tbl_st_stock_in_detail WHERE std_id='$del_detail_id'");
		// $connect->query("DELETE FROM st_stock_out WHERE stsin_id='$v_parent_id'");
		// $v_sql_check="SELECT stsin_id FROM tbl_st_stock_in WHERE stsin_id='$v_parent_id'";
		// $v_sql_check="SELECT stsin_id FROM tbl_st_stock_in_detail WHERE stsin_id='$v_parent_id'";
		// if(!mysqli_num_rows($connect->query($v_sql_check))){
		// 	$connect->query("DELETE FROM tbl_st_stock_in WHERE stsin_id='$v_parent_id'");
		// 	$v_sql_check="SELECT stsin_id FROM tbl_st_stock_in WHERE stsin_id='$v_parent_id'";
		// 	$v_sql_check="SELECT stsin_id FROM tbl_st_stock_in_detail WHERE stsin_id='$v_parent_id'";
		// }
		//echo '<script type="text/javascript">
			// 	window.location.replace("index.php");
			// </script>';
	}
?>