<?php
// $host_name = 'localhost';
// $database = 'rithygranite';
// $user_name = 'root';
// $password = '';

$host_name = 'localhost';
$database = '14systems';
$user_name = 'phpmyadmin';
$password = 'Rithygroup@300';
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

