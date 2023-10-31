<?php
$layout_title = "Welcome Account";
$menu_active = 20;
$left_active=76;
include_once '../../config/database.php';
include_once '../../config/athonication.php';
include_once '../layout/header.php';
include '../acc_my_operation/my_operation.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2 style="font-family: 'Times New Roman'; color: #45932b;"><b>Expenses</b></h2>
            
            <!-- <button type="button" class="btn btn-info" name="btn_testing">Testing</button> -->
            <hr>
        </div>
    </div>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#activity" data-toggle="tab">Expenses</a>
        </li>
        <li role="presentation">
            <a href="#timeline" data-toggle="tab">Suppliers</a>
        </li>
    </ul> 
    <div class="tab-content">
        <div class="active tab-pane" id="activity">
          <div class="form-group" style="background-color: #CCECFF;">
            <br>
            <a href="#" target="_blank" id="sample_editable_1_new" class="btn green"> Expense Transactions
                <i class="fa fa-plus"></i>
            </a>
            <div class="btn-group pull-right">
                <a class="btn red btn-circle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-cog"></i>
                    <span class="hidden-xs"> New Transactions</span>
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu pull-right">
                    <li >
                        <a class="tool-action">
                            <i class="fa fa-plus"></i>
                                Time Activity
                        </a>
                    </li>
                    <li >
                        <a href="add_bill.php" class="tool-action">
                            <i role="button" data-toggle="modal" class="fa fa-plus"></i>
                                Bill
                        </a>
                    </li>
                    <li >
                        <a class="tool-action">
                            <i class="fa fa-plus"></i>
                                Import Bills
                        </a>
                    </li>
                    <li >
                        <a class="tool-action">
                            <i class="fa fa-plus"></i>
                                Expense
                        </a>
                    </li>
                    <li >
                        <a class="tool-action">
                            <i class="fa fa-plus"></i>
                                Cheque
                        </a>
                    </li>
                    <li >
                        <a class="tool-action">
                            <i class="fa fa-plus"></i>
                                Purchase order
                        </a>
                    </li>
                    <li >
                        <a class="tool-action">
                            <i class="fa fa-plus"></i>
                                Supplier Credit
                        </a>
                    </li>
                    <li >
                        <a class="tool-action">
                            <i class="fa fa-plus"></i>
                                Pay down credit card
                        </a>
                    </li>
                </ul>
            </div> 
            <br>
          </div>
          <div class="portlet-body">
            <div id="sample_1_wrapper" class="dataTables_wrapper">
                <br><br><br>
                <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_2" role="grid" aria-describedby="sample_info">
                    <thead>
                        <tr role="row" class="text-center">
                            <th>N&deg;</th>
                            <th><input type="checkbox" name=""></th>
                            <th>DATE</th>
                            <th>TYPE</th>
                            <th>PAYEE</th>
                            <th>CATEGORY</th>
                            <th>MENO</th>
                            <th>TOTAL</th>
                            <th style="min-width: 100px;" class="text-center">ACTION <i class="fa fa-cog fa-spin"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                          <td>ds</td>
                          <td><input type="checkbox" name=""></td>
                          <td>ds</td>
                          <td>ds</td>
                          <td>ds</td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td><a href="iframe_view_edit.php">View/Edit  </a>
                            <div class="btn-group pull-right">
                                <a class="" data-toggle="dropdown" aria-expanded="false">
                                    
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li >
                                        <a class="tool-action">
                                            <i class="fa fa-plus"></i>
                                                Print
                                        </a>
                                    </li>
                                    <li >
                                        <a class="tool-action">
                                            <i class="fa fa-plus"></i>
                                                Copy
                                        </a>
                                    </li>
                                    <li >
                                        <a class="tool-action">
                                            <i class="fa fa-plus"></i>
                                                Delete
                                        </a>
                                    </li>
                                    <li >
                                        <a class="tool-action">
                                            <i class="fa fa-plus"></i>
                                                Void
                                        </a>
                                    </li>
                                    
                                </ul>
                            </div>  
                          </td>
                        </tr>

                        
                    </tbody>
                </table>
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
    function load_iframe(obj){
       let v_id=$(obj).attr('data_id');
       // let v_status=$(obj).attr('data_status');
        $('#my_frame').attr("src","iframe_view_edit.php?v_id="+v_id);
    }
    function load_iframe_edit(obj){
       let v_id1=$(obj).attr('data_id');
       // let v_status=$(obj).attr('data_status');
        $('#my_frame_edit').attr("src","add_bill.php?v_id="+v_id1);
    }
</script>
<div class="modal fade" id="more_info">
    <div class="modal-dialog modal-lg">
        <iframe id="my_frame" frameborder="0" style="height: 100%; max-width: 100%; width: 100%;" align="left" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="more_info_edit">
    <div class="modal-dialog modal-lg">
        <iframe id="my_frame_edit" frameborder="0" style="height: 100%; max-width: 100%; width: 100%;" align="left" scrolling="0"></iframe>
    </div>
</div>
<?php include_once '../layout/footer.php' ?>