<?php


$giftid=$_POST["giftid"];
//$userid=$_POST["userid"];
$points=$_POST["points"];

session_start();
$userid=$_SESSION["fbid"];

$userid=mysql_escape_string($userid);

			require_once("../DB/initDB.php");
			require_once("../DB/giftsDB.php");
			require_once("../DB/fbActivity.php");
			$DB = new giftsDB();
			$fbDB = new fbActivityDB();
			if(!$DB->status)
			{
				die("Connection Error");
				exit;
			}

/* check validity of giftid whether it is opened or closed */


if(!$DB->giftExists($giftid))
{
$val=array('status'=>0,'msg'=>'Reward not available for bidding');
print(json_encode($val));
die();
}

/* check validity of userid as well as points in his account */
if(!$fbDB->checkClient($userid))
{
$val=array('status'=>0,'msg'=>'User does not exists');
print(json_encode($val));
die();
}

/* Check User Points */

if(!$DB->giftForUser($giftid, $userid))
{
$val=array('status'=>3,'msg'=>'This reward is not added in your goal.');
print(json_encode($val));
die();
}


$upoints=0;
$upoints = $fbDB->checkPoints($userid);
if($upoints<$points)
{

$val=array('status'=>2,'msg'=>'Insufficient points in your account');
print(json_encode($val));
die();
}





if($DB->AddBid($giftid, $userid, $points))
{

$fbDB->lockPoints($userid, $points, $giftid);

$msg="Thank you for bidding on this gift !";
$val=array('status'=>1,'msg'=>$msg);
print(json_encode($val));
}
else
{
$val=array('status'=>2,'msg'=>'Unknown Error Occured');
print(json_encode($val));

}







?>
