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
		$connect->query("DELETE FROM tbl_doc_document WHERE docdoc_id='$del_id'");
		$sql=$connect->query("SELECT * FROM tbl_doc_attach_file WHERE docatt_document_id='$del_id'");
		while($row=mysqli_fetch_object($sql)){
	        if(file_exists('../../file/file_attatch_document/'.$row->docatt_attach)){
	            unlink('../../file/file_attatch_document/'.$row->docatt_attach);
	        }
		}
		$connect->query("DELETE FROM tbl_doc_attach_file WHERE docatt_document_id='$del_id'");
	}
?>
<script type="text/javascript">
	window.location.replace("index.php");
</script>