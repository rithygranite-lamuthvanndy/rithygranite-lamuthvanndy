<?php
if (isset($_POST['btn_search'])) {
    $v_date_s = @$_POST['txt_date_start'];
    $v_date_e = @$_POST['txt_date_end'];
    // echo $v_date_s.'fff'.$v_date_e;
    $v_sql = "SELECT A.*,B.length,B.width,B.height,B.sheet,
            C.name AS counter_name,B.ns_date_out,B.ns_make_to,B.id as b_id,
            D.user_name,
            (select name from tbl_inv_grade_type_list where id=B.grade_type_id) as grade_type_dd,
            (select name from tbl_inv_color_list where id=B.color_id) as color_ee,
            (select block_code from tbl_inv_1_stock_block_stone_detail where id=B.block_code_id) as block_code_ff,
            (B.length*B.width*B.sheet) as total_m2
            FROM  tbl_inv_2_stock_slap_no_polish AS A 
            LEFT JOIN tbl_inv_2_stock_slap_no_polish_detail AS B ON A.id=B.parent_id
            LEFT JOIN tbl_inv_counter_list AS C ON A.counter_id=C.id
            LEFT JOIN tbl_user AS D ON A.user_id=D.user_id
            WHERE date_record BETWEEN'$v_date_s' AND '$v_date_e'
            ";
    $get_data = $connect->query($v_sql);
} else {
    $v_current_month = date('Y-m');
    $v_sql = "SELECT A.*,B.length,B.width,B.height,B.sheet,
            C.name AS counter_name,B.ns_date_out,B.ns_make_to,B.id as b_id,
            D.user_name,
            (select name from tbl_inv_grade_type_list where id=B.grade_type_id) as grade_type_dd,
            (select name from tbl_inv_color_list where id=B.color_id) as color_ee,
            (select block_code from tbl_inv_1_stock_block_stone_detail where id=B.block_code_id) as block_code_ff,
            (B.length*B.width*B.sheet) as total_m2
            FROM  tbl_inv_2_stock_slap_no_polish AS A 
            LEFT JOIN tbl_inv_2_stock_slap_no_polish_detail AS B ON A.id=B.parent_id
            LEFT JOIN tbl_inv_counter_list AS C ON A.counter_id=C.id
            LEFT JOIN tbl_user AS D ON A.user_id=D.user_id
            WHERE DATE_FORMAT(date_record,'%Y-%m')='$v_current_month' 
            ";
    $get_data = $connect->query($v_sql);
    $v_old_amo = 0;
}
?>
<div class="">
    <div class="caption font-dark">
        <?php
        $sql = $connect->query("SELECT * FROM tbl_inv_1_stock_block_stone WHERE date_record='$now'");
        // if(!mysqli_num_rows($sql)){
        echo '<a href="add.php" id="sample_editable_1_new" class="btn green"> Add New
                    <i class="fa fa-plus"></i>
                </a>';
        // }
        ?>
    </div>
</div>
<br>
<div class="row">
    <form action="index.php?action=1" method="post">
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
        <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
            <thead>
                <tr role="row" class="text-center">
                    <th>N&deg;</th>
                    <th>Date Record</th>
                    <th>Counter</th>
                    <th>Color</th>
                    <th>Grade</th>
                    <th>Block Code</th>
                    <th>Length</th>
                    <th>Width</th>
                    <th>Height</th>
                    <th>Slab</th>
                    <th>M2</th>
                    <th>Date Out</th>
                    <th>Make Type</th>
                    <th style="min-width: 150px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                while ($row = mysqli_fetch_object($get_data)) {

                    echo '<tr>';
                    echo '<td class="text-center">' . (++$i) . '</td>';
                    echo '<td class="text-center">' . $row->date_record . '</td>';
                    echo '<td class="text-center">' . $row->counter_name . '</td>';
                    echo '<td class="text-center">' . $row->color_ee . '</td>';
                    echo '<td class="text-center">' . $row->grade_type_dd . '</td>';
                    echo '<td class="text-center">' . $row->np_num_block . '</td>';
                    echo '<td class="text-center">' . number_format($row->length, 2) . '</td>';
                    echo '<td class="text-center">' . number_format($row->width, 2) . '</td>';
                    echo '<td class="text-center">' . number_format($row->height, 2) . '</td>';
                    echo '<td class="text-center">' . $row->sheet . '</td>';
                    echo '<td class="text-center">' . number_format($row->total_m2, 2) . '</td>';

                    echo '<td class="text-center">
                        <p>'.$row->ns_date_out.' <a data_id='.$row->b_id.' class="btn btn-xs green" title="Edit"><i class="fa fa-pencil"></i></a></p>
                            <div style="display: flex;">
                            <input type="hidden" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control input-small" required value="'.$row->ns_date_out.'">
                            <button style="visibility: hidden;" type="button" class="btn btn-primary btn-xs"><i class="fa fa-save"></i></button>
                            <div>
                    </td>';

                    echo '<td class="text-center">
                        <p>'.$row->ns_make_to.' <a data_id='.$row->b_id.' class="btn btn-xs green" title="Stock Out Type"><i class="fa fa-pencil"></i></a></p>
                            <div style="display: flex;">
                            <input type="hidden" required class="form-control input-small" value="'.$row->ns_make_to.'">
                            <button style="visibility: hidden;" type="button" class="btn btn-primary btn-xs"><i class="fa fa-save"></i></button>                                    
                            <div>
                    </td>';
                    echo '<td class="text-center">';
                    echo '<a href="#modal" onclick="set_iframe_more_info_in(' . $row->b_id . ')" data-toggle="modal" class="btn btn-xs btn-info" title="More Info Stock In">More Info Stock In</a> ';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
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
    $('td:nth-child(12)').find('button').click(function () {
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
        myAlertInfo("Update Date out Compelted");
    });
    $('td:nth-child(12) a').click(function () {
        $(this).parents('td').find('input').attr('type','text');
        $(this).parents('td').find('input').css('margin','0px 25px');
        $(this).parents('td').find('button').css('visibility','visible');
        $(this).css('display','none');
    });


    $('td:nth-child(13)').find('button').click(function () {
        var v_id1=$(this).parents('td').find('a').attr('data_id');
        var v_code1=$(this).parents('td').find('input').val();
        var arr=new Array(v_id1,v_code1);
        $.ajax({url:'ajax_update_code1.php',type:'POST',data:'data1='+arr,success:function (result) {
            if(!(result).trim()){
                alert("Error");
                return false;
            }
        }});
        $(this).parents('td').find('p').html(v_code1);
        $(this).prev().hide();
        $(this).hide();
        // $(this).parents('td').find('p >a').css('display','block');
        myAlertInfo("Update Make Type Compelted");
    });
    $('td:nth-child(13) a').click(function () {
        $(this).parents('td').find('input').attr('type','text');
        $(this).parents('td').find('input').css('margin','0px 25px');
        $(this).parents('td').find('button').css('visibility','visible');
        $(this).css('display','none');
    });

</script>