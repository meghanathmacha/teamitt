<?php
include("checkid.php");
require("DB/initDB.php");
require("DB/usersDB.php");
require("DB/goalsDB.php");
$uDB = new usersDB();
$gDB=new goalsDB();
if(isset($_GET['goalId'])){
$goalId=$_GET['goalId'];
}

?>
<div class='dynamicRegionHeader'>
<h2>Goal Contributor</h2>
<span style="float:right;"><input type="button" value="Back" onclick="backButtonClick()" class="button" /><span>
</div>
<div class='dynamicRegionContent'>
<?php
  $result=$uDB->ShowAllConnectionUser($userId,10000,$companyId);
 // $contributor=$gDB->isGoalContributor($goalId,$USERID);
 // $goalStatus=$gDB->getGoalStatus($goalId);
 // $createdBy=$gDB->getGoalOwner($goalId);
  $count=0;
  while($row=mysql_fetch_row($result)){
	  $userId=$row[0];
//	 if($userId==$USERID)
//		continue;
	  $userFName=$row[1];
	  $userLName=$row[2];
	  $userImageSrc=$row[3];
	if(!$userImageSrc || strlen($userImageSrc)  == 0)
	{
	$userImageSrc ="static/images/teamitt-user.jpg";
	}	

		$count++;
  ?>
	<div class='pendingRequest'>
	<div class='pendingRequestPic'>
	<a href='profile.php?id=<?php echo $userId?>'><img src='<?php echo $userImageSrc?>' /></a>
	</div>
	<div class='pendingRequestDesc'>
	<a href='profile.php?id=<?php echo $userId?>'><?php echo $userFName." ".$userLName ?></a>
	<?php
//	if($contributor && $goalStatus!=3 && $userId!=$createdBy && $userId!= $USERID){	
	?>
	<span>
	<input type="button" class="button" value="Remove" onclick="removeContributor(<?php echo  $userId ?>)" id="removeContributor<?php echo $userId ?>"/>
	</span>
	<?php
	//}
	?>
	</div>
	<div style='clear:both;'></div></div>


<?php
}
	if($count==0){
	echo "<div><h2 style='text-align:center;'>No Contributor</h2></div>";
	}
?>

</div>
