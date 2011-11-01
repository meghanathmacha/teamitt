<div>
<div class="company">
<?php

$companyName= $uDB->getCompanyName($owner);
$company_id= $uDB->getCompanyId($owner);
$pic = $uDB->getcompanyImage($company_id);
if(is_int($pic) || !$pic || strlen($pic) == 0)
{
$pic ="static/images/img.jpg";
}


?>

<img src="<?php echo $pic;?>">

</div>
<div class="listings">
<ul>
<li>
<a href="home.php" ><?php echo $companyName;?></a>
</li>
<li>
<a href="profile.php">Profile</a>
</li>
</ul>
</div>
<?php

	$contributor=$gDB->getGoalContributor($GoalId,1);

?>


<div class="sectionHeader">
<span onclick='goalContributor()' style='cursor:pointer;'>Goal Contributor</span>
<?php
if($canedit){
?>
<span onclick="ShowConn('goal','addConnections')" style='cursor:pointer;float:right'>Add</span>
<?php
}
?>
</div>

<div class="connections">
<ul>
<?php

while(list($id, $fname, $lname, $pic) = mysql_fetch_row($contributor))
{
if(!$pic || strlen($pic)  == 0)
{
$pic ="static/images/teamitt-user.jpg";
}
?>
<li>
<div class="tuserpic fl">
<img src="<?php echo $pic;?>">
</div>
<a href="profile.php?id=<?php echo $id;?>"><?php echo $fname." ".$lname;?></a>
</li>
<?php
}
?>



</ul>
</div>




</div>




