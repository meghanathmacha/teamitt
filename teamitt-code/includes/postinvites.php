<?php
include("ajaxid.php");
include("ajaxadmin.php");


require_once("../DB/initDB.php");
require_once("../DB/usersDB.php");
require_once("../DB/adminDB.php");
include_once("/home/ec2-user/teamitt/sendMail/queueMail.php");
$uDB = new usersDB();
$aDB = new adminDB();

//$USERID =52;
//$_POST["emails"] = "akash.reflectperfection@gmail.com";


if(isset($_POST["emails"]))
{
$domain = $uDB->getCompanyDomain($USERID);
$company_id = $uDB->getCompanyId($USERID);

$emails = trim($_POST["emails"]);

$emails = explode(",", "$emails");

$succ = 0;


	$vars = array();
	$vars["userid"] = $USERID;

$listemails =array();

$total_emails = 0;

foreach($emails as $email)
{
$email = trim($email);
if(!preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/',$email)){
continue;
}
$total_emails++;

$temp=split('@',$email);
$emaildomain=$temp[1];

if($emaildomain == $domain && !$aDB->userExist($email))
{
$ikey = md5("Invite".$email."@Teamitt.ComBy".$USERID);

if($aDB->existInvites($USERID, $email))
{
$aDB->updateInvites($USERID, $email);
$listemails[] =$email;
$succ++;
}
else if($aDB->addInvites($USERID, $company_id, $email, $ikey))
{
$listemails[] =$email;
$succ++;
}

}
else { 
//echo "Skip $email\n";
}

}


$listemails = implode(",", $listemails);


	$vars["emails"] = $listemails;
	queueMail("Invite", $vars);


if($succ == 0)
{
$output = array("success"=>0, "message"=>"No invitaions Sent, Try again !");
}
else if($succ == $total_emails)
{
$output = array("success"=>2, "message"=>"All the invitaions are sent!");
}
else
{
$msg =$succ." invitations out of ".$total_emails." are sent";
$output = array("success"=>1, "message"=>$msg);
}

print(json_encode($output));

}





?>
