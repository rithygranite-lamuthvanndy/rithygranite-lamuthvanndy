<?php 
    $layout_title = "Welcome";
    $menu_active =11;
    $left_menu =4;
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    if(@($_GET['view']=='iframe')){
        include_once '../layout/header_frame.php';
    }
    else{
        include_once '../layout/header.php';
    }
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2 style="font-family: 'Khmer OS';"><i class="fa fa-fw fa-map-marker"></i> តារាងផលិតផលកែច្នៃ</h2>
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
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Code</th>
                        <th>Manufacturer's Part Num</th>
                        <th>Name kh</th>
                        <th>Name en</th>
                        <th>Name vn</th>
                        <th>Description</th>
                        <th>U/M</th>
                        <th>Unit Price</th>
                        <th>Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                               *
                            FROM tbl_items_type_list AS A 
                            ORDER BY tit_code ASC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->tit_code.'</td>';
                                echo '<td>'.$row->tit_name_kh.'</td>';
                                echo '<td>'.$row->tit_name_kh.'</td>';
                                echo '<td>'.$row->tit_name_en.'</td>';
                                echo '<td>'.$row->tit_name_vn.'</td>';
                                echo '<td>'.$row->tit_description.'</td>';
                                echo '<td>'.$row->tit_description.'</td>';
                                echo '<td>'.$row->tit_unit_price.'</td>';
                                echo '<td>'.$row->tit_note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->tit_id.'&view='.@$_GET['view'].'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   echo '<a onclick="deleteRecord('.$row->tit_id.')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

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
     if(@$_GET['view']=='iframe'){
        include_once '../layout/footer_frame.php';
    }
    else{
        include_once '../layout/footer.php';
    }
 ?>
<!-- <div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-body">
                <iframe id="result_modal" src="" width="100%" style="min-height: 600px; resize: vertical;" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function set_iframe_add(){
        document.getElementById('result_modal').src = 'add.php?view=iframe';
    }
</script> -->