<?php  
    $menu_active =3;
    $left_menu =4;
    $layout_title = "Welcome to User Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once 'permission.php';
?>
<?php 
  if(isset($_POST['btn_save'])){
    $v_name = $connect->real_escape_string($_POST['txt_module_name']);
    $v_main_menu = $connect->real_escape_string($_POST['txt_main_menu']);
    $v_dir = $connect->real_escape_string($_POST['txt_dir']);
    $v_index = $connect->real_escape_string($_POST['txt_index']);
    $v_status = $connect->real_escape_string($_POST['txt_status']);
    $connect->query("INSERT INTO tbl_left_menu(lm_name,lm_directory,lm_main_menu,lm_status,lm_index_order) VALUES('$v_name','$v_dir','$v_main_menu',$v_status,'$v_index')");
  }
?>
<?php
    include_once '../layout/header.php';
?>
<style type="text/css">
    .switch {
      position: relative;
      display: inline-block;
      width: 40px;
      height: 20px;
      margin-top: 0px;
      padding: 0px;
    }

    .switch input {display:none;}

    .switch .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
      height: 100%;
      width: 100%;
      margin: 0px;
    }

    .switch .slider:before {
      position: absolute;
      content: "";
      height: 12.5px;
      width: 16px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .switch input:checked + .slider {
      background-color: #2196F3;
    }

    .switch input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
    }

    .switch input:checked + .slider:before {
      -webkit-transform: translateX(16px);
      -ms-transform: translateX(16px);
      transform: translateX(16px);
    }
