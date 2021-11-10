<?php 
    $menu_active =140;
    $left_active =0;
    $layout_title = "Create Stock In";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
    if(@$_SESSION['save_call_back']){
        $sms='<div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Success !</strong> Creating record
            </div>';
        $_SESSION['save_call_back']=null;
    }
    if(isset($_GET['f']))
    {
        $f = $_GET['f'];
        echo('<input type="text" id="f" value='.$f.'>');
    }
 ?>
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
        </div>
    </div>
    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    
                    Non Fixed Asset Disposal
                </h3>
            </div>
            <div class="panel-body">
                <div class="col-lg-12">
                    <form class="upl" method="post" enctype="multipart/form-data">
                        <!-- block 1 -->
                        <div class="col-lg-12" style="margin-top: 10px;">
                            <div class="row">
                                <div class="col-lg-6" id="1cat_container">
                                    <div class="form-group row">
                                    
                                        
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label for="colFormLabel" class="col-sm-2 col-form-label" style="color: black;">Asset ID</label>
                                        <div class="col-sm-6" id="cat_container">
                                            <select name="asset_cat1" id="asset_cat1" class="form-control" style="display:none;">
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end block 1 -->

                        <!-- block 2 -->
                        <div class="col-lg-12">
                            <div id="form1">
                                
                            </div>
                        </div>
                        <!-- end block 2 -->

                        <!-- button -->
                        <div class="col-lg-12" style="margin-bottom: 10px;">
                            <input type="button" id="btn_previous" value="Previous" class="btn btn-primary" style="margin-left: 10px;">
                            <input type="button" id="btn_next" value="Next" class="btn btn-primary" style="margin-left: 10px;">
                            <input type="button" id="btn_fine" value="Find" class="btn btn-primary" style="margin-left: 10px;">
                            <input type="button" id="btn_print" value="Print" class="btn btn-primary" style="margin-left: 10px;">
                            <input type="button" id="btn_add" class="btn btn-primary" style="margin-left: 10px;" value="ADD">
                            <!-- <a class="btn btn-danger" style="margin-right: 4px;" id="btn_add1">Post</a> -->
                            <input type="button" id="btn_edit" value="Edit" class="btn btn-primary" style="margin-left: 10px;">
                            <input type="button" id="btn_delete" value="Delete" class="btn btn-primary" style="margin-left: 10px;">
                            <input type="button" id="btn_exit" value="Exit" class="btn btn-primary" style="margin-left: 10px;">
                        </div>
                        <!-- end button -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once '../layout/footer.php' ?>
