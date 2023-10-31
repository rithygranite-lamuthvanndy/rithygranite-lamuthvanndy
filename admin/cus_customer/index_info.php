<?php
    $get_id=0;
    if(@$_GET['edit_id'] == null){
        $old_data = $connect->query("SELECT 
                * 
            FROM tbl_cus_customer_info AS A 
            LEFT JOIN tbl_cus_type AS B ON B.cusct_id=A.cussi_type 
            WHERE cussi_id = '53'
            ORDER BY cussi_id DESC limit 1");        

        $row_old_data = mysqli_fetch_object($old_data);
    }else{
        $edit_id = @$_GET['edit_id'];
        $old_data = $connect->query("SELECT 
                * 
            FROM tbl_cus_customer_info AS A 
            LEFT JOIN tbl_cus_type AS B ON B.cusct_id=A.cussi_type 
            WHERE cussi_id='$edit_id'");

        $row_old_data = mysqli_fetch_object($old_data);
    }
 ?>
            <h2> Customer Information</h2>
            <hr>

            <div class="form-group col-xs-4">
            -Code:<?= $row_old_data->cus_code ?> <br>
            -Company Name:<?= $row_old_data->cussi_name ?><br>
            -Full Name:<?= $row_old_data->cusct_name ?><br>
            -Bill To:<?= $row_old_data->cus_code ?><br>
            -Note:<?= $row_old_data->cussi_note ?><br>
            </div>
            <div class="form-group col-xs-4">
            -Phone: <?= $row_old_data->cussi_phone ?><br>
            -Email:<?= $row_old_data->cussi_email ?><br>
            -Website:<?= $row_old_data->cus_code ?><br>                
            -Ship to:<?= $row_old_data->cus_code ?><br>
            -Address:<?= $row_old_data->cussi_address ?><br>                
            </div>

            <div class="form-group col-xs-4">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15635.874733444616!2d104.92720480000001!3d11.554102749999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3109513e80d24737%3A0xe0def55e8a14cf0c!2zMTHCsDMzJzM3LjUiTiAxMDTCsDU1JzA2LjkiRQ!5e0!3m2!1sen!2skh!4v1675933542757!5m2!1sen!2skh" width="350" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <hr>
            
            <br>
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#contact1" data-toggle="tab">Transaction</a>                   
                    </li>
                    <li>
                        <a href="#contact" data-toggle="tab">Contacts</a>
                    </li>
                    <li>
                        <a href="#todos" data-toggle="tab">To Do's</a>
                    </li>
                    <li>
                        <a href="#notes" data-toggle="tab">Notes</a>
                    </li>
                    <li>
                        <a href="#sends" data-toggle="tab">Sends</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="active tab-pane" id="contact1">
                        <div class="form-group col-xs-3">
                            <label>SHOW </label>
                            <select type="text" class="form-control myselect2" name="txt_type" required="" autocomplete="off">
                            <option value="">==choose type==</option>
                                                    <?php 
                                                        $get_cus_type=$connect->query("SELECT * FROM tbl_cus_type ORDER BY cusct_name ASC");
                                                        while($row_cus_type = mysqli_fetch_object($get_cus_type)){
                                                            echo '<option value="'.$row_cus_type->cusct_id.'">'.$row_cus_type->cusct_name.'</option>';
                                                        }
                                                    ?>
                            </select>
                        </div>
                        <div class="form-group col-xs-3">
                            <label>FILTER BY </label>
                            <select type="text" class="form-control myselect2" name="txt_type" required="" autocomplete="off">
                            <option value="">==choose type==</option>
                                                    <?php 
                                                        $get_cus_type=$connect->query("SELECT * FROM tbl_cus_type ORDER BY cusct_name ASC");
                                                        while($row_cus_type = mysqli_fetch_object($get_cus_type)){
                                                            echo '<option value="'.$row_cus_type->cusct_id.'">'.$row_cus_type->cusct_name.'</option>';
                                                        }
                                                    ?>
                            </select>
                        </div>
                        <div class="form-group col-xs-3">
                            <label>DATE </label>
                            <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" required name="txt_date" value="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="form-group col-xs-3">
                        </div>
                        <div class="form-group">
                            <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_3" role="grid" aria-describedby="sample_1_info">
                                                <thead>
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Num</th>
                                                    <th>Date</th>
                                                    <th>Account</th>
                                                    <th>Amount</th>
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
                                                               *,A.date_audit AS audit
                                                            FROM tbl_cus_customer_info AS A 
                                                            LEFT JOIN tbl_cus_type AS B ON B.cusct_id=A.cussi_type 
                                                            WHERE (A.user_id='$v_user_id')
                                                            ORDER BY cussi_id DESC");
                                                        }
                                                        else{
                                                            $get_data = $connect->query("SELECT 
                                                               *,A.date_audit AS audit
                                                            FROM tbl_cus_customer_info AS A 
                                                            LEFT JOIN tbl_cus_type AS B ON B.cusct_id=A.cussi_type 
                                                            ORDER BY cussi_id DESC");
                                                        }
                                                        while ($row = mysqli_fetch_object($get_data)) {
                                                            echo '<tr>';
                                                                echo '<td>'.(++$i).'</td>';
                                                                echo '<td>'.$row->cus_code.'</td>';
                                                                echo '<td>'.$row->cussi_name.'</td>';
                                                                echo '<td>'.$row->cussi_phone.'</td>';
                                                                echo '<td>'.$row->cussi_email.'</td>';
                                                            echo '</tr>';
                                                        }
                                                    ?>

                                                </tbody>
                                                
                                </table>                
                        </div>                
                    </div>
                    <div class="tab-pane" id="contact">
                        Contacts                
                    </div>
                    <div class="tab-pane" id="todos">
                        To Do's                
                    </div>
                    <div class="tab-pane" id="notes">
                        Notes                
                    </div>
                    <div class="tab-pane" id="sends">
                         Sends               
                    </div>
                </div>
            </div>


            