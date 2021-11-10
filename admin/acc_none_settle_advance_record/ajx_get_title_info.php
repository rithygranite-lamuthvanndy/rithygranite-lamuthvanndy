<?php include '../../config/database.php'; ?>
<?php 
if(isset($_GET['p_rec_id'])){
  $v_rec_id=$_GET['p_rec_id'];
  $sql=$connect->query("SELECT * FROM tbl_acc_other_rec_from_list WHERE id='$v_rec_id'");
  $row_result=mysqli_fetch_object($sql);
  @$myObj->rec_address=$row_result->address;
  @$myObj->rec_phone=$row_result->phone_number;
  @$myJSON=json_encode($myObj);
  echo $myJSON;
}

?>



