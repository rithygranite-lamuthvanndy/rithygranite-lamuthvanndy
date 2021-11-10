<?php
$host_name = 'localhost';
$database = '14systemsdemo2';
// $database = 'rithygranite_v1';
$user_name = 'phpmyadmin';
$password = 'Khmerboy@016';
$connect = new mysqli($host_name, $user_name, $password, $database);

if ($connect->connect_error) {
    die("Connection failed: " . mysqli_connect_error());
}else{
	// echo 'Connect Successfull';
	mysqli_set_charset($connect,"utf8");
	session_start();
	ob_start();
	date_default_timezone_set("Asia/Bangkok");
	mysqli_query($connect, "SET SESSION sql_mode = ''");

	error_reporting(E_ALL);
    ini_set("display_errors", 1);
    ini_set('max_execution_time', 300); //300 seconds = 5 minutes
}
?>

