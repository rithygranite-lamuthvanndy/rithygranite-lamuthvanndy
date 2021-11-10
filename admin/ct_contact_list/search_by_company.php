<?php 
    $menu_active =111;
    $left_active =0;
    $layout_title = "Welcome to Setting Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Report: Search by company</h2>
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
                    <select name="txt_company" class="form-control">
                        <option value="">Choose: Company</option>
                        <?php 
                            $category = $connect->query("SELECT * FROM tbl_ct_company ORDER BY ctcom_company_name ASC");
                            while($row_cate = mysqli_fetch_object($category)){
                                if($row_cate->ctcom_id == @$_POST['txt_company']){
                                    echo '<option SELECTED value="'.$row_cate->ctcom_id.'">'.$row_cate->ctcom_company_name.'</option>';

                                }else{
                                    echo '<option value="'.$row_cate->ctcom_id.'">'.$row_cate->ctcom_company_name.'</option>';
                                    
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
                        <th>Date Record</th>
                        <th>Company</th>
                        <th>Full Name</th>
                        <th>Sex</th>
                        <th>Position</th>
                        <th>Photo</th>
                        <th>Tel (1)</th>
                        <th>Tel (2)</th>
                        <th>Email (1)</th>
                        <th>Email (2)</th>
                        <th>Address</th>
                        <th>Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $count = 0;
                        $i = 0;
                        

                        if(isset($_POST['btn_search'])){
                            $v_date_s = @$_POST['txt_date_start'];
                            $v_date_e = @$_POST['txt_date_end'];

                            if(@$_POST['txt_company']!=""){
                                $v_company = @$_POST['txt_company'];
                                $get_data = $connect->query("SELECT 
                                   *
                                FROM  tbl_ct_contact_list AS A
                                LEFT JOIN tbl_ct_company AS B ON A.ctco_company=B.ctcom_id
                                LEFT JOIN tbl_ct_position AS C ON A.ctco_position=C.ctpo_id
                                LEFT JOIN tbl_ct_sex AS D ON A.ctco_sex=D.ctsex_id
                                WHERE ctco_date_record BETWEEN '$v_date_s' AND '$v_date_e' AND A.ctco_company='$v_company'
                                ORDER BY ctco_id DESC");

                            }else{
                                $get_data = $connect->query("SELECT 
                                   *
                                FROM  tbl_ct_contact_list AS A
                                LEFT JOIN tbl_ct_company AS B ON A.ctco_company=B.ctcom_id
                                LEFT JOIN tbl_ct_position AS C ON A.ctco_position=C.ctpo_id
                                LEFT JOIN tbl_ct_sex AS D ON A.ctco_sex=D.ctsex_id
                                WHERE ctco_date_record BETWEEN '$v_date_s' AND '$v_date_e'
                                ORDER BY ctco_id DESC");

                            }
                        }else{
                            $v_current_year_month = date('Y-m');
                            $get_data = $connect->query("SELECT 
                               *
                            FROM  tbl_ct_contact_list AS A
                            LEFT JOIN tbl_ct_company AS B ON A.ctco_company=B.ctcom_id
                            LEFT JOIN tbl_ct_position AS C ON A.ctco_position=C.ctpo_id
                            LEFT JOIN tbl_ct_sex AS D ON A.ctco_sex=D.ctsex_id
                            WHERE DATE_FORMAT(ctco_date_record,'%Y-%m')='$v_current_year_month'
                            ORDER BY ctco_id DESC");

                        }

                        
                        while ($row = mysqli_fetch_object($get_data)) {
                            $count+= 1; 

                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->ctco_date_record.'</td>';
                                echo '<td>'.$row->ctcom_company_name.'</td>';
                                echo '<td>'.$row->ctco_full_name.'</td>';
                                echo '<td>'.$row->ctsex_name.'</td>';
                                echo '<td>'.$row->ctpo_name.'</td>';
                                echo '<td class="text-center">
                                    <a href="upload_img.php?cl_id='.$row->ctco_id.'&old_img='.$row->ctco_photo.'">
                                    <i class="fa fa-pencil"></i>
                                    </a>
                                    <img src="../../img/img_contact_list/'.$row->ctco_photo.'" width="60px"></td>';
                                echo '<td>'.$row->ctco_tel1.'</td>';
                                echo '<td>'.$row->ctco_tel2.'</td>';
                                echo '<td>'.$row->ctco_email1.'</td>';
                                echo '<td>'.$row->ctco_email2.'</td>';
                                echo '<td>'.$row->ctco_address.'</td>';
                                echo '<td>'.$row->ctco_note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->ctco_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   //echo '<a href="delete.php?del_id='.$row->ctco_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Count:
                            <?php
                                echo "$count";
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
