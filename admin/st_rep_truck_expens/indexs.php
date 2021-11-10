<?php
$menu_active = 140;
$left_active = 0;
$layout_title = "Report Truck";
include_once '../../config/database.php';
include_once '../../config/athonication.php';
include_once '../layout/header.php';
include_once '../st_operation/operation.php';
include_once 'function.php';
?>

<?php
 
 function myCalCostAverage_Report($arg_arr,$tr_id,$cu_out,$month)
    {
       
        $result = 0;
        $result = ($arg_arr['begining_bal_price'] + $arg_arr['current_in_price']) /
        MAX(($arg_arr['begining_bal_qty'] + $arg_arr['current_in_qty']), 1);
         $result=$result * $cu_out;
         echo '<input type="text" class="section_data'.$tr_id.''.$month.'" value=" '.$result.' " ';
   
        return round($result, 2);
    }


if (isset($_POST['btn_search'])) {
    $v_date_start = @$_POST['txt_month_start'];
    $v_date_end = @$_POST['txt_month_end'];
    $txt_truck_name_id=@$_POST['txt_truck_name'];
            if($txt_truck_name_id !="") {
                $truck_id_search=$txt_truck_name_id;
                $query_truck='WHERE E.id='.$truck_id_search.' ';
                $date_query='AND E.stsout_date_out BETWEEN "'.$v_date_start.'" AND  "'.$v_date_end.'" ';
            }
            else {
                $query_truck='';
                $date_query='AND E.stsout_date_out BETWEEN "'.$v_date_start.'" AND  "'.$v_date_end.'" ';
            }
    
}
else {
    $query_truck='';
    
     $txt_truck_name_id="";
     $date1 = date('Y-m-01');
     $date2 = date('Y-m-t');
     $date_query='AND E.stsout_date_out BETWEEN "'.$v_date_start.'" AND  "'.$v_date_end.'" ';
}

