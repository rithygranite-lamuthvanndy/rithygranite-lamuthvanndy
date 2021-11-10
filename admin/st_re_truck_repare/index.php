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


 function belen_price($v_date_start,$v_date_end,$pro_name_id) {


    global $connect;
    // start stock_early
       $v_sql_eanly = "SELECT A.*,B.stca_name,B.stca_code,C.stun_name,B.stca_id,
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
                WHERE A.stpron_material_type='3' OR A.stpron_material_type='5' AND A.stpron_id='$pro_name_id' 
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
                )<>0

                ";
              //  echo $v_sql_eanly."<br>";
// echo $v_sql;
$get_data_early = $connect->query($v_sql_eanly);
      
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
            
     
     
  while ($row_a = mysqli_fetch_object($get_data_early)) {

// if (!in_array($row_a->stca_name, $v_cat_name_tmp)) {
//                         array_push($v_cat_name_tmp, $row_a->stca_name);
                        
//                     }
   
     // =========================== Start Calculation ====================
                    $v_begining_bal_qty = ($row_a->begining_bal_qty ?: 0);
                    $v_begining_bal_price =round(($row_a->begining_bal_price ?: 0), 2);

                     


                    
                    
         // echo $a_id."<br>";

                    $v_arr_in = explode("=", $row_a->current_in);
                    $v_current_in_qty = (@$v_arr_in[0] ?: 0);
                    $v_current_in_price = round((@$v_arr_in[1] ?: 0), 2);

                    $v_array = [
                        'begining_bal_price' => $v_begining_bal_price,
                        'begining_bal_qty' => $v_begining_bal_qty,
                        'current_in_price' => $v_current_in_price,
                        'current_in_qty' => $v_current_in_qty
                    ];

                    $result_cost = myCalCostAverage($v_array);

                    $v_last_qty = ($v_begining_bal_qty + $v_current_in_qty - @$row_a->current_out + @$row_a->current_adjust);
                    // =========================== End Calculation ====================
                     $v_total_price_beg += $v_begining_bal_price;
                    $v_total_qty_in += $v_current_in_qty;
                    $v_total_price_in += $v_current_in_price;
                    $v_total_price_out += $result_cost * $row_a->current_out;
                    $v_total_qty_out += $row_a->current_out;
                    $v_total_price_adjust += $result_cost * $row_a->current_adjust;
                    $v_total_qty_adjust += $row_a->current_adjust;
                    $v_total_price_bal += $v_last_qty * $result_cost;
                    $v_total_qty_bal += $v_last_qty;

                    $arr_child = [
                        $row_a->stca_id => $row_a->stca_id,
                        'price_beg' => $v_begining_bal_price,
                        'price_in' => $v_current_in_price,
                        'price_out' => $result_cost * $row_a->current_out,
                        'price_adjust' => $result_cost * $row_a->current_adjust,
                        'price_end' => $v_last_qty * $result_cost
                    ];
                    array_push($v_arr_summary, $arr_child);
                   
                }
 

               


     

       // end stock ealy
}

function numberToRomanRepresentation($number) {
    $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
    $returnValue = '';
    while ($number > 0) {
        foreach ($map as $roman => $int) {
            if($number >= $int) {
                $number -= $int;
                $returnValue .= $roman;
                break;
            }
        }
    }
    return $returnValue;
}

if (isset($_POST['btn_search'])) {
    $date1 = @$_POST['txt_month_start'];
    $date2 = @$_POST['txt_month_end'];
    $txt_truck_name_id=@$_POST['txt_truck_name'];
    $txt_location=@$_POST['txt_location'];
            if($txt_truck_name_id !="") {
                $truck_id_search=$txt_truck_name_id;
               
                $query_truck='WHERE tbl_group_truck.id='.$truck_id_search.' ';
                $date_query='AND A.stsout_date_out BETWEEN "'.$date1.'" AND  "'.$date2.'" ';
            }
            else {
                $query_truck='';
                $date_query='AND A.stsout_date_out BETWEEN "'.$date1.'" AND  "'.$date2.'" ';
            }

            if($txt_location !="") {
                $location_id_search=$txt_location;
                $query_location='AND B.locaton_id="'.$location_id_search.'" ';
            }
            else {
                $query_location="";
            }
    
}
else {
    $query_truck='';
     $date_query='';
     $date1=$date2=$txt_truck_name_id=$query_location="";
     $date1 = date('Y-m-01');
     $date2 = date('Y-m-t');
}

