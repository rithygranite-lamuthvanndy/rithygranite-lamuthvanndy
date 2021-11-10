<?php
    include_once '../../config/database.php';
?>


<?php 
	if(@$_GET['del_id'] != ""){
		$del_id = @$_GET['del_id'];
		$connect->query("DELETE FROM tbl_inv_product_name WHERE inv_pron_id='$del_id'");
	}
?>
<script type="text/javascript">
	window.location.replace("index.php");
</script>