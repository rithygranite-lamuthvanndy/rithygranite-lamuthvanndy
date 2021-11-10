<?php 
    include_once '../../config/database.php';
?>
<?php 

if(isset($_GET['p_date_start'])&&isset($_GET['p_date_end'])){
    $v_date_start=$_GET['p_date_start'];
    $v_date_end=$_GET['p_date_end'];
    $condition="stsadj_date_record BETWEEN '$v_date_start' 
                AND '$v_date_end' 
                AND stsadj_status={$_SESSION['status']}";
    $sql="SELECT
        A.*,C.*,B.*
        FROM tbl_st_stock_adjustment AS A 
        LEFT JOIN tbl_st_stock_adjustment_detail AS B ON A.stsadj_id=B.stsadj_id
        LEFT JOIN tbl_st_product_name AS C On B.pro_id=C.stpron_id
        WHERE {$condition} GROUP BY B.id";
        $get_data=$connect->query($sql);


    $v_sql_beg="
            SELECT IFNULL(SUM(qty_adjust),0) AS old_qty
            FROM tbl_st_stock_adjustment AS AA 
            LEFT JOIN tbl_st_stock_adjustment_detail AS BB ON AA.stsadj_id=BB.stsadj_id
            WHERE AA.stsadj_date_record<'{$v_date_start}'";
    $get_data_beg=$connect->query($v_sql_beg);
}   
 ?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    <link href='https://fonts.googleapis.com/css?family=Khmer|DM+Serif+Display&display=swap' rel='stylesheet' type='text/css'>
    <style type="text/css">
        *{ 
            font-size: 13px; 
            font-family: 'khmer','Time New Reman';
            -webkit-print-color-adjust: exact;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table >tbody, th, td {
            text-align: center!important;
            border: 1px solid black!important;
            white-space: nowrap;
            padding: 5px 10px!important;
        }
        table >tbody tr th{
            font-family: 'Khmer Moul'!important; 
            font-weight: bold!important;
        }
        table >tbody tr:first-child th{width: 2px;}
        
        table tbody tr:first-child td,
        table tbody tr td:nth-child(5),
        table tbody tr:nth-child(3)
        {
            background: #DDEBF7!important;
        }
        table tbody tr td:nth-child(7){
            background: #E7E6E6!important;
        }
        table tbody tr:first-child td{
            font-weight: bold;
        }
        .main_border h3,.main_border h4{
            font-family: 'Khmer Moul'!important; 
            text-decoration: underline;
            font-weight: bold;
            text-align: center;
        }

        .myqty{
            font-weight: bold;
        }
        .myprice,
        table tbody tr td:nth-child(5)
        {
            font-weight: bold;
            color: #FF0000!important;
        }
        .myprice:before
        {
            content: '$ ';
            padding-right: 5px;
        }
        .myprice_vn:after{
            content: 'd';
            text-decoration: underline;
            padding-left: 5px;
        }
    </style>
</head>
    <link rel="stylesheet" href="../../print_offline/bootstrap.min.css">
    <script src="../../print_offline/jquery.min.js"></script>
<body>
    <div class="main_border">
        <?php 
            if($_SESSION['status']==6){
                echo '<h3>តារាងស្ដុកឧបករណ៍ជាង នឹង ម៉ាស៊ីនខា្នតតូច</h3>';
            }
            else if($_SESSION['status']==2){
                echo '<h3>តារាងកែប្រែស្ដុកសំភារៈផ្កត់ផ្គង់រោងចក្រប្រចាំថ្ងៃ</h3>';
            }
         ?>
        <h4>Bảng Kho Thiết Bị Và Máy Kích Thước Nhỏ</h4>
        <br> 
        <!-- Table Decription -->
        <table>
            <tbody>
                <tr>
                    <th rowspan="2">N</th>
                    <th>ថ្ងៃខែ</th>
                    <th>លេខប័ណ្ណ</th>
                    <th>កូដ</th>
                    <th colspan="2">ឈ្មោះ/Tền</th>
                    <th>ចំនួន</th>
                    <th>សំគាល់</th>
                </tr>
                <tr>
                    <th>Ngày</th>
                    <th>Số Đề Nghị</th>
                    <th>Mã</th>
                    <th>VN</th>
                    <th>KH</th>
                    <th>Đơn vị</th>
                    <th>Ghi chú</th>
                </tr>
                <tr>
                    <td colspan="6">TOTAL:</td>
                    <td><?= mysqli_fetch_object($get_data_beg)->old_qty ?></td>
                    <td colspan="5"></td>
                </tr>
                <?php
                    $i = 0;
                    while ($row = mysqli_fetch_object($get_data)) {
                        echo '<tr>';
                            echo '<td>'.sprintf('%02d',(++$i)).'</td>';
                            echo '<td>'.date('d/M/Y',strtotime($row->stsadj_date_record)).'</td>';
                            echo '<td>'.$row->stsadj_code.'</td>';
                            echo '<td>'.$row->stpron_code.'</td>';
                            echo '<td>'.$row->stpron_name_vn.'</td>';
                            echo '<td>'.$row->stpron_name_kh.'</td>';
                            echo '<td class="myqty">'.$row->qty_adjust.'</td>';
                            echo '<td>'.$row->stsadj_note.'</td>';
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
    <script type="text/javascript">
       $(document).ready(function () {
            window.print();
        });
        setTimeout(function(){
           window.close();
        },1000);
    </script>
</body>
</html>


