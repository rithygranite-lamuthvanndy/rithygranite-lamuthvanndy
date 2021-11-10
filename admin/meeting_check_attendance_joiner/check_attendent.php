<?php 
    include_once '../../config/database.php';
?>

<?php 
	// if(@$_GET['check_id']&&@$_GET['meet_id']&&@$_GET['flag']){
		// $v_id = @$_GET['check_id'];
		$meet_id = @$_GET['meet_id'];
		$status=@$_GET['flag'];
		$sql="UPDATE tbl_meeting_add_joiner_name SET ajn_join='$status' WHERE ajn_id='$meet_id'";
		$connect->query($sql);
		echo $sql;
?>