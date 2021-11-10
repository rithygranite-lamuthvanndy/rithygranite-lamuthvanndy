<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
if(isset($_GET['status'])=='true'){
    echo '<script>myAlertSuccess("Add")</script>';
}
if(isset($_POST['btn_search'])){
    $v_date_s = @$_POST['txt_date_start'];
    $v_date_e = @$_POST['txt_date_end'];
    $get_data = $connect->query("SELECT A.*,
        SUM(debit) AS totalDebit,
        SUM(credit) AS totalCredit
        FROM tbl_acc_rec_stock_inventory AS A 
        RIGHT JOIN tbl_acc_rec_stock_inventory_detail AS B ON A.id=B.detail_id
        WHERE DATE_FORMAT(A.date_record,'%Y-%m-%d') BETWEEN '$v_date_s' AND '$v_date_e'
        GROUP BY A.id
        ORDER BY A.date_record ASC
        ");

}else if(isset($_POST['btn_print'])){
    $v_date_start = @$_POST['txt_date_start'];
    $v_date_end = @$_POST['txt_date_end'];
    if(($v_date_start&&$v_date_end)==""){
        header('location: index.php');
        die();
    }else{
        header('location: print.php?date_start='.$v_date_start.'&date_end='.$v_date_end);
    }
}
else if(isset($_POST['btn_Review'])){
    $get_data = $connect->query("SELECT A.*,
        SUM(debit) AS totalDebit,
        SUM(credit) AS totalCredit
        FROM tbl_acc_rec_stock_inventory AS A 
        RIGHT JOIN tbl_acc_rec_stock_inventory_detail AS B ON A.id=B.detail_id
        GROUP BY A.id
        ORDER BY A.date_record ASC
        ");
}
else{
    $v_current_year_month = date('Y-m');
    $get_data = $connect->query("SELECT A.*,
        SUM(debit) AS totalDebit,
        SUM(credit) AS totalCredit
        FROM tbl_acc_rec_stock_inventory AS A 
        RIGHT JOIN tbl_acc_rec_stock_inventory_detail AS B ON A.id=B.detail_id
        WHERE DATE_FORMAT(A.date_record,'%Y-%m')='$v_current_year_month'
        GROUP BY A.id
        ORDER BY A.date_record ASC"); 
}
if(isset($_POST['txt_new_row'])){
    $_SESSION['new_row_acc_add_account_stock_inventory']=$_POST['txt_new_row'];
}

 ?>

<div class="portlet light bordered">
    <!-- Nav tabs -->
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Account Record</h2>
        </div>
    </div>
    <br>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation">
            <a href="../acc_add_account_adjustment/">Adjustment Record</a>
        </li>
        <li role="presentation" class="active">
            <a href="#">Stock/ Inventory Record</a>
        </li>
    </ul>
    <br>
    <div class="">
        <div class="caption font-dark">
            <a href="add.php" id="sample_editable_1_new" class="btn green"> Add New
                <i class="fa fa-plus"></i>
            </a>
            <div class="btn-group pull-right">
                <a class="btn red btn-circle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-cog"></i>
                    <span class="hidden-xs"> Setting</span>
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu pull-right">
                    <li >
                        <a class="tool-action">
                            <i class="icon-printer"></i>
                                Custom Row Page
                                <input name="txt_new_row" form="form" value="<?= (@$_SESSION['new_row_acc_add_account_stock_inventory'])?(@$_SESSION['new_row_acc_add_account_stock_inventory']):0 ?>" class="form-control" type="number" onsubmit="this.form,submit()" value="0">
                        </a>
                    </li>
                </ul>
            </div> 
        </div>
    </div>
    <br>
    <div class="row">
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" id="form">
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
                    <a name="btn_delete" onclick="submitForm();" id="sample_editable_1_new" class="btn-sm btn btn-primary"> Delete 
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
                <div class="caption font-dark" style="display: none;">
                    <button type="submit" formtarget="new" name="btn_print" id="sample_editable_1_new" class="btn btn-warning btn-sm"> Print
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
        </form>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th class="text-center">N&deg;</th>
                        <th class="text-center">Date Record</th>
                        <th class="text-center">Entry No</th>
                        <th class="text-center">Total Debit </th>
                        <th class="text-center">Total Credit</th>
                        <th style="min-width: 100px;" class="text-center">
                            Action 
                            <i class="fa fa-cog fa-spin"></i>
                            <input type="checkbox" name="check_all">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $bal_acc=0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.date('d-M-Y',strtotime($row->date_record)).'</td>';
                                echo '<td class=" text-center">'.$row->entry_no.'</td>';
                                echo '<td class="text-center">'.number_format($row->totalDebit,2).'</td>';
                                echo '<td class="text-center">'.number_format($row->totalCredit,2).'</td>';
                                echo '<td class="text-center">';
                                    echo '<a target="_blank" href="print.php?print_id='.$row->id.'" class="btn btn-xs btn-danger" title="Print"><i class="fa fa-print"></i></a> ';
                                    echo '<a target="_blank" href="edit.php?edit_id='.$row->id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                    echo '<a href="#more_info" class="btn btn-info btn-xs" onclick="load_iframe(this)" data="'.$row->id.'" role="button" data-toggle="modal">More Info</a>';
                                    echo '<input type="checkbox" name="myCheckboxes[]" id="myCheckboxes"  value="'.$row->id.'">';
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
    $('input[name=check_all]').change(function () {
        var st=$(this).prop('checked');
        $('td:last-child').find('input[name^=myCheckboxes]').each(function () {
            $(this).prop('checked',st);
        });
    });
    function submitForm() {
        var myCheckboxes = new Array();
        $i=0;
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
    }
    function load_iframe(obj){
       let v_id=$(obj).attr('data');
        $('#my_frame').attr("src","iframe_more_info.php?v_id="+v_id);
    }
</script>
<script type="text/javascript">
    var $custm_print = function(){
        $('[name=btn_print]').click();
    }
</script>
<?php include_once '../layout/footer.php' ?><div class="modal fade" id="more_info">
<div class="modal-dialog modal-lg" style="width: 1300px; border: 1px solid darkred;">
        <iframe id="my_frame" frameborder="0" style="height: 600px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>