<?php 
    $layout_title = "Welcome Granite Inventory";
    $menu_active =145;
    $left_active =0;
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12 text-center">
            <link href="https://fonts.googleapis.com/css?family=Iceberg" rel="stylesheet">
            <h1 style="font-family: 'Iceberg'">Welcome: Inventory System</h1>
			<hr>
        </div>
    </div>
        <table border="2px" width="100%">
            <thead>
                <tr>
                    <th colspan="12" class="text-center">
                         <h3 style="font-family: 'Times New Roman'">BÁO CÁO KẾT QUẢ KHAI THÁC ĐÁ VÀ TỒN KHO THÁNG 09 NĂM 2021</h3>
                    </th>
                </tr>
                <tr class="text-center">
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






<?php include_once '../layout/footer.php' ?>
