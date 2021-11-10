<?php
if (isset($_POST['btn_search'])) {
    $v_date_s = @$_POST['txt_date_start'];
    $v_date_e = @$_POST['txt_date_end'];
    // echo $v_date_s.'fff'.$v_date_e;
    $v_sql = "SELECT A.*,
            length,
            width,
            height,
            date_format(date_record,'%d-%m-%Y') as date_ff,
            (length*width*height) as total_block,
            D.user_name, B.block_code, B.id as b_id, B.date_out, B.machine_id, 
            (select name from tbl_inv_location_list where id=B.location_id) as location_bb, 
            (select name from tbl_inv_floor_list where id=B.floor_id) as floor_cc, 
            (select name from tbl_inv_grade_type_list where id=B.grade_type_id) as grade_type_dd,
            (select name from tbl_inv_color_list where id=B.color_id) as color_ee,
            B.id AS detail_id,
            B.stock_out_status 
            FROM tbl_inv_1_stock_block_stone AS A 
            LEFT JOIN tbl_inv_1_stock_block_stone_detail AS B ON A.id=B.parent_id
            LEFT JOIN tbl_user AS D ON A.user_id=D.user_id
            LEFT JOIN tbl_inv_product_step_list AS F ON B.stock_out_status=F.id
            WHERE date_record BETWEEN'$v_date_s' AND '$v_date_e' and B.machine_id >'0'
            ORDER BY B.date_out
            ";
    $get_data = $connect->query($v_sql);
} else {
    $v_current_month = date('Y-m');
    $v_sql = "SELECT A.*,
            length,
            width,
            height,
            date_format(date_record,'%d-%m-%Y') as date_ff,
            (length*width*height) as total_block,
            D.user_name, B.block_code, B.id as b_id, B.date_out, B.machine_id,
            (select name from tbl_inv_location_list where id=B.location_id) as location_bb, 
            (select name from tbl_inv_floor_list where id=B.floor_id) as floor_cc, 
            (select name from tbl_inv_grade_type_list where id=B.grade_type_id) as grade_type_dd,
            (select name from tbl_inv_color_list where id=B.color_id) as color_ee,
            B.id AS detail_id,
            B.stock_out_status 
            FROM tbl_inv_1_stock_block_stone AS A 
            LEFT JOIN tbl_inv_1_stock_block_stone_detail AS B ON A.id=B.parent_id
            LEFT JOIN tbl_user AS D ON A.user_id=D.user_id
            LEFT JOIN tbl_inv_product_step_list AS F ON B.stock_out_status=F.id
            WHERE DATE_FORMAT(date_record,'%Y-%m')='$v_current_month' and B.machine_id >'0'
            ORDER BY B.date_out
            ";
    $get_data = $connect->query($v_sql);
    $v_old_amo = 0;
}
?>

<br>
<div class="row">
    <form action="index.php?action=1" method="POST">
        <div class="col-sm-2">
            <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                <input autocomplete="off" name="txt_date_start" value="<?= @$_POST['txt_date_start'] ?>" type="text" class="form-control" placeholder="Date From ....">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                <input autocomplete="off" name="txt_date_end" value="<?= @$_POST['txt_date_end'] ?>" type="text" class="form-control" placeholder="Date To">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="caption font-dark" style="display: inline-block;">
                <button type="submit" name="btn_search" id="sample_editable_1_new" class="btn blue btn-sm"> Search
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </form>
</div>
<br>
<div class="portlet-body">
    <div id="sample_1_wrapper" class="dataTables_wrapper">
        <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_1" role="grid" aria-describedby="sample_1_info">
            <thead>
                <tr role="row" class="text-center">
                    <th class="text-center">N&deg;</th>
                    <th class="text-center">Date Record</th>
                    <th class="text-center">Machine</th>
                    <th class="text-center">COLOR</th>
                    <th class="text-center">GRADE</th>
                    <th class="text-center">Code Block</th>
                    <th class="text-center">Length</th>
                    <th class="text-center">Width</th>
                    <th class="text-center">Height</th>
                    <th class="text-center">M3</th>
                    <th class="text-center">User Name</th>
                    <th style="min-width: 150px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;

                while ($row = mysqli_fetch_object($get_data)) {
                    echo '<tr>';
                    echo '<td class="text-center">' . (++$i) . '</td>';
                    echo '<td class="text-center">' . $row->date_out . '</td>';
                    echo '<td class="text-center">' . $row->machine_id . '</td>';
                    echo '<td class="text-center">' . $row->color_ee . '</td>';
                    echo '<td class="text-center">' . $row->grade_type_dd . '</td>';
                    echo '<td class="text-center">' . $row->block_code . '</td>';
                    echo '<td class="text-center">' . number_format($row->length, 2) . ' m</td>';
                    echo '<td class="text-center">' . number_format($row->width, 2) . ' m</td>';
                    echo '<td class="text-center">' . number_format($row->height, 2) . ' m</td>';
                    echo '<td class="text-center">' . number_format($row->total_block, 3) . ' M3 </td>';
                    echo '<td class="text-center">' . $row->user_name . '</td>';
                    echo '<td class="text-center">';

                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
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
    $('td:nth-child(11)').find('button').click(function () {
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
    $('td:nth-child(11) a').click(function () {
        $(this).parents('td').find('input').attr('type','text');
        $(this).parents('td').find('input').css('margin','0px 25px');
        $(this).parents('td').find('button').css('visibility','visible');
        $(this).css('display','none');
    });

</script>
<script type="text/javascript">
    function set_iframe_edit(i){
        document.getElementById('result_modal').src = 'edit.php?edit_id='+i;
    }
    $('#modal').on('hidden.bs.modal', function () {
        location.reload();
    });
    $(document).ready(function () {
    });
    $('td:nth-child(12)').find('button').click(function () {
        var v_id=$(this).parents('td').find('a').attr('data_id');
        var v_code=$(this).parents('td').find('input').val();
        var arr=new Array(v_id,v_code);
        $.ajax({url:'ajax_update_code1.php',type:'POST',data:'data='+arr,success:function (result) {
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
    $('td:nth-child(12) a').click(function () {
        $(this).parents('td').find('input').attr('type','text');
        $(this).parents('td').find('input').css('margin','0px 25px');
        $(this).parents('td').find('button').css('visibility','visible');
        $(this).css('display','none');
    });

</script>