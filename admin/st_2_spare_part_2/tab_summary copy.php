<?php
    include_once '../st_operation/operation.php';
?>
<?php
   if (isset($_POST['txt_date_start']) || isset($_POST['txt_date_end'])) {
    $v_date_start = $_POST['txt_date_start'];
    $v_date_end = $_POST['txt_date_end'];

        } else {
            $v_date_start = date('Y-m-01');
            $v_date_end = date('Y-m-t');
        }

    $v_sql = "SELECT A.*,B.stca_name,B.stca_code,C.stun_name,B.stca_id,E.stsout_date_out,H.stsin_letter_no,
    H.stsin_req_no,D.locaton_id,F.name_vn as machine_name,D.out_qty,C.stun_name,H.stsin_id,H.stsin_date_in,
     D.std_id,E.stsout_date_out,G.in_qty,
     (G.in_qty*G.in_price_vn/H.stsin_exchange_rate)+(G.in_qty*G.in_price_dollar) AS price_qty,I.stsup_name,
                (
                    (
                        SELECT IFNULL(SUM(in_qty),0)
                        FROM tbl_st_stock_in AS AA 
                        LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                        WHERE AA.stsin_date_in>'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )-
                    (
                        SELECT IFNULL(SUM(out_qty),0)
                        FROM tbl_st_stock_out AS AA 
                        LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
                        WHERE AA.stsout_date_out<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )+
                    (
                        SELECT IFNULL(SUM(qty_adjust),0)
                        FROM tbl_st_stock_adjustment AS AA 
                        LEFT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
                        WHERE  AA.stsadj_date_record <'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )
                ) AS begining_bal_qty,
                (
                    (
                        SELECT SUM(
                                    (IFNULL(in_qty,0)*in_price_vn/stsin_exchange_rate)
                                        +(in_price_dollar*IFNULL(in_qty,0))
                                    )
                        FROM tbl_st_stock_in AS AA 
                        LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                        WHERE AA.stsin_date_in>'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )
                ) AS begining_bal_price,
                (
                    SELECT CONCAT(
                                SUM(in_qty),
                                '=',
                                SUM((in_price_vn/stsin_exchange_rate)+in_price_dollar)*IFNULL(SUM(in_qty),0)
                            )
                    FROM tbl_st_stock_in AS AA 
                    LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                    WHERE  AA.stsin_date_in BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                ) current_in,
                (
                    SELECT SUM(out_qty) 
                    FROM tbl_st_stock_out AS AA 
                    LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
                    WHERE  AA.stsout_date_out BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                ) current_out,
                (
                    SELECT SUM(BB.qty_adjust) 
                    FROM tbl_st_stock_adjustment AS AA 
                    RIGHT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
                    WHERE  AA.stsadj_date_record BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                )current_adjust
                FROM tbl_st_product_name AS A 
                LEFT JOIN tbl_st_category_list AS B ON A.stpron_category=B.stca_id
                LEFT JOIN tbl_st_unit_list AS C ON A.stpron_unit=C.stun_id
                LEFT JOIN tbl_st_stock_out_detail AS D ON D.pro_id=A.stpron_id
                LEFT JOIN tbl_st_stock_out AS E ON E.stsout_id=D.stsout_id
                LEFT JOIN tbl_st_track_machine_list AS F ON F.id=D.track_mac_id
                LEFT JOIN tbl_st_stock_in_detail AS G ON G.pro_id=A.stpron_id
                LEFT JOIN tbl_st_stock_in AS H ON H.stsin_id=G.stsin_id
                INNER JOIN tbl_st_branch_list AS I ON I.stsup_id=D.locaton_id
               

                WHERE A.stpron_material_type='$_SESSION[status]' AND H.stsin_date_in BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                AND E.stsout_date_out BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                  GROUP BY G.std_id
                HAVING 

                (
                    (
                        SELECT IFNULL(SUM(in_qty),0)
                        FROM tbl_st_stock_in AS AA 
                        LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                        WHERE AA.stsin_date_in<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )-
                    (
                        SELECT IFNULL(SUM(out_qty),0)
                        FROM tbl_st_stock_out AS AA 
                        LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
                        WHERE AA.stsout_date_out<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id
                    )+
                    (
                        SELECT IFNULL(SUM(qty_adjust),0)
                        FROM tbl_st_stock_adjustment AS AA 
                        LEFT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
                        WHERE  AA.stsadj_date_record BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                        AND BB.pro_id=A.stpron_id
                    )
                )>0 OR 
                (
                    SELECT SUM(in_qty) 
                    FROM tbl_st_stock_in AS AA 
                    LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                    WHERE  AA.stsin_date_in BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                )>0 OR
                (
                    SELECT SUM(out_qty) 
                    FROM tbl_st_stock_out AS AA 
                    LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
                    WHERE  AA.stsout_date_out BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                )>0 
                OR 
                (
                    SELECT SUM(qty_adjust)
                    FROM tbl_st_stock_adjustment AS AA 
                    LEFT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
                    WHERE  AA.stsadj_date_record BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id
                )<>0  ORDER BY B.stca_code ASC,A.stpron_code ASC
                ";
//echo $v_sql;
$get_data = $connect->query($v_sql);
?>
<style type="text/css">
    .mycustomtable tbody,
    .mycustomtable thead,
    .mycustomtable tfoot {
        white-space: nowrap;
    }

    .myqty {
        font-weight: bold;
    }

    .myprice {
        font-weight: bold;
        color: #FF0000;
        background-color: #F2F2F2;
    }

    .myavg {
        color: #39EB7C;
    }

    .myavg:before,
    .myprice:before {
        content: '$ ';
        padding-right: 5px;
    }
</style>
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
                <a target="_blank" href="print_in.php?p_date_start=<?= (@$_POST['txt_date_start'] ? $_POST['txt_date_start'] : date('Y-m-d')) ?>&p_date_end=<?= (@$_POST['txt_date_end'] ? $_POST['txt_date_end'] : date('Y-m-d')) ?>" id="sample_editable_1_new" class="btn yellow">
                    <i class="fa fa-print"></i> Print</a>
                     <a target="_blank" href="in_export_excell.php?p_date_start=<?= (@$_POST['txt_date_start'] ? $_POST['txt_date_start'] : date('Y-m-d')) ?>&p_date_end=<?= (@$_POST['txt_date_end'] ? $_POST['txt_date_end'] : date('Y-m-d')) ?>" id="sample_editable_1_new" class="btn blue">
                <i class="fa fa-share"></i> Export</a>
                <a href="add_in.php" id="sample_editable_1_new" class="btn green"><i class="fa fa-plus-circle"></i> Add Stock In</a>
            </div>
        </div>
    </form>
</div>
<br>
<div class="portlet-body">
    <div style="overflow-x:auto;">
        <table class="table table-striped table-bordered table-hover dataTable dtr-inline mycustomtable">
            <thead>
                <tr role="row" class="text-center">
                    <th rowspan="2">ល.រ</th>
                    <th class="text-center">ថ្ងៃខែ</th>
                    <th class="text-center">លេខសំណើរ</th>
                    <th class="text-center">លេខប័ណ្ណ</th>
                    <th class="text-center">កូដ</th>
                    <th class="text-center">តំបន់</th>
                    <th class="text-center">គ្រឿងចក្រឬម៉ាស៊ីន</th>
                    <th class="text-center" colspan="2">ឈ្មោះ</th>
                    <th class="text-center">ចំនួន</th>
                    <th class="text-center">ឯកតា</th>
                    <th class="text-center" colspan="2">តម្លៃ</th>
                    <th class="text-center">សរុប</th>
                    <th class="text-center">Action</th>
                </tr>
                <tr>
                    <th>Ngày</th>
                    <th>Số Đề Nghị</th>
                    <th>số Phiếu</th>
                    <th>Mã</th>
                    <th>Khu vực</th>
                    <th>cơ giới và máy</th>
                    <th>VN</th>
                    <th>KH</th>
                    <th>số lượng</th>
                    <th>Đơn vị</th>
                    <th>NHẬP</th>
                    <th>$</th>
                    <th>Tổng công</th>
                    <th></th>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="float:rigth; background-color: gray; color:white;">Total</td>
                    <td id="total" style="background-color:gray; color:white;"></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <?php
                   $i = 0;
                $v_cat_name_tmp = [];

                $v_total_price_beg = 0;
                $v_total_price_in = 0;
                $v_total_qty_in = 0;
                $v_total_price_out = 0;
                $v_total_qty_out = 0;
                $v_total_price_adjust = 0;
                $v_total_qty_adjust = 0;
                $v_total_price_bal = 0;
                $v_total_qty_bal = 0;
                $v_arr_summary = [];
                $total_prce=0;
                   while ($row = mysqli_fetch_object($get_data)) {
                    if (!in_array($row->stca_name, $v_cat_name_tmp)) {
                        array_push($v_cat_name_tmp, $row->stca_name);
                        echo '<tr class="bg-blue">';
                        echo '<td colspan="15">' . $row->stca_code . ' - ' . $row->stca_name . '</td>';
                        echo '</tr>';
                    }

                    $total_prce +=$row->price_qty;

                     // =========================== Start Calculation ====================
                    $v_begining_bal_qty = ($row->begining_bal_qty ?: 0);
                    $v_begining_bal_price = round(($row->begining_bal_price ?: 0), 2);

                    $v_arr_in = explode("=", $row->current_in);
                    $v_current_in_qty = (@$v_arr_in[0] ?: 0);
                    $v_current_in_price = round((@$v_arr_in[1] ?: 0), 2);
                   

                    $v_array = [
                        'begining_bal_price' => $v_begining_bal_price,
                        'begining_bal_qty' => $v_begining_bal_qty,
                        'current_in_price' => $v_current_in_price,
                        'current_in_qty' => $v_current_in_qty
                    ];

                    $result_cost = myCalCostAverage($v_array);

                    $v_last_qty = ($v_begining_bal_qty + $v_current_in_qty - @$row->current_out + @$row->current_adjust);
                    // =========================== End Calculation ====================
                    
                        ?>
                            <tr>
                                <!-- ល.រ -->
                                <td><?=(++$i);?></td>
                                <!-- date -->
                                <td><?php echo $row->stsin_date_in; ?></td>
                                <!-- លេខសំណើរ -->
                                <td><?php echo $row->stsin_letter_no; ?></td>
                                <!-- លេខប័ណ្ឌ -->
                                <td><?php echo $row->stsin_req_no; ?></td>
                                <!-- code -->
                                <td><?php echo $row->stpron_code; ?></td>
                                <!-- location -->
                                <td>
                                    <?php 
                                       echo $row->stsup_name;
                                
                               
                            ?>
                                </td>
                                <!-- machine -->
                                <td><?php echo $row->machine_name; ?></td>
                                <!-- name vn -->
                                <td><?php echo $row->stpron_name_vn; ?></td>
                                <!-- name kh -->
                                <td><?php echo $row->stpron_name_kh; ?></td>
                                <!-- qty -->
                                <td><?php echo $row->in_qty; ?></td>
                                <!-- total -->
                               
                                <!-- unit -->
                                <td><?php echo $row->stun_name; ?></td>
                                <!-- price_vn -->
                                <td><?php echo ($row->price_qty/$row->in_qty ?: 0); ?></td>
                                <!-- price_$ -->
                                <td><?php echo number_format($row->price_qty, 2); ?></td>
                                <!-- amount -->
                                <td></td>
                                <td class="text-center">
                                    <a href="edit_in.php?edit_id=<?=$row->stsin_id;?>" class="btn btn-xs btn-warning" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a> 
                                    <?php
                                        echo'<a href="delete_in.php?del_id='.$row->stsin_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete">
                                        <i class="fa fa-trash"></i>
                                        </a>'
                                    ?>
                
                                </td>
                            </tr>
                        <?php

                         $v_total_price_beg += $v_begining_bal_price;
                    $v_total_qty_in += $v_current_in_qty;
                    $v_total_price_in += $v_current_in_price;
                    $v_total_price_out += $result_cost * $row->current_out;
                    $v_total_qty_out += $row->current_out;
                    $v_total_price_adjust += $result_cost * $row->current_adjust;
                    $v_total_qty_adjust += $row->current_adjust;
                    $v_total_price_bal += $v_last_qty * $result_cost;
                    $v_total_qty_bal += $v_last_qty;

                    $arr_child = [
                        $row->stca_id => $row->stca_id,
                        'price_beg' => $v_begining_bal_price,
                        'price_in' => $v_current_in_price,
                        'price_out' => $result_cost * $row->current_out,
                        'price_adjust' => $result_cost * $row->current_adjust,
                        'price_end' => $v_last_qty * $result_cost
                    ];
                    array_push($v_arr_summary, $arr_child);
                    }    
                ?>
                <input type="hidden" id="tt" name="total" value="<?php echo number_format($total_prce,2); ?>">
            </tbody>
        </table>  
    </div>
</div>
<script>
    $(document).ready(function()
    {
        var t = $('#total');
        var t1 = $('#tt').val();
        t.text(t1);
    });
</script>

