<?php
error_reporting(0);
function confirm($email,$name)
{
date_default_timezone_set('America/Toronto');
require_once('PHPMailer_v5.1/class.phpmailer.php');
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail = new PHPMailer();

$body ="<div style='background:#f6f6f6; padding: 5px 8px;'>";
$body .="Hi  $name ,<br/>";
$body.=file_get_contents('mail_header.html');

$content="
<br/>
<a href='http://teamitt.com/confirmation.php?aclink=$aclink'>
http://teamitt.com/confirmation.php?aclink=$aclink
</a>
 <br/>
<br/>
If above link doesn't works  copy and paste the given url link  in browser.
<br/>
<br/>
http://teamitt.com/confirmation.php?aclink=$aclink
<br/>
<br/>";

$body.=$content;

$body.=file_get_contents('mail_footer.html');
$body .= "</div>";
$body             = eregi_replace("[\]",'',$body);

$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = "mail.teamitt.com"; // SMTP server
$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
$mail->Host       = "box381.bluehost.com";      // sets GMAIL as the SMTP server
$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
$mail->Username   = "info@teamitt.com";  // GMAIL username
$mail->Password   = "infomail@teamitt";            // GMAIL password

$mail->SetFrom('info@teamitt.com', 'Teamitt');

$mail->AddReplyTo("info@teamitt.com","Teamitt");

$mail->Subject    = "Confirm your new teamitt account";

$mail->AltBody  = strip_tags($body); // optional, comment out and test

$mail->MsgHTML($body);

$address = $email;
$mail->AddAddress($address,$name);

//$mail->AddAttachment("myphotos/friend/DSC00122.JPG");      // attachment
//$mail->AddAttachment("myphotos/friend/DSC08266.JPG"); // attachment

if(!$mail->Send()) {
 echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}

}

confirm("akash.reflectperfection@gmail.com","Akash","6565ghfgg54433ddsds3232");
?>

