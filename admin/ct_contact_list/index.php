<?php 
    $menu_active =111;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Contact List</h2>
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
                        <th>Company</th>
                        <th>Full Name</th>
                        <th>Sex</th>
                        <th>Position</th>
                        <th>Photo</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Social Network</th>
                        <th>Address</th>
                        <th>Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                               *,GROUP_CONCAT(ctp_number SEPARATOR '<hr>') AS s_phone_number
                            FROM  tbl_ct_contact_list AS A
                            LEFT JOIN tbl_ct_company AS B ON A.ctco_company=B.ctcom_id
                            LEFT JOIN tbl_ct_position AS C ON A.ctco_position=C.ctpo_id
                            LEFT JOIN tbl_ct_sex AS D ON A.ctco_sex=D.ctsex_id
                            LEFT JOIN tbl_ct_contact_phone AS P ON P.ctp_contact=A.ctco_id
                            GROUP BY A.ctco_id
                            ORDER BY ctco_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->ctco_date_record.'</td>';
                                echo '<td>'.$row->ctcom_company_name.'</td>';
                                echo '<td><a href="contact_card.php?ct_id='.$row->ctco_id.'" target="_blank">'.$row->ctco_full_name.'</a></td>';
                                echo '<td>'.$row->ctsex_name.'</td>';
                                echo '<td>'.$row->ctpo_name.'</td>';
                                echo '<td class="text-center">
                                    <img src="../../img/img_contact_list/'.$row->ctco_photo.'" width="60px">
                                    <a href="upload_img.php?cl_id='.$row->ctco_id.'&old_img='.$row->ctco_photo.'">
                                    <i class="fa fa-pencil"></i>
                                    </a>
                                    </td>';
                                echo '<td class="text-center">
                                    <a href="index_phone.php?sent_id='.$row->ctco_id.'">
                                    <i class="fa fa-pencil"></i><br>
                                    '.$row->ctp_number.'
                                    </a>
                                    </td>';
                                echo '<td class="text-center">
                                    <a href="index_email.php?sent_id='.$row->ctco_id.'">
                                    <i class="fa fa-pencil"></i>
                                    </a>
                                    </td>';
                                echo '<td class="text-center">
                                    <a href="index_social_network.php?sent_id='.$row->ctco_id.'">
                                    <i class="fa fa-pencil"></i>
                                    </a>
                                    </td>';
                                echo '<td>'.$row->ctco_address.'</td>';
                                echo '<td>'.$row->ctco_note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->ctco_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
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
