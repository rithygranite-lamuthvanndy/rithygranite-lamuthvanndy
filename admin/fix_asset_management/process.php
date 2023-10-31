<?php 
    $layout_title = "Welcome Fixed Asset Management";
    $menu_active =141;
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
    require_once "../../plugin/PHPExcel/Classes/PHPExcel.php";
$date_n=date("Y-m-d h:i:sa");
$file = $_FILES['file']['name'];
$ekstensi = explode(".", $file);
$file_name ="file-".round(microtime(true)).".".end($ekstensi);
$sumber = $_FILES['file']['tmp_name'];
$target_dir ="../_file/";
$target_file = $target_dir.basename($_FILES["file"]["name"]);
move_uploaded_file($sumber, $target_file);
?>

<?php 

    if(isset($_POST['btn_submit'])){
        $status=true;
        if(@($_GET['status']=='add_more')){
            $v_last_id=$_GET['parent_id'];
        }
        else{
            //Add Main Item

            $v_date_record = @$connect->real_escape_string($_POST['txt_date_record']);
            $v_counter_id = @$connect->real_escape_string($_POST['cbo_counter']);
            $v_np_num_block = @$connect->real_escape_string($_POST['txt_num_block']);
            $v_note = @$connect->real_escape_string($_POST['txt_note']);

            $query_add = "INSERT INTO `tbl_inv_excel_stock_block`(
            esb_date_record, 
            esb_counter_id,
            esb_np_num_block,
            esb_note,
            user_id) 
            VALUES (
            '$v_date_record',
            '$v_counter_id',
            '$v_np_num_block',
            '$v_note',
            '$user_id'
            )";

            if(!$connect->query($query_add)){
                $status=false;
                die(mysqli_error($connect));
            }
            $v_last_id=$connect->insert_id;
        }
$date_n=date("Y-m-d h:i:sa");
$file = $_FILES['file']['name'];
$ekstensi = explode(".", $file);
$file_name ="file-".round(microtime(true)).".".end($ekstensi);
$sumber = $_FILES['file']['tmp_name'];
$target_dir ="../_file/";
$target_file = $target_dir.basename($_FILES["file"]["name"]);
move_uploaded_file($sumber, $target_file);

        $v_new_date= @$_POST['txt_date'];
        $v_new_map= @$_POST['txt_map'];
        $v_new_layer= @$_POST['txt_layer'];
        $v_new_grade= @$_POST['txt_grade'];
        $v_new_code= @$_POST['txt_code'];
        $v_new_lenght= @$_POST['txt_lenght'];
        $v_new_width= @$_POST['txt_width'];
        $v_new_height= @$_POST['txt_height'];
        $v_new_m3= @$_POST['txt_m3'];
        $v_new_in_month= @$_POST['txt_in_month'];
        $v_new_date_out= @$_POST['txt_date_out'];
        

        foreach ($new_date as $key => $value) {
            if($value&&$new_m3[$key]){
                $new_date=$v_new_date[$key];
                $new_color=$v_new_date[$key];
                $new_map=$v_new_map[$key];
                $new_layer=$v_new_layer[$key];
                $new_grade=$v_new_grade[$key];
                $new_code=$v_new_code[$key];
                $new_lenght=$v_new_lenght[$key];
                $new_width=$v_new_width[$key];
                $new_height=$v_new_height[$key];
                $new_m3=$v_new_m3[$key];
                $new_in_month=$v_new_in_month[$key];
                $new_date_out=$v_new_date_out[$key];
                 //Add Sub Item
                $query_add_2="INSERT INTO `tbl_inv_excel_stock_block_list`(
                    `esbl_esb_id`,  
                    `esbl_date`, 
                    `esbl_color`, 
                    `esbl_map`, 
                    `esbl_layer`,
                    `esbl_grade`,
                    `esbl_code`,
                    `esbl_length`,
                    `esbl_width`,
                    `esbl_height`,
                    `esbl_m3`,
                    `esbl_in_month`,
                    `esbl_date_out`
                    )
                    VALUES
                    (
                    '$v_last_id',
                    '$new_date',
                    '$new_color',
                    '$new_map',
                    '$new_layer',
                    '$new_code',
                    '$new_lenght',
                    '$new_width',
                    '$new_height',
                    '$new_m3',
                    '$new_in_month',
                    '$new_date_out'
                    )";
                if(!$connect->query($query_add_2)){
                    $status=false;
                    die(mysqli_error($connect));
                }
            }
        }
        if($status){
            $sms = '<div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Successfull!</strong> Data inserted ...
                    </div>'; 
        }else{  
            $sms = '<div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Error!</strong> '.mysqli_error($connect).'
                    </div>';   
        }
    }
 ?>
