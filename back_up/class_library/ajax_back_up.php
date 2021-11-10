<?php include_once '../../config/database.php'; ?>
<?php include_once '../../back_up/class_library/back_up_code.php'; ?>
<?php 
	echo backup_database($connect,"*");
 ?>