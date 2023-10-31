<?php include_once '../../config/database.php';?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../print_offline/bootstrap.min.css">
    <script src="../../print_offline/jquery.min.js"></script> 
    <link href="../../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <style>
        table, td, th{
            border: 1px solid;
        }
        table{
            width: 100%;
            border-collapse: collapse;
        }
        *{ font-family: 'khmer os content'; font-size: 12px; }
        @media print{
            #my_green{
                background-color: #DDEBF7 !important;
                -webkit-print-color-adjust: exact; 
            }
            #my_pink{
                background-color: #DDEBF7 !important;
                -webkit-print-color-adjust: exact; 
            }
            #my_blue{
                background-color: #DDEBF7 !important;
                -webkit-print-color-adjust: exact; 
            }
            #table_1 tr >td,#table_1 tr >th{
              border-collapse: collapse;
              border: 1px black solid;
              padding:15px;
            }
            tr:nth-of-type(5) td:nth-of-type(1) {
              visibility: hidden;
            }
            .rotate {
              transform: rotate(-90.0deg);
              white-space: nowrap;
              font-size: 11px;
            }
            .par_rotate{
                text-align: center;
                max-width: 30px;
                width:4px;
            }
            #table_2 tr >td,#table_2 tr >th{
                padding: 10px;
                border-collapse: collapse;
                border: 1px black solid;
            }
        }

         td {
      border-collapse: collapse;
      border: 1px black solid;
      line-height: 0.5px !important;
    }
    tr:nth-of-type(5) td:nth-of-type(1) {
      visibility: hidden;
    }
    .rotate {
      transform: rotate(-90.0deg);
      white-space: nowrap;
    }
    .par_rotate{
        text-align: center;
        max-width:7px;
    }
    #table_2 >thead{
        background: #DDEBF7;
    }
     #table_2 >thead >tr:nth-child(3){
        background: #fff;
    }
    .table>thead>tr>th {
        line-height:2px !important;


    }
    .mt-checkbox {
        letter-spacing:1px;
        font-size: 9px;
    }
    .img_size {
        width: 15px;
        height: 15px;
        margin-right: 10px;
    }
   .col-xs-12 label {
            margin-bottom:0px !important;
    }
    .form-inline label {
            margin-top: 6px;
    }
    </style>

