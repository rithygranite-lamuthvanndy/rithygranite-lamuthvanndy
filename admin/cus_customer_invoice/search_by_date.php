<?php 
    $menu_active =120;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Report: Search By Date</h2>
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
                        <th>Project</th>
                        <th>Site</th>
                        <th>Location</th>
                        <th>Invoice Amount</th>
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
                        $i = 0;
                        $get_data = $connect->query("SELECT  *,B.cuspro_code AS p_code,B.cuspro_name AS p_name,C.cuspro_name AS sp_name FROM tbl_cus_invoice AS A
                            LEFT JOIN tbl_cus_project AS B ON A.cusin_project=B.cuspro_id 
                            LEFT JOIN tbl_cus_step_payment AS C ON A.cusin_step_payment=C.cuspro_id 
                            ORDER BY  cusin_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->cusin_date_record.'</td>';
                                echo '<td>'.$row->cusin_invoice_no.'</td>';
                                echo '<td>'.$row->p_name .' :: '.$row->p_code.'</td>';
                                echo '<td>'.$row->cusin_site.'</td>';
                                echo '<td>'.$row->cusin_location.'</td>';
                                echo '<td class="text-center">$'.number_format($row->cusin_amount,2).'</td>';
                                echo '<td class="text-center">$'.number_format($row->cusin_received_amount,2).'
                                    <a href="index_received.php?sent_id='.$row->cusin_id.'">
                                    <i class="fa fa-pencil"></i>
                                    </a>
                                    </td>';
                                echo '<td class="text-center">$'.number_format($row->cusin_balance_amount,2).'</td>';
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
            </table>
        </div>
    </div>
</div>






<?php include_once '../layout/footer.php' ?>
