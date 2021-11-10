<?php 
    $menu_active =20;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<link href="../../assets/global/plugins/jstree/dist/themes/default/style.min.css" rel="stylesheet" type="text/css" />
<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Chart Account</h2>
        </div>
    </div>
    <br>
    <div class="">
        <div class="caption font-dark">
            <a href="add.php" id="sample_editable_1_new" class="btn green"> Add New
                <i class="fa fa-plus"></i>
            </a>
            <a name="btn_delete" onclick="submitForm()" id="sample_editable_1_new" class="btn-md btn btn-primary"> Delete 
                <i class="fa fa-list"></i>
            </a>
            <a name="btn_update" id="sample_editable_1_new"  class="btn-md btn btn-info"> Update 
                <i class="fa fa-pencil"></i>
            </a>
        </div>
    </div>
    <br>
    <div class="portlet-body">
        <div id="jstree1" style="font-size: 18px;">
        </div>
    </div>
</div>

<script src="../../assets/global/plugins/jquery.min.js"></script>
<script src="../../assets/global/plugins/jstree/dist/jstree.min.js" type="text/javascript"></script>
<script type="text/javascript">
   
    function MyLoad () {
        var tmp=null;
        $.ajax({url:'ajax_jstree_item.php',async:false,success:function (result) {
            $('#jstree1').jstree({ 
                core : {
                    data :  JSON.parse(result)
                }, 
                 "checkbox" : {
                  "keep_selected_style" : false
                },
                "types" : {
                    "default" : {
                        "icon" : "fa fa-minus"
                    }
                },
                "plugins" : ["types","checkbox" ]
            });
        }});
    }
    MyLoad();

    

    var myid=new Array();
    var mySelectedid;
    $('#jstree1')
    // listen for event
    .on('changed.jstree', function (e, data) {
        var i, j, r = [];
        for(i = 0, j = data.selected.length; i < j; i++) {
          r.push(data.instance.get_node(data.selected[i]).id);
        }
        myid.push(r);
        mySelectedid=data.instance.get_node(data.selected[0]).id;
    })
</script>
<!-- END THEME LAYOUT SCRIPTS -->
<script type="text/javascript">
    $('a[name=btn_update]').click(function () {
        if(!mySelectedid) {
            bootbox.alert("Please select one item before press botton",function () {}); 
        }else {
            var id=mySelectedid.substring(3,10);
            var str_tmp=mySelectedid.substring(0,3);
            if(str_tmp=='de_'){
                window.location.replace('edit.php?edit_id='+id);
            }
            else{
                bootbox.alert("You Cann't update this information",function () {}); 
            }
        }
    });
    function submitForm() {
        bootbox.confirm("Do You Want to delete this ?",function (result) {
            if(result){
                $.ajax({
                    type: "POST",
                    url: "ajax_delete.php",
                    data: 'myAllId='+myid,
                    success: function(result){
                        // alert(result);
                        // $('#myResponse').html(data)
                    }
                });
                window.location.replace("index.php");
            }
        });
    }
</script>

<?php include_once '../layout/footer.php' ?>