<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
if(isset($_POST['btn_search'])){
    $v_date_s = @$_POST['txt_date_start'];
    $v_date_e = @$_POST['txt_date_end'];
    $get_data = $connect->query("SELECT 
           *,
         A.id AS main_id,
         A.note AS main_note
        FROM tbl_acc_director_transation AS A 
        LEFT JOIN tbl_acc_director_tran_type AS B ON A.id=B.id
        WHERE DATE_FORMAT(A.date_record,'%Y-%m-%d') BETWEEN '$v_date_s' AND '$v_date_e' 
        ORDER BY date_record,A.id ASC");
    
    $sql_sum=$connect->query("SELECT SUM(debit) AS tot_debit,
         SUM(credit) AS tol_cre
         FROM tbl_acc_director_transation
         WHERE DATE_FORMAT(date_record,'%Y-%m-%d')<'$v_date_s'");
     $row_old_bal=mysqli_fetch_object($sql_sum);
    if(mysqli_num_rows($sql_sum)>0)
        $v_old_amo=$row_old_bal->tot_debit-$row_old_bal->tol_cre;
    else
        $v_old_amo=0;

}else if(isset($_POST['btn_print'])){
    $v_date_start = @$_POST['txt_date_start'];
    $v_date_end = @$_POST['txt_date_end'];
    $v_begin_bal = @$_POST['txt_bigning_bal'];
    $v_cash_in = @$_POST['txt_cash_in'];
    $v_cash_out = @$_POST['txt_cash_out'];
    if(($v_date_start&&$v_date_end)==""){
        header('location: index.php');
        die();
    }else{
        header('location: print.php?date_start='.$v_date_start.'&date_end='.$v_date_end.'&bin_bal='.$v_begin_bal.'&cash_in='.$v_cash_in.'&cash_out='.$v_cash_out);
    }
    // $v_name = @$_POST['txt_name'];
}
else if(isset($_POST['btn_Review'])){
    $get_data = $connect->query("SELECT 
           *,SUM(debit) AS tot_debit,
         SUM(credit) AS tol_cre,
         A.id AS main_id,
        A.note AS main_note
        FROM  tbl_acc_director_transation AS A 
        LEFT JOIN tbl_acc_director_tran_type AS B ON A.id=B.id
        GROUP BY A.id
        ORDER BY A.date_record,A.id ASC");
        $v_old_amo=0;
}
else{
    $v_current_year_month = date('Y-m');
    $get_data = $connect->query("SELECT 
           *,
         A.id AS main_id,
        A.note AS main_note
        FROM  tbl_acc_director_transation AS A 
        LEFT JOIN tbl_acc_director_tran_type AS B ON A.id=B.id
        WHERE DATE_FORMAT(A.date_record,'%Y-%m')='$v_current_year_month'
        GROUP BY A.id
        ORDER BY A.date_record,A.id ASC");

    $sql_sum=$connect->query("SELECT SUM(debit) AS tot_debit,
         SUM(credit) AS tol_cre
         FROM tbl_acc_director_transation
         WHERE DATE_FORMAT(date_record,'%Y-%m')<'$v_current_year_month'");
     $row_old_bal=mysqli_fetch_object($sql_sum);
    if(mysqli_num_rows($sql_sum)>0)
        $v_old_amo=$row_old_bal->tot_debit-$row_old_bal->tol_cre;
    else
        $v_old_amo=0;
}

 ?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Add Personal Transations</h2>
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
                    <input autocomplete="off" name="txt_date_start" value="<?= @$_POST['txt_date_start'] ?>" type="text" class="form-control" placeholder="Date From ....">
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
                    <a name="btn_delete" onclick="submitForm()" id="sample_editable_1_new" class="btn-sm btn btn-primary"> Delete 
                        <i class="fa fa-list"></i>
                    </a>
                </div>
                <div class="caption font-dark" style="display: inline-block;">
                    <button type="submit" name="btn_search" id="sample_editable_1_new" class="btn blue btn-sm"> Search
                        <i class="fa fa-search"></i>
                    </button>

                </div>
                <div class="caption font-dark" style="display: inline-block;">
                    <button type="submit" name="btn_Review" id="sample_editable_1_new" class="btn btn-success btn-sm"> Review
                        <i class="fa fa-reply-all"></i>
                    </button>
                </div>
                <div class="caption font-dark" style="display: inline-block;">
                    <button type="submit" name="btn_print" id="sample_editable_1_new" class="btn btn-warning btn-sm"> Print
                        <i class="fa fa-print"></i>
                    </button>
                </div>
                <div class="caption font-dark" style="display: inline-block;">
                    <a href="<?= $_SERVER['PHP_SELF'] ?>" id="sample_editable_1_new" class="btn red btn-sm"> Clear
                        <i class="fa fa-refresh"></i>
                    </a>
                </div>

            </div>
            <br>
            <br>
            <br>
            <div class="clearfix"></div>
                <div class="col-xs-2">
                    <label for="input">Beginning Balance :</label>
                    <input type="text" name="txt_bigning_bal" readonly="" id="input" class="form-control" value="<?= number_format($v_old_amo,2) ?> $" required="required">                
                </div>
                <div class="col-xs-2">
                    <label for="input">Total Debit:</label>
                    <input type="text" name="txt_cash_in" readonly="" id="input" class="form-control" value="0.00 $" required="required">                
                </div>
                <div class="col-xs-2">
                    <label for="input">Total Credit :</label>
                    <input type="text" name="txt_cash_out" readonly="" id="input" class="form-control" value="0.00 $" required="required">                
                </div>
                <div class="col-xs-2">
                    <label for="input">Total Cash Balance :</label>
                    <input type="text" name="txt_cash_bal" readonly="" id="input" class="form-control" value="0.00 $" required="required">                
                </div>
            <br>
        </form>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Check</th>
                        <th>Date Record</th>
                        <th>Attach File</th>
                        <th>Director Transation Type</th>
                        <th class="text-center">Debit</th>
                        <th class="text-center">Credit </th>
                        <th class="text-center">Balance </th>
                        <th>Note </th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $bal=round($v_old_amo,2);
                        $flag_in=0;
                        $flag_out=0;


                        $total_cash_in=0;
                        $total_cash_out=0;
                        $total_bal=0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            

                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td class="text-center"><input type="checkbox" name="myCheckboxes[]" id="myCheckboxes"  value="'.$row->main_id.'"></td>';
                                echo '<td>'.date('D d-m-Y',strtotime($row->date_record)).'</td>';
                                 echo '<td class="text-center">';
                                    echo '<a href="list_attach.php?sent_id='.$row->main_id.'" class="btn btn-xs btn-info"><i class="fa fa-file"></i></a> ';
                                echo '</td>';
                                echo '<td>'.$row->name.'</td>';
                                echo '<th class="text-center">'.round($row->debit,2).' $</th>';
                                echo '<th class="text-center">'.round($row->credit,2).' $</th>';

                                // $row->debit+=$bal;
                                // $row->credit-=$bal;
                                $flag_in+=$row->debit;
                                $flag_out+=$row->credit;
                                $bal= round($bal+$row->debit-$row->credit,2);

                                echo '<th class="text-center">'.round($bal,2).' $</th>';
                                echo '<td>'.$row->main_note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->main_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                    // echo '<a href="delete.php?del_id='.$row->accdr_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

                                echo '</td>';
                            echo '</tr>';


                            $total_cash_in+=$row->debit;
                            $total_cash_out+=$row->credit;
                            $total_bal=$v_old_amo+$total_cash_in-$total_cash_out;
                        }
                    ?>
                </tbody>
            </table>
            <input type="hidden" name="txt_t_cash_in_tmp" value="<?= $total_cash_in ?>">
            <input type="hidden" name="txt_t_cash_out_tmp" value="<?= $total_cash_out ?>">
            <input type="hidden" name="txt_t_cash_bal_tmp" value="<?= $total_bal ?>">
        </div>
    </div>
</div>



<script src="../../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    function submitForm() {
        $i=0;
        $(document).ready(function() {
            var myCheckboxes = new Array();
            $("input:checked").each(function(e) {
               // $(this).parents('tr').find('td:not(:first-child),th').html('--');
               myCheckboxes.push($(this).val());
               $i++;
            });

            if($i==0){
                alert("Please Check !");
                return false;
            }
            // return false;
            var a=confirm("You you wanna delete all of this ?");
            if(a==false){
                 return false;
            }
            $.ajax({
                type: "POST",
                url: "delete_all.php",
                dataType: 'html',
                data: 'myCheckboxes='+myCheckboxes,
                success: function(result){
                    // alert(result);
                    // $('#myResponse').html(data)
                }
            });
            window.location.replace("index.php");
        });
    }


    var total_in=$('input[name=txt_t_cash_in_tmp]').val();
    total_in=Number(parseFloat(total_in).toFixed(2)).toLocaleString('en', {
        minimumFractionDigits: 2
    });
    $('input[name=txt_cash_in]').val(total_in+" $");

    var total_out=$('input[name=txt_t_cash_out_tmp]').val();
    total_out=Number(parseFloat(total_out).toFixed(2)).toLocaleString('en', {
        minimumFractionDigits: 2
    });
    $('input[name=txt_cash_out]').val(total_out+" $");

    var total_bal=$('input[name=txt_t_cash_bal_tmp]').val();
    total_bal=Number(parseFloat(total_bal).toFixed(2)).toLocaleString('en', {
        minimumFractionDigits: 2
    });
    $('input[name=txt_cash_bal]').val(total_bal+" $");

</script>

<?php include_once '../layout/footer.php' ?>
<!-- <div class="modal fade" id="modal_print">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Input Information</h4>
            </div>
            <div class="modal-body">
                <form action="#" method="post" accept-charset="utf-8">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label>Date From: </label>
                                <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" required name="txt_start" value="<?= date('Y-m-d') ?>">
                            </div>  
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label>Date End: </label>
                                <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" required name="txt_end" value="<?= date('Y-m-d') ?>">
                            </div>  
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-danger" data-dismiss="modal"><i class="fa fa-undo"></i> Close</button>
                        <button type="submit" name="btn_print" class="btn btn-info"><i class="fa fa-print"></i> Print</button>
                        
                    </div>
                </form>
            </div>
    </div>
</div> -->