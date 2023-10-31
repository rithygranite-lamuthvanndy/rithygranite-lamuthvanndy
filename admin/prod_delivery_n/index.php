<?php 
    $layout_title = "Welcome";
    $left_menu_active = 3;
    $menu_active =11;
    $left_menu =4;
    $layout_title = "Welcome to Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-6">
            <h2 style="font-family: 'Khmer OS';"><i class="fa fa-fw fa-map-marker"></i> តារាងដឹកថ្មចេញពី រោងចក្រ ជូនភ្ញៀវ</h2>
        </div>
        <div class="col-xs-6 text-right">
            <h2>Delivery Note</h2>
        </div>
    </div>
    <br>
    <div class="">
        <div class="caption font-dark">
            <a href="add.php" id="sample_editable_1_new" class="btn green"> Add New
                <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info">
                <thead style="background-color: #CCFFFF;">
                    <tr role="row" class="text-center">
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">N&deg;</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">Date Record </th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">Code DV </th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">Code PO</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">Customer Name & Code</th>
                        <th colspan="2" style="vertical-align: middle; text-align: center;">Description of Goods<br> 
                            (Sự miêu tả)</th>
                        <th colspan="3" style="vertical-align: middle; text-align: center;">Dimension/Quy Cách (CM)</th>
                        <th colspan="2" style="vertical-align: middle; text-align: center;">Quantity (Số lượng)</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">Noted (Lưu ý)</th>
                        <th style="vertical-align: middle; text-align: center;" rowspan="2" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                    <tr role="row" class="text-center">
                        <th style="vertical-align: middle; text-align: center;">Name (Tên)</th>
                        <th style="vertical-align: middle; text-align: center;">Feature (Đặc tính)</th>
                        <th style="vertical-align: middle; text-align: center;">Length<br>(Chiều dài)</th>
                        <th style="vertical-align: middle; text-align: center;">Width<br>(Chiều rộng)</th>
                        <th style="vertical-align: middle; text-align: center;">Thickness<br>(Chiều cao)<br>(+-0.2)</th>
                        <th style="vertical-align: middle; text-align: center;">Pc/Slab</th>
                        <th style="vertical-align: middle; text-align: center;">M2</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                               A.*, B.*, C.*, D.*, TM.*, PO.*
                            FROM   tbl_prod_dv_list AS A  
                            LEFT JOIN tbl_prod_dv AS B ON B.dv_id = A.dvl_dv_id
                            LEFT JOIN tbl_cus_customer_info AS C ON C.cussi_id=B.dv_cus_id
                            LEFT JOIN tbl_prod_type_dv AS D ON D.tdv_id = B.dv_type_id
                            LEFT JOIN tbl_inv_type_make AS TM ON TM.tm_id = A.dvl_feature
                            LEFT JOIN tbl_prod_add_po AS PO ON PO.po_id = B.dv_po_id
                            ORDER BY dvl_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->dv_date.'</td>';
                                echo '<td>'.$row->dv_no.'</td>';
                                echo '<td>'.$row->po_no.'</td>';
                                echo '<td>'.$row->cussi_name.'<br><small>'.$row->cus_code.'</smail></td>';
                                echo '<td>'.$row->dvl_name.'</td>';
                                echo '<td>'.$row->tm_code.'</td>';
                                echo '<td>'.$row->dvl_length.'</td>';
                                echo '<td>'.$row->dvl_width.'</td>';
                                echo '<td>'.$row->dvl_thickness.'</td>';
                                echo '<td>'.$row->dvl_pcs_slab.'</td>';
                                echo '<th class="text-center">'.number_format($row->dvl_m2,2).'</th>';
                                echo '<td>'.$row->dvl_note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->dv_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                    echo '<a href="delete.php?del_id='.$row->dv_id.'" class="btn btn-xs btn-warning" title="delete"><i class="fa fa-trash"></i></a> ';
                                    echo '<a target="_blank" href="print.php?print_id=' . $row->dv_id . '" class="btn btn-xs btn-info" title="edit"><i class="fa fa-print"></i></a> ';
                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>






<?php include_once '../layout/footer.php' ?>
