<?php 
    $menu_active =145;
    $dropdown=false;
    $left_menu_active=1;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
    include_once '../inv_operation/PHP/operation.php';
?>
<?php 
// get old data 
    $edit_id = @$_GET['edit_id'];
    $old_data = $connect->query("SELECT * FROM tbl_inv_1_stock_block_stone WHERE id='$edit_id'");
    $row_old_data = mysqli_fetch_object($old_data);
if(isset($_POST['btn_submit'])){
    //Update Main Item
    $v_parent_id= @$connect->real_escape_string($_POST['txt_parent_id']);
    $v_date_record = @$connect->real_escape_string($_POST['txt_date_record']);
    $v_counter_id = @$connect->real_escape_string($_POST['cbo_counter']);
    $v_note = @$connect->real_escape_string($_POST['txt_note']);

    $sql_update_parent="UPDATE `tbl_inv_1_stock_block_stone` SET 
    date_record='$v_date_record',
    counter_id='$v_counter_id',
    note='$v_note',
    user_id='$user_id'
    WHERE id='$v_parent_id'";
    if($connect->query($sql_update_parent))
        $flag_add_1=1;
    //Uodate Sub Item Or Add Morw
    $v_child_id= @$_POST['txt_child_id'];
    $v_location= @$_POST['cbo_location'];
    $v_floor= @$_POST['cbo_floor'];
    $v_block_code= @$_POST['txt_block_code'];
    $v_lenght= @$_POST['txt_lenght'];
    $v_width= @$_POST['txt_width'];
    $v_height= @$_POST['txt_height'];
    $v_grade_type= @$_POST['cbo_grade_type'];
    $v_color= @$_POST['cbo_color'];

    foreach ($v_location as $key => $value) {
            if($v_child_id[$key]!='0'&&$value&&$v_block_code[$key]){
                $new_child_id=$v_child_id[$key];
                $new_location=$v_location[$key];
                $new_floor=$v_floor[$key];
                $new_block_code=$v_block_code[$key];
                $new_lenght=$v_lenght[$key];
                $new_width=$v_width[$key];
                $new_height=$v_height[$key];
                $new_grade_type=@$v_grade_type[$key];
                $new_color=$v_color[$key];
                 //Add Sub Item
                $query_add_2="UPDATE `tbl_inv_1_stock_block_stone_detail` SET
                    `location_id`='$new_location', 
                    `floor_id`='$new_floor', 
                    `block_code`='$new_block_code', 
                    `length`='$new_lenght', 
                    `width`='$new_width', 
                    `height`='$new_height', 
                    -- `grade_type_id`='$new_grade_type', 
                    `color_id`='$new_color' 
                    WHERE id='$new_child_id'";
                $flag_add_2=$connect->query($query_add_2);

            }
            else if($v_child_id[$key]=='0'&&$value&&$v_block_code[$key]){//Add Sub Item
                // echo $v_child_id[$key].'='.$value.'='.$v_block_code[$key].'<br>';

                // echo '<script>alert("fff");</script>';
                $new_child_id=$v_child_id[$key];
                $new_location=$v_location[$key];
                $new_floor=$v_floor[$key];
                $new_block_code=$v_block_code[$key];
                $new_lenght=$v_lenght[$key];
                $new_width=$v_width[$key];
                $new_height=$v_height[$key];
                $new_grade_type=$v_grade_type[$key];
                $new_color=$v_color[$key];
                $query_add_2="INSERT INTO `tbl_inv_block_from_mine_detail`(
                    `parent_id`, 
                    `location_id`, 
                    `floor_id`, 
                    `block_code`, 
                    `length`, 
                    `width`, 
                    `height`,  
                    `grade_type_id`,  
                    `color_id`)
                    VALUES
                    (
                    '$v_parent_id',
                    '$new_location',
                    '$new_floor',
                    '$new_block_code',
                    '$new_lenght',
                    '$new_width',
                    '$new_height',
                    '$new_grade_type',
                    '$new_color'
                    )";
                if(!$connect->query($query_add_2))
                    die(mysqli_error($connect));
            }
        }
        if($flag_add_1==1){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data updated ...
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
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2 class="voucher_code">
                <i class="fa fa-plus-circle fa-fw"></i>Edit Record
            </h2>
        </div>
    </div>
    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
            <h3 class="panel-title">Update Information</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data" autocomplete="off">
                    <input type="hidden" name="txt_parent_id" value="<?= $edit_id ?>">
                    <div class="row">
                        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>ថ្ងៃទី / Date Record:</label>
                                <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" required name="txt_date_record" value="<?= $row_old_data->date_record ?>">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>អ្នករាប់ / Counter:</label>
                                <a class="btn btn-primary btn-xs" data-toggle="modal" href='#add_modal' onclick="set_iframe_counter()"><i class="fa fa-plus"></i></a>
                                <div class="btn btn-success btn-xs" id="refresh_cbo_counter"><i class="fa fa-refresh"></i></div>
                                <select name="cbo_counter" id="input" class="form-control myselect2" required="required">
                                    <option>=== Select and Choose here ===</option>
                                    <?php 
                                        $sql=$connect->query("SELECT * FROM tbl_inv_counter_list ORDER BY name ASC");
                                        while ($row=mysqli_fetch_object($sql)) {
                                            if($row_old_data->counter_id==$row->id)
                                                echo '<option selected value="'.$row->id.'">'.$row->name.'</option>';
                                            else
                                                echo '<option value="'.$row->id.'">'.$row->name.'</option>';
                                        }
                                     ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Note : </label>
                                <textarea class="form-control" rows="1" autocomplete="off" name="txt_note"><?= $row_old_data->note ?></textarea>
                            </div>
                         </div>
                    </div>
                    <hr>
                    <table id="myTable" class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 8%;">ពណ៌<br>Color </th>
                                <th class="text-center" style="width: 15%;">តំបន់ / Map:<br>
                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#add_modal' onclick="set_iframe_location()"><i class="fa fa-plus"></i></a>
                                    <div class="btn btn-success btn-xs" id="refresh_cbo_location"><i class="fa fa-refresh"></i></div>
                                </th>
                                <th class="text-center" style="width: 15%;">ជាន់ <br> Layer<br>
                                </th>
                                <th class="text-center" style="width: 8%;">ប្រភេទថ្ម<br>Grade </th>
                                <th class="text-center" style="width: 10%;">កូដថ្មដុំ <br> Block Code*</th>
                                <th class="text-center">បណ្ដោយ <br> Dài</th>
                                <th class="text-center">ទទឹង <br> Rộng</th>
                                <th class="text-center">កម្រាស់ <br> PRICE</th>
                                <th class="text-center">ម៉ែតគូប  <br> M3</th>
                                <th class="text-center"> <i class="fa fa-cog fa-spin"></i> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sql_child=$connect->query("SELECT * FROM  tbl_inv_1_stock_block_stone_detail WHERE parent_id='$edit_id'");
                                while ($row_old_child=mysqli_fetch_object($sql_child)) {
                                    echo '<input value='.$row_old_child->id.' type="hidden" name="txt_child_id[]">';

                                    echo '<tr>';
                                        echo '<td>
                                                <select class="form-control myselect2" name="cbo_color[]">
                                                    <option value="">===  ===</option>';
                                                        $v_select = $connect->query("SELECT * FROM tbl_inv_color_list ORDER BY name");
                                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                                            if($row_old_child->color_id==$row_data->id)
                                                                echo '<option selected value="'.$row_data->id.'">'.$row_data->name.'</option>';
                                                            else
                                                                echo '<option value="'.$row_data->id.'">'.$row_data->name.'</option>';
                                                        }
                                                '</select>
                                            </td>';
                                        echo '<td>
                                                <select class="form-control myselect2" name="cbo_location[]">
                                                    <option value="">=== Please Choose and Select ===</option>';
                                                        $v_select = $connect->query("SELECT * FROM tbl_inv_location_list ORDER BY name");
                                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                                            if($row_old_child->location_id==$row_data->id)
                                                                echo '<option selected value="'.$row_data->id.'">'.$row_data->name.'</option>';
                                                            else
                                                                echo '<option value="'.$row_data->id.'">'.$row_data->name.'</option>';
                                                        }
                                                '</select>
                                            </td>';
                                        echo '<td>
                                                <input value='.$row_old_child->floor_id.' type="text" name="cbo_floor[]" class="form-control text-center" >
                                            </td>';
                                        echo '<td>
                                                <select class="form-control myselect2" onchange="changeGradetype(this);" name="cbo_grade_type[]">';
                                                        $v_select = $connect->query("SELECT * FROM tbl_inv_grade_type_list ORDER BY name");
                                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                                            if($row_old_child->grade_type_id==$row_data->id)
                                                                echo '<option selected value="'.$row_data->id.'">'.$row_data->name.'</option>';
                                                            // else
                                                            //     echo '<option value="'.$row_data->id.'">'.$row_data->name.'</option>';
                                                        }
                                                '</select>
                                            </td>';
                                        echo '<td>
                                                <input value='.$row_old_child->block_code.' type="text" name="txt_block_code[]" class="form-control text-center">
                                            </td>';
                                        echo '<td>
                                                <input value='.$row_old_child->length.' type="number" onchange="changeLenght(this);" onkeyup="changeLenght(this);" step="0.01" name="txt_lenght[]" class="form-control"value="0.01">
                                            </td>';
                                        echo '<td>
                                                <input value='.$row_old_child->width.' type="number" onchange="changeWidth(this);" onkeyup="changeWidth(this);" step="0.01" name="txt_width[]" class="form-control"value="0.01">
                                            </td>';
                                        echo '<td>
                                                <input value='.$row_old_child->height.' type="number" onchange="changeHeight(this);" onkeyup="changeHeight(this);" step="0.01" name="txt_height[]" class="form-control"value="0.01">
                                            </td>';
                                        echo '<td>
                                                <input value='.cal_mater_cub($row_old_child->length,$row_old_child->width,$row_old_child->height).' type="number" step="0.01" name="txt_mater_kub[]" class="form-control" readonly="" value="0">
                                            </td>';

                                        echo '<td class="text-center">
                                                    <button class="btnDelete btn btn-info"><i class="fa fa-trash"></i></button>
                                                 </td>';
                                    echo '</tr>';
                                }
                             ?>
                            
                                

                            <tr class="my_form_base" style="background: red; display: none;">
                                <td>
                                    <select class="form-control" name="cbo_color[]">
                                        <option value="">===  ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_inv_color_list ORDER BY name");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_data->id.'">'.$row_data->name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" name="cbo_location[]">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_inv_location_list ORDER BY name");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_data->id.'">'.$row_data->name.'</option>';
                                            }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                     <input type="number" name="cbo_floor[]" class="form-control">
                                </td>
                                <td>
                                    <select class="form-control" onchange="changeGradetype(this);" name="cbo_grade_type[]">
                                        <option value="">===  ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_inv_grade_type_list ORDER BY name");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_data->id.'">'.$row_data->name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="txt_block_code[]" class="form-control">
                                </td>
                                <td>
                                    <input type="number" onchange="changeLenght(this);" onkeyup="changeLenght(this);" step="0.01" name="txt_lenght[]" class="form-control"value="0.01">
                                </td>
                                <td>
                                    <input type="number" onchange="changeWidth(this);" onkeyup="changeWidth(this);" step="0.01" name="txt_width[]" class="form-control"value="0.01">
                                </td>
                                <td>
                                    <input type="number" onchange="changeHeight(this);" onkeyup="changeHeight(this);" step="0.01" name="txt_height[]" class="form-control"value="0.01">
                                </td>
                                <td>
                                    <input type="number" step="0.01" name="txt_mater_kub[]" class="form-control" readonly="" value="0">
                                </td>

                                <td class="text-center">
                                    <button class="btnDelete btn btn-info"><i class="fa fa-trash"></i></button>
                                </td>
                                <input value="0" type="hidden" name="txt_child_id[]">
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th class="text-right">សរុប <br>​ TOTAL Mater</th>
                                <th ><input type="text" name="txt_total_amo" readonly="" id="inputTxt_total_amo" class="form-control" value="0" required="required" pattern="" title=""></th>
                            </tr>
                        </tfoot>
                    </table>
                    <br>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_submit" class="btn green"><i class="fa fa-save fa-fw"></i>Save</button>
                                <div id="add_more" class="btn btn-default yellow btn-md" title="Click on this button to add more record !">[<i class="fa fa-plus"></i>]</div>
                                <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../../assets/global/plugins/jquery.min.js"></script>
