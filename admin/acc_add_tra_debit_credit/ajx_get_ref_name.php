<?php include '../../config/database.php'; ?>
<?php 
if(isset($_GET['p_type'])&&isset($_GET['p_id'])){
	$v_type_id=(int) @$_GET['p_type'];
	$v_id=$_GET['p_id'];
	$v_name="";
	switch ($v_type_id) {
	  	case 1://Add cash record voucher
	  		$sql=$connect->query("SELECT rec_from_id,rec_status 
	  			FROM tbl_acc_cash_record 
	  			WHERE accdr_id='$v_id'");
	  		$row=mysqli_fetch_object($sql);
	  		$v_status=$row->rec_status;
	  		$v_cus_id=$row->rec_from_id;
	  		if($v_status==1){//Received From
	  			$sql_name=$connect->query("SELECT cussi_name FROM tbl_cus_customer_info WHERE cussi_id='$v_cus_id'");
	  			$row_result=mysqli_fetch_object($sql_name);
	  			$v_name=@$row_result->cussi_name;
	  		}
	  		else if($v_status==2){//Other Received From
	  			$sql_name=$connect->query("SELECT name FROM tbl_acc_other_rec_from_list WHERE id='$v_cus_id'");
	  			$row_result=mysqli_fetch_object($sql_name);
	  			$v_name=@$row_result->name;
	  		}
	  		else if($v_status==3){//Pay to
	  			$sql_name=$connect->query("SELECT supsi_name FROM tbl_sup_supplier_info WHERE supsi_id='$v_cus_id'");
	  			$row_result=mysqli_fetch_object($sql_name);
	  			$v_name=@$row_result->supsi_name;
	  		}
	  		else if($v_status==4){//Other Pay to
	  			$sql_name=$connect->query("SELECT name FROM tbl_acc_other_pay_to_list WHERE id='$v_cus_id'");
	  			$row_result=mysqli_fetch_object($sql_name);
	  			$v_name=@$row_result->name;
	  		}
	  		break;
	  	case 2://Invoice Sale Revenue
	  		$sql=$connect->query("SELECT cussi_name 
	  			FROM tbl_acc_none_sale_revenue AS A 
	  			LEFT JOIN tbl_cus_customer_info AS B  ON A.cus_id=B.cussi_id
	  			WHERE id='$v_id'");
	  		$row_result=mysqli_fetch_object($sql);
  			$v_name=@$row_result->cussi_name;
	  		break;
	  	case 3://Bill Supplier
	  		$sql=$connect->query("SELECT supsi_name 
	  			FROM tbl_acc_none_bill_supp AS A 
	  			LEFT JOIN tbl_sup_supplier_info AS B ON A.supp_id=B.supsi_id
	  			WHERE id='$v_id'");
	  		$row_result=mysqli_fetch_object($sql);
  			$v_name=@$row_result->supsi_name;
	  		break;
	  	case 4://\Settle Advance
	  		$sql=$connect->query("SELECT name 
	  			FROM tbl_acc_none_settle_advance AS A 
	  			LEFT JOIN tbl_acc_other_rec_from_list AS B ON A.rec_from_id=B.id
	  			WHERE id='$v_id'");
	  		$row_result=mysqli_fetch_object($sql);
  			$v_name=@$row_result->name;
	  		break;
  	}
  	echo $v_name;
}

?>



