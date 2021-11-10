<?php include '../../config/database.php'; ?>
<?php 
$v_br='<br>';
$v_sp='&nbsp&nbsp';
$i=0;
$sql1=$connect->query("SELECT B.*,A.*,B.id AS aaa_id
	FROM tbl_acc_add_tran_amount AS A 
	LEFT JOIN tbl_acc_add_tran_amount_detail AS B ON A.id=B.main_id
	WHERE status='1'
	GROUP BY B.id");
while ($row1=mysqli_fetch_object($sql1)) {
    // echo $row1->ref_id.$v_br;
    if($row1->status_type=='1'){
        $sql2=$connect->query("SELECT detail_id FROM tbl_acc_cash_record_detail WHERE cash_rec_id='$row1->ref_id'");
    }
    else if($row1->status_type=='2'){
        $sql2=$connect->query("SELECT id AS detail_id FROM tbl_acc_none_sale_revenue_detial WHERE none_sale_rev_id='$row1->ref_id'");
    }
    else if($row1->status_type=='3'){
        $sql2=$connect->query("SELECT id AS detail_id FROM tbl_acc_none_bill_supp_detail WHERE none_bill_supp_id='$row1->ref_id'");
    }
    else if($row1->status_type=='4'){
        $sql2=$connect->query("SELECT id AS detail_id FROM tbl_acc_none_settle_advance_detail WHERE main_id='$row1->ref_id'");
    }
    while ($row2=mysqli_fetch_object($sql2)) {
    	$connect->query("UPDATE tbl_acc_add_tran_amount_detail 
    		SET ref_detail_id='$row2->detail_id' 
    		WHERE id='$row1->aaa_id'");
        // echo $row1->ref_id.$v_sp.$row2->detail_id.$v_br;
    }
}
 ?>