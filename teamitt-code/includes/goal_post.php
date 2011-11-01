 <?php
include("ajaxid.php");
include("feed_helper.php");
include_once("/home/ec2-user/teamitt/sendMail/queueMail.php");

$feedtypes=Array("action"=>1, "thank"=>2, "update"=>3);
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
else { $userids = "".$USERID;}


	require_once("../DB/initDB.php");
	require_once("../DB/postsDB.php");
	require_once("../DB/usersDB.php");
	include("../DB/goalsDB.php");
	$uDB= new usersDB();
	$gDB = new goalsDB();
	$DB = new postsDB();
	if(!$DB->status)
	{
		die("Connection Error");
		exit;
	}



	
$ref = getenv('HTTP_REFERER');
$url = (parse_url($ref));
if(strlen($url["query"])>0)
{
$query = explode("=", $url["query"]);
$goal_id =$query[1];
}
else { exit; }


$goal_data = array();
$goal_data[0] = $goal_id;
$goalname= $gDB->goalName($goal_id);
$goal_data[1]= $goalname;


$more=0;
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



switch($type)
{
case "action":
	$actionid=$DB -> AddAction($post, $USERID, 1, $goal_id); //1 for goal type
	if($actionid) {
	$feedid=$DB -> insertFeed(1, $USERID, $firstuserid, $post, "actions", $actionid, $more);
 	$DB -> attachToGoal($feedid, $goal_id);
	}
	$DB -> insertActionReceivers($actionid, $olduserids);
	$DB -> insertFeedReceivers($feedid, $userids);
	$DB -> insertVisibility($feedid, 1, $olduserids);
	$DB -> insertVisibility($feedid, 1, $USERID);
	$DB -> insertVisibility($feedid, 2, $goal_id);
	

	$vars = array();
	$vars["userid"] = $USERID;
	$vars["actionid"] = $actionid;
	$vars["feedid"] = $feedid;
	$vars["content"] = $post;
	$vars["goal"] = $goalname;
	queueMail("Action", $vars);
	break;

case "update":
	$updateid=$DB -> AddUpdate($post, $USERID);
	if($updateid) {
	$feedid=$DB -> insertFeed(3, $USERID, $USERID, $post, "updates", $updateid, $more);
 	$DB -> attachToGoal($feedid, $goal_id);
	}
	$compid=$uDB->getCompanyId($USERID);
	if($compid){
	$DB -> insertVisibility($feedid, 3, $compid);
	}
	$DB -> insertVisibility($feedid, 2, $goal_id);
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

$badge_arr = null;

$UFNAME=$uDB->fullName($USERID, NULL);
$$ifOpenFeed = false;
$ifUserLiked = false;
$time_ago = "Few seconds ago";
$due_date = NULL;
	
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



$side_buttons = composeSideButtons($USERID,NULL,$USERID,$ifOpenFeed);

$feed_base = composeFeedBase($feed_type,$ifUserLiked,$time_ago,$due_date,$goal_id);
$compfeed = composeFeedTos($more_arr,$you_flag);
$message = composeMessage($feed_type,$post,$USERID,"You",$compfeed, $goal_data,$badge_arr);

$profile_id="profile.php?id=$USERID";
$profile_pic="uploads/profileimg/profileimg-".$USERID.".jpg";
$posthtml= viewFeed($goal_id,$feedid,$USERID,$message,0,$feed_base, $USERID, null);
echo $posthtml;


}
?>

