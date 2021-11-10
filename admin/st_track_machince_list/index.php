<?php 
    $menu_active =140;
    $left_active =0;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    if(@$_GET['view']=='iframe')
        include_once '../layout/header_frame.php';
    else
        include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Truck & Machine List</h2>
        </div>
    </div>
    <br>
    <div class="" style="display: inline-block;">
        <div class="caption font-dark">
            <a href="add.php?view=<?= @$_GET['view'] ?>" id="sample_editable_1_new" class="btn green"> Add New
                <i class="fa fa-plus"></i>
            </a>
        </div>

    </div>
 
    
     <div class="" style="display: inline-block;">
        <div class="caption font-dark">
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
             <a name="btn_delete" onclick="submitForm()" id="sample_editable_1_new" class="btn green"> Truck Club 
                       <i class="fa fa-plus"></i>
            </a>
            </form>

        </div>
        
    </div>
    <select id="clup_name_id"  class="btn" style="width:20%;height:33px;">
        <!-- <option value="">Machine List</option> -->
        <?php
           $get_se = $connect->query("SELECT * FROM tbl_group_truck ORDER BY order_number");
            while ($rows = mysqli_fetch_object($get_se)) {
        ?>
         <option value="<?php echo $rows->id; ?>"><?php echo $rows->name; ?></option>
        <?php
          }
        ?>
    </select>
    <select onchange="window.location=this.value" class="btn"  style="width:20%;height: 33px;">
        <option selected="" value="../st_track_machince_list">Truck & Machine List</option>
        <option  value="../st_track_machince_group">Truck Club Name</option>
    </select>
    
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline" id="sample_1" role="grid" aria-describedby="sample_1_info">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Check <input type="checkbox" name="check_all"></th>
                        <th>Machine Code</th>
                        <th>Date Buy</th>
                        <th>Machine Name KH</th>
                        <th>Machine Name NV</th>
                        <th>Machine Position</th>
                        <th>Machine Price</th>
                        <th>Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                               *
                            FROM tbl_st_track_machine_list AS A 
                            ORDER BY id DESC");
                       
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td class="text-center">
<input type="checkbox" name="myCheckboxes[]" id="myCheckboxes"  value="'.$row->id.'"></td>';
                                echo '<td>'.$row->code.'</td>';
                                echo '<td>'.$row->date_buy.'</td>';
                                echo '<td>'.$row->name_vn.'</td>';
                                echo '<td>'.$row->name_kh.'</td>';
                                echo '<td>'.$row->track_position.'</td>';
                                echo '<td class="text-primary">$ '.$row->track_price.'</td>';
                                echo '<td>'.$row->note.'</td>';
                                echo '<td class="text-center">';
                                    echo '<a href="edit.php?edit_id='.$row->id.'&view='.@$_GET['view'].'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                    echo '<a onclick="deleteRecord('.$row->id.')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="../../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    function submitForm() {
        var clup_name_id=$("#clup_name_id").val();
        $i=0;
        var myCheckboxes = new Array();
        $("input:checked").each(function(e) {
           // $(this).parents('tr').find('td:not(:first-child),th').html('--');
           myCheckboxes.push($(this).val());
           $i++;
        });
        if($i==0){
            alert("Please Check !");
            return false;
        }
        // return false;
        bootbox.confirm("You want update all of this ?", function(result){ 
            if(result){
                $.ajax({
                    type: "POST",
                    url: "update_all.php",
                    dataType: 'html',
                    data: 'myCheckboxes='+myCheckboxes+
                          '&clup_name_id='+clup_name_id,
                    success: function(result){
                        // alert(result);
                        // $('#myResponse').html(data)
                    }
                });
                window.location.replace("../st_track_machince_list/");
            }
        });
    }

</script>
<script>
    $('input[name=check_all]').change(function () {
        var st=$(this).prop('checked');
        $('td:nth-child(2)').find('input[name^=myCheckboxes]').each(function () {
            $(this).prop('checked',st);
        });
    });
</script>
<?php 
    if(@$_GET['view']=='iframe')
        include_once '../layout/footer_frame.php';
    else
        include_once '../layout/footer.php';
 ?>

