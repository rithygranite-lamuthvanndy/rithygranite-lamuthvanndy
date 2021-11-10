<?php 
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
?>
<?php 
	if(@$_GET['del_id'] != ""){
		$del_id = @$_GET['del_id'];
		$connect->query("DELETE FROM tbl_st_stock_adjustment WHERE stsadj_id='$del_id'");
	}
?>