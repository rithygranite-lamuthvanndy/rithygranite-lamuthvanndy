<?php include_once '../../config/database.php'; ?>
<?php 
	if(isset($_GET['p_type'])){
		$v_type=(int) @$_GET['p_type'];
		$v_id=@$_GET['p_id'];
		$i=0;
		switch ($v_type) {
			case 1://Adjustment Record
				$sql=$connect->query("SELECT A.*,A.id AS ref_detail_id,B.entry_no,accca_account_name
                    FROM tbl_acc_rec_adjustment_detail AS A 
                    LEFT JOIN tbl_acc_rec_adjustment AS B ON A.detail_id=B.id
                    LEFT JOIN tbl_acc_chart_account AS C ON A.account_id=C.accca_id
                    WHERE detail_id='$v_id'");
                $idx=0;
				while ($row_content=mysqli_fetch_object($sql)) {
                    echo '<input type="hidden" name="txt_status[]" value="1">';
				    echo '<tr data-row-id="'.$idx++.'">';
                        echo '<td style="display: none;"><input type="hidden" class="form-control" readonly="" name="txt_ref_detail_id[]" value="'.$row_content->ref_detail_id.'"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_detail_code[]" value="'.$row_content->entry_no.'"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_description[]" value="'.$row_content->accca_account_name.'"></td>';
                        echo '<td><textarea name="txt_tran_note[]" readonly id="input" class="form-control" rows="3"></textarea></td>';
                        echo '<td><textarea name="txt_doc_ref[]" readonly id="input" class="form-control" rows="3">'.$row_content->entry_no.'</textarea></td>';
                        echo '<td><input type="text" class="form-control"  readonly="" name="txt_qty[]" value=""></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_unit_price[]" value=""></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_debit_old[]" value="'.number_format($row_content->debit,2).'"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_credit_old[]" value="'.number_format($row_content->credit,2).'"></td>';
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
	                                <input type="text"  onkeyup="getDebit(this)" name="txt_debit[]" class="form-control" value="0">
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
			case 2://Stock Inventory 
				$sql=$connect->query("SELECT A.*,A.id AS ref_detail_id,C.des_name,B.entry_no
                    FROM tbl_acc_rec_stock_inventory_detail AS A 
                    LEFT JOIN tbl_acc_rec_stock_inventory AS B ON A.detail_id=B.id
                    LEFT JOIN tbl_acc_decription AS C ON A.description_id=C.des_id
                    WHERE detail_id='$v_id'");
                $idx=0;
				while ($row_content=mysqli_fetch_object($sql)) {
                    echo '<input type="hidden" name="txt_status[]" value="1">';
				    echo '<tr data-row-id="'.$idx++.'">';
                        // echo '<td>'.++$i.'</td>';
                        echo '<td style="display: none;"><input type="text" class="form-control" readonly="" name="txt_ref_detail_id[]" value="'.$row_content->ref_detail_id.'"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_detail_code[]" value="'.$row_content->entry_no.'"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_description[]" value="'.$row_content->des_name.'"></td>';
                        echo '<td><textarea name="txt_tran_note[]" readonly id="input" class="form-control" rows="3">'.$row_content->tran_note.'</textarea></td>';
                        echo '<td><textarea name="txt_doc_ref[]" readonly id="input" class="form-control" rows="3">'.$row_content->doc_ref.'</textarea></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_qty[]" value="'.number_format($row_content->quantity,0).'"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_unit_price[]" value="'.number_format($row_content->price,2).'"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_debit_old[]" value="'.number_format($row_content->debit,2).'"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_credit_old[]" value="'.number_format($row_content->credit,2).'"></td>';
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
	                                <input type="text" onkeyup="getDebit(this)" onchange="getCredit(this)" name="txt_debit[]" class="form-control" value="0">
	                            </td>';
	                    echo  	'<td>
	                                <input type="text" onkeyup="getCredit(this)" onchange="getCredit(this)" name="txt_credit[]" class="form-control" value="0">
	                            </td>';
                        echo '<td class="text-center">';
                                echo '<button type="button" name="btnUp" class="btn btn-primary btn-xs"><i class="fa fa-arrow-up"></i></button>';
                                echo '&nbsp';
                                echo '<button type="button" name="btnDown" class="btn btn-primary btn-xs"><i class="fa fa-arrow-down"></i></button>';
                        echo '</td>';
                    echo '</tr>';
				}
			break;
            case 3://Transfer Funs
                $sql="SELECT A.*,A.id AS ref_detail_id,B.des_name
                    FROM tbl_acc_add_transfer_fund AS A
                    LEFT JOIN tbl_acc_decription AS B ON A.des_id=B.des_id
                    WHERE id='$v_id'
                    OR parent_id='$v_id'
                    ";
                $result=$connect->query($sql);
                $idx=0;
                while ($row_content=mysqli_fetch_object($result)) {
                    echo '<input type="hidden" name="txt_status[]" value="1">';
                    echo '<tr data-row-id="'.++$idx.'">';
                        // echo '<td>'.++$i.'</td>';
                        echo '<td style="display: none;"><input type="text" class="form-control" readonly="" name="txt_ref_detail_id[]" value="'.$row_content->ref_detail_id.'"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_detail_code[]"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_description[]" value="'.$row_content->des_name.'"></td>';
                        echo '<td><textarea name="txt_tran_note[]" readonly id="input" class="form-control" rows="3">'.$row_content->note.'</textarea></td>';
                        echo '<td><textarea name="txt_doc_ref[]" readonly id="input" class="form-control" rows="3"></textarea></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_qty[]" value="0"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_unit_price[]" value="0"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_debit_old[]" value="'.number_format($row_content->debit,2).'"></td>';
                        echo '<td><input type="text" class="form-control" readonly="" name="txt_credit_old[]" value="'.number_format($row_content->credit,2).'"></td>';
                        echo '<td>
                                <select class="form-control" disabled="disabled" onchange="changeAccNo(this)" name="cbo_acc_id_tmp[]" style="width: 100%;">
                                    <option value="">== Select ==</option>';
                                    $v_select = $connect->query("SELECT accca_id,accca_number,accca_account_name FROM tbl_acc_chart_account ORDER BY accca_number DESC");
                                    while ($row_data = mysqli_fetch_object($v_select)) {
                                        if($row_data->accca_id==$row_content->to_chart_acc||$row_data->accca_id==$row_content->from_chart_acc){
                                            echo '<option selected value="'.$row_data->accca_id.'">'.$row_data->accca_number.'</option>';
                                            $v_acc_selected=$row_data->accca_id;
                                            echo '<input type="hidden" name="cbo_acc_id[]" value="'.$v_acc_selected.'">';
                                        }
                                        // else
                                        //     echo '<option value="'.$row_data->accca_id.'">'.$row_data->accca_number.'</option>';
                                    }
                                '</select>
                            </td>';               
                        echo    '<td>
                                    <select class="form-control" disabled="disabled" onchange="changeAccName(this)" name="cbo_acc_name[]" style="width: 100%;">
                                        <option value="">== Select ==</option>';
                                        $v_select = $connect->query("SELECT accca_id,accca_number,accca_account_name FROM tbl_acc_chart_account ORDER BY accca_account_name DESC");
                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                            if($row_data->accca_id==$row_content->to_chart_acc||$row_data->accca_id==$row_content->from_chart_acc)
                                                echo '<option selected value="'.$row_data->accca_id.'">'.$row_data->accca_account_name.'</option>';
                                            else
                                                echo '<option value="'.$row_data->accca_id.'">'.$row_data->accca_account_name.'</option>';
                                        }
                                    '</select>
                                </td>';
                        echo    '<td>
                                    <input type="text" onkeyup="getDebit(this)" onchange="getDebit(this)" name="txt_debit[]" class="form-control" value="'.@$row_content->debit.'">
                                </td>';
                        echo    '<td>
                                    <input type="text" onkeyup="getCredit(this)" onchange="getCredit(this)" name="txt_credit[]" class="form-control" value="'.@$row_content->credit.'">
                                </td>';
                        echo '<td class="text-center">';
                                echo '<button type="button" name="btnUp" class="btn btn-primary btn-xs"><i class="fa fa-arrow-up"></i></button>';
                                echo '&nbsp';
                                echo '<button type="button" name="btnDown" class="btn btn-primary btn-xs"><i class="fa fa-arrow-down"></i></button>';
                        echo '</td>';
                    echo '</tr>';
                }
		}
	}
    //For Append more Item
    echo '<tr class="my_form_base" style="background: red; display: none;">';
        echo '<input type="hidden" name="txt_status[]" value="0">';
        echo '<td style="display: none;"><input type="hidden" class="form-control" readonly="" name="txt_ref_detail_id[]" value="0"></td>';
        echo '<td><input type="text" class="form-control" name="txt_detail_code[]"></td>';
        echo '<td><input type="text" class="form-control" name="txt_description[]"></td>';
        echo '<td><textarea name="txt_tran_note[]" id="input" class="form-control" rows="3"></textarea></td>';
        echo '<td><textarea name="txt_doc_ref[]" id="input" class="form-control" rows="3"></textarea></td>';
        echo '<td><input type="text" class="form-control" onkeyup="getQty(this)" name="txt_qty[]" value="0"></td>';
        echo '<td><input type="text" class="form-control" onkeyup="getUnitPrice(this)" name="txt_unit_price[]" value="0"></td>';
        echo '<td><input type="text" class="form-control" readonly="" name="txt_debit_old[]" value="0"></td>';
        echo '<td><input type="text" class="form-control" readonly="" name="txt_credit_old[]" value="0"></td>';
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
                    <input type="number" step="0.01" onkeyup="getDebit(this)" onchange="getDebit(this)" name="txt_debit[]" class="form-control" value="0">
                </td>';
        echo    '<td>
                    <input type="number" step="0.01" onkeyup="getCredit(this)" onchange="getCredit(this)" name="txt_credit[]" class="form-control" value="0">
                </td>';
        echo '<td class="text-center">';
                echo '<button type="button" name="btnUp" class="btn btn-primary btn-xs"><i class="fa fa-arrow-up"></i></button>';
                echo '&nbsp';
                echo '<button type="button" name="btnDown" class="btn btn-primary btn-xs"><i class="fa fa-arrow-down"></i></button>';
        echo '</td>';
    echo '</tr>';
 ?>