<script>
    //Refresh Cmbobox
    $('div#refresh_cbo_counter').click(function(){
        $.ajax({url: "ajax_get_content_select.php?d=cbo_counter", success: function(result){
            if($('select[name="cbo_counter"]').html().trim() != result.trim()){
                $('select[name="cbo_counter"]').html(result);
                myAlertInfo("Your refresh item successfully !");
            }
        }});
    });
    $('div#refresh_cbo_location').click(function(){
        $.ajax({url: "ajax_get_content_select.php?d=cbo_location", success: function(result){
            if($('select[name="cbo_location[]"]').html().trim() != result.trim()){
                $('select[name="cbo_location[]"]').html(result);
                myAlertInfo("Your refresh item successfully !");
            }
        }});
    });

    $('div#refresh_cbo_floor').click(function(){
        $.ajax({url: "ajax_get_content_select.php?d=cbo_floor", success: function(result){
            if($('select[name="cbo_floor[]"]').html().trim() != result.trim()){
                $('select[name="cbo_floor[]"]').html(result);
                myAlertInfo("Your refresh item successfully !");
            }
        }});
    });
    

    $(document).ready(function(){
        //Press Button Add More
        var index_row = 1;
        $('#add_more').click(function(){ 
            $('#myTable').append('<tr data-row-id="'+(++index_row)+'">'+$('.my_form_base').html()+'</tr>');
            $('tr[data-row-id='+index_row+']').find('select').select2();
        });
        setTimeout(function(){
            // $('#add_more').click();    
            totalAmount();
        },1000);

        //Delete Row By Row
        $("tbody").on('click', '.btnDelete', function () {
            var rowCount = $('tbody>tr').length;
            if(rowCount<=2){
                alert("You can not delete this record.");
                return false;
            }
            $(this).parents('tr').remove();
            let v_block_code=$(this).parents('tr').find('td:nth-child(3) >input').val();
            //Clear Session
            $.ajax({
                url: 'ajax_get_block_code.php?clear_block_code='+v_block_code,
                success:function (result) {
                    // alert(result);
                }
            });
            totalAmount();
        });


        // $('').prop("disabled", true);
    });

    function changeLenght (args) {
        let v_length=$(args).val();
        let v_width=$(args).parents('tbody >tr').find('td:nth-child(7) >input').val();
        let v_height=$(args).parents('tbody >tr').find('td:nth-child(8) >input').val();
        let v_mater_cub=cal_mater_cub(v_length,v_width,v_height);
        $(args).parents('tbody >tr').find('td:nth-child(9) >input').val(v_mater_cub);
        totalAmount();
    }
    function changeWidth(args) {
        let v_length=$(args).parents('tbody >tr').find('td:nth-child(6) >input').val();
        let v_width=$(args).val();
        let v_height=$(args).parents('tbody >tr').find('td:nth-child(8) >input').val();
        let v_mater_cub=cal_mater_cub(v_length,v_width,v_height);
        $(args).parents('tbody >tr').find('td:nth-child(9) >input').val(v_mater_cub);
        totalAmount();
    }

    function changeHeight(args) {
        let v_length=$(args).parents('tbody >tr').find('td:nth-child(6) >input').val();
        let v_width=$(args).parents('tbody >tr').find('td:nth-child(7) >input').val();
        let v_height=$(args).val();
        let v_mater_cub=cal_mater_cub(v_length,v_width,v_height);
        $(args).parents('tbody >tr').find('td:nth-child(9) >input').val(v_mater_cub);
        totalAmount();
    }
    function totalAmount () {
        var t_amo=0;
        $('input[name^="txt_mater_kub"]').each(function () {
            t_amo+= parseFloat($(this).val());
        });
        $('tfoot >tr:first-child').find('th:nth-last-child(1) >input[name=txt_total_amo]').val(t_amo.toFixed(2));
    }
    function changeGradetype(args){
        let v_grade_type=$(args).val();
        $.ajax({
            url: 'ajax_get_block_code.php?grade_type_id='+v_grade_type,
            success:function(result){
                $(args).parents('tbody >tr').find('td:nth-child(3) >input').val(result);
                let v_arr=new Array();
                $('input[name^="txt_block_code"]').each(function () {
                    let v_block_code=$(this).val();
                    v_arr.push(v_block_code);
                }); 
                $.ajax({
                    url: 'ajax_get_block_code.php',
                    type: 'POST',
                    data: 'data='+v_arr,
                    success:function(result_new){
                        obj=JSON.parse(result_new);
                        $(args).parents('tbody >tr').find('td:nth-child(3) >input').val(obj['new_code']);
                    }
                });
            }
        });
    }
</script>
<?php include_once '../layout/footer.php' ?>
<div class="modal fade" id="add_modal">
    <div class="modal-dialog modal-lg" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-body">
                <iframe id="result_modal" src="" width="100%" style="min-height: 600px; resize: vertical;" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function set_iframe_counter(){
        document.getElementById('result_modal').src = '../inv_counter_list/index.php?view=iframe';
    }
    function set_iframe_location(){
        document.getElementById('result_modal').src = '../inv_location_list/index.php?view=iframe';
    }
    function set_iframe_floor(){
        document.getElementById('result_modal').src = '../inv_floor_list/index.php?view=iframe';
    }
</script>