<?php include '../../config/database.php'; ?>
<?php 
	   $id = @$_GET['id'];	
		$v_select=$connect->query("SELECT * FROM tbl_acc_request_item WHERE rei_number='$id'");
		$sum=0;
        while ($row_select=mysqli_fetch_object($v_select)) {
        	$sum +=$row_select->rei_qty * $row_select->rei_price;
            
        }
        if($sum >0) {
        	echo $sum;
        }
        else {
        	echo 0;
        }
        

?>



