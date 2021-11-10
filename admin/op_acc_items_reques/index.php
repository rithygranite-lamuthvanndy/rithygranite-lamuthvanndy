<?php 
    $menu_active =13;
    $left_active =63;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    
    include_once '../layout/header.php';
?>
<?php 
    if(isset($_POST['btn_search'])){
        $v_start=@$_POST['txt_date_start'];
        $v_end=@$_POST['txt_date_end'];
        $txt_items=@$_POST['txt_items'];
        if($txt_items !="")   {
             $txt_items=" AND  A.rei_item_name ='$txt_items' ";
        } 
        else {
             $txt_items='';
        }

        $get_data=$connect->query("SELECT * FROM tbl_acc_request_item  AS A
                        LEFT JOIN tbl_acc_request_form AS        B ON A.rei_number=B.req_id
                     LEFT JOIN tbl_acc_department_list AS        C ON B.dep_id=C.dep_id
                   LEFT JOIN tbl_acc_request_name_list AS        D ON B.req_request_name=D.res_id
                  LEFT JOIN tbl_acc_approved_name_list AS        E ON B.req_approved_by=E.apn_id
                  LEFT JOIN tbl_acc_pur_confirm        AS        F ON F.req_no=B.req_id
                  LEFT JOIN tbl_hr_employee_list1      AS        G ON G.empl_id=F.buyer_id
                  LEFT JOIN tbl_acc_unit_list          AS        H ON H.uni_id=A.rei_unit
                  LEFT JOIN tbl_acc_type_request_list  AS        I ON I.typr_id=B.type_req_id
                    WHERE DATE_FORMAT(B.req_date,'%Y-%m-%d') BETWEEN '$v_start' AND '$v_end' $txt_items
                         ORDER BY I.typr_name ASC");

       

        
    }
    else{

        $v_start = date('Y-m-01');
        $v_end = date('Y-m-t');
        $v_current_month = date('Y-m');

       $get_data=$connect->query("SELECT * FROM tbl_acc_request_item  AS A
                        LEFT JOIN tbl_acc_request_form AS        B ON A.rei_number=B.req_id
                     LEFT JOIN tbl_acc_department_list AS        C ON B.dep_id=C.dep_id
                   LEFT JOIN tbl_acc_request_name_list AS        D ON B.req_request_name=D.res_id
                  LEFT JOIN tbl_acc_approved_name_list AS        E ON B.req_approved_by=E.apn_id
                  LEFT JOIN tbl_acc_pur_confirm        AS        F ON F.req_no=B.req_id
                  LEFT JOIN tbl_hr_employee_list1       AS        G ON G.empl_id=F.buyer_id
                  LEFT JOIN tbl_acc_unit_list          AS        H ON H.uni_id=A.rei_unit
                  LEFT JOIN tbl_acc_type_request_list  AS        I ON I.typr_id=B.type_req_id
                            WHERE DATE_FORMAT(B.req_date,'%Y-%m') = '$v_current_month'
                         ORDER BY I.typr_name ASC");
       
    }


    
 ?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2 style="font-family: 'Khmer OS Moul';"><i class="fa fa-fw fa-map-marker"></i> សរុបសំណើរ & សរុបចំណាយ</h2>
        </div>
    </div>
  
<br>
    <div class="row">
        <?php
          if(@$_GET['check']==1) {
            $date_s_s=@$_GET['v_start'];
            $date_s_e=@$_GET['v_end'];
          }
          else {
            $date_s_s=@$_POST['txt_date_start'];
            $date_s_e=@$_POST['txt_date_end'];
          }
        ?>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" name= "form1" id ="form1">
             <div class="col-sm-2">
                <select onchange="window.location=this.value" class="btn"  style="width:100%;height: 33px;">
                    <option  value="../op_acc_add_request_form_invoice">Request</option>
                    <option  selected="" value="../op_acc_items_reques">Items</option>
                </select>
            </div>
            <div class="col-sm-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input autocomplete="off" name="txt_date_start" 
                    value="<?php echo $date_s_s; ?>"
                     type="text" class="form-control" placeholder="Date From ....">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input autocomplete="off" name="txt_date_end" 
                    value="<?php echo $date_s_e; ?>" 
                    type="text" class="form-control" placeholder="Date To">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <select class="form-control myselect2" name="txt_items"  >
                        <option value="">=== Please Choose and Select ===</option>
                        <?php
                        $v_select = $connect->query("SELECT * FROM tbl_acc_request_item GROUP BY rei_item_name  ORDER BY rei_id ASC");
                        while ($row_data = mysqli_fetch_object($v_select)) {
                            if(@$_POST['txt_items']==$row_data->rei_item_name) {
                                 echo '<option selected value="' . $row_data->rei_item_name . '">' . $row_data->rei_item_name .' ' . $row_data->rei_type .'</option>';
                            }

                            else {
                                 echo '<option value="' . $row_data->rei_item_name . '">' . $row_data->rei_item_name .' ' . $row_data->rei_type .'</option>';
                            }

                           
                        }
                        ?>
                    </select>
             </div>
            
            <div class="col-sm-2">
                
            </div>
            <div class="caption font-dark" style="display: inline-block;">
                    <button type="submit" name="btn_search" id="sample_editable_1_new" class="btn blue btn-sm"> Search
                        <i class="fa fa-search"></i>
                    </button>
                 <a target="_blank" href="print.php?p_date_start=<?= (@$_POST['txt_date_start'] ? $_POST['txt_date_start'] : date('Y-m-d')) ?>&p_date_end=<?= (@$_POST['txt_date_end'] ? $_POST['txt_date_end'] : date('Y-m-d')) ?>&txt_items=<?= @$_POST['txt_items']?>" id="sample_editable_1_new" class="btn yellow">
                    <i class="fa fa-print"></i> Print</a>
                     <a target="_blank" href="export_excell.php?p_date_start=<?= (@$_POST['txt_date_start'] ? $_POST['txt_date_start'] : date('Y-m-d')) ?>&p_date_end=<?= (@$_POST['txt_date_end'] ? $_POST['txt_date_end'] : date('Y-m-d')) ?>&txt_items=<?= @$_POST['txt_items']?>" id="sample_editable_1_new" class="btn blue">
                <i class="fa fa-share"></i> Export</a>

                <!-- <a target="_blank" href="#" id="print" onClick="javascript:fnExcelReport();" class="btn blue">
                <i class="fa fa-share"></i> Export</a> -->
            </div>
            <br>
        </form>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline myTableNowrap" role="grid" aria-describedby="sample_1_info" >
                <thead>
                    <tr role="row" class="text-center">
                        <th style="width: 4%;">N&deg;</th>
                        <th style="">កាលបរិច្ឆេទស្នើរសុំ</th>
                        <th style="">លេខសំណើរ</th>
                        <th style="">ឈ្មោះនាយកដ្ឋាន</th>
                        <th style="">អ្នកស្នើរសុំ</th>
                        <th style="">ឯកភាពដោយ</th>
                        <th style="">ទឹកប្រាក់ស្នើរសុំ</th>
                        <th style="">ឈ្មោះអ្នកទិញ&អ្នកទទួល</th>
                        <th style="">ប្រភេទឡាន&ម៉ាស៊ីន&ឈ្នួល</th>
                        <th style="">ឈ្មោះសម្ភារៈ</th>
                        <th style="">ទំហំ/លេខ</th>
                        <th style="">ចំនួន</th>
                        <th style="">ឯកតា</th>
                        <th style="">តម្លៃរាយ</th>
                        <th style="">តម្លៃសរុប</th>
                        <th style="">ចំណាំសំរាប់ផ្នែកទិញ
                    </th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                       
                        $v_cat_name_tmp = [];
                        while ($row = mysqli_fetch_object($get_data)) {

                     if (!in_array($row->typr_name, $v_cat_name_tmp)) {
                      $i = 0;
                        array_push($v_cat_name_tmp, $row->typr_name);
                        echo '<tr class="bg-blue">';
                        echo '<td colspan="16" style="color:white;">' . $row->typr_name . '</td>';
                        echo '</tr>';
                     }

                    ?>

                    <tr>
                        <td><?php echo (++$i); ?></td>
                        <td><?php echo $row->req_date; ?></td>
                        <td><?php echo $row->req_number; ?></td>
                        <td><?php echo $row->dep_name; ?></td>
                        <td><?php echo $row->res_name; ?></td>
                        <td><?php echo $row->apn_name; ?></td>
                        <td><?php echo number_format($row->rei_price,2); ?></td>
                        <td><?php echo $row->empl_emloyee_kh.' '.$row->empl_emloyee_en; ?></td>
                        <td><?php echo $row->for_area;  ?></td>
                        <td><?php echo $row->rei_item_name.' '.$row->rei_type; ?></td>
                        <td><?php echo $row->rei_size; ?></td>
                        <td><?php echo $row->rei_qty; ?></td>
                        <td><?php echo $row->uni_name; ?></td>
                        <td><?php echo number_format($row->rei_price,2); ?></td>
                        <td><?php echo number_format($row->rei_qty * $row->rei_price, 2) ?></td>
                        <td>
                            <?php
                             if($row->pur_id >0) {
                                echo "Done";
                             }
                             else {
                                echo "Pendding";
                             }
                            ?>
                        </td>
                        
                        
                    </tr>
                    <?php
                      }
                    ?>
                </tbody>
            </table>

            <?php
                 if(isset($_POST['btn_search'])){
                  $v_start=@$_POST['txt_date_start'];
                  $v_end=@$_POST['txt_date_end'];
                  $txt_items=@$_POST['txt_items'];
                  if($txt_items !="")   {
                       $txt_items=" AND  C.rei_item_name ='$txt_items' ";
                  } 
                  else {
                       $txt_items='';
                  }

                   $get_datas=$connect->query("SELECT SUM(rei_qty*rei_price) as total_price,typr_name
                                       FROM tbl_acc_type_request_list  AS A
                                    LEFT JOIN tbl_acc_request_form AS        B ON A.typr_id=B.type_req_id
                                    LEFT JOIN tbl_acc_request_item AS        C ON C.rei_number=B.req_id
                               
                              WHERE DATE_FORMAT(B.req_date,'%Y-%m-%d') BETWEEN '$v_start' AND '$v_end' $txt_items
                                      GROUP BY A.typr_name
                                   ORDER BY A.typr_name ASC");
              }
              else{

                  $v_start = date('Y-m-01');
                  $v_end = date('Y-m-t');

                 $get_datas=$connect->query("SELECT SUM(rei_qty*rei_price) as total_price,typr_name
                                       FROM tbl_acc_type_request_list  AS A
                                    LEFT JOIN tbl_acc_request_form AS        B ON A.typr_id=B.type_req_id
                                    LEFT JOIN tbl_acc_request_item AS        C ON C.rei_number=B.req_id
                               
                                      WHERE DATE_FORMAT(B.req_date,'%Y-%m-%d') BETWEEN '$v_start' AND '$v_end'
                                      GROUP BY A.typr_name
                                   ORDER BY A.typr_name ASC");
                 
              }
            ?>


              <table class="table table-striped table-bordered table-hover dataTable dtr-inline myTableNowrap" style="width: 50%;float: left;">
                <thead>
                 
                </thead>
                <tbody>
                  <?php
                    $total_price_all=0;
                     while ($rows = mysqli_fetch_object($get_datas)) {
                      $total_price_all +=$rows->total_price;
                  ?>
                  <tr>
                    <td><?php echo $rows->typr_name; ?></td>
                    <td><label style="text-align: left;">$</label> <span style="float: right;">
                        <?php echo number_format($rows->total_price,2); ?>
                    </span></td>
                  </tr>
                  <?php } ?>
                  
                  <tr>
                    
                    <td style="font-weight: bold;">សរុប</td>
                    <td><label style="text-align: left;font-weight: bold;">$</label> <span style="float: right;font-weight: bold;"><?php echo number_format($total_price_all,2); ?></span></td>
                  </tr>
                </tbody>
              </table>



        </div>
    </div>
</div>

<script type="text/javascript" src="../../assets/global/plugins/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('a[href="#more_info"]').click(function(){
            v_id=$(this).attr('data_id');
            $('iframe[id=my_frame]').attr('src','iframe_more_info.php?sent_id='+v_id);
        });

       
    });
        <?php
          if(@$_GET['check']==1) {
        ?>
        
         $("button").click();
        <?php
           }
        ?>
</script>
<?php include_once '../layout/footer.php' ?>

<div class="modal fade" id="more_info">
    <div class="modal-dialog modal-lg" style="width: 1300px; border: 1px solid darkred;">
        <iframe id="my_frame" frameborder="0" style="height: 600px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<style type="text/css">
    .dt-buttons  {
        display: none;
    }
</style>
<?php
       if(@$_POST['txt_date_start']=="") {
        $t1=date("Y");
       }
       else {
        $t1=@$_POST['txt_date_start'];
       }
        if(@$_POST['txt_date_end']=="") {
        $t2=date("Y");
       }
       else {
        $t2=@$_POST['txt_date_end'];
       }
    ?>
    <script>
        function fnExcelReport() {
            var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
            tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';
            tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
            tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
            tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';
    tab_text=tab_text + '<p style="text-align:center;">សរុបសំណើរ&សរុបចំណាយ <?php echo $t1.'-'.$t2; ?><br>Báo Cáo Sửa Chữa Cơ Giới</p>';
            
            tab_text = tab_text + "<table border='1px'>";
    
            //get table HTML code
            tab_text = tab_text + $('.table').html();
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