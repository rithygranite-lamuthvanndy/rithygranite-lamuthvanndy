<?php 
    $menu_active =13;
    $left_active =103;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once 'permission.php';
    include_once '../layout/header.php';
?>
<?php 
    if(isset($_POST['btn_search'])){
        $v_start=@$_POST['txt_date_start'];
        $v_end=@$_POST['txt_date_end'];
        $get_data=$connect->query("SELECT 
                            reiw_id, reiw_description, (reiw_qty*reiw_price) as amount,B.reqw_id, date_format(B.reqw_date,'%d-%m-%Y') as datefor, B.reqw_number FROM tbl_acc_reqw_item_ AS A
                            LEFT JOIN tbl_acc_request_wordsite AS B ON A.reiw_numberw=B.reqw_id 
                            WHERE DATE_FORMAT(B.reqw_date,'%Y-%m-%d') BETWEEN '$v_start' AND '$v_end'
                         ORDER BY reiw_id ASC");
    }
    else{
        $v_current_year_month = date('Y-m');
        $get_data=$connect->query("SELECT 
                            reiw_id, reiw_description, (reiw_qty*reiw_price) as amount,B.reqw_id, date_format(B.reqw_date,'%d-%m-%Y') as datefor, B.reqw_number FROM tbl_acc_reqw_item_ AS A
                            LEFT JOIN tbl_acc_request_wordsite AS B ON A.reiw_numberw=B.reqw_id 
                            WHERE DATE_FORMAT(B.reqw_date,'%Y-%m')='$v_current_year_month'
                         ORDER BY reiw_id ASC");
        $v_start =$v_end=date("Y-m-d");
    }
    
 ?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2 style="font-family: 'Khmer OS';"><i class="fa fa-fw fa-cubes"></i> តារាងតាមដានសំណើរខែ <?= date('m') ?> ឆ្នាំ <?= date('Y') ?></h2>
        </div>
    </div>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation">
            <a href="../fr_pc_work_site/">Suppary Report Request</a>
        </li>
        <li role="presentation">
            <a href="../fr_pc_work_site_add/">Add Request Form</a>
        </li>
        <li role="presentation">
            <a href="../fr_pc_work_site_inv/">Add Inovice</a>
        </li>
        <li role="presentation">
            <a href="../fr_pc_work_site_pay/">Add Payment</a>
        </li>
        <li role="presentation" class="active">
            <a href="../fr_pc_work_site_er/">Add Expence Report</a>
        </li>
    </ul>

    
    <?= button_add(); ?>



    <div class="row">
        <?php
          if(@$_GET['check']==1) {
            $date_s_s=@$_GET['v_start'];
            $date_s_e=@$_GET['v_end'];
          }
          else {
            $date_s_s=@$_POST['txt_date_start'];
            $date_s_e=@$_POST['txt_date_end'];
          }
        ?>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" name= "form1" id ="form1">
            <div class="col-sm-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input autocomplete="off" name="txt_date_start" 
                    value="<?php echo $date_s_s; ?>"
                     type="text" class="form-control" placeholder="Date From ....">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input autocomplete="off" name="txt_date_end" 
                    value="<?php echo $date_s_e; ?>" 
                    type="text" class="form-control" placeholder="Date To">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-4">
                <div class="caption font-dark" style="display: inline-block;">
                    <button type="submit" name="btn_search" id="sample_editable_1_new" class="btn blue btn-sm"> Search
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
            <br>
             
        </form>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row">
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">N&deg;</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">Date Record</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">Request Number</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">Description</th>
                        <th colspan="3" style="vertical-align: middle; text-align: center;">ទឹកប្រាក់ស្នើរសុំ</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">ឈ្មោះ<br> អ្នកផ្គត់ផ្គង់</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">ថ្ងៃខែឆ្នាំទិញ<br>រឺជំពាក់</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">ប្រតិបត្តិការ<br> (សំណើរ) </th>
                        <th colspan="2" style="vertical-align: middle; text-align: center;">ទឹកប្រាក់បានទូទាត់ </th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">ទឹកប្រាក់ជំពាក់ <br>អ្នកផ្គត់ផ្គង់</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                    <tr role="row">
                        <th style="vertical-align: middle; text-align: center;">សរុប</th>
                        <th style="vertical-align: middle; text-align: center;">ទិញជាសាច់ប្រាក់</th>
                        <th style="vertical-align: middle; text-align: center;">ទិញជំពាក់</th>
                        <th style="vertical-align: middle; text-align: center;">កាលបរិច្ឆេទ</th>
                        <th style="vertical-align: middle; text-align: center;">ទឹកប្រាក់</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->datefor.'</td>';
                                echo '<td>'.$row->reqw_number.'</td>';
                                echo '<td>'.$row->reiw_description.'</td>';
                                echo '<td class="text-center">$'.number_format($row->amount,  2) .'</td>';
                                echo '<td></td>';
                                echo '<td></td>';
                                echo '<td></td>';
                                echo '<td></td>';
                                echo '<td></td>';
                                echo '<td></td>';
                                echo '<td></td>';
                                echo '<td></td>';
                                echo '<td class="text-center">';
                                echo button_edit($row->reqw_id);
                                echo button_delete($row->reqw_id);
                                echo '</td>';
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
    $(document).ready(function(){
        $('a[href="#more_info"]').click(function(){
            v_id=$(this).attr('data_id');
            $('iframe[id=my_frame]').attr('src','iframe_more_info.php?sent_id='+v_id);
        });

       
    });
        <?php
          if(@$_GET['check']==1) {
        ?>
        
         $("button").click();
        <?php
           }
        ?>
</script>
<?php include_once '../layout/footer.php' ?>

<div class="modal fade" id="more_info">
    <div class="modal-dialog modal-lg" style="width: 1300px; border: 1px solid darkred;">
        <iframe id="my_frame" frameborder="0" style="height: 600px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>