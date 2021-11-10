<?php 
    $menu_active =101;
    $layout_title = "Welcome to User Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-user fa-fw"></i> Report Meeting</h2>
        </div>
    </div>
    
    <br>
    <br>

    <div class="portlet-title">
        <div class="caption font-dark">
			<!--
            <a href="add.php" id="sample_editable_1_new" class="btn green"> Add New
                <i class="fa fa-plus"></i>
            </a>
			-->
        </div>
        <div class="tools"> </div>
    </div>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row">
                        <th>N&deg; #</th>
                        <th>Date Meeting</th>
                        <th>Participation (Who)</th>
                        <th>Location (Where)</th>
                        <th>Time (When)</th>
                        <th>Topic (What)</th>
                        <th>Reason (Why)</th>
                        <th>Desciption (How)</th>
                        <th>Note (Which)</th>
                        <th class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $user_query = $connect->query("SELECT * FROM tbl_sex
                                                            ");
                        $no = 0;
                        while ($row_user = mysqli_fetch_object($user_query)) {
                            echo '<tr>';
                                echo "<td>".(++$no)."</td>";

                                //echo "<td>$row_user->sex_name</td>";
                                //echo "<td>$row_user->sex_note</td>";

                                echo "<td> </td>";
                                echo "<td> </td>";
                                echo "<td> </td>";
                                echo "<td> </td>";
                                echo "<td> </td>";
                                echo "<td> </td>";
                                echo "<td> </td>";
                                echo "<td> </td>";
                                echo '<td class="text-center">';
                                    echo '<a href="index.php?edit_id='.$row_user->sex_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> '; 
                                    echo '<a href="index.php?del_id='.$row_user->sex_id.'" onclick="return confirm(\'Are u sure to  delete this user?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';
                                    echo '</td>';
                            echo '</tr>';
                        }
                    ?> 
                </tbody>
            </table>
        </div>
    </div>
</div>




<?php include_once '../layout/footer.php' ?>
