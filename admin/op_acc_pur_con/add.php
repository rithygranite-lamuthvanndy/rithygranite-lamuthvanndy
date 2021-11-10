<?php 
    $menu_active =13;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
    $date=date('Y-m-d');
    if(isset($_POST['btn_prin'])){
        header('location: print.php');
    }
 ?>
<style type="text/css">
    td {
      border-collapse: collapse;
      border: 1px black solid;
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
    }
    #table_2 >thead{
        background: #D9E1F2;
    }
     #table_2 >thead >tr:nth-child(3){
        background: #fff;
    }
   
</style>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Purchase Confirmation Form</h2>
        </div>
    </div>
    <br>
    <form action="save_pur_confirm.php" method="POST" role="form">
        <!-- <button type="submit" name="btn_prin" class="btn btn-warning"><i class="fa fa-print"></i> Print</button> -->
        <button type="submit" name="btnSave" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
        <br>
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="4" style="background: #E2EFDA;text-align: center;">Purchase Request_Information</th>
                </tr>
                <tr>
                    <th colspan="4" style="background: #E7E6E6;">
                        <div class="pull-right">   
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
                                <label>1/ Confirmed Date :</label>
                            </div>
                        </div>
                        <div class="pull-right">
                            
                        </div> 
                    </td>
                   <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                 <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" value="<?= $date ?>" name="txt_confirm_date" class="form-control">
                            </div>
                        </div>
                        <div class="pull-right">
                            
                        </div> 
                    </td>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>6/ Approved by:</label>
                            
                            </div>
                        </div>
                        <div class="pull-right">
                            
                        </div> 
                    </td>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                 <input readonly="" id="txt_app_name" type="text"  value="" name="txt_6_app_by" class="form-control">
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
                                <label>2/ Request No:</label>
                            </div>
                        </div>
                        <div class="pull-right">
                            
                        </div> 
                    </td>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                 <select name="txt_request_no" id="txt_request_no" class="form-control myselect2">
                                    <option value="">=== Select And Choose ===</option>
                                    <?php 
                                        $v_select=$connect->query("SELECT A.req_id,A.req_number,A.req_date,
                                            A.type_req_id,B.dep_name,A.type_req_id,C.typr_id,C.typr_name,
                                            D.res_name,A.req_request_name,E.apn_name
                                         FROM tbl_acc_request_form AS A
                                        INNER JOIN tbl_acc_department_list AS B ON A.dep_id=B.dep_id
                                        INNER JOIN tbl_acc_type_request_list AS C ON A.type_req_id=C.typr_id
                                        INNER JOIN tbl_acc_request_name_list AS D 
                                        ON D.res_id=A.req_request_name
                                        INNER JOIN tbl_acc_approved_name_list AS E 
                                        ON E.apn_id=A.req_approved_by
                            ORDER BY A.req_id DESC");


                                        while ($row_select=mysqli_fetch_object($v_select)) {
                                            echo '<option 
                                            data_id='.$row_select->req_id.'
                                            data_app='.str_replace(' ','',$row_select->apn_name).'
                                            
                                            data_department='.str_replace(' ','',$row_select->dep_name).'
                                            data_type_request='.str_replace(' ','',$row_select->typr_name).'
                                            data_request_by='.str_replace(' ','',$row_select->res_name).'
                                             value="'.$row_select->req_id.'">['.$row_select->req_number.'] ['.$row_select->req_date.']</option>';
                                        }
                                     ?>
                                </select>
                            </div>
                        </div>
                        <div class="pull-right">
                            
                        </div> 
                    </td>                   
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>7/ Requested Amount:</label>
                            </div>
                        </div>
                        <div class="pull-right">
                            
                        </div> 
                    </td>

                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                 <input  type="text" id="txt_request_amount"  value="" name="txt_request_amount" class="form-control">
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
                                <label>3/ Department of RGC:</label>
                            </div>
                        </div>
                        <div class="pull-right">
                            
                        </div> 
                    </td>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                 <input type="text" readonly="" id="txt_department"  value="" name="txt_3_dep_of_rgc" class="form-control">
                            </div>
                        </div>
                        <div class="pull-right">
                            
                        </div> 
                    </td>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>8/ Location:</label>
                            </div>
                        </div>
                        <div class="pull-right">
                            
                        </div> 
                    </td>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                 <input type="text"  value="" name="location" class="form-control">
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
                                <label>4/ Type of Request:</label>
                            </div>
                        </div>
                        <div class="pull-right">
                            
                        </div> 
                    </td>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                 <input type="text" id="txt_type_request" readonly="" value="" name="txt_4_typ_of_req" class="form-control">
                            </div>
                        </div>
                        <div class="pull-right">
                            
                        </div> 
                    </td>      
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>9/ Buyer:</label>
                            </div>
                        </div>
                        <div class="pull-right">
                            
                        </div> 
                    </td>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <select name="txt_buyer" class="form-control myselect2">
                                    <option value="">=== Select And Choose ===</option>
                                    <?php 
                                        $v_select=$connect->query("SELECT 
                            A.*,B.po_name,C.dep_name
                            FROM tbl_hr_employee_list AS A 
                            LEFT JOIN tbl_hr_position_list AS B ON A.empl_position=B.po_id
                            LEFT JOIN tbl_hr_department_sub AS C ON A.empl_department=C.dep_id
                            ORDER BY empl_id DESC");
                                        while ($row_select=mysqli_fetch_object($v_select)) {
                                            echo '<option value="'.$row_select->empl_id.'">['.$row_select->empl_emloyee_en.'] ['.$row_select->empl_emloyee_kh.']</option>';
                                        }
                                     ?>
                                </select>
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
                                <label>5/ Requested by:</label>
                            </div>
                        </div>
                        <div class="pull-right">
                            
                        </div> 
                    </td>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                 <input readonly="" id="txt_request_by" type="text" value="" name="txt_5_res_by" class="form-control">
                            </div>
                        </div>
                        <div class="pull-right">
                            
                        </div> 
                    </td>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>10/ Note:</label>
                            </div>
                        </div>
                        <div class="pull-right">
                            
                        </div> 
                    </td>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                 <textarea name="tx_note" class="form-control"></textarea>
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
                       <select name="txt_user_id" class="form-control myselect2">
                                    <option value="">=== Select And Choose ===</option>
                                    <?php 
                                        $v_select=$connect->query("SELECT * FROM tbl_user
                            ORDER BY user_name DESC");
                                        while ($row_select=mysqli_fetch_object($v_select)) {
                                            echo '<option value="'.$row_select->user_id.'">['.$row_select->user_name.'] ['.$row_select->user_phone_number.']</option>';
                                        }
                                     ?>
                                </select>
                    </span>
                    <br>

                    <label>DATE:</label>
                    <span>
                        <?php echo date("Y-m-d"); ?>
                        <input type="hidden" name="txt_today" value="<?php echo date("Y-m-d"); ?>">
                    </span>
                </div>
            </div>
            <div class="col-xs-8">
                <div class="form-group">
                    <label style="font-weight: bold;">Description : </label>
                    <textarea rows="6" type="text" class="form-control" name="txt_des" autocomplete="off"></textarea>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-hover"  id="table_2">
            <thead>
               
            <tr>
                <th colspan="3">*** (First Request) Admin Type of Request and Reference Requirement:</th>
                <th colspan="2">***(Last Request) Admin Reference Requirement:</th>

            </tr>
                <tr>
                    <th class="text-center" rowspan="2">No</th>
                    <th class="text-center" rowspan="2" width="14%;">Type of Request</th>
                    <th class="text-center" colspan="1">Reference Requirement</th>
                    <th class="text-center" rowspan="2" colspan="2">Checking Note Cashier</th>
                </tr>
                <tr>
                    <th class="text-center">Permanent Request</th>
                    
                </tr>
            </thead>
            <tbody>
               <tr>
                 <td rowspan="3" style="vertical-align: middle !important;">1</td>
                 <td rowspan="3" style="vertical-align: middle !important;">From $1 - $200</td>
                   <td>
                        <div class="row">
                            <div class="col-xs-12">
                                <label class="mt-checkbox">
                                    <input type="checkbox"  name="txt_ch_1_1" value="1">1/ ការឯកភាពពីគណៈគ្រប់គ្រង
                                    <span></span>
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
                                <label>1/ Received Date:</label>
                                 <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" value="<?= $date ?>" name="txt_1" class="form-control">
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
                                    <input type="checkbox"  name="txt_ch_1_2" value="1">2/ រូបភាព
                                    <span></span>
                                </label>
                            </div>
                            
                        </div>
                    </td>
                    
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>2/ Received Amount:</label>
                                 <input type="text"  value="" name="txt_2" class="form-control">
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
                                    <input type="checkbox"  name="txt_ch_1_3" value="1">3/ កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ)
                                    <span></span>
                                </label>
                            </div>
                            
                        </div>
                    </td>
                    
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>3/ Actual Expense:</label>
                                 <input type="text"  value="" name="txt_3" class="form-control">
                            </div>
                        </div>
                        <div class="pull-right">
                           
                        </div> 
                    </td>
                </tr>

                <tr>
                  <td rowspan="5" style="vertical-align: middle !important;">2</td>
                  <td rowspan="5" style="vertical-align: middle !important;">from $201 - $300</td>
                   <td>
                        <div class="row">
                            <div class="col-xs-12">
                                <label class="mt-checkbox">
                                    <input type="checkbox"  name="txt_ch_2_1" value="1">1/ ការឯកភាពពីគណៈគ្រប់គ្រង
                                    <span></span>
                                </label>
                            </div>
                            
                        </div>
                    </td>
                    
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>4/ Cash Settlement:</label>
                                 <input type="text"  value="" name="txt_4" class="form-control">
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
                                    <input type="checkbox"  name="txt_ch_2_2" value="1">2/ រូបភាព
                                    <span></span>
                                </label>
                            </div>
                            
                        </div>
                    </td>
                    
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>5/ Cash Settled by:</label>
                                 <input type="text"  value="" name="txt_5" class="form-control">
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
                                    <input type="checkbox"  name="txt_ch_2_3" value="1">3/ កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ)
                                    <span></span>
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
                                <label>6/ Purchsed Date :</label>
                                 <input type="text"  data-provide="datepicker" data-date-format="yyyy-mm-dd" value="<?= $date ?>" name="txt_6" class="form-control">
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
                                    <input type="checkbox"  name="txt_ch_2_4" value="1">4/ រ.តាមដានចំណាយ, រ.ស្តុក, រ.ជួសជុលគ្រឿងចក្រ
                                    <span></span>
                                </label>
                            </div>
                            
                        </div>
                    </td>
                    
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>7/ Transferred Date:</label>
                                 <input type="text"  data-provide="datepicker" data-date-format="yyyy-mm-dd" value="<?= $date ?>" name="txt_7" class="form-control">
                            </div>
                        </div>
                        <div class="pull-right">
                           
                        </div> 
                    </td>
                </tr>



                 <tr></tr>
                <tr>
                  <td rowspan="8" style="vertical-align: middle !important;">3</td>
                  <td rowspan="8" style="vertical-align: middle !important;">From $301 -$1000</td>
                   <td>
                        <div class="row">
                            <div class="col-xs-12">
                                <label class="mt-checkbox">
                                    <input type="checkbox"  name="txt_ch_3_1" value="1">1/ ការឯកភាពពីគណៈគ្រប់គ្រង
                                    <span></span>
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
                                <label>8/ Deliveried Date:</label>
                                 <input type="text"  data-provide="datepicker" data-date-format="yyyy-mm-dd" value="<?= $date ?>" name="txt_8" class="form-control">
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
                                    <input type="checkbox"  name="txt_ch_3_2" value="1">2/ រូបភាព
                                    <span></span>
                                </label>
                            </div>
                            
                        </div>
                    </td>
                    
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>9/ Supplier's Name:</label>
                                 <input type="text"  value="" name="txt_9" class="form-control">
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
                                    <input type="checkbox"  name="txt_ch_3_3" value="1">3/ កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ
                                    <span></span>
                                </label>
                            </div>
                            
                        </div>
                    </td>
                    
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>10/ Phone Number:</label>
                                 <input type="text"  value="" name="txt_10" class="form-control">
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
                                    <input type="checkbox"  name="txt_ch_3_4" value="1">4/ រ.តាមដានចំណាយ, រ.ស្តុក, រ.ជួសជុលគ្រឿងចក្រ
                                    <span></span>
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
                                <label>11/ Area Purchase:</label>
                                 <input type="text"  value="" name="txt_11" class="form-control">
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
                                    <input type="checkbox"  name="txt_ch_3_5" value="1">5/ សំភារៈធ្លាប់ទិញឫជួសជុលពីមុន
                                    <span></span>
                                </label>
                            </div>
                            
                        </div>
                    </td>
                    
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>12/ Site Received Date:</label>
                                 <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" value="<?= $date ?>" name="txt_12" class="form-control">
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
                                    <input type="checkbox"  name="txt_ch_3_6" value="1">6/ Quotation
                                    <span></span>
                                </label>
                            </div>
                            
                        </div>
                    </td>
                    
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>13/ Attachment:</label>
                                 <input type="text"  value="" name="txt_13" class="form-control">
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
                                    <input type="checkbox"  name="txt_ch_3_7" value="1">7/ ផែនការប្រើប្រាស់សំភារៈផលិត
                                    <span></span>
                                </label>
                            </div>
                            
                        </div>
                    </td>
                    
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>14/ Stock In Slip:</label>
                                 <input type="text"  value="" name="txt_14" class="form-control">
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
                <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" value="<?= $date ?>" name="txt_review_admin_date" class="form-control">
                <br><br><br>
            </div>
            <div class="col-xs-1"></div>
            <div class="col-xs-3" class="text-center">
                <label style="font-weight: bold;">Reviewed by<br><span style="color:#337ab7;">(FM)</span></label>
                 <br><br><br><br><br><br>
                <div style="border: 0.5px double black;"></div>
                <label>Date:</label>
                <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" value="<?= $date ?>" name="txt_review_fm_date" class="form-control">
                <br><br><br>
            </div>

            <div class="col-xs-1"></div>
            <div class="col-xs-3" class="text-center">
                <label style="font-weight: bold;">Approved by<br><span style="color:#337ab7;">(CEO)</span></label>
                 <br><br><br><br><br><br>
                <div style="border: 0.5px double black;"></div>
                <label>Date:</label>
                 <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" value="<?= $date ?>" name="txt_app_ceo_date" class="form-control">
                <br><br><br>
            </div>

        </div>
    
    </form>
</div> 
<script type="text/javascript">

    $(document).ready(function(){
        $('.par_rotate').each(function(e){
            $v_parent_width = $('.par_rotate').eq(e).width();
            $v_parent_height = $('.par_rotate').eq(e).height()+15;
            $('.rotate').eq(e).width($v_parent_height+'px');
            $('.rotate').eq(e).css('margin-left','-'+(($v_parent_height/2)-15)+'px');
            $('.rotate').eq(e).css('margin-top',($v_parent_height/2)-15+'px');
        });

        $("tbody").on('change', '#txt_request_no', function () {
            data_app=$(this).find('option:selected').attr('data_app');
            $("#txt_app_name").val(data_app);
            data_department=$(this).find('option:selected').attr('data_department');
            $("#txt_department").val(data_department);
            data_type_request=$(this).find('option:selected').attr('data_type_request');
            $("#txt_type_request").val(data_type_request);
            data_request_by=$(this).find('option:selected').attr('data_request_by');
            $("#txt_request_by").val(data_request_by);


            data_id=$(this).find('option:selected').attr('data_id');

            $.ajax({url: 'ajx_get_amount.php?id='+data_id,success:function (result) {
               
              $('#txt_request_amount').val(result);
            if($('#txt_request_amount').html().trim()!=result.trim())
                $('#txt_request_amount').html(result);
                }});           
           
             

        });


    });
     

     

    

     



</script>
<?php include_once '../layout/footer.php' ?>