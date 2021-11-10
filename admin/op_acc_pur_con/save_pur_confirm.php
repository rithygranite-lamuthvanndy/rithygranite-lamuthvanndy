<?php include_once '../../config/database.php'; ?>
<?php 
$v_user_id=@$_SESSION['user']->user_id;
if(isset($_POST['btnSave'])){//Add Pur Form
	
	$txt_confirm_date=$connect->real_escape_string(@$_POST['txt_confirm_date']);
	$txt_request_no=$connect->real_escape_string(@$_POST['txt_request_no']);
	$txt_request_amount=$connect->real_escape_string(@$_POST['txt_request_amount']);
	$location=$connect->real_escape_string(@$_POST['location']);
	$txt_buyer=$connect->real_escape_string(@$_POST['txt_buyer']);
	$txt_user_id=$connect->real_escape_string(@$_POST['txt_user_id']);
	$txt_note=$connect->real_escape_string(@$_POST['txt_note']);
	$txt_des=$connect->real_escape_string(@$_POST['txt_des']);
	$txt_today=$connect->real_escape_string(@$_POST['txt_today']);

	$txt_ch_1_1=$connect->real_escape_string(@$_POST['txt_ch_1_1']);
	$txt_ch_1_2=$connect->real_escape_string(@$_POST['txt_ch_1_2']);
	$txt_ch_1_3=$connect->real_escape_string(@$_POST['txt_ch_1_3']);

	$txt_ch_2_1=$connect->real_escape_string(@$_POST['txt_ch_2_1']);
	$txt_ch_2_2=$connect->real_escape_string(@$_POST['txt_ch_2_2']);
	$txt_ch_2_3=$connect->real_escape_string(@$_POST['txt_ch_2_3']);
	$txt_ch_2_4=$connect->real_escape_string(@$_POST['txt_ch_2_4']);

	$txt_ch_3_1=$connect->real_escape_string(@$_POST['txt_ch_3_1']);
	$txt_ch_3_2=$connect->real_escape_string(@$_POST['txt_ch_3_2']);
	$txt_ch_3_3=$connect->real_escape_string(@$_POST['txt_ch_3_3']);
	$txt_ch_3_4=$connect->real_escape_string(@$_POST['txt_ch_3_4']);
	$txt_ch_3_5=$connect->real_escape_string(@$_POST['txt_ch_3_5']);
	$txt_ch_3_6=$connect->real_escape_string(@$_POST['txt_ch_3_6']);
	$txt_ch_3_7=$connect->real_escape_string(@$_POST['txt_ch_3_7']);

	$txt_1=$connect->real_escape_string(@$_POST['txt_1']);
	$txt_2=$connect->real_escape_string(@$_POST['txt_2']);
	$txt_3=$connect->real_escape_string(@$_POST['txt_3']);
	$txt_4=$connect->real_escape_string(@$_POST['txt_4']);
	$txt_5=$connect->real_escape_string(@$_POST['txt_5']);
	$txt_6=$connect->real_escape_string(@$_POST['txt_6']);
	$txt_7=$connect->real_escape_string(@$_POST['txt_7']);
	$txt_8=$connect->real_escape_string(@$_POST['txt_8']);
	$txt_9=$connect->real_escape_string(@$_POST['txt_9']);
	$txt_10=$connect->real_escape_string(@$_POST['txt_10']);
	$txt_11=$connect->real_escape_string(@$_POST['txt_11']);
	$txt_12=$connect->real_escape_string(@$_POST['txt_12']);
	$txt_13=$connect->real_escape_string(@$_POST['txt_13']);
	$txt_14=$connect->real_escape_string(@$_POST['txt_14']);
	$txt_review_admin_date=$connect->real_escape_string(@$_POST['txt_review_admin_date']);
	$txt_review_fm_date=$connect->real_escape_string(@$_POST['txt_review_fm_date']);
	$txt_app_ceo_date=$connect->real_escape_string(@$_POST['txt_app_ceo_date']);

	$sql="INSERT INTO tbl_acc_pur_confirm(
	confirm_date, 
	req_no,
	amount_request, 
	location,
	user_id,
	name_id,
	buyer_id,
	ch_1_1,
	ch_1_2,
	ch_1_3,
	ch_2_1,
	ch_2_2,
	ch_2_3,
	ch_2_4,
	ch_3_1,
	ch_3_2,
	ch_3_3,
	ch_3_4,
	ch_3_5,
	ch_3_6,
	ch_3_7,
	txt_1,
	txt_2,
	txt_3,
	txt_4,
	txt_5,
	txt_6,
	txt_7,
	txt_8,
	txt_9,
	txt_10,
	txt_11,
	txt_12,
	txt_13,
	txt_14,
	note,
	description,
	review_ad_date,
	review_fm_date,
	app_ceo_date
	)

	

	VALUES (
	'$txt_confirm_date',
	'$txt_request_no',
	'$txt_request_amount',
	'$location',
	'$v_user_id',
	'$txt_user_id',
	'$txt_buyer',
	'$txt_ch_1_1',
	'$txt_ch_1_2',
	'$txt_ch_1_3',
	'$txt_ch_2_1',
	'$txt_ch_2_2',
	'$txt_ch_2_3',
	'$txt_ch_2_4',
	'$txt_ch_3_1',
	'$txt_ch_3_2',
	'$txt_ch_3_3',
	'$txt_ch_3_4',
	'$txt_ch_3_5',
	'$txt_ch_3_6',
	'$txt_ch_3_7',
	'$txt_1',
	'$txt_2',
	'$txt_3',
	'$txt_4',
	'$txt_5',
	'$txt_6',
	'$txt_7',
	'$txt_8',
	'$txt_9',
	'$txt_10',
	'$txt_11',
	'$txt_12',
	'$txt_13',
	'$txt_14',
	'$txt_note',
	'$txt_des',
	'$txt_review_admin_date',
	'$txt_review_fm_date',
	'$txt_app_ceo_date'
	)";
	// die($sql);
	if($connect->query($sql))
		header('location: index.php?status=Success&action=add');
	else
		header('location: index.php?status=Error');
}

