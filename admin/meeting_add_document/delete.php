<?php 
    $menu_active =2;
    $layout_title = "Welcome Dashboard";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
	if(@$_GET['del_id'] != ""){
		$del_id = @$_GET['del_id'];
		$file_name = @$_GET['file_name'];
		$connect->query("DELETE FROM tbl_meeting_document WHERE doc_id='$del_id'");
		if(file_exists('../../file/file_meeting_document/'.$file_name)){
            unlink('../../file/file_meeting_document/'.$file_name);
        }
	}
?>
<script type="text/javascript">
	window.location.replace("index.php");
</script>