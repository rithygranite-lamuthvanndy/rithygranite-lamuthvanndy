<?php 
    $menu_active =1;
    $layout_title = "Welcome";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header_frame.php'
?>
<?php
    if(@$_GET['parent']){
        $v_id=@$_GET['parent'];
        $sql="SELECT A.*,B.stpron_code,B.stpron_name_kh
                                            FROM tbl_st_product_set_detail AS A 
                                            LEFT JOIN tbl_st_product_name AS B ON A.pro_id=B.stpron_id
                                            WHERE stpset_detail_id='$v_id'";
        $result_detail=$connect->query($sql);
        
    }
?>
<div class="portlet light bordered">
    <div class="row">
        <div class="panel-heading text-center text-primary">
            <h2>More Information</h2>
        </div>
    </div>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_3" role="grid" aria-describedby="sample_1_info">
                <thead>
                    <th class="text-center">N&deg;</th>
                    <th class="text-center">Product Code</th>
                    <th class="text-center">Product Name</th>
                    <th class="text-center">QUANTITY</th>
                    <th class="text-center">Note</th>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        while ($row = mysqli_fetch_object($result_detail)) {      
                            echo '<tr>';
                                echo '<td class="text-center">'.(++$i).'</td>';
                                echo '<td class="text-left">'.$row->stpron_code.'</td>';
                                echo '<td class="text-left">'.$row->stpron_name_kh.'</td>';
                                echo '<td class="text-left">'.$row->qty.'</td>';
                                echo '<td class="text-left">'.$row->note.'</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php 
    include_once '../layout/footer_frame.php'
 ?>

