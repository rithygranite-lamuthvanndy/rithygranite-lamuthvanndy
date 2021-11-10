<?php
$host_name = 'localhost';
$database = 'rithygranite';
$user_name = 'root';
$password = '';

 ?>
<?php
$dumpfile = $database . "_" . date("Y-m-d_H-i-s") . ".sql";
// '../mysql/bin/mysqldump.exe';
// passthru("C://xampp//mysql//bin//mysqldump --opt --host=$host_name --user=$user_name --password=$password $database > $dumpfile");
$v_path=getcwd().'//mysql//bin//mysqldump';

exec("$v_path --opt --host=$host_name --user=$user_name --password=$password $database > $dumpfile", $output, $return);
if(!$return){
	echo "PDF Created Successfully";
	echo "$dumpfile "; //passthru("tail -1 $dumpfile");
}else {
    echo "PDF not created";
}
$current_time=strtotime(date('Y-m-d'));

$nextWeek = $current_time + (7 * 24 * 60 * 60);
echo 'Next Week: '. date('Y-m-d',$nextWeek)."\n";
// echo getcwd();

// report - disable with // if not needed
// must look like "-- Dump completed on ..." 


?>