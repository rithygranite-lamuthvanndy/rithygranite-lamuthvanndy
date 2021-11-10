<?php 
	include_once '../../config/database.php';

	$v_user_id = @$_GET['user_id'];
	$get_data = $connect->query("SELECT A.*,B.ug_name,C.up_name,D.ua_name,E.us_name,F.user_f_name AS f_register,F.user_l_name AS l_register 
	FROM tbl_user AS A 
		LEFT JOIN tbl_user_gender AS B ON B.ug_id=A.user_gender
		LEFT JOIN tbl_user_position AS C ON C.up_id=A.user_position
		LEFT JOIN tbl_user_agency AS D ON D.ua_id=A.user_agency
		LEFT JOIN tbl_user_status AS E ON E.us_id=A.user_status
		LEFT JOIN tbl_user AS F ON F.user_id=A.user_register_by
		WHERE A.user_id='$v_user_id'");
	$row = mysqli_fetch_object($get_data);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>IIS User Agrement</title>
	<link rel="stylesheet" href="../../assets/global/plugins/bootstrap/css/bootstrap.css">
	<style>
		body{ padding: 0px auto; }
		h3{ font-family: 'khmer moul'; text-align: center; font-size: 1.3em; font-weight: bolder; }
		table td{ white-space: nowrap; font-family: 'khmer os content';}
		p{ font-family: 'khmer os content'; }
		.bdb{ border-bottom: 0.5px dotted #000; padding: auto 10px; text-align: center;}
		.w_25{ width: 25%; }
		.w_33{ width: 33%; }
		.block_img{ position: relative; }
		.block_img img{ position: absolute; right: 0px; bottom: 0px; width: 100px; }
	</style>
</head>
<body onload="window.print();">
	<div class="container">
		<br>
		<img src="../../img/img_logo/iis_logo.png" alt="" width="150px">
		<br>
		<br>
		<h3 class="text-center">ព័ត៍មានអ្នកប្រើប្រាស់ <div class="text-right block_img"><img src="../../img/img_user/<?= $row->user_photo ?>" alt=""></div></h3><br>
		<table width="100%">
			<tr>
				<td>ឈ្មោះ</td>
				<td class="bdb w_25"><?= $row->user_f_name ?> <?= $row->user_l_name ?></td>
				<td>ភេទ</td>
				<td class="bdb w_25"><?= $row->ug_name ?></td>
				<td>អត្ថលេខ</td>
				<td class="bdb w_25"><?= $row->user_id_number ?></td>
				<td>ថ្ងៃកំណើត</td>
				<td class="bdb w_25"><?= $row->user_dob ?></td>
			</tr>
		</table><br>
		<table width="100%">
			<tr>
				<td>ទូរសព្ទ</td>
				<td class="bdb w_33"><?= $row->user_phone_number ?></td>
				<td>អ៊ីម៉ែល</td>
				<td class="bdb w_33"><?= $row->user_email ?></td>
				<td>ក្រុម</td>
				<td class="bdb w_33"><?= $row->up_name ?></td>
			</tr>
		</table><br>
		<table width="100%">
			<tr>
				<td>ភ្នាក់ងារ</td>
				<td class="bdb" width="70%"><?= $row->ua_name ?></td>
				<td>ស្ថានភាព</td>
				<td class="bdb" width="40%"><?= $row->us_name ?></td>
			</tr>
		</table><br>
		<table width="100%">
			<tr>
				<td>អាសយដ្ឋាន</td>
				<td class="bdb" width="100%"><?= $row->user_address ?></td>
			</tr>
		</table><br>
		<table width="100%">
			<tr>
				<td>ពណ៍នាផ្សេងៗ</td>
				<td class="bdb" width="100%"><?= $row->user_note ?></td>
			</tr>
		</table><br>
		<table>
			<tr>
				<td>ចុះឈ្មោះប្រើប្រាស់នៅថ្ងៃទី</td>
				<td class="bdb" width="40%"><?= $row->user_created_at ?></td>
				<td>ដោយ</td>
				<td class="bdb" width="30%"><?= $row->f_register ?> <?= $row->l_register ?></td>

			</tr>
		</table><br><br>
		<h3 class="text-center">លក្ខខណ្ឌ និងកិច្ចព្រមព្រៀង</h3><br>
		<p>អ្នកប្រើប្រាស់ត្រូវគោរពនូវលក្ខខណ្ឌមួយចំនួនដួចខាងក្រោម៖</p>
		<p>១. រក្សាជាសំងាត់នូវព័ត៍មានដែលផ្ដល់ឲ្យដូចជា អ៊ីម៉ែល និងពាក្យសំងាត់  </p>
		<p>២. មិនត្រូវផ្ដល់ អ៊ីម៉ែល និងពាក្យសំងាត់ទៅឲ្យជនទីបីប្រើប្រាស់ដោយគ្មានការអនុញ្ញាតិ </p>
		<p>៣. រាល់ព័ត៍មាននៅក្នុងប្រពន្ធ័ត្រូវរក្សាការសំងាត់ </p>
		<p>៤. ត្រូវចាកចេញ (Log out) ប្រសិនបើមិនប្រើប្រាស់ ឫមិននៅតុធ្វើការ </p>
		<p>៥. ត្រូវមានការអនុញ្ញាតិ ឫមានភាពច្បាស់លាស់ក្នុងការលុប ឫកែប្រែទិន្នន័យ </p>
		<p><strong>ប្រសិនបើអ្នកប្រើប្រាស់ល្មើសនឹងលក្ខខណ្ឌណាមួយក្នុងចំណោមលក្ខខណ្ឌខាងលើ អ្នកប្រើប្រាស់នោះនឹងត្រូវទទួលខុសត្រូវចំពោះក្រុមហ៊ុន។</strong></p>
		
		<br><br><br>
		<div class="row">
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
				<p>ភ្នំពេញ, ថ្ងៃទី <?= date('d') ?> ខែ <?= date('m') ?> ឆ្នាំ <?= date('Y') ?></p>
			</div>

		</div>
		<div class="row">
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
				<p>បានឃើញនិងអនុញ្ញាតិ</p>
				<p><strong>អគ្គនាយក</strong></p>
				<br>
				<br>
				<br>
				<br>
				<p><strong>ឯល រ៉ូហ្សែត</strong></p>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
				<p>ហត្ថលេខាឫស្នាមមេដៃ</p>
				<p><strong>អ្នកចុះឈ្មោះអោយប្រើប្រាស់</strong></p>
				<br>
				<br>
				<br>
				<br>
				<p><strong><?= $row->f_register ?> <?= $row->l_register ?></strong></p>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
				<p>ហត្ថលេខាឫស្នាមមេដៃ</p>
				<p><strong>អ្នកប្រើប្រាស់</strong></p>
				<br>
				<br>
				<br>
				<br>
				<p><strong><?= $row->user_f_name ?> <?= $row->user_l_name ?></strong></p>
			</div>
			
		</div>
	</div>
</body>
</html>
<script type="text/javascript">
	setTimeout(function(){
		window.close();
	},2000);
</script>