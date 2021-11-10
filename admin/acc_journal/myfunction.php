<?php 
    function myDetail1($v_ref_id,$statustable,$status_type){
        if($statustable==1){//Table add Transaction Amount
            if($status_type==1){//Add Cash record
                $sql1="SELECT accdr_voucher_no AS entry_no,B.name,
                    SUM(C.debit) AS debit,SUM(C.credit) AS credit,accca_number,accca_number,accca_account_name,description,tran_note
                    FROM tbl_acc_cash_record AS A 
                    LEFT JOIN tbl_acc_add_tran_amount AS B ON A.accdr_id=B.ref_id
                    LEFT JOIN tbl_acc_add_tran_amount_detail AS C ON B.id=C.main_id
                    LEFT JOIN tbl_acc_chart_account AS D ON C.acc_id=D.accca_id
                    WHERE B.ref_id='$v_ref_id' AND B.status_type=1
                    GROUP BY C.id"; 
            }
            else if($status_type==2){//Add None sale revenue
                $sql1="SELECT inv_no AS entry_no,B.name,
                    SUM(C.debit) AS debit,SUM(C.credit) AS credit,accca_number,accca_account_name,description,tran_note
                    FROM tbl_acc_none_sale_revenue AS A 
                    LEFT JOIN tbl_acc_add_tran_amount AS B ON A.id=B.ref_id
                    LEFT JOIN tbl_acc_add_tran_amount_detail AS C ON B.id=C.main_id
                    LEFT JOIN tbl_acc_chart_account AS D ON C.acc_id=D.accca_id
                    WHERE B.ref_id='$v_ref_id' AND B.status_type=2
                    GROUP BY C.id";
            }
            else if($status_type==3){//Add Bill Supplier
                $sql1="SELECT inv_no AS entry_no,B.name,
                    SUM(C.debit) AS debit,SUM(C.credit) AS credit,accca_number,accca_number,accca_account_name,description,tran_note
                    FROM tbl_acc_none_bill_supp AS A 
                    LEFT JOIN tbl_acc_add_tran_amount AS B ON A.id=B.ref_id
                    LEFT JOIN tbl_acc_add_tran_amount_detail AS C ON B.id=C.main_id
                    LEFT JOIN tbl_acc_chart_account AS D ON C.acc_id=D.accca_id
                    WHERE B.ref_id='$v_ref_id' AND B.status_type=3
                    GROUP BY C.id";
            }
            else if($status_type==4){//Add Settle advance
                $sql1="SELECT entry_no,B.name,
                    SUM(C.debit) AS debit,SUM(C.credit) AS credit,accca_number,accca_number,accca_account_name,description,tran_note
                    FROM tbl_acc_none_settle_advance AS A 
                    LEFT JOIN tbl_acc_add_tran_amount AS B ON A.id=B.ref_id
                    LEFT JOIN tbl_acc_add_tran_amount_detail AS C ON B.id=C.main_id
                    LEFT JOIN tbl_acc_chart_account AS D ON C.acc_id=D.accca_id
                    WHERE B.ref_id='$v_ref_id' AND B.status_type=4
                    GROUP BY C.id";
            }
        }
        else if($statustable==2){//Table Add transaction DR/CR
            if($status_type==1){//Add adjustment record
                $sql1="SELECT entry_no,'' AS name,
                    SUM(C.debit) AS debit,SUM(C.credit) AS credit,accca_number,accca_number,accca_account_name,description,tran_note
                    FROM tbl_acc_rec_adjustment AS A 
                    LEFT JOIN tbl_acc_add_tran_dr_cr AS B ON A.id=B.ref_id
                    LEFT JOIN tbl_acc_add_tran_dr_cr_detail AS C ON B.id=C.main_id
                    LEFT JOIN tbl_acc_chart_account AS D ON C.acc_id=D.accca_id
                    WHERE B.ref_id='$v_ref_id'
                    GROUP BY accca_number";
            }
            else if($status_type==2){//Add stock/inventory
                $sql1="SELECT entry_no ,'' AS name,
                    SUM(C.debit) AS debit,SUM(C.credit) AS credit,accca_number,accca_number,accca_account_name,description,tran_note
                    FROM tbl_acc_rec_stock_inventory AS A 
                    LEFT JOIN tbl_acc_add_tran_dr_cr AS B ON A.id=B.ref_id
                    LEFT JOIN tbl_acc_add_tran_dr_cr_detail AS C ON B.id=C.main_id
                    LEFT JOIN tbl_acc_chart_account AS D ON C.acc_id=D.accca_id
                    WHERE B.ref_id='$v_ref_id'
                    GROUP BY accca_number";
            }
        }
        // else if($statustable==3){
        //     if($status_type==3){
        //         $sql1="SELECT '-' AS entry_no ,'-' AS name,
        //                 SUM(C.debit) AS debit,SUM(C.credit) AS credit,accca_number,accca_account_name,'Openning Balance' AS description,'' AS tran_note
        //                 FROM  tbl_acc_open_bal AS A 
        //                 LEFT JOIN tbl_acc_chart_account AS B ON A.chart_acc_id=B.accca_id
        //                 WHERE A.id='$v_ref_id'
        //                 GROUP BY accca_number";
        //     }
        // }
        return @$sql1;
    }

    function myDetail2($v_ref_id,$statustable,$status_type,$strSearch){
        if($statustable==1){//Table add Transaction Amount
            if($status_type==1){//Add Cash record
                $sql1="SELECT accdr_voucher_no AS entry_no,B.name,description,tran_note,
                    SUM(C.debit) AS debit,SUM(C.credit) AS credit,accca_number,accca_number,accca_account_name
                    FROM tbl_acc_cash_record AS A 
                    LEFT JOIN tbl_acc_add_tran_amount AS B ON A.accdr_id=B.ref_id
                    LEFT JOIN tbl_acc_add_tran_amount_detail AS C ON B.id=C.main_id
                    LEFT JOIN tbl_acc_chart_account AS D ON C.acc_id=D.accca_id
                    WHERE B.ref_id='$v_ref_id' AND accdr_voucher_no ='$strSearch'
                    GROUP BY accca_number";
            }
            else if($status_type==2){//Add None sale revenue
                $sql1="SELECT inv_no AS entry_no,B.name,description,tran_note,
                    SUM(C.debit) AS debit,SUM(C.credit) AS credit,accca_number,accca_account_name
                    FROM tbl_acc_none_sale_revenue AS A 
                    LEFT JOIN tbl_acc_add_tran_amount AS B ON A.id=B.ref_id
                    LEFT JOIN tbl_acc_add_tran_amount_detail AS C ON B.id=C.main_id
                    LEFT JOIN tbl_acc_chart_account AS D ON C.acc_id=D.accca_id
                    WHERE B.ref_id='$v_ref_id' AND inv_no ='$strSearch'
                    GROUP BY accca_number";
            }
            else if($status_type==3){//Add Bill Supplier
                $sql1="SELECT inv_no AS entry_no,B.name,description,tran_note,
                    SUM(C.debit) AS debit,SUM(C.credit) AS credit,accca_number,accca_account_name
                    FROM tbl_acc_none_bill_supp AS A 
                    LEFT JOIN tbl_acc_add_tran_amount AS B ON A.id=B.ref_id
                    LEFT JOIN tbl_acc_add_tran_amount_detail AS C ON B.id=C.main_id
                    LEFT JOIN tbl_acc_chart_account AS D ON C.acc_id=D.accca_id
                    WHERE B.ref_id='$v_ref_id' AND inv_no ='$strSearch'
                    GROUP BY accca_number";
            }
            else if($status_type==4){//Add Settle advance
                $sql1="SELECT entry_no,B.name,description,tran_note,
                    SUM(C.debit) AS debit,SUM(C.credit) AS credit,accca_number,accca_account_name
                    FROM tbl_acc_none_settle_advance AS A 
                    LEFT JOIN tbl_acc_add_tran_amount AS B ON A.id=B.ref_id
                    LEFT JOIN tbl_acc_add_tran_amount_detail AS C ON B.id=C.main_id
                    LEFT JOIN tbl_acc_chart_account AS D ON C.acc_id=D.accca_id
                    WHERE B.ref_id='$v_ref_id' AND entry_no ='$strSearch'
                    GROUP BY accca_number";
            }
        }
        else if($statustable==2){//Table Add transaction DR/CR
            if($status_type==1){//Add adjustment record
                $sql1="SELECT entry_no,'' AS name,description,tran_note,
                    SUM(C.debit) AS debit,SUM(C.credit) AS credit,accca_number,accca_account_name
                    FROM tbl_acc_rec_adjustment AS A 
                    LEFT JOIN tbl_acc_add_tran_dr_cr AS B ON A.id=B.ref_id
                    LEFT JOIN tbl_acc_add_tran_dr_cr_detail AS C ON B.id=C.main_id
                    LEFT JOIN tbl_acc_chart_account AS D ON C.acc_id=D.accca_id
                    WHERE B.ref_id='$v_ref_id' AND entry_no ='$strSearch'
                    GROUP BY accca_number";
            }
            else if($status_type==2){//Add stock/inventory
                $sql1="SELECT entry_no ,'' AS name,description,tran_note,
                    SUM(C.debit) AS debit,SUM(C.credit) AS credit,accca_number,accca_account_name
                    FROM tbl_acc_rec_stock_inventory AS A 
                    LEFT JOIN tbl_acc_add_tran_dr_cr AS B ON A.id=B.ref_id
                    LEFT JOIN tbl_acc_add_tran_dr_cr_detail AS C ON B.id=C.main_id
                    LEFT JOIN tbl_acc_chart_account AS D ON C.acc_id=D.accca_id
                    WHERE B.ref_id='$v_ref_id' AND entry_no ='$strSearch'
                    GROUP BY accca_number";
            }
        }
        // else if($statustable==3){
        //     if($status_type==3){
        //         $sql1="SELECT '-' AS entry_no ,'-' AS name,
        //                 SUM(C.debit) AS debit,SUM(C.credit) AS credit,accca_number,accca_account_name,'Openning Balance' AS description,'' AS tran_note
        //                 FROM  tbl_acc_open_bal AS A 
        //                 LEFT JOIN tbl_acc_chart_account AS B ON A.chart_acc_id=B.accca_id
        //                 WHERE A.id='$v_ref_id'";
        //     }
        // }
        return @$sql1;
    }

    function myNumber($v_ref_id,$statustable,$status_type){
        if($statustable==1){//Table add Transaction Amount
            if($status_type==1){//Add Cash record
                $sql1="SELECT accdr_voucher_no as entry_no
                    FROM tbl_acc_cash_record AS A 
                    LEFT JOIN tbl_acc_add_tran_amount AS B ON A.accdr_id=B.ref_id
                    WHERE B.ref_id='$v_ref_id' 
                    GROUP BY accdr_voucher_no";
            }
            else if($status_type==2){//Add None sale revenue
                $sql1="SELECT inv_no AS entry_no
                    FROM tbl_acc_none_sale_revenue AS A 
                    WHERE B.ref_id='$v_ref_id'
                    GROUP BY inv_no";
            }
            else if($status_type==3){//Add Bill Supplier
                $sql1="SELECT inv_no AS entry_no,
                    FROM tbl_acc_none_bill_supp AS A 
                    LEFT JOIN tbl_acc_add_tran_amount AS B ON A.id=B.ref_id
                    WHERE B.ref_id='$v_ref_id'
                    GROUP BY inv_no";
            }
            else if($status_type==4){//Add Settle advance
                $sql1="SELECT entry_no,B.name
                    FROM tbl_acc_none_settle_advance AS A 
                    LEFT JOIN tbl_acc_add_tran_amount AS B ON A.id=B.ref_id
                    WHERE B.ref_id='$v_ref_id'
                    GROUP BY inv_no";
            }
        }
        else if($statustable==2){//Table Add transaction DR/CR
            if($status_type==1){//Add adjustment record
                $sql1="SELECT entry_no
                    FROM tbl_acc_rec_adjustment AS A 
                    LEFT JOIN tbl_acc_add_tran_dr_cr AS B ON A.id=B.ref_id
                    WHERE B.ref_id='$v_ref_id'
                    GROUP BY entry_no";
            }
            else if($status_type==2){//Add stock/inventory
                $sql1="SELECT entry_no 
                    FROM tbl_acc_rec_stock_inventory AS A 
                    LEFT JOIN tbl_acc_add_tran_dr_cr AS B ON A.id=B.ref_id
                    WHERE B.ref_id='$v_ref_id'
                    GROUP BY entry_no";
            }
        }
        return $sql1;
    }
 ?>