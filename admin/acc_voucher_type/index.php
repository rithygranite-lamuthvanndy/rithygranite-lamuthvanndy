<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>

    <div class="row">
        <div class="col-xs-3">
            <li class="dropdown dropdown-dark" width="400px">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <h2><i class="fa fa-fw fa-map-marker" style="color: lightgreen;"></i><span class="username username-hide-on-mobile">  Voucher Type</span></h2>
                </a>
                 <ul class="dropdown-menu dropdown-menu-default">
                    <li>

<?php 
    if(isset($_POST['btn_submit'])){
        $v_code = @$_POST['txt_code'];
        $v_name = @$_POST['txt_name'];
        $v_note = @$_POST['txt_note'];        

        $query_add = "INSERT INTO tbl_acc_voucher_type_list (
                vot_code,
                vot_name,
                vot_note    
                ) 
            VALUES(
                '$v_code',
                '$v_name',
                '$v_note'
                )";
        if($connect->query($query_add)){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data inserted ...
            </div>'; 
        }else{
            $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> Query error ...
            </div>';   
        }
    }

 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h3><i class="fa fa-plus-circle fa-fw"></i>Create Voucher Type</h3>
        </div>
    </div>
    
    <br>
    <br>

    <div class="portlet-title">
        <div class="caption font-dark">
            <a href="index.php" id="sample_editable_1_new" class="btn red"> 
                <i class="fa fa-arrow-left"></i>
                Back
            </a>
        </div>
    </div>
    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Input Information</h3>
            </div>
            <div class="panel-body">
                 <form action="#" method="post" enctype="multipart/form-data">
                    <div class="form-body">


                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_code"  autocomplete="off">
                                    <label>Voucher Code :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_name"  autocomplete="off">
                                    <label>Voucher Name :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_note"  autocomplete="off">
                                    <label>Note :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_submit" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
                                <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>



                    </li>
                </ul>
        </div>
        <div class="col-xs-3">

                                <div class="form-group form-md-line-input">
                                    <select class="form-control" name="txt_category" required="required">
                                        <h2><option value="">=== Please Choose and Select ===</option></h2>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM  tbl_acc_voucher_type_list ORDER BY vot_name ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_data->vot_id.'">'.$row_data->vot_code.'|<br>|'.$row_data->vot_name.' / '.$row_data->vot_note.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>      
        </div>
        <div class="col-xs-6 text-right">
            <h1><a onclick="myFunction()"><i class="fa fa-fw fa-map-marker"></i></a></h1>
        </div>
</div>
      <!-- Small boxes (Stat box) -->
      <div class="row" id="myDIV">

        <?php
                        $get_data1 = $connect->query("SELECT 
                               A.*,A.vot_id, (select sum(arc_credit) from tbl_acc_cash_record_detail as B left join tbl_acc_cash_record as C on B.cash_rec_id=C.accdr_id
                               where C.vou_type_id=A.vot_id
                               ) as ac_credit
                            FROM   tbl_acc_voucher_type_list as A
                            ORDER BY vot_id DESC");
                        while ($row1 = mysqli_fetch_object($get_data1)) {

        echo '<div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">';
            if($row1->ac_credit>'0'){
        echo    '<h3>$ '.number_format($row1->ac_credit,2).'</h3>';
    }else{
        echo    '<h3>$ 0.00</h3>';
    }
        echo '<p><h4>'.$row1->vot_code.' == '.$row1->vot_name.'</h4></p>';
        echo '<p><h5>'.$row1->vot_note.'</h5></p>';
        echo '</div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>';
        }
        ?>
      </div>
      <!-- /.row -->
<br>
<div class="portlet light bordered">
    <div class="">
        <div class="caption font-dark">
            <a href="add.php" id="sample_editable_1_new" class="btn green"> Add New
                <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Vouch_Code</th>
                        <th>Voucher Name</th>
                        <th>Voucher Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                               *
                            FROM   tbl_acc_voucher_type_list
                            ORDER BY vot_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->vot_code.'</td>';
                                echo '<td>'.$row->vot_name.'</td>';
                                echo '<td>'.$row->vot_note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->vot_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   //echo '<a href="delete.php?del_id='.$row->accca_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

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
