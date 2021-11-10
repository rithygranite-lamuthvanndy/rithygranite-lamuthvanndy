<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
    if(isset($_POST['btn_show_all'])){
        $get_data=$connect->query("SELECT A.*,C.*,trat_name,vot_name,accdr_invoice_no
            FROM tbl_acc_add_transaction AS A 
            LEFT JOIN tbl_acc_month_year AS B ON A.accad_month_year=B.accmy_id
            LEFT JOIN tbl_acc_cash_record AS C ON A.accad_cash_rec_id=C.accdr_id
            LEFT JOIN tbl_acc_transaction_type_list AS D ON C.tran_type_id=D.trat_id
            LEFT JOIN tbl_acc_voucher_type_list AS E ON C.vou_type_id=E.vot_id
            ORDER BY accad_id DESC
            ");
    }
    else if(isset($_POST['btn_search'])){
        $v_date_start = @$_POST['txt_date_start'];
        $v_date_end = @$_POST['txt_date_end'];
        $get_data=$connect->query("SELECT A.*,C.*,trat_name,vot_name,accdr_invoice_no
            FROM tbl_acc_add_transaction AS A 
            LEFT JOIN tbl_acc_month_year AS B ON A.accad_month_year=B.accmy_id
            LEFT JOIN tbl_acc_cash_record AS C ON A.accad_cash_rec_id=C.accdr_id
            LEFT JOIN tbl_acc_transaction_type_list AS D ON C.tran_type_id=D.trat_id
            LEFT JOIN tbl_acc_voucher_type_list AS E ON C.vou_type_id=E.vot_id
            WHERE A.accad_date_record BETWEEN '$v_date_start' AND '$v_date_end'
            ORDER BY accad_id DESC
            ");
    }else{
        $get_data=$connect->query("SELECT A.*,C.*,trat_name,vot_name,accdr_invoice_no
        FROM tbl_acc_add_transaction AS A 
        LEFT JOIN tbl_acc_month_year AS B ON A.accad_month_year=B.accmy_id
        LEFT JOIN tbl_acc_cash_record AS C ON A.accad_cash_rec_id=C.accdr_id
        LEFT JOIN tbl_acc_transaction_type_list AS D ON C.tran_type_id=D.trat_id
        LEFT JOIN tbl_acc_voucher_type_list AS E ON C.vou_type_id=E.vot_id
        WHERE A.accad_date_record='$now'
        ORDER BY accad_id DESC
        ");
    }
    
 ?>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Add Transation</h2>
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
                    <input autocomplete="off" required="" name="txt_date_start" value="<?= @$_POST['txt_date_start'] ?>" type="text" class="form-control" placeholder="Date From">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input autocomplete="off" required="" name="txt_date_end" value="<?= @$_POST['txt_date_end'] ?>" type="text" class="form-control" placeholder="Date To">
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
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Date Record</th>
                        <th>Voucher N&deg;</th>
                        <th>Invoice N&deg;</th>
                        <th>Transation Type </th>
                        <th>Voucher Type </th>
                        <th>Phone Number</th>
                        <th>Address</th>
                        <th>Cash In</th>
                        <th>Cash Out</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $tmp=0;
                        
                        while ($row = mysqli_fetch_object($get_data)) {      
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.date('D d-M-Y',strtotime($row->accad_date_record)).'</td>';
                                echo '<td>'.$row->accdr_voucher_no.'</td>';
                                echo '<td>'.$row->accdr_invoice_no.'</td>';
                                echo '<td>'.$row->trat_name.'</td>';
                                echo '<td>'.$row->vot_name.'</td>';
                                echo '<td>'.$row->accdr_phone.'</td>';
                                echo '<td>'.$row->accdr_address.'</td>';
                                echo '<td> <i class="fa fa-dollar"></i> '.$row->accdr_cash_in.'</td>';
                                echo '<td> <i class="fa fa-dollar"></i> '.$row->accdr_cash_out.'</td>';
                                echo '<td>';

                                $sql_count=$connect->query("SELECT 
                                    COUNT(transation_id) AS count
                                    FROM tbl_acc_add_transaction_detail
                                    WHERE transation_id='$row->accad_id'");
                                $row_count=mysqli_fetch_object($sql_count);
                            ?>
                                <a href="#more_info" class="btn btn-info btn-xs" onclick="load_iframe(this)" data="<?= $row->accad_id ?>" data-id="1" role="button" data-toggle="modal">More Info (<?= $row_count->count ?>)</a>
                            <?php
                                echo '<a href="edit.php?edit_id='.$row->accad_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                 echo '<a href="delete_mian.php?del_id='.$row->accad_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';
                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript" src="../../assets/global/plugins/jquery.min.js"></script>
<script type="text/javascript">
    function load_iframe(obj){
        v_this=$(obj).attr('data');
        $('#my_frame').attr("src","iframe_more_info.php?v_id="+v_this);
    }
</script>
<?php include_once '../layout/footer.php' ?>
<div class="modal fade" id="more_info">
    <div class="modal-dialog modal-lg" style="width: 1300px; border: 1px solid darkred;">
        <iframe id="my_frame" frameborder="0" style="height: 600px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>