<?php include_once '../../config/database.php'; ?>
<?php 
$sql1=$connect->query("SELECT * FROM tbl_acc_account_type_report");
$json1=array();	
while ($row1=mysqli_fetch_object($sql1)) {
	$sql2=$connect->query("SELECT A.* 
		FROM tbl_acc_chart_account AS A 
		LEFT JOIN tbl_acc_type_account AS B ON A.accca_account_type=B.accta_id
		WHERE type_report_id='$row1->tr_id'");
	$json2=array();
	while ($row2=mysqli_fetch_object($sql2)) {
	    $v_bus2=["",$row2->accca_account_name,"","","","","","","","",""];
		array_push($json1, $v_bus2);
	}
	$v_bus1=[$row1->tr_name,"","","","","","","","","",""];
	array_push($json1, $v_bus1);
}
$myJSON = json_encode($json1);
echo $myJSON;
 ?>