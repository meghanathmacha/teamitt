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
$oldpass=$_POST['oldpass'];
$newpass1=$_POST['newpass1'];
$newpass2=$_POST['newpass2'];
if($newpass1!=$newpass2){
	header("Location:../account_setting.php?err=1");
}
else if(strlen($newpass1)<6){
	header("Location:../account_setting.php?err=2");
}

$password=md5("password="+$oldpass);

$result=$DB->getUserInfoId($USERID);
$savedpass=$result['password'];

if($password!=$savedpass){
	header("Location:../account_setting.php?err=3");
}
else{
	$password=md5("password="+$newpass1);
	$DB->updatePass($USERID,$password);
	header("Location:../account_setting.php?err=4");
}
?>
