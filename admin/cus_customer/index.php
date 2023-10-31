<?php 
    $layout_title = "Welcome Dashboard";
    $menu_active =120;
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';

?>



<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2>Welcome: Customer Management</h2>
			<hr>
        </div>
    </div>
    <div class="">
        <div class="caption font-dark">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Add New</button>
        </div>
        <div class="modal fade" id="myModal" role="dialog">
                  
              <?php include '../cus_customer_info/add_cus.php';?>
        </div>
    </div>
    <div class="row border">
        <div class="col-xs-3">
            <br>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#activity" data-toggle="tab">Customers & Jobs</a>
                </li>
                <li role="presentation">
                    <a href="#timeline" data-toggle="tab">Transactions</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="activity">
                            <div class="form-group">
                                <label id="change_label_status"></label>
                                <select name="cbo_status_type" id="input" class="form-control myselect2" required="required">
                                    <option value="1"> All Customers </option>
                                    <option value="2"> Active Customers </option>
                                    <option value="3"> Customers With Open Balance </option>
                                    <option value="4"> Customers With Overdue Invoice </option>
                                    <option value="5"> Customers With Almost Due Invoice </option>
                                    <option value="6"> Custom Filter </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="txt_address">
                            </div>
                            <div class="form-group">
                                <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Total Balance</th>
                                        <th>Attach</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                    <?php
                        $i = 0;
                        if(@$_SESSION['user']->user_position==12||@$_SESSION['user']->user_position==13)
                            $flag=1;
                        else
                            $flag=0;
                        if($flag==1){
                            $get_data = $connect->query("SELECT 
                               *,A.date_audit AS audit, left(A.cussi_name, 10) as leftname
                            FROM tbl_cus_customer_info AS A 
                            LEFT JOIN tbl_cus_type AS B ON B.cusct_id=A.cussi_type 
                            WHERE (A.user_id='$v_user_id')
                            ORDER BY cus_code DESC");
                        }
                        else{
                            $get_data = $connect->query("SELECT 
                               *,A.date_audit AS audit, left(A.cussi_name, 10) as leftname
                            FROM tbl_cus_customer_info AS A 
                            LEFT JOIN tbl_cus_type AS B ON B.cusct_id=A.cussi_type 
                            ORDER BY cus_code DESC");
                        }
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td><a href="index.php?edit_id='.$row->cussi_id.'" class="btn btn-xs btn-warning" title="edit">'.$row->leftname.'...</a></td>';
                                echo '<td>'.$row->cus_code.'</td>';
                                echo '<td></td>';
                            echo '</tr>';
                        }
                    ?>

                                    </tbody>
                                    
                                </table>
                            </div>
            </div>
            <div class="tab-pane" id="timeline">
            </div>
        </div>
        </div>
        <div class="col-xs-9">
            <?php include_once 'index_info.php' ?>
        </div>
 
    </div>


    
</div>





<?php include_once '../layout/footer.php' ?>
