<?php 
    include_once '../../config/database.php';
    include_once 'my_function.php';
    include_once '../acc_my_operation/my_operation.php';
?>
<?php 

$sql=$connect->query("SELECT comci_name_kh,comci_name_en,comci_name_ch,comci_logo FROM tbl_com_company_info");
$row_header=mysqli_fetch_object($sql);

if(@$_GET['date_start']==''&&@$_GET['date_end']==''){
    $status=false;
}   
else{
    $status=true;
    $v_date_start=@$_GET['date_start'];
    $v_date_end=@$_GET['date_end'];
}
 ?>

<?php 
    function clearNull($v_data){
        $result="";
        if($v_data==0)
            $result="";
        else if($v_data<0)
            $result='('.number_format(abs($v_data),2).')';
        else
            $result=number_format($v_data,2);
        return $result;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Khmer&family=Time New Roman" rel="stylesheet">
    <style type="text/css">
        *{ 
            font-size: 12px!important; 
            font-family: 'Khmer', 'Time New Roman';
            -webkit-print-color-adjust: exact;
        }
        .titleType{
            -webkit-print-color-adjust: exact;
            background-color: #FFF2CC!important; 
            padding: 10px; 
            color: black;
        }
        .table tfoot tr:nth-child(1) td{ 
            background: #DDEBF7!important;
            padding: 10px;
            -webkit-print-color-adjust: exact;
        }
        .table tfoot tr:nth-child(2) td{ 
            padding: 10px;
            background: #FCE4D6!important;
            -webkit-print-color-adjust: exact;
        }
        .table tfoot tr td >div{
            width: 90%; 
            border-top: 1px solid black; 
            margin: auto; padding: 10px;
        }
        .table tr:nth-child(even) td{ 
            background: #F2F2F2!important;
            -webkit-print-color-adjust: exact;
        }
    </style> 
</head>
<body>
    <link rel="stylesheet" href="../../print_offline/bootstrap.min.css">
    <script src="../../print_offline/jquery.min.js"></script>
    <div class="container">
        <div class="row text-center my_title">
            <p style="font-size: 30px!important; font-family: 'Time New Romen'!important; font-weight: bold;"><?= $row_header->comci_name_en ?></p>
            <p style="font-size: 20px!important; font-weight: bold;" class="text-uppercase">Income Statetment</p>
            <p style="font-size: 16px!important;" class="text-uppercase">From <?= (@$v_date_start)?(@$v_date_start):date("Y-m-d") ?> To <?= (@$v_date_end)?(@$v_date_end):date("Y-m-d"); ?></p>
            <p style="font-size: 16px!important;" class="text-uppercase">Currency : USD</p>
        </div>
    </div><br>
    <div class="container-fluid">
        <div class="container-fluid" style="margin: 0px;">
            <div style="width: 450px;" class="pull-right">
                <div class="pull-right text-center" style="width: 85px; padding: 0px;">
                    <div style=" width: 95%;border-bottom: 2px solid black; padding: 0px;margin: auto;">
                        <h5>YTD<br>Actual</h5>
                    </div>
                </div>
                <div class="pull-right text-center" style="width: 85px;">
                    <div style="width: 95%; border-bottom: 2px solid black;padding: 0px; margin: auto;">
                        <h5>YTD<br>Previous Month</h5>
                    </div>
                </div>
                <div class="pull-right text-center" style="width: 85px;">
                    <div style="width: 95%; border-bottom: 2px solid black;padding: 0px;margin: auto;">
                        <h5>Actual<br>Month</h5>  
                    </div>
                </div> 
            </div>
        </div>
        <div class="portlet-body text-center">
        <div class="list-todo-item dark container-fluid">
            <?php 
                $i=0;
                // $sql=$connect->query("SELECT * FROM tbl_acc_account_type_report WHERE tr_id='5' OR tr_id='4' OR tr_id='6'");

                $v_main_id=5;
                $v_main_name='Income';
                echo '<a class="list-toggle-container" data-toggle="collapse" data-parent="#accordion1" onclick=" " href="#task-0" aria-expanded="false">
                        <div class="list-toggle done uppercase bg-primary" style="background-color: #FFF2CC!important; padding: 10px; color: black;">
                            <div class="list-toggle-title bold text-left">
                            <strong>'.$v_main_name.'</strong>
                            </div>
                        </div>
                    </a>';
                echo '
                <div class="task-list panel-collapse collapse in" id="task-0">
                    <ul>
                        <li class="task-list-item" style="list-style: none;">
                            <div class="task-content">
                                <table class="table table-striped table-bordered myTable">
                                    <tbody>';
                                            $v_bal_current_month_tmp1=0;
                                            $v_bal_old_month_tmp1=0;
                                            $v_bal_current_year_tmp1=0;
                                            if((@$_GET['date_start']&&@$_GET['date_end'])!=''){
                                                $v_date_start=@$_GET['date_start'];
                                                $v_date_end=@$_GET['date_end'];
                                                if($v_date_start>$v_date_end){
                                                    echo '<script>myAlertInfo("Please Choose Date From Before Date End")</script>';
                                                    header( "refresh:3;url=index.php" );
                                                }
                                                // $sql2=my_detail_date($v_main_id,$v_date_start,$v_date_end);
                                            }
                                            else{
                                                $v_date_start=@date('Y-m-d');
                                                $v_date_end=@date('Y-m-d');
                                            }
                                            $sql2=$connect->query(GetAccountName($v_main_id));
                                            while ($row2=mysqli_fetch_object($sql2)) {
                                                echo '<tr>';       
                                                    echo '<td class="text-left">'.$row2->accca_number.'-'.$row2->accca_account_name.'</td>';  
                                                        $current_month_bal=bal_current_month($v_date_start,$v_date_end,$row2->accca_id)+bal_pre_month($v_date_start,$v_date_end,$row2->accca_id);
                                                    echo '<td class="text-center" style="width: 85px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum($current_month_bal).'</span></td>';   
                                                        $old_month_bal=bal_pre_month($v_date_start,$v_date_end,$row2->accca_id);
                                                    echo '<td class="text-center" style="width: 85px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum($old_month_bal).'</span></td>';  
                                                        $current_year_bal=bal_cur_year($v_date_start,$v_date_end,$row2->accca_id);
                                                    echo '<td class="text-center" style="width: 85px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum($current_year_bal).'</span></td>';  
                                                echo '</tr>';
                                                $v_bal_current_month_tmp1+=$current_month_bal;
                                                $v_bal_old_month_tmp1+=$old_month_bal;
                                                $v_bal_current_year_tmp1+=$current_year_bal;
                                            }
                                            
                                echo '</tbody>
                                    <tfoot>
                                        <tr style="background-color: #DDEBF7;">
                                           <td colspan="" class="text-left">Total Income:</td>
                                           <td class="text-right" style="width: 85px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum($v_bal_current_month_tmp1).'</span></td>
                                           <td class="text-right" style="width: 85px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum($v_bal_old_month_tmp1).'</span></td>
                                           <td class="text-right" style="width: 85px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum($v_bal_current_year_tmp1).'</span></td>
                                        </tr>
                                    </tfoot>
                               </table>
                            </div>
                        </li>
                    </ul>
                </div>';


                $v_main_id=4;
                $v_main_name='Cost of Goods Sold';
                echo '<a class="list-toggle-container" data-toggle="collapse" data-parent="#accordion1" onclick=" " href="#task-1" aria-expanded="false">
                        <div class="list-toggle done uppercase bg-primary" style="background-color: #FFF2CC!important; padding: 10px; color: black;">
                            <div class="list-toggle-title bold text-left">
                            <strong>'.$v_main_name.'</strong>
                            </div>
                        </div>
                    </a>';
                echo '
                <div class="task-list panel-collapse collapse in" id="task-1">
                    <ul>
                        <li class="task-list-item" style="list-style: none;">
                            <div class="task-content">
                                <table class="table table-striped table-bordered myTable" >
                                    <tbody>';
                                            $v_bal_current_month_tmp2=0;
                                            $v_bal_old_month_tmp2=0;
                                            $v_bal_current_year_tmp2=0;
                                            if((@$_GET['date_start']&&@$_GET['date_end'])!=''){
                                                $v_date_start=@$_GET['date_start'];
                                                $v_date_end=@$_GET['date_end'];
                                                if($v_date_start>$v_date_end){
                                                    echo '<script>myAlertInfo("Please Choose Date From Before Date End")</script>';
                                                    header( "refresh:3;url=index.php" );
                                                }
                                                // $sql2=my_detail_date($v_main_id,$v_date_start,$v_date_end);
                                            }
                                            else{
                                                $v_date_start=@date('Y-m-d');
                                                $v_date_end=@date('Y-m-d');
                                            }
                                            $sql2=$connect->query(GetAccountName($v_main_id));
                                            while ($row2=mysqli_fetch_object($sql2)) {
                                                echo '<tr>';       
                                                    echo '<td class="text-left">'.$row2->accca_number.'-'.$row2->accca_account_name.'</td>';  
                                                        $current_month_bal=bal_current_month($v_date_start,$v_date_end,$row2->accca_id)+bal_pre_month($v_date_start,$v_date_end,$row2->accca_id);
                                                    echo '<td class="text-center" style="width: 85px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum($current_month_bal).'</span></td>';   
                                                        $old_month_bal=bal_pre_month($v_date_start,$v_date_end,$row2->accca_id);
                                                    echo '<td class="text-center" style="width: 85px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum($old_month_bal).'</span></td>';  
                                                        $current_year_bal=bal_cur_year($v_date_start,$v_date_end,$row2->accca_id);
                                                    echo '<td class="text-center" style="width: 85px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum($current_year_bal).'</span></td>';  
                                                echo '</tr>';
                                                $v_bal_current_month_tmp2+=$current_month_bal;
                                                $v_bal_old_month_tmp2+=$old_month_bal;
                                                $v_bal_current_year_tmp2+=$current_year_bal;
                                            }
                                           $v_to_income_cur_month=$v_bal_current_month_tmp1-$v_bal_current_month_tmp2;
                                           $v_to_income_old_month=$v_bal_old_month_tmp1-$v_bal_old_month_tmp2;
                                           $v_to_income_old_year=$v_bal_current_year_tmp1-$v_bal_current_year_tmp2;
                                echo '</tbody>
                                    <tfoot>
                                        <tr style="background-color: #DDEBF7;">
                                           <td colspan="" class="text-left">Total COGS:</td>
                                           <td class="text-center" style="width: 85px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum($v_bal_current_month_tmp2).'</span></td>
                                           <td class="text-center" style="width: 85px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum($v_bal_old_month_tmp2).'</span></td>
                                           <td class="text-center" style="width: 85px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum($v_bal_current_year_tmp2).'</span></td>
                                        </tr>
                                        <tr style="background-color: #FCE4D6;">
                                           <td colspan="" class="text-left">Gross Profit:</td>
                                           <td class="text-right" style="width: 85px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum($v_to_income_cur_month).'</td>
                                           <td class="text-right" style="width: 85px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum($v_to_income_old_month).'</td>
                                           <td class="text-right" style="width: 85px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum($v_to_income_old_year).'</td>
                                        </tr>
                                    </tfoot>
                               </table>
                            </div>
                        </li>
                    </ul>
                </div>';

                $v_main_id=6;
                $v_main_name='Expense';
                echo '<a class="list-toggle-container" data-toggle="collapse" data-parent="#accordion1" onclick=" " href="#task-2" aria-expanded="false">
                        <div class="list-toggle done uppercase bg-primary" style="background-color: #FFF2CC!important; padding: 10px; color: black;">
                            <div class="list-toggle-title bold text-left">
                            <strong>'.$v_main_name.'</strong>
                            </div>
                        </div>
                    </a>';
                echo '
                <div class="task-list panel-collapse collapse in" id="task-2">
                    <ul>
                        <li class="task-list-item" style="list-style: none;">
                            <div class="task-content">
                                <table class="table table-hover table-striped table-bordered myTable" >
                                    <tbody>';
                                            $v_bal_current_month_tmp3=0;
                                            $v_bal_old_month_tmp3=0;
                                            $v_bal_current_year_tmp3=0;
                                            if((@$_GET['date_start']&&@$_GET['date_end'])!=''){
                                                $v_date_start=@$_GET['date_start'];
                                                $v_date_end=@$_GET['date_end'];
                                                if($v_date_start>$v_date_end){
                                                    echo '<script>myAlertInfo("Please Choose Date From Before Date End")</script>';
                                                    header( "refresh:3;url=index.php" );
                                                }
                                                // $sql2=my_detail_date($v_main_id,$v_date_start,$v_date_end);
                                            }
                                            else{
                                                $v_date_start=@date('Y-m-d');
                                                $v_date_end=@date('Y-m-d');
                                            }
                                            $sql2=$connect->query(GetAccountName($v_main_id));
                                            while ($row2=mysqli_fetch_object($sql2)) {
                                                echo '<tr>';       
                                                    echo '<td class="text-left">'.$row2->accca_number.'-'.$row2->accca_account_name.'</td>';  
                                                        $current_month_bal=bal_current_month($v_date_start,$v_date_end,$row2->accca_id)+bal_pre_month($v_date_start,$v_date_end,$row2->accca_id);
                                                    echo '<td class="text-center" style="width: 85px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum($current_month_bal).'</span></td>';   
                                                        $old_month_bal=bal_pre_month($v_date_start,$v_date_end,$row2->accca_id);
                                                    echo '<td class="text-center" style="width: 85px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum($old_month_bal).'</span></td>';  
                                                        $current_year_bal=bal_cur_year($v_date_start,$v_date_end,$row2->accca_id);
                                                    echo '<td class="text-center" style="width: 85px!important;"><span class="pull-left">$</span><span class="pull-right">'.AccountFormatNum($current_year_bal).'</span></td>';  
                                                echo '</tr>';
                                                $v_bal_current_month_tmp3+=$current_month_bal;
                                                $v_bal_old_month_tmp3+=$old_month_bal;
                                                $v_bal_current_year_tmp3+=$current_year_bal;
                                            }
                                echo '</tbody>
                                        <tr style="background-color: #DDEBF7;">
                                           <td colspan="" class="text-left">Total Expense:</td>
                                           <td class="text-right" style="width: 85px;"><span class="pull-left">$</span><span class="pull-right">'.$v_bal_current_month_tmp3.'</span></td>
                                           <td class="text-right" style="width: 85px;"><span class="pull-left">$</span><span class="pull-right">'.$v_bal_old_month_tmp3.'</span></td>
                                           <td class="text-right" style="width: 85px;"><span class="pull-left">$</span><span class="pull-right">'.$v_bal_current_year_tmp3.'</span></td>
                                        </tr>
                                        <tr style="background-color: #FCE4D6;">
                                           <td colspan="" class="text-left">Net Income:</td>
                                           <td class="text-right" style="width: 85px!important;"><span class="pull-left">$</span><span class="pull-right">'.number_format($v_to_income_cur_month-$v_bal_current_month_tmp3,2).'</span></td>
                                           <td class="text-right" style="width: 85px!important;"><span class="pull-left">$</span><span class="pull-right">'.number_format($v_to_income_old_month-$v_bal_old_month_tmp3,2).'</span></td>
                                           <td class="text-right" style="width: 85px!important;"><span class="pull-left">$</span><span class="pull-right">'.number_format($v_to_income_old_year-$v_bal_current_year_tmp3,2).'</span></td>
                                        </tr>
                               </table>
                            </div>
                        </li>
                    </ul>
                </div>';
            ?>
        </div>
    </div>
    </div> 
    <script type="text/javascript">
        $(document).ready(function () {
            $('tbody tr').each(function() {
                v_act_month=$(this).find('td:nth-child(2) >span:nth-child(2)').html();
                v_pre_month=$(this).find('td:nth-child(3) >span:nth-child(2)').html();
                v_act_year=$(this).find('td:nth-child(4) >span:nth-child(2)').html();
                if(v_act_month==''&&v_pre_month==''&&v_act_year==''){
                    $(this).hide();
                }
            });
            window.print();
        });
        setTimeout(function(){
           window.close();
        },1000);
    </script>
</body>
</html>


