<?php

$inviteTab = "";
$badgeTab = "";
$settingTab = "";

$query=$_SERVER["QUERY_STRING"];
if(!$query) { $query="NONE";}

switch($query)
{
case "badge":
	$badgeTab = "class='selected'";
	include("BadgeAdmin.php");
	break;
case "invite":
	$inviteTab = "class='selected'";
	include("InviteAdmin.php");
	break;
default:
	$settingTab = "class='selected'";
	include("CompanySetting.php");
	break;


}



?>
