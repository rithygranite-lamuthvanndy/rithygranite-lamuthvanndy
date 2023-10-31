<?php 
    $menu_active =11;
    $left_menu =4;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    if(@($_GET['view']=='iframe')){
        include_once '../layout/header_frame.php';
    }
    else{
        include_once '../layout/header.php';
    }
?> 
<?php 
    if(isset($_POST['btn_submit'])){
        $v_code = @$_POST['txt_code'];
        $v_manu_num = @$_POST['txt_manu_num'];
        $v_name = @$_POST['txt_name'];
        $v_name_en = @$_POST['txt_name_en'];
        $v_name_kh = @$_POST['txt_name_kh'];
        $v_description = @$_POST['txt_description'];
        $v_account = @$_POST['txt_account'];
        $v_unit_price = @$_POST['txt_unit_price'];
        $v_unit_measure = @$_POST['txt_unit_measure'];
        $v_note = @$_POST['txt_note'];
        $v_user_id = @$_SESSION['user']->user_id;

        $query_add = "INSERT INTO  tbl_inv_type_make (
                tm_code,
                tm_name,
                tm_manu_num,
                tm_name_en,
                tm_name_kh,
                tm_description,
                tm_account,
                tm_unit_price,
                tm_unit_measure,
                tm_note,
                tm_user_id             
                ) 
            VALUES(
                '$v_code',
                '$v_manu_num',
                '$v_name',
                '$v_name_en',
                '$v_name_kh',
                '$v_description',
                '$v_account',
                '$v_unit_price',
                '$v_unit_measure',
                '$v_note',
                '$v_user_id'
                )";
        if($connect->query($query_add)){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong>  Adding Record ...
            </div>'; 
        }else{
            $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong>   '.mysqli_error($connect).'
            </div>'; 
        }
    }

 ?>


<div class="portlet light bordered">
    <div class="row">
        <?= @$sms ?>
        <div class="col-xs-12">
            <h2><i class="fa fa-plus-circle fa-fw"></i>Create Record</h2>
        </div>
    </div>
    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Input Information</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <div class="form-body">

                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label>Code Type : </label>
                                    <input type="text" class="form-control" name="txt_code" required=""  autocomplete="off">
                                </div>
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label>Manufacturer's Part Number : </label>
                                    <input type="text" class="form-control" name="txt_manu_num" required=""  autocomplete="off">
                                </div>
                                <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                    <label>Name Khmer : </label>
                                    <input type="text" class="form-control" name="txt_name_kh" required=""  autocomplete="off">
                                </div>
                                <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                    <label>Name English : </label>
                                    <input type="text" class="form-control" name="txt_name_en" required=""  autocomplete="off">
                                </div>
                                <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                    <label>Name Vietnam : </label>
                                    <input type="text" class="form-control" name="txt_name" required=""  autocomplete="off">
                                </div>
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label>Add Account Items: </label>
                                    <select name="txt_account" id="input" class="form-control myselect2" required="required">
                                        <option value="">=== Select and choose ===</option>
                                        <?php 
                                            $v_select=$connect->query("SELECT accca_id,accca_number,accca_account_name FROM tbl_acc_chart_account ORDER BY accca_number");
                                            while ($row_select=mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_select->accca_id.'">'.$row_select->accca_number.' = '.$row_select->accca_account_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                    <label>Unit Price/M2 or M3 : </label>
                                    <input type="number" class="form-control" name="txt_unit_price" required=""  autocomplete="off">
                                </div>
                                <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                    <label>Unit of measure (M2/M3) </label>
                                    <input type="text" class="form-control" name="txt_unit_price" required=""  autocomplete="off" value="M2">
                                </div>
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label>Description : </label>
                                    <textarea type="text" class="form-control" name="txt_description" style="height: 80px;" autocomplete="off"></textarea>
                                </div>
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label>Note : </label>
                                    <textarea type="text" class="form-control" name="txt_note" style="height: 80px;" autocomplete="off"></textarea>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <button type="submit" name="btn_submit" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
                                <a href="index.php?view=<?= @$_GET['view'] ?>" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>
<?php 
    if(@$_GET['view']=='iframe')
        include_once '../layout/footer_frame.php';
    else
        include_once '../layout/footer.php';
 ?>
