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
           *
        FROM tbl_acc_none_cash_record AS A 
        WHERE DATE_FORMAT(date_record,'%Y-%m-%d') BETWEEN '$v_date_s' AND '$v_date_e'
        ORDER BY date_record ASC");

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
    $v_date_s = @$_POST['txt_date_start'];
    $v_date_e = @$_POST['txt_date_end'];
    $get_data = $connect->query("SELECT 
           *
        FROM tbl_acc_none_cash_record AS A
        ORDER BY date_record ASC");
}
else{
    $v_current_year_month = date('Y-m');
    $get_data = $connect->query("SELECT *
        FROM  tbl_acc_none_cash_record AS A 
        WHERE DATE_FORMAT(date_record,'%Y-%m')='$v_current_year_month'
        ORDER BY date_record ASC"); 
}

 ?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Add None Cash Record</h2>
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
            
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_2" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Check</th>
                        <th>Date Record</th>
                        <th>Delivery N&deg;</th>
                        <th>Invoice N&deg;</th>
                        <th>PO N&deg;</th>
                        <th>Name </th>
                        <th class="text-center">Accrual </th>
                        <th>Note </th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $bal_acc=0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td class="text-center"><input type="checkbox" name="myCheckboxes[]" id="myCheckboxes"  value="'.$row->id.'"></td>';
                                echo '<td>'.date('D d-m-Y',strtotime($row->date_record)).'</td>';
                                echo '<td>'.$row->deli_no.'</td>';
                                echo '<td>'.$row->inv_no.'</td>';
                                echo '<td>'.$row->po_no.'</td>';
                                echo '<td>'.$row->name.'</td>';
                                echo '<th class="text-center">'.number_format($row->Accrual,2).' $</th>';
                                echo '<td>'.$row->note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a target="_blank" href="edit.php?edit_id='.$row->id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                    // echo '<a href="delete.php?del_id='.$row->accdr_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

                                echo '</td>';
                            echo '</tr>';
                        $bal_acc+=$row->Accrual;
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="text-center text-success"><?= number_format($bal_acc,2) ?> $</th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>



<script src="../../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
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

</script>
<script type="text/javascript">
    var $custm_print = function(){
        $('[name=btn_print]').click();
    }
</script>
<?php include_once '../layout/footer.php' ?>