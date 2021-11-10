<?php 
    $menu_active =120;
    $left_active =0;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        $cus_name = @$_POST['txt_name'];
        $cus_tell = @$_POST['txt_tell'];
        $cus_date_record = @$_POST['txt_date'];
        $cus_procode = @$_POST['txt_procode'];
        $cus_desc = @$_POST['txt_desc'];
        $cus_quantiy = @$_POST['txt_quanity'];
        $cus_unitprice = @$_POST['txt_unitprice'];
        $cus_amount = @$_POST['txt_amount'];
        

        $query_add = "INSERT INTO tbl_customer_order (
                cus_name,
                cus_tell,
                cus_date_record,
                cus_pro_code,
                cus_descripiton,
                cus_quantiy,
                cus_unitprice,
                cus_amount,
                ) 
            VALUES(
                '$cus_name',
                '$cus_tell',
                '$cus_date_record',
                '$cus_procode',
                '$cus_desc',
                '$cus_quanity';
                '$cus_unitprice',
                '$cus_amount',

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
                                <div class="form-group">
                                    <label>Date Record :
                                    </label>
                                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                        <input type="text" class="form-control" placeholder="Choose Date" required="" aufocomplete="off" name="txt_date">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Name : </label>
                                    <input type="text" class="form-control" name="txt_name" required=""  autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Pro_Code : </label>
                                    <input type="text" class="form-control" name="txt_procode" required=""  autocomplete="off">
                                </div>
                                
                                <div class="form-group">
                                    <label>Phone Number : </label>
                                    <input type="text" class="form-control" name="txt_tell" required="" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Unit Price : </label>
                                    <input type="text" class="form-control" name="txt_unitprice" required="" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Amount : </label>
                                    <input type="text" class="form-control" name="txt_amount" required="" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Description : </label>
                                    <textarea type="text" class="form-control" name="txt_desc" style="height: 163px;" autocomplete="off"></textarea>
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


<?php include_once '../layout/footer.php' ?>
