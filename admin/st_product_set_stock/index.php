<?php 
    $menu_active =140;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
    if(isset($_POST['txt_date_start'])&&isset($_POST['txt_date_end'])){
        $v_date_start=$_POST['txt_date_start'];
        $v_date_end=$_POST['txt_date_end'];
        $condition="stpset_date_record BETWEEN '$v_date_start' AND '$v_date_end' ";
    }
    else{
        $condition="DATE_FORMAT(stpset_date_record,'%Y-%m')='".date('Y-m')."'";
    }

    $sql = "SELECT A.*, B.*,SUM(C.qty) AS totalQty FROM tbl_st_product_set AS A LEFT JOIN tbl_employee AS B ON A.stpset_employee=B.emp_id LEFT JOIN tbl_st_product_set_detail AS C ON B.emp_id=C.stpset_detail_id WHERE stpset_date_record BETWEEN '".$v_date_start."' AND '".$v_date_end."'";
    // $sql="SELECT 
    //         A.*,C.stemp_name,
    //         (
    //             SELECT 
    //             COUNT(*) 
    //             FROM tbl_st_product_set_detail A1
    //             WHERE A1.stpset_detail_id=A.stpset_id
    //         ) AS count_pro
    //         FROM tbl_st_product_set AS A 
    //         LEFT JOIN tbl_st_product_set_detail AS B ON A.stpset_id=B.stpset_detail_id
    //         LEFT JOIN tbl_employee AS C ON A.stpset_employee=C.stemp_id
    //         WHERE 1=1 AND {$condition}
    //         GROUP BY A.stpset_id";
    $get_data=$connect->query($sql);
 ?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Product Set Stock</h2>
        </div>
    </div>
    <br>
    <div class="row">
        <form action="<?= $_SERVER['PHP_SELF']?>" method="post" id="form">
            <div class="col-sm-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input autocomplete="off" onchange="this.form.submit()" name="txt_date_start" value="<?= @$_POST['txt_date_start'] ?>" type="text" class="form-control" placeholder="Date From ....">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input autocomplete="off" onchange="this.form.submit()" name="txt_date_end" value="<?= @$_POST['txt_date_end'] ?>" type="text" class="form-control" placeholder="Date To">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="caption font-dark" style="display: inline-block;">
                    <a href="index.php" id="sample_editable_1_new" class="btn btn-danger"><i class="fa fa-undo"></i> Clear</a>
                    <a href="add.php" id="sample_editable_1_new" class="btn green"> Create Item
                        <i class="fa fa-list"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_2" role="grid" aria-describedby="sample_1_info">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Date Record</th>
                        <th>Item KH</th>
                        <th>Item VN</th>
                        <th class="select-filter">Employee</th>
                        <th>Count Product</th>
                        <th>Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->stpset_date_record.'</td>';
                                echo '<td>'.$row->stpset_name_kh.'</td>';
                                echo '<td>'.$row->stpset_name_vn.'</td>';
                                echo '<td>'.$row->emp_name.'</td>';
                                echo '<td>'.$row->totalQty.'</td>';
                                echo '<td>'.$row->stpset_note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a onclick="showInfo('.$row->stpset_id.')" data-toggle="modal" href="#modal" class="btn btn-xs btn-info" title="detail"><i class=""> Detail </i></a> ';
                                    echo '<a href="edit.php?edit_id='.$row->stpset_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-pencil"></i></a> ';
                                   echo '<a onclick="deleteRecord('.$row->stpset_id.')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <th>Item KH</th>
                        <th>Item VN</th>
                        <td></td>
                        <th>Count Product</th>
                        <th>Note</th>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?php include_once '../layout/footer.php' ?>
<script type="text/javascript">
    function showInfo(e){
        document.getElementById('result_modal').src = 'more_info.php?parent='+e;
    }
</script>
<div class="modal fade" id="modal">
    <div class="modal-dialog" style="border: 1px solid darkred; width: 70%;">
        <iframe id="result_modal" frameborder="0" style="height: 600px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