?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12"> 
        </div>
         <div class="col-xs-7">
            <form action="#" method="post">
                <div class="col-sm-4">
                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                        <input type="text" class="form-control" value="<?= @$_POST['txt_month_start'] ?>" name="txt_month_start" placeholder="Date From ..." required="" aufocomplete="off">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                        <input type="text" class="form-control" value="<?= @$_POST['txt_month_end'] ?>" name="txt_month_end" placeholder=" To Date ..." required="" aufocomplete="off">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <select name="txt_truck_name" class="form-control myselect2">
                            <option value="">Default</option>
                            <?php
                              $v_sql_op = "SELECT * FROM tbl_st_track_machine_list";
                              $get_op =$connect->query($v_sql_op);
                         while ($row_op = mysqli_fetch_object($get_op)) {
                            ?>
                            <option 
                            <?php
                             if($txt_truck_name_id==$row_op->id) {
                                echo "selected='selected'";
                             }
                            ?>
                             value="<?php echo $row_op->id; ?>">
                                <?php echo $row_op->name_vn; ?>
                            </option>

                            <?php
                              }
                            ?>
                        </select>
                    </div>
                </div>
                <br>
                <br>
           
        </div>
        <div class="col-xs-5">
             <div class="caption font-dark" style="display: inline-block;">
                        <button type="submit" name="btn_search" id="sample_editable_1_new" class="btn blue btn-md"> Search
                            <i class="fa fa-search"></i>
                        </button>

                        <a class="btn btn-md btn-danger" href="index.php" role="button"><i class="fa fa-undo"></i> Clear</a>
                        <a target="_blank" href="print_truck.php?p_date_start=<?= (@$_POST['txt_month_start'] ? $_POST['txt_month_start'] : date('Y-m-d')) ?>&p_date_end=<?= (@$_POST['txt_month_end'] ? $_POST['txt_month_end'] : date('Y-m-d')) ?>&id=<?php echo @$_POST['txt_truck_name'] ?>" id="sample_editable_1_new" class="btn yellow">
                <i class="fa fa-print"></i> Print</a>
            <a target="_blank" href="export_excell.php?p_date_start=<?= (@$_POST['txt_month_start'] ? $_POST['txt_month_start'] : date('Y-m-d')) ?>&p_date_end=<?= (@$_POST['txt_month_end'] ? $_POST['txt_month_end'] : date('Y-m-d')) ?>&id=<?php echo @$_POST['txt_truck_name'] ?>" id="sample_editable_1_new" class="btn blue">
                <i class="fa fa-share"></i> Export</a>

                    </div>
        </div>
        <br>
        <h2 style="font-family: 'khmer'; float: left;"><i class="fa fa-file"></i>
            របាយការណ៍ជួសជុលគ្រឿងចក្រ 2019 / Báo Cáo Sửa Chữa Cơ Giới
        </h2>

        <div class="portlet-body">
            <div id="sample_1_wrapper" class="dataTables_wrapper" style="overflow-x: scroll;">
                <table class="table table-striped table-bordered table-hover dataTable dtr-inline myTableNowrap" role="grid" aria-describedby="sample_1_info">
                    <tr style="background-color: #35baf6;">
                        <th>No</th>
                        <th>Ngày Mua</th>
                        <th colspan="2">Tên</th>
                        <th>Giá</th>
                        <th>%</th>
                        <th>Chức năng</th>
                        <th>Tổng cộng sửa chữa</th>
                        <th>Tổng cộng sửa chữa2018</th>
                        <th>Tổng cộng sửa chữa2019</th>
                        <th>tháng 1</th>
                        <th>tháng 2</th>
                        <th>tháng 3</th>
                        <th>tháng 4</th>
                        <th>tháng 5</th>
                        <th>tháng 6</th>
                        <th>tháng 7</th>
                        <th>tháng 8</th>
                        <th>tháng 9</th>
                        <th>tháng 10</th>
                        <th>tháng 11</th>
                        <th>tháng 12</th>
                    </tr>
                    <tr style="background-color: #ffe0b2;">
                        <th rowspan="2">ល.រ</th>
                        <th rowspan="2">កាលបរិច្ឆេទទិញ</th>
                        <th colspan="2">ឈ្មោះគ្រឿងចក្រ</th>
                        <!-- <th></th> -->
                        <th rowspan="2">តម្លៃគ្រឿងចក្រ</th>
                        <th rowspan="2">%</th>
                        <th rowspan="2">មុខងារនិងប្រចាំការ</th>
                        <th rowspan="2">សរុបការជុសជួលទាំងអស់</th>
                        <th rowspan="2">សរុបការជុសជួលទាំងអស់ ២០១៨</th>
                        <th rowspan="2">សរុបការជុសជួលទាំងអស់ ២០១៩</th>
                        <th colspan="12">ទឹកប្រាក់ជួសជុលតាមខែ</th>
                      
                    </tr>
                    <tr style="background-color: #ffe0b2;">
                       
                        <th>ខ្មែរ</th>
                        <th>វៀតណាម</th>
                        
                        <th>Jan 1</th>
                        <th>Feb 2</th>
                        <th>Mar 3</th>
                        <th>Apr 4</th>
                        <th>May 5</th>
                        <th>Jun 6</th>
                        <th>Jul 7</th>
                        <th>Aug 8</th>
                        <th>Sep 9</th>
                        <th>Oct 10</th>
                        <th>Nov 11</th>
                        <th>Dec 12</th>
                    </tr>
                    <?php
    $v_sql_report = "SELECT A.*,B.stca_name,B.stca_code,C.stun_name,B.stca_id,F.name_kh,F.name_vn,F.date_buy,F.track_price,F.note,F.id,E.stsout_date_out,F.id as tr_id,
    YEAR(E.stsout_date_out) AS sy, MONTH(E.stsout_date_out) AS sm,
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
                        WHERE AA.stsin_date_in<'{$v_date_start}'
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
                    LEFT JOIN tbl_st_track_machine_list AS CC ON CC.id=BB.track_mac_id
                    WHERE  AA.stsout_date_out BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id AND F.id=BB.track_mac_id
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
                WHERE A.stpron_material_type='3' AND E.stock_status='3' 
                $date_query 
                
                HAVING 

                (
                    (
                        SELECT IFNULL(SUM(in_qty),0)
                        FROM tbl_st_stock_in AS AA 
                        LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                        WHERE AA.stsin_date_in<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id ORDER BY F.id
                    )-
                    (
                        SELECT IFNULL(SUM(out_qty),0)
                        FROM tbl_st_stock_out AS AA 
                        LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
                        WHERE AA.stsout_date_out<'{$v_date_start}'
                        AND BB.pro_id=A.stpron_id ORDER BY F.id
                    )+
                    (
                        SELECT IFNULL(SUM(qty_adjust),0)
                        FROM tbl_st_stock_adjustment AS AA 
                        LEFT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
                        WHERE  AA.stsadj_date_record BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                        AND BB.pro_id=A.stpron_id ORDER BY F.id
                    )
                )>0 OR 
                (
                    SELECT SUM(in_qty) 
                    FROM tbl_st_stock_in AS AA 
                    LEFT JOIN tbl_st_stock_in_detail AS BB ON AA.stsin_id=BB.stsin_id
                    WHERE  AA.stsin_date_in BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id ORDER BY F.id
                )>0 OR
                (
                    SELECT SUM(out_qty) 
                    FROM tbl_st_stock_out AS AA 
                    LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
                    WHERE  AA.stsout_date_out BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id ORDER BY F.id
                )>0 
                OR 
                (
                    SELECT SUM(qty_adjust)
                    FROM tbl_st_stock_adjustment AS AA 
                    LEFT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
                    WHERE  AA.stsadj_date_record BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                    AND BB.pro_id=A.stpron_id ORDER BY F.id
                )<>0 
                     ";  

           //echo $v_sql_report;     
    $get_data =$connect->query($v_sql_report);
    $i=0;
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
                $total_cost=0;
               
        
    while ($row = mysqli_fetch_object($get_data)) {

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

                    $result_cost = myCalCostAverage_Report($v_array,$row->tr_id,$row->current_out,12);

                    $v_last_qty = ($v_begining_bal_qty + $v_current_in_qty - @$row->current_out + @$row->current_adjust);
                    // =========================== End Calculation ====================

                    ?>

                    <?php
                   
                if (!in_array($row->tr_id, $v_cat_name_tmp)) {
                      array_push($v_cat_name_tmp, $row->tr_id);
                    ?>

                   

                    <tr>
                        <td><?php echo (++$i); ?></td>
                        <td><?php echo $row->date_buy; ?></td>
                        <td><?php echo $row->name_kh; ?></td>
                        <td><?php echo $row->name_vn; ?></td>
                        <td><?php echo $row->track_price; ?></td>
                        <td></td>
                        <td><?php echo $row->note; ?></td>
                    
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
                        <td></td>
                        <td></td>
                        <td id="out_td<?php echo $row->tr_id; ?>12">
                            <?php  echo number_format($result_cost,2); ?>
                            
                        </td>
                    </tr>
                     <script type="text/javascript">
                        $(document).ready(function() {
                        var sum_out = 0;
                        $(".section_data<?php echo $row->tr_id; ?>12").each(function(){
                            sum_out += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var total_cost_out=sum_out.toFixed(2);
                        $('#out_td<?php echo $row->tr_id; ?>12').html(total_cost_out);

                         })
                   </script>
                <?php  } ?>
    <?php
    $tr_id=$row->id;
    
        }
    ?>

                    <tr>
                        <td colspan="7">Tổng cộng sửa chữa / សរុបការជួសជុល:</td>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                        <td>5</td>
                        <td>6</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="7">Tổng cộng Mở mặt mỏ đá Suy nghĩ m2 / សរុបលទ្ធផលបើមុខនៅរណ្ដៅគិតជា m2:</td>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                        <td>5</td>
                        <td>6</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

    <style type="text/css">
        
        .tr_report  {
            background: #F2F2DB !important;
        }
        th {
            text-align: center;
        }
        .myselect2 {
            width: 100% !important;
        }
    </style>
    <?php include_once '../layout/footer.php' ?>
    

    