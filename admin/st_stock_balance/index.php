<?php 
    $menu_active =140;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
    if(@$_POST['txt_date_start']&&@$_POST['txt_date_end']){
        $v_date_start=$_POST['txt_date_start'];
        $v_date_end=$_POST['txt_date_end'];

        $con_date="BETWEEN '$v_date_start' AND '$v_date_end'";
        $condition_in="AAA.stsin_date_in ".$con_date;
        $condition_out="BBB.stsout_date_out ".$con_date;
        $condition_adj="CC.stsadj_date_record ".$con_date;
    }
    else{
        $now=date('Y-m-d');
        $condition_in="AAA.stsin_date_in <='$now' ";
        $condition_out="BBB.stsout_date_out <='$now' ";
        $condition_adj="CC.stsadj_date_record <='$now' ";
    }
    $sql="SELECT 
            A.stpron_code,A.stpron_name_vn,A.stpron_name_kh,
            (
                SELECT SUM(AA.in_qty)
                FROM tbl_st_stock_in_detail AS AA 
                LEFT JOIN tbl_st_stock_in AS AAA ON AA.stsin_id=AAA.stsin_id
                WHERE AA.pro_id=A.stpron_id AND {$condition_in}
            ) AS bal_in,
            (
                SELECT SUM(BB.out_qty)
                FROM tbl_st_stock_out_detail AS BB 
                LEFT JOIN tbl_st_stock_out AS BBB ON BB.stsout_id=BBB.stsout_id
                WHERE BB.pro_id=A.stpron_id AND {$condition_out}
            ) AS bal_out,
            (
                SELECT SUM(CC.stsadj_qty_adj)
                FROM tbl_st_stock_adjustment AS CC 
                WHERE CC.stsadj_product_code=A.stpron_id AND {$condition_adj}
            ) AS bal_adjust,
            B.sttyp_name,C.name AS pro_type_name
        FROM tbl_st_product_name AS A 
        LEFT JOIN tbl_st_material_type_list AS B ON A.stpron_material_type=B.sttyp_id
        LEFT JOIN tbl_st_product_type_list AS C ON A.stpron_pro_type=C.id
        WHERE 
            A.stpron_id IN
                (SELECT A1.pro_id  FROM tbl_st_stock_in_detail AS A1)
            OR 
            A.stpron_id IN 
                (SELECT A2.pro_id FROM tbl_st_stock_out_detail AS A2)
            OR 
            A.stpron_id IN 
                (SELECT A3.stsadj_product_code FROM tbl_st_stock_adjustment AS A3)
        GROUP BY A.stpron_id
        ";
    // echo $sql;
    $get_data=$connect->query($sql);
 ?>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Stock Balance</h2>
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
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th class="text-center">QTY In</th>
                        <th class="text-center">QTY Out</th>
                        <th class="text-center">Adjustment</th>
                        <th class="text-center">Balance</th>
                        <th>Material Type</th>
                        <th>Product Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            $bal=($row->bal_in-$row->bal_out+$row->bal_adjust);
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->stpron_code.'</td>';
                                echo '<td>'.$row->stpron_name_vn.' :: '.$row->stpron_name_kh.'</td>';
                                echo '<td class="bold">'.($row->bal_in?:0).'</td>';
                                echo '<td class="bold">'.($row->bal_out?:0).'</td>';
                                echo '<td class="bold">'.($row->bal_adjust?:0).'</td>';
                                echo '<td  class="bold text-warning">'.$bal.'</td>';
                                echo '<td>'.$row->sttyp_name.'</td>';
                                echo '<td>'.$row->pro_type_name.'</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>






<?php include_once '../layout/footer.php' ?>
