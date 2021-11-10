<?php include_once '../../config/database.php';?>
<?php 
    $uncheck_img='<img class="img_size" src="uncheck.png">';
    $check_img='<img class="img_size" src="check.png">';
 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body id ="content">
    <link rel="stylesheet" href="../../print_offline/bootstrap.min.css">  
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

    <?php 
        if (isset($_GET['print_id'])) {
            $v_id=@$_GET['print_id'];
            $sql=$connect->query("SELECT A.*,B.req_number,C.dep_name,D.typr_name,E.res_name,
                        F.apn_name
                        FROM tbl_acc_pur_confirm AS A 
                        INNER JOIN tbl_acc_request_form AS B ON B.req_id =A.req_no
                        INNER JOIN tbl_acc_department_list AS C ON C.dep_id=B.dep_id
                        INNER JOIN tbl_acc_type_request_list AS D ON D.typr_id=B.type_req_id
                        INNER JOIN tbl_acc_request_name_list AS E ON E.res_id=B.req_request_name
                        INNER JOIN tbl_acc_approved_name_list AS F ON F.apn_id=B.req_approved_by
                         WHERE pur_id='$v_id'");
            $row_old_data=mysqli_fetch_object($sql);
        }
     ?>
    <div class="text-center">
        <h2 class="text-uppercase" style="text-decoration: underline; font-family: 'Times New Roman'!important; color: #8B57F5!important;font-size:14px;">Purchase Confirmation Form</h2>
    </div>
    <br>
    <!-- <table id="table_1" style="width: 100%;"> -->
           <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="3" style="background: #E2EFDA;text-align: center;font-size: 11px;">Purchase Request_Information</th>
                </tr>
                <tr>
                    <th colspan="3" style="background: #E7E6E6;">
                        <div class="pull-right" style="font-size: 11px;">   
                            Purchaser Responsibility
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>1/ Confirmed Date :</label>&nbsp;<?= $row_old_data->confirm_date; ?>
                                 
                            </div>
                        </div>
                        <div class="pull-right">
                            
                        </div> 
                    </td>
                   
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>6/ Approved by:</label> <?php echo $row_old_data->apn_name; ?>
                               
                            </div>
                        </div>
                        <div class="pull-right">
                            
                        </div> 
                    </td>


                </tr>

                <tr>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                
                                <label>2/ Request No:</label> <?php echo $row_old_data->req_number; ?>
                                 
                            </div>
                        </div>
                        <div class="pull-right">
                            
                        </div> 
                    </td>
                   
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>7/ Requested Amount:</label>&nbsp;

<?php echo number_format($row_old_data->amount_request,2); ?>
                                 
                            </div>
                        </div>
                        <div class="pull-right">
                            
                        </div> 
                    </td>

                    
                </tr>
                <tr>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>3/ Department of RGC: </label>&nbsp;<?php echo $row_old_data->dep_name; ?>
                                
                            </div>
                        </div>
                        <div class="pull-right">
                            
                        </div> 
                    </td>
                   
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>8/ Location:</label> <?php echo $row_old_data->location; ?>
                                
                            </div>
                        </div>
                        <div class="pull-right">
                            
                        </div> 
                    </td>

                    
                </tr>
                <tr>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>4/ Type of Request:</label> <?php echo $row_old_data->typr_name; ?>
                                 
                            </div>
                        </div>
                        <div class="pull-right">
                            
                        </div> 
                    </td>
                   
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>9/ Buyer:</label>&nbsp;<?php 
                            $v_select=$connect->query("SELECT A.*,B.po_name,C.dep_name
                            FROM tbl_hr_employee_list AS A 
                            LEFT JOIN tbl_hr_position_list AS B ON A.empl_position=B.po_id
                            LEFT JOIN tbl_hr_department_list AS C ON A.empl_department=C.dep_id
                            ORDER BY empl_id DESC");
                                        while ($row_select=mysqli_fetch_object($v_select)) {

                                             if ($row_old_data->buyer_id == $row_select->empl_id) {

                                                echo $row_select->empl_emloyee_en.' '.$row_select->empl_emloyee_kh;

                                                
                                             }
                                             else {
                                                 echo "";
                                             }
                                           
                                        }
                                     ?>
                                
                            </div>
                        </div>
                        <div class="pull-right">
                            
                        </div> 
                    </td>

                    
                </tr>
                <tr style="display:none;">
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                               
                            </div>
                        </div>
                        <div class="pull-right">
                            
                        </div> 
                    </td>
                   
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label></label>
                                
                            </div>
                        </div>
                        <div class="pull-right">
                            
                        </div> 
                    </td>

                    
                </tr>

                <tr>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>5/ Requested by:</label> <?php echo $row_old_data->res_name; ?>
                                 
                            </div>
                        </div>
                        <div class="pull-right">
                            
                        </div> 
                    </td>
                   
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>10/ Note:</label>&nbsp;<?php echo $row_old_data->note; ?>
                                
                            </div>
                        </div>
                        <div class="pull-right">
                            
                        </div> 
                    </td>

                    
                </tr>

            </tbody>
        </table>
        <div class="row">
            <div class="col-xs-4">
                <div class="form-group">
                    <label style="font-weight: bold;">Prepared by<br><span style="color:#337ab7;">(PURCASE)</span></label>
                    <br><br><br><br><br><br>
                    <label>NAME:</label>
                    <span>
                      
                    </span>
                    <br>

                    <label>DATE:</label>
                    <span>
                        <?php echo date("Y-m-d"); ?>
                    </span>
                </div>
            </div>
            <div class="col-xs-8">
                <div class="form-group">
                    <label style="font-weight: bold;">Description :</label>&nbsp;

<?php echo $row_old_data->description; ?>
                    
                </div>
            </div>
        </div>
       <table class="table table-bordered">
            <thead>
               
            <tr>
                <th colspan="3" style="padding:20px;line-height: 2px;font-size: 11px;">*** (First Request) Admin Type of Request and Reference Requirement</th>
                <th colspan="2" style="padding:20px;line-height: 2px;font-size: 11px;overflow-wrap: break-word;">Admin Reference Requirement</th>

            </tr>
                <tr>
                    <th class="text-center" rowspan="2" style="font-size: 11px;">No</th>
                    <th class="text-center" rowspan="2" width="16%;" style="font-size: 11px;">Type of Request</th>
                    <th class="text-center" colspan="1" style="font-size: 11px;">Reference Requirement</th>
                    <th class="text-center" rowspan="2" colspan="2" style="font-size: 11px;">Checking Note Cashier</th>
                </tr>
                <tr>
                    <th class="text-center" style="font-size: 11px;">Permanent Request</th>
                    
                </tr>
            </thead>
            <tbody>
               <tr>
                 <td rowspan="3" style="vertical-align: middle !important;font-size: 11px;">1</td>
                 <td rowspan="3" style="vertical-align: middle !important;font-size: 11px;">From $1 - $200</td>
                   <td>
                        <div class="row">
                            <div class="col-xs-12">
                                <label class="mt-checkbox">
                                <?php if($row_old_data->ch_1_1=="1") {echo $check_img;} else {echo $uncheck_img; } ?>
                                   1/ ការឯកភាពពីគណៈគ្រប់គ្រង
                                   
                                </label>
                            </div>
                            
                        </div>
                    </td>
                    <td class="par_rotate" rowspan="6">
                        <div class="rotate" >Cash Advance Info</div>
                    </td>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>1/ Received Date:</label>&nbsp;

<?php echo $row_old_data->txt_1; ?>
                                
                            </div>
                        </div>

                        <div class="pull-right">
                           
                        </div> 
                    </td>
                </tr>

                <tr >
                  
                   <td>
                        <div class="row">
                            <div class="col-xs-12">
                                <label class="mt-checkbox">
                                   <?php if($row_old_data->ch_1_2=="1") {echo $check_img;} else {echo $uncheck_img; } ?>2/ រូបភាព
                                   
                                </label>
                            </div>
                            
                        </div>
                    </td>
                    
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>2/ Received Amount:</label>&nbsp;

<?php echo $row_old_data->txt_2; ?>
                                
                            </div>
                        </div>
                        <div class="pull-right">
                           
                        </div> 
                    </td>
                </tr>


                <tr>
                  
                   <td>
                        <div class="row">
                            <div class="col-xs-12">
                                <label class="mt-checkbox">
                                    <?php if($row_old_data->ch_1_3=="1") {echo $check_img;} else {echo $uncheck_img; } ?>3/ កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ)
                                   
                                </label>
                            </div>
                            
                        </div>
                    </td>
                    
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>3/ Actual Expense:</label>&nbsp;

<?php echo $row_old_data->txt_3; ?>
                                 
                            </div>
                        </div>
                        <div class="pull-right">
                           
                        </div> 
                    </td>
                </tr>

                <tr>
                  <td rowspan="5" style="vertical-align: middle !important;font-size: 11px;">2</td>
                  <td rowspan="5" style="vertical-align: middle !important;font-size: 11px;">From $201 - $300</td>
                   <td>
                        <div class="row">
                            <div class="col-xs-12">
                                <label class="mt-checkbox">
                                   <?php if($row_old_data->ch_2_1=="1") {echo $check_img;} else {echo $uncheck_img; } ?>1/ ការឯកភាពពីគណៈគ្រប់គ្រង
                                   
                                </label>
                            </div>
                            
                        </div>
                    </td>
                    
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>4/ Cash Settlement:</label>&nbsp;

<?php echo $row_old_data->txt_4; ?>
                                 
                            </div>
                        </div>
                        <div class="pull-right">
                           
                        </div> 
                    </td>
                </tr>


                <tr style="display: none;">
                  
                </tr>

                <tr>
                
                   <td>
                        <div class="row">
                            <div class="col-xs-12">
                                <label class="mt-checkbox">
                                    <?php if($row_old_data->ch_2_2=="1") {echo $check_img;} else {echo $uncheck_img; } ?>2/ រូបភាព
                                   
                                </label>
                            </div>
                            
                        </div>
                    </td>
                    
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>5/ Cash Settled by:</label>&nbsp;

<?php echo $row_old_data->txt_5; ?>
                                 
                            </div>
                        </div>
                        <div class="pull-right">
                           
                        </div> 
                    </td>
                </tr>



               
                <tr></tr>
                <tr>
                 
                   <td>
                        <div class="row">
                            <div class="col-xs-12">
                                <label class="mt-checkbox">
                                    <?php if($row_old_data->ch_2_3=="1") {echo $check_img;} else {echo $uncheck_img; } ?>3/ កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ)
                                   
                                </label>
                            </div>
                            
                        </div>
                    </td>
                    <td class="par_rotate" rowspan="2">
                        <div class="rotate" >Purchase Info</div>
                    </td>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>6/ Purchsed Date :</label>&nbsp;

