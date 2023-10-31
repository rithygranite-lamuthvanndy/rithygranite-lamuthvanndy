<?php 
    $menu_active =13;
    $left_active =103;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once 'permission.php';
    include_once '../layout/header.php';
?>
    
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> From Request / Purchase Claim</h2>
        </div>
        <div class="col-xs-12">
            <div class="row" id="myDIV">
                <!-- Main content -->
                <section class="content">
                  <!-- Small boxes (Stat box) -->
                    <?php
                                  // get old data 
                        $old_data = $connect->query("SELECT *, 
                            (select sum(frpc_amount) from tbl_fr_pc_expense WHERE frpc_type=12) as totol_pc, 
                            (select count(frpc_amount) from tbl_fr_pc_expense WHERE frpc_type=12) as count_pc,
                            (select sum(frpc_amount) from tbl_fr_pc_expense WHERE frpc_type=11) as totol_fr, 
                            (select count(frpc_amount) from tbl_fr_pc_expense WHERE frpc_type=11) as count_fr 
                                                    FROM tbl_fr_pc_type_list ORDER BY fpt_name ASC");
                        $row_old_data_main = mysqli_fetch_object($old_data);


                     ?>
                    <div class="row">
                        <div class="col-xs-3">
                          <!-- small box -->
                          <div class="small-box">
                            <div class="inner bg-aqua">
                                សរុបសំណើ
                                <table width="100%">
                                    <tr>
                                        <td><h1><b>$ <?= number_format($row_old_data_main->totol_fr,2) ?></b></h1></td><td class="text-right"><h2><?= $row_old_data_main->count_fr ?></h2></td>
                                    </tr>
                                    <tr>
                                        <td>សំណើស្នើសុំ</td><td class="text-right"><small>Updated moments ago</small></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="inner bg-red">
                                <table width="100%">
                                    <tr>
                                        <td><h1><b>$ <?= number_format($row_old_data_main->totol_pc,2) ?></b></h1></td><td class="text-right"><h2><?= $row_old_data_main->count_pc ?></h2></td>
                                    </tr>
                                    <tr>
                                        <td>ស្នើសុំទូទាត់ប្រាក់</td><td></td>
                                    </tr>
                                </table>
                            </div>
                          </div>

                        </div>
                    </div>
                </section>

            </div>
            <hr>

        </div>
    </div>
        <div class="">
            <div class="col-xs-6 caption font-dark">
                <a href="add.php" id="sample_editable_1_new" class="btn green"> Add New
                    <i class="fa fa-plus"></i>
                </a>
            </div>
            <div class="col-xs-6 text-right">
                <button class="text-left" onclick="myFunction()"><i class="fa fa-plus"></i></button>    
            </div>
        </div>
        <br>
        <a class="btn btn-primary btn-xs" data-toggle="modal" href='#request_add'>
           <i class="fa fa-plus"></i>
        </a> <h3>From Request</h3>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_3" role="grid" aria-describedby="sample_3_info" style="width: 100%;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th class="text-center">FR/PC No</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">FR/PC Type</th>
                        <th class="text-center">Description</th>
                        <th class="text-right">Qty</th>
                        <th class="text-center">Unit Price</th>
                        <th class="text-center">AMOUNT(USD)</th>
                        <th style="width: 450px;" class="text-center">Other</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $totol_frpc=0;
                        $v_cat_name_tmp = [];
                        $get_data = $connect->query("SELECT A.*,B.fpt_name, date_format(frpc_date,'%m-%Y') as date11, C.*
                         FROM   tbl_fr_pc_expense as A
                            LEFT JOIN tbl_fr_pc_type_list AS B ON A.frpc_type=B.fpt_id
                            LEFT JOIN tbl_acc_unit_list AS C ON A.frpc_qty=C.uni_id
                            ORDER BY frpc_date DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            if (!in_array($row->date11, $v_cat_name_tmp)) {
                                array_push($v_cat_name_tmp, $row->date11);
                            echo '<tr class="bg-yellow">';
                                echo '<td colspan="10">សំណើរប្រចាំខែ '.$row->date11.'</td>';
                            echo '</tr>';
                        }

                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->frpc_no.'</td>';
                                echo '<td>'.$row->frpc_date.'</td>';
                                echo '<td>'.$row->fpt_name.'</td>';
                                echo '<td>'.$row->frpc_description.'</td>';
                                echo '<td>'.$row->frpc_qty.' '.$row->uni_name.'</td>';
                                echo '<td class="text-right"><i class="fa fa-dollar"></i> '.number_format($row->frpc_unit_price, 2).'</td>';
                                if($row->frpc_amount>0){
                                    echo '<td class="text-right"><i class="fa fa-dollar"></i> '.number_format($row->frpc_amount, 2).'</td>';
                                }else{
                                    echo '<td class="text-right"><i class="fa fa-dollar"></i> '.number_format($row->frpc_unit_price*$row->frpc_qty, 2).'</td>';
                                }
                                echo '<td>'.$row->frpc_note.'</td>';
                                echo '<td class="text-center">';
                                echo button_edit($row->frpc_id);
                                echo button_delete($row->frpc_id);
                                echo '<a target="_blank" href="print.php?print_id=' . $row->frpc_id . '" class="btn btn-xs btn-info" title="edit"><i class="fa fa-print"></i></a> ';
                            echo '</tr>';
                            $totol_frpc+=$row->frpc_amount;
                        }

                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>




<div class="modal fade" id="request_add">
    <div class="modal-dialog" style="width: 70%;">
        <iframe src="request_add.php" frameborder="0" style="height: 700px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<?php include_once '../layout/footer.php' ?>
<style>
#myDIV {
  width: 100%;
  padding: 50px 0;
  margin-top: 20px;
  display: none;
}
</style>
<script>
function myFunction() {
  var x = document.getElementById("myDIV");
  if (window.getComputedStyle(x).display === "none") {
    x.style.display = "block";
  }else{
    x.style.display = "none";
  }
}
</script>