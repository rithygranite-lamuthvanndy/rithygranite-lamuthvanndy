<?php include_once '../../config/database.php'; ?>
<?php 
    function ii_detial($v_date)
    {
        global $connect;
        $i=0;
        $row_grand_total=0;
        $sql=$connect->query("SELECT A.*,
            (accdr_cash_in-accdr_cash_out) AS bal
            FROM tbl_acc_cash_record AS A 
            WHERE DATE_FORMAT(accdr_date,'%Y-%m-%d')='$v_date' 
            ");
        while ($row_cus=mysqli_fetch_object($sql)) {
            echo '<tr>';
                if($row_cus->rec_status==1){//Rec From
                    $sql_name=$connect->query("SELECT cussi_name FROM tbl_cus_customer_info WHERE cussi_id='$row_cus->rec_from_id'");
                    $row_main_cus=mysqli_fetch_object($sql_name);
                    $v_cus_name=$row_main_cus->cussi_name;
                }
                else if($row_cus->rec_status==2){//Other Rec
                    $sql_name=$connect->query("SELECT name FROM tbl_acc_other_rec_from_list WHERE id='$row_cus->rec_from_id'");
                    $row_main_cus=mysqli_fetch_object($sql_name);
                    $v_cus_name=$row_main_cus->name;
                }
                else if($row_cus->rec_status==3){//Pay To
                    $sql_name=$connect->query("SELECT supsi_name FROM tbl_sup_supplier_info WHERE supsi_id='$row_cus->rec_from_id'");
                    $row_main_cus=mysqli_fetch_object($sql_name);
                    $v_cus_name=$row_main_cus->supsi_name;
                }
                else if($row_cus->rec_status==4){//Other Pay to
                    $sql_name=$connect->query("SELECT name FROM tbl_acc_other_pay_to_list WHERE id='$row_cus->rec_from_id'");
                    $row_main_cus=mysqli_fetch_object($sql_name);
                    $v_cus_name=$row_main_cus->name;
                }

                if($row_cus->type_bank_id==1){
                    $v_leng_rithy=$row_cus->bal;
                    $v_rithy_granite=0;
                    $v_ncb_vn=0;
                    $v_director=0;
                }
                else if($row_cus->type_bank_id==3){
                    $v_leng_rithy=0;
                    $v_rithy_granite=$row_cus->bal;
                    $v_ncb_vn=0;
                    $v_director=0;
                }
                else if($row_cus->type_bank_id==6){
                    $v_leng_rithy=0;
                    $v_rithy_granite=0;
                    $v_ncb_vn=$row_cus->bal;
                    $v_director=0;
                }
                else if($row_cus->type_bank_id==7){
                    $v_leng_rithy=0;
                    $v_rithy_granite=0;
                    $v_ncb_vn=0;
                    $v_director=$row_cus->bal;
                }
                $row_grand_total+=$row_cus->bal;
                echo '<td class="text-center">'.++$i.'-'.$v_cus_name.'</td>';
                echo '<td class="text-center">'.number_format($row_cus->bal,2).' $</td>';
                echo '<td class="text-center">'.number_format($v_leng_rithy,2).'$</td>';
                echo '<td class="text-center"> '.number_format($v_rithy_granite,2).'$</td>';
                echo '<td class="text-center"> '.number_format($v_ncb_vn,2).'$</td>';
                echo '<td class="text-center"> '.number_format($v_director,2).'$</td>';
                echo '<td class="text-center"> '.number_format($row_cus->bal,2).'$</td>';
            echo '</tr>';
        }
    }

    function iii_2_1_detail($v_date_start,$v_date_end,$old_cash,$v_acc_id,$type_cash_bank)
    {
        global $connect;
        $i=0;
        $v_old_bal=round($old_cash,2);
        $flag_in=0;
        $flag_out=0;
        $sql1=$connect->query("SELECT 
            accdr_voucher_no AS A,
            CASE
                WHEN vou_type_id=6 THEN (price*qty)
            END AS B,
            CASE
                WHEN vou_type_id <>6 THEN (price*qty)
            END AS C,
            des_name AS des_tmp,
            GROUP_CONCAT(tran_note) AS tran_note
        FROM tbl_acc_cash_record AS A 
        LEFT JOIN tbl_acc_cash_record_detail AS B ON A.accdr_id=B.cash_rec_id 
        LEFT JOIN tbl_acc_decription AS C ON B.des_id=C.des_id
        WHERE (DATE_FORMAT(accdr_date,'%Y-%m-%d') BETWEEN '$v_date_start' AND '$v_date_end')
        AND type_bank_id='$type_cash_bank'
        GROUP BY B.detail_id
        UNION ALL
        SELECT 'Opening Balance' AS A, A2.debit AS B, A2.credit as C,
            'Opening Balance' AS des_tmp,
            '' AS tran_note
            FROM tbl_acc_add_tran_amount_detail AS A2 
            LEFT JOIN tbl_acc_chart_account AS B ON A2.acc_id=B.accca_id
            LEFT JOIN tbl_acc_add_tran_amount AS C ON A2.main_id=C.id
            WHERE A2.parent_id='0' 
            AND C.date_record BETWEEN '$v_date_start' AND '$v_date_end'
            AND C.status_type='5'
            AND A2.acc_id='$v_acc_id'
        -- SELECT 
        -- description AS A,
        -- debit AS B,
        -- credit AS C,
        -- description AS tmp
        -- FROM tbl_acc_open_bal
        -- WHERE (DATE_FORMAT(open_date,'%Y-%m-%d')='$v_date_start')
        -- AND chart_acc_id='6' 
        ");
        if(mysqli_num_rows($sql1)){
            while ($row_cash_on_hand=mysqli_fetch_object($sql1)) {
                // $flag_in+=$old_cash+$row_cash_on_hand->accdr_cash_in;
                echo '<tr>';
                    echo '<td class="text-right">'.sprintf('%02d',++$i).'</td>';
                    echo '<td class="text-left" style="width: 150px;">'.$row_cash_on_hand->A.'</td>';
                    echo '<td class="text-right" style="width: 100px;">-</td>';
                    echo '<td class="text-left">'.$row_cash_on_hand->des_tmp.'</td>';
                    echo '<td class="text-left">'.$row_cash_on_hand->tran_note.'</td>';
                    echo '<td class="text-center">$ '.round($row_cash_on_hand->B,2).'</td>';
                    echo '<td class="text-center">$ '.round($row_cash_on_hand->C,2).'</td>';
                    $flag_in+=$row_cash_on_hand->B;
                    $flag_out+=$row_cash_on_hand->C;
                    $v_old_bal= round($v_old_bal+$row_cash_on_hand->B-$row_cash_on_hand->C,2);
                    echo '<td class="text-center">$ '.round($v_old_bal,2).'</td>';
                echo '</tr>';
            }
        }
        else{
            echo '<tr>';
                echo '<td class="text-right">'.sprintf('%02d',++$i).'</td>';
                echo '<td class="text-right"></td>';
                echo '<td class="text-right"></td>';
                echo '<td class="text-right"></td>';
                echo '<td class="text-right"></td>';
                echo '<td class="text-right"></td>';
                echo '<td class="text-right"></td>';
                echo '<td class="text-right"></td>';
            echo '</tr>';
        }
    }

    function i_cash_on_hand_old_total($v_date_start)
    {
        global $connect;
        $sql=$connect->query("SELECT SUM(accdr_cash_in-accdr_cash_out) AS old_bal 
            FROM tbl_acc_cash_record 
            WHERE DATE_FORMAT(accdr_date,'%Y-%m-%d')<'$v_date_start' AND type_bank_id='8'");
        $row_old_bal1=mysqli_fetch_object($sql);
        $sql=$connect->query("SELECT SUM(A.debit-A.credit) AS old_bal
            FROM tbl_acc_add_tran_amount_detail AS A 
            LEFT JOIN tbl_acc_chart_account AS B ON A.acc_id=B.accca_id
            LEFT JOIN tbl_acc_add_tran_amount AS C ON A.main_id=C.id
            WHERE A.parent_id='0' 
            AND DATE_FORMAT(C.date_record,'%Y-%m-%d')<'$v_date_start' 
            AND acc_id='1'
            AND C.status_type='5'");
        $row_old_bal2=mysqli_fetch_object($sql);
        $total= $row_old_bal2->old_bal+ $row_old_bal1->old_bal;
        return $total;
    }
    function i_cash_on_hand_cash_in_total($v_date_start,$v_date_end)
    {
        global $connect;
        $sql=$connect->query("SELECT SUM(accdr_cash_in) AS cash_in
            FROM tbl_acc_cash_record 
            WHERE (DATE_FORMAT(accdr_date,'%Y-%m-%d') BETWEEN '$v_date_start' AND '$v_date_end')
            AND type_bank_id='8'");
        $row_cash_in1=mysqli_fetch_object($sql);

        
        $total=$row_cash_in1->cash_in;
        return ($total)?($total):"0";
    }
    function i_cash_on_hand_cash_out_total($v_date_start,$v_date_end)
    {
        global $connect;
        $sql=$connect->query("SELECT SUM(accdr_cash_out) AS cash_out
            FROM tbl_acc_cash_record WHERE (DATE_FORMAT(accdr_date,'%Y-%m-%d') BETWEEN '$v_date_start' AND '$v_date_end')
            AND type_bank_id='8'");
        $row_cash_out1=mysqli_fetch_object($sql);
        $total=$row_cash_out1->cash_out;
        return ($total)?($total):"0";
    }

    function i_re_cash_old_total($v_date)
    {
        global $connect;
        $sql=$connect->query("SELECT SUM(accdr_cash_in-accdr_cash_out) AS old_bal 
            FROM tbl_acc_cash_record WHERE DATE_FORMAT(accdr_date,'%Y-%m-%d')<'$v_date' AND tran_type_id='6'");
        $row_old_bal=mysqli_fetch_object($sql);
        return ($row_old_bal->old_bal)?($row_old_bal->old_bal):"0";
    }
    function i_re_cash_cash_in_total($v_date_start,$v_date_end)
    {
        global $connect;
        $sql=$connect->query("SELECT SUM(accdr_cash_in) AS cash_in
            FROM tbl_acc_cash_record WHERE (DATE_FORMAT(accdr_date,'%Y-%m-%d') BETWEEN '$v_date_start' AND '$v_date_end')  
            AND tran_type_id='6'");
        $row_cash_in=mysqli_fetch_object($sql);
        return ($row_cash_in->cash_in)?($row_cash_in->cash_in):"0";
    }
    function i_re_cash_cash_out_total($v_date_start,$v_date_end)
    {
        global $connect;
        $sql=$connect->query("SELECT SUM(accdr_cash_out) AS cash_out
            FROM tbl_acc_cash_record WHERE (DATE_FORMAT(accdr_date,'%Y-%m-%d') BETWEEN '$v_date_start' AND '$v_date_end') 
            AND tran_type_id='6'");
        $row_cash_out=mysqli_fetch_object($sql);
        return ($row_cash_out->cash_out)?($row_cash_out->cash_out):"0";
    }

    function i_cash_in_bank_old_total($v_date)
    {
        global $connect;
        $sql=$connect->query("SELECT SUM(accdr_cash_in-accdr_cash_out) AS old_bal 
            FROM tbl_acc_cash_record 
            WHERE (DATE_FORMAT(accdr_date,'%Y-%m-%d')<'$v_date' AND type_bank_id='1') 
            OR
            (DATE_FORMAT(accdr_date,'%Y-%m-%d')<'$v_date' AND type_bank_id='2')");
        $row_old_bal1=mysqli_fetch_object($sql);
        $sql=$connect->query("SELECT SUM(A.debit-A.credit) AS old_bal
            FROM tbl_acc_add_tran_amount_detail AS A 
            LEFT JOIN tbl_acc_chart_account AS B ON A.acc_id=B.accca_id
            LEFT JOIN tbl_acc_add_tran_amount AS C ON A.main_id=C.id
            WHERE A.parent_id='0' 
            AND DATE_FORMAT(C.date_record,'%Y-%m-%d')<'$v_date' 
            AND (acc_id='6' OR acc_id='7')
            AND C.status_type='5'");
        $row_old_bal2=mysqli_fetch_object($sql);
        $total=$row_old_bal1->old_bal+$row_old_bal2->old_bal;
        return ($total)?($total):"0";
    }
    function i_cash_in_bank_cash_in_total($v_date_start,$v_date_end)
    {
        global $connect;
        $sql=$connect->query("SELECT SUM(accdr_cash_in) AS cash_in
            FROM tbl_acc_cash_record 
            WHERE ((DATE_FORMAT(accdr_date,'%Y-%m-%d') BETWEEN '$v_date_start' AND '$v_date_end')
            AND type_bank_id='1') 
            OR
            ((DATE_FORMAT(accdr_date,'%Y-%m-%d')BETWEEN '$v_date_start' AND '$v_date_end')
            AND type_bank_id='2')");
        $row_cash_in1=mysqli_fetch_object($sql);
        $total=$row_cash_in1->cash_in;//+$row_cash_in2->cash_in;
        return ($total)?($total):"0";
    }
    function i_cash_in_bank_cash_out_total($v_date_start,$v_date_end)
    {
        global $connect;
        $sql=$connect->query("SELECT SUM(accdr_cash_out) AS cash_out
            FROM tbl_acc_cash_record 
            WHERE ((DATE_FORMAT(accdr_date,'%Y-%m-%d') BETWEEN '$v_date_start' AND '$v_date_end')
            AND type_bank_id='1') 
            OR 
            ((DATE_FORMAT(accdr_date,'%Y-%m-%d') BETWEEN '$v_date_start' AND '$v_date_end')
            AND type_bank_id='2')
            ");
        $row_cash_out1=mysqli_fetch_object($sql);
        $total=$row_cash_out1->cash_out;//+$row_cash_out2->cash_out;
        return ($total)?($total):"0";
    }

    function i_i_bank_old_total($v_date)
    {
        global $connect;
        $sql=$connect->query("SELECT SUM(accdr_cash_in-accdr_cash_out) AS old_bal 
            FROM tbl_acc_cash_record WHERE (DATE_FORMAT(accdr_date,'%Y-%m-%d')<'$v_date') AND type_bank_id='1'");
        $row_old_bal1=mysqli_fetch_object($sql);
        $sql=$connect->query("SELECT SUM(A.debit-A.credit) AS old_bal
            FROM tbl_acc_add_tran_amount_detail AS A 
            LEFT JOIN tbl_acc_chart_account AS B ON A.acc_id=B.accca_id
            LEFT JOIN tbl_acc_add_tran_amount AS C ON A.main_id=C.id
            WHERE A.parent_id='0' 
            AND DATE_FORMAT(C.date_record,'%Y-%m-%d')<'$v_date' 
            AND acc_id='6'
            AND C.status_type='5'");
        $row_old_bal2=mysqli_fetch_object($sql);
        $total=$row_old_bal1->old_bal+$row_old_bal2->old_bal;
        return ($total)?($total):"0";
    }
    function i_i_bank_cash_in_total($v_date_start,$v_date_end)
    {
        global $connect;
        $sql=$connect->query("SELECT SUM(accdr_cash_in) AS cash_in
            FROM tbl_acc_cash_record 
            WHERE (DATE_FORMAT(accdr_date,'%Y-%m-%d') BETWEEN '$v_date_start' AND '$v_date_end')
            AND type_bank_id='1'");
        $row_cash_in1=mysqli_fetch_object($sql);
        // $sql=$connect->query("SELECT SUM(debit) AS cash_in
        //     FROM tbl_acc_open_bal 
        //     WHERE (DATE_FORMAT(open_date,'%Y-%m-%d') BETWEEN '$v_date_start' AND '$v_date_end')
        //     AND chart_acc_id='6'");
        // $row_cash_in2=mysqli_fetch_object($sql);
        $total=$row_cash_in1->cash_in;//+$row_cash_in2->cash_in;
        return ($total)?($total):"0";
    }
    function i_i_bank_cash_out_total($v_date_start,$v_date_end)
    {
        global $connect;
        $sql=$connect->query("SELECT SUM(accdr_cash_out) AS cash_out
            FROM tbl_acc_cash_record WHERE (DATE_FORMAT(accdr_date,'%Y-%m-%d') BETWEEN '$v_date_start' AND '$v_date_end')
             AND type_bank_id='1'");
        $row_cash_out1=mysqli_fetch_object($sql);
        // $sql=$connect->query("SELECT SUM(credit) AS cash_out
        //     FROM tbl_acc_open_bal WHERE (DATE_FORMAT(open_date,'%Y-%m-%d') BETWEEN '$v_date_start' AND '$v_date_end')
        //      AND chart_acc_id='6'");
        // $row_cash_out2=mysqli_fetch_object($sql);
        $total=$row_cash_out1->cash_out;//+$row_cash_out2->cash_out;
        return ($total)?($total):"0";
    }

    function i_ii_bank_old_total($v_date)
    {
        global $connect;
        $sql=$connect->query("SELECT SUM(accdr_cash_in-accdr_cash_out) AS old_bal 
            FROM tbl_acc_cash_record WHERE DATE_FORMAT(accdr_date,'%Y-%m-%d')<'$v_date' AND type_bank_id='2'");
        $row_old_bal1=mysqli_fetch_object($sql);
        $sql=$connect->query("SELECT SUM(A.debit-A.credit) AS old_bal
            FROM tbl_acc_add_tran_amount_detail AS A 
            LEFT JOIN tbl_acc_chart_account AS B ON A.acc_id=B.accca_id
            LEFT JOIN tbl_acc_add_tran_amount AS C ON A.main_id=C.id
            WHERE A.parent_id='0' 
            AND DATE_FORMAT(C.date_record,'%Y-%m-%d')<'$v_date' 
            AND acc_id='7'
            AND C.status_type='5'");
        $row_old_bal2=mysqli_fetch_object($sql);
        $total=$row_old_bal1->old_bal+$row_old_bal2->old_bal;
        return ($total)?($total):"0";
    }
    function i_ii_bank_cash_in_total($v_date_start,$v_date_end)
    {
        global $connect;
        $sql=$connect->query("SELECT SUM(accdr_cash_in) AS cash_in
            FROM tbl_acc_cash_record WHERE (DATE_FORMAT(accdr_date,'%Y-%m-%d') BETWEEN '$v_date_start' AND '$v_date_end') 
            AND type_bank_id='2'");
        $row_cash_in1=mysqli_fetch_object($sql);
        $total=$row_cash_in1->cash_in;//+$row_cash_in2->cash_in;
        return ($total)?($total):"0";
    }
    function i_ii_bank_cash_out_total($v_date_start,$v_date_end)
    {
        global $connect;
        $sql=$connect->query("SELECT SUM(accdr_cash_out) AS cash_out
            FROM tbl_acc_cash_record WHERE (DATE_FORMAT(accdr_date,'%Y-%m-%d') BETWEEN '$v_date_start' AND '$v_date_end')
            AND type_bank_id='2'");
        $row_cash_out1=mysqli_fetch_object($sql);
        $total=$row_cash_out1->cash_out;//+$row_cash_out2->cash_out;
        return ($total)?($total):"0";
    }

 ?>