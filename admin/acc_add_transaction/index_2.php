<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
    $get_data=$connect->query("SELECT A.*,B.*,F.*,
        accmy_name,accca_number,accca_account_name,accpro_name,trat_name,vot_name,des_name
    FROM tbl_acc_add_transaction_detail AS A 
    LEFT JOIN tbl_acc_add_transaction AS B ON A.transation_id=B.accad_id
    LEFT JOIN tbl_acc_month_year AS C ON B.accad_month_year=C.accmy_id
    LEFT JOIN tbl_acc_chart_account AS D ON A.chart_acc_id=D.accca_id
    LEFT JOIN tbl_acc_project AS E ON A.project_id=E.accpro_id
    LEFT JOIN tbl_acc_cash_record AS F ON B.accad_cash_rec_id=F.accdr_id
    LEFT JOIN tbl_acc_transaction_type_list AS G ON F.transa_type_id=G.trat_id
    LEFT JOIN tbl_acc_voucher_type_list AS H ON F.voucher_type_id=H.vot_id
    LEFT JOIN tbl_acc_decription AS I ON F.accdr_description=I.des_id
    WHERE B.accad_date_record='$now'
    ORDER BY accad_id ASC
    ");
 ?>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Add Transaction</h2>
        </div>
    </div>
    <br>
    <div class="">
        <div class="caption font-dark">
            <a href="add.php" id="sample_editable_1_new" class="btn green"> Add New
                <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>
    <br>
    <div class="row">
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="col-sm-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input autocomplete="off" name="txt_date_start" value="<?= @$_POST['txt_date_start'] ?>" type="text" class="form-control" placeholder="Date From">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input autocomplete="off" name="txt_date_end" value="<?= @$_POST['txt_date_end'] ?>" type="text" class="form-control" placeholder="Date To">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-6">
                <div class="caption font-dark" style="display: inline-block;">
                    <button type="submit" name="btn_show_all" id="sample_editable_1_new" class="btn green"> Show All
                        <i class="fa fa-list"></i>
                    </button>
                </div>
                <div class="caption font-dark" style="display: inline-block;">
                    <button type="submit" name="btn_search" id="sample_editable_1_new" class="btn blue"> Search
                        <i class="fa fa-search"></i>
                    </button>
                </div>
                <div class="caption font-dark" style="display: inline-block;">
                    <a href="<?= $_SERVER['PHP_SELF'] ?>" id="sample_editable_1_new" class="btn red"> Clear
                        <i class="fa fa-refresh"></i>
                    </a>
                </div>

            </div>
        </form>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered dataTable dtr-inline" id="sample_1" role="grid" aria-describedby="sample_1_info">

                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Date Record</th>
                        <th>Invoice No</th>
                        <th>Transation Type </th>
                        <th>Voucher Type </th>
                        <th>Description</th>
                        <th>To</th>
                        <th>Address</th>
                        <th>Cash In</th>
                        <th>Cash Out</th>
                        <th>Account Name</th>
                        <th>Account No</th>
                        <th>Project Code</th>
                        <th>Activity Code</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <!-- 16 -->
                        <!-- <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $tmp=0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                if($row->accad_id!=$tmp){
                                    $sql_num_main=$connect->query("SELECT A.*,transation_id,accad_id,accca_number,accca_account_name,accpro_name
                                    FROM tbl_acc_add_transaction_detail AS A 
                                    LEFT JOIN tbl_acc_add_transaction AS B ON A.transation_id=B.accad_id
                                    LEFT JOIN tbl_acc_chart_account AS C ON A.chart_acc_id=C.accca_id
                                    LEFT JOIN tbl_acc_project AS E ON A.project_id=E.accpro_id
                                    WHERE B.accad_id='$row->accad_id'");
                                    $row_num_main=mysqli_num_rows($sql_num_main);

                                    echo '<td rowspan="'.$row_num_main.'">'.(++$i).'</td>';
                                    echo '<td rowspan="'.$row_num_main.'">'.date('D d-M-Y',strtotime($row->accad_date_record)).'</td>';
                                    echo '<td rowspan="'.$row_num_main.'">'.$row->accdr_invoice_no.'</td>';
                                    echo '<td rowspan="'.$row_num_main.'">'.$row->trat_name.'</td>';
                                    echo '<td rowspan="'.$row_num_main.'">'.$row->vot_name.'</td>';
                                    echo '<td rowspan="'.$row_num_main.'">'.$row->des_name.'</td>';
                                    echo '<td rowspan="'.$row_num_main.'">'.$row->accdr_name.'</td>';
                                    echo '<td rowspan="'.$row_num_main.'">'.$row->accdr_address.'</td>';
                                    echo '<td rowspan="'.$row_num_main.'">'.$row->accdr_cash_in.'</td>';
                                    echo '<td rowspan="'.$row_num_main.'">'.$row->accdr_cash_out.'</td>';

                                    $tmp=$row->accad_id;
                                }
                                else{
                                    echo '<td style="display: none!important;">'.(++$i).'</td>';
                                    echo '<td style="display: none!important;">'.date('D d-M-Y',strtotime($row->accad_date_record)).'</td>';
                                    echo '<td style="display: none!important;">'.$row->accdr_invoice_no.'</td>';
                                    echo '<td style="display: none!important;">'.$row->trat_name.'</td>';
                                    echo '<td style="display: none!important;">'.$row->vot_name.'</td>';
                                    echo '<td style="display: none!important;">'.$row->des_name.'</td>';
                                    echo '<td style="display: none!important;">'.$row->accdr_name.'</td>';
                                    echo '<td style="display: none!important;">'.$row->accdr_address.'</td>';
                                    echo '<td style="display: none!important;">'.$row->accdr_cash_in.'</td>';
                                    echo '<td style="display: none!important;">'.$row->accdr_cash_out.'</td>';
                                }
                                echo '<td>'.$row->accca_account_name.'</td>';
                                echo '<td>'.$row->accca_number.'</td>';
                                echo '<td>'.$row->accpro_name.'</td>';
                                echo '<td>===</td>';
                                echo '<td>'.$row->debit.'</td>';
                                echo '<td>'.$row->credit.'</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript" src="../../assets/global/plugins/jquery.min.js"></script>


<?php include_once '../layout/footer.php' ?>
                    <?php
                        $i = 0;
                        $tmp=0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                if($row->accad_id!=$tmp){
                                    $sql_num_main=$connect->query("SELECT A.*,transation_id,accad_id,accca_number,accca_account_name,accpro_name
                                    FROM tbl_acc_add_transaction_detail AS A 
                                    LEFT JOIN tbl_acc_add_transaction AS B ON A.transation_id=B.accad_id
                                    LEFT JOIN tbl_acc_chart_account AS C ON A.chart_acc_id=C.accca_id
                                    LEFT JOIN tbl_acc_project AS E ON A.project_id=E.accpro_id
                                    WHERE B.accad_id='$row->accad_id'");
                                    $row_num_main=mysqli_num_rows($sql_num_main);

                                    echo '<td rowspan="'.$row_num_main.'">'.(++$i).'</td>';
                                    echo '<td rowspan="'.$row_num_main.'">'.date('D d-M-Y',strtotime($row->accad_date_record)).'</td>';
                                    echo '<td rowspan="'.$row_num_main.'">'.$row->accdr_invoice_no.'</td>';
                                    echo '<td rowspan="'.$row_num_main.'">'.$row->trat_name.'</td>';
                                    echo '<td rowspan="'.$row_num_main.'">'.$row->vot_name.'</td>';
                                    echo '<td rowspan="'.$row_num_main.'">'.$row->des_name.'</td>';
                                    echo '<td rowspan="'.$row_num_main.'">'.$row->accdr_name.'</td>';
                                    echo '<td rowspan="'.$row_num_main.'">'.$row->accdr_address.'</td>';
                                    echo '<td rowspan="'.$row_num_main.'">'.$row->accdr_cash_in.'</td>';
                                    echo '<td rowspan="'.$row_num_main.'">'.$row->accdr_cash_out.'</td>';

                                    $tmp=$row->accad_id;
                                }
                                else{
                                    echo '<td style="display: none!important;">'.(++$i).'</td>';
                                    echo '<td style="display: none!important;">'.date('D d-M-Y',strtotime($row->accad_date_record)).'</td>';
                                    echo '<td style="display: none!important;">'.$row->accdr_invoice_no.'</td>';
                                    echo '<td style="display: none!important;">'.$row->trat_name.'</td>';
                                    echo '<td style="display: none!important;">'.$row->vot_name.'</td>';
                                    echo '<td style="display: none!important;">'.$row->des_name.'</td>';
                                    echo '<td style="display: none!important;">'.$row->accdr_name.'</td>';
                                    echo '<td style="display: none!important;">'.$row->accdr_address.'</td>';
                                    echo '<td style="display: none!important;">'.$row->accdr_cash_in.'</td>';
                                    echo '<td style="display: none!important;">'.$row->accdr_cash_out.'</td>';
                                }
                                echo '<td>'.$row->accca_account_name.'</td>';
                                echo '<td>'.$row->accca_number.'</td>';
                                echo '<td>'.$row->accpro_name.'</td>';
                                echo '<td>===</td>';
                                echo '<td>'.$row->debit.'</td>';
                                echo '<td>'.$row->credit.'</td>';
                            echo '</tr>';
                        }
                    ?>
