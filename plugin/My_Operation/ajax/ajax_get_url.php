<?php 
	$file=fopen('url.txt', 'r');
	$data=fread($file, filesize("url.txt"));
	echo $data;
 ?>