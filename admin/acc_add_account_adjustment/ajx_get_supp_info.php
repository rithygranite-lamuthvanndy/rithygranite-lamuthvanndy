<?php include '../../config/database.php'; ?>
<?php 
if(isset($_GET['v_sup_id'])){
  $v_id=$_GET['v_sup_id'];
  $sql=$connect->query("SELECT * FROM tbl_sup_supplier_info WHERE supsi_id='$v_id'");
  $row_result=mysqli_fetch_object($sql);
  @$myObj->sup_address=$row_result->supsi_address;
  @$myObj->sup_phone=$row_result->supsi_phone;
  @$myJSON=json_encode($myObj);
  echo $myJSON;
}

?>



