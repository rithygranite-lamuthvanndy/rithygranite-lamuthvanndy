<?php 
    $layout_title = "Welcome Fixed Asset Management";
    $menu_active =141;
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';

?>




<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-4">
            <h2><b>Fixed Asset Management</b></h2>
        </div>
                    <div class="btn-group">
                      <button type="button" class="btn btn-default btn-flat" style="width: 100px;">Payments</button>
                      <button type="button" class="btn btn-default btn-flat" style="width: 100px;">Deposits</button>
                      <button type="button" class="btn btn-default btn-flat" style="width: 100px;">All</button>
                    </div>
                    
        <div class="col-xs-4 text-center">
            <b>
                <?php
                    $timezone = new DateTimeZone("Asia/Kolkata");
                    $date = new DateTime();
                    $date->setTimezone($timezone);
                    $today = $date->format('D, d-m-Y');
                    echo '<h2><b>'.$today.'</b></h2>';
                ?>
            </b>
        </div>
        <div class="col-xs-4">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <a href="../../admin/fam_nfa_1_ar/add.php?view=<?= @$_GET['view'] ?>" id="sample_editable_1_new" class="btn bg-purple btn-flat margin"> Non Fixed Asset  <i class="fa fa-hospital-o"></i></a>
                    <a href="../../admin/fam_nfa_2_as/index.php?view=<?= @$_GET['view'] ?>" id="sample_editable_1_new" class="btn bg-purple btn-flat margin"> Fixed Asset  <i class="fa fa-hospital-o"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <form action="process.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                    <label for="file">File Excel</label>
                    <input type="file" name="file" id="file" class="form-control" required="">
                    </div>
                    <div class="form-roup pull-right">
                        <input type="submit" name="submit" value="Upload Image" class="btn btn-success">
                    </div>
                </form>
                
            </div>
            <hr>
        </div>

   
        <!--<img src="../../img/img_system/Fixed-asset-accounting.jpg" alt="" class="img-thumbnail img-responsive" style="width: 100%;">-->
    <br>
    
     </div>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_2" role="grid" aria-describedby="sample_1_info">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>DATE</th>
                        <th>COLOR</th>
                        <th>MAP</th>
                        <th>LAYER</th>
                        <th>GRADE</th>
                        <th>CODE</th>
                        <th>LENGTH</th>
                        <th>WIDTH</th>
                        <th>HEIHGT</th>
                        <th>QTY</th>
                        <th>M3</th>
                        <th>IN MONTH</th>
                        <th>Date Out</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $v_cat_name_tmp = [];
                        $get_data = $connect->query("SELECT *
                            FROM tbl_block_onout 
                            ORDER BY bo_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                        echo '<tr>';
                        echo '<td>'.(++$i).'</td>';
                        echo '<td>'.$row->bo_date.'</td>';
                        echo '<td>'.$row->bo_color.'</td>';
                        echo '<td>'.$row->bo_maps.'</td>';
                        echo '<td>'.$row->bo_layer.'</td>';
                        echo '<td>'.$row->bo_grade.'</td>';
                        echo '<td>'.$row->bo_code.'</td>';
                        echo '<td>'.$row->bo_map.'</td>';
                        echo '<td>'.$row->bo_length.'</td>';
                        echo '<td>'.$row->bo_width.'</td>';
                        echo '<td>'.$row->bo_height.'</td>';
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td>'.$row->bo_date_out.'</td>';
                        echo '<td></td>';
                        echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>






<?php include_once '../layout/footer.php' ?>
