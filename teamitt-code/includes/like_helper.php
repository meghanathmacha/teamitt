
<?php
require_once("../DB/initDB.php");
require_once("../DB/likeDB.php");
$likeDB = new likeDB();
if(isset($_POST['insertLiker']))
{
	$type_id = $_POST["type_id"];
	$content_id = $_POST["content_id"];
	$user_fbid = $_POST["user_fbid"];
	$like_id = $likeDB ->  insertLiker($type_id,$content_id,$user_fbid);
	echo json_encode($like_id);
}
else if(isset($_POST["getLikerByContentId"]))
{
	$type_id = $_POST["type_id"];
	$content_id = $_POST["content_id"];
	$result = $likeDB -> getLikerByContentId($type_id,$content_id);
	$rows = array();
	while(($r = mysql_fetch_array($result)) != null)
	{
		$rows[] = $r;
	}
	echo json_encode($rows);
}
else if(isset($_POST["ifUserLiked"]))
{
	$type_id = $_POST["type_id"];
	$content_id = $_POST["content_id"];
	$user_fbid = $_POST["user_fbid"];
	$result =  $likeDB -> ifUserLiked($type_id,$content_id,$user_fbid);
	echo json_encode($result);
}
else if(isset($_POST["getLikeUpdates"]))
{
	$user_fbid = $_POST["user_fbid"];
	$result =  $likeDB -> getLikeUpdates($user_fbid);
	echo json_encode($result);
}
?>
