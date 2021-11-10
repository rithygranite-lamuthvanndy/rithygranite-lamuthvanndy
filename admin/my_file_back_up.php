<?php
$host_name = 'localhost';
$database = 'back_up_database';
$user_name = 'root';
$password = '';
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

<!-- End Connection -->
<?php 
$sql=$connect->query("SELECT * FROM tbl_acc_cash_record ORDER BY accdr_id DESC");
while($row=mysqli_fetch_object($sql)){
	// echo $row->accdr_note.'<br>';
	$sql_1="UPDATE tbl_acc_cash_record SET 
	accdr_description=''
	WHERE accdr_id='$row->accdr_id'
	";
	$connect->query($sql_1);
}
echo 'Seccus';

 ?>