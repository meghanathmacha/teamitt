<div class="section">
<?php
if($PROFILEID!=0){
$userId=$PROFILEID;
$userFName=$uDB->firstName($userId);
$userFName=$userFName."'s";
}
else{
$userId=$USERID;
$userFName="My";
}

?>
<div class='sectionHeader' style='cursor:pointer;'><span onclick='moreGoals(<?php echo $userId?>)'><?php echo  $userFName?> Goals</span></div>
<div class="sectionBody">
<ul>
<?php
if($PROFILEID!=0){
$userId=$PROFILEID;
}
else{
$userId=$USERID;
}

$result=$gDB->getGoalByUserId($userId);
$count=0;
while($row=mysql_fetch_row($result)){
$goalId=$row[0];
$goalName=$row[1];
$goalImageSrc=$row[2];
$goalDueDate=$row[3];
$goalProgress=$row[4];
if(strlen($goalName)>30){
$goalName=substr($goalName(0,30));
$goalName=$goalName.".. ";
}
 echo "<li><div class='goalImage'><div style='float:left;'><a href='goal.php?id=".$goalId."'><img src='".$goalImageSrc."' style='width:50px;height:50px;'/></a></div><div class='goalDesc'><a href='goal.php?id=".$goalId."'>".$goalName."</a></div><div style='clear:both;'></div></div></li>";
$count++;
if($count==6){
break;
}

}
?>
</ul>
</div>
</div>

<input type='button' value='Create Goal' class='button' onclick="createGoal('goal','new')"></input>
