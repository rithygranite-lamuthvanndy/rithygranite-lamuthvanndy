<?php 
    $menu_active =141;
    $left_active =0;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    if(@$_GET['view']=='iframe')
        include_once '../layout/header_frame.php';
    else
        include_once '../layout/header.php';
?>

<?php 
// get old data 
    $edit_id = @$_SESSION['user']->user_id;
    $old_data = $connect->query("SELECT * FROM tbl_user WHERE user_id='$edit_id'");
    $row_old_data = mysqli_fetch_object($old_data);
?>

<?php 
    if(isset($_POST['btn_submit'])){
                $v_fam_id_code = @$_POST['txt_search'];
                $v_fam_desc = @$_POST['txt_des_gi'];
                $v_fam_cost = @$_POST['txt_cost_gi'];
                $v_fam_unit = @$_POST['txt_unit_gi'];
                $v_fam_model = @$_POST['txt_model_gi'];
                $v_fam_serial = @$_POST['txt_serial_gi'];
                $v_fam_barcode = @$_POST['txt_bar_gi'];
                $v_fam_condition = @$_POST['txt_cond_gi'];
                $v_fam_note = @$_POST['txt_note_gi'];
                $v_fam_photo = @$_POST['txt_pic_pi'];
                $v_fam_desc_pho = @$_POST['txt_desc_pi'];
                $v_fam_location = @$_POST['cbo_locat_li'];
                $v_fam_section = @$_POST['cbo_sect_li'];
                $v_fam_depart = @$_POST['cbo_depart_li'];
                $v_fam_group = @$_POST['cbo_group_li'];
                $v_fam_date_acquired = @$_POST['txt_date_acq_di'];
                $v_fam_date_inservice = @$_POST['txt_date_inser_di'];
                $v_fam_date_sold = @$_POST['txt_date_sold_di'];
                $v_fam_sold_id = @$_POST['check_sold_di'];
                $v_user_id = @$_SESSION['user']->user_id;
        $query_add = "INSERT INTO  tbl_fam_nfa_1_ar(
                fam_id_code,
                fam_desc,
                fam_cost,
                fam_unit,
                fam_model,
                fam_serial,
                fam_barcode,
                fam_condition,
                fam_note,
                fam_photo,
                fam_desc_pho,
                fam_location,
                fam_section,
                fam_depart,
                fam_group,
                fam_date_acquired,
                fam_date_inservice,
                fam_date_sold,
                fam_sold_id,
                user_id                     
                ) 
            VALUES(
                '$v_fam_id_code',
                '$v_fam_desc',
                '$v_fam_cost',
                '$v_fam_unit',
                '$v_fam_model',
                '$v_fam_serial',
                '$v_fam_barcode',
                '$v_fam_condition',
                '$v_fam_note',
                '$v_fam_photo',
                '$v_fam_desc_pho',
                '$v_fam_location',
                '$v_fam_section',
                '$v_fam_depart',
                '$v_fam_group',
                '$v_fam_date_acquired',
                '$v_fam_date_inservice',
                '$v_fam_date_sold',
                '$v_fam_sold_id',
                '$v_user_id'
                )";
        if($connect->query($query_add)){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data inserted ...
            </div>'; 
        }else{
            $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> '.$connect->error.'
            </div>';   
        }
    }

 ?>


