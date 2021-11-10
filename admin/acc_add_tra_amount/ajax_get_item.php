<?php include_once '../../config/database.php'; ?>
<?php 
	if(isset($_GET['p_type'])){
		$v_type=(int) @$_GET['p_type'];
		$v_id=@$_GET['p_id'];
		$i=0;
		switch ($v_type) {
			case 1://Add Cash On Hand
				$sql=$connect->query("SELECT A.*,B.des_name
                    FROM tbl_acc_cash_record_detail AS A 
                    LEFT JOIN tbl_acc_decription AS B ON A.des_id=B.des_id
                    WHERE cash_rec_id='$v_id'");
                $idx=0;
				while ($row_content=mysqli_fetch_object($sql)) {
                    echo '<input type="hidden" name="txt_status[]" value="1">';
				    echo '<tr data-row-id="'.$idx++.'">';
                        // echo '<td>'.++$i.'</td>';
                        echo '<td style="display: none;"><input type="hidden" class="form-control" readonly="" name="txt_ref_detail_id[]" value="'.$row_content->detail_id.'"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_detail_code[]" value="'.$row_content->code.'"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_description[]" value="'.$row_content->des_name.'"></td>';
                        echo '<td><textarea name="txt_tran_note[]" readonly id="input" class="form-control" rows="3">'.$row_content->tran_note.'</textarea></td>';
                        echo '<td><textarea name="txt_doc_ref[]" readonly id="input" class="form-control" rows="3">'.$row_content->doc_ref.'</textarea></td>';
                        echo '<td><input type="text" class="form-control"  readonly="" name="txt_qty[]" value="'.number_format($row_content->qty,2).'"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_unit_price[]" value="'.number_format($row_content->price,2).'"></td>';
                        $v_amo=number_format($row_content->price*$row_content->qty,2);
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_amo[]" value="'.$v_amo.'"></td>';
                        echo '<td>
                                <select class="form-control myselect2" onchange="changeAccNo(this)" name="cbo_acc_id[]">
                                    <option value="">== Select ==</option>';
                                    $v_select = $connect->query("SELECT accca_id,accca_number,accca_account_name FROM tbl_acc_chart_account ORDER BY accca_number DESC");
                                    while ($row_data = mysqli_fetch_object($v_select)) {
                                        echo '<option value="'.$row_data->accca_id.'">'.$row_data->accca_number.'</option>';
                                    }
                                '</select>
                            </td>';               
                        echo  	'<td>
                                <select class="form-control" onchange="changeAccName(this)" name="cbo_acc_name[]">
                                    <option value="">== Select ==</option>';
                                    $v_select = $connect->query("SELECT accca_id,accca_number,accca_account_name FROM tbl_acc_chart_account ORDER BY accca_account_name DESC");
                                    while ($row_data = mysqli_fetch_object($v_select)) {
                                        echo '<option value="'.$row_data->accca_id.'">'.$row_data->accca_account_name.'</option>';
                                    }
                                '</select>
	                            </td>';
	                    echo  	'<td>
	                                <input type="text" onkeyup="getDebit(this)" name="txt_debit[]" class="form-control" value="0">
	                            </td>';
	                    echo  	'<td>
	                                <input type="text" onkeyup="getCredit(this)" name="txt_credit[]" class="form-control" value="0">
	                            </td>';
                        echo '<td class="text-center">';
                                echo '<button type="button" name="btnUp" class="btn btn-primary btn-xs"><i class="fa fa-arrow-up"></i></button>';
                                echo '&nbsp';
                                echo '<button type="button" name="btnDown" class="btn btn-primary btn-xs"><i class="fa fa-arrow-down"></i></button>';
                        echo '</td>';
                    echo '</tr>';
				}
				break;
			case 2://Invoice Sale Revenue
				$sql=$connect->query("SELECT A.*,A.id AS detail_id,B.inv_pron_name_en,C.name AS tran_note
                    FROM tbl_acc_none_sale_revenue_detial AS A 
                    LEFT JOIN tbl_inv_product_name AS B ON A.inv_pro_id=B.inv_pron_id
                    LEFT JOIN tbl_inv_feature AS C ON A.fea_id=C.id
                    WHERE none_sale_rev_id='$v_id'");
                $idx=0;
				while ($row_content=mysqli_fetch_object($sql)) {
                    echo '<input type="hidden" name="txt_status[]" value="1">';
				    echo '<tr data-row-id="'.$idx++.'">';
                        // echo '<td>'.++$i.'</td>';
                        echo '<td style="display: none;"><input type="hidden" class="form-control" readonly="" name="txt_ref_detail_id[]" value="'.$row_content->detail_id.'"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_detail_code[]" value="'.$row_content->code.'"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_description[]" value="'.$row_content->inv_pron_name_en.'"></td>';
                        echo '<td><textarea name="txt_tran_note[]" readonly id="input" class="form-control" rows="3">'.$row_content->tran_note.'</textarea></td>';
                        echo '<td><textarea name="txt_doc_ref[]" readonly id="input" class="form-control" rows="3"></textarea></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_qty[]" value="'.number_format($row_content->mater,0).'"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_unit_price[]" value="'.number_format($row_content->unit_price,2).'"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_content_code" value="'.number_format($row_content->amount,2).'"></td>';
                        echo '<td>
                                <select class="form-control" onchange="changeAccNo(this)" name="cbo_acc_id[]" style="width: 100%;">
                                    <option value="">== Select ==</option>';
                                    $v_select = $connect->query("SELECT accca_id,accca_number,accca_account_name FROM tbl_acc_chart_account ORDER BY accca_number DESC");
                                    while ($row_data = mysqli_fetch_object($v_select)) {
                                        echo '<option value="'.$row_data->accca_id.'">'.$row_data->accca_number.'</option>';
                                    }
                                '</select>
                            </td>';               
                        echo  	'<td>
	                                <select class="form-control" onchange="changeAccName(this)" name="cbo_acc_name[]" style="width: 100%;">
                                        <option value="">== Select ==</option>';
                                        $v_select = $connect->query("SELECT accca_id,accca_number,accca_account_name FROM tbl_acc_chart_account ORDER BY accca_account_name DESC");
                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                            echo '<option value="'.$row_data->accca_id.'">'.$row_data->accca_account_name.'</option>';
                                        }
                                    '</select>
	                            </td>';
	                    echo  	'<td>
	                                <input type="text" onkeyup="getDebit(this)" name="txt_debit[]" class="form-control" value="0">
	                            </td>';
	                    echo  	'<td>
	                                <input type="text" onkeyup="getCredit(this)" name="txt_credit[]" class="form-control" value="0">
	                            </td>';
                        echo '<td class="text-center">';
                                echo '<button type="button" name="btnUp" class="btn btn-primary btn-xs"><i class="fa fa-arrow-up"></i></button>';
                                echo '&nbsp';
                                echo '<button type="button" name="btnDown" class="btn btn-primary btn-xs"><i class="fa fa-arrow-down"></i></button>';
                        echo '</td>';
                    echo '</tr>';
				}
			 break;
		    case 3://Bill Supplier
                $sql=$connect->query("SELECT A.*
                    FROM tbl_acc_none_bill_supp_detail AS A 
                    WHERE none_bill_supp_id='$v_id'");
                $idx=0;
                while ($row_content=mysqli_fetch_object($sql)) {
                    echo '<input type="hidden" name="txt_status[]" value="1">';
                    echo '<tr data-row-id="'.$idx++.'">';
                    echo '<td style="display: none;"><input type="hidden" class="form-control" readonly="" name="txt_ref_detail_id[]" value="'.$row_content->id.'"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_detail_code[]" value=""></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_description[]" value="'.$row_content->decription.'"></td>';
                        echo '<td><textarea name="txt_tran_note[]" readonly id="input" class="form-control" rows="3"></textarea></td>';
                        echo '<td><textarea name="txt_doc_ref[]" readonly id="input" class="form-control" rows="3">'.$row_content->po_no.'-'.$row_content->pur_confirm_no.'</textarea></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_qty[]" value="'.number_format($row_content->qty,0).'"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_unit_price[]" value="'.number_format($row_content->unit_price,2).'"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_amo[]" value="'.number_format($row_content->amount,2).'"></td>';
                        echo '<td>
                                <select class="form-control select2" onchange="changeAccNo(this)" name="cbo_acc_id[]" style="width: 100%;">
                                    <option value="">== Select ==</option>';
                                    $v_select = $connect->query("SELECT accca_id,accca_number,accca_account_name FROM tbl_acc_chart_account ORDER BY accca_number DESC");
                                    while ($row_data = mysqli_fetch_object($v_select)) {
                                        echo '<option value="'.$row_data->accca_id.'">'.$row_data->accca_number.'</option>';
                                    }
                                '</select>
                            </td>';               
                        echo    '<td>
                                    <select class="form-control select2" onchange="changeAccName(this)" name="cbo_acc_name[]" style="width: 100%;">
                                        <option value="">== Select ==</option>';
                                        $v_select = $connect->query("SELECT accca_id,accca_number,accca_account_name FROM tbl_acc_chart_account ORDER BY accca_account_name DESC");
                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                            echo '<option value="'.$row_data->accca_id.'">'.$row_data->accca_account_name.'</option>';
                                        }
                                    '</select>
                                </td>';
                        echo    '<td>
                                    <input type="text" onkeyup="getDebit(this)" name="txt_debit[]" class="form-control" value="0">
                                </td>';
                        echo    '<td>
                                    <input type="text" onkeyup="getCredit(this)" name="txt_credit[]" class="form-control" value="0">
                                </td>';
                        echo '<td class="text-center">';
                                echo '<button type="button" name="btnUp" class="btn btn-primary btn-xs"><i class="fa fa-arrow-up"></i></button>';
                                echo '&nbsp';
                                echo '<button type="button" name="btnDown" class="btn btn-primary btn-xs"><i class="fa fa-arrow-down"></i></button>';
                        echo '</td>';
                    echo '</tr>';
                }
            break;
            case 4://Settle Advance
                $sql=$connect->query("SELECT A.*,A.id AS detail_id,B.des_name
                    FROM tbl_acc_none_settle_advance_detail AS A 
                    LEFT JOIN tbl_acc_decription AS B ON A.description_id=B.des_id
                    WHERE main_id='$v_id'");
                $idx=0;
                while ($row_content=mysqli_fetch_object($sql)) {
                    echo '<input type="hidden" name="txt_status[]" value="1">';
                    echo '<tr data-row-id="'.$idx++.'">';
                        // echo '<td>'.++$i.'</td>';
                        echo '<td style="display: none;"><input type="hidden" class="form-control" readonly="" name="txt_ref_detail_id[]" value="'.$row_content->detail_id.'"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_detail_code[]" value="'.$row_content->code_no.'"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_description[]" value="'.$row_content->des_name.'"></td>';
                        echo '<td><textarea name="txt_tran_note[]" readonly id="input" class="form-control" rows="3">'.$row_content->tran_note.'</textarea></td>';
                        echo '<td><textarea name="txt_doc_ref[]" readonly id="input" class="form-control" rows="3">'.$row_content->doc_ref.'</textarea></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_qty[]" value="'.number_format($row_content->quantity,0).'"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_unit_price[]" value="'.number_format($row_content->price,2).'"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_amo[]" value="'.number_format($row_content->quantity*$row_content->price,2).'"></td>';
                        echo '<td>
                                <select class="form-control" onchange="changeAccNo(this)" name="cbo_acc_id[]" style="width: 100%;">
                                    <option value="">== Select ==</option>';
                                    $v_select = $connect->query("SELECT accca_id,accca_number,accca_account_name FROM tbl_acc_chart_account ORDER BY accca_number DESC");
                                    while ($row_data = mysqli_fetch_object($v_select)) {
                                        echo '<option value="'.$row_data->accca_id.'">'.$row_data->accca_number.'</option>';
                                    }
                                '</select>
                            </td>';               
                        echo    '<td>
                                    <select class="form-control" onchange="changeAccName(this)" name="cbo_acc_name[]" style="width: 100%;">
                                        <option value="">== Select ==</option>';
                                        $v_select = $connect->query("SELECT accca_id,accca_number,accca_account_name FROM tbl_acc_chart_account ORDER BY accca_account_name DESC");
                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                            echo '<option value="'.$row_data->accca_id.'">'.$row_data->accca_account_name.'</option>';
                                        }
                                    '</select>
                                </td>';
                        echo    '<td>
                                    <input type="text" onkeyup="getDebit(this)" name="txt_debit[]" class="form-control" value="0">
                                </td>';
                        echo    '<td>
                                    <input type="text" onkeyup="getCredit(this)" name="txt_credit[]" class="form-control" value="0">
                                </td>';
                        echo '<td class="text-center">';
                                echo '<button type="button" name="btnUp" class="btn btn-primary btn-xs"><i class="fa fa-arrow-up"></i></button>';
                                echo '&nbsp';
                                echo '<button type="button" name="btnDown" class="btn btn-primary btn-xs"><i class="fa fa-arrow-down"></i></button>';
                        echo '</td>';
                    echo '</tr>';
                }
            break;

            case 5://Add Transfer Funds
                $sql=$connect->query("SELECT A.*,A.id AS detail_id,B.des_name
                    FROM tbl_acc_add_transfer_fund AS A 
                    LEFT JOIN tbl_acc_decription AS B ON A.des_id=B.des_id
                    WHERE A.id='$v_id' OR parent_id='$v_id'");
                $idx=0;
                while ($row_content=mysqli_fetch_object($sql)) {
                    echo '<input type="hidden" name="txt_status[]" value="1">';
                    echo '<tr data-row-id="'.$idx++.'">';
                        // echo '<td>'.++$i.'</td>';
                        echo '<td style="display: none;"><input type="hidden" class="form-control" readonly="" name="txt_ref_detail_id[]" value="'.$row_content->detail_id.'"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_detail_code[]" value=""></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_description[]" value="'.$row_content->des_name.'"></td>';
                        echo '<td><textarea name="txt_tran_note[]" readonly id="input" class="form-control" rows="3"></textarea></td>';
                        echo '<td><textarea name="txt_doc_ref[]" readonly id="input" class="form-control" rows="3">'.$row_content->note.'</textarea></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_qty[]" value=""></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_unit_price[]" value=""></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_amo[]" value=""></td>';
                        echo '<td>
                                <select class="form-control" onchange="changeAccNo(this)" name="cbo_acc_id[]" style="width: 100%;">
                                    <option value="">== Select ==</option>';
                                    $v_select = $connect->query("SELECT accca_id,accca_number,accca_account_name FROM tbl_acc_chart_account ORDER BY accca_number DESC");
                                    while ($row_data = mysqli_fetch_object($v_select)) {
                                        if($row_content->from_chart_acc==$row_data->accca_id||$row_content->to_chart_acc==$row_data->accca_id)
                                            echo '<option selected value="'.$row_data->accca_id.'">'.$row_data->accca_number.'</option>';
                                        else
                                            echo '<option value="'.$row_data->accca_id.'">'.$row_data->accca_number.'</option>';
                                    }
                                '</select>
                            </td>';               
                        echo    '<td>
                                    <select class="form-control" onchange="changeAccName(this)" name="cbo_acc_name[]" style="width: 100%;">
                                        <option value="">== Select ==</option>';
                                        $v_select = $connect->query("SELECT accca_id,accca_number,accca_account_name FROM tbl_acc_chart_account ORDER BY accca_account_name DESC");
                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                            if($row_content->from_chart_acc==$row_data->accca_id||$row_content->to_chart_acc==$row_data->accca_id)
                                                echo '<option selected value="'.$row_data->accca_id.'">'.$row_data->accca_account_name.'</option>';
                                            else
                                                echo '<option value="'.$row_data->accca_id.'">'.$row_data->accca_account_name.'</option>';
                                        }
                                    '</select>
                                </td>';
                        echo    '<td>
                                    <input type="text" onkeyup="getDebit(this)" name="txt_debit[]" class="form-control" value="'.(($row_content->debit)?($row_content->debit):0).'">
                                </td>';
                        echo    '<td>
                                    <input type="text" onkeyup="getCredit(this)" name="txt_credit[]" class="form-control" value="'.(($row_content->credit)?($row_content->credit):0).'">
                                </td>';
                        echo '<td class="text-center">';
                                echo '<button type="button" name="btnUp" class="btn btn-primary btn-xs"><i class="fa fa-arrow-up"></i></button>';
                                echo '&nbsp';
                                echo '<button type="button" name="btnDown" class="btn btn-primary btn-xs"><i class="fa fa-arrow-down"></i></button>';
                        echo '</td>';
                    echo '</tr>';
                }
            break;
		}
	}
    //For Append more Item
    echo '<tr class="my_form_base" style="background: red; display: none;">';
        echo '<input type="hidden" name="txt_status[]" value="0">';
        echo '<td><input type="text" class="form-control" name="txt_detail_code[]"></td>';
        echo '<td><input type="text" class="form-control" name="txt_description[]"></td>';
        echo '<td><textarea name="txt_tran_note[]" id="input" class="form-control" rows="3"></textarea></td>';
        echo '<td><textarea name="txt_doc_ref[]" id="input" class="form-control" rows="3"></textarea></td>';
        echo '<td><input type="text" class="form-control" onkeyup="getQty(this)" name="txt_qty[]" value="0"></td>';
        echo '<td><input type="text" class="form-control" onkeyup="getUnitPrice(this)" name="txt_unit_price[]" value="0"></td>';
        echo '<td><input type="text" class="form-control" name="txt_amo[]" value="0" readonly></td>';
        echo '<td>
                <select class="form-control myselect2" onchange="changeAccNo(this)" name="cbo_acc_id[]">
                    <option value="">== Select ==</option>';
                    $v_select = $connect->query("SELECT accca_id,accca_number,accca_account_name FROM tbl_acc_chart_account ORDER BY accca_number DESC");
                    while ($row_data = mysqli_fetch_object($v_select)) {
                        echo '<option value="'.$row_data->accca_id.'">'.$row_data->accca_number.'</option>';
                    }
                '</select>
            </td>';               
        echo    '<td>
                <select class="form-control" onchange="changeAccName(this)" name="cbo_acc_name[]">
                    <option value="">== Select ==</option>';
                    $v_select = $connect->query("SELECT accca_id,accca_number,accca_account_name FROM tbl_acc_chart_account ORDER BY accca_account_name DESC");
                    while ($row_data = mysqli_fetch_object($v_select)) {
                        echo '<option value="'.$row_data->accca_id.'">'.$row_data->accca_account_name.'</option>';
                    }
                '</select>
                </td>';
        echo    '<td>
                    <input type="text" onkeyup="getDebit(this)" name="txt_debit[]" class="form-control" value="0">
                </td>';
        echo    '<td>
                    <input type="text" onkeyup="getCredit(this)" name="txt_credit[]" class="form-control" value="0">
                </td>';
        echo '<td class="text-center">';
                echo '<button type="button" name="btnUp" class="btn btn-primary btn-xs"><i class="fa fa-arrow-up"></i></button>';
                echo '&nbsp';
                echo '<button type="button" name="btnDown" class="btn btn-primary btn-xs"><i class="fa fa-arrow-down"></i></button>';
        echo '</td>';
    echo '</tr>';
 ?>