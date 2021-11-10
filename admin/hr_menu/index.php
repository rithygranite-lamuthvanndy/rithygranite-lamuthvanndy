<?php 
    $layout_title = "Welcome";
    $menu_active =33;
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2>Welcome: HR</h2>
			<hr>
        </div>
                      <div class="col-md-6">
                <!-- USERS LIST -->
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Latest Members</h3>

                    <div class="card-tools">
                      <span class="badge badge-danger">New Members</span>
                      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa fa-minus-square-o"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fa fa-plus-square-o"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                    <ul class="users-list clearfix">
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                            A.*,B.po_name
                            FROM tbl_hr_employee_list AS A 
                            LEFT JOIN tbl_hr_position_list AS B ON A.empl_position=B.po_id
                            ORDER BY empl_id ASC");
                        while ($row = mysqli_fetch_object($get_data)) {

                        echo '<li>';
                        echo '<img src="../../img/img_empl/'.$row->empl_pic.'" alt="User Image" class="img-responsive img-responsive img-thumbnail" style="width:120px;" alt="Avatar">';
                        echo '<a class="users-list-name" href="#">'.$row->empl_emloyee_en.'</a>';
                        echo '<span class="users-list-date">'.$row->po_name.'</span>';
                        echo '</li>';
                         }
                    ?>
                    </ul>
                    <!-- /.users-list -->
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer text-center">
                    <a href="javascript::">View All Users</a>
                  </div>
                  <!-- /.card-footer -->
                </div>
                <!--/.card -->
              </div>
              <!-- /.col -->
    </div>
       
    <!--<img src="../../img/img_system/HiRes-47.jpg" alt="" width="100%" class="img-responsive img-thumbnail"> -->
</div>






<?php include_once '../layout/footer.php' ?>
