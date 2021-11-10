<?php 
    $menu_active =0;
    $left_active =0;
    $layout_title = "Welcome to Setting Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i>Alert Contact List</h2>
        </div>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th style="color:red" >Date Alert</th>
                        <th>Alert Detail</th>
                        <th>Date Record</th>
                        <th>Company</th>
                        <th>Full Name</th>
                        <th>Sex</th>
                        <th>Position</th>
                        <th>Photo</th>
                        <th>Tel (1)</th>
                        <th>Tel (2)</th>
                        <th>Email (1)</th>
                        <th>Email (2)</th>
                        <th>Address</th>
                        <th>Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $v_current_date = date('Y-m-d');
                        $get_data = $connect->query("SELECT 
                               *
                            FROM  tbl_ct_contact_list AS A
                            RIGHT JOIN tbl_ct_contact_alert AS CA ON CA.ctca_contact=A.ctco_id
                            LEFT JOIN tbl_ct_company AS B ON A.ctco_company=B.ctcom_id
                            LEFT JOIN tbl_ct_position AS C ON A.ctco_position=C.ctpo_id
                            LEFT JOIN tbl_ct_sex AS D ON A.ctco_sex=D.ctsex_id
                            WHERE ctca_date_alert = '$v_current_date'
                            GROUP BY ctca_id
                            ORDER BY ctco_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td style="color:red">'.$row->ctca_date_alert.'</td>';
                                echo '<td>'.$row->ctca_note.'</td>';
                                echo '<td>'.$row->ctco_date_record.'</td>';
                                echo '<td>'.$row->ctcom_company_name.'</td>';
                                echo '<td>'.$row->ctco_full_name.'</td>';
                                echo '<td>'.$row->ctsex_name.'</td>';
                                echo '<td>'.$row->ctpo_name.'</td>';
                                echo '<td class="text-center">
                                    <a href="upload_img.php?cl_id='.$row->ctco_id.'&old_img='.$row->ctco_photo.'">
                                    
                                    </a>
                                    <img src="../../img/img_contact_list/'.$row->ctco_photo.'" width="60px"></td>';
                                echo '<td>'.$row->ctco_tel1.'</td>';
                                echo '<td>'.$row->ctco_tel2.'</td>';
                                echo '<td>'.$row->ctco_email1.'</td>';
                                echo '<td>'.$row->ctco_email2.'</td>';
                                echo '<td>'.$row->ctco_address.'</td>';
                                echo '<td>'.$row->ctco_note.'</td>';
                                echo '<td class="text-center">';
                                    //echo '<a href="edit.php?edit_id='.$row->ctco_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   //echo '<a href="delete.php?del_id='.$row->ctco_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

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
