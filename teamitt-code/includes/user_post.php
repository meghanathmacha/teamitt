 <?php
include("ajaxid.php");
include("feed_helper.php");
include("utility.php");
include_once("/home/ec2-user/teamitt/sendMail/queueMail.php");


$feedtypes=Array("action"=>1, "thank"=>2, "update"=>3, "giveFeedback"=>11, "askFeedback"=>12);
     
if(isset($_POST['type']))
    {

$type=$_POST["type"];
$feed_type=$feedtypes[$type];
$post=$_POST["post"];
$post=htmlspecialchars($post);
if(isset($_POST["userids"]))
{
$userids= $_POST["userids"];
}
else { $userids = "";}

	require_once("../DB/initDB.php");
	require_once("../DB/postsDB.php");
	require_once("../DB/usersDB.php");
	$uDB= new usersDB();
	$DB = new postsDB();
	if(!$DB->status)
	{
		die("Connection Error");
		exit;
	}
	
$more=0;
$badgeUrl=0;
$profile = 0;
$badge_arr = array();

$ref = getenv('HTTP_REFERER');
$url = (parse_url($ref));
$ref_profile =0;
if($url["path"] == "profile.php")
{
$ref_profile = 1;
}
if(strlen($url["query"])>0)
{
$query = explode("=", $url["query"]);
if($query[1]!=$USERID)
{
$profile =$query[1];
}
}

if(!$profile)
{
if($type!="update")
{
$userids=trim($userids);
$olduserids= $userids;
if(strlen($userids))
{
$userids=explode(",", $userids);
}
else
{
$userids=Array();
}
$user_cnt=count($userids);
$more=0;
if(count($userids))
{
$firstuserid = $userids[0];
unset($userids[0]);
$userids = array_values($userids);
$userids=implode(",", $userids);
if(count($userids))
{
$more=1;
}
}
else
{
$firstuserid = $USERID;
}
}

}
else
{
$firstuserid = $profile;
$userids = "";
$olduserids = $firstuserid;
}

$ifOpenFeed = false;
switch($type)
{
case "action":
	$actionid=$DB -> AddAction($post, $USERID, 0, 0);
	if($actionid) {
	$feedid=$DB -> insertFeed(1, $USERID, $firstuserid, $post, "actions", $actionid, $more);
	}
	$DB -> insertActionReceivers($actionid, $olduserids);
	$DB -> insertFeedReceivers($feedid, $userids);
	$DB -> insertVisibility($feedid, 1, $olduserids);
	$DB -> insertVisibility($feedid, 1, $USERID);
	
	$vars = array();
	$vars["userid"] = $USERID;
	$vars["actionid"] = $actionid;
	$vars["feedid"] = $feedid;
	$vars["content"] = $post;
	queueMail("Action", $vars);
	break;

case "askFeedback":
	if(!$profile) { exit;}
	$feedbackid=$DB -> AddFeedback($post, $profile, $USERID, 0);
	if($feedbackid) {
	$feedid=$DB -> insertFeed(12, $USERID, $firstuserid, $post, "feedbacks", $feedbackid, $more);
	}
	$DB -> insertVisibility($feedid, 1, $olduserids);
	$DB -> insertVisibility($feedid, 1, $USERID);
	break;

case "giveFeedback":
	if(!$profile) { exit;}
	$feedbackid=$DB -> AddFeedback($post, $profile, $USERID, 1);
	if($feedbackid) {
	$feedid=$DB -> insertFeed(11, $USERID, $firstuserid, $post, "feedbacks", $feedbackid, $more);
	}
	$DB -> insertVisibility($feedid, 1, $olduserids);
	$DB -> insertVisibility($feedid, 1, $USERID);
	break;

case "thank":
	$badgeid = $_POST["badgeid"];
        if($badgeid > 0)
        {
	include("../DB/badgeDB.php");
	require_once("../DB/usersDB.php");
	$uDB=new usersDB();
	$remainingPoints=$uDB->getUserRemainingPoint($USERID);
	$compId=$uDB->getCompanyId($USERID);
		
	$bDB = new badgeDB();
        $badgeDet = $bDB -> getBadge($badgeid,$compId);	
        $badge_arr["badgename"] = $badgeDet[0];
        $badge_arr["url"] = $badgeDet[1];
	$badge_arr["points"]=$badgeDet[2];
	if(($user_cnt * $badge_arr["points"]) > $remainingPoints){
		echo '0';
		exit;
	}
        }
	$thankid=$DB -> AddThank($post, $USERID, $badgeid);
	if($thankid) {
	$feedid=$DB -> insertFeed(2, $USERID, $firstuserid, $post, "thanks", $thankid, $more);
	}
	$leftPoints=$remainingPoints-($user_cnt*$badge_arr["points"]);
	$re=$uDB->updateUserRemainingBadgePoints($USERID,$leftPoints);
	$DB -> insertThankReceivers($thankid, $olduserids);
	$DB -> insertFeedReceivers($feedid, $userids);
	$DB -> insertVisibility($feedid, 1, $olduserids);
	$DB -> insertVisibility($feedid, 1, $USERID);
	$compid=$uDB->getCompanyId($USERID);
	if($compid){
	$DB -> insertVisibility($feedid, 3, $compid);
	}
	$vars = array();
	$vars["userid"] = $USERID;
	$vars["thankid"] = $thankid;
	$vars["feedid"] = $feedid;
	$vars["badgeid"] = $badgeid;
	$vars["content"] = $post;
	queueMail("Thank", $vars);
	break;
case "update":
$ifOpenFeed = true;
	$updateid=$DB -> AddUpdate($post, $USERID);
	if($updateid) {
	$feedid=$DB -> insertFeed(3, $USERID, $USERID, $post, "updates", $updateid, $more);
	}
	$compid=$uDB->getCompanyId($USERID);
	if($compid){
	$DB -> insertVisibility($feedid, 3, $compid);
	}
	$DB -> insertVisibility($feedid, 1, $USERID);
	break;

default:
break;	
}	

$allusers=explode(",", $userids);
$more_second_user="";
$more_third_user="";
if($firstuserid==$USERID)
{
$more_first_user="You";
}
else
{
$more_first_user=$uDB->fullName($firstuserid, NULL);
}

if(count($allusers))
{
$more_second_user=$uDB->fullName($allusers[0], NULL);
if(count($allusers)>1)
{
$more_third_user=$uDB->fullName($allusers[1], NULL);
}

}


$UFNAME=$uDB->fullName($USERID, NULL);
$goal_id = 0;
$ifUserLiked = false;
$time_ago = "Few seconds ago";
$due_date = NULL;
if(!$profile)
{
$profile = $USERID;
}
/*$badge_arr['url'] = 
$badge_arr['badgename']=
$goal_data[0]= 'Goal_name';
$goal_data[1] = 'goal_id';*/
		
	$more_count = 0;
	$you_flag = -1;
	$more_users = '';
	$userIds = explode(",", $olduserids);
	$more_arr = array();
		foreach($userIds as $userId)
		{
			$more_user_id = $userId;	
			$more_user_name = $uDB->fullName($userId, NULL);
			if($more_user_id == $USERID)
			{
				$more_user_name = 'you';
				$you_flag = $more_count;
			}
			$more_arr[$more_count]['id'] = $more_user_id;
			$more_arr[$more_count]['name'] = $more_user_name;
			$more_count++;
		}


if(!$ref_profile)
{
$side_buttons = composeSideButtons($USERID,NULL,$USERID,$ifOpenFeed);
}
else
{
$side_buttons = composeSideButtons($USERID,$profile,$USERID,$ifOpenFeed);

}
$feed_base = composeFeedBase($feed_type,$ifUserLiked,$time_ago,$due_date,$goal_id);
$compfeed = composeFeedTos($more_arr,$you_flag);
$message = composeMessage($feed_type,$post,$USERID,"You",$compfeed,null,$badge_arr);
/*$compfeed = composeFeedTos($more_first_user,$more_second_user,$more_third_user,$user_cnt);
$message=composeMessage($feedtype, $post, $USERID,"You",0,0,$compfeed,0,$badgeUrl) ;*/

$profile_id="profile.php?id=$USERID";
$profile_pic="uploads/profileimg/profileimg-".$USERID.".jpg";
$posthtml= viewFeed($profile,$feedid,$USERID,$message,0,$feed_base,$USERID,null,null,$side_buttons);
echo $posthtml;


}
?>

