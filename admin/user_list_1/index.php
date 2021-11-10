<?php 
    $menu_active =10;
    $layout_title = "Welcome...";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
    if(isset($_POST['btn_submit'])){
        $v_image = @$_FILES['txt_file'];
        $v_id = @$_POST['txt_id'];
        $sql=$connect->query("SELECT user_photo FROM tbl_user WHERE user_id='$v_id'");
        $row_photo=mysqli_fetch_object($sql);
        if(file_exists('../../img/img_user/'.$row_photo->user_photo)){
            unlink('../../img/img_user/'.$row_photo->user_photo);
        }
         if($v_image["name"] != ""){
            $new_name = date("Ymd")."_".rand(1111,9999).$v_image["name"];
            move_uploaded_file($v_image["tmp_name"], "../../img/img_user/".$new_name);


            $connect->query("UPDATE tbl_user SET 
                user_photo='$new_name'
                WHERE user_id='$v_id'
                ");
        }else{
            $sms = '<div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> Please Choose Image ...
                </div>';
        }
    }
 ?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-user fa-fw"></i>User Administrator</h2>
        </div>
    </div>
    
    <br>
    <br>

    <div class="portlet-title">
        <div class="caption font-dark">
            <a href="add.php" id="sample_editable_1_new" class="btn green"> Add New
                <i class="fa fa-plus"></i>
            </a>
        </div>
        <div class="tools"> </div>
    </div>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row">
                        <th>N&deg; #</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Email</th>
                        <th class="text-center">Photo</th>
                        <th>Gender</th>
                        <th>Status</th>
                        <th>Permission Position</th>
                        <th class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $user_query = $connect->query("SELECT * FROM tbl_user AS U LEFT JOIN tbl_user_position AS P ON U.user_position=P.up_id LEFT JOIN tbl_user_status AS S ON U.user_status=S.us_id LEFT JOIN tbl_user_gender AS G ON U.user_gender=G.ug_id");
                        $no = 0;
                        while ($row_user = mysqli_fetch_object($user_query)) {
                            echo '<tr>';
                                echo "<td>".(++$no)."</td>";
                                echo "<td>$row_user->user_name</td>";
                                echo '<td class="text-center">';
                                        echo '*** ';
                                        echo '<a href="edit_password.php?edit_id='.$row_user->user_id.'" class="btn btn-xs btn-danger" title="edit_password"> Change Password </a> '; 
                                echo '</td>';
                                echo "<td>$row_user->user_email</td>";
                                echo "<td class='text-center'>";
                                    echo "<img src='../../img/img_user/".trim($row_user->user_photo)."' width='50px'>";
                                    echo '&nbsp;&nbsp;';
                                    echo '<a onclick="my_modal(this)" class="btn btn-primary btn-xs" data="'.$row_user->user_id.'" data-toggle="modal" href="#modal-id"><i class="fa fa-edit"></i></a>';
                                echo "</td>";
                                echo "<td>$row_user->ug_name</td>";
                                echo "<td>$row_user->us_name</td>";
                                echo "<td>$row_user->up_name</td>";
                                echo '<td class="text-center">';
                                    echo '<a href="edit_permission.php?edit_id='.$row_user->user_id.'" class="btn btn-xs btn-info" title="edit"> Permission </a> '; 
                                    echo '<a href="edit.php?edit_id='.$row_user->user_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> '; 
                                    
                                //    echo '<a href="delete.php?del_id='.$row_user->user_id.'&del_img='.trim($row_user->user_photo).'" onclick="return confirm(\'Are u sure to  delete this user?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';
                                    
                                    echo '</td>';
                            echo '</tr>';
                        }
                    ?> 
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript" src="../../assets/global/plugins/jquery.min.js"></script>
<script type="text/javascript">
    function my_modal(obj){
        v_id=$(obj).attr('data');
        $('.modal-body').find('input').val(v_id);
    }
</script>

<?php include_once '../layout/footer.php' ?>
<div class="modal fade" id="modal-id">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Change Profile Photo</h4>
            </div>
            <div class="modal-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt_id">
                        <div class="form-group form-md-line-input">
                            <input required="" type="file" class="form-control" name="txt_file" placeholder="date record..."  autocomplete="off">
                            <label>Upload File :
                                <span class="required" aria-required="true"></span>
                            </label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" name="btn_submit" class="btn btn-primary">Save changes</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>