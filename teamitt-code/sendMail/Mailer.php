<?php
$dir_path ="/home/ec2-user/teamitt/";
$curr_path ="/home/ec2-user/teamitt/sendMail/";

require_once($dir_path."DB/initDB.php");
require_once($dir_path."DB/MailsDB.php");

require_once($curr_path.'PHPMailer_v5.1/class.phpmailer.php');

class Mailer
{
protected $body;
protected $alt_body;
protected $subject;

public function sendMail($email, $name)
{
date_default_timezone_set('America/Toronto');
$mail = new PHPMailer();
$mail->IsSMTP(); 
$mail->Host       = "mail.teamitt.com";
$mail->SMTPDebug  = 0;                     

$mail->SMTPAuth   = true;                 
$mail->SMTPSecure = "ssl";                 
$mail->Host       = "box381.bluehost.com";      
$mail->Port       = 465;                   
$mail->Username   = "notification@teamitt.com"; 
$mail->Password   = "notifyTeamitt";  
$mail->SetFrom('notification@teamitt.com', 'Teamitt');
$mail->AddReplyTo("notification@teamitt.com","Teamitt");

$mail->Subject    = $this->subject;

$msg_body ="<div style='background:#f6f6f6; padding: 20px;'>";
$msg_body .="Hi $name,<br/>";
$msg_body .= $this->body;
$msg_alt_body ="Hi $name,
";
$msg_alt_body .= $this->alt_body;
$mail->AltBody  = $msg_alt_body;

$mail->MsgHTML($msg_body);

$mail->AddAddress($email,$name);
$mail->Send();

}

}

class Register extends Mailer
{
private $uname,$email;

public function __construct($vars)
{
global $curr_path;
$ackey = $vars["ackey"];
$this->uname = $vars["name"];
$this->email= $vars["email"];

$this->subject = "Confirm your Teamitt account";


$msg_body =file_get_contents($curr_path.'reg_header.html');
$msg_body .= "
<br/>
<a href='http://www.teamitt.com/activate.php?key=".$ackey."'>http://www.teamitt.com/activate.php?key=".$ackey."</a>";
$msg_body .=file_get_contents($curr_path.'mail_footer.html');
$this->body = $msg_body;

$msg_alt_body = file_get_contents($curr_path.'reg_header.txt');
$msg_alt_body .= "
http://www.teamitt.com/activate.php?key=".$ackey."

If the above link doesn't work, try copying the url in your browser's location bar.

";
$msg_alt_body .=file_get_contents($curr_path.'mail_footer.txt');
$this->alt_body = $msg_alt_body;



}

public function pushMail()
{
$this->sendMail($this->email, $this->uname);
}

}

class IRegister extends Mailer
{
private $uname,$email;

public function __construct($vars)
{
global $curr_path;
$this->uname = $vars["name"];
$this->email= $vars["email"];
$email= $vars["email"];

$this->subject = "Welcome to Teamitt";


$msg_body = "
<div style='border:1px solid #e5e5e5;padding:10px 20px;'>
Congratulations, You have just created your account at Teamitt.
<br/><br/>
Please click on link given below to login into your account.

<br/>
<a href='http://www.teamitt.com/login.php?email=".$email."'>http://www.teamitt.com/login.php</a>";
$msg_body .=file_get_contents($curr_path.'mail_footer.html');
$this->body = $msg_body;

$msg_alt_body = "
Congratulations, You have just created your account at Teamitt.


Please click on link given below to login into your account.

http://www.teamitt.com/login.php?email=".$email."

If the above link doesn't work, try copying the url in your browser's location bar.

";
$msg_alt_body .=file_get_contents($curr_path.'mail_footer.txt');
$this->alt_body = $msg_alt_body;



}

public function pushMail()
{
$this->sendMail($this->email, $this->uname);
}

}

class Activate extends Mailer
{
private $uname,$email;

public function __construct($vars)
{
global $curr_path;
$this->uname = $vars["name"];
$this->email= $vars["email"];
$email= $vars["email"];

$this->subject = "Your account has been activated";


$msg_body = "
<div style='border:1px solid #e5e5e5;padding:10px 20px;'>
Congratulations, You account has been activated at Teamitt.
<br/><br/>
Please click on link given below to login into your account.

<br/>
<a href='http://www.teamitt.com/login.php?email=".$email."'>http://www.teamitt.com/login.php</a>";
$msg_body .=file_get_contents($curr_path.'mail_footer.html');
$this->body = $msg_body;

$msg_alt_body = "
Congratulations, Your account has been activated at Teamitt.

Please click on link given below to login into your account.

http://www.teamitt.com/login.php?email=".$email."

If the above link doesn't work, try copying the url in your browser's location bar.

";
$msg_alt_body .=file_get_contents($curr_path.'mail_footer.txt');
$this->alt_body = $msg_alt_body;



}

public function pushMail()
{
$this->sendMail($this->email, $this->uname);
}

}




class Invited extends Mailer
{
private $uname,$email;

public function __construct($vars)
{
global $curr_path;
$ackey = $vars["ackey"];
$this->uname = $vars["name"];
$this->email= $vars["email"];

$this->subject = "Welcome to Teamitt";


$msg_body = "
<div style='border:1px solid #e5e5e5;padding:10px 20px;'>
<br/>
Congratulations, you are now registered at teamitt, 
<br/>
Click on the below link to login<br/>
<a href='http://www.teamitt.com/login.php>http://www.teamitt.com/login.php</a>
<br/><br/>
";
$msg_body .=file_get_contents($curr_path.'mail_footer.html');
$msg_body .=file_get_contents($curr_path.'mail_footer.html');
$this->body = $msg_body;

$msg_alt_body = "

Congratulations, you are now registered at teamitt

Click on the below link to login

http://www.teamitt.com/login.php

";
$msg_alt_body .=file_get_contents($curr_path.'mail_footer.txt');
$this->alt_body = $msg_alt_body;

}

public function pushMail()
{
$this->sendMail($this->email, $this->uname);
}

}




?>
