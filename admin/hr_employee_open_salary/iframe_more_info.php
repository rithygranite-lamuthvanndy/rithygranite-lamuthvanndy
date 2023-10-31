<?php 
    $menu_active =33;
    $layout_title = "Welcome";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
?>


<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
<!-- END GLOBAL MANDATORY STYLES -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="../../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN THEME GLOBAL STYLES -->
<link href="../../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="../../assets/global/css/components-rounded.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="../../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
<!-- END THEME GLOBAL STYLES -->

<!-- BEGIN THEME LAYOUT STYLES -->
<link href="../../assets/layouts/layout4/css/layout.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/layouts/layout4/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
<link href="../../assets/layouts/layout4/css/custom.min.css" rel="stylesheet" type="text/css" />
<!-- END THEME LAYOUT STYLES -->
<?php
    if(@$_GET['v_id']){
        $v_id=@$_GET['v_id'];
        $get_data=$connect->query("SELECT A.*,B.*,C.*,E.*,
            (select sum(emup_salary_up) from tbl_hr_employee_salary_up where emup_emp_id=A.empl_id) as tt_salary_up
            FROM tbl_hr_employee_list AS A 
            LEFT JOIN tbl_hr_position_list AS B ON A.empl_position=B.po_id
            LEFT JOIN tbl_hr_department_sub AS C ON A.empl_department=C.dep_id
            left join tbl_hr_sex_list as D on A.empl_sex=D.sex_id
            left join tbl_hr_national_list as E on A.empl_national=E.national_id
            WHERE A.empl_id='$v_id'");
        $row = mysqli_fetch_object($get_data);
    }
?>
<div class="portlet light bordered">
    <br>
    <div class="row">
        <div class="text-primary">
          <div class="col-xs-6">
            <br>
            <b>#254Beo, St 107, Sangkat Boeung Prolit, Khan 7Makara,
            <br>Phnom Penh, Cambodia.
            <br>Tel: (088)-254-7979</b>
          </div>
          <div class="col-xs-6 text-center">
            <h1 style="font-family: 'Khmer OS Moul';">ការដ្ឋានឫទ្ធីកៅស៊ូ (ឬទ្ធីក្រានីត)</h1>
            <h2 style="font-family: 'Times New Roman';"><b>RITHY RUBBER (CAMBODIA)</b></h2>
          </div>            
        </div>
          <div class="col-xs-12 text-center">
            <h2 style="font-family: 'Times New Roman';"><b>BẢNG LƯƠNG CÁ NHÂN / SALARY</b></h2>
            <h4 style="font-family: 'Khmer OS Moul';"><b><?= $row->dep_name ?></b></h4>
          </div>
        <div class="portlet-body">
            <div class="col-xs-12">
              <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_2" role="grid" aria-describedby="sample_1_info">
                <thead>
                  <tr>
                    <th></th>
                    <th colspan="3" class="text-right">Ngày/tháng/năm PRINT DATE:</th>
                    <th colspan="2" class="text-center"><?= date('d-M-Y') ?></th>
                  </tr>
                  <tr>
                    <th></th>
                    <th colspan="3" class="text-right">Ngày / PAYDAY:</th>
                    <th colspan="2" class="text-center"><?= date('l') ?></th>
                  </tr>
                  <tr>
                    <th>NO: <?= $row->empl_id ?></th>
                    <th colspan="3" class="text-right">Tháng/ MONTH:</th>
                    <th colspan="2" class="text-center"><?= date('F') ?></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><b>TÊN NHÂN VIÊN:</b></td>
                    <td colspan="4" class="text-center"><?= $row->empl_emloyee_en ?> - <?= $row->empl_emloyee_kh ?></td>
                    <td></td>
                  </tr> 
                  <tr>
                    <td><b>QUỐC TỊCH:</b></td>
                    <td><?= $row->national_name ?></td>
                    <td><b>GIỚI TÍNH:</b></td>
                    <td><?= $row->empl_date_work ?></td>
                    <td><b>CODE ID:</b></td>
                    <td><?= $row->empl_card_id ?></td>
                  </tr> 
                  <tr>
                    <td>CHỨC VỤ:</td>
                    <td colspan="5" class="text-center"><?= $row->dep_name ?> - <?= $row->po_name ?></td>
                  </tr>
                  <tr>
                    <td>HÌNH THỨC :</td>
                    <td>Full</td>
                    <td>Ngày bắt đầu:</td>
                    <td class="text-center"><b>Chức vụ 1</b></td>
                    <td class="text-center"><b>Chức vụ 2</b></td>
                    <td class="text-center"><b>Chức vụ 3</b></td>
                  </tr> 
                  <tr>
                    <td>NGÀY CÔNG :</td>
                    <td>30</td>
                    <td>Số ngày làm việc :</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr> 
                  <tr>
                    <td rowspan="7" class="text-center"><b>Emp_ID: <?= $row->empl_card_id ?></b><br><img style="width:200px;" src="../../img/img_empl/<?= $row->empl_pic ?>" class="img-responsive img-responsive img-thumbnail" alt="Blank"></td>
                    <td class="text-right">Lương  cũ:</td>
                    <td>ប្រាក់ខែចាស់ៈ</td>
                    <td>$ <?= number_format($row->empl_salary,2) ?></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="text-right">Giảm trừ lương:</td>
                    <td>ប្រាក់កាត់បន្ថយៈ</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="text-right">Tiền lương đủ ngày công:</td>
                    <td>ប្រាក់ខែពេញម៉ោងៈ</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="text-right">Lương cơ bản:</td>
                    <td>ប្រាក់ខែមូលដ្ឋានៈ</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="text-right">Tiến cấp chức vụ:</td>
                    <td>ប្រាក់បំពេញការងារៈ</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="text-right">Đánh giá:</td>
                    <td>វាយតំលៃៈ</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="text-right">Tiền cấp chức vụ nhận được:</td>
                    <td>ប្រាក់ការងារទទួលបានៈ</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="text-center"><b>Ghi chú : សំគាល់</b></td>
                    <td class="text-right">Lương ngày công thực tế:</td>
                    <td>ប្រាក់នៃចំនួនថ្ងៃធ្វើការៈ</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td class="text-right">Tăng/Trừ lương:</td>
                    <td>តំឡើង/កាត់ៈ</td>
                    <td>$ <?= number_format($row->tt_salary_up,2) ?></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td class="text-right">Phụ cấp/ trừ:</td>
                    <td>ឧបត្ថម្ភ/កាត់ៈ</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td class="text-right">Phụ cấp Lễ tết</td>
                    <td>ឧបត្ថម្ភចូលឆ្នាំចិន</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td class="text-right">Ứng tháng trước</td>
                    <td>ខ្ចីមុនខែ:</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td class="text-right">Ứng trong tháng</td>
                    <td>ខ្ចីក្នុងខែ:</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td class="text-right">Hoàn Ứng</td>
                    <td>ប្រាក់កាត់សង:</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td class="text-right">Nợ Ứng</td>
                    <td>នៅជំពាក់ៈ</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr> 
                  <tr>
                    <td class="text-center"><b>Tiền lương thực nhận</b></td>
                    <td class="text-center"><b>សរុបប្រាក់ត្រូវបើក</b></td>
                    <td style="'Times New Roman'; font-size: 14px; text-align: center;"><b>$ <?= number_format($row->empl_salary+$row->tt_salary_up,2) ?></b></td>
                    <td style="'Times New Roman'; font-size: 14px; text-align: center;"><b>$ <?= number_format($row->empl_salary+$row->tt_salary_up,2) ?></b></td>
                    <td></td>
                    <td></td>
                  </tr>        
                </tbody>  
                <tfoot>
                 <tr>
                   <th></th>
                   <th></th>
                   <th></th>
                   <th></th>
                   <th></th>
                   <th></th>
                 </tr> 
                </tfoot>
              </table>
            </div>
        </div>
    </div>    
</div>
<!-- BEGIN CORE PLUGINS -->
<script src="../../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="../../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="../../assets/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../assets/pages/scripts/table-datatables-buttons.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="../../assets/layouts/layout4/scripts/layout.min.js" type="text/javascript"></script>
<script src="../../assets/layouts/layout4/scripts/demo.min.js" type="text/javascript"></script>
<!-- <script src="../../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script> -->
<!-- <script src="../../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script> -->
<!-- END THEME LAYOUT SCRIPTS -->

