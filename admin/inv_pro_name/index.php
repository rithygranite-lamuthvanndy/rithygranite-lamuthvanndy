<?php 
    $menu_active =145;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
if(isset($_POST['btnSearch'])){
    $v_date_start=@$_POST['txt_date_start'];
    $v_date_end=@$_POST['txt_date_end'];
    $get_data = $connect->query("SELECT 
           *,CAT.name AS inv_ca_name,B.name AS pro_type_name
        FROM   tbl_inv_product_name AS A
        LEFT JOIN tbl_st_unit AS U ON A.inv_pron_unit=U.stun_id
        LEFT JOIN tbl_inv_category AS CAT ON A.inv_pron_category=CAT.id
        LEFT JOIN  tbl_inv_pro_type AS B ON A.inv_pron_pro_type=B.id
        WHERE inv_pron_date_record BETWEEN '$v_date_start' AND '$v_date_end'
        ORDER BY inv_pron_id DESC");
}
else{
    $get_data = $connect->query("SELECT 
           *,CAT.name AS inv_ca_name,B.name AS pro_type_name
        FROM   tbl_inv_product_name AS A
        LEFT JOIN tbl_st_unit AS U ON A.inv_pron_unit=U.stun_id
        LEFT JOIN tbl_inv_category AS CAT ON A.inv_pron_category=CAT.id
        LEFT JOIN  tbl_inv_pro_type AS B ON A.inv_pron_pro_type=B.id
        ORDER BY inv_pron_id DESC");
}

 ?>
<?php 
if(@$_GET['status']=='update')
    echo '<script>myAlertSuccess("Updating ");</script>';
 ?>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i>Inventory Name</h2>
        </div>
    </div>
    <br>
    <div class="">
        <div class="caption font-dark">
            <a href="add.php" id="sample_editable_1_new" class="btn green"> Add New
                <i class="fa fa-plus"></i>
            </a>
        </div>
        <br>
        <form action="" method="POST" class="form-inline" role="form">
            <div class="row">
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                        <input autocomplete="off" name="txt_date_start" value="<?= @$_POST['txt_date_start'] ?>" type="text" class="form-control" placeholder="Date From ...." >
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                        <input autocomplete="off" name="txt_date_end" value="<?= @$_POST['txt_date_end'] ?>" type="text" class="form-control" placeholder="Date To ....">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <button type="submit" name="btnSearch" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
            </div>
        
        </form>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Date Record</th>
                        <th>Product Code</th>
                        <th>Product EN</th>
                        <th>Product KH</th>
                        <th>Unit</th>
                        <th>Inventory Type</th>
                        <th>Category</th>
                        <th>Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->inv_pron_date_record.'</td>';
                                echo '<td>'.$row->inv_pron_code.'</td>';
                                echo '<td>'.$row->inv_pron_name_en.'</td>';
                                echo '<td>'.$row->inv_pron_name_kh.'</td>';
                                echo '<td>'.$row->stun_name.'</td>';
                                echo '<td>'.$row->pro_type_name.'</td>';
                                echo '<td>'.$row->inv_ca_name.'</td>';
                                echo '<td>'.$row->inv_pron_note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->inv_pron_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                    
                                   echo '<a href="delete.php?del_id='.$row->inv_pron_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

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
