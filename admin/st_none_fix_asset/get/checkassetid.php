<?php
    include_once '../../../config/database.php';

    $c = $_POST['c'];

    $stml_select = "SELECT id FROM tbl_non_fixed WHERE assetid LIKE '".$c."%'";

    $obj = $connect->query($stml_select);
    if($obj->num_rows>0)
    {
        $msg['msg']='have';
    }
    else
    {
        $msg['msg']='no';
    }
    echo(json_encode($msg));
?>