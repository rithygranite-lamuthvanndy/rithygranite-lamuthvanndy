    <?php 
        $menu_active =20;
        $left_active =0;
        $layout_title = "Edit Add Transation Amount";
        include_once '../../config/database.php';
        include_once '../../config/athonication.php';
        include_once '../layout/header.php';
        include_once '../acc_my_operation/my_operation.php';
    ?>
    <?php 
    if(isset($_GET['edit_id'])){
        $v_id=$_GET['edit_id'];
        $sql=$connect->query("SELECT A.*
            FROM tbl_acc_add_tran_amount AS A 
            WHERE A.id='$v_id'");
        $row_main=mysqli_fetch_object($sql);
        // echo $row_main->id.'fff'.$row_main->ref_id;
    }
     ?>

    <?php 
        if(isset($_POST['btn_save'])){
            //Add Main Item
            $v_main_id = @$connect->real_escape_string($_POST['txt_main_id']);
            $v_type_id = @$connect->real_escape_string($_POST['cboType']);
            $v_name = @$connect->real_escape_string($_POST['txt_name']);
            $v_entry_no = @$connect->real_escape_string($_POST['cbo_entry_no']);
            $v_date_record = @$connect->real_escape_string($_POST['txt_date_record']);

            // $connect->query("DELETE FROM tbl_acc_add_tran_amount_detail WHERE main_id='$v_main_id' AND status='1'");

            // echo $row_main->ref_id.'='.$v_type_id;
            // echo $status_1.'='.$status_2;
            // return;

            $query_update = "UPDATE tbl_acc_add_tran_amount SET 
            date_record='$v_date_record',
            ref_id='$v_entry_no', 
            status_type='$v_type_id', 
            user_id='$user_id'
            WHERE id='$v_main_id'";
            if($connect->query($query_update))
                $flag_add_1=1;
            // $v_last_id=$connect->insert_id;

            $v_detail_id= @$_POST['txt_detail_id'];
            $v_ref_detail_id= @$_POST['txt_ref_detail_id'];
            $v_status= @$_POST['txt_status'];
            $v_detail_code=@$_POST['txt_detail_code'];
            $v_description=@$_POST['txt_description'];
            $v_tran_note=@$_POST['txt_tran_note'];
            $v_doc_ref=@$_POST['txt_doc_ref'];
            $v_qty=@$_POST['txt_qty'];
            $v_unit_price=@$_POST['txt_unit_price'];
            $v_amo=@$_POST['txt_amo'];
            $v_acc_id= @$_POST['cbo_acc_id'];
            $v_acc_debit= @$_POST['txt_debit'];
            $v_acc_credit= @$_POST['txt_credit'];
             foreach ($v_acc_id as $key => $value) {
                   $new_detail_id=$v_detail_id[$key];
                   // echo $new_detail_id;
                    if($value&&$new_detail_id!='0'){
                        $new_ref_detail=$v_ref_detail_id[$key];
                        $new_status=$v_status[$key];
                        $new_detail_code=$v_detail_code[$key];
                        $new_des=$v_description[$key];
                        $new_tran_note=$v_tran_note[$key];
                        $new_doc_ref=$v_doc_ref[$key];
                        $new_qty=$v_qty[$key];
                        $new_unit_price=convertStringToDouble($v_unit_price[$key]);
                        $new_amo=convertStringToDouble($v_amo[$key]);
                        $new_acc_id=$v_acc_id[$key];
                        $new_acc_debit=convertStringToDouble($v_acc_debit[$key]);
                        $new_acc_credit=convertStringToDouble($v_acc_credit[$key]);
                        $query_add_2="UPDATE tbl_acc_add_tran_amount_detail SET 
                            main_id='$v_main_id', 
                            ref_detail_id='$new_ref_detail', 
                            status='$new_status', 
                            detail_code='$new_detail_code', 
                            description='$new_des', 
                            tran_note='$new_tran_note', 
                            doc_ref='$new_doc_ref', 
                            qty ='$new_qty', 
                            unit_price ='$new_unit_price', 
                            amo ='$new_amo', 
                            acc_id='$new_acc_id', 
                            debit='$new_acc_debit', 
                            credit='$new_acc_credit'
                            WHERE id='$new_detail_id'
                            ";
                        $flag_add_2=$connect->query($query_add_2);
                    }
                    else if($value&&$new_detail_id=='0'){
                        $new_ref_detail=$v_ref_detail_id[$key];
                        $new_detail_code=$v_detail_code[$key];
                        $new_des=$v_description[$key];
                        $new_tran_note=$v_tran_note[$key];
                        $new_doc_ref=$v_doc_ref[$key];
                        $new_qty=$v_qty[$key];
                        $new_unit_price=convertStringToDouble($v_unit_price[$key]);
                        $new_amo=convertStringToDouble($v_amo[$key]);
                        $new_acc_id=$v_acc_id[$key];
                        $new_acc_debit=convertStringToDouble($v_acc_debit[$key]);
                        $new_acc_credit=convertStringToDouble($v_acc_credit[$key]);
                         //Add Sub Item
                        $query_add_2="INSERT INTO tbl_acc_add_tran_amount_detail(
                            `ref_detail_id`, 
                            `main_id`, 
                            `status`, 
                            `detail_code`, 
                            `description`, 
                            `tran_note`, 
                            `doc_ref`, 
                            `qty`, 
                            `unit_price`, 
                            `amo`, 
                            `acc_id`, 
                            `debit`, 
                            `credit`
                            )
                            VALUES
                            (
                            '$new_ref_detail',
                            '$v_main_id',
                            '$new_status',
                            '$new_detail_code',
                            '$new_des',
                            '$new_tran_note',
                            '$new_doc_ref',
                            '$new_qty',
                            '$new_unit_price',
                            '$new_amo',
                            '$new_acc_id',
                            '$new_acc_debit',
                            '$new_acc_credit'
                            )";
                        $flag_add_2=$connect->query($query_add_2);
                    }
                }
            
            if($flag_add_1==1&&$flag_add_2){
                echo '<script>myAlertSuccess("Updated")</script>';
                header('location: edit.php?edit_id='.@$_GET['edit_id']);
            }else{  
                echo '<script>myAlertError("Error")</script>';
            }
        }

     ?>



    <div class="portlet light bordered">
        <div class="row">
            <div class="col-xs-12">
                <?= @$sms ?>
                <h2><i class="fa fa-plus-circle fa-fw"></i>Update Transaction Amount</h2>
            </div>
        </div>
        <div class="portlet-body">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Input Information</h3>
                </div>
                <div class="panel-body">
                     <form action="#" method="post" enctype="multipart/form-data" autocomplete="off">
                        <input type="hidden" name="txt_main_id" value="<?= $row_main->id ?>">
                        <input type="hidden" name="txt_main_status" value="<?= $row_main->status_type ?>">
                        <div class="form-body">
                           <div class="row">
                                <div class="col-xs-12">
                                    <div class="col-xs-3">
                                        <div class="form-group">
                                            <label class="control-label">Type :</label>
                                            <select name="cboType" onchange="changeType(this)" id="inputCboType" class="form-control myselect2" required="required">
                                                <option value="1">Add Cash Record Voucher</option>
                                                <option value="2">Invoice Sale Revenue</option>
                                                <option value="3">Bill Supplier</option>
                                                <option value="4">Settle Advance</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <label for="input" class="control-label">Entry No *:</label>
                                            <select name="cbo_entry_no" id="input" onchange="changeItem()" class="form-control myselect2" required="required">
                                                <!-- <option value="">== Select and Choose ==</option> -->
                                                <?php 
                                                    if($row_main->status_type==1){
                                                        $sql=$connect->query("SELECT accdr_id AS id,accdr_voucher_no AS entry_no
                                                                            FROM tbl_acc_cash_record
                                                                            ");
                                                        if(@$_GET['status']=='con_update'){
                                                            $v_sql_detail="SELECT '1' AS status,A1.des_name AS description,A.tran_note,A.qty,A.price AS unit_price,A.doc_ref AS doc_ref,
                                                                                (SELECT AA.acc_id
                                                                                 FROM tbl_acc_add_tran_amount_detail AS AA
                                                                                 WHERE AA.ref_detail_id=A.detail_id
                                                                                ) AS old_acc_id,
                                                                                (SELECT AA.debit
                                                                                 FROM tbl_acc_add_tran_amount_detail AS AA
                                                                                 WHERE AA.ref_detail_id=A.detail_id
                                                                                ) AS old_debit,
                                                                                (SELECT AA.credit
                                                                                 FROM tbl_acc_add_tran_amount_detail AS AA
                                                                                 WHERE AA.ref_detail_id=A.detail_id
                                                                                ) AS old_credit,
                                                                                (SELECT AA.id
                                                                                 FROM tbl_acc_add_tran_amount_detail AS AA
                                                                                 WHERE AA.ref_detail_id=A.detail_id
                                                                                ) AS old_detail_id,
                                                                                (SELECT AA.detail_code 
                                                                                FROM tbl_acc_add_tran_amount_detail AS AA
                                                                                WHERE AA.ref_detail_id=A.detail_id
                                                                                )AS detail_code,
                                                                                (SELECT AA.ref_detail_id 
                                                                                FROM tbl_acc_add_tran_amount_detail AS AA
                                                                                WHERE AA.ref_detail_id=A.detail_id
                                                                                )AS ref_detail_id
                                                                            FROM tbl_acc_cash_record_detail AS A 
                                                                            LEFT JOIN tbl_acc_decription AS A1 ON A.des_id=A1.des_id
                                                                            WHERE A.cash_rec_id='$row_main->ref_id'
                                                                            UNION 
                                                                            SELECT '0' AS status,B.description,B.tran_note,B.qty,B.unit_price,B.detail_code,
                                                                            B.acc_id AS old_acc_id,B.debit AS old_debit,B.credit AS old_credit,B.id AS old_detail_id,B.ref_detail_id,B.doc_ref AS doc_ref
                                                                            FROM tbl_acc_add_tran_amount_detail AS B
                                                                            WHERE B.main_id='$row_main->id' AND B.status=0";
                                                        }
                                                        else{
                                                            $v_sql_detail="SELECT '0' AS status,B.description,B.tran_note,B.qty,B.unit_price,B.detail_code,
                                                                            B.acc_id AS old_acc_id,B.debit AS old_debit,B.credit AS old_credit,B.id AS old_detail_id,B.ref_detail_id,B.doc_ref AS doc_ref
                                                                            FROM tbl_acc_add_tran_amount_detail AS B
                                                                            WHERE B.main_id='$row_main->id'";
                                                        }
                                                    }
                                                    else if($row_main->status_type==2){
                                                        $sql=$connect->query("SELECT id AS id,inv_no AS entry_no
                                                                            FROM tbl_acc_none_sale_revenue
                                                                            ");

                                                        if(@$_GET['status']=='con_update_sale_revenue'){
                                                            $v_sql_detail="SELECT '1' AS status,A1.name AS description,A2.inv_pron_name_en AS tran_note,A.mater AS qty,
                                                                        A.unit_price AS unit_price,'' AS doc_ref,
                                                                                (SELECT AA.acc_id
                                                                                 FROM tbl_acc_add_tran_amount_detail AS AA
                                                                                 WHERE AA.ref_detail_id=A.id
                                                                                ) AS old_acc_id,
                                                                                (SELECT AA.debit
                                                                                 FROM tbl_acc_add_tran_amount_detail AS AA
                                                                                 WHERE AA.ref_detail_id=A.id
                                                                                ) AS old_debit,
                                                                                (SELECT AA.credit
                                                                                 FROM tbl_acc_add_tran_amount_detail AS AA
                                                                                 WHERE AA.ref_detail_id=A.id
                                                                                ) AS old_credit,
                                                                                (SELECT AA.id
                                                                                 FROM tbl_acc_add_tran_amount_detail AS AA
                                                                                 WHERE AA.ref_detail_id=A.id
                                                                                ) AS old_detail_id,
                                                                                (SELECT AA.detail_code 
                                                                                FROM tbl_acc_add_tran_amount_detail AS AA
                                                                                WHERE AA.ref_detail_id=A.id
                                                                                )AS detail_code,
                                                                                (SELECT AA.ref_detail_id 
                                                                                FROM tbl_acc_add_tran_amount_detail AS AA
                                                                                WHERE AA.ref_detail_id=A.id
                                                                                )AS ref_detail_id
                                                                            FROM tbl_acc_none_sale_revenue_detial AS A 
                                                                            LEFT JOIN tbl_inv_feature AS A1 ON A.fea_id=A1.id
                                                                            LEFT JOIN tbl_inv_product_name AS A2 ON A.inv_pro_id=A2.inv_pron_id
                                                                            WHERE A.none_sale_rev_id='$row_main->ref_id'
                                                                            UNION 
                                                                            SELECT '0' AS status,B.description,B.tran_note,B.qty,B.unit_price,B.detail_code,
                                                                            B.acc_id AS old_acc_id,B.debit AS old_debit,B.credit AS old_credit,B.id AS old_detail_id,B.ref_detail_id,B.doc_ref AS doc_ref
                                                                            FROM tbl_acc_add_tran_amount_detail AS B
                                                                            WHERE B.main_id='$row_main->id' AND B.status=0";
                                                        }
                                                        else{
                                                            $v_sql_detail="SELECT '0' AS status,B.description,B.tran_note,B.qty,B.unit_price,B.detail_code,
                                                                            B.acc_id AS old_acc_id,B.debit AS old_debit,B.credit AS old_credit,B.id AS old_detail_id,B.ref_detail_id,B.doc_ref AS doc_ref
                                                                            FROM tbl_acc_add_tran_amount_detail AS B
                                                                            WHERE B.main_id='$row_main->id'";
                                                        }
                                                    }
                                                    else if($row_main->status_type==3){//Bill Supplier
                                                        $sql=$connect->query("SELECT id AS id,inv_no AS entry_no
                                                                            FROM tbl_acc_none_bill_supp
                                                                            ");
                                                        if(@$_GET['status']=='con_update_bill_supplier'){
                                                            $v_sql_detail="SELECT '1' AS status,A.decription AS description,'' AS tran_note,A.qty AS qty,
                                                                        A.unit_price AS unit_price,A.po_no AS doc_ref,
                                                                                (SELECT AA.acc_id
                                                                                 FROM tbl_acc_add_tran_amount_detail AS AA
                                                                                 WHERE AA.ref_detail_id=A.id
                                                                                ) AS old_acc_id,
                                                                                (SELECT AA.debit
                                                                                 FROM tbl_acc_add_tran_amount_detail AS AA
                                                                                 WHERE AA.ref_detail_id=A.id
                                                                                ) AS old_debit,
                                                                                (SELECT AA.credit
                                                                                 FROM tbl_acc_add_tran_amount_detail AS AA
                                                                                 WHERE AA.ref_detail_id=A.id
                                                                                ) AS old_credit,
                                                                                (SELECT AA.id
                                                                                 FROM tbl_acc_add_tran_amount_detail AS AA
                                                                                 WHERE AA.ref_detail_id=A.id
                                                                                ) AS old_detail_id,
                                                                                (SELECT AA.detail_code 
                                                                                FROM tbl_acc_add_tran_amount_detail AS AA
                                                                                WHERE AA.ref_detail_id=A.id
                                                                                )AS detail_code,
                                                                                (SELECT AA.ref_detail_id 
                                                                                FROM tbl_acc_add_tran_amount_detail AS AA
                                                                                WHERE AA.ref_detail_id=A.id
                                                                                )AS ref_detail_id
                                                                            FROM tbl_acc_none_bill_supp_detail AS A 
                                                                            WHERE A.none_bill_supp_id='$row_main->ref_id'
                                                                            UNION 
                                                                            SELECT '0' AS status,B.description,B.tran_note,B.qty,B.unit_price,B.detail_code,
                                                                            B.acc_id AS old_acc_id,B.debit AS old_debit,B.credit AS old_credit,B.id AS old_detail_id,B.ref_detail_id,B.doc_ref AS doc_ref
                                                                            FROM tbl_acc_add_tran_amount_detail AS B
                                                                            WHERE B.main_id='$row_main->id' AND B.status=0";
                                                        }
                                                        else{
                                                            $v_sql_detail="SELECT '0' AS status,B.description,B.tran_note,B.qty,B.unit_price,B.detail_code,
                                                                            B.acc_id AS old_acc_id,B.debit AS old_debit,B.credit AS old_credit,B.id AS old_detail_id,B.ref_detail_id,B.doc_ref AS doc_ref
                                                                            FROM tbl_acc_add_tran_amount_detail AS B
                                                                            WHERE B.main_id='$row_main->id'";
                                                        }
                                                    }
                                                    else if($row_main->status_type==4){
                                                        $sql=$connect->query("SELECT id AS id,entry_no AS entry_no
                                                                            FROM tbl_acc_none_settle_advance
                                                                            ");

                                                        if(@$_GET['status']=='con_update_settle_advance'){
                                                            $v_sql_detail="SELECT '1' AS status,A1.des_name AS description,A.tran_note AS tran_note,A.quantity AS qty,
                                                                        A.price AS unit_price,A.doc_ref AS doc_ref,
                                                                                (SELECT AA.acc_id
                                                                                 FROM tbl_acc_add_tran_amount_detail AS AA
                                                                                 WHERE AA.ref_detail_id=A.id
                                                                                ) AS old_acc_id,
                                                                                (SELECT AA.debit
                                                                                 FROM tbl_acc_add_tran_amount_detail AS AA
                                                                                 WHERE AA.ref_detail_id=A.id
                                                                                ) AS old_debit,
                                                                                (SELECT AA.credit
                                                                                 FROM tbl_acc_add_tran_amount_detail AS AA
                                                                                 WHERE AA.ref_detail_id=A.id
                                                                                ) AS old_credit,
                                                                                (SELECT AA.id
                                                                                 FROM tbl_acc_add_tran_amount_detail AS AA
                                                                                 WHERE AA.ref_detail_id=A.id
                                                                                ) AS old_detail_id,
                                                                                (SELECT AA.detail_code 
                                                                                FROM tbl_acc_add_tran_amount_detail AS AA
                                                                                WHERE AA.ref_detail_id=A.id
                                                                                )AS detail_code,
                                                                                (SELECT AA.ref_detail_id 
                                                                                FROM tbl_acc_add_tran_amount_detail AS AA
                                                                                WHERE AA.ref_detail_id=A.id
                                                                                )AS ref_detail_id
                                                                            FROM tbl_acc_none_settle_advance_detail AS A 
                                                                            LEFT JOIN tbl_acc_decription AS A1 ON A.description_id=A1.des_id
                                                                            WHERE A.main_id='$row_main->ref_id'
                                                                            UNION 
                                                                            SELECT '0' AS status,B.description,B.tran_note,B.qty,B.unit_price,B.detail_code,
                                                                            B.acc_id AS old_acc_id,B.debit AS old_debit,B.credit AS old_credit,B.id AS old_detail_id,B.ref_detail_id,B.doc_ref AS doc_ref
                                                                            FROM tbl_acc_add_tran_amount_detail AS B
                                                                            WHERE B.main_id='$row_main->id' AND B.status=0";
                                                        }
                                                        else{
                                                            $v_sql_detail="SELECT '0' AS status,B.description,B.tran_note,B.qty,B.unit_price,B.detail_code,
                                                                            B.acc_id AS old_acc_id,B.debit AS old_debit,B.credit AS old_credit,B.id AS old_detail_id,B.ref_detail_id,B.doc_ref AS doc_ref
                                                                            FROM tbl_acc_add_tran_amount_detail AS B
                                                                            WHERE B.main_id='$row_main->id'";
                                                        }
                                                    }
                                                    while ($row_select=mysqli_fetch_object($sql)) {
                                                        if($row_main->ref_id==$row_select->id)
                                                            echo '<option selected value="'.$row_select->id.'">'.$row_select->entry_no.'</option>';
                                                        else
                                                            echo '<option value="'.$row_select->id.'">'.$row_select->entry_no.'</option>';
                                                    }
                                                 ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group">
                                            <label>Date : </label>
                                            <input type="text" name="txt_date_record" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control date" required value="<?= $row_main->date_record ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="form-group">
                                            <label>Name : </label>
                                            <input type="text" name="txt_name" id="inputTxt_name" class="form-control" readonly="" value="<?= $row_main->name; ?>">
                                        </div>
                                    </div>
                                </div>

                                <!-- Detail -->
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <style type="text/css">
                                        table >thead >tr th,table >tfoot >tr th{
                                            padding: 10px;
                                        }
                                    </style>  
                                    <table class="table-bordered table-responsive" id="myTable">
                                        <thead>
                                            <tr>
                                                <!-- <th class="text-center" style="width: 2%;">No</th> -->
                                                <th class="text-center" style="width: 4%;">Code</th>
                                                <th class="text-center">Description</th>
                                                <th class="text-center">Transation Note</th>
                                                <th class="text-center">Document Ref</th>
                                                <th class="text-center" style="width: 6px;">Quantity</th>
                                                <th class="text-center">Unit</th>
                                                <th class="text-center">Amount</th>
                                                <th class="text-center" style="width: 10%;">Account No</th>
                                                <th class="text-center" style="width: 20%;">Account Name</th>
                                                <th class="text-center" style="width: 7%;">Debit</th>
                                                <th class="text-center" style="width: 7%;">Credit</th>
                                                <th class="text-center" style="width: 3%;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $idx=0;
                                                $i=0;
                                                $result=$connect->query($v_sql_detail);
                                                while ($row_detail=mysqli_fetch_object($result)) {
                                                    echo '<tr data-row-id="'.$idx++.'">';
                                                    echo '<input type="hidden" value="'.$row_detail->status.'" name="txt_status[]">';
                                                        $v_detail_id=($row_detail->old_detail_id)?($row_detail->old_detail_id):'0';
                                                        if($row_detail->status=='1'){//Old Ref No
                                                            echo '<td style="display: none;"><input type="hidden" value="'.$v_detail_id.'" name="txt_detail_id[]"></td>';
                                                            echo '<td style="display: none;"><input type="hidden" value="'.$row_detail->ref_detail_id.'" name="txt_ref_detail_id[]"></td>';
                                                            echo '<td><input type="text" class="form-control" readonly name="txt_detail_code[]" value="'.$row_detail->detail_code.'"></td>';
                                                            echo '<td><input type="text" class="form-control" readonly="" name="txt_description[]" value="'.$row_detail->description.'"></td>';
                                                            echo '<td><textarea name="txt_tran_note[]" readonly id="input" class="form-control" rows="3">'.$row_detail->tran_note.'</textarea></td>';
                                                            echo '<td><textarea name="txt_doc_ref[]" readonly id="input" class="form-control" rows="3">'.$row_detail->doc_ref.'</textarea></td>';
                                                            echo '<td><input type="text" class="form-control" readonly="" name="txt_qty[]" value="'.number_format($row_detail->qty,0).'"></td>';
                                                            echo '<td><input type="text" class="form-control" readonly="" name="txt_unit_price[]" value="'.number_format($row_detail->unit_price,2).'"></td>';
                                                        }
                                                        else if($row_detail->status=='0'){//New ref No
                                                            echo '<td style="display: none;"><input type="hidden" value="'.$v_detail_id.'" name="txt_detail_id[]"></td>';
                                                            echo '<td style="display: none;"><input type="hidden" value="" name="txt_ref_detail_id[]"></td>';
                                                            echo '<td><input type="text" class="form-control" name="txt_detail_code[]" value="'.$row_detail->detail_code.'"></td>';
                                                            echo '<td><input type="text" class="form-control" name="txt_description[]" value="'.$row_detail->description.'"></td>';
                                                            echo '<td><textarea name="txt_tran_note[]" id="input" class="form-control" rows="3">'.$row_detail->tran_note.'</textarea></td>';
                                                            echo '<td><textarea name="txt_doc_ref[]" id="input" class="form-control" rows="3">'.$row_detail->doc_ref.'</textarea></td>';
                                                            echo '<td><input type="text" class="form-control" onkeyup="getQty(this)" name="txt_qty[]" value="'.number_format($row_detail->qty,0).'"></td>';
                                                            echo '<td><input type="text" class="form-control" onkeyup="getUnitPrice(this)" name="txt_unit_price[]" value="'.number_format($row_detail->unit_price,2).'"></td>';
                                                        }
                                                        $v_amo=$row_detail->qty*$row_detail->unit_price;
                                                        echo '<td><input type="text" class="form-control" readonly="" name="txt_amo[]" value="'.$v_amo.'" readonly></td>';
                                                        echo '<td>
                                                                <select class="form-control myselect2" onchange="changeAccNo(this)" name="cbo_acc_id[]">
                                                                    <option value="">== Select ==</option>';
                                                                    $v_select = $connect->query("SELECT accca_id,accca_number,accca_account_name FROM tbl_acc_chart_account ORDER BY accca_number DESC");
                                                                    while ($row_data = mysqli_fetch_object($v_select)) {
                                                                        if($row_detail->old_acc_id==$row_data->accca_id)
                                                                            echo '<option selected value="'.$row_data->accca_id.'">'.$row_data->accca_number.'</option>';
                                                                        else
                                                                            echo '<option value="'.$row_data->accca_id.'">'.$row_data->accca_number.'</option>';
                                                                    }
                                                                '</select>
                                                            </td>';               
                                                        echo    '<td>
                                                                    <select class="form-control myselect2" onchange="changeAccName(this)" name="cbo_acc_name[]">
                                                                        <option value="">== Select ==</option>';
                                                                        $v_select = $connect->query("SELECT accca_id,accca_number,accca_account_name FROM tbl_acc_chart_account ORDER BY accca_account_name DESC");
                                                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                                                            if($row_detail->old_acc_id==$row_data->accca_id)
                                                                                echo '<option selected value="'.$row_data->accca_id.'">'.$row_data->accca_account_name.'</option>';
                                                                            else
                                                                                echo '<option value="'.$row_data->accca_id.'">'.$row_data->accca_account_name.'</option>';
                                                                        }
                                                                    '</select>
                                                                </td>';
                                                                $v_debit=($row_detail->old_debit)?($row_detail->old_debit):0;
                                                        echo    '<td>
                                                                    <input type="text" onkeyup="getDebit(this)" name="txt_debit[]" class="form-control" value="'.$v_debit.'">
                                                                </td>';
                                                                $v_credit=($row_detail->old_credit)?($row_detail->old_credit):0;
                                                        echo    '<td>
                                                                    <input type="text" onkeyup="getCredit(this)" name="txt_credit[]" class="form-control" value="'.$v_credit.'">
                                                                </td>';
                                                        echo '<td class="text-center">';
                                                            echo '<button type="button" name="btnUp" class="btn btn-primary btn-xs"><i class="fa fa-arrow-up"></i></button>';
                                                            echo '&nbsp';
                                                            echo '<button type="button" name="btnDown" class="btn btn-primary btn-xs"><i class="fa fa-arrow-down"></i></button>';
                                                        echo '</td>';
                                                    echo '</tr>';
                                                 
                                                }
                                                // ====================
                                                echo '<tr class="my_form_base" style="background: red; display: none;">';
                                                        echo '<input type="hidden" name="txt_detail_id[]" value="0">';
                                                        echo '<input type="hidden" value="0" name="txt_ref_detail_id[]">';
                                                        echo '<td><input type="text" class="form-control" name="txt_detail_code[]"></td>';
                                                        echo '<td><input type="text" class="form-control" name="txt_description[]"></td>';
                                                        echo '<td><textarea name="txt_tran_note[]" id="input" class="form-control" rows="3"></textarea></td>';
                                                        echo '<td><textarea name="txt_doc_ref[]" id="input" class="form-control" rows="3"></textarea></td>';
                                                        echo '<td><input type="text" class="form-control" onkeyup="getQty(this)" name="txt_qty[]" value="0"></td>';
                                                        echo '<td><input type="text" class="form-control" onkeyup="getUnitPrice(this)"  name="txt_unit_price[]" value="0"></td>';
                                                        echo '<td><input type="text" class="form-control" name="txt_amo[]" value="0" readonly></td>';
                                                        echo '<td>
                                                                <select class="form-control" onchange="changeAccNo(this)" name="cbo_acc_id[]">
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
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th style="visibility: hidden;"></th>
                                                <th style="visibility: hidden;"></th>
                                                <th style="visibility: hidden;"></th>
                                                <th style="visibility: hidden;"></th>
                                                <th style="visibility: hidden;"></th>
                                                <th style="visibility: hidden;"></th>
                                                <th style="visibility: hidden;"></th>
                                                <th class="text-right" colspan="2">Total Amount:</th>
                                                <th class="text-center">0.00</th>
                                                <th class="text-center">0.00</th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <th style="visibility: hidden;"></th>
                                                <th style="visibility: hidden;"></th>
                                                <th style="visibility: hidden;"></th>
                                                <th style="visibility: hidden;"></th>
                                                <th style="visibility: hidden;"></th>
                                                <th style="visibility: hidden;"></th>
                                                <th style="visibility: hidden;"></th>
                                                <th class="text-right" colspan="2">Out of Balance:</th>
                                                <th class="text-center" colspan="2">0.00</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="text-center">
                                <div class="form_add_result"></div>
                                <div id="add_more" class="btn btn-warning btn-md"><i class="fa fa-plus"></i> Add More</div>
                            </div>
                        </div>
                        <br>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" name="btn_save" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
                                    <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form><br>
                </div>
            </div>  
        </div>
    </div>
    <script type="text/javascript" src="../../assets/global/plugins/jquery.min.js"></script>
    <script type="text/javascript">
         var index_row=0;
         //Load Item
        $(document).ready(function () { 
            let v_type_id=$('input[name=txt_main_status]').val();
            $('select[name=cboType]').val(v_type_id);

            $('#add_more').click(function(){ 
                var index_row = $('#myTable tr').length-1;
                $('#myTable').append('<tr data-row-id="'+(index_row)+'">'+$('.my_form_base').html()+'</tr>');
                // $('#myTable').append('<tr>'+$('.my_form_base').html()+'</tr>');
                $('tr[data-row-id='+index_row+']').find('select').select2();
            });

            $('tr').find('td:nth-last-child(3) >input').each(function () {
                getDebit($(this));
                /* body... */
            });
            $('tr').find('td:nth-last-child(2) >input').each(function () {
                getCredit($(this));
                /* body... */
            });
        });

        // $(document).ready(function () {

        //     $('tbody >tr').each(function () {
        //         changeAccNo($(this).find('td:nth-last-child(5) >select'));
        //         getDebit($(this).find('td:nth-last-child(3) >input'));
        //         getCredit($(this).find('td:nth-last-child(2) >input'));
        //     });
        // });
        function changeType (args) {
            let v_type_id=parseInt($(args).val());
            $.ajax({url: 'ajx_get_content_select.php?p_type_id='+v_type_id,success:function (result) {
                // alert(result);
                $('select[name=cbo_entry_no]').html(result.trim());
            }});
        }
        

        $("tbody").on('click', 'button[name=btnUp],button[name=btnDown]', function () {
             var row = $(this).parents('tr:first');
            if ($(this).is('button[name=btnUp]')) 
                row.insertBefore(row.prev());
            else 
                row.insertAfter(row.next());
        });
        function changeItem (args) {
            var v_type=$('select[name=cboType] >option:selected').val();
            var v_id=$('select[name=cbo_entry_no]').val();
            $('tbody >tr').remove();
            $.ajax({url: 'ajax_get_item.php?p_type='+v_type+"&p_id="+v_id,async:false,success:function (result) {
                $('tbody').html(result);
            }});
            index_row=0;
            $('tbody >tr').each(function () {
                $('tbody >tr[data-row-id='+(index_row++)+']').find('select').select2();
            });
            // =====
            $.ajax({url: 'ajx_get_ref_name.php?p_type='+v_type+"&p_id="+v_id,async:false,success:function (data,status) {
                $('input[name=txt_name]').val(data);
            }});
        }
        function changeAccName (args) {
            let v_acc_id=$(args).val();
             $.ajax({url: 'ajx_get_content_select.php?v_acc_id_name='+v_acc_id,success:function (result) {
                // alert(result);
                $(args).parents('tbody >tr').find('td:nth-last-child(5) >select').html(result);
            }});
        }
        function changeAccNo (args) {
            let v_acc_id=$(args).val();
             $.ajax({url: 'ajx_get_content_select.php?v_acc_id='+v_acc_id,success:function (result) {
                $(args).parents('tbody >tr').find('td:nth-last-child(4) >select').html(result);
            }});
        }

        function getDebit (args) {
            var v_total_debit=0;
            $('tbody >tr').find('td:nth-last-child(3)').each(function () {
                v_total_debit+=parseFloat($(this).find('input').val());
            });
            $('tfoot tr:first-child').find('th:nth-last-child(3)').html(v_total_debit.toFixed(2));
            totalAmount();
        }
        function getCredit (args) {
            var v_total_credit=0;
            $('tbody >tr').find('td:nth-last-child(2)').each(function () {
                v_total_credit+=parseFloat($(this).find('input').val());
            });
            $('tfoot tr:first-child').find('th:nth-last-child(2)').html(v_total_credit.toFixed(2));
            totalAmount();
        }
        function totalAmount () {
            let v_total_amo=0;
            let v_total_debit=$('tfoot tr:first-child').find('th:nth-last-child(3)').html();
            let v_total_credit=$('tfoot tr:first-child').find('th:nth-last-child(2)').html();
            v_total_amo=parseFloat(v_total_debit)-parseFloat(v_total_credit);     
            if(v_total_amo!=0){
                $('button[name=btn_save]').attr("disabled", "disabled");
            }
            else{
                $('button[name=btn_save]').removeAttr("disabled");
            } 
            $('tfoot tr:last-child').find('th:nth-last-child(2)').html(v_total_amo.toFixed(2));
        }
        function getQty(args) {
            let v_qty=$(args).val();
            let v_unit_price=$(args).parents('tbody >tr').find('td:nth-last-child(7) >input').val();
            $(args).parents('tbody >tr').find('td:nth-last-child(6) >input').val(v_qty*parseFloat(v_unit_price));
        }
        function getUnitPrice (args) {
            let v_unit_price=$(args).val();
            let v_qty=$(args).parents('tbody >tr').find('td:nth-last-child(8) >input').val();
            $(args).parents('tbody >tr').find('td:nth-last-child(6) >input').val(parseFloat(v_unit_price)*parseFloat(v_qty));
        }
    </script>
    <?php include_once '../layout/footer.php' ?>