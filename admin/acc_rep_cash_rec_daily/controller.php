<?php 
	include_once '../../config/database.php';
 ?>
 <?php 
 	if(isset($_POST['btn_Save'])){
 		$v_main_date=$_POST['txt_main_date'];

        $connect->query("DELETE FROM tbl_acc_rep_cash_rec_daily_padding WHERE cash_rec_daily_date='$v_main_date'");
        $connect->query("DELETE FROM tbl_acc_rep_cash_rec_daily_cash_count WHERE cash_rec_daily_date='$v_main_date'");

 		$v_date= @$_POST['txt_date'];
        $v_description= mysqli_escape_string($connect,$_POST['txt_description']);
        $v_amo= @$_POST['txt_amo'];
        foreach ($v_amo as $key=>$value) {
        	if($value!=0){
        		$v_new_date=$v_date[$key];
                $v_new_description=$v_description[$key];
        		$v_new_amo=$v_amo[$key];
        		$v_insert="INSERT INTO tbl_acc_rep_cash_rec_daily_padding
        			(cash_rec_daily_date,
        			date_record,
        			description,
        			amo)
        			VALUES(
        				'$v_main_date',
        				'$v_new_date',
        				'$v_new_description',
        				'$v_new_amo'
        			)
        		";
        		if(!$connect->query($v_insert)){
        			die($connect->error);
        		}
        	}
        }

        // =============================

        $v_unit_dollar_100=@$_POST['txt_unit_dollar_100'];
        $v_unit_dollar_50=@$_POST['txt_unit_dollar_50'];
        $v_unit_dollar_20=@$_POST['txt_unit_dollar_20'];
        $v_unit_dollar_10=@$_POST['txt_unit_dollar_10'];
        $v_unit_dollar_2=@$_POST['txt_unit_dollar_2'];
        $v_unit_dollar_5=@$_POST['txt_unit_dollar_5'];
        $v_unit_dollar_1=@$_POST['txt_unit_dollar_1'];
        $v_unit_reils_1000=@$_POST['txt_unit_reils_1000'];
        $v_unit_reils_500=@$_POST['txt_unit_reils_500'];
        $v_unit_reils_200=@$_POST['txt_unit_reils_200'];
        $v_unit_reils_100=@$_POST['txt_unit_reils_100'];
        $v_unit_reils_50=@$_POST['txt_unit_reils_50'];
        $v_unit_reils_20=@$_POST['txt_unit_reils_20'];
        $v_unit_reils_10=@$_POST['txt_unit_reils_10'];
        $v_unit_reils_5=@$_POST['txt_unit_reils_5'];
        $v_unit_reils_1=@$_POST['txt_unit_reils_1'];
        $v_total_dollar=@$_POST['txt_total_dollar'];
        $v_total_reils=@$_POST['txt_total_reils'];
        $v_final_grand_total=@$_POST['txt_final_grand_total'];

        $v_sql_insert="INSERT INTO tbl_acc_rep_cash_rec_daily_cash_count(
        cash_rec_daily_date, 
        dollar_100, 
        dollar_50, 
        dollar_20, 
        dollar_10, 
        dollar_5, 
        dollar_2, 
        dollar_1, 
        reils_1000, 
        reils_500, 
        reils_200, 
        reils_100, 
        reils_50, 
        reils_20, 
        reils_10, 
        reils_5, 
        reils_1, 
        total_dollar, 
        total_reils, 
        final_grand_total) 
        VALUES(
        '$v_main_date',
        '$v_unit_dollar_100',
        '$v_unit_dollar_50',
        '$v_unit_dollar_20',
        '$v_unit_dollar_10',
        '$v_unit_dollar_5',
        '$v_unit_dollar_2',
        '$v_unit_dollar_1',
        '$v_unit_reils_1000',
        '$v_unit_reils_500',
        '$v_unit_reils_200',
        '$v_unit_reils_100',
        '$v_unit_reils_50',
        '$v_unit_reils_20',
        '$v_unit_reils_10',
        '$v_unit_reils_5',
        '$v_unit_reils_1',
        '$v_total_dollar',
        '$v_total_reils',
        '$v_final_grand_total'
        )";
        if(!$connect->query($v_sql_insert)){
            die($connect->error);
        }
        else{
            header('location: index.php?status=true');
        }
 	}
  ?>