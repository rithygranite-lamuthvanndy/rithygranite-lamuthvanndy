<?php
$menu_active = 140;
$left_active = 0;
$layout_title = "Edit Page";
include_once '../../config/database.php';
include_once '../../config/athonication.php';
if (@$_GET['view'] == 'iframe')
    include_once '../layout/header_frame.php';
else
    include_once '../layout/header.php';
?>


<?php
if (isset($_POST['btn_submit'])) {

    $v_id = @$_POST['txt_id'];
    $v_date_buy = mysqli_real_escape_string($connect, @$_POST['txt_date_buy']);
    $v_code = mysqli_real_escape_string($connect, @$_POST['txt_code']);
    $v_name_kh = mysqli_real_escape_string($connect, @$_POST['txt_name_kh']);
    $v_name_vn = mysqli_real_escape_string($connect, @$_POST['txt_name_vn']);
    $v_price = mysqli_real_escape_string($connect, @$_POST['txt_price']);
    $v_positon = mysqli_real_escape_string($connect, @$_POST['txt_positon']);
    $v_note = mysqli_real_escape_string($connect, @$_POST['txt_note']);
    $txt_material_type_id= mysqli_real_escape_string($connect, @$_POST['txt_material_type_id']);
    $v_user_id = @$_SESSION['user']->user_id;


    $query_update = "UPDATE `tbl_st_track_machine_list` 
            SET 
                `date_buy`='$v_date_buy',
                `code`='$v_code',
                `name_vn`='$v_name_vn',
                `name_kh`='$v_name_kh',
                `track_price`='$v_price',
                `track_position`='$v_positon',
                `note`='$v_note',
                `user_id`='$v_user_id',
                `material_type_id`='$txt_material_type_id'
            WHERE `id`='$v_id'";


    if ($connect->query($query_update)) {
         
    } else {
       
    }
    $last_id=@$_GET['edit_id'];
     $connect->query("DELETE FROM tbl_st_track_machine_list_mores WHERE tr_id='$last_id'");

     $sql="INSERT INTO tbl_st_track_machine_list_mores
                (
                tr_id,
                roman_id
                )VALUES";

        $v_track_id=$_POST['txt_track_id'];
       
        $flag=0;
        foreach ($v_track_id as $key=>$value) {
            $v_new_v_track_id=mysqli_real_escape_string($connect,$v_track_id[$key]);
            if($v_new_v_track_id){
                $sql.="(
                        '$last_id',
                        '$v_new_v_track_id'
                        ),";
                ++$flag;
            }
        }

        $sql = rtrim($sql,",");
        if($connect->query($sql)){
           $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data update ...
            </div>';
        }
        else{
             $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> ' . $connect->error . '
            </div>';
        }



}


// get old data 
$edit_id = @$_GET['edit_id'];
$old_data = $connect->query("SELECT * FROM tbl_st_track_machine_list AS A
    LEFT JOIN tbl_st_track_machine_list_mores  AS B ON B.tr_id=A.id
    WHERE A.id='$edit_id'");


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
                <h3 class="panel-title">Edit Information</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Date Buy: </label>
                                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                    <input autocomplete="off" readonly value="<?= $row_old_data->date_buy ?>" name="txt_date_buy" type="text" class="form-control" placeholder="Date Buy .....">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Code *: </label>
                                    <input type="text" class="form-control" name="txt_code" value="<?= $row_old_data->code ?>" required="" autocomplete="off">
                                </div>
                            </div>
                             <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Material Type *: </label><br>
                                    <input  type="hidden" name="txt_material_type_id" value="1">
                                   
                                   
                                   <?php
                    

                                        $get_select = $connect->query("SELECT * FROM tbl_st_material_type_list ORDER BY sttyp_name DESC");
                                        while ($row_data = mysqli_fetch_object($get_select)) {
                                           
                                        ?>


                                      
            <input class="ch<?php echo $row_data->sttyp_id;  ?>"  type="checkbox" name="txt_track_id[]" value="<?php echo $row_data->sttyp_id; ?>">
                                        <?php echo $row_data->sttyp_name; ?><br>
                                       

                                        <?php
                                            
                                          }
                                        ?>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Name KH *: </label>
                                    <input type="text" value="<?= $row_old_data->name_kh ?>" class="form-control" name="txt_name_kh" required="" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Name VN *: </label>
                                    <input type="text" value="<?= $row_old_data->name_vn ?>" class="form-control" name="txt_name_vn" required="" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Truck Position: </label>
                                    <input type="text" value="<?= $row_old_data->track_position ?>" class="form-control" name="txt_positon">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Truck Price : </label>
                                    <input type="text" value="<?= $row_old_data->track_price ?>" class="form-control" name="txt_price">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Note : </label>
                                    <textarea type="text" class="form-control" name="txt_note" style="height: 163px;" autocomplete="off"><?= $row_old_data->note ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_submit" class="btn green"><i class="fa fa-save fa-fw"></i>Save</button>
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
    $data_check= $connect->query("SELECT * FROM tbl_st_track_machine_list AS A
    LEFT JOIN tbl_st_track_machine_list_mores  AS B ON B.tr_id=A.id
    WHERE A.id='$edit_id'");
    while ($row_check = mysqli_fetch_object($data_check)) {
        $ch=$row_check->roman_id;
        
        echo '<script type="text/javascript">
    $(document).ready(function(){
        $(".ch'.$ch.'").prop("checked",true)
    });
</script>';
?>

<?php } ?>
<?php
if (@$_GET['view'] == 'iframe')
    include_once '../layout/footer_frame.php';
else
    include_once '../layout/footer.php';
?>