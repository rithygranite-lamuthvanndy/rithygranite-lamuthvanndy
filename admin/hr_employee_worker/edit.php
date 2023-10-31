<?php 
    $menu_active =33;
    $left_active =0;
    $layout_title ="Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    if(@$_GET['view']=='iframe')
        include_once '../layout/header_frame.php';
    else
        include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        $v_id = mysqli_escape_string($connect,@$_POST['txt_id']);
        $v_card_no = mysqli_escape_string($connect,@$_POST['txt_card_no']);
        $v_id_card = mysqli_escape_string($connect,@$_POST['txt_id_card']);
        $v_name_eng = mysqli_escape_string($connect,@$_POST['txt_name_eng']);
        $v_name_kh = mysqli_escape_string($connect,@$_POST['txt_name_kh']);
        $v_gender = mysqli_escape_string($connect,@$_POST['cbo_gender']);
        $v_national = mysqli_escape_string($connect,@$_POST['cbo_national']);
        $v_position = mysqli_escape_string($connect,@$_POST['cbo_position']);
        $v_departmant = mysqli_escape_string($connect,@$_POST['cbo_departmant']);
        $v_salary = mysqli_escape_string($connect,@$_POST['txt_salary']);
        $v_datebith = mysqli_escape_string($connect,@$_POST['txt_daitebirth']);
        $v_datework = mysqli_escape_string($connect,@$_POST['txt_datework']);
        $v_phone = mysqli_escape_string($connect,@$_POST['txt_phone']);
        $v_phone2 = mysqli_escape_string($connect,@$_POST['txt_phone2']);
        //$v_photo = (!@$_SESSION['saved_image_name']) ?: 'blank.png';
        $v_email = mysqli_escape_string($connect,@$_POST['txt_email']);
        $v_note = mysqli_escape_string($connect,@$_POST['txt_note']);
        
       $image = "no_photo.png";
         if(!empty($_FILES['image']['size'])){
            $image = date("Ymd")."_".rand(1111,9999).$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'],"../../img/img_empl/$image");

        $query_update = "UPDATE `tbl_hr_employee_list` 
            SET 
                `empl_card_id`='$v_card_no',
                `empl_id_card`='$v_id_card',
                `empl_pic`='$image',
                `empl_emloyee_en`='$v_name_eng',
                `empl_emloyee_kh`='$v_name_kh',
                `empl_sex`='$v_gender',
                `empl_national`='$v_national',
                `empl_position`='$v_position',
                `empl_department`='$v_departmant',
                `empl_salary`='$v_salary',
                `empl_date_birth`='$v_datebith',
                `empl_date_work`='$v_datework',
                `empl_phone`= '$v_phone',
                `empl_phone2`='$v_phone2',
                `empl_email`='$v_email',
                `empl_note`='$v_note'                
            WHERE `empl_id`='$v_id'";

        if($connect->query($query_update)){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data inserted ...
            </div>'; 
        }else{
            $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> '.$connect->error.'
            </div>';   
        }
        }else{
        $query_update = "UPDATE `tbl_hr_employee_list` 
            SET 
                `empl_card_id`='$v_card_no',
                `empl_id_card`='$v_id_card',
                `empl_emloyee_en`='$v_name_eng',
                `empl_emloyee_kh`='$v_name_kh',
                `empl_sex`='$v_gender',
                `empl_national`='$v_national',
                `empl_position`='$v_position',
                `empl_department`='$v_departmant',
                `empl_salary`='$v_salary',
                `empl_date_birth`='$v_datebith',
                `empl_date_work`='$v_datework',
                `empl_phone`= '$v_phone',
                `empl_phone2`='$v_phone2',
                `empl_email`='$v_email',
                `empl_note`='$v_note'                
            WHERE `empl_id`='$v_id'";

        if($connect->query($query_update)){

            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data inserted ...
            </div>'; 
        }else{
            $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> '.$connect->error.'
            </div>';   
        }
     }
    }
    
