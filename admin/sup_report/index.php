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
            <h2><i class="fa fa-fw fa-map-marker"></i> Report: Supplier Bill</h2>
        </div>
    </div>
    <br>
    <div class="row">
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="col-sm-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input name="txt_date_start" value="<?= @$_POST['txt_date_start'] ?>" autocomplete="off" REQUIRED type="text" class="form-control" placeholder="date from">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input name="txt_date_end" value="<?= @$_POST['txt_date_end'] ?>" autocomplete="off" REQUIRED type="text" class="form-control" placeholder="date to">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="" >
                    <select name="txt_project" class="form-control">
                        <option value="">Choose: Project</option>
                        <?php 
                            $category = $connect->query("SELECT * FROM tbl_sup_project ORDER BY suppro_name ASC");
                            while($row_cate = mysqli_fetch_object($category)){
                                if($row_cate->suppro_id == @$_POST['txt_project']){
                                    echo '<option SELECTED value="'.$row_cate->suppro_id.'">'.$row_cate->suppro_name.' :: '.$row_cate->suppro_code.'</option>';

                                }else{
                                    echo '<option value="'.$row_cate->suppro_id.'">'.$row_cate->suppro_name.' :: '.$row_cate->suppro_code.'</option>';
                                    
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="" >
                    <select name="txt_supplier" class="form-control">
                        <option value="">Choose: Supplier</option>
                        <?php 
                            $customer = $connect->query("SELECT * FROM tbl_sup_supplier_info ORDER BY supsi_name ASC");
                            while($row_cus = mysqli_fetch_object($customer)){
                                if($row_cus->supsi_id == @$_POST['txt_supplier']){
                                    echo '<option SELECTED value="'.$row_cus->supsi_id.'">'.$row_cus->supsi_name.'</option>';

                                }else{
                                    echo '<option value="'.$row_cus->supsi_id.'">'.$row_cus->supsi_name.'</option>';
                                    
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
            <br>
            <br>
            <br>
            <br>
            <br>
        </form>
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
                        <th>Attatch File</th>
                        <th>Amount</th>
                        <th>Pay Amount</th>
                        <th>Balance Amount</th>
                        <th>Step Payment</th>
                        <th>Percent</th>
                        <th>Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                        if(isset($_POST['btn_search'])){
                            $v_date_s = @$_POST['txt_date_start'];
                            $v_date_e = @$_POST['txt_date_end'];
                            $v_project = @$_POST['txt_project'];
                            $v_supplier = @$_POST['txt_supplier'];

                            if(@$_POST['txt_project']!="" AND @$_POST['txt_supplier']==""){
                                $get_data = $connect->query("SELECT  *,B.suppro_code AS p_code,B.suppro_name AS p_name,C.supp_name AS sp_name,SUM(D.suppay_pay_amount) AS sum_sup_pay FROM   tbl_sup_bill AS A
                                LEFT JOIN tbl_sup_project AS B ON A.supb_project=B.suppro_id 
                                LEFT JOIN tbl_sup_step_payment AS C ON A.supb_step_payment=C.supp_id 
                                LEFT JOIN tbl_sup_payment AS D ON D.suppay_invoice_no=A.supb_id
                                LEFT JOIN tbl_sup_supplier_info AS E ON E.supsi_id=A.supb_supplier_id
                                WHERE A.supb_date_record BETWEEN '$v_date_s' AND '$v_date_e' AND A.supb_project='$v_project'
                                GROUP BY A.supb_id
                                ORDER BY  supb_id DESC");

                            }else if(@$_POST['txt_project']=="" AND @$_POST['txt_supplier']!=""){
                                $get_data = $connect->query("SELECT  *,B.suppro_code AS p_code,B.suppro_name AS p_name,C.supp_name AS sp_name,SUM(D.suppay_pay_amount) AS sum_sup_pay FROM   tbl_sup_bill AS A
                                LEFT JOIN tbl_sup_project AS B ON A.supb_project=B.suppro_id 
                                LEFT JOIN tbl_sup_step_payment AS C ON A.supb_step_payment=C.supp_id 
                                LEFT JOIN tbl_sup_payment AS D ON D.suppay_invoice_no=A.supb_id
                                LEFT JOIN tbl_sup_supplier_info AS E ON E.supsi_id=A.supb_supplier_id
                                WHERE A.supb_date_record BETWEEN '$v_date_s' AND '$v_date_e' AND A.supb_supplier_id='$v_supplier'
                                GROUP BY A.supb_id
                                ORDER BY  supb_id DESC");

                            }else if(@$_POST['txt_project']!="" AND @$_POST['txt_supplier']!=""){
                                $get_data = $connect->query("SELECT  *,B.suppro_code AS p_code,B.suppro_name AS p_name,C.supp_name AS sp_name,SUM(D.suppay_pay_amount) AS sum_sup_pay FROM   tbl_sup_bill AS A
                                LEFT JOIN tbl_sup_project AS B ON A.supb_project=B.suppro_id 
                                LEFT JOIN tbl_sup_step_payment AS C ON A.supb_step_payment=C.supp_id 
                                LEFT JOIN tbl_sup_payment AS D ON D.suppay_invoice_no=A.supb_id
                                LEFT JOIN tbl_sup_supplier_info AS E ON E.supsi_id=A.supb_supplier_id
                                WHERE A.supb_date_record BETWEEN '$v_date_s' AND '$v_date_e' AND A.supb_project='$v_project' AND A.supb_supplier_id='$v_supplier'
                                GROUP BY A.supb_id
                                ORDER BY  supb_id DESC");

                            }else{
                                $get_data = $connect->query("SELECT  *,B.suppro_code AS p_code,B.suppro_name AS p_name,C.supp_name AS sp_name,SUM(D.suppay_pay_amount) AS sum_sup_pay FROM   tbl_sup_bill AS A
                                LEFT JOIN tbl_sup_project AS B ON A.supb_project=B.suppro_id 
                                LEFT JOIN tbl_sup_step_payment AS C ON A.supb_step_payment=C.supp_id 
                                LEFT JOIN tbl_sup_payment AS D ON D.suppay_invoice_no=A.supb_id
                                LEFT JOIN tbl_sup_supplier_info AS E ON E.supsi_id=A.supb_supplier_id
                                WHERE A.supb_date_record BETWEEN '$v_date_s' AND '$v_date_e'
                                GROUP BY A.supb_id
                                ORDER BY  supb_id DESC");
                            }
                        }else{
                            $v_current_year_month = date('Y-m');
                            $get_data = $connect->query("SELECT  *,B.suppro_code AS p_code,B.suppro_name AS p_name,C.supp_name AS sp_name,SUM(D.suppay_pay_amount) AS sum_sup_pay FROM   tbl_sup_bill AS A
                            LEFT JOIN tbl_sup_project AS B ON A.supb_project=B.suppro_id 
                            LEFT JOIN tbl_sup_step_payment AS C ON A.supb_step_payment=C.supp_id 
                            LEFT JOIN tbl_sup_payment AS D ON D.suppay_invoice_no=A.supb_id
                            LEFT JOIN tbl_sup_supplier_info AS E ON E.supsi_id=A.supb_supplier_id
                            WHERE DATE_FORMAT(A.supb_date_record,'%Y-%m')='$v_current_year_month'
                            GROUP BY A.supb_id
                            ORDER BY  supb_id DESC");

                        }

                        



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
                                echo '<td class="text-center">';
                                    echo '<a href="upload.php?up_id='.$row->supb_id.'&old_file='.$row->supb_attach_file.'" class="text-danger" title="upload"><i class="fa fa-upload fa-fw"></i></a>';
                                    if($row->supb_attach_file != ""){
                                        echo ' | <a href="../../file/file_supplier_bill/'.$row->supb_attach_file.'" target="_blank" title="download"><i class="fa fa-download fa-fw"></i></a>';
                                        
                                    }else{
                                        echo ' | <a class="text-default"><i class="fa fa-download fa-fw"></i></a>';
                                    }
                                echo '</td>';
                                echo '<td class="text-center">$'.number_format($row->supb_amount,2).'</td>';
                                echo '<td class="text-center">$'.number_format($row->sum_sup_pay,2).'</td>';
                                echo '<td class="text-center">$'.number_format($row->supb_amount-$row->sum_sup_pay,2).'</td>';
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
