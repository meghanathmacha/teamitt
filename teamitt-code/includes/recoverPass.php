<?php 
require_once("../../tools/sendMail/mail.php");
require_once("../DB/initDB.php");
                        require_once("../DB/checkUser.php");
                        $DB = new userDB();
                        if(!$DB->status)
                        {
                                die("Connection Error");
                                exit;
                        }

$email=$_POST['username'];
// If email is not registered, report error

if(!$DB->checkExistingUser($email)){
	header("Location:../forgotPass.php?err=1");
}
else{
$string="teamitt";
$activationString=$email+$string+time();
$activationKey=md5($activationString);

$result=$DB->getUserInfo($email);
$uid=$result['id'];
$fname=$result['first_name'];
$temp=$DB->insertRecoveryKey($uid,$activationKey);

// Send a Email to the User.

$smtp_address="box381.bluehost.com";      // sets GMAIL as the SMTP server
$smtp_port = 465;
$sender_server_email = "info@goalcat.com";
$sender_server_password ="info@123";

$subject="Password Recovery";
$mail_content = "Hi ".$fname.",<br><br>Click the link below to proceed for your password recovery:<br><br>http://home.goalcat.com/teamitt/newPass.php?key=".$activationKey;
$receiver_mail=$email;

sendEmail($smtp_address,$smtp_port,$sender_server_email,$sender_server_password,$receiver_mail,$mail_content,$subject);

header("Location:../forgotPass.php?err=2");
}
?>