?>
<div class="portlet light bordered">
    <div class="row">
        
        <div class="col-xs-7">
            <form action="#" method="post">
                <div class="col-sm-3">
                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                        <input type="text" class="form-control" value="<?= @$_POST['txt_month_start'] ?>" name="txt_month_start" placeholder="Date From ..." required="" aufocomplete="off">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                        <input type="text" class="form-control" value="<?= @$_POST['txt_month_end'] ?>" name="txt_month_end" placeholder=" To Date ..." required="" aufocomplete="off">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <select name="txt_truck_name" class="form-control myselect2">
                            <option value="">Default</option>
                            <?php
                              $v_sql_op = "SELECT * FROM tbl_group_truck
                              ORDER BY order_number";
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
                                <?php echo $row_op->name; ?>
                            </option>

                            <?php
                              }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <select name="txt_location" class="form-control myselect2">
                            <option value="">Default</option>
                            <option <?php if(@$_POST['txt_location']=="0") {echo "selected='selected'";} ?> 
                            value="0">រោងចក្រ</option>
                            <option <?php if(@$_POST['txt_location']=="1") {echo "selected='selected'";} ?>
                             value="1">រណ្ដៅ</option>
                            <option 
                            <?php if(@$_POST['txt_location']=="2") {echo "selected='selected'";} ?>
                            value="2">រោងជាង</option>
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
                        <a target="_blank" href="print_truck_repare.php?txt_month_start=<?= (@$_POST['txt_month_start'] ? $_POST['txt_month_start'] : date('Y-m-d')) ?>&txt_month_end=<?= (@$_POST['txt_month_end'] ? $_POST['txt_month_end'] : date('Y-m-d')) ?>&txt_truck_name=<?php echo @$_POST['txt_truck_name'] ?>&txt_location=<?php echo @$_POST['txt_location'] ?>" id="sample_editable_1_new" class="btn yellow">
                <i class="fa fa-print"></i> Print</a>
            <a target="_blank" href="export_excell.php?txt_month_start=<?= (@$_POST['txt_month_start'] ? $_POST['txt_month_start'] : date('Y-m-d')) ?>&txt_month_end=<?= (@$_POST['txt_month_end'] ? $_POST['txt_month_end'] : date('Y-m-d')) ?>&txt_truck_name=<?php echo @$_POST['txt_truck_name'] ?>&txt_location=<?php echo @$_POST['txt_location'] ?>" id="sample_editable_1_new" class="btn blue">
                <i class="fa fa-share"></i> Export</a>

                    </div>
        </div>
         </form>
         <div class="row">
          <div class="col-xs-12">
              <h2 style="font-family: 'khmer';"><i class="fa fa-file"></i> របាយការណ៍សម្ភារៈប្រើប្រាស់ក្នុងការជួសជុល ប្រចាំខែ  
              </h2>
          </div>
      </div>
        <br>
     
       <div class="portlet light bordered">
    
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper" style="overflow-x: scroll;">
            <table class="table table-striped table-bordered  myTableNowrap">
                <thead>
                    <tr class="bg_color">
                        <th rowspan="2">ល.រ</th>
                        <th rowspan="2">បរិយាយ</th>
                        <th rowspan="2">លេខសម្គាល់</th>
                        <th rowspan="2">តម្លៃជាមធ្យម</th>
                        <th rowspan="2">ទីតាំង</th>
                        <th colspan="2">ចេញ / OUT</th>
                        <th rowspan="2">លេខ PO</th>
                        <th rowspan="2">ទីតាំងទិញ</th>
                        
                    </tr>
                    <tr class="bg_color">
                        <th rowspan="1">បរិមាណ</th>
                        <th rowspan="1">ទឹកប្រាក់</th>
                    </tr>
                    <tr class="bg_color">
                        <th>Nº</th>
                        <th>Description</th>
                        <th>ID</th>
                        <th>Price</th>
                        <th>Section</th>
                        <th>QTY</th>
                        <th>$</th>
                        <th>PO</th>
                        <th>MUA</th>
                      
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $loop_i=0;
                    $track_name="";
                    $truck_id=0;
                   
                    $v_sql_report = "SELECT * FROM tbl_group_truck
                    LEFT JOIN tbl_group_truck_items
                    ON tbl_group_truck_items.group_id=tbl_group_truck.id
                    INNER JOIN tbl_st_stock_out_detail
                    ON tbl_st_stock_out_detail.track_mac_id=tbl_group_truck_items.truck_machin_id

                    LEFT JOIN tbl_st_track_machine_list
                    ON tbl_group_truck_items.truck_machin_id=tbl_st_track_machine_list.id
                    $query_truck
                    GROUP BY tbl_group_truck.id ORDER BY order_number
                ";            
    $get_data =$connect->query($v_sql_report);
    $status_track=0;

    while ($rows = mysqli_fetch_object($get_data)) {
      $truck_id=$rows->id;
      $machin_id=$rows->truck_machin_id;
    ?>
                    
                          
                            <?php
                             if($track_name !=$rows->name) {
                                ++$status_track;
                                echo '<tr class="bg_col_tr">
                                <td  colspan="9" class="">'.numberToRomanRepresentation(++$loop_i).' '.$rows->name.'</td>
                                       </tr>';
                                $track_name=$rows->name;
                                
                                $is_truck=true;
                             }
                             else {
                                //$a_pro_id=$row->pro_id;
                                $is_truck =false;
                             }
                            //echo numberToRomanRepresentation(++$loop_i).' '.$rows->name;
                            ?>
                        
                <?php
                
                   $v_sql_detail = "SELECT 
                                    A.stsout_date_out,A.stsout_letter_no,B.out_qty,B.pro_id,C.stpron_name_vn,
                                    DATE_FORMAT(A.stsout_date_out,'%m/%Y') AS group_month,
                                    B.out_qty,
                        D.stun_name,B.stsout_id,B.locaton_id,C.stpron_code,A.stsout_note,
                        F.supsi_name,C.stpron_name_kh,A.stock_status,
                                    (
                                        SELECT 
                                        COUNT(*)
                                        FROM tbl_st_stock_out_detail AS AA 
                                        WHERE AA.track_mac_id=B.track_mac_id
                                        AND AA.stsout_id=A.stsout_id
                                    ) AS group_letter_no,
                                    (
                                        SELECT 
                                            COUNT(*)
                                        FROM tbl_st_stock_out_detail AS AA 
                                        LEFT JOIN tbl_st_stock_out AS BB ON AA.stsout_id=BB.stsout_id
                                        WHERE AA.track_mac_id=B.track_mac_id
                                        AND BB.stock_status=A.stock_status
                                        AND DATE_FORMAT(BB.stsout_date_out,'%Y-%m')=DATE_FORMAT(A.stsout_date_out,'%Y-%m')
                                    ) AS group_row_monthly
                                    FROM tbl_st_stock_out AS A 
                                    LEFT JOIN tbl_st_stock_out_detail AS B ON A.stsout_id=B.stsout_id
                                   
                                    LEFT JOIN tbl_st_product_name AS C ON B.pro_id=C.stpron_id
                                    LEFT JOIN tbl_st_unit_list AS D ON B.unit_id=D.stun_id
                                    LEFT JOIN tbl_st_stock_in AS E ON E.stsin_letter_no=A.stsout_letter_no
                                     LEFT JOIN tbl_sup_supplier_info AS F ON F.supsi_id=E.stsin_supp_id
                                   
                                    WHERE A.stock_status='3' OR A.stock_status='5'
                                    AND B.track_mac_id='$machin_id'

                                    $date_query $query_location
                                   
                                    GROUP BY  B.std_id,MONTH(A.stsout_date_out),YEAR(A.stsout_date_out)
                                    ORDER BY A.stsout_date_out";
                                   
                    $v_result = $connect->query($v_sql_detail);
                    $i = 0;
                    $v_total=0;
                    $total_by_cate=0;
                    while ($row = mysqli_fetch_object($v_result)) {
                        if($row->pro_id !="") { 
                        $v_unit_price = getCostPerProductName($row->stsout_date_out, $row->pro_id,$row->stock_status);
                        $v_total = ($v_unit_price * $row->out_qty);

                        if($track_name ==$rows->name) {
                            $total_by_cate +=$v_total;
                        }

                ?>
                    <tr>
                        <td><?php echo (++$i); ?></td>

                        <td>
                        <?php echo $rows->name_vn.' | '.$row->stpron_name_vn; ?>
                            
                        </td>
                        <td><?php echo $row->stpron_code; ?></td>
                        <td><?php echo $v_unit_price; ?></td>
                        <td>
                            <?php 
                              if($row->locaton_id==0) {
                                echo "រោងចក្រ";

                              }
                              else if($row->locaton_id==1) {
                                echo "រណ្ដៅ";
                              }
                              else if($row->locaton_id==2) {
                                echo "រោងជាង";
                              }
                              else {
                                echo "";
                              }
                           
                             ?>
                             
                         </td>
                         <td><?php echo $row->out_qty; ?></td>
                         <td><?php echo number_format($v_total,2); ?></td>
                         <td><?php echo $row->stsout_letter_no; ?></td>
                         <td><?php echo $row->supsi_name; ?></td>
                        
                    </tr>

                <?php
                     }
                   }
                ?>
                    <tr class="bg_col_tr">
                        <th colspan="2" style="text-align: center;font-size: 14px;">TOTAL <?php echo $rows->name; ?></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th><?php echo number_format($total_by_cate,2); ?></th>
                        <th></th>
                        <th></th>
                    </tr>
            <tr style="background:white;">
                        <td colspan="9"></td>
             </tr>
<?php
  }
