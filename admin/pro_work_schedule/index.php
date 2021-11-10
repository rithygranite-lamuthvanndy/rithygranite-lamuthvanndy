<?php 
    $menu_active =150;
    $left_active =0;
    $layout_title = "Welcome to Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Work Schedule</h2>
        </div>
    </div>
    <br>
    <form class="form-inline" method="post" action="">
        <div class="row">
            <div class='col-sm-2'>
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker1'>
                        <input name="from" placeholder="YYYY-MM-DD" value="<?= @$_POST['from'] ?>" type='text' class="form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" required="" autocomplete="off">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>

            <div class='col-sm-2'>
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker1'>
                        <input name="to" placeholder="YYYY-MM-DD" value="<?= @$_POST['to'] ?>" type='text' class="form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" required="" autocomplete="off">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <button type="submit" name="btn_search" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
            <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn btn-danger"><i class="fa fa-undo"></i> Clear</a>
        </div>
    </form>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Date Record </th>
                        <th>Project Title</th>
                        <th>Project Sub</th>
                        <th>Description</th>
                        <th>Leader</th>
                        <th>Group</th>
                        <th>Start Date</th>
                        <th>Finish Date</th>
                        <th>Amount</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(isset($_POST['btn_search'])){
                           $from = $_POST['from'];
                            $to = $_POST['to'];
                            $get_data = $connect->query("SELECT 
                               *
                            FROM   tbl_pj_project_initiation AS A  
                            LEFT JOIN tbl_pj_leader AS B ON B.dlead_id = A.pini_leader
                            LEFT JOIN tbl_pj_project_title AS C ON C.pti_id=A.pini_project_title
                            WHERE pini_date_record BETWEEN '$from' AND '$to'
                            ORDER BY pini_id DESC");
                        }else{
                            $v_current_date = date('Y-m-d');
                            $get_data = $connect->query("SELECT 
                               *
                            FROM   tbl_pj_project_initiation AS A  
                            LEFT JOIN tbl_pj_leader AS B ON B.dlead_id = A.pini_leader
                            LEFT JOIN tbl_pj_project_title AS C ON C.pti_id=A.pini_project_title
                            WHERE pini_date_record ='$v_current_date'
                            ORDER BY pini_id DESC");
                        }

                        $i = 0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->pini_date_record.'</td>';
                                echo '<td>'.$row->pti_project_title.'</td>';
                                echo '<td>'.$row->pini_project_sub.'</td>';
                                echo '<td>'.$row->pini_description.'</td>';
                                echo '<td>'.$row->dlead_name.'</td>';
                                echo '<td>'.$row->pini_group.'</td>';
                                echo '<td>'.$row->pini_date_start.'</td>';
                                echo '<td>'.$row->pini_date_finish.'</td>';
                                echo '<th class="text-center">'.number_format($row->pini_amount,2).'</th>';
                                echo '<td>'.$row->pini_note.'</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>






<?php include_once '../layout/footer.php' ?>
