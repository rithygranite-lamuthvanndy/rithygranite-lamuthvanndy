<?php 
include_once 'config/database.php';
// include_once 'backup_mysqldump/backup.php';
// logout
if(isset($_GET['action'])){
  if($_GET['action'] == "logout"){
  	session_destroy();
	session_start();
	unset($_COOKIE['user']);
	setcookie('user', '', 1);
	// setcookie('user', null, -1, '/');
    header("Refresh:0; url=index.php");
  }
}
if(@unserialize($_COOKIE['user'])!=""){
	// die("Remember Cookies");
	$_SESSION['user']=@unserialize($_COOKIE['user']);
	header('location: admin/dashboard/index.php?status=Remember');	
}
// redirect if already login
if(@$_SESSION['user']!=''){
	header("location: admin/dashboard/index.php?status=success2");
}

// register success 
if(@$_GET['sms']=='register_success'){
	$sms = '<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<strong>Success!</strong> register successfull. Please Login to System ...
	</div>';
}
 // echo '<script>alert("Log In Cookies='.@unserialize($_COOKIE['pass']).'");</script>';
// if(@unserialize($_COOKIE['pass'])){
// 	// header('location: page_tem.php');
//     header("location: admin/dashboard/index.php?status=success1");
// }
if(@$_GET['check_email']=='false'){
	$sms = '<div class="alert alert-warning">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<strong>Warning!</strong> '.@$_GET['email_name'].' not register to this system !!!!!
		</div>';
	$forgot_pass = '<a class="btn btn-warning btn-xs" data-toggle="modal" href="#modal-id">Recovery Your Password</a>';
}
else if(@$_GET['send_status']=='true'){
	$sms = '<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<strong>Successfull !</strong> Message has been sent to '.@$_GET['email_name'].' successfully
		</div>';
}
else if(@$_GET['reset_status']=='true'){
	$sms = '<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<strong>Successfull !</strong> Please, enter your new password to log in
		</div>';
}

// login
if(isset($_POST['btnlogin'])){
  	$name = trim($connect->real_escape_string(@$_POST['txtname']));
  	$pass = trim($connect->real_escape_string(@$_POST['txtpass']));

  	$check = trim($connect->real_escape_string(@$_POST['check_stay_in']));
  	// $enctypt_password = sha1(md5($pass)).sha1("0962195196");

  	$stm = "SELECT user_id,user_name,user_status,user_email,user_photo,user_position FROM tbl_user WHERE user_name='{$name}' AND user_password='{$pass}'";
  	$user = $connect->query($stm);
  	if(mysqli_num_rows($user)==1){
		$user_data = mysqli_fetch_object($user);
	    $v_last_ativity=date("Y-m-d H:i:s");
	    $connect->query("UPDATE tbl_user SET last_activity='$v_last_ativity' WHERE user_id='$user_data->user_id'");
	    if($check){//Stay Sign In
		    	// setcookie('pass', serialize($user_data->user_id), time() + (86400 * 30), "/");
	    	setcookie('user', serialize($user_data),  time() + (10 * 365 * 24 * 60 * 60));
	    	$_SESSION['user']=$user_data;			
			header("location: admin/dashboard/index.php?status=Remember");
	    }
	    else if(!$check){
	    	$_SESSION['user']=$user_data;	
	    	// die();		
			header("location: admin/dashboard/index.php?status=success2");
	    }
		// backup_mysqldump();//Back Up database with mysql dump
    // echo $_SESSION['user']->user_email  ** example when u want to user session
  	}else{
    	$sms = '<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong>Error!</strong> Invalid Account ...
			</div>';
		$forgot_pass = '<a class="btn btn-warning btn-xs" data-toggle="modal" href="#modal-id">Recovery Your Password</a>';
  	}
}
mysqli_close($connect);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<!-- <meta http-equiv="refresh" content="2; url=<?= $_SERVER['HTTP_HOST'] ?>"> -->
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
					<p class="text-right">Welcome to ! <a href="http://42.115.80.92/phpmyadmin" class="btn btn-success"><i class="fa fa-database"></i> Back ! DATABASE MANAGEMENT SYSTEM <i class="fa fa-database"></i></a></p>
				</div>
			</div>
		</header>
	</div>
	<div class="container" style="background: #fff; padding-top: 20px;">
		<main>
			<div class="row">
				<div class="col-sm-8">
					<div class="content">
					<img src="img/img_logo/main_login.jpg" class="img-responsive img-thumbnail" alt="Norway">

					</div>
				</div>
				<div class="col-sm-4">
					<form action="" method="POST" role="form">
						<?= @$sms ?>
						<legend><b>Login to Database System</b></legend>
					
						<div class="form-group">
							<label for="n">Username:</label>
							<input type="text" autofocus="autofocus" class="form-control" id="n" placeholder="username" name="txtname">
						</div>
						<div class="form-group">
							<label for="p">Password:</label>
							<input type="password" class="form-control" id="p" placeholder="password" name="txtpass">
						</div>
						<label class="pull-right"><input type="checkbox" name="check_stay_in"> Stay sign in</label>
						<button type="submit" name="btnlogin" class="btn btn-primary">Sign in <i class="fa fa-sign-in"></i></button>
					</form>
					<br>
					<div class="row">
						<div class="col-sm-6">
							<?= @$forgot_pass ?>
						</div>
						<div class="col-sm-6">
							<a href="admin/user_guide/" title="fast answer question"><i class="fa fa-tasks"></i> Question & Answer</a><br><br>

						</div>
					</div>
					<a href="register.php" class="btn btn-success" style="border-radius: 0px;" title="fast answer question"><i class="fa fa-user"></i> Register Now</a>
				</div>
			</div>
		</main><br>
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
	<br>
	<br>
	<br>
	<div class="modal fade" id="modal-id">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Sending Email</h4>
				</div>
				<div class="modal-body">
					<form action="send_email.php" method="POST" role="form">
						<div class="form-group">
							<label for="email">Email Address:</label>
							<input type="email" value="<?= @$_POST['txt_email'] ?>" name="txt_email" class="form-control" id="email" placeholder="Please, Input your email to reset password">
						</div>
						<br>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i></button>
							<button type="submit" name="btn_send" class="btn btn-primary"><i class="fa fa-paper-plane"></i></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<script type="text/javascript" src="assets/global/plugins/bootstrap/js/bootstrap.js"></script>