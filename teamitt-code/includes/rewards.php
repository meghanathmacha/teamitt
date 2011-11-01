<?php



$rewardid=$_POST["rewardid"];
session_start();
$userid=$_SESSION["fbid"];
$action=$_POST["action"];


			require_once("../DB/initDB.php");
			require_once("../DB/goalsDB.php");
			$DB = new goalsDB();
			if(!$DB->status)
			{
				die("Connection Error");
				exit;
			}
switch($action)
{
case  "show";
/* check validity of userid and owner of goal */

echo "<div id='eventHeader'><span onClick='closeEvent();'></span>Select Goal</div>";
echo "<div class='newGoals'>";
      $res = $DB -> newGoalForReward($rewardid, $userid);
        while($row=mysql_fetch_row($res))
	{
        $id=$row[0];
        $name=$row[1];
?>
<div class='newGoal' goalid="<?php echo $id;?>">
<div class="newGoal-title">
<?php echo $name;?>
</div>
</div>
<?php
}
?>
<div class='addnewGoal'>
<span class='addnewLabel'>Add a new Goal </span>
<span>
<form action="#" method="post" onsubmit="newGoal(this, event);">
<input type='text' required='true' placeholder="Title for the Goal ?" name="goaltitle"/>
<input type='hidden' name="rewardid" value="<?php echo $rewardid;?>"/>

<input type="submit" value="Add" />
</form>
</span>
</div>

</div>
 <div id="eventFooter">
<input type="button" value="Done" onClick="submitGoal(<?php echo $rewardid;?>);"/>
<span></span>
<div class="clr"></div>
</div>

<?php

break;
case "save":
$goalid=$_POST["goalid"];			
 if(!$DB->goalOwner($goalid, $userid))
{
$val=array('status'=>0,'msg'=>'Invalid user exception.');
print(json_encode($val));
die();
}
if($DB->goalRewardExists($goalid, $rewardid))
			{
				$val=array('status'=>0,'msg'=>'Reward is already there.');
				print(json_encode($val));
				die();
			}
if($DB->AddGoalReward($goalid, $rewardid))
{
						$DB->addGoalPoints($goalid, "reward",$userid,50,$rewardid,0);

				$val=array('status'=>1,'msg'=>'Reward is added to the goal.');
				print(json_encode($val));
die();
}




break;
case "new";
$title=mysql_escape_string($_POST["title"]);

			require_once("../DB/giftsDB.php");
			$gDB = new giftsDB();
if(!$gDB->giftExists($rewardid))
{
$val=array('status'=>0,'msg'=>'Reward not available.');
print(json_encode($val));
die();
}



$ret=$DB->AddGoal($title, $userid);
if($ret)
{
$goalid= $ret;

$ret=$DB->AddGoalReward($goalid, $rewardid);

$DB->addGoalPoints($goalid, "new",$userid,100,0,0);

$DB->addGoalPoints($goalid, "reward",$userid,50,$rewardid,0);

				$val=array('status'=>1,'msg'=>'New goal added.');
				print(json_encode($val));
die();

}
else
{
				$val=array('status'=>0,'msg'=>'Connection Error.');
				print(json_encode($val));
die();

}


break;

default:
break;

}
?>

