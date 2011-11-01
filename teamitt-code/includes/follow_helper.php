
<?php
require_once("../DB/initDB.php");
require_once("../DB/followDB.php");
$followDB = new followDB();
if(isset($_POST['insertFollower']))
{
	$type_id = $_POST["type_id"];
	$content_id = $_POST["content_id"];
	$user_fbid = $_POST["user_fbid"];
	$follow_id = $followDB ->  insertFollower($type_id,$content_id,$user_fbid);
	echo json_encode($follow_id);
}
else if(isset($_POST["getFollowerByContentId"]))
{
	$type_id = $_POST["type_id"];
	$content_id = $_POST["content_id"];
	$result = $followDB -> getFollowerByContentId($type_id,$content_id);
	$rows = array();
	while(($r = mysql_fetch_array($result)) != null)
	{
		$rows[] = $r;
	}
	echo json_encode($rows);
}
else if(isset($_POST["ifUserFollowing"]))
{
	$user_fbid = $_POST["user_fbid"];
	$result =  $followDB -> ifUserFollowing($user_fbid);
	echo json_encode($result);
}
else if(isset($_POST["getFollowedGoalsByUser"]))
{
	$user_fbid = $_POST["user_fbid"];
	$result =  $followDB -> getFollowedGoalsByUser($user_fbid);
	echo json_encode($result);
}
?>
