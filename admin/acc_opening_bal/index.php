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
    $sql=$connect->query("SELECT A.*,accca_account_name,C.date_record AS open_date
        FROM tbl_acc_add_tran_amount_detail AS A 
        LEFT JOIN tbl_acc_chart_account AS B ON A.acc_id=B.accca_id
        LEFT JOIN tbl_acc_add_tran_amount AS C ON A.main_id=C.id
        WHERE A.parent_id='0' 
        AND C.date_record BETWEEN '$v_date_s' AND '$v_date_e'
        AND C.status_type='5'");

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
    $v_current_month=date('Y-m');
    $sql=$connect->query("SELECT A.*,accca_account_name,C.date_record AS open_date
        FROM tbl_acc_add_tran_amount_detail AS A 
        LEFT JOIN tbl_acc_chart_account AS B ON A.acc_id=B.accca_id
        LEFT JOIN tbl_acc_add_tran_amount AS C ON A.main_id=C.id
        WHERE A.parent_id='0' 
        AND C.status_type='5'");
}
if(isset($_GET['status'])=='close'){
    echo '<script>myAlertSuccess("Add")</script>';
}
 ?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Openning Balance</h2>
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
        </form>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Check <input type="checkbox" name="check_all"></th>
                        <th>Date Record</th>
                        <th>Chart of Account</th>
                        <th>Description</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Balance</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        while ($row = mysqli_fetch_object($sql)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td class="text-center"><input type="checkbox" name="myCheckboxes[]" id="myCheckboxes"  value="'.$row->id.'"></td>';
                                echo '<td>'.date('d-M-Y',strtotime($row->open_date)).'</td>';
                                echo '<td>'.$row->accca_account_name.'</td>';
                                echo '<td>'.$row->description.'</td>';
                                echo '<td>'.$row->debit.'</td>';
                                echo '<td>'.$row->credit.'</td>';
                                echo '<td>'.($row->debit-$row->credit).'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<script src="../../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    function submitForm() {
        $i=0;
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
        bootbox.confirm("You you wanna delete all of this ?", function(result){ 
            if(result){
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
            }
        });
    }

</script>
<script>
    $('input[name=check_all]').change(function () {
        var st=$(this).prop('checked');
        $('td:nth-child(2)').find('input[name^=myCheckboxes]').each(function () {
            $(this).prop('checked',st);
        });
    });
</script>
<?php include_once '../layout/footer.php' ?>
