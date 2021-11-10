<?php 
    $menu_active =2;
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
?>
<?php 
	if(@$_GET['del_id'] != ""){
		$del_id = @$_GET['del_id'];
		$connect->query("DELETE FROM tbl_st_stock_adjustment WHERE stsadj_id='$del_id'");
		$connect->query("DELETE FROM tbl_st_stock_adjustment_detail WHERE stsadj_id='$del_id'");
	}
	if(@$_GET['del_detail_id']){
		$del_detail_id = @$_GET['del_detail_id'];
		$v_parent_id = @$_GET['parent_id'];
		$connect->query("DELETE FROM tbl_st_stock_adjustment_detail WHERE id='$del_detail_id'");
		$v_sql_check="SELECT stsadj_id FROM tbl_st_stock_adjustment_detail WHERE stsadj_id='$v_parent_id'";
		if(!mysqli_num_rows($connect->query($v_sql_check))){
			$connect->query("DELETE FROM tbl_st_stock_adjustment WHERE stsadj_id='$v_parent_id'");
		}
		echo '<script type="text/javascript">
				window.location.replace("index.php");
			</script>';
	}
?>