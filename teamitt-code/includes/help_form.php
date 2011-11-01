
<table>
<?php
require_once("../DB/initDB.php");
require_once("../DB/goalsDB.php");
$goalDB = new goalsDB();
if(isset($_GET['profile_user_fbid']))
{
	$profile_user_fbid = $_GET['profile_user_fbid'];
	$result = $goalDB -> isUser($profile_user_fbid);
if(!$result)
{
?>
<tr class = 'mail_input'>
<td>
<label for='receiver_email'>Your Friend Email Address </label> </td>
<td><input type = "text" id="receiver_email"  value="" name="receiver_email" class="text" required="true" placeholder="enter friend's email address"/></td>
</tr>
<?php
}
else
{
$row = mysql_fetch_array($result);
$profile_user_email = $row["facebook_email"];
?>

<tr class = 'mail_input'>
<td></td>
<td><input type = "hidden" id="receiver_email"  value= '<?php echo $profile_user_email ?>' name="receiver_email" class="text" required="true" placeholder="enter friend's email address"/></td>
</tr>
<?php
}
}
$user_fbid = $_GET['user_fbid'];
$result = $goalDB -> getGoalsByUser($user_fbid);
if($result)
{
?>
<tr>
<td>
	<label for='goal_selection'>Select Goal</label> </td>
<td>
<select name = 'goal_selection' id = 'goal_selection'>
<?php
while(($row = mysql_fetch_array($result)) != null)
{
	$goal_title = $row["title"];
	$goal_id = $row["goalid"];
	?>
	<option value = <?php echo $goal_id ?> > <?php echo $goal_title ?> </option>
	<?php
}
?>
	<option value = "0"> Add New </option></select> </td></tr>
        <tr style='display:none'> 	
	
	<td><label for='add_goal'>Add Your Goal</label></td>
	<td> <input id="add_goal"  value="" name="add_goal" class="text" required="true" placeholder=""/></td>
	</tr>
<?php 
} 
else
{
?>
	<tr>
	<td><label for='add_goal'>What is your Goal</label></td>
	<td><input id="add_goal"  value="" name="add_goal" class="text" required="true" placeholder=""/></td>
	</tr></table>
<?php
}
	
?>

</ul>
