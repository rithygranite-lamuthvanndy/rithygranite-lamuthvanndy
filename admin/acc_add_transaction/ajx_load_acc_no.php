<?php 
    include_once '../../config/database.php';
    $acc_id = @$_GET['acc_id'];
    $data = $connect->query("SELECT *
    FROM tbl_acc_chart_account
    WHERE accca_id='$acc_id'");
    $row = mysqli_fetch_object($data);
?>
<?php
    @$myObj->acc_no=$row->accca_number;
    $myJSON = json_encode($myObj);
    
    echo $myJSON;
?>