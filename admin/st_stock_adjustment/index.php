<?php 
    $menu_active =140;
    $left_active =0;
    $layout_title = "View Stock Adjustment";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 

    if(isset($_POST['txt_date_start'])&&isset($_POST['txt_date_end'])){
        $v_date_start=$_POST['txt_date_start'];
        $v_date_end=$_POST['txt_date_end'];
        $condition=" stsadj_date_record BETWEEN '$v_date_start' AND '$v_date_end' ";
    }
    else{
        $v_current_month=date('Y-m');
        $condition=" DATE_FORMAT(stsadj_date_record, '%Y-%m')='$v_current_month'";
    }
    $sql="SELECT 
            A.*,B.stpron_code,B.stpron_name_vn,B.stpron_name_kh
            FROM tbl_st_stock_adjustment AS A 
            LEFT JOIN tbl_st_product_name AS B ON A.stsadj_product_code=B.stpron_id
            WHERE {$condition}";

    $get_data=$connect->query($sql);
 ?>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-pencil"></i> Stock Adjustment</h2>
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
                    <a href="add.php" id="sample_editable_1_new" class="btn green"><i class="fa fa-plus-circle"></i> Add Stock Adjustment</a>
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
                        <th>Date Record</th>
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th class="text-center">Qty Adjust</th>
                        <th>Note</th>
                        <th>Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->stsadj_date_record.'</td>';
                                echo '<td>'.$row->stpron_code.'</td>';
                                echo '<td>'.$row->stpron_name_vn.' :: '.$row->stpron_name_kh.'</td>';
                                echo '<th class="text-center">'.number_format($row->stsadj_qty_adj,0).'</th>';
                                echo '<td>'.$row->stsadj_note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->stsadj_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                    echo '<a onclick="deleteRecord('.$row->stsadj_id.')" class="btn btn-xs btn-danger" title="Delete"><i class="fa fa-trash"></i></a> ';
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
