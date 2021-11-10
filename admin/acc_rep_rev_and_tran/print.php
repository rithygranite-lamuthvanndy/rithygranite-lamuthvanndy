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
        *{ font-family: 'Khmer OS Content','Khmer OS'; font-size: 10px; }
        @media print {
            .my_left_table tr:last-child >th:last-child{
                background-color: #C0C0C0!important;
                -webkit-print-background-color: #C0C0C0!important;
            }
            .font_sign{
                font-family: 'Khmer OS Freehand'!important;
            }
            #my_content_table tr>th{
                background-color: #FFE699!important;
                -webkit-print-color-adjust: exact;
                -webkit-background-color: #FFE699!important;
            }
            #my_content_table tr:nth-child(1) >th:nth-child(1),
            #my_content_table tr:nth-child(1) >th:nth-child(2),
            #my_content_table tr:nth-child(1) >th:nth-child(5),
            #my_content_table tr:nth-child(1) >th:nth-child(3){
                padding: 45px 0px!important;
            } 
            #my_content_table tr:nth-child(4) >td:not(:first-child),
            #my_content_table tr:nth-last-child(2) >td:not(:first-child)
            {
                -webkit-print-color-adjust: exact;
                background-color: #FFF2CC!important;
                -webkit-background-color: #FFF2CC!important;
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
                <h1 style="color: #6467EF!important; font-weight: bold!important; font-size: 25px!important; font-family: 'Time New Roman'!important;"><?= $row_header->comci_name_en ?></h1>
                <br>
                <br>
                <br>
                <p  style="font-size: 17px!important; text-decoration: underline; font-family: 'Khmer OS Muol Light','Khmer OS';">របាយការណ៍សង្ខេបប្រតិបត្តិការណ៍ចំណូល និង ការផ្ទេរសាច់ប្រាក់ </p>
                <p  style="font-size: 14px!important; font-family: 'Khmer OS Muol Light','Khmer OS';">(បង្ហាញពីទិន្នន័យដែលបានផ្ទេរទឹកប្រាក់ចំណូលចូលទៅធនាគារ )</p>
            </div>
        </div>
    </div><br>
    <br>
    <ul>
        <li>ឈ្មោះក្រុមហ៊ុន  : </li>
        <li>កាលបរិច្ឆេទ     : </li>
    </ul>    
    <br> 
    <div class="container-fliud">
        <!-- my_content_table Table -->
        <table class="table table-bordered" id="my_content_table">
            <tbody>
                <tr>
                    <th rowspan="2" class="text-center" style="width: 150px;">បរិយាយ</th>
                    <th rowspan="2" class="text-center" style="width: 150px;">Code</th>
                    <th rowspan="2" class="text-center" style="width: 100px;">ទឹកប្រាក់</th>
                    <th colspan="4" class="text-center">ទឹកប្រាក់ផ្ទេរចេញ</th>
                    <th rowspan="2" class="text-center" style="width: 150px;">សមតុល្យចុងគ្រា</th>
                </tr>
                <tr>
                    <th class="text-center" style="width: 100px; ">ធនាគារ Agribank-<br>គណនី Mr.Leng Rithy</th>
                    <th class="text-center" style="width: 100px; ">ធនាគារ Vattanac <br>គណនី Rithy Granite </th>
                    <th class="text-center" style="width: 100px;">លោកនាយក <br> (ធនាគារ NCB/VN)</th>
                    <th class="text-center" style="width: 100px;">លោកនាយក <br> (សាច់ប្រាក់)</th>
                </tr>
                <tr>
                  <td colspan="7" class="text-right" >សមតុល្យដើមគ្រា៖</td>
                  <td class="text-left">$</td>
                </tr>
                <tr>
                    <td class="text-left">សរុបទឹកប្រាក់ចំណូលពី ៖</td>
                    <td class="text-center">$</td>
                    <td class="text-center">$</td>
                    <td class="text-center">$</td>
                    <td class="text-center">$</td>
                    <td class="text-center">$</td>
                    <td class="text-center">$</td>
                    <td class="text-center">$</td>
                </tr>
                <tr>
                    <td class="text-left">1.WAMMING</td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                </tr>
                <tr>
                    <td class="text-left">សរុបទឹកប្រាក់ចំណូលពី ៖</td>
                    <td class="text-center">$</td>
                    <td class="text-center">$</td>
                    <td class="text-center">$</td>
                    <td class="text-center">$</td>
                    <td class="text-center">$</td>
                    <td class="text-center">$</td>
                    <td class="text-center">$</td>
                </tr>
                <tr>
                    <td class="text-left">កំណត់សំគាល់ ៖</td>
                    <td colspan="7" class="text-right">$</td>
                </tr>
            </tbody>
        </table>
        
        <br>
        <br>
        <!-- font_Sign  -->
        <div class="row">
            <div class="col-xs-3 text-center">
                <p class="font_sign">រៀបចំដោយ</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black;">
                <p class="font_sign">បេឡាករ</p>
            </div>

            <div class="col-xs-3 text-center">
                <p class="font_sign">ត្រួតពិនិត្យដោយ</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black;">
                <p class="font_sign">ប្រធានគណនេយ្យ</p>
            </div>

            <div class="col-xs-3 text-center">
                <p class="font_sign">ត្រួតពិនិត្យនិងឯកភាពដោយ</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black;">
                <p class="font_sign">ប្រធានហរិញ្ញវត្ថុ</p>
            </div>
             <div class="col-xs-3 text-center">
                <p class="font_sign">ឯកភាពដោយ</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 0.5px solid black;">
                <p class="font_sign">នាយិកាប្រតិបត្តិ</p>
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


