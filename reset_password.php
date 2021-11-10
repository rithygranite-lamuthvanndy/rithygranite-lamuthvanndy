<?php 
	include_once 'config/database.php';
	use PHPMailer\PHPMailer\PHPMailer;
 ?>
<!-- Reset Password -->
<?php 
 	if(@$_GET['user_id']){
 		$sms = '<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<strong>Successfull !</strong> Please, enter your new password
		</div>';
 	}
 	if(isset($_POST['btn_update_password'])){
 		$v_user_id=@$connect->real_escape_string($_POST['txt_user_id']);
 		$v_new_password=@$connect->real_escape_string($_POST['txtpass']);
 		$sql_update="UPDATE tbl_user SET user_password='$v_new_password' WHERE user_id='$v_user_id'";
 		if($connect->query($sql_update)){

 			// Getting Email Name
 			$sql_check_email=$connect->query("SELECT user_email,user_id FROM tbl_user WHERE user_id='$v_user_id'");
 			$v_email=mysqli_fetch_object($sql_check_email)->user_email;

 			// require_once "vendor/autoload.php";
			require_once "plugin/PHPSendEmail/vendor/autoload.php";

			$mail = new PHPMailer;

			//Enable SMTP debugging. 
			$mail->SMTPDebug = 0;                               
			//Set PHPMailer to use SMTP.
			$mail->isSMTP();          
			//Set SMTP host name                          
			$mail->Host = "smtp.gmail.com";
			//Set this to true if SMTP host requires authentication to send email
			$mail->SMTPAuth = true;                          
			//Provide username and password     
			$mail->Username = "chhumsilak@gmail.com";                 
			$mail->Password = "0969807370";                           
			//If SMTP requires TLS encryption then set it
			$mail->SMTPSecure = "tls";                           
			//Set TCP port to connect to 
			$mail->Port = 587;                                   

			$mail->From = "chhumsilak@gmail.com";
			$mail->FromName = "Chhum Silak";

			$mail->addAddress($v_email, "Recepient Name");
			$mail->addAddress("chhumsilak@gmail.com", "Recepient Name");

			//Provide file path and name of the attachments
			// $mail->addAttachment("File/text.txt");        
			// $mail->addAttachment("plugin/PHPSendEmail/Image/image.jpg"); //Filename is optional

			$mail->isHTML(true);

			$mail->Subject = "Rithy Granite Company";
			// $mail->Body = "<i>Mail body in HTML</i>";
			$v_content="You've changed your password on ".date('D d-M-Y H:i:s').', and new password is <strong> '.$v_new_password.'</strong> with email <strong>'.$v_email.'</strong>';
			$mail->Body = $v_content;
			$mail->AltBody = "This is the plain text version of the email content";

			if(!$mail->send()) 
			{
			    echo "Mailer Error: " . $mail->ErrorInfo;
			} 
			// else 
			// {
			// 	header("location: login.php?send_status=true&email_name='$v_email'");
			//     // echo "Message has been sent successfully";
			// }

 			header('location: login.php?reset_status=true');
 		}
 		else{
 			$sms = '<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong>Error !</strong> '.mysqli_error($connect).'
			</div>';
 		}
 	}
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Reset Password</title>
	<link rel="stylesheet" href="assets/global/plugins/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="assets/global/plugins/font-awesome/css/font-awesome.css">
	<style type="text/css">
		input,button{ border-radius: 0px!important; }
		body{ background: #f5f5f5; }
	</style>
	<script type="text/javascript" src="assets/global/plugins/jquery.min.js"></script>
</head>
<body><br>
	<div class="container" style="background: #eee; border: 2px solid #fff;">
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
					<p class="text-right">Welcome to ! <a href="http://newdayopensource.website" class="btn btn-success"><i class="fa fa-database"></i> Back ! DATABASE MANAGEMENT SYSTEM</a></p>
				</div>
			</div>
		</header>
	</div>
	<div class="container" style="background: #fff; padding-top: 20px;">
		<main>
			<div class="row">
				<div class="col-sm-8">
					<img src="img/img_logo/main_login.jpg" class="img-responsive img-thumbnail" alt="Image">
				</div>
				<div class="col-sm-4">
					<form action="" method="POST" role="form">
						<input type="hidden" class="form-control" name="txt_user_id" value="<?= @$_GET['user_id'] ?>">
						<?= @$sms ?>
						<legend>Reset Password</legend>
						<div class="form-group">
							<label for="p">New Password:</label>
							<input type="password" class="form-control" id="p" placeholder="New Password ....." name="txtpass">
						</div>
						<button type="submit" name="btn_update_password" class="btn btn-primary">Update <i class="fa fa-sign-in"></i></button>
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
						<p>Delvelop by <a href="http://www.newday-tech.com/">http://www.newday-tech.com</a></p>
					</article>
				</div>
				<div class="col-sm-9">
					<article class="text-right">
						<p>Address: Building 99, Street Borey
							Sangkat Phnom Penh Thmey, Khanm Sen Sok,  
							Phnom Penh, Cambodia.
						<p>Zip Code: 12000</p>
						<p>Tel: (855) 15 286 120</p>
						<p>Email: <a href="#">info@newdayopensource.website </a></p>
						<p>Website: <a href="http://newdayopensource.website">www.newdayopensource.website </a></p> 
					</article>
				</div>

			</div>
		</footer>
	</div>
	<br>
	<br>
</body>
</html>
<script type="text/javascript" src="assets/global/plugins/bootstrap/js/bootstrap.js"></script>