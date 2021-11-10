<?php include_once '../../config/database.php'; ?>
<?php 
    $status=array(
            'opend'=>'true',
            'selected'=>'true'
                );
	$arr_main=array();
	$sql_main=$connect->query("SELECT * FROM tbl_acc_main_account ORDER BY acc_main_code ASC");
	while ($row_main=mysqli_fetch_object($sql_main)) {
		$arr_sub=array();
        $sql_sub=$connect->query("SELECT * FROM tbl_acc_chart_sub WHERE main_id='$row_main->accma_id'");
        while ($row_sub=mysqli_fetch_object($sql_sub)) {
        	$arr_item=array();
        	$sql_child=$connect->query("SELECT A.*,SUM(debit-credit) AS amount
                FROM tbl_acc_chart_account AS A 
                LEFT JOIN tbl_acc_add_transaction_detail AS B ON A.accca_id=B.chart_acc_id
                WHERE sub_main_id='$row_sub->id' 
                GROUP BY accca_id");
            while ($row_child=mysqli_fetch_object($sql_child)) {
            	$my_item_detail=array(
            		'id'=>'de_'.$row_child->accca_id,
            		'parent'=>'su_'.$row_sub->id,
            		'text'=>$row_child->accca_number. '-' .$row_child->accca_account_name.' = $'.number_format($row_child->amount,2),
                    'state'=>$status
            		);
            	array_push($arr_main, $my_item_detail);
            }
            $my_item_sub=array(
            	'id'=>'su_'.$row_sub->id,
        		'parent'=>'ma_'.$row_main->accma_id,
        		'text'=>$row_sub->name. str_pad($row_sub->code, 6, '*', STR_PAD_RIGHT),
                'state'=>$status
            );
            array_push($arr_main, $my_item_sub);
        }
        $my_item_main=array(
        	'id'=>'ma_'.$row_main->accma_id,
    		'parent'=>"#",
    		'text'=>$row_main->accma_main_account. '<i class="fa fa-arrow-right"></i>'. str_pad($row_main->acc_main_code, 6, '*', STR_PAD_RIGHT)
        );
        array_push($arr_main, $my_item_main);
	}
	$myJSON=json_encode($arr_main);
	echo $myJSON;
?>