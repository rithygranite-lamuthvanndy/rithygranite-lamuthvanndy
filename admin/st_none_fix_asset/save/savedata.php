<?php
    include_once '../../../config/database.php';


    $typeform = $_POST['typeform'];

    // $f2l = $_POST['f2l'];

    if($typeform==1)
    {
        $assetID = $_POST['asset_id'];
        $exp = explode('-', $assetID);

        $des1 = $_POST['des1'];
        $cost = $_POST['cost'];
        $model = $_POST['model'];
        $barcode = $_POST['barcode'];
        $unit = $_POST['unit'];
        $serial = $_POST['serial'];
        $condi=  $_POST['condi'];
        $note = $_POST['note'];

        $des2 = $_FILES['des2']['name'];
        $tmp_des2 = $_FILES['des2']['tmp_name'];
        $extdes2=pathinfo($des2, PATHINFO_EXTENSION);
	    // $t=time();
        move_uploaded_file($tmp_des2,'../img/'.$des2.'.'.$extdes2);

        $pic = $_FILES['pic']['name'];
        $tmp_pic = $_FILES['pic']['tmp_name'];
        $extpic=pathinfo($pic, PATHINFO_EXTENSION);
	    // $t=time();
	    move_uploaded_file($tmp_pic,'../img/'.$pic.'.'.$extpic);

        $location = $_POST['location'];
        $section = $_POST['section'];
        $department = $_POST['department'];
        $gp = $_POST['gp'];

        $acq = $_POST['acq'];
        $in_service = $_POST['in_service'];
        $sold = $_POST['sold'];

        $check_exit_asset_id = "SELECT assetid FROM tbl_non_fixed WHERE assetid='".$exp[1]."' AND cat_id='".$exp[0]."'";
        $query = $connect->query($check_exit_asset_id);
        if($query->num_rows>0)
        {
            $stml_update = "UPDATE tbl_non_fixed SET
                            cat_id='".$exp[0]."',
                            des1='".$des1."',
                            cost='".$cost."',
                            model='".$model."',
                            note='".$note."',
                            unit='".$unit."',
                            serail='".$serial."',
                            condit='".$condi."',
                            locat='".$location."',
                            section='".$section."',
                            department='".$department."',
                            gp='".$gp."',
                            picture='".$pic."',
                            des2='".$des2."',
                            acquired='".$acq."',
                            in_service='".$in_service."',
                            sold='".$sold."'
                            WHERE assetid='".$assetID."'
                            ";
            if($connect->query($stml_update))
            {
                $msg['msg'] = "success";
            }
        }
        else
        {
            $stml_insert = "INSERT INTO tbl_non_fixed VALUES(null, '".$exp[1]."','".$exp[0]."','".$des1."','".$cost."','".$model."','".$barcode."','".$note."','".$unit."','".$serial."','".$condi."','".$location."','".$section."','".$department."','".$gp."','".$pic."','".$des2."','".$acq."','".$in_service."','".$sold."', null)";
            if($connect->query($stml_insert))
            {
                $last_id = $connect->insert_id;
                $msg['last_id'] = $last_id;
                $msg['msg'] = "success";
            }
        }
        
    }
    elseif($typeform==2)
    {
        $assign_to = $_POST['assign_to'];
        $assign_to = explode(',', $assign_to);

        $assign_date = $_POST['assign_date'];
        $parend_id = $_POST['asset_cat1'];

        $isedit = $_POST['isedit'];
        if($isedit==0)
        {
            $stml_insert = "INSERT INTO tbl_non_fixed_assign VALUES(null, '".$assign_to[0]."','".$assign_date."','".$parend_id."', 9, null)";
            if($connect->query($stml_insert))
            {
                $msg['last_id'] = $connect->insert_id;
                $msg['msg']='success';
            }
        }
        else
        {
            $id = $_POST['ass_id'];
            $stml_update = "UPDATE tbl_non_fixed_assign SET assign_to='".$assign_to[0]."', assign_date='".$assign_date."' WHERE id='".$id."'";
            if($connect->query($stml_update))
            {
                $msg['msg']='success';   
            }
        }
    } 
    elseif($typeform==3)
    {
        $adj = $_POST['adj'];
        $remark = $_POST['remark'];
        $parend_id = $_POST['asset_cat1'];

        $assign_id = $_POST['ass_id'];

        $isedit = $_POST['isedit'];
        if($isedit==0)
        {
            $stml_insert = "INSERT INTO tbl_non_fixed_adj VALUES(null, '".$adj."','".$remark."','".$parend_id."', '".$assign_id."', null)";
            if($connect->query($stml_insert))
            {
                $msg['last_id'] = $connect->insert_id;
                $msg['msg']='success';
            }
        }
        else
        {
            $id = $_POST['adj_id'];
            $stml_update = "UPDATE tbl_non_fixed_adj SET adj='".$adj."', remark='".$remark."' WHERE id='".$id."'";
            if($connect->query($stml_update))
            {
                $msg['msg']='success';   
            }
        }
    }
    // $msg['msg']='success';

    echo(json_encode($msg)); 
?>