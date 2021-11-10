<?php include '../../config/database.php'; ?>
<?php 
	$d = @$_GET['status'];
	if($d == 'st_product_name'){
		echo '<option value="">=== Please Choose and Select ===</option>';
		$v_select = $connect->query("SELECT stpron_id,stpron_code,stpron_name_vn,stpron_name_kh FROM tbl_st_product_name ORDER BY stpron_code DESC");
        while ($row_data = mysqli_fetch_object($v_select)) {
            echo '<option value="'.$row_data->stpron_id.'">['.$row_data->stpron_code.' ] '.$row_data->stpron_name_kh.' :: '.$row_data->stpron_name_vn.'</option>';
        }
	}

	if(isset($_GET['p_pro_id'])){
		$v_pro_id=$_GET['p_pro_id'];
		$sql="SELECT 
            A.stpron_code,A.stpron_name_vn,A.stpron_name_kh,
            (
                SELECT SUM(AA.in_qty)
                FROM tbl_st_stock_in_detail AS AA 
                LEFT JOIN tbl_st_stock_in AS AAA ON AA.stsin_id=AAA.stsin_id
                WHERE AA.pro_id=A.stpron_id
            ) AS bal_in,
            (
                SELECT SUM(BB.out_qty)
                FROM tbl_st_stock_out_detail AS BB 
                LEFT JOIN tbl_st_stock_out AS BBB ON BB.stsout_id=BBB.stsout_id
                WHERE BB.pro_id=A.stpron_id
            ) AS bal_out,
            (
                SELECT SUM(CC.stsadj_qty_adj)
                FROM tbl_st_stock_adjustment AS CC 
                WHERE CC.stsadj_product_code=A.stpron_id
            ) AS bal_adjust,
            B.sttyp_name,C.name AS pro_type_name
        FROM tbl_st_product_name AS A 
        LEFT JOIN tbl_st_material_type_list AS B ON A.stpron_material_type=B.sttyp_id
        LEFT JOIN tbl_st_product_type_list AS C ON A.stpron_pro_type=C.id
        WHERE 
            A.stpron_id='$v_pro_id'
        GROUP BY A.stpron_id
        ";
    	$get_data=$connect->query($sql);
    	$row_bal=mysqli_fetch_object($get_data);
    	echo $row_bal->bal_in-$row_bal->bal_out+$row_bal->bal_adjust;
	}
?>



