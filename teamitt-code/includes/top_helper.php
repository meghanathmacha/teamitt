<?php
	require_once("../DB/initDB.php");
	require_once("../DB/goalDB.php");
	$goal_DB = new goalDB();
	$row = 40;
	$result = $goal_DB -> UsersByGoalPoints($row);
	$rows = array();
	while(($r = mysql_fetch_array($result)) != null)
	{
		$rows[] = $r;
	}
	echo json_encode($rows);
?>
