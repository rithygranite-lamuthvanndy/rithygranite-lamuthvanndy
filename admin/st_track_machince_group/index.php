<?php 
    $menu_active =140;
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
            <h2><i class="fa fa-fw fa-map-marker"></i> Truck Club Name  List</h2>
        </div>
    </div>
    <br>
   
    
    <select onchange="window.location=this.value" class="btn"  style="width:40%;height: 33px;">
        <option              value="../st_track_machince_list">Truck & Machine List</option>
        <option selected=""  value="../st_track_machince_group">Truck Club Name</option>
        
    </select>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_2" role="grid" aria-describedby="sample_1_info">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Club Name</th>
                        <th>Machine Code</th>
                        <th>Date Buy</th>
                        <th>Machine Name KH</th>
                        <th>Machine Name NV</th>
                        <th>Machine Position</th>
                        <th>Machine Price</th>
                        <th>Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                               A.*,B.*,C.*,B.id as id_show
                            FROM tbl_group_truck AS A
                            INNER JOIN tbl_group_truck_items AS B
                            ON A.id=B.group_id
                            INNER JOIN tbl_st_track_machine_list AS C
                            ON B.truck_machin_id=C.id
                            ORDER BY A.order_number DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->name.'</td>';
                                echo '<td>'.$row->code.'</td>';
                                echo '<td>'.$row->date_buy.'</td>';
                                echo '<td>'.$row->name_vn.'</td>';
                                echo '<td>'.$row->name_kh.'</td>';
                                echo '<td>'.$row->track_position.'</td>';
                                echo '<td class="text-primary">$ '.$row->track_price.'</td>';
                                echo '<td>'.$row->note.'</td>';
                                echo '<td class="text-center">';
                                    
                                    echo '<a onclick="deleteRecord('.$row->id_show.')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

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