<?php echo $row_old_data->txt_6; ?>
                                 
                            </div>
                        </div>
                        <div class="pull-right">
                           
                        </div> 
                    </td>
                </tr>

                <tr>
                 
                   <td>
                        <div class="row">
                            <div class="col-xs-12">
                                <label class="mt-checkbox">
                                    <?php if($row_old_data->ch_2_4=="1") {echo $check_img;} else {echo $uncheck_img; } ?>4/ រ.តាមដានចំណាយ, រ.ស្តុក, រ.ជួសជុលគ្រឿងចក្រ
                                   
                                </label>
                            </div>
                            
                        </div>
                    </td>
                    
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>7/ Transferred Date:</label>&nbsp;

<?php echo $row_old_data->txt_7; ?>
                                 
                            </div>
                        </div>
                        <div class="pull-right">
                           
                        </div> 
                    </td>
                </tr>



                 <tr></tr>
                <tr>
                  <td rowspan="8" style="vertical-align: middle !important;font-size: 11px;">3</td>
                  <td rowspan="8" style="vertical-align: middle !important;font-size: 11px;">From $301 -$1000</td>
                   <td>
                        <div class="row">
                            <div class="col-xs-12">
                                <label class="mt-checkbox">
                                   <?php if($row_old_data->ch_3_1=="1") {echo $check_img;} else {echo $uncheck_img; } ?>1/ ការឯកភាពពីគណៈគ្រប់គ្រង
                                   
                                </label>
                            </div>
                            
                        </div>
                    </td>
                    <td class="par_rotate" rowspan="3">
                        <div class="rotate" >Supplier Info</div>
                    </td>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>8/ Deliveried Date:</label>&nbsp;