</head>
<body  onload="window.print();" id="content">
    <!--<link href="https://fonts.googleapis.com/css?family=Khmer" rel="stylesheet">
    <style>
        *{
            font-family: 'Khmer OS', 'khmer'!important;
        }
    </style>-->
    <link rel=Stylesheet href=stylesheet.css>

    <div class="container-fliud">
        <?php 
            if (isset($_GET['print_id'])) {
                $v_main_id=@$_GET['print_id'];
                $sql_main=$connect->query("SELECT A.*,B.fpt_name, date_format(frpc_date, '%d-%m-%Y') as datefor, C.*
                    FROM tbl_fr_pc_expense as A
                                LEFT JOIN tbl_fr_pc_type_list AS B ON A.frpc_type=B.fpt_id
                                LEFT JOIN tbl_fr_pc_company AS C ON A.frpc_company=C.fpc_id
                    WHERE frpc_id='$v_main_id'
                    ");
                $row_main=mysqli_fetch_object($sql_main);
            }
         ?>
        <div class="container-fliud border">

        <table width="100%" border="2px">
            <tr>
            <td colspan="3" style="padding: 10px;border-collapse: collapse;font-size: 26px!important; font-family: 'Times New Roman';">Rithy Group</td>
            <td colspan="2" style="padding: 10px;border-collapse: collapse;font-size: 16px!important; font-family: 'Khmer OS Muol';text-align: right;">សំណើរស្នើសុំ</td>
            </tr>
            <tr>
            <td colspan="5" style="font-size: 28px!important; font-family: 'Times New Roman';text-align: center;"><?= $row_main->fpt_name ?></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td style="font-size: 14px!important; font-family: 'Times New Roman';text-align: right;">FR/PC No:</td>
                <td style="font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"><?= $row_main->frpc_no ?></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td style="font-size: 14px!important; font-family: 'Times New Roman';text-align: right;">Company:</td>
                <td style="font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"><?= $row_main->fpc_code ?></td>
            </tr>
            <tr>
                <td style="font-size: 14px!important; font-family: 'Times New Roman';text-align: right;">Date:</td>
                <td style="font-size: 14px!important; font-family: 'Times New Roman';text-align: left;"><?= $row_main->datefor ?></td>
                <td></td>
                <td style="font-size: 14px!important; font-family: 'Times New Roman';text-align: right;">Project Code:</td>
                <td style="font-size: 14px!important; font-family: 'Times New Roman';text-align: center;">FR.23-03-0001</td>
            </tr>
                <tr>
                <td colspan="3"></td>
                <td style="font-size: 14px!important; font-family: 'Times New Roman';text-align: right;">Activity Code:</td>
                <td style="font-size: 14px!important; font-family: 'Times New Roman';text-align: center;">FR.23-03-0001</td>
            </tr>
        </table>
        <table width="100%" border="2px">
            <tr>
                <td width="4%" style="border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;background:#00FFFF;">NO</td>
                <td width="46%" style="border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;background:#00FFFF;">Description</td>
                <td width="15%" style="border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;background:#00FFFF;">Unit Price</td>
                <td width="15%" style="border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;background:#00FFFF;">Qty</td>
                <td width="20%" style="font-size: 14px!important; font-family: 'Times New Roman';text-align: center;background:#00FFFF;">AMOUNT(USD)</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS Niroth';">សំណើរ <?= $row_main->fpc_namekh ?> <?= $row_main->fpc_nameen ?></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;">1</td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"><?= $row_main->frpc_description ?></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;">$ <?= number_format($row_main->frpc_unit_price,2) ?></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"><?= $row_main->frpc_qty ?></td>
                <td style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;">$ <?= number_format($row_main->frpc_amount,2) ?></td>
            </tr>
                <?php 
                    if($row_main->frpc_note<>""){ ?>
            <tr>
                <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: left; color: #ffffff;"><br></td>
                <td style="text-decoration: underline; border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS Niroth';">បញ្ជាក់</td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
                <td style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: left; color: #ffffff;"><br></td>
                <td rowspan="6" style="border-top: 1px solid black; vertical-align: text-top; border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"><?= $row_main->frpc_note ?></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
                <td style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: left; color: #ffffff;"><br></td>
                
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
                <td style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: left; color: #ffffff;"><br></td>
                
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
                <td style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: left; color: #ffffff;"><br></td>
                
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
                <td style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: left; color: #ffffff;"><br></td>
                
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
                <td style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: left; color: #ffffff;"><br></td>
                
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
                <td style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
            </tr>
        <?php }else{ ?>
            <tr>
                <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: left; color: #ffffff;"><br></td>
                <td style="text-decoration: underline; border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS Niroth';"></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
                <td style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: left; color: #ffffff;"><br></td>
                <td style="text-decoration: underline; border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS Niroth';"></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
                <td style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: left; color: #ffffff;"><br></td>
                <td style="text-decoration: underline; border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS Niroth';"></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
                <td style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: left; color: #ffffff;"><br></td>
                <td style="text-decoration: underline; border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS Niroth';"></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
                <td style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: left; color: #ffffff;"><br></td>
                <td style="text-decoration: underline; border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS Niroth';"></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
                <td style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: left; color: #ffffff;"><br></td>
                <td style="text-decoration: underline; border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS Niroth';"></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
                <td style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: left; color: #ffffff;"><br></td>
                <td style="text-decoration: underline; border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS Niroth';"></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
                <td style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
            </tr>
        <?php } ?>
            <tr>
                <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: left; color: #ffffff;"><br></td>
                <td style="text-decoration: underline; border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS Niroth';"></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
                <td style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: left; color: #ffffff;"><br></td>
                <td style="text-decoration: underline; border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS Niroth';"></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
                <td style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: left; color: #ffffff;"><br></td>
                <td style="text-decoration: underline; border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS Niroth';"></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
                <td style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
            </tr>
        </table>
        <br>
        <table width="100%" border="2px">
            <tr>
                <td width="5%"></td>
                <td align="center" style="font-family: 'Khmer OS Siemreap';">Request Report by (អ្នកស្នើរបាយការណ៍ដោយ):</td>
                <td width="10%"></td>
                <td align="center" style="font-family: 'Khmer OS Siemreap';">Checked by (ត្រួតពិនិត្យដោយ):</td>
                <td width="5%"></td>
            </tr>
            <tr>
                <td><br><br><br><br><br></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><br><br></td>
                <td style="border-top: 1px solid black;"></td>
                <td></td>
                <td style="border-top: 1px solid black;"></td>
                <td></td>
            </tr>
        </table><br>
        <table width="100%" border="2px">
            <tr>
                <td width="5%"></td>
                <td align="center" style="font-family: 'Khmer OS Siemreap';">First Approved by(ឯកភាពដោយទី 1):</td>
                <td width="10%"></td>
                <td align="center" style="font-family: 'Khmer OS Siemreap';">Payment by(ទូទាត់ដោយ):</td>
                <td width="5%"></td>
            </tr>
            <tr>
                <td><br><br><br><br><br></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><br><br></td>
                <td style="border-top: 1px solid black;"></td>
                <td></td>
                <td style="border-top: 1px solid black;"></td>
                <td></td>
            </tr>
        </table><br>
        <table width="100%" border="2px">
            <tr>
                <td width="5%"></td>
                <td align="center" style="font-family: 'Khmer OS Siemreap';">First Approved by(ឯកភាពដោយទី 2):</td>
                <td width="10%"></td>
                <td align="center" style="font-family: 'Khmer OS Siemreap';">Payment by(ទូទាត់ដោយ):</td>
                <td width="5%"></td>
            </tr>
            <tr>
                <td><br><br><br><br><br></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><br><br></td>
                <td style="border-top: 1px solid black;"></td>
                <td></td>
                <td style="border-top: 1px solid black;"></td>
                <td></td>
            </tr>
        </table>
        </div>


    </div>
    <!-- Detail -->
    <script src="../../print_offline/bootstrap.min.js"></script>
    <script src="../../print_offline/jquery.min.js"></script>
</body>
</html>

<script type="text/javascript">
    window.onload=function(){
      var printme=document.getElementById('content');
      var wme=window.open("","","width=1080,height=720");
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



