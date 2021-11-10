<?php 
	function myDetail1($v_ref_id,$statustable,$status_type){
		if($statustable==1){//Table add Transaction Amount
            if($status_type==1){//Add Cash record
                $sql1="SELECT accdr_voucher_no AS entry_no,B.name,
                    C.debit,C.credit,accca_number,accca_account_name,tran_note,doc_ref
                    FROM tbl_acc_cash_record AS A 
                    LEFT JOIN tbl_acc_add_tran_amount AS B ON A.accdr_id=B.ref_id
                    LEFT JOIN tbl_acc_add_tran_amount_detail AS C ON B.id=C.main_id
                    LEFT JOIN tbl_acc_chart_account AS D ON C.acc_id=D.accca_id
                    WHERE B.ref_id='$v_ref_id'";
            }
            else if($status_type==2){//Add None sale revenue
                $sql1="SELECT inv_no AS entry_no,B.name,
                    C.debit,C.credit,accca_number,accca_account_name,tran_note,doc_ref
                    FROM tbl_acc_none_sale_revenue AS A 
                    LEFT JOIN tbl_acc_add_tran_amount AS B ON A.id=B.ref_id
                    LEFT JOIN tbl_acc_add_tran_amount_detail AS C ON B.id=C.main_id
                    LEFT JOIN tbl_acc_chart_account AS D ON C.acc_id=D.accca_id
                    LEFT JOIN tbl_inv_feature AS E ON A.fea_id=E.id
                    WHERE B.ref_id='$v_ref_id'";
            }
            else if($status_type==3){//Add Bill Supplier
                $sql1="SELECT inv_no AS entry_no,B.name,
                    C.debit,C.credit,accca_number,accca_account_name,tran_note,doc_ref
                    FROM tbl_acc_none_bill_supp AS A 
                    LEFT JOIN tbl_acc_add_tran_amount AS B ON A.id=B.ref_id
                    LEFT JOIN tbl_acc_add_tran_amount_detail AS C ON B.id=C.main_id
                    LEFT JOIN tbl_acc_chart_account AS D ON C.acc_id=D.accca_id
                    WHERE B.ref_id='$v_ref_id'";
            }
            else if($status_type==4){//Add Settle advance
                $sql1="SELECT entry_no,B.name,
                    C.debit,C.credit,accca_number,accca_account_name,tran_note,doc_ref
                    FROM tbl_acc_none_settle_advance AS A 
                    LEFT JOIN tbl_acc_add_tran_amount AS B ON A.id=B.ref_id
                    LEFT JOIN tbl_acc_add_tran_amount_detail AS C ON B.id=C.main_id
                    LEFT JOIN tbl_acc_chart_account AS D ON C.acc_id=D.accca_id
                    WHERE B.ref_id='$v_ref_id'";
            }
        }
        else if($statustable==2){//Table Add transaction DR/CR
            if($status_type==1){//Add adjustment record
                $sql1="SELECT entry_no,'' AS name,
                    C.debit,C.credit,accca_number,accca_account_name,tran_note,doc_ref
                    FROM tbl_acc_rec_adjustment AS A 
                    LEFT JOIN tbl_acc_add_tran_dr_cr AS B ON A.id=B.ref_id
                    LEFT JOIN tbl_acc_add_tran_dr_cr_detail AS C ON B.id=C.main_id
                    LEFT JOIN tbl_acc_chart_account AS D ON C.acc_id=D.accca_id
                    WHERE B.ref_id='$v_ref_id'";
            }
            else if($status_type==2){//Add stock/inventory
                $sql1=$connect->query("SELECT entry_no ,'' AS name,
                    C.debit,C.credit,accca_number,accca_account_name,tran_note,doc_ref
                    FROM tbl_acc_rec_stock_inventory AS A 
                    LEFT JOIN tbl_acc_add_tran_dr_cr AS B ON A.id=B.ref_id
                    LEFT JOIN tbl_acc_add_tran_dr_cr_detail AS C ON B.id=C.main_id
                    LEFT JOIN tbl_acc_chart_account AS D ON C.acc_id=D.accca_id
                    WHERE B.ref_id='$v_ref_id'");
            }
        }
        return $sql1;
	}

    function myDetail2($v_ref_id,$statustable,$status_type,$strSearch){
        if($statustable==1){//Table add Transaction Amount
            if($status_type==1){//Add Cash record
                $sql1="SELECT accdr_voucher_no AS entry_no,B.name,tran_note,doc_ref,
                    C.debit,C.credit,accca_number,accca_account_name
                    FROM tbl_acc_cash_record AS A 
                    LEFT JOIN tbl_acc_add_tran_amount AS B ON A.accdr_id=B.ref_id
                    LEFT JOIN tbl_acc_add_tran_amount_detail AS C ON B.id=C.main_id
                    LEFT JOIN tbl_acc_chart_account AS D ON C.acc_id=D.accca_id
                    WHERE B.ref_id='$v_ref_id' AND accdr_voucher_no ='$strSearch'";
            }
            else if($status_type==2){//Add None sale revenue
                $sql1="SELECT inv_no AS entry_no,B.name,tran_note,doc_ref,
                    C.debit,C.credit,accca_number,accca_account_name
                    FROM tbl_acc_none_sale_revenue AS A 
                    LEFT JOIN tbl_acc_add_tran_amount AS B ON A.id=B.ref_id
                    LEFT JOIN tbl_acc_add_tran_amount_detail AS C ON B.id=C.main_id
                    LEFT JOIN tbl_acc_chart_account AS D ON C.acc_id=D.accca_id
                    WHERE B.ref_id='$v_ref_id' AND inv_no ='$strSearch'";
            }
            else if($status_type==3){//Add Bill Supplier
                $sql1="SELECT inv_no AS entry_no,B.name,tran_note,doc_ref,
                    C.debit,C.credit,accca_number,accca_account_name
                    FROM tbl_acc_none_bill_supp AS A 
                    LEFT JOIN tbl_acc_add_tran_amount AS B ON A.id=B.ref_id
                    LEFT JOIN tbl_acc_add_tran_amount_detail AS C ON B.id=C.main_id
                    LEFT JOIN tbl_acc_chart_account AS D ON C.acc_id=D.accca_id
                    WHERE B.ref_id='$v_ref_id' AND inv_no ='$strSearch'";
            }
            else if($status_type==4){//Add Settle advance
                $sql1="SELECT entry_no,B.name,tran_note,doc_ref,
                    C.debit,C.credit,accca_number,accca_account_name
                    FROM tbl_acc_none_settle_advance AS A 
                    LEFT JOIN tbl_acc_add_tran_amount AS B ON A.id=B.ref_id
                    LEFT JOIN tbl_acc_add_tran_amount_detail AS C ON B.id=C.main_id
                    LEFT JOIN tbl_acc_chart_account AS D ON C.acc_id=D.accca_id
                    WHERE B.ref_id='$v_ref_id' AND entry_no ='$strSearch'";
            }
        }
        else if($statustable==2){//Table Add transaction DR/CR
            if($status_type==1){//Add adjustment record
                $sql1="SELECT entry_no,'' AS name,tran_note,doc_ref,
                    C.debit,C.credit,accca_number,accca_account_name
                    FROM tbl_acc_rec_adjustment AS A 
                    LEFT JOIN tbl_acc_add_tran_dr_cr AS B ON A.id=B.ref_id
                    LEFT JOIN tbl_acc_add_tran_dr_cr_detail AS C ON B.id=C.main_id
                    LEFT JOIN tbl_acc_chart_account AS D ON C.acc_id=D.accca_id
                    WHERE B.ref_id='$v_ref_id' AND entry_no ='$strSearch'";
            }
            else if($status_type==2){//Add stock/inventory
                $sql1=$connect->query("SELECT entry_no ,'' AS name,tran_note,doc_ref,
                    C.debit,C.credit,accca_number,accca_account_name
                    FROM tbl_acc_rec_stock_inventory AS A 
                    LEFT JOIN tbl_acc_add_tran_dr_cr AS B ON A.id=B.ref_id
                    LEFT JOIN tbl_acc_add_tran_dr_cr_detail AS C ON B.id=C.main_id
                    LEFT JOIN tbl_acc_chart_account AS D ON C.acc_id=D.accca_id
                    WHERE B.ref_id='$v_ref_id' AND entry_no ='$strSearch'");
            }
        }
        return $sql1;
    }

    function myNumber($v_ref_id,$statustable,$status_type){
        if($statustable==1){//Table add Transaction Amount
            if($status_type==1){//Add Cash record
                $sql1="SELECT accdr_voucher_no as entry_no
                    FROM tbl_acc_cash_record AS A 
                    LEFT JOIN tbl_acc_add_tran_amount AS B ON A.accdr_id=B.ref_id
                    WHERE B.ref_id='$v_ref_id'";
            }
            else if($status_type==2){//Add None sale revenue
                $sql1="SELECT inv_no AS entry_no
                    FROM tbl_acc_none_sale_revenue AS A 
                    WHERE B.ref_id='$v_ref_id'";
            }
            else if($status_type==3){//Add Bill Supplier
                $sql1="SELECT inv_no AS entry_no,
                    FROM tbl_acc_none_bill_supp AS A 
                    LEFT JOIN tbl_acc_add_tran_amount AS B ON A.id=B.ref_id
                    WHERE B.ref_id='$v_ref_id'";
            }
            else if($status_type==4){//Add Settle advance
                $sql1="SELECT entry_no,B.name
                    FROM tbl_acc_none_settle_advance AS A 
                    LEFT JOIN tbl_acc_add_tran_amount AS B ON A.id=B.ref_id
                    WHERE B.ref_id='$v_ref_id'";
            }
        }
        else if($statustable==2){//Table Add transaction DR/CR
            if($status_type==1){//Add adjustment record
                $sql1="SELECT entry_no
                    FROM tbl_acc_rec_adjustment AS A 
                    LEFT JOIN tbl_acc_add_tran_dr_cr AS B ON A.id=B.ref_id
                    WHERE B.ref_id='$v_ref_id'";
            }
            else if($status_type==2){//Add stock/inventory
                $sql1="SELECT entry_no 
                    FROM tbl_acc_rec_stock_inventory AS A 
                    LEFT JOIN tbl_acc_add_tran_dr_cr AS B ON A.id=B.ref_id
                    WHERE B.ref_id='$v_ref_id'";
            }
        }
        return $sql1;
    }
 ?>