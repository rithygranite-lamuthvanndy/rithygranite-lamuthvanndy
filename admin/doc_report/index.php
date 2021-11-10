<?php 
    $menu_active =55;
    $left_menu =69;
    $layout_title = "Welcome...";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once 'permission.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Report Document</h2>
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
                        <option value="">Choose: Category</option>
                        <?php 
                            $category = $connect->query("SELECT * FROM  tbl_doc_category ORDER BY doccat_name ASC");
                            while($row_cate = mysqli_fetch_object($category)){
                                if($row_cate->doccat_id == @$_POST['txt_project']){
                                    echo '<option SELECTED value="'.$row_cate->doccat_id.'">'.$row_cate->doccat_name.'</option>';

                                }else{
                                    echo '<option value="'.$row_cate->doccat_id.'">'.$row_cate->doccat_name.'</option>';
                                    
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
             <div class="col-sm-2">
                <div class="" >
                    <select name="txt_customer" class="form-control">
                        <option value="">Choose: Department</option>
                        <?php 
                            $customer = $connect->query("SELECT * FROM tbl_doc_department ORDER BY   docdep_name ASC");
                            while($row_cus = mysqli_fetch_object($customer)){
                                if($row_cus->docdep_id == @$_POST['txt_customer']){
                                    echo '<option SELECTED value="'.$row_cus->docdep_id.'">'.$row_cus->docdep_name.'</option>';

                                }else{
                                    echo '<option value="'.$row_cus->docdep_id.'">'.$row_cus->docdep_name.'</option>';
                                    
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
                <br>
                <br>
                <br>
            </div>
        </form>
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
                        <th>Attach File</th>
                        <th>Category</th>
                        <th>Creator</th>
                        <th>Department</th>
                        <th>Note</th>
                        <th>Date_Audit</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                        if(isset($_POST['btn_search'])){
                            $v_date_s = @$_POST['txt_date_start'];
                            $v_date_e = @$_POST['txt_date_end'];

                            $v_project = @$_POST['txt_project'];
                            $v_customer = @$_POST['txt_customer'];
                            if(@$_POST['txt_project']!="" && @$_POST['txt_customer']==""){
                                $get_data = $connect->query("SELECT 
                                   *
                                FROM  tbl_doc_document AS D 
                                LEFT JOIN  tbl_doc_category AS C ON D.docdoc_category=C.doccat_id
                                LEFT JOIN  tbl_doc_creator AS CR ON D.docdoc_creator=CR.doccre_id
                                LEFT JOIN  tbl_doc_department AS DP ON D.docdoc_department=DP.docdep_id
                                WHERE D.docdoc_date BETWEEN '$v_date_s' AND '$v_date_e' AND D.docdoc_department='$v_project'
                                ORDER BY docdoc_id DESC");

                            }else if(@$_POST['txt_project']=="" && @$_POST['txt_customer']!=""){
                                $get_data = $connect->query("SELECT 
                                   *
                                FROM  tbl_doc_document AS D 
                                LEFT JOIN  tbl_doc_category AS C ON D.docdoc_category=C.doccat_id
                                LEFT JOIN  tbl_doc_creator AS CR ON D.docdoc_creator=CR.doccre_id
                                LEFT JOIN  tbl_doc_department AS DP ON D.docdoc_department=DP.docdep_id
                                WHERE D.docdoc_date BETWEEN '$v_date_s' AND '$v_date_e' AND D.docdoc_category='$v_customer'
                                ORDER BY docdoc_id DESC");

                            }else if(@$_POST['txt_project']!="" && @$_POST['txt_customer']!=""){

                                $get_data = $connect->query("SELECT 
                                   *
                                FROM  tbl_doc_document AS D 
                                LEFT JOIN  tbl_doc_category AS C ON D.docdoc_category=C.doccat_id
                                LEFT JOIN  tbl_doc_creator AS CR ON D.docdoc_creator=CR.doccre_id
                                LEFT JOIN  tbl_doc_department AS DP ON D.docdoc_department=DP.docdep_id
                                WHERE D.docdoc_date BETWEEN '$v_date_s' AND '$v_date_e' AND D.docdoc_category='$v_customer'  AND D.docdoc_department='$v_project'
                                ORDER BY docdoc_id DESC");

                            }else{

                                $get_data = $connect->query("SELECT 
                                   *
                                FROM  tbl_doc_document AS D 
                                LEFT JOIN  tbl_doc_category AS C ON D.docdoc_category=C.doccat_id
                                LEFT JOIN  tbl_doc_creator AS CR ON D.docdoc_creator=CR.doccre_id
                                LEFT JOIN  tbl_doc_department AS DP ON D.docdoc_department=DP.docdep_id
                                WHERE D.docdoc_date BETWEEN '$v_date_s' AND '$v_date_e'
                                ORDER BY docdoc_id DESC");

                            }
                        }else{
                            $v_current_year_month = date('Y-m');
                            $get_data = $connect->query("SELECT 
                               *
                            FROM  tbl_doc_document AS D 
                            LEFT JOIN  tbl_doc_category AS C ON D.docdoc_category=C.doccat_id
                            LEFT JOIN  tbl_doc_creator AS CR ON D.docdoc_creator=CR.doccre_id
                            LEFT JOIN  tbl_doc_department AS DP ON D.docdoc_department=DP.docdep_id
                            WHERE DATE_FORMAT(D.docdoc_date,'%Y-%m')='$v_current_year_month'
                            ORDER BY docdoc_id DESC");

                        }

                        $i = 0;
                        $count = 0;

                        while ($row = mysqli_fetch_object($get_data)) {

                        $count+= 1; 

                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->docdoc_date.'</td>';
                                echo '<td>'.$row->docdoc_title.'</td>';
                                echo '<td>'.$row->docdoc_desciption.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="list_attach.php?sent_id='.$row->docdoc_id.'" class="btn btn-xs btn-info"><i class="fa fa-file"></i></a> ';
                                echo '</td>';
                                echo '</td>';
                                echo '<td>'.$row->doccat_name.'</td>';
                                echo '<td>'.$row->doccre_name.'</td>';
                                echo '<td>'.$row->docdep_name.'</td>';
                                echo '<td>'.$row->docdoc_note.'</td>';
                                echo '<td>'.$row->date_audit.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->docdoc_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                 //  echo '<a href="delete.php?del_id='.$row->docdoc_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

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
                        
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>






<?php include_once '../layout/footer.php' ?>
