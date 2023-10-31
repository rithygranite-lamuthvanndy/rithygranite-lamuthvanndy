<?php 
    $menu_active =11;
    $left_menu =4;
    $layout_title = "Welcome to Setting Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    if(@$_GET['view']=='iframe')
        include_once '../layout/header_frame.php';
    else
        include_once '../layout/header.php';
    $v_user_id = @$_SESSION['user']->user_id;
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Customer Info</h2>
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
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_2" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead style="background-color: #CCFFFF;">
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Customer Code</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Note</th>
                        <th>Date Audit</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        if(@$_SESSION['user']->user_position==12||@$_SESSION['user']->user_position==13)
                            $flag=1;
                        else
                            $flag=0;
                        if($flag==1){
                            $get_data = $connect->query("SELECT 
                               *,A.date_audit AS audit
                            FROM tbl_cus_customer_info AS A 
                            LEFT JOIN tbl_cus_type AS B ON B.cusct_id=A.cussi_type 
                            WHERE (A.user_id='$v_user_id')
                            ORDER BY cus_code DESC");
                        }
                        else{
                            $get_data = $connect->query("SELECT 
                               *,A.date_audit AS audit
                            FROM tbl_cus_customer_info AS A 
                            LEFT JOIN tbl_cus_type AS B ON B.cusct_id=A.cussi_type 
                            ORDER BY cus_code DESC");
                        }
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td><a href="#more_info" class="btn btn-info btn-xs" onclick="load_iframe(this)" data_id="'.$row->cussi_id.'" data_status="'.$row->cussi_id.'" role="button" data-toggle="modal">'.$row->cus_code.'</a></td>';
                                echo '<td>'.$row->cussi_name.'</td>';
                                echo '<td>'.$row->cusct_name.'</td>';
                                echo '<td>'.$row->cussi_phone.'</td>';
                                echo '<td>'.$row->cussi_email.'</td>';
                                echo '<td>'.$row->cussi_address.'</td>';
                                echo '<td>'.$row->cussi_note.'</td>';
                                echo '<td>'.$row->audit.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->cussi_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                    echo '<a href="delete.php?del_id='.$row->cussi_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

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
        document.getElementById('result_modal').src = 'upload.php?empl_id='+e;
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
        <iframe id="my_frame" frameborder="0" style="height: 800px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>