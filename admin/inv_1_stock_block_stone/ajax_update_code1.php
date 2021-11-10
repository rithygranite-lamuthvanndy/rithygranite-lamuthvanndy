<?php 
    include_once '../../config/database.php';
 ?>
 <?php 
    if(isset($_POST['data1'])){
        $arr=explode(',', $_POST['data1']);

        $v_update="UPDATE tbl_inv_1_stock_block_stone_detail 
        SET machine_id='$arr[1]' 
        WHERE id='$arr[0]'";
        if($connect->query($v_update))
            echo $v_update;
    }

  ?>