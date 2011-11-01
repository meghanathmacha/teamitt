<?php
include("../DB/initDB.php");
include("../DB/fbActivity.php");
$DB=new fbActivityDB();
if(!$DB->status)
{
	die("Connection Error");
	exit;
}

$type  = $_POST['type'];
switch($type)
{
case "save":
$facebook_id  = $_POST['facebook_id'];
$facebook_email  = $_POST['facebook_email'];
$facebook_name = $_POST['facebook_name'];
$isClient = $DB->checkClient($facebook_id);
if(!$isClient) {
	$DB->AddClient($facebook_id, $facebook_email, $facebook_name);
} else{
	$DB->updateLogin($facebook_id);
}
break;

case "session":
session_start();
$facebook_id  = $_POST['facebook_id'];
$action=$_POST["action"];
if($action=="disable")
{
unset($_SESSION["fbid"]);
session_destroy();
}
else
{
$_SESSION["fbid"]=$facebook_id;
}
break;
default:
break;


}

?>
