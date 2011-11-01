
<?php
$user_fbid = $_GET['user_fbid'];
require_once("../DB/initDB.php");
require_once("../DB/goalsDB.php");
$goalDB = new goalsDB();
$result = $goalDB -> getGoalsByUser($user_fbid);
$rows = array();
while(($r = mysql_fetch_array($result)) != null)
{
	$rows[] = $r;
}
echo json_encode($rows);
?>
