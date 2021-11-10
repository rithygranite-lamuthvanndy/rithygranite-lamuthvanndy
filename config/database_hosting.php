<?php
$host_name = 'localhost';
$database = 'newdayop_newdayos';
$user_name = 'newdayopensource';
$password = 'neAAA@@@123neAAA@@@123';
$connect = new mysqli($host_name, $user_name, $password, $database);

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}else{
	mysqli_set_charset($connect,"utf8");
	session_start();
	ob_start();
	date_default_timezone_set("Asia/Bangkok");
}
?>

