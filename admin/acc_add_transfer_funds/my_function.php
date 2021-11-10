<?php 
	// include '../../config/database.php';
	include '../acc_my_operation/my_operation.php';
	include '../acc_chart_account/my_function.php';
 ?>
 <?php
 	function GetBalanceOfAccount($chart_id)
 	{
 		global $connect;
 		$sql_bal=$connect->query(getDataCur(date('Y-m-d'),date('Y-m-d'),$chart_id));
 		$row_bal=@mysqli_fetch_object($sql_bal);
	    $res_debit=@$row_bal->total_debit1+@$row_bal->total_debit2;
	    $res_credit=@$row_bal->total_credit1+@$row_bal->total_credit2;
	    $v_bal=calBalance($chart_id,$res_debit,$res_credit);
	    return number_format($v_bal,2);
 	}
  ?>