?>
                                   
                </tbody>
                <tfoot>
                    
                </tfoot>
            </table>
<?php
 $txt_check_la_id=@$_POST['txt_location'];
 $txt_check_tr_id=@$_POST['txt_truck_name'];
   if( ($txt_check_tr_id !="" || empty($_POST['btn_search'])) && ($txt_check_la_id=="")){
 ?>  
<div style="margin-top:3%;margin-left:4%;">
            <label>***** TRUCK</label>
            <table style="width: 50%;" class="table table-striped table-bordered  myTableNowrap ">
                <thead>
                   
                    <tr class="bg_col_tr">
                        <th>Nº</th>
                        <th>Description</th>
                        <th>BEGINNING($)</th>
                        <th>IN/NHAP($)</th>
                        <th>OUT/XUAT($)</th>
                       
                    </tr>
                </thead>
                <tbody> 
                    <?php
if (isset($_POST['btn_search'])) {
    $date1 = @$_POST['txt_month_start'];
    $date2 = @$_POST['txt_month_end'];
    $v_date_start =$date1;
    $v_date_end =$date2;
    $condition = "A.stsin_date_in BETWEEN '$v_date_start' 
                    AND '$v_date_end' 
                    AND A.stock_status='3' OR A.stock_status='5' ";
} else {
    $v_date_start = date('Y-m-01');
    $v_date_end = date('Y-m-t');
    $condition = "DATE_FORMAT(A.stsin_date_in,'%Y-%m')='" . date('Y-m') . "'
            AND A.stock_status='3' OR A.stock_status='5' ";
}

if($query_truck !="") {
    $date_query_turck='AND stsout_date_out BETWEEN "'.$date1.'" AND  "'.$date2.'" ';
}
else {
     $date_query_turck='WHERE stsout_date_out BETWEEN "'.$date1.'" AND  "'.$date2.'" ';
}
        $truck_id=0;
                    $v_sql_truck = "SELECT *,tbl_group_truck.id as id_kemun FROM tbl_group_truck
                    LEFT JOIN tbl_group_truck_items
                    ON tbl_group_truck_items.group_id=tbl_group_truck.id
                    LEFT JOIN tbl_st_stock_out_detail
                    ON tbl_st_stock_out_detail.track_mac_id=tbl_group_truck_items.truck_machin_id
                    LEFT JOIN tbl_st_stock_out ON 
                    tbl_st_stock_out_detail.stsout_id=tbl_st_stock_out.stsout_id

                    LEFT JOIN tbl_st_track_machine_list
                    ON tbl_group_truck_items.truck_machin_id=tbl_st_track_machine_list.id
                    $query_truck $date_query_turck
  GROUP BY tbl_group_truck.id
                    ORDER BY order_number
                ";  
               // echo $v_sql_truck;
                       
    $get_data_truck =$connect->query($v_sql_truck);

   
    $i_truck=0;
    $track_name="";
    $amount_truck_be=0;
    $amount_truck_in=0;
    $amount_truck_out=0;
    $total_stock_in=0;
    $loop_belen=0;
    while ($rows = mysqli_fetch_object($get_data_truck)) {
      $truck_id=$rows->id;
      $machin_id=$rows->truck_machin_id;

      $v_sql_truck_cate= "SELECT 
                                    A.stsout_date_out,A.stsout_letter_no,B.out_qty,B.pro_id,C.stpron_name_vn,
                                    DATE_FORMAT(A.stsout_date_out,'%m/%Y') AS group_month,
                                    B.out_qty,
                        D.stun_name,B.stsout_id,B.locaton_id,C.stpron_code,A.stsout_note,
                        F.supsi_name,C.stpron_name_kh,C.stpron_id as pro_name_id,A.stock_status,
                        -- DISTINCT C.stpron_id),
                                    (
                                        SELECT 
                                        COUNT(*)
                                        FROM tbl_st_stock_out_detail AS AA 
                                        WHERE AA.track_mac_id=B.track_mac_id
                                        AND AA.stsout_id=A.stsout_id
                                    ) AS group_letter_no,
                                    (
                                        SELECT 
                                            COUNT(*)
                                        FROM tbl_st_stock_out_detail AS AA 
                                        LEFT JOIN tbl_st_stock_out AS BB ON AA.stsout_id=BB.stsout_id
                                        WHERE AA.track_mac_id=B.track_mac_id
                                        AND BB.stock_status=A.stock_status
                                        AND DATE_FORMAT(BB.stsout_date_out,'%Y-%m')=DATE_FORMAT(A.stsout_date_out,'%Y-%m')
                                    ) AS group_row_monthly
                                    FROM tbl_st_stock_out AS A 
                                    LEFT JOIN tbl_st_stock_out_detail AS B ON A.stsout_id=B.stsout_id
                                   
                                    LEFT JOIN tbl_st_product_name AS C ON B.pro_id=C.stpron_id
                                    LEFT JOIN tbl_st_unit_list AS D ON B.unit_id=D.stun_id
                                    LEFT JOIN tbl_st_stock_in AS E ON E.stsin_letter_no=A.stsout_letter_no
                                     LEFT JOIN tbl_sup_supplier_info AS F ON F.supsi_id=E.stsin_supp_id
                                   
                                   
                                    WHERE A.stock_status='3' OR A.stock_status='5'
                                    AND B.track_mac_id='$machin_id'

                                    $date_query 
                                   
                                    GROUP BY  B.std_id,MONTH(A.stsout_date_out),YEAR(A.stsout_date_out)
                                    ORDER BY A.stsout_date_out";

                                   
                    $v_result = $connect->query($v_sql_truck_cate);
                    $v_total=0;
                    $total_by_cate=0;
                    $pro_name_id=0;
                     $total_stock_in=0;
                    


                    while ($row = mysqli_fetch_object($v_result)) {
                        $pro_name_id=$row->pro_name_id;
                        if($row->pro_id !="") {

                        $v_unit_price = getCostPerProductName($row->stsout_date_out, $row->pro_id,$row->stock_status);
                        $v_total = ($v_unit_price * $row->out_qty);
                        $track_name=$rows->name;

                        if($track_name ==$rows->name) {
                            $total_by_cate +=$v_total;
                        }

                       

                       

                    ?>

                      <?php
                      // AND B.stsin_id='$machin_id'

                      //echo $row->pro_id."<br>";


       
            // IN stock
                      
      $v_sql_stock_in = "SELECT A.*,B.*,C.*,
           (B.in_qty*B.in_price_vn/A.stsin_exchange_rate)+(B.in_qty*B.in_price_dollar) AS total_in

                         FROM tbl_st_stock_in AS A
                            LEFT JOIN tbl_st_stock_in_detail AS B
                            ON A.stsin_id=B.stsin_id  
                            LEFT JOIN tbl_st_product_name AS C On B.pro_id=C.stpron_id  
                         WHERE    C.stpron_id='$pro_name_id'  
                         AND A.stsin_date_in BETWEEN '{$v_date_start}' AND '{$v_date_end}'
                          "; 
              //echo $v_sql_stock_in."<br>";          
      $get_data_in =$connect->query($v_sql_stock_in);
     
      $status_in=0;
      $in_id="";
     
       while ($row_in = mysqli_fetch_object($get_data_in)) {


        
          if($in_id !=$row_in->stpron_id) {

             ++$status_in;
             $in_id=$row_in->stpron_id;
             $total_stock_in +=$row_in->total_in;
             $is_in=true;
          }

          else {
             $is_in=false;
          }


       }
       // end in stock

       


                            ?>



                <?php } }




                 // start belen_price

                $v_sql_truck_belent = "SELECT *,tbl_group_truck.id as id_kemun FROM tbl_group_truck
                    LEFT JOIN tbl_group_truck_items
                    ON tbl_group_truck_items.group_id=tbl_group_truck.id
                    INNER JOIN tbl_st_stock_out_detail
                    ON tbl_st_stock_out_detail.track_mac_id=tbl_group_truck_items.truck_machin_id
                    LEFT JOIN tbl_st_track_machine_list
                    ON tbl_group_truck_items.truck_machin_id=tbl_st_track_machine_list.id
                    INNER JOIN tbl_st_product_name  
                    ON tbl_st_stock_out_detail.pro_id=tbl_st_product_name.stpron_id
                    $query_truck
                    -- GROUP BY truck_machin_id
                      ORDER BY order_number
                "; 
                //echo $v_sql_truck_belent; 
                       
    $get_truck_belen =$connect->query($v_sql_truck_belent);
    $pro_name_id=0;
    $a_pro_id_last="";
    $track_name_last="";
    $total_stock_early1=0;
    $total_stock_early2=0;
    $total_stock_early3=0;
    $total_stock_early4=0;
    $total_stock_early5=0;
    $i_kemn=0;
    $status_kemun=0;
    $status_kemun1=0;

     while ($row= mysqli_fetch_object($get_truck_belen)) {
        $p_name_id=$row->stpron_id;


        // start stock_early
       $v_sql_eanly = "SELECT A.*,B.stca_name,B.stca_code,C.stun_name,B.stca_id,
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
                WHERE A.stpron_material_type='3' OR A.stpron_material_type='5' AND A.stpron_id='$p_name_id' 
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
                )<>0

                ";
              // echo $v_sql_eanly."<br>";
// echo $v_sql;
$get_data_early = $connect->query($v_sql_eanly);
      
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
            
     
     
  while ($row_a = mysqli_fetch_object($get_data_early)) {

// if (!in_array($row_a->stca_name, $v_cat_name_tmp)) {
//                         array_push($v_cat_name_tmp, $row_a->stca_name);
                        
//                     }
   
     // =========================== Start Calculation ====================
                    $v_begining_bal_qty = ($row_a->begining_bal_qty ?: 0);
                    $v_begining_bal_price =round(($row_a->begining_bal_price ?: 0), 2);

                     


                    
                    
         // echo $a_id."<br>";

                    $v_arr_in = explode("=", $row_a->current_in);
                    $v_current_in_qty = (@$v_arr_in[0] ?: 0);
                    $v_current_in_price = round((@$v_arr_in[1] ?: 0), 2);

                    $v_array = [
                        'begining_bal_price' => $v_begining_bal_price,
                        'begining_bal_qty' => $v_begining_bal_qty,
                        'current_in_price' => $v_current_in_price,
                        'current_in_qty' => $v_current_in_qty
                    ];

                    $result_cost = myCalCostAverage($v_array);

                    $v_last_qty = ($v_begining_bal_qty + $v_current_in_qty - @$row_a->current_out + @$row_a->current_adjust);
                    // =========================== End Calculation ====================
                     $v_total_price_beg += $v_begining_bal_price;
                    $v_total_qty_in += $v_current_in_qty;
                    $v_total_price_in += $v_current_in_price;
                    $v_total_price_out += $result_cost * $row_a->current_out;
                    $v_total_qty_out += $row_a->current_out;
                    $v_total_price_adjust += $result_cost * $row_a->current_adjust;
                    $v_total_qty_adjust += $row_a->current_adjust;
                    $v_total_price_bal += $v_last_qty * $result_cost;
                    $v_total_qty_bal += $v_last_qty;

                    $arr_child = [
                        $row_a->stca_id => $row_a->stca_id,
                        'price_beg' => $v_begining_bal_price,
                        'price_in' => $v_current_in_price,
                        'price_out' => $result_cost * $row_a->current_out,
                        'price_adjust' => $result_cost * $row_a->current_adjust,
                        'price_end' => $v_last_qty * $result_cost
                    ];
                    array_push($v_arr_summary, $arr_child);
                   
                }
 

               


     

       // end stock ealy
               
                if($track_name_last=="XE SK / គ្រឿងចក្រអេស្កា") {
                   
                    
                    if($a_pro_id_last !=$row->stpron_id) {
                    
                        $total_stock_early1 +=$v_begining_bal_price;
                    }
                    else {
                        //$total_stock_early1 =$v_begining_bal_price;
                    }

                }

                else if($track_name_last=="XE BEN / គ្រឿងចក្រឡានបែន") {
                    if($a_pro_id_last !=$row->stpron_id) {


                        $total_stock_early2 +=$v_begining_bal_price;
                    }
                    else {
                        //$total_stock_early2 =$v_begining_bal_price;
                    }

                }

                 else if($track_name_last=="NHOM XE KHAC / ផ្សេងៗ") {
                    if($a_pro_id_last !=$row->stpron_id) {


                        $total_stock_early3 +=$v_begining_bal_price;
                    }
                    else {
                        //$total_stock_early3 =$v_begining_bal_price;
                    }

                }

                 else if($track_name_last=="XE SASER 15T / គ្រឿងចក្រសាសឺរ") {
                    if($a_pro_id_last !=$row->stpron_id) {

                        $total_stock_early4 +=$v_begining_bal_price;
                    }
                    else {
                        //$total_stock_early3 =$v_begining_bal_price;
                    }

                }

                 else if($track_name_last=="XUONG CO KHI / ​រោងជាង") {
                    if($a_pro_id_last !=$row->stpron_id) {

                        $total_stock_early5 +=$v_begining_bal_price;
                    }
                    else {
                        //$total_stock_early3 =$v_begining_bal_price;
                    }

                }

            
            
           $track_name_last=$row->name;
           $a_pro_id_last=$row->stpron_id;
            

           
     }
     $amount_truck_be =$v_begining_bal_price;

        // end start balen



                 ?>
                       
                    
                        <tr>
                        <td><?php echo (++$i_truck); ?></td>
                        <td>
                            <?php 
                                
                                echo $rows->name;
                            ?>
                                
                            </td>
                        <td>
                            <?php 
                            $name_check=$rows->name; 
                            if($name_check=="XE SK / គ្រឿងចក្រអេស្កា") {
                                    echo number_format($total_stock_early1,2);

                                }
                                else if($name_check=="XE BEN / គ្រឿងចក្រឡានបែន"){
                                    echo number_format($total_stock_early2,2);
                                }
                                else if($name_check=="NHOM XE KHAC / ផ្សេងៗ"){
                                    echo number_format($total_stock_early3,2);
                                }
                                else if($name_check=="XE SASER 15T / គ្រឿងចក្រសាសឺរ"){
                                    echo number_format($total_stock_early4,2);
                                }
                                else if($name_check=="XUONG CO KHI / ​រោងជាង"){
                                    echo number_format($total_stock_early5,2);
                                }
                                else {
                                   echo number_format(0,2);
                                }

                             ?>
                        </td>
                        <td>
                          
                            <?php 
                            echo number_format($total_stock_in,2); 
                            ?>
                                
                        </td>
                        <td><?php echo number_format($total_by_cate,2); ?></td>
                    </tr>
                    <?php 
                     $amount_truck_be =$total_stock_early1
                     +$total_stock_early2
                     +$total_stock_early3
                     +$total_stock_early4
                     +$total_stock_early5;
                     $amount_truck_in +=$total_stock_in;
                     $amount_truck_out +=$total_by_cate;
                } ?>
                       <tr class="bg_col_tr">
                        <th colspan="2" style="text-align: center;font-size: 14px;">TOTAL/CONG</th>
                        <th><?php echo number_format($amount_truck_be,2); ?></th>
                        <th><?php echo number_format($amount_truck_in,2); ?></th>
                        <th><?php echo number_format($amount_truck_out,2); ?></th>
                
                        
                        
                    </tr>
            <tr style="background:white;">
                        <td colspan="9"></td>
             </tr>
                    
                        
                </tbody>
                <tfoot>
                    
                </tfoot>
            </table>
        </div>
        <?php
          }
        ?>

 <?php
 $txt_check_la_id=@$_POST['txt_location'];
 $txt_check_tr_id=@$_POST['txt_truck_name'];
   if( ($txt_check_la_id !="" || empty($_POST['btn_search'])) && ($txt_check_tr_id=="")) {
    $total_stock_in_section1=0;
    $total_stock_in_section2=0;
    $total_stock_in_section3=0;
 ?>           
<div style="margin-top:3%;margin-left:4%;">
            <label>***** SECTION</label>
            <table style="width: 50%;" class="table table-striped table-bordered  myTableNowrap ">
                <thead>
                   
                    <tr class="bg_col_tr">
                        <th>Nº</th>
                        <th>Description</th>
                        <th>BEGINNING($)</th>
                        <th>IN/NHAP($)</th>
                        <th>OUT/XUAT($)</th>
                       
                    </tr>
                </thead>
                <tbody> 
                    <?php

if (isset($_POST['btn_search'])) {
    $date1 = @$_POST['txt_month_start'];
    $date2 = @$_POST['txt_month_end'];
    $v_date_start =$date1;
    $v_date_end =$date2;
    $condition = "A.stsin_date_in BETWEEN '$v_date_start' 
                    AND '$v_date_end' 
                    AND A.stock_status='3' OR A.stock_status='5' ";
    $txt_location_section=@$_POST['txt_location'];
     if($txt_location_section !="") {
                $location_section_search=$txt_location_section;
                $query_location_section='WHERE tbl_st_stock_out_detail.locaton_id="'.$location_section_search.'" ';
            }
            else {
                $query_location_section="";
            }



} else {
    $query_location_section="";
    $v_date_start = date('Y-m-01');
    $v_date_end = date('Y-m-t');
    $condition = "DATE_FORMAT(A.stsin_date_in,'%Y-%m')='" . date('Y-m') . "'
            AND A.stock_status='3' OR A.stock_status='5' ";
}
        $truck_id=0;
                    $v_sql_truck = "SELECT *,tbl_group_truck.id as id_kemun FROM tbl_group_truck
                    LEFT JOIN tbl_group_truck_items
                    ON tbl_group_truck_items.group_id=tbl_group_truck.id
                    INNER JOIN tbl_st_stock_out_detail
                    ON tbl_st_stock_out_detail.track_mac_id=tbl_group_truck_items.truck_machin_id
                    LEFT JOIN tbl_st_track_machine_list
                    ON tbl_group_truck_items.truck_machin_id=tbl_st_track_machine_list.id
                    $query_location_section
                    
                    GROUP BY tbl_st_stock_out_detail.locaton_id
                ";  

               // echo $v_sql_truck."<br>";
                       
    $get_data_truck =$connect->query($v_sql_truck);

   
    $i_truck=0;
    $track_name="";
    $amount_truck_be=0;
    
    $amount_truck_out=0;
    $total_stock_in=0;
    $loop_belen=0;
    while ($rows = mysqli_fetch_object($get_data_truck)) {
      $locaton_id_where=$rows->locaton_id;
      $machin_id=$rows->truck_machin_id;

      $v_sql_truck_cate= "SELECT 
                                    A.stsout_date_out,A.stsout_letter_no,B.out_qty,B.pro_id,C.stpron_name_vn,
                                    DATE_FORMAT(A.stsout_date_out,'%m/%Y') AS group_month,
                                    B.out_qty,
                        D.stun_name,B.stsout_id,B.locaton_id,C.stpron_code,A.stsout_note,
                        F.supsi_name,C.stpron_name_kh,C.stpron_id as pro_name_id,A.stock_status,
                        -- DISTINCT C.stpron_id),
                                    (
                                        SELECT 
                                        COUNT(*)
                                        FROM tbl_st_stock_out_detail AS AA 
                                        WHERE AA.track_mac_id=B.track_mac_id
                                        AND AA.stsout_id=A.stsout_id
                                    ) AS group_letter_no,
                                    (
                                        SELECT 
                                            COUNT(*)
                                        FROM tbl_st_stock_out_detail AS AA 
                                        LEFT JOIN tbl_st_stock_out AS BB ON AA.stsout_id=BB.stsout_id
                                        WHERE AA.track_mac_id=B.track_mac_id
                                        AND BB.stock_status=A.stock_status
                                        AND DATE_FORMAT(BB.stsout_date_out,'%Y-%m')=DATE_FORMAT(A.stsout_date_out,'%Y-%m')
                                    ) AS group_row_monthly
                                    FROM tbl_st_stock_out AS A 
                                    LEFT JOIN tbl_st_stock_out_detail AS B ON A.stsout_id=B.stsout_id
                                   
                                    LEFT JOIN tbl_st_product_name AS C ON B.pro_id=C.stpron_id
                                    LEFT JOIN tbl_st_unit_list AS D ON B.unit_id=D.stun_id
                                    LEFT JOIN tbl_st_stock_in AS E ON E.stsin_letter_no=A.stsout_letter_no
                                     LEFT JOIN tbl_sup_supplier_info AS F ON F.supsi_id=E.stsin_supp_id
                                   
                                   
                                    WHERE A.stock_status='3' OR A.stock_status='5'
                                    AND B.locaton_id='$locaton_id_where'

                                    $date_query 
                                   
                                    GROUP BY  B.std_id,MONTH(A.stsout_date_out),YEAR(A.stsout_date_out)
                                    ORDER BY A.stsout_date_out";

                                   
                    $v_result = $connect->query($v_sql_truck_cate);
                    $v_total_section=0;
                    $total_by_cate1=0;
                    $total_by_cate2=0;
                    $total_by_cate3=0;
                    $location_name_id=10;
                    $location_status=0;
                    $pro_name_id_section=0;
                    $total_by_cate_location=0;

                    
                    
                    


                    while ($row = mysqli_fetch_object($v_result)) {

       
                      //  echo $v_total_section.'kk'.$row->locaton_id."<br>";


                        if($row->pro_name_id !="") {
        $v_unit_price = getCostPerProductName($row->stsout_date_out, $row->pro_name_id,$row->stock_status);
                $v_total_section = ($v_unit_price * $row->out_qty);
            }
            else {
                $v_unit_price=0;
            }

               
              

                        if($row->locaton_id=="0") {
                
     // $v_unit_price = getCostPerProductName($row->stsout_date_out, $row->pro_name_id, 3);
     //            $v_total_section = ($v_unit_price * $row->out_qty);
                        
                                $total_by_cate1 +=$v_total_section;
                        } 
                         else if($row->locaton_id=="1") {
                             
    // $v_unit_price = getCostPerProductName($row->stsout_date_out, $row->pro_name_id, 3);
    //             $v_total_section = ($v_unit_price * $row->out_qty);
                                $total_by_cate2 +=$v_total_section;

                        }

                        else if($row->locaton_id=="2") {
                             if($pro_name_id_section !=$row->pro_name_id) {

    // $v_unit_price = getCostPerProductName($row->stsout_date_out, $row->pro_name_id, 3);
    //             $v_total_section = ($v_unit_price * $row->out_qty);
                                $total_by_cate3 +=$v_total_section;
                            }
                            else {
                                //$total_stock_early1 =$v_begining_bal_price;
                            }

                        }




    

                        $pro_name_id_section=$row->pro_name_id;
                          $total_by_cate_location +=$v_total_section;
                           

                       

                       

                    ?>

                      <?php
                      // AND B.stsin_id='$machin_id'

                      //echo $row->pro_id."<br>";


       
            // IN stock
                      
      $v_sql_stock_in = "SELECT A.*,B.*,C.*,D.*,
           SUM((B.in_qty*B.in_price_vn/A.stsin_exchange_rate)+(B.in_qty*B.in_price_dollar)) AS total_in_section

                         FROM tbl_st_stock_in AS A
                            LEFT JOIN tbl_st_stock_in_detail AS B
                            ON A.stsin_id=B.stsin_id  
                            LEFT JOIN tbl_st_product_name AS C On B.pro_id=C.stpron_id  
                            LEFT JOIN tbl_st_stock_out_detail AS D 
                            ON D.pro_id=C.stpron_id
                         WHERE {$condition}  AND   
                         D.locaton_id='$locaton_id_where'  
                 AND A.stsin_date_in BETWEEN '{$v_date_start}' AND '{$v_date_end}'

                         GROUP BY D.locaton_id "; 

                        // echo $v_sql_stock_in;

              //echo $v_sql_stock_in;          
      $get_data_in =$connect->query($v_sql_stock_in);
      
      $total_stock_in_section1=0;
      $total_stock_in_section2=0;
      $total_stock_in_section3=0;

      $total_in_query=0;
      $in_pro_id=0;
      
      //echo $i_truck;
     
        $amount_truck_in_section=0;

       while ($row_in = mysqli_fetch_object($get_data_in)) {
        

             if($row_in->locaton_id=="0") {
                if($in_pro_id !=$row_in->stpron_id) {
                    $total_stock_in_section1 +=$row_in->total_in_section;
                   
                }
                else {

                }
                
               
             }
             else if($row_in->locaton_id=="1") {
                 if($in_pro_id !=$row_in->stpron_id) {
                    $total_stock_in_section2 +=$row_in->total_in_section;
                }
                else {
                    
                }
                

             }
             else if($row_in->locaton_id=="2") {
                 if($in_pro_id !=$row_in->stpron_id) {
                    $total_stock_in_section3 +=$row_in->total_in_section;
                }
                else {
                    
                }
             }


         
             
             $in_pro_id=$row_in->stpron_id;

             
    

       }


       
       // end in stock

       
 
                    

                            ?>




                <?php 

            }
              

                 // start belen_price

                $v_sql_truck_belent = "SELECT *,tbl_st_stock_out_detail.locaton_id FROM tbl_group_truck
                    LEFT JOIN tbl_group_truck_items
                    ON tbl_group_truck_items.group_id=tbl_group_truck.id
                    INNER JOIN tbl_st_stock_out_detail
                    ON tbl_st_stock_out_detail.track_mac_id=tbl_group_truck_items.truck_machin_id
                    LEFT JOIN tbl_st_track_machine_list
                    ON tbl_group_truck_items.truck_machin_id=tbl_st_track_machine_list.id
                    INNER JOIN tbl_st_product_name  
                    ON tbl_st_stock_out_detail.pro_id=tbl_st_product_name.stpron_id
                    INNER JOIN tbl_st_stock_out 
                    ON tbl_st_stock_out_detail.stsout_id=tbl_st_stock_out_detail.stsout_id

                
                    $query_location_section
                     ORDER BY locaton_id
                "; 
                //echo $v_sql_truck_belent; 
                       
    $get_truck_belen =$connect->query($v_sql_truck_belent);
    $location_early_section=0;
    $location_early=0;
    $total_stock_early_section1=0;
    $total_stock_early_section2=0;
    $total_stock_early_section3=0;
    $total_stock_early_section4=0;
    $total_stock_early_section5=0;
    $i_kemn=0;
    $status_kemun=0;
    $status_kemun1=0;
    $a_pro_id_early_section="";


     while ($row= mysqli_fetch_object($get_truck_belen)) {
        $p_name_id_early_section=$row->stpron_id;

        


        // start stock_early
       $v_sql_eanly = "SELECT A.*,B.stca_name,B.stca_code,C.stun_name,B.stca_id,
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
                WHERE A.stpron_material_type='3' OR A.stpron_material_type='5' AND A.stpron_id='$p_name_id_early_section' 
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
                )<>0

                ";
              //  echo $v_sql_eanly."<br>";
// echo $v_sql;
$get_data_early = $connect->query($v_sql_eanly);
      
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
            
     
     
  while ($row_a_section = mysqli_fetch_object($get_data_early)) {

// if (!in_array($row_a_section->stca_name, $v_cat_name_tmp)) {
//                         array_push($v_cat_name_tmp, $row_a_section->stca_name);
                        
//                     }
   
     // =========================== Start Calculation ====================
                    $v_begining_bal_qty = ($row_a_section->begining_bal_qty ?: 0);
                    $v_begining_bal_price =round(($row_a_section->begining_bal_price ?: 0), 2);

                     


                    
                    
         // echo $a_id."<br>";

                    $v_arr_in = explode("=", $row_a_section->current_in);
                    $v_current_in_qty = (@$v_arr_in[0] ?: 0);
                    $v_current_in_price = round((@$v_arr_in[1] ?: 0), 2);

                    $v_array = [
                        'begining_bal_price' => $v_begining_bal_price,
                        'begining_bal_qty' => $v_begining_bal_qty,
                        'current_in_price' => $v_current_in_price,
                        'current_in_qty' => $v_current_in_qty
                    ];

                    $result_cost = myCalCostAverage($v_array);

                    $v_last_qty = ($v_begining_bal_qty + $v_current_in_qty - @$row_a_section->current_out + @$row_a_section->current_adjust);
                    // =========================== End Calculation ====================
                     $v_total_price_beg += $v_begining_bal_price;
                    $v_total_qty_in += $v_current_in_qty;
                    $v_total_price_in += $v_current_in_price;
                    $v_total_price_out += $result_cost * $row_a_section->current_out;
                    $v_total_qty_out += $row_a_section->current_out;
                    $v_total_price_adjust += $result_cost * $row_a_section->current_adjust;
                    $v_total_qty_adjust += $row_a_section->current_adjust;
                    $v_total_price_bal += $v_last_qty * $result_cost;
                    $v_total_qty_bal += $v_last_qty;

                    $arr_child = [
                        $row_a_section->stca_id => $row_a_section->stca_id,
                        'price_beg' => $v_begining_bal_price,
                        'price_in' => $v_current_in_price,
                        'price_out' => $result_cost * $row_a_section->current_out,
                        'price_adjust' => $result_cost * $row_a_section->current_adjust,
                        'price_end' => $v_last_qty * $result_cost
                    ];
                    array_push($v_arr_summary, $arr_child);
                   
                }
 

               


     

       // end stock ealy
           
           

                if($location_early=="0") {
                 
                   
                    if($a_pro_id_early_section !=$row->stpron_id) {

  
                        $total_stock_early_section1 +=$v_begining_bal_price;
                        //$is_be_section=true;

                    }
                    else {
                        //$is_be_section=false;
                        // $total_stock_early_section1 +=$v_begining_bal_price;
                    }

                }

                else if($location_early=="1") {
                    if($a_pro_id_early_section !=$row->stpron_id) {

                        $total_stock_early_section2 +=$v_begining_bal_price;
                    }
                    else {
                        //$total_stock_early2 =$v_begining_bal_price;
                    }

                }

                 else if($location_early=="2") {
                    if($a_pro_id_early_section !=$row->stpron_id) {

                        $total_stock_early_section3 +=$v_begining_bal_price;
                    }
                    else {
                        //$total_stock_early3 =$v_begining_bal_price;
                    }

                }

                 else if($location_early=="3") {
                    if($a_pro_id_early_section !=$row->stpron_id) {

                        $total_stock_early_section4 +=$v_begining_bal_price;
                    }
                    else {
                        //$total_stock_early3 =$v_begining_bal_price;
                    }

                }

                 else if($location_early=="4") {
                    if($a_pro_id_early_section !=$row->stpron_id) {

                        $total_stock_early_section5 +=$v_begining_bal_price;
                    }
                    else {
                        //$total_stock_early3 =$v_begining_bal_price;
                    }

                }

            $location_early=$row->locaton_id;
            $a_pro_id_early_section=$row->stpron_id;
            
          
           
            

           
     }

        // end start balen
 
                 ?>
                       
                    
                        <tr>
                        <td><?php echo (++$i_truck); ?></td>
                        <td>
                            <?php 
                            if($rows->locaton_id=="0") {
                                echo "រោងចក្រ";
                            }
                            else if($rows->locaton_id=="1"){
                                 echo "រណ្ដៅ";
                            }
                            else if($rows->locaton_id=="2"){
                                 echo "រោងជាង";
                            }
                                
                               
                            ?>
                                
                            </td>
                        <td>

                            <?php 
                              if($rows->locaton_id=="0") {
                                echo number_format($total_stock_early_section1,2);
echo '<input type="hidden" class="ealy_data" value=" '.$total_stock_early_section1.' " ';
                               }
                                elseif($rows->locaton_id=="1") {
                                echo number_format($total_stock_early_section2,2);
echo '<input type="hidden" class="ealy_data" value=" '.$total_stock_early_section2.' " ';
                               }
                                elseif($rows->locaton_id=="2") {
                                echo number_format($total_stock_early_section3,2);
echo '<input type="hidden" class="ealy_data" value=" '.$total_stock_early_section3.' " ';
                               }
                                elseif($rows->locaton_id=="3") {
                                echo number_format($total_stock_early_section4,2);
echo '<input type="hidden" class="ealy_data" value=" '.$total_stock_early_section4.' " ';
                               }
                                elseif($rows->locaton_id=="4") {
                                echo number_format($total_stock_early_section5,2);
echo '<input type="hidden" class="ealy_data" value=" '.$total_stock_early_section5.' " ';
                               }
                                else {
                                   echo number_format(0,2);
echo '<input type="hidden" class="ealy_data" value="0" ';
                                }

                             ?>
                        </td>
                        <td  >


                            

                          
                            <?php 
                           
                            if($rows->locaton_id=="0") {
                               

                                 echo number_format($total_stock_in_section1,2);

    echo '<input type="hidden" class="section_data" value=" '.$total_stock_in_section1.' " ';

                                 
                            }
                            else if($rows->locaton_id=="1"){
                                 echo number_format($total_stock_in_section2,2);
                                 $test=$total_stock_in_section2;
    echo '<input type="hidden" class="section_data" value=" '.$total_stock_in_section2.' " ';
                            }
                            else if($rows->locaton_id=="2"){
                                  echo number_format($total_stock_in_section3,2);
  echo '<input type="hidden" class="section_data" value=" '.$total_stock_in_section3.' " ';
                                 
                            }


                          

                            
                            ?>
                                
                        </td>
                        <td>
                            <?php 
                            if($rows->locaton_id=="0") {
                                 echo number_format($total_by_cate1,2); 
echo '<input type="hidden" class="location_td" value="'.$total_by_cate1.'"';
                            }
                            else if($rows->locaton_id=="1"){
                                 echo number_format($total_by_cate2,2); 
echo '<input type="hidden" class="location_td" value="'.$total_by_cate2.'"';
                            }
                            else if($rows->locaton_id=="2"){
                                  echo number_format($total_by_cate3,2); 
echo '<input type="hidden" class="location_td" value="'.$total_by_cate3.'"';
                            }
                                
                         
                             ?>
                            
                        </td>
                    </tr>

                    <?php 



                    

                     $location_early_section=
                     +$total_stock_early_section1
                     +$total_stock_early_section2
                     +$total_stock_early_section3
                     +$total_stock_early_section4;


                   
                    
                }

                  

                 ?>

                
                       <tr class="bg_col_tr">
                        <th colspan="2" style="text-align: center;font-size: 14px;">TOTAL/CONG</th>
                        <th id="ealy_data_th"><?php echo number_format($location_early_section,2); ?></th>
                        <th id="section_data_th">
                            <?php
                            echo number_format($amount_truck_in_section,2); 
                            ?>
                                
                            </th>
                        <th id="location_th"><?php echo number_format($total_by_cate_location,2); ?></th>

                        
                    </tr>
            <tr style="background:white;">
                        <td colspan="9"></td>
             </tr>
                    
                        
                </tbody>
                <tfoot>
                    
                </tfoot>
            </table>
            </div>
        <?php
          }
        ?>

        </div>
    </div>
</div>
 


 <style type="text/css">
     
     table th {
        text-align: center;
     }
      .bg_color {
      background: #b0d8f1!important;
    }
    .bg_col_span {
     background: #e0e7ea!important;
    }
    .bg_col_tr {
        background:#ddf1d8 !important;
    }
    .select2 {
        width: 100% !important;
    }
 </style>
 <?php include_once '../layout/footer.php' ?>

 <script type="text/javascript">
     $(document).ready(function() {
        var sum = 0;
$('.section_data').each(function(){
    sum += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
});
var stock_in_section=sum.toFixed(2);
$('#section_data_th').html(stock_in_section);


var sum_out = 0;
$('.location_td').each(function(){
    sum_out += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
});
var location_td_sum=sum_out.toFixed(2);
$('#location_th').html(location_td_sum);


var sum_bel = 0;
$('.ealy_data').each(function(){
    sum_bel += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
});
var sum_bel_td_sum=sum_bel.toFixed(2);
$('#ealy_data_th').html(sum_bel_td_sum);



       
      
    })


 </script>

    

    