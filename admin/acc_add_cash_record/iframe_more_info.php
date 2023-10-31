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
<!-- <link href="https://fonts.googleapis.com/css?family=Rancho&effect=shadow-multiple" rel="stylesheet" type="text/css" /> -->
<!-- END THEME LAYOUT STYLES -->
<style type="text/css">
    @import "https://fonts.googleapis.com/css?family=Rancho&effect=3d";
    @import url(https://fonts.googleapis.com/css?family=khmer);
    *{
        font-family: 'khmer','Time New Roman';
    }
</style>
<?php
    if(@$_GET['v_id']){
        $v_id=@$_GET['v_id'];
        $get_data=$connect->query("SELECT A.*,des_name
            FROM  tbl_acc_cash_record_detail AS A 
            LEFT JOIN tbl_acc_decription AS B ON A.des_id=B.des_id
            WHERE cash_rec_id='$v_id'");
    }
?>
<div class="portlet light bordered">
    <br>
    <div class="row">
        <div class="panel-heading text-center">
            <h1 class="font-effect-3d">More Information</h1>
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
                        <th class="text-center">កូដ <br> Code</th>
                        <th class="text-center">ការបរិយាយ <br> DESCRIPTION </th>
                        <th class="text-center">សំគាល់ប្រតិបត្តិការណ៍ <br> TRANSACTION NOTE</th>
                        <th class="text-center">ឯកសារយោង <br> DOCUMENT REF</th>
                        <th class="text-center">បរិមាណ <br> QUANTITY</th>
                        <th class="text-center">តម្លៃ <br> PRICE</th>
                        <th class="text-center">បញ្ចុះតម្លៃ <br> DISCOUNT</th>
                        <th class="text-center">សរុបតម្លៃ <br>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $tot_amo=0;
                        while ($row = mysqli_fetch_object($get_data)) {      
                            echo '<tr>';
                                echo '<td class="text-center">'.(++$i).'</td>';
                                echo '<td class="text-center">'.$row->des_name.'</td>';
                                echo '<td class="text-center">'.$row->tran_note.'</td>';
                                echo '<td class="text-center">'.$row->doc_ref.'</td>';
                                echo '<td class="text-right">'.$row->qty.'</td>';
                                echo '<td class="text-right"><i class="fa fa-dollar"></i> '.number_format($row->price,2).'</td>';
                                echo '<td class="text-right"><i class="fa fa-dollar"></i> '.number_format($row->discount,2).'</td>';
                                $amo=($row->qty*$row->price)-($row->discount*0.01*$row->qty*$row->price);
                                echo '<td class="text-right"><i class="fa fa-dollar"></i> '.number_format($amo,2).'</td>';
                            echo '</tr>';
                            $tot_amo+=$amo;
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="7" class="text-right">Total Amount :</th>
                        <th class="text-right"><i class="fa fa-dollar"></i><?= number_format($tot_amo,2) ?></th>
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

