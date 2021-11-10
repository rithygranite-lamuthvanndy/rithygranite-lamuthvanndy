<?php 
    $menu_active =140;
    $left_active =0;
    $layout_title = "View Stock In";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
    $sql="SELECT
        A.*,B.supsi_name,SUM(C.in_qty*C.in_price) AS total_amo
        FROM tbl_st_stock_in AS A 
        LEFT JOIN tbl_sup_supplier_info AS B ON A.stsin_supp_id=B.supsi_id
        LEFT JOIN tbl_st_stock_in_detail AS C ON A.stsin_id=C.stsin_id
        WHERE 1=1 ";
    if(isset($_POST['txt_date_start'])&&isset($_POST['txt_date_end'])){
        $v_date_start=$_POST['txt_date_start'];
        $v_date_end=$_POST['txt_date_end'];
        $condition="AND stsin_date_in BETWEEN '$v_date_start' AND '$v_date_end' ";
    }
    else{
        $condition="AND MONTH(stsin_date_in)=MONTH(CURRENT_DATE()) ";
    }
    $sql.=$condition." GROUP BY A.stsin_id";
    // echo $sql;
    $get_data=$connect->query($sql);
 ?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-truck fa-flip-horizontal"></i> Stock In</h2>
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
                    <a href="add.php" id="sample_editable_1_new" class="btn green"><i class="fa fa-plus-circle"></i> Add Stock In</a>
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
                                echo '<td>'.$row->stsin_note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a onclick="showInfo('.$row->stsin_id.')" data-toggle="modal" href="#modal" class="btn btn-xs btn-info" title="detail"><i class=""> Detail </i></a> ';
                                    echo '<a href="edit.php?edit_id='.$row->stsin_id.'" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-edit"></i></a> ';
                                   echo '<a onclick="deleteRecord('.$row->stsin_id.')" class="btn btn-xs btn-danger" title="Delete"><i class="fa fa-trash"></i></a> ';

                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include_once '../layout/footer.php' ?>
<script type="text/javascript">
    function showInfo(e){
        document.getElementById('result_modal').src = 'more_info.php?parent='+e;
    }
</script>
<div class="modal fade" id="modal">
    <div class="modal-dialog" style="border: 1px solid darkred; width: 70%;">
        <iframe id="result_modal" frameborder="0" style="height: 600px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>