<?php 
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
?>


<?php 
	if(@$_GET['del_id'] != ""){
		$del_id = @$_GET['del_id'];
		$connect->query("DELETE FROM tbl_acc_pur_confirm WHERE pur_id='$del_id'");
	}
?>
<script type="text/javascript">
	window.location.replace("index.php");
</script>