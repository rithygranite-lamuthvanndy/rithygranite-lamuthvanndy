<?php 
    $layout_title = "Welcome HR";
    $menu_active =33;
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>

                    
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2 style="font-family: 'Khmer OS Muol';">ផ្នែក ធនធានមនុស្ស និងរដ្ឋបាល</h2>
			<hr>
        </div>

        
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="index.php">សកម្មភាពបុគ្គលិក</a>
            </li>
            <li role="presentation">
                <a href="index_sw.php">ចរនា បុគ្គលិក និង កម្មករ ចេញចូល</a>
            </li>
        </ul>
            <div class="col-md-4">
                <!-- USERS LIST -->
                <div class="box box-primary">
                  <div class="box-header with-border">
                        <h3 class="box-title"  style="font-family:'Khmer OS';">បុគ្គលិកការិយាល័យ</h3>
                  
                      <div class="box-tools pull-right">
                        <span class="label label-danger"> New Members</span>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                      </div>
                  </div>
                </div>
                  <!-- /.card-header -->
                  <div class="box-body no-padding">
                    <ul class="users-list clearfix">
                    
                    <?php
                        $i = 0;
                        $datecount=0;
                        $get_data1 = $connect->query("SELECT 
                            A.*,B.po_name
                            FROM tbl_hr_employee_list AS A 
                            LEFT JOIN tbl_hr_position_list AS B ON A.empl_position=B.po_id
                            ORDER BY empl_id ASC
                            limit 12
                            ");
                        while ($row = mysqli_fetch_object($get_data1)) {

                        echo '<li>';
                        echo '<img src="../../img/img_empl/'.$row->empl_pic.'" alt="User Image" class="img-responsive img-responsive img-thumbnail" style="width:120px;" alt="Avatar">';
                        echo '<a class="users-list-name" href="#">'.$row->empl_emloyee_en.'</a>';
                        echo '<span class="users-list-date">'.$row->po_name.'</span>';
                        echo '</li>';
                        $datecount+=1;
                         
                        }
                        $datecount;
                    ?>
                    </ul>
                    <!-- /.users-list -->
                  </div>
                  <!-- /.card-body -->
                  <div class="box-footer text-center">
                  <a href="javascript:void(0)" class="uppercase"><?= $datecount ?> View All Users</a>
                  </div>
                  <!-- /.card-footer -->
            </div>
                <!--/.card -->
              <!-- /.col -->

            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title" style="font-family:'Khmer OS';">ទំរង់ឯកសាររដ្ឋបាលផ្សេងៗ</h3>
                    </div>
                    <div class="col-xs-6">
                        <br>
                        <div class="table-responsive">
                            <table class="table no-margin" >
                            
                                <?php
                                            $i = 0;
                                            $get_data = $connect->query("SELECT 
                                                   *
                                                FROM   tbl_admin_document_sample AS A  
                                                LEFT JOIN tbl_admin_check_name_list AS B ON A.docs_employee_check=B.cnl_id
                                                LEFT JOIN  tbl_admin_department_list AS C ON A.docs_department=C.dep_id
                                                ORDER BY docs_id DESC");
                                            while ($row = mysqli_fetch_object($get_data)) {
                                                    
                                                    echo '<tr class="bg-blue" style="color: #00B050; font-size: 20px;"><td>'.$row->docs_title_name.'</td><td></td><td class="text-right"><small>'.$row->docs_date_record.'</small></td><tr>';
                                                    echo '<tr>';
                                                    echo '<td>'.(++$i).':.</td>';
                                                    echo '<td>'.$row->docs_description.'</td>';
                                                    if($row->docs_attach_file == null){
                                                        echo '<td><a href="#" class="btn btn-xs btn-warning" title="edit"></a></td>';
                                                    }else{
                                                        echo '<td class="text-right"><a href="index.php?edit_id='.$row->docs_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i> មានឯកសារ</a></td>';
                                                    }
                                                    echo '</tr>';
                                                    echo '<tr>';
                                                    echo '<td>'.$row->dep_name.'</td><td>..........</td><td class="text-right text-indent">'.$row->cnl_name.'</td></tr>';
                                            }
                                ?>
                            </table>
                        </div>    
                    </div>
                    <div class="col-xs-6"><br>
                        <?php
                            $get_id=0;
                            if(@$_GET['edit_id'] == null){
                                $old_data = $connect->query("SELECT 
                                        * 
                                    FROM tbl_admin_document_sample 
                                    ORDER BY docs_id ASC limit 1");        

                                $row_old_data = mysqli_fetch_object($old_data);
                            }else{
                                $edit_id = @$_GET['edit_id'];
                                $old_data = $connect->query("SELECT 
                                        * 
                                    FROM tbl_admin_document_sample
                                    WHERE docs_id='$edit_id'");

                                $row_old_data = mysqli_fetch_object($old_data);
                            }
                            ?>    
                            
                                <embed src="../../file/file_document_sample/<?= $row_old_data->docs_attach_file ?> "
                                    type="application/pdf"
                                    frameBorder="0"
                                    scrolling="auto"
                                    height="700px"
                                    width="100%"></embed>
                             
                    </div>

                </div>
            </div>

    </div>
    <!--<img src="../../img/img_system/HiRes-47.jpg" alt="" width="100%" class="img-responsive img-thumbnail"> -->
</div>






<?php include_once '../layout/footer.php' ?>
