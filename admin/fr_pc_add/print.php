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
            $sql_main=$connect->query("SELECT A.*,B.fpt_name, date_format(frpc_date, '%d-%m-%Y') as datefor
                FROM tbl_fr_pc_expense as A
                            LEFT JOIN tbl_fr_pc_type_list AS B ON A.frpc_type=B.fpt_id
                WHERE frpc_id='$v_main_id'
                ");
            $row_main=mysqli_fetch_object($sql_main);
        }
     ?>
<div class="container-fliud">
<table width="100%">
  <tr>
    <td width=7 style='padding: 10px;border-collapse: collapse;border-top: 1px solid black;border-left: 1px solid black;'></td>
    <td colspan="16" style="padding: 10px;border-collapse: collapse;font-size: 26px!important; font-family: 'Times New Roman';border-top: 1px solid black;">Rithy Group</td>
    <td colspan=5 style="padding: 10px;border-collapse: collapse;font-size: 16px!important; font-family: 'Khmer OS Muol';text-align: right;border-top: 1px solid black;">សំណើរស្នើសុំ</td>
    <td width=7 style='padding: 10px;border-collapse: collapse;border-top: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td colspan="21" style="font-size: 28px!important; font-family: 'Times New Roman';text-align: center;"><?= $row_main->fpt_name ?></td>
    <td style='border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td colspan="15" style="font-size: 22px!important; font-family: 'Times New Roman';text-align: center;"></td>
    <td style="font-size: 14px!important; font-family: 'Times New Roman';text-align: right;">FR/PC No:</td>
    <td colspan="5" style="font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"><?= $row_main->frpc_no ?></td>
    <td style='border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td colspan="15" style="font-size: 22px!important; font-family: 'Times New Roman';text-align: center;"></td>
    <td style="font-size: 14px!important; font-family: 'Times New Roman';text-align: right;">Company:</td>
    <td colspan="5" style="font-size: 14px!important; font-family: 'Times New Roman';text-align: center;">G-2</td>
    <td style='border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td colspan="2" style="font-size: 14px!important; font-family: 'Times New Roman';text-align: center;">Date:</td>
    <td colspan="3" style="font-size: 14px!important; font-family: 'Times New Roman';text-align: left;"><?= $row_main->datefor ?></td>

    <td colspan="10" style="font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
    <td style="font-size: 14px!important; font-family: 'Times New Roman';text-align: right;">Project Code:</td>
    <td colspan="5" style="font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
    <td style='border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td colspan="15" style="font-size: 22px!important; font-family: 'Times New Roman';text-align: center;"></td>
    <td style="font-size: 14px!important; font-family: 'Times New Roman';text-align: right;">Activity Code:</td>
    <td colspan="5" style="font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
    <td style='border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;border-bottom: 1px solid black;'></td>
    <td colspan="21" style="font-size: 22px!important; font-family: 'Times New Roman';text-align: center;border-bottom: 1px solid black;"></td>
    <td style='border-right: 1px solid black;border-bottom: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td style="border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;background:#00FFFF;">NO</td>
    <td colspan="14" style="border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;background:#00FFFF;">Description</td>
    <td style="border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;background:#00FFFF;">Unit Price</td>
    <td colspan="3" style="border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;background:#00FFFF;">Qty</td>
    <td colspan="2" style="font-size: 14px!important; font-family: 'Times New Roman';text-align: center;background:#00FFFF;">AMOUNT(USD)</td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
    <td colspan="14" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS Niroth';">សំណើរ រោងចក្រថ្ម ឬទ្ធីក្រានីត + រ៉ែថ្ម (ក្រចេះ, ស្នួល)</td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
    <td colspan="3" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
    <td colspan="2" style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;">1</td>
    <td colspan="14" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"><?= $row_main->frpc_description ?></td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;">$ <?= number_format($row_main->frpc_unit_price,2) ?></td>
    <td colspan="3" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"><?= $row_main->frpc_qty ?></td>
    <td colspan="2" style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;">$ <?= number_format($row_main->frpc_amount,2) ?></td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center; color: #ffffff;">2</td>
    <td colspan="14" style="text-decoration: underline; border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS Niroth';">
                <?php 
            if($row_main->frpc_note<>""){
                echo 'បញ្ជាក់';
               
            }
        ?>
    </td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;">
    </td>
    <td colspan="3" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
    <td colspan="2" style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: left; color: #ffffff;">3</td>
    <td colspan="14" rowspan="4" style="border-top: 1px solid black; vertical-align: text-top; border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"><?= $row_main->frpc_note ?></td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
    <td colspan="3" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
    <td colspan="2" style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center; color: #ffffff;">4</td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
    <td colspan="3" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
    <td colspan="2" style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center; color: #ffffff;">5</td> 
    <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
    <td colspan="3" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
    <td colspan="2" style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center; color: #ffffff;">6</td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
    <td colspan="3" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
    <td colspan="2" style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center; color: #ffffff;">7</td>
    <td colspan="14" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"></td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
    <td colspan="3" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
    <td colspan="2" style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center; color: #ffffff;">8</td>
    <td colspan="14" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"></td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
    <td colspan="3" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
    <td colspan="2" style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr> 
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center; color: #ffffff;">3</td>
    <td colspan="14" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"></td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
    <td colspan="3" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
    <td colspan="2" style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center; color: #ffffff;">4</td>
    <td colspan="14" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"></td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
    <td colspan="3" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
    <td colspan="2" style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center; color: #ffffff;">5</td>
    <td colspan="14" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"></td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
    <td colspan="3" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
    <td colspan="2" style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center; color: #ffffff;">6</td>
    <td colspan="14" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"></td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
    <td colspan="3" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
    <td colspan="2" style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center; color: #ffffff;">7</td>
    <td colspan="14" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"></td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
    <td colspan="3" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
    <td colspan="2" style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center; color: #ffffff;">8</td>
    <td colspan="14" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"></td>
    <td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
    <td colspan="3" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
    <td colspan="2" style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>  
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: center;"></td>
    <td colspan="14" style="border-top: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';">Activities:</td>
    <td colspan="4" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;">GRAND TOTAL (USD)</td>
    <td colspan="2" style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;background:#FFFF99;">$ <?= number_format($row_main->frpc_amount,2) ?></td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>

  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td colspan="19" style="font-size: 11px!important; font-family: 'Times New Roman';">*** Type of Request and Reference Requirement:</td>
    <td colspan="2" style="border-top: 1px solid black;font-size: 14px!important; font-family: 'Times New Roman';text-align: right;"></td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>

  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td rowspan="2" style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';text-align: center;vertical-align: middle;">NO</td>
    <td rowspan="2" colspan="2" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';text-align: center;vertical-align: middle;">Type of Request</td>
    <td colspan="18" style="border-top: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';text-align: center;">Reference Requirement</td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr> 
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td colspan="12" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';text-align: center;">Permanent Request</td>
    <td colspan="6" style="border-top: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';text-align: center;">Temporary Request</td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr> 

  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td rowspan="2" style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';text-align: center;vertical-align: middle;">1</td>
    <td rowspan="2" colspan="2" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';text-align: center;vertical-align: middle;">From $1 - $200</td>
    <td colspan="4" style="border-top: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"><input type="checkbox" name="myCheckboxes[]"  value="">1/ ការឯកភាពពីគណៈគ្រប់គ្រង</td>
    <td colspan="5" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"><input type="checkbox" name="myCheckboxes[]"  value="">2/  រូបភាព</td>
    <td colspan="4" style="border-top: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"><input type="checkbox" name="myCheckboxes[]"  value="">1/ ការឯកភាពពីគណៈគ្រប់គ្រង</td>
    <td colspan="5" style="border-top: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"><input type="checkbox" name="myCheckboxes[]"  value="">2/  រូបភាព</td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr> 
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td colspan="9" style="border-right: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';"></td>
    <td colspan="9" style="font-size: 11px!important; font-family: 'Khmer OS';text-align: center;"><input type="checkbox" name="myCheckboxes[]"  value="">3/  កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ)</td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr> 

  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td rowspan="3" style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';text-align: center;vertical-align: middle;">2</td>
    <td rowspan="3" colspan="2" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';text-align: center;vertical-align: middle;">From $201 - $300</td>
    <td colspan="4" style="border-top: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"><input type="checkbox" name="myCheckboxes[]"  value="">1/ ការឯកភាពពីគណៈគ្រប់គ្រង</td>
    <td colspan="5" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"><input type="checkbox" name="myCheckboxes[]"  value="">2/  រូបភាព</td>
    <td colspan="4" style="border-top: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"><input type="checkbox" name="myCheckboxes[]"  value="">1/ ការឯកភាពពីគណៈគ្រប់គ្រង</td>
    <td colspan="5" style="border-top: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"><input type="checkbox" name="myCheckboxes[]"  value="">2/  រូបភាព</td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr> 
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td colspan="9" style="border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"><input type="checkbox" name="myCheckboxes[]"  value="">3/  កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ)</td>
    <td colspan="9" style="font-size: 11px!important; font-family: 'Khmer OS';"><input type="checkbox" name="myCheckboxes[]"  value="">3/  កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ)</td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr> 
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td colspan="9" style="border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"><input type="checkbox" name="myCheckboxes[]"  value="">4/  រ.តាមដានចំណាយ, រ.ស្តុក, រ.ជួសជុលគ្រឿងចក្រ</td>
    <td colspan="9" style="font-size: 11px!important; font-family: 'Khmer OS';"><input type="checkbox" name="myCheckboxes[]"  value="">4/  រ.តាមដានចំណាយ, រ.ស្តុក, រ.ជួសជុលគ្រឿងចក្រ</td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr> 

  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td rowspan="5" style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';text-align: center;vertical-align: middle;">3</td>
    <td rowspan="5" colspan="2" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';text-align: center;vertical-align: middle;">From $301 -$1000</td>
    <td colspan="4" style="border-top: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"><input type="checkbox" name="myCheckboxes[]"  value="">1/ ការឯកភាពពីគណៈគ្រប់គ្រង</td>
    <td colspan="5" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"><input type="checkbox" name="myCheckboxes[]"  value="">2/  រូបភាព</td>
    <td colspan="4" style="border-top: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"><input type="checkbox" name="myCheckboxes[]"  value="">1/ ការឯកភាពពីគណៈគ្រប់គ្រង</td>
    <td colspan="5" style="border-top: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"><input type="checkbox" name="myCheckboxes[]"  value="">2/  រូបភាព</td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr> 
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td colspan="9" style="border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"><input type="checkbox" name="myCheckboxes[]"  value="">3/  កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ)</td>
    <td colspan="9" style="font-size: 11px!important; font-family: 'Khmer OS';"><input type="checkbox" name="myCheckboxes[]"  value="">3/  កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ)</td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr> 
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td colspan="9" style="border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"><input type="checkbox" name="myCheckboxes[]"  value="">4/  រ.តាមដានចំណាយ, រ.ស្តុក, រ.ជួសជុលគ្រឿងចក្រ</td>
    <td colspan="9" style="font-size: 11px!important; font-family: 'Khmer OS';"><input type="checkbox" name="myCheckboxes[]"  value="">4/  រ.តាមដានចំណាយ, រ.ស្តុក, រ.ជួសជុលគ្រឿងចក្រ</td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr> 
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td colspan="4" style="font-size: 11px!important; font-family: 'Khmer OS';"><input type="checkbox" name="myCheckboxes[]"  value="">5/ ផែនការប្រើប្រាស់សំភារៈផលិត</td>
    <td colspan="5" style="border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"><input type="checkbox" name="myCheckboxes[]"  value="">6/ Quotation</td>
    <td colspan="4" style="font-size: 11px!important; font-family: 'Khmer OS';"><input type="checkbox" name="myCheckboxes[]"  value="">5/ ផែនការប្រើប្រាស់សំភារៈផលិត</td>
    <td colspan="5" style="font-size: 11px!important; font-family: 'Khmer OS';"><input type="checkbox" name="myCheckboxes[]"  value="">6/ Quotation</td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr> 
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td colspan="9" style="border-right: 1px solid black;font-size: 11px!important; font-family: 'Khmer OS';"><input type="checkbox" name="myCheckboxes[]"  value="">7/ ផ្សេងៗ</td>
    <td colspan="9" style="font-size: 11px!important; font-family: 'Khmer OS';"><input type="checkbox" name="myCheckboxes[]"  value="">7/ ផ្សេងៗ</td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr> 
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td colspan="21" style="border-top: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';"></td>
    <td style='border-right: 1px solid black;'></td>
  </tr>

  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td style="border-left: 1px solid black;border-top: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';"></td>
    <td colspan="11" style="border-top: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';">Request Report by(អ្នកស្នើររបាយការណ៏ដោយ):</td>
    <td style="border-top: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';"></td>
    <td style="border-top: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';"></td>
    <td colspan="7" style="border-top: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';">Checked by(ត្រួតពិនិត្យដោយ):</td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td colspan="21" style="border-left: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman'; color: #ffffff;">1</td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td colspan="21" style="border-left: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman'; color: #ffffff;">1</td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td style="border-left: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman'; color: #ffffff;">1</td>
    <td colspan="8" style="border-bottom: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';"></td>
    <td colspan="6" style="font-size: 11px!important; font-family: 'Times New Roman';"></td>
    <td colspan="5" style="border-bottom: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';"></td>
    <td></td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td colspan="21" style="border-left: 1px solid black;border-bottom: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman'; color: #ffffff;">1</td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>

  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td colspan="21" style="font-size: 11px!important; font-family: 'Times New Roman';"></td>
    <td style='border-right: 1px solid black;'></td>
  </tr>

  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td style="border-left: 1px solid black;border-top: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';"></td>
    <td colspan="11" style="border-top: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';">First Aprroved by(ឯកភាពដោយ ទី 1):</td>
    <td style="border-top: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';"></td>
    <td style="border-top: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';"></td>
    <td colspan="7" style="border-top: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';">Payment by(ទួទាត់ដោយ):</td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td colspan="21" style="border-left: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman'; color: #ffffff;">1</td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td colspan="21" style="border-left: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman'; color: #ffffff;">1</td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td style="border-left: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman'; color: #ffffff;">1</td>
    <td colspan="8" style="border-bottom: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';"></td>
    <td colspan="6" style="font-size: 11px!important; font-family: 'Times New Roman';"></td>
    <td colspan="5" style="border-bottom: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';"></td>
    <td></td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td colspan="21" style="border-left: 1px solid black;border-bottom: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman'; color: #ffffff;">1</td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>

  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td colspan="21" style="font-size: 11px!important; font-family: 'Times New Roman';"></td>
    <td style='border-right: 1px solid black;'></td>
  </tr>

  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td style="border-left: 1px solid black;border-top: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';"></td>
    <td colspan="11" style="border-top: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';">Second Aprroved by(ឯកភាពដោយ ទី 2):</td>
    <td style="border-top: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';"></td>
    <td style="border-top: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';"></td>
    <td colspan="7" style="border-top: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';"></td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td colspan="21" style="border-left: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman'; color: #ffffff;">1</td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td colspan="21" style="border-left: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman'; color: #ffffff;">1</td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td style="border-left: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman'; color: #ffffff;">1</td>
    <td colspan="8" style="border-bottom: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman';"></td>
    <td colspan="6" style="font-size: 11px!important; font-family: 'Times New Roman';"></td>
    <td colspan="5" style="font-size: 11px!important; font-family: 'Times New Roman';"></td>
    <td></td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-left: 1px solid black;'></td>
    <td colspan="21" style="border-left: 1px solid black;border-bottom: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman'; color: #ffffff;">1</td>
    <td style='border-left: 1px solid black;border-right: 1px solid black;'></td>
  </tr>
  <tr>
    <td style='border-bottom: 1px solid black;border-left: 1px solid black;'></td>
    <td colspan="21" style="border-bottom: 1px solid black;font-size: 11px!important; font-family: 'Times New Roman'; color: #ffffff;">1</td>
    <td style='border-bottom: 1px solid black;border-right: 1px solid black;'></td>
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



