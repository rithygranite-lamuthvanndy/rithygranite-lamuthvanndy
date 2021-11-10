<?php 
	include_once '../../config/database.php';
 ?>
<!-- ==============================Save Data================================ -->
<?php 
	if(isset($_POST['btn_save_in'])){
		$v_date_record = mysqli_escape_string($connect,@$_POST['txt_date_record']);
        $v_supplier = mysqli_escape_string($connect,@$_POST['cbo_supplier']);
        $v_letter_no = mysqli_escape_string($connect,@$_POST['txt_letter_no']);
        $v_exchange_rate = mysqli_escape_string($connect,@$_POST['txt_exchange_rate']);
        $v_req_no = mysqli_escape_string($connect,@$_POST['txt_req_no']);
        $v_note = mysqli_escape_string($connect,@$_POST['txt_note']);
        $v_user_id = @$_SESSION['user']->user_id;
        $v_stock_status=$_SESSION['status'];
        

        $query_add = "INSERT INTO tbl_st_stock_in(
                stock_status,
                stsin_date_in,
                stsin_exchange_rate,
                stsin_letter_no,
                stsin_req_no,
                stsin_supp_id,
                stsin_note,
                user_id                
                ) 
            VALUES(
                '$v_stock_status',
                '$v_date_record',
                '$v_exchange_rate',
                '$v_letter_no',
                '$v_req_no',
                '$v_supplier',
                '$v_note',
                '$v_user_id'
                )";
        if($connect->query($query_add)){
            $last_id=$connect->insert_id;
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

        $v_pro_code=$_POST['cbo_pro_code'];
        $v_unit=$_POST['cbo_unit'];
        $v_qty=$_POST['txt_qty'];
        $v_price_vn=$_POST['txt_price_vn'];
        $v_price_dollar=$_POST['txt_price_dollar'];
        $flag=0;
        foreach ($v_pro_code as $key=>$value) {
            $v_new_pro_code=mysqli_real_escape_string($connect,$v_pro_code[$key]);
            $v_new_unit=mysqli_real_escape_string($connect,$v_unit[$key]);
            $v_new_qty=mysqli_real_escape_string($connect,$v_qty[$key]);
            $v_new_price_vn=mysqli_real_escape_string($connect,$v_price_vn[$key]);
            $v_new_price_dollar=mysqli_real_escape_string($connect,$v_price_dollar[$key]);
            if($v_new_pro_code&&$v_new_qty&&$v_new_unit){
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
        }
        $sql = rtrim($sql,",");
        // die($sql);
        if($flag){
            if($connect->query($sql)){
            	$_SESSION['save_call_back']=1;
            	header('location: add_in.php');
            }
            else{
            	die($connect->error);
            }
        }
	}

    if(isset($_POST['btn_save_out'])){
         $v_date_record = mysqli_escape_string($connect,@$_POST['txt_date_record']);
        $v_manager = mysqli_escape_string($connect,@$_POST['cbo_manager']);
        $v_letter_no = mysqli_escape_string($connect,@$_POST['txt_letter_no']);
        $v_note = mysqli_escape_string($connect,@$_POST['txt_note']);
        $v_user_id = @$_SESSION['user']->user_id;
        $v_stock_status=$_SESSION['status'];
        

        $query_add = "INSERT INTO tbl_st_stock_out (
                stock_status,
                stsout_date_out,
                stsout_letter_no,
                stsout_man_id,
                stsout_note,
                user_id                
                ) 
            VALUES(
                '$v_stock_status',
                '$v_date_record',
                '$v_letter_no',
                '$v_manager',
                '$v_note',
                '$v_user_id'
                )";
        if($connect->query($query_add)){
            $last_id=$connect->insert_id;
        }
        else{
            die($connect->error);
        }

        $sql="INSERT INTO tbl_st_stock_out_detail
                (
                stsout_id,
                pro_id,
                unit_id,
                out_qty,
                track_mac_id
                )VALUES
            ";

        $v_pro_code=$_POST['cbo_pro_code'];
        $v_unit=$_POST['cbo_unit'];
        $v_qty=$_POST['txt_qty'];
        $v_track_machine=$_POST['cbo_track_machine'];
        $flag=0;
        foreach ($v_pro_code as $key=>$value) {
            $v_new_pro_code=mysqli_real_escape_string($connect,$v_pro_code[$key]);
            $v_new_unit=mysqli_real_escape_string($connect,$v_unit[$key]);
            $v_new_qty=mysqli_real_escape_string($connect,$v_qty[$key]);
            $v_new_track_machine=mysqli_real_escape_string($connect,$v_track_machine[$key]);
            if($v_new_pro_code&&$v_new_qty&&$v_new_unit&&$v_new_track_machine){
                $sql.="(
                        '$last_id',
                        '$v_new_pro_code',
                        '$v_new_unit',
                        '$v_new_qty',
                        '$v_new_track_machine'
                        ),";
                ++$flag;
            }
        }
        $sql = rtrim($sql,",");
        if($connect->query($sql)){
            $_SESSION['save_call_back']=1;
            header('location: add_out.php');
        }
        else{
            die($connect->error);
        }
    }


    if(isset($_POST['btn_save_adjust'])){
        $v_date_record = mysqli_escape_string($connect,@$_POST['txt_date_record']);
        $v_adjust_code = mysqli_escape_string($connect,@$_POST['txt_adjust_code']);
        $v_note = mysqli_escape_string($connect,@$_POST['txt_note']);
        $v_user_id = @$_SESSION['user']->user_id;
        $v_stock_status=$_SESSION['status'];
        

        $query_add = "INSERT INTO tbl_st_stock_adjustment (
                stsadj_status,
                stsadj_code,
                stsadj_date_record,
                stsadj_note,
                user_id                
                ) 
            VALUES(
                '$v_stock_status',
                '$v_adjust_code',
                '$v_date_record',
                '$v_note',
                '$v_user_id'
                )";
        if($connect->query($query_add)){
            $last_id=$connect->insert_id;
        }
        else{
            die($connect->error);
        }

        $sql="INSERT INTO tbl_st_stock_adjustment_detail
                (
                stsadj_id,
                pro_id,
                qty_adjust
                )VALUES
            ";

        $v_pro_code=$_POST['cbo_pro_code'];
        $v_qty=$_POST['txt_qty'];
        $flag=0;
        foreach ($v_pro_code as $key=>$value) {
            $v_new_pro_code=mysqli_real_escape_string($connect,$v_pro_code[$key]);
            $v_new_qty=mysqli_real_escape_string($connect,$v_qty[$key]);
            if($v_new_pro_code&&$v_new_qty){
                $sql.="(
                        '$last_id',
                        '$v_new_pro_code',
                        '$v_new_qty'
                        ),";
                ++$flag;
            }
        }
        $sql = rtrim($sql,",");
        if($connect->query($sql)){
            $_SESSION['save_call_back']=1;
            header('location: add_adjustment.php');
        }
        else{
            die($connect->error);
        }
    }
 ?>
<!-- ==============================Update Data================================ -->
