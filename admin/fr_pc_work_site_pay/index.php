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
                            A.*,sum(B.apl_amount) as tot_amount
                        FROM tbl_frpc_add_pay AS A 
                        LEFT JOIN tbl_frpc_add_pay_list AS B ON A.ap_id=B.apl_ap_id 
                            WHERE DATE_FORMAT(A.ap_date,'%Y-%m-%d') BETWEEN '$v_start' AND '$v_end'
                         ORDER BY ap_id ASC");
    }
    else{
        $v_current_year_month = date('Y-m');
        $get_data=$connect->query("SELECT 
                            *,sum(B.apl_amount) as tot_amount
                        FROM tbl_frpc_add_pay AS A 
                        LEFT JOIN tbl_frpc_add_pay_list AS B ON A.ap_id=B.apl_ap_id
                            WHERE DATE_FORMAT(A.ap_date,'%Y-%m')='$v_current_year_month'
                         ORDER BY ap_id ASC");
        $v_start =$v_end=date("Y-m-d");
    }
    
 ?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2 style="font-family: 'Khmer OS';"><i class="fa fa-fw fa-cubes"></i> តារាងតាមដានសំណើរខែ <?= date('m') ?> ឆ្នាំ <?= date('Y') ?></h2>
            <h4><a onclick="myFunction()"><i class="fa fa-plus-circle fa-fw"></i>Show</a></h4>
        </div>
    </div>

      <!-- Small boxes (Stat box) -->
      <div class="row" id="myDIV">

        <?php
                        $get_data1 = $connect->query("SELECT A.osl_name,B.ai_date, (select sum(ail_qty*ail_unit_price) from tbl_frpc_add_inv_list WHERE ail_ai_id=B.ai_id) AS total FROM tbl_op_sup_list AS A LEFT JOIN tbl_frpc_add_inv AS B ON A.osl_id=B.ai_supply 
                        WHERE DATE_FORMAT(B.ai_date,'%Y-%m')='$v_current_year_month'
                         ORDER BY osl_id ASC");
                        while ($row1 = mysqli_fetch_object($get_data1)) {

        echo '<div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
                <div class="inner">';
        echo    '<h3>$ '.number_format($row1->total,2).'</h3>';
    
        echo '<p><h4>'.$row1->osl_name.'</h4></p>';
        echo '<p><h5>ទឹកប្រាក់ជំពាក់</h5></p>';
        echo '</div>
                <div class="icon">
              <i class="glyphicon glyphicon-list-alt"></i>
                </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
                </div>';
        }
        ?>
      </div>
      <!-- /.row -->


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
        <li role="presentation" class="active">
            <a href="../fr_pc_work_site_pay/">Add Payment</a>
        </li>
        <li role="presentation">
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
                        <th style="vertical-align: middle; text-align: center;">N&deg;</th>
                        <th style="vertical-align: middle; text-align: center;">Date Record</th>
                        <th style="vertical-align: middle; text-align: center;">Pay No</th>
                        <th style="vertical-align: middle; text-align: center;">Description</th>
                        <th style="vertical-align: middle; text-align: center;">Transaction Type</th>
                        <th style="vertical-align: middle; text-align: center;">Payer</th>
                        <th style="vertical-align: middle; text-align: center;">Received</th>
                        <th style="vertical-align: middle; text-align: center;">Amount</th>
                        <th style="vertical-align: middle; text-align: center;">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->ap_date.'</td>';
                                echo '<td>'.$row->ap_no.'</td>';
                                echo '<td>'.$row->ap_description.'</td>';
                                echo '<td>'.$row->ap_trans_type.'</td>';
                                echo '<td>'.$row->ap_pay.'</td>';
                                echo '<td>'.$row->ap_receive.'</td>';
                                echo '<td class="text-right">$ '.number_format($row->tot_amount,  2) .'</td>';
                                 echo '<td class="text-center">';
                                echo button_edit($row->ap_id);
                                echo button_delete($row->ap_id);
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
<style>
#myDIV {
  width: 100%;
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
<?php include_once '../layout/footer.php' ?>

<div class="modal fade" id="more_info">
    <div class="modal-dialog modal-lg" style="width: 1300px; border: 1px solid darkred;">
        <iframe id="my_frame" frameborder="0" style="height: 600px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>