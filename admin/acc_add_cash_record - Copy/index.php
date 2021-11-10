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
    // echo $v_date_s.'fff'.$v_date_e;
    $get_data = $connect->query("SELECT 
           *,E.name AS cash_name
        FROM   tbl_acc_cash_record AS A 
        LEFT JOIN tbl_acc_decription AS B ON A.accdr_description=B.des_id
        LEFT JOIN tbl_acc_transaction_type_list AS C ON A.transa_type_id=C.trat_id
        LEFT JOIN tbl_acc_voucher_type_list AS D ON A.voucher_type_id=D.vot_id
        LEFT JOIN tbl_acc_type_cash_bank AS E ON A.cash_type_bank_id=E.id
        WHERE DATE_FORMAT(accdr_date,'%Y-%m-%d') BETWEEN '$v_date_s' AND '$v_date_e' AND status=1
        ORDER BY accdr_date,accdr_id ASC");


    $sql=$connect->query("SELECT SUM(accdr_cash_in) AS bal_in,
         SUM(accdr_cash_out) AS bal_out
        FROM  tbl_acc_cash_record 
        WHERE DATE_FORMAT(accdr_date,'%Y-%m-%d') < '$v_date_s' AND status=1");
    $row_old_bal=mysqli_fetch_object($sql);
    if(mysqli_num_rows($sql)>0)
        $v_old_amo=$row_old_bal->bal_in-$row_old_bal->bal_out;
    else
        $v_old_amo=0;

}else if(isset($_POST['btn_print'])){
    $v_date_start = @$_POST['txt_date_start'];
    $v_date_end = @$_POST['txt_date_end'];
    $v_begin_bal = @$_POST['txt_bigning_bal'];
    $v_cash_in = @$_POST['txt_cash_in'];
    $v_cash_out = @$_POST['txt_cash_out'];
    if(($v_date_start&&$v_date_end)==""){
        echo '<script>';
            echo 'alert("Please Input Search Date and press button print !")';
        echo '</script>';
        header('location: index.php');
    }else{
        header('location: print.php?date_start='.$v_date_start.'&date_end='.$v_date_end);
    }
}
else{
    $v_current_year_month = date('Y-m-d');
    $get_data = $connect->query("SELECT 
           *,SUM(accdr_cash_in) AS bal_in,
         SUM(accdr_cash_out) AS bal_out,E.name AS cash_name
        FROM  tbl_acc_cash_record AS A 
        LEFT JOIN tbl_acc_decription AS B ON A.accdr_description=B.des_id
        LEFT JOIN tbl_acc_transaction_type_list AS C ON A.transa_type_id=C.trat_id
        LEFT JOIN tbl_acc_voucher_type_list AS D ON A.voucher_type_id=D.vot_id
        LEFT JOIN tbl_acc_type_cash_bank AS E ON A.cash_type_bank_id=E.id
        WHERE DATE_FORMAT(accdr_date,'%Y-%m-%d')='$v_current_year_month' AND status=1
        GROUP BY accdr_id
        ORDER BY accdr_date,accdr_id ASC"); 
    $v_old_amo=0;
}

 ?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Add Cash Record</h2>
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
                    <button type="submit" name="btn_print" formtarget="new" id="sample_editable_1_new" class="btn btn-warning btn-sm"> Print
                        <i class="fa fa-print"></i>
                    </button>
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
                    <label for="input">Total Cash In :</label>
                    <input type="text" name="txt_cash_in" readonly="" id="input" class="form-control" value="0.00 $" required="required">                
                </div>
                <div class="col-xs-2">
                    <label for="input">Total Cash Out :</label>
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
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_1" role="grid" aria-describedby="sample_1_info">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Check <input type="checkbox" name="check_all"></th>
                        <th>Date Record</th>
                        <th>Voucher Type</th>
                        <th>Transation Type</th>
                        <th>Cash Bank Type</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Reference N&deg;</th>
                        <th style="padding:10px 60px!important;">Voucher N&deg;</th>
                        <th>Attach File</th>
                        <th>Name </th>
                        <th>Description </th>
                        <th class="text-center">Cash In </th>
                        <th class="text-center">Cash Out </th>
                        <th class="text-center">Balance </th>
                        <th>Note </th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $bal=round($v_old_amo,2);
                        // // $flag_in=0;
                        $flag_in=0;
                        $flag_out=0;


                        $total_cash_in=0;
                        $total_cash_out=0;
                        $total_bal=0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            

                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td class="text-center"><input type="checkbox" name="myCheckboxes[]" id="myCheckboxes"  value="'.$row->accdr_id.'"></td>';
                                echo '<td>'.date('D d-m-Y h:i:s',strtotime($row->accdr_date)).'</td>';
                                echo '<td>'.$row->vot_name.'</td>';
                                echo '<td>'.$row->trat_name.'</td>';
                                echo '<td>'.$row->cash_name.'</td>';
                                echo '<td>'.$row->accdr_name.'</td>';
                                echo '<td>'.$row->accdr_address.'</td>';
                                echo '<td>'.$row->accdr_invoice_no.'</td>';

                                echo '<td  style="width: 100%!important;" class="text-center">';

                                    echo '<p>'.$row->accdr_voucher_no.' <a data_id='.$row->accdr_id.' class="btn btn-xs green" title="Edit"><i class="fa fa-pencil"></i></a></p>';
                                    echo '<div style="display: flex;">
                                            <input type="hidden" required class="form-control input-small" value="'.$row->accdr_voucher_no.'">
                                            <button style="visibility: hidden;" type="button" class="btn btn-primary btn-xs"><i class="fa fa-save"></i></button>
                                            <div';
                                echo '</td>';
                                 echo '<td class="text-center">';
                                    echo '<a href="list_attach.php?sent_id='.$row->accdr_id.'" class="btn btn-xs btn-info"><i class="fa fa-file"></i></a> ';
                                echo '</td>';
                                echo '</td>';
                                echo '<td>'.$row->accdr_name.'</td>';
                                echo '<td>'.$row->des_name.'</td>';
                                echo '<th class="text-center">'.round($row->accdr_cash_in,2).'<i class="fa fa-dollar"></i></th>';
                                echo '<th class="text-center">'.round($row->accdr_cash_out,2).' <i class="fa fa-dollar"></i></th>';

                                // $row->accdr_cash_in+=$bal;
                                // $row->accdr_cash_out-=$bal;
                                $flag_in+=$row->accdr_cash_in;
                                $flag_out+=$row->accdr_cash_out;
                                $bal= round($bal+$row->accdr_cash_in-$row->accdr_cash_out,2);

                                echo '<th class="text-center">'.round($bal,2).' <i class="fa fa-dollar"></i></th>';
                                echo '<td>'.$row->accdr_note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->accdr_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                echo '</td>';
                            echo '</tr>';


                            $total_cash_in+=$row->accdr_cash_in;
                            $total_cash_out+=$row->accdr_cash_out;
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
    $('td:nth-child(10)').find('button').click(function () {
        var v_id=$(this).parents('td').find('a').attr('data_id');
        var v_code=$(this).parents('td').find('input').val();
        var arr=new Array(v_id,v_code);
        $.ajax({url:'ajax_update_vou_code.php',type:'POST',data:'data='+arr,success:function (result) {
            if(!(result).trim()){
                alert("Error");
                return false;
            }
        }});
        $(this).parents('td').find('p').html(v_code);
        $(this).prev().hide();
        $(this).hide();
        // $(this).parents('td').find('p >a').css('display','block');
        alert('Save Completed !');
    });
    $('td:nth-child(10) a').click(function () {
        $(this).parents('td').find('input').attr('type','text');
        $(this).parents('td').find('input').css('margin','0px 25px');
        $(this).parents('td').find('button').css('visibility','visible');
        $(this).css('display','none');
    });
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
<script>
    $('input[name=check_all]').change(function () {
        var st=$(this).prop('checked');
        $('td:nth-child(2)').find('input[name^=myCheckboxes]').each(function () {
            $(this).prop('checked',st);
        });
    });
</script>
<!-- <script type="text/javascript">
    var $custm_print = function(){
        $('[name=btn_print]').click();
    }
</script> -->
<?php include_once '../layout/footer.php' ?>
