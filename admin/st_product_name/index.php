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
</style>
<?php 
if(@$_GET['status']=='update')
    echo '<script>myAlertSuccess("Updating ");</script>';
 ?>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> សម្ភារៈផ្គត់ផ្គង់ការផលិត</h2>
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
            <table class="table table-striped table-bordered table-hover dataTable collapsed" id="sample_1" role="grid" aria-describedby="sample_2_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Image</th>
                        <th>Product Bar Code</th>
                        <th>Product Code</th>
                        <th>Product KH</th>
                        <th>Product VN</th>
                        <th class="select-filter">Product Type Name</th>
                        <th class="select-filter">Unit</th>
                        <th class="select-filter">Category</th>
                        <th  class="select-filter">Material Type</th>
                        <th>Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                               A.*,B.name AS pro_type_name,D.sttyp_name,U.stun_name,CAT.stca_name
                            FROM   tbl_st_product_name AS A
                            LEFT JOIN tbl_st_unit_list AS U ON A.stpron_unit=U.stun_id
                            LEFT JOIN tbl_st_category_list AS CAT ON A.stpron_category=CAT.stca_id
                            LEFT JOIN tbl_st_product_type_list AS B ON A.stpron_pro_type=B.id
                            LEFT JOIN tbl_st_material_type_list AS D ON A.stpron_material_type=D.sttyp_id
                            ORDER BY stpron_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>';
                                    if($row->stpron_photo!= ""){
                                        echo '<img width="50px;" src="../../img/img_stock/product_name/'.$row->stpron_photo.'" alt="Blank">';   
                                    }else{
                                        echo '<img width="50px;" src="../../img/img_stock/product_name/product.jpg">';
                                    }
                                    
                                    echo '&nbsp;&nbsp;';
                                    echo '<a class="btn btn-primary btn-xs" data-toggle="modal" href="#modal" onclick="view_iframe_upload_image('.$row->stpron_id.')"><i class="fa fa-upload"></i></a>';
                                echo '</td>';
            
                                echo '<td><a href="#more_info" class="btn btn-info btn-xs" onclick="load_iframe(this)" data_id="'.$row->stpron_id.'" data_status="'.$row->stpron_id.'" role="button" data-toggle="modal">'.$row->stpron_barcode.'</a></td>';   
                                echo '<td><a href="#more_info" class="btn btn-info btn-xs" onclick="load_iframe(this)" data_id="'.$row->stpron_id.'" data_status="'.$row->stpron_id.'" role="button" data-toggle="modal">'.$row->stpron_code.'</a></td>';   
                                echo '<td>'.$row->stpron_name_kh.'</td>';
                                echo '<td>'.$row->stpron_name_vn.'</td>';
                                echo '<td>'.$row->pro_type_name.'</td>';
                                echo '<td>'.$row->stun_name.'</td>';
                                echo '<td>'.$row->stca_name.'</td>';
                                echo '<td>'.$row->sttyp_name.'</td>';
                                echo '<td>'.$row->stpron_note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->stpron_id.'&view='.@$_GET['view'].'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                    echo '<a onclick="deleteRecord('.$row->stpron_id.')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';
                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <th></th>
                        <th></th>
                        <th></th>
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
        document.getElementById('result_modal').src = 'upload.php?p_product_id='+e;
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