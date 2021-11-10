<?php include_once '../../config/database.php';?>
<?php include_once 'myfunction.php';?>
<?php include '../acc_my_operation/my_operation.php'; ?>
<?php
$sql=$connect->query("SELECT comci_name_kh,comci_name_en,comci_name_ch,comci_logo FROM tbl_com_company_info");
$row_header=mysqli_fetch_object($sql);

if(@$_GET['date_start']&&@$_GET['date_end']!=""){
    $v_date_s = @$_GET['date_start'];
    $v_date_e = @$_GET['date_end'];
     $str="SELECT '1' AS statustable,A.status_type,A.date_record,A.ref_id
            FROM tbl_acc_add_tran_amount AS A 
            WHERE DATE_FORMAT(A.date_record,'%Y-%m-%d') BETWEEN '$v_date_s' AND '$v_date_e' AND p_appr='1'
            UNION
            SELECT '2' AS statustable,AA.status_type,AA.date_record,AA.ref_id
            FROM tbl_acc_add_tran_dr_cr AS AA 
            WHERE DATE_FORMAT(AA.date_record,'%Y-%m-%d') BETWEEN '$v_date_s' AND '$v_date_e'  AND p_appr='1'";
}
else{
    $v_current_year_month = date('Y-m');
    $str="SELECT '1' AS statustable,A.status_type,A.date_record,A.ref_id
            FROM tbl_acc_add_tran_amount AS A 
            WHERE DATE_FORMAT(A.date_record,'%Y-%m')='$v_current_year_month' AND p_appr='1'
            UNION
            SELECT '2' AS statustable,AA.status_type,AA.date_record,AA.ref_id
            FROM tbl_acc_add_tran_dr_cr AS AA 
            WHERE DATE_FORMAT(AA.date_record,'%Y-%m')='$v_current_year_month' AND p_appr='1'";
}
$get_data_main = $connect->query($str);
 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../print_offline/bootstrap.min.css">  
    <link href="https://fonts.googleapis.com/css?family=Khmer&family=Time New Roman" rel="stylesheet">
    <!-- <style>
        *{
            font-family: 'Khmer', 'Time New Roman';
        }
    </style>   -->
