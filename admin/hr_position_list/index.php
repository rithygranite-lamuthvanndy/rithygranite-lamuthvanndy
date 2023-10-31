<?php 
    $menu_active =33;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Position List</h2>
        </div>
    </div>
    <br>
    <div class="">
        <div class="caption font-dark">
            <a class="btn green"  data-toggle="modal" href='#addposition'> Add New
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
                        <th>N&deg;</th>
                        <th>Position Name</th>
                        <th>Position Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                               *
                            FROM tbl_hr_position_list ORDER BY po_name DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->po_name.'</td>';
                                echo '<td>'.$row->po_note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->po_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                    echo '<a class="btn btn-primary btn-xs" data-toggle="modal" href="#editposition" onclick="view_iframe_upload_image('.$row->po_id.')"><i class="fa fa-upload"></i></a>';
                                    echo '<a href="#more_info" class="btn btn-info btn-xs" onclick="load_iframe(this)" data_id="'.$row->po_id.'" data_status="'.$row->po_id.'" role="button" data-toggle="modal">Edit</a>';
                                    echo '<a href="delete.php?del_id='.$row->po_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

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

<script type="text/javascript">
    function view_iframe_upload_image(e){
        document.getElementById('result_modal').src = 'edit_position.php?po_id='+e;
    }
    $(document).ready(function() {
        $('#modal').on('hidden.bs.modal', function () {
            location.reload();
        });
    });
    function load_iframe(obj){
       let v_id=$(obj).attr('data_id');
       // let v_status=$(obj).attr('data_status');
        $('#my_frame').attr("src","edit_position.php?v_id="+v_id);
    }
</script>
<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <iframe id="result_modal" frameborder="0" style="height: 500px; width: 100%;" align="top" scrolling="0"></iframe>

    </div>
</div>
<div class="modal fade" id="more_info">
    <div class="modal-dialog modal-lg" style="width: 30%; border: 1px solid darkred;">
        <iframe id="my_frame" frameborder="0" style="height: 500px; max-width: 100%; width: 100%;" align="center" scrolling="0"></iframe>
    </div>
</div>

<div class="modal fade" id="addposition">
    <div class="modal-dialog" style="width: 30%;">
        <iframe src="add_position.php" frameborder="0" style="height: 500px; max-width: 100%; width: 100%;" align="center" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="editposition">
    <div class="modal-dialog" style="width: 30%;">
        <iframe src="edit_position.php?edit_id='.$row->po_id.'" frameborder="0" style="height: 500px; max-width: 100%; width: 100%;" align="center" scrolling="0"></iframe>
    </div>
</div>