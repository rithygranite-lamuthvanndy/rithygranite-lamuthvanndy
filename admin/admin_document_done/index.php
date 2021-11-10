<?php 
    $menu_active =44;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Document Done</h2>
        </div>
    </div>
    <br>
   <!--  <div class="">
        <div class="caption font-dark">
            <a href="add.php" id="sample_editable_1_new" class="btn green"> Add New
                <i class="fa fa-plus"></i>
            </a>
        </div>
    </div> -->
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Date Record</th>
                        <th>Request Name</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Department</th>
                        <th>Employee Check</th>
                        <th>Done</th>
                        <th>Date Done</th>
                        <th>Sign By</th>
                        <th>Approved By</th>
                        <th>Attach File</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                               *
                           FROM   tbl_admin_document_request AS A  
                            LEFT JOIN tbl_admin_department_list AS B ON A.docr_department=B.dep_id
                            LEFT JOIN tbl_admin_check_name_list AS C ON A.docr_employee_check=C.cnl_id
                            LEFT JOIN tbl_admin_approved_name_list AS D ON A.docr_approved_by=D.anl_id
                            LEFT JOIN tbl_admin_sign_name_list AS E ON A.docr_sign_by=E.snl_id
                            LEFT JOIN tbl_admin_done_list AS F ON A.docr_done=F.do_id
                            ORDER BY docr_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->docr_date_record.'</td>';
                                echo '<td>'.$row->docr_request_name.'</td>';
                                echo '<td>'.$row->docr_title.'</td>';
                                echo '<td>'.$row->docr_description.'</td>';
                                echo '<td>'.$row->dep_name.'</td>';
                                echo '<td>'.$row->cnl_name.'</td>';
                                echo '<td>'.$row->do_name.'</td>';
                                 // $v_total_sum_qty_add =($row_sum['total_qty_add'])?($row_sum['total_qty_add']):("0") ;
                                $v_done_date=($row->docr_done_date!='0000-00-00')?($row->docr_done_date):(" ");
                                echo '<td>'.$v_done_date.'</td>';
                                echo '<td>'.$row->snl_name.'</td>';
                                echo '<td>'.$row->anl_name.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="upload.php?up_id='.$row->docr_id.'&old_file='.$row->docr_attach_file.'" " title="Upload file"><i class="fa fa-upload" style="color: blue;"></i></a> &nbsp;&nbsp;';

                                        if($row->docr_attach_file!= ""){
                                            echo '| &nbsp;&nbsp;<a href="../../file/file_document_done/'.$row->docr_attach_file.'" target="_blank" title="Download"><i class="fa fa-download" style="color: red;"></i></a>';
                                        
                                        }else{
                                            echo '| &nbsp;&nbsp;<a class="text-default"><i class="fa fa-download fa-fw" style="color: red;" title="No file to download"></i></a>';
                                        }
                                    echo '</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->docr_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   //echo '<a href="delete.php?del_id='.$row->docr_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

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
