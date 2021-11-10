<?php 
    $menu_active =13;
    $left_active =57;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once 'permission.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Approved Name List</h2>
        </div>
    </div>
    <?= button_add(); ?>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT * FROM   tbl_acc_approved_name_list ORDER BY apn_name ASC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>';
                                echo '<img width="50px;" src="../../img/sign_name/'.$row->img.'" alt="Blank">';
                                echo '&nbsp;&nbsp;';
                                echo '<a class="btn btn-primary btn-xs" data-toggle="modal" href="#modal" onclick="view_iframe_upload_image('.$row->apn_id.')"><i class="fa fa-upload"></i></a>';
                                echo '</td>';
                                echo '<td>'.$row->apn_name.'</td>';
                                echo '<td>'.$row->apn_note.'</td>';
                                echo '<td class="text-center">';
                                echo button_edit($row->apn_id);
                                echo button_delete($row->apn_id);
                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>






<?php 
    if(@$_GET['view']=='iframe')
        include_once '../layout/footer_frame.php';
    else
        include_once '../layout/footer.php';
 ?>
<script type="text/javascript">
    function view_iframe_upload_image(e){
        document.getElementById('result_modal').src = 'upload.php?edit_id='+e;
    }
    $(document).ready(function() {
        $('#modal').on('hidden.bs.modal', function () {
            location.reload();
        });
    });
</script>
<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <iframe id="result_modal" frameborder="0" style="height: 500px; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>

