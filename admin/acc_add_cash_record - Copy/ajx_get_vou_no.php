<?php include '../../config/database.php'; ?>
<?php 
if(@$_POST['data']){
  $data= @$_POST['data'];
  $arr=explode(',', $data);
  $cash_res_id=$arr[0];$vou_code=$arr[1];$v_date=$arr[2];$vou_id=$arr[3];

  //Edit
  if($cash_res_id){
    $sql_main=$connect->query("SELECT accdr_voucher_no
      FROM tbl_acc_cash_record WHERE accdr_id='$cash_res_id'");
    $row_main=mysqli_fetch_object($sql_main);
    $vou_code_old=substr($row_main->accdr_voucher_no, 0,2);
    $vou_last_code=substr($row_main->accdr_voucher_no, -4);
    if($vou_code_old==$vou_code){
      $new_last_code=substr($row_main->accdr_voucher_no, -2,2);//JV
    }
    else{
      $sql_get_last_code=$connect->query("SELECT vot_code,accdr_voucher_no
        FROM tbl_acc_cash_record AS A 
        LEFT JOIN tbl_acc_voucher_type_list AS B ON A.voucher_type_id=B.vot_id
        WHERE DATE_FORMAT(accdr_date,'%Y-%m-%d')='$v_date' AND vot_code = '$vou_code'");
      $row_get_last_code=mysqli_fetch_object($sql_get_last_code);
      if(@mysqli_num_rows($sql_get_last_code)==0)//Not Available record
      { 
        $v_date_clone_start=date("Y-m-01",strtotime($v_date));
        $sql=$connect->query("SELECT vot_code,accdr_voucher_no
        FROM tbl_acc_cash_record AS A 
        LEFT JOIN tbl_acc_voucher_type_list AS B ON A.voucher_type_id=B.vot_id
          WHERE DATE_FORMAT(accdr_date,'%Y-%m-%d') 
          BETWEEN '$v_date_clone_start' AND '$v_date'
          AND vot_code = '$vou_code'
          ");
        $num_null=mysqli_num_rows($sql);
        $new_last_code=($num_null)?($num_null):'1';
      }
      else if(@mysqli_num_rows($sql_get_last_code)>0){//Have Record
        $v_date_clone_start=date("Y-m-01",strtotime($v_date));
        $sql=$connect->query("SELECT vot_code,accdr_voucher_no
        FROM tbl_acc_cash_record AS A 
        LEFT JOIN tbl_acc_voucher_type_list AS B ON A.voucher_type_id=B.vot_id
          WHERE DATE_FORMAT(accdr_date,'%Y-%m-%d') 
          BETWEEN '$v_date_clone_start' AND '$v_date'
          AND vot_code = '$vou_code'
          ");
        $num_aval=mysqli_num_rows($sql);
        $new_last_code=$num_aval+1;
      }
    }
    //$new_last_code;
  }
  //Add
  else{
    $v_date_clone_start=date("Y-m",strtotime($v_date));
    $sql_main=$connect->query("SELECT accdr_date AS max_date,accdr_date,accdr_voucher_no,accdr_id
      FROM tbl_acc_cash_record AS A 
      LEFT JOIN tbl_acc_voucher_type_list AS B ON A.voucher_type_id=B.vot_id
      WHERE DATE_FORMAT(accdr_date,'%Y-%m')='$v_date_clone_start' AND vot_code='$vou_code'
      ORDER BY accdr_voucher_no DESC
      LIMIT 1
      ");
    $row_max=mysqli_fetch_object($sql_main);
    $tmp=substr(@$row_max->accdr_voucher_no,9);
    if(@mysql_num_rows($sql_main)<0){
      $new_last_code=1;
    }
    $new_last_code=(int) preg_replace('/[^0-9]/', '',$tmp)+1;
    // echo $new_last_code;
  }
}

    $v_voucher_no =$vou_code.date("ymd",strtotime($v_date)).'-'.str_pad(($new_last_code!=0)?($new_last_code):('1'), 4, '0', STR_PAD_LEFT);
    @$myObj->vou_no=$v_voucher_no;
    @$myJSON=json_encode($myObj);
    echo $myJSON;


?>



