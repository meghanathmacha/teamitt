<?php

$profileTab = "";
$accountTab = "";
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
case "company":
	$settingTab = "class='selected'";
	include("CompanySetting.php");
	break;
case "account":
	$accountTab = "class='selected'";
	include("AccountSettings.php");
	break;
default:
	$profileTab = "class='selected'";
	include("ProfileSettings.php");
	break;



}






?>
