<?php 
    $layout_title = "Welcome";
    $menu_active =13;
    $left_active=null;
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2 style="font-family: 'Khmer OS';"><i class="fa fa-fw fa-map-marker"></i> តារាងតាមដានសំណើរខែ <?= date('m') ?> ឆ្នាំ <?= date('Y') ?> (ការដ្ឋាន)</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <h4 style="font-family: 'Khmer OS';"> I- តារាងសង្ខេបសំណើរ</h2>
            <h4 style="font-family: 'Khmer OS';"> 1.1- តារាងសំណើររួម</h2>
        </div>
    </div>
    <div style="border: 2px dashed black;">
        <table border="2px" width="100%">
            <thead>
                <tr>
                    <th colspan="12">
                         <h3 style="font-family: 'Times New Roman'">BÁO CÁO KẾT QUẢ KHAI THÁC ĐÁ VÀ TỒN KHO THÁNG 09 NĂM 2021</h3>
                    </th>
                </tr>
                <tr>
                    <th colspan="2" rowspan="2">លរ No</th>
                    <th rowspan="2">បរិយាយ Description</th>
                    <th rowspan="2">កំរិត Grade</th>
                    <th rowspan="2">បរិមាណដើមគ្រា Beginning Quantity M3/M2</th>
                    <th rowspan="2">ផលផលិតបាន In Stock M3/M2</th>
                    <th colspan="4">ផលផលិតបាន In Stock M3/M2</th>
                    <th rowspan="2">សមតុល្យ Endding Balance M3/M2</th>
                    <th rowspan="2">ថ្មជាក់ស្ដែង</th>
                </tr>
                <tr>
                    <th>កែច្នៃបន្ត For Production</th>
                    <th>ថ្មជាក់ស្ដែង</th>
                    <th>ថ្មជាក់ស្ដែង</th>
                    <th>ថ្មជាក់ស្ដែង</th>
                </tr>
            </thead>
        </table>

    </div> 
</div>






<?php include_once '../layout/footer.php' ?>
