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
            <h1 style="font-family: 'Iceberg'">របាយការណ៍ស្តុកថ្មក្រានីត ប្រចាំខែ កុម្ភះ  2023</h1>
            <h1 style="font-family: 'Iceberg'">MONTHLY STOCK STONE GRANITE REPORT 02-2023</h1>
			<hr>
        </div>
    </div>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#activity" data-toggle="tab">Summery Stock</a>
        </li>
        <li role="presentation">
            <a href="#blockinout" data-toggle="tab">Block In & Out</a>
        </li>
        <li role="presentation">
            <a href="#blocksaw" data-toggle="tab">Block Saw</a>
        </li>
        <li role="presentation">
            <a href="#carvedslab" data-toggle="tab">Carved Slab</a>
        </li>
        <li role="presentation">
            <a href="#polished" data-toggle="tab">Polished</a>
        </li>
        <li role="presentation">
            <a href="#cuttosize" data-toggle="tab">Cut to Size</a>
        </li>
        <li role="presentation">
            <a href="#sandblast" data-toggle="tab">Sand Blast</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="active tab-pane" id="activity">
            <table border="2px" width="100%">
                <thead>
                    <tr>
                        <th colspan="12" class="text-center">
                             <h3 style="font-family: 'Times New Roman'">BÁO CÁO KẾT QUẢ KHAI THÁC ĐÁ VÀ TỒN KHO THÁNG <?= date('m') ?> NĂM <?= date('Y') ?></h3>
                        </th>
                    </tr>
                    <tr class="text-center">
                        <th colspan="2" rowspan="2" style="vertical-align: middle; text-align: center;">លរ<br>No</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">បរិយាយ<br>Description</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">កំរិត<br>Grade</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">បរិមាណដើមគ្រា<br>Beginning Quantity M3/M2</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">ផលផលិតបាន<br>In Stock M3/M2</th>
                        <th colspan="4" style="vertical-align: middle; text-align: center;">ផលផលិតបាន<br>In Stock M3/M2</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">សមតុល្យ<br>Endding Balance M3/M2</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">ថ្មជាក់ស្ដែង</th>
                    </tr>
                    <tr>
                        <th style="vertical-align: middle; text-align: center;">កែច្នៃបន្ត<br>For Production</th>
                        <th style="vertical-align: middle; text-align: center;">ថ្មជាក់ស្ដែង</th>
                        <th style="vertical-align: middle; text-align: center;">ថ្មជាក់ស្ដែង</th>
                        <th style="vertical-align: middle; text-align: center;">ថ្មជាក់ស្ដែង</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="tab-pane" id="blockinout">
            <h3>របាយការណ៍ថ្មប្លុក ពីអណ្តូងរ៉ែ ចូលរោងចក្រ​ ខែ​ កុម្ភះ  ឆ្នាំ <?= date('Y') ?></h3>
        </div>
        <div class="tab-pane" id="blocksaw">
            <h3>របាយការណ៍ថ្មប្លុកអារ ប្រចាំថ្ងៃក្នុងរោងចក្រ​ ខែ កុម្ភះ ​ឆ្នាំ <?= date('Y') ?></h3>
        </div>
        <div class="tab-pane" id="carvedslab">
            <h3>របាយការណ៍ថ្មស្លាបដាប់បាន ប្រចាំថ្ងៃក្នុងរោងចក្រ​ ខែ កុម្ភះ ឆ្នាំ <?= date('Y') ?></h3>
        </div>
        <div class="tab-pane" id="polished">
            <h3>របាយការណ៍ថ្មស្លាប ប៉ូលាបានប្រចាំថ្ងៃ ដាក់ចូលប៉ាឡែតក្នុងរោងចក្រ​ ខែ កុម្ភះ ឆ្នាំ <?= date('Y') ?></h3>
        </div>
        <div class="tab-pane" id="cuttosize">
            <h3>របាយការណ៍ថ្មកាត់ខ្នាត ប្រចាំថ្ងៃក្នុងរោងចក្រ​ ខែ ​កុម្ភះ ឆ្នាំ <?= date('Y') ?></h3>
        </div>
        <div class="tab-pane" id="sandblast">
            <h3>របាយការណ៍ថ្មបាញ់ខ្សាច់ ប្រចាំថ្ងៃក្នុងរោងចក្រ​ ខែ កុម្ភះ ឆ្នាំ <?= date('Y') ?></h3>
        </div>
    </div>
</div>



<?php include_once '../layout/footer.php' ?>
