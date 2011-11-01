<?php
$mailer_path = "/home/ec2-user/teamitt/sendMail/Mailer.php";
include_once($mailer_path);
function sendMail($MAIL_TYPE, $vars)
{
$mailer = new $MAIL_TYPE($vars);
$mailer->pushMail();


}



?>
