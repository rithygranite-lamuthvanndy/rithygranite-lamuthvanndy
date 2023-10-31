<?php 
    $menu_active =2;
    include_once '../../config/database.php';
?>


<?php 
	if(@$_GET['del_id'] != ""){
		$del_id = @$_GET['del_id'];
		$connect->query("DELETE FROM tbl_acc_add_transaction_detail WHERE id='$del_id'");	}
?>
<script type="text/javascript">
	window.location.replace("index.php");
</script>