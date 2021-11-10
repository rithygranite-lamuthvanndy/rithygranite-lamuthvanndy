<?php 
    $menu_active =122;
    $left_active =0;
    $layout_title = "Welcome...";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Report: Search by department</h2>
        </div>
    </div>
    <br>
    <div class="row">
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="col-sm-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input name="txt_date_start" value="<?= @$_POST['txt_date_start'] ?>" REQUIRED type="text" class="form-control" placeholder="date from">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input name="txt_date_end" value="<?= @$_POST['txt_date_end'] ?>" REQUIRED type="text" class="form-control" placeholder="date to">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="" >
                    <select name="txt_department" class="form-control">
                        <option value="">Choose: Department</option>
                        <?php 
                            $category = $connect->query("SELECT * FROM tbl_working_department ORDER BY dep_name ASC");
                            while($row_cate = mysqli_fetch_object($category)){
                                if($row_cate->dep_id == @$_POST['txt_department']){
                                    echo '<option SELECTED value="'.$row_cate->dep_id.'">'.$row_cate->dep_name.'</option>';

                                }else{
                                    echo '<option value="'.$row_cate->dep_id.'">'.$row_cate->dep_name.'</option>';
                                    
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="caption font-dark" style="display: inline-block;">
                    <button type="submit" name="btn_search" id="sample_editable_1_new" class="btn blue"> Search
                        <i class="fa fa-search"></i>
                    </button>
                </div>
                <div class="caption font-dark" style="display: inline-block;">
                    <a href="<?= $_SERVER['PHP_SELF'] ?>" id="sample_editable_1_new" class="btn red"> Clear
                        <i class="fa fa-refresh"></i>
                    </a>
                </div>

            </div>
        </form>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Date</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Hour</th>
                        <th>Attach File</th>
                        <th>Category</th>
                        <th>Employee</th>
                        <th>Company</th>
                        <th>Department</th>
                        <th>User_id</th>
                        <th>Note</th>
                        <th>Date_Audit</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $total_hour=0;

                        if(isset($_POST['btn_search'])){
                            $v_date_s = @$_POST['txt_date_start'];
                            $v_date_e = @$_POST['txt_date_end'];
                            if(@$_POST['txt_department']!=""){
                                $v_dep = @$_POST['txt_department'];
                                $get_data = $connect->query("SELECT 
                                   A.*,U.user_name,Cat.cate_name,Emp.emp_name,C.com_name,D.dep_name
                                FROM  tbl_working_record AS A 
                                    LEFT JOIN tbl_user AS U ON U.user_id=A.wr_user_id
                                    LEFT JOIN tbl_working_category AS Cat ON Cat.cate_id=A.wr_category
                                    LEFT JOIN tbl_employee AS Emp ON Emp.emp_id=A.wr_employee
                                    LEFT JOIN tbl_company AS C ON C.com_id=A.wr_company
                                    LEFT JOIN tbl_working_department AS D ON D.dep_id= A.wr_department
                                    WHERE wr_date BETWEEN '$v_date_s' AND '$v_date_e' AND A.wr_department='$v_dep'
                                ORDER BY wr_id DESC");
                            }else{
                                $get_data = $connect->query("SELECT 
                                   A.*,U.user_name,Cat.cate_name,Emp.emp_name,C.com_name,D.dep_name
                                FROM  tbl_working_record AS A 
                                    LEFT JOIN tbl_user AS U ON U.user_id=A.wr_user_id
                                    LEFT JOIN tbl_working_category AS Cat ON Cat.cate_id=A.wr_category
                                    LEFT JOIN tbl_employee AS Emp ON Emp.emp_id=A.wr_employee
                                    LEFT JOIN tbl_company AS C ON C.com_id=A.wr_company
                                    LEFT JOIN tbl_working_department AS D ON D.dep_id= A.wr_department
                                    WHERE wr_date BETWEEN '$v_date_s' AND '$v_date_e'
                                ORDER BY wr_id DESC");
                            }
                        }else{
                            $v_current_year_month = date('Y-m');
                            $get_data = $connect->query("SELECT 
                               A.*,U.user_name,Cat.cate_name,Emp.emp_name,C.com_name,D.dep_name
                            FROM  tbl_working_record AS A 
                                LEFT JOIN tbl_user AS U ON U.user_id=A.wr_user_id
                                LEFT JOIN tbl_working_category AS Cat ON Cat.cate_id=A.wr_category
                                LEFT JOIN tbl_employee AS Emp ON Emp.emp_id=A.wr_employee
                                LEFT JOIN tbl_company AS C ON C.com_id=A.wr_company
                                LEFT JOIN tbl_working_department AS D ON D.dep_id= A.wr_department
                                WHERE DATE_FORMAT(wr_date,'%Y-%m')='$v_current_year_month'
                            ORDER BY wr_id DESC");
                        }


                        while ($row = mysqli_fetch_object($get_data)) {
                            

                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->wr_date.'</td>';
                                echo '<td>'.$row->wr_title.'</td>';
                                echo '<td>'.$row->wr_desciption.'</td>';
                                echo '<td>'.$row->wr_hour.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="list_attach.php?sent_id='.$row->wr_id.'" class="btn btn-xs btn-info"><i class="fa fa-file"></i></a> ';
                                echo '</td>';
                                echo '</td>';
                                echo '<td>'.$row->cate_name.'</td>';
                                echo '<td>'.$row->emp_name.'</td>';
                                echo '<td>'.$row->com_name.'</td>';
                                echo '<td>'.$row->dep_name.'</td>';
                                echo '<td>'.$row->user_name.'</td>';
                                echo '<td>'.$row->wr_note.'</td>';
                                echo '<td>'.$row->wr_date_audit.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->wr_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                 //  echo '<a href="delete.php?del_id='.$row->docdoc_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

                                echo '</td>';
                            echo '</tr>'; 
                        }
                    ?>
                </tbody>
                <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Total:
                                <?php
                                    echo "$total_hour";
                                ?>
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            
                        </tr>
                    </tfoot>
            </table>
        </div>
    </div>
</div>






<?php include_once '../layout/footer.php' ?>
