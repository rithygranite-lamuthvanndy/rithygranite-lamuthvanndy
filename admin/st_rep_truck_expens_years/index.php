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
 
 function myCalCostAverage_Report($arg_arr,$tr_id,$cu_out,$year)
    {
        $result = 0;
        $result = ($arg_arr['begining_bal_price'] + $arg_arr['current_in_price']) /
        MAX(($arg_arr['begining_bal_qty'] + $arg_arr['current_in_qty']), 1);
         $result=$result * $cu_out;
    echo '<input type="hidden"  class="section_data'.$tr_id.''.$year.'  section_data_y'.$year.'  
          
         " 
         value="'.round($result, 2).'"> ';
   
        return round($result, 2);
    }


  function group_by_month_report($v_date_start,$v_date_end,$year_order) {



   
    global $connect;
    $date_query_function='AND E.stsout_date_out BETWEEN "'.$v_date_start.'" AND  "'.$v_date_end.'" ';
        $v_sql_report = "SELECT A.*,B.stca_name,B.stca_code,C.stun_name,B.stca_id,F.name_kh,F.name_vn,F.date_buy,F.track_price,F.note,F.id,E.stsout_date_out,F.id as tr_id,
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
                WHERE A.stpron_material_type='3' OR A.stpron_material_type='5' AND E.stock_status='3' OR 
                E.stock_status='5' 
                $date_query_function 
                
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

          // echo $v_sql_report;     
    $get_data =$connect->query($v_sql_report);
   
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

                    $result_cost = myCalCostAverage_Report($v_array,$row->tr_id,$row->current_out,$year_order);

                    $v_last_qty = ($v_begining_bal_qty + $v_current_in_qty - @$row->current_out + @$row->current_adjust);
                    // =========================== End Calculation ====================


      }
  }


if (isset($_POST['btn_search'])) {
   
    $v_date_start = @$_POST['txt_month_start'];
    $v_date_start="$v_date_start-01-01";
    $v_date_end = @$_POST['txt_month_end'];
    $v_date_end="$v_date_end-12-31";

    $date_query=' C.stsout_date_out BETWEEN "'.$v_date_start.'" AND  "'.$v_date_end.'" ';
            }


else {
     $v_date_start = date('Y-01-01');
     $v_date_end = date('Y-12-31');
     $date_query=' C.stsout_date_out BETWEEN "'.$v_date_start.'" AND  "'.$v_date_end.'" ';
}

?>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12"> 
        </div>
         <div class="col-xs-7">
            <form action="#" method="post" name= "form1" id ="form1">
                <div class="col-sm-4">
                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy">
                        <input type="text" class="form-control" value="<?= @$_POST['txt_month_start'] ?>" name="txt_month_start" placeholder="Date From ..." required="" aufocomplete="off">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy">
                        <input type="text" class="form-control" value="<?= @$_POST['txt_month_end'] ?>" name="txt_month_end" placeholder=" To Date ..." required="" aufocomplete="off">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    
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
                        <a target="_blank" href="print_summary.php?p_date_start=<?= (@$_POST['txt_month_start'] ? $_POST['txt_month_start'] : date('Y-m-d')) ?>&p_date_end=<?= (@$_POST['txt_month_end'] ? $_POST['txt_month_end'] : date('Y-m-d')) ?>" id="sample_editable_1_new" class="btn yellow">
                <i class="fa fa-print"></i> Print</a>


               

            <a target="_blank" href="#" id="print" onClick="javascript:fnExcelReport();" class="btn blue">
                <i class="fa fa-share"></i> Export</a>

                    </div>
        </div>
        <br>
        <h2 style="font-family: 'khmer'; float: left;"><i class="fa fa-file"></i>
            របាយការណ៍ជួសជុលគ្រឿងចក្រ  / Báo Cáo Sửa Chữa Cơ Giới
        </h2>
<?php
  if (isset($_POST['btn_search'])) {
    $v_date_start = @$_POST['txt_month_start'];
    $v_date_start="$v_date_start-01-01";
    $v_date_end = @$_POST['txt_month_end'];
    $v_date_end="$v_date_end-12-31";
    $date_query=' C.stsout_date_out BETWEEN "'.$v_date_start.'" AND  "'.$v_date_end.'" ';
     $sum_loop_year=0;  
     $start_year=@$_POST['txt_month_start'];
     $end_year=@$_POST['txt_month_end'];
     $sum_loop_year =($end_year - $start_year)+1;
            }


