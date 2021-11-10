<?php 
    include_once '../../config/database.php';
    $inv_no = @$_GET['inv_no'];
    $sql=$connect->query("SELECT rec_status,rec_from_id FROM tbl_acc_cash_record WHERE accdr_id='$inv_no'");
    $row_old_data=mysqli_fetch_object($sql);
    if($row_old_data->rec_status==1){
        $data = $connect->query("SELECT A.*,vot_code,vot_name,trat_name,name AS res_name
        FROM tbl_acc_cash_record AS A
        LEFT JOIN tbl_acc_voucher_type_list AS B ON A.vou_type_id=B.vot_id
        LEFT JOIN tbl_acc_transaction_type_list AS C ON A.tran_type_id=C.trat_id
        LEFT JOIN tbl_cus_customer_info AS D ON A.rec_from_id=D.cussi_id
        WHERE accdr_id='$inv_no' AND status=1");
    }
    else if($row_old_data->rec_status==2){
        $data = $connect->query("SELECT A.*,vot_code,vot_name,trat_name,name AS res_name
        FROM tbl_acc_cash_record AS A
        LEFT JOIN tbl_acc_voucher_type_list AS B ON A.vou_type_id=B.vot_id
        LEFT JOIN tbl_acc_transaction_type_list AS C ON A.tran_type_id=C.trat_id
        LEFT JOIN tbl_acc_other_rec_from_list AS D ON A.rec_from_id=D.id
        WHERE accdr_id='$inv_no' AND status=1");
    }
    else if($row_old_data->rec_status==3){
        $data = $connect->query("SELECT A.*,vot_code,vot_name,trat_name,name AS res_name
        FROM tbl_acc_cash_record AS A
        LEFT JOIN tbl_acc_voucher_type_list AS B ON A.vou_type_id=B.vot_id
        LEFT JOIN tbl_acc_transaction_type_list AS C ON A.tran_type_id=C.trat_id
        LEFT JOIN tbl_sup_supplier_info AS D ON A.rec_from_id=D.supsi_id
        WHERE accdr_id='$inv_no' AND status=1");
    }
    else if($row_old_data->rec_status==4){
        $data = $connect->query("SELECT A.*,vot_code,vot_name,trat_name,name AS res_name
        FROM tbl_acc_cash_record AS A
        LEFT JOIN tbl_acc_voucher_type_list AS B ON A.vou_type_id=B.vot_id
        LEFT JOIN tbl_acc_transaction_type_list AS C ON A.tran_type_id=C.trat_id
        LEFT JOIN tbl_acc_other_pay_to_list AS D ON A.rec_from_id=D.id
        WHERE accdr_id='$inv_no' AND status=1");
    }
    $row = mysqli_fetch_object($data);
?>
<?php
    @$myObj->vouch = $row->vot_code.' :: '.$row->vot_name;
    @$myObj->tran=$row->trat_name;
    // @$myObj->tran='fff';
    @$myObj->address=$row->accdr_address;
    @$myObj->phone=$row->accdr_phone;
    // @$myObj->name='aaa';
    @$myObj->name=$row->res_name;
    @$myObj->note=$row->accdr_note;
    @$myObj->cash_in=number_format($row->accdr_cash_in,2);
    @$myObj->cash_out=number_format($row->accdr_cash_out,2);
    $myJSON = json_encode($myObj);
    
    echo $myJSON;
?>