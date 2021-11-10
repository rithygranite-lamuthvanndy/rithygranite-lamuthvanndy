<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        $txt_from = @$_POST['txt_from'];
        $txt_to = @$_POST['txt_to'];
        $txt_rate = @$_POST['txt_rate'];
        $txt_description = @$_POST['exchange_from'].'-'.@$_POST['exchange_to'];
        $txt_note = @$_POST['txt_note'];
        $v_user_id = @$_SESSION['user']->user_id;
        $today=date("Y-m-d  h:i:s");
        

        $query_add = "INSERT INTO tbl_exchange_rate (
                user_id,
                description,
                rate,
                note,
                from_date,
                to_date,
                date_note,
                date_update
                ) 
            VALUES(
                '$v_user_id',
                '$txt_description',
                '$txt_rate',
                '$txt_note',
                '$txt_from',
                '$txt_to',
                '$today',
                '$today'
                )";
        if($connect->query($query_add)){
            echo '<script>myAlertSuccess("Creating");</script>';
            // $sms = '<div class="alert alert-success">
            // <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            //     <strong>Successfull!</strong> Data inserted ...
            // </div>'; 
        }else{
            echo '<script>myAlertError("'.mysqli_error($connect).'");</script>';
            // $sms = '<div class="alert alert-danger">
            // <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            //     <strong>Error!</strong> Query error ....
            // </div>';   
        }
    }

 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Create Record</h2>
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
                                    <input type="text" class="form-control" name="txt_from" value="<?=date('Y-m-d');?>" autocomplete="off" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                    <label>From :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                             <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_to" id="date_to" autocomplete="off" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                    <label>Expire :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Exchange from</label><br>
                                <select id="exchange_from" name="exchange_from" style="width: 20%;">
                                    <option value="Dollar">Dollar</option>
                                    <option value="Riel">Riel</option>
                                    <option value="Dong">Dong</option>
                                    <!-- <option value="Yuan">Yuan</option> -->
                                </select>

                                <br><br>

                                <input type="text" class="form-control" name="m_from" value="1" autocomplete="off">
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>To</label><br>
                                <select id="exchange_to" name="exchange_to" style="width: 20%;">
                                   
                                </select>

                                <br><br>
                                
                                <input type="text" class="form-control" name="txt_rate" id="exchange_to_inp" autocomplete="off">
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <textarea class="form-control" name="txt_note">
                                        
                                    </textarea>
                                    
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


<script type="text/javascript" src="../../plugin/ckeditor_4.7.0_full/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace( 'detail', {
        language: 'en',
      height: '700'
        // uiColor: '#9AB8F3'
    });
</script>

<script>
    $(document).ready(function(){
        var exchange_from = $('#exchange_from');

        var ex_form = ['<option value="Riel">Riel</option><option value="Dong">Dong</option><option value="Yuan">Yuan</option>','<option value="Dong">Dong</option><option value="Yuan">Yuan</option>','<option value="Yuan">Yuan</option>'];

        var t = $('#exchange_from option:selected').text();
        if(t=="Dollar")
        {
            $('#exchange_to').html(ex_form[0]);
            $('#exchange_to_inp').focus();
        }

        exchange_from.on('change', function(){
            // var text = $(this option:selected).text();
            var text = $("#exchange_from option:selected").text();
            
            if(text=='Dollar')
            {
                $('#exchange_to').html(ex_form[0]);
            }
            else if(text=='Riel')
            {
                $('#exchange_to').html(ex_form[1]);
            }
            else if(text=='Dong')
            {
                $('#exchange_to').html(ex_form[2]);
            }

            $('#exchange_to_inp').focus();
        });
        
    });
</script>


<?php include_once '../layout/footer.php' ?>
