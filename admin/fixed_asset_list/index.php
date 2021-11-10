<?php 
    $menu_active =141;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    if(@$_GET['view']=='iframe')
        include_once '../layout/header_frame.php';
    else
        include_once '../layout/header.php';
?>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2 style="font-family: 'Constantia';"><i class="fa fa-fw fa-map-marker"></i> Detail Comparizon of physical fixed Asset Registered and Fixed Asset in Accounting Book</h2>
        </div>
    </div>
    <br>
    <div class="">
        <div class="caption font-dark">
            <a href="add.php?view=<?= @$_GET['view'] ?>" id="sample_editable_1_new" class="btn green"> Add New
                <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_1" role="grid" aria-describedby="sample_1_info">
                <thead>
                    <tr role="row" class="bg-red">
                        <th class="text-center">N&deg;</th>
                        <th class="text-center">Fixed Asset No</th>
                        <th class="text-center">Fixed Asset Name</th>
                        <th class="text-center">Despcription Fixed Asset</th>
                        <th class="text-center">Size Model</th>
                        <th class="text-center">Unit</th>
                        <th class="select-filter text-center">Narrative Remarks</th>
                        <th class="select-filter text-center">Responsible Staff</th>
                        <th class="select-filter text-center">Location</th>
                        <th class="text-center">Purchased Date</th>
                        <th class="text-center"> Physical FA  Cost</th>
                        <th class="text-center">Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $v_cat_name_tmp = [];
                        $get_data = $connect->query("SELECT A.*,(select dep_name from tbl_fix_depart where dep_id=A.dep_id) as name_dep_a,(select locat_name from tbl_fix_locat where locat_id=A.fix_asset_location) as name_locat_a
                            FROM tbl_fix_asset_list as A
                            ORDER BY name_dep_a ASC");

                        while ($row = mysqli_fetch_object($get_data)) {
                            // (!in_array($row->name_dep_a, $v_cat_name_tmp)) {
                            //    array_push($v_cat_name_tmp, $row->name_dep_a);
                            //echo '<tr class="bg-blue">';
                            //    echo '<td colspan="12">'.$row->name_dep_a.'</td>';
                            //echo '</tr>';}

                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td><a href="#more_info" class="btn btn-info btn-xs" onclick="load_iframe(this)" data_id="'.$row->fl_id.'" data_status="'.$row->fl_id.'" role="button" data-toggle="modal">'.$row->fixed_asset_no.'</a></td>';                               
                                echo '<td>'.$row->fix_asset_name.'</td>';
                                echo '<td>'.$row->name_dep_a.'</td>';
                                echo '<td>'.$row->size_model.'</td>';
                                echo '<td>'.$row->unit.'</td>';
                                echo '<td>$ '.number_format($row->narrative_remarks,2).'</td>';
                                echo '<td>'.$row->responsible_staff.'</td>';
                                echo '<td>'.$row->name_locat_a.'</td>';
                                echo '<td>'.$row->purchased_date.'</td>';
                                echo '<td style="text-align: right";>$ '.number_format($row->physical_fa_cost,2).'</td>';
                                echo '<td>'.$row->fl_note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->fl_id.'&view='.@$_GET['view'].'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   echo '<a onclick="deleteRecord('.$row->fl_id.')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';
                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr class="bg-yellow">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
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
        document.getElementById('result_modal').src = 'upload1.php?fl_id='+e;
    }
    $(document).ready(function() {
        $('#modal').on('hidden.bs.modal', function () {
            location.reload();
        });
    });
    function load_iframe(obj){
       let v_id=$(obj).attr('data_id');
       // let v_status=$(obj).attr('data_status');
        $('#my_frame').attr("src","iframe_more_info.php?v_id="+v_id);
    }
</script>
<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <iframe id="result_modal" frameborder="0" style="height: 500px; width: 100%;" align="top" scrolling="0"></iframe>

    </div>
</div>
<div class="modal fade" id="more_info">
    <div class="modal-dialog modal-lg" style="width: 80%; border: 1px solid darkred;">
        <iframe id="my_frame" frameborder="0" style="height: 700px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>