<?php echo $row_old_data->txt_8; ?>
                                
                            </div>
                        </div>
                        <div class="pull-right">
                           
                        </div> 
                    </td>
                </tr>

                <tr>
                 
                   <td>
                        <div class="row">
                            <div class="col-xs-12">
                                <label class="mt-checkbox">
                                    <?php if($row_old_data->ch_3_2=="1") {echo $check_img;} else {echo $uncheck_img; } ?>2/ រូបភាព
                                   
                                </label>
                            </div>
                            
                        </div>
                    </td>
                    
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>9/ Supplier's Name:</label>&nbsp;

<?php echo $row_old_data->txt_9; ?>
                                 
                            </div>
                        </div>
                        <div class="pull-right">
                           
                        </div> 
                    </td>
                </tr>


                <tr>
                 
                   <td>
                        <div class="row">
                            <div class="col-xs-12">
                                <label class="mt-checkbox">
                                    <?php if($row_old_data->ch_3_3=="1") {echo $check_img;} else {echo $uncheck_img; } ?>3/ កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ
                                   
                                </label>
                            </div>
                            
                        </div>
                    </td>
                    
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>10/ Phone Number:</label>&nbsp;

<?php echo $row_old_data->txt_10; ?>
                                 
                            </div>
                        </div>
                        <div class="pull-right">
                           
                        </div> 
                    </td>
                </tr>





                 <tr></tr>
                <tr>
                 
                   <td>
                        <div class="row">
                            <div class="col-xs-12">
                                <label class="mt-checkbox">
                                   <?php if($row_old_data->ch_3_4=="1") {echo $check_img;} else {echo $uncheck_img; } ?>4/ រ.តាមដានចំណាយ, រ.ស្តុក, រ.ជួសជុលគ្រឿងចក្រ
                                   
                                </label>
                            </div>
                            
                        </div>
                    </td>
                    <td class="par_rotate" rowspan="4">
                        <div class="rotate" >Received Info</div>
                    </td>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>11/ Area Purchase:</label>&nbsp;

