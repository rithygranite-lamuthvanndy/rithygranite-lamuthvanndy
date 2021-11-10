<?php 
	include_once 'config/database.php';
	use PHPMailer\PHPMailer\PHPMailer;
 ?>
<?php 
// Recovery Password
if(isset($_POST['btn_send'])){
	$v_email=@$connect->real_escape_string($_POST['txt_email']);
	$sql_check_email=$connect->query("SELECT user_email,user_id FROM tbl_user WHERE user_email='$v_email'");
	if(mysqli_num_rows($sql_check_email)){//Avalable Email
		// Getting current url
		$row_check_email=mysqli_fetch_object($sql_check_email);
		$actual_link = 'http://'.$_SERVER['HTTP_HOST'].'/reset_password.php?user_id='.$row_check_email->user_id;//.$_SERVER['PHP_SELF'];
		// echo $actual_link;

		// Content url
		$v_content='<!DOCTYPE html>
						 <html>
						 <head>
						 	<meta charset="utf-8">
						 	<meta http-equiv="X-UA-Compatible" content="IE=edge">
						 	<title></title>
						 	<!-- Latest compiled and minified CSS & JS -->
						 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" >
						 	<script src="//code.jquery.com/jquery.js"></script>
						 	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
						 </head>
						 <body>
						 	<div class="text-center">
						 		<h3>Please, Click this link to reset password </h3>
						 		<a target="_blank" class="btn btn-primary" href="'.$actual_link.'">Click this link to reset password</a>
						 	</div>
						 </body>
						 </html>';
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
		// $mail->addAddress("pinseyha97@gmail.com", "Recepient Name");

		//Provide file path and name of the attachments
		// $mail->addAttachment("File/text.txt");        
		// $mail->addAttachment("plugin/PHPSendEmail/Image/image.jpg"); //Filename is optional

		$mail->isHTML(true);

		$mail->Subject = "Rithy Granite Company";
		// $mail->Body = "<i>Mail body in HTML</i>";
		$mail->Body = $v_content;
		$mail->AltBody = "This is the plain text version of the email content";

		if(!$mail->send()) 
		{
		    echo "Mailer Error: " . $mail->ErrorInfo;
		} 
		else 
		{
			header("location: login.php?send_status=true&email_name='$v_email'");
		    // echo "Message has been sent successfully";
		}
	}
	else{//Unavalable Email
		header("location: login.php?check_email=false&email_name='$v_email'");
	}
}
 ?>
