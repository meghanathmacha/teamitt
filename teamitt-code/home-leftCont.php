<div>
<div class="comp-image upimage">
<?php

$pic = $uDB->getCompanyImage($company_id);
$utext = "Change Pic";
if(is_int($pic) || !$pic || strlen($pic) == 0)
{
$pic ="static/images/img.jpg";
$utext = "Add Pic";
}

?>

<img src="<?php echo $pic;?>" id="companydp">
<div class='company-image-upload-text'>
<div class="upload-text-cont">
<span class="txt"><?php echo $utext;?></span>
<div id="goalfile">
<form name="companypicform" action="includes/up_companypic.php" method="post" target="upframe" enctype='multipart/form-data'>
<input type="file" name="companypic" onChange="companyimagetaken();"/>
</form>
</div>
</div>
</div>
<div id='company-image-upload-load' style="width: 100%;">&nbsp;</div>
<div style="display:none;">
<iframe name="upframe"></iframe>
</div>
</div>

<div class="listings">
<ul>
<li>
<a href="home.php" class="selected"><?php echo $company_name;?></a>
</li>
<li>
<a href="profile.php">Profile</a>
</li>
</ul>
</div>
<?php

	$numconn =  $uDB->NumCompconnections($company_id);
	$limit = 0;
	$connections = $uDB->GetCompconnections($company_id,$limit)

?>


<div class="sectionHeader">
At <?php echo $company_name." (".$numconn.")";?>
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




</div>




