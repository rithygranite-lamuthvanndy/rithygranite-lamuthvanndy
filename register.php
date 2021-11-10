<?php 
include_once 'config/database.php';
// redirect if already login
if(@$_SESSION['allowLog']=="logAlready"){
	header("location: admin/");
}


// login
if(isset($_POST['btn_register'])){
  	$v_username = trim($connect->real_escape_string(@$_POST['txt_username']));
  	$v_email_address = trim($connect->real_escape_string(@$_POST['txt_email_address']));
  	$v_phone_number = trim($connect->real_escape_string(@$_POST['txt_phone_number']));
  	$v_password = trim($connect->real_escape_string(@$_POST['txt_password']));
  	// $enctypt_password = sha1(md5($pass)).sha1("0962195196");

  	$stm = "INSERT INTO 
  		tbl_user (
  			user_name,
  			user_password,
  			user_email,
  			user_phone_number,
  			user_position,
  			user_originattion
  		)
  		VALUES(
			'$v_username',
			'$v_password',
			'$v_email_address',
			'$v_phone_number',
			'2',
			'Register'
  		)";
  	if($connect->query($stm)){
		header("location: login.php?sms=register_success");
  	}else{
   		$sms = '<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<strong>Error!</strong> register Error ...
		</div>';
  	}
}
mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Register</title>
	<link rel="stylesheet" href="assets/global/plugins/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="assets/global/plugins/font-awesome/css/font-awesome.css">
	<style type="text/css">
		input,button{ border-radius: 0px!important; }
		body{ background: #f5f5f5; }
	</style>
	<script type="text/javascript" src="assets/global/plugins/jquery.min.js"></script>
</head>
<body><br>
	<div class="container" style="background: #14E909; border: 2px solid #fff;">
		<header>
			<div class="row">
				<div class="col-sm-6">
					<div style="padding: 20px 0px;">
						<a href="index.php">
							<img src="img/img_logo/logo.png" align="middle" style="width: 250px;" class="img-responsive img-thumbnail" alt="Image">
						</a>
					</div>
				</div>
				<div class="col-sm-6">
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p class="text-right">Welcome to ! <a href="http://localhost/phpmyadmin" class="btn btn-success"><i class="fa fa-database"></i> DATABASE MANAGEMENT SYSTEM <i class="fa fa-database"></i></a></p>
				</div>
			</div>
		</header>
	</div>
	<div class="container" style="background: #fff; padding-top: 20px;">
		<main>
			<div class="row">
				<div class="col-sm-6">
					<?= @$sms ?>
					<form onsubmit="if(document.getElementById('password').value != document.getElementById('confirm_password').value){alert('password not match'); return false; } " action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" role="form">
						<legend><b>Register To Enter Group</b></legend>
						<br>
						<div class="form-group">
							<label for="">Username <span class="text-danger">*</span></label>
							<input autofocus="off" required="" name="txt_username" type="text" class="form-control" >
						</div>
						<div class="form-group">
							<label for="">Email Address <span class="text-danger">*</span></label>
							<input autofocus="off" required="" name="txt_email_address" type="email" class="form-control" >
						</div>
						<div class="form-group">
							<label for="">Phone Number <span class="text-danger">*</span></label>
							<input autofocus="off" required="" name="txt_phone_number" type="text" class="form-control" >
						</div>
						<div class="form-group">
							<label for="">Password <span class="text-danger">*</span></label>
							<input autofocus="off"  required="" id="password" name="txt_password" type="text" class="form-control" >
						</div>
						<div class="form-group">
							<label for="">Confirm Password <span class="text-danger">*</span></label>
							<input autofocus="off" required="" id="confirm_password" type="password" class="form-control" >
						</div>
						
						
					
						<button type="submit" name="btn_register" class="btn btn-primary">Register Now</button>
					</form>
				</div>
				<div class="col-sm-6">
					<legend><b>Why Join Us?</b></legend>
					<br><br>
					<p><i class="fa fa-check fa-fw text-success"></i> Track your saved properties across devices</p>
					<p><i class="fa fa-check fa-fw text-success"></i> Be alerted when properties matching your criteria hit the market</p>
					<p><i class="fa fa-check fa-fw text-success"></i> Sell or rent your property free</p>
					<br>
					<a href="admin/user_guide/" title="fast answer question"><i class="fa fa-tasks"></i> Question & Answer</a><br>
					<br>
					<a href="login.php" title="fast answer question" class="btn btn-success"><i class="fa fa-user"></i> Go To Login </a>
				</div>
			</div>
		</main><br><br>
		<footer>
			<div class="row">
				<div class="col-sm-3">
					<article>
						<p> &nbsp; </p>
						<p> &nbsp; </p>
						<p> &nbsp; </p>
						<p>Delvelop by <a href="http://khmerboy26.wordpress.com">khmerboy26.wordpress.com </a></p>
					</article>
				</div>
				<div class="col-sm-9">
					<article class="text-right">
						<p>Address: No. 254, Street 107, Sangkat Boeung Pralit, <br>Khan 7 Makara, Phnom Penh City.</p>
						<p>Zip Code: 12258</p>
						<p>Mobile: (+855) 979 057 757 - Tel : (+855) 23-69 45 888</p>
						<p>Email: <a href="#">rithygranite.lamuthvanndy@gmail.com </a></p>
						<p>Website Systems: <a href="http://42.115.80.92">14 Systems (Rithy Granite) </a></p> 
					</article>
				</div>

			</div>
		</footer>
	</div>
</body>
</html>

<script type="text/javascript" src="assets/global/plugins/bootstrap/js/bootstrap.js"></script>