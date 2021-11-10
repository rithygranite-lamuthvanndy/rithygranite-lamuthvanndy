<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
    if(isset($_POST['btn_search'])){
        $v_start=@$_POST['txt_date_start'];
        $v_end=@$_POST['txt_date_end'];
        $sql=$connect->query("SELECT A.*,
            SUM(rei_qty*rei_unit) AS totalAmount,
            req_date,req_number,
            res_name,po_name,chn_name,apn_name,dep_name,typr_name,uni_name
            FROM tbl_acc_request_item AS A 
            LEFT JOIN tbl_acc_request_form AS B ON A.rei_number=B.req_id
            LEFT JOIN tbl_acc_request_name_list AS C ON B.req_request_name=C.res_id
            LEFT JOIN tbl_acc_position AS D ON B.req_position=D.po_id
            LEFT JOIN tbl_acc_check_name_list AS E ON B.req_check_by=E.chn_id
            LEFT JOIN tbl_acc_approved_name_list AS F ON B.req_approved_by=F.apn_id
            LEFT JOIN tbl_acc_department_list AS G ON B.dep_id=G.dep_id
            LEFT JOIN tbl_acc_type_request_list AS H ON B.type_req_id=H.typr_id
            LEFT JOIN tbl_acc_unit_list AS I ON A.rei_unit=I.uni_id
            WHERE req_date BETWEEN '$v_start' AND '$v_end'
            GROUP BY A.rei_id
            ");
    }
    else if(isset($_POST['btn_print'])){
        header('location: print.php');
    }
    else{
        $sql=$connect->query("SELECT A.*,
            SUM(rei_qty*rei_unit) AS totalAmount,
            req_date,req_number,
            res_name,po_name,chn_name,apn_name,dep_name,typr_name,uni_name
            FROM tbl_acc_request_item AS A 
            LEFT JOIN tbl_acc_request_form AS B ON A.rei_number=B.req_id
            LEFT JOIN tbl_acc_request_name_list AS C ON B.req_request_name=C.res_id
            LEFT JOIN tbl_acc_position AS D ON B.req_position=D.po_id
            LEFT JOIN tbl_acc_check_name_list AS E ON B.req_check_by=E.chn_id
            LEFT JOIN tbl_acc_approved_name_list AS F ON B.req_approved_by=F.apn_id
            LEFT JOIN tbl_acc_department_list AS G ON B.dep_id=G.dep_id
            LEFT JOIN tbl_acc_type_request_list AS H ON B.type_req_id=H.typr_id
            LEFT JOIN tbl_acc_unit_list AS I ON A.rei_unit=I.uni_id
            GROUP BY A.rei_id
            ");
    }
 ?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Report Flow Up</h2>
        </div>
    </div>
    <br>
    <div class="row">
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
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
                    <a class="btn btn-sm btn-danger" href="index.php"> Clear
                        <i class="fa fa-undo"></i>
                    </a>
                    <button type="submit" name="btn_print" formtarget="new" id="sample_editable_1_new" class="btn btn-warning btn-sm"> Print
                        <i class="fa fa-print"></i>
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
                        <th rowspan="2">N&deg;</th>
                        <th rowspan="2">កាលបរិច្ឆេទ</th>
                        <th rowspan="2" class="text-center">លេខសំណើរ</th>
                        <th rowspan="2">ឈ្មោះនាយកដ្ឋាន</th>
                        <th rowspan="2">ប្រភេទសំនើរ</th>
                        <th rowspan="2">អ្នកស្នើរសុំ</th>
                        <th rowspan="2">ឯកភាពដោយ</th>
                        <th rowspan="2">ទឹកប្រាក់ស្នើរសុំ</th>
                        <th rowspan="2">ទីតាំងទិញ</th>
                        <th rowspan="2">ឈ្មោះអ្នកទិញ</th>
                        <th colspan="5" class="text-center">បរិយាយ</th>
                        <th rowspan="2">តម្លៃរាយ</th>
                        <th rowspan="2">តម្លៃសរុប</th>
                        <th rowspan="2">ចំណាំ</th>
                    </tr>
                    <tr>
                        <th>ប្រភេទ</th>
                        <th>ឈ្មោះសម្ភារះ</th>
                        <th>ទំហំ/លេខ</th>
                        <th>ចំនួន</th>
                        <th>ឯកតា</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $i=0;
                        while ($row=mysqli_fetch_object($sql)) {
                            echo '<tr>';
                                echo '<td class="text-center">'.++$i.'</td>';
                                echo '<td class="text-center">'.$row->req_date.'</td>';
                                echo '<td class="text-center">'.$row->req_number.'</td>';
                                echo '<td class="text-center">'.$row->dep_name.'</td>';
                                echo '<td class="text-center">'.$row->typr_name.'</td>';
                                echo '<td class="text-center">'.$row->res_name.'</td>';
                                echo '<td class="text-center">'.$row->apn_name.'</td>';
                                echo '<td class="text-center">'.number_format($row->totalAmount,2).' $</td>';
                                echo '<td class="text-center">-</td>';
                                echo '<td class="text-center">-</td>';
                                echo '<td class="text-center">'.$row->rei_type.'</td>';
                                echo '<td class="text-center">'.$row->rei_item_name.'</td>';
                                echo '<td class="text-center">'.$row->rei_size.'</td>';
                                echo '<td class="text-center">'.$row->rei_qty.'</td>';
                                echo '<td class="text-center">'.$row->uni_name.'</td>';
                                echo '<td class="text-center">'.$row->rei_unit.'</td>';
                                echo '<td class="text-center">'.round($row->rei_qty*$row->rei_unit,2).' $</td>';
                                echo '<td class="text-center">-</td>';
                            echo '</tr>';
                        }
                     ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include_once '../layout/footer.php' ?>
