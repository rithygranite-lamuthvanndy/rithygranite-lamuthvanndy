<?php
include_once '../../config/database.php';
?>
<?php

if (isset($_GET['p_date_start']) && isset($_GET['p_date_end'])) {
    $v_date_start = $_GET['p_date_start'];
    $v_date_end = $_GET['p_date_end'];
    $condition = "stsout_date_out BETWEEN '$v_date_start' 
                AND '$v_date_end' 
                AND stock_status={$_SESSION['status']}";
    $sql = "SELECT
        A.*,C.*,B.stman_name,stun_name,stpron_code,stpron_name_vn,stpron_name_kh,
        F.name_vn AS track_machine,
        (
            CASE C.locaton_id
                WHEN 0 THEN 'រោងចក្រ'
                WHEN 1 THEN 'រណ្ដៅ'
                WHEN 2 THEN 'រោងជាង'
            END 
        ) AS location_name
        FROM tbl_st_stock_out AS A 
        LEFT JOIN tbl_st_manager_list AS B ON A.stsout_man_id=B.stman_id
        LEFT JOIN tbl_st_stock_out_detail AS C ON A.stsout_id=C.stsout_id
        LEFT JOIN tbl_st_unit_list AS D On C.unit_id=D.stun_id
        LEFT JOIN tbl_st_product_name AS E On C.pro_id=E.stpron_id
        LEFT JOIN tbl_st_track_machine_list AS F ON C.track_mac_id=F.id
        WHERE {$condition} GROUP BY C.std_id,C.stsout_id";
    $get_data = $connect->query($sql);


    $v_sql_beg = "
            SELECT IFNULL(SUM(out_qty),0) AS old_qty
            FROM tbl_st_stock_out AS AA 
            LEFT JOIN tbl_st_stock_out_detail AS BB ON AA.stsout_id=BB.stsout_id
            WHERE AA.stsout_date_out<'{$v_date_start}'
            AND stock_status={$_SESSION['status']}";
    $get_data_beg = $connect->query($v_sql_beg);
}
?>
<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta charset="utf-8">
    <link href='https://fonts.googleapis.com/css?family=Khmer|DM+Serif+Display&display=swap' rel='stylesheet' type='text/css'>
    <style type="text/css">
        * {
            font-size: 13px;
            font-family: 'khmer', 'Time New Reman';
            -webkit-print-color-adjust: exact;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table>tbody,
        th,
        td {
            text-align: center !important;
            border: 1px solid black !important;
            white-space: nowrap;
            padding: 5px 10px !important;
        }

        table>tbody tr th {
            font-family: 'Khmer Moul' !important;
            font-weight: bold !important;
        }

        table>tbody tr:first-child th {
            width: 2px;
        }

        table tbody tr td:nth-child(2),
        table tbody tr td:nth-child(3),
        table tbody tr td:nth-child(4),
        table tbody tr td:nth-child(5) {
            width: 100px !important;
        }

        table tbody tr:first-child td,
        table tbody tr td:nth-child(5),
        table tbody tr:nth-child(3) {
            background: #DDEBF7 !important;
        }

        table tbody tr td:nth-child(7) {
            background: #E7E6E6 !important;
        }

        table tbody tr:first-child td {
            font-weight: bold;
        }

        .main_border h3,
        .main_border h4 {
            font-family: 'Khmer Moul' !important;
            text-decoration: underline;
            font-weight: bold;
            text-align: center;
        }

        .myqty {
            font-weight: bold;
        }

        .myprice,
        table tbody tr td:nth-child(5) {
            font-weight: bold;
            color: #FF0000 !important;
        }

        .myprice:before {
            content: '$ ';
            padding-right: 5px;
        }

        .myprice_vn:after {
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
        <h3>តារាងបញ្ចេញស្ដុកប្រេងប្រចាំថ្ងៃ</h3>
        <h4>Bảng Xuất Kho dầu Hàng Ngày</h4>
        <br>
        <!-- Table Decription -->
        <table>
            <tbody>
                <tr>
                    <th rowspan="2">N</th>
                    <th>ថ្ងៃខែ</th>
                    <th>លេខប័ណ្ណ</th>
                    <th>អ្នកទទួល</th>
                    <th>កូដ</th>
                    <th colspan="2">ឈ្មោះ/Tền</th>
                    <th>តំបន់</th>
                    <th>ចំនួន</th>
                    <th>ឯកតា</th>
                    <th>ម៉ាស៊ីន/គ្រឿងចក្រ</th>
                    <th>សំគាល់</th>
                </tr>
                <tr>
                    <th>Ngày</th>
                    <th>Số Đề Nghị</th>
                    <th>Người Nhận</th>
                    <th>Mã</th>
                    <th>VN</th>
                    <th>KH</th>
                    <th>Khu vực</th>
                    <th>số lượng</th>
                    <th>Đơn vị</th>
                    <th>Máy móc / máy móc</th>
                    <th>Ghi chú</th>
                </tr>
                <tr>
                    <td colspan="8">TOTAL:</td>
                    <td><?= mysqli_fetch_object($get_data_beg)->old_qty ?></td>
                    <td colspan="6"></td>
                </tr>
                <?php
                $i = 0;
                while ($row = mysqli_fetch_object($get_data)) {
                    echo '<tr>';
                    echo '<td>' . sprintf('%02d', (++$i)) . '</td>';
                    echo '<td>' . date('d/M/Y', strtotime($row->stsout_date_out)) . '</td>';
                    echo '<td>' . $row->stsout_letter_no . '</td>';
                    echo '<td>' . $row->stman_name . '</td>';
                    echo '<td>' . $row->stpron_code . '</td>';
                    echo '<td>' . $row->stpron_name_vn . '</td>';
                    echo '<td>' . $row->stpron_name_kh . '</td>';
                    echo '<td>' . $row->location_name . '</td>';
                    echo '<td class="myqty">' . $row->out_qty . '</td>';
                    echo '<td>' . $row->stun_name . '</td>';
                    echo '<td>' . $row->track_machine . '</td>';
                    echo '<td>' . $row->stsout_note . '</td>';
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