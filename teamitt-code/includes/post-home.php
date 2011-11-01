<div class='postArea'>
<div class="postTitle"><span id="thank" class="selected">Thanks</span><span id="update">Updates</span></div>
<div id="post_recv">
<span class="recv_span">
<input type="text" id="postFor" placeholder="enter name" onkeyup="getPeople(event);" autocomplete="off"> <small>(leave it blank, if action is for you)</small>
</span>
<div class="recv">
</div>
</div>

<div class="postForm">
<table>
<tr>
<td>
<div class="badges actbadge" title="Select Badge" style="display: block;">
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
<textarea rows='4' cols='10' id="postEditor" placeholder="Post Thanks to your connections">
</textarea>
<div class="postButton">
<input type="button" value="Post" class="add_help_answer" >
</div>
</div>
</td>
</tr>
</table>
</div>
</div>

