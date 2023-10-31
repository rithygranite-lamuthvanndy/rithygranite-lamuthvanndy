<?php 
    $menu_active =33;
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
        $v_card_no = mysqli_escape_string($connect,@$_POST['txt_card_no']);
        $v_id_card = mysqli_escape_string($connect,@$_POST['txt_id_card']);
        $v_name_eng = mysqli_escape_string($connect,@$_POST['txt_name_eng']);
        $v_name_kh = mysqli_escape_string($connect,@$_POST['txt_name_kh']);
        $v_gender = mysqli_escape_string($connect,@$_POST['cbo_gender']);
        $v_national = mysqli_escape_string($connect,@$_POST['cbo_national']);
        $v_position = mysqli_escape_string($connect,@$_POST['cbo_position']);
        $v_departmant = mysqli_escape_string($connect,@$_POST['cbo_departmant']);
        $v_datebith = mysqli_escape_string($connect,@$_POST['txt_daitebirth']);
        $v_datework = mysqli_escape_string($connect,@$_POST['txt_datework']);
        $v_salary = mysqli_escape_string($connect,@$_POST['txt_salary']);
        $v_phone = mysqli_escape_string($connect,@$_POST['txt_phone']);
        $v_phone2 = mysqli_escape_string($connect,@$_POST['txt_phone2']);
        //$v_photo = (!@$_SESSION['saved_image_name']) ?: 'blank.png';
        $v_email = mysqli_escape_string($connect,@$_POST['txt_email']);
        $v_note = mysqli_escape_string($connect,@$_POST['txt_note']);
        
       $image = "no_photo.png";
         if(!empty($_FILES['image']['size'])){
            $image = date("Ymd")."_".rand(1111,9999).$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'],"../../img/img_empl/$image");

        $query_add = "INSERT INTO tbl_hr_employee_list (
                empl_card_id,
                empl_id_card,
                empl_pic,
                empl_emloyee_en,
                empl_emloyee_kh,
                empl_sex,
                empl_national,
                empl_position,
                empl_department,
                empl_date_birth,
                empl_date_work,
                empl_salary,
                empl_phone,
                empl_phone2,
                empl_email,
                empl_note                
                ) 
            VALUES(
                '$v_card_no',
                '$v_id_card',
                '$image',
                '$v_name_eng',
                '$v_name_kh',
                '$v_gender',
                '$v_national',
                '$v_position',
                '$v_departmant',
                '$v_datebith',
                '$v_datework',
                '$v_salary',
                '$v_phone',
                '$v_phone2',
                '$v_email',
                '$v_note'
                )";
        if($connect->query($query_add)){
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
        $query_add = "INSERT INTO tbl_hr_employee_list (
                empl_card_id,
                empl_id_card,
                empl_pic,
                empl_emloyee_en,
                empl_emloyee_kh,
                empl_sex,
                empl_national,
                empl_position,
                empl_department,
                empl_date_birth,
                empl_date_work,
                empl_salary,
                empl_phone,
                empl_phone2,
                empl_email,
                empl_note                
                ) 
            VALUES(
                '$v_card_no',
                '$v_id_card',
                'no_photo.png',
                '$v_name_eng',
                '$v_name_kh',
                '$v_gender',
                '$v_national',
                '$v_position',
                '$v_departmant',
                '$v_datebith',
                '$v_datework',
                '$v_salary',
                '$v_phone',
                '$v_phone2',
                '$v_email',
                '$v_note'
                )";
        if($connect->query($query_add)){
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
    
 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
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
                                <div class="form-group">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label>Card No * : </label>
                                        <input name="txt_card_no" type="text" class="form-control" required=""  autocomplete="off" autofocus="">
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label>ID Card or Passport : </label>
                                        <input name="txt_id_card" type="text" class="form-control" required=""  autocomplete="off" autofocus="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label>Name VN * : </label>
                                        <input name="txt_name_eng" type="text" class="form-control" required=""  autocomplete="off">
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label>Name KH * : </label>
                                        <input name="txt_name_kh" type="text" class="form-control" required=""  autocomplete="off">
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
                                        <label for="inputCbo_position">មុខងារជា * : </label>
                                        <select name="cbo_position" id="inputCbo_position" class="form-control myselect2" required="required">
                                            <option value="">*** Select and choose ***</option>
                                            <?php 
                                                $v_result=$connect->query("SELECT * FROM tbl_hr_position_list where po_id =142 ORDER BY po_name");
                                                while ($row_select=mysqli_fetch_object($v_result)) {
                                                    echo '<option value="'.$row_select->po_id.'">'.$row_select->po_name.'||'.$row_select->po_note.'</option>';
                                                }
                                             ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label>នៅផ្នែក * : </label>
                                        <select name="cbo_departmant" id="inputCbo_position" class="form-control myselect2" required="required">
                                            <option value="">*** Select and choose ***</option>
                                            <?php 
                                                $v_result=$connect->query("SELECT * FROM tbl_hr_department_sub WHERE dep_id Not IN (65, 66, 67, 68, 69, 70, 71)  ORDER BY dep_name");
                                                while ($row_select=mysqli_fetch_object($v_result)) {
                                                    echo '<option value="'.$row_select->dep_id.'">'.$row_select->dep_id.' || '.$row_select->dep_name.'</option>';
                                                }
                                             ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label>ថ្ងែ ខែ ឆ្នាំ កំណើត : </label>
                                        <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" required name="txt_daitebirth" value="<?= date('Y-m-d') ?>">
                                        
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label>ថ្ងៃ ខែ ឆ្នាំ ចូលធ្វើការ : </label>
                                        <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" required name="txt_datework" value="<?= date('Y-m-d') ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                        <label>Phone 1 * : </label>
                                        <input type="text" class="form-control" name="txt_phone" required=""  autocomplete="off">
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                        <label>Phone 2 : </label>
                                        <input type="text" class="form-control" name="txt_phone2" autocomplete="off">
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                        <label>Salary : </label>
                                        <input type="number" class="form-control" name="txt_salary" autocomplete="off">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group col-xs-12">
                                            <label for = "">មាន រូប</label>
                                            <input type="file" id = "phot" name="image" onchange="loadFile(event)" />
                                        </div>
                                        <div class="form-group col-xs-12">                                   
                                            <img src="" alt="" id="preview">
                                        </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="col-md-12">
                                        <label>អាសយដ្ឋានបច្ចុប្បន្ន </label>
                                        <input type="text" class="form-control" name="txt_email"  autocomplete="off">
                                    </div>
                                    <div class="col-md-12">
                                        <label>សំគាល់ផ្សេងៗ </label>
                                        <textarea type="text" class="form-control" name="txt_note" style="height: 80px;" autocomplete="off"></textarea>
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
        output.width = 400;
        output.height = 300;
        output.src = URL.createObjectURL(e.target.files[0]);
        }
    </script>