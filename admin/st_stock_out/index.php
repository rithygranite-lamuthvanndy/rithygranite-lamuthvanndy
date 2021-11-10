<?php 
    $menu_active =140;
    $left_active =0;
    $layout_title = "View Stock Out";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
    $sql="SELECT
        A.*,B.empl_emloyee_en,SUM(C.out_qty*C.out_price) AS total_amo
        FROM tbl_st_stock_out AS A 
        LEFT JOIN tbl_hr_employee_list AS B ON A.stsout_emp_id=B.empl_id
        LEFT JOIN tbl_st_stock_out_detail AS C ON A.stsout_id=C.stsout_id
        WHERE 1=1 ";
    if(isset($_POST['txt_date_start'])&&isset($_POST['txt_date_end'])){
        $v_date_start=$_POST['txt_date_start'];
        $v_date_end=$_POST['txt_date_end'];
        $condition="AND stsout_date_out BETWEEN '$v_date_start' AND '$v_date_end' ";
    }
    else{
        $condition="AND MONTH(stsout_date_out)=MONTH(CURRENT_DATE()) ";
    }
    $sql.=$condition." GROUP BY A.stsout_id";
    // echo $sql;
    $get_data=$connect->query($sql);
 ?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-truck"></i> Stock Out</h2>
        </div>
    </div>
    <br>
    <div class="row">
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" id="form">
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
                    <a href="add.php" id="sample_editable_1_new" class="btn green"><i class="fa fa-plus-circle"></i> Add Stock Out</a>
                </div>
            </div>
        </form>
        <div class="caption font-dark">
        </div>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_1" role="grid" aria-describedby="sample_1_info">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Date Stock Out</th>
                        <th>Letter Out N&deg;</th>
                        <th>employee</th>
                        <th>Total Amount</th>
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
                                echo '<td>'.$row->stsout_date_out.'</td>';
                                echo '<td>'.$row->stsout_letter_no.'</td>';
                                echo '<td>'.$row->empl_emloyee_en.'</td>';
                                echo '<td>'.number_format($row->total_amo,2).'</td>';
                                echo '<td>'.$row->stsout_note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a onclick="showInfo('.$row->stsout_id.')" data-toggle="modal" href="#modal" class="btn btn-xs btn-info" title="detail"><i class=""> Detail </i></a> ';
                                    echo '<a href="edit.php?edit_id='.$row->stsout_id.'" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-edit"></i></a> ';
                                   echo '<a onclick="deleteRecord('.$row->stsout_id.')" class="btn btn-xs btn-danger" title="Delete"><i class="fa fa-trash"></i></a> ';

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
<script type="text/javascript">
    function showInfo(e){
        document.getElementById('result_modal').src = 'more_info.php?parent='+e;
    }
</script>
<div class="modal fade" id="modal">
    <div class="modal-dialog" style="border: 1px solid darkred; width: 80%;">
        <iframe id="result_modal" frameborder="0" style="height: 600px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>