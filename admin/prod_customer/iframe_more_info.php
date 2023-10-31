<?php 
    $menu_active =33;
    $layout_title = "Welcome";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
?>


<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
<!-- END GLOBAL MANDATORY STYLES -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="../../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN THEME GLOBAL STYLES -->
<link href="../../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="../../assets/global/css/components-rounded.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="../../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
<!-- END THEME GLOBAL STYLES -->

<!-- BEGIN THEME LAYOUT STYLES -->
<link href="../../assets/layouts/layout4/css/layout.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/layouts/layout4/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
<link href="../../assets/layouts/layout4/css/custom.min.css" rel="stylesheet" type="text/css" />
<!-- END THEME LAYOUT STYLES -->
<?php
    if(@$_GET['v_id']){
        $v_id=@$_GET['v_id'];
        $get_data=$connect->query("SELECT 
                               A.*,A.date_audit AS audit, B.*
                            FROM tbl_cus_customer_info AS A 
                            LEFT JOIN tbl_cus_type AS B ON B.cusct_id=A.cussi_type 
            WHERE A.cussi_id='$v_id'");
        $row = mysqli_fetch_object($get_data);
    }
?>
<div class="portlet light bordered">
    <br>
    <div class="row">
        <div class="panel-heading text-center text-primary">

            <h2><b>Customer Information</b></h2>
            <h4><b><?= $row->cussi_name ?></b></h4>
        </div>

        <div class="portlet-body">
            <div class="col-xs-12">
                <div class="col-xs-6 text-center">
                    <h3><b>CUS_ID: <?= $row->cus_code ?></b></h3>  
                    <img width="300px;" src="../../img/img_empl/<?php if($row->cussi_photos<>""){ echo $row->cussi_photos; }else{ echo 'blank.png';} ?>" class="img-responsive img-responsive img-thumbnail" alt="Blank">
                    
                </div>
                <div class="col-xs-6">
                    <div class="col-sm-12">
                        <p><h1><b><?= $row->cussi_name ?></b></h1><?= $row->cusct_name ?></p><br>
                        <i class="fa fa-phone"></i> <?= $row->cussi_phone ?><br>
                        <i class="fa fa-envelope"></i> <?= $row->cussi_email ?>
                        <p>
                          - Address៖ <?= $row->cussi_address ?>, 
                        </p>
                          - Info: <h1><?= $row->cussi_note ?></h1>
                        <p>
                            <button type="button" class="btn bg-maroon btn-flat margin"><i class="fa fa-edit"></i> Edit Info</button>
                            <button type="button" class="btn bg-purple btn-flat margin"><i class="fa fa-upload"></i> Upload Profile Image</button>
                            <button type="button" class="btn bg-navy btn-flat margin"><i class="fa fa-eraser"></i> Delete Profile Image</button>
                            <button type="button" class="btn bg-orange btn-flat margin"><i class="fa fa-500px"></i> Change Password</button>
                        </p>
                     
                    </div>
                </div>
            </div>

            <!-- /.col -->
            <div class="col-xs-12">
                      <hr>
                      <br>
                      <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                          <li class="active"><a href="#activity" data-toggle="tab">Prochase Order</a></li>
                          <li><a href="#timeline" data-toggle="tab">Invoice</a></li>
                          <li><a href="#settings" data-toggle="tab">Delivery Note</a></li>
                          <li><a href="#settings1" data-toggle="tab">Quotatuons</a></li>
                        </ul>
                        <div class="tab-content">
                          <div class="active tab-pane" id="activity">
                      <br>
                      <br>
                            <!-- /.post -->
                            <div class="col-sm-12">
                      <br>
                      <br>
                              <div class="portlet-body">
                                  <div id="sample_1_wrapper" class="dataTables_wrapper">

<table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info">
                <thead style="background-color: #CCFFFF;">
                    <tr role="row" class="text-center">
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">N&deg;</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">Date Record </th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">PO No </th>
                        <th colspan="2" style="vertical-align: middle; text-align: center;">Description of Goods<br> 
                            (Sự miêu tả)</th>
                        <th colspan="3" style="vertical-align: middle; text-align: center;">Dimension/Quy Cách (CM)</th>
                        <th colspan="2" style="vertical-align: middle; text-align: center;">Quantity (Số lượng)</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">Noted (Lưu ý)</th>
                    </tr>
                    <tr role="row" class="text-center">
                        <th style="vertical-align: middle; text-align: center;">Name (Tên)</th>
                        <th style="vertical-align: middle; text-align: center;">Feature (Đặc tính)</th>
                        <th style="vertical-align: middle; text-align: center;">Length<br>(Chiều dài)</th>
                        <th style="vertical-align: middle; text-align: center;">Width<br>(Chiều rộng)</th>
                        <th style="vertical-align: middle; text-align: center;">Thickness<br>(Chiều cao)<br>(+-0.2)</th>
                        <th style="vertical-align: middle; text-align: center;">Pc/Slab</th>
                        <th style="vertical-align: middle; text-align: center;">M2</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $total_slab=0;
                        $total_m2=0;
                        $get_data = $connect->query("SELECT 
                               *, (select count(pol_id) from tbl_prod_add_po_list where pol_po_id=po_id) as countid
                            FROM   tbl_prod_add_po_list AS A  
                            LEFT JOIN tbl_prod_add_po AS B ON B.po_id = A.pol_po_id
                            LEFT JOIN tbl_inv_type_make AS D ON D.tm_id = A.pol_feature
                            WHERE B.po_customer= '$row->cussi_id'
                            ORDER BY po_date DESC");
                        while ($row1 = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row1->po_date.'</td>';
                                echo '<td>'.$row1->po_no.'</td>';
                                echo '<td>'.$row1->pol_name.'</td>';
                                echo '<td>'.$row1->tm_code.'</td>';
                                echo '<td>'.$row1->pol_length.'</td>';
                                echo '<td>'.$row1->pol_width.'</td>';
                                echo '<td>'.$row1->pol_thickness.'</td>';
                                echo '<td>'.$row1->pol_pcs_slab.'</td>';
                                echo '<th class="text-center">'.number_format($row1->pol_m2,2).'</th>';
                                echo '<td>'.$row1->pol_note.'</td>';
                            echo '</tr>';
                            $total_slab+=$row1->pol_pcs_slab;
                            $total_m2+=$row1->pol_m2;
                        }
                    ?>
                </tbody>
                        <tfoot>
                            <tr>
                               
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th colspan="2" class="text-right">សរុប <br>TOTAL M <sup>2</sup></th>
                                <th style="vertical-align: middle; text-align: center; font-size: 14px;"><?= $total_slab ?></th>
                                <th style="vertical-align: middle; text-align: center; font-size: 14px;"><?= number_format($total_m2,2) ?></th>
                                <th style="visibility: hidden;"></th>
                                
                            </tr>
                        </tfoot>

            </table>


                                  </div>
                              </div>

                            </div>
                          </div>
                          <!-- /.tab-pane -->
                          <div class="tab-pane" id="timeline">
                            <!-- The timeline -->
                            <ul class="timeline timeline-inverse">
                              <!-- timeline time label -->
                              <li class="time-label">
                                    <span class="bg-red">
                                        <?php
                                            $timezone = new DateTimeZone("Asia/Kolkata");
                                            $date = new DateTime();
                                            $date->setTimezone($timezone);
                                            $today = $date->format('d-M-Y');
                                            echo '<i>'.$today.'</i>';
                                        ?>
                                    </span>
                              </li>
                              <!-- /.timeline-label -->
                              <!-- timeline item -->
                              <li>
                                <i class="fa fa-envelope bg-blue"></i>

                                <div class="timeline-item">
                                  <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                                  <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                                  <div class="timeline-body">
                                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                    weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                    jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                    quora plaxo ideeli hulu weebly balihoo...
                                  </div>
                                  <div class="timeline-footer">
                                    <a class="btn btn-primary btn-xs">Read more</a>
                                    <a class="btn btn-danger btn-xs">Delete</a>
                                  </div>
                                </div>
                              </li>
                              <!-- END timeline item -->
                              <!-- timeline item -->
                              <li>
                                <i class="fa fa-user bg-aqua"></i>

                                <div class="timeline-item">
                                  <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

                                  <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request
                                  </h3>
                                </div>
                              </li>
                              <!-- END timeline item -->
                              <!-- timeline item -->
                              <li>
                                <i class="fa fa-comments bg-yellow"></i>

                                <div class="timeline-item">
                                  <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>

                                  <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                                  <div class="timeline-body">
                                    Take me to your leader!
                                    Switzerland is small and neutral!
                                    We are more like Germany, ambitious and misunderstood!
                                  </div>
                                  <div class="timeline-footer">
                                    <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                                  </div>
                                </div>
                              </li>
                              <!-- END timeline item -->
                              <!-- timeline time label -->
                              <li class="time-label">
                                    <span class="bg-green">
                                      3 Jan. 2014
                                    </span>
                              </li>
                              <!-- /.timeline-label -->
                              <!-- timeline item -->
                              <li>
                                <i class="fa fa-camera bg-purple"></i>

                                <div class="timeline-item">
                                  <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>

                                  <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                                  <div class="timeline-body">
                                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                                  </div>
                                </div>
                              </li>
                              <!-- END timeline item -->
                              <li>
                                <i class="fa fa-clock-o bg-gray"></i>
                              </li>
                            </ul>
                          </div>
                          <!-- /.tab-pane -->
                            <div class="tab-pane" id="settings">
                            </div>
                          <div class="tab-pane" id="settings1">
                            <form class="form-horizontal">
                              <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info">
                                    <thead style="background-color: #CCFFFF;">
                                        <tr role="row" class="text-center">
                                            <th rowspan="2" style="vertical-align: middle; text-align: center;">N&deg;</th>
                                            <th rowspan="2" style="vertical-align: middle; text-align: center;">Date Record </th>
                                            <th rowspan="2" style="vertical-align: middle; text-align: center;">Code Quote </th>
                                            <th colspan="2" style="vertical-align: middle; text-align: center;">Description of Goods<br> 
                                                (Sự miêu tả)</th>
                                            <th colspan="3" style="vertical-align: middle; text-align: center;">Dimension/Quy Cách (CM)</th>
                                            <th colspan="2" style="vertical-align: middle; text-align: center;">Quantity (Số lượng)</th>
                                            <th rowspan="2" style="vertical-align: middle; text-align: center;">Noted (Lưu ý)</th>
                                            
                                        </tr>
                                        <tr role="row" class="text-center">
                                            <th style="vertical-align: middle; text-align: center;">Name (Tên)</th>
                                            <th style="vertical-align: middle; text-align: center;">Feature (Đặc tính)</th>
                                            <th style="vertical-align: middle; text-align: center;">Length<br>(Chiều dài)</th>
                                            <th style="vertical-align: middle; text-align: center;">Width<br>(Chiều rộng)</th>
                                            <th style="vertical-align: middle; text-align: center;">Thickness<br>(Chiều cao)<br>(+-0.2)</th>
                                            <th style="vertical-align: middle; text-align: center;">Pc M2</th>
                                            <th style="vertical-align: middle; text-align: center;">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $i = 0;
                                            $get_data = $connect->query("SELECT 
                                                   *
                                                FROM   tbl_prod_add_quote_list AS A  
                                                LEFT JOIN tbl_prod_add_quote AS B ON B.qt_id = A.qtl_qt_id
                                                LEFT JOIN tbl_cus_customer_info AS C ON C.cussi_id=B.qt_customer
                                                LEFT JOIN tbl_inv_type_make AS D ON D.tm_id = A.qtl_feature
                                                WHERE B.qt_customer = '$row->cussi_id'
                                                ORDER BY qtl_id DESC");
                                            while ($row = mysqli_fetch_object($get_data)) {
                                                echo '<tr>';
                                                    echo '<td>'.(++$i).'</td>';
                                                    echo '<td>'.$row->qt_date.'</td>';
                                                    echo '<td>'.$row->qt_no.'</td>';
                                                    echo '<td>'.$row->qtl_name.'</td>';
                                                    echo '<td>'.$row->tm_code.'</td>';
                                                    echo '<td>'.$row->qtl_length.'</td>';
                                                    echo '<td>'.$row->qtl_width.'</td>';
                                                    echo '<td>'.$row->qtl_thickness.'</td>';
                                                    echo '<td>'.$row->qtl_pcs_m2.'</td>';
                                                    echo '<th class="text-center">'.number_format($row->qtl_price,2).'</th>';
                                                    echo '<td>'.$row->qtl_note.'</td>';
                                                    
                                                echo '</tr>';
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </form>
                          </div>
                          <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                      </div>
                      <!-- /.nav-tabs-custom -->
                    </div>
                    <!-- /.col -->

        </div>
    </div>    
</div>


<!-- BEGIN CORE PLUGINS -->
<script src="../../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="../../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="../../assets/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../assets/pages/scripts/table-datatables-buttons.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="../../assets/layouts/layout4/scripts/layout.min.js" type="text/javascript"></script>
<script src="../../assets/layouts/layout4/scripts/demo.min.js" type="text/javascript"></script>
<!-- <script src="../../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script> -->
<!-- <script src="../../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script> -->
<!-- END THEME LAYOUT SCRIPTS -->

