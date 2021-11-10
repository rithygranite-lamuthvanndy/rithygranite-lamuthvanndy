<?php 
    $menu_active =0;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i>Alert Cash Flow List</h2>
        </div>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th style="color:red">Date Alert</th>
                        <th>Alert Detail</th>
                        <th>Date Record</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Month Year</th>
                        <th>Amount In</th>
                        <th>Amount Out</th>
                        <th>Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $total_income = 0;
                        $total_expense = 0;
                        $total_balance = 0;

                        $v_current_date = date('Y-m-d');

                            $get_data = $connect->query("SELECT 
                               *
                            FROM tbl_cf_cash_record AS A
                            LEFT JOIN tbl_cf_category_list AS CL ON CL.cfcl_id=A.cfcr_category
                            LEFT JOIN tbl_cf_type_list AS T ON T.cftl_id=A.cfcr_type
                            LEFT JOIN tbl_cf_monthyear_list AS MY ON MY.cfmy_id=A.cfcr_month_year
                            LEFT JOIN tbl_user AS U ON U.user_id=A.user_id
                            LEFT JOIN tbl_cf_cash_flow_alert AS CFA ON A.cfcr_id=CFA.cfcfa_description
                            WHERE cfcfa_date_alert = '$v_current_date'
                            ORDER BY A.cfcr_id DESC");
                        
                        while ($row = mysqli_fetch_object($get_data)) {
                            $total_income+= $row->cfcr_amount_in; 
                            $total_expense+= $row->cfcr_amount_out; 
                            $total_balance= $total_income-$total_expense; 

                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td style="color:red">'.$row->cfcfa_date_alert.'</td>';
                                echo '<td>'.$row->cfcfa_note.'</td>';
                                echo '<td>'.$row->cfcr_date_record.'</td>';
                                echo '<td>'.$row->cfcr_description.'</td>';
                                echo '<td>'.$row->cfcl_name.'</td>';
                                echo '<td>'.$row->cftl_name.'</td>';
                                echo '<td>'.$row->cfmy_name.'</td>';
                                echo '<td>'.$row->cfcr_amount_in.'</td>';
                                echo '<td>'.$row->cfcr_amount_out.'</td>';
                                echo '<td>'.$row->cfcr_note.'</td>';
                                echo '<td class="text-center">';
                                //    echo '<a href="edit.php?edit_id='.$row->cfcr_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                //   echo '<a href="delete.php?del_id='.$row->doccat_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Total:</th>
                        <th>
                            <?php
                                echo "$total_income";
                            ?>
                        </th>
                        <th>
                            <?php
                                echo "$total_expense";
                            ?>
                        </th>
                        <th>
                            <?php
                                echo "$total_balance";
                            ?>
                        </th>
                        <th></th>
                        
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>






<?php include_once '../layout/footer.php' ?>
