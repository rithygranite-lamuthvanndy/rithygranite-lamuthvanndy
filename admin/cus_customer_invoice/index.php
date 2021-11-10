<?php 
    $menu_active =120;
    $left_active =0;
    $layout_title = "Welcome to Setting Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
    $v_user_id = @$_SESSION['user']->user_id;
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Customer Invoice</h2>
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
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Date Record</th>
                        <th>Invoice Number</th>
                        <th>Customer Name</th>
                        <th>Project</th>
                        <th>Site</th>
                        <th>Location</th>
                        <th>Amount</th>
                        <th>Received Amount</th>
                        <th>Balance</th>
                        <th>Step Payment</th>
                        <th>Percent</th>
                        <th>Attatch File</th>
                        <th>Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $check_sql=$connect->query("SELECT A.user_id,B.user_id,user_position FROM tbl_cus_invoice AS A 
                            INNER JOIN tbl_user AS B ON A.user_id=B.user_id
                            WHERE A.user_id='$v_user_id'");
                        $row_check=mysqli_fetch_object($check_sql);
                        if(mysqli_num_rows($check_sql)>0){
                            if($row_check->user_position==1)
                                $flag=0;
                            else if($row_check->user_position==12||$row_check->user_position==13)
                                $flag=1; 
                        }
                        else
                            $flag=0;
                     ?>
                    <?php
                        $v_current_year_month = date('Y-m');
                        if($flag==0){
                            $get_data = $connect->query("SELECT  *,B.cuspro_code AS p_code,B.cuspro_name AS p_name,C.cuspro_name AS sp_name,SUM(cusre_received_amount) as sum_pay_amount FROM tbl_cus_invoice AS A
                                LEFT JOIN tbl_cus_project AS B ON A.cusin_project=B.cuspro_id 
                                LEFT JOIN tbl_cus_step_payment AS C ON A.cusin_step_payment=C.cuspro_id
                                LEFT JOIN tbl_cus_customer_info AS D ON D.cussi_id=A.cusin_customer_id 
                                LEFT JOIN tbl_cus_receipt AS E ON E.cusre_invoice_no=A.cusin_id
                                -- WHERE DATE_FORMAT(A.cusin_date_record,'%Y-%m')='$v_current_year_month'
                                GROUP BY A.cusin_id
                                ORDER BY  A.cusin_id DESC"); 
                        }
                        else if($flag==1){
                            $get_data = $connect->query("SELECT  *,B.cuspro_code AS p_code,B.cuspro_name AS p_name,C.cuspro_name AS sp_name,SUM(cusre_received_amount) as sum_pay_amount FROM   tbl_cus_invoice AS A
                                LEFT JOIN tbl_cus_project AS B ON A.cusin_project=B.cuspro_id 
                                LEFT JOIN tbl_cus_step_payment AS C ON A.cusin_step_payment=C.cuspro_id
                                LEFT JOIN tbl_cus_customer_info AS D ON D.cussi_id=A.cusin_customer_id 
                                LEFT JOIN tbl_cus_receipt AS E ON E.cusre_invoice_no=A.cusin_id
                                WHERE 
                                -- DATE_FORMAT(A.cusin_date_record,'%Y-%m')='$v_current_year_month' AND 
                                (A.user_id='$v_user_id')
                                GROUP BY A.cusin_id
                                ORDER BY  A.cusin_id DESC"); 
                        }
                        $i = 0;
                        $v_total_amount = 0;
                        $v_total_recvied_amouut = 0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            $v_total_amount += $row->cusin_amount;
                            $v_total_recvied_amouut += $row->sum_pay_amount;
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->cusin_date_record.'</td>';
                                echo '<td>'.$row->cusin_invoice_no.'</td>';
                                echo '<td>'.$row->cussi_name.'</td>';
                                echo '<td>'.$row->p_name .' :: '.$row->p_code.'</td>';
                                echo '<td>'.$row->cusin_site.'</td>';
                                echo '<td>'.$row->cusin_location.'</td>';
                                echo '<td class="text-center">$'.number_format($row->cusin_amount,2).'</td>';
                                echo '<td class="text-center">$'.number_format($row->sum_pay_amount,2).'
                                    <a href="index_received.php?sent_id='.$row->cusin_id.'">
                                    <i class="fa fa-pencil"></i>
                                    </a>
                                    </td>';
                                echo '<td class="text-center">$'.number_format($row->cusin_amount-$row->sum_pay_amount,2).'</td>';
                                echo '<td>'.$row->sp_name.'</td>';
                                echo '<td>'.$row->cusin_percent.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="upload.php?up_id='.$row->cusin_id.'&old_file='.$row->cusin_attach_file.'" class="text-danger" title="upload"><i class="fa fa-upload fa-fw"></i></a>';
                                    if($row->cusin_attach_file != ""){
                                        echo ' | <a href="../../file/file_customer_invoice/'.$row->cusin_attach_file.'" target="_blank" title="download"><i class="fa fa-download fa-fw"></i></a>';
                                        
                                    }else{
                                        echo ' | <a class="text-default"><i class="fa fa-download fa-fw"></i></a>';
                                    }
                                echo '</td>';
                                echo '<td>'.$row->cusin_note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="alert.php?alert_id='.$row->cusin_id.'" class="btn btn-xs btn-info" title="alert"><i class="fa fa-bell"></i></a> ';
                                    echo '<a href="edit.php?edit_id='.$row->cusin_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                    //echo '<a href="delete.php?del_id='.$row->cusin_id.'&del_img='.$row->cusin_attach_file.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

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
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="text-center">$<?= number_format($v_total_amount,2) ?></th>
                        <th class="text-center">$<?= number_format($v_total_recvied_amouut,2) ?></th>
                        <th class="text-center">$<?= number_format($v_total_amount-$v_total_recvied_amouut,2) ?></th>
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
