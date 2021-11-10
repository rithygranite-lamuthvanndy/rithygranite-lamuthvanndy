<?php include_once '../../config/database.php';?>
<?php 
    if(isset($_GET['print_id'])){
        $v_id=$_GET['print_id'];
        $sql=$connect->query("SELECT A.*,res_name,apn_name
                        FROM tbl_acc_pur_confirm AS A 
                        LEFT JOIN tbl_acc_approved_name_list AS B ON A.app_by_id=B.apn_id
                        LEFT JOIN tbl_acc_request_name_list AS C ON A.res_by_id=C.res_id
                        WHERE pur_id='$v_id'
                        ORDER BY pur_id ASC");
        $row_old_data=mysqli_fetch_object($sql);
    }
    $check='<img src="check.png" width="100px;">';
    $uncheck='<img src="uncheck.png" width="100px;">';
 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body id ="content">
    <link rel="stylesheet" href="../../print_offline/bootstrap.min.css">   
    <style type="text/css">
        *{ font-family: 'khmer os'; font-size: 100px; }
        @media print{
            #my_green{
                background-color: #E2EFDA !important;
                -webkit-print-color-adjust: exact; 
            }
            #my_pink{
                background-color: #E7E6E6 !important;
                -webkit-print-color-adjust: exact; 
            }
            #my_blue{
                background-color: #D9E1F2 !important;
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
            }
            .par_rotate{
                text-align: center;
                max-width: 30px;
                width: 10px;
            }
            #table_2 tr >td,#table_2 tr >th{
                padding: 10px;
                border-collapse: collapse;
                border: 1px black solid;
            }
            .myhidden1{
                border-style: hidden none hidden;
            }
            td.myhidden2{
                border-style: hidden double hidden!important;
            }
            .myHideButtom{
                border-style: double double hidden!important;
            }
            #table_2 tbody >tr >td:nth-child(2){
                width: 170px!important;
            }
            #table_1 table.sub_table td{ 
                border: none!important; padding: 9px!important; 
            }
            #table_1 table.sub_table td:nth-child(2){ 
                border-bottom: 1px solid #000!important; width: 95%;
            }
            #table_1 .mt-checkbox { 
                position: absolute; right: 5px; top: 10px;
            }
            #table_1 tr >td{ 
                padding: 50px 10px;
            }
            .sub_table{
                min-width: 100%;
            }
            #table_1 >tbody td >div{position: relative;}
        }
    </style>
    <div class="text-center">
        <h2 class="text-uppercase" style="text-decoration: underline; font-family: 'Times New Roman'!important; color: #8B57F5!important; font-size: 100px!important;">Purchase Confirmation Form</h2>
    </div>
    <br>
    <table id="table_1" style="width: 100%;">
        <tr id="my_green">
            <th colspan="3"><strong>Purchase Request_Information</strong></th>
        </tr>
        <tr id="my_pink" class="myhidden1">
            <th colspan="3">
                <div class="pull-right">   
                    <strong>Purchaser Responsibility</strong>
                </div>
            </th>
        </tr>
        <tbody>
            <tr class="myhidden1">
                <td>
                    <div>
                        <table class="sub_table">
                            <tr>
                                <td style="white-space: nowrap;">1/Date Request:</td>
                                <td><?= $row_old_data->date_req ?></td>
                            </tr>
                        </table>
                        <label class="mt-checkbox">
                            <?php 
                                if($row_old_data->chk_date_req) 
                                    echo $check;
                                else
                                    echo $uncheck;
                             ?>
                            <span></span>
                        </label>
                    </div> 
                </td>
                <td rowspan="4" class="par_rotate" id="my_pink">
                    <div class="rotate">
                        Cash Advance Info
                    </div>
                </td>
                <td>
                    <div>
                        <table class="sub_table">
                            <tr>
                                <td style="white-space: nowrap;">1/Date:</td>
                                <td><?php echo $row_old_data->date_pur_res ?></td>
                            </tr>
                        </table>
                        <label class="mt-checkbox">
                            <?php 
                                if($row_old_data->chk_date_pur_res)
                                    echo $check;
                                else
                                    echo $uncheck;
                             ?>
                            <span></span>
                        </label>
                    </div>
                </td>
            </tr>

            <tr class="myhidden1">
                <td>
                    <div>
                        <table class="sub_table">
                            <tr>
                                <td style="white-space: nowrap;">2/Request No :</td>
                                <td><?php echo $row_old_data->req_no ?></td>
                            </tr>
                        </table>
                        <label class="mt-checkbox">
                            <?php 
                                if($row_old_data->chk_req_no)
                                    echo $check;
                                else
                                    echo $uncheck;
                             ?>
                            <span></span>
                        </label>
                    </div>
                </td>
                <td>
                    <div>
                        <table class="sub_table">
                            <tr>
                                <td style="white-space: nowrap;">2/Amount Received :</td>
                                <td><?php echo number_format($row_old_data->amo_rec,2) ?></td>
                            </tr>
                        </table>
                        <label class="mt-checkbox">
                            <?php 
                                if($row_old_data->chk_amo_rec)
                                    echo $check;
                                else
                                    echo $uncheck;
                             ?>    
                            <span></span>
                        </label>
                    </div>
                </td>
            </tr>

            <tr class="myhidden1">
                <td>
                    <div>
                        <table class="sub_table">
                            <tr>
                                <td style="white-space: nowrap;">3/Department of RGC  : </td>
                                <td><?php echo $row_old_data->dep_rgc; ?></td>
                            </tr>
                        </table>
                        <label class="mt-checkbox">
                            <?php 
                                if($row_old_data->chk_dep_rgc)
                                    echo $check;
                                else
                                    echo $uncheck;
                             ?>  
                            <span></span>
                        </label>
                    </div>
                </td>
                <td>
                    <div>
                        <table class="sub_table">
                            <tr>
                                <td style="white-space: nowrap;">3/Actual Expense :</td>
                                <td><?php echo $row_old_data->act_exp ?></td>
                            </tr>
                        </table>
                        <label class="mt-checkbox">
                            <?php 
                                if($row_old_data->chk_act_exp)
                                    echo $check;
                                else
                                    echo $uncheck;
                             ?>  
                            <span></span>
                        </label>
                    </div>
                </td>
            </tr>

            <tr  class="myhidden1">
                <td>
                    <div>
                        <table class="sub_table">
                            <tr>
                                <td style="white-space: nowrap;">4/Type of Request No: (***) :</td>
                                <td><?php echo $row_old_data->type_of_req ?></td>
                            </tr>
                        </table>
                        <label class="mt-checkbox">
                            <?php 
                                if($row_old_data->chk_type_of_rgc)
                                    echo $check;
                                else
                                    echo $uncheck;
                             ?>  
                            <span></span>
                        </label>
                    </div>
                </td>
                <td>
                    <div>
                        <table class="sub_table">
                            <tr>
                                <td style="white-space: nowrap;">4/Cash Reimbursement :</td>
                                <td><?php echo $row_old_data->cash_rei ?></td>
                            </tr>
                        </table>
                        <label class="mt-checkbox">
                            <?php 
                                if($row_old_data->chk_cash_rei)
                                    echo $check;
                                else
                                    echo $uncheck;
                             ?>  
                            <span></span>
                        </label>
                    </div>
                </td>
            </tr>
            <tr></tr>

            <tr>
                <td class="myhidden2">
                    <div>
                        <table class="sub_table">
                            <tr>
                                <td style="white-space: nowrap;">5/Request by :</td>
                                <td><?php echo $row_old_data->res_name ?></td>
                            </tr>
                        </table>
                        <label class="mt-checkbox">
                            <?php 
                                if($row_old_data->chk_res_by_id)
                                    echo $check;
                                else
                                    echo $uncheck;
                             ?>  
                            <span></span>
                        </label>
                    </div>
                </td>
                <td rowspan="2" class="par_rotate" id="my_pink">
                    <div class="rotate">Purchase Date</div>
                </td>
                <td class="myHideButtom">
                    <div>
                        <table class="sub_table">
                            <tr>
                                <td style="white-space: nowrap;">5/Date of Purchse :</td>
                                <td><?php echo $row_old_data->date_of_pur ?></td>
                            </tr>
                        </table>
                        <label class="mt-checkbox">
                            <?php 
                                if($row_old_data->chk_date_of_pur)
                                    echo $check;
                                else
                                    echo $uncheck;
                             ?> 
                            <span></span>
                        </label>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="myhidden2">
                    <div>
                        <table class="sub_table">
                            <tr>
                                <td style="white-space: nowrap;">6/Approve by : </td>
                                <td><?php echo $row_old_data->apn_name ?></td>
                            </tr>
                        </table>
                        <label class="mt-checkbox">
                            <?php 
                                if($row_old_data->chk_app_by_id)
                                    echo $check;
                                else
                                    echo $uncheck;
                             ?>  
                            <span></span>
                        </label>
                    </div>
                </td>
                <td>
                    <div>
                        <table class="sub_table">
                            <tr>
                                <td style="white-space: nowrap;">6/Date of Delivery  :</td>
                                <td><?php echo $row_old_data->date_del ?></td>
                            </tr>
                        </table>
                        <label class="mt-checkbox">
                            <?php 
                                if($row_old_data->chk_date_del)
                                    echo $check;
                                else
                                    echo $uncheck;
                             ?> 
                            <span></span>
                        </label>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="myhidden2">
                    <div>
                        <table class="sub_table">
                            <tr>
                                <td style="white-space: nowrap;">7/Amount Request :</td>
                                <td><?php echo number_format($row_old_data->amo_req,2) ?></td>
                            </tr>
                        </table>
                        <label class="mt-checkbox">
                            <?php 
                                if($row_old_data->chk_amo_req)
                                    echo $check;
                                else
                                    echo $uncheck;
                             ?>  
                            <span></span>
                        </label>
                    </div>
                </td>
                <td rowspan="3" class="par_rotate" id="my_pink">
                    <div class="rotate">Supplier Info</div>
                </td>
                <td class="myHideButtom">
                    <div>
                        <table class="sub_table">
                            <tr>
                                <td style="white-space: nowrap;">7/Supply Name:</td>
                                <td><?php echo $row_old_data->supp_name ?></td>
                            </tr>
                        </table>
                        <label class="mt-checkbox">
                            <?php 
                                if($row_old_data->chk_supp_name)
                                    echo $check;
                                else
                                    echo $uncheck;
                             ?>  
                            <span></span>
                        </label>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="myhidden2">
                    <div>
                        <table class="sub_table">
                            <tr>
                                <td style="white-space: nowrap;">8/Location :</td>
                                <td><?= $row_old_data->location ?></td>
                            </tr>
                        </table>
                        <label class="mt-checkbox">
                            <?php 
                                if($row_old_data->chk_loccation)
                                    echo $check;
                                else
                                    echo $uncheck;
                             ?>   
                            <span></span>
                        </label>
                    </div>
                </td>
                <td class="myHideButtom">
                    <div>
                        <table class="sub_table">
                            <tr>
                                <td style="white-space: nowrap;">8/Area Purchase:</td>
                                <td><?php echo $row_old_data->area_pur ?></td>
                            </tr>
                        </table>
                        <label class="mt-checkbox">
                            <?php 
                                if($row_old_data->chk_area_pur)
                                    echo $check;
                                else
                                    echo $uncheck;
                             ?> 
                            <span></span>
                        </label>
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <div>
                        <table class="sub_table">
                            <tr>
                                <td style="white-space: nowrap;">9/Responsible Purchase :</td>
                                <td><?= $row_old_data->res_pur ?></td>
                            </tr>
                        </table>
                        <label class="mt-checkbox">
                            <?php 
                                if($row_old_data->chk_res_pur)
                                    echo $check;
                                else
                                    echo $uncheck;
                             ?>
                            <span></span>
                        </label>
                    </div>
                </td>
                <td>
                    <div>
                        <table class="sub_table">
                            <tr>
                                <td style="white-space: nowrap;">9/Phone Number:</td>
                                <td><?php echo $row_old_data->pho_number ?></td>
                            </tr>
                        </table>
                        <label class="mt-checkbox">
                            <?php 
                                if($row_old_data->chk_pho_number)
                                    echo $check;
                                else
                                    echo $uncheck;
                             ?>
                            <span></span>
                        </label>
                    </div> 
                </td>
            </tr>

            <tr>
                <td rowspan="2">
                    <div class="pull-left">
                        <div class="form-inline">
                            <label>Note: </label>
                            <?= $row_old_data->pur_ch_con_note_par ?>
                        </div>
                    </div>
                </td>
                <td rowspan="2"class="par_rotate" id="my_pink">
                    <div class="rotate">Site Received Info</div>
                </td>
                <td>
                    <div>
                        <table class="sub_table">
                            <tr>
                                <td style="white-space: nowrap;">10/Date of Purchse :</td>
                                <td><?php echo $row_old_data->date_of_pur ?></td>
                            </tr>
                        </table>
                        <label class="mt-checkbox">
                            <?php 
                                if($row_old_data->chk_date_of_pur)
                                    echo $check;
                                else
                                    echo $uncheck;
                             ?>
                            <span></span>
                        </label>
                    </div>  
                </td>
            </tr>
            <tr>
                <td>
                    <div>
                        <table class="sub_table">
                            <tr>
                                <td style="white-space: nowrap;">11/Date of Delivery :</td>
                                <td><?php echo $row_old_data->date_del ?></td>
                            </tr>
                        </table>
                        <label class="mt-checkbox">
                            <?php 
                                if($row_old_data->chk_date_del)
                                    echo $check;
                                else
                                    echo $uncheck;
                             ?>
                            <span></span>
                        </label>
                    </div> 
                </td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="col-xs-6 col-md-6 col-lg-6 text-center">
                            <b>Prepared by</b>
                            <br>
                            <br>
                            <br>
                            <div style="border: 0.5px dashed black;"></div>
                            <br>
                            <label class="pull-left">Date :
                                <span class="required" aria-required="true">*</span>
                            <?php echo $row_old_data->pre_by_date_1 ?>
                            </label>
                        </div>
                        <div class="col-xs-6 col-md-6 col-lg-6 text-center">
                            <b>Acknowledged by</b>
                            <br>
                            <br>
                            <br>
                            <div style="border: 0.5px dashed black;"></div>
                            <br>
                            <label class="pull-left">Date :
                                <span class="required" aria-required="true">*</span>
                                <?php echo $row_old_data->ack_by_date_1 ?>
                            </label>
                        </div>
                    </div>
                </td>
                <td colspan="2">
                    <div class="row">
                        <div class="col-xs-6 col-md-6 col-lg-6 text-center">
                            <b>Prepared by</b>
                            <br>
                            <br>
                            <br>
                            <div style="border: 0.5px dashed black;"></div>
                            <br>
                            <label class="pull-left">Date :
                                <span class="required" aria-required="true">*</span>
                                <?php echo $row_old_data->pre_by_date_2 ?>
                            </label>
                        </div>
                        <div class="col-xs-6 col-md-6 col-lg-6 text-center">
                            <b>Acknowledged by</b>
                            <br>
                            <br>
                            <br>
                            <div style="border: 0.5px dashed black;"></div>
                            <br>
                            <label class="pull-left">Date :
                                <span class="required" aria-required="true">*</span>
                                <?php echo $row_old_data->ack_by_date_2 ?>
                            </label>    
                        </div>
                    </div>
                </td>    
            </tr>
        </tbody>
    </table>

    <br>
    <br>
    <table id="table_2">
        <tbody>
            <tr>
                <th colspan="4" id="my_green"><strong>Purchase Request_Information</strong></th>
            </tr>
            <tr class="myhidden1">
                <th colspan="4" id="my_pink">
                    <div class="pull-right">   
                        <strong>Accountant or Account Manager Responsibility</strong>
                    </div>
                </th>
            </tr>
            <tr>
                <th colspan="4">*** Type of Request and Reference Requirement:</th>
            </tr>
            <tr id="my_blue">
                <th class="text-center" rowspan="2">No</th>
                <th class="text-center" rowspan="2"> Type of Request</th>
                <th class="text-center" colspan="2">Reference Requirement</th>
            </tr>
            <tr id="my_blue">
                <th class="text-center">Permanent Request</th>
                <th class="text-center">Temporary Request</th>
            </tr>
            <tr>
                <td>1</td>
                <td style="width: 1000px!important;">From $1 - $200</td>
                <td>
                    <div class="row">
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    if($row_old_data->per_1_1)
                                        echo $check;
                                    else
                                        echo $uncheck;
                                 ?>
                                 1/ការឯកភាពពីគណៈគ្រប់គ្រង
                                <span></span>
                            </label>
                        </div>
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    if($row_old_data->per_1_2)
                                        echo $check;
                                    else
                                        echo $uncheck;
                                 ?>
                                 2/រូបភាព
                                <span></span>
                            </label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="row">
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    if($row_old_data->tem_1_1)
                                        echo $check;
                                    else
                                        echo $uncheck;
                                 ?>
                                 1/ការឯកភាពពីគណៈគ្រប់គ្រង
                                <span></span>
                            </label>
                        </div>
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    if($row_old_data->tem_1_2)
                                        echo $check;
                                    else
                                        echo $uncheck;
                                 ?>
                                 2/រូបភាព
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <label class="mt-checkbox">
                                <?php   
                                    if($row_old_data->tem_1_3)
                                        echo $check;
                                    else
                                        echo $uncheck;
                                 ?>
                                 3/កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ)
                                <span></span>
                            </label>
                        </div>
                    </div>
                </td>
            </tr>

            <tr>
                <td>2</td>
                <td style="width: 1000px!important;">from $201 - $300</td>
                <td>
                    <div class="row">
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    if($row_old_data->per_2_1)
                                        echo $check;
                                    else
                                        echo $uncheck;
                                 ?>
                                 1/ការឯកភាពពីគណៈគ្រប់គ្រង
                                <span></span>
                            </label>
                        </div>
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php   
                                    if($row_old_data->per_2_2)
                                        echo $check;
                                    else
                                        echo $uncheck;
                                 ?>
                                 2/រូបភាព
                                <span></span>
                            </label>
                        </div>
                        <div class="col-xs-12">
                            <label class="mt-checkbox">
                                <?php 
                                   if($row_old_data->per_2_3)
                                        echo $check;
                                    else
                                        echo $uncheck;
                                 ?>
                                 3/កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ)
                                <span></span>
                            </label>
                        </div>
                        <div class="col-xs-12">
                            <label class="mt-checkbox">
                                <?php 
                                    if($row_old_data->per_2_4)
                                        echo $check;
                                    else
                                        echo $uncheck;
                                 ?>
                                 4/រ.តាមដានចំណាយ, រ.ស្តុក, រ.ជួសជុលគ្រឿងចក្រ
                                <span></span>
                            </label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="row">
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    if($row_old_data->tem_2_1)
                                        echo $check;
                                    else
                                        echo $uncheck;
                                 ?>
                                 1/ការឯកភាពពីគណៈគ្រប់គ្រង
                                <span></span>
                            </label>
                        </div>
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    if($row_old_data->tem_2_2)
                                        echo $check;
                                    else
                                        echo $uncheck;
                                 ?>
                                 2/រូបភាព
                                <span></span>
                            </label>
                        </div>
                        <div class="col-xs-12">
                            <label class="mt-checkbox">
                                <?php 
                                    if($row_old_data->tem_2_3)
                                        echo $check;
                                    else
                                        echo $uncheck;
                                 ?>
                                 3/កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ)
                                <span></span>
                            </label>
                        </div>
                        <div class="col-xs-12">
                            <label class="mt-checkbox">
                                <?php 
                                    if($row_old_data->tem_2_4)
                                        echo $check;
                                    else
                                        echo $uncheck;
                                 ?>
                                 4/រ.តាមដានចំណាយ, រ.ស្តុក, រ.ជួសជុល
                                <span></span>
                            </label>
                        </div>
                    </div>
                </td>
            </tr>

            <tr>
                <td>3</td>
                <td  style="width: 1000px!important;">From $301 -$1000</td>
                <td>
                    <div class="row">
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    if($row_old_data->per_3_1)
                                        echo $check;
                                    else
                                        echo $uncheck;
                                 ?>
                                 1/ការឯកភាពពីគណៈគ្រប់គ្រង
                                <span></span>
                            </label>
                        </div>
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    if($row_old_data->per_3_2)
                                        echo $check;
                                    else
                                        echo $uncheck;
                                 ?>
                                 2/រូបភាព
                                <span></span>
                            </label>
                        </div>
                        <div class="col-xs-12">
                            <label class="mt-checkbox">
                                <?php 
                                    if($row_old_data->per_3_3)
                                        echo $check;
                                    else
                                        echo $uncheck;
                                 ?>
                                 3/កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ)
                                <span></span>
                            </label>
                        </div>
                        <div class="col-xs-12">
                            <label class="mt-checkbox">
                                <?php 
                                    if($row_old_data->per_3_4)
                                        echo $check;
                                    else
                                        echo $uncheck;
                                 ?>
                                 4/រ.តាមដានចំណាយ, រ.ស្តុក, រ.ជួសជុលគ្រឿងចក្រ
                                <span></span>
                            </label>
                        </div>
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    if($row_old_data->per_3_5)
                                        echo $check;
                                    else
                                        echo $uncheck;
                                 ?>
                                 5/ផែនការប្រើប្រាស់សំភារៈផលិត
                                <span></span>
                            </label>
                        </div>
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    if($row_old_data->per_3_6)
                                        echo $check;
                                    else
                                        echo $uncheck;
                                 ?>
                                 6/Quotation
                                <span></span>
                            </label>
                        </div>
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    if($row_old_data->per_3_7)
                                        echo $check;
                                    else
                                        echo $uncheck;
                                 ?>
                                 7/ផ្សេងៗ
                                <span></span>
                            </label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="row">
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    if($row_old_data->tem_3_1)
                                        echo $check;
                                    else
                                        echo $uncheck;
                                 ?>
                                 1/ការឯកភាពពីគណៈគ្រប់គ្រង
                                <span></span>
                            </label>
                        </div>
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    if($row_old_data->tem_3_2)
                                        echo $check;
                                    else
                                        echo $uncheck;
                                 ?>
                                <span></span>
                            </label>
                        </div>
                        <div class="col-xs-12">
                            <label class="mt-checkbox">
                                <?php 
                                    if($row_old_data->tem_3_3)
                                        echo $check;
                                    else
                                        echo $uncheck;
                                 ?>
                                 3/កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ)
                                <span></span>
                            </label>
                        </div>
                        <div class="col-xs-12">
                            <label class="mt-checkbox">
                                <?php 
                                    if($row_old_data->tem_3_4)
                                        echo $check;
                                    else
                                        echo $uncheck;
                                 ?>
                                 4/រ.តាមដានចំណាយ, រ.ស្តុក, រ.ជួសជុល
                                <span></span>
                            </label>
                        </div>
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    if($row_old_data->tem_3_5)
                                        echo $check;
                                    else
                                        echo $uncheck;
                                 ?>
                                 5/ផែនការប្រើប្រាស់សំភារៈផលិត
                                <span></span>
                            </label>
                        </div>
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    if($row_old_data->tem_3_6)
                                        echo $check;
                                    else
                                        echo $uncheck;
                                 ?>
                                 6/Quotation
                                <span></span>
                            </label>
                        </div>
                        <div class="col-xs-6">
                            <label class="mt-checkbox">
                                <?php 
                                    if($row_old_data->tem_3_7)
                                        echo $check;
                                    else
                                        echo $uncheck;
                                 ?>
                                 7/ផ្សេងៗ
                                <span></span>
                            </label>
                        </div>
                    </div>
                </td>
            </tr>
            <!-- Footer -->
            <tr>
                <th colspan="4">
                    <div class="container-fluid">
                        <p>Description :<?= $row_old_data->pur_des ?></p>
                        <div style="border: 0.5px dashed black;"></div>
                        
                    </div>
                    <br>
                    <div class="container-fluid">
                        <p>Note :<?= $row_old_data->pur_note ?></p>
                        <br>    
                        <div style="border: 0.5px dashed black;"></div>
                        
                    </div>
                </th>
            </tr>
            <tr>
                <th colspan="4">
                    <div class="row">
                        <div class="col-xs-6 col-md-6 col-lg-6 text-center">
                            <div style="width: 50%; margin: auto;">
                                <b>Prepared by </b>
                                <br>
                                <br>
                                <br>
                                <div style="border: 0.5px dashed black;"></div>
                                <br>
                                <label class="pull-left">Date :
                                    <span class="required" aria-required="true">*</span>
                                </label>    
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-6 col-lg-6 text-center">
                            <div style="width: 50%; margin: auto;">
                                <b>Checked by</b>
                                <br>
                                <br>
                                <br>
                                <div style="border: 0.5px dashed black;"></div>
                                <br>
                                <label class="pull-left">Date :
                                    <span class="required" aria-required="true">*</span>
                                </label>    
                            </div>
                        </div>
                    </div>
                </th>
            </tr>
            <tr>
                <th colspan="4">
                    <div class="row">
                        <div class="col-xs-6 col-md-6 col-lg-6 text-center">
                            <div style="width: 50%; margin: auto;">
                                <b>First Approved by </b>
                                <br>
                                <br>
                                <br>
                                <div style="border: 0.5px dashed black;"></div>
                                <br>
                                <label class="pull-left">Date :
                                    <span class="required" aria-required="true">*</span>
                                </label>    
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-6 col-lg-6 text-center">
                            <div style="width: 50%; margin: auto;">
                                <b>Second Approved by</b>
                                <br>
                                <br>
                                <br>
                                <div style="border: 0.5px dashed black;"></div>
                                <br>
                                <label class="pull-left">Date :
                                    <span class="required" aria-required="true">*</span>
                                </label>    
                            </div>
                        </div>
                    </div>
                </th>
            </tr>
        </tbody>
    </table>