</style>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-user fa-fw"></i>User Permission (Module)</h2>
        </div>
    </div>
    
    <br>
    <br>
    <div class="portlet-title">
        <div class="caption font-dark">
            <?php if(@$_GET['parent_id'] != ""){ ?>
            <a href="add.php" class="btn red" onclick="window.close()"> Close <i class="fa fa-times"></i> </a>
            <?php }else{ echo button_add(); } ?>
            <select name="txt_main_menu" form="form_search" class="btn green" onchange="this.form.submit()">
                <option value="">==all permission==</option>
                <?php 
                    $get_main_menu = $connect->query("SELECT * FROM tbl_main_menu ORDER BY mm_index_order ASC");
                    while ($row_main_menu = mysqli_fetch_object($get_main_menu)) {
                        if($row_main_menu->mm_id == @$_GET['txt_main_menu']){
                            echo '<option SELECTED value="'.$row_main_menu->mm_id.'">'.$row_main_menu->mm_name.'</option>';
                            
                        }else{
                            echo '<option value="'.$row_main_menu->mm_id.'">'.$row_main_menu->mm_name.'</option>';
                        }
                    }
                ?>
            </select>
            <form action="" id="form_search" method="get">
                <input type="hidden" name="parent_id" value="<?= @$_GET['parent_id'] ?>">
            </form>
        </div>
        <div class="tools"> </div>
    </div>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info">
                <thead>
                    <tr role="row">
                        <th>N&deg; #</th>
                        <th class="text-center">Main Menu</th>
                        <th class="text-center">Permission on Module</th>
                        <th class="text-center">View <i style="border-radius: 0px;" class="btn btn-xs btn-default fa fa-tasks"></th>
                        <th class="text-center">Add <i style="border-radius: 0px;" class="btn btn-xs btn-primary fa fa-plus"></i></th>
                        <th class="text-center">Edit <i style="border-radius: 0px;" class="btn btn-xs btn-warning fa fa-edit"></i></th>
                        <th class="text-center">Delete <i style="border-radius: 0px;" class="btn btn-xs btn-danger fa fa-trash"></i></th>
                        <?php if(@$_GET['parent_id'] == ""){ ?>
                          <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        if(@$_GET['txt_main_menu'] != ""){
                            $v_permission = @$_GET['txt_main_menu'];
                            $get_data = $connect->query("SELECT * FROM tbl_left_menu AS A 
                                LEFT JOIN tbl_main_menu AS B ON B.mm_id=A.lm_main_menu 
                                WHERE A.lm_main_menu='$v_permission' 
                                ORDER BY B.mm_index_order ASC,A.lm_index_order ASC");
                        }else{
                            $get_data = $connect->query("SELECT * FROM tbl_left_menu AS A 
                                LEFT JOIN tbl_main_menu AS B ON B.mm_id=A.lm_main_menu 
                                ORDER BY B.mm_index_order ASC,A.lm_index_order ASC");
                        }
                        $no = 0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            $v_position = @$_GET['parent_id'];
                            echo '<tr data-position="'.$v_position.'" data-module="'.$row->lm_id.'">';
                                echo "<td>".(++$no)."</td>";
                                echo '<th>'.$row->mm_name.'</th>';
                                echo '<td>'.$row->lm_name.'</td>';
                                if(@$_GET['parent_id'] != ""){
                                    $get_permission = $connect->query("SELECT * FROM tbl_permission WHERE p_position='$v_position' AND p_module=".$row->lm_id);
                                    if(mysqli_num_rows($get_permission)){
                                        $row_permission = mysqli_fetch_object($get_permission);
                                        echo '<td class="text-center"><label class="switch"> <input data-parent-id='.$row->lm_id.' type="checkbox"  '.(($row_permission->p_view)?('checked'):('')).'> <span class="slider"></span> </label></td>';
                                        echo '<td class="text-center"><label class="switch"> <input data-parent-id='.$row->lm_id.' type="checkbox"  '.(($row_permission->p_add)?('checked'):('')).'> <span class="slider"></span> </label></td>';
                                        echo '<td class="text-center"><label class="switch"> <input data-parent-id='.$row->lm_id.' type="checkbox"  '.(($row_permission->p_edit)?('checked'):('')).'> <span class="slider"></span> </label></td>';
                                        echo '<td class="text-center"><label class="switch"> <input data-parent-id='.$row->lm_id.' type="checkbox"  '.(($row_permission->p_delete)?('checked'):('')).'> <span class="slider"></span> </label></td>';
                                    }else{                          
                                        echo '<td class="text-center"><label class="switch"> <input data-parent-id='.$row->lm_id.' type="checkbox"> <span class="slider"></span> </label></td>';
                                        echo '<td class="text-center"><label class="switch"> <input data-parent-id='.$row->lm_id.' type="checkbox"> <span class="slider"></span> </label></td>';
                                        echo '<td class="text-center"><label class="switch"> <input data-parent-id='.$row->lm_id.' type="checkbox"> <span class="slider"></span> </label></td>';
                                        echo '<td class="text-center"><label class="switch"> <input data-parent-id='.$row->lm_id.' type="checkbox"> <span class="slider"></span> </label></td>';
                                    }
                                }else{
                                    echo '<td class="text-center">--</td>';
                                    echo '<td class="text-center">--</td>';
                                    echo '<td class="text-center">--</td>';
                                    echo '<td class="text-center">--</td>';
                                }
                                if(@$_GET['parent_id'] == ""){
                                  echo '<td class="text-center">';
                                      echo button_edit($row->lm_id);
                                      echo button_delete($row->lm_id);
                                  echo '</td>';
                                }
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
  $('input[type="checkbox"]').change(function(){
    v_view = $(this).parents('tr').find('td').eq(2).find('input').prop('checked');
    v_add = $(this).parents('tr').find('td').eq(3).find('input').prop('checked');
    v_edit = $(this).parents('tr').find('td').eq(4).find('input').prop('checked');
    v_delete = $(this).parents('tr').find('td').eq(5).find('input').prop('checked');

    v_position = $(this).parents('tr').attr('data-position');
    v_module = $(this).parents('tr').attr('data-module');
    $.ajax({url: "ajx_set_permission.php?m="+v_module+"&p="+v_position+"&v="+v_view+"&a="+v_add+"&e="+v_edit+"&d="+v_delete, success: function(result){ 
      //alert(result); 
    }});
  });
</script>
<?php include_once '../layout/footer.php' ?>
<div class="modal fade" id="modal_add">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add New Module</h4>
      </div>
      <div class="modal-body">
        <form action="" method="POST" role="form" id="form_add_module">
          <div class="row">
            <div class="col-xs-6">
              <div class="form-group">
                <label for="">Module Name</label>
                <input name="txt_module_name" type="text" class="form-control" placeholder="module name" required="">
              </div>
            </div>
            <div class="col-xs-6">
              <div class="form-group">
                <label for="">Main Menu</label>
                <select name="txt_main_menu" class="form-control" required="">
                  <option value="">==choose Main Menu==</option>
                  <?php 
                      $get_main_menu = $connect->query("SELECT * FROM tbl_main_menu ORDER BY mm_index_order ASC");
                      while ($row_main_menu = mysqli_fetch_object($get_main_menu)) {
                          if($row_main_menu->mm_id == @$_GET['txt_main_menu']){
                              echo '<option SELECTED value="'.$row_main_menu->mm_id.'">'.$row_main_menu->mm_name.'</option>';
                              
                          }else{
                              echo '<option value="'.$row_main_menu->mm_id.'">'.$row_main_menu->mm_name.'</option>';
                          }
                      }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-xs-6">
              <label for="">Directory :</label>
              <input type="text" name="txt_dir" id="input" class="form-control">
            </div>
            <div class="col-xs-6">
              <label for="">Index :</label>
              <input type="text" name="txt_index" id="input" class="form-control">
            </div>
            <div class="col-xs-6">
              <div class="form-group">
                <label>Status <span style="color: red;">*</span></label>
                <select class="form-control" name="txt_status" required="required">
                    <?php 
                        $status = $connect->query("SELECT * FROM tbl_user_status ORDER BY us_id ASC");
                        while ($row_status = mysqli_fetch_object($status)) {
                            echo '<option value="'.$row_status->us_id.'">'.$row_status->us_name.'</option>';
                        }
                     ?>
                </select><span class="help-block help-block-error"></span>
              </div>
            </div>
          </div>        

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="btn_save" form="form_add_module" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
