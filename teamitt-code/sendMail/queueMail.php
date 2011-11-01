<?php

$dir_path ="/home/ec2-user/teamitt/";
$curr_path ="/home/ec2-user/teamitt/sendMail/";

require_once($dir_path."DB/initDB.php");
require_once($dir_path."DB/MailsDB.php");

function queueMail($MAIL_TYPE, $vars)
{
$mailDB  = new MailsDB();
$mailDB->putMail($MAIL_TYPE, $vars);

}


//$vars = array();
/* Comment 
$vars["feedid"] = "598";
$vars["userid"] = 31;
$vars["content"] = "Try to do it asap !";
*/


/* vars for action  */

/*
$vars["userid"] = 31;
$vars["actionid"] = 172;
$vars["feedid"] = 598;
$vars["content"] = "Gear up for our first customer !";



$MAIL_TYPE = "Action";
queueMail($MAIL_TYPE, $vars);
*/




?>
