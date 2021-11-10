<?php include '../../config/database.php'; ?>
<?php 
if(isset($_GET['v_cus_id'])){
  $v_id=$_GET['v_cus_id'];
  $sql=$connect->query("SELECT * FROM tbl_cus_customer_info WHERE cussi_id='$v_id'");
  $row_result=mysqli_fetch_object($sql);
  @$myObj->cus_code=$row_result->cus_code;
  @$myObj->cus_address=$row_result->cussi_address;
  @$myObj->cus_phone=$row_result->cussi_phone;
  @$myObj->cus_email=$row_result->cussi_email;
  @$myJSON=json_encode($myObj);
  echo $myJSON;
}

?>