else {
     $v_date_start = date('Y-01-01');
     $v_date_end = date('Y-12-31');
     $date_query=' C.stsout_date_out BETWEEN "'.$v_date_start.'" AND  "'.$v_date_end.'" ';
     $sum_loop_year=1;
     $start_year=date('Y');
}

?>
        <div class="portlet-body">
            <div id="sample_1_wrapper" class="dataTables_wrapper" style="overflow-x: scroll;">
        
<table class="table table-striped table-bordered table-hover dataTable dtr-inline myTableNowrap" role="grid" aria-describedby="sample_1_info" id="myTable">

                    <tr style="background-color: #e7ecf1;">
                        <th>No</th>
                        <th>Ngày Mua</th>
                        <th colspan="2">Tên</th>
                       <?php
                         for ($th=1; $th <=$sum_loop_year ; $th++) { 
                        
                        ?>
                        <th>ជុសជួលប្រចាំឆ្នាំ <?php echo $start_year+$th-1; ?></th>
                        <?php
                          }
                        ?>
                        
                        
                    </tr>
                    <tr style="background-color: #e7ecf1;">
                        <th rowspan="2">ល.រ</th>
                        <th rowspan="2">កាលបរិច្ឆេទទិញ</th>
                        <th colspan="2">ឈ្មោះគ្រឿងចក្រ</th>
                        <?php
                         for ($th=1; $th <=$sum_loop_year ; $th++) { 
                        
                        ?>
                        <th rowspan="2">Tổng cộng 
sửa chữa <?php echo $start_year+$th-1; ?></th>
                        <?php
                          }
                        ?>
                        
                       
                      
                    </tr>
                    <tr style="background-color: #e7ecf1;">
                       
                        <th>ខ្មែរ</th>
                        <th>វៀតណាម</th>
                    </tr>
                   

                     <?php



    $v_sql_track= "SELECT *  FROM tbl_st_track_machine_list  AS A
                LEFT JOIN tbl_st_stock_out_detail AS B ON A.id =B.track_mac_id
                LEFT JOIN tbl_st_stock_out AS C ON C.stsout_id=B.stsout_id
                WHERE $date_query  AND C.stock_status='3' OR C.stock_status='5'   ";  
           // echo $v_sql_report;     
    $get_data_track =$connect->query($v_sql_track);
    $j=0;

   
             $v_track_tmp = [];   
        
    while ($rows = mysqli_fetch_object($get_data_track)) {

          if (!in_array($rows->id, $v_track_tmp)) {
              array_push($v_track_tmp, $rows->id);

            for ($th=1; $th <=$sum_loop_year ; $th++) { 
                $year=$start_year+$th-1;
                  echo group_by_month_report($year.'-01-01',$year.'-01-31',$year); 
                  echo group_by_month_report($year.'-02-01',$year.'-02-31',$year); 
                  echo group_by_month_report($year.'-03-01',$year.'-03-31',$year); 
                  echo group_by_month_report($year.'-04-01',$year.'-04-31',$year); 
                  echo group_by_month_report($year.'-04-01',$year.'-05-31',$year); 
                  echo group_by_month_report($year.'-06-01',$year.'-06-31',$year); 
                  echo group_by_month_report($year.'-07-01',$year.'-07-31',$year); 
                  echo group_by_month_report($year.'-08-01',$year.'-08-31',$year); 
                  echo group_by_month_report($year.'-09-01',$year.'-09-31',$year); 
                  echo group_by_month_report($year.'-10-01',$year.'-10-31',$year); 
                  echo group_by_month_report($year.'-11-01',$year.'-11-31',$year); 
                  echo group_by_month_report($year.'-12-01',$year.'-12-31',$year); 


                       
            }
                        



                        
              

                    ?>

                    <tr>
                        <td><?php echo ++$j; ?></td>
                        <td><?php echo $rows->date_buy; ?></td>
                        <td><?php echo $rows->name_kh; ?></td>
                        <td><?php echo $rows->name_vn; ?></td>
                        <?php
                         for ($th=1; $th <=$sum_loop_year ; $th++) { 
                             $year=$start_year+$th-1;
                        
                        ?>
                        <td style='mso-number-format:"0\.00"' id="out_td<?php echo $rows->id.$year; ?>" class="t_y<?php echo $rows->id.$year; ?>"></td>
                        <?php
                          }
                        ?>
                    </tr>

                    <?php
                      for ($th=1; $th <=$sum_loop_year ; $th++) { 
                             $year=$start_year+$th-1;
                    ?>
                    <div style="display:hidden;">
                    
                    <script>
                      
                           var sum_out = 0;
                           
                           var div_tr = $('#myTable').children('tbody').children('tr').length -3;


                        $(".section_data<?php echo $rows->id.$year; ?>").each(function(){
                            sum_out += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                        });
                        var divid_sum=sum_out/div_tr;
                        var total_cost_out=divid_sum.toFixed(2);
                        $('#out_td<?php echo $rows->id.$year; ?>').html(total_cost_out);


                        


                      
                    </script>
                    </div>
                  <?php } ?>
                    
   <?php } } ?>

     <tr class="tr_report" style="font-weight: bold;background: #F2F2DB !important"> 
                        <td colspan="4">Tổng cộng sửa chữa / សរុបការជួសជុល:</td>
                         <?php
                         for ($th=1; $th <=$sum_loop_year ; $th++) { 
                             $year=$start_year+$th-1;
                        
                        ?>

                        <td style='mso-number-format:"0\.00"' id="total_top_m<?php echo $year;?>"></td>
                       
                        <div style="display:hidden;">
                        <script type="text/javascript">
                            var sum_total_ex = 0;
                            var div_tr_total_ex = $('#myTable').children('tbody').children('tr').length-4;
                            $(".section_data_y<?php echo $year; ?>").each(function(){
                                sum_total_ex += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                            });
                        
                            
                            var div_t_total=sum_total_ex/div_tr_total_ex;
                            var total_cost_t_total=div_t_total.toFixed(2);
                            $("#total_top_m<?php echo $year; ?>").html(total_cost_t_total);
                        </script>
                        </div>
                        <?php
                          }
                        ?>
                        
                       
                        
                    </tr>


                    
                </table>

            </div>
        </div>
    </div>
