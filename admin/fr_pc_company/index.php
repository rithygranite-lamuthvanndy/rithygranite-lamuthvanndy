<?php 
    $menu_active =13;
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
                    <h2><i class="fa fa-fw fa-map-marker" style="color: lightgreen;"></i><span class="username username-hide-on-mobile"> Work Site (ការដ្ឋាន)</span></h2>
                </a>
                 <ul class="dropdown-menu dropdown-menu-default">
                    <li>

<?php 
    if(isset($_POST['btn_submit'])){
        $v_code = @$_POST['txt_code'];
        $v_namekh = @$_POST['txt_namekh'];
        $v_nameen = @$_POST['txt_nameen'];
        $v_note = @$_POST['txt_note'];        

        $query_add = "INSERT INTO tbl_fr_pc_company (
                fpc_code,
                fpc_namekh,
                fpc_nameen,
                fpc_note    
                ) 
            VALUES(
                '$v_code',
                '$v_namekh',
                '$v_nameen',
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
                                    <label>ការដ្ឋាន Code :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_namekh"  autocomplete="off">
                                    <label>Name KH :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_nameen"  autocomplete="off">
                                    <label>Name EN :
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

        <section class="content-header">
            
            <h3><a onclick="myFunction()"><i class="fa fa-plus-circle fa-fw"></i>Show</a></h3>
              

        </section>
</div>
      <!-- Small boxes (Stat box) -->
      <div class="row" id="myDIV">

        <?php
                        $get_data1 = $connect->query("SELECT *, (select sum(frpc_amount) from tbl_fr_pc_expense WHERE frpc_company=fpc_id) as totol_fpt FROM tbl_fr_pc_company ORDER BY fpc_nameen ASC");
                        while ($row1 = mysqli_fetch_object($get_data1)) {

        echo '<div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">';
        echo    '<h3>$ '.number_format($row1->totol_fpt,2).'</h3>';
    
        echo '<p><h4>'.$row1->fpc_code.' == '.$row1->fpc_nameen.'</h4></p>';
        echo '<p><h5>'.$row1->fpc_note.'</h5></p>';
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
                        <th>ការដ្ឋាន_Code</th>
                        <th>ឈ្មោះការដ្ឋាន KH</th>
                        <th>ឈ្មោះការដ្ឋាន Name EN</th>
                        <th>សំគាល់ Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                               *
                            FROM   tbl_fr_pc_company
                            ORDER BY fpc_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->fpc_code.'</td>';
                                echo '<td>'.$row->fpc_namekh.'</td>';
                                echo '<td>'.$row->fpc_nameen.'</td>';
                                echo '<td>'.$row->fpc_note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->fpc_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
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
