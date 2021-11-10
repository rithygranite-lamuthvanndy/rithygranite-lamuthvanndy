<?php include_once '../../config/database.php';?>
<?php 
function my_detail_date($v_main_id,$v_date_start,$v_date_end)
{
    global $connect;
   if(@$v_date_start!=''&&@$v_date_end!=''){
      $v_pre_year=date('Y',strtotime($v_date_start));
      $sql2="SELECT A.date_record,C.accca_account_name,C.accca_number,C.accca_id,
                (SELECT CONCAT(CAST(SUM(BB.debit) AS char(100)),'=',CAST(SUM(BB.credit) AS char(100))) FROM tbl_acc_add_tran_amount_detail AS BB 
                 LEFT JOIN tbl_acc_add_tran_amount AS AA ON BB.main_id=AA.id
                 WHERE B.main_id=BB.main_id 
                 AND DATE_FORMAT(A.date_record, '%Y-%m-%d') 
                 BETWEEN '$v_date_start' AND '$v_date_end' AND BB.acc_id=C.accca_id
                 AND AA.p_appr='1'
                 ) AS current_month_bal,

                (SELECT CONCAT(CAST(SUM(BB.debit) AS char(100)),'=',CAST(SUM(BB.credit) AS char(100))) 
                FROM tbl_acc_add_tran_amount_detail AS BB 
                 LEFT JOIN tbl_acc_add_tran_amount AS AA ON BB.main_id=AA.id
                 WHERE B.main_id=BB.main_id 
                  AND DATE_FORMAT(A.date_record, '%Y-%m-%d')<'$v_date_start' AND BB.acc_id=C.accca_id
                  AND AA.p_appr='1'
                  )AS old_month_bal,

               (SELECT CONCAT(CAST(SUM(BB.debit) AS char(100)),'=',CAST(SUM(BB.credit) AS char(100))) FROM tbl_acc_add_tran_amount_detail AS BB 
                 LEFT JOIN tbl_acc_add_tran_amount AS AA ON BB.main_id=AA.id
                 WHERE B.main_id=BB.main_id 
                 AND DATE_FORMAT(A.date_record, '%Y')<'$v_pre_year' AND BB.acc_id=C.accca_id
                 AND AA.p_appr='1'
                 ) AS current_year_bal

              FROM tbl_acc_add_tran_amount AS A 
              LEFT JOIN tbl_acc_add_tran_amount_detail AS B ON A.id=B.main_id
              LEFT JOIN tbl_acc_chart_account AS C ON B.acc_id=C.accca_id
              LEFT JOIN tbl_acc_type_account AS D ON C.accca_account_type=D.accta_id
              WHERE D.type_report_id='$v_main_id'
              GROUP BY C.accca_id
              UNION 
              SELECT A.date_record,C.accca_account_name,C.accca_number,C.accca_id,
                (SELECT CONCAT(CAST(SUM(BB.debit) AS char(100)),'=',CAST(SUM(BB.credit) AS char(100))) FROM tbl_acc_add_tran_dr_cr_detail AS BB 
                 LEFT JOIN tbl_acc_add_tran_dr_cr AS AA ON BB.main_id=AA.id
                 WHERE B.main_id=BB.main_id 
                 AND DATE_FORMAT(A.date_record, '%Y-%m-%d') 
                 BETWEEN '$v_date_start' AND '$v_date_end' AND BB.acc_id=C.accca_id
                 AND AA.p_appr='1'
                 ) AS current_month_bal,

                (SELECT CONCAT(CAST(SUM(BB.debit) AS char(100)),'=',CAST(SUM(BB.credit) AS char(100))) FROM tbl_acc_add_tran_dr_cr_detail AS BB 
                 LEFT JOIN tbl_acc_add_tran_dr_cr AS AA ON BB.main_id=AA.id
                 WHERE B.main_id=BB.main_id 
                 AND DATE_FORMAT(A.date_record, '%Y-%m-%d')<'$v_date_start' 
                 AND BB.acc_id=C.accca_id
                 AND AA.p_appr='1'
                 )AS old_month_bal,

                 (SELECT CONCAT(CAST(SUM(BB.debit) AS char(100)),'=',CAST(SUM(BB.credit) AS char(100))) FROM tbl_acc_add_tran_dr_cr_detail AS BB 
                 LEFT JOIN tbl_acc_add_tran_dr_cr AS AA ON BB.main_id=AA.id
                 WHERE B.main_id=BB.main_id 
                 AND DATE_FORMAT(A.date_record, '%Y')<='$v_pre_year' 
                 AND BB.acc_id=C.accca_id 
                 AND AA.p_appr='1'
                 )AS current_year_bal
              FROM tbl_acc_add_tran_dr_cr AS A 
              LEFT JOIN tbl_acc_add_tran_dr_cr_detail AS B ON A.id=B.main_id
              LEFT JOIN tbl_acc_chart_account AS C ON B.acc_id=C.accca_id
              LEFT JOIN tbl_acc_type_account AS D ON C.accca_account_type=D.accta_id
              WHERE D.type_report_id='$v_main_id'
              GROUP BY C.accca_id
              ";
        }
        else{
            $v_current_month=date('Y-m');
            $v_current_year=date('Y');
            $sql2="SELECT A.date_record,C.accca_account_name,C.accca_number,
                    (SELECT CONCAT(CAST(SUM(BB.debit) AS char(100)),'=',CAST(SUM(BB.credit) AS char(100))) FROM tbl_acc_add_tran_amount_detail AS BB 
                     LEFT JOIN tbl_acc_add_tran_amount AS AA ON BB.main_id=AA.id
                     WHERE B.main_id=BB.main_id AND DATE_FORMAT(A.date_record, '%Y-%m')='$v_current_month'  AND BB.acc_id=C.accca_id) AS current_month_bal,
                    (SELECT CONCAT(CAST(SUM(BB.debit) AS char(100)),'=',CAST(SUM(BB.credit) AS char(100))) FROM tbl_acc_add_tran_amount_detail AS BB 
                     LEFT JOIN tbl_acc_add_tran_amount AS AA ON BB.main_id=AA.id
                     WHERE B.main_id=BB.main_id AND DATE_FORMAT(A.date_record, '%Y-%m')<'$v_current_month' AND BB.acc_id=C.accca_id) AS old_month_bal,
                    (SELECT CONCAT(CAST(SUM(BB.debit) AS char(100)),'=',CAST(SUM(BB.credit) AS char(100))) FROM tbl_acc_add_tran_amount_detail AS BB 
                     LEFT JOIN tbl_acc_add_tran_amount AS AA ON BB.main_id=AA.id
                     WHERE B.main_id=BB.main_id AND DATE_FORMAT(A.date_record, '%Y')<='$v_current_year' AND BB.acc_id=C.accca_id) AS current_year_bal
                    FROM tbl_acc_add_tran_amount AS A 
                    LEFT JOIN tbl_acc_add_tran_amount_detail AS B ON A.id=B.main_id
                    LEFT JOIN tbl_acc_chart_account AS C ON B.acc_id=C.accca_id
                    LEFT JOIN tbl_acc_type_account AS D ON C.accca_account_type=D.accta_id
                    WHERE D.type_report_id='$v_main_id' AND A.p_appr='1'
                    GROUP BY C.accca_id
                    UNION 
                    SELECT A.date_record,C.accca_account_name,C.accca_number,
                    (SELECT CONCAT(CAST(SUM(BB.debit) AS char(100)),'=',CAST(SUM(BB.credit) AS char(100))) FROM tbl_acc_add_tran_dr_cr_detail AS BB 
                     LEFT JOIN tbl_acc_add_tran_dr_cr AS AA ON BB.main_id=AA.id
                     WHERE B.main_id=BB.main_id AND DATE_FORMAT(A.date_record, '%Y-%m')='$v_current_month'  AND BB.acc_id=C.accca_id) AS current_month_bal,
                    (SELECT CONCAT(CAST(SUM(BB.debit) AS char(100)),'=',CAST(SUM(BB.credit) AS char(100))) FROM tbl_acc_add_tran_dr_cr_detail AS BB 
                     LEFT JOIN tbl_acc_add_tran_dr_cr AS AA ON BB.main_id=AA.id
                     WHERE B.main_id=BB.main_id AND DATE_FORMAT(A.date_record, '%Y-%m')<'$v_current_month' AND BB.acc_id=C.accca_id) AS old_month_bal,
                     (SELECT CONCAT(CAST(SUM(BB.debit) AS char(100)),'=',CAST(SUM(BB.credit) AS char(100))) FROM tbl_acc_add_tran_dr_cr_detail AS BB 
                     LEFT JOIN tbl_acc_add_tran_dr_cr AS AA ON BB.main_id=AA.id
                     WHERE B.main_id=BB.main_id AND DATE_FORMAT(A.date_record, '%Y')<='$v_current_year' AND BB.acc_id=C.accca_id) AS current_year_bal
                    FROM tbl_acc_add_tran_dr_cr AS A 
                    LEFT JOIN tbl_acc_add_tran_dr_cr_detail AS B ON A.id=B.main_id
                    LEFT JOIN tbl_acc_chart_account AS C ON B.acc_id=C.accca_id
                    LEFT JOIN tbl_acc_type_account AS D ON C.accca_account_type=D.accta_id
                    WHERE D.type_report_id='$v_main_id' AND A.p_appr='1'
                    GROUP BY C.accca_id
                    GROUP BY B.accca_id
                    ";
        }
    return $connect->query($sql2);
  // return $sql2;
}

function bal_current_month($v_date_start,$v_date_end,$v_chart_acc_id){
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
function bal_pre_month($v_date_start,$v_date_end,$v_chart_acc_id){
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
function bal_cur_year($v_date_start,$v_date_end,$v_chart_acc_id){
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
function GetAccountName($acc_type_id){
    global $connect;
    // $arr_size=sizeof($sub_acc_id);
    $sql="SELECT accca_id,accca_number,accca_account_name,accca_account_type 
            FROM tbl_acc_chart_account AS A 
            LEFT JOIN tbl_acc_type_account AS B ON A.accca_account_type=B.accta_id
            LEFT JOIN tbl_acc_account_type_report AS C ON B.type_report_id=C.tr_id
            WHERE C.tr_id='$acc_type_id'";
    return $sql;
}
function AccountFormatNum($v_data){
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
