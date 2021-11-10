<?php  
    $menu_active =10;
    $left_menu =4;
    $layout_title = "Welcome to User Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once 'permission.php';
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

    .menu_title{ background: #aaa!important; }
    .menu_search{background: :#61EC71!important;}
    .menu_title > td:first-child ~ td ~ td ~ td *{ visibility: hidden; }

    /*.menu_search > td:first-child ~ td ~ td ~ td *{ visibility: hidden; }*/
</style>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-user fa-fw"></i>User Permission (Module)<?= @$_GET['txt_main_menu'] ?></h2>
        </div>
    </div>

    <br>
    <br>
    <div class="portlet-title">
        <div class="caption font-dark">
            <a href="index.php" class="btn red"> <i class="fa fa-arrow-left"></i> Back</a>
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
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row">
                        <th>N&deg; #</th>
                        <th class="text-center">Main Menu</th>
                        <th class="text-center">Permission on Module</th>
                        <th class="text-center">View 
                          <i style="border-radius: 0px;" class="btn btn-xs btn-default fa fa-tasks"></i>
                          <input type="checkbox" name="check_all_view" onchange="change_view(this);" class="make-switch" id="test" data-size="mini">
                        </th>
                        <th class="text-center">Add 
                          <i style="border-radius: 0px;" class="btn btn-xs btn-primary fa fa-plus"></i>
                          <input type="checkbox" name="check_all_view" onchange="change_add(this);" class="make-switch" id="test" data-size="mini">
                        </th>
                        <th class="text-center">Edit 
                          <i style="border-radius: 0px;" class="btn btn-xs btn-warning fa fa-edit"></i>
                          <input type="checkbox" name="check_all_view" onchange="change_edit(this);" class="make-switch" id="test" data-size="mini">
                        </th>
                        <th class="text-center">Delete 
                          <i style="border-radius: 0px;" class="btn btn-xs btn-danger fa fa-trash"></i>
                          <input type="checkbox" name="check_all_view" onchange="change_delete(this);" class="make-switch" id="test" data-size="mini">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        if(@$_GET['txt_main_menu'] != ""){
                            $v_permission = @$_GET['txt_main_menu'];
                            $get_data = $connect->query("SELECT * FROM tbl_left_menu AS A 
                                LEFT JOIN tbl_main_menu AS B ON B.mm_id=A.lm_main_menu 
                                WHERE A.lm_main_menu='$v_permission' AND (A.lm_status='1' OR A.lm_status='2' OR A.lm_status='3' OR A.lm_status='4')
                                ORDER BY B.mm_index_order ASC,A.lm_index_order ASC");
                        }else{
                            $get_data = $connect->query("SELECT * FROM tbl_left_menu AS A 
                                LEFT JOIN tbl_main_menu AS B ON B.mm_id=A.lm_main_menu 
                                WHERE (A.lm_status='1' OR A.lm_status='2' OR A.lm_status='3' OR A.lm_status='4')
                                ORDER BY B.mm_index_order ASC,A.lm_index_order ASC");
                        }
                        $no = 0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            $v_position = @$_GET['parent_id'];
                            if($row->lm_status==2||$row->lm_status==3||$row->lm_status==4){
                              echo '<tr class="menu_title" data-position="'.$v_position.'" data-module="'.$row->lm_id.'">';
                            }
                            else if($row->lm_status==1){
                              echo '<tr data-position="'.$v_position.'" data-module="'.$row->lm_id.'">';
                            }
                                echo "<td>".(++$no)."</td>";
                                echo '<th>'.$row->mm_name.'</th>';
                                echo '<td>'.$row->lm_name.'</td>';
                                if(@$_GET['parent_id'] !=""){
                                    $get_permission = $connect->query("SELECT * FROM tbl_permission WHERE p_position='$v_position' AND p_module=".$row->lm_id);
                                    if(mysqli_num_rows($get_permission)){
                                        $row_permission = mysqli_fetch_object($get_permission);
                                        echo '<td class="text-center"> <label class="switch"><input data-parent-id='.$row->lm_id.' type="checkbox"  '.(($row_permission->p_view)?('checked'):('')).'> <span class="slider"></span> </label></td>';
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
      // alert(result);
    }});
    myAlertInfo("Change Completed !");
  });
  function change_view (args) {
    var check=$(args).prop('checked');
    var arr=new Array();
    if(check){
      $('td:nth-child(4)').find('label>input').prop("checked", !$(this).prop("checked"));
      $('td:nth-child(4)').find('label>input').each(function () {
        var v_view=$(this).prop('checked');
        var v_add=$(this).parents('tr').find('td').eq(3).find('input').prop('checked');
        var v_edit = $(this).parents('tr').find('td').eq(4).find('input').prop('checked');
        var v_delete = $(this).parents('tr').find('td').eq(5).find('input').prop('checked');

        var v_position = $(this).parents('tr').attr('data-position');
        var v_module = $(this).parents('tr').attr('data-module');
        $.ajax({url: "ajx_set_permission.php?m="+v_module+"&p="+v_position+"&v="+v_view+"&a="+v_add+"&e="+v_edit+"&d="+v_delete, success: function(result){ 

        }});
      });
    }
    else{
      $('td:nth-child(4)').find('label>input').removeAttr('checked');
      $('td:nth-child(4)').find('label>input').each(function () {
        var v_view=$(this).prop('checked');
        var v_add=$(this).parents('tr').find('td').eq(3).find('input').prop('checked');
        var v_edit = $(this).parents('tr').find('td').eq(4).find('input').prop('checked');
        var v_delete = $(this).parents('tr').find('td').eq(5).find('input').prop('checked');

        var v_position = $(this).parents('tr').attr('data-position');
        var v_module = $(this).parents('tr').attr('data-module');
        $.ajax({url: "ajx_set_permission.php?m="+v_module+"&p="+v_position+"&v="+v_view+"&a="+v_add+"&e="+v_edit+"&d="+v_delete, success: function(result){ 

        }});
      });
    }
    myAlertInfo("Change Completed !");
  }

  function change_add (args) {
    var check=$(args).prop('checked');
    var arr=new Array();
    if(check){
      $('td:nth-child(5)').find('label>input').prop("checked", !$(this).prop("checked"));
      $('td:nth-child(5)').find('label>input').each(function () {
        var v_view=$(this).parents('tr').find('td').eq(2).find('input').prop('checked');
        var v_add=$(this).prop('checked');
        var v_edit = $(this).parents('tr').find('td').eq(4).find('input').prop('checked');
        var v_delete = $(this).parents('tr').find('td').eq(5).find('input').prop('checked');

        var v_position = $(this).parents('tr').attr('data-position');
        var v_module = $(this).parents('tr').attr('data-module');
        $.ajax({url: "ajx_set_permission.php?m="+v_module+"&p="+v_position+"&v="+v_view+"&a="+v_add+"&e="+v_edit+"&d="+v_delete, success: function(result){ 
          // alert(result);
        }});
      });
    }
    else{
      $('td:nth-child(5)').find('label>input').removeAttr('checked');
      $('td:nth-child(5)').find('label>input').each(function () {
        v_view=$(this).parents('tr').find('td').eq(2).find('input').prop('checked');
        v_add=$(this).prop('checked');
        v_edit = $(this).parents('tr').find('td').eq(4).find('input').prop('checked');
        v_delete = $(this).parents('tr').find('td').eq(5).find('input').prop('checked');

        v_position = $(this).parents('tr').attr('data-position');
        v_module = $(this).parents('tr').attr('data-module');
        $.ajax({url: "ajx_set_permission.php?m="+v_module+"&p="+v_position+"&v="+v_view+"&a="+v_add+"&e="+v_edit+"&d="+v_delete, success: function(result){ 
          // alert(result);
          
        }});
      });
    }
    myAlertInfo("Change Completed !");
  }
  function change_edit (args) {
    var check=$(args).prop('checked');
    var arr=new Array();
    if(check){
      $('td:nth-child(6)').find('label>input').prop("checked", !$(this).prop("checked"));
      $('td:nth-child(6)').find('label>input').each(function () {
        var v_view=$(this).parents('tr').find('td').eq(2).find('input').prop('checked');
        var  v_add= $(this).parents('tr').find('td').eq(3).find('input').prop('checked');
        var v_edit=$(this).prop('checked');
        var v_delete = $(this).parents('tr').find('td').eq(5).find('input').prop('checked');

        var v_position = $(this).parents('tr').attr('data-position');
        var v_module = $(this).parents('tr').attr('data-module');
        $.ajax({url: "ajx_set_permission.php?m="+v_module+"&p="+v_position+"&v="+v_view+"&a="+v_add+"&e="+v_edit+"&d="+v_delete, success: function(result){ 
        }});
      });
    }
    else{
      $('td:nth-child(6)').find('label>input').removeAttr('checked');
      $('td:nth-child(6)').find('label>input').each(function () {
        var v_view=$(this).parents('tr').find('td').eq(2).find('input').prop('checked');
        var  v_add= $(this).parents('tr').find('td').eq(3).find('input').prop('checked');
        var v_edit=$(this).prop('checked');
        var v_delete = $(this).parents('tr').find('td').eq(5).find('input').prop('checked');

        var v_position = $(this).parents('tr').attr('data-position');
        var v_module = $(this).parents('tr').attr('data-module');
        $.ajax({url: "ajx_set_permission.php?m="+v_module+"&p="+v_position+"&v="+v_view+"&a="+v_add+"&e="+v_edit+"&d="+v_delete, success: function(result){ 
        }});
      });
    }
    myAlertInfo("Change Completed !");
  }
  function change_delete (args) {
    var check=$(args).prop('checked');
    var arr=new Array();
    if(check){
      $('td:nth-child(7)').find('label>input').prop("checked", !$(this).prop("checked"));
      $('td:nth-child(7)').find('label>input').each(function () {
       var v_view=$(this).parents('tr').find('td').eq(2).find('input').prop('checked');
        var  v_add= $(this).parents('tr').find('td').eq(3).find('input').prop('checked');
        var v_edit = $(this).parents('tr').find('td').eq(4).find('input').prop('checked');
        var v_delete=$(this).prop('checked');

        var v_position = $(this).parents('tr').attr('data-position');
        var v_module = $(this).parents('tr').attr('data-module');
        $.ajax({url: "ajx_set_permission.php?m="+v_module+"&p="+v_position+"&v="+v_view+"&a="+v_add+"&e="+v_edit+"&d="+v_delete, success: function(result){ 
        }});
      });
    }
    else{
      $('td:nth-child(7)').find('label>input').removeAttr('checked');
      $('td:nth-child(7)').find('label>input').each(function () {
        var v_view=$(this).parents('tr').find('td').eq(2).find('input').prop('checked');
        var v_add= $(this).parents('tr').find('td').eq(3).find('input').prop('checked');
        var v_edit = $(this).parents('tr').find('td').eq(4).find('input').prop('checked');
        var v_delete=$(this).prop('checked');

        var v_position = $(this).parents('tr').attr('data-position');
        var v_module = $(this).parents('tr').attr('data-module');
        $.ajax({url: "ajx_set_permission.php?m="+v_module+"&p="+v_position+"&v="+v_view+"&a="+v_add+"&e="+v_edit+"&d="+v_delete, success: function(result){ 
        }});
      });
    }
    myAlertInfo("Change Completed !");
  }
</script>

<?php include_once '../layout/footer.php' ?>
