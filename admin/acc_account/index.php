<?php
$layout_title = "Welcome Account";
$menu_active = 20;
$left_active=76;
include_once '../../config/database.php';
include_once '../../config/athonication.php';
include_once '../layout/header.php';
include_once 'my_function.php';
include '../acc_my_operation/my_operation.php';
?>

<?php
    $edit_id = @$_GET['edit_id'];
    $old_data = $connect->query("SELECT *, sum(debit) as tadebit, sum(credit) as tacredit
                                    FROM tbl_acc_chart_account AS A 
                                    LEFT JOIN tbl_acc_type_account AS C ON A.accca_account_type=C.accta_id
                                    LEFT JOIN tbl_acc_chart_sub AS D ON A.sub_main_id=D.id
                                    LEFT JOIN tbl_acc_add_tran_amount_detail AS TA ON A.accca_account_type=TA.acc_id
                                    WHERE accta_type_account='Income'
                                    GROUP BY accca_id 
                                    ORDER BY accca_number ASC");
    $row_old_data = mysqli_fetch_object($old_data);
 ?>
<?php
    $edit_id = @$_GET['edit_id'];
    $old_data_ex = $connect->query("SELECT *, sum(debit) as tadebitex, sum(credit) as tacreditex
                                    FROM tbl_acc_chart_account AS A 
                                    LEFT JOIN tbl_acc_type_account AS C ON A.accca_account_type=C.accta_id
                                    LEFT JOIN tbl_acc_chart_sub AS D ON A.sub_main_id=D.id
                                    LEFT JOIN tbl_acc_add_tran_amount_detail AS TA ON A.accca_account_type=TA.acc_id
                                    WHERE accta_type_account='Expense'
                                    GROUP BY accca_id 
                                    ORDER BY accca_number ASC");
    $row_old_data_ex = mysqli_fetch_object($old_data_ex);
 ?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="text-center" style="font-family: 'Times New Roman'; color: #45932b;"><b>Welcome: Account</b></h2>
            
            <!-- <button type="button" class="btn btn-info" name="btn_testing">Testing</button> -->
            <hr>
        </div>
    </div>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#activity" data-toggle="tab">Get things done</a>
        </li>
        <li role="presentation">
            <a href="#timeline" data-toggle="tab">Business Overview</a>
        </li>
    </ul> 
    <div class="tab-content">
        <div class="active tab-pane" id="activity">
            <div class="col-lg-12">
                  <div class="portlet-body col-lg-4">
                      <div class="panel panel-primary">
                          <div class="panel-heading">
                              <h3 class="panel-title">Profit and Loss</h3>
                          </div>
                          <div class="panel-body">
                              <h1 style="font-family: 'Times New Roman';"><b> $ <?= number_format(($row_old_data->tadebit+$row_old_data->tacredit)-($row_old_data_ex->tadebitex+$row_old_data_ex->tacreditex),2) ?></b></h1>
                              <h4 style="font-family: 'Times New Roman'; color: #A7B3AC;"><b>NET INCONE FOR <?= date('M') ?></b></h4>
                              <br><br>

                              <h4 style="font-family: 'Times New Roman';"><b><a data-toggle="modal" href='#income'> $ <?= number_format($row_old_data->tadebit+$row_old_data->tacredit,2) ?></a></b></h4>
                              <h4 style="font-family: 'Times New Roman'; color: #A7B3AC;"><b>INCONE</b></h4>

                              <h4 style="font-family: 'Times New Roman';"><b><a data-toggle="modal" href='#description'> $ <?= number_format($row_old_data_ex->tadebitex+$row_old_data_ex->tacreditex,2) ?></a></b></h4>
                              <h4 style="font-family: 'Times New Roman'; color: #A7B3AC;"><b>EXPENSES</b></h4>
                          </div>
                      </div>
                  </div>
                  <div class="portlet-body col-lg-4">
                      <div class="panel panel-primary">
                          <div class="panel-heading">
                              <h3 class="panel-title">Expenses</h3>
                          </div>
                          <div class="panel-body">
                              <h1 style="font-family: 'Times New Roman';"><b> $ <?= number_format($row_old_data_ex->tadebitex+$row_old_data_ex->tacreditex,2) ?></b></h1>
                              <h4 style="font-family: 'Times New Roman'; color: #A7B3AC;"><b>LAST MONTH</b></h4>
                              <br><br>
                          </div>
                      </div>
                  </div>
                  <div class="portlet-body col-lg-4">
                      <div class="panel panel-primary">
                          <div class="panel-heading">
                              <h3 class="panel-title">Bank Accounts</h3>
                          </div>
                          <div class="panel-body">
                              <table width="100%">
                                <tr>
                                  <th></th>
                                  <th></th>
                                </tr>
                                <?php
                                    $i = 0;
                                    $v_cat_name_tmp = [];
                                    $get_data = $connect->query("SELECT A.*,accta_type_account,accca_id,D.name AS sub_name
                                    FROM tbl_acc_chart_account AS A 
                                    LEFT JOIN tbl_acc_type_account AS C ON A.accca_account_type=C.accta_id
                                    LEFT JOIN tbl_acc_chart_sub AS D ON A.sub_main_id=D.id
                                    WHERE accta_type_account='Cash' or accta_type_account='Bank'
                                    GROUP BY accca_id 
                                    ORDER BY accca_number ASC");
                                    while ($row = mysqli_fetch_object($get_data)) {
                                        if (!in_array($row->accta_type_account, $v_cat_name_tmp)) {
                                                array_push($v_cat_name_tmp, $row->accta_type_account);
                                            echo '<tr class="bg-blue" style="color: #00B050; font-size: 20px;">';
                                                echo '<td colspan="2">&nbsp;'.$row->accta_type_account.'</td>';
                                            echo '</tr>';
                                            }
                                        $sql_bal=$connect->query(getDataCur(date('Y-m-d'),date('Y-m-d'),$row->accca_id));
                                        // echo $sql_bal;
                                        $row_bal=mysqli_fetch_object($sql_bal);
                                        $res_debit=$row_bal->total_debit1+$row_bal->total_debit2;
                                        $res_credit=$row_bal->total_credit1+$row_bal->total_credit2;
                                        $v_bal=calBalance($row->accca_id,$res_debit,$res_credit);
                                        echo '<tr>';
                                            // echo '<td>'.(++$i).'</td>';
                                            echo '<td style="border-bottom: 1px solid #ddd;"> '.$row->accca_number.' = '.$row->accca_account_name.'<br>'.$row->accca_des.'</td>';
                                            echo '<td style="color: #00B050; font-size: 20px;" class="text-right">$ '.number_format($v_bal,2).'</td>';
                                        echo '</tr>';
                                    }
                                ?>
                              </table>
                          </div>
                      </div>
                  </div>      
            </div>
            <div class="col-lg-12">
              <div class="portlet-body col-lg-4">
                  <div class="panel panel-primary">
                      <div class="panel-heading">
                          <h3 class="panel-title">Invoices</h3>
                      </div>
                      <div class="panel-body">
                          <h1 style="font-family: 'Times New Roman';"><b> $ 0.00</b></h1>
                          <h4 style="font-family: 'Times New Roman'; color: #A7B3AC;"><b>LAST MONTH</b></h4>
                          <br><br>
                      </div>
                  </div>
              </div>
              <div class="portlet-body col-lg-4">
                  <div class="panel panel-primary">
                      <div class="panel-heading">
                          <h3 class="panel-title">Sales</h3>
                      </div>
                      <div class="panel-body">
                          <h1 style="font-family: 'Times New Roman';"><b> $ 0.00</b></h1>
                          <h4 style="font-family: 'Times New Roman'; color: #A7B3AC;"><b>LAST MONTH</b></h4>
                          <br><br>
                      </div>
                  </div>
              </div>
              <div class="portlet-body col-lg-4">
                  <div class="panel panel-primary">
                      <div class="panel-heading">
                          <h3 class="panel-title">Dicover</h3>
                      </div>
                      <div class="panel-body">
                          <h1 style="font-family: 'Times New Roman';"><b> $ 0.00</b></h1>
                          <h4 style="font-family: 'Times New Roman'; color: #A7B3AC;"><b>LAST MONTH</b></h4>
                          <br><br>
                      </div>
                  </div>
              </div>      
            </div>  
            <div class="row" id="myDIV">
                <div class="col-sm-12">
                    <h2 style="font-family: 'Times New Roman';"><i class="fa fa-folder-open"></i><b> Workspace</b></h2>
                </div>
                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-aqua">
                    <div class="inner">
                      <h3>150</h3>
                      <p><b>Profit and Loss</b></p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-play"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-green">
                    <div class="inner">
                      <h3>53<sup style="font-size: 20px">%</sup></h3>
                      <p><b>Expenses</b></p>
                    </div>
                    <div class="icon">
                      <i class="fa fa glyphicon glyphicon-list-alt"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-yellow">
                    <div class="inner">
                      <h3>44</h3>
                      <p><b>Income</b></p>
                    </div>
                    <div class="icon">
                      <i class="fa glyphicon glyphicon-edit"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-red">
                    <div class="inner">
                      <h3>65</h3>

                      <p><b>Bank accounts</b></p>
                    </div>
                    <div class="icon">
                      <i class="fa glyphicon glyphicon-folder-close"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
            </div>
        </div>
        
        <div class="tab-pane" id="timeline">
            <div style="border: 2px dashed black;">
                <img src="../../img/img_system/flow_account_page_1.png" alt="" class="img-responsive" width="100%">
                <img src="../../img/img_system/flow_account_page_2.png" alt="" class="img-responsive" width="100%">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('button[name=btn_testing]').click(function() {
        let myArr = new Array("Thyda", "Vanda", "Mesa");
        alert(myArr);
        $.ajax({
            url: 'ajax_testing.php',
            type: 'POST',
            data: 'data=' + myArr,
            success: function(result) {
                alert(result);
            },
            error: function() {
                alert("Error");
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).keyup(function(event) {
        if (event.shiftKey && event.which  == 78) {
            window.location.href = "add.php";
        }
    });
</script>
<div class="modal fade" id="description">
    <div class="modal-dialog" style="width: 100%; height: 100%;">
        <iframe src="iframe_description.php" frameborder="0" style="height: 100%; width: 100%;" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="income">
    <div class="modal-dialog" style="width: 100%; height: 100%;">
        <iframe src="iframe_income.php" frameborder="0" style="height: 100%; width: 100%;" scrolling="0"></iframe>
    </div>
</div>
<?php include_once '../layout/footer.php' ?>