<div class="portlet light bordered">
    <div class="portlet-body">
            <div class="panel-heading">
                <h3 class="panel-title">Input Information</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data" autocomplete="off">
                    <?php if(!@$_GET['status']=='add_more'){ ?>
                        <div class="row">
                            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>ថ្ងៃទី / Date Record:</label>
                                    <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" required name="txt_date_record" value="<?= date('Y-m-d') ?>">
                                </div>
                                <div class="form-group">
                                    <label>អ្នករាប់ / Counter *:</label>
                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#add_modal' onclick="set_iframe_counter()"><i class="fa fa-plus"></i></a>
                                    <div class="btn btn-success btn-xs" id="refresh_cbo_counter"><i class="fa fa-refresh"></i></div>
                                    <select name="cbo_counter" id="input" class="form-control myselect2" required="">
                                        <option>=== Select and Choose here ===</option>
                                        <?php 
                                            $sql=$connect->query("SELECT * FROM tbl_inv_counter_list ORDER BY name ASC");
                                            while ($row=mysqli_fetch_object($sql)) {
                                                echo '<option value="'.$row->id.'">'.$row->name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Number Block : </label>
                                    <input type="text" class="form-control" name="txt_num_block" required=""  autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Note : </label>
                                    <textarea class="form-control" rows="1" autocomplete="off" name="txt_note"></textarea>
                                </div>
                             </div>
                        </div>
                    <?php } ?>
                    <hr>

                    <div id="sample_1_wrapper" class="dataTables_wrapper">
                        <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_2" role="grid" aria-describedby="sample_1_info">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>DATE</th>
                                    <th>COLOR</th>
                                    <th>MAP</th>
                                    <th>LAYER</th>
                                    <th>GRADE</th>
                                    <th>CODE</th>
                                    <th>LENGTH</th>
                                    <th>WIDTH</th>
                                    <th>HEIHGT</th>
                                    <th>QTY</th>
                                    <th>M3</th>
                                    <th>IN MONTH</th>
                                    <th>Date Out</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $obj = PHPExcel_IOFactory::load($target_file);
                                $all_data = $obj->getActiveSheet()->toArray(null,true,true,true);
                                for($i=2; $i<= count($all_data); $i++){
                                echo '<tr>';
                                echo '<td><input type="text" class=" form-control" name="txt_limit[]" value="'.$all_data[$i]['A'].'"></td>';
                                echo '<td><input type="text" class=" form-control" name="txt_date[]" value="'.$all_data[$i]['B'].'"></td>';
                                echo '<td><input type="text" class=" form-control" name="txt_color[]" value="'.$all_data[$i]['C'].'"></td>';
                                echo '<td><input type="text" class=" form-control" name="txt_map[]" value="'.$all_data[$i]['D'].'"></td>';
                                echo '<td><input type="text" class=" form-control" name="txt_layer[]" value="'.$all_data[$i]['E'].'"></td>';
                                echo '<td><input type="text" class=" form-control" name="txt_grade[]" value="'.$all_data[$i]['F'].'"></td>';
                                echo '<td><input type="text" class=" form-control" name="txt_code[]" value="'.$all_data[$i]['G'].'"></td>';
                                echo '<td><input type="text" class=" form-control" name="txt_length[]" value="'.$all_data[$i]['H'].'"></td>';
                                echo '<td><input type="text" class=" form-control" name="txt_width[]" value="'.$all_data[$i]['I'].'"></td>';
                                echo '<td><input type="text" class=" form-control" name="txt_height[]" value="'.$all_data[$i]['J'].'"></td>';
                                echo '<td><input type="text" class=" form-control" name="txt_qty[]" value="'.$all_data[$i]['K'].'"></td>';
                                echo '<td><input type="text" class=" form-control" name="txt_m3[]" value="'.$all_data[$i]['L'].'"></td>';
                                echo '<td><input type="text" class=" form-control" name="txt_in_month[]" value="'.$all_data[$i]['M'].'"></td>';
                                echo '<td><input type="text" class=" form-control" name="txt_date_out[]" value="'.$all_data[$i]['N'].'"></td>';
                                echo '</tr>';
                                }
                                ?>


                            </tbody>
                        </table>
                        <br>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" name="btn_submit" class="btn green"><i class="fa fa-save fa-fw"></i>Save</button>
                                    <a href="index.php?action=2" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
               </form><br>
            </div>
    </div>
</div>