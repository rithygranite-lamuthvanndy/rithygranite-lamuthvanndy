<?php 
    $menu_active =13;
    $left_active =33;
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
        $get_data=$connect->query("SELECT * FROM tbl_acc_request_form AS A
                            LEFT JOIN tbl_acc_request_name_list AS B ON A.req_request_name=B.res_id 
                            LEFT JOIN tbl_acc_position AS C ON A.req_position=C.po_id
                            LEFT JOIN tbl_acc_prepare_name_list AS D ON A.req_prepare_by=D.pren_id
                            LEFT JOIN tbl_acc_check_name_list AS E ON A.req_check_by=E.chn_id
                            LEFT JOIN tbl_acc_approved_name_list AS F ON A.req_approved_by=F.apn_id
                            WHERE DATE_FORMAT(req_date,'%Y-%m-%d') BETWEEN '$v_start' AND '$v_end'
                         ORDER BY req_date ASC");
    }
    else{
        $get_data=$connect->query("SELECT * FROM tbl_acc_request_form AS A
                            LEFT JOIN tbl_acc_request_name_list AS B ON A.req_request_name=B.res_id 
                            LEFT JOIN tbl_acc_position AS C ON A.req_position=C.po_id
                            LEFT JOIN tbl_acc_prepare_name_list AS D ON A.req_prepare_by=D.pren_id
                            LEFT JOIN tbl_acc_check_name_list AS E ON A.req_check_by=E.chn_id
                            LEFT JOIN tbl_acc_approved_name_list AS F ON A.req_approved_by=F.apn_id
                            WHERE DATE_FORMAT(req_date,'%Y-%m-%d')='$now'
                         ORDER BY req_date ASC");
        $v_start =$v_end=date("Y-m-d");
    }
    
 ?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Add Request Form</h2>
        </div>
    </div>

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
            <select onchange="window.location=this.value" class="btn"  style="width:100%;height: 33px;">
                <option selected="" value="../op_acc_add_request_form_invoice">Request</option>
                <option  value="../op_acc_items_reques">Items</option>
            </select>
        </div>
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
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Date Record</th>
                        <th style="padding: 10px 50px;">View Item</th>
                        <th>Number </th>
                        <th>Request Name</th>
                        <th>Position</th>
                        <th>Prepare By</th>
                        <th>Check By </th>
                        <th>Approved By </th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.date("D d-m-Y",strtotime($row->req_date)).'</td>';
                                    $sql=$connect->query("SELECT * FROM tbl_acc_request_item WHERE rei_number='$row->req_id'");
                                    $n_row=mysqli_num_rows($sql);
                                echo '<td class="text-center">
                                    <a href="view_form.php?sent_id='.$row->req_id.'&v_start='.$v_start.'&v_end='.$v_end.' " title="View Form Item" target="_blank">
                                        <i class="fa fa-eye btn btn-warning btn-xs"> Preview '.$n_row.'</i> 
                                    </a>
                                    ';
                                    // <a class="btn btn-info btn-xs" data_id="'.$row->req_id.'" data-toggle="modal" href="#more_info"><i class="fa fa-info-circle"></i> Info</a>
                                    // </td>
                                    
                                    // echo '<td class="text-center">
                                    // <a href="../op_acc_add_request_item/?sent_id='.$row->req_id.'" title="Add Item"">';
                                    // echo    '<button type="button" class="btn btn-info btn-xs">'.$n_row.'</button>';
                                    // echo '</a>
                                    // </td>';
                                echo '<td>'.$row->req_number.'</td>';
                                echo '<td>'.$row->res_name.'</td>';
                                echo '<td>'.$row->po_name.'</td>';
                                echo '<td>'.$row->pren_name.'</td>';
                                echo '<td>'.$row->chn_name.'</td>';
                                echo '<td>'.$row->apn_name.'</td>';
                                echo '<td class="text-center">';
                                echo button_edit($row->req_id);
                                echo button_delete($row->req_id);
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