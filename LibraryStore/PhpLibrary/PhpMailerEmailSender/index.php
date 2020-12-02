<?php
	/*
	*@filename PhpMailerEmailSender/index.php
	*@Author Arpit sharma
	*/

	// Not show any error
	error_reporting(0);
	if(!DomainName){
		// Get server port type (exampale - http:// or https://)
		if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
			$HeaderSecureType = "https://";
		}else{
			$HeaderSecureType = "http://";
		}
		// Create Domain name and save it in const variable
		define("DomainName",  $HeaderSecureType.$_SERVER['HTTP_HOST']);
	}
	
	if(!isset($FileAccessCode) || $FileAccessCode !== 'Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH' ){
		header("Location: " . DomainName . "/PageNotAvailable/index.php");
		die();
		exit();
	}

	if(!@include(RootPath.'LibraryStore/PhpLibrary/PhpMailerEmailSender/PhpMailer/PHPMailerAutoload.php')){
		require_once(RootPath.'LibraryStore/PhpLibrary/PhpMailerEmailSender/PhpMailer/PHPMailerAutoload.php');
	}

	function PhpMailerEmailSender ($PhpMailerEmailSender = array()){
		foreach ($PhpMailerEmailSender as $key=>$value){ ${ $key } = $value; }

		/*if(!@include(RootPath.'LibraryStore/PhpLibrary/PhpMailerEmailSender/PhpMailer/class.phpmailer.php')){
			return ["status"=>"Error","msg"=>"Required files not fetched [ PhpMailerEmailSender ]","code"=>400];
		}*/
		require_once(RootPath.'LibraryStore/PhpLibrary/PhpMailerEmailSender/PhpMailer/PHPMailerAutoload.php');
		#return_response(json_encode(include(RootPath.'LibraryStore/PhpLibrary/PhpMailerEmailSender/PhpMailer/class.phpmailer.php')));

		/*if($MailFromEmail == '' || $MailFromName == '' || $MailTo == '' || $MsgBody == '' || $CheckType == '' || $EPass == ''){
			return ["status"=>"Error","msg"=>"Invalid Data format detect [ PhpMailerEmailSender ]","code"=>400];
		}*/

		$mail = new PHPMailer;

		// $mail->SMTPDebug = 4;                               // Enable verbose debug output

		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'esymanager@gmail.com';                 // SMTP username
		$mail->Password = 'EsyManager@Cov2019@India';                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to

		$mail->setFrom('esymanager@gmail.com', 'Dsmart Tutorials');
		$mail->addAddress('arpitsh018@gmail.com');     // Add a recipient

		#$mail->addReplyTo(EMAIL);
		// print_r($_FILES['file']); exit;
		/*for ($i=0; $i < count($_FILES['file']['tmp_name']) ; $i++) { 
			$mail->addAttachment($_FILES['file']['tmp_name'][$i], $_FILES['file']['name'][$i]);    // Optional name
		}*/
		$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject = 'Otp send';
		$mail->Body    = '<div style="border:2px solid red;">This is the HTML message body <b>in bold!</b></div>';
		$mail->AltBody = 'This is the HTML message body';

		if(!$mail->send()) {
			return_response('Mailer Error: ' . $mail->ErrorInfo);
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			return_response('Message has been sent');
		    echo 'Message has been sent';
		}
	}
?>