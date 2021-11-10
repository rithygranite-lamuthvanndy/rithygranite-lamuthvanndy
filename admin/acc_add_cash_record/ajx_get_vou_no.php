<?php include '../../config/database.php'; ?>
<?php 
  $data=@$_POST['data'];
  $json = json_decode($data);
  $cash_res_id=$json->cash_res_id;
  $vou_code=$json->vou_code;
  $v_date=$json->v_date;
  $vou_id=$json->vou_id;

  //Edit
  $sql="";
  if($cash_res_id){
    $v_date=date("Y",strtotime($v_date));
    //Check Old Voucher
    $sql=$connect->query("SELECT SUBSTR(accdr_voucher_no,13,4) AS old_data
      FROM tbl_acc_cash_record 
      WHERE accdr_id='$cash_res_id' 
      AND SUBSTR(accdr_voucher_no,4,2)='$vou_code' 
      AND DATE_FORMAT(accdr_date,'%Y')='$v_date'");
    if(mysqli_num_rows($sql)){
      $row_old_no=mysqli_fetch_object($sql);
      $new_last_code=$row_old_no->old_data;
    }
    else{
      $sql=$connect->query("SELECT COUNT(accdr_date) AS count FROM tbl_acc_cash_record 
      WHERE DATE_FORMAT(accdr_date,'%Y')='$v_date' 
      AND SUBSTR(accdr_voucher_no,4,2)='$vou_code'");
      $row_count=mysqli_fetch_object($sql);
      if($row_count->count){
        $new_last_code=$row_count->count-2;
      }
      else
        $new_last_code=1;
    }
  }
  //Add
  else{
    $v_date_clone_start=date("Y",strtotime($v_date));
    $sql_main=$connect->query("SELECT accdr_date AS max_date,accdr_date,SUBSTR(accdr_voucher_no,13,4) tmp_accdr_voucher_no,accdr_id
      FROM tbl_acc_cash_record AS A 
      LEFT JOIN tbl_acc_voucher_type_list AS B ON A.vou_type_id=B.vot_id
      WHERE DATE_FORMAT(accdr_date,'%Y')='$v_date_clone_start' AND vot_code='$vou_code'
      ORDER BY accdr_voucher_no DESC
      LIMIT 1
      ");
    $row_max=mysqli_fetch_object($sql_main);
    $tmp=@$row_max->tmp_accdr_voucher_no;
    if(@mysqli_num_rows($sql_main)<0){
      $new_last_code=1;
    }
    $new_last_code=(int) preg_replace('/[^0-9]/', '',$tmp)+1;
  }
  $v_voucher_no ='G02'.$vou_code.date("ymd",strtotime($v_date)).'-'.str_pad($new_last_code, 4, '0', STR_PAD_LEFT);
  @$myObj->vou_no=$v_voucher_no;
  @$myJSON=json_encode($myObj);
  echo $myJSON;
?>



