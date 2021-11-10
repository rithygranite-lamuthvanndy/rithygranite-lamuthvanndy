<?php 
    $layout_title = "Welcome";
    $menu_active =44;
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12" style="text-align: center;">
            <h2 style="font-family: 'Khmer OS Moul';">របាយការណ៍ការងារប្រចាំថ្ងៃ</h2>
            <h2><b>BÁO CÁO CÔNG VIỆC HẰNG NGÀY</b></h2>
			<hr>
        </div>
        <div class="col-xs-12">
            <label class="col-md-6">ការដ្ឋានរ៉ែថ្មក្រានីត / NHÀ MÁY ĐÁ GRANITE</label><label class="col-md-6 text-right">ថ្ងៃទី ១៤  ខែ មេសា ឆ្នាំ  ២០២០ / Ngày 14  tháng 04 năm 2020</label><br>
            <hr>
        </div>
        <div class="col-xs-12">
            <h4 style="font-family: 'Khmer OS Siemreap';"><b>I-<u>សង្វាក់ផលិតកម្ម (រណ្តៅរ៉ែ) - HOẠT ĐỘNG TẠI KHU KHAI THÁC MỎ</u> </b></h4>
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed">
              <thead style="border: 2; background: #39CCCC; font-family: 'Khmer OS New'; center;" class="text-center">
                <tr>
                  <th class="text-center" rowspan="2">
                    ល.រ
                  </th>
                  <th class="text-center" rowspan="2">
                    បរិយាយ
                  </th>
                  <th class="text-center" colspan="2">
                    ពេលធ្វើការ
                  </th>
                  <th class="text-center" rowspan="2">
                    កំណត់សម្គាល់
                  </th>
                </tr>
                <tr>
                  <th class="text-center">
                    ថ្ងៃ (Ngày)
                  </th>
                  <th class="text-center">
                    យប់ (Đêm)
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    1
                  </td>
                  <td>
                    សកម្មភាពអារថាស់​/Cưa Mâm: 
                  </td>
                  <td class="text-center">
                    <input type="checkbox" name="check_stay_in" style="width: 20px; height: 20px;">
                  </td>
                  <td class="text-center">
                    <input type="checkbox" name="check_stay_in" style="width: 20px; height: 20px;">
                  </td>
                  <td>
                    <textarea type="text" class="form-control" name="txt_note" rows="2"  autocomplete="off"></textarea>
                  </td>
                </tr>
                <tr>
                  <td>
                    2
                  </td>
                  <td>
                    សកម្មភាពអារ​ខ្សែរ/Cưa Dây : 
                  </td>
                  <td class="text-center">
                    <input type="checkbox" name="check_stay_in" style="width: 20px; height: 20px;">
                  </td>
                  <td class="text-center">
                    <input type="checkbox" name="check_stay_in" style="width: 20px; height: 20px;">
                  </td>
                  <td>
                    <textarea type="text" class="form-control" name="txt_note" rows="2"  autocomplete="off"></textarea>
                  </td>
                </tr>
                <tr>
                  <td>
                    3
                  </td>
                  <td>
                    សកម្មភាពគាស់យកថ្ម/Thu đá BLOCK:
                  </td>
                  <td class="text-center">
                    <input type="checkbox" name="check_stay_in" style="width: 20px; height: 20px;">
                  </td>
                  <td class="text-center">
                    <input type="checkbox" name="check_stay_in" style="width: 20px; height: 20px;">
                  </td>
                  <td>
                    <textarea type="text" class="form-control" name="txt_note" rows="2"  autocomplete="off"></textarea>
                  </td>
                </tr>
                <tr>
                  <td>
                    4
                  </td>
                  <td>
                    "ដឹកជញ្ជូនថ្មចេញពីរណ្តៅរ៉ែដើម្បីពិនិត្យគុណភាព"<br>          
                    Vận chuyển đá khu khai thác mỏ để kiểm định chất lượng:         
                  </td>
                  <td class="text-center">
                    <input type="checkbox" name="check_stay_in" style="width: 20px; height: 20px;">
                  </td>
                  <td class="text-center">
                    <input type="checkbox" name="check_stay_in" style="width: 20px; height: 20px;">
                  </td>
                  <td>
                    <textarea type="text" class="form-control" name="txt_note" rows="2"  autocomplete="off"></textarea>
                  </td>
                </tr>
                <tr>
                  <td>
                    5
                  </td>
                  <td>
                    សកម្មភាពអារបើកមុខ/ Cưa mở miệng:         
                  </td>
                  <td class="text-center">
                    <input type="checkbox" name="check_stay_in" style="width: 20px; height: 20px;">
                  </td>
                  <td class="text-center">
                    <input type="checkbox" name="check_stay_in" style="width: 20px; height: 20px;">
                  </td>
                  <td>
                    <textarea type="text" class="form-control" name="txt_note" rows="2"  autocomplete="off"></textarea>
                  </td>
                </tr>
              </tbody>
            </table>


        </div>
        <div class="col-xs-12">
            <h4 style="font-family: 'Khmer OS Siemreap';"><b>II-<u>សង្វាក់ផលិតកម្ម (រោងចក្រ) - HOẠT ĐỘNG NHÀ MÁY</u> </b></h4>
<span class="label success">Success</span>
<span class="label info">Info</span>
<span class="label warning">Warning</span>
<span class="label danger">Danger</span>
<span class="label other">Other</span>


        </div>
    </div>
</div>



<?php include_once '../layout/footer.php' ?>