<div class="portlet light bordered">
  
                    <section class="content-header">                       
                            <div class="col-lg-8">
                                <?= @$sms ?>
                                <div class="col-lg-2">
                                    <img src="../../img/img_nfa/nfa.png" alt="" width="100px">
                                </div>
                                <div class="col-lg-8">
                                    <h2><b>Asset Registering</b></h2>
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <a href="index.php" id="sample_editable_1_new" class="btn red"> 
                                                <i class="fa fa-arrow-left"></i>
                                                Back
                                            </a>
                                        </div>
                                    </div><BR>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <label>Asset ID* </label>
                                <div class="input-group margin">
                                    <input type="text" class="form-control" name="txt_search">
                                    <span class="input-group-btn">
                                            <button type="button" name="btn_search_id1" class="btn btn-info btn-flat">Search!</button>
                                    </span>
                                </div>
                            </div>

                    </section>
                    <hr>
        <div class="panel-body">
                 <form action="#" method="post" enctype="multipart/form-data">
                    <div class="form-body">

                        <div class="row">
                            <div class="col-sm-8">
                                <div class="col-sm-6">
                                                            
                                    <div class="box box-warning direct-chat direct-chat-warning">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><b>General Information</b></h3>
                                            <div class="box-tools pull-right">
                                               
                                            </div>
                                        </div>
                                            <div class="form-group">

                                                <div class="col-md-12">
                                                    <label>Asset ID* </label>
                                                    <div class="input-group margin">
                                                        <input type="text" class="form-control" name="txt_search">
                                                        <span class="input-group-btn">
                                                                <button type="button" name="btn_search_id" class="btn btn-info btn-flat">Search!</button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12">
                                                    <label><i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i> Description : </label>
                                                    <input type="text" class="form-control" name="txt_des_gi" required=""  autocomplete="off">
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label><i class="fa fa-fw fa-dollar"></i> Cost : </label>
                                                        <input type="text" class="form-control" name="txt_cost_gi" required=""  autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label><i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i> Unit : </label>
                                                        <input type="text" class="form-control" name="txt_unit_gi" required=""  autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label><i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i> Model* : </label>
                                                        <input type="text" class="form-control" name="txt_model_gi" required=""  autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label><i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i> Serial# : </label>
                                                        <input type="text" class="form-control" name="txt_serial_gi" required=""  autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label><i class="fa fa-barcode"></i> Barcode : </label>
                                                        <input type="text" class="form-control" name="txt_bar_gi" required=""  autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label><i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i> Condition : </label>
                                                        <input type="text" class="form-control" name="txt_cond_gi" required=""  autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <label><i class="fa fa-sticky-note"></i> Note : </label>
                                                    <textarea name="txt_note_gi" rows="5" class="form-control"></textarea>
                                                    <br>
                                                </div>

                                            </div>
                                        
                                    </div>
                         
                                </div>
                               
                                <div class="col-sm-6">
                                    <div class="box box-warning direct-chat direct-chat-warning">
                                            <div class="box-header with-border">
                                                <h3 class="box-title"><b>Location Information</b></h3>
                                                <div class="box-tools pull-right">
                                                    
                                                </div>
                                            </div>
                                            
                                                <div class="form-group">
                                                    <label><i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i> Location* : </label>
                                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#modal' onclick="view_iframe_location()"><i class="fa fa-plus"></i></a>
                                                    <select type="text" class="form-control myselect2" name="cbo_locat_li" required="" autocomplete="off">
                                                        <option value="">=== Select and choose===</option>
                                                        <?php
                                                        $get_select = $connect->query("SELECT * FROM tbl_fix_locat ORDER BY locat_name ASC");
                                                        while ($row_data = mysqli_fetch_object($get_select)) {
                                                            echo '<option value="' . $row_data->locat_id . '">' . $row_data->locat_name . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label><i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i> Section* : </label>
                                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#modal' onclick="view_iframe_section()"><i class="fa fa-plus"></i></a>
                                                    <select type="text" class="form-control myselect2" name="cbo_sect_li" required="" autocomplete="off">
                                                        <option value="">=== Select and choose===</option>
                                                        <?php
                                                        $get_select1 = $connect->query("SELECT * FROM tbl_fix_section ORDER BY sect_name ASC");
                                                        while ($row_data1 = mysqli_fetch_object($get_select1)) {
                                                            echo '<option value="' . $row_data1->sect_id . '">' . $row_data1->sect_name . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label><i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i> Department* : </label>
                                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#modal' onclick="view_iframe_depart()"><i class="fa fa-plus"></i></a>
                                                    <select type="text" class="form-control myselect2" name="cbo_depart_li" required="" autocomplete="off">
                                                        <option value="">=== Select and choose===</option>
                                                        <?php
                                                        $get_select2 = $connect->query("SELECT * FROM tbl_fix_depart ORDER BY dep_name ASC");
                                                        while ($row_data2 = mysqli_fetch_object($get_select2)) {
                                                            echo '<option value="' . $row_data2->dep_id . '">' . $row_data2->dep_name . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label><i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i> Group* : </label>
                                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#modal' onclick="view_iframe_group()"><i class="fa fa-plus"></i></a>
                                                    <select type="text" class="form-control myselect2" name="cbo_group_li" required="" autocomplete="off">
                                                        <option value="">=== Select and choose===</option>
                                                        <?php
                                                        $get_select3 = $connect->query("SELECT * FROM tbl_fix_group ORDER BY gr_name ASC");
                                                        while ($row_data3 = mysqli_fetch_object($get_select3)) {
                                                            echo '<option value="' . $row_data3->gr_id . '">' . $row_data3->gr_name . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            <div class="box box-primary">
                                                <div class="box-header">
                                                    <h4 class="panel-title"><b>Date Information</b></h4>
                                                </div>

                                                    <div class="form-group">
                                                        <label><i class="fa fa-calendar-times-o"></i> Acquired* : </label>
                                                        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                                            <input type="text" class="form-control" value="<?= date('Y-m-d') ?>" name="txt_date_acq_di" placeholder="Choose Date" required="" aufocomplete="off">
                                                            <div class="input-group-addon">
                                                                <span class="glyphicon glyphicon-th"></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label><i class="fa fa-calendar-times-o"></i> In Service : </label>
                                                        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                                            <input type="text" class="form-control" value="<?= date('Y-m-d') ?>" name="txt_date_inser_di" placeholder="Choose Date" required="" aufocomplete="off">
                                                            <div class="input-group-addon">
                                                                <span class="glyphicon glyphicon-th"></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label><i class="fa fa-calendar-times-o"></i> Sold :  <input type="checkbox" name="check_sold_di"  value="1"> <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                                            <input type="text" class="form-control" value="<?= date('Y-m-d') ?>" name="txt_date_sold_di" placeholder="Choose Date" required="" aufocomplete="off">
                                                            <div class="input-group-addon">
                                                                <span class="glyphicon glyphicon-th"></span>
                                                            </div>
                                                        </div><br>
                                                    </div>
                                                    
                                            </div>       
                                    </div>
                                </div> 
                            </div>

                            <div class="col-sm-4">
                                <div class="box box-warning direct-chat direct-chat-warning">
                                    <div class="box-header with-border">
                                            <h3 class="panel-title"><b>Picture Information</b></h3>
                                    </div>
                                        
                                                <input type="hidden" name="txt_id" value="<?= $row_old_data->user_id ?>">
                                                <input type="hidden" name="txt_old_img" value="<?= $row_old_data->user_photo ?>">
                                                <div class="form-body">                                                    
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <div class="form-group">
                                                                <label>Preview Image <span class="required" aria-required="true">*</span> </label>
                                                                <div id="uploaded_image">
                                                                    <img width="100%" src="../../img/img_user/<?= $row_old_data->user_photo ?>" class="img-responsive img-responsive img-thumbnail" alt="Image">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label><i class="fa fa-file-image-o"></i> New Image <span class="required" aria-required="true">*</span> </label>
                                                                <input type="file" class="form-control" name="txt_pic_pi" placeholder="Enter your email" autocomplete="off" required="" id="upload_image">
                                                            </div>
                                                            <div class="form-group">
                                                                <label><i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i> Description : </label>
                                                                <input type="text" class="form-control" name="txt_desc_pi" required=""  autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                        
                                        
                                </div>
                            </div>


                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" name="btn_prev" style="width: 100px;" class="btn bg-maroon btn-flat margin"><i class="fa fa-arrow-left"></i> Previous</button>
                                    <button type="submit" name="btn_next" style="width: 100px;"  class="btn bg-purple btn-flat margin"><i class="fa  fa-arrow-right"></i> Next</button>
                                    <button type="submit" name="btn_find" style="width: 100px;"  class="btn bg-navy btn-flat margin"><i class="fa fa-binoculars"></i> Find</button>
                                    <button type="submit" name="btn_print" style="width: 100px;"  class="btn bg-orange btn-flat margin"><i class="fa fa-print"></i> Print</button>
                                   
                                    <button type="submit" name="btn_submit" style="width: 100px;"  class="btn bg-olive btn-flat margin"><i class="fa fa-fw fa-save"></i> Add</button>
                                    <button type="submit" name="btn_exit" style="width: 100px;"  class="btn bg-maroon btn-flat margin"><i class="fa fa-edit"></i> Edit</button>
                                    <button type="submit" name="btn_dele" style="width: 100px;"  class="btn bg-purple btn-flat margin"><i class="fa fa-fw fa-remove"></i> Delete</button>
                                    <button type="submit" name="btn_exit" style="width: 100px;"  class="btn bg-navy btn-flat margin"><i class="fa fa-fw fa-close"></i> Exit</button>
                                    <br>
                                </div>
                            </div>
                        </div>           
        </form>
    </div>
</div>


<script>
    function view_iframe_location() {
        document.getElementById('result_modal').src = '../fix_location/index.php?view=iframe';
    }
</script>

<?php
if (@$_GET['view'] == 'iframe')
    include_once '../layout/footer_frame.php';
else
    include_once '../layout/footer.php';
?>
<script src="../../js/croppie.js"></script>
<link rel="stylesheet" href="../../css/croppie.css" />

<div id="uploadimageModal" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Upload & Crop Image</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8 text-center">
                          <div id="image_demo" style="width:350px; margin-top:30px"></div>
                    </div>
                    <div class="col-md-4" style="padding-top:30px;">
                        <br />
                        <br />
                        <br/>
                          <button class="btn btn-success crop_image">Crop & Upload Image</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>  
$(document).ready(function(){

    $image_crop = $('#image_demo').croppie({
    enableExif: true,
    viewport: {
      width:250,
      height:300,
      type:'square' //circle
    },
    boundary:{
      width:350,
      height:400
    }
  });

  $('#upload_image').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      $image_crop.croppie('bind', {
        url: event.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
    $('#uploadimageModal').modal('show');
  });

  $('.crop_image').click(function(event){
    $image_crop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function(response){
      $.ajax({
        url:"upload.php",
        type: "POST",
        async:false,
        data:{"image": response},
        success:function(data)
        {   
          $('#uploadimageModal').modal('hide');
          $('#uploaded_image').html(data);
        }
      });
    })
  });

});  
</script>
<script type="text/javascript">
    Dropzone.autoDiscover = false;

    var myDropzone = new Dropzone(".dropzone", {
        autoProcessQueue: false,
        acceptedFiles: "image/jpeg,image/png,image/gif",
        addRemoveLinks: true,
        parallelUploads: 1 // Number of files process at a time (default 2)

    });

    $('button[name=btn_submit]').click(function() {
        myDropzone.processQueue();
    });

    $('select[name=cbo_locat_li]').change(function(event) {
        v_sect_locat = $(this).find('option:selected').val();
        $.get('ajax_get_content_select.php?cbo_sect_li=cbo_sect_li&p_sect_locat=' + v_sect_locat, function(data) {
            $('select[name=cbo_sect_li]').html(data);
        });

        $.get('ajax_get_content_select.php?cbo_pro_type=cbo_pro_type&p_materail_type_id=' + v_material_type, function(data) {
            $('select[name=cbo_pro_type]').html(data);
        });
    });
</script>

<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg" style="width: 70%;">
        <div class="modal-content">
            <div class="modal-body">
                <iframe id="result_modal" src="" width="100%" style="min-height: 600px; resize: vertical;" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>