</div>


    <style type="text/css">
        
        .tr_report  {
            background: #F2F2DB !important;
            border: 3px solid  black !important;

        }
        th {
            text-align: center;
        }
        .myselect2 {
            width: 100% !important;
        }
        .buttons-excel {
            display: block !important;
        }
    </style>
  
    
    <?php include_once '../layout/footer.php' ?>
    <?php
       if(@$_POST['txt_month_start']=="") {
        $t1=date("Y");
       }
       else {
        $t1=@$_POST['txt_month_start'];
       }
        if(@$_POST['txt_month_end']=="") {
        $t2=date("Y");
       }
       else {
        $t2=@$_POST['txt_month_end'];
       }
    ?>
    <script>
        function fnExcelReport() {
            var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
            tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';
            tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
            tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
            tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';
    tab_text=tab_text + '<p style="text-align:center;">របាយការណ៍ជួសជុលគ្រឿងចក្រ <?php echo $t1.'-'.$t2; ?><br>Báo Cáo Sửa Chữa Cơ Giới</p>';
            
            tab_text = tab_text + "<table border='1px'>";
    
            //get table HTML code
            tab_text = tab_text + $('#myTable').html();
            tab_text = tab_text + '</table></body></html>';

            var data_type = 'data:application/vnd.ms-excel';
 
            var ua = window.navigator.userAgent;
            var msie = ua.indexOf("MSIE ");
            //For IE
            // if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
            //     if (window.navigator.msSaveBlob) {
            //     var blob = new Blob([tab_text], {type: "application/csv;charset=utf-8;"});
            //     navigator.msSaveBlob(blob, 'Test file.xls');
            //     }
            // } 
            //for Chrome and Firefox 
            // else {
            $('#print').attr('href', data_type + ', ' + encodeURIComponent(tab_text));
            $('#print').attr('download', 'Test file.xls');
            // }
        }
    </script>
    

    