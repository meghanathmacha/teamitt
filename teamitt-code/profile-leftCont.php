<div>
<div class="display-pic">
<?php
$company_name = $uDB->getCompanyName($USERID);
if($PROFILEID)
{
$pic = $uDB->getImage($PROFILEID);
} 
else
{
$pic = $uDB->getImage($USERID);
}
if(is_int($pic) || strlen($pic) < 1)
{
$pic = "static/images/teamitt-user.jpg";
}

?>

<img src="<?php echo $pic;?>">


</div>

<div class="listings">
<ul>
<li>
<a href="home.php"><?php echo $company_name;?></a>
</li>
<li>
<?php
if($PROFILEID)
{
$userId = $PROFILEID;
$conn_title = $firstname."'s Connections";
$having_conn_title = "Having ".$firstname." in Connections";
?>
<a href="profile.php">Profile</a>
<?php
}
else {

$userId = $USERID;
$conn_title = "My Connections";
$having_conn_title = "Having Me in Connections";
?>
<a href="profile.php" class="selected">Profile</a>

<?php
}


	$numconn =  $uDB->NumOfConn($userId,$company_id);
	$limit = 0;
	$connections = $uDB->ShowAllConnectionsUser($userId,$limit,$company_id);

	$having_numconn = $uDB->NumOfHavingMeInConn($userId,$company_id);
	 $having_connections = $uDB->HavingMeInConnections($userId,$limit,$company_id);

?>

</li>
</ul>
</div>

<br/>
<div class="sectionHeader">
<span onclick='userConnection(<?php echo $userId ?>)' style='cursor:pointer;'><?php echo $conn_title;?></span> (<?php echo $numconn;?>)
<?php if(!$PROFILEID) {
?>
<span onclick="ShowConn('people','connections')" style='cursor:pointer;float:right'>Add</span>
<?php
}
?>
</div>

<div class="connections">
<ul>
<?php
while(list($id, $fname, $lname, $pic) = mysql_fetch_row($connections))
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
<div class="clr"></div>

<div class="sectionHeader" >
<?php echo $having_conn_title;?> (<?php echo $having_numconn;?>)
</div>

<div class="connections">
<ul>
<?php
while(list($id, $fname, $lname, $pic) = mysql_fetch_row($having_connections))
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




