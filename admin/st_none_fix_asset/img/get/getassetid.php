<?php
    include_once '../../../config/database.php';

    $cat_id = $_POST['catid'];
    $stml_select = "SELECT MAX(assetid) AS max_id FROM tbl_non_fixed WHERE cat_id='".$cat_id."'";
    $query = $connect->query($stml_select);
    $row = mysqli_fetch_object($query);
    if($row->max_id==null)
    {
        $in = (int)$row->max_id+1;
        $msg['maxid'] = str_pad($in, 4, '0', STR_PAD_LEFT);
    }
    else
    {
        $in = (int)$row->max_id+1;
        $msg['maxid'] = str_pad($in, 4, '0', STR_PAD_LEFT);
    }
    
    echo(json_encode($msg));
?>