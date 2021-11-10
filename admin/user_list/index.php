<?php 
    $menu_active =10;
    $left_menu =4;
    $layout_title = "Welcome to User Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once 'permission.php';
    include_once '../layout/header.php';
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
            <?= button_add(); ?>
            <select name="txt_postition" form="form_search" class="btn red" onchange="this.form.submit()">
                <option value="">==all position==</option>
                <?php 
                    $get_position = $connect->query("SELECT * FROM tbl_user_position ORDER BY up_id ASC");
                    while ($row_position = mysqli_fetch_object($get_position)) {
                        if($row_position->up_id == @$_GET['txt_postition']){
                            echo '<option SELECTED value="'.$row_position->up_id.'">'.$row_position->up_name.'</option>';
                            
                        }else{
                            echo '<option value="'.$row_position->up_id.'">'.$row_position->up_name.'</option>';

                        }
                    }
                ?>
            </select>
            <form action="" id="form_search" method="get"> </form>
        </div>
        <div class="tools"> </div>
    </div>
    <div class="portlet-body">
        <div id="sample_2_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline " id="sample_2" role="grid" aria-describedby="sample_2_info">
                <thead>
                    <tr role="row">
                        <th>N&deg; #</th>
                        <th>User Code</th>
                        <th>User Name</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Gender</th>
                        <th>Photo</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Position</th>
                        <th>Password</th>
                        <th>Status</th>
                        <th>Note</th>
                        <th class="text-center" style="min-width: 100px;">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        if(@$_GET['txt_postition'] != ""){
                            $v_position = @$_GET['txt_postition'];
                            $user_query = $connect->query("SELECT * FROM tbl_user AS U 
                                LEFT JOIN tbl_user_position AS P ON U.user_position=P.up_id 
                                LEFT JOIN tbl_user_status_add AS S ON U.user_status=S.us_id 
                                LEFT JOIN tbl_user_gender AS G ON U.user_gender=G.ug_id 
                                WHERE U.user_position='$v_position' ORDER BY user_id DESC");
                        }else{
                            $user_query = $connect->query("SELECT * FROM tbl_user AS U 
                                LEFT JOIN tbl_user_position AS P ON U.user_position=P.up_id 
                                LEFT JOIN tbl_user_status_add AS S ON U.user_status=S.us_id 
                                LEFT JOIN tbl_user_gender AS G ON U.user_gender=G.ug_id ORDER BY user_id DESC");
                        }

                        $no = 0;
                        while ($row = mysqli_fetch_object($user_query)) {
                            if($row->user_status==1){
                                $v_color = 'black';
                            }else if($row->user_status==2){
                                $v_color = 'darkred';
                            }else{
                                $v_color = 'black';
                            }
                            echo '<tr style="color:'.$v_color.'">';
                                echo "<td>".(++$no)."</td>";
                                echo '<td>'.$row->user_code.'</td>';
                                echo '<td>'.$row->user_name.'</td>';
                                echo '<td>'.$row->user_first_name.'</td>';
                                echo '<td>'.$row->user_last_name.'</td>';
                                echo '<td>'.$row->ug_name.'</td>';
                                echo "<td class='text-center'>";
                                    echo "<a target='_blank' href='../../img/img_user/".trim($row->user_photo)."'><img src='../../img/img_user/".trim($row->user_photo)."' width='20px'></a>";
                                    echo '<a href="upload_image.php?edit_id='.$row->user_id.'" title="edit photo"><i class="fa fa-pencil fa-fw"></i></a>';
                                echo "</td>";
                                
                                echo '<td>'.$row->user_phone_number.'</td>';
                                echo '<td>'.$row->user_email.'</td>';
                                echo '<td>'.$row->up_name.'</td>';
                                echo '<td>'.$row->user_password.'</td>';
                                echo '<td>'.$row->us_name.'</td>';
                                echo '<td>'.$row->user_note.'</td>';
                                echo '<td class="text-center">';
                                    // echo '<a target="_blank" href="print_agrement.php?user_id='.$row->user_id.'" class="btn btn-xs btn-info" title="print agrement"><i class="fa fa-print"></i></a> ';
                                    echo button_edit($row->user_id);
                                    echo button_delete($row->user_id,$row->user_photo);
                                echo '</td>';
                            echo '</tr>';
                        }
                    ?> 
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include_once '../layout/footer.php' ?>
<div class="modal fade" id="document">
    <div class="modal-dialog modal-lg" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-body">
                <iframe id="result" src="" width="100%" style="min-height: 500px; resize: vertical;" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function set_iframe(e){
        document.getElementById('result').src = '../user_document/index.php?parent_id='+e;
    }
</script>
