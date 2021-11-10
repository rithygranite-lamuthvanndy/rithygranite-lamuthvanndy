<?php 
	include_once '../../config/database.php';
 ?>
<!-- ==============================Save Data================================ -->
<?php 
	if(isset($_POST['btn_save_in'])){
        echo("dfjslfjieofie");
		$v_date_record = mysqli_escape_string($connect,@$_POST['txt_date_record']);
        $v_supplier = mysqli_escape_string($connect,@$_POST['cbo_supplier']);
        $v_letter_no = mysqli_escape_string($connect,@$_POST['txt_letter_no']);
        $v_exchange_rate = mysqli_escape_string($connect,@$_POST['txt_exchange_rate']);
        $v_req_no = mysqli_escape_string($connect,@$_POST['txt_req_no']);
        $v_note = mysqli_escape_string($connect,@$_POST['txt_note']);
        $v_user_id = @$_SESSION['user']->user_id;
        $v_stock_status=$_SESSION['status'];
        $v_manager = mysqli_escape_string($connect,@$_POST['cbo_manager']);
        

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
        // $connect->query($query_add1);
        
        if($connect->query($query_add)){
            $last_id=$connect->insert_id;
        }
        else{
            die($connect->error);
        }

        $query_add1 = "INSERT INTO tbl_st_stock_out (
            stock_status,
            stsout_date_out,
            stsout_letter_no,
            stsout_man_id,
            stsout_note,
            user_id,
            in_id
            ) 
        VALUES(
            '$v_stock_status',
            '$v_date_record',
            '$v_manager',
            '$v_letter_no',
            '$v_note',
            '$v_user_id',
            '$last_id'
            )";
        if($connect->query($query_add1)){
            $last_id1=$connect->insert_id;
        }
        else {
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

        $sql1 = "INSERT INTO tbl_st_stock_out_detail
            (
            stsout_id,
            pro_id,
            locaton_id,
            unit_id,
            out_qty,
            track_mac_id,
            in_id
            )VALUES";

        $v_pro_code = $_POST['cbo_pro_code'];

        $v_machine = $_POST['cbo_track_machine'];
        $v_location = $_POST['cbo_location'];

        $v_unit=$_POST['cbo_unit'];
        $v_qty=$_POST['txt_qty'];
        $v_price_vn=$_POST['txt_price_vn'];
        $v_price_dollar=$_POST['txt_price_dollar'];
        $flag=0;
       
        foreach ($v_pro_code as $key=>$value) {

            $v_new_machine = mysqli_real_escape_string($connect,$v_machine[$key]);
            $v_new_location = mysqli_real_escape_string($connect,$v_location[$key]);
           
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
                $sql1.="(
                    '$last_id1',
                    '$v_new_pro_code',
                    '$v_new_location',
                    '$v_new_unit',
                    '$v_new_qty',
                    '$v_new_machine',
                    '$last_id'
                ),";
                
                ++$flag;
            }
        }
        $sql = rtrim($sql,",");
        $sql1 = rtrim($sql1, ",");
        // die($sql);
        if($flag){
            if($connect->query($sql) && $connect->query($sql1)){
            	$_SESSION['save_call_back']=1;
            	header('location: add_in.php');
            }
            else{
            	die($connect->error);
            }
        }
	}



    function delete_first_insert($del_id) {
        global $connect;
        $connect->query("DELETE FROM tbl_st_stock_in WHERE stsin_id='$del_id'");
        $connect->query("DELETE FROM tbl_st_stock_in_detail WHERE stsin_id='$del_id'");
        $connect->query("DELETE FROM tbl_st_stock_out_detail WHERE in_id='$del_id'");
        $connect->query("DELETE FROM tbl_st_stock_out WHERE in_id='$del_id'");
    }



    if(isset($_POST['btn_save_in_update'])){
        $txt_parent_id=mysqli_escape_string($connect,@$_POST['txt_parent_id']);
        delete_first_insert($txt_parent_id);
        echo("dfjslfjieofie");
        $v_date_record = mysqli_escape_string($connect,@$_POST['txt_date_record']);
        $v_supplier = mysqli_escape_string($connect,@$_POST['cbo_supplier']);
        $v_letter_no = mysqli_escape_string($connect,@$_POST['txt_letter_no']);
        $v_exchange_rate = mysqli_escape_string($connect,@$_POST['txt_exchange_rate']);
        $v_req_no = mysqli_escape_string($connect,@$_POST['txt_req_no']);
        $v_note = mysqli_escape_string($connect,@$_POST['txt_note']);
        $v_user_id = @$_SESSION['user']->user_id;
        $v_stock_status=$_SESSION['status'];
        $v_manager = mysqli_escape_string($connect,@$_POST['cbo_manager']);
        

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
        // $connect->query($query_add1);
        
        if($connect->query($query_add)){
            $last_id=$connect->insert_id;
        }
        else{
            die($connect->error);
        }

        $query_add1 = "INSERT INTO tbl_st_stock_out (
            stock_status,
            stsout_date_out,
            stsout_letter_no,
            stsout_man_id,
            stsout_note,
            user_id,
            in_id
            ) 
        VALUES(
            '$v_stock_status',
            '$v_date_record',
            '$v_manager',
            '$v_letter_no',
            '$v_note',
            '$v_user_id',
            '$last_id'
            )";
        if($connect->query($query_add1)){
            $last_id1=$connect->insert_id;
        }
        else {
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

        $sql1 = "INSERT INTO tbl_st_stock_out_detail
            (
            stsout_id,
            pro_id,
            locaton_id,
            unit_id,
            out_qty,
            track_mac_id,
            in_id
            )VALUES";

        $v_pro_code = $_POST['cbo_pro_code'];

        $v_machine = $_POST['cbo_track_machine'];
        $v_location = $_POST['cbo_location'];

        $v_unit=$_POST['cbo_unit'];
        $v_qty=$_POST['txt_qty'];
        $v_price_vn=$_POST['txt_price_vn'];
        $v_price_dollar=$_POST['txt_price_dollar'];
        $flag=0;
       
        foreach ($v_pro_code as $key=>$value) {

            $v_new_machine = mysqli_real_escape_string($connect,$v_machine[$key]);
            $v_new_location = mysqli_real_escape_string($connect,$v_location[$key]);
           
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
                $sql1.="(
                    '$last_id1',
                    '$v_new_pro_code',
                    '$v_new_location',
                    '$v_new_unit',
                    '$v_new_qty',
                    '$v_new_machine',
                    '$last_id'
                ),";
                
                ++$flag;
            }
        }
        $sql = rtrim($sql,",");
        $sql1 = rtrim($sql1, ",");
        // die($sql);
        if($flag){
            if($connect->query($sql) && $connect->query($sql1)){
                $_SESSION['save_call_back']=1;
                header('location: add_in.php');
            }
            else{
                die($connect->error);
            }
        }
    }





   

   

 ?>
