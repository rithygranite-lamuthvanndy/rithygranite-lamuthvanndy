<?php 
    $menu_active =12;
    $left_menu_active=3;
    $layout_title = "View Top Menu";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    if(@(@$_GET['view']=='iframe')){
        include_once '../layout/header_frame.php';
    }
    else{
        include_once '../layout/header.php';
    }
?>
<?php 
    if(@$_GET['cbo_search_top_menu']){
        $v_search_top_menu=$_GET['cbo_search_top_menu'];
        $get_data = $connect->query("SELECT 
                               A.*,U.*,M.*
                            FROM tbl_menu_premission AS A
                            left join tbl_user as U on U.user_id=A.mp_user_id
                            left join tbl_main_menu as M on M.mm_id=A.mp_menu_id
                            where U.user_id='$v_search_top_menu' 
                            ORDER BY mp_id ASC");
    }
    else{
        $get_data = $connect->query("SELECT 
                               A.*, U.*,M.*
                            FROM tbl_premission AS A
                            left join tbl_user as U on U.user_id=M.mp_user_id
                            left join tbl_main_menu as M on M.mm_id=A.mp_menu_id
                            ORDER BY mp_id ASC");
    }
 ?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> User Premission Menu</h2>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-xs-1">
            <a href="add.php?view=<?= @$_GET['view'] ?>" id="sample_editable_1_new" class="btn green"> Add New
                <i class="fa fa-plus"></i>
            </a>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <select onchange="this.form.submit();" name="cbo_search_top_menu" id="inputCbo_search_top_menu" class="form-control myselect2">
                        <option value="">=== Select User Name ===</option>
                        <?php 
                            $v_select=$connect->query("SELECT * FROM  tbl_user ORDER BY user_name");
                            while ($row_top_menu=mysqli_fetch_object($v_select)) {
                                if($row_top_menu->user_id==@$_GET['cbo_search_top_menu'])
                                    echo '<option selected value="'.$row_top_menu->user_id.'">'.$row_top_menu->user_name.'</option>';
                                else
                                    echo '<option value="'.$row_top_menu->user_id.'">'.$row_top_menu->user_name.'</option>';
                            }
                         ?>
            </select>
        </div>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>User Name</th>
                        <th>Menu Premission</th>
                        <th>Action Premssion</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->user_name.'</td>';
                                echo '<td>'.$row->mm_name.'</td>';
                                echo '<td>'.$row->mp_active.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->mp_id.'&view='.@$_GET['view'].'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   echo '<a onclick="deleteRecord('.$row->mp_id.')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php 
     if(@$_GET['view']=='iframe'){
        include_once '../layout/footer_frame.php';
    }
    else{
        include_once '../layout/footer.php';
    }
 ?>
 <script type="text/javascript">
    function set_iframe_edit(i){
        document.getElementById('result_modal').src = 'edit.php?edit_id='+i;
    }
    $('#modal').on('hidden.bs.modal', function () {
        location.reload();
    });
    $(document).ready(function () {
    });
    $('td:nth-child(5)').find('button').click(function () {
        var v_id=$(this).parents('td').find('a').attr('data_id');
        var v_code=$(this).parents('td').find('input').val();
        var arr=new Array(v_id,v_code);
        $.ajax({url:'ajax_update_code.php',type:'POST',data:'data='+arr,success:function (result) {
            if(!(result).trim()){
                alert("Error");
                return false;
            }
        }});
        $(this).parents('td').find('p').html(v_code);
        $(this).prev().hide();
        $(this).hide();
        // $(this).parents('td').find('p >a').css('display','block');
        myAlertInfo("Update Left Menu Compelted");
    });
    $('td:nth-child(5) a').click(function () {
        $(this).parents('td').find('input').attr('type','text');
        $(this).parents('td').find('input').css('margin','0px 25px');
        $(this).parents('td').find('button').css('visibility','visible');
        $(this).css('display','none');
    });

</script>