<?php 
    if(isset($_POST['txt_date_start'])&&isset($_POST['txt_date_end'])){
        $v_date_start=$_POST['txt_date_start'];
        $v_date_end=$_POST['txt_date_end'];
        $condition="stsadj_date_record BETWEEN '$v_date_start' 
                    AND '$v_date_end' 
                    AND stsadj_status={$_SESSION['status']}";
    }
    else{
        $condition="DATE_FORMAT(stsadj_date_record,'%Y-%m')='".date('Y-m')."'
            AND stsadj_status={$_SESSION['status']}";
    }
    $sql="SELECT
            A.*,B.*,C.stpron_name_vn,C.stpron_name_kh,C.stpron_code,B.id AS child_id
            FROM tbl_st_stock_adjustment AS A 
            LEFT JOIN tbl_st_stock_adjustment_detail AS B ON A.stsadj_id=B.stsadj_id
            LEFT JOIN tbl_st_product_name AS C ON B.pro_id=C.stpron_id
        WHERE {$condition} GROUP BY B.id";
    // echo $sql;
    $get_data=$connect->query($sql);
 ?>
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
                <a target="_blank" href="print_adjust.php?p_date_start=<?= (@$_POST['txt_date_start'] ? $_POST['txt_date_start'] : date('Y-m-d')) ?>&p_date_end=<?= (@$_POST['txt_date_end'] ? $_POST['txt_date_end'] : date('Y-m-d')) ?>" id="sample_editable_1_new" class="btn yellow">
                    <i class="fa fa-print"></i> Print</a>
                     <a target="_blank" href="aj_export_excell.php?p_date_start=<?= (@$_POST['txt_date_start'] ? $_POST['txt_date_start'] : date('Y-m-d')) ?>&p_date_end=<?= (@$_POST['txt_date_end'] ? $_POST['txt_date_end'] : date('Y-m-d')) ?>" id="sample_editable_1_new" class="btn blue">
                <i class="fa fa-share"></i> Export</a>
                <a href="add_adjustment.php" id="sample_editable_1_new" class="btn green"><i class="fa fa-plus-circle"></i> Add Adjustment (<?= $_SESSION['title'] ?>)</a>
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
                    <th rowspan="2" style="vertical-align: middle;">N&deg;</th>
                    <th>ថ្ងៃខែ</th>
                    <th>Adjust Number</th>
                    <th>កូដ</th>
                    <th colspan="2">ឈ្មោះ/Tền</th>
                    <th>ចំនួន</th>
                    <th rowspan="2" style="min-width: 100px; vertical-align: middle;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                </tr>
                <tr>
                    <th>Ngày</th>
                    <th>Điều chỉnh số</th>
                    <th>Người Nhận</th>
                    <th>VN</th>
                    <th>KH</th>
                    <th>số Phiếu</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i = 0;
                    while ($row = mysqli_fetch_object($get_data)) {
                        echo '<tr>';
                            echo '<td>'.(++$i).'</td>';
                            echo '<td>'.$row->stsadj_date_record.'</td>';
                            echo '<td>'.$row->stsadj_code.'</td>';
                            echo '<td>'.$row->stpron_code.'</td>';
                            echo '<td>'.$row->stpron_name_vn.'</td>';
                            echo '<td>'.$row->stpron_name_kh.'</td>';
                            echo '<td>'.$row->qty_adjust.'</td>';
                            echo '<td class="text-center">';
                                echo '<a href="edit_adjustment.php?edit_id='.$row->stsadj_id.'" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-edit"></i></a> ';
                                echo '<a href="delete_adjust.php?del_detail_id='.$row->child_id .'&parent_id='.$row->stsadj_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';
                            echo '</td>';
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
    </div>