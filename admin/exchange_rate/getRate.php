<?php
   	include_once '../../config/database.php';
   	
   	$amount = $_POST['amount'];
   	$m_f = $_POST['m_f'];
   	$m_t = $_POST['m_t'];
   	$date = $_POST['date'];

   	$m1 = $m_f.'-'.$m_t;
   	$m2 = $m_t.'-'.$m_f;

   	$get_data = $connect->query("SELECT rate FROM tbl_exchange_rate WHERE from_date<='".$date."' AND to_date>='".$date."' AND description='".$m1."' OR description='".$m2."'");
   	$result = mysqli_fetch_object($get_data);
    if($result != null)
    {
      $msg['id'] = $result->rate;
    }
    else
    {
      $msg['id'] = "0";
    }
    // $msg['id1']=$m1; 
    echo(json_encode($msg));
?>