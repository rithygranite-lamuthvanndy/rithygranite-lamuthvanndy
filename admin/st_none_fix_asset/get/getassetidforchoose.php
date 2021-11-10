<?php
    include_once '../../../config/database.php';

    $stml_select = "SELECT * FROM tbl_non_fixed ORDER BY id DESC";
    $query = $connect->query($stml_select);

    $arr = "";
    while($row = mysqli_fetch_object($query))
    { 
        $arr.="<option value=".$row->id.">".$row->cat_id."-".$row->assetid."</option>";
    }
    $msg['arr'] = $arr;
    echo(json_encode($msg));
?>