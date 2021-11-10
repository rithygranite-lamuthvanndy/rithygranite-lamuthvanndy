<?php 
    $menu_active =111;
    $left_active =0;
    $layout_title = "Welcome to Setting Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Contact Company </h2>
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
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Date Record</th>
                        <th>Company Name</th>
                        <th>Category</th>
                        <th>Logo</th>
                        <th>Website</th>
                        <th>Phone Number(1)</th>
                        <th>Phone Number(2)</th>
                        <th>Email(1)</th>
                        <th>Email(2)</th>
                        <th>Address</th>
                        <th>Note</th>
                        <th>User_ID</th>
                        <th>Date_Audit</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                               *
                            FROM  tbl_ct_company AS A
                            LEFT JOIN tbl_ct_category AS B ON A.ctcom_category=B.ctcat_id
                            ORDER BY ctcom_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->ctcom_date_record.'</td>';
                                echo '<td>'.$row->ctcom_company_name.'</td>';
                                echo '<td>'.$row->ctcat_name.'</td>';
                                echo '<td class="text-center">
                                    <a href="upload_img.php?cl_id='.$row->ctcom_id.'&old_img='.$row->ctcom_logo.'">
                                    <i class="fa fa-pencil"></i>
                                    </a>
                                    <img src="../../img/img_company_list/'.$row->ctcom_logo.'" width="60px"></td>';
                                echo '<td>'.$row->ctcom_website.'</td>';
                                echo '<td>'.$row->ctcom_phone1.'</td>';
                                echo '<td>'.$row->ctcom_phone2.'</td>';
                                echo '<td>'.$row->ctcom_email1.'</td>';
                                echo '<td>'.$row->ctcom_email2.'</td>';
                                echo '<td>'.$row->ctcom_address.'</td>';
                                echo '<td>'.$row->ctcom_note.'</td>';
                                echo '<td>'.$row->user_id.'</td>';
                                echo '<td>'.$row->date_audit.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->ctcom_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   //echo '<a href="delete.php?del_id='.$row->ctcom_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

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
