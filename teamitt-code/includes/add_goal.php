<?php
$user_fbid = $_GET['user_fbid'];
$title = $_GET['title'];
require_once("../DB/initDB.php");
require_once("../DB/goalsDB.php");
$goalDB = new goalsDB();
if(!$goalDB->status)
{
	die("Connection Error");
	exit;
}

$goal_id = $goalDB -> AddGoal($title, $user_fbid);
echo json_encode($goal_id);

?>
