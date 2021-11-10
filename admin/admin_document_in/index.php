<?php 
    $menu_active =44;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Document In</h2>
        </div>
    </div>
    <br>
    <div class="">
        <div class="caption font-dark">
            <a href="add.php" id="sample_editable_1_new" class="btn green"> Add New
                <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <div class="col-xs-12">
                <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Date Record</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Attach File</th>
                        <th>From</th>
                        <th>Employee Check</th>
                        <th>Department</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $v_user_id = @$_SESSION['user']->user_id;
                        $get_data = $connect->query("SELECT 
                               A.*,B.dep_name,C.cnl_name
                            FROM tbl_admin_document_in AS A  
                            LEFT JOIN tbl_admin_department_list AS B ON A.docin_department=B.dep_id
                            LEFT JOIN tbl_admin_check_name_list AS C ON A.docin_employee_check=C.cnl_id
                            Where user_id='$v_user_id'
                            ORDER BY docin_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->docin_date_record.'</td>';
                                echo '<td>'.$row->docin_title.'</td>';
                                echo '<td>'.$row->docin_description.'</td>';
                                echo '<td class="text-center">';
                                        echo '<a href="upload.php?up_id='.$row->docin_id.'&old_file='.$row->docin_attach_file.'" " title="Upload file"><i class="fa fa-upload" style="color: blue;"></i></a> &nbsp;&nbsp;';

                                        if($row->docin_attach_file!= ""){
                                            echo '| &nbsp;&nbsp;<a href="../../file/file_document_in/'.$row->docin_attach_file.'" target="_blank" title="download"><i class="fa fa-download" style="color: red;"></i></a>';
                                        
                                        }else{
                                            echo '| &nbsp;&nbsp;<a class="text-default"><i class="fa fa-download fa-fw" style="color: red;" title="No file to download"></i></a>';
                                        }
                                    echo '</td>';
                                echo '<td>'.$row->docin_from.'</td>';
                                echo '<td>'.$row->cnl_name.'</td>';
                                echo '<td>'.$row->dep_name.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="view.php?view_id='.$row->docin_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-file-pdf-o"></i></a> ';
                                     echo '<a href="edit.php?edit_id='.$row->docin_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   //echo '<a href="delete.php?del_id='.$row->docin_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
                </table>
            </div>
            <div class="col-xs-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Quick Example</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">File input</label>
                  <input type="file" id="exampleInputFile">

                  <p class="help-block">Example block-level help text here.</p>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox"> Check me out
                  </label>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
            </div>

        </div>
    </div>
</div>






<?php include_once '../layout/footer.php' ?>