<?php echo $row_old_data->txt_11; ?>
                               
                            </div>
                        </div>
                        <div class="pull-right">
                           
                        </div> 
                    </td>
                </tr>

                <tr>
                 
                   <td>
                        <div class="row">
                            <div class="col-xs-12">
                                <label class="mt-checkbox">
                                    <?php if($row_old_data->ch_3_5=="1") {echo $check_img;} else {echo $uncheck_img; } ?>5/ សំភារៈធ្លាប់ទិញឫជួសជុលពីមុន
                                   
                                </label>
                            </div>
                            
                        </div>
                    </td>
                    
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>12/ Site Received Date:</label>&nbsp;

<?php echo $row_old_data->txt_12; ?>
                                 
                            </div>
                        </div>
                        <div class="pull-right">
                           
                        </div> 
                    </td>
                </tr>


                <tr>
                 
                   <td>
                        <div class="row">
                            <div class="col-xs-12">
                                <label class="mt-checkbox">
                                    <?php if($row_old_data->ch_3_6=="1") {echo $check_img;} else {echo $uncheck_img; } ?>6/ Quotation
                                   
                                </label>
                            </div>
                            
                        </div>
                    </td>
                    
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>13/ Attachment:</label>&nbsp;

<?php echo $row_old_data->txt_13; ?>
                                 
                            </div>
                        </div>
                        <div class="pull-right">
                           
                        </div> 
                    </td>
                </tr>


                 <tr>
                 
                   <td>
                        <div class="row">
                            <div class="col-xs-12">
                                <label class="mt-checkbox">
                                   <?php if($row_old_data->ch_3_7=="1") {echo $check_img;} else {echo $uncheck_img; } ?>7/ ផែនការប្រើប្រាស់សំភារៈផលិត
                                   
                                </label>
                            </div>
                            
                        </div>
                    </td>
                    
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>14/ Stock In Slip:</label>&nbsp;

<?php echo $row_old_data->txt_14; ?>
                                 
                            </div>
                        </div>
                        <div class="pull-right">
                           
                        </div> 
                    </td>
                </tr>





            </tbody>
        </table>
        <div class="row">
            <div class="col-xs-1"></div>
            <div class="col-xs-3" class="text-center">
                <label style="font-weight: bold;">Reviewed by<br><span style="color:#337ab7;">(ADMIN)</span></label>
                <br><br><br><br><br><br>
                <div style="border: 0.5px double black;"></div>
                <label>Date:</label>
                <?php echo $row_old_data->review_ad_date; ?>
                <br><br><br>
            </div>
            <div class="col-xs-1"></div>
            <div class="col-xs-3" class="text-center">
                <label style="font-weight: bold;">Reviewed by<br><span style="color:#337ab7;">(FM)</span></label>
                 <br><br><br><br><br><br>
                <div style="border: 0.5px double black;"></div>
                <label>Date:</label>
                <?php echo $row_old_data->review_fm_date; ?>
                <br><br><br>
            </div>

            <div class="col-xs-1"></div>
            <div class="col-xs-3" class="text-center">
                <label style="font-weight: bold;">Approved by<br><span style="color:#337ab7;">(CEO)</span>
                </label>
                
                 <br><br><br><br><br><br>
                <div style="border: 0.5px double black;"></div>
                <label>Date:</label>
                <?php echo $row_old_data->app_ceo_date; ?>
                <br><br><br>
            </div>

        </div>
    <br>
    <br>
    <br>
    <script src="../../assets/global/plugins/jquery.min.js"></script>
    <script src="../../print_offline/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.par_rotate').each(function(e){
                $v_parent_width = $('.par_rotate').eq(e).width();
                $v_parent_height = $('.par_rotate').eq(e).height()+15;
                $('.rotate').eq(e).width($v_parent_height+'px');
                $('.rotate').eq(e).css('margin-left','-'+(($v_parent_height/2))+'px');
                $('.rotate').eq(e).css('margin-top',($v_parent_height/2)-10+'px');
            });
        });
    </script>
</body>
</html>
<script type="text/javascript">
        $(document).ready(function () {
           window.print();
        });
        setTimeout(function(){
          window.close();
        },1000);
    </script>
