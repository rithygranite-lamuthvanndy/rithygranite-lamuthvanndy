<?php 
    $menu_active =13;
    $left_active =52;

    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once 'permission.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2 style="font-family: 'Khmer OS';"><i class="fa fa-fw fa-map-marker"></i> តារាងតាមដានសំណើរខែ <?= date('m') ?> ឆ្នាំ <?= date('Y') ?> (ការដ្ឋាន)</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <h4 style="font-family: 'Khmer OS';"> I- តារាងសង្ខេបសំណើរ</h2>
            <h4 style="font-family: 'Khmer OS';"> 1.1- តារាងសំណើររួម</h2>
        </div>
    </div>
    <?= button_add() ?>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th class="text-center">FR/PC No</th>
                        <th class="text-right">Date</th>
                        <th class="text-center">FR/PC Type</th>
                        <th class="text-center">Description</th>
                        <th class="text-right">Unit Price</th>
                        <th class="text-center">Qty</th>
                        <th class="text-center">AMOUNT(USD)</th>
                        <th class="text-center">Other</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT A.*,B.fpt_name FROM   tbl_fr_pc_expense as A
                            LEFT JOIN tbl_fr_pc_type_list AS B ON A.frpc_type=B.fpt_id
                            ORDER BY frpc_no ASC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->frpc_no.'</td>';
                                echo '<td>'.$row->frpc_date.'</td>';
                                echo '<td>'.$row->fpt_name.'</td>';
                                echo '<td>'.$row->frpc_description.'</td>';
                                echo '<td>'.$row->frpc_qty.'</td>';
                                echo '<td class="text-right"><i class="fa fa-dollar"></i> '.number_format($row->frpc_unit_price, 2).'</td>';
                                echo '<td class="text-right"><i class="fa fa-dollar"></i> '.number_format($row->frpc_amount, 2).'</td>';
                                echo '<td>'.$row->frpc_note.'</td>';
                                echo '<td class="text-center">';
                                echo button_edit($row->frpc_id);
                                echo button_delete($row->frpc_id);
                                echo '<a target="_blank" href="print.php?print_id=' . $row->frpc_id . '" class="btn btn-xs btn-info" title="edit"><i class="fa fa-print"></i></a> ';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>






<?php include_once '../layout/footer.php' ?>
