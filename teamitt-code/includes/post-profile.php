<div class='postArea'>
<div class="postTitle"><span id="action" class="selected">Action</span><span id="thank">Thanks</span>
<span id="giveFeedback">Give Feedback</span>
<span id="askFeedback">Ask Feedback</span>
</div>

<div class="postForm">
<table>
<tr>
<td>
<div class="badges actbadge" title="Select Badge">
<?php
$rempts=$uDB->getUserRemainingPoint($USERID);
include("DB/badgeDB.php");
$bDB = new badgeDB();
$getFirst = $bDB->getrandomBadge($rempts);

if(is_int($getFirst))
{
?>
<div class="badge" badgeid="0">
</div>
<div class="no-badge" title="Add Badge" style="display: block;">No Badge</div>
<?php
}
else 
{
?>
<span class="delbadge" title="Remove Badge">&nbsp;</span>
<div class="badge" badgeid="<?php echo $getFirst[0];?>">
<img src="<?php echo $getFirst[2];?>" width='60px' />
<span class="badgename"><?php echo $getFirst[1]; ?></span>
</div>
<div class="no-badge" title="Add Badge">No Badge</div>
<?php
}
?>

</div>
</td>
<td>
<div class="inputs">
<textarea rows='4' cols='10' id="postEditor" placeholder="Post action for <?php echo $fullname;?>">
</textarea>
<div class="postButton">
<small>(Visible to You and <?php echo $fullname;?> only) </small>
<input type="button" value="Post" class="add_help_answer" >
</div>
</div>
</td>
</tr>
</table>
</div>
</div>

