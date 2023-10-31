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
    if(@$_GET['v_id']){
        $v_id=@$_GET['v_id'];
        $get_data=$connect->query("SELECT A.*,B.*,
            inv_pron_name_en,D.name AS fea_name
            FROM tbl_inv_sale_revenue AS A 
            LEFT JOIN tbl_acc_inv_revenue_detial AS B ON B.none_sale_rev_id=A.id
            LEFT JOIN tbl_inv_product_name AS C ON B.inv_pro_id=C.inv_pron_id
            LEFT JOIN tbl_inv_feature AS D ON B.fea_id=D.id
            WHERE A.id='$v_id'");
    }
?>
<div class="portlet light bordered">
    <br>
    <div class="row">
        <div class="panel-heading text-center">
            <h2>More Information</h2>
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
                        <th class="text-center" rowspan="2">N&deg;</th>
                        <th class="text-center" colspan="2">Description of Goods</th>
                        <th class="text-center" colspan="3">Dimension (CM)</th>
                        <th class="text-center" colspan="2">Quantity</th>
                        <th class="text-center" rowspan="2">Unit Price <br> (USD)</th>
                        <th class="text-center">Amount <br> (USD) </th>
                    </tr>
                     <tr>
                        <th class="text-center">Inventory Name</th>
                        <th class="text-center">Feacture</th>
                        <th class="text-center">Length</th>
                        <th class="text-center">Width</th>
                        <th class="text-center">Thickness</th>
                        <th class="text-center">Slab</th>
                        <th class="text-center">M<sup>2</sup></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $tot_width=0;
                        $tot_thicknes=0;
                        $tot_slap=0;
                        $tot_mater=0;
                        $tot_unit_price=0;
                        $tot_amount=0;
                        while ($row = mysqli_fetch_object($get_data)) {      
                            echo '<tr>';
                                echo '<td class="text-center">'.(++$i).'</td>';
                                echo '<td class="text-center">'.$row->inv_pron_name_en.'</td>';
                                echo '<td class="text-center">'.$row->fea_name.'</td>';
                                echo '<td class="text-center">'.$row->length.'</td>';
                                echo '<td class="text-center">'.number_format($row->width,2).'</td>';
                                echo '<td class="text-center">'.number_format($row->thickness,2).'</td>';
                                echo '<td class="text-center">'.number_format($row->slab,2).'</td>';
                                echo '<td class="text-center">'.number_format($row->mater,2).'</td>';
                                echo '<td class="text-center">'.number_format($row->unit_price,2).'</td>';
                                echo '<td class="text-center">'.number_format($row->amount,2).'</td>';
                            echo '</tr>';
                            $tot_width+=$row->width;
                            $tot_thicknes+=$row->thickness;
                            $tot_slap+=$row->slab;
                            $tot_mater+=$row->mater;
                            $tot_unit_price+=$row->unit_price;
                            $tot_amount+=$row->amount;
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="text-right"><?= number_format($tot_width,2) ?></th>
                        <th class="text-right"><?= number_format($tot_thicknes,2) ?></th>
                        <th class="text-right"><?= number_format($tot_slap,2) ?></th>
                        <th class="text-right"><?= number_format($tot_mater,2) ?></th>
                        <th class="text-right"><?= number_format($tot_unit_price,2) ?></th>
                        <th class="text-right"><?= number_format($tot_amount,2) ?></th>
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

