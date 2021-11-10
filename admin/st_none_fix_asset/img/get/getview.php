<?php
    include_once '../../../config/database.php';

    $nf_id = $_POST['assetid'];

    $stml_select = "SELECT A.id,B.id, B.assign_date, D.empl_emloyee_en,E.po_name,A.condit,
    CASE
        WHEN C.adj='It is very old' THEN 'Broken'
        WHEN C.adj='Not see' THEN 'Loss'
    END AS adjus
    FROM tbl_non_fixed AS A 
    LEFT JOIN tbl_non_fixed_assign AS B ON B.non_fixed_id=A.id
    LEFT JOIN tbl_non_fixed_adj AS C ON C.assign_id=B.id
    INNER JOIN tbl_hr_employee_list AS D ON D.empl_id=B.assign_to
    INNER JOIN tbl_hr_position_list AS E ON E.po_id=D.empl_position
    WHERE A.id='".$nf_id."' ORDER BY B.id DESC";

    $arr = "";
    $query = $connect->query($stml_select);
    while($row = mysqli_fetch_object($query))
    {
        $arr.="<tr><td>".$row->assign_date."</td><td>".$row->condit."</td><td>".$row->empl_emloyee_en."</td><td>".$row->po_name."</td><td>".$row->adjus."</td></tr>";
    }
    $msg['msg'] = $arr;
    echo(json_encode($msg));
?>