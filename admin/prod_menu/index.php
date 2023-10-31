<?php 
    $layout_title = "Welcome";
    $menu_active =11;
    $left_menu =4;
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2 style="font-family:'Khmer OS';">តារាងតាមដាន</h2>
			<hr>
        </div>
    </div>
    <br><br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">    
                <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info">
                    <thead>
                        <tr role="row" class="text-center">
                            <th rowspan="2" class="text-center">N&deg;</th>
                            <th rowspan="2" class="text-center">Code Customer</th>
                            <th colspan="2" class="text-center">Customer</th>
                            <th colspan="3" class="text-center">Quotetion</th>
                            <th colspan="4" class="text-center">Purchase Order</th>
                            <th colspan="4" class="text-center">Delivery Note</th>
                            <th colspan="4" class="text-center">Invioce</th>
                            <th colspan="3" class="text-center">Total & Balance</th>
                        </tr>
                        <tr role="row" class="text-center">
                            <th class="text-center">Name</th>
                            <th class="text-center">Ship</th>
                            <th class="text-center">Code</th>
                            <th class="text-center">Feature</th>
                            <th class="text-center">QTY</th>
                            <th class="text-center">Code</th>
                            <th class="text-center">Feature</th>
                            <th class="text-center">PCs</th>
                            <th class="text-center">M2/M3</th>
                            <th class="text-center">Code</th>
                            <th class="text-center">Feature</th>
                            <th class="text-center">PCs</th>
                            <th class="text-center">M2/M3</th>
                            <th class="text-center">Code</th>
                            <th class="text-center">Feature</th>
                            <th class="text-center">PCs</th>
                            <th class="text-center">M2/M3</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Balances</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i = 0;
                            $get_data = $connect->query("SELECT 
                                   *
                                FROM tbl_pro_price AS A 
                                ORDER BY pp_id ASC");
                            while ($row = mysqli_fetch_object($get_data)) {
                                echo '<tr>';
                                    echo '<td>'.(++$i).'</td>';
                                    echo '<td>'.$row->pp_name_id.'</td>';
                                    echo '<td>'.$row->pp_name_id.'</td>';
                                    echo '<td>'.$row->pp_name_id.'</td>';
                                    echo '<td>'.$row->pp_length.'</td>';
                                    echo '<td>'.$row->pp_width.'</td>';
                                    echo '<td>'.$row->pp_thickness.'</td>';
                                    echo '<td>'.$row->pp_pcs_slab.'</td>';
                                    echo '<td>'.$row->pp_m2_m3.'</td>';
                                    echo '<td>'.$row->pp_price.'</td>';
                                    echo '<td>'.$row->pp_name_id.'</td>';
                                    echo '<td>'.$row->pp_name_id.'</td>';
                                    echo '<td>'.$row->pp_name_id.'</td>';
                                    echo '<td>'.$row->pp_length.'</td>';
                                    echo '<td>'.$row->pp_width.'</td>';
                                    echo '<td>'.$row->pp_thickness.'</td>';
                                    echo '<td>'.$row->pp_pcs_slab.'</td>';
                                    echo '<td>'.$row->pp_m2_m3.'</td>';
                                    echo '<td>'.$row->pp_price.'</td>';
                                    echo '<td>'.$row->pp_thickness.'</td>';
                                    echo '<td>'.$row->pp_pcs_slab.'</td>';
                                    echo '<td>'.$row->pp_m2_m3.'</td>';
                                    echo '<td>'.$row->pp_price.'</td>';
                                    echo '<td>'.$row->pp_pcs_slab.'</td>';
                                    echo '<td>'.$row->pp_m2_m3.'</td>';
                                    echo '<td>'.$row->pp_price.'</td>';
                                echo '</tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                    <div class="form-group">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#activity" data-toggle="tab">Name</a>
                            </li>
                            <li role="presentation">
                                <a href="#timeline" data-toggle="tab">Transactions</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">
                                <br>
                                <b>Quotation</b>
                                <hr>
                                <table width="100%" class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>QTY</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        $get_data_qt = $connect->query("SELECT 
                                               A.*,TE.*, (select  count(qtl_qt_id) from  tbl_prod_add_quote_list where qtl_qt_id = A.qt_id) as countdate
                                            FROM   tbl_prod_add_quote AS A 
                                            LEFT JOIN tbl_estimate AS TE ON TE.te_id = A.qt_estimate
                                            ORDER BY qt_id DESC");
                                        while ($rowqt = mysqli_fetch_object($get_data_qt)) {
                                            
                                            echo '<tr>';
                                            echo '<td>'.(++$i).'</td>';
                                            echo '<td>'.$rowqt->qt_date.'</td>';
                                            echo '<td>'.$rowqt->te_name_en.'</td>';
                                            echo '<td>'.$rowqt->countdate.'</td>';
                                            echo '</tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table><br>

                                <b>Purchase Order</b>
                                <hr>
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>QTY</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $j = 0;
                                        $get_data_po = $connect->query("SELECT 
                                               A.*,left(TE.tso_name_en,10) as tsoname, (select  count(pol_name) from  tbl_prod_add_po_list where pol_po_id = A.po_id) as countdate
                                            FROM   tbl_prod_add_po AS A 
                                            LEFT JOIN tbl_sale_order AS TE ON TE.tso_id = A.po_sale_order
                                            ORDER BY po_id DESC");
                                        while ($rowpo = mysqli_fetch_object($get_data_po)) {
                                            
                                            echo '<tr>';
                                            echo '<td>'.(++$j).'</td>';
                                            echo '<td>'.$rowpo->po_date.'</td>';
                                            echo '<td>'.$rowpo->tsoname.'...</td>';
                                            echo '<td>'.$rowpo->countdate.'</td>';
                                            echo '</tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table><br>
                                <b>Delivery Note</b>
                                <hr>
                                <table width="100%" class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>QTY</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $j = 0;
                                        $get_data_dv = $connect->query("SELECT 
                                               A.*,left(TE.tdv_name_en,7) as tsoname, (select  count(dvl_name) from  tbl_prod_dv_list where dvl_dv_id = A.dv_id) as countdate
                                            FROM   tbl_prod_dv AS A 
                                            LEFT JOIN tbl_prod_type_dv AS TE ON TE.tdv_id = A.dv_type_id
                                            ORDER BY dv_id DESC");
                                        while ($rowdv = mysqli_fetch_object($get_data_dv)) {
                                            
                                            echo '<tr>';
                                            echo '<td>'.(++$j).'</td>';
                                            echo '<td>'.$rowdv->dv_date.'</td>';
                                            echo '<td>'.$rowdv->tsoname.'...</td>';
                                            echo '<td>'.$rowdv->countdate.'</td>';
                                            echo '</tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table><br>
                                <b>Invioce</b>
                                <hr><br><br><br><br>
                            </div>
                            <div class="tab-pane" id="timeline">
                            </div>
                        </div>    
                    </div>                       
            </div>
        </div>
    </div>
</div>






<?php include_once '../layout/footer.php' ?>
