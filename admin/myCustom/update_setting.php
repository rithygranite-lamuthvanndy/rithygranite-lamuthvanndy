<?php include_once '../../config/database.php'; ?>
<?php 
$sql1=$connect->query("SELECT * FROM tbl_acc_open_bal");
while ($row1=mysqli_fetch_object($sql1)) {
	$sql2=$connect->query("SELECT A.*,C.tr_id
	FROM tbl_acc_chart_account AS A 
	LEFT JOIN tbl_acc_type_account AS B ON A.accca_account_type=B.accta_id
	LEFT JOIN tbl_acc_account_type_report AS C ON B.type_report_id=C.tr_id");
	while ($row2=mysqli_fetch_object($sql2)) {
		if($row2->tr_id=='1'||$row2->tr_id=='6'||$row2->tr_id=='4')
			$bal=$row1->debit-$row1->credit;
		else
			$bal=-$row1->debit+$row1->credit;
		$connect->query("UPDATE tbl_acc_open_bal SET bal='$bal' WHERE id='$row1->id' AND chart_acc_id='$row2->accca_id'");
	}
}
 ?>
<?php 
$sql1=$connect->query("SELECT * FROM tbl_acc_add_tran_amount_detail");
while ($row1=mysqli_fetch_object($sql1)) {
	$sql2=$connect->query("SELECT A.*,C.tr_id
	FROM tbl_acc_chart_account AS A 
	LEFT JOIN tbl_acc_type_account AS B ON A.accca_account_type=B.accta_id
	LEFT JOIN tbl_acc_account_type_report AS C ON B.type_report_id=C.tr_id");
	while ($row2=mysqli_fetch_object($sql2)) {
		if($row2->tr_id=='1'||$row2->tr_id=='6'||$row2->tr_id=='4')
			$bal=$row1->debit-$row1->credit;
		else
			$bal=-$row1->debit+$row1->credit;
		$connect->query("UPDATE tbl_acc_add_tran_amount_detail SET bal='$bal' WHERE id='$row1->id' AND acc_id='$row2->accca_id'");
	}
}
 ?>
<?php 
$sql1=$connect->query("SELECT * FROM tbl_acc_add_tran_dr_cr_detail");
while ($row1=mysqli_fetch_object($sql1)) {
	$sql2=$connect->query("SELECT A.*,C.tr_id
	FROM tbl_acc_chart_account AS A 
	LEFT JOIN tbl_acc_type_account AS B ON A.accca_account_type=B.accta_id
	LEFT JOIN tbl_acc_account_type_report AS C ON B.type_report_id=C.tr_id");
	while ($row2=mysqli_fetch_object($sql2)) {
		if($row2->tr_id=='1'||$row2->tr_id=='6'||$row2->tr_id=='4')
			$bal=$row1->debit-$row1->credit;
		else
			$bal=-$row1->debit+$row1->credit;
		$connect->query("UPDATE tbl_acc_add_tran_dr_cr_detail SET bal='$bal' WHERE id='$row1->id' AND acc_id='$row2->accca_id'");
	}
}
 ?>