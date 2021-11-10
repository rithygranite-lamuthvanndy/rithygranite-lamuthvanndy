<?php 
    $menu_active =140;
    $left_active =0;
    $layout_title = "View Stock In";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
    if(isset($_POST['txt_date_start'])&&isset($_POST['txt_date_end'])){
        $v_date_start=$_POST['txt_date_start'];
        $v_date_end=$_POST['txt_date_end'];
        $condition="stsin_date_in BETWEEN '$v_date_start' AND '$v_date_end' ";
    }
    else{
        $v_current_date=date('Y-m');
        $condition="DATE_FORMAT(stsin_date_in,'%Y-%m')='{$v_current_date}'";
    }
    $sql="SELECT
        A.*,B.supsi_name,SUM(C.in_qty*C.in_price) AS total_amo,
        (
            SELECT
            COUNT(*)
            FROM tbl_st_stock_in_detail AS AA1
            WHERE AA1.stsin_id=A.stsin_id AND AA1.in_approved=0
        )AS not_approved,
        (
            SELECT
            COUNT(*)
            FROM tbl_st_stock_in_detail AS AA1
            WHERE AA1.stsin_id=A.stsin_id AND AA1.in_approved=1
        )AS approved
        FROM tbl_st_stock_in AS A 
        LEFT JOIN tbl_sup_supplier_info AS B ON A.stsin_supp_id=B.supsi_id
        LEFT JOIN tbl_st_stock_in_detail AS C ON A.stsin_id=C.stsin_id
        WHERE {$condition} GROUP BY A.stsin_id";
    // echo $sql;
    $get_data=$connect->query($sql);
 ?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-truck fa-flip-horizontal"></i> Stock In Approved</h2>
        </div>
    </div>
    <br>
    <div class="row">
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" id="form">
            <div class="col-sm-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input autocomplete="off" onchange="this.form.submit()" name="txt_date_start" value="<?= @$_POST['txt_date_start'] ?>" type="text" class="form-control" placeholder="Date From ....">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input autocomplete="off" onchange="this.form.submit()" name="txt_date_end" value="<?= @$_POST['txt_date_end'] ?>" type="text" class="form-control" placeholder="Date To">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="caption font-dark" style="display: inline-block;">
                    <a href="index.php" id="sample_editable_1_new" class="btn btn-danger"><i class="fa fa-undo"></i> Clear</a>
                </div>
            </div>
        </form>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_1" role="grid" aria-describedby="sample_1_info">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Date Stock In</th>
                        <th>Letter In N&deg;</th>
                        <th>Request N&deg;</th>
                        <th>Supplier</th>
                        <th>Total Amount</th>
                        <th>Amount Approved</th>
                        <th>Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->stsin_date_in.'</td>';
                                echo '<td>'.$row->stsin_letter_no.'</td>';
                                echo '<td>'.$row->stsin_req_no.'</td>';
                                echo '<td>'.$row->supsi_name.'</td>';
                                echo '<td>'.number_format($row->total_amo,2).'</td>';
                                echo '<td class="text-center">';
                                    echo '<div class="btn btn-danger btn-sm">Not Approved: <strong>'.$row->not_approved.'</strong></div>';
                                    echo '<div class="btn btn-success btn-sm">Approved: <strong>'.$row->approved.'</strong></div>';
                                echo '</td>';
                                echo '<td>'.$row->stsin_note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a onclick="showInfo('.$row->stsin_id.')" data-toggle="modal" href="#modal" class="btn btn-xs btn-info" title="detail"><i class=""> Detail </i></a> ';
                                    echo '<a onclick="updateApproved('.$row->stsin_id.')" data-toggle="modal" href="#modal" class="btn btn-xs btn-danger" title="detail"><i class=""> Approved </i></a> ';
                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        // ===============Refrsh Modal ========================
        $('#modal').on('hidden.bs.modal', function () {
            var iframe_statue=($(this).find('iframe').attr('src')).split('?');
            if(iframe_statue[0]=='update_approved_in.php'){
                location.reload();
            }
        });
    });
    function showInfo(e){
        document.getElementById('result_modal').src = 'more_info.php?parent='+e;
    }
    function updateApproved(e){
        document.getElementById('result_modal').src = 'update_approved_in.php?parent='+e;
    }
</script>
<?php include_once '../layout/footer.php' ?>
<div class="modal fade" id="modal">
    <div class="modal-dialog" style="border: 1px solid darkred; width: 80%;">
        <iframe id="result_modal" frameborder="0" style="height: 600px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>