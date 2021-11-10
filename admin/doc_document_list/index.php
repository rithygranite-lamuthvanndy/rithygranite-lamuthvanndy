<?php 
    $menu_active =55;
    $left_active =64;
    $layout_title = "Welcome...";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once 'permission.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Document List</h2>
        </div>
    </div>
    <?= button_add(); ?>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Date</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Attach File</th>
                        <th>Category</th>
                        <th>Creator</th>
                        <th>Department</th>
                        <th>Note</th>
                        <th>Date_Audit</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                               *
                            FROM  tbl_doc_document AS D 
                            LEFT JOIN  tbl_doc_category AS C ON D.docdoc_category=C.doccat_id
                            LEFT JOIN  tbl_doc_creator AS CR ON D.docdoc_creator=CR.doccre_id
                            LEFT JOIN  tbl_doc_department AS DP ON D.docdoc_department=DP.docdep_id
                            ORDER BY docdoc_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->docdoc_date.'</td>';
                                echo '<td>'.$row->docdoc_title.'</td>';
                                echo '<td>'.$row->docdoc_desciption.'</td>';
                                echo '<td class="text-center">';                                    echo '<a href="list_attach.php?sent_id='.$row->docdoc_id.'" class="btn btn-xs btn-info"><i class="fa fa-file"></i></a> ';
                                echo '</td>';
                                echo '</td>';
                                echo '<td>'.$row->doccat_name.'</td>';
                                echo '<td>'.$row->doccre_name.'</td>';
                                echo '<td>'.$row->docdep_name.'</td>';
                                echo '<td>'.$row->docdoc_note.'</td>';
                                echo '<td>'.$row->date_audit.'</td>';
                                echo '<td class="text-center">';
                                echo button_edit($row->docdoc_id);
                                echo button_delete($row->docdoc_id);
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
