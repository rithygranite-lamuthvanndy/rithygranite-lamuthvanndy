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
        <div class="col-xs-6">
            <h2><i class="fa fa-fw fa-map-marker"></i> From Request / Purchase Claim</h2>
        </div>
        <div class="col-xs-6">

                <div class="" style="display: inline-block;">
                    <div class="caption font-dark">
                      <!-- Messages: style can be found in dropdown.less-->
                      <li class="dropdown messages-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                          <h2> Purchase Claim</h2>
                        </a>
                        <ul class="dropdown-menu" style="width: 500px;">
                          <li class="header">You have 4 messages</li>
                          <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                              <!-- start message -->
                              <?php 
                              $v_select = $connect->query("SELECT *, (select sum(frpc_amount) from tbl_fr_pc_expense WHERE frpc_type=fpt_id) as totol_fpt, (select count(frpc_amount) from tbl_fr_pc_expense WHERE frpc_type=fpt_id) as count_fpt FROM tbl_fr_pc_type_list ORDER BY fpt_name ASC");
                              while ($row_data = mysqli_fetch_object($v_select)) {
                
                                      echo '<li>';
                                         echo '<a href="#">';
                                          echo '<div class="pull-left" style="width: 150px">';
                                          echo '<h4>'.$row_data->fpt_name.'|| '.$row_data->count_fpt.'<small><i class="fa fa-clock-o"></i> '.$row_data->fpt_name.'</small>
                                          </h4>';
                                          echo '</div>';
                                          echo '<h3>$ '.number_format($row_data->totol_fpt,2).'</h3>';
                                        echo '</a>';
                                      echo '</li><br>';
                              }
                              ?>
                              <!-- end message -->
                              
                            </ul>
                          </li>
                          <li class="footer"><a href="#">See All Messages</a></li>
                        </ul>
                      </li>
                      <!-- Notifications: style can be found in dropdown.less -->
                    </div>
                </div>
            
        </div>
    </div>
    <?= button_add() ?>
        <a class="btn btn-primary btn-xs" data-toggle="modal" href='#request_add'>
           <i class="fa fa-plus"></i>
        </a>
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
                        <th class="text-center">Other</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $v_cat_name_tmp = [];
                        $get_data = $connect->query("SELECT A.*,B.fpt_name, date_format(frpc_date,'%m-%Y') as date11 FROM   tbl_fr_pc_expense as A
                            LEFT JOIN tbl_fr_pc_type_list AS B ON A.frpc_type=B.fpt_id
                            ORDER BY frpc_no ASC");
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
                                echo '<td>'.$row->frpc_qty.' '.$row->frpc_unit.'</td>';
                                echo '<td class="text-right"><i class="fa fa-dollar"></i> '.number_format($row->frpc_unit_price, 2).'</td>';
                                echo '<td class="text-right"><i class="fa fa-dollar"></i> '.number_format($row->frpc_amount, 2).'</td>';
                                echo '<td>'.$row->frpc_note.'</td>';
                                echo '<td class="text-center">';
                                echo button_edit($row->frpc_id);
                                echo button_delete($row->frpc_id);
                                echo '<a target="_blank" href="print.php?print_id=' . $row->frpc_id . '" class="btn btn-xs btn-info" title="edit"><i class="fa fa-print"></i></a> ';
                            echo '</tr>';
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
