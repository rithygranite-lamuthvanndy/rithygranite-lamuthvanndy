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
        $v_date_record = @$_POST['txt_date_record'];
        $v_dir_tran_type = @$_POST['txt_dir_tran_type'];
        $v_debit = @$_POST['txt_debit'];
        $v_credit = @$_POST['txt_credit'];
        $v_note = @$_POST['txt_note'];

        $query_add = "INSERT INTO tbl_acc_director_transation (
                date_record,
                ditector_type_id,
                debit,
                credit,
                note
                ) 
            VALUES
                (
                '$v_date_record',
                '$v_dir_tran_type',
                '$v_debit',
                '$v_credit',
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
                 <form action="#" method="post" enctype="multipart/form-data" autocomplete="off">
                    <div class="form-body">
                       <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Date : </label>
                                    <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" required name="txt_date_record" value="<?= date('Y-m-d') ?>">
                                </div>
                                <div class="form-group">
                                    <label>Director Transation Type : </label>
                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#description'><i class="fa fa-plus"></i></a>
                                    <select name="txt_dir_tran_type" id="input" class="form-control" required="required">
                                        <option value="">=== Select and Choose here ===</option>
                                        <?php 
                                            $sql=$connect->query("SELECT id,name FROM tbl_acc_director_tran_type ORDER BY name ASC");
                                            while ($row=mysqli_fetch_object($sql)) {
                                                echo '<option value="'.$row->id.'">'.$row->name.'</option>';
                                            }
                                         ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Debit :</label>
                                    <input type="text" class="form-control" required name="txt_debit" value="0">
                                </div>
                                <div class="form-group">
                                    <label>Credit : </label>
                                    <input type="text" class="form-control" required name="txt_credit" value="0">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Balance : </label>
                                    <input type="text" readonly="" class="form-control" required name="txt_balance" value="0">
                                </div>
                                <div class="form-group">
                                    <label>Note : </label>
                                    <textarea class="form-control" rows="8" autocomplete="off" name="txt_note"></textarea>
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
<script type="text/javascript" src="../../assets/global/plugins/jquery.min.js"></script>
<script type="text/javascript">
    $('input[name="txt_debit"],input[name="txt_credit"]').keyup(function(){
        $c_in = $('input[name="txt_debit"]').val();
        $c_out =$('input[name="txt_credit"]').val();
        $('input[name="txt_balance"]').val($c_in-$c_out);
    });
    $('select[name=txt_dir_tran_type]').click(function(){
        $.ajax({url: "ajx_get_content_select.php?d=txt_dir_tran_type", success: function(result){
            if($('select[name=txt_dir_tran_type]').html().trim() != result.trim()){
                $('select[name=txt_dir_tran_type]').html(result);
            }
        }});
    });
    
</script>
<?php include_once '../layout/footer.php' ?>
<div class="modal fade" id="description">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_dir_tra_typ.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>