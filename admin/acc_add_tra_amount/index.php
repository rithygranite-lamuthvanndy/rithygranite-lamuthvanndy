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
    $get_data = $connect->query("SELECT  A.id AS id_main,A.p_appr,ref_id,A.date_record,A.status_type,name,
        SUM(B.debit) AS total_debit,
        SUM(B.credit) AS total_credit,
        (SELECT COUNT(*) 
            FROM tbl_acc_add_tran_amount_detail AS A1
            WHERE A1.main_id=A.id) AS count_row
        FROM tbl_acc_add_tran_amount AS A 
        LEFT JOIN tbl_acc_add_tran_amount_detail AS B ON A.id=B.main_id
        WHERE DATE_FORMAT(A.date_record,'%Y-%m-%d') BETWEEN '$v_date_s' AND '$v_date_e'
        AND status_type<>'5'
        GROUP BY A.id");

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
    $get_data = $connect->query("SELECT  A.id AS id_main,A.p_appr,ref_id,A.date_record,A.status_type,name,
        SUM(B.debit) AS total_debit,
        SUM(B.credit) AS total_credit,
        (SELECT COUNT(*) 
            FROM tbl_acc_add_tran_amount_detail AS A1
            WHERE A1.main_id=A.id) AS count_row
        FROM tbl_acc_add_tran_amount AS A 
        LEFT JOIN tbl_acc_add_tran_amount_detail AS B ON A.id=B.main_id
        AND status_type<>'5'
        GROUP BY A.id
        ");
}
else{
    $v_current_year_month = date('Y-m');
    $get_data = $connect->query("SELECT  A.id AS id_main,A.p_appr,ref_id,A.date_record,A.status_type,name,
        SUM(B.debit) AS total_debit,
        SUM(B.credit) AS total_credit,
        (SELECT COUNT(*) 
            FROM tbl_acc_add_tran_amount_detail AS A1
            WHERE A1.main_id=A.id) AS count_row
        FROM tbl_acc_add_tran_amount AS A 
        LEFT JOIN tbl_acc_add_tran_amount_detail AS B ON A.id=B.main_id
        WHERE DATE_FORMAT(A.date_record,'%Y-%m')='$v_current_year_month'
        AND status_type<>'5'
        GROUP BY A.id
        ORDER BY A.date_record DESC
        "); 
}
if(isset($_POST['txt_new_row'])){
    $_SESSION['new_row']=$_POST['txt_new_row'];
}


 ?>
<style type="text/css">
                .switch {
                    position: relative;
                    display: inline-block;
                    width: 90px;
                    height:50px;
                }

                .switch input #togBtn {display:none;}

                .slider {
                    position: absolute;
                    cursor: pointer;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background-color: #ca2222;
                    -webkit-transition: .4s;
                    transition: .4s;
                }

                .slider:before {
                    position: absolute;
                    content: "";
                    height: 20px;
                    width: 20px;
                    left: 4px;
                    bottom: 4px;
                    background-color: white;
                    -webkit-transition: .4s;
                    transition: .4s;
                }

                #togBtn:checked + .slider {
                    background-color: #2ab934;
                }

                #togBtn:focus + .slider {
                    box-shadow: 0 0 1px #2196F3;
                }

                #togBtn:checked + .slider:before {
                    -webkit-transform: translateX(55px);
                    -ms-transform: translateX(55px);
                    transform: translateX(55px);
                }

                /*------ ADDED CSS ---------*/
                .on
                {
                    display: none;
                }

                .on, .off
                {
                    color: white;
                    position: absolute;
                    transform: translate(-50%,-50%);
                    top: 50%;
                    left: 50%;
                    font-size: 10px;
                    font-family: Verdana, sans-serif;
                }

                #togBtn:checked + .slider .on
                {display: block;}

                #togBtn:checked + .slider .off
                {display: none;}

                /*--------- END --------*/

                /* Rounded sliders */
                .slider.round {
                    border-radius: 34px;
                }

                .slider.round:before {
                  border-radius: 50%;}
            </style>
 
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Add Transation</h2>
        </div>
    </div>
    <br>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="../acc_add_tra_amount/">Transaction Amount</a>
        </li>
        <li role="presentation">
            <a href="../acc_add_tra_debit_credit/">Transaction Debit/Credit</a>
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
                                <input name="txt_new_row" form="form" value="<?= (@$_SESSION['new_row'])?(@$_SESSION['new_row']):0 ?>" class="form-control" type="number" onsubmit="this.form,submit()" value="0">
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
        </form>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <?php 
                // Getting Position Account Manager 
                $v_pos_id=$_SESSION['user']->user_position;
                // $v_pos_id=6 is ID of Account Manager
             ?>
             <?php 
                if($v_pos_id==6||$v_pos_id==15||$v_pos_id==1){
                    echo 'Approved All';
                    echo '<br>';
                        echo '<label class="switch">';
                            echo '<input type="checkbox" id="togBtn" name="check_all_view" onchange="change_views(this);">
                                <div class="slider round">
                                    <span class="on">YES</span>
                                    <span class="off">NO</span>
                                </div>';
                        echo '</label>';
                }
             ?>
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <?php 
                            if($v_pos_id==6||$v_pos_id==15||$v_pos_id==1){
                                echo '<th>';
                                    echo 'Approved';
                                echo '</th>';
                            }
                         ?>
                        <th>Date Record</th>
                        <th>Name</th>
                        <th>Type Of DR/CR</th>
                        <th>Ref N&deg;</th>
                        <th class="text-center">Total Debit</th>
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
                                echo '<td>'.++$i.'</td>';
                                if($v_pos_id==6||$v_pos_id==15||$v_pos_id==1){
                                    echo '<td><label class="switch">';
                                        echo '<input type="checkbox" id="togBtn" data-parent-id='.$row->id_main.' name="rdoAppr" onchange="change_view(this);" '.(($row->p_appr)?('checked'):('')).'>
                                        <div class="slider round">
                                            <span class="on">YES</span>
                                            <span class="off">NO</span>
                                        </div>';
                                    echo '</label></td>';
                                }
                                echo '<td>'.date('d-M-Y',strtotime($row->date_record)).'</td>';
                                echo '<td>'.$row->name.'</td>';
                                if($row->status_type==1){
                                    echo '<td>Cash Record Voucher</td>';
                                    $sql=$connect->query("SELECT accdr_voucher_no FROM  tbl_acc_cash_record WHERE accdr_id='$row->ref_id'");
                                    $row_tmp=mysqli_fetch_object($sql);
                                    echo '<td>'.@$row_tmp->accdr_voucher_no.'</td>';
                                }
                                else if($row->status_type==2){
                                    echo '<td>IV Sale Revenue</td>';
                                    $sql=$connect->query("SELECT inv_no FROM tbl_acc_none_sale_revenue WHERE id='$row->ref_id'");
                                    $row_tmp=mysqli_fetch_object($sql);
                                    echo '<td>'.$row_tmp->inv_no.'</td>';
                                }
                                else if($row->status_type==3){
                                    echo '<td>Bill Supplier</td>';
                                    $sql=$connect->query("SELECT inv_no FROM tbl_acc_none_bill_supp WHERE id='$row->ref_id'");
                                    $row_tmp=mysqli_fetch_object($sql);
                                    echo '<td>'.$row_tmp->inv_no.'</td>';
                                }
                                else if($row->status_type==4){
                                    echo '<td>Settle Advance</td>';
                                    $sql=$connect->query("SELECT entry_no FROM tbl_acc_none_settle_advance WHERE id='$row->ref_id'");
                                    $row_tmp=mysqli_fetch_object($sql);
                                    echo '<td>'.@$row_tmp->entry_no.'</td>';
                                }
                                echo '<td class="text-center">'.number_format($row->total_debit,2).'</td>';
                                echo '<td class="text-center">'.number_format($row->total_credit,2).'</td>';
                                echo '<td class="text-center">';                                echo '<a target="_blank" href="print.php?print_id='.$row->id_main.'&status=tra_amount" class="btn btn-xs btn-danger" title="Print"><i class="fa fa-print"></i></a> ';
                                    echo '<a target="_blank" href="edit.php?edit_id='.$row->id_main.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                    echo '<a href="#more_info" class="btn btn-info btn-xs" onclick="load_iframe(this)" data_id="'.$row->id_main.'" data_status="'.$row->status_type.'" role="button" data-toggle="modal">More Info</a>';
                                    echo '<input type="checkbox" name="myCheckboxes[]" id="myCheckboxes"  value="'.$row->id_main.'">';
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
       let v_id=$(obj).attr('data_id');
       // let v_status=$(obj).attr('data_status');
        $('#my_frame').attr("src","iframe_more_info.php?v_id="+v_id);
    }
    function change_view (args) {
        let v_view=$(args).prop('checked');
        let v_man_id=$(args).parents('tr').find('td:nth-child(2)').find('input').attr('data-parent-id');
        let arr=[{v_view,v_man_id}];
        $.ajax({url: "ajax_update_appro.php",
            type: "POST",
            data: "myData="+JSON.stringify(arr),
            async: false,
            success: function(data,status){ 
            myAlertInfo("Approved !");
        }});
    }
    function change_views (args) {
        var check=$(args).prop('checked');
        let v_arrs=[];
        if(check){
            $('td:nth-child(2)').find('label>input').prop("checked", !$(this).prop("checked"));
            $('td:nth-child(2)').find('label>input').each(function () {
                var v_view=$(this).prop('checked');
                var v_man_id = $(this).parents('tr').find('td:nth-child(2)').find('input').attr('data-parent-id');
                let arr={v_view,v_man_id};
                v_arrs.push(arr);
            });
            $.ajax({url: "ajax_update_appro.php",
                type: "POST",
                data: "myData="+JSON.stringify(v_arrs),
                async: false,
                success: function(data,status){ 
                    myAlertInfo("Approved !");
            }});
        }
        else{
            $('td:nth-child(2)').find('label>input').removeAttr('checked');
            $('td:nth-child(2)').find('label>input').each(function () {
                var v_view=$(this).prop('checked');
                var v_man_id = $(this).parents('tr').find('td:nth-child(2)').find('input').attr('data-parent-id');
                let arr={v_view,v_man_id};
                v_arrs.push(arr);
            });
            $.ajax({url: "ajax_update_appro.php",
                type: "POST",
                data: "myData="+JSON.stringify(v_arrs),
                async: false,
                success: function(data,status){ 
                    myAlertInfo("Disable !");
            }});
        }
    }
</script>
<?php include_once '../layout/footer.php' ?>
<div class="modal fade" id="more_info">
    <div class="modal-dialog modal-lg" style="width: 80%; border: 1px solid darkred;">
        <iframe id="my_frame" frameborder="0" style="height: 600px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>