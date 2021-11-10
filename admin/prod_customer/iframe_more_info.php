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
                    <img width="300px;" src="../../img/img_empl/<?= $row->cussi_photos ?>" class="img-responsive img-responsive img-thumbnail" alt="Blank">
                    
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
                          <li><a href="#settings" data-toggle="tab">Quotatuons</a></li>
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
                                      <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_2" role="grid" aria-describedby="sample_1_info">
                                          <thead>
                                              <tr role="row">
                                                  <th class="text-center">N&deg;</th>
                                                  <th class="text-center">Date</th>
                                                  <th class="text-center">Num PO</th>
                                                  <th class="text-center">Feature</th>
                                                  <th class="text-center">Length (cm)</th>
                                                  <th class="text-center">Width (cm)</th>
                                                  <th class="text-center">Thickness (cm)</th>
                                                  <th class="text-center">Pc/Slab</th>
                                                  <th class="text-center">M2</th>
                                                  <th class="text-center">Note</th>
                                                  <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                            <?php
                                                      echo '<tr>';
                                                          echo '<td></td>';
                                                          echo '<td></td>';
                                                          echo '<td></td>';
                                                          echo '<td></td>';
                                                          echo '<td></td>';
                                                          echo '<td></td>';
                                                          echo '<td></td>';
                                                          echo '<td></td>';
                                                          echo '<td></td>';
                                                          echo '<td></td>';
                                                          echo '<td class="text-center">';
                                                              
                                                          echo '</td>';
                                                      echo '</tr>';
                                                  
                                              ?>
                                          </tbody>
                                          <tfoot>
                                              <tr>
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
                            <form class="form-horizontal">
                              <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Name</label>

                                <div class="col-sm-10">
                                  <input type="email" class="form-control" id="inputName" placeholder="Name">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                <div class="col-sm-10">
                                  <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Name</label>

                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="inputName" placeholder="Name">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="inputExperience" class="col-sm-2 control-label">Experience</label>

                                <div class="col-sm-10">
                                  <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="inputSkills" class="col-sm-2 control-label">Skills</label>

                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                  <div class="checkbox">
                                    <label>
                                      <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                    </label>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                  <button type="submit" class="btn btn-danger">Submit</button>
                                </div>
                              </div>
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

