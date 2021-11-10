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
            <h2><i class="fa fa-fw fa-map-marker"></i> Report: Search by employee</h2>
        </div>
    </div>
    <br>
    <div class="">
        <div class="caption font-dark">
            
        </div>
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

                        $get_data = $connect->query("SELECT 
                               A.*,U.user_name,Cat.cate_name,Emp.emp_name,C.com_name,D.dep_name
                            FROM  tbl_working_record AS A 
                                LEFT JOIN tbl_user AS U ON U.user_id=A.wr_user_id
                                LEFT JOIN tbl_working_category AS Cat ON Cat.cate_id=A.wr_category
                                LEFT JOIN tbl_employee AS Emp ON Emp.emp_id=A.wr_employee
                                LEFT JOIN tbl_company AS C ON C.com_id=A.wr_company
                                LEFT JOIN tbl_working_department AS D ON D.dep_id= A.wr_department
                            ORDER BY wr_id DESC");
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
