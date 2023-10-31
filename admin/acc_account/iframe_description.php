<?php 
    $menu_active =1;
    $layout_title = "Welcome";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
?>


<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
<!-- END GLOBAL MANDATORY STYLES -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="../../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN THEME GLOBAL STYLES -->
<link href="../../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="../../assets/global/css/components-rounded.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="../../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
<!-- END THEME GLOBAL STYLES -->

<!-- BEGIN THEME LAYOUT STYLES -->
<link href="../../assets/layouts/layout4/css/layout.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/layouts/layout4/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
<link href="../../assets/layouts/layout4/css/custom.min.css" rel="stylesheet" type="text/css" />
<!-- END THEME LAYOUT STYLES -->
<?php
    
        $get_data=$connect->query("SELECT A.*,acc_id,debit,credit,accca_number,accca_account_name ,accta_type_account
            FROM tbl_acc_add_tran_amount_detail AS A 
            LEFT JOIN tbl_acc_chart_account AS B ON A.acc_id=B.accca_id
            LEFT JOIN tbl_acc_type_account AS C ON B.accca_account_type=C.accta_id
            WHERE accta_type_account='Expense'");
        
    
?>
<div class="portlet light bordered">
    <br>
    <div class="row">
        <div class="panel-heading text-center text-primary">
            <h2><b>Expense Information</b></h2>
        </div>
    </div>
    
    <br>
    <br>
    <br>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%;">N&deg;</th>
                        <th class="text-center">Code</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">Transation Note</th>
                        
                        <th class="text-center" style="width: 7%;">Debit</th>
                        <th class="text-center" style="width: 7%;">Credit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $tot_debit=0;
                        $tot_credit=0;
                        while ($row = mysqli_fetch_object($get_data)) {      
                            echo '<tr>';
                                echo '<td class="text-center">'.(++$i).'</td>';
                                echo '<td class="text-left">'.$row->detail_code.'</td>';
                                echo '<td class="text-left">'.$row->accca_number.' = '.$row->accca_account_name.'<br><small>'.$row->description.'</small></td>';
                                echo '<td class="text-left">'.$row->tran_note.'</td>';
                                
                                echo '<td class="text-left">'.number_format($row->debit,2).'</td>';
                                echo '<td class="text-left">'.number_format($row->credit,2).'</td>';
                            echo '</tr>';
                            $tot_debit+=$row->debit;
                            $tot_credit+=$row->credit;
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr class="bg-success">
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        
                        <th class="text-left"><?= number_format($tot_debit,2) ?></th>
                        <th class="text-left"><?= number_format($tot_credit,2) ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<!-- BEGIN CORE PLUGINS -->
<script src="../../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="../../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="../../assets/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../assets/pages/scripts/table-datatables-buttons.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="../../assets/layouts/layout4/scripts/layout.min.js" type="text/javascript"></script>
<script src="../../assets/layouts/layout4/scripts/demo.min.js" type="text/javascript"></script>
<!-- <script src="../../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script> -->
<!-- <script src="../../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script> -->
<!-- END THEME LAYOUT SCRIPTS -->

