<?php include_once '../../config/database.php'; ?>
<?php 
if(isset($_POST['data'])){

	$my_arr=explode(",", $_POST['data']);
	$v_id=$my_arr[1];
			$sql=$connect->query("SELECT * 

				FROM tbl_cus_customer_info AS A
				LEFT JOIN tbl_prod_add_po AS B ON B.po_customer = A.cussi_id
				LEFT JOIN tbl_prod_add_po_list AS C ON C.pol_po_id = A.po_id
				WHERE cussi_id='$v_id'");
			$row=mysqli_fetch_object($sql);
			$v_code=$row->cus_code;
			$v_email=$row->cussi_email;
			$v_phone=$row->cussi_phone;
			$v_add=$row->cussi_address;

	@$myObj->code=$v_code;
	@$myObj->email=$v_email;
	@$myObj->address=$v_add;
	@$myObj->phone=$v_phone;
  	@$myJSON=json_encode($myObj);
  	echo $myJSON;
}
?>