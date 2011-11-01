<?php 
require_once("../sendMail/sendMail.php");
require_once("../DB/initDB.php");
                        require_once("../DB/registerDB.php");
                        require_once("../DB/badgeDB.php");
                        $rDB = new registerDB();
                        $bDB = new badgeDB();
                        if(!$rDB->status)
                        {
                                die("Connection Error");
                                exit;
                        }
$email=$_POST['email'];
$fname=$_POST['fname'];
$lname=$_POST['lname'];
$pass1=$_POST['password'];
$pass2=$_POST['cpassword'];
$title=$_POST['title'];
$phone=$_POST['phone'];
$gender=$_POST['gender'];

$password=md5("password=".$pass1);

if(!preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/',$email)){
header("Location:../register.php?error=1");
	die();
}

$temp=split('@',$email);
$domain=$temp[1];
if($rDB->checkDomain($domain)) {
header("Location:../register.php?error=2");
die();
}

// Check whether user exists
if($rDB->checkExistingUser($email)){
header("Location:../register.php?error=3");
die();
}
$newcomp = false;

if(strlen($pass1) < 6) {
header("Location:../register.php?error=4");
die();
}

if($pass2 != $pass2 ) {
header("Location:../register.php?error=5");
die();
}




$string="teamitt";
$activationString=$email+$string+time();
$activationKey=md5($activationString);
$company_id=$rDB->getCompanyId($domain);
$activated = 0;

$rDB->insertUser($email,$fname,$lname,$gender,$company_id,$title,$phone, $password, $activated);

$uid=$rDB->getUserId($email);
if($uid)
{
if(!$rDB->checkExistingDomain($domain)){
	// Add a new group and the user to that group
	$rDB->addCompany($domain);
	$re=$bDB->getBadges();
	$company_id=$rDB->getCompanyId($domain);
	$points=0;
	while($row=mysql_fetch_row($re)){
		$badgeId=$row[0];
		$rDB->addBadge($badgeId,$company_id,$points);
	}
$newcomp = true;
}



if($newcomp)
{
$rDB->makeDomainAdmin($uid, $company_id, 2);
}


$rDB->insertActivationKey($uid,$activationKey);
$vars = array("name"=> $fname, "email"=>$email, "ackey"=>$activationKey);
sendMail("Register", $vars);

}
else
{
header("Location:../register.php?error=6");
die();
}



// Send mail to the user




header("Location:../registered.php");
?>
