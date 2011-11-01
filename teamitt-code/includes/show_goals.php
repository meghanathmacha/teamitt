
<?php
require_once("../DB/initDB.php");
require_once("../DB/feedsDB.php");
$feedsDB = new feedsDB();
$user_id = $_GET['user_id'];
$result = $feedsDB -> getGoalsByUserId($user_id);
$content = '<div class = "goal_attach">';
while(($row = mysql_fetch_array($result)) != null)
{
	$goal_name = $row['name'];
	
	
	$goal_id = $row['id'];
	$path = '../static/images/ambitions.png';
	$content.= '<div class = "goal_row" id = "goal-row-'.$goal_id.'">';
	$content.= '<div class = "goal_img">';
	$content.= '<img src = "'.$path.'"></img>';
	$content.= '</div>';
	$content.= '<div class = "goal_name">';
	$content.= '<span>'.$goal_name.'</span>';
	$content.= '</div></div>';
	$content.= '<div class = "clr"> </div> ';
}
$content.= '</div>';
echo "<div id='eventHeader'><span onClick='closeBox();'></span>
<ul class = 'tabs'>
<li class = 'attach_goal_tab'>Attach  Goal</li>
<li class = 'create_goal_tab'> Create Goal </li>
</ul>
<div class = 'clr'></div>
</div>";
echo "<div id = 'eventContent' > <div class = 'attach_goal_content'>$content</div></div>";
/*$result = $feedsDB -> getConnectionGoalsByUserId($user_id);
$result = $feedsDB -> getAllGoalsByUserId($user_id);*/
?>