<script type="text/javascript">
    $(document).ready(function()
    {
        var body = $('body');

        // entry 1
        var assetID = $('#asset_id');
        var des1 = $('#des1');
        var cost = $('#cost');
        var model = $('#model');
        var barcode = $('#barcode');
        var unit = $('#unit');
        var serial = $('#serial');
        var condi = $('#condi');
        var note = $('#note');

        var pic = $('#pic');
        var des2 = $('#des2');

        var location = $('#location');
        var section = $('#section');
        var department = $('#department');
        var gp = $('#gp');
        var acq = $('#acq');
        var in_service = $('#in_service');
        var sold = $('#sold');
        // end entry 1

        var form4; // store form3 layout
        var form3; // store form3 layout
        var form2; // store form2 layout
        var form1; // store form1 layout
        var form1_1; //* store form1 after click on btn next
        var form2_2; //* store form2 after click on btn previouse

        var last_id;

        // entry 2
        var assign_to;
        var assign_date;
        var lst2;
        var ass;
        var assign_to_val;
        var id; // table edit data last id
        var tr_ind; // store tr index when editing
        // end entry 2

        // entry page 3
        var adj = $('#adj');
        var remark = $('#remark');
        var lst3;
        var adj_text;
        var adj_val;
        var ass_last_id;
        // end entry page 3

        // entry page 4
        var lst4;
        // end entry page 4

        var isedit = 0;  // compare condition for edit data list
        

        var form_action = 1; // note for form active (using now)

        var f = body.find('#f').val();  // get form when user click left menu

        // get assign to person -
        $.ajax({
            url:'get/getassignperson.php',
            type:'POST',
            data:{},
            cache:false,
            dataType:'json',
            success: function(data)
            {
                // alert(data.ass);
                ass = data.ass;
            }
        });

        // set form default
        $.ajax({
            url:'frm/entry2_des.php',
            type:'POST',
            data:{},
            cache: false,
            success: function(data)
            {
                if(f!=2 && f!=3)
                {
                    $('#form1').html(data);
                    body.find(".datepicker").datepicker();
                    form1 = $('#form1').html();  // store entry 1 before input any data

                    getassetidforchoose();

                    body.find('#cat_container input').css({'display':'none'});
                    body.find('#cat_container select').css({'display':'block'});

                    body.find('#1cat_container').css({'display':'none'});
                }
            }
        });
        // auto get entry 2 when page start load
        $.ajax({
            url:'frm/entry2.php',
            type:'POST',
            data:{},
            cache: false,
            success: function(data)
            {
                if(f==2)
                {
                    getassetidforchoose();

                    body.find('#cat_container input').css({'display':'none'});
                    body.find('#cat_container select').css({'display':'block'});

                    body.find('#1cat_container').css({'display':'none'});

                    $('#form1').html(data);
                    form_action=2;
                    body.find('#btn_reg').css({'background-color':''});
                    body.find('#btn_assign').css({'background-color':'red'});
                    body.find('#btn_write').css({'background-color':''});
                    body.find('#btn_view').css({'background-color':''});

                    body.find('#assign_to').html(ass); // put assign to person to ASSIGNING
                }
                form2 = data;
            }
        });

        $.ajax({
            url:'frm/entry1.php',
            type:'POST',
            data:{},
            cache: false,
            success: function(data)
            {
                form1 = data;
            }
        });
        // auto get entry 3 when page start load
        $.ajax({
            url:'frm/entry3.php',
            type:'POST',
            data:{},
            cache: false,
            success: function(data)
            {
                if(f==3)
                {
                    getassetidforchoose();

                    body.find('#cat_container input').css({'display':'none'});
                    body.find('#cat_container select').css({'display':'block'});

                    body.find('#1cat_container').css({'display':'none'});

                    $('#form1').html(data);
                    form_action=3;
                    body.find('#btn_reg').css({'background-color':''});
                    body.find('#btn_assign').css({'background-color':''});
                    body.find('#btn_write').css({'background-color':'red'});
                    body.find('#btn_view').css({'background-color':''});

                    body.find('#remark').val($('#adj option:selected').val());
                }
                form3 = data;
            }
        });
        // auto get entry 4 when page start load
        $.ajax({
            url:'frm/entry4.php',
            type:'POST',
            data:{},
            cache: false,
            success: function(data)
            {
                form4 = data;
            }
        });

        // btn save data
        body.on('click','#btn_add',  function()
        {
            var id = body.find("#asset_cat1").val();
            var eThis = $(this);
            var frm = eThis.closest('form.upl');
            var frm_data = new FormData(frm[0]);
            save(frm_data);
        });

        // btn_next
        body.on('click', '#btn_next', function(e)
        {
            // clear tap color
            body.find('#btn_reg').css({'background-color':''});
            body.find('#btn_assign').css({'background-color':''});
            body.find('#btn_write').css({'background-color':''});
            body.find('#btn_view').css({'background-color':''});
            
            if(form_action<=3)
            {
                form_action+=1;
                if(form_action==2)
                {
                    $('#form1').html(form2); // append entry page 2 to form2list

                    getassetidforchoose();

                    body.find('#cat_container input').css({'display':'none'});
                    body.find('#cat_container select').css({'display':'block'});

                    body.find('#1cat_container').css({'display':'none'});

                    body.find('#last_id').val(last_id); // set last_id to Assigning page

                    body.find('#isedit').val(0);  // set condition to control for edit or add new
                    
                    body.find('#btn_assign').css({'background-color':'red'}); // set tap action color

                    body.find('#assign_to').html(ass); // put assign to person to ASSIGNING

                    

                    body.find(".datepicker").datepicker();
                    

                }
                else if(form_action==3)
                {
                    // lst2 = body.find('#form2list').html(); // get list from Assigning page before form3 put

                    $('#form1').html(form3); // set Written of page

                    getassetidforchoose();
                    
                    body.find('#last_id').val(last_id); // set last_id to Assigning to

                    body.find('#isedit').val(0);

                    body.find("#ass_id").val(ass_last_id);

                    body.find('#remark').val($('#adj option:selected').val());
                    
                    body.find('#btn_write').css({'background-color':'red'}); // set tap action color

                    // body.find('#form2list').html(lst3); // use for put list to Written of page when btn_previous clicked

                }
                else if(form_action==4)
                {
                    // lst3 = body.find('#form2list').html(); // get list from Written page before form4 put
                    body.find('#btn_view').css({'background-color':'red'}); // set tap action color
                    $('#form1').html(form4);

                    getassetidforchoose();

                    // var assetid = body.find('#asset_cat1 option:selected').val();
                    // alert(assetid);
                    // $.ajax({
                    //     url:'get/getview.php',
                    //     type:'POST',
                    //     data:{assetid:assetid},
                    //     cache:false,
                    //     dataType:'json',
                    //     success: function(data)
                    //     {
                    //         $('#form2list').find('tr:eq(0)').after(data.msg);
                    //     }
                    // });
                }
               
            }
            else
            {
                alert('hey');
                body.find('#btn_view').css({'background-color':'red'}); // set tap action color
                return;
            }
        });

        // btn previous
        body.on('click','#btn_previous', function(e)
        {      
            if(form_action<2)
            {
                return;
            }
            form_action-=1;
            if(form_action==1)
            {
                $('#form1').html(form1); // put old entry 1

                body.find('#cat_container input').css({'display':'block'});
                body.find('#cat_container select').css({'display':'none'});

                body.find('#1cat_container').css({'display':'block'});

                body.find('#btn_reg').css({'background-color':''});
                body.find('#btn_assign').css({'background-color':''});
                body.find('#btn_write').css({'background-color':''});
                body.find('#btn_view').css({'background-color':''});
                body.find('#btn_reg').css({'background-color':'red'}); // set tap action color

                
            }
            else if(form_action==2)
            {
                // lst2 = body.find('#form2list').html();

                $('#form1').html(form2); // put old entry 2

                body.find(".datepicker").datepicker();

                body.find('#last_id').val(last_id); // set last_id to Assigning to

                body.find('#isedit').val(0);

                body.find('#btn_reg').css({'background-color':''});
                body.find('#btn_assign').css({'background-color':''});
                body.find('#btn_write').css({'background-color':''});
                body.find('#btn_view').css({'background-color':''});
                body.find('#btn_assign').css({'background-color':'red'}); // set tap action color


                body.find('#assign_to').html(ass); // put person for ASSIGNING
                var assetid = body.find('#asset_cat1 option:selected').val();
                getdataofform2(assetid, 2);
            }
            else if(form_action==3)
            {
                $('#form1').html(form3);

                body.find('#last_id').val(last_id); // set last_id to Assigning to

                body.find('#isedit').val(0);


                body.find('#btn_reg').css({'background-color':''});
                body.find('#btn_assign').css({'background-color':''});
                body.find('#btn_write').css({'background-color':''});
                body.find('#btn_view').css({'background-color':''});
                body.find('#btn_write').css({'background-color':'red'}); // set tap action color

                var assetid = body.find('#asset_cat1 option:selected').val();
                getdataofform2(assetid, 3);
            }
            else
            {
                // e.preventDefault();
                return;
            }
            
        });


        // edit list entry 2
        body.on('dblclick', '#form2list tr', function()
        {
            tr_ind = $(this).index();
            assign_to = $(this).find('td:eq(2)').text();
            assign_date = $(this).find('td:eq(0)').text();
            id = $(this).find('td:eq(0) input').val();

            if(form_action==2)
            {
                assign_to = $(this).find('td:eq(2)').text();
                assign_date = $(this).find('td:eq(0)').text();
                
                body.find('#ass_id').val(id);

                body.find('#isedit').val(1);
                $('#assign_to option').removeAttr("selected");
                $.ajax({
                    url:'get/assign_to_selected.php',
                    type:'POST',
                    data:{pos:assign_to},
                    cache:false,
                    dataType:'json',
                    success: function(data)
                    {
                        body.find('#assign_to').html(data.msg); // set assign to with selected
                        body.find("#assign_date").val(assign_date);
                    }
                });
            }
            else if(form_action==3)
            {
                remark = $(this).find('td:eq(3)').text();
                body.find('#adj_id').val(id);
                $('#remark').val(remark);
                body.find('#isedit').val(1);
                var adj = $(this).find('td:eq(2)').text();

                $.ajax({
                    url:'get/adj.php',
                    type:'POST',
                    data:{adj: adj},
                    cache:false,
                    dataType:'json',
                    success: function(data)
                    {
                        body.find('#adj').html(data.msg);
                    }
                });
            }
        });

        // btn_print
        body.on('click', '#btn_print', function()
        {
            var restorepage = body.html();
            var printContent = $('.box').html();
            body.html(printContent);
            window.print();
            body.html(restorepage);
        });

        body.on('change', '#asset_cat1', function()
        {    
            var typeform = body.find('#typeform').val();
            var assetid = body.find('#asset_cat1 option:selected').val();
            getdataofform2(assetid, typeform);
        });

        // has change adj
        body.on('change', '#adj', function()
        {
            adj_text = $('#adj option:selected').text();
            adj_val = $('#adj option:selected').val();

            $('#remark').val(adj_val);
        });

        // get auto assetID
        function getassetid()
        {
            var val = body.find('#asset_cat option:selected').val();
            $.ajax({
                url:'get/getassetid.php',
                type:'POST',
                data:{catid: val},
                cache: false,
                dataType:'json',
                success: function(data)
                {
              
                    // val = val.substring(2);
                    body.find('#asset_id').val(val+"-"+data.maxid);
                
                }
            });
        }

        // get assetid to choose
        function getassetidforchoose()
        {
            $.ajax({
                url:'get/getassetidforchoose.php',
                type:'POST',
                data:{},
                cache: false,
                dataType:'json',
                success: function(data)
                {
                    body.find('#asset_cat1').html(data.arr);
                    
                    // get data of form 2
                    
                    var assetid = body.find('#asset_cat1 option:selected').val();
                    getdataofform2(assetid, form_action);
                }
            });
        }

        getassetid();
        body.on('change', '#asset_cat', function()
        {
            getassetid();
        });

        // get data of form 2
        function getdataofform2(assetid, formn)
        {
            $.ajax({
                url:'get/getdataofform2.php',
                type:'POST',
                data:{id:assetid, form: formn},
                cache:false,
                dataType:'json',
                success: function(data)
                {
                    body.find('#des1').val(data.des1);
                    body.find('#cost').val(data.cost);
                    body.find('#acq').val(data.acquired);
                    body.find('#model').val(data.model);
                    body.find('#serial').val(data.serail);
                    body.find('#section').val(data.section);
                    
                    if(formn==2)
                    {
                        $('#form2list').html(data.arr);
                        // $('#form2list').after();
                        body.find('#cdt').val(data.cdt);
                    }
                    else if(formn==3)
                    {
                        $('#form2list').html(data.arr);
                        body.find('#cdt').val(data.cdt);
                    }
                    else if(formn == 4)
                    {
                        $('#form2list').html(data.arr);
                    }
                }
            });
        }

        // function save
        function save(frm_data)
        {
            alert(1);
            $.ajax({
                url:"save/savedata_des.php",
                type:"POST",
                data: frm_data,
                cache:false,
                processData:false,
                contentType: false,
                dataType: 'json',
                success: function(data)
                {
                    alert(data.msg);
                    
                }
            });
        }
        // end function save

        //btn_exit
        body.on('click', '#btn_exit', function()
        {
            window.history.back();
        });
    });
</script>
<div class="modal fade" id="modal">
    <div class="modal-dialog" style="border: 1px solid darkred; width: 70%;">
        <iframe id="result_modal" frameborder="0" style="height: 600px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>