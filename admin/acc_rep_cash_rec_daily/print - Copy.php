<?php include_once '../../config/database.php';?>
<?php 
$sql=$connect->query("SELECT comci_name_kh,comci_name_en,comci_name_ch,comci_logo,comci_addr FROM tbl_com_company_info");
    $row_header=mysqli_fetch_object($sql);

 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body id="content">
    <link rel="stylesheet" href="../../print_offline/bootstrap.min.css">
    <style type="text/css">
        *{ font-family: 'Khmer OS Content','Khmer OS'; font-size: 13px; }
        @media print {
            #my_first_table tr>th,#my_fourth_table tr:nth-child(1) >th{
                -webkit-print-color-adjust: exact;
                background-color: #2F75B5!important;
                -webkit-background-color: #2F75B5!important;
                color: #fff!important;
                -webkit-color: #fff!important;
            }
            #my_first_table tr:last-child >td{
                -webkit-print-color-adjust: exact;
                background-color: #DDEBF7!important;
                -webkit-background-color: #DDEBF7!important;
            }

            #my_second_table tr>th,#my_third_table tr:nth-child(1) >th{
                background-color: #FFE699!important;
                -webkit-print-color-adjust: exact;
                -webkit-background-color: #FFE699!important;
            }

            #my_second_table tr:nth-child(1) >th:nth-child(1),
            #my_second_table tr:nth-child(1) >th:nth-child(2),
            #my_second_table tr:nth-child(1) >th:nth-child(4)
            {
                padding: 45px 0px!important;
            } 
            #my_second_table tr:nth-child(4)>td,
            #my_second_table tr:nth-last-child(2) >td,
            #my_third_table tr:last-child >th
            {
                -webkit-print-color-adjust: exact;
                background-color: #FFF2CC!important;
                -webkit-background-color: #FFF2CC!important;
            } 

            #my_third_table tr:nth-child(1) >th:first-child,
            #my_third_table tr:nth-child(1) >th:nth-last-child(2)
            {
                padding: 20px 0px!important;
            }
            #my_third_table tr:nth-child(1) >th:last-child{
                padding: 40px 0px!important;
            }

            #my_fourth_table .my_sub_th{
                -webkit-print-color-adjust: exact;
                background: #DDEBF7!important;
                -webkit-background: #DDEBF7!important;
            }
        }
    </style>
    <div class="container">
        <br>
        <br>
        <div class="row text-center my_title">
            <div class="pull-left">
                <img width="80px" class="img-reponsive" src="../../img/img_logo/<?= $row_header->comci_logo ?>">
            </div>
            <div style="position: absolute; width: 100%; left: 0px; top: 0px; text-align: center;">
                <h1 class="text-primary" style="color: #6467EF!important; font-weight: bold!important; font-size: 25px!important; font-family: 'Time New Roman'!important;"><?= $row_header->comci_name_en ?></h1>
                <p style="font-size: 17px!important; text-decoration: underline; font-family: 'Khmer OS Muol Light','Khmer OS';">របាយការណ៍សាច់ប្រាក់ប្រចាំថ្ងៃ</p>
            </div>
        </div>
    </div><br>
    <br>
    <ul>
            <li>ឈ្មោះក្រុមហ៊ុន  : ឬទ្ធីក្រានីត(សកម្មភាពថ្មក្រានីត)</li>
            <li>កាលបរិច្ឆេទ     : <?php echo date('Y-m-d') ?></li>
        </ul>    
    <div class="container-fliud">
        <!-- First Table -->
        <table class="table table-bordered" id="my_first_table">
            <tbody>
                <tr>
                    <th class="text-center">I- ទិន្នន័យសាច់ប្រាក់ជាក់ស្តែងប្រចាំថ្ងៃ</th>
                    <th class="text-center">សមតុល្យដើមគ្រា</th>
                    <th class="text-center">ទឹកប្រាក់ចូល</th>
                    <th class="text-center">ទឹកប្រាក់ចេញ</th>
                    <th class="text-center">សមតុល្យចុងគ្រា</th>
                </tr>
                <tr>
                  <td class="text-left">1- សាច់ប្រាក់ក្នុងដៃ</td>
                  <td class="text-left"></td>
                  <td class="text-left"></td>
                  <td class="text-left"></td>
                  <td class="text-left"></td>
                </tr>
                <tr>
                  <td class="text-left">សរុបសាច់ប្រាក់ក្រុមហ៊ុនឬទ្ធីក្រានីត</td>
                  <td class="text-left"></td>
                  <td class="text-left"></td>
                  <td class="text-left"></td>
                  <td class="text-left"></td>
                </tr>
            </tbody>
        </table>

        <!-- Second Table -->
        <p style="font-family: 'Khmer OS Muol Light';">II- សង្ខេបប្រតិបត្តិការណ៍ចំណូល និង ការផ្ទេរសាច់ប្រាក់<small> ( បង្ហាញពីទិន្នន័យដែលបានផ្ទេរទឹកប្រាក់ចំណូលចូលទៅធនាគារ )</small></p>
        <table class="table table-bordered" id="my_second_table">
            <tbody>
                <tr>
                    <th rowspan="2" class="text-center" style="width: 150px;">បរិយាយ</th>
                    <th rowspan="2" class="text-center" style="width: 100px;">ទឹកប្រាក់</th>
                    <th colspan="4" class="text-center">ទឹកប្រាក់ផ្ទេរចេញ</th>
                    <th rowspan="2" class="text-center">សមតុល្យចុងគ្រា</th>
                </tr>
                <tr>
                    <th class="text-center" style="width: 100px; ">ធនាគារ Agribank-<br>គណនី Mr.Leng Rithy</th>
                    <th class="text-center" style="width: 100px; ">ធនាគារ Vattanac <br>គណនី Rithy Granite </th>
                    <th class="text-center" style="width: 100px;">លោកនាយក</th>
                    <th class="text-center" style="width: 100px;">លោកនាយក(សាច់ប្រាក់)</th>
                </tr>
                <tr>
                  <td colspan="6" style="padding-left: 400px;">សមតុល្យដើមគ្រា៖</td>
                  <td class="text-center">$</td>
                </tr>
                <tr>
                    <td class="text-center">សរុបទឹកប្រាក់ចំណូលពី ៖</td>
                    <td class="text-center">$</td>
                    <td class="text-center">$</td>
                    <td class="text-center">$</td>
                    <td class="text-center">$</td>
                    <td class="text-center">$</td>
                    <td class="text-center">$</td>
                </tr>
                <tr>
                    <td class="text-center">1.WAMMING</td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                </tr>
                <tr>
                    <td class="text-center">សរុបទឹកប្រាក់ចំណូលពី ៖</td>
                    <td class="text-center">$</td>
                    <td class="text-center">$</td>
                    <td class="text-center">$</td>
                    <td class="text-center">$</td>
                    <td class="text-center">$</td>
                    <td class="text-center">$</td>
                </tr>
                <tr>
                    <td class="text-center">កំណត់សំគាល់ ៖</td>
                    <td colspan="6" class="text-center">$</td>
                </tr>
            </tbody>
        </table>

        <!-- Third Table -->
        <p style="font-family: 'Khmer OS Muol Light';">III- សង្ខេបទឹកប្រាក់ប្រគល់និងទទួលពីលោកនាយក</p>
        <table class="table table-bordered" id="my_third_table">
            <tbody>
                <tr>
                    <th class="text-center" style="width: 200px;">បរិយាយ</th>
                    <th class="text-center" style="width: 150px;">ទឹកប្រាក់លោកនាយកប្រគល់ទៅក្រុមហ៊ុន</th>
                    <th class="text-center" style="width: 150px;">ទឹកប្រាក់លោកនាយកប្រគល់ទៅក្រុមហ៊ុន</th>
                    <th class="text-center" style="width: 150px;">សមតុល្យចុងគ្រា</th>
                    <th rowspan="2" class="text-center" style="width: 250px;">កំណត់សំគាល់</th>
                </tr>
                <tr>
                    <th colspan="3" class="text-center" style="padding-left: 300px;">សមតុល្យដើមគ្រា៖</th>
                    <th class="text-center">$</th>
                </tr>
                <tr>
                    <td class="text-center">1-សាច់ប្រាក់/ចុះបញ្ជី   </td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                </tr>
                <tr>
                    <td class="text-center">2-ធនាគារ NCB/VN   </td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                </tr>
                <tr>
                    <th class="text-center">សរុប</th>
                    <th class="text-center">$</th>
                    <th class="text-center">$</th>
                    <th class="text-center">$</th>
                </tr>
            </tbody>
        </table>
        
        <br>
        <br>
        <!-- Fourth Table -->
        <table class="table table-bordered" id="my_fourth_table">
            <tbody>
                <tr>
                    <th class="text-center" style="width: 20px;">ល.រ</th>
                    <th class="text-center" style="width: 200px;">យោង</th>
                    <th class="text-center" style="width: 350px;">បរិយាយ</th>
                    <th class="text-center" style="width: 150px;">ទឹកប្រាក់ចូល</th>
                    <th class="text-center" style="width: 150px;">ទឹកប្រាក់ចេញ</th>
                    <th class="text-center" style="width: 150px;">សមតុល្យ</th>
                </tr>
                <tr>
                    <th colspan="6" class="text-left my_sub_th">I-ប្រតិបត្តិការណ៍សាច់ប្រាក់ក្នុងដៃ</th>
                </tr>
                <tr>
                    <th colspan="5" class="text-right">សមតុល្យដើមគ្រា៖ </th>
                    <th class="text-center">$ </th>
                </tr>
                <tr>
                    <th colspan="5" class="text-right"></th>
                    <th class="text-center">$ </th>
                </tr>
            </tbody>
        </table>
        
        <br>
        <br>
        <!-- Sign  -->
        <div class="row sign">
            <div class="col-xs-4 text-center">
                <p  style="font-family: 'Khmer OS Muol Light';">រៀបចំដោយ</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black;">
                <p style="font-family: 'Khmer OS Muol Light';">បេឡាករ</p>
            </div>

            <div class="col-xs-4 text-center">
                <p  style="font-family: 'Khmer OS Muol Light';">ត្រួតពិនិត្យដោយ</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black;">
                <p  style="font-family: 'Khmer OS Muol Light';">ប្រធានគណនេយ្យ</p>
            </div>

            <div class="col-xs-4 text-center">
                <p  style="font-family: 'Khmer OS Muol Light';">ត្រួតពិនិត្យនិងឯកភាពដោយ</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black;">
                <p  style="font-family: 'Khmer OS Muol Light';">នាយិកាប្រតិបត្តិ</p>
            </div>
        </div>
    </div> 
</body>
</html>
<script src="../../print_offline/jquery.min.js"></script>
<script type="text/javascript">
    window.onload=function(){
      var printme=document.getElementById('content');
      var wme=window.open("","","width=1200px");
      wme.document.write(printme.outerHTML);
      wme.document.close();
      wme.focus();
      wme.print();
      wme.close();
    }
	setTimeout(function(){
		window.close();
	},1000);
</script>


