<?php include '../../config/database.php'; ?>
<?php 
  $data=@$_POST['data'];
  $json = json_decode($data);
  $fpt_id=$json->fpt_id;
  $vou_code=$json->vou_code;
  $v_date=$json->v_date;
  $vou_id=$json->vou_id;


  //Edit
  $sql="";
  if($fpt_id){
    $v_date=date("Y",strtotime($v_date));
    //Check Old Voucher
    $sql=$connect->query("SELECT SUBSTR(frpc_no,10,4) AS old_data
      FROM tbl_fr_pc_expense 
      WHERE frpc_type='$fpt_id' 
      AND SUBSTR(frpc_no,1,2)='$vou_code' 
      AND DATE_FORMAT(frpc_date,'%Y')='$v_date'");
    if(mysqli_num_rows($sql)){
      $row_old_no=mysqli_fetch_object($sql);
      $new_last_code=$row_old_no->old_data;
    }
    else{
      $sql=$connect->query("SELECT COUNT(frpc_date) AS count FROM tbl_fr_pc_expense
      WHERE DATE_FORMAT(frpc_date,'%Y')='$v_date' 
      AND SUBSTR(frpc_no,1,2)='$vou_code'");
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
    $sql_main=$connect->query("SELECT frpc_date AS max_date,frpc_date,SUBSTR(frpc_no,10,4) tmp_frpc_no,frpc_id
      FROM tbl_fr_pc_expense AS A 
      LEFT JOIN tbl_fr_pc_type_list AS B ON A.frpc_type=B.fpt_id
      WHERE DATE_FORMAT(frpc_date,'%Y')='$v_date_clone_start' AND fpt_code='$vou_code'
      ORDER BY frpc_no DESC
      LIMIT 1
      ");
    $row_max=mysqli_fetch_object($sql_main);
    $tmp=@$row_max->tmp_frpc_no;
    if(@mysqli_num_rows($sql_main)<0){
      $new_last_code=1;
    }
    $new_last_code=(int) preg_replace('/[^0-9]/', '',$tmp)+1;
  }
  $v_voucher_no =$vou_code.date("y-m",strtotime($v_date)).'-'.str_pad($new_last_code, 4, '0', STR_PAD_LEFT);
  @$myObj->vou_no=$v_voucher_no;
  @$myJSON=json_encode($myObj);
  echo $myJSON;
?>