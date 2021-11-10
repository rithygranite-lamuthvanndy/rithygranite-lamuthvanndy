<?php 
    $menu_active =13;
    $left_active =63;
    $layout_title = "View Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    
    include_once '../layout/header.php';
?>
<?php 
    if(isset($_POST['btn_search'])){
        $v_start=@$_POST['txt_date_start'];
        $v_end=@$_POST['txt_date_end'];
        $txt_category=@$_POST['txt_category'];
        if($txt_category !="") {
            $txt_category=" AND  cate_id ='$txt_category' ";
        }
        else {
            $txt_category='';
        }
        $get_data=$connect->query("SELECT * FROM tbl_op_acc_history_purchase_list 
            INNER JOIN tbl_acc_unit_list ON 
            tbl_acc_unit_list.uni_id=tbl_op_acc_history_purchase_list.unit_id
                           
                            WHERE DATE_FORMAT(buy_date,'%Y-%m-%d') BETWEEN '$v_start' AND '$v_end' 
                            $txt_category
                         ORDER BY cate_id ASC,pro_name_kh ASC");
    }
    else{

        $v_start = date('Y-m-01');
        $v_end = date('Y-m-t');
        $txt_category='';

        $get_data=$connect->query("SELECT * FROM tbl_op_acc_history_purchase_list 
            INNER JOIN tbl_acc_unit_list ON 
            tbl_acc_unit_list.uni_id=tbl_op_acc_history_purchase_list.unit_id
                            WHERE DATE_FORMAT(buy_date,'%Y-%m-%d') BETWEEN '$v_start' AND '$v_end' $txt_category
                         ORDER BY cate_id ASC,pro_name_kh ASC");
       
    }
    
 ?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Price History List of Purchase</h2>
        </div>
    </div>
   <div class=""> <div class="caption font-dark"> <a href="add.php" id="sample_editable_1_new" class="btn green"> Add New <i class="fa fa-plus"></i> </a> </div> </div>
<br>
    <div class="row">
        <?php
          if(@$_GET['check']==1) {
            $date_s_s=@$_GET['v_start'];
            $date_s_e=@$_GET['v_end'];
          }
          else {
            $date_s_s=@$_POST['txt_date_start'];
            $date_s_e=@$_POST['txt_date_end'];
          }
        ?>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" name= "form1" id ="form1">
            <div class="col-sm-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input autocomplete="off" name="txt_date_start" 
                    value="<?php echo $date_s_s; ?>"
                     type="text" class="form-control" placeholder="Date From ....">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                    <input autocomplete="off" name="txt_date_end" 
                    value="<?php echo $date_s_e; ?>" 
                    type="text" class="form-control" placeholder="Date To">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>

             <div class="col-sm-2">
               <select class="form-control" name="txt_category">
                                    <option value="">Default</option>
                                    <option <?php if(@$_POST['txt_category']=="1") {echo "selected='selected'";} ?> value="1">សំភារៈផលិត</option>
                                    <option <?php if(@$_POST['txt_category']=="2") {echo "selected='selected'";} ?> value="2">គ្រឿងបន្លាស់</option>
                                    <option <?php if(@$_POST['txt_category']=="3") {echo "selected='selected'";} ?> value="3">សំភារៈរោងជាង</option>
                                    <option <?php if(@$_POST['txt_category']=="4") {echo "selected='selected'";} ?> value="4">សំភារៈការិយាល័យ</option>
                                </select>
            </div>
            
            <div class="col-sm-4">
                <div class="caption font-dark" style="display: inline-block;">
                    <button type="submit" name="btn_search" id="sample_editable_1_new" class="btn blue btn-sm"> Search
                        <i class="fa fa-search"></i>
                    </button>
                <a href="index.php" id="sample_editable_1_new" class="btn btn-danger"><i class="fa fa-undo"></i> Clear</a>
                 <a target="_blank" href="print.php?p_date_start=<?= (@$_POST['txt_date_start'] ? $_POST['txt_date_start'] : date('Y-m-d')) ?>&p_date_end=<?= (@$_POST['txt_date_end'] ? $_POST['txt_date_end'] : date('Y-m-d')) ?>&cate_id=<?php echo @$_POST['txt_category']; ?>" id="sample_editable_1_new" class="btn yellow">
                    <i class="fa fa-print"></i> Print</a>
                     <a target="_blank" href="export_excell.php?p_date_start=<?= (@$_POST['txt_date_start'] ? $_POST['txt_date_start'] : date('Y-m-d')) ?>&p_date_end=<?= (@$_POST['txt_date_end'] ? $_POST['txt_date_end'] : date('Y-m-d')) ?>&cate_id=<?php echo @$_POST['txt_category']; ?>" id="sample_editable_1_new" class="btn blue">
                <i class="fa fa-share"></i> Export</a>
                </div>
            </div>
            <br>
        </form>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover   collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width:100%;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Date Buy</th>
                        <th style="padding: 10px 50px;">Item Name</th>
                        <th>Qty</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Amount</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        
                        $v_cat_name_tmp = [];
                        while ($row = mysqli_fetch_object($get_data)) {
                            if (!in_array($row->cate_id, $v_cat_name_tmp)) {
                                $i = 0;
                                array_push($v_cat_name_tmp, $row->cate_id);
                                    if($row->cate_id=="1") {
                                        $cate_name="សំភារៈផលិត";
                                     }
                                     else if($row->cate_id=="2") {
                                        $cate_name="គ្រឿងបន្លាស់";
                                     }
                                      else if($row->cate_id=="3") {
                                        $cate_name="សំភារៈរោងជាង";
                                     }
                                      else if($row->cate_id=="4") {
                                        $cate_name="សំភារៈការិយាល័យ";
                                        
                                     }
                                     else {
                                        $cate_name="";
                                     }
                                echo '<tr class="bg-blue">';
                                echo '<td colspan="8">' . $cate_name . '</td>';
                                echo '</tr>';
                        }

                    ?>
                    <tr>
                        <td><?php echo (++$i); ?></td>
                        <td><?php echo $row->buy_date; ?></td>
                        <td><?php echo $row->pro_name_kh.' '.$row->pro_name_vn; ?></td>
                       
                        <td><?php echo $row->qty; ?></td>
                        <td><?php echo $row->uni_name; ?></td>
                        <td><?php echo $row->price; ?></td>
                        <td><?php echo $row->amount; ?></td>
                        <td>
                            <a href="edit.php?edit_id=<?php echo $row->id; ?>" class="btn btn-xs btn-warning" title="edit" style="white-space: nowrap;"><i class="fa fa-edit" style="white-space: nowrap;"></i></a>
                            <a href="delete.php?del_id=<?php echo $row->id; ?>" onclick="return confirm('Are you sure to delete this?')" class="btn btn-xs btn-danger" title="delete" style="white-space: nowrap;"><i class="fa fa-trash" style="white-space: nowrap;"></i></a>
                        </td>
                    </tr>
                    <?php
                      }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript" src="../../assets/global/plugins/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('a[href="#more_info"]').click(function(){
            v_id=$(this).attr('data_id');
            $('iframe[id=my_frame]').attr('src','iframe_more_info.php?sent_id='+v_id);
        });

       
    });
        <?php
          if(@$_GET['check']==1) {
        ?>
        
         $("button").click();
        <?php
           }
        ?>
</script>
<?php include_once '../layout/footer.php' ?>

<div class="modal fade" id="more_info">
    <div class="modal-dialog modal-lg" style="width: 1300px; border: 1px solid darkred;">
        <iframe id="my_frame" frameborder="0" style="height: 600px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<style type="text/css">
    .dt-buttons  {
        display: none;
    }
</style>