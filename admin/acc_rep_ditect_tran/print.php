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
        *{ 
            font-family: 'Khmer OS Content','Khmer OS'; 
            font-size: 13px; 
            -webkit-print-color-adjust: exact;
        }
        @media print {
            #my_first_table tr >th:not(:first-child),
            #my_fourth_table tr:nth-child(1) >th
            {
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
            #my_second_table{
                font-size: 8px!important;
            }
            #my_second_table tr:nth-child(1) >th:nth-child(1),
            #my_second_table tr:nth-child(1) >th:nth-child(2),
            #my_second_table tr:nth-child(1) >th:nth-child(3),
            #my_second_table tr:nth-child(1) >th:nth-child(4),
            #my_second_table tr:nth-child(1) >th:nth-child(5),
            #my_second_table tr:nth-child(2) >th:nth-child(1),
            #my_second_table tr:nth-child(2) >th:nth-child(2),
            #my_second_table tr:nth-child(2) >th:nth-child(3),
            #my_second_table tr:nth-child(2) >th:nth-child(4)
            {
                background-color: #F4B084!important;
            }
            #my_second_table tr:nth-child(1) >th:nth-child(6),
            #my_second_table tr:nth-child(1) >th:nth-child(7),
            #my_second_table tr:nth-child(2) >th:nth-child(5),
            #my_second_table tr:nth-child(2) >th:nth-child(6),
            #my_second_table tr:nth-child(2) >th:nth-child(7)
            {
                background-color: #8497B0!important;
            }
            #my_second_table tr:nth-child(2) >th{
                padding: 5px!important;
            }
            #my_second_table tr:nth-child(1) >th:nth-child(8){background-color: #A9D08E!important;}
            #my_second_table tr:nth-child(1) >th:nth-child(9){background-color: #E2EFDA!important;}

            #my_second_table tr:nth-child(1) >th:nth-child(1),
            #my_second_table tr:nth-child(1) >th:nth-child(2),
            #my_second_table tr:nth-child(1) >th:nth-child(3),
            #my_second_table tr:nth-child(1) >th:nth-child(5),
            #my_second_table tr:nth-child(1) >th:nth-child(7),
            #my_second_table tr:nth-child(1) >th:nth-child(8),
            #my_second_table tr:nth-child(1) >th:nth-child(9)
            {
                 padding: 45px 0px!important;
            }

            #my_second_table tr >td:nth-child(3){
                background: #FFF2CC!important;
            }
            #my_second_table tr >td:nth-child(4),
            #my_second_table tr >td:nth-child(5),
            #my_second_table tr >td:nth-child(6),
            #my_second_table tr >td:nth-child(7),
            #my_second_table tr >td:nth-child(8)
            {
                background: #FCE4D6!important;
            }
            #my_second_table tr >td:nth-child(9),
            #my_second_table tr >td:nth-child(10),
            #my_second_table tr >td:nth-child(11),
            #my_second_table tr >td:nth-child(12)
            {
                background: #D6DCE4!important;
            }
            #my_second_table tr >td:nth-child(13){
                background: #E2EFDA!important;
            }

            #my_third_table tr:nth-child(1) >th:first-child,#my_third_table tr:nth-child(1) >th:nth-last-child(2){
                padding: 20px 0px!important;
            }
            #my_third_table tr:nth-child(1) >th:last-child{
                padding: 40px 0px!important;
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
                <p style="font-size: 17px!important; text-decoration: underline; font-family: 'Khmer OS Muol Light','Khmer OS';">តារាងតាមដានទឹកប្រាក់ប្រគល់ & ទទួលសាច់ប្រាក់ពីលោកនាយក</p>
            </div>
        </div>
    </div><br>
    <br>
    <ul>
            <li>ឈ្មោះក្រុមហ៊ុន  : </li>
            <li>កាលបរិច្ឆេទ     : </li>
        </ul>    
    <div class="container-fliud">
        <!-- First Table -->
        <table class="table table-bordered" id="my_first_table">
            <tbody>
                <tr>
                    <th class="text-left">I- ទិន្នន័យសង្ខេបទឹកប្រាក់ប្រគល់ & ទទួល</th>
                    <th class="text-center">សមតុល្យដើមគ្រា</th>
                    <th class="text-center">ទឹកប្រាក់ចូល</th>
                    <th class="text-center">ទឹកប្រាក់ចេញ</th>
                    <th class="text-center">សមតុល្យចុងគ្រា</th>
                </tr>
                <tr>
                  <td class="text-left">1- សាច់ប្រាក់/ចុះបញ្ជី</td>
                  <td class="text-left"></td>
                  <td class="text-left"></td>
                  <td class="text-left"></td>
                  <td class="text-left"></td>
                </tr>
                <tr>
                  <td class="text-left">2- ធនាគារ NCB / VN</td>
                  <td class="text-left"></td>
                  <td class="text-left"></td>
                  <td class="text-left"></td>
                  <td class="text-left"></td>
                </tr>
                <tr>
                  <td colspan="4" class="text-right">សាច់ប្រាក់ផ្ទាល់ខ្លួនលោកនាយក ៖</td>
                  <td class="text-left">$</td>
                </tr>
                <tr>
                  <td colspan="4" class="text-right">សរុបសាច់ប្រាក់លោកនាយក ៖</td>
                  <td class="text-left">$</td>
                </tr>
            </tbody>
        </table>
        <br>
        <!-- Second Table -->
        <p style="font-family: 'Khmer OS Muol Light';">II- ទិន្នន័យលំអិតពីប្រតិបត្តិការសាច់ប្រាក់ (CASH)</p>
        <table class="table table-bordered" id="my_second_table">
            <tbody>
                <tr>
                    <th rowspan="2" class="text-center" style="width: 15px;">ល.រ</th>
                    <th rowspan="2" class="text-center" style="width: 100px;">កាលបរិច្ឆេទ</th>
                    <th rowspan="2" class="text-center" style="width: 100px;">ទឹកប្រាក់សរុប <br> (3)=(1)-(2)</th>
                    <th colspan="4" class="text-center">ទឹកប្រាក់លោកនាយកទទួលពីក្រុមហ៊ុន</th>
                    <th rowspan="2" class="text-center" style="width: 100px;">សរុបទឹកប្រាក់ប្រគល់ <br> (1)</th>
                    <th colspan="3" class="text-center">ទឹកប្រាក់លោកនាយកប្រគល់ទៅក្រុមហ៊ុន</th>
                    <th rowspan="2" class="text-center">សរុបទឹកប្រាក់ប្រគល់ <br> (2)</th>
                    <th rowspan="2" class="text-center" style="width: 50px;">ផ្សេងៗ</th>
                    <th rowspan="2" class="text-center" style="width: 50px;">សំំគាល់</th>
                </tr>
                <tr>
                    <th class="text-center">Ms.bopha</th>
                    <th class="text-center">Ms.Da</th>
                    <th class="text-center">Mr.Lak</th>
                    <th class="text-center">ផ្សេងៗ</th>
                    <th class="text-center">សំណើរក្រុមហ៊ុន <br> (ក្រានីត)</th>
                    <th class="text-center">សំណើរក្រុមហ៊ុន <br>  (ក្រូចថ្លុង)</th>
                    <th class="text-center">សំណើរក្រុមហ៊ុន <br> (កៅស៊ូ)</th>
                </tr>
                <tr>
                    <th colspan="2" class="text-left">ទឹកប្រាក់ដើមគ្រា ៖</th>
                    <th  class="text-center">A</th>
                    <th  class="text-center">A</th>
                    <th  class="text-center">A</th>
                    <th  class="text-center">A</th>
                    <th  class="text-center">A</th>
                    <th  class="text-center">A</th>
                    <th  class="text-center">A</th>
                    <th  class="text-center">A</th>
                    <th  class="text-center">A</th>
                    <th  class="text-center">A</th>
                    <th  class="text-center">A</th>
                    <th  class="text-center">A</th>
                </tr>
                <tr>
                    <td  class="text-center">1</td>
                    <td  class="text-center">A</td>
                    <td  class="text-center">A</td>
                    <td  class="text-center">A</td>
                    <td  class="text-center">A</td>
                    <td  class="text-center">A</td>
                    <td  class="text-center">A</td>
                    <td  class="text-center">A</td>
                    <td  class="text-center">A</td>
                    <td  class="text-center">A</td>
                    <td  class="text-center">A</td>
                    <td  class="text-center">A</td>
                    <td  class="text-center">A</td>
                    <td  class="text-center">A</td>
                </tr>
            </tbody>
        </table>

        <!-- Third Table -->
        <p style="font-family: 'Khmer OS Muol Light';">III- ទិន្នន័យលំអិតពីប្រតិបត្តិការធនាគារ (NCB/VN )</p>
        <table class="table table-bordered" id="my_second_table">
            <tbody>
                <tr>
                    <th rowspan="2" class="text-center" style="width: 15px;">ល.រ</th>
                    <th rowspan="2" class="text-center" style="width: 100px;">កាលបរិច្ឆេទ</th>
                    <th rowspan="2" class="text-center" style="width: 100px;">ទឹកប្រាក់សរុប <br> (3)=(1)-(2)</th>
                    <th colspan="4" class="text-center">ទឹកប្រាក់លោកនាយកទទួលពីក្រុមហ៊ុន</th>
                    <th rowspan="2" class="text-center" style="width: 100px;">សរុបទឹកប្រាក់ប្រគល់ <br> (1)</th>
                    <th colspan="3" class="text-center">ទឹកប្រាក់លោកនាយកប្រគល់ទៅក្រុមហ៊ុន</th>
                    <th rowspan="2" class="text-center">សរុបទឹកប្រាក់ប្រគល់ <br> (2)</th>
                    <th rowspan="2" class="text-center" style="width: 50px;">ផ្សេងៗ</th>
                    <th rowspan="2" class="text-center" style="width: 50px;">សំំគាល់</th>
                </tr>
                <tr>
                    <th class="text-center">Ms.bopha</th>
                    <th class="text-center">Ms.Da</th>
                    <th class="text-center">Mr.Lak</th>
                    <th class="text-center">ផ្សេងៗ</th>
                    <th class="text-center">សំណើរក្រុមហ៊ុន <br> (ក្រានីត)</th>
                    <th class="text-center">សំណើរក្រុមហ៊ុន <br>  (ក្រូចថ្លុង)</th>
                    <th class="text-center">សំណើរក្រុមហ៊ុន <br> (កៅស៊ូ)</th>
                </tr>
                <tr>
                    <th colspan="2" class="text-left">ទឹកប្រាក់ដើមគ្រា ៖</th>
                    <th  class="text-center">A</th>
                    <th  class="text-center">A</th>
                    <th  class="text-center">A</th>
                    <th  class="text-center">A</th>
                    <th  class="text-center">A</th>
                    <th  class="text-center">A</th>
                    <th  class="text-center">A</th>
                    <th  class="text-center">A</th>
                    <th  class="text-center">A</th>
                    <th  class="text-center">A</th>
                    <th  class="text-center">A</th>
                    <th  class="text-center">A</th>
                </tr>
                <tr>
                    <td  class="text-center">1</td>
                    <td  class="text-center">A</td>
                    <td  class="text-center">A</td>
                    <td  class="text-center">A</td>
                    <td  class="text-center">A</td>
                    <td  class="text-center">A</td>
                    <td  class="text-center">A</td>
                    <td  class="text-center">A</td>
                    <td  class="text-center">A</td>
                    <td  class="text-center">A</td>
                    <td  class="text-center">A</td>
                    <td  class="text-center">A</td>
                    <td  class="text-center">A</td>
                    <td  class="text-center">A</td>
                </tr>
            </tbody>
        </table>
        
        <br>
        <br>
        <!-- Fourth Table -->
        <table class="table table-bordered" id="my_fourth_table">
            <tbody>
                <tr>
                    <th class="text-center">ល.រ</th>
                    <th colspan="3" class="text-center">យោង</th>
                    <th class="text-center">បរិយាយ</th>
                    <th class="text-center">ទឹកប្រាក់ចូល</th>
                    <th class="text-center">ទឹកប្រាក់ចេញ</th>
                    <th class="text-center">សមតុល្យ</th>
                </tr>
                <tr>
                    <th colspan="7" class="text-right">សមតុល្យដើមគ្រា៖ </th>
                    <th class="text-center">$</th>
                </tr>
                <tr>
                    <th class="text-center">1 </th>
                    <th class="text-center">2 </th>
                    <th class="text-center">3 </th>
                    <th class="text-center">4 </th>
                    <th class="text-center">4 </th>
                    <th class="text-center">4 </th>
                    <th class="text-center">4 </th>
                    <th class="text-center">4 </th>
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


