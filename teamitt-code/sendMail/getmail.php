<?php
set_time_limit(0); 

$mailer_path = "/home/ec2-user/teamitt/sendMail/dequeueMailer.php";
include_once($mailer_path);

$dir_path ="/home/ec2-user/teamitt/";

require_once($dir_path."DB/initDB.php");
require_once($dir_path."DB/MailsDB.php");

$mDB = new MailsDB();
$mails = $mDB ->getmail(50);
while(list($mail_id, $MAIL_TYPE, $serialized_vars) = mysql_fetch_row($mails))
{
$vars = unserialize($serialized_vars);

$mailer = new $MAIL_TYPE($vars);
$mailer->pushMail();

// Removing it from the mail queue
$mDB ->removemail($mail_id);


}








?>
