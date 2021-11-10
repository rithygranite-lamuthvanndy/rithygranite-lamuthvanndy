<?php 
    $menu_active =12;
    $left_menu_active =2;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
    if(@$_GET['cbo_search_top_menu']){
        $v_search_top_menu=$_GET['cbo_search_top_menu'];
        $get_data = $connect->query("SELECT 
                               A.*,mm_name
                            FROM tbl_left_menu AS A 
                            LEFT JOIN tbl_main_menu AS B ON A.lm_main_menu=B.mm_id
                            WHERE lm_main_menu='$v_search_top_menu'
                            ORDER BY lm_main_menu");
    }
    else{
        $get_data = $connect->query("SELECT 
                               A.*,mm_name
                            FROM tbl_left_menu AS A 
                            LEFT JOIN tbl_main_menu AS B ON A.lm_main_menu=B.mm_id
                            ORDER BY lm_main_menu");
    }
 ?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Left Menu List</h2>
        </div>
    </div>
    <br>
    <div>
        <form action="#" method="GET">
            <div class="row">
                <div class="col-xs-1">
                    <div class="caption font-dark">
                        <a href="add.php" id="sample_editable_1_new" class="btn green"> Add New
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    <select onchange="this.form.submit();" name="cbo_search_top_menu" id="inputCbo_search_top_menu" class="form-control myselect2">
                        <option value="">=== Select Top Menu ===</option>
                        <?php 
                            $v_select=$connect->query("SELECT * FROM  tbl_main_menu ORDER BY mm_index_order");
                            while ($row_top_menu=mysqli_fetch_object($v_select)) {
                                if($row_top_menu->mm_id==@$_GET['cbo_search_top_menu'])
                                    echo '<option selected value="'.$row_top_menu->mm_id.'">'.$row_top_menu->mm_name.'</option>';
                                else
                                    echo '<option value="'.$row_top_menu->mm_id.'">'.$row_top_menu->mm_name.'</option>';
                            }
                         ?>
                    </select>
                </div>
            </div>
        </form>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Top Menu Name</th>
                        <th>Left Menu Name</th>
                        <th>Left Meu Directory</th>
                        <th>Left Menu Index</th>
                        <th>Left Menu Type</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->mm_name.'</td>';
                                echo '<td>'.$row->lm_name.'</td>';
                                echo '<td>'.$row->lm_directory.'</td>';
                                echo '<td class="text-center">
                                        <p>'.$row->lm_index_order.' <a data_id='.$row->lm_id.' class="btn btn-xs green" title="Edit"><i class="fa fa-pencil"></i></a></p>
                                         <div style="display: flex;">
                                            <input type="hidden" required class="form-control input-small" value="'.$row->lm_index_order.'">
                                            <button style="visibility: hidden;" type="button" class="btn btn-primary btn-xs"><i class="fa fa-save"></i></button>
                                        <div>
                                </td>';

                                echo '<td>';
                                    if($row->lm_status==1)
                                        echo 'Link';
                                    else if($row->lm_status==2)
                                        echo 'Tittle';
                                    else if($row->lm_status==3)
                                        echo 'Drop Down';
                                echo '</td>';
                                echo '<td class="text-center">';
                                    echo '<a onclick="set_iframe_edit('.$row->lm_id.')" href="#modal" data-toggle="modal" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   echo '<a onclick="deleteRecord('.$row->lm_id.')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

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
<!-- <script src="../../assets/global/plugins/jquery.min.js" type="text/javascript"></script> -->
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg" style="width: 50%;">
        <div class="modal-content">
            <div class="modal-body">
                <iframe id="result_modal" src="" width="100%" style="min-height: 600px; resize: vertical;" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>
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