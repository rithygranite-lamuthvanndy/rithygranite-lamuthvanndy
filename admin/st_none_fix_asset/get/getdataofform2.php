<?php
    include_once '../../../config/database.php';

    $id = $_POST['id'];
    $form = $_POST['form'];
    if($form==2)
    {
        $arr = "<tr><th>Assign Date</th><th>Condition</th><th>Assigned To</th><th>Position</th></tr>";
        $stml_select = "SELECT A.*, B.*, C.*, D.po_name
                        FROM tbl_non_fixed AS A 
                        LEFT JOIN tbl_non_fixed_assign AS B ON B.non_fixed_id=A.id 
                        LEFT JOIN tbl_hr_employee_list AS C ON B.assign_to=C.empl_id
                        LEFT JOIN tbl_hr_position_list AS D ON C.empl_position=D.po_id
                        WHERE A.id='".$id."' ORDER BY B.id DESC";
    }
    else if($form==3)
    {
        $arr = "<tr><th>Date</th><th>Condition</th><th>Adjusment</th><th>Remark</th></tr>";
        $stml_select = "SELECT A.*, B.*, C.* ,
                        CASE
                            WHEN C.adj='It is very old' THEN 'Broken'
                            WHEN C.adj='Not see' THEN 'Loss'
                        END AS adj
                        FROM tbl_non_fixed AS A 
                        LEFT JOIN tbl_non_fixed_assign AS B ON B.non_fixed_id=A.id 
                        LEFT JOIN tbl_non_fixed_adj AS C ON C.assign_id=B.id 
                        WHERE A.id='".$id."'";
    }
    else if($form==4)
    {
        $arr = "<tr><th>Assign Date</th><th>Condition</th><th>Assigned To</th><th>Position</th><th>Adjusment</th></tr>";
        $stml_select = "SELECT A.*, B.assign_date, D.empl_emloyee_en,E.po_name,A.condit,
                        CASE
                            WHEN C.adj='It is very old' THEN 'Broken'
                            WHEN C.adj='Not see' THEN 'Loss'
                        END AS adjus
                        FROM tbl_non_fixed AS A 
                        LEFT JOIN tbl_non_fixed_assign AS B ON B.non_fixed_id=A.id
                        LEFT JOIN tbl_non_fixed_adj AS C ON C.assign_id=B.id
                        INNER JOIN tbl_hr_employee_list AS D ON D.empl_id=B.assign_to
                        INNER JOIN tbl_hr_position_list AS E ON E.po_id=D.empl_position
                        WHERE A.id='".$id."' ORDER BY B.id DESC";
    }
    if($query = $connect->query($stml_select))
    {
        while($row = mysqli_fetch_object($query))
        {
            $msg['des1'] = $row->des1;
            $msg['cost'] = $row->cost;
            $msg['model'] = $row->model;
            $msg['acquired'] = $row->acquired;
            $msg['serail'] = $row->serail;
            $msg['section'] = $row->section;
            $msg['cdt'] = $row->condit;
            if($form == 2)
            {
                if($row->assign_to != null)
                {
                    $arr.="<tr><td>".$row->assign_date." <input type='hidden' value=".$row->id."></td><td>".$row->condit."</td><td>".$row->empl_emloyee_en."</td><td>".$row->po_name."</td></tr>";
                }
            }
            else if($form==3)
            {
                if($row->adj != null)
                {
                    $arr.="<tr><td>".$row->assign_date."<input type='hidden' value='".$row->id."'></td><td>".$row->condit."</td><td>".$row->adj."</td><td>".$row->remark."</td></tr>";
                }
            }
            else if($form==4)
            {
                $arr.="<tr><td>".$row->assign_date."</td><td>".$row->condit."</td><td>".$row->empl_emloyee_en."</td><td>".$row->po_name."</td><td>".$row->adjus."</td></tr>";
            }
        }
    }
    
  
    $msg['arr'] = $arr;
    echo(json_encode($msg));
?>