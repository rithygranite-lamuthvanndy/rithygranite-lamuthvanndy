<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
    include_once 'myfunction.php';
?>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Report: Ledger</h2>
        </div>
    </div>
    <br>

    <div class="row">
        <!-- start search form -->
        <form action="" method="post">
            <div class="col-xs-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input type="text" name="txt_from" required  value="<?= @$_POST['txt_from'] ?>" autocomplete="off" class="form-control">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-xs-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input type="text" name="txt_to"  required value="<?= @$_POST['txt_to'] ?>" autocomplete="off" class="form-control">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-xs-3">
                <select name="txt_topic" class="form-control myselect2">
                    <option value="">== All Account ==</option>
                    <?php 
                        $get_topic = $connect->query("SELECT * FROM tbl_acc_chart_account ORDER BY accca_account_name ASC");
                        while($row_topic = mysqli_fetch_object($get_topic)){
                            if($row_topic->accca_id == @$_POST['txt_topic']){
                                echo '<option SELECTED value="'.$row_topic->accca_id.'">'.$row_topic->accca_account_name.'</option>';
                                
                            }else{

                                echo '<option value="'.$row_topic->accca_id.'">'.$row_topic->accca_account_name.'</option>';
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="col-xs-2">
                <button type="submit" name="btn_search" class="btn blue"><i class="fa fa-search"></i> Search</button>
                <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn red"><i class="fa fa-undo"></i> Clear</a>
            </div>
        </form>
        <!-- end search form -->
    </div>
    <br><br><br>

    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <!-- <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="example" role="grid" aria-describedby="sample_1_info" style="width: 1180px;"> -->
                <table id="example" class="stripe hover cell-border order-column" cellspacing="0" width="100%">
                <thead>
                    <tr role="row" class="text-center">
                        <th class="text-center">Type</th>
                        <th class="text-center">Date Record</th>
                        <th class="text-center">Number</th>
                        <th class="text-center">Adi</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Memo</th>
                        <th class="text-center">Spilt</th>
                        <th class="text-center">Debit</th>
                        <th class="text-center">Credit</th>
                        <th class="text-center">Balance</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                    <!-- <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Office</th>
                        <th>Extn.</th>
                        <th>Start date</th>
                        <th>Salary</th>
                    </tr> -->
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $total_debit=0;
                        $total_credit=0;
                        $total_balance=$total_debit-$total_credit;
                        
                        if(isset($_POST['btn_search'])){
                            $v_from = @$_POST['txt_from'];
                            $v_to = @$_POST['txt_to'];
                            $v_topic = @$_POST['txt_topic'];
                            $v_employee = @$_POST['txt_employee'];
                            if($v_topic != "" AND $v_employee == ""){
                                //echo "5";
                                $get_data = $connect->query("SELECT 
                                   *
                                FROM   tbl_acc_add_transaction AS A
                                LEFT JOIN tbl_acc_project AS PRO ON A.accad_project=PRO.accpro_id
                                LEFT JOIN tbl_acc_item AS I ON A.accad_item=I.accit_id
                                LEFT JOIN tbl_acc_chart_account AS ACC ON A.accad_account=ACC.accca_id
                                WHERE accad_date_record BETWEEN '$v_from' AND '$v_to' AND A.accad_account='$v_topic' 
                                ORDER BY accad_id DESC"); 

                            }else if($v_topic == "" AND $v_employee != ""){
                                //echo "4";
                                $get_data = $connect->query("SELECT 
                                   *
                                FROM   tbl_acc_add_transaction AS A
                                LEFT JOIN tbl_acc_project AS PRO ON A.accad_project=PRO.accpro_id
                                LEFT JOIN tbl_acc_item AS I ON A.accad_item=I.accit_id
                                LEFT JOIN tbl_acc_chart_account AS ACC ON A.accad_account=ACC.accca_id
                                WHERE accad_date_record BETWEEN '$v_from' AND '$v_to' AND A.accad_project='$v_employee'
                                ORDER BY accad_id DESC"); 

                            }else if($v_topic != "" AND $v_employee != ""){
                                //echo "3"; topic
                                $get_data = $connect->query("SELECT 
                                   *
                                FROM   tbl_acc_add_transaction AS A
                                LEFT JOIN tbl_acc_project AS PRO ON A.accad_project=PRO.accpro_id
                                LEFT JOIN tbl_acc_item AS I ON A.accad_item=I.accit_id
                                LEFT JOIN tbl_acc_chart_account AS ACC ON A.accad_account=ACC.accca_id
                                WHERE accad_date_record BETWEEN '$v_from' AND '$v_to' AND A.accad_project='$v_employee' AND A.accad_account='$v_topic' 
                                ORDER BY accad_id DESC"); 

                            }else if($v_topic == "" AND $v_employee == ""){
                                //echo "2";
                                $get_data = $connect->query("SELECT 
                                   *
                                FROM   tbl_acc_add_transaction AS A
                                LEFT JOIN tbl_acc_project AS PRO ON A.accad_project=PRO.accpro_id
                                LEFT JOIN tbl_acc_item AS I ON A.accad_item=I.accit_id
                                LEFT JOIN tbl_acc_chart_account AS ACC ON A.accad_account=ACC.accca_id
                                WHERE accad_date_record BETWEEN '$v_from' AND '$v_to'
                                ORDER BY accad_id DESC");   
                            }
                        }else{
                            //echo "1";
                            $v_current_year_month = date('Y-m');
                            $get_data = $connect->query("SELECT 
                               *
                            FROM   tbl_acc_add_transaction AS A
                            LEFT JOIN tbl_acc_project AS PRO ON A.accad_project=PRO.accpro_id
                            LEFT JOIN tbl_acc_item AS I ON A.accad_item=I.accit_id
                            LEFT JOIN tbl_acc_chart_account AS ACC ON A.accad_account=ACC.accca_id
                            WHERE DATE_FORMAT(accad_date_record,'%Y-%m')='$v_current_year_month'
                            ORDER BY accad_id DESC");                  

                        }
                 

                        while ($row = mysqli_fetch_object($get_data)) {

                            $total_debit+= $row->accad_debit;
                            $total_credit+= $row->accad_credit;

                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->accad_date_record.'</td>';
                                echo '<td>'.$row->accad_invoice_no.'</td>';
                                echo '<td>'.$row->accpro_name.'</td>';
                                echo '<td>'.$row->accit_name.'</td>';
                                echo '<td>'.$row->accad_qty.'</td>';
                                echo '<td>'.$row->accad_description.'</td>';
                                echo '<td>'.$row->accca_account_name.'</td>';
                                echo '<td>'.$row->accad_debit.'</td>';
                                echo '<td>'.$row->accad_credit.'</td>';
                                echo '<td>'.$row->accad_note.'</td>';
                                echo '<td>'.$row->date_audit.'</td>';
                                echo '<td class="text-center">';
                                   // echo '<a href="edit.php?edit_id='.$row->accad_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   //echo '<a href="delete.php?del_id='.$row->accad_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
                <!-- <footer>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Total: </th>
                    <th>$
                        <?php
                            echo "$total_debit";
                        ?>
                    </th>
                    <th>$
                        <?php
                            echo "$total_credit";
                        ?>
                    </th>
                    <th>$
                        <?php
                            echo $total_debit-$total_credit;
                        ?>
                    </th>
                </footer> -->
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
        // var v_data;
    // $(document).ready(function () {
    //     $.ajax({url: 'ajax_get_data.php',success:function (result) {
    //         alert(result);
    //         var table = $('#example').DataTable({
    //         data: JSON.parse(result),
    //         columnDefs: [
    //             {
    //                 'targets': [1, 2, 3, 4, 5],
    //                 'orderable': false,
    //                 'searchable': false
    //             }
    //         ],
    //         rowsGroup: [0],
    //         createdRow: function(row, data, dataIndex){
    //             // Use empty value in the "Office" column
    //             // as an indication that grouping with COLSPAN is needed
    //             if(data[1] === ''){
    //                 // Add COLSPAN attribute
    //                 $('td:eq(1)', row).attr('colspan', 9);
    //                 for(i=2;i<=9;i++)
    //                     $('td:eq("'+i+'")', row).css('display', 'none');
    //             }
    //             if(data[0] === ''){
    //                 // Add COLSPAN attribute
    //                 $('td:eq(1)', row).attr('colspan',2);
    //                 $('td:eq("0")', row).css('display', 'none');
    //                 // for(i=2;i<=9;i++)
    //             }
    //         }      
    //     });   
    //     }});
    // }); 
</script>

<?php include_once '../layout/footer.php' ?>
