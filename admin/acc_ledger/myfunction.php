<?php 
	function myDetailDate($v_date_start,$v_date_end,$v_chat_acc1,$v_chat_acc2){
        if($v_date_start!=''&&$v_date_end!=''){
            if($v_chat_acc1!=''){
                    $sql="SELECT AA.id AS main_id,A.debit AS my_debit,A.credit AS my_credit,
                B.accca_id,B.accca_account_name,AA.date_record,CONCAT('amo',AA.status_type) AS f_status
                                FROM tbl_acc_add_tran_amount_detail AS A 
                                LEFT JOIN tbl_acc_add_tran_amount AS AA ON A.main_id=AA.id
                                LEFT JOIN tbl_acc_chart_account AS B ON A.acc_id=B.accca_id
                                -- LEFT JOIN tbl_acc_add_tran_amount_detail AS ZZ ON ZZ.main_id=A.main_id 
                                WHERE A.acc_id='$v_chat_acc1' 
                                AND (date_record BETWEEN '$v_date_start' AND '$v_date_end') AND AA.p_appr='1'
                                UNION ALL
                                SELECT AA.id AS main_id,A.debit AS my_debit,A.credit AS my_credit,
                                B.accca_id,B.accca_account_name,AA.date_record,CONCAT('dr_cr',AA.status_type) AS f_status
                                FROM tbl_acc_add_tran_dr_cr_detail AS A 
                                LEFT JOIN tbl_acc_add_tran_dr_cr AS AA ON A.main_id=AA.id
                                LEFT JOIN tbl_acc_chart_account AS B ON A.acc_id=B.accca_id
                                -- LEFT JOIN tbl_acc_add_tran_dr_cr_detail AS ZZ ON ZZ.main_id=A.main_id 
                                WHERE A.acc_id='$v_chat_acc1' AND AA.p_appr='1'
                                AND (date_record BETWEEN '$v_date_start' AND '$v_date_end') AND AA.p_appr='1'
                                GROUP BY A.id 
                                ORDER BY main_id,date_record ASC";
            }
            else{
                $sql="SELECT AA.id AS main_id,A.debit AS my_debit,A.credit AS my_credit,
                B.accca_id,B.accca_account_name,AA.date_record,CONCAT('amo',AA.status_type) AS f_status
                                FROM tbl_acc_add_tran_amount_detail AS A 
                                LEFT JOIN tbl_acc_add_tran_amount AS AA ON A.main_id=AA.id
                                LEFT JOIN tbl_acc_chart_account AS B ON A.acc_id=B.accca_id
                                -- LEFT JOIN tbl_acc_add_tran_amount_detail AS ZZ ON ZZ.main_id=A.main_id 
                                WHERE A.acc_id='$v_chat_acc2'
                                AND (date_record BETWEEN '$v_date_start' AND '$v_date_end') AND AA.p_appr='1'
                                UNION ALL
                                SELECT AA.id AS main_id,A.debit AS my_debit,A.credit AS my_credit,
                                B.accca_id,B.accca_account_name,AA.date_record,CONCAT('dr_cr',AA.status_type) AS f_status
                                FROM tbl_acc_add_tran_dr_cr_detail AS A 
                                LEFT JOIN tbl_acc_add_tran_dr_cr AS AA ON A.main_id=AA.id
                                LEFT JOIN tbl_acc_chart_account AS B ON A.acc_id=B.accca_id
                                -- LEFT JOIN tbl_acc_add_tran_dr_cr_detail AS ZZ ON ZZ.main_id=A.main_id 
                                WHERE A.acc_id='$v_chat_acc2' AND AA.p_appr='1'
                                AND (date_record BETWEEN '$v_date_start' AND '$v_date_end') AND AA.p_appr='1'
                                GROUP BY A.id 
                                ORDER BY main_id,date_record ASC";
            }
        }
        return $sql;
	}

    function myNormal($v_chat_acc){
        $v_current_date=date('Y-m-d');
        $sql="SELECT AA.id AS main_id,A.debit AS my_debit,A.credit AS my_credit,
        B.accca_id,B.accca_account_name,AA.date_record,CONCAT('amo',AA.status_type) AS f_status
                                FROM tbl_acc_add_tran_amount_detail AS A 
                                LEFT JOIN tbl_acc_add_tran_amount AS AA ON A.main_id=AA.id
                                LEFT JOIN tbl_acc_chart_account AS B ON A.acc_id=B.accca_id
                                -- LEFT JOIN tbl_acc_add_tran_amount_detail AS ZZ ON ZZ.main_id=A.main_id 
                                WHERE A.acc_id='$v_chat_acc' AND AA.p_appr='1'
                                AND date_record= '$v_current_date'
                                UNION
                                SELECT AA.id AS main_id,A.debit AS my_debit,A.credit AS my_credit,
                                B.accca_id,B.accca_account_name,AA.date_record,CONCAT('dr_cr',AA.status_type) AS f_status
                                FROM tbl_acc_add_tran_dr_cr_detail AS A 
                                LEFT JOIN tbl_acc_add_tran_dr_cr AS AA ON A.main_id=AA.id
                                LEFT JOIN tbl_acc_chart_account AS B ON A.acc_id=B.accca_id
                                -- LEFT JOIN tbl_acc_add_tran_dr_cr_detail AS ZZ ON ZZ.main_id=A.main_id 
                                WHERE A.acc_id='$v_chat_acc' AND AA.p_appr='1'
                                AND date_record= '$v_current_date'
                                GROUP BY A.id
                                ORDER BY date_record ASC";
        return $sql;
    }

    function myDetailDate1($v_date_start,$v_date_end,$v_chat_acc){
        $v_date=date('Y-m',strtotime($v_date_start));
        $sql="SELECT 
            SUM(A.debit) AS my_debit,
            (SELECT SUM(debit) FROM tbl_acc_add_tran_dr_cr_detail 
                LEFT JOIN tbl_acc_add_tran_dr_cr ON tbl_acc_add_tran_dr_cr_detail.main_id=tbl_acc_add_tran_dr_cr.id 
                WHERE acc_id='$v_chat_acc' AND tbl_acc_add_tran_dr_cr.p_appr='1' AND DATE_FORMAT(tbl_acc_add_tran_dr_cr.date_record,'%Y-%m')<'$v_date'
            ) as my_debit1,
            SUM(A.credit) AS my_credit,
            (SELECT SUM(credit) FROM tbl_acc_add_tran_dr_cr_detail
                LEFT JOIN tbl_acc_add_tran_dr_cr ON tbl_acc_add_tran_dr_cr_detail.main_id=tbl_acc_add_tran_dr_cr.id 
                WHERE acc_id='$v_chat_acc' AND tbl_acc_add_tran_dr_cr.p_appr='1' AND DATE_FORMAT(tbl_acc_add_tran_dr_cr.date_record,'%Y-%m')<'$v_date'
            ) as my_credit1,
            A.acc_id AS accca_id
        FROM tbl_acc_add_tran_amount_detail as A
        LEFT JOIN tbl_acc_add_tran_amount AS AA ON A.main_id=AA.id
        WHERE A.acc_id='$v_chat_acc'
            AND AA.p_appr='1' 
            AND DATE_FORMAT(date_record,'%Y-%m')<'$v_date'
        ";
        return $sql;
    }
    function myNormal1($v_chat_acc){
        $v_date=date('Y-m');
        $sql="SELECT 
            SUM(A.debit) AS my_debit,
            (SELECT SUM(debit) FROM tbl_acc_add_tran_dr_cr_detail 
                LEFT JOIN tbl_acc_add_tran_dr_cr ON tbl_acc_add_tran_dr_cr_detail.main_id=tbl_acc_add_tran_dr_cr.id 
                WHERE acc_id='$v_chat_acc' AND tbl_acc_add_tran_dr_cr.p_appr='1' AND DATE_FORMAT(tbl_acc_add_tran_dr_cr.date_record,'%Y-%m')<'$v_date'
            ) as my_debit1,
            SUM(A.credit) AS my_credit,
            (SELECT SUM(credit) FROM tbl_acc_add_tran_dr_cr_detail
                LEFT JOIN tbl_acc_add_tran_dr_cr ON tbl_acc_add_tran_dr_cr_detail.main_id=tbl_acc_add_tran_dr_cr.id 
                WHERE acc_id='$v_chat_acc' AND tbl_acc_add_tran_dr_cr.p_appr='1' AND DATE_FORMAT(tbl_acc_add_tran_dr_cr.date_record,'%Y-%m')<'$v_date'
            ) as my_credit1,
            A.acc_id AS accca_id
        FROM tbl_acc_add_tran_amount_detail as A
        LEFT JOIN tbl_acc_add_tran_amount AS AA ON A.main_id=AA.id
        WHERE A.acc_id='$v_chat_acc' 
            AND AA.p_appr='1' 
            AND DATE_FORMAT(date_record,'%Y-%m')<'$v_date'
        ";
        return $sql;
                                // -- LEFT JOIN tbl_acc_add_tran_amount_detail AS ZZ ON ZZ.main_id=A.main_id 
    }

    function getNo($v_main_id,$v_status){
        global $connect;
        if($v_status=='amo1'){
            $v_type='Add Cash Record Voucher';
            $sql11="SELECT accdr_voucher_no AS no
                FROM tbl_acc_cash_record AS A 
                LEFT JOIN tbl_acc_add_tran_amount AS B ON A.accdr_id=B.ref_id 
                WHERE B.id='$v_main_id'";
        }
        else if($v_status=='amo2'){
            $v_type='Invocie Sale Revenue';
            $sql11="SELECT inv_no AS no
                FROM tbl_acc_none_sale_revenue AS A 
                LEFT JOIN tbl_acc_add_tran_amount AS B ON A.id=B.ref_id 
                WHERE B.id='$v_main_id'";
        }
        else if($v_status=='amo3'){
            $v_type='Bill Supplier';
            $sql11="SELECT inv_no AS no
                FROM tbl_acc_none_bill_supp AS A 
                LEFT JOIN tbl_acc_add_tran_amount AS B ON A.id=B.ref_id 
                WHERE B.id='$v_main_id'";
        }
        else if($v_status=='amo4'){
            $v_type='Settle Advance';
            $sql11="SELECT entry_no AS no
                FROM tbl_acc_none_settle_advance AS A 
                LEFT JOIN tbl_acc_add_tran_amount AS B ON A.id=B.ref_id 
                WHERE B.id='$v_main_id'";
        }
        else if($v_status=='amo5'){
            $v_type='Openning Balance';
            $sql11="SELECT '' AS no
                FROM tbl_acc_add_tran_amount AS B 
                WHERE B.id='$v_main_id'";
        }
        else if($v_status=='dr_cr1'){
            $v_type='Adjustment Record';
            $sql11="SELECT entry_no AS no
                FROM tbl_acc_rec_adjustment AS A 
                LEFT JOIN tbl_acc_add_tran_dr_cr AS B ON A.id=B.ref_id 
                WHERE B.id='$v_main_id'";
        }
        else if($v_status=='dr_cr2'){
            $v_type='Stock/Inventory Record';
            $sql11="SELECT entry_no AS no
                FROM tbl_acc_rec_stock_inventory AS A 
                LEFT JOIN tbl_acc_add_tran_dr_cr AS B ON A.id=B.ref_id 
                WHERE B.id='$v_main_id'";
        }
        else if($v_status=='dr_cr3'){
            $v_type='Transfer Funds';
            $sql11="SELECT tran_ref_no AS no
                FROM tbl_acc_add_transfer_fund AS A 
                LEFT JOIN tbl_acc_add_tran_dr_cr AS B ON A.id=B.ref_id 
                WHERE B.id='$v_main_id'";
        }
        return [$sql11,$v_type];
    }
 ?>