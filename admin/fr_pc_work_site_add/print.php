<?php include_once '../../config/database.php';?>
<?php 

if(@$_GET['print_id']){
    $id = @$_GET['print_id'];
    $sql = $connect->query("SELECT * FROM tbl_acc_request_wordsite 
            WHERE reqw_id=$id
            ");
    $row_old = mysqli_fetch_object($sql);
}   
 ?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    </style>
</head>
<body  id="content">
    <link rel="stylesheet" href="../../print_offline/bootstrap.min.css">
    <style type="text/css">
        *{ font-family: 'khmer os'; font-size: 11px!important; }
        @media print {
            .table thead tr th{
                -webkit-print-color-adjust: exact;
                background: blue; !important;
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
    <div class="container border my_box_border">
        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-3">
                        <img class="img-reponsive" src="../../img/img_logo/logo.png">
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="row text-center">
                    <h4 style="font-family: 'Khmer OS Muol Light';font-weight: bold!important; color: black;!important;">សំណើរស្នើសុំ</h4>
                </div>
            </div>
            <!-- <div class="clearfix"></div> -->
            <div class="col-xs-12 pull-right">
              
                <table style="width: 50%;">
                    <thead>
                        <tr>
                            <th>ថ្ងៃខែឆ្នាំសំណើរ៖</th>
                            <th><?= $row_old->reqw_date ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>លេខសំណើរ៖</td>
                            <td><?= $row_old->reqw_number ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
               <div class="col-xs-12 pull-right">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_ft_name" <?php if($row_old->reqw_ft_name>"0"){ echo 'checked';} ?> />
                            <label for="customCheckbox1" class="custom-control-label">រោងចក្រ</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_mo_name" <?php if($row_old->reqw_mo_name>"0"){ echo 'checked';} ?> />
                            <label for="customCheckbox1" class="custom-control-label">រណ្តៅរ៉ែ</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_fix_name" <?php if($row_old->reqw_fix_name>"0"){ echo 'checked';} ?> />
                            <label for="customCheckbox1" class="custom-control-label">ជួសជុល</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_of_name" <?php if($row_old->reqw_of_name>"0"){ echo 'checked';} ?> />
                            <label for="customCheckbox1" class="custom-control-label">ការិយាល័យ</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_other" <?php if($row_old->reqw_other>"0"){ echo 'checked';} ?> >
                            <label for="customCheckbox1" class="custom-control-label">ផ្សេងៗ</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_fr_order" <?php if($row_old->reqw_fr_order>"0"){ echo 'checked';} ?> >
                            <label for="customCheckbox1" class="custom-control-label">ប្រភេទសំណើរទិញកម្មង់</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_fr_other" <?php if($row_old->reqw_fr_other>"0"){ echo 'checked';} ?> >
                            <label for="customCheckbox1" class="custom-control-label">ស្នើប្រាក់ទូទាត់ ឬផ្សេងៗ</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <label>-បានជួសជុល ឬទិញរួច៖</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_fixbuy_not" <?php if($row_old->reqw_fixbuy_not>"0"){ echo 'checked';} ?> >
                            <label for="customCheckbox1" class="custom-control-label">មិនទាន់</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_fixbuy_ready" <?php if($row_old->reqw_fixbuy_ready>"0"){ echo 'checked';} ?> >
                            <label for="customCheckbox1" class="custom-control-label">រួចរាល់</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_fixbuy_borrow" <?php if($row_old->reqw_fixbuy_borrow>"0"){ echo 'checked';} ?> >
                            <label for="customCheckbox1" class="custom-control-label">ទិញជំពាក់</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <label>-បានទូទាត់រួច៖</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_pay_not" <?php if($row_old->reqw_pay_not>"0"){ echo 'checked';} ?> >
                            <label for="customCheckbox1" class="custom-control-label">មិនទាន់</label>
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="1" name="txt_pay_ready" <?php if($row_old->reqw_pay_ready>"0"){ echo 'checked';} ?> >
                            <label for="customCheckbox1" class="custom-control-label">រួចរាល់</label>
                        </div>
                    </div>
                </div>
               <div class="col-xs-12 pull-right">
                    <div class="form-group">
                        <label>-ផ្សេងៗ៖
                            <span class="required" aria-required="true">*</span>
                        </label>
                        <label><?= $row_old->reqw_note ?></label>
                        <br>
                    </div>
                </div>
        </div>
   
    <div class="container-fliud">
        <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>
                                <label>លរ
                                </label>
                            </th>
                            <th>
                                <label>បរិយាយ / ប្រភេទ / ទំហំ
                                </label>
                            </th>
                            <th>
                                <label>ចំនួន
                                </label>
                            </th>
                            <th>
                                <label>ឯកតា
                                </label>
                            </th>
                            <th>
                                <label>តម្លៃរាយ
                                </label>
                            </th>
                            <th>
                                <label>តម្លៃសរុប
                                </label>
                            </th>
                            <th>
                                <label>កម្រិត
                                </label>
                            </th>
                            <th>
                                <label>ថ្ងៃកំណត់
                                </label>
                            </th>
                            <th>
                                <label>មូលហេតុ/សម្គាល់
                                </label>
                            </th>
                        </tr>
                    </thead>
                <tbody>
                <?php
                    $i=1;
                    $total_amo=0;
                    $id1 = @$_GET['print_id'];
                    $get_data=$connect->query("SELECT A.*,B.uni_name FROM tbl_acc_reqw_item_ as A
                            LEFT JOIN  tbl_acc_unit_list AS B ON A.reiw_unit=B.uni_id
                            WHERE reiw_numberw = $id1");
                    while($row_body=mysqli_fetch_object($get_data)) 
                    {   
  
                        $v_description = $row_body->reiw_description;
                        $v_qty = $row_body->reiw_qty;
                        $v_unit = $row_body->uni_name;
                        $v_price = $row_body->reiw_price;
                        $v_amount= $v_qty*$v_price;
                        $v_limit = $row_body->reiw_limit;
                        $v_date_li = $row_body->reiw_date_li;
                        $v_note1 = $row_body->reiw_note;
                        $total_amo +=$v_amount;
                    ?>
                    <tr>
                      <td class="text-left"><?= sprintf("%02d",$i); ?></td>
                      <td class="text-left"><?= $v_description; ?></td>
                      <td class="text-center"><?= number_format($v_qty,0.3); ?></td>
                      <td class="text-left"><?= $v_unit; ?></td>
                      <td class="text-center"><?= number_format($v_price,2); ?> $</td>
                      <td class="text-center"><?= number_format($v_amount,2); ?> $</td>
                      <td class="text-left"><?= $v_limit; ?></td>
                      <td class="text-left"><?= $v_date_li; ?></td>
                      <td class="text-left"><?= $v_note1; ?></td>
                    </tr>
                <?php
                    $i++;
                }
                if($i<16){
                    for ($idx = 1; $idx <=(16-$i) ; $idx++) {
                        echo '<tr>';
                            echo '<td>'.sprintf("%02d",($i+$idx)).'</td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';

                        echo '</tr>';
                    }
                }

                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th style="visibility: hidden;"></th>
                    <th style="visibility: hidden;"></th>
                    <th style="visibility: hidden;"></th>
                    <th class="text-center" colspan="2">Grand Total (USD) :</th>
                    <th class="text-center"><strong><?= number_format($total_amo,2) ?> $</strong></th>
                    <th style="visibility: hidden;"></th>
                    <th style="visibility: hidden;"></th>
                    <th style="visibility: hidden;"></th>
                </tr>
            </tfoot>
        </table>
        <div class="row" style="padding: 0 15px;">
                <div class="col-xs-3 border text-center my_box_border">
                    <h5>ឯកភាពដោយ </h5>
                    <br>
                    <br>
                    <br>
                    <hr class="my_box_border">
                    <div class="text-left">
                        <h5>Name : <strong> </strong></h5>
                        <h5>Date : <strong>.......................................</strong></h5>
                    </div>
                </div>
                 <div class="col-xs-3 border text-center my_box_border">
                    <h5>ត្រួតពិនិត្យដោយ</h5>
                    <br>
                    <br>
                    <br>
                    <hr class="my_box_border">
                    <div class="text-left">
                        <h5>Name : <strong> </strong></h5>
                        <h5>Date : <strong>.......................................</strong></h5>
                    </div>
                </div>
                 <div class="col-xs-3 border text-center my_box_border">
                    <h5>រៀបចំដោយ</h5>
                    <br>
                    <br>
                    <br>
                    <hr class="my_box_border">
                    <div class="text-left">
                        <h5>Name : <strong> </strong></h5>
                        <h5>Date : <strong>.......................................</strong></h5>
                    </div>
                </div>
                 <div class="col-xs-3 border text-center my_box_border">
                    <h5>អ្នកស្នើសុំដោយ</h5>
                    <br>
                    <br>
                    <br>
                    <hr class="my_box_border">
                    <div class="text-left">
                        <h5>Name : <strong> </strong></h5>
                        <h5>Date : <strong>.......................................</strong></h5>
                    </div>
                </div>
            </div>
    </div>   <br>
 </div>
</body>
</html>
<script src="../../print_offline/jquery.min.js"></script>
<script type="text/javascript">
    window.onload=function(){
      var printme=document.getElementById('content');
      var wme=window.open("","","width=1100,height=1100");
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


