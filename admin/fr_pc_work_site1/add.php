<?php 
    $menu_active =13;
    $left_active =52;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        $v_frpc_no = @$_POST['txt_frpc_no'];
        $v_date = @$_POST['txt_date'];
        $v_type = @$_POST['txt_type'];
        $v_disc = @$_POST['txt_disc'];
        $v_qty = @$_POST['txt_qty'];
        $v_un_pr = @$_POST['txt_un_pc'];
        $v_amount = @$_POST['txt_amount'];
        $v_note = @$_POST['txt_note'];
        $query_add = "INSERT INTO tbl_fr_pc_expense (
                frpc_no,
                frpc_date,
                frpc_type,
                frpc_description,
                frpc_qty,
                frpc_unit_price,
                frpc_amount,
                frpc_note
                ) 
            VALUES(
                '$v_frpc_no',
                '$v_date',
                '$v_type',
                '$v_disc',
                '$v_qty',
                '$v_un_pr',
                '$v_amount',
                '$v_note')";
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
            <h2><i class="fa fa-plus-circle fa-fw"></i>Create Record (FR/PC)</h2>
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

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                        <label>FR-PC/ប្រភេទសំណើរ * : </label>
                                        <select name="txt_type" id="input" class="form-control myselect2" required="required">
                                            <option value="">*** Select and choose ***</option>
                                            <?php 
                                                $v_result=$connect->query("SELECT * FROM tbl_fr_pc_type_list ORDER BY fpt_id");
                                                while ($row_select=mysqli_fetch_object($v_result)) {
                                                    echo '<option value="'.$row_select->fpt_id.'">'.$row_select->fpt_code.' || '.$row_select->fpt_name.'</option>';
                                                }
                                             ?>
                                        </select>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>FR/PC No : </label>
                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href='#add_modal' onclick="set_iframe_counter()"><i class="fa fa-plus"></i></a>
                                    <div class="btn btn-success btn-xs" id="refresh_cbo_counter"><i class="fa fa-refresh"></i></div>
                                    <input type="text" class="form-control" name="txt_frpc_no" readonly="">
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <label>Date : </label>
                                <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" required name="txt_date" value="<?= date('Y-m-d') ?>">   
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Description : </label>
                                    <input type="text" class="form-control" name="txt_disc"  autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <label>QTY : </label> 
                                <input type="text" class="form-control" name="txt_qty"  autocomplete="off">        
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <label>Unit Price : </label> 
                                <input type="text" class="form-control" name="txt_un_pc"  autocomplete="off">        
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Amount (USD) : </label>
                                    <input type="text" class="form-control" name="txt_amount"  autocomplete="off">
                                </div>
                            </div>
                        </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Note : </label>
                                    <textarea type="text" class="form-control" name="txt_note" rows="5"  autocomplete="off"></textarea>
                                </div>
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
        $('select[name=txt_type]').change(function () {
            var code_vouch=$(this).find('option:selected').attr('data_code');
            var v_date=my_getDate($('input[name=txt_date]').val());
            var vou_id=$(this).val();
            var myObject={
                cash_res_id:null,
                vou_code:code_vouch,
                v_date:v_date,
                vou_id:vou_id
            };
            
            var myString =JSON.stringify(myObject);
            $.ajax({type:'POST',url:"ajx_get_frpc_no.php",data:'data='+myString,success: function(result){
                var myObj=JSON.parse(result);
                // alert(result);
                $('input[name=txt_frpc_no]').val(myObj['vou_no']);
            }});
        });
        $('input[name=txt_date]').datepicker().on('changeDate', function (ev) {
            $(this).change();
            var v_date=my_getDate(new Date($(this).val()));
            var vou_id=$('select[name=txt_type]').val();
            var vou_id=$('select[name=txt_type]').val();
            code_vouch=$('select[name=txt_type]').find('option:selected').attr('data_code');
            var myObject={
                cash_res_id:null,
                vou_code:code_vouch,
                v_date:v_date,
                vou_id:vou_id
            };
            var myString =JSON.stringify(myObject);
            $.ajax({url:"ajx_get_frpc_no.php",type:'POST',data:'data='+myString,success: function(result){
                var myObj=JSON.parse(result);
                $('input[name=txt_frpc_no]').val(myObj['vou_no']);
            }});
        });
    });

</script>

<?php include_once '../layout/footer.php' ?>
