<?php 
    $menu_active =101;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
    if(@$_GET['sent_id']!=""){
        $edit_id = @$_GET['sent_id'];
    }
    if(isset($_POST["btn_add"])){
        $v_joiner = @$_POST["cbo_joiner"];
        $v_id = @$_POST["txt_id"];
        // echo $v_joiner;
        foreach ($v_joiner as $key => $value) {
            if($value){
                $new_join=$v_joiner[$key];
                $sql="INSERT INTO tbl_meeting_add_joiner_name 
                (
                ajn_meeting_no,
                ajn_name
                )
                VALUES
                (
                '$v_id',
                '$new_join'
                )
                ";
                $result = mysqli_query($connect, $sql);
            }
        }
        if($result){
                $sms = '<div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Successfull!</strong> Data inserted ...
                </div>';
                // header("Refresh:2; url=index.php");   
            }else{
                $sms = '<div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Error!</strong> Query error ...
                </div>';
                // header("Refresh:0; url=add.php");    
            }
    }
 ?>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-user fa-fw"></i>Add New Joiner</h2>
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
                     <input type="hidden" name="txt_id" value="<?= $edit_id ?>">
                    <div class="form-body">
                        <div class="clearfix"></div>
                          <div class="clearfix"></div>
                          <div class="form_base">
                            <div class="form_row">
                              <div class="form-group col-xs-6" style="padding-left: 0px">   
                                <div class="form-group">
                                  <label for="input" class="col-sm-4 control-label">Joiner Name:</label>
                                  <div class="col-sm-8">
                                      <select name="cbo_joiner[]" id="input" class="form-control" required="required">
                                          <option value="">=== Select Joiner Here ===</option>
                                          <?php 
                                            $sql=$connect->query("SELECT * FROM tbl_meeting_name_list   ORDER BY mnl_name ASC");
                                            while($row_add=mysqli_fetch_object($sql)){
                                                echo '<option value="'.$row_add->mnl_id.'">'.$row_add->mnl_name.'</option>';

                                            }
                                           ?>
                                      </select>
                                  </div>
                                </div>         
                              </div>
                              <div class="clearfix"></div>
                               </div>
                          </div>
                          <div class="form_add_result"> </div>
                          <div class="row">
                            <div class="col-md-6">
                                <div class="text-center">
                                    <button type="button" id="btn_add_form" class="btn btn-primary">Add <i class="fa fa-plus fa-fw"></i></button>
                                </div>
                            </div>
                          </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 col-sm-6 col-md-6 col-lg-6 text-center">
                                <button type="submit" name="btn_add" class="btn blue"><i class="fa fa-save fa-fw"></i> Save</button>
                                <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i> Cancel</a>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>
<script src="../../assets/global/plugins/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
  $('#btn_add_form').click(function(){
    $('.form_add_result').append($('.form_base').html());
    ch_pd();
  });
</script>
<?php include_once '../layout/footer.php' ?>