</body>
</html>
<script src="../../assets/global/plugins/jquery.min.js"></script>
<script src="../../print_offline/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.par_rotate').each(function(e){
            $v_parent_width = $('.par_rotate').eq(e).width(100+'px');
            $v_parent_height = $('.par_rotate').eq(e).height()+15;
            $('.rotate').eq(e).width($v_parent_height+'px');
            $('.rotate').eq(e).css('margin-left','-'+(($v_parent_height/2)-40)+'px');
            $('.rotate').eq(e).css('margin-top',($v_parent_height/2)-15+'px');
            // $('.rotate').eq(e).css('font-size',90+'px');
            // $('.rotate').eq(0).css('padding-left',10+'px');
            // $('.rotate').eq(2).css('padding-top',-100+'px');
            // $('.rotate').eq(e).css('padding',100+'px');
        });
        // $('#table_1 >tbody').find('tr >td >div.pull-left').each(function (e) {
            // var cell_witdh=$('#table_1 >tbody').find('tr >td').width();
            // var label_width=$('#table_1 >tbody').find('tr >td >div.pull-left').eq(e).width();
            // var border_add=cell_witdh-label_width;
            // $('#table_1 >tbody').find('tr >td >div.pull-left').css('border-bottom','1px solid black');
        // });
    });
</script>
<script type="text/javascript">
        $(document).ready(function () {
           // window.print();
        });
        setTimeout(function(){
           //window.close();
        },1000);
    </script>