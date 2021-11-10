<?php
$menu_active = 140;
$left_active = 0;
$layout_title = "Report Truck";
include_once '../../config/database.php';
include_once '../../config/athonication.php';
include_once '../layout/header.php';
include_once 'operation.php';
include_once 'function.php';
?>
<?php
if (isset($_POST['btn_search'])) {
    $date1 = @$_POST['txt_month_start'];
    $date2 = @$_POST['txt_month_end'];
    $txt_truck_name_id=@$_POST['txt_truck_name'];
            if($txt_truck_name_id !="") {
                $truck_id_search=$txt_truck_name_id;
                $query_truck='WHERE A.id='.$truck_id_search.' ';
                $date_query='AND A.stsout_date_out BETWEEN "'.$date1.'" AND  "'.$date2.'" ';
            }
            else {
                $query_truck='';
                $date_query='AND A.stsout_date_out BETWEEN "'.$date1.'" AND  "'.$date2.'" ';
            }
    
}
else {
    $query_truck='';
     $date_query='';
     $date1=$date2=$txt_truck_name_id="";
}

?>
<div class="portlet light bordered">
    <div class="row">
        
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
         </form>
         <div class="row">
          <div class="col-xs-12">
              <h2 style="font-family: 'khmer';"><i class="fa fa-file"></i> តារាងតាមដានការជួសជុលគ្រឿងចក្រ 
              </h2>
          </div>
      </div>
        <br>
     
       <?php
      
    
    $v_sql_report = "SELECT A.* 
                FROM tbl_st_track_machine_list AS A 
                $query_truck
                ";
               
    $get_data =$connect->query($v_sql_report);

    while ($rows = mysqli_fetch_object($get_data)) {
   
      $truck_id=$rows->id;
      $h_id=$rows->id;


     
      
      
?>
       <div class="portlet light bordered" id="h_id<?php echo $h_id; ?>" style="display: none;">
    <!-- <a class="btn btn-md btn-danger" style="float: right;" href="index.php" onclick="window.close();"><i class="fa fa-close"></i> Close</a> -->
    <div class="row">
        <div class="col-xs-12">
            
            <label>ឈ្មោះគ្រឿងចក្រ: <span class="text-primary"><?= $rows->name_vn ?></span></label><br>
            <label>កាលបរិច្ឆេទទិញ: <span class="text-primary"><?= $rows->date_buy ?></span></label><br>
            <label>តម្លៃគ្រឿងចក្រ: <span class="text-primary"><?= $rows->track_price ?></span></label><br>
        </div>
    </div>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper" style="overflow-x: scroll;">
            <table class="table table-striped table-bordered table-hover myTableNowrap">
                <thead>
                    <tr class="bg_color">
                        <th rowspan="2">N°</th>
                        <th>ថ្ងៃខែឆ្នាំ</th>
                        <th>លេខសំណើរ</th>
                        <th>ឈ្មោះសំភារះ</th>
                        <th>ទំហំ</th>
                        <th>ចំនួន</th>
                        <th>ឯកតា</th>
                        <th>តម្លៃរាយ</th>
                        <th>សរុប</th>
                        <th>សរុបក្នុងខែ</th>
                    </tr>
                    <tr class="bg_color">
                       
                        <th>Ngày/Tháng/Năm</th>
                        <th>Số Đề Nghị</th>
                        <th>Tên hàng</th>
                        <th>Kích thước</th>
                        <th>số lưởng</th>
                        <th>đơn vi</th>
                        <th>giá</th>
                        <th>Giá tông</th>
                        <th>tông công</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    $v_gounp_month_year =null;
                    $v_gounp_letter_no =null;
                    
                    $v_sql_detail = "SELECT 
                                    A.stsout_date_out,A.stsout_letter_no,B.out_qty,B.pro_id,C.stpron_name_vn,
                                    DATE_FORMAT(A.stsout_date_out,'%m/%Y') AS group_month,
                                    B.out_qty,
                                    D.stun_name,B.stsout_id,B.track_mac_id,A.stock_status,
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
                                   
                                    WHERE A.stock_status='3' OR A.stock_status='5'
                                    AND B.track_mac_id='$truck_id'
                                    $date_query
                                   
                                    GROUP BY  B.std_id,MONTH(A.stsout_date_out),YEAR(A.stsout_date_out)
                                    ORDER BY A.stsout_date_out";


                    $v_result = $connect->query($v_sql_detail);
                    $status_month = 0;

                   

                    

                    
                    // getTotalMonthly($p_result);
                    
                    
                         $v_total_monthly = 0;
                     
                
                    while ($row = mysqli_fetch_object($v_result)) {
                        if($row->pro_id !='') {
                        $b_id=$row->track_mac_id;


                        if ($v_gounp_month_year != $row->group_month) {

                            ++$status_month;
                            
                            // $v_total_monthly = 0;
                            echo '<tr  class="bg_col_span" data_month="dd' . $status_month . '">';
                            echo '<td colspan="10">ខែ ' . $row->group_month . '</td>';
                            echo '</tr>';
                            $v_gounp_month_year = $row->group_month;
                            $is_new_month = true;
                        } else {
                            $is_new_month = false;
                        }
                        
 $v_unit_price = getCostPerProductName($row->stsout_date_out, $row->pro_id,$row->stock_status);
                        
                       
                        echo '<tr id="'.$b_id.'" data_price_each="' . $status_month . '" row_group="' . $row->group_row_monthly . '">';
                        echo '<td>' . (++$i) . '</td>';
                        echo '<td>' . $row->stsout_date_out . '</td>';
                        if ($v_gounp_letter_no != $row->stsout_id) {
                            echo '<td rowspan="' . $row->group_letter_no . '">' . $row->stsout_letter_no . '</td>';
                            $v_gounp_letter_no = $row->stsout_id;
                        }
                        echo '<td>' . $row->stpron_name_vn . '</td>';
                        echo '<td>-</td>';
                        echo '<td>' . $row->out_qty . '</td>';
                        echo '<td>' . $row->stun_name . '</td>';
                        echo '<td>';
                        echo '<span class="pull-left">$</span>';
                        echo '<span class="pull-right">' . number_format($v_unit_price, 2) . '</span>';
                        echo '</td>';
                        echo '<td data_price="' . $v_unit_price * $row->out_qty . '">';
                        echo  '<span class="pull-left">$</span>';
                        echo '<span class="pull-right">' . number_format($v_unit_price * $row->out_qty, 2) . '</span>';
                        echo '</td>';
                        $v_total_monthly += ($v_unit_price * $row->out_qty);

                        if ($is_new_month)
                            
                            echo '<td class="monthly_price" rowspan="' . $row->group_row_monthly . '">' . number_format($v_total_monthly,2) . '</td>';
                        echo '</tr>';
                    
                    ?>

                <?php
                  if($h_id ==$b_id) {
                ?>

                 <script type="text/javascript">

                     $("#h_id<?php echo $h_id; ?>").css("display", "block");
                 </script>
                 <?php
                   }
                 ?>
                <?php
                    }
                  }
                ?>
               
                </tbody>
                <tfoot>
                    <tr class="bg_color">
                        <th colspan="9" class="text-right">TOTAL:</th>
                        <th>
                            <span class="pull-left" style="color: red;">$</span> 
                            <span class="pull-right" style="color: red;"><?= number_format($v_total_monthly, 2) ?></span>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
 <?php
 
                  }
                ?>
    </div>
<style type="text/css">
    .bg_color {
      background: #b0d8f1!important;
    }
    .bg_col_span {
     background: #e0e7ea!important;
    }
</style>
    <?php include_once '../layout/footer.php' ?>

    <script>
    $(document).ready(function() {
        var v_status_parent = 0;
        var v_status = 0;
        var v_price_total = 0;
        var v_flag = 0;
        $('table tbody tr').each(function() {
            v_status_parent = $(this).attr('data_price_each');
            v_group_row = $(this).attr('row_group');
            v_price = parseFloat($(this).find('td[data_price]').attr('data_price'));
           
            if (v_status != v_status_parent) {
                obj_first = $(this);
                v_status = v_status_parent;
                v_obj = $(this).parent('tr').html();
                v_price_total = v_price;
                v_flag = 0;
            } else {
                v_price_total += v_price;
            }
            ++v_flag;
            if (v_flag == v_group_row) {
                v_span_left = `<span class="pull-left">$</span>`;
                v_span_left = `${v_span_left}<span class="pull-right">${numeral(v_price_total).format('0,0.00')}</span>`;
                obj_first.find('td:last-child').html(v_span_left);
            }
        });
    });
</script>
    

    