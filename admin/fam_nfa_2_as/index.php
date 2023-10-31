<?php 
    $menu_active =141;
    $left_active =0;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    if(@$_GET['view']=='iframe')
        include_once '../layout/header_frame.php';
    else
        include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        
        $v_id = @$_POST['txt_id'];
        $v_name = @$_POST['txt_name'];
        $v_note = @$_POST['txt_note'];
       
        $query_update = "UPDATE `tbl_fam_nfa_1_ar` 
            SET 
                `locat_name`='$v_name',
                `locat_note`='$v_note'
            WHERE `locat_id`='$v_id'";
            
       
        if($connect->query($query_update)){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data update ...
            </div>'; 
        }else{
            $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> Query error ...
            </div>';   
        }
    }


// get old data 
    $edit_id = @$_GET['edit_id'];
    $old_data = $connect->query("SELECT * FROM tbl_fam_nfa_1_ar WHERE fam_id_code='$edit_id'");
    $row_old_data = mysqli_fetch_object($old_data);


 ?>



<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i><b>Create Record Assigning</b></h2>
        </div>
    </div>

    <div class="portlet-title">
        <div class="caption font-dark">
            <a href="../fix_asset_management/index.php" id="sample_editable_1_new" class="btn bg-maroon btn-flat"> 
                <i class="fa fa-arrow-left"></i>
                Back
            </a>
        </div>
    </div>
    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Input Information</h3>
            </div>
            <div class="panel-body">
                 <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->fam_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-4">
                                    <h2><b>ASSETS INFO</b></h2>
                                </div>
                                <div class="col-sm-4">
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Asset ID:
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <div class="input-group margin col-sm-8">
                                        <input type="text" name="txt_name" class="form-control" required="">
                                        <span class="input-group-btn">
                                                <button type="button" name="btn_search_id" class="btn btn-info btn-flat">Search!</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                            <hr>    
                            </div>
                            <br>
                                <div class="col-sm-8">
                                    
                                    <div class="col-sm-6">
                                        <label>Description:
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <input type="text" name="txt_name" class="form-control" required="" disabled>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Cost:
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <input type="text" name="txt_name" class="form-control" required="" disabled>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Acquired Date:
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <input type="text" name="txt_name" class="form-control" required="" disabled>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Model:
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <input type="text" name="txt_name" class="form-control" required="" disabled>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Serial#:
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <input type="text" name="txt_name" class="form-control" required="" disabled>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Section:
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <input type="text" name="txt_name" class="form-control" required="" disabled>
                                    </div>

                                    <div class="col-sm-12">
                                        <hr>
                                        <h4><b>ASSETS INFO</b></h4>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Assigned To:
                                                <span class="required" aria-required="true">*</span>
                                            </label>
                                            <select type="text" class="form-control myselect2" name="cbo_locat" required="" autocomplete="off">
                                                <option value="">=== Select and choose===</option>
                                                <?php
                                                $get_select = $connect->query("SELECT * FROM tbl_st_manager_list ORDER BY stman_id ASC");
                                                while ($row_data = mysqli_fetch_object($get_select)) {
                                                    echo '<option value="' . $row_data->stman_id . '">' . $row_data->stman_name . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label >Assign Date:
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                            <input type="text" class="form-control" value="<?= date('Y-m-d') ?>" name="txt_date_acq_di" placeholder="Choose Date" required="" aufocomplete="off">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 text-center">
                                        <h4><b>TRANSACTIONS</b></h4>
                                        <hr>
                                            <div id="sample_1_wrapper" class="dataTables_wrapper">
                                                <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_3" role="grid" aria-describedby="sample_1_info">
                                                    <thead>
                                                        <tr role="row" class="text-center">
                                                            <th>N&deg;</th>
                                                            <th>Assign Date</th>
                                                            <th>Condition</th>
                                                            <th>Assigned To</th>
                                                            <th>Position</th>
                                                            <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $i = 0;
                                                            while ($row = mysqli_fetch_object($old_data)) {
                                                                echo '<tr>';
                                                                    echo '<td>'.(++$i).'</td>';
                                                                    echo '<td>'.$row->fam_date_acquired.'</td>';
                                                                    echo '<td>'.$row->fam_condition.'</td>';
                                                                    echo '<td>'.$row->fam_location.'</td>';
                                                                    echo '<td>'.$row->fam_note.'</td>';
                                                                    echo '<td class="text-center">';
                                                                        echo '<a href="edit.php?edit_id='.$row->fam_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                                                       echo '<a href="delete.php?del_id='.$row->fam_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

                                                                    echo '</td>';
                                                                echo '</tr>';
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                    </div>
                                </div>
                                    <div class="col-sm-4">
                                        <input type="hidden" name="txt_id" value="<?= @$_SESSION['user']->user_id ?>">
                                        <input type="hidden" name="txt_old_img" value="<?= @$_SESSION['user']->user_photo ?>">
                                                    <div class="form-body">                                                    
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Preview Image <span class="required" aria-required="true">*</span> </label>
                                                                    <div id="uploaded_image">
                                                                        <img width="100%" src="../../img/img_user/<?= @$_SESSION['user']->user_photo ?>" class="img-responsive img-responsive img-thumbnail" alt="Image">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                    </div>
                        
                            <div class="col-sm-12">
                                
                            <hr>    
                            </div>   
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                    <button type="submit" name="btn_prev" style="width: 100px;" class="btn bg-maroon btn-flat margin"><i class="fa fa-arrow-left"></i> Previous</button>
                                    <button type="submit" name="btn_next" style="width: 100px;"  class="btn bg-purple btn-flat margin"><i class="fa  fa-arrow-right"></i> Next</button>
                                    <button type="submit" name="btn_find" style="width: 100px;"  class="btn bg-navy btn-flat margin"><i class="fa fa-binoculars"></i> Find</button>
                                    <button type="submit" name="btn_print" style="width: 100px;"  class="btn bg-orange btn-flat margin"><i class="fa fa-print"></i> Print</button>
                                   
                                    <button type="submit" name="btn_submit" style="width: 100px;"  class="btn bg-olive btn-flat margin"><i class="fa fa-fw fa-save"></i> Add</button>
                                    <button type="submit" name="btn_exit" style="width: 100px;"  class="btn bg-maroon btn-flat margin"><i class="fa fa-edit"></i> Edit</button>
                                    <button type="submit" name="btn_dele" style="width: 100px;"  class="btn bg-purple btn-flat margin"><i class="fa fa-fw fa-remove"></i> Delete</button>
                                    <button type="submit" name="btn_exit" style="width: 100px;"  class="btn bg-navy btn-flat margin"><i class="fa fa-fw fa-close"></i> Exit</button>
                                    <br>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript" src="../../plugin/ckeditor_4.7.0_full/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace( 'detail', {
        language: 'en',
      height: '700'
        // uiColor: '#9AB8F3'
    });
</script>


<?php
if (@$_GET['view'] == 'iframe')
    include_once '../layout/footer_frame.php';
else
    include_once '../layout/footer.php';
?>