<?php 
    $menu_active =101;
    $left_menu=12;
    $layout_title = "Welcome...";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once 'permission.php';
    include_once '../layout/header.php';
    if(@$_GET['del_id'] != ""){
        $del_id = @$_GET['del_id'];
        $connect->query("DELETE FROM tbl_meeting_document WHERE doc_id='$del_id'");

        $old_file = @$_GET['old_file'];
        if(file_exists('../../file/file_meeting_document/'.$old_file)){
            unlink('../../file/file_meeting_document/'.$old_file);
        }
    }

?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Add Document List</h2>
        </div>
    </div>
    <br>
    <div class="">
        <div class="caption font-dark">
           <?= button_add(); ?>
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
                        <th>Plan N&deg;</th>
                        <th>Title</th>
                        <th>Note</th>
                        <th>User ID</th>
                        <th>Date Audit</th>
                        <th>Download</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                               *,A.user_id AS u_id,A.date_audit AS date
                            FROM  tbl_meeting_document AS A 
                            LEFT JOIN  tbl_meeting_plan AS B ON A.plan_id=B.meetp_id
                            ORDER BY doc_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->doc_date_record.'</td>';
                                echo '<td>'.$row->meetp_meting_no.'</td>';
                                echo '<td>'.$row->title.'</td>';
                                echo '<td>'.$row->note.'</td>';
                                echo '<td>'.$row->u_id.'</td>';
                                echo '<td>'.$row->date.'</td>';
                                echo '<td><a href="../../file/file_meeting_document/'.$row->file_title  .'">DOWNLOAD <i class="fa fa-download"></i></a></td>';
                                echo '<td class="text-center">';
                                    echo button_edit($row->doc_id);
                                    echo button_delete($row->doc_id,$row->file_title);
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
