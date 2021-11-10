<?php 
function Update_Row($v_status,$v_ref_id)
{
	$sql=null;
	if($v_status==1){
			$sql="SELECT C.des_name AS description,
					B.tran_note AS tran_note,
					B.doc_ref AS doc_ref,
					B.qty AS qty,
					B.price AS unit_price,
						SELECT COUNT(*) FROM tbl_acc_cash_record AS A1
						LEFT JOIN tbl_acc_cash_record_detail AS A2 ON A1.accdr_id=A2.cash_rec_id 
						WHERE A1.accdr_id='$v_ref_id' AS total_1,
						SELECT COUNT(*) FROM tbl_acc_add_tran_amount AS B1
						LEFT JOIN tbl_acc_add_tran_amount_detail AS B2 ON B1.id=B2.main_id
						WHERE B1.ref_id='$v_ref_id' AS total_2
					FROM tbl_acc_cash_record AS A 
					LEFT JOIN tbl_acc_cash_record_detail AS B ON A.accdr_id=B.cash_rec_id 
					LEFT JOIN tbl_acc_decription AS C ON B.des_id=C.des_id 
					LEFT JOIN tbl_acc_add_tran_amount AS D ON A.accdr_id=D.ref_id
					LEFT JOIN tbl_acc_add_tran_amount_detail AS E ON D.id=E.main_id
			WHERE accdr_id='$v_ref_id' 
			GROUP BY B.detail_id";
	}
	return $sql;
}
 ?>