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
    <style type="text/css" media="screen,print">
        @media print{
            /*#my_second_table >*/
            table tr td,table tr th{
                border-collapse: collapse;
                border: 1px black solid;
                text-align: center;
                font-family: "khmer os";
            }
            #my_first_table tr >th,
            #my_second_table tbody >tr >th:nth-child(1),
            #my_second_table tbody >tr >th:nth-child(2),
            #my_second_table tbody >tr:nth-child(1) >th:nth-child(3)
            {
                -webkit-print-color-adjust:exact;
                background: #C6E0B4!important;
            }
            #my_second_table tbody >tr:nth-child(2) >th:nth-child(3),
            #my_second_table tbody >tr:nth-child(2) >th:nth-child(4),
            #my_second_table tbody >tr:nth-child(2) >th:nth-child(5),
            #my_second_table tbody >tr:nth-child(2) >th:nth-child(6),
            #my_second_table tbody >tr:nth-child(1) >th:nth-child(4)
            {
                -webkit-print-color-adjust:exact;
                background: #F8CBAD!important;
            }
            #my_second_table tbody >tr:nth-child(2) >th:nth-child(7),
            #my_second_table tbody >tr:nth-child(2) >th:nth-child(8),
            #my_second_table tbody >tr:nth-child(2) >th:nth-child(9),
            #my_second_table tbody >tr:nth-child(2) >th:nth-child(10),
            #my_second_table tbody >tr:nth-child(2) >th:nth-child(11),
            #my_second_table tbody >tr:nth-child(1) >th:nth-child(5)
            {
                -webkit-print-color-adjust:exact;
                background: #BDD7EE!important;
            }
        }
    </style>
    <link rel="stylesheet" href="../../print_offline/bootstrap.min.css">
    <div class="container" style="margin-bottom: 100px;">
        <div style="position: absolute; left: 10px; top: 0px;">
            <h1 class="text-primary" style="color: #6467EF!important; font-weight: bold!important; font-size: 25px!important; font-family: 'Time New Roman'!important;"><?= $row_header->comci_name_en ?></h1>
            <p style="font-size: 17px!important; text-decoration: underline; font-family: 'Khmer OS Muol Light','Khmer OS';">តារាងការស្នើរសុំ និង ការទូទាត់-ខែ  ឆ្នាំ2018</p>
        </div>
        <div class="clearfix"></div>
    </div>
    <br>
    <?php 
        
     ?>
    <div class="container-fliud">
        <table id="my_first_table">
            <tbody>
                <tr role="row" class="text-center">
                    <th rowspan="2">N&deg;</th>
                    <th rowspan="2">កាលបរិច្ឆេទ</th>
                    <th rowspan="2" class="text-center">លេខសំណើរ</th>
                    <th rowspan="2">ឈ្មោះនាយកដ្ឋាន</th>
                    <th rowspan="2">ប្រភេទសំនើរ</th>
                    <th rowspan="2">អ្នកស្នើរសុំ</th>
                    <th rowspan="2">ឯកភាពដោយ</th>
                    <th rowspan="2">ទឹកប្រាក់ស្នើរសុំ</th>
                    <th rowspan="2">ទីតាំងទិញ</th>
                    <th rowspan="2">ឈ្មោះអ្នកទិញ</th>
                    <th colspan="5" class="text-center">បរិយាយ</th>
                    <th rowspan="2">តម្លៃរាយ</th>
                    <th rowspan="2">តម្លៃសរុប</th>
                    <th rowspan="2">ចំណាំ</th>
                </tr>
                <tr>
                    <th>ប្រភេទ</th>
                    <th>ឈ្មោះសម្ភារះ</th>
                    <th>ទំហំ/លេខ</th>
                    <th>ចំនួន</th>
                    <th>ឯកតា</th>
                </tr>
                 <?php 
                    $sql1=$connect->query("SELECT A.*,
                        SUM(rei_qty*rei_unit) AS totalAmount,
                        req_date,req_number,
                        res_name,po_name,chn_name,apn_name,dep_name,typr_name,uni_name
                        FROM tbl_acc_request_item AS A 
                        LEFT JOIN tbl_acc_request_form AS B ON A.rei_number=B.req_id
                        LEFT JOIN tbl_acc_request_name_list AS C ON B.req_request_name=C.res_id
                        LEFT JOIN tbl_acc_position AS D ON B.req_position=D.po_id
                        LEFT JOIN tbl_acc_check_name_list AS E ON B.req_check_by=E.chn_id
                        LEFT JOIN tbl_acc_approved_name_list AS F ON B.req_approved_by=F.apn_id
                        LEFT JOIN tbl_acc_department_list AS G ON B.dep_id=G.dep_id
                        LEFT JOIN tbl_acc_type_request_list AS H ON B.type_req_id=H.typr_id
                        LEFT JOIN tbl_acc_unit_list AS I ON A.rei_unit=I.uni_id
                        GROUP BY A.rei_id
                        ");
                    
                    $i=0;
                    while ($row1=mysqli_fetch_object($sql1)) {
                        echo '<tr>';
                            echo '<td class="text-center">'.++$i.'</td>';
                                echo '<td class="text-center">'.$row1->req_date.'</td>';
                                echo '<td class="text-center">'.$row1->req_number.'</td>';
                                echo '<td class="text-center">'.$row1->dep_name.'</td>';
                                echo '<td class="text-center">'.$row1->typr_name.'</td>';
                                echo '<td class="text-center">'.$row1->res_name.'</td>';
                                echo '<td class="text-center">'.$row1->apn_name.'</td>';
                                echo '<td class="text-center">'.number_format($row1->totalAmount,2).' $</td>';
                                echo '<td class="text-center">-</td>';
                                echo '<td class="text-center">-</td>';
                                echo '<td class="text-center">'.$row1->rei_type.'</td>';
                                echo '<td class="text-center">'.$row1->rei_item_name.'</td>';
                                echo '<td class="text-center">'.$row1->rei_size.'</td>';
                                echo '<td class="text-center">'.$row1->rei_qty.'</td>';
                                echo '<td class="text-center">'.$row1->uni_name.'</td>';
                                echo '<td class="text-center">'.$row1->rei_unit.'</td>';
                                echo '<td class="text-center">'.round($row1->rei_qty*$row1->rei_unit,2).' $</td>';
                                echo '<td class="text-center">-</td>';
                        echo '</tr>';
                    }
                 ?>
            </tbody>
        </table>
        <br>
        <br>
        <br>
        <!-- Second Table -->
        <table class="table" id="my_second_table">
            <tbody>
                <tr role="row" class="text-center">
                    <th rowspan="2">N&deg;</th>
                    <th rowspan="2">កាលបរិច្ឆេទ</th>
                    <th colspan="2" class="text-center">លេខសំណើរ</th>
                    <th colspan="4" class="text-center">ពត៌មានពីការទូទាត់</th>
                    <th colspan="5" class="text-center">ពត៌មានអ្នកផ្គត់ផ្គង់</th>
                </tr>
                <tr>
                    <th>PO</th>
                    <th>FR</th>
                    <th>កាលបរិច្ឆេទ</th>
                    <th>ទឹកប្រាក់បានទទួល</th>
                    <th>ចំណាយជាក់ស្តែង</th>
                    <th>ទឹកប្រាក់(ចាយលើស/សល់)</th>
                    <th>ឈ្មោះអ្នកផ្គត់ផ្គង់</th>
                    <th>លេខទូរស័ព្ទ</th>
                    <th>ថ្ងៃទិញ</th>
                    <th>ថ្ងៃដឹក</th>
                    <th>ទីតាំងទិញ</th>
                </tr>
                <?php 
                    $i=0;
                     $sql2=$connect->query("SELECT A.*,
                        SUM(rei_qty*rei_unit) AS totalAmount,
                        req_date,req_number,
                        res_name,po_name,chn_name,apn_name
                        FROM tbl_acc_request_item AS A 
                        LEFT JOIN tbl_acc_request_form AS B ON A.rei_number=B.req_id
                        LEFT JOIN tbl_acc_request_name_list AS C ON B.req_request_name=C.res_id
                        LEFT JOIN tbl_acc_position AS D ON B.req_position=D.po_id
                        LEFT JOIN tbl_acc_check_name_list AS E ON B.req_check_by=E.chn_id
                        LEFT JOIN tbl_acc_approved_name_list AS F ON B.req_approved_by=F.apn_id
                        GROUP BY A.rei_id
                        ");
                    while ($row2=mysqli_fetch_object($sql2)) {
                        echo '<tr>';
                            echo '<td class="text-center">'.++$i.'</td>';
                            echo '<td class="text-center">'.$row2->req_date.'</td>';
                            echo '<td class="text-center">'.$row2->req_number.'</td>';
                            echo '<td class="text-center">'.$row2->req_number.'</td>';
                            echo '<td class="text-center">'.$row2->res_name.'</td>';
                            echo '<td class="text-center">'.$row2->po_name.'</td>';
                            echo '<td class="text-center">'.$row2->chn_name.'</td>';
                            echo '<td class="text-center">'.$row2->apn_name.'</td>';
                            echo '<td class="text-center">-</td>';
                            echo '<td class="text-center">-</td>';
                            echo '<td class="text-center">-</td>';
                            echo '<td class="text-center">-</td>';
                            echo '<td class="text-center">-</td>';
                        echo '</tr>';
                    }
                 ?> 
            </tbody>
        </table>
    </div> 
</body>
</html>
<script src="../../print_offline/bootstrap.min.js"></script>
<script src="../../print_offline/jquery.min.js"></script>
<script type="text/javascript">
    window.onload=function(){
      var printme=document.getElementById('content');
      var wme=window.open("","","width=1200px");
      wme.document.write(printme.innerHTML);
      wme.document.close();
      wme.focus();
      wme.print();
      wme.close();
    }
	setTimeout(function(){
		window.close();
	},1000);
</script>


