<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Chart Account</h2>
        </div>
    </div>
    <br>
    <div class="">
        <div class="caption font-dark">
            <!-- <form action="" method="POST" class="form-inline" role="form">
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
                <button type="submit" name="btn_search" class="btn btn-danger"><i class="fa fa-search"></i> Search</button>
            </form> -->
            <a href="add.php" id="sample_editable_1_new" class="btn green"> Add New
                <i class="fa fa-plus"></i>
            </a>
            <a name="btn_delete" onclick="submitForm()" id="sample_editable_1_new" class="btn-md btn btn-primary"> Delete 
                <i class="fa fa-list"></i>
            </a>
        </div>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
           <table class="table table-striped table-bordered table-hover dataTable dtr-inline " id="sample_1" role="grid" aria-describedby="sample_1_info">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Main Account</th>
                        <th>Sub Main Account</th>
                        <th>Chart Account</th>
                        <th>Account Type</th>
                        <th>Sum Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        // if(isset($_POST['btn_search'])){
                        //     $v_date_start=@$_POST['txt_date_start'];
                        //     $v_date_end=@$_POST['txt_date_end'];
                        //     $get_data = $connect->query("SELECT *,
                        //         A.main_id AS main,
                        //         A.sub_main_id AS sub_main,SUM(debit-credit) AS amount,E.date_audit
                        //      FROM tbl_acc_chart_account AS A 
                        //      LEFT JOIN tbl_acc_chart_sub AS B ON A.sub_main_id=B.id
                        //      LEFT JOIN tbl_acc_main_account AS C ON A.main_id=C.accma_id
                        //      LEFT JOIN tbl_acc_type_account AS D ON A.accca_account_type=D.accta_id
                        //      LEFT JOIN tbl_acc_add_transaction_detail AS E ON A.accca_id=E.chart_acc_id
                        //      WHERE DATE_FORMAT(E.date_audit,'%Y-%m-%d') BETWEEN '$v_date_start' AND '$v_date_end'
                        //      GROUP BY accca_id  
                        //      ORDER BY main,sub_main ASC 
                        //         ");
                        // }
                        // else{
                            $get_data = $connect->query("SELECT *,
                                A.main_id AS main,
                                A.sub_main_id AS sub_main,SUM(debit-credit) AS amount
                             FROM tbl_acc_chart_account AS A 
                             LEFT JOIN tbl_acc_chart_sub AS B ON A.sub_main_id=B.id
                             LEFT JOIN tbl_acc_main_account AS C ON A.main_id=C.accma_id
                             LEFT JOIN tbl_acc_type_account AS D ON A.accca_account_type=D.accta_id
                             LEFT JOIN tbl_acc_add_transaction_detail AS E ON A.accca_id=E.chart_acc_id
                             GROUP BY accca_id  
                             ORDER BY main,sub_main ASC 
                                ");
                        // }

                        $flag=0;
                        $tmp_main=0;
                        $tmp_sub_main=0;
                        $tmp_chart_acc=0;
                        $i= 0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.++$i.'</td>';
                                if($tmp_main!=$row->main_id){
                                    $get_num_main=$connect->query("SELECT accma_main_account,COUNT(main_id) AS count 
                                        FROM tbl_acc_chart_account AS A
                                        LEFT JOIN tbl_acc_main_account AS B ON A.main_id=B.accma_id
                                        WHERE main_id='$row->main_id' 
                                        ORDER BY main_id ASC");
                                    $row_num_main=mysqli_fetch_object($get_num_main);
                                    $v_code=str_pad($row->acc_main_code, 6, '*', STR_PAD_RIGHT);
                                    echo '<td rowspan="'.$row_num_main->count.'">'.$v_code.' - '.$row_num_main->accma_main_account.'</td>';
                                }
                                $tmp_main=$row->main_id;
                                if($tmp_sub_main!=$row->sub_main_id){
                                    $get_sub_main=$connect->query("SELECT name,COUNT(A.sub_main_id) AS count
                                        FROM tbl_acc_chart_account AS A 
                                        LEFT JOIN tbl_acc_chart_sub AS B ON A.sub_main_id=B.id
                                        WHERE A.sub_main_id='$row->sub_main_id' 
                                        AND A.main_id='$row->main_id'
                                        -- ORDER BY main_id,sub_main_id ASC
                                        ");
                                     $row_num_sub_main=mysqli_fetch_object($get_sub_main);
                                     $v_code=str_pad($row->code, 6, '*', STR_PAD_RIGHT);
                                    echo '<td rowspan="'.$row_num_sub_main->count.'">'.$v_code.' - '.$row_num_sub_main->name.'</td>';
                                }
                                $tmp_sub_main=$row->sub_main_id;
                                $v_code=str_pad($row->accca_number, 6, '0', STR_PAD_RIGHT);
                                echo '<td>'.$v_code.' - '.$row->accca_account_name.'</td>';
                                echo '<td>'.$row->accta_type_account.'</td>';
                                echo '<td>'.number_format($row->amount,2).' <i class="fa fa-dollar"></i></td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->accca_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                    echo '<input type="checkbox" name="myCheckboxes[]" id="myCheckboxes"  value="'.$row->accca_id.'">';
                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
          
        </div>
    </div>
</div>

<style type="text/css">
    ol,ul{
       padding-left: 30px;
    }
    ul > li{ margin-bottom: 20px; }
</style>

<script src="../../assets/global/plugins/jquery.min.js" type="text/javascript" ></script>
<script type="text/javascript">
    function submitForm() {
        $i=0;
        // alert("fffff");
            var myCheckboxes = new Array();
            $("input:checked").each(function(e) {
               // $(this).parents('tr').find('td:not(:first-child),th').html('--');
               myCheckboxes.push($(this).val());
               $i++;
               // alert($(this).val());
            });
            if($i==0){
                alert("Please Check Some Item to delete!");
                return false;
            }
            // return false;
            var a=confirm("Do you wanna delete all of this ?");
            if(a==false){
                 return false;
            }
            $.ajax({
                type: "POST",
                url: "delete_all.php",
                dataType: 'html',
                data: 'myCheckboxes='+myCheckboxes,
                success: function(result){
                    // alert(result);
                    // $('#myResponse').html(data)
                }
            });
            window.location.replace("index.php");
    }

    $('.datepicker').datepicker();
</script>


<?php include_once '../layout/footer.php' ?>