</head>
<body>
<div id ="content">
    <style>  
        *{ font-family: 'khmer', 'Time New Roman'; font-size: 10px; -webkit-print-color-adjust: exact;}
        @media print {
            table, th, td {
                -webkit-print-color-adjust: exact;
                border: 0.5px solid black;
                border-collapse: collapse;
            }
            th, td {
                padding: 5px;
                text-align: left;    
            }
            h5{
                color: #9692C9!important;
            }
        }
    </style>
    <center id="center">
        <div class="row">
            <!-- <p class="text-primary" style="color: #6467EF!important; font-size: 18px!important; font-family: 'khmer OS Muol Light'!important;"><?= $row_header->comci_name_kh ?></p> -->
            <p style="font-size: 27px!important; font-weight: bold; font-family: 'Time New Roman'!important; color: #BD9ED3!important"><?= $row_header->comci_name_en ?></p>
            <p style="font-size: 20px!important; font-weight: bold; text-decoration: underline; font-family: 'Time New Roman'">Report Ledger</p>
            <b><h4 style="font-family: 'Khmer OS Moul';">FROM <?= @$_GET['date_start'] ?> TO <?= @$_GET['date_end'] ?></h4></b>
        </div>
    </center>
    <div class="portlet-body">
        <?php 
        $i=0;
        if((@$_GET['date_start']&&$_GET['date_end'])!=''){
            if(@$_GET['type']!=''){
                $v_chart_account_id=@$_GET['type'];
                $sql2=$connect->query("SELECT A.accca_id AS row2_id,A.accca_number,A.accca_account_name
                FROM tbl_acc_chart_account AS A 
                WHERE A.accca_id='$v_chart_account_id'
                GROUP BY A.accca_id 
                ORDER BY A.accca_number");
            }
            else{
                $sql2=$connect->query("SELECT A.accca_id AS row2_id,A.accca_number,A.accca_account_name
                FROM tbl_acc_chart_account AS A 
                GROUP BY A.accca_id
                ORDER BY A.accca_number");
            }
        }
        
        echo '<ul>';
            $grand_total_debit=0;
            $grand_total_credit=0;
            $grand_total_bal=0;
            while ($row2=mysqli_fetch_object($sql2)) {
                if((@$_GET['date_start']&&$_GET['date_end'])!=''){
                    $v_start=@$_GET['date_start'];
                    $v_end=@$_GET['date_end'];
                    if($v_start>$v_end){
                        echo '<script>myAlertInfo("Please Choose Date From Before Date End")</script>';
                        header( "refresh:3;url=index.php" );
                    }
                    $v_type=@$_GET['type'];
                    if($v_type!=''){
                         // AND ZZ.acc_id!=A.acc_id
                        $v_type=@$_GET['type'];
                        $sql33=myDetailDate($v_start,$v_end,$v_type,$row2->row2_id);
                    }
                    else{
                        $sql33=myDetailDate($v_start,$v_end,'',$row2->row2_id);
                    }
                    $stm111=myDetailDate1($v_start,$v_end,$row2->row2_id);
                }
                else{
                    $sql33=myNormal($row2->row2_id);
                    $stm111 = myNormal1($row2->row2_id);
                }
                // echo $stm111;
                $sql3=$connect->query($sql33);
                $sql_beg=$connect->query($stm111);
                $row_beg_bal=mysqli_fetch_object($sql_beg);

                // if(mysqli_num_rows($sql3)<=0)continue;
                echo '<li class="mt-list-item" style="list-style: none;">
                        <div class="list-todo-item dark">
                            <a class="list-toggle-container" data-toggle="collapse" data-parent="#accordion1" onclick=" " href="#task-'.$i.'" aria-expanded="false">
                                <div class="list-toggle done uppercase" style="padding: 10px; background-color: #FCE4D6!important;">
                                    <div class="list-toggle-title bold">
                                        <strong>'.$row2->accca_number.'-'.$row2->accca_account_name.'</strong>
                                        <div class="badge pull-right bold" style="margin-left: 100px; color: black;background-color: #66E9CC;" id="total_balance"></div>
                                        <div class="badge pull-right bold" style="margin-left: 100px; color: black;background-color: #fff;" id="total_credit"></div>
                                        <div class="badge pull-right bold" style="color: black;background-color: #fff;" id="total_debit"></div>
                                    </div>
                                </div>
                            </a>';
                            echo '<br>';
                            $t_debit=0;
                            $t_crebit=0;
                            $t_bal=0;
                            $v_bal=0;

                            echo '<div class="task-list panel-collapse collapse in" id="task-'.$i.'">
                                <ul>
                                    <li class="task-list-item" style="list-style: none;">
                                        <div class="task-content">
                                            <br>
                                            <table style="width: 100%;">
                                                <thead>
                                                    <tr role="row" class="text-center">
                                                        <th class="text-left">Type</th>
                                                        <th class="text-left">No</th>
                                                        <th class="text-center">Date Record</th>
                                                        <th class="text-center">Account Name</th>
                                                        <th class="text-center">Debit</th>
                                                        <th class="text-center">Credit</th>
                                                        <th class="text-center">Balance</th>    
                                                    </tr>
                                                </thead>
                                                    <tr class="text-center">
                                                        <td class="text-right" colspan="4">Beginning Balance :</td>';
                                                         echo '<td class="text-center">
                                                                ';
                                                                $v_bal1=0;
                                                                    echo number_format($row_beg_bal->my_debit+$row_beg_bal->my_debit1,2);
                                                            echo '</td>';    
                                                            echo '<td class="text-center">';
                                                                    echo number_format($row_beg_bal->my_credit+$row_beg_bal->my_credit1,2);
                                                            echo '</td>';  
                                                            // $v_bal1+=calBalance($row_beg_bal->accca_id+0,$row_beg_bal->my_debit+0,$row_beg_bal->my_credit+0);
                                                            $v_bal1+=$row_beg_bal->my_debit+0-$row_beg_bal->my_credit+0;
                                                            echo '<td class="text-center">'.number_format($v_bal1,2).'</td>';    
                                                    echo '</tr>
                                                <tbody>';
                                                    $v_bal = $v_bal1;
                                                    while ($row3=mysqli_fetch_object($sql3)) {
                                                        // Status Type
                                                        // echo $row3->f_status;
                                                        $v_no="Null";
                                                        $sql_result=@getNo($row3->main_id,$row3->f_status);
                                                        // echo $sql_result[0].'<br>';
                                                        $row_no=mysqli_fetch_object($connect->query($sql_result[0]));
                                                        $v_type=$sql_result[1];
                                                        echo '<tr>';
                                                            echo '<td class="text-left">'.$v_type.'</td>';    
                                                            echo '<td class="text-left">'.$row_no->no.'</td>';    
                                                            echo '<td class="text-center">'.$row3->date_record.'</td>';    
                                                            echo '<td class="text-left">'.$row3->accca_account_name.'</td>';    
                                                            echo '<td class="text-center">';
                                                                // if($row3->my_debit>0)
                                                                    echo number_format($row3->my_debit,2);
                                                            echo '</td>';    
                                                            echo '<td class="text-center">';
                                                                // if($row3->my_credit>0)
                                                                    echo number_format($row3->my_credit,2);
                                                            echo '</td>';  
                                                            // $v_bal+=calBalance($row3->accca_id,$row3->my_debit,$row3->my_credit);
                                                            $v_bal+=$row3->my_debit-$row3->my_credit;
                                                            echo '<td class="text-center">'.number_format($v_bal,2).'</td>';    
                                                        echo '</tr>';
                                                        $t_debit+=$row3->my_debit;
                                                        $t_crebit+=$row3->my_credit;
                                                        // $t_bal+=$v_bal;
                                                    }
                                            echo '</tbody>';
                                            echo '<tfoot>';
                                                echo '<tr>';
                                                    echo '<td colspan="4" class="text-right">Total :</td>';
                                                    echo '<td class="text-center">'.number_format($t_debit,2).'</td>';
                                                    echo '<td class="text-center">'.number_format($t_crebit,2).'</td>';
                                                    echo '<td class="text-center">'.number_format($v_bal,2).'</td>';
                                                echo '</tr>';
                                            echo '</tfoot>';
                                            echo '</table>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>';
                $i++;
                $grand_total_debit+=$t_debit+$row_beg_bal->my_debit+$row_beg_bal->my_debit1;
                $grand_total_credit+=$t_crebit+$row_beg_bal->my_credit+$row_beg_bal->my_credit1;
                $grand_total_bal+=$t_bal;
            } 
        echo '</ul>';
    ?>
    <div class="row">
        <div class="col-xs-5 pull-right">
            <h5 class="text-right">Total Debit : $ <?= number_format($grand_total_debit,2) ?></h5>
            <h5 class="text-right">Total Credit : $ <?= number_format($grand_total_credit,2) ?></h5>
            <h5 class="text-right">Total Balance : $ <?= number_format($grand_total_debit-$grand_total_credit,2) ?></h5>
        </div>
    </div>
    </div>
  </div>
</body>
</html>
<script src="../../print_offline/jquery.min.js"></script>
<script type="text/javascript">
   $(document).ready(function () {
         window.print();
         
        $('tfoot >tr').each(function() {
            let v_total_debit=$(this).find('td:nth-child(2)').html();
            $(this).parents('.mt-list-item').find('#total_debit').html("$ "+v_total_debit);
            let v_total_credit=$(this).find('td:nth-child(3)').html();
            $(this).parents('.mt-list-item').find('#total_credit').html("$ "+v_total_credit);
            let v_total_balance=$(this).find('td:nth-child(4)').html();
            if(v_total_balance=='0.00'){
                 $(this).parents('.mt-list-item').hide();
            }
            $(this).parents('.mt-list-item').find('#total_balance').html("$ "+v_total_balance);
        });
    });
    setTimeout(function(){
       window.close();
    },1000);
    function myChangDateStart(args){
        $('h4').css('display','block');
        $('h4').html('FROM '+$(args).val());
    }
    function myChangDateEnd(args){
        $('h4').css('display','block');
        $('h4').append(' To '+$(args).val());
    }
</script>