<?php
    include_once '../st_operation/operation.php';
?>
<?php
if (isset($_POST['txt_date_start']) || isset($_POST['txt_date_end'])) {
    $v_date_start = $_POST['txt_date_start'];
    $v_date_end = $_POST['txt_date_end'];
} else {
    $v_date_start = date('Y-m-01');
    $v_date_end = date('Y-m-t');
}
$stml_select = "SELECT E.empl_emloyee_en,F.po_name, A.*, C.*, D.*,
                CASE
                    WHEN D.adj = 'It is very old' THEN 'Broken'
                    WHEN D.adj = 'Not see' THEN 'Loss'
                END AS adj
                FROM tbl_non_fixed_assign AS A
                LEFT JOIN tbl_non_fixed AS C ON C.id = A.non_fixed_id
                LEFT JOIN tbl_non_fixed_adj AS D ON D.assign_id=A.id
                LEFT JOIN tbl_hr_employee_list AS E ON A.assign_to=E.empl_id
                LEFT JOIN tbl_hr_position_list AS F ON F.po_id=E.empl_position
                WHERE A.assign_date IN (SELECT MAX(B.assign_date) FROM tbl_non_fixed_assign AS B GROUP BY B.non_fixed_id) AND C.acquired>='".$v_date_start."' AND C.acquired<='".$v_date_end."'
                ";
// echo $v_sql;
$query = $connect->query($stml_select);
$i=0;
$j=1;
$arr1 = [];
$a = [];

while($row = mysqli_fetch_object($query))
{
    // echo($row->locat);
    // echo("<br>");
    if(in_array($row->locat.'-'.$row->section, $a))
    {
        // array_push($a, $row->locat);
    }
    else
    {
        array_push($a, $row->locat.'-'.$row->section);
    }
    $arr1[] = $row;
}
?>
<style type="text/css">
    .mycustomtable tbody,
    .mycustomtable thead,
    .mycustomtable tfoot {
        white-space: nowrap;
    }

    .myqty {
        font-weight: bold;
    }

    .myprice {
        font-weight: bold;
        color: #FF0000;
        background-color: #F2F2F2;
    }

    .myavg {
        color: #39EB7C;
    }

    .myavg:before,
    .myprice:before {
        content: '$ ';
        padding-right: 5px;
    }
    .table th {
        
            background: #ffe0b2 !important;
            font-weight: bold !important;
            border: 1px solid white !important;
    }

    .box
    {
        width: 90%;
        height: 90%;
        background-color: white;
        position: fixed; top:50%;
        left: 50%; 
        transform:translate(-50%, -50%);
        z-index: 77;
        border: 1px solid black;
    }
</style>

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
                <a href="add_in.php" id="sample_editable_1_new" class="btn btn-primary">ADD new</a>
            </div>
            <input type="button" value="Export" id="btn_add" class="btn green">
            <input type="button" value="Delete" id="btn_add" class="btn green">
            <input type="button" value="Report" id="btn_add" class="btn green">
            <input type="button" value="Exit" id="btn_add" class="btn green">
            <!-- <div class="caption font-dark" style="display: inline-block;">
                <a href="index.php" id="sample_editable_1_new" class="btn btn-danger"><i class="fa fa-undo"></i> Clear</a>
            </div> -->
            <!-- <a target="_blank" href="print_summary.php?p_date_start=<?= (@$_POST['txt_date_start'] ? $_POST['txt_date_start'] : date('Y-m-d')) ?>&p_date_end=<?= (@$_POST['txt_date_end'] ? $_POST['txt_date_end'] : date('Y-m-d')) ?>" id="sample_editable_1_new" class="btn yellow">
                <i class="fa fa-print"></i> Print</a> -->
            <!-- <a target="_blank" href="export_excell.php?p_date_start=<?= (@$_POST['txt_date_start'] ? $_POST['txt_date_start'] : date('Y-m-d')) ?>&p_date_end=<?= (@$_POST['txt_date_end'] ? $_POST['txt_date_end'] : date('Y-m-d')) ?>" id="sample_editable_1_new" class="btn blue">
                <i class="fa fa-share"></i> Export</a> -->
                <!-- <a href="add_in.php" id="sample_editable_1_new" class="btn green"><i class="fa fa-plus-circle"></i> Add Stock In</a> -->
        </div>
    </form>
</div>
<br>

<div class="portlet-body">
    <div style="overflow-x:auto;">
        <table class="table table-striped table-bordered table-hover dataTable dtr-inline mycustomtable">
            <thead>
                <tr role="row" class="text-center" style="background-color: #ffe0b2;">
                    <th>N</th>
                    <th>Description</th>
                    <th>Model</th>
                    <th>Asset ID</th>
                    <th>Acquired Date</th>
                    <th>Condition</th>
                    <th>Cost</th>
                    <th>Assigned To</th>
                    <th>Adjustment</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i = 1;
                    foreach($a as $value)
                    {
                        $amount = 0;
                        ?>
                            <tr style="background-color: #c1daff;">
                                <td><?=$i;?></td>
                                <td><?=$value;?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php
                        $i++;
                        $j=1;
                        foreach($arr1 as $value1)
                        {
                            if($value==$value1->locat.'-'.$value1->section)
                            {
                                $amount=$amount+$value1->cost;
                                ?>
                                    <tr>
                                        <td><?=$j." ";?><a href="add_in.php?id=<?=$value1->cat_id."-".$value1->assetid?>"><i class="fa fa-edit"></i></a></td>
                                        <td><?=$value1->des1;?></td>
                                        <td><?=$value1->model;?></td>
                                        <td><?=$value1->cat_id."-".$value1->assetid;?></td>
                                        <td><?=$value1->acquired;?></td>
                                        <td><?=$value1->condit;?></td>
                                        <td><?=$value1->cost;?></td>
                                        <td><?=$value1->empl_emloyee_en;?></td>
                                        <td><?=$value1->adj;?></td>
                                    </tr>
                                <?php
                                $j++;
                            }
                        }
                        ?>
                            <tr style="background-color: ;">
                                <td></td>
                                <td>Total</td>
                                <td><?=$j-1;?></td>
                                <td>Pieces</td>
                                <td></td>
                                <td>$</td>
                                <td><?=$amount;?></td>
                            </tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
        <br>
    </div>
</div>