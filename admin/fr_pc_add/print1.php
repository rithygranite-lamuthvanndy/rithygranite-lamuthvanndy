<?php include_once '../../config/database.php';?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../print_offline/bootstrap.min.css">
    <script src="../../print_offline/jquery.min.js"></script>
    <style type="text/css">
        *{ font-family: 'khmer os content'; font-size: 14px!important; }
        @media print {
            .table thead tr th{
                -webkit-print-color-adjust: exact;
                background: #222 !important;
                color: #fff !important;
            }
            .table tfoot tr td.bg{
                -webkit-print-color-adjust: exact;
                background: #444 !important;
                color: #fff !important;
            }
            .table *{ padding-bottom: 2px!important; padding-top: 2px!important; }
            .my_title>p{
                font-weight: bold!important;
            }
            .my_box_border{
                border: 1px solid black;
            }
            .table-bordered>thead>tr>th,.table-bordered>tbody>tr>td,.table-bordered>tfoot>tr>th{
                border: 0.5px solid black!important;
            }
        }
    </style>
</head>
<body  onload="window.print();" id="content">
    <link href="https://fonts.googleapis.com/css?family=Khmer" rel="stylesheet">
    <style>
        *{
            font-family: 'Khmer', 'khmer'!important;
        }
    </style>
    <link rel=Stylesheet href=stylesheet.css>

    <div class="container-fliud">
    <?php 
        if (isset($_GET['print_id'])) {
            $v_main_id=@$_GET['print_id'];
            $sql_main=$connect->query("SELECT * 
                FROM tbl_fr_pc_expense 
                WHERE frpc_id='$v_main_id'
                ");
            $row_main=mysqli_fetch_object($sql_main);
        }
     ?>
<div class="container-fliud">
<table width="595px" style='border-collapse:collapse;table-layout:fixed;width:811pt'>
 <tr width="100%" style='mso-height-source:userset;height:28.5pt'>
  <td style='height:28.5pt;width:11pt'><a name="Print_Area">&nbsp;</a></td>
  <td colspan=16 width=172 style='mso-ignore:colspan;width:130pt'>Rithy Group</td>
  <td colspan=5 class=xl74 style="width:23pt; font-size: 25px!important; font-family: 'Khmer OS Muol Light','Khmer OS Muol';">សំណើរស្នើសុំ</td>
  <td width=14 style='width:11pt'></td>
 </tr>

 <tr height=29 style='mso-height-source:userset;height:21.75pt'>
  <td height=29 class=xl76 style='height:21.75pt'>&nbsp;</td>
  <td colspan=21 class=xl215 width=879 style='width:661pt'>Purchase Claim</td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=23 style='mso-height-source:userset;height:17.25pt'>
  <td height=23 class=xl76 style='height:17.25pt'>&nbsp;</td>
  <td></td>
  <td class=xl78></td>
  <td class=xl79></td>
  <td class=xl80 width=5 style='width:4pt'></td>
  <td class=xl80 width=24 style='width:18pt'></td>
  <td colspan=2 class=xl85></td>
  <td></td>
  <td></td>
  <td class=xl81 width=29 style='width:22pt'></td>
  <td></td>
  <td></td>
  <td colspan=2 class=xl216></td>
  <td colspan=2 class=xl85>FR/PC No:</td>
  <td colspan=5 class=xl217 width=194 style='width:146pt'><?= $row_main->frpc_no ?></td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=23 style='mso-height-source:userset;height:17.25pt'>
  <td height=23 class=xl76 style='height:17.25pt'>&nbsp;</td>
  <td></td>
  <td class=xl79></td>
  <td class=xl79></td>
  <td class=xl82></td>
  <td class=xl83 width=24 style='width:18pt'></td>
  <td colspan=2 class=xl85></td>
  <td></td>
  <td></td>
  <td class=xl84></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td colspan=2 class=xl85>Company:</td>
  <td colspan=5 class=xl214>G-2</td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>


 <tr height=23 style='mso-height-source:userset;height:17.25pt'>
  <td height=23 class=xl76 style='height:17.25pt'>&nbsp;</td>
  <td class=xl85>Date:</td>
  <td colspan=4 class=xl212><?= $row_main->frpc_date ?></td>
  <td colspan=2 class=xl85></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td colspan=2 class=xl85>Project Code:</td>
  <td colspan=5 class=xl213></td>
  <td class=xl77>&nbsp;</td>
  <td class=xl210></td>
 </tr>

 <tr height=23 style='mso-height-source:userset;height:17.25pt'>
  <td height=23 class=xl76 style='height:17.25pt'>&nbsp;</td>
  <td></td>
  <td class=xl79></td>
  <td class=xl79></td>
  <td class=xl82></td>
  <td class=xl83 width=24 style='width:18pt'></td>
  <td colspan=2 class=xl85></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td colspan=2 class=xl85>Activity Code:</td>
  <td colspan=5 class=xl213></td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=9 style='mso-height-source:userset;height:6.75pt'>
  <td height=9 class=xl86 style='height:6.75pt'>&nbsp;</td>
  <td class=xl87>&nbsp;</td>
  <td class=xl88>&nbsp;</td>
  <td class=xl87>&nbsp;</td>
  <td class=xl87>&nbsp;</td>
  <td class=xl87>&nbsp;</td>
  <td class=xl89>&nbsp;</td>
  <td class=xl90>&nbsp;</td>
  <td class=xl91>&nbsp;</td>
  <td class=xl87>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl93>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=34 style='mso-height-source:userset;height:25.5pt'>
  <td height=34 class=xl68 style='height:25.5pt;border-top:none'>&nbsp;</td>
  <td class=xl94 style='border-top:none'>No</td>
  <td colspan=14 class=xl218 width=468 style='border-right:1.0pt solid black; border-left:none;width:352pt'>Description</td>
  <td class=xl95 style='border-top:none;border-left:none'>Unit Price</td>
  <td colspan=3 class=xl221 style='border-left:none'>Qty</td>
  <td colspan=2 class=xl223 style='border-right:1.0pt solid black'>AMOUNT(USD)</td>
  <td class=xl75 style='border-top:none'>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=34 style='mso-height-source:userset;height:25.5pt'>
  <td height=34 class=xl76 style='height:25.5pt'>&nbsp;</td>
  <td class=xl96>&nbsp;</td>
  <td colspan=14 class=xl225 style='border-left:none'>សំណើរ រោងចក្រថ្ម ឬទ្ធីក្រានីត + រ៉ែថ្ម (ក្រចេះ, ស្នួល)</td>
  <td class=xl97 style='border-left:none'>&nbsp;</td>
  <td colspan=3 class=xl226 style='border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl226 style='border-left:none'>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=32 style='mso-height-source:userset;height:24.0pt'>
  <td height=32 class=xl76 style='height:24.0pt'>&nbsp;</td>
  <td class=xl98 style='border-top:none'>1</td>
  <td class=xl99 colspan=6 style='mso-ignore:colspan'><?= $row_main->frpc_description ?></td>
  <td class=xl100 style='border-top:none'>&nbsp;</td>
  <td class=xl100 style='border-top:none'>&nbsp;</td>
  <td class=xl100 style='border-top:none'>&nbsp;</td>
  <td class=xl100 style='border-top:none'>&nbsp;</td>
  <td class=xl100 style='border-top:none'>&nbsp;</td>
  <td class=xl100 style='border-top:none'>&nbsp;</td>
  <td class=xl100 style='border-top:none'>&nbsp;</td>
  <td class=xl101 style='border-top:none'>&nbsp;</td>
  <td class=xl102 style='border-top:none;border-left:none'><?= $row_main->frpc_qty ?></td>
  <td colspan=3 class=xl227 style='border-right:1.0pt solid black;border-left:
  none'><?= number_format($row_main->frpc_unit_price,2) ?></td>
  <td colspan=2 class=xl230 style='border-left:none'><span
  style='mso-spacerun:yes'> </span>$<span style='mso-spacerun:yes'>       
  </span><?= number_format($row_main->frpc_amount,2) ?></td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=29 style='mso-height-source:userset;height:21.75pt'>
  <td height=29 class=xl76 style='height:21.75pt'>&nbsp;</td>
  <td class=xl98 style='border-top:none'>&nbsp;</td>
  <td class=xl211 style='border-top:none;border-left:none'><u style='visibility:
  hidden;mso-ignore:visibility'>&nbsp;</u></td>
  <td class=xl202 width=41 style='border-top:none;width:31pt'>&nbsp;</td>
  <td class=xl202 width=5 style='border-top:none;width:4pt'>&nbsp;</td>
  <td class=xl202 width=24 style='border-top:none;width:18pt'>&nbsp;</td>
  <td class=xl202 width=20 style='border-top:none;width:15pt'>&nbsp;</td>
  <td class=xl202 width=153 style='border-top:none;width:115pt'>&nbsp;</td>
  <td class=xl202 width=24 style='border-top:none;width:18pt'>&nbsp;</td>
  <td class=xl202 width=18 style='border-top:none;width:14pt'>&nbsp;</td>
  <td class=xl202 width=29 style='border-top:none;width:22pt'>&nbsp;</td>
  <td class=xl202 width=33 style='border-top:none;width:25pt'>&nbsp;</td>
  <td class=xl202 width=7 style='border-top:none;width:5pt'>&nbsp;</td>
  <td class=xl202 width=7 style='border-top:none;width:5pt'>&nbsp;</td>
  <td class=xl202 width=23 style='border-top:none;width:17pt'>&nbsp;</td>
  <td class=xl203 width=20 style='border-top:none;width:15pt'>&nbsp;</td>
  <td class=xl103 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=3 class=xl231 style='border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl231 style='border-left:none'>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>
 <tr height=29 style='mso-height-source:userset;height:21.75pt'>
  <td height=29 class=xl76 style='height:21.75pt'>&nbsp;</td>
  <td class=xl98 style='border-top:none'>&nbsp;</td>
  <td class=xl99 colspan=6 rowspan=3 style='mso-ignore:colspan'>
    <textarea type="text" class="form-control" name="txt_note" rows="6" autocomplete="off"><?= $row_main->frpc_note ?></textarea>
  </td>

  <td colspan=6 class=xl250 width=119 style='border-right:1.0pt solid black;
  width:89pt'>&nbsp;</td>
  <td class=xl103 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=3 class=xl231 style='border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl231 style='border-left:none'>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=29 style='mso-height-source:userset;height:21.75pt'>
  <td height=29 class=xl76 style='height:21.75pt'>&nbsp;</td>
  <td class=xl98 style='border-top:none'>&nbsp;</td>

  <td colspan=6 class=xl250 width=119 style='border-right:1.0pt solid black;
  width:89pt'>&nbsp;</td>
  <td class=xl103 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=3 class=xl231 style='border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl231 style='border-left:none'>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=29 style='mso-height-source:userset;height:21.75pt'>
  <td height=29 class=xl76 style='height:21.75pt'>&nbsp;</td>
  <td class=xl98 style='border-top:none'>&nbsp;</td>

  <td colspan=6 class=xl250 width=119 style='border-right:1.0pt solid black;
  width:89pt'>&nbsp;</td>
  <td class=xl103 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=3 class=xl231 style='border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl231 style='border-left:none'>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=29 style='mso-height-source:userset;height:21.75pt'>
  <td height=29 class=xl76 style='height:21.75pt'>&nbsp;</td>
  <td class=xl105 style='border-top:none'>&nbsp;</td>
  <td class=xl99 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl206 style='border-top:none'>&nbsp;</td>
  <td class=xl206 style='border-top:none'>&nbsp;</td>
  <td class=xl206 style='border-top:none'>&nbsp;</td>
  <td class=xl206 style='border-top:none'>&nbsp;</td>
  <td class=xl207 width=153 style='border-top:none;width:115pt'>&nbsp;</td>
  <td class=xl208 width=24 style='border-top:none;width:18pt'>&nbsp;</td>
  <td class=xl209 style='border-top:none'>&nbsp;</td>
  <td colspan=6 class=xl250 width=119 style='border-right:1.0pt solid black;
  width:89pt'>&nbsp;</td>
  <td class=xl103 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=3 class=xl231 style='border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl231 style='border-left:none'>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=29 style='mso-height-source:userset;height:21.75pt'>
  <td height=29 class=xl76 style='height:21.75pt'>&nbsp;</td>
  <td class=xl106 style='border-top:none'>&nbsp;</td>
  <td class=xl107 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl108 style='border-top:none'>&nbsp;</td>
  <td class=xl108 style='border-top:none'>&nbsp;</td>
  <td class=xl108 style='border-top:none'>&nbsp;</td>
  <td class=xl108 style='border-top:none'>&nbsp;</td>
  <td class=xl108 style='border-top:none'>&nbsp;</td>
  <td class=xl108 style='border-top:none'>&nbsp;</td>
  <td class=xl108 style='border-top:none'>&nbsp;</td>
  <td class=xl108 style='border-top:none'>&nbsp;</td>
  <td class=xl108 style='border-top:none'>&nbsp;</td>
  <td class=xl108 style='border-top:none'>&nbsp;</td>
  <td class=xl108 style='border-top:none'>&nbsp;</td>
  <td class=xl108 style='border-top:none'>&nbsp;</td>
  <td class=xl109 style='border-top:none'>&nbsp;</td>
  <td class=xl110 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=3 class=xl256 style='border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl256 style='border-left:none'>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=29 style='mso-height-source:userset;height:21.75pt'>
  <td height=29 class=xl111 style='height:21.75pt'>&nbsp;</td>
  <td></td>
  <td class=xl112 colspan=2 style='mso-ignore:colspan'>Activities:</td>
  <td colspan=12 class=xl257></td>
  <td colspan=4 class=xl114>GRAND TOTAL (USD)<span style='mso-spacerun:yes'> </span></td>
  <td colspan=2 class=xl258 style='border-right:1.0pt solid black'><span
  style='mso-spacerun:yes'>        </span><?= number_format($row_main->frpc_amount,2) ?></td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=24 style='mso-height-source:userset;height:18.0pt'>
  <td height=24 class=xl115 style='height:18.0pt'>&nbsp;</td>
  <td colspan=21 class=xl116>*** Type of Request and Reference Requirement:</td>
  <td class=xl120>&nbsp;</td>
  <td class=xl118></td>
 </tr>

 <tr height=25 style='mso-height-source:userset;height:18.75pt'>
  <td height=25 class=xl115 style='height:18.75pt'>&nbsp;</td>
  <td rowspan=2 class=xl241 style='border-top:none'>No</td>
  <td colspan=2 rowspan=2 class=xl242 width=105 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black;width:79pt'>Type of Request</td>
  <td colspan=18 class=xl246 style='border-right:.5pt solid black;border-left:
  none'>Reference Requirement</td>
  <td class=xl120>&nbsp;</td>
  <td class=xl118></td>
 </tr>

 <tr height=25 style='mso-height-source:userset;height:18.75pt'>
  <td height=25 class=xl115 style='height:18.75pt'>&nbsp;</td>
  <td colspan=9 class=xl246 style='border-right:.5pt solid black;border-left:
  none'>Permanent Request</td>
  <td colspan=9 class=xl246 style='border-right:.5pt solid black'>Temporary
  Request</td>
  <td class=xl120>&nbsp;</td>
  <td class=xl118></td>
 </tr>

 <tr class=xl125 height=7 style='mso-height-source:userset;height:5.25pt'>
  <td height=7 class=xl121 style='height:5.25pt'>&nbsp;</td>
  <td rowspan=5 class=xl232 style='border-bottom:.5pt solid black'>1</td>
  <td colspan=2 rowspan=5 class=xl235 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black'>From $1 - $200</td>
  <td class=xl122 style='border-left:none'>&nbsp;</td>
  <td class=xl123>&nbsp;</td>
  <td class=xl123>&nbsp;</td>
  <td class=xl123>&nbsp;</td>
  <td class=xl123>&nbsp;</td>
  <td class=xl123>&nbsp;</td>
  <td class=xl123>&nbsp;</td>
  <td class=xl123>&nbsp;</td>
  <td class=xl124>&nbsp;</td>
  <td class=xl123>&nbsp;</td>
  <td class=xl123>&nbsp;</td>
  <td class=xl123>&nbsp;</td>
  <td class=xl123>&nbsp;</td>
  <td class=xl123>&nbsp;</td>
  <td class=xl123>&nbsp;</td>
  <td class=xl123>&nbsp;</td>
  <td class=xl123>&nbsp;</td>
  <td class=xl124>&nbsp;</td>
  <td class=xl120>&nbsp;</td>
  <td class=xl125>&nbsp;</td>
 </tr>

 <tr class=xl134 height=23 style='mso-height-source:userset;height:17.25pt'>
  <td height=23 class=xl126 style='height:17.25pt'>&nbsp;</td>
  <td class=xl127 style='border-left:none'>&nbsp;</td>
  <td class=xl128>&nbsp;</td>
  <td class=xl129 style='border-left:none'>1/</td>
  <td class=xl130>ការឯកភាពពីគណៈគ្រប់គ្រង</td>
  <td class=xl128>&nbsp;</td>
  <td class=xl131>2/</td>
  <td class=xl130 colspan=2 style='mso-ignore:colspan'>រូបភាព</td>
  <td class=xl132>&nbsp;</td>
  <td class=xl130></td>
  <td class=xl128>&nbsp;</td>
  <td class=xl129 style='border-left:none'>1/</td>
  <td class=xl130>ការឯកភាពពីគណៈគ្រប់គ្រង</td>
  <td class=xl133>&nbsp;</td>
  <td class=xl129>2/</td>
  <td class=xl130 colspan=2 style='mso-ignore:colspan'>រូបភាព</td>
  <td class=xl132>&nbsp;</td>
  <td class=xl120>&nbsp;</td>
  <td class=xl134></td>
 </tr>

 <tr class=xl134 height=9 style='mso-height-source:userset;height:6.75pt'>
  <td height=9 class=xl126 style='height:6.75pt'>&nbsp;</td>
  <td class=xl127 style='border-left:none'>&nbsp;</td>
  <td class=xl135 style='border-top:none'>&nbsp;</td>
  <td class=xl131></td>
  <td class=xl130></td>
  <td class=xl136></td>
  <td class=xl131></td>
  <td class=xl130></td>
  <td class=xl130></td>
  <td class=xl132>&nbsp;</td>
  <td class=xl130></td>
  <td class=xl137>&nbsp;</td>
  <td class=xl131></td>
  <td class=xl130></td>
  <td class=xl136></td>
  <td class=xl131></td>
  <td class=xl130></td>
  <td class=xl130></td>
  <td class=xl132>&nbsp;</td>
  <td class=xl120>&nbsp;</td>
  <td class=xl134></td>
 </tr>

 <tr class=xl134 height=23 style='mso-height-source:userset;height:17.25pt'>
  <td height=23 class=xl126 style='height:17.25pt'>&nbsp;</td>
  <td class=xl127 style='border-left:none'>&nbsp;</td>
  <td class=xl136></td>
  <td class=xl131></td>
  <td class=xl130></td>
  <td class=xl136></td>
  <td class=xl131></td>
  <td class=xl130></td>
  <td class=xl130></td>
  <td class=xl132>&nbsp;</td>
  <td class=xl130></td>
  <td class=xl128 style='border-top:none'>&nbsp;</td>
  <td class=xl131>3/</td>
  <td class=xl130 colspan=5 style='mso-ignore:colspan'>កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ)</td>
  <td class=xl132>&nbsp;</td>
  <td class=xl120>&nbsp;</td>
  <td class=xl134></td>
 </tr>

 <tr height=7 style='mso-height-source:userset;height:5.25pt'>
  <td height=7 class=xl115 style='height:5.25pt'>&nbsp;</td>
  <td class=xl138 style='border-left:none'>&nbsp;</td>
  <td class=xl139></td>
  <td class=xl140>&nbsp;</td>
  <td class=xl141>&nbsp;</td>
  <td class=xl142>&nbsp;</td>
  <td class=xl142>&nbsp;</td>
  <td class=xl142>&nbsp;</td>
  <td class=xl142>&nbsp;</td>
  <td class=xl143>&nbsp;</td>
  <td class=xl142>&nbsp;</td>
  <td class=xl142>&nbsp;</td>
  <td class=xl144></td>
  <td class=xl142>&nbsp;</td>
  <td class=xl142>&nbsp;</td>
  <td class=xl145>&nbsp;</td>
  <td class=xl145>&nbsp;</td>
  <td class=xl145>&nbsp;</td>
  <td class=xl146>&nbsp;</td>
  <td class=xl120>&nbsp;</td>
  <td class=xl118></td>
 </tr>

 <tr height=7 style='mso-height-source:userset;height:5.25pt'>
  <td height=7 class=xl115 style='height:5.25pt'>&nbsp;</td>
  <td rowspan=7 class=xl232 style='border-bottom:.5pt solid black'>2</td>
  <td colspan=2 rowspan=7 class=xl235 style='border-right:.5pt solid black'>from
  $201 - $300</td>
  <td class=xl147 style='border-left:none'>&nbsp;</td>
  <td class=xl148>&nbsp;</td>
  <td class=xl139></td>
  <td class=xl149></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl150>&nbsp;</td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl151>&nbsp;</td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl152></td>
  <td class=xl152></td>
  <td class=xl152></td>
  <td class=xl153>&nbsp;</td>
  <td class=xl120>&nbsp;</td>
  <td class=xl118></td>
 </tr>

 <tr height=23 style='mso-height-source:userset;height:17.25pt'>
  <td height=23 class=xl115 style='height:17.25pt'>&nbsp;</td>
  <td class=xl154 style='border-left:none'>&nbsp;</td>
  <td class=xl155>&nbsp;</td>
  <td class=xl129 style='border-left:none'>1/</td>
  <td class=xl130>ការឯកភាពពីគណៈគ្រប់គ្រង</td>
  <td class=xl128>&nbsp;</td>
  <td class=xl131>2/</td>
  <td class=xl130 colspan=2 style='mso-ignore:colspan'>រូបភាព</td>
  <td class=xl132>&nbsp;</td>
  <td class=xl144></td>
  <td class=xl128>&nbsp;</td>
  <td class=xl129 style='border-left:none'>1/</td>
  <td class=xl130>ការឯកភាពពីគណៈគ្រប់គ្រង</td>
  <td class=xl133>&nbsp;</td>
  <td class=xl129>2/</td>
  <td class=xl130 colspan=2 style='mso-ignore:colspan'>រូបភាព</td>
  <td class=xl150>&nbsp;</td>
  <td class=xl120>&nbsp;</td>
  <td class=xl118></td>
 </tr>

 <tr height=7 style='mso-height-source:userset;height:5.25pt'>
  <td height=7 class=xl115 style='height:5.25pt'>&nbsp;</td>
  <td class=xl147 style='border-left:none'>&nbsp;</td>
  <td class=xl148 style='border-top:none'>&nbsp;</td>
  <td class=xl139></td>
  <td class=xl149></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl150>&nbsp;</td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl152></td>
  <td class=xl152></td>
  <td class=xl152></td>
  <td class=xl153>&nbsp;</td>
  <td class=xl120>&nbsp;</td>
  <td class=xl118></td>
 </tr>

 <tr height=23 style='mso-height-source:userset;height:17.25pt'>
  <td height=23 class=xl115 style='height:17.25pt'>&nbsp;</td>
  <td class=xl154 style='border-left:none'>&nbsp;</td>
  <td class=xl155>&nbsp;</td>
  <td class=xl129 style='border-left:none'>3/</td>
  <td class=xl130 colspan=6 style='mso-ignore:colspan;border-right:.5pt solid black'>កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ)</td>
  <td class=xl144></td>
  <td class=xl128>&nbsp;</td>
  <td class=xl129 style='border-left:none'>3/</td>
  <td class=xl130 colspan=5 style='mso-ignore:colspan'>កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ)</td>
  <td class=xl150>&nbsp;</td>
  <td class=xl120>&nbsp;</td>
  <td class=xl118></td>
 </tr>

 <tr height=7 style='mso-height-source:userset;height:5.25pt'>
  <td height=7 class=xl115 style='height:5.25pt'>&nbsp;</td>
  <td class=xl147 style='border-left:none'>&nbsp;</td>
  <td class=xl148 style='border-top:none'>&nbsp;</td>
  <td class=xl139></td>
  <td class=xl149></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl150>&nbsp;</td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl152></td>
  <td class=xl152></td>
  <td class=xl152></td>
  <td class=xl153>&nbsp;</td>
  <td class=xl120>&nbsp;</td>
  <td class=xl118></td>
 </tr>

 <tr height=24 style='mso-height-source:userset;height:18.0pt'>
  <td height=24 class=xl115 style='height:18.0pt'>&nbsp;</td>
  <td class=xl147 style='border-left:none'>&nbsp;</td>
  <td class=xl155>&nbsp;</td>
  <td class=xl129 style='border-left:none'>4/</td>
  <td class=xl130 colspan=4 style='mso-ignore:colspan'>&#6042;.&#6031;&#6070;&#6040;&#6026;&#6070;&#6035;&#6021;&#6086;&#6030;&#6070;&#6041;,
  &#6042;.&#6047;&#6098;&#6031;&#6075;&#6016;,
  &#6042;.&#6023;&#6077;&#6047;&#6023;&#6075;&#6043;&#6018;&#6098;&#6042;&#6079;&#6020;&#6021;&#6016;&#6098;&#6042;</td>
  <td class=xl144></td>
  <td class=xl150>&nbsp;</td>
  <td class=xl144></td>
  <td class=xl155>&nbsp;</td>
  <td class=xl129 style='border-left:none'>4/</td>
  <td class=xl130 colspan=3 style='mso-ignore:colspan'>&#6042;.&#6031;&#6070;&#6040;&#6026;&#6070;&#6035;&#6021;&#6086;&#6030;&#6070;&#6041;,
  &#6042;.&#6047;&#6098;&#6031;&#6075;&#6016;,
  &#6042;.&#6023;&#6077;&#6047;&#6023;&#6075;&#6043;&#6018;&#6098;&#6042;&#6079;&#6020;&#6021;&#6016;&#6098;&#6042;</td>
  <td class=xl152></td>
  <td class=xl152></td>
  <td class=xl153>&nbsp;</td>
  <td class=xl120>&nbsp;</td>
  <td class=xl118></td>
 </tr>

 <tr height=7 style='mso-height-source:userset;height:5.25pt'>
  <td height=7 class=xl115 style='height:5.25pt'>&nbsp;</td>
  <td class=xl147 style='border-left:none'>&nbsp;</td>
  <td class=xl156 style='border-top:none'>&nbsp;</td>
  <td class=xl139></td>
  <td class=xl149></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl150>&nbsp;</td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl142>&nbsp;</td>
  <td class=xl145>&nbsp;</td>
  <td class=xl145>&nbsp;</td>
  <td class=xl145>&nbsp;</td>
  <td class=xl146>&nbsp;</td>
  <td class=xl120>&nbsp;</td>
  <td class=xl118></td>
 </tr>

 <tr height=7 style='mso-height-source:userset;height:5.25pt'>
  <td height=7 class=xl115 style='height:5.25pt'>&nbsp;</td>
  <td rowspan=11 class=xl232 style='border-bottom:.5pt solid black'>3</td>
  <td colspan=2 rowspan=11 class=xl235 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black'>From $301 -$1000</td>
  <td class=xl157 style='border-left:none'>&nbsp;</td>
  <td class=xl148>&nbsp;</td>
  <td class=xl156>&nbsp;</td>
  <td class=xl158>&nbsp;</td>
  <td class=xl151>&nbsp;</td>
  <td class=xl151>&nbsp;</td>
  <td class=xl151>&nbsp;</td>
  <td class=xl151>&nbsp;</td>
  <td class=xl159>&nbsp;</td>
  <td class=xl151>&nbsp;</td>
  <td class=xl151>&nbsp;</td>
  <td class=xl151>&nbsp;</td>
  <td class=xl151>&nbsp;</td>
  <td class=xl144></td>
  <td class=xl152></td>
  <td class=xl152></td>
  <td class=xl152></td>
  <td class=xl153>&nbsp;</td>
  <td class=xl120>&nbsp;</td>
  <td class=xl118></td>
 </tr>

 <tr height=24 style='mso-height-source:userset;height:18.0pt'>
  <td height=24 class=xl115 style='height:18.0pt'>&nbsp;</td>
  <td class=xl147 style='border-left:none'>&nbsp;</td>
  <td class=xl155>&nbsp;</td>
  <td class=xl129 style='border-left:none'>1/</td>
  <td class=xl130>&#6016;&#6070;&#6042;&#6063;&#6016;&#6039;&#6070;&#6038;&#6038;&#6072;&#6018;&#6030;&#6088;&#6018;&#6098;&#6042;&#6036;&#6091;&#6018;&#6098;&#6042;&#6020;</td>
  <td class=xl128>&nbsp;</td>
  <td class=xl131>2/</td>
  <td class=xl130 colspan=2 style='mso-ignore:colspan'>&#6042;&#6076;&#6036;&#6039;&#6070;&#6038;</td>
  <td class=xl150>&nbsp;</td>
  <td class=xl144></td>
  <td class=xl155>&nbsp;</td>
  <td class=xl129 style='border-left:none'>1/</td>
  <td class=xl130>&#6016;&#6070;&#6042;&#6063;&#6016;&#6039;&#6070;&#6038;&#6038;&#6072;&#6018;&#6030;&#6088;&#6018;&#6098;&#6042;&#6036;&#6091;&#6018;&#6098;&#6042;&#6020;</td>
  <td class=xl133>&nbsp;</td>
  <td class=xl129>2/</td>
  <td class=xl130 colspan=2 style='mso-ignore:colspan'>&#6042;&#6076;&#6036;&#6039;&#6070;&#6038;</td>
  <td class=xl153>&nbsp;</td>
  <td class=xl120>&nbsp;</td>
  <td class=xl118></td>
 </tr>

 <tr height=7 style='mso-height-source:userset;height:5.25pt'>
  <td height=7 class=xl115 style='height:5.25pt'>&nbsp;</td>
  <td class=xl147 style='border-left:none'>&nbsp;</td>
  <td class=xl148 style='border-top:none'>&nbsp;</td>
  <td class=xl139></td>
  <td class=xl149></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl150>&nbsp;</td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl152></td>
  <td class=xl152></td>
  <td class=xl152></td>
  <td class=xl153>&nbsp;</td>
  <td class=xl120>&nbsp;</td>
  <td class=xl118></td>
 </tr>

 <tr height=24 style='mso-height-source:userset;height:18.0pt'>
  <td height=24 class=xl115 style='height:18.0pt'>&nbsp;</td>
  <td class=xl147 style='border-left:none'>&nbsp;</td>
  <td class=xl155>&nbsp;</td>
  <td class=xl129 style='border-left:none'>3/</td>
  <td class=xl130 colspan=6 style='mso-ignore:colspan;border-right:.5pt solid black'>&#6016;&#6086;&#6030;&#6031;&#6091;&#6048;&#6081;&#6031;&#6075;
  &#6060;&#6040;&#6076;&#6043;&#6048;&#6081;&#6031;&#6075;&#6035;&#6083;&#6016;&#6070;&#6042;&#6023;&#6077;&#6047;&#6023;&#6075;&#6043;
  (&#6036;&#6086;&#6038;&#6081;&#6025;&#6016;&#6098;&#6035;&#6075;&#6020;&#6047;&#6086;&#6030;&#6078;&#6042;)</td>
  <td class=xl144></td>
  <td class=xl155>&nbsp;</td>
  <td class=xl129 style='border-left:none'>3/</td>
  <td class=xl130 colspan=5 style='mso-ignore:colspan'>&#6016;&#6086;&#6030;&#6031;&#6091;&#6048;&#6081;&#6031;&#6075;
  &#6060;&#6040;&#6076;&#6043;&#6048;&#6081;&#6031;&#6075;&#6035;&#6083;&#6016;&#6070;&#6042;&#6023;&#6077;&#6047;&#6023;&#6075;&#6043;
  (&#6036;&#6086;&#6038;&#6081;&#6025;&#6016;&#6098;&#6035;&#6075;&#6020;&#6047;&#6086;&#6030;&#6078;&#6042;)</td>
  <td class=xl153>&nbsp;</td>
  <td class=xl120>&nbsp;</td>
  <td class=xl118></td>
 </tr>

 <tr height=7 style='mso-height-source:userset;height:5.25pt'>
  <td height=7 class=xl115 style='height:5.25pt'>&nbsp;</td>
  <td class=xl147 style='border-left:none'>&nbsp;</td>
  <td class=xl148 style='border-top:none'>&nbsp;</td>
  <td class=xl139></td>
  <td class=xl149></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl150>&nbsp;</td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl152></td>
  <td class=xl152></td>
  <td class=xl152></td>
  <td class=xl153>&nbsp;</td>
  <td class=xl120>&nbsp;</td>
  <td class=xl118></td>
 </tr>

 <tr height=24 style='mso-height-source:userset;height:18.0pt'>
  <td height=24 class=xl115 style='height:18.0pt'>&nbsp;</td>
  <td class=xl147 style='border-left:none'>&nbsp;</td>
  <td class=xl155>&nbsp;</td>
  <td class=xl129 style='border-left:none'>4/</td>
  <td class=xl130 colspan=4 style='mso-ignore:colspan'>&#6042;.&#6031;&#6070;&#6040;&#6026;&#6070;&#6035;&#6021;&#6086;&#6030;&#6070;&#6041;,
  &#6042;.&#6047;&#6098;&#6031;&#6075;&#6016;,
  &#6042;.&#6023;&#6077;&#6047;&#6023;&#6075;&#6043;&#6018;&#6098;&#6042;&#6079;&#6020;&#6021;&#6016;&#6098;&#6042;</td>
  <td class=xl144></td>
  <td class=xl150>&nbsp;</td>
  <td class=xl144></td>
  <td class=xl155>&nbsp;</td>
  <td class=xl129 style='border-left:none'>4/</td>
  <td class=xl130 colspan=3 style='mso-ignore:colspan'>&#6042;.&#6031;&#6070;&#6040;&#6026;&#6070;&#6035;&#6021;&#6086;&#6030;&#6070;&#6041;,
  &#6042;.&#6047;&#6098;&#6031;&#6075;&#6016;,
  &#6042;.&#6023;&#6077;&#6047;&#6023;&#6075;&#6043;&#6018;&#6098;&#6042;&#6079;&#6020;&#6021;&#6016;&#6098;&#6042;</td>
  <td class=xl152></td>
  <td class=xl152></td>
  <td class=xl153>&nbsp;</td>
  <td class=xl120>&nbsp;</td>
  <td class=xl118></td>
 </tr>

 <tr height=7 style='mso-height-source:userset;height:5.25pt'>
  <td height=7 class=xl115 style='height:5.25pt'>&nbsp;</td>
  <td class=xl147 style='border-left:none'>&nbsp;</td>
  <td class=xl148 style='border-top:none'>&nbsp;</td>
  <td class=xl139></td>
  <td class=xl149></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl150>&nbsp;</td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl152></td>
  <td class=xl152></td>
  <td class=xl152></td>
  <td class=xl153>&nbsp;</td>
  <td class=xl120>&nbsp;</td>
  <td class=xl118></td>
 </tr>

 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl115 style='height:15.75pt'>&nbsp;</td>
  <td class=xl147 style='border-left:none'>&nbsp;</td>
  <td class=xl155>&nbsp;</td>
  <td class=xl129 style='border-left:none'>5/</td>
  <td class=xl130>&#6037;&#6082;&#6035;&#6016;&#6070;&#6042;&#6036;&#6098;&#6042;&#6078;&#6036;&#6098;&#6042;&#6070;&#6047;&#6091;&#6047;&#6086;&#6039;&#6070;&#6042;&#6088;&#6037;&#6043;&#6071;&#6031;</td>
  <td class=xl128>&nbsp;</td>
  <td class=xl131>6/</td>
  <td class=xl136 colspan=2 style='mso-ignore:colspan'>Quotation</td>
  <td class=xl150>&nbsp;</td>
  <td class=xl144></td>
  <td class=xl155>&nbsp;</td>
  <td class=xl129 style='border-left:none'>5/</td>
  <td class=xl130>&#6037;&#6082;&#6035;&#6016;&#6070;&#6042;&#6036;&#6098;&#6042;&#6078;&#6036;&#6098;&#6042;&#6070;&#6047;&#6091;&#6047;&#6086;&#6039;&#6070;&#6042;&#6088;&#6037;&#6043;&#6071;&#6031;</td>
  <td class=xl128>&nbsp;</td>
  <td class=xl131>6/</td>
  <td class=xl136 colspan=2 style='mso-ignore:colspan'>Quotation</td>
  <td class=xl153>&nbsp;</td>
  <td class=xl120>&nbsp;</td>
  <td class=xl118></td>
 </tr>

 <tr height=7 style='mso-height-source:userset;height:5.25pt'>
  <td height=7 class=xl115 style='height:5.25pt'>&nbsp;</td>
  <td class=xl147 style='border-left:none'>&nbsp;</td>
  <td class=xl148 style='border-top:none'>&nbsp;</td>
  <td class=xl139></td>
  <td class=xl149></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl150>&nbsp;</td>
  <td class=xl144></td>
  <td class=xl148 style='border-top:none'>&nbsp;</td>
  <td class=xl139></td>
  <td class=xl149></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl144></td>
  <td class=xl153>&nbsp;</td>
  <td class=xl120>&nbsp;</td>
  <td class=xl118></td>
 </tr>

 <tr height=23 style='mso-height-source:userset;height:17.25pt'>
  <td height=23 class=xl115 style='height:17.25pt'>&nbsp;</td>
  <td class=xl147 style='border-left:none'>&nbsp;</td>
  <td class=xl155>&nbsp;</td>
  <td class=xl129 style='border-left:none'>7/</td>
  <td class=xl130>&#6037;&#6098;&#6047;&#6081;&#6020;&#6103;</td>
  <td class=xl136></td>
  <td class=xl131></td>
  <td class=xl130></td>
  <td class=xl144></td>
  <td class=xl150>&nbsp;</td>
  <td class=xl144></td>
  <td class=xl155>&nbsp;</td>
  <td class=xl129 style='border-left:none'>7/</td>
  <td class=xl130>&#6037;&#6098;&#6047;&#6081;&#6020;&#6103;</td>
  <td class=xl136></td>
  <td class=xl131></td>
  <td class=xl130></td>
  <td class=xl144></td>
  <td class=xl153>&nbsp;</td>
  <td class=xl120>&nbsp;</td>
  <td class=xl118></td>
 </tr>

 <tr height=7 style='mso-height-source:userset;height:5.25pt'>
  <td height=7 class=xl115 style='height:5.25pt'>&nbsp;</td>
  <td class=xl138 style='border-left:none'>&nbsp;</td>
  <td class=xl148 style='border-top:none'>&nbsp;</td>
  <td class=xl140>&nbsp;</td>
  <td class=xl141>&nbsp;</td>
  <td class=xl142>&nbsp;</td>
  <td class=xl142>&nbsp;</td>
  <td class=xl142>&nbsp;</td>
  <td class=xl142>&nbsp;</td>
  <td class=xl143>&nbsp;</td>
  <td class=xl142>&nbsp;</td>
  <td class=xl148 style='border-top:none'>&nbsp;</td>
  <td class=xl140>&nbsp;</td>
  <td class=xl141>&nbsp;</td>
  <td class=xl142>&nbsp;</td>
  <td class=xl142>&nbsp;</td>
  <td class=xl142>&nbsp;</td>
  <td class=xl142>&nbsp;</td>
  <td class=xl146>&nbsp;</td>
  <td class=xl120>&nbsp;</td>
  <td class=xl118></td>
 </tr>

 <tr height=16 style='mso-height-source:userset;height:12.0pt'>
  <td height=16 class=xl76 style='height:12.0pt'>&nbsp;</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl160></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl162></td>
  <td class=xl163></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=13 style='mso-height-source:userset;height:9.75pt'>
  <td height=13 class=xl76 style='height:9.75pt'>&nbsp;</td>
  <td class=xl164>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl166>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165 style='border-top:none'>&nbsp;</td>
  <td class=xl165 style='border-top:none'>&nbsp;</td>
  <td class=xl165 style='border-top:none'>&nbsp;</td>
  <td class=xl165 style='border-top:none'>&nbsp;</td>
  <td class=xl167>&nbsp;</td>
  <td class=xl168>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl169>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=26 style='mso-height-source:userset;height:19.5pt'>
  <td height=26 class=xl170 style='height:19.5pt'>&nbsp;</td>
  <td class=xl171>&nbsp;</td>
  <td colspan=6 class=xl252>Request Report
  by(&#6050;&#6098;&#6035;&#6016;&#6047;&#6098;&#6035;&#6078;&#6042;&#6042;&#6036;&#6070;&#6041;&#6016;&#6070;&#6042;&#6030;&#6095;&#6026;&#6084;&#6041;):</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl162></td>
  <td class=xl163></td>
  <td colspan=6 class=xl252 style='border-right:.5pt solid black'>Checked
  by(&#6031;&#6098;&#6042;&#6077;&#6031;&#6038;&#6071;&#6035;&#6071;&#6031;&#6098;&#6041;&#6026;&#6084;&#6041;):</td>
  <td class=xl172>&nbsp;</td>
  <td></td>
 </tr>

 <tr class=xl174 height=26 style='mso-height-source:userset;height:19.5pt'>
  <td height=26 class=xl76 style='height:19.5pt'>&nbsp;</td>
  <td class=xl173>&nbsp;</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl160></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl174></td>
  <td colspan=2 class=xl254></td>
  <td class=xl162></td>
  <td class=xl163></td>
  <td></td>
  <td></td>
  <td class=xl174></td>
  <td></td>
  <td></td>
  <td class=xl175>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td class=xl174></td>
 </tr>

 <tr height=26 style='mso-height-source:userset;height:19.5pt'>
  <td height=26 class=xl76 style='height:19.5pt'>&nbsp;</td>
  <td class=xl173>&nbsp;</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl160></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl162></td>
  <td class=xl163></td>
  <td class=xl174></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl175>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=26 style='mso-height-source:userset;height:19.5pt'>
  <td height=26 class=xl76 style='height:19.5pt'>&nbsp;</td>
  <td class=xl173>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl162></td>
  <td class=xl163></td>
  <td class=xl176>&nbsp;</td>
  <td class=xl176>&nbsp;</td>
  <td class=xl176>&nbsp;</td>
  <td class=xl176>&nbsp;</td>
  <td class=xl176>&nbsp;</td>
  <td class=xl177>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=26 style='mso-height-source:userset;height:19.5pt'>
  <td height=26 class=xl76 style='height:19.5pt'>&nbsp;</td>
  <td class=xl178>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl176>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl179>&nbsp;</td>
  <td class=xl180>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl181>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl76 style='height:15.75pt'>&nbsp;</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl160></td>
  <td></td>
  <td></td>
  <td class=xl182 style='border-top:none'>&nbsp;</td>
  <td class=xl182 style='border-top:none'>&nbsp;</td>
  <td class=xl182 style='border-top:none'>&nbsp;</td>
  <td class=xl182 style='border-top:none'>&nbsp;</td>
  <td class=xl182 style='border-top:none'>&nbsp;</td>
  <td class=xl183 style='border-top:none'>&nbsp;</td>
  <td class=xl184 style='border-top:none'>&nbsp;</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=19 style='mso-height-source:userset;height:14.25pt'>
  <td height=19 class=xl76 style='height:14.25pt'>&nbsp;</td>
  <td class=xl164>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl166>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td colspan=2 class=xl249>&nbsp;</td>
  <td class=xl167>&nbsp;</td>
  <td class=xl168>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl169>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=26 style='mso-height-source:userset;height:19.5pt'>
  <td height=26 class=xl185 style='height:19.5pt'>&nbsp;</td>
  <td class=xl186>&nbsp;</td>
  <td class=xl187 colspan=6 style='mso-ignore:colspan'>First Aprroved
  by(&#6063;&#6016;&#6039;&#6070;&#6038;&#6026;&#6084;&#6041; &#6033;&#6072;
  1):</td>
  <td></td>
  <td class=xl174></td>
  <td class=xl189></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl162></td>
  <td class=xl163></td>
  <td colspan=5 class=xl252>Payment
  by(&#6033;&#6077;&#6033;&#6070;&#6031;&#6091;&#6026;&#6084;&#6041;):</td>
  <td class=xl175>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>

 <tr class=xl189 height=26 style='mso-height-source:userset;height:19.5pt'>
  <td height=26 class=xl76 style='height:19.5pt'>&nbsp;</td>
  <td class=xl173>&nbsp;</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl189></td>
  <td class=xl189></td>
  <td class=xl189></td>
  <td></td>
  <td></td>
  <td class=xl189></td>
  <td></td>
  <td></td>
  <td class=xl162></td>
  <td class=xl163></td>
  <td class=xl160></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl175>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td class=xl189></td>
 </tr>

 <tr height=26 style='mso-height-source:userset;height:19.5pt'>
  <td height=26 class=xl76 style='height:19.5pt'>&nbsp;</td>
  <td class=xl173>&nbsp;</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl162></td>
  <td class=xl163></td>
  <td class=xl160></td>
  <td></td>
  <td></td>
  <td class=xl189></td>
  <td class=xl189></td>
  <td class=xl190>&nbsp;</td>
  <td class=xl191>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=26 style='mso-height-source:userset;height:19.5pt'>
  <td height=26 class=xl76 style='height:19.5pt'>&nbsp;</td>
  <td class=xl173>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td></td>
  <td></td>
  <td class=xl189></td>
  <td class=xl189></td>
  <td class=xl162></td>
  <td class=xl163></td>
  <td class=xl176>&nbsp;</td>
  <td class=xl176>&nbsp;</td>
  <td class=xl176>&nbsp;</td>
  <td class=xl176>&nbsp;</td>
  <td class=xl176>&nbsp;</td>
  <td class=xl175>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=26 style='mso-height-source:userset;height:19.5pt'>
  <td height=26 class=xl76 style='height:19.5pt'>&nbsp;</td>
  <td class=xl178>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl176>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td colspan=2 class=xl253>&nbsp;</td>
  <td class=xl179>&nbsp;</td>
  <td class=xl192>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl181>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl76 style='height:15.75pt'>&nbsp;</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl160></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl182 style='border-top:none'>&nbsp;</td>
  <td class=xl182 style='border-top:none'>&nbsp;</td>
  <td class=xl182 style='border-top:none'>&nbsp;</td>
  <td class=xl182 style='border-top:none'>&nbsp;</td>
  <td class=xl183 style='border-top:none'>&nbsp;</td>
  <td class=xl193></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=13 style='mso-height-source:userset;height:9.75pt'>
  <td height=13 class=xl76 style='height:9.75pt'>&nbsp;</td>
  <td class=xl164>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl166>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl167>&nbsp;</td>
  <td class=xl194>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl165>&nbsp;</td>
  <td class=xl169>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>


 <tr height=26 style='mso-height-source:userset;height:19.5pt'>
  <td height=26 class=xl185 style='height:19.5pt'>&nbsp;</td>
  <td class=xl186>&nbsp;</td>
  <td class=xl187 colspan=6 style='mso-ignore:colspan'>Second Aprroved
  by(&#6063;&#6016;&#6039;&#6070;&#6038;&#6026;&#6084;&#6041; &#6033;&#6072;
  2):</td>
  <td class=xl188></td>
  <td class=xl189></td>
  <td class=xl189></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl162></td>
  <td class=xl193></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl175>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>

 <tr class=xl189 height=26 style='mso-height-source:userset;height:19.5pt'>
  <td height=26 class=xl76 style='height:19.5pt'>&nbsp;</td>
  <td class=xl173>&nbsp;</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl160></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl189></td>
  <td></td>
  <td></td>
  <td class=xl162></td>
  <td class=xl193></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl175>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td class=xl189></td>
 </tr>

 <tr height=26 style='mso-height-source:userset;height:19.5pt'>
  <td height=26 class=xl76 style='height:19.5pt'>&nbsp;</td>
  <td class=xl173>&nbsp;</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl160></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td colspan=2 class=xl254></td>
  <td class=xl162></td>
  <td class=xl193></td>
  <td class=xl189></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl175>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=26 style='mso-height-source:userset;height:19.5pt'>
  <td height=26 class=xl76 style='height:19.5pt'>&nbsp;</td>
  <td class=xl173>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl162></td>
  <td class=xl193></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td class=xl175>&nbsp;</td>
  <td class=xl77>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=26 style='mso-height-source:userset;height:19.5pt'>
  <td height=26 class=xl76 style='height:19.5pt'>&nbsp;</td>
  <td class=xl178>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl176>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl179>&nbsp;</td>
  <td class=xl192>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl161>&nbsp;</td>
  <td class=xl196>&nbsp;</td>
  <td class=xl196>&nbsp;</td>
  <td class=xl197>&nbsp;</td>
  <td class=xl191>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=18 style='mso-height-source:userset;height:13.5pt'>
  <td height=18 class=xl86 style='height:13.5pt'>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl198>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl199>&nbsp;</td>
  <td class=xl199>&nbsp;</td>
  <td class=xl200>&nbsp;</td>
  <td class=xl201>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl199>&nbsp;</td>
  <td class=xl199>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl93>&nbsp;</td>
  <td></td>
 </tr>

 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl118 style='height:15.75pt'></td>
  <td class=xl118></td>
  <td class=xl118></td>
  <td class=xl118></td>
  <td class=xl118></td>
  <td class=xl118></td>
  <td class=xl118></td>
  <td class=xl118></td>
  <td class=xl118></td>
  <td class=xl118></td>
  <td class=xl118></td>
  <td class=xl118></td>
  <td class=xl118></td>
  <td class=xl118></td>
  <td class=xl118></td>
  <td class=xl118></td>
  <td class=xl118></td>
  <td class=xl118></td>
  <td class=xl118></td>
  <td class=xl118></td>
  <td class=xl118></td>
  <td class=xl118></td>
  <td class=xl118></td>
  <td class=xl118></td>
 </tr>

 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=15 style='width:11pt'></td>
  <td width=38 style='width:29pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=41 style='width:31pt'></td>
  <td width=5 style='width:4pt'></td>
  <td width=24 style='width:18pt'></td>
  <td width=20 style='width:15pt'></td>
  <td width=153 style='width:115pt'></td>
  <td width=24 style='width:18pt'></td>
  <td width=18 style='width:14pt'></td>
  <td width=29 style='width:22pt'></td>
  <td width=33 style='width:25pt'></td>
  <td width=7 style='width:5pt'></td>
  <td width=7 style='width:5pt'></td>
  <td width=23 style='width:17pt'></td>
  <td width=20 style='width:15pt'></td>
  <td width=179 style='width:134pt'></td>
  <td width=22 style='width:17pt'></td>
  <td width=23 style='width:17pt'></td>
  <td width=23 style='width:17pt'></td>
  <td width=96 style='width:72pt'></td>
  <td width=30 style='width:23pt'></td>
  <td width=8 style='width:6pt'></td>
  <td width=14 style='width:11pt'></td>
 </tr>

 <![endif]>
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



