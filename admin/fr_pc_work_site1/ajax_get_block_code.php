<?php include_once('../../config/database.php'); ?>

<?php 

    $v_type_id=@$_GET['grade_type_id'];

    if($v_grade_type_id){
        $obj_select=$connect->query("SELECT COUNT(*) AS count,
                (SELECT fpt_name FROM tbl_fr_pc_type_list WHERE fpt_id='$v_type_id') AS type_name
            FROM tbl_fr_pc_expense 
            WHERE frpc_type='$v_type_id'");
        $row_count=mysqli_fetch_object($obj_select);
        $new_code=$row_count->type_name.'-'.sprintf("%'.04d",$row_count->count+1);
        $_SESSION['grade_name']=$row_count->grade_type_name;
        echo $new_block_code;
    }
    
    else if(@$_POST['data']){
        $v_arr=explode(',', @$_POST['data']);
        $v_block_code_tmp="";
        foreach ($v_arr as $value) {
            if($value){
                $v_grade_type_name=substr($value, 0,-5);//A-
                $v_block_code_5=substr($value,-4);//0001
                $v_full_clock_code=$value;

                if($v_grade_type_name==$_SESSION['grade_name']){//A-==A-


                    $v_old_full_code=$_SESSION['last_full_code'.$_SESSION['grade_name']];
                    $v_old_code_5=substr($v_old_full_code, -4);
                    if($v_block_code_5==$v_old_code_5){//0001==00001
                        $str_new_code=sprintf("%'.04d",$v_old_code_5+1);
                        break;
                    }
                    else if($v_block_code_5!=$v_old_code_5){
                        $str_new_code=sprintf("%'.04d",$v_block_code_5+0);
                    }
                }
                else{//A-==B-
                    $str_new_code=sprintf("%'.04d",$v_block_code_5-1);
                }
            } 
        }

        $last_full_code=$_SESSION['grade_name'].'-'.$str_new_code;
        $_SESSION['last_full_code'.$_SESSION['grade_name']]=$last_full_code;


        @$myObj->new_code=$last_full_code;
        @$myObj->status=$status;
        @$myObj->data=$v_grade_type_name.'='.$_SESSION['last_full_code'.$_SESSION['grade_name']];
        @$myJSON=json_encode($myObj);
        echo $myJSON;
    }

    //Clear Session
    else if(@$_GET['clear_block_code']){
        $v_clear_block_code=@$_GET['clear_block_code'];
        if($v_clear_block_code){
            $_SESSION['last_full_code'.substr($v_clear_block_code, -4)]=$v_clear_block_code;
            echo  $_SESSION['last_full_code'.substr($v_clear_block_code, -4)];
        }
    }
?>