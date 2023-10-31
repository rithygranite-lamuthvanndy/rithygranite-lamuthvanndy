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
        $get_data=$connect->query("SELECT A.*,B.*,C.*,
            (select sum(emup_salary_up) from tbl_hr_employee_salary_up where emup_emp_id=A.empl_id) as tt_salary_up
            FROM tbl_hr_employee_list AS A 
            LEFT JOIN tbl_hr_position_list AS B ON A.empl_position=B.po_id
            LEFT JOIN tbl_hr_department_sub AS C ON A.empl_department=C.dep_id
            left join tbl_hr_sex_list as D on A.empl_sex=D.sex_id
            left join tbl_hr_national_list as E on A.empl_national=E.national_id
            WHERE A.empl_id='$v_id'");
        $row = mysqli_fetch_object($get_data);
    }
?>
<div class="portlet light bordered">
    <br>
    <div class="row">
        <div class="panel-heading text-center text-primary">

            <h2><b>Employee Information</b></h2>
            <h4 style="font-family: 'Khmer OS Moul';"><?= $row->dep_name ?></h4>
        </div>

        <div class="portlet-body">
            <div class="col-xs-12">
                <div class="col-xs-6 text-center">
                    <h3><b>Emp_ID: <?= $row->empl_card_id ?></b></h3>  
                    <img width="300px;" src="../../img/img_empl/<?= $row->empl_pic ?>" class="img-responsive img-responsive img-thumbnail" alt="Blank">
                    <br>សម្គាល់៖ <h4><p  style="font-family: 'Khmer OS Siemreap';"><?= $row->empl_note ?></p></h4>
                </div>
                <div class="col-xs-6">
                    <div class="col-sm-12">
                        <p><h1 style="font-family: 'Khmer OS Moul';"><?= $row->empl_emloyee_kh ?></h1>  <h1><b><?= $row->empl_emloyee_en ?></b></h1></p><br>មានមុខងារជា៖ <h4><p  style="font-family: 'Khmer OS Siemreap';"><?= $row->po_name ?></p></h4><br>
                        <i class="fa fa-phone"></i> <?= $row->empl_phone ?>, <?= $row->empl_phone2 ?><br>
                        <i class="fa fa-envelope"></i> <?= $row->empl_email ?>
                        <p>
                            - ថ្ងៃចូលបំរើ ធ្វើការ៖ <?= $row->empl_date_work ?>, 
                        </p>
                        <p>
                            - លេខអត្តសញ្ញាណប័ណ្ណ៖ <h3><?= $row->empl_id_card ?></h3>
                        </p>
                        ប្រាក់ខែមូលដ្ឋាន: <h1><?= number_format($row->empl_salary+$row->tt_salary_up,0) ?> ៛</h1>
                        <p>
                            - អាសយដ្ឋានបច្ចុប្បន្ន <h3><p  style="font-family: 'Khmer OS Siemreap';"><?= $row->empl_email ?></p></h3>
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
                          <li class="active"><a href="#activity" data-toggle="tab">បៀវត្សរ៍ប្រចាំខែ</a></li>
                          <li><a href="#timeline" data-toggle="tab">បទពិសោធន៍ការងារ</a></li>
                          <li><a href="#settings" data-toggle="tab">កំរិតជំនាញ់ទូទៅ</a></li>
                          <li><a href="#salaryup" data-toggle="tab">កំរិតការសិក្សា</a></li>
                        </ul>
                        <div class="tab-content">
                          <div class="active tab-pane" id="activity">
                            <!-- Post -->
                            <div class="col-sm-12">
                              <div class="form-body">
                                <div class="row">
                                  <div class="form-group col-sm-12">
                                    <div class="col-sm-2">
                                  <label>Date of Birth : </label>
                                        <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" required name="txt_daitebirth" value="<?= date('Y-m-d') ?>">
                                    </div>
                                    <div class="col-sm-2">
                                  <label>ចំនួនថ្ងៃធ្វើការ: </label>
                                        <input type="text" class="form-control" name="txt_phone" required=""  autocomplete="off">
                                    </div>
                                    <div class="col-sm-2">
                                  <label>ចំនួនបៀវត្សរ៍ប្រចាំខែ: </label>
                                        <input type="text" class="form-control" name="txt_phone" required=""  autocomplete="off">
                                    </div>
                                    <div class="col-sm-2">
                                  <label>តំឡើងបៀវត្សរ៍: </label>
                                        <input type="text" class="form-control" name="txt_phone" required=""  autocomplete="off">
                                    </div>
                                    <div class="col-sm-2">
                                  <label>កាត់បៀវត្សរ៍: </label>
                                        <input type="text" class="form-control" name="txt_phone" required=""  autocomplete="off">
                                    </div>
                                    <div class="col-sm-2">
                                  <label>កត់សម្គាល់: </label>
                                        <input type="text" class="form-control" name="txt_phone" required=""  autocomplete="off">
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="form-actions">
                                <div class="row">
                                  <br><br>
                                </div>
                              </div>
                            </div>

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
                                                  <th class="text-center">Name EN</th>
                                                  <th class="text-center">Name KH</th>
                                                  <th class="text-center">ខែឆ្នាំ</th>
                                                  <th class="text-center">ចំនួនថ្ងៃធ្វើការ</th>
                                                  <th class="text-center">បៀវត្សរ៍</th>
                                                  <th class="text-center">ប្រាក់តំឡើង</th>
                                                  <th class="text-center">ប្រាក់កាត</th>
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

                          <!-- /.tab-salaryup -->
                          <div class="tab-pane" id="salaryup">
                            <form class="form-horizontal">

      <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row">
                        <th class="text-center">N&deg;</th>
                        <th class="text-center">Month Up</th>
                        <th class="text-center">Employee Name</th>
                        <th class="text-center">Position</th>
                        <th class="text-center">Salary Default</th>
                        <th class="text-center">Salary Up</th>
                        <th class="text-center">Total</th>
                        <th>Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                               *
                            FROM   tbl_hr_employee_salary_up AS A  
                            LEFT JOIN tbl_hr_employee_list AS MA ON A.emup_emp_id=MA.empl_id
                            LEFT JOIN tbl_hr_position_list AS B ON MA.empl_position=B.po_id
                            WHERE empl_id='$v_id'
                            ORDER BY emup_date DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->emup_date.'</td>';
                                echo '<td>'.$row->empl_emloyee_kh.'<br>'.$row->empl_emloyee_en.'</td>';
                                echo '<td class="text-center">'.$row->po_name.'</td>';
                                echo '<td>'.number_format($row->empl_salary,2).'</td>';
                                echo '<td>'.number_format($row->emup_salary_up,2).'</td>';
                                echo '<td>'.number_format($row->empl_salary+$row->emup_salary_up,2).'</td>';

                                echo '<td>'.$row->emup_note.'</td>';
                                echo '<td class="text-center">';
                                   //echo '<a href="edit.php?edit_id='.$row->emup_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   //echo '<a href="delete.php?del_id='.$row->emup_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
                            </form>
                          </div>
                          <!-- /.tab-salaryup -->



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

