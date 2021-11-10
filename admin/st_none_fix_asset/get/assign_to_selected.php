<?php
    include_once '../../../config/database.php';
    
    $name = $_POST['pos'];
    
    $stml_select = "SELECT A.empl_emloyee_en, B.po_name AS po_name, A.empl_id AS empl_id FROM tbl_hr_employee_list AS A INNER JOIN tbl_hr_position_list AS B ON A.empl_position=B.po_id";
    $obj = $connect->query($stml_select);
    $result = "";
    while($row = mysqli_fetch_object($obj))
    {
        if($row->empl_emloyee_en==$name)
        {
            $result.="<option value='".$row->empl_id.",".$row->po_name."' selected>".$row->empl_emloyee_en."</option>";
        }
        else
        {
            $result.="<option value='".$row->empl_id.",".$row->po_name."'>".$row->empl_emloyee_en."</option>";
        }
        
    }

    $msg['msg'] = $result;
    echo(json_encode($msg));
?>