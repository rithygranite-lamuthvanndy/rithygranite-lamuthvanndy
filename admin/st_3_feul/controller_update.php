<?php 
	include_once '../../config/database.php';
 ?>
<!-- ==============================Save Data================================ -->
<?php 
	if(isset($_POST['btn_save_in'])){
		$v_parent_id = mysqli_escape_string($connect,@$_POST['txt_parent_id']);
        $v_date_record = mysqli_escape_string($connect,@$_POST['txt_date_record']);
        $v_supplier = mysqli_escape_string($connect,@$_POST['cbo_supplier']);
        $v_letter_no = mysqli_escape_string($connect,@$_POST['txt_letter_no']);
        $v_exchange_rate = mysqli_escape_string($connect,@$_POST['txt_exchange_rate']);
        $v_req_no = mysqli_escape_string($connect,@$_POST['txt_req_no']);
        $v_note = mysqli_escape_string($connect,@$_POST['txt_note']);
        $v_user_id = @$_SESSION['user']->user_id;
        $v_stock_status=$_SESSION['status'];
        

        $query_add = "UPDATE tbl_st_stock_in SET 
                stock_status='$v_stock_status',
                stsin_date_in='$v_date_record',
                stsin_exchange_rate='$v_exchange_rate',
                stsin_letter_no='$v_letter_no',
                stsin_req_no='$v_req_no',
                stsin_supp_id='$v_supplier',
                stsin_note='$v_note' 
                WHERE stsin_id='$v_parent_id'";
        if($connect->query($query_add)){
            $last_id=$v_parent_id;
        }
        else{
            die($connect->error);
        }

        $sql="INSERT INTO tbl_st_stock_in_detail
                (
                stsin_id,
                pro_id,
                unit_id,
                in_qty,
                in_price_vn,
                in_price_dollar
                )VALUES";

        $v_status=$_POST['txt_status'];
        $v_pro_code=$_POST['cbo_pro_code'];
        $v_unit=$_POST['cbo_unit'];
        $v_qty=$_POST['txt_qty'];
        $v_price_vn=$_POST['txt_price_vn'];
        $v_price_dollar=$_POST['txt_price_dollar'];
        $flag=0;
        foreach ($v_pro_code as $key=>$value) {
            $v_new_status=@mysqli_real_escape_string($connect,$v_status[$key]);
            $v_new_pro_code=mysqli_real_escape_string($connect,$v_pro_code[$key]);
            $v_new_unit=mysqli_real_escape_string($connect,$v_unit[$key]);
            $v_new_qty=mysqli_real_escape_string($connect,$v_qty[$key]);
            $v_new_price_vn=mysqli_real_escape_string($connect,$v_price_vn[$key]);
            $v_new_price_dollar=mysqli_real_escape_string($connect,$v_price_dollar[$key]);
            if($v_new_pro_code&&$v_new_qty&&$v_new_unit&&$v_new_status==0){
                $sql.="(
                        '$last_id',
                        '$v_new_pro_code',
                        '$v_new_unit',
                        '$v_new_qty',
                        '$v_new_price_vn',
                        '$v_new_price_dollar'
                        ),";
                ++$flag;
            }
            else if($v_new_pro_code&&$v_new_qty&&$v_new_unit&&$v_new_status!=0){
                $sql_update_child="UPDATE tbl_st_stock_in_detail SET    
                                    pro_id='$v_new_pro_code',
                                    unit_id='$v_new_unit',
                                    in_qty='$v_new_qty',
                                    in_price_vn='$v_new_price_vn',
                                    in_price_dollar='$v_new_price_dollar'
                                    WHERE std_id='$v_new_status'
                                    ";
                // echo $sql_update_child;
                $connect->query($sql_update_child);
                ++$flag;
            }
        }
        $sql = rtrim($sql,",");
        // die($sql);
        if($flag){
            echo $sql;
            $connect->query($sql);
        	$_SESSION['save_call_back']=1;
        	header('location: edit_in.php?edit_id='.$last_id);
        }
        else{
        	die($connect->error);
        }
	}

    if(isset($_POST['btn_save_out'])){
        $v_parent_id = mysqli_escape_string($connect,@$_POST['txt_parent_id']);
        $v_date_record = mysqli_escape_string($connect,@$_POST['txt_date_record']);
        $v_manager = mysqli_escape_string($connect,@$_POST['cbo_manager']);
        $v_letter_no = mysqli_escape_string($connect,@$_POST['txt_letter_no']);
        $v_note = mysqli_escape_string($connect,@$_POST['txt_note']);
        $v_user_id = @$_SESSION['user']->user_id;
        $v_stock_status=$_SESSION['status'];
        

         $query_add = "UPDATE tbl_st_stock_out SET 
                stsout_date_out='$v_date_record',
                stsout_letter_no='$v_letter_no',
                stsout_man_id='$v_manager',
                stsout_note='$v_note' 
                WHERE stsout_id='$v_parent_id'";
        if($connect->query($query_add)){
            $last_id=$v_parent_id;
        }
        else{
            die($connect->error);
        }

        $sql= "INSERT INTO tbl_st_stock_out_detail
                (
                stsout_id,
                project_id,
                pro_id,
                locaton_id,
                unit_id,
                track_mac_id,
                out_qty,
                pro_type_id
                )VALUES
            ";
        $v_status=$_POST['txt_status'];
        $v_pro_type_id=$_POST['cbo_pro_type_id'];
        $v_project = $_POST['cbo_project'];
        $v_location=$_POST['cbo_location'];

        $v_pro_code=$_POST['cbo_pro_code'];
        $v_unit=$_POST['cbo_unit'];
        $v_qty=$_POST['txt_qty'];
        $v_track_machine=$_POST['cbo_track_machine'];
        $flag=0;
        foreach ($v_pro_code as $key=>$value) {
            $v_new_pro_type_id=@mysqli_real_escape_string($connect,$v_pro_type_id[$key]);
            $v_new_project = mysqli_real_escape_string($connect, $v_project[$key]);
            $v_new_location=@mysqli_real_escape_string($connect,$v_location[$key]);

            $v_new_status=@mysqli_real_escape_string($connect,$v_status[$key]);
            $v_new_pro_code=mysqli_real_escape_string($connect,$v_pro_code[$key]);
            $v_new_unit=mysqli_real_escape_string($connect,$v_unit[$key]);
            $v_new_qty=mysqli_real_escape_string($connect,$v_qty[$key]);
            $v_new_track_machine=mysqli_real_escape_string($connect,$v_track_machine[$key]);
            if($v_new_pro_code&&$v_new_qty&&$v_new_unit&&$v_new_track_machine&&$v_new_status==0){

                $sql.="(
                        '$last_id',
                        '$v_new_project',
                        '$v_new_pro_code',
                        '$v_new_location',
                        '$v_new_unit',
                        '$v_new_track_machine',
                        '$v_new_qty',
                        '$v_new_pro_type_id'
                        ),";
                ++$flag;

            }
            else if($v_new_pro_code&&$v_new_qty&&$v_new_unit&&$v_new_track_machine&&$v_new_status!=0){
                $sql_update_child="UPDATE tbl_st_stock_out_detail SET    
                                    pro_id='$v_new_pro_code',
                                    unit_id='$v_new_unit',
                                    out_qty='$v_new_qty',
                                    track_mac_id='$v_new_track_machine',
                                    pro_type_id='$v_new_pro_type_id',
                                    locaton_id='$v_new_location'
                                    WHERE std_id='$v_new_status'
                                    ";
                                    // echo $sql_update_child;
                $connect->query($sql_update_child);
                ++$flag;
            }
        }
        $sql = rtrim($sql,",");
        // die($sql);
        if($flag){
            // echo $sql;
            $connect->query($sql);
            $_SESSION['save_call_back']=1;
            header('location: edit_out.php?edit_id='.$last_id);
        }
        else{
            die($connect->error);
        }
    }

    if (isset($_POST['btn_save_adjust'])) {
        $v_parent_id = mysqli_escape_string($connect, @$_POST['txt_parent_id']);
        $v_date_record = mysqli_escape_string($connect, @$_POST['txt_date_record']);
        $v_adjust_code = mysqli_escape_string($connect, @$_POST['txt_adjust_code']);
        $v_note = mysqli_escape_string($connect, @$_POST['txt_note']);
        $v_user_id = @$_SESSION['user']->user_id;
        $v_stock_status = $_SESSION['status'];


        $query_add = "UPDATE tbl_st_stock_adjustment SET 
                    stsadj_date_record='$v_date_record',
                    stsadj_code='$v_adjust_code',
                    stsadj_note='$v_note' 
                    WHERE stsadj_id='$v_parent_id'";
        if ($connect->query($query_add)) {
            $last_id = $v_parent_id;
        } else {
            die($connect->error);
        }

        $sql = "INSERT INTO tbl_st_stock_adjustment_detail
                    (
                    stsadj_id,
                    pro_id,
                    qty_adjust
                    )VALUES
                ";
        $v_status = $_POST['txt_status'];
        $v_pro_code = $_POST['cbo_pro_code'];
        $v_qty = $_POST['txt_qty'];
        $flag = 0;
        foreach ($v_pro_code as $key => $value) {
            $v_new_status = @mysqli_real_escape_string($connect, $v_status[$key]);
            $v_new_pro_code = mysqli_real_escape_string($connect, $v_pro_code[$key]);
            $v_new_qty = mysqli_real_escape_string($connect, $v_qty[$key]);
            if ($v_new_pro_code && $v_new_qty && $v_new_status == 0) {
                $sql .= "(
                            '$last_id',
                            '$v_new_pro_code',
                            '$v_new_qty'
                            ),";
                ++$flag;
            } else if ($v_new_pro_code && $v_new_qty && $v_new_status != 0) {
                $sql_update_child = "UPDATE tbl_st_stock_adjustment_detail SET    
                                        pro_id='$v_new_pro_code',
                                        qty_adjust='$v_new_qty'
                                        WHERE id='$v_new_status'
                                        ";
                // echo $sql_update_child;
                $connect->query($sql_update_child);
                ++$flag;
            }
        }
        $sql = rtrim($sql, ",");
        // die($sql);
        if ($flag) {
            // echo $sql;
            $connect->query($sql);
            $_SESSION['save_call_back'] = 1;
            header('location: edit_adjustment.php?edit_id=' . $last_id);
        } else {
            die($connect->error);
        }
    }

 ?>
<!-- ==============================Update Data================================ -->