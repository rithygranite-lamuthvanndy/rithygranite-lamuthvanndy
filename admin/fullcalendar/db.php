<?php
$conn = mysqli_connect("localhost","phpmyadmin","Khmerboy@016","14systemsdemo") ;

if (!$conn)
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>