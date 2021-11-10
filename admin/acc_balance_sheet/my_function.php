<?php include_once '../../config/database.php';?>
<?php include_once '../acc_my_operation/my_operation.php'; ?>
<?php 

function bal_current_month_BS($v_date_start,$v_date_end,$v_chart_acc_id){
    global $connect;
    $sql="SELECT SUM(total_debit) AS gr_debit,
            SUM(total_credit) AS gr_credit
            FROM(
                SELECT SUM(B.debit) AS total_debit,SUM(B.credit) AS total_credit
                FROM tbl_acc_add_tran_amount AS A 
                LEFT JOIN tbl_acc_add_tran_amount_detail AS B ON A.id=B.main_id
                WHERE A.p_appr='1'
                AND B.acc_id='$v_chart_acc_id'
                AND DATE_FORMAT(A.date_record, '%Y-%m-%d') BETWEEN '$v_date_start' AND '$v_date_end' 
            UNION ALL
            SELECT SUM(B.debit) AS total_debit,SUM(B.credit) AS total_credit
                FROM tbl_acc_add_tran_dr_cr AS A
                LEFT JOIN tbl_acc_add_tran_dr_cr_detail AS B ON A.id=B.main_id
                WHERE A.p_appr='1'
                AND B.acc_id='$v_chart_acc_id'
                AND DATE_FORMAT(A.date_record, '%Y-%m-%d') BETWEEN '$v_date_start' AND '$v_date_end' 
            ) T";
    $row_result=mysqli_fetch_object($connect->query($sql));

    $v_bal=calBalance($v_chart_acc_id,$row_result->gr_debit,$row_result->gr_credit);
    return $v_bal;
}
function bal_pre_month_BS($v_date_start,$v_date_end,$v_chart_acc_id){
    global $connect;
    $sql="SELECT SUM(total_debit) AS gr_debit,
            SUM(total_credit) AS gr_credit
            FROM(
                SELECT SUM(B.debit) AS total_debit,SUM(B.credit) AS total_credit
                FROM tbl_acc_add_tran_amount AS A 
                LEFT JOIN tbl_acc_add_tran_amount_detail AS B ON A.id=B.main_id
                WHERE A.p_appr='1'
                AND B.acc_id='$v_chart_acc_id'
                AND DATE_FORMAT(A.date_record, '%Y-%m-%d')< '$v_date_start' 
            UNION ALL
            SELECT SUM(B.debit) AS total_debit,SUM(B.credit) AS total_credit
                FROM tbl_acc_add_tran_dr_cr AS A
                LEFT JOIN tbl_acc_add_tran_dr_cr_detail AS B ON A.id=B.main_id
                WHERE A.p_appr='1'
                AND B.acc_id='$v_chart_acc_id'
                AND DATE_FORMAT(A.date_record, '%Y-%m-%d') < '$v_date_start' 
            ) T";
    $row_result=mysqli_fetch_object($connect->query($sql));

    $v_bal=calBalance($v_chart_acc_id,$row_result->gr_debit,$row_result->gr_credit);
    return $v_bal;
}
function bal_cur_year_BS($v_date_start,$v_date_end,$v_chart_acc_id){
    global $connect;
    $v_cur_year=date('Y',strtotime($v_date_start));
    $sql="SELECT SUM(total_debit) AS gr_debit,
            SUM(total_credit) AS gr_credit
            FROM(
                SELECT SUM(B.debit) AS total_debit,SUM(B.credit) AS total_credit
                FROM tbl_acc_add_tran_amount AS A 
                LEFT JOIN tbl_acc_add_tran_amount_detail AS B ON A.id=B.main_id
                WHERE A.p_appr='1'
                AND B.acc_id='$v_chart_acc_id'
                AND DATE_FORMAT(A.date_record, '%Y') < '$v_cur_year' 
            UNION ALL
            SELECT SUM(B.debit) AS total_debit,SUM(B.credit) AS total_credit
                FROM tbl_acc_add_tran_dr_cr AS A
                LEFT JOIN tbl_acc_add_tran_dr_cr_detail AS B ON A.id=B.main_id
                WHERE A.p_appr='1'
                AND B.acc_id='$v_chart_acc_id'
                AND DATE_FORMAT(A.date_record, '%Y') < '$v_cur_year' 
            ) T";
    $row_result=mysqli_fetch_object($connect->query($sql));

    $v_bal=calBalance($v_chart_acc_id,$row_result->gr_debit,$row_result->gr_credit);
    return $v_bal;
}
function GetAccountName_BS($sub_acc_id){
    global $connect;
    $arr_size=sizeof($sub_acc_id);
    $sql="SELECT accca_id,accca_number,accca_account_name,accca_account_type 
            FROM tbl_acc_chart_account AS A 
            LEFT JOIN tbl_acc_type_account AS B ON A.accca_account_type=B.accta_id
            WHERE B.accta_id='$sub_acc_id[0]'";
    for($i=1;$i<$arr_size;$i++){
        $sql=$sql." OR B.accta_id='".$sub_acc_id[$i]."'";
    }
    return $sql;
}
function AccountFormatNum_BS($v_data){
    $result="";
    if($v_data==0)
        $result="";
    else if($v_data<0)
        $result='('.number_format(abs($v_data),2).')';
    else
        $result=number_format($v_data,2);
    return $result;
}
 ?>
