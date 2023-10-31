<?php include '../../config/database.php'; ?>
<?php 
  $data=@$_POST['data'];
  $json = json_decode($data);
  $tso_id=$json->tso_id;
  $vou_code=$json->vou_code;
  $v_date=$json->v_date;
  $vou_id=$json->vou_id;


  //Edit
  $sql="";
  if($tso_id){
    $v_date=date("Y",strtotime($v_date));
    //Check Old Voucher
    $sql=$connect->query("SELECT SUBSTR(po_no,10,4) AS old_data
      FROM tbl_prod_add_po 
      WHERE po_sale_order='$tso_id' 
      AND SUBSTR(po_no,1,2)='$vou_code' 
      AND DATE_FORMAT(po_date,'%Y')='$v_date'");
    if(mysqli_num_rows($sql)){
      $row_old_no=mysqli_fetch_object($sql);
      $new_last_code=$row_old_no->old_data;
    }
    else{
      $sql=$connect->query("SELECT COUNT(po_date) AS count FROM tbl_prod_add_po
      WHERE DATE_FORMAT(po_date,'%Y')='$v_date' 
      AND SUBSTR(po_no,1,2)='$vou_code'");
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
    $sql_main=$connect->query("SELECT po_date AS max_date,po_date,SUBSTR(po_no,10,4) as tmp_frpc_no,po_id
      FROM tbl_prod_add_po AS A 
      LEFT JOIN tbl_sale_order AS B ON A.po_sale_order=B.tso_id
      WHERE DATE_FORMAT(po_date,'%Y')='$v_date_clone_start' AND tso_code='$vou_code'
      ORDER BY po_no DESC
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