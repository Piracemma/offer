<?php 

// Set the content type
header('Content-Type: text/html; charset=utf-8');

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

if(!empty($name) && !empty($email) && !empty($message)) 
{
	// Mail template (Your mail)
	$to_email = 'yourmail@example.com';
	$mail_subject = 'FreeCart : Contact-US';
	$main_title = "FreeCart";
	$site_title = "FreeCart - ecommerce html lite template";
	
	$tbl = '<html>
		<head>
			<title>'.$site_title.'</title>
		</head>
		<body aria-readonly="false">Hello,&nbsp; <strong>'.$main_title.'</strong><br />
			<br />
			You got new inquiry  on <strong>'.$site_title.'</strong><br />
			<br />
			<strong>Item Name : </strong>'.$site_title.'<br />
			<strong>User Name : </strong>'.$name.'<br />
			<strong>Email :</strong>'.$email.'<br />
			<strong>Message :</strong>'.$message.'<br />
		</body>
		</html>';
		
	// Sending detail
	$to = $to_email;
	$subject = $mail_subject;
	$message = $tbl;
	$headers = 'From: '.$to_email. "\r\n" .
		'Reply-To: '.$to_email. "\r\n" .
		'Content-type: text/html' . "\r\n" .
		'charset: utf8' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
		
	//echo mail($to, $subject, $message, $headers);
	
	if( @mail($to, $subject, $message, $headers) )
	{
		echo 1;
	}
	else
	{
		echo 2;
	}
}
else
{	
	echo 2;
}	
 
?>