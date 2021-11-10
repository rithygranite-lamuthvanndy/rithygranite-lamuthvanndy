<?php
$host_name = 'localhost';
$database = 'newdayop_1802001';
$user_name = 'newdayop_cususer';
$password = 'zG-K+ms30xXy';
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

