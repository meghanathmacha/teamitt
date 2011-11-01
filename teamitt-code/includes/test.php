<?php 
require_once("../sendMail/sendMail.php");
// Send a Email to the User.

$fname= "Akash Sinha";
$receiver_mail = "akash.reflectperfection@gmail.com";
$activationKey = "ds43ffg42dsd5475fb3";

$vars = array("name"=> $fname, "email"=>$receiver_mail, "ackey"=>$activationKey);
sendMail("Register", $vars);

?>
