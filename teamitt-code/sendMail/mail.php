
<?php
function sendEmail($smtp_address,$smtp_port,$sender_email,$sender_password,$receiver_email,$body,$subject)
{
//error_reporting(E_ALL);
error_reporting(E_STRICT);

date_default_timezone_set('America/Toronto');
require_once('PHPMailer_v5.1/class.phpmailer.php');
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail             = new PHPMailer();

//$body             = "hi";//file_get_contents('contents.html');
$body             = eregi_replace("[\]",'',$body);

$mail->IsSMTP(); // telling the class to use SMTP
//$mail->Host       = "mail.google.com"; // SMTP server
$mail->Host       = "mail.goalcat.com"; // SMTP server
$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
$mail->Host =    $smtp_address;      // sets GMAIL as the SMTP server
$mail->Port  = $smtp_port;                   // set the SMTP port for the GMAIL server
$mail->Username   = $sender_email;  // GMAIL username
$mail->Password   = $sender_password;            // GMAIL password
//$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
//$mail->Host       = "mail.goalcat.com";      // sets GMAIL as the SMTP server
//$mail->Host=     "box381.bluehost.com";      // sets GMAIL as the SMTP server
//$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
//$mail->Port       = 26;                   // set the SMTP port for the GMAIL server
/*$mail->Username   = "akash.reflectperfection@gmail.com";  // GMAIL username
$mail->Password   = "*********";            // GMAIL password*/
//$mail->Username   = "freaks61@gmail.com";  // GMAIL username
//$mail->Password   = "integration";            // GMAIL password
//$mail->Username   = "info@goalcat.com";  // GMAIL username
//$mail->Password   = "info@123";            // GMAIL password

$mail->SetFrom('info@teamitt.com', 'Teamitt');

//$mail->AddReplyTo("no-reply@goalcat.com","Goalcat.com");

$mail->Subject    =$subject;

$mail->AltBody    =  strip_tags($body);

$mail->MsgHTML($body);

//$address = "ja";
$mail->AddAddress($receiver_email, "");

//$mail->AddAttachment("myphotos/friend/DSC00122.JPG");      // attachment
//$mail->AddAttachment("myphotos/friend/DSC08266.JPG"); // attachment

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}
}

?>