// get old data 
    $edit_id = @$_GET['edit_id'];
    $old_data = $connect->query("SELECT * FROM tbl_hr_employee_list WHERE empl_id='$edit_id'");
    $row_old_data = mysqli_fetch_object($old_data);

 ?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Edit Record</h2>
        </div>
    </div>
    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Input Information</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->empl_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label>Card No * : </label>
                                        <input name="txt_card_no" value="<?= $row_old_data->empl_card_id ?>" type="text" class="form-control" required=""  autocomplete="off" autofocus="">
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label>ID Card or Passport : </label>
                                        <input name="txt_id_card" value="<?= $row_old_data->empl_id_card ?>" type="text" class="form-control" required=""  autocomplete="off" autofocus="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label>Name VN : </label>
                                        <input name="txt_name_eng" value="<?= $row_old_data->empl_emloyee_en ?>" type="text" class="form-control" required=""  autocomplete="off">
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label>Name KH * : </label>
                                        <input name="txt_name_kh" value="<?= $row_old_data->empl_emloyee_kh ?>" type="text" class="form-control" required=""  autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label>Gender * : </label>
                                        <select name="cbo_gender" id="inputCbo_position" class="form-control myselect2" required="required">
                                            <option value="">*** Select and choose ***</option>
                                            <?php 
                                            $v_result=$connect->query("SELECT * FROM tbl_hr_sex_list ORDER BY sex_name");
                                            while ($row_select=mysqli_fetch_object($v_result)) {
                                                if($row_old_data->empl_sex==$row_select->sex_id)
                                                    echo '<option selected value="'.$row_select->sex_id.'">'.$row_select->sex_name.'</option>';
                                                else
                                                    echo '<option value="'.$row_select->sex_id.'">'.$row_select->sex_name.'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label>National/សញ្ជាតិ * : </label>
                                        <select name="cbo_national" id="inputCbo_position" class="form-control myselect2" required="required">
                                        <option value="">*** Select and choose ***</option>
                                        <?php 
                                            $v_result=$connect->query("SELECT * FROM tbl_hr_national_list ORDER BY national_name");
                                            while ($row_select=mysqli_fetch_object($v_result)) {
                                                if($row_old_data->empl_national==$row_select->national_id)
                                                    echo '<option selected value="'.$row_select->national_id.'">'.$row_select->national_name.'</option>';
                                                else
                                                    echo '<option value="'.$row_select->national_id.'">'.$row_select->national_name.'</option>';
                                            }
                                         ?>
                                        </select>
                                    </div>
                                </div>                                
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label for="inputCbo_position">Position * : </label>
                                        <select name="cbo_position" id="inputCbo_position" class="form-control myselect2" required="required">
                                            <option value="">*** Select and choose ***</option>
                                            <?php 
                                                $v_result=$connect->query("SELECT * FROM tbl_hr_position_list ORDER BY po_name");
                                                while ($row_select=mysqli_fetch_object($v_result)) {
                                                    if($row_old_data->empl_position==$row_select->po_id)
                                                        echo '<option selected value="'.$row_select->po_id.'">'.$row_select->po_name.'</option>';
                                                    else
                                                        echo '<option value="'.$row_select->po_id.'">'.$row_select->po_name.'</option>';
                                                }
                                             ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label>Department * : </label>
                                        <select name="cbo_departmant" id="inputCbo_position" class="form-control myselect2" required="required">
                                            <option value="">*** Select and choose ***</option>
                                            <?php 
                                                $v_result=$connect->query("SELECT * FROM tbl_hr_department_sub ORDER BY dep_name");
                                                while ($row_select=mysqli_fetch_object($v_result)) {
                                                    if($row_old_data->empl_department==$row_select->dep_id)
                                                        echo '<option selected value="'.$row_select->dep_id.'">'.$row_select->dep_name.'</option>';
                                                    else
                                                        echo '<option value="'.$row_select->dep_id.'">'.$row_select->dep_name.'</option>';
                                                }
                                             ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label>Date of Birth : </label>
                                        <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" required name="txt_daitebirth" value="<?= $row_old_data->empl_date_birth?>">
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label>Date of Working : </label>
                                        <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" required name="txt_datework" value="<?= $row_old_data->empl_date_work?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label>Phone 1 * : </label>
                                        <input type="text" value="<?= $row_old_data->empl_phone ?>" class="form-control" name="txt_phone" required=""  autocomplete="off">
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label>Phone 2 : </label>
                                        <input type="text" value="<?= $row_old_data->empl_phone2 ?>" class="form-control" name="txt_phone2"  autocomplete="off">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group col-xs-12">
                                                <label for = "">User Photo</label>
                                                <input type="file" id = "phot" name="image"  value="<?= $row_old_data->empl_pic ?>" onchange="loadFile(event)" />
                                        </div>
                                        <div class = "form-group col-xs-6">                                   
                                            <img src = "../../img/img_empl/<?= $row_old_data->empl_pic ?>"  height="250px" id="preview">
                                        </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label>អាសយដ្ឋានបច្ចុប្បន្ន * : </label>
                                            <input type="text" value="<?= $row_old_data->empl_email ?>" class="form-control" name="txt_email"  autocomplete="off">
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label>Salary</label>
                                            <input type="number" value="<?= $row_old_data->empl_salary ?>" class="form-control" name="txt_salary" required=""  autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Note : </label>
                                        <textarea type="text" class="form-control" name="txt_note" style="height: 80px;" autocomplete="off"><?= $row_old_data->empl_note ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <br>
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
    <script>
        function loadFile(e){
        var output = document.getElementById('preview');
        output.width = 150;
        output.src = URL.createObjectURL(e.target.files[0]);
        }
    </script>

<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg" style="width: 70%;">
        <div class="modal-content">
            <div class="modal-body">
                <iframe id="result_modal" src="" width="100%" style="min-height: 600px; resize: vertical;" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>