<?php 
	function getDataCur($v_start,$v_end,$chart_acc)
	{
		$v_month_cur=date('Y-m',strtotime($v_start));
		$get_data="SELECT A.accca_id,A.accca_number,A.accca_account_name,
                                        (SELECT SUM(AA.debit)
                                        FROM tbl_acc_add_tran_amount_detail AS AA
                                        LEFT JOIN tbl_acc_add_tran_amount AS BB ON AA.main_id=BB.id
                                        WHERE 
                                        AA.acc_id=A.accca_id 
                                        AND BB.p_appr='1'
                                        AND BB.date_record <='$v_end') AS total_debit1,
                                        (SELECT SUM(AA.credit) 
                                        FROM tbl_acc_add_tran_amount_detail AS AA
                                        LEFT JOIN tbl_acc_add_tran_amount AS BB ON AA.main_id=BB.id
                                        WHERE 
                                        AA.acc_id=A.accca_id 
                                        AND BB.p_appr='1'
                                        AND BB.date_record <='$v_end') AS total_credit1,
                                        (SELECT SUM(AA.debit) 
                                        FROM tbl_acc_add_tran_dr_cr_detail AS AA
                                        LEFT JOIN tbl_acc_add_tran_dr_cr AS BB ON AA.main_id=BB.id
                                        WHERE 
                                        AA.acc_id=A.accca_id 
                                        AND BB.p_appr='1'
                                        AND BB.date_record <='$v_end') AS total_debit2,
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
        return $get_data;
	}
 ?>