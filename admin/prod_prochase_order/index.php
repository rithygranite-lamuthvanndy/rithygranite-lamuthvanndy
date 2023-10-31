<?php 
    
    $left_menu_active = 2;
    $menu_active =11;
    $left_menu =2;
    $layout_title = "Welcome to Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-4">
            <h2 style="font-family:'Khmer OS';"><i class="fa fa-fw fa-map-marker"></i> តារាងកម្មង់ពី ការិយាល័យ មករោងចក្រ</h2>
        </div>
        <div class="col-xs-8 text-right">
            <h2>PURCHASE ORDER</h2><p style="font-family:'Times New Roman';">THÔNG BÁO SẢN XUẤT THEO ĐƠN HÀNG</p>
        </div>
    </div>
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
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">Code PO </th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">Customer Code</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">Customer Name</th>
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
                               *, (select count(pol_id) from tbl_prod_add_po_list where pol_po_id=po_id) as countid, (select dv_id from tbl_prod_dv where dv_po_id=po_id) as dv_po_lo,(select dv_no from tbl_prod_dv where dv_po_id=po_id) as dv_po_no
                            FROM   tbl_prod_add_po_list AS A  
                            LEFT JOIN tbl_prod_add_po AS B ON B.po_id = A.pol_po_id
                            LEFT JOIN tbl_cus_customer_info AS C ON C.cussi_id=B.po_customer
                            LEFT JOIN tbl_inv_type_make AS D ON D.tm_id = A.pol_feature
                            LEFT JOIN tbl_prod_add_quote AS QT ON QT.qt_id = B.po_quota_code
                            ORDER BY pol_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->po_date.'</td>';
                                echo '<td>'.$row->po_no.'</td>';
                                if($row->dv_po_lo>0){
                                echo '<td>'.$row->cus_code.'<br> <a target="_blank" href="print_dv.php?print_id=' . $row->po_id . '" class="btn btn-info btn-xs"><i class="fa fa-truck"> ' . $row->dv_po_no . '</i></a></td>';    
                                }else{
                                    echo '<td>'.$row->cus_code.'</td>';
                                }
                                
                                echo '<td>'.$row->cussi_name.'<br><small>'.$row->qt_no.'</small></td>';
                                echo '<td>'.$row->pol_name.'</td>';
                                echo '<td>'.$row->tm_code.'<br><small>'.$row->tm_name_kh.'</small></td>';
                                echo '<td>'.$row->pol_length.'</td>';
                                echo '<td>'.$row->pol_width.'</td>';
                                echo '<td>'.$row->pol_thickness.'</td>';
                                echo '<td>'.$row->pol_pcs_slab.'</td>';
                                echo '<th class="text-center">'.number_format($row->pol_m2,2).'</th>';
                                echo '<td>'.$row->pol_note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->po_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                    echo '<a href="delete.php?del_id='.$row->pol_id.'" class="btn btn-xs btn-warning" title="delete"><i class="fa fa-trash"></i></a> ';
                                    echo '<a target="_blank" href="print.php?print_id=' . $row->po_id . '" class="btn btn-xs btn-info" title="edit"><i class="fa fa-print"></i></a> ';
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

