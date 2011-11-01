<?php 

include_once("/home/ec2-user/teamitt/sendMail/sendMail.php");


$fname=htmlspecialchars(trim($_POST['fname']));
$lname=htmlspecialchars(trim($_POST['lname']));
$pass=$_POST['password'];
$title=htmlspecialchars($_POST['title']);
$gender=htmlspecialchars($_POST['gender']);
$phone = "";


if($fname == "" || $lname =="" || $title == "" || $pass == "")
{
$r_error = 2;
}

// Check whether user exists
else if($uDB->checkExistingUser($email)){
$r_error = 1; // User already exists
}
else
{

$password=md5("password=".$pass);
/*$string="@@ctivateteamitt";
$activationString=$email+$string+time();
$activationKey=md5($activationString);
*/

if($uDB->insertUser($email,$password,$fname,$lname,$gender,$company_id,$title, $phone))
{
$invited_user_id=$DB->getUserId($email);
$uDB->activateUser($invited_user_id)
$r_error = 0;
$uDB->removeInviteKey($ikey);
$vars = array("name"=> $fname, "email"=>$email);
sendMail("Invited", $vars);
}
else
{
$r_error = 3;
}


//Does activation required here ?
//$uDB->insertActivationKey($uid,$activationKey);



// Send mail to the user


}

?>
