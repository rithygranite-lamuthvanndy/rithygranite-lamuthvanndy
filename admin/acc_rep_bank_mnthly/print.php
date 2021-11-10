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


            #my_content_table tr:first-child >th, 
            #my_content_table tr:last-child >th
            {
                -webkit-print-color-adjust: exact;
                background-color: #EEECE1!important;
               /* color: #fff!important;
                -webkit-color: #fff!important;*/
            }
            #my_content_table tr:nth-child(3) >th{
                -webkit-print-color-adjust: exact;
                background-color: #FFFF00!important;
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
                <h1 style="margin: auto!important; color: #6467EF!important; font-weight: bold!important; font-size: 25px!important; font-family: 'Time New Roman'!important;"><?= $row_header->comci_name_en ?></h1>
                <p style="margin: auto!important;font-size: 17px!important;">Head Office Rithy Group</p>
                <p  style="margin: auto!important;font-size: 17px!important; text-decoration: underline; font-family: 'Khmer OS Muol Light','Khmer OS';">BANK RECORD កំណត់ត្រាធនាគារ</p>
                <p  style="margin: auto!important;font-size: 17px!important; text-decoration: underline; font-family: 'Khmer OS Muol Light','Khmer OS';">(Internal) <br> (ប្រើប្រាស់ផ្ទៃក្នុង)</p>
            </div>
        </div>
    </div><br>
    <br>
    <!-- Table Title -->
    <div class="row">
        <div class="col-xs-4">
            <table class="table table-bordered my_left_table">
                <tbody>
                    <tr>
                        <th class="text-left">Bank Name: <br>ឈ្មោះធនាគារ</th>
                        <th class="text-center">ABC</th>
                    </tr>
                    <tr>
                        <th class="text-left">Account Name: <br>ឈ្មោះគណនី</th>
                        <th class="text-center">ABC</th>
                    </tr>
                    <tr>
                        <th class="text-left">Balance Bank : <br>សមតុល្យធនាគារ</th>
                        <th class="text-center">ABC</th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-xs-4" style="float: right;">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th class="text-left">Date: <br>ថ្ងៃទី ខែ ឆ្នាំ :</th>
                        <th class="text-center">ABC</th>
                    </tr>
                    <tr>
                        <th class="text-left">Year: <br>ឆ្នាំ :</th>
                        <th class="text-center">ABC</th>
                    </tr>
                    <tr>
                        <th class="text-left">Account # : <br>លេខគណនី</th>
                        <th class="text-center">ABC</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>  
    <br> 
    <div class="container-fliud">
        <!-- my_content_table Table -->
        <table class="table table-bordered" id="my_content_table">
            <tbody>
                <tr>
                    <th class="text-center">Receipt NT : <br> លេខប័ណ្ណទទួលប្រាក់</th>
                    <th class="text-center">Voucher NT: <br> លេខសក្ខីប័ត្រ</th>
                    <th class="text-center">Payer/Payee : <br> ឈ្មោះអ្នកប្រគល់ប្រាក់ឬអ្នកទទួលប្រាក់</th>
                    <th class="text-center">Description & Explanation : <br> បរិយាយ និង ពន្យល់</th>
                    <th class="text-center">Received (USD) : <br> ទទូលប្រាក់</th>
                    <th class="text-center">Outstanding Cheque Deposit:  <br> Cheque ដែលយើងទទូលហើយមិនទាន់យកទៅដាក់នៅធនាគារ</th>
                    <th class="text-center">Deposit Cash/Cheque: <br> សាច់ប្រាក់ និង Cheque ដែលយើងយកទៅដាក់នៅធនាគារ</th>
                    <th class="text-center">Payament per Bank : <br> ការទូទាត់តាមធនាគាររឺដក់ប្រាក់ពីធនាគារ</th>
                    <th class="text-center">Amount (USD) : <br> ចំនួនទឹកប្រាក់ (ដុល្លារអាមេរិក)</th>
                </tr>
                <tr>
                    <th colspan="8" class="text-right">Beginning balnace <br> សមតុល្យដើមគ្រា</th>
                    <th class="text-right"> $</th>
                </tr>
                <tr>
                    <th colspan="9" class="text-center">ខែ តុលា-2018</th>
                </tr>
                <tr>
                    <td class="text-center">A</td>
                    <td class="text-center">A</td>
                    <td class="text-center">A</td>
                    <td class="text-center">A</td>
                    <td class="text-center">A</td>
                    <td class="text-center">A</td>
                    <td class="text-center">A</td>
                    <td class="text-center">A</td>
                    <td class="text-center">A</td>
                </tr>
                <tr>
                    <th colspan="5" class="text-right">សរុប (ដុល្លារអាមេរិក) ខែ តុលា-2018</th>
                    <th class="text-center">$</th>
                    <th class="text-center">$</th>
                    <th class="text-center">$</th>
                    <th class="text-center">$</th>
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


