<?php
    include_once '../../../config/database.php';
        $parend_id = $_POST['asset_cat1'];
        $remark = $_POST['remark'];
        $sale = $_POST['sale'];
        $date = $_POST['date'];

        $stml_insert = "INSERT INTO tbl_non_fixed_des VALUES(null, '".$date."','".$sale."','".$remark."','".$parend_id."',null)";
        if($connect->query($stml_insert))
        {
            $msg['msg']= 'success';
        }
        else
        {
            $msg['msg'] = mysqli_error($connect);
        }

    echo(json_encode($msg)); 
?>