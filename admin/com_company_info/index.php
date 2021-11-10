<?php 
    $menu_active =10;
    $left_menu =4;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once 'permission.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Company Info</h2>
        </div>
    </div>
    <br>
    <div class="">
        
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Name KH</th>
                        <th>Name EN</th>
                        <th>Name CH</th>
                        <th>Logo</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Website</th>
                        <th>Facebook</th>
                        <th>Note</th>
                        <th>User</th>
                        <th>Date Audit</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                               *
                            FROM   tbl_com_company_info AS A  
                            ORDER BY comci_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->comci_name_kh.'</td>';
                                echo '<td>'.$row->comci_name_en.'</td>';
                                echo '<td>'.$row->comci_name_ch.'</td>';
                                echo '<td class="text-center">
                                    <img src="../../img/img_logo/'.$row->comci_logo.'" width="100px">
                                    <a href="upload_img.php?sent_id='.$row->comci_id.'&old_img='.$row->comci_logo.'">
                                    <i class="fa fa-pencil"></i>
                                    </a>
                                    </td>';
                                echo '<td>'.$row->comci_addr.'</td>';
                                echo '<td>'.$row->comci_phone.'</td>';
                                echo '<td>'.$row->comci_email.'</td>';
                                echo '<td>'.$row->comci_website.'</td>';
                                echo '<td>'.$row->comci_facebook.'</td>';
                                echo '<td>'.$row->comci_note.'</td>';
                                echo '<td>'.$row->user_id.'</td>';
                                echo '<td>'.$row->date_audit.'</td>';
                                echo '<td class="text-center">';
                                    echo button_edit($row->comci_id);
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>






<?php include_once '../layout/footer.php' ?>
