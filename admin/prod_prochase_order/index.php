<?php 
    $layout_title = "Welcome";
    $menu_active =11;
    $left_menu =4;
    $layout_title = "Welcome to Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2 style="font-family:'Khmer OS';"><i class="fa fa-fw fa-map-marker"></i> តារាងារតម្លៃថ្មសម្រាប់អតិថិជន</h2>
            <h2>PURCHASE ORDER - THÔNG BÁO SẢN XUẤT THEO ĐƠN HÀNG</h2>
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
                <thead>
                    <tr role="row" class="text-center">
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">N&deg;</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">Date Record </th>
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
                               *
                            FROM   tbl_pj_project_initiation AS A  
                            LEFT JOIN tbl_pj_leader AS B ON B.dlead_id = A.pini_leader
                            LEFT JOIN tbl_pj_project_title AS C ON C.pti_id=A.pini_project_title
                            ORDER BY pini_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->pini_date_record.'</td>';
                                echo '<td>'.$row->pti_project_title.'</td>';
                                echo '<td>'.$row->pini_project_sub.'</td>';
                                echo '<td>'.$row->pini_description.'</td>';
                                echo '<td>'.$row->dlead_name.'</td>';
                                echo '<th class="text-center">'.number_format($row->pini_amount,2).'</th>';
                                echo '<td>'.$row->pini_note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->pini_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
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
