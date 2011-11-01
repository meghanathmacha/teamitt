<?php 
include("../checkid.php");
require_once("../DB/initDB.php");
                        require_once("../DB/checkUser.php");
                        $DB = new userDB();
                        if(!$DB->status)
                        {
                                die("Connection Error");
                                exit;
                        }
$fname=htmlspecialchars($_POST['fname']);
$lname=htmlspecialchars($_POST['lname']);
$title=htmlspecialchars($_POST['title']);
$phone=htmlspecialchars($_POST['phone']);
$gender=htmlspecialchars($_POST['gender']);
$gender = $gender == "M" ? "M" : "F";
$mbti=strtoupper(htmlspecialchars($_POST['mbti']));
$DB->updateUser($USERID,$fname,$lname,$gender,$title,$phone, $mbti);
header("Location:../settings.php?profile&err=1");
?>
