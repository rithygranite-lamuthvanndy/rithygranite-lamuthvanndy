<?php 
function calBalance($v_chart_acc,$v_debit,$v_credit)
{
	global $connect;
    $bal=0;
	//Update balance Add transation
    $sql1=$connect->query("SELECT A.*,C.tr_id
    FROM tbl_acc_chart_account AS A 
    LEFT JOIN tbl_acc_type_account AS B ON A.accca_account_type=B.accta_id
    LEFT JOIN tbl_acc_account_type_report AS C ON B.type_report_id=C.tr_id 
    WHERE A.accca_id='$v_chart_acc'");
    while ($row1=mysqli_fetch_object($sql1)) {
        if($row1->tr_id=='1'||$row1->tr_id=='6'||$row1->tr_id=='4')
            $bal=$v_debit-$v_credit;
        else
            $bal=-$v_debit+$v_credit;
    }
    return $bal;
}

function convertStringToDouble($str){
    $result=floatval(preg_replace('/[^\d.]/', '', $str));
    return $result;
}

 ?>