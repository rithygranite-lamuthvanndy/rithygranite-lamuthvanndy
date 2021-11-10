<?php
    $adj = $_POST['adj'];

    $arr = array('Broken'=>'It is very old', 'Loss'=>'Not see');
    $txt = "";
    foreach($arr as $key => $val)
    {
        if($key==$adj)
        {
            $txt.="<option value='".$val."' selected>".$key."</option>";
        }
        else
        {
            $txt.="<option value='".$val."'>".$key."</option>";
        }
    }

    $msg['msg'] = $txt;
    echo(json_encode($msg));
?>