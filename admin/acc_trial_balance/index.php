<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "View Trail Balance";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
    include_once 'my_function.php';
    include_once '../acc_ledger/myfunction.php';
    include '../acc_my_operation/my_operation.php';
?>

<div class="portlet light bordered">
    <div class="row">
        <!-- start search form -->
        <form action="" method="post" id="form_search">
            <div class="col-sm-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input autocomplete="off" onchange="myChangDateStart(this)" name="txt_date_start" value="<?= @$_POST['txt_date_start'] ?>" type="text" class="form-control" placeholder="Date From ....">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input autocomplete="off" onchange="myChangDateEnd(this)" name="txt_date_end" value="<?= @$_POST['txt_date_end'] ?>" type="text" class="form-control" placeholder="Date To">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-xs-5">
                <button type="submit" name="btn_search" class="btn blue"><i class="fa fa-search"></i> Search</button>
                <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn red"><i class="fa fa-undo"></i> Clear</a>
                <a href="print.php?date_start=<?= @$_POST['txt_date_start'] ?>&date_end=<?= @$_POST['txt_date_end'] ?>&type=<?= @$_POST['optionsRadios'] ?>" target="_blank" class="btn btn-warning"><i class="fa fa-print"></i> Print</a>
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
                <h3><b>Trail Balance</b></h3>
                <b><h4 style="font-family: 'Khmer OS Moul';">FROM <?= @$_POST['txt_date_start'] ?> TO <?= @$_POST['txt_date_end'] ?></h4></b>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label>Choice to show data :</label>
        <div class="mt-radio-inline">
            <label class="mt-radio">
                <input type="radio" name="optionsRadios" form="form_search" id="optionsRadios4" value="option1" onchange="" <?php echo ((@$_POST['optionsRadios']=='option1'||@$_POST['optionsRadios']=='')?('checked'):(''))?>>Show All Record
                <span></span>
                <!-- form.submit() -->
                <!-- <?php echo ((@$_POST['optionsRadios']=='option1'||@$_POST['optionsRadios']=='')?('checked'):('')) ?>  -->
                <!-- this.form.submit() -->
            </label>
            <label class="mt-radio">
                <input type="radio" name="optionsRadios" form="form_search" id="optionsRadios5" value="option2" onchange="" <?php echo ((@$_POST['optionsRadios']=='option2'||@$_POST['optionsRadios']=='')?('checked'):(''))?>> Show Record debit or credit
                <span></span>
            </label>
        </div>
    </div>

    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline myTable" role="grid" aria-describedby="sample_1_info" style="width: 100%;">
                <thead>
                    <tr role="row" class="text-center">
                        <th class="text-center">Number</th>
                        <th class="text-center">Account Name</th>
                        <th class="text-center">Debit</th>
                        <th class="text-center">Credit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        if(isset($_POST['btn_search'])){
                            $v_start=@$_POST['txt_date_start'];
                            $v_end=@$_POST['txt_date_end'];
                            if($v_start>$v_end){
                                echo '<script>myAlertInfo("Please Choose Date From Before Date End")</script>';
                                header( "refresh:3;url=index.php" );
                            }
                            $sql = my_detail_date($v_start,$v_end);
                        }
                        else{
                            $sql=my_detail_date(date('Y-m-d'),date('Y-m-d'));
                        }
                        // echo $sql;
                        $get_cur=$connect->query($sql);
                        // $get_data_cur=$connect->query($sql[1]);
                        $grand_total_debit=0;
                        $grand_total_credit=0;
                        while ($row = mysqli_fetch_object($get_cur)) {
                            if(isset($_POST['btn_search'])){
                                $sql_old=my_detail_date($v_start,$v_end,$row->accca_id);
                            }
                            else{
                                $sql_old=my_detail_date(date('Y-m-d'),date('Y-m-d'),$row->accca_id);
                            }
                            // echo '<br><br>'.$sql_old;
                            $get_old_data=$connect->query($sql_old);
                            $row_old=mysqli_fetch_object($get_old_data);

                            $res_debit=$row_old->total_debit1+$row_old->total_debit2+$row->total_debit1+$row->total_debit2;
                            $res_credit=$row_old->total_credit1+$row_old->total_credit2+$row->total_credit1+$row->total_credit2;


                            $v_bal=calBalance($row->accca_id,$res_debit,$res_credit);
                            // echo $v_bal;
                            if ((@$_POST['optionsRadios'])=='option2') {
                                if($v_bal==0)continue;  
                            }


                            $show_bal=Show_Trial_bal($row->accca_id,$v_bal);
                            echo '<tr>';
                                echo '<td>'.$row->accca_number.'</td>';
                                echo '<td>'.$row->accca_account_name.'</td>';
                                echo '<td><span class="pull-left">$</span><span class="pull-right">'.number_format(abs($show_bal[0]),2).'</span></td>';
                                echo '<td><span class="pull-left">$</span><span class="pull-right">'.number_format(abs($show_bal[1]),2).'</span></td>';
                            echo '</tr>';
                            $grand_total_debit+=abs($show_bal[0]);
                            $grand_total_credit+=abs($show_bal[1]);
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-right">Total :</th>
                        <th class="text-center"><span class="pull-left">$</span><span class="pull-right"></span><?= number_format($grand_total_debit,2) ?></span></th>
                        <th class="text-center"><span class="pull-left">$</span><span class="pull-right"><?= number_format($grand_total_credit,2) ?></span></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.myTable').DataTable( {
            paging:   false,
            ordering: true,
            info:     false,
            searching: true,
            dom: 'Bfrtip',
            buttons: [
                // { extend: 'print', className: 'btn red' },
                { extend: 'copy', className: 'btn green' },
                { extend: 'excel', className: 'btn purple' },
                { extend: 'pdf', className: 'btn blue' },
                { extend: 'colvis', className: 'btn yellow', text: 'Hide Columns'}
            ]
        });
    });
    function myChangDateStart(args){
        $('h4').css('display','block');
        $('h4').html('FROM '+$(args).val());
    }
    function myChangDateEnd(args){
        $('h4').css('display','block');
        $('h4').append(' To '+$(args).val());
    }
</script>
<?php include_once '../layout/footer.php' ?>
