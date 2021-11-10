<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "View ledger";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
    include_once 'myfunction.php';
    include '../acc_my_operation/my_operation.php';
?>
<div class="portlet light bordered">
    <div class="row">
        <!-- start search form -->
        <form action="" method="post">
            <div class="col-xs-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input type="text" name="txt_from" required onchange="myChangDateStart(this)" value="<?= @$_POST['txt_from'] ?>" autocomplete="off" class="form-control">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-xs-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input type="text" name="txt_to" onchange="myChangDateEnd(this)" required value="<?= @$_POST['txt_to'] ?>" autocomplete="off" class="form-control">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-xs-3">
                <select name="txt_topic" class="form-control myselect2">
                    <option value="">== All Account ==</option>
                    <?php 
                        $get_topic = $connect->query("SELECT * FROM tbl_acc_chart_account ORDER BY accca_account_name ASC");
                        while($row_topic = mysqli_fetch_object($get_topic)){
                            if($row_topic->accca_id == @$_POST['txt_topic']){
                                echo '<option SELECTED value="'.$row_topic->accca_id.'">'.$row_topic->accca_account_name.'</option>';
                                
                            }else{
                                echo '<option value="'.$row_topic->accca_id.'">'.$row_topic->accca_account_name.'</option>';
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="col-xs-5">
                <button type="submit" name="btn_search" class="btn blue"><i class="fa fa-search"></i> Search</button>
                <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn red"><i class="fa fa-undo"></i> Clear</a>
                <a title="Print" href="print.php?date_start=<?= @$_POST['txt_from'] ?>&date_end=<?= @$_POST['txt_to'] ?>&type=<?= @$_POST['txt_topic'] ?>" target="_blank" class="btn btn-warning"><i class="fa fa-print"></i> Print</a>
            </div>
        </form>
        <!-- end search form -->
    </div>
    <div class="row">
        <div class="col-xs-12"> 
            <?php 
                $sql=$connect->query("SELECT * FROM tbl_com_company_info");
                $row_company=mysqli_fetch_array($sql);
             ?>
            <div class="text-center">
                <h1><b><?= $row_company['comci_name_en'] ?></b></h1>
                <h3><b>Report Ledger</b></h3>
                <b><h4 style="font-family: 'Khmer OS Moul';" name="from_to">FROM <?= @$_POST['txt_from'] ?> TO <?= @$_POST['txt_to'] ?></h4></b>
            </div>
        </div>
    </div>
    <br>
    <?php 
        $i=0;
        if(isset($_POST['btn_search'])){
            if(@$_POST['txt_topic']!=''){
                $v_chart_account_id=@$_POST['txt_topic'];
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
        else{
        	$sql2=$connect->query("SELECT A.accca_id AS row2_id,A.accca_number,A.accca_account_name
                FROM tbl_acc_chart_account AS A 
                GROUP BY A.accca_id
                ORDER BY A.accca_number");
        }
        
        echo '<ul>';
            $grand_total_debit=0;
            $grand_total_credit=0;
            $grand_total_bal=0;
            while ($row2=mysqli_fetch_object($sql2)) {
                if(isset($_POST['btn_search'])){
                    $v_start=@$_POST['txt_from'];
                    $v_end=@$_POST['txt_to'];
                    if($v_start>$v_end){
                        echo '<script>myAlertInfo("Please Choose Date From Before Date End")</script>';
                        header( "refresh:3;url=index.php" );
                    }
                    $v_type=@$_POST['txt_topic'];
                    if($v_type!=''){
                         // AND ZZ.acc_id!=A.acc_id
                        $v_type=@$_POST['txt_topic'];
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
                                <div class="list-toggle done uppercase" style="padding: 10px; background-color: #FCE4D6;">
                                    <div class="list-toggle-title bold">
                                        '.$row2->accca_number.'-'.$row2->accca_account_name.'
                                        <div class="badge pull-right bold" style="margin-left: 100px; color: black;background-color: #66E9CC;" id="total_balance"></div>
                                        <div class="badge pull-right bold" style="margin-left: 100px; color: black;background-color: #fff;" id="total_credit"></div>
                                        <div class="badge pull-right bold" style="color: black;background-color: #fff;" id="total_debit">3</div>
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
                                            <table class="table table-hover table-bordered myTable" >
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
                                                            echo '<td class="text-left">'.@$row_no->no.'</td>';    
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
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 pull-right">
            <h4 class="text-right text-primary">Total Debit : $ <?= number_format($grand_total_debit,2) ?></h4>
            <h4 class="text-right text-primary">Total Credit : $ <?= number_format($grand_total_credit,2) ?></h4>
            <h4 class="text-right text-primary">Total Balance : $ <?= number_format($grand_total_debit-$grand_total_credit,2) ?></h4>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        
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
    function myChangDateStart(args){
        $('h4[name=from_to]').css('display','block');
        $('h4[name=from_to]').html('FROM '+$(args).val());    
        let date_start=new Date($(args).val());
        let date_end=new Date($('input[name=txt_to]').val());
        let v_same=date_start.getTime()>date_end.getTime();
        if(v_same){
            $('a[title=Print]').addClass('disabled');
        }
        else{
            $('a[title=Print]').removeClass('disabled');
        }
    }
    function myChangDateEnd(args){
        $('h4[name=from_to]').css('display','block');
        $('h4[name=from_to]').append(' To '+$(args).val());
        let date_end=new Date($(args).val());
        let date_start=new Date($('input[name=txt_from]').val());
        let v_same=date_start.getTime()>date_end.getTime();
        if(v_same){
            $('a[title=Print]').addClass('disabled');
        }
        else{
            $('a[title=Print]').removeClass('disabled');
        }
    }
</script>

<?php include_once '../layout/footer.php' ?>
