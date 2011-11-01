<div id="staticRegion">
<div id="mainHeader">
<div class="welcome-name">
<?php echo $fullname;

//$userId  coming from leftCont
$mbti = $uDB->getMBTI($userId);
$totalPoint = $uDB->getUserTotalPoint($userId);
$remPoint = $uDB->getUserRemainingPoint($userId);
$activeGoals=$gDB->countGoalProgress($userId,2); //in progress
$closedGoals=$gDB->countGoalProgress($userId,3); //closed Goal
if(!$mbti)
{
$mbti = "static/images/mbti-logo.gif";
}
else
{
$mbti = "uploads/mbti-badges/".strtolower($mbti).".png";
}

?>
</div>
<div class="props">
<div class="prop">
<img src="<?php echo $mbti;?>" />
</div>
<div class="prop">
<img src="static/images/thanks.png" height='80px'>
<?php

$profile_id = $PROFILEID ? $PROFILEID : $USERID;
$thanks_received = $reportDB-> thanksReceivedByUserId($profile_id,$from_date,$end_date,$time_range);
$thanks_received = mysql_fetch_array($thanks_received);
$thanks_received = $thanks_received["thanks_count"];
$thanks_given= $reportDB-> thanksGivenByUserId($profile_id,$from_date,$end_date,$time_range);
$thanks_given = mysql_fetch_array($thanks_given);
$thanks_given = $thanks_given["thanks_count"];
?>
<div>
<span>Thanks Received : <?php echo $thanks_received ?></span>
<br/>
<span>Thanks Given : <?php echo $thanks_given ?></span>
</div>
</div>
<div class="prop">
<img src="static/images/goal.png" height='80px' class="circularImage">
<div>
<span>Active Goals : <?php echo  $activeGoals ?></span>
<br>
<span>Closed Goals : <?php echo  $closedGoals ?></span>
</div>

</div>
<?php
if($PROFILEID==0)
{
?>
<div class="prop">
<img src="static/images/gold-coins-pile.jpg" height='80px' >
<div>
<span>Total Points : <?php echo  $totalPoint ?></span>
<br>
<span>Remaining Points : <?php echo  $remPoint ?></span>
</div>
</div>
<?php
}
?>

</div>



</div>
<?php
if($PROFILEID )
{

if($uDB->isConnected($USERID,$PROFILEID))
{
include("includes/post-profile.php");
}
}
else
{
include("includes/post-myprofile.php");
}
?>

<div class="feedArea">

<?php
 $TYPE_NAME = 1;
 include('feeds.php'); 
?>
</div>
</div>
<div id="dynamicRegion" style='display:none;'>
<b style='text-align:center;font-size:18px;'> Loading....</b></div>

