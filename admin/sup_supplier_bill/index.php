<?php 
    $menu_active =130;
    $left_active =0;
    $layout_title = "Veiw Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Supplier Bill</h2>
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
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Date Record</th>
                        <th>Bill Number</th>
                        <th>Supplier Name</th>
                        <th>Project</th>
                        <th>Site</th>
                        <th>Location</th>
                        <th>Amount</th>
                        <th>Pay Amount</th>
                        <th>Balance Amount</th>
                        <th>Attatch File</th>
                        <th>Step Payment</th>
                        <th>Percent</th>
                        <th>Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead> 
                <tbody>
                    <?php
                        $v_current_year_month = date('Y-m');
                        $get_data = $connect->query("SELECT  *,B.suppro_code AS p_code,B.suppro_name AS p_name,C.supp_name AS sp_name,SUM(D.suppay_pay_amount) AS sum_sup_pay FROM   tbl_sup_bill AS A
                            LEFT JOIN tbl_sup_project AS B ON A.supb_project=B.suppro_id 
                            LEFT JOIN tbl_sup_step_payment AS C ON A.supb_step_payment=C.supp_id 
                            LEFT JOIN tbl_sup_payment AS D ON D.suppay_invoice_no=A.supb_id
                            LEFT JOIN tbl_sup_supplier_info AS E ON E.supsi_id=A.supb_supplier_id
                            WHERE DATE_FORMAT(A.supb_date_record,'%Y-%m')='$v_current_year_month'
                            GROUP BY A.supb_id
                            ORDER BY  supb_id DESC");
                        $i = 0;
                        $v_total_amount = 0;
                        $v_total_recvied_amouut = 0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            $v_total_amount += $row->supb_amount;
                            $v_total_recvied_amouut += $row->sum_sup_pay;
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->supb_date_record.'</td>';
                                echo '<td>'.$row->supb_invoice_no.'</td>';
                                echo '<td>'.$row->supsi_name.'</td>';
                                echo '<td>'.$row->p_code .' :: '.$row->p_name.'</td>';
                                echo '<td>'.$row->supb_site.'</td>';
                                echo '<td>'.$row->supb_location.'</td>';
                                echo '<td class="text-center">$'.number_format($row->supb_amount,2).'</td>';
                                echo '<td class="text-center">$'.number_format($row->sum_sup_pay,2).'
                                    <a href="index_received.php?sent_id='.$row->supb_id.'">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </td>';
                                echo '<td class="text-center">$'.number_format($row->supb_amount-$row->sum_sup_pay,2).'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="upload.php?up_id='.$row->supb_id.'&old_file='.$row->supb_attach_file.'" class="text-danger" title="upload"><i class="fa fa-upload fa-fw"></i></a>';
                                    if($row->supb_attach_file != ""){
                                        echo ' | <a href="../../file/file_supplier_bill/'.$row->supb_attach_file.'" target="_blank" title="download"><i class="fa fa-download fa-fw"></i></a>';
                                        
                                    }else{
                                        echo ' | <a class="text-default"><i class="fa fa-download fa-fw"></i></a>';
                                    }
                                echo '</td>';
                                echo '<td>'.$row->sp_name.'</td>';
                                echo '<td>'.$row->supb_percent.'</td>';
                                echo '<td>'.$row->supb_note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="alert.php?alert_id='.$row->supb_id.'" class="btn btn-xs btn-info" title="alert"><i class="fa fa-bell"></i></a> ';
                                    echo '<a href="edit.php?edit_id='.$row->supb_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                //    echo '<a href="delete.php?del_id='.$row->supb_id.'&del_img='.$row->supb_attach_file.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

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
                        <th></th>
                        <th class="text-center">$<?= number_format($v_total_amount,2) ?></th>
                        <th class="text-center">$<?= number_format($v_total_recvied_amouut,2) ?></th>
                        <th class="text-center">$<?= number_format($v_total_amount-$v_total_recvied_amouut,2) ?></th>
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
