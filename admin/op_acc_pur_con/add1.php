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
                    <th colspan="3" style="background: #E2EFDA;">Purchase Request_Information</th>
                </tr>
                <tr>
                    <th colspan="3" style="background: #E7E6E6;">
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
                                <label>1/Date Request:</label>
                                 <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" value="<?= $date ?>" name="txt_1_date_res" class="form-control">
                            </div>
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <input type="checkbox" id="inlineCheckbox22" name="chk_1_date_rec">
                                <span></span>
                            </label>
                        </div> 
                    </td>
                    <td class="par_rotate" rowspan="4">
                        <div class="rotate">Cash Advance Info</div>
                    </td>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>1/Date:</label>
                                 <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" value="<?= $date ?>" name="txt_1_date" class="form-control">
                            </div>
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <input type="checkbox" id="inlineCheckbox22" name="chk_1_date">
                                <span></span>
                            </label>
                        </div> 
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>2/Request No :</label>
                                <select name="txt_2_res_no" id="input" class="form-control myselect2">
                                    <option value="">=== Select And Choose ===</option>
                                    <?php 
                                        $v_select=$connect->query("SELECT req_id,req_number,req_date FROM tbl_acc_request_form ORDER BY req_id DESC");
                                        while ($row_select=mysqli_fetch_object($v_select)) {
                                            echo '<option value="'.$row_select->res_id.'">['.$row_select->req_number.'] ['.$row_select->req_date.']</option>';
                                        }
                                     ?>
                                </select>

                                <!-- <input type="text" name="txt_2_res_no" id="input" class="form-control"> -->
                            </div>
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <input type="checkbox" id="inlineCheckbox22" name="chk_2_req_no">
                                <span></span>
                            </label>
                        </div> 
                    </td>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>2/Amount Received :</label>
                                <input type="number" name="txt_2_amo_rec" id="input" class="form-control" step="0.01">
                            </div>
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <input type="checkbox" id="inlineCheckbox22" name="chk_2_amo_rec">
                                <span></span>
                            </label>
                        </div> 
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>3/Department of RGC  :</label>
                                <input type="text" name="txt_3_dep_of_rgc" id="input" class="form-control">
                            </div>
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <input type="checkbox" id="inlineCheckbox22" name="chk_3_dep_of_rgc">
                                <span></span>
                            </label>
                        </div> 
                    </td>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>3/Actual Expense :</label>
                                <input type="text" name="txt_3_act_exp" id="input" class="form-control">
                            </div>
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <input type="checkbox" id="inlineCheckbox22" name="chk_3_act_exp">
                                <span></span>
                            </label>
                        </div> 
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label> 4/Type of Request No: (***)</label>
                                <input type="text" name="txt_4_typ_of_req" id="input" class="form-control">
                            </div>
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <input type="checkbox" id="inlineCheckbox22" name="chk_4_type_of_req">
                                <span></span>
                            </label>
                        </div> 
                    </td>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>4/Cash Reimbursement :</label>
                                <input type="text" name="txt_4_cash_rei" id="input" class="form-control">
                            </div>
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <input type="checkbox" id="inlineCheckbox22" name="chk_4_cash_rei">
                                <span></span>
                            </label>
                        </div> 
                    </td>
                </tr>
                <tr></tr>

                <tr>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>5/Request by :</label>
                                <select name="txt_5_res_by" id="input" class="form-control myselect2">
                                    <option value="">=== Select And Choose ===</option>
                                    <?php 
                                        $v_select=$connect->query("SELECT res_id,res_name FROM tbl_acc_request_name_list ORDER BY res_name ASC");
                                        while ($row_select=mysqli_fetch_object($v_select)) {
                                            echo '<option value="'.$row_select->res_id.'">'.$row_select->res_name.'</option>';
                                        }
                                     ?>
                                </select>
                                <!-- <input type="text" name="txt_5_res_by" id="input" class="form-control" required="required"> -->
                            </div>
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <input type="checkbox" id="inlineCheckbox22" name="chk_5_req_by">
                                <span></span>
                            </label>
                        </div> 
                    </td>
                    <td class="par_rotate" rowspan="2">
                        <div class="rotate">Purchase Date</div>
                    </td>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>5/Date of Purchse :</label>
                                <input type="text"  data-provide="datepicker" data-date-format="yyyy-mm-dd" name="txt_5_date_pur" id="input" class="form-control">
                            </div>
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <input type="checkbox" id="inlineCheckbox22" name="chk_5_date_pur">
                                <span></span>
                            </label>
                        </div> 
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>6/Approve by :</label>
                                <select name="txt_6_app_by" id="input" class="form-control myselect2">
                                    <option value="">=== Select And Choose ===</option>
                                    <?php 
                                        $v_select=$connect->query("SELECT apn_id,apn_name FROM  tbl_acc_approved_name_list ORDER BY apn_name ASC");
                                        while ($row_select=mysqli_fetch_object($v_select)) {
                                            echo ' <option value="'.$row_select->apn_id.'">'.$row_select->apn_name.'</option>';
                                        }
                                     ?>
                                </select>
                                <!-- <input type="text" name="txt_6_app_by" id="input" class="form-control" required="required"> -->
                            </div>
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <input type="checkbox" id="inlineCheckbox22" name="chk_6_appr_by">
                                <span></span>
                            </label>
                        </div> 
                    </td>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>6/Date of Delivery  :</label>
                                <input type="text"  data-provide="datepicker" data-date-format="yyyy-mm-dd" name="txt_6_date_of_del" id="input" class="form-control">
                            </div>
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <input type="checkbox" id="inlineCheckbox22"  name="chk_6_date_del">
                                <span></span>
                            </label>
                        </div> 
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>7/Amount Request :</label>
                                <input type="number" name="txt_7_amo_req" id="input" class="form-control" step="0.01">
                            </div>
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <input type="checkbox" id="inlineCheckbox22" name="chk_7_amo_req">
                                <span></span>
                            </label>
                        </div> 
                    </td>
                    <td rowspan="3" class="par_rotate" >
                        <div class="rotate">Supplier Info</div>
                    </td>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>7/Supply Name:</label>
                                <input type="text" name="txt_7_sup_name" id="input" class="form-control">
                            </div>
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <input type="checkbox" id="inlineCheckbox22" name="chk_7_sup_name">
                                <span></span>
                            </label>
                        </div> 
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>8/Location :</label>
                                <input type="text" name="txt_8_loc" id="input" class="form-control">
                            </div>
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <input type="checkbox" id="inlineCheckbox22" name="chk_8_loc">
                                <span></span>
                            </label>
                        </div> 
                    </td>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>8/Area Purchase:</label>
                                <input type="text" name="txt_8_area_pur" id="input" class="form-control">
                            </div>
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <input type="checkbox" id="inlineCheckbox22" name="chk_8_area_pur">
                                <span></span>
                            </label>
                        </div> 
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>9/Responsible Purchase :</label>
                                <input type="text" name="txt_9_res_pur" id="input" class="form-control">
                            </div>
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <input type="checkbox" id="inlineCheckbox22"  name="chk_9_res_pur">
                                <span></span>
                            </label>
                        </div> 
                    </td>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>9/Phone Number:</label>
                                <input type="text" id="mask_phone" name="txt_9_pho_num" class="form-control">
                            </div>
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <input type="checkbox" id="inlineCheckbox22" name="chk_9_pho_number">
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
                                <textarea name="txt_sub_note" id="inputTxt_sub_note" class="form-control" rows="5" cols="50"></textarea>
                            </div>
                        </div>
                    </td>
                    <td rowspan="2"class="par_rotate">
                        <div class="rotate">Site Received Info</div>
                    </td>
                    <td>
                        <div class="pull-left">
                             
                            <div class="form-inline">
                                <label>10/Site Received Date:</label>
                                <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" name="txt_10_site_rec_date" id="input" class="form-control">
                            </div>
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <input type="checkbox" id="inlineCheckbox22" name="chk_10_site_rec_date">
                                <span></span>
                            </label>
                        </div> 
                    </td>
                </tr>
                    <td>
                        <div class="pull-left">
                            <div class="form-inline">
                                <label>11/Site Received Reference:</label>
                                <input type="text" name="txt_11_site_rec_ref" id="input" class="form-control">
                            </div>
                        </div>
                        <div class="pull-right">
                            <label class="mt-checkbox">
                                <input type="checkbox" id="inlineCheckbox22" name="chk_11_site_rec_ref">
                                <span></span>
                            </label>
                        </div> 
                    </td>
                <tr>
                <tr>
                    <td>
                        <div class="row">
                            <div class="col-xs-6 col-md-6 col-lg-6 text-center">
                                <b>Prepared by</b>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <div style="border: 0.5px dashed black;"></div>
                                <br>
                                <label class="pull-left">Date Record :
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" value="<?= $date ?>" name="txt_date_pre_1" class="form-control">
                            </div>
                            <div class="col-xs-6 col-md-6 col-lg-6 text-center">
                                <b>Acknowledged by</b>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <div style="border: 0.5px dashed black;"></div>
                                <br>
                                <label class="pull-left">Date Record :
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" value="<?= $date ?>" name="txt_date_ack_by_1" class="form-control">
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
                                <br>
                                <br>
                                <div style="border: 0.5px dashed black;"></div>
                                <br>
                                <label class="pull-left">Date Record :
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" value="<?= $date ?>" name="txt_date_pre_2" class="form-control">
                            </div>
                            <div class="col-xs-6 col-md-6 col-lg-6 text-center">
                                <b>Acknowledged by</b>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <div style="border: 0.5px dashed black;"></div>
                                <br>
                                <label class="pull-left">Date Record :
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" value="<?= $date ?>" name="txt_date_ack_by_2" class="form-control">
                            </div>
                        </div>
                    </td>    
                </tr>
            </tbody>
        </table>
        <table class="table table-bordered table-hover"  id="table_2">
            <thead>
                <tr>
                    <th colspan="4" style="background: #E2EFDA;">Purchase Request_Information</th>
                </tr>
                <tr>
                    <th colspan="4" style="background: #E7E6E6;">
                        <div class="pull-right">   
                            Accountant or Account Manager Responsibility
                        </div>
                    </th>
                </tr>
                <tr>
                    <th colspan="4">*** Type of Request and Reference Requirement:</th>
                </tr>
                <tr>
                    <th class="text-center" rowspan="2">No</th>
                    <th class="text-center" rowspan="2">Type of Request</th>
                    <th class="text-center" colspan="2">Reference Requirement</th>
                </tr>
                <tr>
                    <th class="text-center">Permanent Request</th>
                    <th class="text-center">Temporary Request</th>
                </tr>
            </thead>
            <tbody>
                <tr rowspan="2">
                    <td>1</td>
                    <td>From $1 - $200</td>
                    <td>
                        <div class="row">
                            <div class="col-xs-6">
                                <label class="mt-checkbox">
                                    <input type="checkbox" id="inlineCheckbox22" name="chk_tab_1_1_1">1/ការឯកភាពពីគណៈគ្រប់គ្រង
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-xs-6">
                                <label class="mt-checkbox">
                                    <input type="checkbox" id="inlineCheckbox22" name="chk_tab_1_1_2">2/រូបភាព
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-xs-6">
                                <label class="mt-checkbox">
                                    <input type="checkbox" id="inlineCheckbox22" name="chk_tab_1_2_1">1/ការឯកភាពពីគណៈគ្រប់គ្រង
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-xs-6">
                                <label class="mt-checkbox">
                                    <input type="checkbox" id="inlineCheckbox22" name="chk_tab_1_2_2">2/រូបភាព
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label class="mt-checkbox">
                                    <input type="checkbox" id="inlineCheckbox22" name="chk_tab_1_2_3">3/កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ)
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr rowspan="2">
                    <td >2</td>
                    <td>from $201 - $300</td>
                    <td>
                        <div class="row">
                            <div class="col-xs-6">
                                <label class="mt-checkbox">
                                    <input type="checkbox" id="inlineCheckbox22" name="chk_tab_2_1_1">1/ការឯកភាពពីគណៈគ្រប់គ្រង
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-xs-6">
                                <label class="mt-checkbox">
                                    <input type="checkbox" id="inlineCheckbox22" name="chk_tab_2_1_2">2/រូបភាព
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-xs-12">
                                <label class="mt-checkbox">
                                    <input type="checkbox" id="inlineCheckbox22" name="chk_tab_2_1_3">3/កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ)
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-xs-12">
                                <label class="mt-checkbox">
                                    <input type="checkbox" id="inlineCheckbox22" name="chk_tab_2_1_4">4/រ.តាមដានចំណាយ, រ.ស្តុក, រ.ជួសជុលគ្រឿងចក្រ
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-xs-6">
                                <label class="mt-checkbox">
                                    <input type="checkbox" id="inlineCheckbox22" name="chk_tab_2_2_1">1/ការឯកភាពពីគណៈគ្រប់គ្រង
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-xs-6">
                                <label class="mt-checkbox">
                                    <input type="checkbox" id="inlineCheckbox22" name="chk_tab_2_2_2">2/រូបភាព
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-xs-12">
                                <label class="mt-checkbox">
                                    <input type="checkbox" id="inlineCheckbox22" name="chk_tab_2_2_3">3/កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ)
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-xs-12">
                                <label class="mt-checkbox">
                                    <input type="checkbox" id="inlineCheckbox22" name="chk_tab_2_2_4">4/រ.តាមដានចំណាយ, រ.ស្តុក, រ.ជួសជុល
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr rowspan="2">
                    <td>3</td>
                    <td rowspan="2">From $301 -$1000</td>
                    <td>
                        <div class="row">
                            <div class="col-xs-6">
                                <label class="mt-checkbox">
                                    <input type="checkbox" id="inlineCheckbox22" name="chk_tab_3_1_1">1/ការឯកភាពពីគណៈគ្រប់គ្រង
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-xs-6">
                                <label class="mt-checkbox">
                                    <input type="checkbox" id="inlineCheckbox22" name="chk_tab_3_1_2">2/រូបភាព
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-xs-12">
                                <label class="mt-checkbox">
                                    <input type="checkbox" id="inlineCheckbox22" name="chk_tab_3_1_3">3/កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ)
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-xs-12">
                                <label class="mt-checkbox">
                                    <input type="checkbox" id="inlineCheckbox22" name="chk_tab_3_1_4">4/រ.តាមដានចំណាយ, រ.ស្តុក, រ.ជួសជុលគ្រឿងចក្រ
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-xs-6">
                                <label class="mt-checkbox">
                                    <input type="checkbox" id="inlineCheckbox22" name="chk_tab_3_1_5">5/ផែនការប្រើប្រាស់សំភារៈផលិត
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-xs-6">
                                <label class="mt-checkbox">
                                    <input type="checkbox" id="inlineCheckbox22" name="chk_tab_3_1_6">6/Quotation
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-xs-6">
                                <label class="mt-checkbox">
                                    <input type="checkbox" id="inlineCheckbox22" name="chk_tab_3_1_7">7/ផ្សេងៗ
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-xs-6">
                                <label class="mt-checkbox">
                                    <input type="checkbox" id="inlineCheckbox22" name="chk_tab_3_2_1">1/ការឯកភាពពីគណៈគ្រប់គ្រង
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-xs-6">
                                <label class="mt-checkbox">
                                    <input type="checkbox" id="inlineCheckbox22" name="chk_tab_3_2_2">2/រូបភាព
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-xs-12">
                                <label class="mt-checkbox">
                                    <input type="checkbox" id="inlineCheckbox22" name="chk_tab_3_2_3">3/កំណត់ហេតុ ឬមូលហេតុនៃការជួសជុល (បំពេញក្នុងសំណើរ)
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-xs-12">
                                <label class="mt-checkbox">
                                    <input type="checkbox" id="inlineCheckbox22" name="chk_tab_3_2_4">4/រ.តាមដានចំណាយ, រ.ស្តុក, រ.ជួសជុល
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-xs-6">
                                <label class="mt-checkbox">
                                    <input type="checkbox" id="inlineCheckbox22" name="chk_tab_3_2_5">5/ផែនការប្រើប្រាស់សំភារៈផលិត
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-xs-6">
                                <label class="mt-checkbox">
                                    <input type="checkbox" id="inlineCheckbox22" name="chk_tab_3_2_6">6/Quotation
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-xs-6">
                                <label class="mt-checkbox">
                                    <input type="checkbox" id="inlineCheckbox22" name="chk_tab_3_2_7">7/ផ្សេងៗ
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="form-group">
            <label>Description:</label>
            <input type="text" name="txt_des" id="input" class="form-control">
        </div>
        <div class="form-group">
            <label>Note : </label>
            <textarea type="text" class="form-control" name="txt_note" rows="5"  autocomplete="off"></textarea>
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
    });
</script>
<?php include_once '../layout/footer.php' ?>