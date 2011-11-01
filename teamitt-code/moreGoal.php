<?php
include("checkid.php");
require("DB/initDB.php");
require("DB/usersDB.php");
require("DB/goalsDB.php");
$uDB = new usersDB();
$gDB=new goalsDB();
if(isset($_GET['id'])){
$userId=$_GET['id'];
if($userId==$USERID){
$userFName="My";
}
else{
$userFName=$uDB->firstName($userId);
$userFName=$userFName."'s";
}
}
?>
<div class='dynamicRegionHeader'><h2><?php echo $userFName?> Goals</h2>
<span style="float:right;"><input type="button" value="Back" onclick="backButtonClick()" class="button" /><span>
</div>
<div class='dynamicRegionContent'>

<?php
$result=$gDB->getGoalByUserId($userId);
$count=0;
while($row=mysql_fetch_row($result)){
$goalId=$row[0];
$goalName=$row[1];
$goalImageSrc=$row[2];
$goalDueDate=$row[3];
$goalProgress=$row[4];
$creatorFName=$row[5];
$creatorId=$row[6];
if(strlen($goalName)>30){
$goalName=substr($goalName(0,30));
$goalName=$goalName.".. ";
}
$contributor=$gDB->isGoalContributor($goalId,$USERID);

?>
<div class='pendingRequest'>
<div class='pendingRequestPic'>
<a href='goal.php?id=<?php echo $goalId?>'><img src='<?php echo $goalImageSrc?>' /></a>
</div>
<div class='pendingRequestDesc'>
<a href='goal.php?id=<?php echo $goalId?>'><?php echo $goalName ?></a>
<?php
if(!$contributor && $goalProgress!="Close"){
?>
<input type="button" id='joinMoreGoal<?php echo $goalId ?>' class="button" value="Join Goal" style="float:right;" onclick='joinMoreGoal(<?php echo  $goalId?>)'/>
<?php
}
if(!$contributor && $goalProgress=="Close"){
?>
<input type="button"  class="disableButton" value="Join Goal" style="float:right;" disabled='disabled'/>
<?php
}
?>

<br>
<span style='padding-top:3px;'>Created By:<span><a style='font-size:13px;'  href='profile.php?id=<?php echo $creatorId ?>'><?php echo  $creatorFName ?></a></span>
<br>
<span style='padding-top:3px;'>Goal Status:<span><span><?php echo  $goalProgress ?></span>
</div>
<div style='clear:both;'></div></div>
<?php

}

?>
</div>
