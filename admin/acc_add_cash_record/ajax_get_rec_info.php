<?php include_once '../../config/database.php'; ?>
<?php 
if(isset($_POST['data'])){
	$my_arr=explode(',', $_POST['data']);
	$v_status=(int)$my_arr[0];
	$v_id=$my_arr[1];
	switch ($v_status) {
		case 1://rec_From
			$sql=$connect->query("SELECT cussi_email,cussi_phone,cussi_address FROM tbl_cus_customer_info WHERE cussi_id='$v_id'");
			$row=mysqli_fetch_object($sql);
			$v_email=$row->cussi_email;
			$v_phone=$row->cussi_phone;
			$v_add=$row->cussi_address;
			break;
		case 2://Other Rec From 
			$sql=$connect->query("SELECT email,phone_number,address FROM tbl_acc_other_rec_from_list WHERE id='$v_id'");
			$row=mysqli_fetch_object($sql);
			$v_email=@$row->email;
			$v_phone=@$row->phone_number;
			$v_add=$row->address;
			break;
		case 3://Pay To
			$sql=$connect->query("SELECT supsi_email,supsi_phone,supsi_address FROM tbl_sup_supplier_info WHERE supsi_id='$v_id'");
			$row=mysqli_fetch_object($sql);
			$v_email=$row->supsi_email;
			$v_phone=$row->supsi_phone;
			$v_add=$row->supsi_address;
			break;
		case 4://Pay to Other
			$sql=$connect->query("SELECT email,phone_number,address FROM tbl_acc_other_pay_to_list WHERE id='$v_id'");
			$row=mysqli_fetch_object($sql);
			$v_email=$row->email;
			$v_phone=$row->phone_number;
			$v_add=$row->address;
			break;
	}
	@$myObj->email=$v_email;
	@$myObj->address=$v_add;
	@$myObj->phone=$v_phone;
  	@$myJSON=json_encode($myObj);
  	echo $myJSON;
}
 ?>