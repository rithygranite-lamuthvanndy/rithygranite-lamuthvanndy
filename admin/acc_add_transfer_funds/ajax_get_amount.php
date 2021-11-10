<?php 
	include_once '../../config/database.php'; 
	include_once '../acc_chart_account/my_function.php'; 
	include '../acc_my_operation/my_operation.php';
?>
<?php 
if($_POST['data']){
	$arr=explode(",", $_POST['data']);
	$chart_acc_id=$arr[1];
	$sql_bal=$connect->query(getDataCur(date('Y-m-d'),date('Y-m-d'),$chart_acc_id));
                            // echo $sql_bal;
    $row_bal=mysqli_fetch_object($sql_bal);
    $res_debit=$row_bal->total_debit1+$row_bal->total_debit2;
    $res_credit=$row_bal->total_credit1+$row_bal->total_credit2;
    $v_bal=calBalance($chart_acc_id,$res_debit,$res_credit);
	echo @$v_bal;
}
 ?>