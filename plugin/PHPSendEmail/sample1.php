<?php
	use PHPMailer\PHPMailer\PHPMailer;
	require_once "vendor/autoload.php";

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
	$mail->FromName = "Full Name";

	$mail->addAddress("chhumsilak1999@gmail.com", "Recepient Name");

	//Provide file path and name of the attachments
	$mail->addAttachment("File/text.txt");        
	$mail->addAttachment("Image/image.jpg"); //Filename is optional

	$mail->isHTML(true);

	$mail->Subject = "Subject Text";
	$mail->Body = "<i>Mail body in HTML</i>";
	$mail->AltBody = "This is the plain text version of the email content";

	if(!$mail->send()) 
	{
	    echo "Mailer Error: " . $mail->ErrorInfo;
	} 
	else 
	{
	    echo "Message has been sent successfully";
	}
?>