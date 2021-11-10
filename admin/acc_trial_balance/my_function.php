<?php include_once '../../config/database.php';?>
<?php 
function my_detail_date($v_start,$v_end,$chart_acc=null)
{
	global $connect;
        $v_month_cur=date('Y-m',strtotime($v_start));
        if($chart_acc!=null){
                $get_data="SELECT A.accca_id,A.accca_number,A.accca_account_name,
                                        (SELECT SUM(AA.debit)
                                        FROM tbl_acc_add_tran_amount_detail AS AA
                                        LEFT JOIN tbl_acc_add_tran_amount AS BB ON AA.main_id=BB.id
                                        WHERE 
                                        AA.acc_id=A.accca_id 
                                        AND BB.p_appr='1'
                                        AND BB.date_record BETWEEN '$v_start' AND '$v_end') AS total_debit1,
                                        (SELECT SUM(AA.credit) 
                                        FROM tbl_acc_add_tran_amount_detail AS AA
                                        LEFT JOIN tbl_acc_add_tran_amount AS BB ON AA.main_id=BB.id
                                        WHERE 
                                        AA.acc_id=A.accca_id 
                                        AND BB.p_appr='1'
                                        AND BB.date_record BETWEEN '$v_start' AND '$v_end') AS total_credit1,
                                        (SELECT SUM(AA.debit) 
                                        FROM tbl_acc_add_tran_dr_cr_detail AS AA
                                        LEFT JOIN tbl_acc_add_tran_dr_cr AS BB ON AA.main_id=BB.id
                                        WHERE 
                                        AA.acc_id=A.accca_id 
                                        AND BB.p_appr='1'
                                        AND BB.date_record BETWEEN '$v_start' AND '$v_end') AS total_debit2,
                                        (SELECT SUM(AA.credit) 
                                        FROM tbl_acc_add_tran_dr_cr_detail AS AA
                                        LEFT JOIN tbl_acc_add_tran_dr_cr AS BB ON AA.main_id=BB.id
                                        WHERE 
                                        AA.acc_id=A.accca_id 
                                        AND BB.p_appr='1'
                                        AND BB.date_record BETWEEN '$v_start' AND '$v_end') AS total_credit2
                                FROM tbl_acc_chart_account AS A
                                WHERE A.accca_id='$chart_acc'
                                ";
        }
        else{
                $get_data="SELECT A.accca_id,A.accca_number,A.accca_account_name,
                                        (SELECT SUM(AA.debit) 
                                        FROM tbl_acc_add_tran_amount_detail AS AA
                                        LEFT JOIN tbl_acc_add_tran_amount AS BB ON AA.main_id=BB.id
                                        WHERE 
                                        AA.acc_id=A.accca_id 
                                        AND BB.p_appr='1'
                                        AND DATE_FORMAT(BB.date_record,'%Y-%m')<'$v_month_cur') AS total_debit1,
                                        (SELECT SUM(AA.credit) 
                                        FROM tbl_acc_add_tran_amount_detail AS AA
                                        LEFT JOIN tbl_acc_add_tran_amount AS BB ON AA.main_id=BB.id
                                        WHERE 
                                        AA.acc_id=A.accca_id 
                                        AND BB.p_appr='1'
                                        AND DATE_FORMAT(BB.date_record,'%Y-%m')<'$v_month_cur') AS total_credit1,
                                        (SELECT SUM(AA.debit) 
                                        FROM tbl_acc_add_tran_dr_cr_detail AS AA
                                        LEFT JOIN tbl_acc_add_tran_dr_cr AS BB ON AA.main_id=BB.id
                                        WHERE 
                                        AA.acc_id=A.accca_id 
                                        AND BB.p_appr='1'
                                        AND DATE_FORMAT(BB.date_record,'%Y-%m')<'$v_month_cur') AS total_debit2,
                                        (SELECT SUM(AA.credit) 
                                        FROM tbl_acc_add_tran_dr_cr_detail AS AA
                                        LEFT JOIN tbl_acc_add_tran_dr_cr AS BB ON AA.main_id=BB.id
                                        WHERE 
                                        AA.acc_id=A.accca_id 
                                        AND BB.p_appr='1'
                                        AND DATE_FORMAT(BB.date_record,'%Y-%m')<'$v_month_cur') AS total_credit2
                                        FROM tbl_acc_chart_account AS A
                                ";

        }

	return $get_data;
}

function my_detail_normal()
{
	global $connect;
        $get_data="SELECT A.accca_id,A.accca_number,A.accca_account_name,
                        (SELECT SUM(AA.debit) 
                        FROM tbl_acc_add_tran_amount_detail AS AA
                        LEFT JOIN tbl_acc_add_tran_amount AS BB ON AA.main_id=BB.id
                        WHERE AA.acc_id=A.accca_id AND BB.p_appr='1') AS total_debit1,
                        (SELECT SUM(AA.credit) 
                        FROM tbl_acc_add_tran_amount_detail AS AA
                        LEFT JOIN tbl_acc_add_tran_amount AS BB ON AA.main_id=BB.id
                        WHERE AA.acc_id=A.accca_id AND BB.p_appr='1') AS total_credit1,
                        (SELECT SUM(AA.debit) 
                        FROM tbl_acc_add_tran_dr_cr_detail AS AA
                        LEFT JOIN tbl_acc_add_tran_dr_cr AS BB ON AA.main_id=BB.id
                        WHERE AA.acc_id=A.accca_id AND BB.p_appr='1') AS total_debit2,
                        (SELECT SUM(AA.credit) 
                        FROM tbl_acc_add_tran_dr_cr_detail AS AA
                        LEFT JOIN tbl_acc_add_tran_dr_cr AS BB ON AA.main_id=BB.id
                        WHERE AA.acc_id=A.accca_id AND BB.p_appr='1') AS total_credit2
                FROM tbl_acc_chart_account AS A";
	return $get_data;
}
function Show_Trial_bal($chart_acc_id,$bal){
        global $connect;
        $res_debit='';
        $res_credit='';
        $sql=$connect->query("SELECT C.tr_id
                FROM tbl_acc_chart_account AS A 
                LEFT JOIN  tbl_acc_type_account AS B ON A.accca_account_type=B.accta_id
                LEFT JOIN  tbl_acc_account_type_report AS C ON B.type_report_id=C.tr_id
                WHERE A.accca_id='$chart_acc_id'");

        $row_result=mysqli_fetch_object($sql);
        if($row_result->tr_id=='1'||$row_result->tr_id=='6'||$row_result->tr_id=='4'){
                if($bal>0)
                        $res_debit=$bal;
                else
                        $res_credit=$bal;
        }
        else{
                if($bal>0)
                        $res_credit=$bal;
                else
                        $res_debit=$bal;
        }
        return [$res_debit,$res_credit];
}
function myFormat($value){
        if($value<=0){
                return '-';
        }
        else{
                return number_format($value,2);
        }
}

 ?>
