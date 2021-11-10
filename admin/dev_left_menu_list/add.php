<?php 
    $menu_active =12;
    $left_menu_active =2;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        $status=true;
        $v_main_menu= @$_POST['cbo_main_menu'];
        $v_left_menu_name= @$_POST['txt_left_menu_name'];
        $v_left_menu_directory= @$_POST['txt_left_menu_directory'];
        $v_left_menu_index= @$_POST['txt_left_menu_index'];
        $v_left_type= @$_POST['cbo_type'];
        foreach ($v_main_menu as $key => $value) {
            if($value&&$v_left_menu_name[$key]){

                $new_main_menu=$v_main_menu[$key];
                $new_left_menu_nam=$v_left_menu_name[$key];
                $new_left_menu_directory=$v_left_menu_directory[$key];
                $new_left_menu_index=$v_left_menu_index[$key];
                $new_left_menu_type=$v_left_type[$key];
                 //Add Item
                $query_add="INSERT INTO `tbl_left_menu`(
                    `lm_name`, 
                    `lm_directory`, 
                    `lm_index_order`, 
                    `lm_status`, 
                    `lm_main_menu`)
                    VALUES
                    (
                    '$new_left_menu_nam',
                    '$new_left_menu_directory',
                    '$new_left_menu_index',
                    '$new_left_menu_type',
                    '$new_main_menu'
                    )";
                if(!$connect->query($query_add)){
                    $status=false;
                    exit();
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
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Create Left Menu</h2>
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
                        <table id="myTable" class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 20%;">Top Memu<br>
                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#modal' onclick="set_iframe_top_menu()"><i class="fa fa-plus"></i></a>
                                    <div class="btn btn-success btn-xs" id="refresh_main_menu"><i class="fa fa-refresh"></i></div>
                                </th>
                                <th class="text-center" style="width: 20%;">Left Menu Name</th>
                                <th class="text-center">Directory Name</th>
                                <th class="text-center" style="width: 8%;">Index Order</th>
                                <th class="text-center" style="width: 8%;">Type</th>
                                <th class="text-center" style="width: 10%;"><i class="fa fa-cog fa-spin"></i> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="my_form_base" style="background: red; display: none;">
                                <td>
                                    <select class="form-control" name="cbo_main_menu[]">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_main_menu ORDER BY mm_index_order");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_data->mm_id.'">'.$row_data->mm_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="txt_left_menu_name[]" class="form-control">
                                </td>
                                <td>
                                    <input type="text" name="txt_left_menu_directory[]" class="form-control" >
                                </td>
                                <td>
                                    <input type="number" step="1" name="txt_left_menu_index[]" class="form-control">
                                </td>
                                <td>
                                    <select class="form-control" name="cbo_type[]">
                                        <option value="1">Link</option>
                                        <option value="2">Tittle</option>
                                        <option value="3">DropDown</option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <button class="btnDelete btn btn-info"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
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
<?php include_once '../layout/footer.php' ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('div#refresh_main_menu').click(function(){
            $.ajax({url: "ajax_get_content_select.php?d=cbo_main_menu", success: function(result){
                if($('select[name="cbo_main_menu[]"]').html().trim() != result.trim()){
                    $('select[name="cbo_main_menu[]"]').html(result);
                    myAlertInfo("Your refresh item successfully !");
                }
            }});
        });

        //Press Button Add More
        var index_row = 1;
        $('#add_more').click(function(){ 
            $('#myTable').append('<tr data-row-id="'+(++index_row)+'">'+$('.my_form_base').html()+'</tr>');
            $('tr[data-row-id='+index_row+']').find('select').select2();
        });
        setTimeout(function(){
            $('#add_more').click();      
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
                    alert(result);
                }
            });
        });
    });
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
<script type="text/javascript">
    function set_iframe_top_menu(){
        document.getElementById('result_modal').src = '../dev_top_menu_list/add.php?view=iframe';
    }
</script>