else if(isset($_POST['btnUpdate'])){
	
	$v_main_id=$connect->real_escape_string(@$_POST['txt_main_id']);
	$txt_confirm_date=$connect->real_escape_string(@$_POST['txt_confirm_date']);
	$txt_request_no=$connect->real_escape_string(@$_POST['txt_request_no']);
	$txt_request_amount=$connect->real_escape_string(@$_POST['txt_request_amount']);
	$location=$connect->real_escape_string(@$_POST['location']);
	$txt_buyer=$connect->real_escape_string(@$_POST['txt_buyer']);
	$txt_user_id=$connect->real_escape_string(@$_POST['txt_user_id']);
	$txt_note=$connect->real_escape_string(@$_POST['txt_note']);
	$txt_des=$connect->real_escape_string(@$_POST['txt_des']);
	$txt_today=$connect->real_escape_string(@$_POST['txt_today']);

	$txt_ch_1_1=$connect->real_escape_string(@$_POST['txt_ch_1_1']);
	$txt_ch_1_2=$connect->real_escape_string(@$_POST['txt_ch_1_2']);
	$txt_ch_1_3=$connect->real_escape_string(@$_POST['txt_ch_1_3']);

	$txt_ch_2_1=$connect->real_escape_string(@$_POST['txt_ch_2_1']);
	$txt_ch_2_2=$connect->real_escape_string(@$_POST['txt_ch_2_2']);
	$txt_ch_2_3=$connect->real_escape_string(@$_POST['txt_ch_2_3']);
	$txt_ch_2_4=$connect->real_escape_string(@$_POST['txt_ch_2_4']);

	$txt_ch_3_1=$connect->real_escape_string(@$_POST['txt_ch_3_1']);
	$txt_ch_3_2=$connect->real_escape_string(@$_POST['txt_ch_3_2']);
	$txt_ch_3_3=$connect->real_escape_string(@$_POST['txt_ch_3_3']);
	$txt_ch_3_4=$connect->real_escape_string(@$_POST['txt_ch_3_4']);
	$txt_ch_3_5=$connect->real_escape_string(@$_POST['txt_ch_3_5']);
	$txt_ch_3_6=$connect->real_escape_string(@$_POST['txt_ch_3_6']);
	$txt_ch_3_7=$connect->real_escape_string(@$_POST['txt_ch_3_7']);

	$txt_1=$connect->real_escape_string(@$_POST['txt_1']);
	$txt_2=$connect->real_escape_string(@$_POST['txt_2']);
	$txt_3=$connect->real_escape_string(@$_POST['txt_3']);
	$txt_4=$connect->real_escape_string(@$_POST['txt_4']);
	$txt_5=$connect->real_escape_string(@$_POST['txt_5']);
	$txt_6=$connect->real_escape_string(@$_POST['txt_6']);
	$txt_7=$connect->real_escape_string(@$_POST['txt_7']);
	$txt_8=$connect->real_escape_string(@$_POST['txt_8']);
	$txt_9=$connect->real_escape_string(@$_POST['txt_9']);
	$txt_10=$connect->real_escape_string(@$_POST['txt_10']);
	$txt_11=$connect->real_escape_string(@$_POST['txt_11']);
	$txt_12=$connect->real_escape_string(@$_POST['txt_12']);
	$txt_13=$connect->real_escape_string(@$_POST['txt_13']);
	$txt_14=$connect->real_escape_string(@$_POST['txt_14']);
	$txt_review_admin_date=$connect->real_escape_string(@$_POST['txt_review_admin_date']);
	$txt_review_fm_date=$connect->real_escape_string(@$_POST['txt_review_fm_date']);
	$txt_app_ceo_date=$connect->real_escape_string(@$_POST['txt_app_ceo_date']);

	$sql="UPDATE tbl_acc_pur_confirm SET
	confirm_date='$txt_confirm_date', 
	req_no='$txt_request_no',
	amount_request='$txt_request_amount', 
	location='$location',  
	name_id='$txt_user_id', 
	buyer_id='$txt_buyer', 
	ch_1_1='$txt_ch_1_1',
	ch_1_2='$txt_ch_1_2', 
	ch_1_3='$txt_ch_1_3', 
	ch_2_1='$txt_ch_2_1', 
	ch_2_2='$txt_ch_2_2', 
	ch_2_3='$txt_ch_2_3', 
	ch_2_4='$txt_ch_2_4', 
	ch_3_1='$txt_ch_3_1', 
	ch_3_2='$txt_ch_3_2', 
	ch_3_3='$txt_ch_3_3', 
	ch_3_4='$txt_ch_3_4', 
	ch_3_5='$txt_ch_3_5', 
	ch_3_6='$txt_ch_3_6', 
	ch_3_7='$txt_ch_3_7', 
	txt_1='$txt_1', 
	txt_2='$txt_2', 
	txt_3='$txt_3', 
	txt_4='$txt_4', 
	txt_5='$txt_5',
	txt_6='$txt_6', 
	txt_7='$txt_7', 
	txt_8='$txt_8', 
	txt_9='$txt_9', 
	txt_10='$txt_10', 
	txt_11='$txt_11', 
	txt_12='$txt_12', 
	txt_13='$txt_13', 
	txt_14='$txt_14', 
	note='$txt_note', 
	description='$txt_des', 
	review_ad_date='$txt_review_admin_date', 
	review_fm_date='$txt_review_fm_date', 
	app_ceo_date='$txt_app_ceo_date'
	WHERE pur_id='$v_main_id'
	";
	if($connect->query($sql))
		header('location: index.php?status=Success&action=edit');
	else
		header('location: index.php?status=Error');
}

 ?>